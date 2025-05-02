<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function login_post()
    {
        $input = $this->validate([
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Email tidak valid',
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Email harus diisi',
                ]
            ],
        ]);
        
     
        if (!$input) {
            $validation = \Config\Services::validation();
            return redirect()->to(site_url() . 'login')->withInput()->with('validation', $validation);
        } else {

            $penggunaModel = new \App\Models\PenggunaModel();
            $alumniModel = new \App\Models\AlumniModel();
            $roleModel = new \App\Models\RoleModel();

            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');
            $user = $penggunaModel->where('username', $email)->first();

            if (!$user) {
                return redirect()->to('login')->with('error', 'Email belum terdaftar');
            } else {

                $db_pass = $user['password'];
                $authenticatePassword = password_verify($password, $db_pass);
                if ($authenticatePassword) {

                    if ($user['active'] != 1) {
                        return redirect()->to('login')->with('error', 'Akun akan anda bekum aktif, , silahkan hubungi admin');
                    }
                    if (!$user['angkatan']) {
                        return redirect()->to('login')->with('error', 'Data angkatan belum disetting, silahkan hubungi admin');
                    }

                    $role = $roleModel->find($user['role']);
                    $ses_data = [
                        'isLoggedIn' => true,
                        'id' => $user['id'],
                        'role' => $user['role'],
                        'role_name' => $role['role'],
                        'angkatan' => $user['angkatan'],
                        'username' => $user['username'],
                        'nama' => $user['nama'],
                    ];

                    $dataAlumni = $alumniModel->select('pengguna_id,id')->where('pengguna_id', $user['id'])->first();
                    if ($dataAlumni) {
                        $ses_data['isMapped'] = true;
                        $ses_data['alumniId'] = $dataAlumni['id'];
                    }

                    session()->set($ses_data);
                    return redirect()->to(site_url() . 'alumni');
                } else {
                    return redirect()->to('login')->with('error', 'Password salah');
                }
            }
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(site_url() . 'login');
    }

    public function forgot_password()
    {
        return view('auth/forgot_password');
    }

    public function forgot_password_post()
    {
        $req = $this->request->getVar();
        $penggunaModel = new \App\Models\PenggunaModel();

        $user = $penggunaModel->where('username', $req['username'])->first();
        if (!$user) {
            return redirect()->to('forgot')->with('error', 'Username tidak terdaftar');
        }

        $new_password = random_string('sha1');
        $penggunaModel->where('username', $req['username'])
            ->set('password', password_hash($new_password, PASSWORD_DEFAULT))
            ->update();

        $send = $this->password_mailer($user['username'], $new_password);
        if ($send) {
            return redirect()->to(site_url() . '?ps=' . random_string('sha1'))->with('success', 'Password sementara telah dikirim ke email anda, silahkan lakukan pergantian password');
        }
    }

    public function password_mailer($to, $new_password)
    {
        $subject = 'Password Recovery';

        $message = 'Password : ' . $new_password;
        $message .= "\r\n";
        $message .= "Silahkan lakukan pergantian password untuk keamanan akun anda";
        $message .= "\r\n";
        $message .= "\r\n";
        $message .= "Gunakan Link dibawah ini untuk login";
        $message .= "\r\n";
        $message .= site_url() . "login";


        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setFrom('humariaitsolutions@gmail.com', 'Katsgama App');

        $email->setSubject($subject);
        $email->setMessage($message);
        if ($email->send()) {
            return true;
        } else {
            return false;
            // $data = $email->printDebugger(['headers']);
            // print_r($data);
        }
    }
}
