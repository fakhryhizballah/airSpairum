<?php

namespace App\Controllers;

use App\Libraries\AuthLibaries;
use App\Models\StasiunModel;
use App\Models\UserModel;
use App\Models\OtpModel;
use CodeIgniter\I18n\Time;
use Generator;

class Ajax extends BaseController
{
    public function __construct()
    {
        $this->AuthLibaries = new AuthLibaries();
        helper('cookie');
        $this->StasiunModel = new StasiunModel();
        $this->UserModel = new UserModel();
        $this->OtpModel = new OtpModel();
    }
    public function index()
    {
        $akun = $this->AuthLibaries->authCek();
        $take = $this->request->getVar('myRange');
        // $take = ('22');
        $id = $this->request->getVar('code');
        // $id = ('eyJpZCI6IjAwMDIiLCJzdGFzaXVuIjoiUktBTC1QT05USU5BS0EiLCJpZF9tZXNpbiI6IlByb3RvdGlwZTIifQ==');
        // $id = ('eyJpZCI6IjAwMSIsInN0YXNpdW4iOiJSRUJBTC1ERU5QQVNBUiIsImlkX21lc2luIjoiUHJvQmFsaSIsIm5ld19pZCI6IlByb0JhbGkzIn0=');
        $id_encode = base64_decode($id);
        $id_mesin = (json_decode($id_encode, true));
        if (empty($id_mesin['new_id'])) {
            $mesin = $this->StasiunModel->cek_ID($id_mesin['id_mesin']);
        } else {
            $mesin = $this->StasiunModel->cek_newID($id_mesin['new_id']);
        }
        // dd($mesin);
        // $mesin = $this->StasiunModel->cek_newID('ProBali2');
        // echo json_encode($id_mesin);
        // if (empty($mesin)) {

        //     $data = [
        //         'status' => '204',
        //         'total' => $mesin,
        //     ];
        //     echo json_encode($data);
        // }
        $sisaSaldo = $akun['debit'] - ($take / 10 * $mesin['harga']);
        // echo json_encode($mesin);
        if ($sisaSaldo >= '0') {
            // dd($akun['debit']);

            $data = [
                'status' => '200',
                'nama' => $mesin['nama'],
                'harga' => $mesin['harga'],
                'diambil' =>  $take * 10,
                // 'total' => $mesin['harga'] * ($take / 10),
                'total' => (int) (($take / 10) * $mesin['harga']),
                'newID' => $mesin['new_id'],
                'mesinID' => $mesin['id_mesin'],
                'index' => $mesin['faktor'],
                'sisaSaldo' => $sisaSaldo
            ];
            echo json_encode($data);
        } else {
            $data = [
                'status' => '204',
                'total' => $mesin['harga'] * ($take / 10),
            ];
            echo json_encode($data);
        };
        // echo json_encode("sisaSaldo");
        // echo json_encode($data);
    }
    public function PushAir()
    {
        $akun = $this->AuthLibaries->authCek();
        $data = $this->request->getVar();
        $vaule = $data['diambil'];
        $idMesin =  $data['newID'];
        $mesinNew = $this->StasiunModel->cek_newID($idMesin);
        $mesin = $this->StasiunModel->cek_ID($idMesin);
        $minum = $mesinNew['nama'];
        $lokasi = $mesin['lokasi'];

        $server   = 'ws.spairum.my.id';
        $port     = 1883;
        $clientId =  $akun['id_user'];
        $idMesin =  $idMesin;
        $vaule =  $data['diambil'];
        $nilai = $vaule / $data['index'];

        // $id = $this->request->getVar('id');
        $respoun = [
            'id' => $idMesin,
            'mesinID' => $data['mesinID'],
            'nama' => $data['nama'],
            'akun' => $akun['id_user'],
            'vaule' =>   $vaule,
            'faktor' =>    $data['index'],
            'HargaTotal' => $data['total']
        ];
        $myJSON = json_encode($respoun);
        $connectionSettings = (new \PhpMqtt\Client\ConnectionSettings)
            ->setUsername('spairum')
            ->setPassword('broker');

        $mqtt = new \PhpMqtt\Client\MqttClient($server, $port, $clientId);
        $mqtt->connect($connectionSettings, true);
        $mqtt->publish("start/$idMesin",  $myJSON);
        $mqtt->disconnect();
        echo json_encode($myJSON);
        $this->AuthLibaries->notif($akun, "Mengambil Air $minum di $lokasi sebanayk $vaule mL");
    }
    // public function Generator()
    // {
    //     $db      = \Config\Database::connect();
    //     $builder = $db->table('user');
    //     $builder->select('*');
    //     $builder->join('otp', 'otp.id_user = user.id_user');
    //     $arr = $builder->get()->getResultObject();
    //     // dd($arr);
    //     $saldo = $db->table('saldo');
    //     $history = $db->table('history');

    //     echo "$value->nama <br>";
    //     echo "$value->id_user<br>";
    // }
    // // dd($query[0]->nama);
}
