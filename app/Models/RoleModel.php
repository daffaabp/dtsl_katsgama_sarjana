<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table      = 'roles';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields =  [
        'id',
        'role',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = false;

    public function roles($filter)
    {
        if (isset($filter['q']) && !empty($filter['q'])) {
            $this->like('roles.role', $filter['q'], 'both');
        }
        return $this;
    }

    public function filteredRoles()
    {

        $this->whereNotIn('id', ['3']);
        return $this;
    }
}
