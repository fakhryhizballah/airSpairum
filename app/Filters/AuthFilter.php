<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\TokenModel;
use \Firebase\JWT\JWT;
use Exception;


class AuthFilter implements FilterInterface
{
    public function __construct()
    {
        $this->TokenModel = new TokenModel();
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
        $key = $this->TokenModel->Key()['token'];
        // $decoded = JWT::decode($jwt, $key, array('HS256'));
        try {
            $decoded = JWT::decode($jwt, $key, array('HS256'));
            $key = $this->TokenModel->Key()['token'];
            $decoded = JWT::decode($jwt, $key, array('HS256'));
        } catch (Exception $exception) {
            session()->setFlashdata('gagal', 'Login Dulu');
            return redirect()->to('/');
        }
        $token = $decoded->Key;
        // dd($token);
        if (empty($this->TokenModel->cek($token))) {
            session()->setFlashdata('gagal', 'Anda sudah Logout, Silahkan Masuk lagi');
            return redirect()->to('/');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
