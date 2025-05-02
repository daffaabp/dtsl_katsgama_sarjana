<?php

namespace App\Models;

use CodeIgniter\Model;

class AlumniModel extends Model
{
    protected $table      = 'data_alumni';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields =  [
        'id',
        'occupation_id',
        'region_id',
        'prop_id',
        'pengguna_id',
        'nama',
        'alamat',
        'notelp',
        'nowa',
        'nobb',
        'email',
        'fb',
        'alamatskrg',
        'instansi',
        'jabatan',
        'alamatktr',
        'narasumber',
        'jobfair',
        'cpkeg',
        'ket',
        'idr',
        'saran',
        'photo',
    ];

    protected $useTimestamps = false;

    public function program_sarjana($filter)
    {
        $this
            ->table('data_alumni')
            ->select(
                '
            data_alumni.id,
            data_alumni.nama,
            data_alumni.email,
            data_alumni.nowa,
            data_alumni.notelp,
            data_alumni.alamat,
            data_alumni.prop_id,
            data_alumni.jabatan,
            data_alumni.instansi,
            data_alumni.occupation_id,
            data_alumni.photo,

            wisuda.twisuda,
            wisuda.blnwisuda,

            akademik.jenjang,
            akademik.universitas,
            akademik.departemen,
            akademik.tmasuk,
            akademik.tlulus,
            propinsi.id AS propinsi_id,
            propinsi.nama AS propinsi,
            occupations.name AS occupation'
            )
            ->join('akademik', 'data_alumni.id = akademik.idorg', 'left')
            ->join('occupations', 'data_alumni.occupation_id = occupations.id', 'left')
            ->join('propinsi', 'data_alumni.prop_id = propinsi.id', 'left')
            ->join('wisuda', 'data_alumni.id = wisuda.idorg', 'left');


        // filter program sarjana
        $this->where('akademik.jenjang', 'S1');

        // filter admin angkatan
        if (session()->get('role') == 2 && session()->get('angkatan')) {
            $this->where('akademik.tmasuk', session()->get('angkatan'));
        }

        // filter QUery 
        if (isset($filter['q']) && !empty($filter['q'])) {
            $this->like('data_alumni.nama', $filter['q'], 'both');
        }

        if (isset($filter['tmasuk']) && !empty($filter['tmasuk'])) {
            $this->where('akademik.tmasuk', $filter['tmasuk']);
        }

        if (isset($filter['occupation']) && !empty($filter['occupation'])) {
            $this->where('occupations.id', $filter['occupation']);
        }

        if (isset($filter['province']) && !empty($filter['province'])) {
            $this->where('data_alumni.prop_id', $filter['province']);
        }

        if (isset($filter['jabatan']) && !empty($filter['jabatan'])) {
            $this->like('data_alumni.jabatan', $filter['jabatan'], 'both');
        }
        if (isset($filter['instansi']) && !empty($filter['instansi'])) {
            $this->like('data_alumni.instansi', $filter['instansi'], 'both');
        }
        if (isset($filter['prodi']) && !empty($filter['prodi'])) {
            $db = db_connect();
            $prodi = $db->table('prodi')->limit(1)->get()->getRowArray();
            $this->like('akademik.prodi', $prodi['nprodi'], 'both');
        }
        if (isset($filter['prodiAlt']) && !empty($filter['prodiAlt'])) {
            $this->like('akademik.prodi', $filter['prodiAlt'], 'both');
        }

        if (isset($filter['twisuda']) && !empty($filter['twisuda'])) {
            $this->where('wisuda.twisuda', $filter['twisuda']);
        }

        if (isset($filter['blnwisuda']) && !empty($filter['blnwisuda'])) {
            $this->where('wisuda.blnwisuda', $filter['blnwisuda']);
        }

        $this->groupBy('data_alumni.id');
        return $this;
    }


