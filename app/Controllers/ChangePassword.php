<?php

namespace App\Controllers;

class ChangePassword extends BaseController
{
    public function index()
    {
        $id = session()->get('id');
        $data['validation'] = \Config\Services::validation();
        return view('change_password/index', $data);
    }

    public function edit_post()
    {


        $input = $this->validate([
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password harus diisi',
                ]
            ],
        ]);
        if (!$input) {
            $validation = \Config\Services::validation();
            return redirect()->to(site_url() . 'change_password')->withInput()->with('validation', $validation);
        } else {
            $penggunaModel = new \App\Models\PenggunaModel();
            $id = session()->get('id');
            $user = $penggunaModel->where(['id' => intval($id)])->first();
            if (!$user) {
                return redirect()->to(site_url() . 'change_password')->withInput()->with('error', 'Terjadi kesalahan');
            } else {
                $pass = $user['password'];
                $password = $this->request->getVar('password');
                $new_password = $this->request->getVar('new_password');
                $authenticatePassword = password_verify($password, $pass);
                if ($authenticatePassword) {
                    $set = [
                        'password' => password_hash($new_password, PASSWORD_DEFAULT)
                    ];
                    $idx = $penggunaModel->where('id', $id)->set($set)->update();
                    if ($idx) {
                        session()->destroy();
                        return redirect()->to(site_url() . 'login/?p=' . random_string('sha1'))->withInput()->with('success', 'Password berhasil diganti, silahkan login kembali');
                    } else {
                        return redirect()->to(site_url() . 'change_password')->withInput()->with('error', 'Terjadi kesalahan');
                    }
                } else {
                    return redirect()->to(site_url() . 'change_password')->withInput()->with('error', 'Password salah');
                }
            }
        }
    }
}
