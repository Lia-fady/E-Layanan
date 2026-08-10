<?php

namespace App\Controllers\Mahasiswa;

class C_Profil extends C_BaseMahasiswa
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
        $mahasiswa = $db->table('m_mahasiswa')
            ->select('m_mahasiswa.*, m_kelurahan.nama_kelurahan, m_kecamatan.nama_kecamatan, m_kecamatan.id_kecamatan, m_kabupaten.nama_kabupaten, m_kabupaten.id_kabupaten, m_provinsi.nama_provinsi, m_provinsi.id_provinsi')
            ->join('m_kelurahan', 'm_kelurahan.id_kelurahan = m_mahasiswa.id_kelurahan', 'left')
            ->join('m_kecamatan', 'm_kecamatan.id_kecamatan = m_kelurahan.id_kecamatan', 'left')
            ->join('m_kabupaten', 'm_kabupaten.id_kabupaten = m_kecamatan.id_kabupaten', 'left')
            ->join('m_provinsi', 'm_provinsi.id_provinsi = m_kabupaten.id_provinsi', 'left')
            ->where('id_mahasiswa', $id_mahasiswa)
            ->get()->getRowArray();
        
        // Data Akademik + join ke m_instansi_pendidikan, m_prodi, m_fakultas
        $instansi = $db->table('t_instansi_mahasiswa')
            ->select('
                t_instansi_mahasiswa.*,
                m_instansi_pendidikan.instansi_pendidikan as nama_instansi,
                m_prodi.nama_prodi as prodi,
                m_fakultas.fakultas,
                m_jenjang_pendidikan.nama_jenjang
            ')
            ->join('m_instansi_pendidikan', 'm_instansi_pendidikan.id_instansi_pendidikan = t_instansi_mahasiswa.id_instansi_pendidikan', 'left')
            ->join('m_prodi', 'm_prodi.id_prodi = t_instansi_mahasiswa.id_prodi', 'left')
            ->join('m_fakultas', 'm_fakultas.id_fakultas = m_prodi.id_fakultas', 'left')
            ->join('m_jenjang_pendidikan', 'm_jenjang_pendidikan.id_jenjang_pendidikan = t_instansi_mahasiswa.id_jenjang_pendidikan', 'left')
            ->where('t_instansi_mahasiswa.id_mahasiswa', $id_mahasiswa)
            ->get()->getRowArray();

        $data = [
            'title'            => 'Profil Mahasiswa',
            'state'            => $stateData['state'],
            'is_log_book'      => $stateData['is_log_book'],
            'jenis_permohonan' => $stateData['jenis_permohonan'],
            'm'                => $mahasiswa,
            'i'                => $instansi,
            'provinsi'         => $db->table('m_provinsi')->get()->getResultArray(),
            'jenjang'          => $db->table('m_jenjang_pendidikan')->where('status', 'AKTIF')->get()->getResultArray()
        ];

        return view('mahasiswa/v_profil_mahasiswa', $data);
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
            'id_kelurahan' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Kelurahan wajib dipilih.']
            ],
            'id_jenjang_pendidikan' => [
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
            'id_kelurahan'  => $this->request->getPost('id_kelurahan')
        ];
        
        $db->table('m_mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->update($dataMahasiswa);

        // 2. Data Akademik (Tabel t_instansi_mahasiswa)
        $instansi = $db->table('t_instansi_mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->get()->getRow();
        
        $dataAkademik = [
            'id_jenjang_pendidikan' => $this->request->getPost('id_jenjang_pendidikan'),
            'angkatan_tahun'        => $this->request->getPost('angkatan_tahun'),
            'semester'              => $this->request->getPost('semester'),
            'tahun_akademik'        => $this->request->getPost('tahun_akademik'),
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
