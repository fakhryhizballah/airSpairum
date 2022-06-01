<?php

namespace App\Controllers;



use App\Models\ExploreModel;
use App\Models\HistoryModel;
use App\Models\UserModel;
use App\Models\TransferModel;
use App\Models\StasiunModel;
use App\Models\TransaksiModel;
use CodeIgniter\I18n\Time;
use App\Models\OtpModel;
use App\Models\VoucherModel;
use App\Models\TokenModel;
use App\Models\SaldoModel;
use App\Libraries\AuthLibaries;
use App\Models\BotolModel;
use App\Models\VerifiedModel;

class User extends BaseController
{
    public function __construct()
    {
        $this->ExploreModel = new ExploreModel();
        $this->HistoryModel = new HistoryModel();
        $this->UserModel = new UserModel();
        $this->TransferModel = new TransferModel();
        $this->StasiunModel = new StasiunModel();
        $this->TransaksiModel = new TransaksiModel();
        $this->email = \Config\Services::email();
        $this->OtpModel = new OtpModel();
        $this->VoucherModel = new VoucherModel();
        $this->TokenModel = new TokenModel();
        $this->SaldoModel = new SaldoModel();
        $this->AuthLibaries = new AuthLibaries();
        $this->BotolModel = new BotolModel();
        $this->VerifiedModel = new VerifiedModel();
        helper('cookie');
    }

    public function index()
    {
        $akun = $this->AuthLibaries->authCek();
        $saldo = $this->SaldoModel->cek_id($akun['id_user']);
        $botol = $this->BotolModel->botol($akun['id_user']);
        if ($akun['nama_depan'] == null) {
            session()->setFlashdata('salah', 'Silahkan lengkapi identitas anda');
            return redirect()->to('editprofile');
        }
        if (empty($_COOKIE['verification-akun'])) {
            // $cek = $this->VerifiedModel->cekid($akun['id_user']);
            // if (($cek['email_status'] == 'unverified')) {
            //     setCookie("verification-akun", "unverified", time() + (60 * 3));
            //     session()->setFlashdata('email', '-');
            // } else {
            //     setCookie("verification-akun", "verified", time() + (60 * 60 * 24 * 30));
            // }
            $cek = $this->OtpModel->cekid($akun['id_user']);
            if (($cek['status'] == 'belum verifikasi')) {
                setCookie("verification-akun", "unverified", time() + (60 * 3));
                session()->setFlashdata('email', '-');
            } else {
                setCookie("verification-akun", "verified", time() + (60 * 60 * 24 * 30));
            }
        }
        $data = [
            'title' => 'Home | Spairum.com',
            'akun' => $akun,
            'saldo' => $saldo,
            'botol' => $botol,
            'socket' => getenv('soket.url'),
        ];
        // dd($data);
        // $this->AuthLibaries->notif($akun, "Membuka halaman Home");
        return view('user/home', $data);
    }

    public function take()
    {
        $akun = $this->AuthLibaries->authCek();
        $take = $this->request->getVar('take');
        $hasil = $akun['debit'] - $take * 10;
        if ($hasil >= "0") {
            // session()->destroy();
            session()->set('vaule', $take);
            return redirect()->to('/connect');
        }
        session()->setFlashdata('Pesan', 'Saldo anda tidak cukup silahkan isi ulang');
        return redirect()->to('/user');
    }

    public function connect()
    {
        $akun = $this->AuthLibaries->authCek();
        $data = [
            'title' => 'Pindai | Spairum.com',
            'akun' => $akun,
        ];

        return   view('layout/scan_qr', $data);
    }
    public function binding()
    {
        $akun = $this->AuthLibaries->authCek();

        $id = $this->request->getVar('qrcode');
        $id_encode = base64_decode($id);
        $id_mesin = (json_decode($id_encode, true));
        if (empty($id_mesin['id_mesin'])) {
            session()->setFlashdata('Pesan', 'Maaf itu bukan QR Spairum');
            return redirect()->to('/connect');
        }
        // $ambil = session()->get('oke');
        // $cek = $this->TransferModel->cek_mesin($id);
        $mesin = $this->StasiunModel->cek_mesin($id_mesin['id_mesin']);
        // dd($mesin);
        if ($mesin['status'] == 'aktif') {
            session()->setFlashdata('Pesan', 'Stasiun sedang tidak aktif.');
            return redirect()->to('/user');
        }
        session()->set('id_mesin', $mesin['id_mesin']);
        return redirect()->to('/control');
    }


