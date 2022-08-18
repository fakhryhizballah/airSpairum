<?php

namespace App\Controllers;

use App\Libraries\AuthLibaries;
use App\Models\VoucherModel;
use App\Models\UserModel;
use App\Models\HistoryModel;
use App\Models\ReferralModel;
use CodeIgniter\I18n\Time;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Saldo extends BaseController
{
    public function __construct()
    {
        $this->AuthLibaries = new AuthLibaries();
        $this->VoucherModel = new VoucherModel();
        $this->UserModel = new UserModel();
        $this->HistoryModel = new HistoryModel();
        $this->ReferralModel = new ReferralModel();
        helper('text');
    }
    public function voucher()
    {
        $db      = \Config\Database::connect();
        $akun = $this->AuthLibaries->authCek();
        $kvoucher = $this->request->getVar('kvoucher');
        $getV = $this->VoucherModel->cari($kvoucher);
        if (!empty($getV)) {
            if ($getV['ket'] == 'Baru') {
                $saldo =  $akun['debit'] + $getV['nominal'];
                $data = [
                    'debit' => $saldo,
                ];
                $this->UserModel->updateprofile($data, $akun['id']);

                $data = [
                    'id_user' => $akun['id_user'],
                    'ket' => 'Lama'
                ];
                $this->VoucherModel->updatevoucher($data, $getV['id']);

                $datavocer = [
                    'id_master' => $akun['id_user'],
                    'Id_slave' => $getV['kvoucher'],
                    'Lokasi' => 'voucher',
                    'status' => 'Top Up',
                    'isi' => $getV['nominal'],
                    'created_at' => Time::now('Asia/Jakarta')
                ];

                $this->HistoryModel->save($datavocer);
                // return; // no diarek
                session()->setFlashdata('Berhasil', 'Voucher berhasil digunakan');
                return redirect()->to('/user');
            }
            if ($getV['ket'] == 'Harian') {
                $harianVocher = $this->VoucherModel->harianvocher($akun['id_user'], $getV['kvoucher']);
                // dd($harianVocher);
                if (empty($harianVocher)) {
                    // vocer bisa digunakan
                    if ($akun['debit'] > 5000) {
                        session()->setFlashdata('Pesan', 'Saldo anda masih banyak bos, Gunain dulu yang ada sampai saldo anda dibawah 5000');
                        return redirect()->to('/user');
                    }
                    $data = [
                        'id_akun' => 'SelfBonus',
                        'id_user'  => $akun['id_user'],
                        'kvoucher'  => $kvoucher,
                        'nominal'  => $getV['nominal'],
                        'ket'  => 'Bonus Harian',
                    ];
                    // dd($data);
                    $this->VoucherModel->insert($data);

                    $saldo =  $akun['debit'] + $getV['nominal'];
                    $data = [
                        'debit' => $saldo,
                    ];
                    $this->UserModel->updateprofile($data, $akun['id']);

                    $datavocer = [
                        'id_master' => $akun['id_user'],
                        'Id_slave' => $getV['kvoucher'],
                        'Lokasi' => 'Voucher Harian',
                        'status' => 'Top Up',
                        'isi' => $getV['nominal'],
                        'created_at' => Time::now('Asia/Jakarta')
                    ];
                    $this->HistoryModel->save($datavocer);
                    // return; 
                    session()->setFlashdata('Berhasil', 'Voucher berhasil digunakan');
                    return redirect()->to('/user');
                } else {
                    // vocer tidak bisa digunakan
                    session()->setFlashdata('Pesan', 'Kode voucher hanya bisa di gunakan sekali dalam 1 hari');
                    return redirect()->to('/topup');
                }
            }
            session()->setFlashdata('Pesan', 'Kode voucher tidak dapat digunakan');
            return redirect()->to('/topup');
        }


        $ref = $this->ReferralModel->getReferral($kvoucher);
        // dd($ref);
        if ($ref != null) {
            if ($ref['id_user'] == $akun['id_user']) {
                session()->setFlashdata('Pesan', 'Tidak dapat mengunakan kode referral anda sendiri');
                return redirect()->to('/user');
            }
            $refral_user = $this->ReferralModel->getMyReferral($akun['id_user']);
            try {
                if ($ref['referral'] == $refral_user['id_referral']) {
                    session()->setFlashdata('Pesan', 'Tidak dapat mengunakan kode referral mantan');
                    return redirect()->to('/user');
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
            if ($refral_user == null || $refral_user['referral'] == null) {
                $db->transStart();
                $newRefralID = $this->id_referral();
                $id_donor = $this->UserModel->cek_id($ref['id_user']);
                $data = [
                    'id' => json_decode($newRefralID, true)['id'],
                    'referral' => $kvoucher,

                ];
                $this->ReferralModel->save($data);
                $saldo =  $akun['debit'] + '1000';
                $saldo_donor =  $id_donor['debit'] + '1000';
                $this->UserModel->updateprofile([
                    'debit' => $saldo,
                ], $akun['id']);
                $this->UserModel->updateprofile([
                    'debit' => $saldo_donor,
                ], $id_donor['id']);
                $dataVocher = [
                    'id_akun' => $ref['id_user'],
                    'id_user'  =>  $akun['id_user'],
                    'kvoucher'  => $kvoucher,
                    'nominal'  => '1000',
                    'ket'  => 'kode referral',
                ];
                $this->VoucherModel->insert($dataVocher);
    
                $dataHistory = [
                    'id_master' => $akun['id_user'],
                    'Id_slave' => $ref['id_user'],
                    'Lokasi' => 'Voucher Referral ' . $ref['id_user'],
                    'status' => 'Redeem Referral',
                    'isi' => '1000'
                ];
                $this->HistoryModel->save($dataHistory);
                $dataHistory = [
                    'id_master' => $ref['id_user'],
                    'Id_slave' => $akun['id_user'],
                    'Lokasi' => 'Kode Referral anda telah digunakan oleh ' . $akun['nama_depan'],
                    'status' => 'Bonus Referral',
                    'isi' => '1000'
                ];
                $this->HistoryModel->save($dataHistory);
                $db->transComplete();
                if ($db->transStatus() === FALSE) {
                    // generate an error... or use the log_message() function to log your error
                    $message = [
                        "level" => 4,
                        "topic" => "Error Referal",
                        "title" => "Databse error",
                        "value" => "Database error",
                    ];
                    $this->AuthLibaries->sendMqtt("log/dump", json_encode($message), $akun['id_user']);
                }
                $message = [
                    "level" => 2,
                    "topic" => "Referal Success",
                    "title" => $akun['nama_depan'],
                    "value" => "mengunakan refral " . $id_donor['nama_depan'],
                ];
                $this->AuthLibaries->sendMqtt("log/dump", json_encode($message), $akun['id_user']);
                $PesanWA = array(
                    [
                        "message" => "Hallo kak " . $akun['nama_depan'] . ", kakak telah berhasil menggunakan kode referral " . $id_donor['nama_depan'] . ". kakak mendapatkan saldo air sebesar Rp. 1000",
                        "number" => $akun['telp']
                    ],
                    [
                        "message" => "Hallo kak " . $id_donor['nama_depan'] . ", kode referral telah digunakan oleh kakak " . $akun['nama_depan'] . ". kakak mendapatkan saldo air sebesar Rp. 1000",
                        "number" => $id_donor['telp']
                    ]
                );
                foreach ($PesanWA as $value) {
                    $this->AuthLibaries->sendWa($value);
                }
                session()->setFlashdata('Berhasil', 'kode referral berhasil digunakan');
                return redirect()->to('/user');
            }
            session()->setFlashdata('Pesan', 'anda telah menggunakan kode referral');

            return redirect()->to('/user');
        } else {
            session()->setFlashdata('Pesan', 'Kode Voucher Salah');
            return redirect()->to('/topup');
        }
    }
    public function cekUser()
    {
        if ($this->request->isAJAX()) {
            $akun = $this->AuthLibaries->authCek();
            $body = $this->request->getBody();
            $body = json_decode($body, true);
            $tujuan = $body['nomortujuan'];
            $nominal = $body['nominal'];
            $cek = $this->UserModel->cek_login($tujuan);
            if (!empty($cek)) {
                if ($akun['id_user'] == $cek['id_user']) {
                    $data = [
                        'status' => 'error',
                        'message' => 'anda tidak bisa mengirim ke akun anda sendiri',
                    ];
                    return json_encode($data);
                } else {
                    $sisa = $akun['debit'] -  $nominal;
                    if ($sisa >= 0) {
                        $key = 'secret';
                        $payload = [
                            'id_tujuan' =>  $cek['id_user'],
                            'nama_tujuan' => $cek['nama_depan'] . ' ' . $cek['nama_belakang'],
                            'nominal' => $nominal,
                            'nomor_tujuan' => $tujuan,
                            'id_pengirim' => $akun['id_user'],
                            'nama_pengirim' => $akun['nama_depan'] . ' ' . $akun['nama_belakang'],
                            'nomor_pengirim' => $akun['telp'],
                            'sisa_saldo' => $sisa,
                        ];
                        $jwt = JWT::encode($payload, $key, 'HS256');

                        $data = [
                            'status' => 'success',
                            'nama' => $cek['nama_depan'] . ' ' . $cek['nama_belakang'],
                            'nominal' => $nominal,
                            'tujuan' =>  $tujuan,
                            'token' => $jwt,
                        ];
                        return json_encode($data);
                    } else {
                        $data = [
                            'status' => 'error',
                            'message' => 'Saldo anda tidak cukup',
                        ];
                        return json_encode($data);
                    }
                }
            } else {
                $data = [
                    'status' => 'error',
                    'message' => 'User tidak ditemukan',
                ];
            }
            return json_encode($data);
        }
        return redirect()->to('/');
    }
    public function kirimSaldo()
    {
        if ($this->request->isAJAX()) {
            $akun = $this->AuthLibaries->authCek();
            $body = $this->request->getBody();
            try {
                $body = json_decode($body, true);
                $jwt = $body['token'];
                $key = 'secret';
                $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
            } catch (\Throwable $e) {
                $data = [
                    'status' => 'error',
                    'message' => 'Token tidak valid',
                ];
                return json_encode($data);
            }
            if ($decoded->sisa_saldo >= 0) {
                $penerima = $this->UserModel->cek_id($decoded->id_tujuan);
                $PesanWA = array(
                    [
                        "message" => "Hallo kak $decoded->nama_tujuan ",
                        "number" => "$decoded->nomor_tujuan"
                    ],
                    [
                        "message" => "Selamat mendapatkan saldo spairum sebesar $decoded->nominal dari kak $decoded->nama_pengirim",
                        "number" => "$decoded->nomor_tujuan"
                    ],
                    [
                        "message" => "Pengriman saldo spairum berhasil ke $decoded->nama_tujuan sebesar $decoded->nominal",
                        "number" => "$decoded->nomor_pengirim"
                    ]
                );
                foreach ($PesanWA as $value) {
                    $this->AuthLibaries->sendWa($value);
                }
                try {
                    $History = [
                        'id_master' => $akun['id_user'],
                        'Id_slave' => $penerima['id_user'],
                        'Lokasi' => 'berbagi Saldo ke ' .  $decoded->nama_pengirim,
                        'status' => 'Kirim Saldo',
                        'isi' => $decoded->nominal,
                        'created_at' => Time::now('Asia/Jakarta')
                    ];
                    $this->HistoryModel->save($History);

                    $History = [
                        'id_master' => $penerima['id_user'],
                        'Id_slave' => $akun['id_user'],
                        'Lokasi' => 'Menerima Saldo dari ' .  $decoded->nama_tujuan,
                        'status' => 'Menerima Saldo',
                        'isi' => $decoded->nominal,
                        'created_at' => Time::now('Asia/Jakarta')
                    ];
                    $this->HistoryModel->save($History);

                    $this->UserModel->updateprofile([
                        'kredit' => $akun['kredit'] + $decoded->nominal,
                        'debit' =>  $akun['debit'] - $decoded->nominal,
                    ], $akun['id']);
                    $this->UserModel->updateprofile(['debit' =>  $penerima['debit'] + $decoded->nominal,
                    ], $penerima['id']);
                } catch (\Exception $e) {
                    $data = [
                        'status' => 'error',
                        'message' => 'Gagal mengirim',
                    ];
                    return json_encode($data);
                }
            }

            $data = [
                'status' => 'success',
                'message' => 'Pengiriman saldo berhasil',
            ];
            return json_encode($data);
        }
        return redirect()->to('/');
    }
    public function saldoUser()
    {
        $akun = $this->AuthLibaries->authCek();
        // dd($akun);
        $data = [
            'saldo' => $akun['debit']
        ];
        return json_encode($data);
    }
    public function id_referral()
    {
        $akun = $this->AuthLibaries->authCek();
        $id_referral = $this->ReferralModel->getMyReferral($akun['id_user']);
        if ($id_referral == null) {
            $referral = $this->newID();
            $data = [        
                'id_user' => $akun['id_user'],
                'id_referral' => $referral,
                'created_at' => Time::now('Asia/Jakarta')
            ];
            $this->ReferralModel->save($data);
        }
        // else {
        //     $data = [
        //         'id' => $id_referral['id'],
        //         'id_referral' => $id_referral['id_referral']
        //     ];
        //     return json_encode($data);
        // }
        $id_referral = $this->ReferralModel->getMyReferral($akun['id_user']);
        return json_encode($id_referral);
        
    }
    public function newID()
    {
        $id_A = random_string('numeric', 5);
        $id_B = strtoupper(random_string('alpha', 3));
        $id_referral = $this->ReferralModel->getReferral("$id_A $id_B");
        if ($id_referral == null) {
            return "$id_A $id_B";
        } else {
            $this->newID();
        }
    }

}
