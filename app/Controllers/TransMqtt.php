<?php

namespace App\Controllers;

use \Firebase\JWT\JWT;
use App\Models\TokenModel;
use App\Models\UserModel;
use Exception;
use CodeIgniter\I18n\Time;
use App\Models\TransaksiModel;
use App\Models\HistoryModel;

use CodeIgniter\Controller;

class TransMqtt extends Controller
{
    public function __construct()
    {
        $this->UserModel = new UserModel();
        $this->TokenModel = new TokenModel();
        $this->TransaksiModel = new TransaksiModel();
        $this->HistoryModel = new HistoryModel();
        helper('cookie');
    }
    public function index()
    {
        $jwt = $_COOKIE['X-Sparum-Token'];
        $key = $this->TokenModel->Key()['token'];
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        $nama = $decoded->nama;

        $akun = $this->UserModel->cek_login($nama);

        if (!session()->get('vaule')) {
            session()->setFlashdata('Pesan', 'mau kemana?');
            return redirect()->to('/user');
        }

        $data = [
            'title' => 'Tes MQtt | Spairum.com',
            'page' => 'Riwayat',
            'akun' => $akun,
        ];

        return view('user/take', $data);
    }

    public function PushAir()
    {
        if ($this->request->isAJAX()) {
            $jwt = $_COOKIE['X-Sparum-Token'];
            $key = $this->TokenModel->Key()['token'];
            $decoded = JWT::decode($jwt, $key, array('HS256'));
            $nama = $decoded->nama;

            $akun = $this->UserModel->cek_login($nama);
            // $server   = 'ws.spairum.my.id';
            $server   = 'spairum.my.id';
            $port     = 1883;
            $clientId =  $akun['id_user'];
            $idMesin =  session()->get('id_mesin');
            $vaule =   session()->get('vaule');
            $nilai = $vaule / 3.3;

            // $id = $this->request->getVar('id');
            $data = [
                'id' => $idMesin,
                'akun' => $akun['id_user'],
                'vaule' =>   $nilai,
            ];
            $myJSON = json_encode($data);
            $connectionSettings = (new \PhpMqtt\Client\ConnectionSettings)
                ->setUsername('mqttuntan')
                ->setPassword('mqttuntan');

            $mqtt = new \PhpMqtt\Client\MqttClient($server, $port, $clientId);
            $mqtt->connect($connectionSettings, true);
            $mqtt->publish("start/$idMesin",  $myJSON);
            $mqtt->disconnect();
            // session_destroy();
        } else {
            exit('404');
        }
    }

    public function desstroy()
    {
        // if ($this->request->isAJAX()) {
        $idMesin =  session()->get('id_mesin');
        $vaule =   session()->get('vaule');
        session_unset();
        session_destroy();
        echo $idMesin;

        // } else {
        //     exit('404');
        // }
    }
}
