<?php

namespace App\Libraries;

use \Firebase\JWT\JWT;
use App\Models\TokenModel;
use App\Models\UserModel;
use Exception;
use Kint\Parser\ToStringPlugin;

class AuthLibaries
{
    public function __construct()
    {
        $this->UserModel = new UserModel();
        $this->TokenModel = new TokenModel();
    }

    public function authCek()
    {
        if (empty($_COOKIE['X-Sparum-Token'])) {
            session()->setFlashdata('gagal', 'Anda belum Login');
            return redirect()->to('/');
        }
        $jwt = $_COOKIE['X-Sparum-Token'];
        try {
            $key = $this->TokenModel->Key()['token'];
            $decoded = JWT::decode($jwt, $key, array('HS256'));
        } catch (Exception $exception) {
            session()->setFlashdata('gagal', 'Login Dulu');
            return redirect()->to('/');
        }
        $key = $this->TokenModel->Key()['token'];
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        $token = $decoded->Key;
        // dd($token);
        if (empty($this->TokenModel->cek($token))) {
            session()->setFlashdata('gagal', 'Anda sudah Logout, Silahkan Masuk lagi');
            return redirect()->to('/');
        }
        $nama = $decoded->nama;
        $akun = $this->UserModel->cek_login($nama);
        return $akun;
    }

    public function notif($masage, $pesan)
    {
        $curl = curl_init();
        $namaD = ($masage['nama_depan']);
        $namaB = ($masage['nama_belakang']);
        $data_pesan = array(
            'number' => '0895321701798',
            'message' => "$namaD $namaB  $pesan"
        );
        $data_pesan1 = array(
            'number' => '089661370197',
            'message' => "$namaD $namaB  $pesan"
        );
        // dd($data_pesan);

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://10.8.0.3:8000/send-message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 5,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data_pesan,
        ));

        $response = curl_exec($curl);
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://10.8.0.3:8000/send-message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 5,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data_pesan1,
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // dd($response);
        // echo $response;
        return;
    }
}
