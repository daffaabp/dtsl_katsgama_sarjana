<?php

namespace App\Controllers;


class Prodi extends BaseController
{

    public function index()
    {
        $req = $this->request->getVar();
        $data['req'] = $req;

        $prodiModel = new \App\Models\ProdiModel();
        $data['prodi'] = $prodiModel->prodi($req)->paginate(10);
        $data['pager'] = $prodiModel->pager;
        return view('prodi/index', $data);
    }

    public function add_post()
    {
        $input = $this->validate([
            'nprodi' => [
                'rules' => 'required|max_length[200]|is_unique[prodi.nprodi]',
                'errors' => [
                    'required' => 'Prodi harus diisi',
                    'max_length' => 'Maksimal karakter 200',
                    'is_unique' => 'Prodi sudah terdaftar',
                ]
            ]

        ]);
        if (!$input) {
            $validation = \Config\Services::validation();
            $data = [
                'error' => $validation->getError('nprodi')
            ];
            return $this->response->setJSON($data);
        } else {
            $prodiModel = new \App\Models\ProdiModel();
            $data = [
                'nprodi' => $this->request->getVar('nprodi')
            ];
            $prodiModel->insert($data);
            return $this->response->setJSON($data);
        }
    }

    public function edit($id)
    {
        $prodiModel = new \App\Models\ProdiModel();
        $data = $prodiModel->find($id);
        return $this->response->setJSON($data);
    }

    public function edit_post($id)
    {
        $input = $this->validate([
            'nprodi' => [
                'rules' => 'required|max_length[200]|is_unique[prodi.nprodi],id,{id}',
                'errors' => [
                    'required' => 'Prodi harus diisi',
                    'max_length' => 'Maksimal karakter 200',
                    'is_unique' => 'Prodi sudah terdaftar',
                ]
            ]

        ]);
        if (!$input) {
            $validation = \Config\Services::validation();
            $data = [
                'error' => $validation->getError('nprodi')
            ];
            return $this->response->setJSON($data);
        } else {
            $prodiModel = new \App\Models\ProdiModel();
            $data = [
                'nprodi' => $this->request->getVar('nprodi')
            ];
            $update_id = $prodiModel->update($id, $data);
            return $this->response->setJSON($update_id);
        }
    }

    public function delete($id)
    {
        $prodiModel = new \App\Models\ProdiModel();
        $prodiModel->delete($id);
    }
}