    public function stasiun()
    {
        $akun = $this->AuthLibaries->authCek();

        $stasiun = $this->StasiunModel->getStasiun();
        // dd($stasiun);
        $data = [
            'title' => 'Home | Spairum.com',
            'stasiun' => $stasiun,
            'akun' => $akun
        ];
        // $this->AuthLibaries->notif($akun, "Membuka halaman Maps");
        return view('user/stasiun', $data);
    }
    public function riwayat()
    {
        $akun = $this->AuthLibaries->authCek();
        $history = $this->HistoryModel->search($akun['id_user']);

        $history = $this->HistoryModel->orderBy('created_at', 'DESC');
        $pager = \Config\Services::pager();
        $data = [
            'title' => 'Riwayat | Spairum.com',
            'page' => 'Riwayat',
            'history' => $history->paginate(12, 'riwayat'),
            'pager' => $history->pager,
            'akun' => $akun

        ];
        // $this->AuthLibaries->notif($akun, "Membuka halaman Cek Riwayat");
        return view('user/riwayat', $data);
    }
    public function payriwayat()
    {

        $akun = $this->AuthLibaries->authCek();

        $history = $this->TransaksiModel->search($akun['id_user']);
        $history = $this->TransaksiModel->orderBy('created_at', 'DESC')->findAll();

        // dd($history);
        $data = [
            'title' => 'Riwayat | Spairum.com',
            'page' => 'Riwayat',
            'history' => $history,
            'akun' => $akun

        ];
        return view('user/payriwayat', $data);
    }

