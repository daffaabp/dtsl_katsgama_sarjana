<?php

namespace App\Controllers;

class Pengguna extends BaseController
{
    public function index()
    {
        $req = $this->request->getVar();
        $data['req'] = $req;

        $penggunaModel = new \App\Models\PenggunaModel();
        $angkatanModel = new \App\Models\AngkatanModel();
        $roleModel = new \App\Models\RoleModel();

        $data['pengguna'] = $penggunaModel->pengguna($req)->paginate(10);
        $data['pager'] = $penggunaModel->pengguna($req)->pager;
        $data['angkatan'] = $angkatanModel->filteredAngkatan()->findAll();
        $data['roles'] = $roleModel->filteredRoles()->findAll();
        return view('pengguna/index', $data);
    }

    public function add()
    {
        $angkatanModel = new \App\Models\AngkatanModel();
        $roleModel = new \App\Models\RoleModel();

        $data['angkatan'] = $angkatanModel->filteredAngkatan()->findAll();
        $data['roles'] = $roleModel->filteredRoles()->findAll();
        $data['validation'] = \Config\Services::validation();

        return view('pengguna/add', $data);
    }

    public function add_post()
    {
        $input = $this->validate([
            'nama' => [
                'rules' => 'required|max_length[200]',
                'errors' => [
                    'required' => 'Nama harus diisi',
                    'max_length' => 'Maksimal karakter 200',
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|max_length[200]|is_unique[pengguna.username]',
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Email tidak valid',
                    'is_unique' => 'Email sudah terdaftar',
                    'max_length' => 'Maksimal karakter 200',
                ]
            ],
            'role' => [
                'rules' => 'required|max_length[200]',
                'errors' => [
                    'required' => 'Role harus diisi',
                    'max_length' => 'Maksimal karakter 200',
                ]
            ],
            'active' => [
                'rules' => 'required|max_length[200]',
                'errors' => [
                    'required' => 'Status harus diisi',
                    'max_length' => 'Maksimal karakter 200',
                ]
            ],
            'angkatan' => [
                'rules' => 'required|max_length[200]',
                'errors' => [
                    'required' => 'Angkatan harus diisi',
                    'max_length' => 'Maksimal karakter 200',
                ]
            ],
            'password' => [
                'rules' => 'required|max_length[200]',
                'errors' => [
                    'required' => 'Password harus diisi',
                    'max_length' => 'Maksimal karakter 200',
                ]
            ],
        ]);
        if (!$input) {
            $validation = \Config\Services::validation();
            return redirect()->to(site_url() . 'pengguna/add/')->withInput()->with('validation', $validation);
        } else {
            $penggunaModel = new \App\Models\PenggunaModel();
            $data = [
                'nama' => $this->request->getVar('nama'),
                'username' => $this->request->getVar('email'),
                'role' => $this->request->getVar('role'),
                'active' => $this->request->getVar('active'),
                'angkatan' => $this->request->getVar('angkatan'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
            ];
            $idx = $penggunaModel->insert($data);
            return redirect()->to(site_url() . 'pengguna')->with('success', 'Data berhasil ditambahkan');
        }
    }

    public function edit($id)
    {
        $angkatanModel = new \App\Models\AngkatanModel();
        $roleModel = new \App\Models\RoleModel();
        $penggunaModel = new \App\Models\PenggunaModel();
        
        $data['id'] = $id;
        $data['pengguna'] = $penggunaModel->find($id);
        $data['angkatan'] = $angkatanModel->filteredAngkatan()->findAll();
        $data['roles'] = $roleModel->filteredRoles()->findAll();
        $data['validation'] = \Config\Services::validation();

        return view('pengguna/edit', $data);
    }

    public function edit_post($id)
    {
        $input = $this->validate([
            'nama' => [
                'rules' => 'required|max_length[200]',
                'errors' => [
                    'required' => 'Nama harus diisi',
                    'max_length' => 'Maksimal karakter 200',
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|max_length[200]|is_unique[pengguna.username,id,{id}]',
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Email tidak valid',
                    'is_unique' => 'Email sudah terdaftar',
                    'max_length' => 'Maksimal karakter 200',
                ]
            ],
            'role' => [
                'rules' => 'required|max_length[200]',
                'errors' => [
                    'required' => 'Role harus diisi',
                    'max_length' => 'Maksimal karakter 200',
                ]
            ],
            'active' => [
                'rules' => 'required|max_length[200]',
                'errors' => [
                    'required' => 'Status harus diisi',
                    'max_length' => 'Maksimal karakter 200',
                ]
            ],
            'angkatan' => [
                'rules' => 'required|max_length[200]',
                'errors' => [
                    'required' => 'Angkatan harus diisi',
                    'max_length' => 'Maksimal karakter 200',
                ]
            ],
        ]);

        if (!$input) {
            $validation = \Config\Services::validation();
            return redirect()->to(site_url() . 'pengguna/edit/' . $id)->withInput()
                ->with('validation', $validation)
                ->with('error', 'Periksa data kembali');
        } else {
            $penggunaModel = new \App\Models\PenggunaModel();
            $data = [
                'nama' => $this->request->getVar('nama'),
                'username' => $this->request->getVar('email'),
                'role' => $this->request->getVar('role'),
                'active' => intval($this->request->getVar('active')),
                'angkatan' => $this->request->getVar('angkatan'),
            ];
            $idx = $penggunaModel->update($id, $data);
            if ($this->request->getVar('password')) {
                $password = $this->request->getVar('password');
                $set = [
                    'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
                ];
                $penggunaModel->where('id', $id)->set($set)->update();
            }
            return redirect()->to(site_url() . 'pengguna/edit/' . $id)->with('success', 'Data berhasil diubah');
        }
    }

    public function delete($id)
    {
        $penggunaModel = new \App\Models\PenggunaModel();
        $alumniModel = new \App\Models\AlumniModel();

        $penggunaModel->delete($id);
        $alumniModel->where('pengguna_id', $id)->set('pengguna_id', $id)->update();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
