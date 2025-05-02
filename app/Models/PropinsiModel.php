<?php

namespace App\Models;

use CodeIgniter\Model;

class PropinsiModel extends Model
{
    protected $table      = 'propinsi';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields =  [
        'id',
        'nama',
        'prop_code',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = false;

    public function propinsi($filter){
        if (isset($filter['q']) && !empty($filter['q'])) {
            $this->like('propinsi.nama', $filter['q'], 'both');
        }
        return $this;
    }

}
