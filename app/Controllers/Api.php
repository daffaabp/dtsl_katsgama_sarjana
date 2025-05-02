<?php

namespace App\Controllers;

class Api extends BaseController
{

    public function getAlumni()
    {
        $req = $this->request->getVar();
        $alumniModel = new \App\Models\AlumniModel();

        $data_alumni = $alumniModel->data_alumni($req)->paginate(10);
        $data['alumni'] = $data_alumni;
        $data['pager'] = $alumniModel->pager->getDetails();
        $data['req'] = $req;

        return $this->response->setStatusCode(200)->setJSON($data);
    }

    public function getAlumniById($id)
    {
        $alumniModel = new \App\Models\AlumniModel();
        $akademikModel = new \App\Models\AkademikModel();

        $data['alumni'] = $alumniModel->getDetail($id)->get()->getRowArray();
        $data['S1'] = $akademikModel->where('idOrg', $id)->where('jenjang', 'S1')->limit(1)->get()->getRowArray();
        $data['S2'] = $akademikModel->where('idOrg', $id)->where('jenjang', 'S2')->limit(1)->get()->getRowArray();
        $data['S3'] = $akademikModel->where('idOrg', $id)->where('jenjang', 'S3')->limit(1)->get()->getRowArray();

        return $this->response->setStatusCode(200)->setJSON($data);
    }

    public function getAlumniByUserId($userId)
    {
        $alumniModel = new \App\Models\AlumniModel();
        $akademikModel = new \App\Models\AkademikModel();

        $alumniQuery = $alumniModel->where('pengguna_id', $userId)->first();
        $alumniId = $alumniQuery['id'];

        $data['alumni'] = $alumniModel->find($alumniId);
        $data['S1'] = $akademikModel->where('idOrg',  $alumniId)->where('jenjang', 'S1')->limit(1)->get()->getRowArray();
        $data['S2'] = $akademikModel->where('idOrg',  $alumniId)->where('jenjang', 'S2')->limit(1)->get()->getRowArray();
        $data['S3'] = $akademikModel->where('idOrg',  $alumniId)->where('jenjang', 'S3')->limit(1)->get()->getRowArray();

        return $this->response->setStatusCode(200)->setJSON($data);
    }

     
    public function editProfile($userId)
    {
        $alumniModel = new \App\Models\AlumniModel();
        $alumniQuery = $alumniModel->where('pengguna_id', $userId)->first();
        if(!$alumniQuery){
            $data = [
                'success' => false,
                'errCode' => 'USER_ERROR',
                'error' => 'User tidak terdaftar',
            ];
            return $this->response->setStatusCode(200)->setJSON($data);
        }
        $id = $alumniQuery['id'];

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
            $error = $validation->getErrors();
            $data = [
                'success' => false,
                'errCode' => 'VALIDATION_ERROR',
                'error' => $error,
            ];
            return $this->response->setStatusCode(200)->setJSON($data);
        } else {
            $alumniModel = new \App\Models\AlumniModel();
            $data = [
                'nama' => $this->request->getVar('nama'),
                'email' => $this->request->getVar('email'),
                'notelp' => $this->request->getVar('notelp'),
                'nowa' => $this->request->getVar('nowa'),
                'alamat' => $this->request->getVar('alamat'),
                'prop_id' => intval($this->request->getVar('prop_id')),
                'instansi' => $this->request->getVar('instansi'),
                'jabatan' => $this->request->getVar('jabatan'),
                'occupation_id' => intval($this->request->getVar('occupation_id')),
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
            $data = [
                'success' => true,
            ];
            return $this->response->setStatusCode(200)->setJSON($data);
        }
        $data = [
            'success' => false,
            'error' => 'System Error',
        ];
        return $this->response->setStatusCode(200)->setJSON($data);
    }

