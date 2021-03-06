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

            if ($cek['email_status'] == 'unverified') {
                echo "verificationEmail";
                // $this->SetStatic->set_flashdata('error', 'Email belum diverifikasi');
                return "verificationEmail";
            }
            if ($cek['whatsapp_status'] == 'unverified') {
                echo "verificationEmail";
                // $this->SetStatic->set_flashdata('error', 'Email belum diverifikasi');
                return "verificationWa";
            }
            setCookie("verification-token", "Done", time() + (60 * 3));
            return;
        } else {
            return;
        }
    }
    // public function skipWA()
    // {
    //     setCookie("verification-token", "Whatsapp Skip verification", time() + (60 * 3));
    // }
}