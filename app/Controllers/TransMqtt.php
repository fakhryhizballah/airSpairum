<?php

namespace App\Controllers;

use \Firebase\JWT\JWT;
use App\Models\TokenModel;
use App\Models\UserModel;
use Exception;

use CodeIgniter\Controller;

class TransMqtt extends Controller
{
    public function __construct()
    {
        $this->UserModel = new UserModel();
        $this->TokenModel = new TokenModel();
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
            $server   = 'ws.spairum.my.id';
            $port     = 1883;
            $clientId =  $akun['id_user'];
            $idMesin =  session()->get('id_mesin');
            $vaule =   session()->get('vaule');
            session_destroy();

            // $id = $this->request->getVar('id');
            $data = [
                'id' => $idMesin,
                'akun' => $akun['id_user'],
                'vaule' => $vaule,
            ];
            $myJSON = json_encode($data);
            $connectionSettings = (new \PhpMqtt\Client\ConnectionSettings)
                ->setUsername('spairum')
                ->setPassword('broker');

            $mqtt = new \PhpMqtt\Client\MqttClient($server, $port, $clientId);
            $mqtt->connect($connectionSettings, true);
            $mqtt->publish("start/$idMesin",  $myJSON);
            $mqtt->disconnect();

            // $Hambil = $ambil * '10';
            // $sisa = $akun['debit'] - $Hambil;
            // $kere = $akun['kredit'] + $Hambil;

            // // dd($kere);

            // $this->UserModel->save([
            //     'id' => $akun['id'],
            //     'debit' => $sisa,
            //     'kredit' => $kere,
            //     'updated_at' => Time::now('Asia/Jakarta')
            // ]);

            // $this->HistoryModel->save([
            //     'id_master' => $akun['id_user'],
            //     'Id_slave' => $id,
            //     'Lokasi' => $mesin['lokasi'],
            //     'status' => 'Pengambilan Air',
            //     'isi' => $Hambil,
            //     'updated_at' => Time::now('Asia/Jakarta')
            // ]);

        } else {
            exit('404');
        }
    }

    public function CallbackAir()
    {
        // if ($this->request->isAJAX()) {

        // // } else {
        //     exit('404');
        // }
    }
}