    public function getFilters()
    {
        $propinsiModel = new \App\Models\PropinsiModel();
        $occupationModel = new \App\Models\OccupationModel();
        $angkatanModel = new \App\Models\AngkatanModel();
        $prodiModel = new \App\Models\ProdiModel();


        $provincesQuery = $propinsiModel->findAll();
        $provinces = [];
        $provinces[0] = [
            "label" => 'Semua Propinsi',
            'value' => null,
        ];
        $i = 1;
        foreach ($provincesQuery as $p) {
            $provinces[$i]['label'] = $p['nama'];
            $provinces[$i]['value'] = $p['id'];
            $i++;
        }
        $data['provinces'] = $provinces;


        $prodiQuery = $prodiModel->findAll();
        $prodis = [];
        $prodis[0] = [
            "label" => 'Semua Prodi',
            'value' => null,
        ];
        $i = 1;
        foreach ($prodiQuery as $p) {
            $prodis[$i]['label'] = $p['nprodi'];
            $prodis[$i]['value'] = $p['nprodi'];
            $i++;
        }
        $data['prodis'] = $prodis;


        $angkatanQuery = $angkatanModel->orderBy('tahun', 'desc')->findAll();
        $angkatan = [];
        $angkatan[0] = [
            "label" => 'Semua Angkatan',
            'value' => null,
        ];
        $i = 1;
        foreach ($angkatanQuery as $p) {
            $angkatan[$i]['label'] = $p['tahun'];
            $angkatan[$i]['value'] = $p['tahun'];
            $i++;
        }
        $data['angkatan'] = $angkatan;


        $occupationsQuery = $occupationModel->findAll();
        $occupations = [];
        $occupations[0] = [
            "label" => 'Semua Bidang Kerja',
            'value' => null,
        ];
        $i = 1;
        foreach ($occupationsQuery as $p) {
            $occupations[$i]['label'] = $p['name'];
            $occupations[$i]['value'] = $p['id'];
            $i++;
        }
        $data['occupations'] = $occupations;


        return $this->response
            ->setStatusCode(200)
            ->setJSON($data);
    }


