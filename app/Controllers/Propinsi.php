<?php

namespace App\Controllers;

class Propinsi extends BaseController
{
    public function index()
    {
        $req = $this->request->getVar();
        $data['req'] = $req;

        $propinsiModel = new \App\Models\PropinsiModel();
        $data['propinsi'] = $propinsiModel->propinsi($req)->paginate(10);
        $data['pager'] = $propinsiModel->pager;

        return view('propinsi/index', $data);
    }

    public function add_post()
    {
        $input = $this->validate([
            'nama' => [
                'rules' => 'required|max_length[200]|is_unique[propinsi.nama]',
                'errors' => [
                    'required' => 'Propinsi harus diisi',
                    'max_length' => 'Maksimal karakter 200',
                    'is_unique' => 'Propinsi sudah terdaftar',
                ]
            ]

        ]);
        if (!$input) {
            $validation = \Config\Services::validation();
            $data = [
                'error' => $validation->getError('nama')
            ];
            return $this->response->setJSON($data);
        } else {
            $propinsiModel = new \App\Models\PropinsiModel();
            $data = [
                'nama' => $this->request->getVar('nama')
            ];
            $propinsiModel->insert($data);
            return $this->response->setJSON($data);
        }
    }

    public function edit($id)
    {
        $propinsiModel = new \App\Models\PropinsiModel();
        $data = $propinsiModel->find($id);
        return $this->response->setJSON($data);
    }

    public function edit_post($id)
    {
        $input = $this->validate([
            'nama' => [
                'rules' => 'required|max_length[200]|is_unique[propinsi.nama,id,{id}]',
                'errors' => [
                    'required' => 'Propinsi harus diisi',
                    'max_length' => 'Maksimal karakter 200',
                    'is_unique' => 'Propinsi sudah terdaftar',
                ]
            ]

        ]);
        if (!$input) {
            $validation = \Config\Services::validation();
            $data = [
                'error' => $validation->getError('nama')
            ];
            return $this->response->setJSON($data);
        } else {
            $propinsiModel = new \App\Models\PropinsiModel();
            $data = [
                'nama' => $this->request->getVar('nama')
            ];
            $update_id = $propinsiModel->update($id, $data);
            return $this->response->setJSON($update_id);
        }
    }

    public function delete($id)
    {
        $propinsiModel = new \App\Models\PropinsiModel();
        $propinsiModel->delete($id);
    }
}
