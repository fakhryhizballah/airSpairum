<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table      = 'transaksi';
    protected $allowedFields    =
    [
        'id_user',
        'order_id',
        'harga',
        'bank',
        'va_code',
        'Biller_Code',
        'Bill_Key',
        'Payment_Code',
        'Merchant_Code',
        'User_Id',
        'status',
    ];
    public function search($keyword)
    {
        // $builder = $this->tabel('history');
        // $builder->like('id_master', $keyword);
        // return $builder;
        return $this->table('transaksi')->like('id_user', $keyword);
    }

    public function editpay($order_id)
    {
        return $this->db->table('transaksi')
            ->where(array('order_id' => $order_id))
            ->get()->getRowArray();
    }
}
