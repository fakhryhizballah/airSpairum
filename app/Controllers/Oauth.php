<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\OtpModel;
use App\Models\TokenModel;
use App\Models\VerifiedModel;
use App\Libraries\SetStatic;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;


class Oauth extends BaseController
{
    public function __construct()
    {
        $this->UserModel = new UserModel();
        $this->OtpModel = new OtpModel();
        $this->TokenModel = new TokenModel();
        $this->VerifiedModel = new VerifiedModel();
        $this->SetStatic = new SetStatic();

        $this->client = new \Google_Client();
        // $client = new \Google_Client();
        $clientID = getenv('google.clientID');
        $clientSecret = getenv('google.clientSecret');
        $redirectUri = getenv('google.redirectUri'); //Harus sama dengan yang kita daftarkan
        $this->client->setClientId($clientID);
        $this->client->setClientSecret($clientSecret);
        $this->client->setRedirectUri($redirectUri);
        $this->client->addScope("email");
        $this->client->addScope("profile");
    }
    public function index()
    {
        $auth_url = $this->client->createAuthUrl();
        // dd($auth_url);
        return  $auth_url;
    }
    public function redirect()
    {
        $code = $this->request->getGet('code');
        // $token = $this->client->fetchAccessTokenWithRefreshToken($code);
        $token = $this->client->fetchAccessTokenWithAuthCode($code);
        if (!isset($token["error"])) {
            $access_token = $this->client->setAccessToken($token['access_token']);
            $google_service = new \Google_Service_Oauth2($access_token);
            $data = $google_service->userinfo->get();
            // echo json_encode($data);
            $gen = random_string('alnum', 5);
            $random = random_string('alnum', 28);
            $time = $this->Time::now('Asia/Jakarta');
            $cekEmail = $this->UserModel->cek_login($data->email);
            $key = getenv('tokenkey');

            if (empty($cekEmail)) {
                // User Belum terdaftar Email
                $this->OtpModel->save([
                    'id_user' => "$data->id",
                    'nama' => $data->id,
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
                    'nama' => $data->id,
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
                    'nama' =>  $user
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
                return redirect()->to('/user');
            }
            // User sudah terdaftar Email
            if ($cekEmail['profil'] == 'https://cdn.spairum.my.id/img/user.png') {
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
            session()->setFlashdata('gagal', 'token tidak valid');
            return redirect()->to('/');
        }
    }
}
