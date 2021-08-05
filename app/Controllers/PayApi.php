<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;
use CodeIgniter\RESTful\ResourceController;
use App\Models\TransaksiModel;
use App\Models\UserModel;
use App\Models\HistoryModel;
use \Firebase\JWT\JWT;

use CodeIgniter\Controller;

class Payapi extends ResourceController
{
    protected $format = 'json';
    protected $modelName = 'App\Models\TransaksiModel';

    public function __construct()
    {

        $this->UserModel = new UserModel();
        $this->TransaksiModel = new TransaksiModel();
        $this->HistoryModel = new HistoryModel();
    }



    public function index()
    {
        $id = $this->request->getVar('order_id');
        // \Midtrans\Config::$serverKey = "SB-Mid-server-OBUKKrJVEPM_WIpDt57XrGHp";
        \Midtrans\Config::$serverKey = "Mid-server-4i1pIlyNH096QXt7HWHDBT8_";

        // Uncomment for production environment
        \Midtrans\Config::$isProduction = true;

        // Enable sanitization
        \Midtrans\Config::$isSanitized = true;

        // Enable 3D-Secure
        \Midtrans\Config::$is3ds = true;

        $notif = \Midtrans\Transaction::status($id);

        // dd($id_order);
        $jwt = $_COOKIE['X-Sparum-Token'];
        $key = $this->TokenModel->Key()['token'];
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        $keyword = $decoded->id_user;
        $nama = $decoded->nama;


        $transaction = $notif->transaction_status;
        $harga = $notif->gross_amount;
        $order_id = $notif->order_id;
        $type = $notif->payment_type;
        $transaction_time = $notif->transaction_time;
        $updated_at = Time::now('Asia/Jakarta');

        // dd($notif);

        if ($type == "bank_transfer") {
            if (!empty($notif->permata_va_number)) {
                $kode = $notif->permata_va_number;
                $bank = "Transfer bank kode bank 013";
                $this->TransaksiModel->save([
                    'id_user' => $keyword,
                    'order_id' => $order_id,
                    'harga' => $harga,
                    'bank' => $bank,
                    'va_code' => $kode,
                    'status' => $transaction,
                    'created_at' => $transaction_time,
                    'updated_at' => $updated_at,
                ]);
                session()->setFlashdata('Pesan', "Silahkan Lakukan Pembayaran di $bank");
                return redirect()->to('/payriwayat');
                // dd($bank);
            }
            $bank = $notif->va_numbers[0]->bank;
            $kode = $notif->va_numbers[0]->va_number;
            $this->TransaksiModel->save([
                'id_user' => $keyword,
                'order_id' => $order_id,
                'harga' => $harga,
                'bank' => $bank,
                'va_code' => $kode,
                'status' => $transaction,
                'created_at' => $transaction_time,
                'updated_at' => $updated_at,
            ]);
            session()->setFlashdata('Pesan', "Silahkan Lakukan Pembayaran di $bank");
            return redirect()->to('/payriwayat');
            //dd($bank);
        }
        if ($type == "cstore") {
            $bank = $notif->store;
            $kode = $notif->payment_code;
            $this->TransaksiModel->save([
                'id_user' => $keyword,
                'order_id' => $order_id,
                'harga' => $harga,
                'bank' => $bank,
                'Payment_Code' => $kode,
                'Merchant_Code' => "G842103672",
                'status' => $transaction,
                'created_at' => $transaction_time,
                'updated_at' => $updated_at,
            ]);
            session()->setFlashdata('Pesan', "Silahkan Lakukan Pembayaran di $bank");
            return redirect()->to('/payriwayat');
        }
        if ($type == "gopay") {
            $bank = $type;
            $this->TransaksiModel->save([
                'id_user' => $keyword,
                'order_id' => $order_id,
                'harga' => $harga,
                'bank' => $bank,
                'status' => $transaction,
                'created_at' => $transaction_time,
                'updated_at' => $updated_at,
            ]);
            session()->setFlashdata('Pesan', "Silahkan Lakukan Pembayaran di $bank");
            return redirect()->to('/payriwayat');
        }
        if ($type == "bca_klikpay") {
            $bank = $type;
            // $kode = $notif->payment_code;
            // dd($bank);
        }

        // $fraud = $notif->fraud_status;
    }

