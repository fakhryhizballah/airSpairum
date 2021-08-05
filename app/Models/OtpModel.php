<?php

namespace App\Models;

use CodeIgniter\Model;

class OtpModel extends Model
{
    protected $table      = 'otp';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $useTimestamps    = true;
    protected $allowedFields    =
    [
        'id_user',
        'nama',
        'nama_depan',
        'nama_belakang',
        'email',
        'telp',
        'password',
        'link',
        'status',

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
