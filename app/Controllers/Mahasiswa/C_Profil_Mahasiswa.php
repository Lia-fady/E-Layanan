<?php

namespace App\Controllers\Mahasiswa;

class C_Profil_Mahasiswa extends C_Base_Mahasiswa
{
    public function profil()
    {
        $id_mahasiswa = session()->get('id_mahasiswa');
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        $stateData = $this->_getMahasiswaState($id_mahasiswa);
        $db = \Config\Database::connect();
        
        // Data Pribadi Mahasiswa
        $mahasiswa = $db->table('m_mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->get()->getRowArray();
        
        // Data Akademik + join ke m_instansi_pendidikan, m_prodi, m_fakultas
        $instansi = $db->table('t_instansi_mahasiswa')
            ->select('
                t_instansi_mahasiswa.*,
                m_instansi_pendidikan.instansi_pendidikan as nama_instansi,
                m_prodi.prodi,
                m_fakultas.fakultas
            ')
            ->join('m_instansi_pendidikan', 'm_instansi_pendidikan.id_instansi_pendidikan = t_instansi_mahasiswa.id_instansi_pendidikan', 'left')
            ->join('m_prodi', 'm_prodi.id_prodi = t_instansi_mahasiswa.id_prodi', 'left')
            ->join('m_fakultas', 'm_fakultas.id_fakultas = m_prodi.id_fakultas', 'left')
            ->where('t_instansi_mahasiswa.id_mahasiswa', $id_mahasiswa)
            ->get()->getRowArray();

        $data = [
            'title'            => 'Profil Mahasiswa',
            'state'            => $stateData['state'],
            'is_log_book'      => $stateData['is_log_book'],
            'jenis_permohonan' => $stateData['jenis_permohonan'],
            'm'                => $mahasiswa,
            'i'                => $instansi
        ];

        return view('mahasiswa/V_ProfilMahasiswa_Mahasiswa', $data);
    }

    public function updateProfil()
    {
        $id_mahasiswa = session()->get('id_mahasiswa');
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'));
        }

        $rules = [
            'nik' => [
                'rules'  => "required|numeric|exact_length[16]|is_unique[m_mahasiswa.nik,id_mahasiswa,{$id_mahasiswa}]",
                'errors' => [
                    'required'     => 'NIK wajib diisi.',
                    'numeric'      => 'NIK harus berupa angka.',
                    'exact_length' => 'NIK wajib berjumlah 16 digit.',
                    'is_unique'    => 'NIK ini sudah terdaftar oleh akun lain.'
                ]
            ],
            'jenis_kelamin' => [
                'rules'  => 'required|in_list[L,P]',
                'errors' => ['required' => 'Jenis kelamin wajib dipilih.', 'in_list' => 'Pilihan jenis kelamin tidak valid.']
            ],
            'tgl_lahir' => [
                'rules'  => 'required|valid_date',
                'errors' => ['required' => 'Tanggal lahir wajib diisi.', 'valid_date' => 'Format tanggal tidak valid.']
            ],
            'email' => [
                'rules'  => "required|valid_email|is_unique[m_mahasiswa.email,id_mahasiswa,{$id_mahasiswa}]",
                'errors' => [
                    'required'    => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique'   => 'Email ini sudah digunakan oleh akun lain.'
                ]
            ],
            'no_telp' => [
                'rules'  => 'required|numeric|min_length[10]|max_length[15]',
                'errors' => [
                    'required'   => 'Nomor telepon wajib diisi.',
                    'numeric'    => 'Nomor telepon harus berupa angka.',
                    'min_length' => 'Minimal 10 digit.',
                    'max_length' => 'Maksimal 15 digit.'
                ]
            ],
            'alamat' => [
                'rules'  => 'required|max_length[255]',
                'errors' => ['required' => 'Alamat wajib diisi.']
            ],
            'rt' => [
                'rules'  => 'required|numeric|max_length[3]',
                'errors' => ['required' => 'RT wajib diisi.', 'numeric' => 'RT harus angka.']
            ],
            'rw' => [
                'rules'  => 'required|numeric|max_length[3]',
                'errors' => ['required' => 'RW wajib diisi.', 'numeric' => 'RW harus angka.']
            ],
            'kelurahan' => [
                'rules'  => 'required|min_length[3]|max_length[100]',
                'errors' => ['required' => 'Kelurahan wajib diisi.']
            ],
            'kecamatan' => [
                'rules'  => 'required|min_length[3]|max_length[100]',
                'errors' => ['required' => 'Kecamatan wajib diisi.']
            ],
            'provinsi' => [
                'rules'  => 'required|min_length[3]|max_length[100]',
                'errors' => ['required' => 'Provinsi wajib diisi.']
            ],
            'jenjang_pendidikan' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Jenjang pendidikan wajib dipilih.']
            ],
            'angkatan_tahun' => [
                'rules'  => 'required|numeric|exact_length[4]',
                'errors' => ['required' => 'Tahun angkatan wajib diisi.', 'numeric' => 'Harus angka.', 'exact_length' => 'Tahun harus 4 digit.']
            ],
            'semester' => [
                'rules'  => 'required|numeric|greater_than[0]|less_than_equal_to[14]',
                'errors' => ['required' => 'Semester wajib diisi.', 'numeric' => 'Harus angka.', 'greater_than' => 'Minimal 1', 'less_than_equal_to' => 'Maksimal 14']
            ],
            'tahun_akademik' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Tahun akademik wajib diisi.']
            ]
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', 'Terdapat kesalahan pada isian profil Anda. Silakan periksa kembali!');
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();

        // 1. Data Pribadi & Domisili (Tabel m_mahasiswa)
        $dataMahasiswa = [
            'nik'           => $this->request->getPost('nik'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tgl_lahir'     => $this->request->getPost('tgl_lahir'),
            'email'         => $this->request->getPost('email'),
            'no_telp'       => $this->request->getPost('no_telp'),
            'alamat'        => $this->request->getPost('alamat'),
            'rt'            => $this->request->getPost('rt'),
            'rw'            => $this->request->getPost('rw'),
            'kelurahan'     => $this->request->getPost('kelurahan'),
            'kecamatan'     => $this->request->getPost('kecamatan'),
            'provinsi'      => $this->request->getPost('provinsi')
        ];
        
        $db->table('m_mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->update($dataMahasiswa);

        // 2. Data Akademik (Tabel t_instansi_mahasiswa)
        $instansi = $db->table('t_instansi_mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->get()->getRow();
        
        $dataAkademik = [
            'jenjang_pendidikan' => $this->request->getPost('jenjang_pendidikan'),
            'angkatan_tahun'     => $this->request->getPost('angkatan_tahun'),
            'semester'           => $this->request->getPost('semester'),
            'tahun_akademik'     => $this->request->getPost('tahun_akademik'),
        ];

        if ($instansi) {
            $db->table('t_instansi_mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->update($dataAkademik);
        } else {
            $dataAkademik['id_mahasiswa'] = $id_mahasiswa;
            $db->table('t_instansi_mahasiswa')->insert($dataAkademik);
        }

        session()->setFlashdata('sweet_success', 'Profil Anda berhasil diperbarui!');
        return redirect()->to(base_url('mahasiswa/profil'));
    }
}
