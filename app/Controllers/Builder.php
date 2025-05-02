<?php

namespace App\Controllers;

class Builder extends BaseController
{

    public function reset_password()
    {
        $penggunaModel = new \App\Models\PenggunaModel();
        $username = 'admin@admin.com';
        $password = 'juragan1719';

        $set = [
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];
        $idx = $penggunaModel->where('username', $username)->set($set)->update();
        dd($idx);
    }

    public function mapping_user_propinsi()
    {
        $db = db_connect();
        $alumni = $db->table('data_alumni')
            ->select('
                data_alumni.id,
                data_alumni.nama,
                data_alumni.region_id,
                regions.province,
            ')
            // ->limit(1000)
            ->join('regions', 'regions.id = data_alumni.region_id')
            ->get()
            ->getResultArray();


        foreach ($alumni as $al) {
            $prop_id = $db->table('propinsi')->where('prop_code', $al['province'])->limit(1)->get()->getRow()->id;
            $db->table('data_alumni')
                ->set('prop_id', $prop_id)
                ->where('id', $al['id'])
                ->update();

            echo $al['region_id'] . '' . $al['nama'] . ' ' . $al['province'] . '<br/>';
        }
    }
    public function create_propinsi()
    {
        $db = db_connect();
        $builder = $db->table('regions');
        $query = $builder
            ->like('regions.code', '.000', 'right')
            ->get();

        $prop = $db->table('propinsi');

        $i = 0;
        $regions = $query->getResultArray();
        foreach ($regions as $r) {
            $i++;
            echo  $i . '. ' . $r['name'] . ' ' . $r['code'] . '<br/>';

            $dt = [
                "nama" => $r['name'],
                "prop_code" => $r['province'],
            ];
            $prop->insert($dt);
        }
    }
}
