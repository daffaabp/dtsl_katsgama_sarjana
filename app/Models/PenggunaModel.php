<?php

namespace App\Models;

use CodeIgniter\Model;

class PenggunaModel extends Model
{
    protected $table      = 'pengguna';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields =  [
        'id',
        'nama',
        'username',
        'password',
        'role',
        'active',
        'angkatan',
    ];

    protected $useTimestamps = false;

    public function pengguna($filter)
    {
        $this->table('pengguna');
        $this->select(
            'pengguna.id,
            pengguna.nama,
            pengguna.username,
            pengguna.role,
            pengguna.active,
            pengguna.angkatan,
            roles.role as role_name'
        );
        $this->join('roles', 'roles.id = pengguna.role', 'left');

        // Protect super admin from list
        $this->where('pengguna.role !=', 3);
        
        // Filter admin angkatan
        if (session()->get('role') != 3 && session()->get('angkatan')) {
            $this->where('angkatan', session()->get('angkatan'));
        }

        // Filter Query
        if (isset($filter['q']) && !empty($filter['q'])) {
            $this->like('pengguna.nama', $filter['q'], 'both');
        }

        if (isset($filter['angkatan']) && !empty($filter['angkatan'])) {
            $this->where('pengguna.angkatan', $filter['angkatan']);
        }

        if (isset($filter['role']) && !empty($filter['role'])) {
            $this->where('pengguna.role', $filter['role']);
        }

        if (isset($filter['active']) && !empty($filter['active'])) {
            if ($filter['active'] == 'yes') {
                $active = 1;
            } else {
                $active = 0;
            }
            $this->where('pengguna.active', $active);
        }
        // $this->groupBy('data_alumni.id');
        return $this;
    }
}