    public function notification()
    {
        $notif = $this->request->getJSON();

        // $data = $this->request->getJSON();
        $order_id = $notif->order_id;
        $type = $notif->payment_type;
        $harga = $notif->gross_amount;
        $status = $notif->transaction_status;
        $edit = $this->TransaksiModel->editpay($order_id);
        $time = $notif->transaction_time;
        if ($harga == 3300) {
            $debit = 1000;
        }
        if ($harga == 12100) {
            $debit = 5000;
        }
        if ($harga == 28600) {
            $debit = 12500;
        }


        if ($type == "bank_transfer") {
            $bank = $notif->va_numbers[0]->bank;
            $kode = $notif->va_numbers[0]->va_number;
            $this->TransaksiModel->save([
                'id' => $edit['id'],
                'order_id' => $order_id,
                'status' =>  $status,
                'updated_at' => $time,
            ]);

            if ($status == "settlement") {
                $id_user = $edit['id_user'];
                $user = $this->UserModel->updateSaldo($id_user);
                $total = $user['debit'] + $debit;
                $this->UserModel->save([
                    'id' => $user['id'],
                    'debit' => $total,
                ]);

                $this->HistoryModel->save([
                    'id_master' => $user['id_user'],
                    'Id_slave' => $order_id,
                    'Lokasi' => $bank,
                    'status' => 'Top Up',
                    'isi' => $debit,
                    'updated_at' => Time::now('Asia/Jakarta')
                ]);
            } else {
                $response = [
                    'status' => 200,
                    'error' => false,
                    'data' => 'belum bayar'
                ];
                return $this->respond($response, 200);
            }

            $response = [
                'status' => 200,
                'error' => false,
                'data' =>   $type
            ];
            return $this->respond($response, 200);
        }

        if ($type == "qris") {
            $bank = $type;
            $this->TransaksiModel->save([
                'id' => $edit['id'],
                'status' => $status,
                'updated_at' => $time,
            ]);

            if ($status == "settlement") {
                $id_user = $edit['id_user'];
                $user = $this->UserModel->updateSaldo($id_user);
                $total = $user['debit'] + $debit;
                $this->UserModel->save([
                    'id' => $user['id'],
                    'debit' => $total,
                ]);

                $this->HistoryModel->save([
                    'id_master' => $user['id_user'],
                    'Id_slave' => $order_id,
                    'Lokasi' => $bank,
                    'status' => 'Top Up',
                    'isi' => $debit,
                    'updated_at' => Time::now('Asia/Jakarta')
                ]);
            } else {
                $response = [
                    'status' => 200,
                    'error' => false,
                    'data' =>   'belum bayar'
                ];
                return $this->respond($response, 200);
            }

            $response = [
                'status' => 200,
                'error' => false,
                'data' =>   "Salah"
            ];
            return $this->respond($response, 200);
        }

        if ($type == "gopay") {
            $bank = $type;
            $this->TransaksiModel->save([
                'id' => $edit['id'],
                'status' => $status,
                'updated_at' => $time,
            ]);

            if ($status == "settlement") {
                $id_user = $edit['id_user'];
                $user = $this->UserModel->updateSaldo($id_user);
                $total = $user['debit'] + $debit;
                $this->UserModel->save([
                    'id' => $user['id'],
                    'debit' => $total,
                ]);

                $this->HistoryModel->save([
                    'id_master' => $user['id_user'],
                    'Id_slave' => $order_id,
                    'Lokasi' => $bank,
                    'status' => 'Top Up',
                    'isi' => $debit,
                    'updated_at' => Time::now('Asia/Jakarta')
                ]);
            } else {
                $response = [
                    'status' => 200,
                    'error' => false,
                    'data' =>   'belum bayar'
                ];
                return $this->respond($response, 200);
            }

            $response = [
                'status' => 200,
                'error' => false,
                'data' =>   $type
            ];
            return $this->respond($response, 200);
        }

        if ($type == "cstore") {
            $bank = $notif->store;
            $this->TransaksiModel->save([
                'id' => $edit['id'],
                'status' => $status,
                'updated_at' => $time,
            ]);

            if ($status == "settlement") {
                $id_user = $edit['id_user'];
                $user = $this->UserModel->updateSaldo($id_user);
                $total = $user['debit'] + $debit;
                $this->UserModel->save([
                    'id' => $user['id'],
                    'debit' => $total,
                ]);

                $this->HistoryModel->save([
                    'id_master' => $user['id_user'],
                    'Id_slave' => $order_id,
                    'Lokasi' => $bank,
                    'status' => 'Top Up',
                    'isi' => $debit,
                    'updated_at' => Time::now('Asia/Jakarta')
                ]);
            } else {
                $response = [
                    'status' => 200,
                    'error' => false,
                    'data' =>   'belum bayar'
                ];
                return $this->respond($response, 200);
            }

            $response = [
                'status' => 200,
                'error' => false,
                'data' =>   $type
            ];
            return $this->respond($response, 200);
        }

        $response = [
            'status' => 200,
            'error' => false,
            'data' =>   $type
        ];
        return $this->respond($response, 200);
    }
}
