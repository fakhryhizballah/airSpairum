<?php

namespace App\Models;

use CodeIgniter\Model;

class BotolModel extends Model
{
    protected $table      = 'botol';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $allowedFields    =
    [
        'id_user',
    ];
    public function cek_botol($id)
    {
        return $this->db->table('botol')
            ->where(array('id_botol' => $id))
            ->get()->getRowArray();
    }
    public function botol($idUser)
    {
        return $this->table('botol')->like('id_user', $idUser)->get()->getResultArray();
        // return $this->table('botol')->like('id_user', $idUser)->get()->getResultObject();
    }
}
