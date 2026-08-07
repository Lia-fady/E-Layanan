<?php

namespace App\Controllers\Mahasiswa;

class C_Permohonan extends C_BaseMahasiswa
{
    public function permohonan()
    {
        $id_mahasiswa = session()->get('id_mahasiswa');
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        $db = \Config\Database::connect();
        
        $data['jenis_permohonan'] = $db->table('m_jenis_permohonan')->where('status', 'aktif')->get()->getResultArray();
        $data['title']            = 'Form Permohonan Magang';
        $data['nama']             = session()->get('nama') ?? 'Mahasiswa';
        
        // Fetch data pribadi dan instansi untuk Review
        $mhs = $db->table('m_mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->get()->getRowArray();
        $instansi = $db->table('t_instansi_mahasiswa')
            ->select('t_instansi_mahasiswa.*, m_instansi_pendidikan.instansi_pendidikan, m_fakultas.nama_fakultas, m_prodi.nama_prodi')
            ->join('m_instansi_pendidikan', 'm_instansi_pendidikan.id_instansi_pendidikan = t_instansi_mahasiswa.id_instansi_pendidikan', 'left')
            ->join('m_prodi', 'm_prodi.id_prodi = t_instansi_mahasiswa.id_prodi', 'left')
            ->join('m_fakultas', 'm_fakultas.id_fakultas = m_prodi.id_fakultas', 'left')
            ->where('t_instansi_mahasiswa.id_mahasiswa', $id_mahasiswa)
            ->get()->getRowArray();

        $data['mhs'] = $mhs;
        $data['instansi'] = $instansi;

        $stateData = $this->_getMahasiswaState($id_mahasiswa);

        // Jika ada draf atau revisi berkas yang sedang berjalan, tampilkan form edit langsung di URL ini
        if (!empty($stateData['permohonan_aktif'])) {
            $aktif = $stateData['permohonan_aktif'];
            if ($aktif['status_persetujuan'] === 'PERBAIKAN_BERKAS' || $aktif['posting_data'] === 'draft') {
                return $this->editPermohonan($aktif['id_permohonan_magang']);
            }
        }

        $data['state']            = $stateData['state'];
        $data['is_log_book']      = $stateData['is_log_book'];
        $data['jenis_permohonan_aktif'] = $stateData['jenis_permohonan'];
        $data['permohonan_aktif'] = $stateData['permohonan_aktif'];

        return view('mahasiswa/v_form_permohonan', $data);
    }

    public function simpanPermohonan()
    {
        $id_mahasiswa = session()->get('id_mahasiswa'); 
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'))->with('error', 'Sesi Anda telah habis. Silakan login kembali.');
        }

        $rules = [
            'id_jenis_permohonan' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Jenis layanan permohonan wajib dipilih.']
            ],
            'deskripsi_keahlian' => [
                'rules'  => 'required|min_length[10]',
                'errors' => [
                    'required'   => 'Deskripsi keahlian wajib diisi.',
                    'min_length' => 'Deskripsi keahlian minimal harus 10 karakter.'
                ]
            ],
            'rencana_kegiatan' => [
                'rules'  => 'required|min_length[20]',
                'errors' => [
                    'required'   => 'Maksud dan tujuan magang wajib diisi.',
                    'min_length' => 'Maksud tujuan minimal harus 20 karakter agar jelas.'
                ]
            ],
            'tgl_mulai' => [
                'rules'  => 'required|valid_date',
                'errors' => [
                    'required'   => 'Tanggal perkiraan mulai magang wajib diisi.',
                    'valid_date' => 'Format tanggal mulai tidak valid.'
                ]
            ],
            'tgl_selesai' => [
                'rules'  => 'required|valid_date',
                'errors' => [
                    'required'   => 'Tanggal perkiraan selesai magang wajib diisi.',
                    'valid_date' => 'Format tanggal selesai tidak valid.'
                ]
            ],
            'surat_pengantar' => [
                'rules'  => 'uploaded[surat_pengantar]|max_size[surat_pengantar,2048]|ext_in[surat_pengantar,pdf]|mime_in[surat_pengantar,application/pdf]',
                'errors' => [
                    'uploaded' => 'Berkas Surat Pengantar wajib diunggah.',
                    'max_size' => 'Ukuran Surat Pengantar terlalu besar, maksimal 2MB.',
                    'ext_in'   => 'Surat Pengantar harus berformat PDF.',
                    'mime_in'  => 'Berkas Surat Pengantar terdeteksi bukan file PDF asli (mime type tidak valid).'
                ]
            ],
            'ktm' => [
                'rules'  => 'uploaded[ktm]|max_size[ktm,2048]|ext_in[ktm,pdf,jpg,jpeg,png]|mime_in[ktm,application/pdf,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Berkas KTM wajib diunggah.',
                    'max_size' => 'Ukuran KTM terlalu besar, maksimal 2MB.',
                    'ext_in'   => 'KTM harus berformat PDF, JPG, atau PNG.',
                    'mime_in'  => 'Berkas KTM terdeteksi bukan file PDF/Gambar asli.'
                ]
            ]
        ];

        if ($this->request->getPost('id_jenis_permohonan') !== '2') {
            $rules['cv'] = [
                'rules'  => 'uploaded[cv]|max_size[cv,2048]|ext_in[cv,pdf]|mime_in[cv,application/pdf]',
                'errors' => [
                    'uploaded' => 'Berkas CV / Proposal wajib diunggah.',
                    'max_size' => 'Ukuran CV / Proposal terlalu besar, maksimal 2MB.',
                    'ext_in'   => 'CV / Proposal harus berformat PDF.',
                    'mime_in'  => 'Berkas CV / Proposal terdeteksi bukan file PDF asli.'
                ]
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id_jenis_permohonan = $this->request->getPost('id_jenis_permohonan');
        $tglMulai = $this->request->getPost('tgl_mulai');
        $tglSelesai = $this->request->getPost('tgl_selesai');
        
        if ($tglMulai && $tglSelesai && $id_jenis_permohonan == '3') {
            $dateMulai = new \DateTime($tglMulai);
            $dateSelesai = new \DateTime($tglSelesai);
            $diff = $dateMulai->diff($dateSelesai);

            if ($diff->invert || $diff->days < 60) {
                return redirect()->back()->withInput()->with('errors', [
                    'tgl_mulai' => 'Durasi permohonan magang minimal adalah 2 bulan (60 hari).',
                    'tgl_selesai' => 'Tanggal selesai magang harus minimal 2 bulan setelah tanggal mulai.'
                ]);
            }
        }

        $db = \Config\Database::connect();

        $id_jenis_permohonan = $this->request->getPost('id_jenis_permohonan');
        $tgl_mulai           = $this->request->getPost('tgl_mulai');
        $tgl_selesai         = $this->request->getPost('tgl_selesai');
        $deskripsi_keahlian  = $this->request->getPost('deskripsi_keahlian');
        $deskripsi    = $this->request->getPost('deskripsi');

        $mhs = $db->table('m_mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->get()->getRowArray();
        $id_instansi_mahasiswa = $mhs['id_instansi_mahasiswa'] ?? 1;

        $db->transStart();

        $action_type = $this->request->getPost('action_type') === 'draft' ? 'draft' : 'kirim';

        $dataPermohonan = [
            'id_mahasiswa'          => $id_mahasiswa,
            'id_instansi_mahasiswa' => $id_instansi_mahasiswa,
            'id_jenis_permohonan'   => $id_jenis_permohonan,
            'deskripsi_keahlian'    => esc($deskripsi_keahlian), // ANTI XSS
            'deskripsi'             => esc($deskripsi),          // ANTI XSS
            'tgl_mulai'             => $tgl_mulai,
            'tgl_selesai'           => $tgl_selesai,
            'posting_data'          => $action_type,
            'created_at'            => date('Y-m-d H:i:s')
        ];
        
        $this->permohonanModel->insert($dataPermohonan);
        $id_permohonan_baru = $this->permohonanModel->getInsertID(); 

        $fileSurat = $this->request->getFile('surat_pengantar'); 
        if ($fileSurat && $fileSurat->isValid() && !$fileSurat->hasMoved()) {
            $namaSuratBaru = $fileSurat->getRandomName();
            $fileSurat->move(FCPATH . 'uploads/dokumen', $namaSuratBaru);

            $id_file_master = 2; 
            if ($id_jenis_permohonan == '1') $id_file_master = 1; 
            if ($id_jenis_permohonan == '2') $id_file_master = 5; 
            if ($id_jenis_permohonan == '4') $id_file_master = 6; 

            $pivot = $db->table('m_file_permohonan')
                        ->where('id_jenis_permohonan', $id_jenis_permohonan)
                        ->where('id_file', $id_file_master)
                        ->get()->getRowArray();

            if ($pivot) {
                $db->table('t_file_permohonan_magang')->insert([
                    'id_permohonan_magang' => $id_permohonan_baru,
                    'id_file_permohonan'   => $pivot['id_file_permohonan'], 
                    'nama_file'            => preg_replace('/[^a-zA-Z0-9-_\.]/', '_', $fileSurat->getClientName()), // ANTI XSS
                    'path_file'            => 'uploads/dokumen/' . $namaSuratBaru,
                    'created_at'           => date('Y-m-d H:i:s')
                ]);
            }
        }

        if ($id_jenis_permohonan !== '2') {
            $fileKedua = $this->request->getFile('cv'); 
            if ($fileKedua && $fileKedua->isValid() && !$fileKedua->hasMoved()) {
                $namaFileKeduaBaru = $fileKedua->getRandomName();
                $fileKedua->move(FCPATH . 'uploads/dokumen', $namaFileKeduaBaru);

                $id_file_kedua_master = 3; 
                if ($id_jenis_permohonan == '1') $id_file_kedua_master = 4; 
                if ($id_jenis_permohonan == '4') $id_file_kedua_master = 7; 

                $pivotKedua = $db->table('m_file_permohonan')
                            ->where('id_jenis_permohonan', $id_jenis_permohonan)
                            ->where('id_file', $id_file_kedua_master)
                            ->get()->getRowArray();

                if ($pivotKedua) {
                    $db->table('t_file_permohonan_magang')->insert([
                        'id_permohonan_magang' => $id_permohonan_baru,
                        'id_file_permohonan'   => $pivotKedua['id_file_permohonan'], 
                        'nama_file'            => preg_replace('/[^a-zA-Z0-9-_\.]/', '_', $fileKedua->getClientName()), // ANTI XSS
                        'path_file'            => 'uploads/dokumen/' . $namaFileKeduaBaru,
                        'created_at'           => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }

        // Upload KTM (mandatory for all types)
        $fileKtm = $this->request->getFile('ktm'); 
        if ($fileKtm && $fileKtm->isValid() && !$fileKtm->hasMoved()) {
            $namaKtmBaru = $fileKtm->getRandomName();
            $fileKtm->move(FCPATH . 'uploads/dokumen', $namaKtmBaru);

            $id_file_ktm_master = 11; // KTM

            $pivotKtm = $db->table('m_file_permohonan')
                        ->where('id_jenis_permohonan', $id_jenis_permohonan)
                        ->where('id_file', $id_file_ktm_master)
                        ->get()->getRowArray();

            if ($pivotKtm) {
                $db->table('t_file_permohonan_magang')->insert([
                    'id_permohonan_magang' => $id_permohonan_baru,
                    'id_file_permohonan'   => $pivotKtm['id_file_permohonan'], 
                    'nama_file'            => preg_replace('/[^a-zA-Z0-9-_\.]/', '_', $fileKtm->getClientName()), // ANTI XSS
                    'path_file'            => 'uploads/dokumen/' . $namaKtmBaru,
                    'created_at'           => date('Y-m-d H:i:s')
                ]);
            }
        }

        if ($action_type === 'kirim') {
            $db->table('t_persetujuan_magang')->insert([
                'id_permohonan_magang' => $id_permohonan_baru,
                'status_persetujuan'   => 'MENUNGGU',
                'disposisi'            => '0',
                'created_at'           => date('Y-m-d H:i:s')
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal memproses pengajuan permohonan magang Anda.');
            return redirect()->back()->withInput();
        }

        if ($action_type === 'draft') {
            catat_log($id_permohonan_baru, 'Mahasiswa', 'Menyimpan Draft Permohonan', 'Permohonan disimpan sebagai draf sementara.');
            session()->setFlashdata('success', 'Permohonan berhasil disimpan sebagai Draft.');
            return redirect()->to(base_url('mahasiswa/status'));
        } else {
            catat_log($id_permohonan_baru, 'Mahasiswa', 'Mengajukan Permohonan', 'Permohonan baru diajukan dan menunggu verifikasi Sekretariat.');
            session()->setFlashdata('permohonan_sent', true);
            session()->setFlashdata('success', 'Permohonan dan berkas PDF berhasil terkirim dan tercatat di sistem.');
            return redirect()->to(base_url('mahasiswa/status'));
        }
    }

    public function editPermohonan($id_permohonan)
    {
        $id_mahasiswa = session()->get('id_mahasiswa');
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'));
        }

        $db = \Config\Database::connect();
        $draft = $db->table('t_permohonan_magang')
                    ->select('t_permohonan_magang.*, t_persetujuan_magang.status_persetujuan, t_persetujuan_magang.catatan as catatan_sekretariat')
                    ->join('t_persetujuan_magang', 't_persetujuan_magang.id_permohonan_magang = t_permohonan_magang.id_permohonan_magang', 'left')
                    ->where('t_permohonan_magang.id_permohonan_magang', $id_permohonan)
                    ->where('t_permohonan_magang.id_mahasiswa', $id_mahasiswa)
                    ->get()->getRowArray();
                                       
        if (!$draft || ($draft['posting_data'] !== 'draft' && $draft['status_persetujuan'] !== 'PERBAIKAN_BERKAS')) {
            return redirect()->to(base_url('mahasiswa/status'))->with('error', 'Permohonan tidak ditemukan atau tidak dapat diedit.');
        }

        $draft['surat_pengantar'] = '';
        $draft['nama_surat_pengantar'] = '';
        $draft['cv'] = '';
        $draft['nama_cv'] = '';
        $draft['ktm'] = '';
        $draft['nama_ktm'] = '';
        
        $files = $db->table('t_file_permohonan_magang')->where('id_permohonan_magang', $id_permohonan)->get()->getResultArray();
        foreach($files as $f) {
            $pivot = $db->table('m_file_permohonan')->where('id_file_permohonan', $f['id_file_permohonan'])->get()->getRowArray();
            if ($pivot) {
                if (in_array($pivot['id_file'], [1, 2, 5, 6])) {
                    $draft['surat_pengantar'] = $f['path_file'];
                    $draft['nama_surat_pengantar'] = $f['nama_file'];
                } elseif (in_array($pivot['id_file'], [3, 4, 7])) {
                    $draft['cv'] = $f['path_file'];
                    $draft['nama_cv'] = $f['nama_file'];
                } elseif ($pivot['id_file'] == 11) {
                    $draft['ktm'] = $f['path_file'];
                    $draft['nama_ktm'] = $f['nama_file'];
                }
            }
        }

        $mhs = $db->table('m_mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->get()->getRowArray();
        $instansi = $db->table('t_instansi_mahasiswa')
            ->select('t_instansi_mahasiswa.*, m_instansi_pendidikan.instansi_pendidikan, m_fakultas.nama_fakultas, m_prodi.nama_prodi')
            ->join('m_instansi_pendidikan', 'm_instansi_pendidikan.id_instansi_pendidikan = t_instansi_mahasiswa.id_instansi_pendidikan', 'left')
            ->join('m_prodi', 'm_prodi.id_prodi = t_instansi_mahasiswa.id_prodi', 'left')
            ->join('m_fakultas', 'm_fakultas.id_fakultas = m_prodi.id_fakultas', 'left')
            ->where('t_instansi_mahasiswa.id_mahasiswa', $id_mahasiswa)
            ->get()->getRowArray();

        $data = [
            'title' => 'Edit Permohonan',
            'draft' => $draft,
            'mhs' => $mhs,
            'instansi' => $instansi,
            'state' => ($draft['status_persetujuan'] === 'PERBAIKAN_BERKAS') ? 6 : 1
        ];

        return view('mahasiswa/v_form_edit_permohonan', $data);
    }

    public function updatePermohonan()
    {
        $id_mahasiswa = session()->get('id_mahasiswa');
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'));
        }

        // Ambil ID dari state aktif mahasiswa agar tidak perlu bergantung pada URL parameter
        $stateData = $this->_getMahasiswaState($id_mahasiswa);
        if (empty($stateData['permohonan_aktif'])) {
            return redirect()->to(base_url('mahasiswa/status'))->with('error', 'Tidak ada permohonan aktif yang dapat diedit.');
        }
        
        $id_permohonan = $stateData['permohonan_aktif']['id_permohonan_magang'];

        $db = \Config\Database::connect();
        $draft = $db->table('t_permohonan_magang')
                    ->select('t_permohonan_magang.*, t_persetujuan_magang.status_persetujuan')
                    ->join('t_persetujuan_magang', 't_persetujuan_magang.id_permohonan_magang = t_permohonan_magang.id_permohonan_magang', 'left')
                    ->where('t_permohonan_magang.id_permohonan_magang', $id_permohonan)
                    ->where('t_permohonan_magang.id_mahasiswa', $id_mahasiswa)
                    ->get()->getRowArray();
                                       
        if (!$draft || ($draft['posting_data'] !== 'draft' && $draft['status_persetujuan'] !== 'PERBAIKAN_BERKAS')) {
            return redirect()->to(base_url('mahasiswa/status'))->with('error', 'Permohonan tidak ditemukan atau tidak dapat diedit.');
        }

        $rules = [
            'id_jenis_permohonan' => ['rules' => 'required'],
            'deskripsi_keahlian'  => ['rules' => 'required|min_length[10]'],
            'deskripsi'    => ['rules' => 'required|min_length[20]'],
            'tgl_mulai'           => ['rules' => 'required|valid_date'],
            'tgl_selesai'         => ['rules' => 'required|valid_date']
        ];

        if ($this->request->getFile('surat_pengantar')->isValid()) {
            $rules['surat_pengantar'] = ['rules' => 'max_size[surat_pengantar,2048]|ext_in[surat_pengantar,pdf]|mime_in[surat_pengantar,application/pdf]'];
        }
        if ($this->request->getPost('id_jenis_permohonan') !== '2' && $this->request->getFile('cv')->isValid()) {
            $rules['cv'] = ['rules' => 'max_size[cv,2048]|ext_in[cv,pdf]|mime_in[cv,application/pdf]'];
        }

        $hasKtm = $db->table('t_file_permohonan_magang')
                     ->join('m_file_permohonan', 'm_file_permohonan.id_file_permohonan = t_file_permohonan_magang.id_file_permohonan')
                     ->where('t_file_permohonan_magang.id_permohonan_magang', $id_permohonan)
                     ->where('m_file_permohonan.id_file', 11)
                     ->countAllResults() > 0;
                     
        if (!$hasKtm) {
            $rules['ktm'] = [
                'rules'  => 'uploaded[ktm]|max_size[ktm,2048]|ext_in[ktm,pdf,jpg,jpeg,png]|mime_in[ktm,application/pdf,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Berkas KTM wajib diunggah karena Anda belum melampirkannya sebelumnya.',
                    'max_size' => 'Ukuran KTM terlalu besar, maksimal 2MB.',
                    'ext_in'   => 'KTM harus berformat PDF, JPG, atau PNG.',
                    'mime_in'  => 'Berkas KTM terdeteksi bukan file PDF/Gambar asli.'
                ]
            ];
        } else {
            if ($this->request->getFile('ktm')->isValid()) {
                $rules['ktm'] = ['rules' => 'max_size[ktm,2048]|ext_in[ktm,pdf,jpg,jpeg,png]|mime_in[ktm,application/pdf,image/jpeg,image/png]'];
            }
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id_jenis_permohonan = $this->request->getPost('id_jenis_permohonan');
        $tglMulai = $this->request->getPost('tgl_mulai');
        $tglSelesai = $this->request->getPost('tgl_selesai');
        if ($tglMulai && $tglSelesai && $id_jenis_permohonan == '3') {
            $dateMulai = new \DateTime($tglMulai);
            $dateSelesai = new \DateTime($tglSelesai);
            $diff = $dateMulai->diff($dateSelesai);

            if ($diff->invert || $diff->days < 60) {
                return redirect()->back()->withInput()->with('errors', [
                    'tgl_mulai' => 'Durasi permohonan magang minimal adalah 2 bulan (60 hari).',
                    'tgl_selesai' => 'Tanggal selesai magang harus minimal 2 bulan setelah tanggal mulai.'
                ]);
            }
        }

        $db->transStart();

        $action_type = $this->request->getPost('action_type') === 'draft' ? 'draft' : 'kirim';
        $id_jenis_permohonan = $this->request->getPost('id_jenis_permohonan');

        $dataPermohonan = [
            'id_jenis_permohonan' => $id_jenis_permohonan,
            'deskripsi_keahlian'  => esc($this->request->getPost('deskripsi_keahlian')), // ANTI XSS
            'deskripsi'           => esc($this->request->getPost('deskripsi')),          // ANTI XSS
            'tgl_mulai'           => $this->request->getPost('tgl_mulai'),
            'tgl_selesai'         => $this->request->getPost('tgl_selesai'),
            'posting_data'        => $action_type,
            'updated_at'          => date('Y-m-d H:i:s')
        ];
        $this->permohonanModel->update($id_permohonan, $dataPermohonan);

        if ($draft['id_jenis_permohonan'] != $id_jenis_permohonan) {
            $oldSurat = $db->table('t_file_permohonan_magang')
                           ->join('m_file_permohonan', 'm_file_permohonan.id_file_permohonan = t_file_permohonan_magang.id_file_permohonan')
                           ->where('t_file_permohonan_magang.id_permohonan_magang', $id_permohonan)
                           ->whereIn('m_file_permohonan.id_file', [1,2,5,6])
                           ->select('t_file_permohonan_magang.id_file_permohonan_magang')
                           ->get()->getRowArray();
            $id_file_master_surat = 2;
            if ($id_jenis_permohonan == '1') $id_file_master_surat = 1;
            if ($id_jenis_permohonan == '2') $id_file_master_surat = 5;
            if ($id_jenis_permohonan == '4') $id_file_master_surat = 6;
            
            $pivotSurat = $db->table('m_file_permohonan')->where('id_jenis_permohonan', $id_jenis_permohonan)->where('id_file', $id_file_master_surat)->get()->getRowArray();
            if ($oldSurat && $pivotSurat) {
                $db->table('t_file_permohonan_magang')->where('id_file_permohonan_magang', $oldSurat['id_file_permohonan_magang'])->update(['id_file_permohonan' => $pivotSurat['id_file_permohonan']]);
            }
            
            $oldCv = $db->table('t_file_permohonan_magang')
                        ->join('m_file_permohonan', 'm_file_permohonan.id_file_permohonan = t_file_permohonan_magang.id_file_permohonan')
                        ->where('t_file_permohonan_magang.id_permohonan_magang', $id_permohonan)
                        ->whereIn('m_file_permohonan.id_file', [3,4,7])
                        ->select('t_file_permohonan_magang.id_file_permohonan_magang')
                        ->get()->getRowArray();
            $id_file_master_cv = 3;
            if ($id_jenis_permohonan == '1') $id_file_master_cv = 4;
            if ($id_jenis_permohonan == '4') $id_file_master_cv = 7;
            
            $pivotCv = $db->table('m_file_permohonan')->where('id_jenis_permohonan', $id_jenis_permohonan)->where('id_file', $id_file_master_cv)->get()->getRowArray();
            if ($oldCv && $pivotCv) {
                $db->table('t_file_permohonan_magang')->where('id_file_permohonan_magang', $oldCv['id_file_permohonan_magang'])->update(['id_file_permohonan' => $pivotCv['id_file_permohonan']]);
            }
        }

        $fileSurat = $this->request->getFile('surat_pengantar'); 
        if ($fileSurat && $fileSurat->isValid() && !$fileSurat->hasMoved()) {
            $namaSuratBaru = $fileSurat->getRandomName();
            $fileSurat->move(FCPATH . 'uploads/dokumen', $namaSuratBaru);
            $id_file_master = 2; 
            if ($id_jenis_permohonan == '1') $id_file_master = 1;
            if ($id_jenis_permohonan == '2') $id_file_master = 5;
            if ($id_jenis_permohonan == '4') $id_file_master = 6;

            $pivot = $db->table('m_file_permohonan')->where('id_jenis_permohonan', $id_jenis_permohonan)->where('id_file', $id_file_master)->get()->getRowArray();
            if ($pivot) {
                $oldSurats = $db->table('t_file_permohonan_magang')->where('id_permohonan_magang', $id_permohonan)->where('id_file_permohonan', $pivot['id_file_permohonan'])->get()->getResultArray();
                if($oldSurats) {
                    foreach($oldSurats as $os) {
                        if(file_exists(FCPATH . $os['path_file'])) {
                            unlink(FCPATH . $os['path_file']);
                        }
                        $db->table('t_file_permohonan_magang')->where('id_file_permohonan_magang', $os['id_file_permohonan_magang'])->delete();
                    }
                }

                $db->table('t_file_permohonan_magang')->insert([
                    'id_permohonan_magang' => $id_permohonan,
                    'id_file_permohonan'   => $pivot['id_file_permohonan'], 
                    'nama_file'            => preg_replace('/[^a-zA-Z0-9-_\.]/', '_', $fileSurat->getClientName()), // ANTI XSS
                    'path_file'            => 'uploads/dokumen/' . $namaSuratBaru,
                    'created_at'           => date('Y-m-d H:i:s')
                ]);
            }
        }

        if ($id_jenis_permohonan !== '2') {
            $fileKedua = $this->request->getFile('cv'); 
            if ($fileKedua && $fileKedua->isValid() && !$fileKedua->hasMoved()) {
                $namaFileKeduaBaru = $fileKedua->getRandomName();
                $fileKedua->move(FCPATH . 'uploads/dokumen', $namaFileKeduaBaru);
                $id_file_kedua_master = 3; 
                if ($id_jenis_permohonan == '1') $id_file_kedua_master = 4;
                if ($id_jenis_permohonan == '4') $id_file_kedua_master = 7;

                $pivotKedua = $db->table('m_file_permohonan')->where('id_jenis_permohonan', $id_jenis_permohonan)->where('id_file', $id_file_kedua_master)->get()->getRowArray();
                if ($pivotKedua) {
                    $oldCvs = $db->table('t_file_permohonan_magang')->where('id_permohonan_magang', $id_permohonan)->where('id_file_permohonan', $pivotKedua['id_file_permohonan'])->get()->getResultArray();
                    if($oldCvs) {
                        foreach($oldCvs as $oc) {
                            if(file_exists(FCPATH . $oc['path_file'])) {
                                unlink(FCPATH . $oc['path_file']);
                            }
                            $db->table('t_file_permohonan_magang')->where('id_file_permohonan_magang', $oc['id_file_permohonan_magang'])->delete();
                        }
                    }

                    $db->table('t_file_permohonan_magang')->insert([
                        'id_permohonan_magang' => $id_permohonan,
                        'id_file_permohonan'   => $pivotKedua['id_file_permohonan'], 
                        'nama_file'            => preg_replace('/[^a-zA-Z0-9-_\.]/', '_', $fileKedua->getClientName()), // ANTI XSS
                        'path_file'            => 'uploads/dokumen/' . $namaFileKeduaBaru,
                        'created_at'           => date('Y-m-d H:i:s')
                    ]);
                }
            }
        } elseif ($id_jenis_permohonan == '2') {
            $oldCvObsArr = $db->table('t_file_permohonan_magang')
                           ->join('m_file_permohonan', 'm_file_permohonan.id_file_permohonan = t_file_permohonan_magang.id_file_permohonan')
                           ->where('t_file_permohonan_magang.id_permohonan_magang', $id_permohonan)
                           ->whereIn('m_file_permohonan.id_file', [3,4,7])
                           ->select('t_file_permohonan_magang.*')
                           ->get()->getResultArray();
            if ($oldCvObsArr) {
                foreach($oldCvObsArr as $cvObs) {
                    if(file_exists(FCPATH . $cvObs['path_file'])) unlink(FCPATH . $cvObs['path_file']);
                    $db->table('t_file_permohonan_magang')->where('id_file_permohonan_magang', $cvObs['id_file_permohonan_magang'])->delete();
                }
            }
        }

        // 3. Upload File KTM (if any replacement)
        $fileKtm = $this->request->getFile('ktm'); 
        if ($fileKtm && $fileKtm->isValid() && !$fileKtm->hasMoved()) {
            $namaKtmBaru = $fileKtm->getRandomName();
            $fileKtm->move(FCPATH . 'uploads/dokumen', $namaKtmBaru);

            $id_file_ktm_master = 11; // KTM

            $pivotKtm = $db->table('m_file_permohonan')
                        ->where('id_jenis_permohonan', $id_jenis_permohonan)
                        ->where('id_file', $id_file_ktm_master)
                        ->get()->getRowArray();

            if ($pivotKtm) {
                // Delete old KTM if exists
                $oldKtm = $db->table('t_file_permohonan_magang')
                            ->where('id_permohonan_magang', $id_permohonan)
                            ->where('id_file_permohonan', $pivotKtm['id_file_permohonan'])
                            ->get()->getResultArray();
                if($oldKtm) {
                    foreach($oldKtm as $ok) {
                        if(file_exists(FCPATH . $ok['path_file'])) {
                            unlink(FCPATH . $ok['path_file']);
                        }
                        $db->table('t_file_permohonan_magang')->where('id_file_permohonan_magang', $ok['id_file_permohonan_magang'])->delete();
                    }
                }

                $db->table('t_file_permohonan_magang')->insert([
                    'id_permohonan_magang' => $id_permohonan,
                    'id_file_permohonan'   => $pivotKtm['id_file_permohonan'], 
                    'nama_file'            => preg_replace('/[^a-zA-Z0-9-_\.]/', '_', $fileKtm->getClientName()), // ANTI XSS
                    'path_file'            => 'uploads/dokumen/' . $namaKtmBaru,
                    'created_at'           => date('Y-m-d H:i:s')
                ]);
            }
        }

        if ($action_type === 'kirim' && $draft['status_persetujuan'] === null) {
            $db->table('t_persetujuan_magang')->insert([
                'id_permohonan_magang' => $id_permohonan,
                'status_persetujuan'   => 'MENUNGGU',
                'disposisi'            => '0',
                'created_at'           => date('Y-m-d H:i:s')
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat menyimpan permohonan. Coba lagi.');
        }

        if ($draft['status_persetujuan'] === 'PERBAIKAN_BERKAS') {
            $db->table('t_persetujuan_magang')->where('id_permohonan_magang', $id_permohonan)->update([
                'status_persetujuan' => 'MENUNGGU',
                'catatan'            => null,
                'disposisi'          => '0',
                'id_bidang'          => null
            ]);
        }

        if ($action_type === 'draft' && $draft['status_persetujuan'] !== 'PERBAIKAN_BERKAS') {
            catat_log($id_permohonan, 'Mahasiswa', 'Memperbarui Draft', 'Draft permohonan telah diperbarui.');
            return redirect()->to(base_url('mahasiswa/status'))->with('success', 'Perubahan pada Draft berhasil disimpan.');
        } else {
            if ($draft['status_persetujuan'] === 'PERBAIKAN_BERKAS') {
                catat_log($id_permohonan, 'Mahasiswa', 'Mengirim Ulang Revisi Berkas', 'Mahasiswa telah memperbaiki berkas/data sesuai catatan Sekretariat.');
            } else {
                catat_log($id_permohonan, 'Mahasiswa', 'Mengirim Permohonan', 'Draft permohonan telah dikirim dan menunggu verifikasi Sekretariat.');
            }
            return redirect()->to(base_url('mahasiswa/status'))->with('success', 'Permohonan berhasil dikirim dan sedang dalam proses verifikasi.');
        }
    }
}
