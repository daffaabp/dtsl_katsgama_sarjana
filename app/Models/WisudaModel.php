<?php

namespace App\Models;

use CodeIgniter\Model;

class WisudaModel extends Model
{
    protected $table      = 'wisuda';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields =  [
        'id',
        'idorg',
        'twisuda',
        'blnwisuda',
    ];

    protected $useTimestamps = false;

}
