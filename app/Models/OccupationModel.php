<?php

namespace App\Models;

use CodeIgniter\Model;

class OccupationModel extends Model
{
    protected $table      = 'occupations';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields =  [
        'id',
        'name',
    ];

    protected $useTimestamps = false;

}
