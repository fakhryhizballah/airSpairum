<?php

namespace App\Models;

use CodeIgniter\Model;

class ReferralModel extends Model
{
    protected $table      = 'referral';
    // Uncomment below if you want add primary key
    protected $primaryKey = 'id';
    protected $useTimestamps    = true;
    protected $allowedFields    =
    [
        'id_user',
        'id_referral',
        'referral',
    ];
    public function getReferral($id)
    {
        return $this->where('id_referral', $id)->get()->getRowArray();
    }
    public function getMyReferral($id_admin)
    {

        return $this->where('id_user', $id_admin)->get()->getRowArray();
    }
}
