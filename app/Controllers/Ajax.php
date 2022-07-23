<?php

namespace App\Controllers;

use App\Libraries\AuthLibaries;
use App\Models\StasiunModel;
use App\Models\UserModel;
use App\Models\OtpModel;
use App\Models\LogModel;
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
        $this->LogModel = new LogModel();
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
        $status = $this->StasiunModel->cek_mesin($id_mesin['id_mesin']);
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
                'sisaSaldo' => $sisaSaldo,
                'status_mesin' => $status['status']
            ];
            echo json_encode($data);
        } else {
            $data = [
                'status' => '204',
                'total' => $mesin['harga'] * ($take / 10),
            ];
            echo json_encode($data);
        };
    }
    public function PushAir()
    {
        $akun = $this->AuthLibaries->authCek();
        $data = $this->request->getVar();
        $vaule = $data['diambil'];
        $idMesin =  $data['newID'];

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
        $message = json_encode($respoun);

        $topic = "start/$idMesin";
        $clientId = $akun['id_user'];

        $this->AuthLibaries->sendMqtt(
            $topic,
            $message,
            $clientId
        );

        // echo json_encode($data);
        $log = [
            "level" => 2,
            "topic" => "Mengambil Air",
            "title" => $akun['id_user'],
            "value" => "$idMesin  | $vaule mL"
        ];
        $this->AuthLibaries->sendMqtt("log/dump", json_encode($log), $akun['id_user']);

        // $this->AuthLibaries->notif($akun, "Mengambil Air $minum di $lokasi sebanayk $vaule mL");
        echo json_encode(array('akun' => $akun['id_user']));
        return;
    }
    public function log()
    {
        $akun = $this->AuthLibaries->authCek();
        $ip = $_SERVER['REMOTE_ADDR'];
        $browser = $_SERVER['HTTP_USER_AGENT'];
        $name = ($akun['nama_depan'] . " " . $akun['nama_belakang']);
        // $ip = '180.242.232.191';
        $last = [
            'user' => $akun['id_user'],
            'ip' => $ip,
            'brouser' => $browser
        ];
        $cek = implode("-", $last);
        $key = hash('sha256', $cek);
        $cekKey = $this->LogModel->cekKey($key);
        if (!empty($cekKey)) {
            $data = [
                'id' => $cekKey['id']
            ];
            $status = $this->LogModel->save($data);
            echo json_encode(array(
                'status' => 200,
                'error' => true,
                'msg' => "Data telah ada",
                'data' => $cekKey
            ));
            return;
        };
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://ip-api.com/json/$ip",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;
        $apiIP = json_decode($response, true);

        try {
            //If the exception is thrown, this text will not be shown
            $data = [
                'key'        => $key,
                'id_user'    => $akun['id_user'],
                'name'       => $name,
                'user_agent' => $browser,
                'ip_user'    => $ip,
                'country'    => $apiIP['country'],
                'regionName' => $apiIP['regionName'],
                'city'       => $apiIP['city'],
                'isp'        => $apiIP['isp'],
                'org'        => $apiIP['org'],
                'as'         => $apiIP['as'],
                // 'time' => $myTime,
            ];
            $status = $this->LogModel->save($data);
            echo json_encode(array(
                'status' => 200,
                'error' => true,
                'msg' => $data,
                'save' => $status,
            ));
            return;
        }

        //catch exception
        catch (\Exception $e) {
            echo $e;
            echo json_encode(array(
                'status' => '400',
                'error' => false,
                'msg' => $e
            ));
            return;
        }
    }
    public function stopAir()
    {
        $akun = $this->AuthLibaries->authCek();
        $data = $this->request->getVar();
        $idMesin = $data['newID'];
        $message = $akun['id_user'];
        $topic = "stop/$idMesin";
        $clientId = $akun['id_user'];

        $this->AuthLibaries->sendMqtt(
            $topic,
            $message,
            $clientId
        );
        // echo ("ping");
        return;
    }
    public function ping()
    {
        $akun = $this->AuthLibaries->authCek();
        $data = $this->request->getVar();
        $data = [
            "message" => 'ping',
        ];
        $message = json_encode($data);
        $topic = "ping";
        $clientId = $akun['id_user'];

        $this->AuthLibaries->sendMqtt(
            $topic,
            $message,
            $clientId
        );
        // echo ("ping");
        return;
    }
    public function sendWa($noHp)
    {
        $akun = $this->AuthLibaries->authCek();
        // $data = $this->request->getVar();
        if (!empty($noHp)) {
            $data = [
                "message" => 'tes WA Mqtt',
                "number" => $noHp
            ];
            $message = json_encode($data);
            $topic = "sendPesan";
            $clientId = $akun['id_user'];

            $this->AuthLibaries->sendMqtt(
                $topic,
                $message,
                $clientId
            );
            return;
        }
        echo ("masukan nomor hp");
        return;
    }
    public function sendgrubWA()
    {
        $akun = $this->AuthLibaries->authCek();
        // $data = $this->request->getVar();
        $data = [
            "message" => 'tes kirim pesan ke grub',
            "grup" => 'log spairum'
        ];
        $message = json_encode($data);
        $topic = "sendGrup";
        $clientId = $akun['id_user'];

        $this->AuthLibaries->sendMqtt(
            $topic,
            $message,
            $clientId
        );
        echo ("terkirim : ");
        return;
    }
    public function qrs()
    {
        return redirect()->to('/');
    }
}
