<?php

namespace App\Controllers;

class User extends BaseController
{
    public function profile()
    {
        $id = session()->get('alumniId');

        $alumniModel = new \App\Models\AlumniModel();
        $akademikModel = new \App\Models\AkademikModel();

        $data['alumni'] = $alumniModel->find($id);
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
        $data['angkatan'] = $angkatanModel->angkatan()->findAll();
        $data['validation'] = \Config\Services::validation();

        return view('user/profile', $data);
    }

    
    public function profile_post()
    {
        $id = session()->get('alumniId');
        $input = $this->validate([
            'nama' => 'required|max_length[200]',
            'email' => 'required|valid_email|max_length[200]',
            'nowa' => 'required|max_length[200]',
            's1_universitas' => 'required|max_length[200]',
            's1_tmasuk' => 'required|max_length[200]',
            's1_tlulus' => 'required|max_length[200]',
            's1_prodi' => 'required|max_length[200]',
        ]);
        if (!$input) {
            $validation = \Config\Services::validation();
            return redirect()->to(site_url() . 'profile')->withInput()->with('validation', $validation);
        } else {
            $alumniModel = new \App\Models\AlumniModel();
            $data = [
                'nama' => $this->request->getVar('nama'),
                'email' => $this->request->getVar('email'),
                'notelp' => $this->request->getVar('notelp'),
                'nowa' => $this->request->getVar('nowa'),
                'alamat' => $this->request->getVar('alamat'),
                'prop_id' => intval($this->request->getVar('propinsi')),
                'instansi' => $this->request->getVar('instansi'),
                'jabatan' => $this->request->getVar('jabatan'),
                'occupation_id' => intval($this->request->getVar('bidang_kerja')),
            ];
            $update = $alumniModel->update($id, $data);
            if ($update) {
                $akademikModel = new \App\Models\AkademikModel();
                $s1 = [
                    'idorg' => $id,
                    'jenjang' => 'S1',
                    'universitas' => $this->request->getVar('s1_universitas'),
                    'tmasuk' => $this->request->getVar('s1_tmasuk'),
                    'tlulus' => $this->request->getVar('s1_tlulus'),
                    'prodi' => $this->request->getVar('s1_prodi'),
                ];
                $akademikModel->where('jenjang', 'S1')->where('idorg', $id)->delete();
                $akademikModel->insert($s1);

                $s2 = [
                    'idorg' => $id,
                    'jenjang' => 'S2',
                    'universitas' => $this->request->getVar('s2_universitas'),
                    'tmasuk' => $this->request->getVar('s2_tmasuk'),
                    'tlulus' => $this->request->getVar('s2_tlulus'),
                    'prodi' => $this->request->getVar('s2_prodi'),
                ];
                $akademikModel->where('jenjang', 'S2')->where('idorg', $id)->delete();
                $akademikModel->insert($s2);

                $s3 = [
                    'idorg' => $id,
                    'jenjang' => 'S3',
                    'universitas' => $this->request->getVar('s3_universitas'),
                    'tmasuk' => $this->request->getVar('s3_tmasuk'),
                    'tlulus' => $this->request->getVar('s3_tlulus'),
                    'prodi' => $this->request->getVar('s3_prodi'),
                ];
                $akademikModel->where('jenjang', 'S3')->where('idorg', $id)->delete();
                $akademikModel->insert($s3);
            }
            return redirect()->to(site_url() . 'profile')->with('success', 'Data berhasil diubah');
        }
    }
}
