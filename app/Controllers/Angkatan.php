<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class Angkatan extends BaseController
{
    public function index()
    {
        $req = $this->request->getVar();
        $data['req'] = $req;

        $angkatanModel = new \App\Models\AngkatanModel();
        $data['angkatan'] = $angkatanModel->angkatan($req)->paginate(10);
        $data['pager'] = $angkatanModel->pager;

        return view('angkatan/index', $data);
    }

    public function add_post()
    {
        $input = $this->validate([
            'tahun' => [
                'rules' => 'required|max_length[4]|is_unique[angkatan.tahun]',
                'errors' => [
                    'required' => 'Tahun harus diisi',
                    'max_length' => 'Maksimal karakter 4',
                    'is_unique' => 'Tahun sudah terdaftar',
                ]
            ]

        ]);
        if (!$input) {
            $validation = \Config\Services::validation();
            $data = [
                'error' => $validation->getError('tahun')
            ];
            return $this->response->setJSON($data);
        } else {
            $angkatanModel = new \App\Models\AngkatanModel();
            $data = [
                'tahun' => $this->request->getVar('tahun')
            ];
            $angkatanModel->insert($data);
            return $this->response->setJSON($data);
        }
    }

    public function edit($id)
    {
        $angkatanModel = new \App\Models\AngkatanModel();
        $data = $angkatanModel->find($id);
        return $this->response->setJSON($data);
    }

    public function edit_post($id)
    {
        $input = $this->validate([
            'tahun' => [
                'rules' => 'required|max_length[4]|is_unique[angkatan.tahun,id,{id}]',
                'errors' => [
                    'required' => 'Tahun harus diisi',
                    'max_length' => 'Maksimal karakter 4',
                    'is_unique' => 'Tahun sudah terdaftar',
                ]
            ]

        ]);
        if (!$input) {
            $validation = \Config\Services::validation();
            $data = [
                'error' => $validation->getError('tahun')
            ];
            return $this->response->setJSON($data);
        } else {
            $angkatanModel = new \App\Models\AngkatanModel();
            $data = [
                'tahun' => $this->request->getVar('tahun')
            ];
            $update_id = $angkatanModel->update($id, $data);
            return $this->response->setJSON($update_id);
        }
    }

    public function delete($id)
    {
        $angkatanModel = new \App\Models\AngkatanModel();
        $angkatanModel->delete($id);
    }
}
