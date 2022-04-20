<?php

namespace App\Controllers;

use App\Libraries\AuthLibaries;
use App\Models\VoucherModel;
use App\Models\UserModel;
use App\Models\HistoryModel;
use CodeIgniter\I18n\Time;

class Saldo extends BaseController
{
    public function __construct()
    {
        $this->AuthLibaries = new AuthLibaries();
        $this->VoucherModel = new VoucherModel();
        $this->UserModel = new UserModel();
        $this->HistoryModel = new HistoryModel();
    }
    public function voucher()
    {
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
        } else {
            session()->setFlashdata('Pesan', 'Kode Voucher Salah');
            return redirect()->to('/topup');
        }
    }
}
