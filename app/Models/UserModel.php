<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'user';
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
        'profil',
        'debit',
        'kredit'
    ];

    public function cek_login($nama)
    {
        return $this->db->table('user')
            ->where(array('nama' => $nama))
            ->orWhere(array('email' => $nama))
            ->orWhere(array('telp' => $nama))
            ->get()->getRowArray();
    }

    public function cek_id($id_user)
    {
        return $this->db->table('user')
            ->where(array('id_user' => $id_user))
            ->get()->getRowArray();
    }
    public function updateSaldo($id_user)
    {
        return $this->db->table('user')
            ->where(array('id_user' => $id_user))
            ->get()->getRowArray();
    }

    public function updateprofile($data, $id)
    {
        return $this->db->table('user')
            ->where('id', $id)
            ->update($data);
    }

    public function updateemail($data, $id)
    {
        return $this->db->table('user')
            ->where('id', $id)
            ->update($data);
    }
}
// tes