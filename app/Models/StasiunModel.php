<?php

namespace App\Models;

use CodeIgniter\Model;


class StasiunModel extends Model
{
    // protected $table            = 'mesin';
    protected $useTimestamps    = true;

    public function getStasiun($id = false)
    {
        if ($id === false) {
            // return $this->findAll();
            return $this->db->table('mesin')->get()->getResultArray();
        } else {
            return $this->db->table('mesin')->getWhere(['id_mesin' => $id])->getRowArray();
        }
    }

    public function updateStasiun($data, $id)
    {
        return $this->db->table($this->table)->update($data, ['id_mesin' => $id]);
    }

    public function cek_mesin($id_mesin)
    {
        return $this->db->table('mesin')
            ->where(array('id_mesin' => $id_mesin))
            ->get()->getRowArray();
    }
    public function cek_newID($new_id)
    {
        return $this->db->table('new_mesin')
            ->where(array('new_id' => $new_id))->select('nama, harga, faktor, id_mesin, new_id')
            ->get()->getRowArray();
    }
    public function cek_ID($id)
    {
        return $this->db->table('new_mesin')
            ->where(array('id_mesin' => $id))->select('nama, harga, faktor, id_mesin, new_id')
            ->get()->getRowArray();
    }
}
