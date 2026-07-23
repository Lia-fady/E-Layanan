<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;
use App\Models\M_PermohonanMagang;
use App\Models\M_LogbookMagang;
use App\Models\M_PenempatanMagang;

class C_Mahasiswa extends BaseController
{
    protected $permohonanModel;
    protected $logbookModel;
    protected $penempatanModel;

    public function __construct()
    {
        // Inisialisasi semua model secara rapi sesuai standar MVC
        $this->permohonanModel = new M_PermohonanMagang();
        $this->logbookModel    = new M_LogbookMagang();
        $this->penempatanModel = new M_PenempatanMagang();
    }

    /**
     * 1. MENAMPILKAN HALAMAN DASHBOARD UTAMA MAHASISWA
     */
    public function dashboard()
    {
        $id_mahasiswa = session()->get('id_mahasiswa');
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        $stateData = $this->_getMahasiswaState($id_mahasiswa);
        $db = \Config\Database::connect();

        // --- Hitung statistik logbook & absensi secara dinamis ---
        $total_logbook  = 0;
        $target_logbook = 0;
        $total_hadir    = 0;
        $target_hadir   = 0;
        $nilai_akhir    = '-';
        $predikat_akhir = 'Belum Ada';

        if ($stateData['state'] >= 4) {
            $penempatan = $this->logbookModel->cekPenempatanAktif($id_mahasiswa);

            if ($penempatan) {
                $id_penempatan = $penempatan['id_penempatan_magang'];

                // Total entri logbook yang sudah dibuat mahasiswa
                $total_logbook = $db->table('t_logbook_magang')
                    ->where('id_penempatan_magang', $id_penempatan)
                    ->countAllResults();

                // Target logbook = durasi hari kerja (Senin-Jumat) selama periode penempatan
                $permohonan_aktif = $stateData['permohonan_aktif'];
                if (!empty($permohonan_aktif['tgl_mulai']) && !empty($permohonan_aktif['tgl_selesai'])) {
                    $start = new \DateTime($permohonan_aktif['tgl_mulai']);
                    $end   = new \DateTime($permohonan_aktif['tgl_selesai']);
                    $end->modify('+1 day');
                    $interval  = new \DateInterval('P1D');
                    $dateRange = new \DatePeriod($start, $interval, $end);
                    foreach ($dateRange as $date) {
                        $dow = (int) $date->format('N');
                        if ($dow <= 5) $target_logbook++;
                    }
                }

                // Absensi = logbook yang sudah disetujui (disetujui_oleh tidak null)
                $total_hadir = $db->table('t_logbook_magang')
                    ->where('id_penempatan_magang', $id_penempatan)
                    ->where('disetujui_oleh IS NOT NULL', null, false)
                    ->countAllResults();
                $target_hadir = $total_logbook; // Target = total entri yang sudah dibuat

                // Nilai akhir jika state selesai
                if ($stateData['state'] == 5) {
                    // Penilaian belum diimplementasikan di database saat ini.
                    // Jika nantinya ada tabel t_nilai_magang, integrasikan di sini.
                    $nilai_akhir = '-';
                    $predikat_akhir = 'Selesai Magang';
                }
            }
        }

        // Ambil dokumen surat penerimaan & sertifikat (jika ada)
        $file_penerimaan = null;
        $file_sertifikat = null;
        $file_piagam = null;
        if (!empty($stateData['permohonan_aktif']) && isset($stateData['permohonan_aktif']['id_persetujuan_magang'])) {
            $dokumen = $db->table('t_file_proses_magang')
                ->where('id_persetujuan_magang', $stateData['permohonan_aktif']['id_persetujuan_magang'])
                ->get()->getResultArray();
                
            foreach ($dokumen as $d) {
                if ($d['id_file'] == 8) {
                    $file_penerimaan = $d['path_file'];
                } elseif ($d['id_file'] == 9) {
                    $file_sertifikat = $d['path_file']; // Tetap dipakai untuk backward compatibility view
                } elseif ($d['id_file'] == 10) {
                    $file_piagam = $d['path_file'];
                }
            }
        }

        $data = [
            'title'            => 'Dashboard Mahasiswa',
            'nama'             => session()->get('nama') ?? 'Mahasiswa',
            'nim'              => session()->get('nim') ?? '-',
            'kampus'           => session()->get('kampus') ?? '-',
            'state'            => $stateData['state'],
            'is_log_book'      => $stateData['is_log_book'],
            'jenis_permohonan' => $stateData['jenis_permohonan'],
            'catatan_tolak'    => $stateData['catatan'],
            'permohonan_aktif' => $stateData['permohonan_aktif'],
            'total_logbook'    => $total_logbook,
            'target_logbook'   => $target_logbook,
            'total_hadir'      => $total_hadir,
            'target_hadir'     => $target_hadir,
            'nilai_akhir'      => $nilai_akhir,
            'predikat_akhir'   => $predikat_akhir,
            'file_penerimaan'  => $file_penerimaan,
            'file_sertifikat'  => $file_sertifikat,
            'file_piagam'      => $file_piagam,
        ];

        return view('mahasiswa/v_dashboard', $data);
    }

