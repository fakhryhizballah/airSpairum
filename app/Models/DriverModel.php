<?php

namespace App\Models;

use CodeIgniter\Model;

class DriverModel extends Model
{
    protected $table            = 'driver';
    protected $useTimestamps    = true;
    protected $allowedFields    =
    [
        'id_driver',
        'nama',
        'email',
        'cv',
        'telp',
        'password',
        'profil',
        'Trip',
        'liter',
        'poin'
    ];
}
