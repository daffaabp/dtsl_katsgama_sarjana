<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdiModel extends Model
{
    protected $table      = 'prodi';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields =  [
        'id',
        'nprodi',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = false;

    
    public function prodi($filter){
        if (isset($filter['q']) && !empty($filter['q'])) {
            $this->like('prodi.nprodi', $filter['q'], 'both');
        }
        return $this;
    }

}
