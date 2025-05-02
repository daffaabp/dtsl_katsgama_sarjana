<?php

namespace App\Models;

use CodeIgniter\Model;

class RegionModel extends Model
{
    protected $table      = 'regions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields =  [
        'id',
        'name',
        'code',
        'province',
        'city',
    ];

    protected $useTimestamps = false;


    public function province()
    {
        return $this
            ->like('code', '000')
            ->findAll();
    }
}
