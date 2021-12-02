<?php

namespace App\Controllers;

use App\Libraries\AuthLibaries;
use App\Models\StasiunModel;
use App\Models\UserModel;
use App\Models\OtpModel;
use App\Models\BotolModel;
use CodeIgniter\I18n\Time;
use Generator;

class addBotol extends BaseController
{
    public function __construct()
    {
        $this->AuthLibaries = new AuthLibaries();
        helper('cookie');
        $this->StasiunModel = new StasiunModel();
        $this->UserModel = new UserModel();
        $this->OtpModel = new OtpModel();
        $this->BotolModel = new BotolModel();
    }
    public function addBotol()
    {
        $akun = $this->AuthLibaries->authCek();
        // $id_botol = 'XA1234';
        $id_botol = $this->request->getVar('id_botol');
        $cek_botol = $this->BotolModel->cek_botol($id_botol);
        if (empty($cek_botol)) {
            echo json_encode("QR Salah");
            return;
        }
        if ($cek_botol['id_user'] == null) {
            $this->BotolModel->save([
                'id' => $cek_botol['id'],
                'id_user' => $akun['id_user']
            ]);
            echo json_encode("Botol berhasil terdafar");
            return;
        }
        echo json_encode("Botol telah terdafar");
        return;
    }
    public function getbotol()
    {
        if (isset($_GET['ajax'])) {
            //this is an ajax request, process data here.
        }
        $akun = $this->AuthLibaries->authCek();
        $idUser = $akun['id_user'];
        $botol = $this->BotolModel->botol($akun['id_user']);
        // dd($botol);
        echo json_encode($botol);
        return;
    }
    public function delBotol()
    {
        $id_botol = 'XA1234';
        // $id_botol = $this->request->getVar('id_botol');
        $akun = $this->AuthLibaries->authCek();
        $cek_botol = $this->BotolModel->cek_botol($id_botol);
        if ($cek_botol['id_user'] ==  $akun['id_user']) {
            $this->BotolModel->save([
                'id' => $cek_botol['id'],
                'id_user' => null
            ]);
            echo json_encode('Berhasil');
            return;
        }
        echo json_encode("salah ID");
    }
}
