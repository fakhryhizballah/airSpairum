<?php

namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model
{
    protected $table      = 'device';
    // Uncomment below if you want add primary key
    protected $primaryKey = 'id';
    protected $useTimestamps    = true;
    protected $allowedFields    =   [
        'key',
        'name',
        'id_user',
        'user_agent',
        'ip_user',
        'country',
        'regionName',
        'city',
        'isp',
        'org',
        'as',
    ];
    public function cekKey($key)
    {
        return $this->db->table('device')
            ->where(array('key' => $key))
            ->get()->getRowArray();
    }
}