    /**
     * 2. MENAMPILKAN HALAMAN FORM PERMOHONAN MAGANG
     */
    // ======================================================================
    // 1. TAMPILAN FORM PERMOHONAN MAGANG
    // ======================================================================
    public function permohonan()
    {
        $id_mahasiswa = session()->get('id_mahasiswa');
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        $db = \Config\Database::connect();
        
        // Mengambil data master jenis permohonan aktif dari database untuk dropdown
        $data['jenis_permohonan'] = $db->table('m_jenis_permohonan')->where('status', 'aktif')->get()->getResultArray();
        $data['title']            = 'Form Permohonan Magang';
        $data['nama']             = session()->get('nama') ?? 'Mahasiswa';
        
        $stateData = $this->_getMahasiswaState($id_mahasiswa);
        $data['state']            = $stateData['state'];
        $data['is_log_book']      = $stateData['is_log_book'];
        $data['jenis_permohonan_aktif'] = $stateData['jenis_permohonan'];
        $data['permohonan_aktif'] = $stateData['permohonan_aktif'];

        return view('mahasiswa/v_permohonan', $data);
    }

    // ======================================================================
    // 2. LOGIKA SIMPAN PERMOHONAN + FORM VALIDATION CI4 (REKOMENDASI PEMBIMBING)
    // ======================================================================
  public function simpanPermohonan()
    {
        $id_mahasiswa = session()->get('id_mahasiswa'); 
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'))->with('error', 'Sesi Anda telah habis. Silakan login kembali.');
        }

