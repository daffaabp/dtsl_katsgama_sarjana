<?php

namespace App\Models;

use CodeIgniter\Model;

class AkademikModel extends Model
{
    protected $table      = 'akademik';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields =  [
        'id',
        'idorg',
        'jenjang',
        'universitas',
        'departemen',
        'tmasuk',
        'tlulus',
        'prodi',
    ];

    protected $useTimestamps = false;

}
