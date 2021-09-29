<?php

namespace App\Models;

use CodeIgniter\Model;

class SaldoModel extends Model
{
    protected $table      = 'saldo';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    public function cek_id($id_user)
    {
        return $this->db->table('saldo')
            ->where(array('id_user' => $id_user))
            ->get()->getRowArray();
    }
}
