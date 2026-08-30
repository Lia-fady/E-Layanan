<?php
/**
 * ============================================================
 * Kode      : C_Verifikasi.php
 * Path      : Controllers/Sekretariat/C_Verifikasi.php
 * Deskripsi : Controller untuk modul Verifikasi Administrasi.
 *             Menampilkan daftar permohonan masuk (card-based),
 *             detail permohonan dengan validasi per file,
 *             dan memproses verifikasi.
 * ============================================================
 */

namespace App\Controllers\Sekretariat;

use App\Controllers\BaseController;
use App\Models\Sekretariat\M_Verifikasi;

class C_Verifikasi extends BaseController
{
    protected $verifikasiModel;

    public function __construct()
    {
        $this->verifikasiModel = new M_Verifikasi();
    }

    /**
     * Halaman daftar permohonan masuk - card-based layout.
     */
    public function index()
    {
        $db = \Config\Database::connect();

        // AJAX Handler for getting detail
        if ($this->request->isAJAX() && $this->request->getPost('action') === 'get_detail') {
            $id = $this->request->getPost('id');
            
            // Ambil id_bidang dari penempatan (jika sudah didisposisi)
            $penempatan = $db->table('t_penempatan_magang as pn')
                ->select('pn.id_bidang, pn.status_penempatan')
                ->join('t_persetujuan_magang as ps', 'ps.id_persetujuan_magang = pn.id_persetujuan_magang', 'inner')
                ->where('ps.id_permohonan_magang', $id)
                ->get()
                ->getRow();

            $bidang_list = $db->table('m_bidang')
                ->select('m_bidang.id_bidang, m_bidang.bidang')
                ->where('m_bidang.status_aktif', '1')
                ->get()->getResult();

            $kuotaModel = new \App\Models\KuotaBidangModel();
            
            // Get permohonan to check dates
            $permohonanData = $this->verifikasiModel->getPermohonanById($id);
            $tgl_mulai = $permohonanData->tgl_mulai ?? null;
            $tgl_selesai = $permohonanData->tgl_selesai ?? null;
            
            $tahun_mulai = $tgl_mulai ? (int)date('Y', strtotime($tgl_mulai)) : (int)date('Y');
            $bulan_mulai = $tgl_mulai ? (int)date('m', strtotime($tgl_mulai)) : (int)date('m');
            $tahun_selesai = $tgl_selesai ? (int)date('Y', strtotime($tgl_selesai)) : $tahun_mulai;
            $bulan_selesai = $tgl_selesai ? (int)date('m', strtotime($tgl_selesai)) : $bulan_mulai;

            foreach ($bidang_list as &$b) {
                $b->sisa_kuota = 0; // Default
                $b->kuota_penuh_di_bulan = null;
                $b->detail_kuota = []; // New
                
                // Get kuota for the starting year
                $kuotaTahunMulai = $kuotaModel->getKuotaPerBulan($b->id_bidang, $tahun_mulai);
                
                $semuaTersedia = true;
                
                // Check each month in the range
                $curr_y = $tahun_mulai;
                $curr_m = $bulan_mulai;
                
                while ($curr_y < $tahun_selesai || ($curr_y == $tahun_selesai && $curr_m <= $bulan_selesai)) {
                    $kuotaBulanData = $kuotaTahunMulai; // Optimize: normally you'd fetch per year if range spans years
                    if ($curr_y != $tahun_mulai) {
                        $kuotaBulanData = $kuotaModel->getKuotaPerBulan($b->id_bidang, $curr_y);
                    }
                    
                    // find by bulan_angka
                    $sisaBulanIni = 0;
                    $namaBulanIni = '';
                    $namaBulanIniShort = '';
                    foreach ($kuotaBulanData as $kb) {
                        if ($kb['bulan_angka'] == $curr_m) {
                            $sisaBulanIni = $kb['sisa_kuota'];
                            $namaBulanIni = $kb['bulan_nama'] . ' ' . $curr_y;
                            $namaBulanIniShort = $kb['bulan_nama'];
                            break;
                        }
                    }
                    
                    $b->detail_kuota[] = [
                        'bulan' => $namaBulanIniShort . ' ' . $curr_y,
                        'sisa' => $sisaBulanIni
                    ];
                    
                    if ($sisaBulanIni <= 0) {
                        $semuaTersedia = false;
                        if (!$b->kuota_penuh_di_bulan) {
                            $b->kuota_penuh_di_bulan = $namaBulanIni;
                        }
                    }
                    
                    $curr_m++;
                    if ($curr_m > 12) {
                        $curr_m = 1;
                        $curr_y++;
                    }
                }
                
                if ($semuaTersedia) {
                    // For UI purposes, just show > 0 if available
                    $b->sisa_kuota = 1; 
                } else {
                    $b->sisa_kuota = 0;
                }
            }

            $data = [
                'permohonan'      => $this->verifikasiModel->getPermohonanById($id),
                'files'           => $this->verifikasiModel->getFilePermohonan($id),
                'bidang'          => $bidang_list,
                'selected_bidang' => $penempatan->id_bidang ?? null,
                'status_penempatan' => $penempatan->status_penempatan ?? 'MENUNGGU',
            ];

            return view('dashboard/sekretariat/verifikasi/_detail', $data);
        }

        $permohonan = $this->verifikasiModel->getPermohonanMasuk();
        
        // Attach files to each permohonan
        if (!empty($permohonan)) {
            $ids = array_map(function($p) { return $p->id_permohonan_magang; }, $permohonan);
            $allFiles = $this->verifikasiModel->getFilesByPermohonanIds($ids);
            
            foreach ($permohonan as &$p) {
                $p->files = $allFiles[$p->id_permohonan_magang] ?? [];
            }
        }

        $data = [
            'title'       => 'Verifikasi Permohonan',
            'active_menu' => 'verifikasi',
            'permohonan'  => $permohonan,
        ];

        return view('dashboard/sekretariat/verifikasi/index', $data);
    }

