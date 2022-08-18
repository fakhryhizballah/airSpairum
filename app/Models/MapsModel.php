<?php

namespace App\Models;

use CodeIgniter\Model;

class MapsModel extends Model
{
    protected $table      = 'map';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $useTimestamps    = true;
    protected $allowedFields    =
    [
        'id_lokasi',
        'id_stasiun',
        'nama',
        'geo',
        'jenis',
        'lokasi',
        'keterangan',
    ];

    public function cek($link)
    {
        return $this->db->table('otp')
            ->where(array('link' => $link))
            ->get()->getRowArray();
    }
    public function cekid($id_user)
    {
        return $this->db->table('otp')
            ->where(array('id_user' => $id_user))
            ->get()->getRowArray();
    }
}
