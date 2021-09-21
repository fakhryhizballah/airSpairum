<?php

namespace App\Libraries;

use \Firebase\JWT\JWT;
use App\Models\TokenModel;
use App\Models\UserModel;
use Exception;

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
}
