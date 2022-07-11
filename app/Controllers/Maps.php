<?php

namespace App\Controllers;

use App\Libraries\AuthLibaries;
use App\Models\StasiunModel;
use App\Models\MapsModel;

class Maps extends BaseController
{
    public function __construct()
    {
        $this->AuthLibaries = new AuthLibaries();
        $this->StasiunModel = new StasiunModel();
        $this->MapsModel = new MapsModel();
    }
    public function StasiunAir()
    {
        $akun = $this->AuthLibaries->authCek();
        $stasiun = $this->StasiunModel->getStasiun();
        return json_encode($stasiun);
     
    }
    public function Stasiun()
    {
        $maps = $this->MapsModel->where('jenis', 'stasiun')->findAll();
        return json_encode($maps);
     
    }
    public function banksampah()
    {
        $maps = $this->MapsModel->where('jenis', 'bank sampah')->findAll();
        return json_encode($maps);
     
    }
    public function sampah()
    {
        $maps = $this->MapsModel->where('jenis', 'tempat sampah')->findAll();
        return json_encode($maps);
     
    }
}
