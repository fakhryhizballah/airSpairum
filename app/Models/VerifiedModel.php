<?php

namespace App\Models;

use CodeIgniter\Model;

class VerifiedModel extends Model
{
    protected $table      = 'verified_user';
    // Uncomment below if you want add primary key
    protected $primaryKey = 'id';
    protected $useTimestamps    = true;
    protected $allowedFields    =   [
        'id_user',
        'email_status',
        'verified_email_date',
        'token_email',
        'whatsapp_status',
        'verified_wa_date',
        'token_wa',
    ];

    public function cekid($id_user)
    {
        return $this->db->table('verified_user')
            ->where(array('id_user' => $id_user))
            ->get()->getRowArray();
    }

    public function cekWa($link)
    {
        return $this->db->table('verified_user')
            ->where(array('token_wa' => $link))
            ->get()->getRowArray();
    }

    public function emailtoken($token, $id_user)
    {
        return $this->db->table('verified_user')
        ->where(array('token_email' => $token, 'id_user' => $id_user))
            ->get()->getRowArray();
    }
    public function watoken($token, $id_user)
    {
        return $this->db->table('verified_user')
        ->where(array('token_wa' => $token, 'id_user' => $id_user))
            ->get()->getRowArray();
    }
}
