<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoryModel extends Model
{
    protected $table      = 'history';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $useTimestamps    = true;
    protected $allowedFields    =
    [
        'id_master',
        'Id_slave',
        'Lokasi',
        'status',
        'isi',
        'updated_at',
        'created_at'

    ];

    public function search($keyword)
    {
        // $builder = $this->tabel('history');
        // $builder->like('id_master', $keyword);
        // return $builder;

        return $this->table('history')->like('id_master', $keyword);
    }
}