        // ----------------------------------------------------------------------
        // 1. BENTENG ATURAN VALIDASI FORM (FORM VALIDATION CI4 REKOMENDASI PEMBIMBING)
        // ----------------------------------------------------------------------
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
            'deskripsi_magang' => [
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
            ]
        ];

        // Jika jenis permohonan BUKAN Observasi (bukan ID 2), berkas CV wajib diunggah & divalidasi
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

        // Jalankan pengecekan validasi CI4
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // VALIDASI CUSTOM: Durasi Magang Minimal 60 Hari
        $tglMulai = $this->request->getPost('tgl_mulai');
        $tglSelesai = $this->request->getPost('tgl_selesai');
        if ($tglMulai && $tglSelesai) {
            $dateMulai = new \DateTime($tglMulai);
            $dateSelesai = new \DateTime($tglSelesai);
            $diff = $dateMulai->diff($dateSelesai);
            
            if ($diff->invert || $diff->days < 60) {
                return redirect()->back()->withInput()->with('errors', [
                    'tgl_selesai' => 'Durasi permohonan magang minimal adalah 2 bulan (60 hari) dari tanggal mulai.'
                ]);
            }
        }

        // ----------------------------------------------------------------------
        // 2. JIKA LOLOS VALIDASI, PROSES DATABASE TRANSACTION BERLANGSUNG
        // ----------------------------------------------------------------------
        $db = \Config\Database::connect();

        $id_jenis_permohonan = $this->request->getPost('id_jenis_permohonan');
        $tgl_mulai           = $this->request->getPost('tgl_mulai');
        $tgl_selesai         = $this->request->getPost('tgl_selesai');
        $deskripsi_keahlian  = $this->request->getPost('deskripsi_keahlian');
        $deskripsi_magang    = $this->request->getPost('deskripsi_magang');

        $mhs = $db->table('m_mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->get()->getRowArray();
        $id_instansi_mahasiswa = $mhs['id_instansi_mahasiswa'] ?? 1;

        // Mulai transaksi database agar aman berantai
        $db->transStart();

        // Tangkap action_type (draft atau kirim), default kirim untuk fallback aman
        $action_type = $this->request->getPost('action_type') === 'draft' ? 'draft' : 'kirim';

        // Simpan data utama ke t_permohonan_magang
        $dataPermohonan = [
            'id_mahasiswa'          => $id_mahasiswa,
            'id_instansi_mahasiswa' => $id_instansi_mahasiswa,
            'id_jenis_permohonan'   => $id_jenis_permohonan,
            'deskripsi_keahlian'    => $deskripsi_keahlian,
            'deskripsi_magang'      => $deskripsi_magang,
            'tgl_mulai'             => $tgl_mulai,
            'tgl_selesai'           => $tgl_selesai,
            'posting_data'          => $action_type,
            'created_at'            => date('Y-m-d H:i:s')
        ];
        
        $this->permohonanModel->insert($dataPermohonan);
        $id_permohonan_baru = $this->permohonanModel->getInsertID(); 

        // Proses Berkas 1: Surat Pengantar
        $fileSurat = $this->request->getFile('surat_pengantar'); 
        if ($fileSurat && $fileSurat->isValid() && !$fileSurat->hasMoved()) {
            $namaSuratBaru = $fileSurat->getRandomName();
            $fileSurat->move(FCPATH . 'uploads/dokumen', $namaSuratBaru);

            $id_file_master = 2; // Default Magang (3) -> Surat
            if ($id_jenis_permohonan == '1') $id_file_master = 1; // Skripsi -> Surat
            if ($id_jenis_permohonan == '2') $id_file_master = 5; // Observasi -> Surat
            if ($id_jenis_permohonan == '4') $id_file_master = 6; // Uji Coba -> Surat

            // Cari id_file_permohonan yang sesuai dengan jenis_permohonan dan file master
            $pivot = $db->table('m_file_permohonan')
                        ->where('id_jenis_permohonan', $id_jenis_permohonan)
                        ->where('id_file', $id_file_master)
                        ->get()->getRowArray();

            if ($pivot) {
                $db->table('t_file_permohonan_magang')->insert([
                    'id_permohonan_magang' => $id_permohonan_baru,
                    'id_file_permohonan'   => $pivot['id_file_permohonan'], 
                    'nama_file'            => $fileSurat->getClientName(),
                    'path_file'            => 'uploads/dokumen/' . $namaSuratBaru,
                    'created_at'           => date('Y-m-d H:i:s')
                ]);
            }
        }

        // Proses Berkas 2: CV / Proposal (Kecuali Observasi)
        if ($id_jenis_permohonan !== '2') {
            $fileKedua = $this->request->getFile('cv'); 
            if ($fileKedua && $fileKedua->isValid() && !$fileKedua->hasMoved()) {
                $namaFileKeduaBaru = $fileKedua->getRandomName();
                $fileKedua->move(FCPATH . 'uploads/dokumen', $namaFileKeduaBaru);

                $id_file_kedua_master = 3; // Default Magang (3) -> CV
                if ($id_jenis_permohonan == '1') $id_file_kedua_master = 4; // Skripsi -> Proposal
                if ($id_jenis_permohonan == '4') $id_file_kedua_master = 7; // Uji Coba -> Proposal

                $pivotKedua = $db->table('m_file_permohonan')
                            ->where('id_jenis_permohonan', $id_jenis_permohonan)
                            ->where('id_file', $id_file_kedua_master)
                            ->get()->getRowArray();

                if ($pivotKedua) {
                    $db->table('t_file_permohonan_magang')->insert([
                        'id_permohonan_magang' => $id_permohonan_baru,
                        'id_file_permohonan'   => $pivotKedua['id_file_permohonan'], 
                        'nama_file'            => $fileKedua->getClientName(),
                        'path_file'            => 'uploads/dokumen/' . $namaFileKeduaBaru,
                        'created_at'           => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }

        // Selesaikan transaksi database
        $db->transComplete();

        if ($db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal memproses pengajuan permohonan magang Anda.');
            return redirect()->back()->withInput();
        }

        if ($action_type === 'draft') {
            session()->setFlashdata('success', 'Permohonan berhasil disimpan sebagai Draft.');
            return redirect()->to(base_url('mahasiswa/status'));
        } else {
            session()->setFlashdata('permohonan_sent', true);
            session()->setFlashdata('success', 'Permohonan dan berkas PDF berhasil terkirim dan tercatat di sistem.');
            return redirect()->to(base_url('mahasiswa/status'));
        }
    }

    /**
     * 4. MENAMPILKAN HALAMAN RIWAYAT & TRACKING STATUS PERMOHONAN (BERSIH & TERSEGMENTASI)
     */
    public function statusPermohonan()
    {
        $id_mahasiswa = session()->get('id_mahasiswa'); 
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $filterStatus = $this->request->getGet('filter_status');
        $filterJenis  = $this->request->getGet('filter_jenis');
        $perPage      = (int) ($this->request->getGet('per_page') ?? 10);
        $currentPage  = $this->request->getGet('page_permohonan') ?? 1; 

        // Query utama dengan join m_file untuk mendukung file dinamis
        $builder = $this->permohonanModel->getStatusPermohonan($id_mahasiswa, $filterStatus);

        // Filter jenis permohonan (jika ada)
        if (!empty($filterJenis)) {
            $builder->where('t_permohonan_magang.id_jenis_permohonan', $filterJenis);
        }

        $totalBuilder = clone $builder; 
        $totalRows    = $totalBuilder->countAllResults(false); 

        $queryPermohonan = $builder
            ->orderBy('t_permohonan_magang.created_at', 'DESC')
            ->limit($perPage, ($currentPage - 1) * $perPage)
            ->get()
            ->getResultArray();

        // Ambil file dokumen untuk setiap permohonan secara dinamis
        $db = \Config\Database::connect();
        foreach ($queryPermohonan as &$p) {
            $p['files'] = $db->table('t_file_permohonan_magang')
                ->select('t_file_permohonan_magang.id_file_permohonan_magang, m_file.nama_file, t_file_permohonan_magang.path_file')
                ->join('m_file_permohonan', 'm_file_permohonan.id_file_permohonan = t_file_permohonan_magang.id_file_permohonan', 'left')
                ->join('m_file', 'm_file.id_file = m_file_permohonan.id_file', 'left')
                ->where('t_file_permohonan_magang.id_permohonan_magang', $p['id_permohonan_magang'])
                ->orderBy('m_file.id_file', 'ASC')
                ->get()->getResultArray();
        }
        unset($p); // Lepas referensi

        $stateData = $this->_getMahasiswaState($id_mahasiswa);

        $data = [
            'title'            => 'Status Permohonan Magang',
            'nama'             => session()->get('nama') ?? 'Mahasiswa',
            'permohonan'       => $queryPermohonan,
            'pager'            => \Config\Services::pager()->makeLinks($currentPage, $perPage, $totalRows, 'default_full', 0, 'permohonan'),
            'state'            => $stateData['state'],
            'is_log_book'      => $stateData['is_log_book'],
            'jenis_permohonan' => $stateData['jenis_permohonan']
        ];

        return view('mahasiswa/v_status', $data);
    }

    /**
     * 5. FUNGSI UNTUK MAHASISWA MEMBATALKAN PERMOHONAN STATUS PENDING
     */
    public function batalkanPermohonan($id_permohonan)
    {
        $id_mahasiswa = session()->get('id_mahasiswa');
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'));
        }

        $db = \Config\Database::connect();
        $cekStatus = $db->table('t_persetujuan_magang')->where('id_permohonan_magang', $id_permohonan)->get()->getRowArray();

        if (!empty($cekStatus) && in_array($cekStatus['status_persetujuan'], ['DISETUJUI', 'DITOLAK'])) {
            session()->setFlashdata('error', 'Permohonan tidak dapat dibatalkan karena sudah diproses oleh tim verifikator.');
            return redirect()->to(base_url('mahasiswa/status'));
        }

        $db->transStart();
            // --- LOGIKA HAPUS FISIK FILE PDF (Unlink) ---
            $fileRecords = $db->table('t_file_permohonan_magang')->where('id_permohonan_magang', $id_permohonan)->get()->getResultArray();
            foreach ($fileRecords as $file) {
                $filePath = FCPATH . $file['path_file'];
                if (file_exists($filePath) && is_file($filePath)) {
                    unlink($filePath); // Menghapus file fisik dari server
                }
            }

            // --- HAPUS DATA DATABASE ---
            $db->table('t_file_permohonan_magang')->where('id_permohonan_magang', $id_permohonan)->delete();
            $this->permohonanModel->where('id_permohonan_magang', $id_permohonan)->where('id_mahasiswa', $id_mahasiswa)->delete();
        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            session()->setFlashdata('error', 'Gagal membatalkan permohonan magang, terjadi kesalahan database.');
        } else {
            session()->setFlashdata('success', 'Permohonan magang Anda berhasil dibatalkan.');
        }

        return redirect()->to(base_url('mahasiswa/status'));
    }

    /**
     * 6. FUNGSI UNTUK INLINE VIEW BROWSER FILE PDF SYARAT DOKUMEN
     * Mendukung dua mode:
     *   - /view-file/{id_file_permohonan_magang}         → dari tampilan file dinamis
     *   - /view-file/{id_permohonan}/{urutan_berkas}     → fallback backward-compatible
     */
    public function viewFile($param1, $param2 = null)
    {
        $id_mahasiswa = session()->get('id_mahasiswa');
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'));
        }

        $db = \Config\Database::connect();

        if ($param2 === null) {
            // --- MODE BARU: param1 = id_file_permohonan_magang ---
            $fileData = $db->table('t_file_permohonan_magang')
                ->where('id_file_permohonan_magang', $param1)
                ->get()->getRowArray();
        } else {
            // --- MODE LAMA: param1 = id_permohonan, param2 = urutan berkas ---
            $listFiles = $db->table('t_file_permohonan_magang')
                ->where('id_permohonan_magang', $param1)
                ->orderBy('id_file_permohonan', 'ASC') 
                ->get()->getResultArray();
            $index    = ($param2 == 'surat' || $param2 == '1') ? 0 : 1;
            $fileData = $listFiles[$index] ?? null;
        }

        if (!empty($fileData)) {
            $filePath = FCPATH . $fileData['path_file']; 
            if (file_exists($filePath)) {
                header("Content-Type: application/pdf");
                header("Content-Disposition: inline; filename=\"" . basename($filePath) . "\"");
                header("Content-Length: " . filesize($filePath));
                readfile($filePath);
                exit;
            }
        }

        session()->setFlashdata('error', 'Berkas PDF fisik tidak ditemukan di direktori server.');
        return redirect()->to(base_url('mahasiswa/status'));
    }

    /**
     * 7. MENAMPILKAN HALAMAN LOGBOOK & ABSENSI MAGANG (SANGAT RINGKAS)
     */
    public function logbook()
    {
        $id_mahasiswa = session()->get('id_mahasiswa'); 
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek penempatan aktif
        $penempatan = $this->logbookModel->cekPenempatanAktif($id_mahasiswa);

        $riwayatLogbook = [];
        if ($penempatan) {
            $id_penempatan = $penempatan['id_penempatan_magang'];

            // Ambil filter dari GET
            $filterPeriode = $this->request->getGet('filter_periode');
            $filterStatus  = $this->request->getGet('filter_status');

            $builder = $this->logbookModel
                ->where('id_penempatan_magang', $id_penempatan);

            // Filter periode
            if ($filterPeriode === 'bulan_ini') {
                $builder->where('MONTH(tgl_logbook)', date('m'))
                        ->where('YEAR(tgl_logbook)', date('Y'));
            } elseif ($filterPeriode === 'minggu_ini') {
                $builder->where('tgl_logbook >=', date('Y-m-d', strtotime('monday this week')))
                        ->where('tgl_logbook <=', date('Y-m-d', strtotime('sunday this week')));
            }

            // Filter status
            if ($filterStatus === 'pending') {
                $builder->where('disetujui_oleh IS NULL', null, false);
            } elseif ($filterStatus === 'disetujui') {
                $builder->where('disetujui_oleh IS NOT NULL', null, false);
            }

            $riwayatLogbook = $builder->orderBy('tgl_logbook', 'DESC')->findAll();
        }

        $stateData = $this->_getMahasiswaState($id_mahasiswa);

        $data = [
            'title'            => 'Logbook & Absensi Magang',
            'nama'             => session()->get('nama') ?? 'Mahasiswa',
            'penempatan'       => $penempatan, 
            'logbook'          => $riwayatLogbook,
            'state'            => $stateData['state'],
            'is_log_book'      => $stateData['is_log_book'],
            'jenis_permohonan' => $stateData['jenis_permohonan']
        ];

        return view('mahasiswa/v_logbook', $data);
    }

    /**
     * 8. LOGIKA SIMPAN DATA LOGBOOK HARIAN KE TABEL t_logbook_magang
     */
    public function simpanLogbook()
    {
        $id_mahasiswa = session()->get('id_mahasiswa'); 
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'));
        }

        $penempatan = $this->logbookModel->cekPenempatanAktif($id_mahasiswa);

        if (!$penempatan) {
            return redirect()->back()->with('error', 'Gagal menyimpan! Anda belum dialokasikan ke bidang manapun.');
        }

        $dataLogbook = [
            'id_penempatan_magang' => $penempatan['id_penempatan_magang'], 
            'tgl_logbook'          => $this->request->getPost('tgl_logbook'),
            'logbook_magang'       => $this->request->getPost('logbook_magang'),
            'created_at'           => date('Y-m-d H:i:s')
        ];

        $this->logbookModel->insert($dataLogbook);

        return redirect()->to(base_url('mahasiswa/logbook'))->with('success', 'Logbook harian berhasil disimpan!');
    }


    /**
     * 9. HALAMAN UNDUH SERTIFIKAT
     */
    public function sertifikat()
    {
        $id_mahasiswa = session()->get('id_mahasiswa'); 
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data penempatan
        $penempatan = $this->penempatanModel->getPenempatanDetail($id_mahasiswa);
        $stateData = $this->_getMahasiswaState($id_mahasiswa);

        // Ambil file dokumen
        $file_penerimaan = null;
        $file_selesai    = null;
        $file_piagam     = null;
        
        if (!empty($stateData['permohonan_aktif']['id_persetujuan_magang'])) {
            $db = \Config\Database::connect();
            $files = $db->table('t_file_proses_magang')
                        ->where('id_persetujuan_magang', $stateData['permohonan_aktif']['id_persetujuan_magang'])
                        ->get()->getResultArray();
            foreach ($files as $f) {
                if ($f['id_file'] == 8) $file_penerimaan = $f;
                if ($f['id_file'] == 9) $file_selesai = $f;
                if ($f['id_file'] == 10) $file_piagam = $f;
            }
        }

        $data = [
            'title'            => 'Dokumen Kegiatan',
            'nama'             => session()->get('nama_mahasiswa') ?? 'Mahasiswa', 
            'penempatan'       => $penempatan,
            'state'            => $stateData['state'],
            'is_log_book'      => $stateData['is_log_book'],
            'jenis_permohonan' => $stateData['jenis_permohonan'],
            'file_penerimaan'  => $file_penerimaan,
            'file_selesai'     => $file_selesai,
            'file_piagam'      => $file_piagam
        ];

        return view('mahasiswa/v_sertifikat', $data);
    }

    /**
     * Helper method to determine the state of the mahasiswa
     */
    private function _getMahasiswaState($id_mahasiswa)
    {
        $db = \Config\Database::connect();

        $permohonan = $db->table('t_permohonan_magang')
            ->select('t_permohonan_magang.*, t_persetujuan_magang.id_persetujuan_magang, t_persetujuan_magang.status_persetujuan, t_persetujuan_magang.disposisi, t_persetujuan_magang.catatan as catatan_persetujuan, t_penempatan_magang.status_penempatan, t_penempatan_magang.is_log_book')
            ->join('t_persetujuan_magang', 't_persetujuan_magang.id_permohonan_magang = t_permohonan_magang.id_permohonan_magang', 'left')
            ->join('t_penempatan_magang', 't_penempatan_magang.id_persetujuan_magang = t_persetujuan_magang.id_persetujuan_magang', 'left')
            ->where('t_permohonan_magang.id_mahasiswa', $id_mahasiswa)
            ->orderBy('t_permohonan_magang.created_at', 'DESC')
            ->limit(1)
            ->get()->getRowArray();

        $state = 1; 
        $jenis_permohonan = null;
        $catatan = '';

        if ($permohonan) {
            $jenis_permohonan = $permohonan['id_jenis_permohonan'];
            if ($permohonan['posting_data'] == 'draft') {
                $state = 1;
            } else {
                if ($permohonan['status_persetujuan'] == 'DITOLAK') {
                    $state = 3; 
                    $catatan = $permohonan['catatan_persetujuan'];
                } else {
                    // Jika belum diplot (status_penempatan kosong) atau disposisi masih 0/1, berarti masih MENUNGGU
                    if (empty($permohonan['status_penempatan']) || in_array($permohonan['disposisi'], ['0', '1'])) {
                        $state = 2; // Menunggu Verifikasi/Penempatan
                    } else {
                        if ($permohonan['status_penempatan'] == 'SELESAI') {
                            $state = 5; 
                        } else {
                            $state = 4; // BERJALAN
                        }
                    }
                }
            }
        }

        return [
            'state'            => $state,
            'jenis_permohonan' => $jenis_permohonan,
            'is_log_book'      => $permohonan['is_log_book'] ?? 'tidak',
            'catatan'          => $catatan,
            'permohonan_aktif' => $permohonan
        ];
    }

    /**
     * HALAMAN EDIT DRAFT PERMOHONAN
     */
    public function editPermohonan($id_permohonan)
    {
        $id_mahasiswa = session()->get('id_mahasiswa');
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'));
        }

        $draft = $this->permohonanModel->where('id_permohonan_magang', $id_permohonan)
                                       ->where('id_mahasiswa', $id_mahasiswa)
                                       ->where('posting_data', 'draft')
                                       ->first();
                                       
        if (!$draft) {
            return redirect()->to(base_url('mahasiswa/status'))->with('error', 'Draft permohonan tidak ditemukan atau sudah dikirim.');
        }

        // Ambil nama file yang sudah tersimpan
        $draft['surat_pengantar'] = 'Belum ada file tersimpan';
        $draft['cv'] = 'Belum ada file tersimpan';
        
        $db = \Config\Database::connect();
        $files = $db->table('t_file_permohonan_magang')->where('id_permohonan_magang', $id_permohonan)->get()->getResultArray();
        foreach($files as $f) {
            $pivot = $db->table('m_file_permohonan')->where('id_file_permohonan', $f['id_file_permohonan'])->get()->getRowArray();
            if ($pivot) {
                if (in_array($pivot['id_file'], [1, 2, 5, 6])) {
                    $draft['surat_pengantar'] = $f['nama_file'];
                } elseif (in_array($pivot['id_file'], [3, 4, 7])) {
                    $draft['cv'] = $f['nama_file'];
                }
            }
        }

        $data = [
            'title' => 'Edit Draft Permohonan',
            'draft' => $draft,
            'state' => 1
        ];

        return view('mahasiswa/v_edit_permohonan', $data);
    }

    /**
     * PROSES UPDATE DRAFT PERMOHONAN
     */
    public function updatePermohonan($id_permohonan)
    {
        $id_mahasiswa = session()->get('id_mahasiswa');
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'));
        }

        $draft = $this->permohonanModel->where('id_permohonan_magang', $id_permohonan)
                                       ->where('id_mahasiswa', $id_mahasiswa)
                                       ->where('posting_data', 'draft')
                                       ->first();
                                       
        if (!$draft) {
            return redirect()->to(base_url('mahasiswa/status'))->with('error', 'Draft permohonan tidak ditemukan atau sudah dikirim.');
        }

        $rules = [
            'id_jenis_permohonan' => ['rules' => 'required'],
            'deskripsi_keahlian'  => ['rules' => 'required|min_length[10]'],
            'deskripsi_magang'    => ['rules' => 'required|min_length[20]'],
            'tgl_mulai'           => ['rules' => 'required|valid_date'],
            'tgl_selesai'         => ['rules' => 'required|valid_date']
        ];

        // Validasi file hanya jika ada file yang diunggah
        if ($this->request->getFile('surat_pengantar')->isValid()) {
            $rules['surat_pengantar'] = ['rules' => 'max_size[surat_pengantar,2048]|ext_in[surat_pengantar,pdf]|mime_in[surat_pengantar,application/pdf]'];
        }
        if ($this->request->getPost('id_jenis_permohonan') !== '2' && $this->request->getFile('cv')->isValid()) {
            $rules['cv'] = ['rules' => 'max_size[cv,2048]|ext_in[cv,pdf]|mime_in[cv,application/pdf]'];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $action_type = $this->request->getPost('action_type') === 'draft' ? 'draft' : 'kirim';
        $id_jenis_permohonan = $this->request->getPost('id_jenis_permohonan');

        $dataPermohonan = [
            'id_jenis_permohonan' => $id_jenis_permohonan,
            'deskripsi_keahlian'  => $this->request->getPost('deskripsi_keahlian'),
            'deskripsi_magang'    => $this->request->getPost('deskripsi_magang'),
            'tgl_mulai'           => $this->request->getPost('tgl_mulai'),
            'tgl_selesai'         => $this->request->getPost('tgl_selesai'),
            'posting_data'        => $action_type,
            'updated_at'          => date('Y-m-d H:i:s')
        ];
        $this->permohonanModel->update($id_permohonan, $dataPermohonan);

        // Cek apakah jenis permohonan berubah, jika ya, update id_file_permohonan file yang sudah ada agar tidak tersesat
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

        // Proses Berkas 1: Surat Pengantar
        $fileSurat = $this->request->getFile('surat_pengantar'); 
        if ($fileSurat && $fileSurat->isValid() && !$fileSurat->hasMoved()) {
            $namaSuratBaru = $fileSurat->getRandomName();
            $fileSurat->move(FCPATH . 'uploads/dokumen', $namaSuratBaru);
            $id_file_master = 2; // Default Magang -> Surat
            if ($id_jenis_permohonan == '1') $id_file_master = 1;
            if ($id_jenis_permohonan == '2') $id_file_master = 5;
            if ($id_jenis_permohonan == '4') $id_file_master = 6;

            $pivot = $db->table('m_file_permohonan')->where('id_jenis_permohonan', $id_jenis_permohonan)->where('id_file', $id_file_master)->get()->getRowArray();
            if ($pivot) {
                // Delete old file if exists
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
                    'nama_file'            => $fileSurat->getClientName(),
                    'path_file'            => 'uploads/dokumen/' . $namaSuratBaru,
                    'created_at'           => date('Y-m-d H:i:s')
                ]);
            }
        }

        // Proses Berkas 2: CV
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
                        'nama_file'            => $fileKedua->getClientName(),
                        'path_file'            => 'uploads/dokumen/' . $namaFileKeduaBaru,
                        'created_at'           => date('Y-m-d H:i:s')
                    ]);
                }
            }
        } elseif ($id_jenis_permohonan == '2') {
            // Jika berubah ke observasi, hapus CV
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

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat menyimpan permohonan. Coba lagi.');
        }

        if ($action_type === 'draft') {
            return redirect()->to(base_url('mahasiswa/status'))->with('success', 'Perubahan pada Draft berhasil disimpan.');
        } else {
            return redirect()->to(base_url('mahasiswa/status'))->with('success', 'Permohonan berhasil dikirim ke Sekretariat untuk diverifikasi.');
        }
    }

    /**
     * HALAMAN PROFIL MAHASISWA
     */
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

        return view('mahasiswa/v_profil', $data);
    }

    /**
     * PROSES SIMPAN EDIT PROFIL MAHASISWA
     */
    public function updateProfil()
    {
        $id_mahasiswa = session()->get('id_mahasiswa');
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'));
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