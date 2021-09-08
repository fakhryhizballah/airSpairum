<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    // protected $table      = 'transaksi';
    protected $updatedField  = 'updated_at';
    // protected $allowedFields    =
    // [
    //     'id_user',
    //     'order_id',
    //     'harga',
    //     'bank',
    //     'va_code',
    //     'Biller_Code',
    //     'Bill_Key',
    //     'Payment_Code',
    //     'Merchant_Code',
    //     'User_Id',
    //     'status',
    // ];
    public function search($keyword)
    {
        // $builder = $this->tabel('history');
        // $builder->like('id_master', $keyword);
        // return $builder;
        return $this->table('transaksi')->like('id_user', $keyword);
    }


    public function updatetransaksi($id, $data)
    {
        return $this->db->table('transaction')
            ->update($id, $data);
    }

    public function editpay($order_id)
    {
        return $this->db->table('transaksi')
            ->where(array('order_id' => $order_id))
            ->get()->getRowArray();
    }
    public function edittransaction($order_id)
    {
        return $this->db->table('transaction')
            ->where(array('order_id' => $order_id))
            ->get()->getRowArray();
    }

    public function statusOrder($order_id)
    {
        return $this->db->table('status_order')
            ->where('order_id', $order_id)
            ->get()->getRowArray();
    }
    public function addOrder($data)
    {
        return $this->db->table('status_order')
            ->insert($data);
    }
    // public function updateOrder($id, $data)
    // {
    //     return $this->db->table('status_order')
    //         ->where('id', $id)
    //         ->update($data);
    // }
}
