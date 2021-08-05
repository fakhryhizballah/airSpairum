<?php

namespace App\Models;

use CodeIgniter\Model;

class VoucherModel extends Model
{
    protected $table      = 'voucher';
    protected $useTimestamps    = true;
    protected $allowedFields    = ['id_user', 'ket'];

    public function cari($kvoucher)
    {
        return $this->db->table('voucher')
            ->where(array('kvoucher' => $kvoucher))
            ->get()->getRowArray();
    }

    public function updatevoucher($data, $id)
    {
        return $this->db->table('voucher')
            ->where('id', $id)
            ->update($data);
    }
}
