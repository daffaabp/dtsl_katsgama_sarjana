<?php

namespace App\Controllers;

class Alumni extends BaseController
{
    public function index()
    {
        $req = $this->request->getVar();
        $alumniModel = new \App\Models\AlumniModel();
        $propinsiModel = new \App\Models\PropinsiModel();
        $occupationModel = new \App\Models\OccupationModel();
        $akademikModel = new \App\Models\AkademikModel();
        $angkatanModel = new \App\Models\AngkatanModel();
        $prodiModel = new \App\Models\ProdiModel();

        $data['request'] = $req;
        $data_alumni = $alumniModel->data_alumni($req)->paginate(10);

        $i = 0;
        foreach ($data_alumni as $dtal) {
            $data_alumni[$i]['riwayat_akademik'] = $akademikModel->where('akademik.idorg', $data_alumni[$i]['id'])->findAll();
            $i++;
        }
        $data['alumni'] = $data_alumni;
        $data['pager'] = $alumniModel->pager;
        $data['provinces'] = $propinsiModel->findAll();
        $data['prodi'] = $prodiModel->findAll();
        $data['occupations'] = $occupationModel->findAll();
        $data['jenjang'] = $akademikModel->select('jenjang')->distinct()->findAll();
        $data['universitas'] = $akademikModel->select('universitas')->distinct()->findAll();
        $data['departemen'] = $akademikModel->select('departemen')->distinct()->findAll();
        $data['angkatan'] = $angkatanModel->findAll();


        $data['req'] = $req;
        return view('alumni/index', $data);
    }

   
    public function detail($id)
    {
        $alumniModel = new \App\Models\AlumniModel();
        $akademikModel = new \App\Models\AkademikModel();

        $data['alumni'] = $alumniModel->getDetail($id)->get()->getRowArray();
        $data['S1'] = $akademikModel->where('idOrg', $id)->where('jenjang', 'S1')->limit(1)->get()->getRowArray();
        $data['S2'] = $akademikModel->where('idOrg', $id)->where('jenjang', 'S2')->limit(1)->get()->getRowArray();
        $data['S3'] = $akademikModel->where('idOrg', $id)->where('jenjang', 'S3')->limit(1)->get()->getRowArray();

        $occupationModel = new \App\Models\OccupationModel();
        $propinsiModel = new \App\Models\PropinsiModel();
        $prodiModel = new \App\Models\ProdiModel();
        $angkatanModel = new \App\Models\AngkatanModel();

        $data['occupations'] = $occupationModel->findAll();
        $data['propinsi'] = $propinsiModel->findAll();
        $data['prodi'] = $prodiModel->findAll();
        $data['angkatan'] = $angkatanModel->findAll();
        $data['validation'] = \Config\Services::validation();

        return view('alumni/detail', $data);
    }

    public function info($id)
    {
        $alumniModel = new \App\Models\AlumniModel();
        $akademikModel = new \App\Models\AkademikModel();

        $data['alumni'] = $alumniModel->getDetail($id)->first();
        $data['S1'] = $akademikModel->where('idorg', $id)->where('jenjang', 'S1')->limit(1)->get()->getRowArray();
        $data['S2'] = $akademikModel->where('idorg', $id)->where('jenjang', 'S2')->limit(1)->get()->getRowArray();
        $data['S3'] = $akademikModel->where('idorg', $id)->where('jenjang', 'S3')->limit(1)->get()->getRowArray();
        
        // dd($data);

       return $this->response->setJSON($data);

       
    }

}
