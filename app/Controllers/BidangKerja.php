<?php

namespace App\Controllers;

class BidangKerja extends BaseController
{
    public function index()
    {
        $req = $this->request->getVar();
        $data['req'] = $req;

        $bidangKerjaModel = new \App\Models\BidangKerjaModel();
        $data['bidangKerja'] = $bidangKerjaModel->bidangKerja($req)->paginate(10);
        $data['pager'] = $bidangKerjaModel->pager;

        return view('bidang_kerja/index', $data);
    }

    public function add_post()
    {
        $input = $this->validate([
            'name' => [
                'rules' => 'required|max_length[200]|is_unique[occupations.name]',
                'errors' => [
                    'required' => 'Bidang Kerja harus diisi',
                    'max_length' => 'Maksimal karakter 200',
                    'is_unique' => 'Bidang Kerja sudah terdaftar',
                ]
            ]

        ]);
        if (!$input) {
            $validation = \Config\Services::validation();
            $data = [
                'error' => $validation->getError('name')
            ];
            return $this->response->setJSON($data);
        } else {
            $bidangKerjaModel = new \App\Models\BidangKerjaModel();
            $data = [
                'name' => $this->request->getVar('name')
            ];
            $bidangKerjaModel->insert($data);
            return $this->response->setJSON($data);
        }
    }

    public function edit($id)
    {
        $bidangKerjaModel = new \App\Models\BidangKerjaModel();
        $data = $bidangKerjaModel->find($id);
        return $this->response->setJSON($data);
    }

    public function edit_post($id)
    {
        $input = $this->validate([
            'name' => [
                'rules' => 'required|max_length[200]|is_unique[occupations.name, id, {id}]',
                'errors' => [
                    'required' => 'Bidang Kerja harus diisi',
                    'max_length' => 'Maksimal karakter 200',
                    'is_unique' => 'Bidang Kerja sudah terdaftar',
                ]
            ]

        ]);
        if (!$input) {
            $validation = \Config\Services::validation();
            $data = [
                'error' => $validation->getError('name')
            ];
            return $this->response->setJSON($data);
        } else {
            $bidangKerjaModel = new \App\Models\BidangKerjaModel();
            $data = [
                'name' => $this->request->getVar('name')
            ];
            $update_id = $bidangKerjaModel->update($id, $data);
            return $this->response->setJSON($update_id);
        }
    }

    public function delete($id)
    {
        $bidangKerjaModel = new \App\Models\BidangKerjaModel();
        $bidangKerjaModel->delete($id);
    }
}
