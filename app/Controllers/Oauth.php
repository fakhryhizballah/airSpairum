<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\OtpModel;
use App\Models\TokenModel;
use App\Models\VerifiedModel;
use App\Libraries\SetStatic;
use App\Libraries\AuthLibaries;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use CodeIgniter\I18n\Time;


class Oauth extends BaseController
{
    public function __construct()
    {
        $this->UserModel = new UserModel();
        $this->OtpModel = new OtpModel();
        $this->TokenModel = new TokenModel();
        $this->VerifiedModel = new VerifiedModel();
        $this->SetStatic = new SetStatic();
        $this->AuthLibaries = new AuthLibaries();
        $this->Time = new Time('Asia/Jakarta');
        helper('text');
        helper('cookie');
    }

    public function redirect()
    {
        $client = new \Google_Client();
        $clientID = getenv('google.clientID');
        $clientSecret = getenv('google.clientSecret');
        $redirectUri = getenv('google.redirectUri'); //Harus sama dengan yang kita daftarkan
        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        $client->addScope("email");
        $client->addScope("profile");
        if (isset($_GET["code"])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);
            $client->setAccessToken($token);
            $gauth = new \Google_Service_Oauth2($client);
            $data = $gauth->userinfo->get();
            // dd($data);
            $gen = random_string('alnum', 5);
          
            $random = random_string('alnum', 28);
            $time = $this->Time::now('Asia/Jakarta');
            $cekEmail = $this->UserModel->cek_login($data->email);
            $key = getenv('tokenkey');
            $db      = \Config\Database::connect();
            
            if (empty($cekEmail)) {
                $username = trim($data->familyName);
                $oldUser = $this->UserModel->cek_login($username);
                // dd($oldUser);

                if (isset($oldUser)) {
                    $num = strval(random_string('nozero', 3));
                    $username = trim($data->familyName) . $num;
                }
                $db->transStart();
                // User Belum terdaftar Email
                $this->OtpModel->save([
                    'id_user' => "$data->id",
                    'nama' => "$username",
                    'nama_depan' => $data->givenName,
                    'nama_belakang' => $data->familyName,
                    'email' => "$data->email",
                    'telp' => "null",
                    'password' => password_hash("$data->id + $data->name", PASSWORD_BCRYPT),
                    'link' => $gen,
                    'status' => 'terverifikasi'
                ]);
                $this->UserModel->save([
                    'id_user' => "$data->id",
                    'nama' => "$username",
                    'nama_depan' => $data->givenName,
                    'nama_belakang' => $data->familyName,
                    'email' => "$data->email",
                    'telp' => "null",
                    'password' => password_hash("$data->id + $data->name", PASSWORD_BCRYPT),
                    'profil' => $data->picture,
                    'debit' => '0',
                    'kredit' => '0',
                ]);
                $this->VerifiedModel->save([
                    'id_user' => "$data->id",
                    'email_status' => "terverifikasi",
                    'verified_email_date' => $time,
                    'token_email' => $gen,
                    'whatsapp_status' => "unverified",
                    'verified_wa_date' => $time,
                    'token_wa' => "$gen$random",
                ]);
                $message =
                [
                    'message' => "$data->name mendaftar air.spairum.my.id",
                    'grup' => "New User Spairum",
                ];
                $this->AuthLibaries->sendMqtt("sendGrup", json_encode($message), $data->id);

                $payload = array(
                    'Key' => $random,
                    'id_user' => "$data->id",
                    'nama' =>  "$username"
                );

                $jwt = JWT::encode($payload, $key, 'HS256');
                $this->TokenModel->save([
                    'id_user' => "$data->id",
                    'token'    => $random,
                    'status' => 'Login'
                ]);
                setCookie("X-Sparum-Token", $jwt, SetStatic::cookie_options());

                if (empty($_COOKIE['theme-color'])) {
                    setCookie("theme-color", "lightblue-theme",  SetStatic::cookie_options());
                }
                $db->transComplete();
                return redirect()->to('/user');
            }
            // User sudah terdaftar Email
            if ($cekEmail['profil'] == 'user.png') {
                $this->UserModel->save([
                    'id_user' => "$data->id",
                    'profil' => $data->picture
                ]);
            }

            $payload = array(
                'Key' => $random,
                'id_user' => $cekEmail['id_user'],
                'nama' => $cekEmail['nama']
            );
            $jwt = JWT::encode($payload, $key, 'HS256');

            $this->TokenModel->save([
                'id_user' => $cekEmail['id_user'],
                'token'    => $random,
                'status' => 'Login'
            ]);
            
            setCookie("X-Sparum-Token", $jwt, SetStatic::cookie_options());
            
            if (empty($_COOKIE['theme-color'])) {
                setCookie("theme-color", "teal-theme", SetStatic::cookie_options());
            }
            return redirect()->to('/user');
            // dd($cekEmail);
        } else {
            $authUrl = $client->createAuthUrl();
            return $authUrl;
        }
    }

}
