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
        
        // Fetch data pribadi dan instansi untuk Review
        $mhs = $db->table('m_mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->get()->getRowArray();
        $instansi = $db->table('t_instansi_mahasiswa')
            ->select('t_instansi_mahasiswa.*, m_instansi_pendidikan.instansi_pendidikan, m_fakultas.fakultas, m_prodi.nama_prodi as prodi, m_kelas.nama_kelas as kelas, m_jenjang_pendidikan.nama_jenjang as jenjang_pendidikan')
            ->join('m_instansi_pendidikan', 'm_instansi_pendidikan.id_instansi_pendidikan = t_instansi_mahasiswa.id_instansi_pendidikan', 'left')
            ->join('m_jenjang_pendidikan', 'm_jenjang_pendidikan.id_jenjang_pendidikan = t_instansi_mahasiswa.id_jenjang_pendidikan', 'left')
            ->join('m_prodi', 'm_prodi.id_prodi = t_instansi_mahasiswa.id_prodi', 'left')
            ->join('m_fakultas', 'm_fakultas.id_fakultas = m_prodi.id_fakultas', 'left')
            ->join('m_kelas', 'm_kelas.id_kelas = t_instansi_mahasiswa.id_kelas', 'left')
            ->where('t_instansi_mahasiswa.id_mahasiswa', $id_mahasiswa)
            ->get()->getRowArray();

        if (isset($instansi['id_jenjang_pendidikan']) && $instansi['id_jenjang_pendidikan']) {
            $data['jenis_permohonan'] = $db->table('m_jenis_permohonan')
                ->select('m_jenis_permohonan.*')
                ->join('m_jenis_permohonan_jenjang', 'm_jenis_permohonan_jenjang.id_jenis_permohonan = m_jenis_permohonan.id_jenis_permohonan')
                ->where('m_jenis_permohonan_jenjang.id_jenjang_pendidikan', $instansi['id_jenjang_pendidikan'])
                ->distinct()
                ->get()->getResultArray();
        } else {
            $data['jenis_permohonan'] = [];
        }

        $data['title']            = 'Form Permohonan Magang';
        $data['nama']             = session()->get('nama') ?? 'Mahasiswa';

        $data['mhs'] = $mhs;
        $data['instansi'] = $instansi;
        $stateData = $this->_getMahasiswaState($id_mahasiswa);

        // Jika ada draf atau revisi berkas yang sedang berjalan, load data draft
        $data['draft'] = null;
        if (!empty($stateData['permohonan_aktif'])) {
            $aktif = $stateData['permohonan_aktif'];
            if ($aktif['status_persetujuan'] === 'PERBAIKAN_BERKAS' || $aktif['posting_data'] === 'draft') {
                $data['draft'] = $this->_loadDraftData($aktif['id_permohonan_magang'], $id_mahasiswa);
            }
        }

        $data['state']            = $stateData['state'];
        $data['is_log_book']      = $stateData['is_log_book'];
        $data['jenis_permohonan_aktif'] = $stateData['jenis_permohonan'];
        $data['permohonan_aktif'] = $stateData['permohonan_aktif'];

        // Dapatkan data bulan yang kuotanya sudah penuh
        $kuotaModel = new \App\Models\KuotaBidangModel();
        $data['bulan_penuh'] = $kuotaModel->getBulanPenuhGlobal(date('Y'));

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
            'deskripsi' => [
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

        $action_type = $this->request->getPost('action_type');

        // Jika simpan draft, tidak wajib mengunggah file
        $is_draft = ($action_type === 'draft');

        if ($this->request->getPost('id_jenis_permohonan') !== '2') {
            $rules['cv'] = [
                'rules'  => ($is_draft ? '' : 'uploaded[cv]|') . 'max_size[cv,2048]|ext_in[cv,pdf]|mime_in[cv,application/pdf]',
                'errors' => [
                    'uploaded' => 'Berkas CV / Proposal wajib diunggah.',
                    'max_size' => 'Ukuran CV / Proposal terlalu besar, maksimal 2MB.',
                    'ext_in'   => 'CV / Proposal harus berformat PDF.',
                    'mime_in'  => 'Berkas CV / Proposal terdeteksi bukan file PDF asli.'
                ]
            ];
        }

        // Modifikasi rule untuk surat_pengantar dan ktm berdasarkan is_draft
        if ($is_draft) {
            $rules['surat_pengantar']['rules'] = 'max_size[surat_pengantar,2048]|ext_in[surat_pengantar,pdf]|mime_in[surat_pengantar,application/pdf]';
            $rules['ktm']['rules'] = 'max_size[ktm,2048]|ext_in[ktm,pdf,jpg,jpeg,png]|mime_in[ktm,application/pdf,image/jpeg,image/png]';
            
            // Draft juga tidak mewajibkan tanggal dan teks jika belum diisi,
            // tapi karena aturan ini di form bisa required, lebih aman dilepas requirement nya untuk draft.
            $rules['id_jenis_permohonan']['rules'] = 'permit_empty';
            $rules['deskripsi_keahlian']['rules'] = 'permit_empty';
            $rules['deskripsi']['rules'] = 'permit_empty';
            $rules['tgl_mulai']['rules'] = 'permit_empty';
            $rules['tgl_selesai']['rules'] = 'permit_empty';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        
        $id_jenis_permohonan = $this->request->getPost('id_jenis_permohonan');
        
        // Backend Validation: Cek apakah id_jenis_permohonan valid untuk jenjang pendidikan mahasiswa
        $mhsValid = $db->table('m_mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->get()->getRowArray();
        $id_instansi_mhs = $mhsValid['id_instansi_mahasiswa'] ?? 0;
        
        if ($id_instansi_mhs) {
            $instValid = $db->table('t_instansi_mahasiswa')->where('id_instansi_mahasiswa', $id_instansi_mhs)->get()->getRowArray();
            $id_jenjang = $instValid['id_jenjang_pendidikan'] ?? null;
            
            if ($id_jenjang) {
                $isValidJenis = $db->table('m_jenis_permohonan_jenjang')
                    ->where('id_jenis_permohonan', $id_jenis_permohonan)
                    ->where('id_jenjang_pendidikan', $id_jenjang)
                    ->countAllResults();
                    
                if ($isValidJenis === 0) {
                    return redirect()->back()->withInput()->with('error', 'Jenis permohonan yang dipilih tidak tersedia atau tidak sesuai dengan jenjang pendidikan Anda.');
                }
            } else {
                return redirect()->back()->withInput()->with('error', 'Data jenjang pendidikan Anda belum lengkap.');
            }
        }

        // Backend Validation: Cek apakah bulan dari tanggal mulai sudah penuh kuotanya
        $tgl_mulai = $this->request->getPost('tgl_mulai');
        if ($tgl_mulai) {
            $bulanMulai = (int)date('n', strtotime($tgl_mulai));
            $tahunMulai = (int)date('Y', strtotime($tgl_mulai));
            
            $kuotaModel = new \App\Models\KuotaBidangModel();
            $bulanPenuh = $kuotaModel->getBulanPenuhGlobal($tahunMulai);
            
            if (in_array($bulanMulai, $bulanPenuh)) {
                $nama_bulan = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ];
                return redirect()->back()->withInput()->with('error', 'Maaf, kuota untuk bulan ' . $nama_bulan[$bulanMulai] . ' ' . $tahunMulai . ' sudah penuh secara keseluruhan. Silakan pilih tanggal mulai di bulan lain.');
            }
        }

        $tglMulai = $this->request->getPost('tgl_mulai');
        $tglSelesai = $this->request->getPost('tgl_selesai');
        
        if ($tglMulai && $tglSelesai) {
            $dateMulai = new \DateTime($tglMulai);
            $dateSelesai = new \DateTime($tglSelesai);
            
            $dateMulai->setTime(0,0,0);
            $dateSelesai->setTime(0,0,0);

            // Ambil konfigurasi tanggal dari database (source of truth)
            $db = \Config\Database::connect();
            $jenisConfig = $db->table('m_jenis_permohonan')
                ->where('id_jenis_permohonan', $id_jenis_permohonan)
                ->get()->getRowArray();

            $maksHariPengajuan  = (int)($jenisConfig['maksimal_hari_pengajuan'] ?? 0);
            if ($maksHariPengajuan == 0) $maksHariPengajuan = 30; // Fallback 1 bulan
            $durasiMinimal      = (int)($jenisConfig['durasi_minimal'] ?? 0);
            if ($durasiMinimal == 0) $durasiMinimal = 59; // Fallback ~2 bulan
            $maksimalPermohonan = (int)($jenisConfig['maksimal_permohonan'] ?? 0);

            $today = new \DateTime();
            $today->setTime(0,0,0);

            // Validasi tanggal mulai: harus >= hari_ini + maksimal_hari_pengajuan
            $minMulai = clone $today;
            $minMulai->modify('+' . $maksHariPengajuan . ' days');

            if ($dateMulai < $minMulai) {
                return redirect()->back()->withInput()->with('errors', [
                    'tgl_mulai' => 'Tanggal mulai minimal ' . $maksHariPengajuan . ' hari dari tanggal pengajuan hari ini.'
                ]);
            }
            
            if ($maksimalPermohonan > 0) {
                $maxMulai = clone $today;
                $maxMulai->modify('+' . $maksimalPermohonan . ' days');
                if ($dateMulai > $maxMulai) {
                    return redirect()->back()->withInput()->with('errors', [
                        'tgl_mulai' => 'Tanggal mulai maksimal ' . $maksimalPermohonan . ' hari dari tanggal pengajuan hari ini.'
                    ]);
                }
            }

            // Validasi tanggal selesai: harus >= tanggal_mulai + durasi_minimal
            if ($dateSelesai < $dateMulai) {
                return redirect()->back()->withInput()->with('errors', [
                    'tgl_selesai' => 'Tanggal selesai tidak boleh mendahului tanggal mulai.'
                ]);
            }

            if ($durasiMinimal > 0) {
                $minSelesai = clone $dateMulai;
                $minSelesai->modify('+' . $durasiMinimal . ' days');
                if ($dateSelesai < $minSelesai) {
                    return redirect()->back()->withInput()->with('errors', [
                        'tgl_selesai' => 'Durasi kegiatan minimal adalah ' . $durasiMinimal . ' hari.'
                    ]);
                }
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
            'rencana_kegiatan'      => esc($deskripsi),
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
            if ($id_jenis_permohonan == '5') $id_file_master = 1;

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
            if ($id_jenis_permohonan == '5') $id_file_ktm_master = 12; // Kartu Pelajar

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
            catat_log($id_permohonan_baru, 'Mahasiswa', 'Menyimpan Draf', 'Permohonan berhasil disimpan sebagai draf dan belum dikirimkan.');
            session()->setFlashdata('success', 'Permohonan berhasil disimpan sebagai Draft.');
            return redirect()->to(base_url('mahasiswa/status'));
        } else {
            catat_log($id_permohonan_baru, 'Mahasiswa', 'Mengirimkan Permohonan', 'Permohonan berhasil dikirim dan sedang menunggu verifikasi oleh Sekretariat.');
            session()->setFlashdata('permohonan_sent', true);
            session()->setFlashdata('success', 'Permohonan dan berkas PDF berhasil terkirim dan tercatat di sistem.');
            return redirect()->to(base_url('mahasiswa/status'));
        }
    }

    private function _loadDraftData($id_permohonan, $id_mahasiswa)
    {
        $db = \Config\Database::connect();
        $draft = $db->table('t_permohonan_magang')
                    ->select('t_permohonan_magang.*, t_persetujuan_magang.status_persetujuan, t_persetujuan_magang.catatan as catatan_sekretariat')
                    ->join('t_persetujuan_magang', 't_persetujuan_magang.id_permohonan_magang = t_permohonan_magang.id_permohonan_magang', 'left')
                    ->where('t_permohonan_magang.id_permohonan_magang', $id_permohonan)
                    ->where('t_permohonan_magang.id_mahasiswa', $id_mahasiswa)
                    ->get()->getRowArray();
                                       
        if (!$draft) return null;

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
                } elseif (in_array($pivot['id_file'], [11, 12])) {
                    $draft['ktm'] = $f['path_file'];
                    $draft['nama_ktm'] = $f['nama_file'];
                }
            }
        }
        return $draft;
    }

    public function editPermohonan($id_permohonan)
    {
        // Redirect to main form to prevent 2 views architecture
        return redirect()->to(base_url('mahasiswa/permohonan'));
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
        
        $statusAwal = $draft['status_persetujuan'];

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
                     ->whereIn('m_file_permohonan.id_file', [11, 12])
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
        
        // Backend Validation: Cek apakah id_jenis_permohonan valid untuk jenjang pendidikan mahasiswa
        $mhsValid = $db->table('m_mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->get()->getRowArray();
        $id_instansi_mhs = $mhsValid['id_instansi_mahasiswa'] ?? 0;
        
        if ($id_instansi_mhs) {
            $instValid = $db->table('t_instansi_mahasiswa')->where('id_instansi_mahasiswa', $id_instansi_mhs)->get()->getRowArray();
            $id_jenjang = $instValid['id_jenjang_pendidikan'] ?? null;
            
            if ($id_jenjang) {
                $isValidJenis = $db->table('m_jenis_permohonan_jenjang')
                    ->where('id_jenis_permohonan', $id_jenis_permohonan)
                    ->where('id_jenjang_pendidikan', $id_jenjang)
                    ->countAllResults();
                    
                if ($isValidJenis === 0) {
                    return redirect()->back()->withInput()->with('error', 'Jenis permohonan yang dipilih tidak tersedia atau tidak sesuai dengan jenjang pendidikan Anda.');
                }
            } else {
                return redirect()->back()->withInput()->with('error', 'Data jenjang pendidikan Anda belum lengkap.');
            }
        }

        // Backend Validation: Cek apakah bulan dari tanggal mulai sudah penuh kuotanya
        $tgl_mulai_baru = $this->request->getPost('tgl_mulai');
        if ($tgl_mulai_baru) {
            $bulanMulaiBaru = (int)date('n', strtotime($tgl_mulai_baru));
            $tahunMulaiBaru = (int)date('Y', strtotime($tgl_mulai_baru));
            
            $kuotaModel = new \App\Models\KuotaBidangModel();
            $bulanPenuh = $kuotaModel->getBulanPenuhGlobal($tahunMulaiBaru);
            
            if (in_array($bulanMulaiBaru, $bulanPenuh)) {
                $nama_bulan = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ];
                return redirect()->back()->withInput()->with('error', 'Maaf, kuota untuk bulan ' . $nama_bulan[$bulanMulaiBaru] . ' ' . $tahunMulaiBaru . ' sudah penuh secara keseluruhan. Silakan pilih tanggal mulai di bulan lain.');
            }
        }

        $tglMulai = $this->request->getPost('tgl_mulai');
        $tglSelesai = $this->request->getPost('tgl_selesai');
        if ($tglMulai && $tglSelesai) {
            $dateMulai = new \DateTime($tglMulai);
            $dateSelesai = new \DateTime($tglSelesai);
            
            $dateMulai->setTime(0,0,0);
            $dateSelesai->setTime(0,0,0);

            // Ambil konfigurasi tanggal dari database (source of truth)
            $jenisConfig = $db->table('m_jenis_permohonan')
                ->where('id_jenis_permohonan', $id_jenis_permohonan)
                ->get()->getRowArray();

            $maksHariPengajuan  = (int)($jenisConfig['maksimal_hari_pengajuan'] ?? 0);
            if ($maksHariPengajuan == 0) $maksHariPengajuan = 30; // Fallback 1 bulan
            $durasiMinimal      = (int)($jenisConfig['durasi_minimal'] ?? 0);
            if ($durasiMinimal == 0) $durasiMinimal = 59; // Fallback ~2 bulan
            $maksimalPermohonan = (int)($jenisConfig['maksimal_permohonan'] ?? 0);

            $today = new \DateTime();
            $today->setTime(0,0,0);

            // Validasi tanggal mulai: harus >= hari_ini + maksimal_hari_pengajuan
            $minMulai = clone $today;
            $minMulai->modify('+' . $maksHariPengajuan . ' days');

            if ($dateMulai < $minMulai) {
                return redirect()->back()->withInput()->with('errors', [
                    'tgl_mulai' => 'Tanggal mulai minimal ' . $maksHariPengajuan . ' hari dari tanggal pengajuan hari ini.'
                ]);
            }

            if ($maksimalPermohonan > 0) {
                $maxMulai = clone $today;
                $maxMulai->modify('+' . $maksimalPermohonan . ' days');
                if ($dateMulai > $maxMulai) {
                    return redirect()->back()->withInput()->with('errors', [
                        'tgl_mulai' => 'Tanggal mulai maksimal ' . $maksimalPermohonan . ' hari dari tanggal pengajuan hari ini.'
                    ]);
                }
            }

            // Validasi tanggal selesai: harus >= tanggal_mulai + durasi_minimal
            if ($dateSelesai < $dateMulai) {
                return redirect()->back()->withInput()->with('errors', [
                    'tgl_selesai' => 'Tanggal selesai tidak boleh mendahului tanggal mulai.'
                ]);
            }

            if ($durasiMinimal > 0) {
                $minSelesai = clone $dateMulai;
                $minSelesai->modify('+' . $durasiMinimal . ' days');
                if ($dateSelesai < $minSelesai) {
                    return redirect()->back()->withInput()->with('errors', [
                        'tgl_selesai' => 'Durasi kegiatan minimal adalah ' . $durasiMinimal . ' hari.'
                    ]);
                }
            }
        }

        $db->transStart();

        $action_type = $this->request->getPost('action_type') === 'draft' ? 'draft' : 'kirim';
        $id_jenis_permohonan = $this->request->getPost('id_jenis_permohonan');

        $dataPermohonan = [
            'id_jenis_permohonan' => $id_jenis_permohonan,
            'deskripsi_keahlian'  => esc($this->request->getPost('deskripsi_keahlian')), // ANTI XSS
            'rencana_kegiatan'    => esc($this->request->getPost('deskripsi')),
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
            if ($id_jenis_permohonan == '5') $id_file_master_surat = 1;
            
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
            if ($id_jenis_permohonan == '5') $id_file_master = 1;

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
            if ($id_jenis_permohonan == '5') $id_file_ktm_master = 12; // Kartu Pelajar

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
                'disposisi'          => 'BELUM',
                'id_bidang'          => null
            ]);
        }

        if ($action_type === 'draft') {
            catat_log($id_permohonan, 'Mahasiswa', 'Memperbarui Draf', 'Draf permohonan berhasil diperbarui.');
            return redirect()->to(base_url('mahasiswa/status'))->with('success', 'Perubahan pada Draft berhasil disimpan.');
        } else {
            if ($statusAwal === 'PERBAIKAN_BERKAS') {
                catat_log($id_permohonan, 'Mahasiswa', 'Mengirimkan Perbaikan Berkas', 'Berkas yang perlu diperbaiki telah dikirim ulang dan sedang menunggu verifikasi Sekretariat.');
            } else {
                catat_log($id_permohonan, 'Mahasiswa', 'Mengirimkan Permohonan', 'Permohonan berhasil dikirim dan sedang menunggu verifikasi oleh Sekretariat.');
            }
            return redirect()->to(base_url('mahasiswa/status'))->with('success', 'Permohonan berhasil dikirim dan sedang dalam proses verifikasi.');
        }
    }
}