    public function topup()
    {
        $akun = $this->AuthLibaries->authCek();

        $data = [
            'title' => 'TopUp | Spairum.com',
            'page' => 'TopUp',
            'akun' => $akun
        ];
        // $this->AuthLibaries->notif($akun, "Membuka halaman TopUp");
        return view('user/topup', $data);
    }
    public function snap()
    {
        $akun = $this->AuthLibaries->authCek();
        // \Midtrans\Config::$serverKey = "SB-Mid-server-OBUKKrJVEPM_WIpDt57XrGHp";
        \Midtrans\Config::$serverKey = "Mid-server-4i1pIlyNH096QXt7HWHDBT8_";

        // Uncomment for production environment
        \Midtrans\Config::$isProduction = true;
        // \Midtrans\Config::$isProduction = false;

        // Enable sanitization
        \Midtrans\Config::$isSanitized = true;

        // Enable 3D-Secure
        \Midtrans\Config::$is3ds = true;

        $harga = (int)$this->request->getVar('harga');
        $paket = $this->request->getVar('paket');
        $order_id = rand();

        $transaction_details = array(
            'order_id' => $order_id,
            'gross_amount' =>  $harga, // no decimal allowed for creditcard
        );
        // dd($transaction_details);

        // Optional
        // $item1_details = array(
        //     'id' => $this->request->getVar('id'),
        //     'price' => $harga,
        //     'quantity' => 1,
        //     'name' => $paket,
        // );
        // Populate items
        $pajak = ($harga + 1000) * 0.1;
        $items = array(
            array(
                'id'       => $this->request->getVar('id'),
                'price'    => $harga,
                'quantity' => 1,
                // 'name'     => $paket
                'name'     => "isi Saldo Air $harga"
            ),
            // array(
            //     'id'       => 'Admin',
            //     'price'    => 1000,
            //     'quantity' => 1,
            //     'name'     => 'biaya admin'
            // ),
            // array(
            //     'id'       => 'pajak',
            //     'price'    => "$pajak",
            //     'quantity' => 1,
            //     'name'     => 'PPN 10%'
            // )
        );

        // Optional
        // $item_details = array($item1_details);

        // Optional
        $billing_address = array(
            'first_name'    => "Spairum",
            'last_name'     => "EET",
            'address'       => "Jl. Merdeka",
            'city'          => "Pontianak",
            'postal_code'   => "78111",
            'phone'         => "0895321701798",
            'country_code'  => 'IDN'
        );

        // Optional
        $shipping_address = array(
            'first_name'    => $akun['nama'],
            'last_name'     => $akun['nama_belakang'],
            'address'       => "",
            'city'          => "",
            'postal_code'   => "",
            'phone'         => $akun['telp'],
            'country_code'  => 'IDN'
        );

        // Optional
        $customer_details = array(
            'first_name'    => $akun['nama_depan'],
            'last_name'     => $akun['nama_belakang'],
            'email'         => $akun['email'],
            'phone'         => $akun['telp'],
            'billing_address'  => $billing_address,
            'shipping_address' => $shipping_address
        );
        // Optional, remove this to display all available payment methods
        // $enable_payments = array(
        //     "credit_card", "mandiri_clickpay", "cimb_clicks",
        //     "bca_klikbca", "bca_klikpay", "bri_epay", "echannel", "permata_va",
        //     "bca_va", "bni_va", "bri_va", "other_va", "gopay", "indomaret", "Alfamart",

        // );
        // $enable_payments = array(
        //     "bri_epay", "echannel", "permata_va",
        //     "bca_va", "bni_va", "bri_va", "other_va", "gopay", "indomaret", "Alfamart",
        // );
        $enable_payments = array(
            "gopay", "indomaret", "Alfamart", "qris"
        );

        // Fill transaction details
        $transaction = array(
            'enabled_payments' => $enable_payments,
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            // 'item_details' => $item_details,
            'item_details' => $items,
        );

        $snapToken = \Midtrans\Snap::getSnapToken($transaction);
        // dd($snapToken);


        // $status = \Midtrans\Transaction::status($order_id);
        // echo "status = ";
        $data = [
            'order_id' => $order_id,
            'user_id' => $akun['id_user'],
            'status' => 'Token',
            'created_at' => Time::now('Asia/Jakarta')
        ];
        // dd($status);
        $this->TransaksiModel->addOrder($data);


        $data = [
            'title' => 'Pembayaran | Spairum.com',
            'page' => 'Pembayaran',
            'akun' => $akun,
            'snapToken' => $snapToken,
            'paket' => $paket,
            'harga' => $harga,

        ];
        // $this->AuthLibaries->notif($akun, "Membuka halaman Membeli");
        return view('user/snap', $data);
    }

    public function editprofile()
    {
        $akun = $this->AuthLibaries->authCek();

        $data = [
            'title' => 'Edit Profile | Spairum.com',
            'akun' => $akun,
            'validation' => \Config\Services::validation()
        ];

        return view('user/editprofile', $data);
    }

    public function profileupdate()
    {
        $akun = $this->AuthLibaries->authCek();
        $id = $akun['id'];
        $telp = $this->request->getVar('telp');
        $image = \Config\Services::image();
        if ($akun['telp'] == $telp) {
            $rules_telp = 'required';
        } else {
            $rules_telp = 'required|is_natural|min_length[10]|is_unique[user.telp]';
        }

        if (!$this->validate([
            'profil' => [
                'rules'  => 'is_image[profil]|mime_in[profil,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'is_image' => 'yang anda pilih bukan Gambar',
                    'mime_in' => 'format file tidak mendukung'
                ]
            ],
            'telp' => [
                'rules'  =>  $rules_telp,
                'errors' => [
                    'required' => 'nomor telpon wajid di isi',
                    'is_natural' => 'nomor telpon tidak benar',
                    'min_length' => 'nomor telpon tidak valid',
                    'is_unique' => 'nomor telp sudah terdaftar'
                ]
            ],

        ])) {
            $validation = \config\Services::validation();

            // session()->setFlashdata('salah', 'Nomor telpon tidak bisa digunakan');

            return redirect()->to('/editprofile')->withInput()->with('validation', $validation);
        }

