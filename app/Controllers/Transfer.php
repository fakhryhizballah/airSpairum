<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;
use CodeIgniter\RESTful\ResourceController;

class Transfer extends ResourceController
{
    protected $format = 'json';
    protected $modelName = 'App\Models\TransferModel';

    public function index()
    {
        // return $this->respond($this->model->findAll(), 200);
    }

    public function get($id = NULL)
    {
        $get = $this->model->getStasiun($id);
        return $this->respond($get, 200);
    }

    public function post($id = null)
    {
        $valid = $this->validate([
            'vaule' => [
                'label' => 'Mili Liter',
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
            $isi = $this->request->getVar('vaule');
            $updated_at = Time::now('Asia/Jakarta');
            $data = [
                'vaule' => $isi,
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