    public function data_alumni($filter)
    {
        $this
            ->table('data_alumni')
            ->select(
                '
            data_alumni.id,
            data_alumni.nama,
            data_alumni.email,
            data_alumni.nowa,
            data_alumni.notelp,
            data_alumni.alamat,
            data_alumni.prop_id,
            data_alumni.jabatan,
            data_alumni.instansi,
            data_alumni.occupation_id,
            data_alumni.photo,

            akademik.jenjang,
            akademik.universitas,
            akademik.departemen,
            akademik.tmasuk,
            akademik.tlulus,
            propinsi.id AS propinsi_id,
            propinsi.nama AS propinsi,
            occupations.name AS occupation'
            )
            ->join('akademik', 'data_alumni.id = akademik.idorg', 'left')
            ->join('occupations', 'data_alumni.occupation_id = occupations.id', 'left')
            ->join('propinsi', 'data_alumni.prop_id = propinsi.id', 'left');


        // filter program sarjana
        $this->whereIn('akademik.jenjang', ['S1']);

        // filter admin angkatan
        // if (session()->get('role') == 2 && session()->get('angkatan')) {
        //     $this->where('akademik.tmasuk', session()->get('angkatan'));
        // }

        // filter QUery 
        if (isset($filter['q']) && !empty($filter['q'])) {
            $this->like('data_alumni.nama', $filter['q'], 'both');
        }

        if (isset($filter['tmasuk']) && !empty($filter['tmasuk'])) {
            $this->where('akademik.tmasuk', $filter['tmasuk']);
        }

        if (isset($filter['occupation']) && !empty($filter['occupation'])) {
            $this->where('occupations.id', $filter['occupation']);
        }

        if (isset($filter['province']) && !empty($filter['province'])) {
            $this->where('data_alumni.prop_id', $filter['province']);
        }

        if (isset($filter['jabatan']) && !empty($filter['jabatan'])) {
            $this->like('data_alumni.jabatan', $filter['jabatan'], 'both');
        }
        if (isset($filter['instansi']) && !empty($filter['instansi'])) {
            $this->like('data_alumni.instansi', $filter['instansi'], 'both');
        }
        if (isset($filter['prodi']) && !empty($filter['prodi'])) {
            $db = db_connect();
            $prodi = $db->table('prodi')->limit(1)->get()->getRowArray();
            $this->like('akademik.prodi', $prodi['nprodi'], 'both');
        }
        if (isset($filter['prodiAlt']) && !empty($filter['prodiAlt'])) {
            $this->like('akademik.prodi', $filter['prodiAlt'], 'both');
        }
        $this->groupBy('data_alumni.id');
        return $this;
    }


    public function export_alumni($filter)
    {
        $this
            ->table('data_alumni')
            ->select(
                '
            data_alumni.id,
            data_alumni.nama,
            data_alumni.email,
            data_alumni.nowa,
            data_alumni.notelp,
            data_alumni.alamat,
            data_alumni.jabatan,
            data_alumni.instansi,
            data_alumni.occupation_id,
            
            wisuda.twisuda,
            wisuda.blnwisuda,

            propinsi.nama AS propinsi,
            occupations.name AS occupation'
            )
            ->join('akademik', 'data_alumni.id = akademik.idorg', 'left')
            ->join('occupations', 'data_alumni.occupation_id = occupations.id', 'left')
            ->join('propinsi', 'data_alumni.prop_id = propinsi.id', 'left')
            ->join('wisuda', 'data_alumni.id = wisuda.idorg', 'left');

      
        // filter QUery 
        if (isset($filter['q']) && !empty($filter['q'])) {
            $this->like('data_alumni.nama', $filter['q'], 'both');
        }

        if (isset($filter['tmasuk']) && !empty($filter['tmasuk'])) {
            $this->where('akademik.tmasuk', $filter['tmasuk']);
        }

        if (isset($filter['occupation']) && !empty($filter['occupation'])) {
            $this->where('occupations.id', $filter['occupation']);
        }

        if (isset($filter['province']) && !empty($filter['province'])) {
            $this->where('data_alumni.prop_id', $filter['province']);
        }

        if (isset($filter['jabatan']) && !empty($filter['jabatan'])) {
            $this->like('data_alumni.jabatan', $filter['jabatan'], 'both');
        }
        if (isset($filter['instansi']) && !empty($filter['instansi'])) {
            $this->like('data_alumni.instansi', $filter['instansi'], 'both');
        }
        if (isset($filter['prodi']) && !empty($filter['prodi'])) {
            $db = db_connect();
            $prodi = $db->table('prodi')->limit(1)->get()->getRowArray();
            $this->like('akademik.prodi', $prodi['nprodi'], 'both');
        }
        if (isset($filter['prodiAlt']) && !empty($filter['prodiAlt'])) {
            $this->like('akademik.prodi', $filter['prodiAlt'], 'both');
        }
        if (isset($filter['twisuda']) && !empty($filter['twisuda'])) {
            $this->where('wisuda.twisuda', $filter['twisuda']);
        }

        if (isset($filter['blnwisuda']) && !empty($filter['blnwisuda'])) {
            $this->where('wisuda.blnwisuda', $filter['blnwisuda']);
        }
        
           
              
        $this->groupBy('data_alumni.id');
    
        return $this;
    }