        $fileProfil = $this->request->getFile('profil');

        // apakah foto di ganti
        $fotolama = $this->request->getVar('profilLama');


        if ($fileProfil->getError() == 4) {
            $url = $fotolama;
        } else {
            $potoProfil = $fileProfil->getName();
            $mime = $fileProfil->getMimeType();
            $fileProfil->move('./img/user', $potoProfil);
            $image->withFile("./img/user/$potoProfil")->resize(300, 300, false, 'auto')->save("./img/user/$potoProfil");
            $file = new \CodeIgniter\Files\File("./img/user/$potoProfil");
            $link = $file->getRealPath();
            $img = new \CURLFILE($link);
            $img->setMimetype($mime);
            $img->setPostFilename($potoProfil);
          
            $curl = curl_init();
            $headers = array("Content-Type:multipart/form-data");

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://cdn.spairum.my.id/api/upload/single/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HEADER => true,
                // CURLOPT_SSL_VERIFYPEER => false, // this line makes it work under https
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_POSTFIELDS => array('image' => $img),
            ));

            $response = curl_exec($curl);
            $status = curl_getinfo($curl);
            unlink("./img/user/$potoProfil");

            if (!curl_errno($curl)) {
                $status = curl_getinfo($curl);
                if ($status['http_code'] == 200) {
                    $info = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
                    $body = substr($response, $info);
                } else {
                    // unlink("./img/user/$potoProfil");
                    // dd($status);
                    session()->setFlashdata('salah', 'sorry Gagal mengupdate foto profil');
                    return redirect()->to('/editprofile');
                }
            } else {
                $errmsg = curl_error($curl);
                // dd($errmsg);
            }

            // curl_close($curl);
        
            $url = json_decode($body, true)['data']['url'];
 
        }


        $data = [
            'nama_depan' => $this->request->getVar('nama_depan'),
            'nama_belakang' => $this->request->getVar('nama_belakang'),
            // 'nama' => $this->request->getVar('nama'),
            // 'telp' => $this->request->getVar('telp'),
            // 'telp' => $telp,
            'profil' => $url,
            // 'validation' => \Config\Services::validation()



        ];

        $this->UserModel->updateprofile($data, $id);
        $this->UserModel->save([
            'id' => $akun['id'],
            'telp' => $telp,
        ]);
        session()->setFlashdata('Berhasil', 'Profile anda telah di perbaharui');
        return redirect()->to('/user');
    }

    public function emailupdate()
    {
        $akun = $this->AuthLibaries->authCek();
        if (!$this->validate([
            'email' => [
                'rules'  => 'required|valid_email|is_unique[user.email]',
                'errors' => [
                    'required' => '{field} wajid di isi',
                    'valid_email' => 'alamat email tidak benar',
                    'is_unique' => '{field} sudah terdaftar'
                ]
            ],
        ])) {
            $validation = \config\Services::validation();

            return redirect()->to('/editprofile')->withInput()->with('validation', $validation);
        }
        $email = $this->request->getVar('email');
        helper('text');
        $token = random_string('alnum', 28);
        $cekOtp =  $this->OtpModel->cekid($akun['id_user']);
        $nama = $akun['nama'];
        $nama_depan = $akun['nama_depan'];
        $nama_belakang = $akun['nama_belakang'];

        $this->OtpModel->save([
            'id' => $cekOtp['id'],
            'id_user' => $cekOtp['id_user'],
            'nama' => $nama,
            'email' => $email,
            'link' => $token,
            'status' => 'Ganti Email',
        ]);
        $this->HistoryModel->save([
            'id_master' => $akun['id_user'],
            'Id_slave' => "User",
            'Lokasi' => "Cek email anda -> $email ",
            'status' => 'Anda menganti Email',
        ]);
        $pesanEmail = ([
            'email' => $email,
            'fullname' => "$nama_depan $nama_belakang",
            'token' => $token,
            'subject' => 'Ganti Email Akun Anda',
            'status' => 'change',
            'lastemail' => $akun['email'],

        ]);
        $this->AuthLibaries->sendMqtt('Email/sendEmailOtp', json_encode($pesanEmail),  $akun['id_user']);

        // $this->email->setFrom('infospairum@gmail.com', 'noreply-spairum');
        // $this->email->setTo($email);
        // $this->email->setSubject('Ganti Email Akun Anda');
        // $this->email->setMessage(" <h1>Hallo $nama_depan $nama_belakang </h1>
        // <p>Anda baru saja menganti Email <br>Email anda akan terganti setelah klik verifikasi pada tautan dibawah : </p>
        // <a href='https://air.spairum.my.id/verifikasi/$token' style='display:block;width:115px;height:25px;background:#0008ff;padding:10px;text-align:center;border-radius:5px;color:white;font-weight:bold'> verifikasi</a>
        // <br>
        // <p>Salam Hormat Kami Tim Support Spairum</p>
        // <a href='https://wa.me/+6285159174224'>Spairum: 085159174224 </a>
        // ");
        // $this->email->send();

        session()->setFlashdata('Berhasil', "Email anda akan diganti setelah anda memverifikasi email anda. cek di kotak masuk atau di spam");
        return redirect()->to('/user');
    }

    public function verifikasi($link)
    {
        $cek = $this->OtpModel->cek($link);
        if (empty($cek)) {
            session()->setFlashdata('gagal', 'Akun sudah di verifikasi');
            return redirect()->to('/');
        }
        $userCek =  $this->UserModel->cek_id($cek['id_user']);
        $this->UserModel->save([
            'id' => $userCek['id'],
            'email' => $cek['email'],

        ]);
        $this->OtpModel->save([
            'id' => $cek['id'],
            'link' => substr(sha1($cek['link']), 0, 10),
            'status' => 'email telah di perbahrui',
        ]);
        $this->HistoryModel->save([
            'id_master' => $cek['id_user'],
            'Id_slave' => "User",
            'Lokasi' => $cek['email'],
            'status' => 'Email telah di perbahrui',
        ]);
        session()->setFlashdata('flash', "Email anda telah di perbarui, silahkan login.");
        return redirect()->to('/');
    }

    public function changepassword()
    {
        $akun = $this->AuthLibaries->authCek();

        $data = [
            'title' => 'Change Password | Spairum.com',
            'akun' => $akun,
            'validation' => \Config\Services::validation()
        ];

        return view('user/change_password', $data);
    }

    public function passwordupdate()
    {

        $akun = $this->AuthLibaries->authCek();
        $id = $akun['id'];
        $password_old = $this->request->getVar('password_lama');
        $cek = password_verify($password_old, ($akun['password']));
        //dd($cek);
        if (($akun['password'] == $cek)) {
            if (!$this->validate([
                'password_baru' => [
                    'rules'  => 'required|min_length[8]',
                    'errors' => [
                        'required' => 'Password Baru wajid di isi',
                        'min_length[8]' => 'Password Minimal 8 karakter'
                    ]
                ],
                'password_ualangi' => [
                    'rules'  => 'required|matches[password_baru]',
                    'errors' => [
                        'required' => 'password wajid di isi',
                        'matches' => 'password tidak sama'
                    ]
                ]

            ])) {
                $validation = \config\Services::validation();

                return redirect()->to('/changepassword')->withInput()->with('validation', $validation);
            }
        } else {
            // dd($id);
            session()->setFlashdata('salah', 'password lama anda salah');
            return redirect()->to('/changepassword');
        }

        $data = [
            'validation' => \Config\Services::validation()

        ];
        $this->UserModel->save([
            'id' => $id,
            'password' => password_hash($this->request->getVar('password_baru'), PASSWORD_BCRYPT),
        ]);
        $this->HistoryModel->save([
            'id_master' => $akun['id_user'],
            'Id_slave' => "User",
            'status' => 'Ganti Password',
        ]);
        session()->setFlashdata('Berhasil', 'Password anda telah di ubah');
        return redirect()->to('/user');
    }
}
