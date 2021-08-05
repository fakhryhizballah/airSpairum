<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\BaseController;
use \Firebase\JWT\JWT;
// use PhpMqtt\Client\Facades\MQTT;
// use \PhpMqtt\Client\MqttClient;
use App\Models\TokenModel;


class Mqtt extends BaseController
{
    public function __construct()
    {
        // $this->MQTT = new MQTT::connection();
    }

    public function index()
    {
        $jwt = $_COOKIE['X-Sparum-Token'];
        $key = $this->TokenModel->Key()['token'];
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        // $keyword = $decoded->id_user;
        $nama = $decoded->nama;

        $akun = $this->UserModel->cek_login($nama);
        $data = [
            'title' => 'Tes MQtt | Spairum.com',
            'page' => 'Riwayat',
            'akun' => $akun,

        ];

        return view('user/take', $data);
    }

    // public function OpenDor()
    // {
    //     if (session()->get('id_akun') == '') {
    //         session()->setFlashdata('gagal', 'Login dulu');
    //         return redirect()->to('/');
    //     }
    //     if ($this->request->isAJAX()) {
    //         $server   = 'ws.spairum.my.id';
    //         $port     = 1883;
    //         $clientId = 'OpenDor';
    //         $id = $this->request->getVar('id');
    //         $data = [
    //             'id' => $id,
    //             'akun' => session()->get('id_akun')
    //         ];
    //         $myJSON = json_encode($data);
    //         $connectionSettings = (new \PhpMqtt\Client\ConnectionSettings)
    //             ->setUsername('spairum')
    //             ->setPassword('broker');

    //         $mqtt = new \PhpMqtt\Client\MqttClient($server, $port, $clientId);
    //         $mqtt->connect($connectionSettings, true);
    //         $mqtt->publish('Web',  $myJSON);
    //         $mqtt->disconnect();
    //     } else {
    //         exit('404');
    //     }
    // }
}
