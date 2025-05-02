<?php

namespace App\Models;

use CodeIgniter\Model;

class BidangKerjaModel extends Model
{
    protected $table      = 'occupations';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields =  [
        'id',
        'name',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = false;

    public function bidangKerja($filter){
        if (isset($filter['q']) && !empty($filter['q'])) {
            $this->like('occupations.name', $filter['q'], 'both');
        }
        return $this;
    }

}
