<?php

namespace App\Models;

use CodeIgniter\Model;


class StasiunNewModel extends Model
{
    protected $table            = 'new_mesin';
    protected $useTimestamps    = true;

    public function getStasiun($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        } else {
            return $this->getWhere(['id_mesin' => $id])->getRowArray();
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
}
