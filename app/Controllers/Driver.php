<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\DriverModel;
use App\Models\ExploreModel;
use App\Models\LoginModel;
use App\Models\HistoryModel;


class Driver extends Controller
{
    public function __construct()
    {
        $this->DriverModel = new DriverModel();
        $this->ExploreModel = new ExploreModel();
        $this->LoginModel = new LoginModel();
        $this->HistoryModel = new HistoryModel();
    }

    public function index()
    {

        if (session()->get('id_driver') == '') {
            session()->setFlashdata('gagal', 'Login dulu');
            return redirect()->to('/');
        }
        $nama = session()->get('nama');
        $akun = $this->LoginModel->cek_login($nama);

        $data = [
            'title' => 'Profil | Spairum.com',
            'akun' => $akun

        ];

        return   view('Home/profil', $data);
    }

    public function explore()
    {

        if (session()->get('id_driver') == '') {
            session()->setFlashdata('gagal', 'Login dulu');
            return redirect()->to('/');
        }
        $stasiun = $this->ExploreModel->findAll();
        $data = [
            'title' => 'Explore | Spairum.com',
            'page' => 'Explore',
            'stasiun' => $stasiun
        ];

        return   view('Home/explore', $data);
    }

    public function History()
    {
        if (session()->get('id_driver') == '') {
            session()->setFlashdata('gagal', 'Login dulu');
            return redirect()->to('/');
        }
        $keyword = session()->get('id_driver');
        // dd($keyword);
        // $data = $this->HistoryModel->search($keyword);
        $history = $this->HistoryModel->search($keyword);

        $history = $this->HistoryModel->findAll();
        $data = [
            'title' => 'Riwayat | Spairum.com',
            'page' => 'Riwayat',
            'history' => $history

        ];

        return   view('Home/History', $data);
    }

    public function Edit()
    {

        if (session()->get('nama') == '') {
            session()->setFlashdata('gagal', 'Login dulu');
            return redirect()->to('/');
        }
        $nama = session()->get('nama');
        $akun = $this->LoginModel->cek_login($nama);
        $data = [
            'title' => 'Edit Profile | Spairum.com',
            'page' => 'Edit Profile',
            'validation' => \Config\Services::validation(),
            'akun' => $akun
        ];
        // return view('auth/regis', $data);
        return   view('Home/edit', $data);
    }

    public function up_telp($id)
    {
        if (!$this->validate([
            'telp' => [
                'rules'  => 'required|is_natural|min_length[10]|is_unique[driver.telp]',
                'errors' => [
                    'required' => 'nomor telpon wajid di isi',
                    'is_natural' => 'nomor telpon tidak benar',
                    'min_length' => 'nomor telpon tidak valid',
                    'is_unique' => 'nomor telp sudah terdaftar'
                ]
            ],
        ])) {
            $validation = \config\Services::validation();
            return redirect()->to('/driver/edit')->withInput();
        }

        // dd($this->request->getVar());
        $this->DriverModel->save([
            'id' => $id,
            'telp' => $this->request->getVar('telp'),

        ]);
        return redirect()->to('/driver');
    }
    public function up_profil($id)
    {
        if (!$this->validate([
            'profil' => [
                'rules' => 'uploaded[profil]|max_size[profil,1024]|is_image[profil]|mime_in[profil,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Pilih Gambar terlebih dahulu',
                    'is_image' => 'yang anda pilih bukan Gambar',
                    'mime_in' => 'format file tidak mendukung'
                ]
            ]
        ])) {
            return redirect()->to('/driver/edit')->withInput();
        }
        // Save file
        $fileProfil = $this->request->getFile('profil');
        // dd($fileProfil);
        $fileProfil->move('img/driver');
        $potoProfil = $fileProfil->getName();

        // dd($this->request->getVar());
        $this->DriverModel->save([
            'id' => $id,
            'profil' => $potoProfil,

        ]);
        return redirect()->to('/driver');
    }
}
