<?php

namespace App\Models;

use CodeIgniter\Model;

class AngkatanModel extends Model
{
    protected $table      = 'angkatan';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields =  [
        'id',
        'tahun',
    ];

    protected $useTimestamps = false;

    public function angkatan()
    {
        $this->orderBy('tahun', 'desc');
        return $this;
    }
    public function filteredAngkatan()
    {
        $this->orderBy('tahun', 'desc');
        if (session()->get('role') == 2) {
            $this->where('tahun', session()->get('angkatan'));
        }
        return $this;
    }
}
