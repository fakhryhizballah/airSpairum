<?php

namespace App\Controllers;

use App\Libraries\AuthLibaries;
use App\Models\StasiunModel;

class Maps extends BaseController
{
    public function __construct()
    {
        $this->AuthLibaries = new AuthLibaries();
        $this->StasiunModel = new StasiunModel();
    }
    public function StasiunAir()
    {
        $akun = $this->AuthLibaries->authCek();
        $stasiun = $this->StasiunModel->getStasiun();
        return json_encode($stasiun);
        // dd($stasiun);
    }
}
