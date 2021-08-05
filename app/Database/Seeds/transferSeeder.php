<?php

namespace App\Database\Seeds;

use CodeIgniter\I18n\Time;

class TransferSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            [
                'id_slave'      => 'COV0001PNK002', // Kode mesin, nomor urut, Kota, kecamatan, mitra
                'vaule'           => '0',
                'created_at'    => Time::now('Asia/Jakarta'),
                'updated_at'    => Time::now('Asia/Jakarta')
            ],
            [
                'id_slave'      => 'COV0002PNK003',
                'vaule'           => '0',
                'created_at'    => Time::now('Asia/Jakarta'),
                'updated_at'    => Time::now('Asia/Jakarta')
            ],
            [
                'id_slave'      => 'COV0003PNK003',
                'vaule'           => '0',
                'created_at'    => Time::now('Asia/Jakarta'),
                'updated_at'    => Time::now('Asia/Jakarta')
            ],
            [
                'id_slave'      => 'COV0004PNK004',
                'vaule'           => '0',
                'created_at'    => Time::now('Asia/Jakarta'),
                'updated_at'    => Time::now('Asia/Jakarta')
            ]
        ];

        $this->db->table('transfer')->insertBatch($data);
    }
}