    /**
     * Handler untuk link detail standalone dari dashboard/riwayat.
     * Akan redirect ke index dan membuka detail otomatis via JS.
     */
    public function detailStandalone($id)
    {
        session()->setFlashdata('auto_open_detail_id', $id);
        return redirect()->to(base_url('sekretariat/verifikasi'));
    }

    /**
     * Proses verifikasi via AJAX Modal.
     */
    public function prosesModal()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to(base_url('sekretariat/verifikasi'));
        }

        $id_permohonan = $this->request->getPost('id_permohonan_magang');

        // Guard: Cek apakah keputusan sudah pernah disimpan (status bukan MENUNGGU)
        // Jika sudah final, tolak perubahan di level backend
        $db = \Config\Database::connect();
        $existing = $db->table('t_persetujuan_magang')
            ->where('id_permohonan_magang', $id_permohonan)
            ->get()
            ->getRow();

        if ($existing && $existing->status_persetujuan !== 'MENUNGGU') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Keputusan verifikasi sudah tersimpan dan tidak dapat diubah. Status saat ini: ' . $existing->status_persetujuan
            ]);
        }

        $keputusan = $this->request->getPost('keputusan_verifikasi');
        $id_bidang = $this->request->getPost('id_bidang');
        $catatanManual = $this->request->getPost('catatan_manual');

        // Validasi: keputusan harus dipilih
        if (empty($keputusan) || !in_array($keputusan, ['DISETUJUI', 'PERBAIKAN_BERKAS', 'DITOLAK'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Silakan pilih keputusan verifikasi terlebih dahulu.'
            ]);
        }

        $overallStatus = $keputusan;
        $catatan = '';

        if ($overallStatus === 'DITOLAK') {
            $catatan = trim($catatanManual ?? '');
            if (empty($catatan)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Catatan wajib diisi sebelum menolak permohonan.'
                ]);
            }
        } elseif ($overallStatus === 'PERBAIKAN_BERKAS') {
            $catatan = trim($catatanManual ?? '');
            if (empty($catatan)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Catatan wajib diisi sebelum mengirim perbaikan berkas.'
                ]);
            }
        } elseif ($overallStatus === 'DISETUJUI') {
            // Validasi: Bidang Tujuan wajib dipilih saat Disetujui
            if (empty($id_bidang)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Silakan pilih Bidang Tujuan untuk meneruskan permohonan yang disetujui.'
                ]);
            }
            $catatan = 'Seluruh berkas persyaratan telah diperiksa dan dinyatakan sesuai. Permohonan Anda disetujui dan akan diproses ke tahap selanjutnya.';
        }

        $data = [
            'id_permohonan_magang' => $id_permohonan,
            'catatan'              => $catatan,
            'status_persetujuan'   => $overallStatus,
            'created_by'           => session('id_user_pegawai'),
            'updated_by'           => session('id_user_pegawai'),
        ];

        $result = $this->verifikasiModel->simpanVerifikasi($data);

        // Jika disetujui dan id_bidang dikirim, langsung proses disposisi
        if ($overallStatus == 'DISETUJUI' && !empty($id_bidang)) {
            $db = \Config\Database::connect();
            $persetujuan = $db->table('t_persetujuan_magang')
                              ->where('id_permohonan_magang', $id_permohonan)
                              ->get()->getRow();
                              
            if ($persetujuan) {
                $disposisiModel = new \App\Models\Sekretariat\M_Disposisi();
                $disposisiModel->simpanDisposisi($persetujuan->id_persetujuan_magang, [
                    'id_bidang'         => $id_bidang,
                    'updated_by'        => session('id_user_pegawai'),
                    'catatan_disposisi' => 'Disposisi dari Verifikasi',
                ]);
                
                // Get nama bidang untuk log
                $bidangRow = $db->table('m_bidang')->where('id_bidang', $id_bidang)->get()->getRow();
                $namaBidang = $bidangRow ? $bidangRow->bidang : 'Bidang Tujuan';
                
                catat_log($id_permohonan, 'Sekretariat', 'Verifikasi Berhasil', 'Berkas telah dinyatakan lengkap dan permohonan diteruskan ke ' . $namaBidang . '.');
            }
        } elseif ($overallStatus == 'DITOLAK') {
            catat_log($id_permohonan, 'Sekretariat', 'Permohonan Ditolak', 'Permohonan tidak dapat diproses lebih lanjut. Catatan Sekretariat: ' . $catatan);
        } else {
            catat_log($id_permohonan, 'Sekretariat', 'Perlu Diperbaiki', 'Terdapat berkas yang harus diperbaiki. Catatan Sekretariat: ' . $catatan);
        }

        if ($result) {
            return $this->response->setJSON(['success' => true, 'message' => 'Verifikasi berhasil disimpan.']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal menyimpan verifikasi.']);
        }
    }

    /**
     * Kembalikan permohonan (tolak/kembalikan berkas).
     */
    public function kembalikan()
    {
        $id_permohonan = $this->request->getPost('id_permohonan_magang');
        
        $result = $this->verifikasiModel->kembalikanPermohonan($id_permohonan);

        if ($result) {
            session()->setFlashdata('success', 'Permohonan berhasil dikembalikan.');
        } else {
            session()->setFlashdata('error', 'Gagal mengembalikan permohonan.');
        }

        return redirect()->to(base_url('sekretariat/verifikasi'));
    }

    /**
     * Tolak permohonan langsung dari tabel (AJAX).
     */
    public function tolakCepat()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to(base_url('sekretariat/verifikasi'));
        }

        $id_permohonan = $this->request->getPost('id_permohonan_magang');
        $catatan = trim($this->request->getPost('catatan') ?? '');

        if (empty($catatan)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Catatan penolakan wajib diisi.'
            ]);
        }

        $data = [
            'id_permohonan_magang' => $id_permohonan,
            'catatan'              => $catatan,
            'status_persetujuan'   => 'DITOLAK',
            'created_by'           => session('id_user_pegawai'),
            'updated_by'           => session('id_user_pegawai'),
        ];

        $result = $this->verifikasiModel->simpanVerifikasi($data);

        if ($result) {
            catat_log($id_permohonan, 'Sekretariat', 'Permohonan Ditolak', 'Permohonan tidak dapat diproses lebih lanjut. Catatan Sekretariat: ' . $catatan);
            return $this->response->setJSON(['success' => true, 'message' => 'Permohonan berhasil ditolak.']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Gagal menolak permohonan.']);
    }
}
