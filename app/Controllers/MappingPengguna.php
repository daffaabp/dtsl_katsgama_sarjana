<?php

namespace App\Controllers;

class MappingPengguna extends BaseController
{
    public function pengguna($id)
    {
        $req = $this->request->getVar();


        $penggunaModel = new \App\Models\PenggunaModel();
        $data['pengguna'] = $penggunaModel->find($id);

        $alumniModel = new \App\Models\AlumniModel();
        $propinsiModel = new \App\Models\PropinsiModel();
        $prodiModel = new \App\Models\ProdiModel();
        $occupationModel = new \App\Models\OccupationModel();
        $akademikModel = new \App\Models\AkademikModel();
        $angkatanModel = new \App\Models\AngkatanModel();

        $data['request'] = $req;

        $data['pengguna_id'] = $id;

        $data['isMapped'] = false;
        $isMapped = $alumniModel->where('pengguna_id', $id)->limit(1)->get();
        if ($isMapped->getNumRows()) {
            $req['pengguna_id'] = $id;
            $data['isMapped'] = true;
        }
        $data_alumni = $alumniModel->mapping_pengguna($req)->paginate(10);

        $i = 0;
        foreach ($data_alumni as $dtal) {
            $data_alumni[$i]['riwayat_akademik'] = $akademikModel->where('akademik.idorg', $data_alumni[$i]['id'])->findAll();
            $i++;
        }
        $data['alumni'] = $data_alumni;
        $data['pager'] = $alumniModel->pager;
        $data['provinces'] = $propinsiModel->findAll();
        $data['occupations'] = $occupationModel->findAll();
        $data['jenjang'] = $akademikModel->select('jenjang')->distinct()->findAll();
        $data['universitas'] = $akademikModel->select('universitas')->distinct()->findAll();
        $data['departemen'] = $akademikModel->select('departemen')->distinct()->findAll();
        $data['prodi'] = $prodiModel->findAll();
        $data['filteredAngkatan'] = $angkatanModel->filteredAngkatan()->findAll();

        $data['validation'] = \Config\Services::validation();
        $data['req'] = $req;
        return view('mapping_pengguna/index', $data);
    }

    public function delete_mapping()
    {
        $req = $this->request->getVar();
        $alumniModel = new \App\Models\AlumniModel();
        $alumniModel
            ->where(['pengguna_id' => intval($req['pengguna_id'])])
            ->set('pengguna_id', 0)
            ->update();
        return redirect()->to(site_url() . 'pengguna/mapping/' . $req['pengguna_id'])->with('success', 'Mapping berhasil dihapus');
    }

    public function add_mapping()
    {
        $req = $this->request->getVar();
        $alumniModel = new \App\Models\AlumniModel();
        $alumniModel
            ->where(['pengguna_id' => intval($req['pengguna_id'])])
            ->set('pengguna_id', 0)
            ->update();
        $alumniModel
            ->where(['data_alumni.id' => intval($req['alumni_id'])])
            ->set('pengguna_id', intval($req['pengguna_id']))
            ->update();
        return redirect()->to(site_url() . 'pengguna/mapping/' . $req['pengguna_id'])->with('success', 'Mapping berhasil ditambahkan');
    }
}
