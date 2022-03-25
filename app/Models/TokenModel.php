<?php

namespace App\Models;

use CodeIgniter\Model;

class TokenModel extends Model
{
    protected $table      = 'token';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $useTimestamps    = true;
    protected $allowedFields    =
    [
        'id_user',
        'token',
        'status'
    ];

    public function cek($token)
    {
        return $this->db->table('token')
            ->where(array('token' => $token))
            ->get()->getRowArray();
    }
}
