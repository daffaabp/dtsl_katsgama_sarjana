<?php

namespace App\Controllers;

class ProgramSarjana extends BaseController
{
    public function index()
    {
        $req = $this->request->getVar();
        $alumniModel = new \App\Models\AlumniModel();
        $propinsiModel = new \App\Models\PropinsiModel();
        $prodiModel = new \App\Models\ProdiModel();
        $occupationModel = new \App\Models\OccupationModel();
        $akademikModel = new \App\Models\AkademikModel();
        $angkatanModel = new \App\Models\AngkatanModel();

        $data['request'] = $req;
        $data_alumni = $alumniModel->program_sarjana($req)->paginate(10);
        $i = 0;
        foreach ($data_alumni as $dtal) {
            $data_alumni[$i]['riwayat_akademik'] = $akademikModel->where('akademik.idorg', $data_alumni[$i]['id'])->findAll();
            $i++;
        }
        $data['alumni'] = $data_alumni;
        $data['pager'] = $alumniModel->pager;
        $data['provinces'] = $propinsiModel->findAll();
        $data['occupations'] = $occupationModel->findAll();
        $data['jenjang'] = $akademikModel->select('jenjang')->distinct()->findAll();
        $data['universitas'] = $akademikModel->select('universitas')->distinct()->findAll();
        $data['departemen'] = $akademikModel->select('departemen')->distinct()->findAll();
        $data['prodi'] = $prodiModel->findAll();
        $data['tmasuk'] = $akademikModel->select('tmasuk')->distinct()->orderBy('tmasuk', 'DESC')->findAll();
        $data['angkatan'] = $angkatanModel->findAll();
        $data['bulan'] = $this->bulan();


        $data['req'] = $req;
        return view('program_sarjana/index', $data);
    }

