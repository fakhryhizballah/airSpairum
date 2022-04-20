<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class VoucherModel extends Model
{
    protected $table      = 'voucher';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'id_akun',
        'id_user',
        'kvoucher',
        'ket',
        'nominal',
    ];

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

    public function harianvocher($id_user, $kvoucher)
    {
        // dd(Time::today('Asia/Jakarta'));
        return $this->db->table('voucher')
        ->where(array('id_user' => $id_user, 'kvoucher' => $kvoucher, 'created_at >=' => Time::today('Asia/Jakarta')))
        ->get()->getRowArray();
    }
}
