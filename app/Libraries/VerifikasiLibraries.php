<?php

namespace App\Libraries;

use App\Models\VerifiedModel;
use App\Libraries\SetStatic;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;


class VerifikasiLibraries
{
    public function __construct()
    {
        $this->VerifiedModel = new VerifiedModel();
        $this->SetStatic = new SetStatic();
        helper('cookie');
    }

    public function user($id_user)
    {
        if (empty($_COOKIE['verification-token'])) {
            $cek = $this->VerifiedModel->cekid($id_user);
            // dd($cek);
            if (($cek['email_status'] == 'verified') && ($cek['whatsapp_status'] == 'verified')) {
                dd('verified');
                $payload = array(
                    'id_user' => $id_user,
                    'email_status' => "verified",
                    'whatsapp_status' => "verified"
                );
                $jwt = JWT::encode($payload,  getenv('tokenkey'), 'HS256');
                setCookie("verification-token", $jwt, SetStatic::cookie_options());
                return false;
            } else {
                $payload = array(
                    'id_user' => $id_user,
                    'email_status' => $cek['email_status'],
                    'whatsapp_status' => $cek['whatsapp_status']
                );
                $jwt = JWT::encode($payload,  getenv('tokenkey'), 'HS256');
                setCookie("verification-token", $jwt, time() + (60 * 3));
                setCookie("verification-invalid", $jwt, time() + (60 * 2));
                return false;
            }
        } else {
            if (isset($_COOKIE['verification-invalid'])) {
                return true;
            }
            return false;
        }
    }
    public function Verified()
    {
        $jwt = $_COOKIE['verification-invalid'];
        $decoded = JWT::decode($jwt, new Key(getenv('tokenkey'), 'HS256'));
        if ($decoded->email_status != 'verified') {
            return true;
        }
        if ($decoded->whatsapp_status != 'verified') {
            return false;
        }
    }
}

// if (($cek['status'] == 'belum verifikasi')) {

//     session()->setFlashdata('email', '-');
// } else {
// }
// setCookie("verification-akun", "verified", time() + (60 * 60 * 24 * 30));
// setCookie("verification-akun", "unverified", time() + (60 * 3));