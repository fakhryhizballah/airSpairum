<?php

namespace App\Database\Seeds;

use CodeIgniter\I18n\Time;


class StasiunSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            [
                'id_mesin'      => 'COV0001PNK002', // Kode mesin, nomor urut, Kota, kecamatan, mitra
                'lokasi'        => 'Alun Alun Kapuas',
                'geo'           => '-0.021974, 109.339413',
                'status'        => '4',
                'isi'           => '1000',
                'indikator'     => '3',
                // 'created_at'    => Time::now(),
                // 'updated_at'    => Time::now()
            ],
            [
                'id_mesin'      => 'COV0002PNK003',
                'lokasi'        => 'Pelabuhan SengHie',
                'geo'           => '-0.028365, 109.345620',
                'status'        => '5',
                'isi'           => '0',
                'indikator'     => '3',
                // 'created_at'    => Time::now(),
                // 'updated_at'    => Time::now()
            ],
            [
                'id_mesin'      => 'COV0003PNK003',
                'lokasi'        => 'Water Front',
                'geo'           => '-0.021974, 109.339413',
                'status'        => '1',
                'isi'           => '21000',
                'indikator'     => '1',
                // 'created_at'    => Time::now(),
                // 'updated_at'    => Time::now()
            ],
            [
                'id_mesin'      => 'COV0004PNK004',
                'lokasi'        => 'Taman Catur',
                'geo'           => '-0.054945, 109.348640',
                'status'        => '1',
                'isi'           => '22500',
                'indikator'     => '1',
                // 'created_at'    => Time::now(),
                // 'updated_at'    => Time::now()
            ]
        ];

        $this->db->table('mesin')->insertBatch($data);
    }
}
//oke