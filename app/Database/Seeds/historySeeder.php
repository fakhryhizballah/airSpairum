<?php

namespace App\Database\Seeds;

use CodeIgniter\I18n\Time;

class HistorySeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            [
                'id_master'     => 'DRV0001PNK002001',
                'id_slave'      => 'COV0002PNK003',
                'Lokasi'        => 'Pelabuhan SengHie',
                'status'        => 'Pengisian',
                'isi'           => '1000',
                'created_at'    => Time::now(),
                'updated_at'    => Time::now()
            ],
            [
                'id_master'     => 'DRV0001PNK002001',
                'id_slave'      => 'COV0001PNK002',
                'Lokasi'        => 'Alun Alun Kapuas',
                'status'        => 'Pengisian',
                'isi'           => '500',
                'created_at'    => Time::now(),
                'updated_at'    => Time::now()
            ],
            [
                'id_master'     => 'DRV0001PNK002001',
                'id_slave'      => 'COV0002PNK003',
                'Lokasi'        => 'Pelabuhan SengHie',
                'status'        => 'Pengisian',
                'isi'           => '500',
                'created_at'    => Time::now(),
                'updated_at'    => Time::now()
            ],
            [
                'id_master'     => 'DRV0002PNK002001',
                'id_slave'      => 'COV 0002 PNK 003',
                'Lokasi'        => 'Pelabuhan SengHie',
                'status'        => 'Pengisian',
                'isi'           => '540',
                'created_at'    => Time::now(),
                'updated_at'    => Time::now()
            ],
            [
                'id_master'     => 'USR19',
                'id_slave'      => 'COV0002PNK003',
                'Lokasi'        => 'Pelabuhan SengHie',
                'status'        => 'Pembelian',
                'isi'           => '1000',
                'created_at'    => Time::now(),
                'updated_at'    => Time::now()
            ],
            [
                'id_master'     => 'neco',
                'id_slave'      => 'COV0001PNK002',
                'Lokasi'        => 'Alun Alun Kapuas',
                'status'        => 'pembelian',
                'isi'           => '500',
                'created_at'    => Time::now(),
                'updated_at'    => Time::now()
            ],

        ];

        $this->db->table('history')->insertBatch($data);
    }
}