    public function signin()
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
            $data = [
                'success' => false,
                'error' => 'Email atau password tidak valid'
            ];
            return $this->response->setStatusCode(200)->setJSON($data);
        } else {

            $penggunaModel = new \App\Models\PenggunaModel();
            $alumniModel = new \App\Models\AlumniModel();
            $roleModel = new \App\Models\RoleModel();

            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');
            $user = $penggunaModel->where('username', $email)->first();

            if (!$user) {
                $data = [
                    'success' => false,
                    'error' => 'Email belum terdaftar'
                ];
                return $this->response
                    ->setStatusCode(200)
                    ->setJSON($data);
            } else {

                $db_pass = $user['password'];
                $authenticatePassword = password_verify($password, $db_pass);
                if ($authenticatePassword) {

                    if ($user['active'] != 1) {
                        $data = [
                            'success' => false,
                            'error' => 'Status user belum aktif'
                        ];
                        return $this->response
                            ->setStatusCode(200)
                            ->setJSON($data);
                    }
                    if (!$user['angkatan']) {
                        $data = [
                            'success' => false,
                            'error' => 'Data angkatan belum disetting, silahkan hubungi admin'
                        ];
                        return $this->response
                            ->setStatusCode(200)
                            ->setJSON($data);
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
                    $data = [
                        'success' => true,
                        'data' => [
                            'token' => 'tokensnsns',
                            'id' => $user['id'],
                            'role' => $user['role'],
                            'role_name' => $role['role'],
                            'angkatan' => $user['angkatan'],
                            'username' => $user['username'],
                            'nama' => $user['nama'],
                        ]
                    ];
                    return $this->response
                        ->setStatusCode(200)
                        ->setJSON($data);
                } else {
                    $data = [
                        'success' => false,
                        'error' => 'Pasword salah, silahkan periksa kembali'
                    ];
                    return $this->response
                        ->setStatusCode(200)
                        ->setJSON($data);
                }
            }
        }
    }


    public function changePassword()
    {
        $input = $this->validate([
            'password' => [
                'rules' => 'required',
            ],
            'newPassword' => [
                'rules' => 'required',
            ],
            'userId' => [
                'rules' => 'required',
            ],
        ]);
        if (!$input) {
            // $validation = \Config\Services::validation();
            $data = [
                'success' => false,
                'error' => 'Data tidak valid'
            ];
            return $this->response->setStatusCode(200)->setJSON($data);
        } else {
            $penggunaModel = new \App\Models\PenggunaModel();
            $id = $this->request->getVar('userId');
            $user = $penggunaModel->where(['id' => intval($id)])->first();

            if (!$user) {
                $data = [
                    'success' => false,
                    'error' => 'Data ID tidak valid'
                ];
                return $this->response->setStatusCode(200)->setJSON($data);
            } else {
                $pass = $user['password'];
                $password = $this->request->getVar('password');
                $new_password = $this->request->getVar('newPassword');
                $authenticatePassword = password_verify($password, $pass);
                if ($authenticatePassword) {
                    $set = [
                        'password' => password_hash($new_password, PASSWORD_DEFAULT)
                    ];
                    $idx = $penggunaModel->where('id', $id)->set($set)->update();
                    $idx = true;
                    if ($idx) {
                        $data = [
                            'success' => true,
                        ];
                        return $this->response->setStatusCode(200)->setJSON($data);
                    } else {
                        $data = [
                            'success' => false,
                            'error' => 'Terjadi kesalahan pada system'
                        ];
                        return $this->response->setStatusCode(200)->setJSON($data);
                    }
                } else {
                    $data = [
                        'success' => false,
                        'error' => 'Pasword salah, silahkan periksa kembali'
                    ];
                    return $this->response->setStatusCode(200)->setJSON($data);
                }
            }
        }
    }


    public function forgotPassword()
    {
        $email = $this->request->getVar('email');
        $penggunaModel = new \App\Models\PenggunaModel();
        $user = $penggunaModel->where('username', $email)->first();

        if (!$user) {
            $data = [
                'success' => false,
                'error' => 'Email tidak terdaftar'
            ];
            return $this->response->setStatusCode(200)->setJSON($data);
        }

        $new_password = random_string('sha1');
        $penggunaModel->where('username', $email)
            ->set('password', password_hash($new_password, PASSWORD_DEFAULT))
            ->update();

        $send = $this->password_mailer($email, $new_password);
        if ($send) {
            $data = [
                'success' => true,
            ];
            return $this->response->setStatusCode(200)->setJSON($data);
        }
        $data = [
            'success' => false,
            'error' => 'System Error'
        ];
        return $this->response->setStatusCode(200)->setJSON($data);
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

    public function editAvatar($userId)
    {
        
        $alumniModel = new \App\Models\AlumniModel();
        $alumniQuery = $alumniModel->where('pengguna_id', $userId)->first();
        if(!$alumniQuery){
            $data = [
                'success' => false,
                'errCode' => 'USER_ERROR',
                'error' => 'User tidak terdaftar',
            ];
            return $this->response->setStatusCode(200)->setJSON($data);
        }
        $id = $alumniQuery['id'];
        
          
        
        $input = $this->validate([
            'file' => [
                'uploaded[file]',
                'mime_in[file,image/jpg,image/jpeg,image/png]',
                'max_size[file,5000]',
            ]
        ]);

        if (!$input) {
            $validation = \Config\Services::validation();
            $data = [
                'success' => false,
                'error' => $validation->getError('file')
            ];
            return $this->response->setStatusCode(200)->setJSON($data);
         
        } else {

            $x_file = $this->request->getFile('file');

            $new_file = $x_file->getRandomName();
            $image = \Config\Services::image()
                ->withFile($x_file)
                ->resize(150, 150, true, 'height')
                ->save(FCPATH . '/photos/' . $new_file);
            // $x_file->move(WRITEPATH . 'uploads');
            $fileData = [
                'name' =>  $x_file->getName(),
                'type'  => $x_file->getClientMimeType()
            ];

            $alumniModel = new \App\Models\AlumniModel();
            $alumniModel->where('id', $id)->set([
                'photo' => $new_file
            ])->update();
            
             $data = [
                'success' => true,
                'msg' => 'Photo berhasil diupload ' . $new_file,
            ];
            return $this->response->setStatusCode(200)->setJSON($data);
           
        }
    }
    
}