    public function add()
    {
        $occupationModel = new \App\Models\OccupationModel();
        $propinsiModel = new \App\Models\PropinsiModel();
        $prodiModel = new \App\Models\ProdiModel();
        $angkatanModel = new \App\Models\AngkatanModel();

        $data['occupations'] = $occupationModel->findAll();
        $data['propinsi'] = $propinsiModel->findAll();
        $data['prodi'] = $prodiModel->findAll();
        $data['angkatan'] = $angkatanModel->angkatan()->findAll();
        $data['filteredAngkatan'] = $angkatanModel->filteredAngkatan()->findAll();
        $data['validation'] = \Config\Services::validation();
        $data['bulan'] = $this->bulan();

        return view('program_sarjana/add', $data);
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
                'rules' => 'required|max_length[200]|is_unique[data_alumni.email]',
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Email tidak valid',
                    'max_length' => 'Maksimal karakter 200',
                    'is_unique' => 'Email sudah terdaftar'
                ]
            ],
            'nowa' => [
                'rules' => 'required|max_length[200]',
                'errors' => [
                    'required' => 'No WA harus diisi',
                    'max_length' => 'Maksimal karakter 200',
                ]
            ],
            's1_universitas' => [
                'rules' => 'required|max_length[200]',
                'errors' => [
                    'required' => 'Universitas harus diisi',
                    'max_length' => 'Maksimal karakter 200',
                ]
            ],
            's1_tmasuk' => [
                'rules' => 'required|max_length[200]',
                'errors' => [
                    'required' => 'Tahun masuk harus diisi',
                    'max_length' => 'Maksimal karakter 200',
                ]
            ],
            's1_tlulus' => [
                'rules' => 'required|max_length[200]',
                'errors' => [
                    'required' => 'Tahun Lulus harus diisi',
                    'max_length' => 'Maksimal karakter 200',
                ]
            ],
            's1_prodi' => [
                'rules' => 'required|max_length[200]',
                'errors' => [
                    'required' => 'Prodi harus diisi',
                    'max_length' => 'Maksimal karakter 200',
                ]
            ],
            'twisuda' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tahun wisuda harus diisi',
                ]
            ],
            'blnwisuda' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Bulan wisuda harus diisi',
                ]
            ],
        ]);
        if (!$input) {
            $validation = \Config\Services::validation();
            return redirect()->to(site_url() . 'program_sarjana/add/')->withInput()->with('validation', $validation);
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
            $idorg = $alumniModel->insert($data);
            if ($idorg) {
                $wisudaModel = new \App\Models\WisudaModel();
                $dataWisuda = [
                    'idorg' => $idorg,
                    'twisuda' => $this->request->getVar('twisuda'),
                    'blnwisuda' => $this->request->getVar('blnwisuda'),

                ];
                $wisudaModel->insert($dataWisuda);

                $akademikModel = new \App\Models\AkademikModel();
                $s1 = [
                    'jenjang' => 'S1',
                    'idorg' => $idorg,
                    'universitas' => $this->request->getVar('s1_universitas'),
                    'tmasuk' => $this->request->getVar('s1_tmasuk'),
                    'tlulus' => $this->request->getVar('s1_tlulus'),
                    'prodi' => $this->request->getVar('s1_prodi'),
                ];
                $akademikModel->insert($s1);

                if ($this->request->getVar('s2_universitas')) {
                    $s2 = [
                        'jenjang' => 'S2',
                        'idorg' => $idorg,
                        'universitas' => $this->request->getVar('s2_universitas'),
                        'tmasuk' => $this->request->getVar('s2_tmasuk'),
                        'tlulus' => $this->request->getVar('s2_tlulus'),
                        'prodi' => $this->request->getVar('s2_prodi'),
                    ];
                    $akademikModel->insert($s2);
                }

                if ($this->request->getVar('s3_universitas')) {
                    $s3 = [
                        'jenjang' => 'S3',
                        'idorg' => $idorg,
                        'universitas' => $this->request->getVar('s3_universitas'),
                        'tmasuk' => $this->request->getVar('s3_tmasuk'),
                        'tlulus' => $this->request->getVar('s3_tlulus'),
                        'prodi' => $this->request->getVar('s3_prodi'),
                    ];
                    $akademikModel->insert($s3);
                }
            }
            return redirect()->to(site_url() . 'program_sarjana/edit/' . $idorg)->with('success', 'Data berhasil ditambahkan');
        }
    }


    public function edit($id)
    {
        $data['id'] = $id;
        $alumniModel = new \App\Models\AlumniModel();
        $akademikModel = new \App\Models\AkademikModel();
        $wisudaModel = new \App\Models\WisudaModel();

        $data['alumni'] = $alumniModel->find($id);
        $data['S1'] = $akademikModel->where('idorg', $id)->where('jenjang', 'S1')->limit(1)->get()->getRowArray();
        $data['S2'] = $akademikModel->where('idorg', $id)->where('jenjang', 'S2')->limit(1)->get()->getRowArray();
        $data['S3'] = $akademikModel->where('idorg', $id)->where('jenjang', 'S3')->limit(1)->get()->getRowArray();
        $data['wisuda'] = $wisudaModel->where('idorg', $id)->first();

        $occupationModel = new \App\Models\OccupationModel();
        $propinsiModel = new \App\Models\PropinsiModel();
        $prodiModel = new \App\Models\ProdiModel();
        $angkatanModel = new \App\Models\AngkatanModel();

        $data['occupations'] = $occupationModel->findAll();
        $data['propinsi'] = $propinsiModel->findAll();
        $data['prodi'] = $prodiModel->findAll();
        $data['angkatan'] = $angkatanModel->findAll();
        $data['filteredAngkatan'] = $angkatanModel->filteredAngkatan()->findAll();
        $data['validation'] = \Config\Services::validation();
        $data['bulan'] = $this->bulan();

        return view('program_sarjana/edit', $data);
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
                'rules' => 'required|max_length[200]|is_unique[data_alumni.email,id,{id}]',
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Email tidak valid',
                    'max_length' => 'Maksimal karakter 200',
                    'is_unique' => 'Email sudah terdaftar'
                ]
            ],
            'nowa' => [
                'rules' => 'required|max_length[200]',
                'errors' => [
                    'required' => 'No WA harus diisi',
                    'max_length' => 'Maksimal karakter 200',
                ]
            ],
            's1_universitas' => [
                'rules' => 'required|max_length[200]',
                'errors' => [
                    'required' => 'Universitas harus diisi',
                    'max_length' => 'Maksimal karakter 200',
                ]
            ],
            's1_tmasuk' => [
                'rules' => 'required|max_length[200]',
                'errors' => [
                    'required' => 'Tahun masuk harus diisi',
                    'max_length' => 'Maksimal karakter 200',
                ]
            ],
            's1_tlulus' => [
                'rules' => 'required|max_length[200]',
                'errors' => [
                    'required' => 'Tahun Lulus harus diisi',
                    'max_length' => 'Maksimal karakter 200',
                ]
            ],
            's1_prodi' => [
                'rules' => 'required|max_length[200]',
                'errors' => [
                    'required' => 'Prodi harus diisi',
                    'max_length' => 'Maksimal karakter 200',
                ]
            ],
        ]);
        if (!$input) {
            $validation = \Config\Services::validation();
            return redirect()->to(site_url() . 'program_sarjana/edit/' . $id)->withInput()
                ->with('validation', $validation)->with('error', 'Periksa data kembali');
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

                $wisudaModel = new \App\Models\WisudaModel();
                $dataWisuda = [
                    'idorg' => $id,
                    'twisuda' => $this->request->getVar('twisuda'),
                    'blnwisuda' => $this->request->getVar('blnwisuda'),

                ];
                $wisudaModel->where('idorg', $id)->delete();
                $wisudaModel->insert($dataWisuda);

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
            return redirect()->to(site_url() . 'program_sarjana/edit/' . $id)->with('success', 'Data berhasil diubah');
        }
    }

    public function edit_avatar()
    {
        $id = $this->request->getVar('id');
        $input = $this->validate([
            'file' => [
                'uploaded[file]',
                'mime_in[file,image/jpg,image/jpeg,image/png]',
                'max_size[file,1024]',
            ]
        ]);

        if (!$input) {
            $validation = \Config\Services::validation();
            return redirect()->to(site_url() . 'program_sarjana/edit/' . $id)->with('error',  $validation->getError('file'));
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
            return redirect()->to(site_url() . 'program_sarjana/edit/' . $id)->with('success', 'Photo berhasil diupload');
        }
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

        return view('program_sarjana/detail', $data);
    }

    public function delete($id)
    {
        $alumniModel = new \App\Models\AlumniModel();
        $akademikModel = new \App\Models\AkademikModel();
        $alumniModel->delete($id);
        $akademikModel->where('idorg', $id)->delete($id);
    }

    public function bulan()
    {
        $bulan = [
            [ 'id' => 1, 'nama' => 'Januari'],
            [ 'id' => 2, 'nama' => 'Februari'],
            [ 'id' => 3, 'nama' => 'Maret'],
            [ 'id' => 4, 'nama' => 'April'],
            [ 'id' => 5, 'nama' => 'Mei'],
            [ 'id' => 6, 'nama' => 'Juni'],
            [ 'id' => 7, 'nama' => 'Juli'],
            [ 'id' => 8, 'nama' => 'Agustus'],
            [ 'id' => 9, 'nama' => 'September'],
            [ 'id' => 10, 'nama' => 'Oktober'],
            [ 'id' => 11, 'nama' => 'November'],
            [ 'id' => 12, 'nama' => 'Desember'],
        ];
        return $bulan;
    }
}