    public function mapping_pengguna($filter)
    {
        $this
            ->table('data_alumni')
            ->select(
                '
            data_alumni.id,
            data_alumni.nama,
            data_alumni.email,
            data_alumni.nowa,
            data_alumni.notelp,
            data_alumni.alamat,
            data_alumni.prop_id,
            data_alumni.pengguna_id,
            data_alumni.jabatan,
            data_alumni.instansi,
            data_alumni.occupation_id,
            data_alumni.photo,

            akademik.jenjang,
            akademik.universitas,
            akademik.departemen,
            akademik.tmasuk,
            akademik.tlulus,
            propinsi.id AS propinsi_id,
            propinsi.nama AS propinsi,
            occupations.name AS occupation'
            )
            ->join('akademik', 'data_alumni.id = akademik.idorg', '')
            ->join('occupations', 'data_alumni.occupation_id = occupations.id', '')
            ->join('propinsi', 'data_alumni.prop_id = propinsi.id', '');


        // filter program sarjana
        $this->where('akademik.jenjang', 'S1');

        // filter admin angkatan
        if (session()->get('role') == 2 && session()->get('angkatan')) {
            $this->where('akademik.tmasuk', session()->get('angkatan'));
        }

        // filter Query 
        if (isset($filter['pengguna_id']) && !empty($filter['pengguna_id'])) {
            $this->where('data_alumni.pengguna_id', $filter['pengguna_id']);
        }

        if (isset($filter['q']) && !empty($filter['q'])) {
            $this->like('data_alumni.nama', $filter['q'], 'both');
        }

        if (isset($filter['tmasuk']) && !empty($filter['tmasuk'])) {
            $this->where('akademik.tmasuk', $filter['tmasuk']);
        }

        if (isset($filter['occupation']) && !empty($filter['occupation'])) {
            $this->where('occupations.id', $filter['occupation']);
        }

        if (isset($filter['province']) && !empty($filter['province'])) {
            $this->where('data_alumni.prop_id', $filter['province']);
        }

        if (isset($filter['prodi']) && !empty($filter['prodi'])) {
            $db = db_connect();
            $prodi = $db->table('prodi')->limit(1)->get()->getRowArray();
            $this->like('akademik.prodi', $prodi['nprodi'], 'both');
        }
        if (isset($filter['prodiAlt']) && !empty($filter['prodiAlt'])) {
            $this->like('akademik.prodi', $filter['prodiAlt'], 'both');
        }
        $this->groupBy('data_alumni.id');
        return $this;
    }


    public function getDetail($id)
    {
        $this
            ->table('data_alumni')
            ->select(
                '
            data_alumni.id,
            data_alumni.nama,
            data_alumni.email,
            data_alumni.nowa,
            data_alumni.notelp,
            data_alumni.alamat,
            data_alumni.jabatan,
            data_alumni.instansi,
            data_alumni.photo,

            propinsi.nama AS propinsi,
            occupations.name AS occupation'
            )
            ->join('occupations', 'data_alumni.occupation_id = occupations.id', 'left')
            ->join('propinsi', 'data_alumni.prop_id = propinsi.id', 'left')
            ->where('data_alumni.id', $id)
            ->limit(1);

        return $this;
    }
}
