<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;
use CodeIgniter\RESTful\ResourceController;

class Mesin extends ResourceController
{
    protected $format = 'json';
    protected $modelName = 'App\Models\StasiunModel';

    public function index()
    {
        return $this->respond($this->model->findAll(), 200);
    }

    public function detail($id = NULL)
    {
        $get = $this->model->getStasiun($id);
        return $this->respond($get, 200);
    }

    public function edit($id = null)
    {
        $valid = $this->validate([
            'isi' => [
                'label' => 'Mili Liter',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Wajib di isi'
                ]
            ],
            'indikator' => [
                'label' => 'status',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Wajib di isi'
                ]
            ],
        ]);
        if (!$valid) {
            $response = [
                'status' => 500,
                'error' => true,
                'data' => \config\Services::validation()->getErrors(),
            ];
            return $this->respond($response, 500);
        } else {
            $isi = $this->request->getVar('isi');
            $indikator = $this->request->getVar('indikator');
            $updated_at = Time::now('Asia/Jakarta');
            $data = [
                'isi' => $isi,
                'indikator' => $indikator,
                'updated_at' => $updated_at,
            ];
            $edit = $this->model->updateStasiun($data, $id);
            if ($edit) {
                $msg = ['massage' => 'berhasil update'];
                $response = [
                    'status' => 200,
                    'error' => false,
                    'data' => $msg
                ];
                return $this->respond($response, 200);
            }
        }
    }
}
