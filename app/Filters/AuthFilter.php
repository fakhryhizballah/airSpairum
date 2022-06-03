<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\TokenModel;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use App\Libraries\SetStatic;
use Exception;


class AuthFilter implements FilterInterface
{
    public function __construct()
    {
        $this->TokenModel = new TokenModel();
        $this->SetStatic = new SetStatic();
        helper('text');
        helper('cookie');
    }
    public function before(RequestInterface $request, $arguments = null)
    {
        if (empty($_COOKIE['X-Sparum-Token'])) {
            session()->setFlashdata('gagal', 'Anda belum Login');
            return redirect()->to('/');
        }
        $jwt = $_COOKIE['X-Sparum-Token'];
        $key = getenv('tokenkey');
        try {
            $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        } catch (Exception $exception) {
            setCookie("X-Sparum-Token", "Token-Invalid", SetStatic::cookie_options());
            session()->setFlashdata('gagal', 'Login Dulu');
            return redirect()->to('/');
        }
        $token = $decoded->Key;
        if (empty($this->TokenModel->cek($token))) {
            session()->setFlashdata('gagal', 'Anda sudah Logout, Silahkan Masuk lagi');
            return redirect()->to('/');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
