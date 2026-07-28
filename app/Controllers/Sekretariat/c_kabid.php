<?php

namespace App\Controllers\Sekretariat;

use App\Controllers\BaseController;
use App\Models\Sekretariat\m_kabid;
use Config\Database;

/**
 * Controller untuk Kepala Bidang
 * 
 * Mengelola dashboard, persetujuan permohonan, penempatan, penilaian,
 * dan komponen penilaian mahasiswa magang.
 */
class C_kabid extends BaseController
{
    protected $m_kabid;

    public function __construct()
    {
        $this->m_kabid = new m_kabid();
    }

    /**
     * Tampilkan dashboard Kepala Bidang dengan statistik dan informasi ringkas
     * 
     * @return string View dashboard
     */
    public function index()
    {
        $id_bidang = 1;
        $kuota_bidang = $this->m_kabid->getKuotaBidang();
        $kuota_slot   = $kuota_bidang[$id_bidang]['kuota_total'] ?? 0;
        $kuota_terisi = $kuota_bidang[$id_bidang]['kuota_terisi'] ?? 0;

        $data = [
            'title'                 => 'Dashboard Kepala Bidang',
            'nama_kabid'            => 'Dias Delia',
            'nama_bidang'           => 'Bidang Infrastruktur TIK - Dinas Kominfo Kota Tangerang',
            'kuota_slot'            => $kuota_slot,
            'kuota_terisi'          => $kuota_terisi,
            'total_disposisi_masuk' => $this->m_kabid->countPendingPersetujuan(),
            'total_logbook_pending' => $this->m_kabid->countPendingLogbook(),
            'total_mahasiswa_aktif' => $this->m_kabid->countPenempatanAktif(),
            'total_sertifikat_siap' => $this->m_kabid->countSertifikatSiap(),
            'disposisi_list'        => $this->m_kabid->getRecentPendingPersetujuan(5),
            'mahasiswa_aktif_list'  => $this->m_kabid->getPermohonanByBidang($id_bidang),
        ];

        return view('kabid/v_kabid_dashboard', $data);
    }


    /**
     * Tampilkan daftar permohonan yang menunggu persetujuan dari Kepala Bidang
     * 
     * @return string View persetujuan
     */
    public function persetujuan()
    {
        $id_bidang = 1;
        $data = [
            'title'      => 'Persetujuan Permohonan',
            'permohonan' => $this->m_kabid->getPermohonanByBidang($id_bidang),
        ];

        return view('kabid/v_kabid_persetujuan', $data);

    }

    public function detail_disposisi($id)
    {
        $data = [
            'title'  => 'Detail Persetujuan Penempatan',
            // Ambil data spesifik mahasiswa berdasarkan ID persetujuan dari model Anda
            'detail' => $this->m_kabid->getPermohonanById($id), 
        ];

        return view('kabid/v_kabid_disposisi_detail', $data);
    
    }

    /**
     * Simpan persetujuan atau penolakan permohonan dari Kepala Bidang
     * 
     * @return RedirectResponse
     */
    public function simpan_persetujuan()
    {
        $id = $this->request->getPost('id_persetujuan');
        
        if (! $id) {
            session()->setFlashdata('error', 'ID persetujuan tidak ditemukan.');
            return redirect()->back();
        }

        $data = [
            'status_persetujuan' => $this->request->getPost('status'),
            'catatan'            => $this->request->getPost('catatan'),
            'tgl_persetujuan'    => date('Y-m-d'),
        ];

        $ok = $this->m_kabid->updatePersetujuan($id, $data);
        
        if ($ok) {
            session()->setFlashdata('success', 'Persetujuan berhasil disimpan.');
        } else {
            session()->setFlashdata('error', 'Gagal menyimpan persetujuan.');
        }

        return redirect()->to(base_url('sekretariat/c_kabid/persetujuan'));
    }


    /**
     * Tampilkan halaman kelola kuota per bidang
     *
     * @return string View kelola kuota
     */
    public function kelola_kuota()
    {
        $data = [
            'title'        => 'Kelola Kuota Bidang',
            'kuota_bidang' => $this->m_kabid->getKuotaBidang(),
        ];

        return view('kabid/v_kabid_kelola_kuota', $data);
    }

    /**
     * Simpan perubahan kuota bidang
     *
     * @return RedirectResponse
     */
    public function simpan_kuota()
    {
        $id_bidang   = (int) $this->request->getPost('id_bidang');
        $kuota_total = (int) $this->request->getPost('kuota_total');

        if (! $id_bidang || $kuota_total < 0) {
            session()->setFlashdata('error', 'Data kuota tidak valid.');
            return redirect()->to(base_url('sekretariat/c_kabid/kelola-kuota'));
        }

        $ok = $this->m_kabid->updateKuotaBidang($id_bidang, $kuota_total);

        if ($ok) {
            session()->setFlashdata('success', 'Kuota bidang berhasil diperbarui.');
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui kuota. Pastikan tabel m_bidang tersedia.');
        }

        return redirect()->to(base_url('sekretariat/c_kabid/kelola-kuota'));
    }

    /**
     * Tampilkan daftar penempatan magang yang perlu dikelola
     *
     * @return string View penempatan
     */
    public function penempatan()
    {
        $id_bidang = null;
        $data = [
            'title'      => 'Kelola Bidang',
            'penempatan' => $this->m_kabid->getPenempatan($id_bidang),
        ];

        return view('kabid/v_kabid_penempatan', $data);
    }

    /**
     * Simpan perubahan status dan catatan penempatan
     * 
     * @return RedirectResponse
     */
    public function simpan_penempatan()
    {
        $id = $this->request->getPost('id_penempatan') ?? $this->request->getPost('id_penempatan_magang');
        
        if (! $id) {
            session()->setFlashdata('error', 'ID penempatan tidak ditemukan.');
            return redirect()->to(base_url('sekretariat/c_kabid/penempatan'));
        }

        $status = $this->request->getPost('status_penempatan');
        $catatan = $this->request->getPost('catatan');

        // Validasi status penempatan
        $allowed = [
            m_kabid::PENEMPATAN_BERJALAN,
            m_kabid::PENEMPATAN_SELESAI,
            m_kabid::PENEMPATAN_DIBATALKAN,
        ];
        
        if (! in_array($status, $allowed, true)) {
            session()->setFlashdata('error', 'Status penempatan tidak valid.');
            return redirect()->to(base_url('sekretariat/c_kabid/penempatan'));
        }

        $data = [
            'status_penempatan' => $status,
            'catatan'           => $catatan,
        ];

        // Gunakan transaksi untuk memastikan konsistensi data
        $db = Database::connect();
        $db->transStart();
        $ok = $this->m_kabid->updatePenempatan($id, $data);
        $db->transComplete();

        if ($db->transStatus() && $ok) {
            session()->setFlashdata('success', 'Penempatan berhasil diperbarui.');
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui penempatan.');
        }

        return redirect()->to(base_url('sekretariat/c_kabid/penempatan'));
    }

    /**
     * Hapus data penempatan
     * 
     * @param int $id ID Penempatan
     * @return RedirectResponse
     */
    public function hapus_penempatan($id)
    {
        if (! $id) {
            session()->setFlashdata('error', 'ID penempatan tidak valid.');
            return redirect()->to(base_url('sekretariat/c_kabid/penempatan'));
        }

        $ok = $this->m_kabid->deletePenempatan((int)$id);

        if ($ok) {
            session()->setFlashdata('success', 'Data penempatan berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data penempatan.');
        }

        return redirect()->to(base_url('sekretariat/c_kabid/penempatan'));
    }


    /**
     * Tampilkan halaman upload sertifikat
     * 
     * @return string View sertifikat
     */
    public function sertifikat()
    {
        return redirect()->to(base_url('sekretariat/upload-sertifikat'));
    }

    /**
     * Simpan upload sertifikat
     * 
     * @return RedirectResponse
     */
    public function simpan_sertifikat()
    {
        $id_penempatan = $this->request->getPost('id_penempatan_magang');
        
        if (! $id_penempatan) {
            session()->setFlashdata('error', 'ID penempatan tidak ditemukan.');
            return redirect()->back();
        }

        // Validasi file upload
        $file = $this->request->getFile('file_sertifikat');
        
        if (! $file || $file->getError() === UPLOAD_ERR_NO_FILE) {
            session()->setFlashdata('error', 'Silakan pilih file sertifikat.');
            return redirect()->back();
        }

        // Validasi jenis file
        $allowed_types = ['application/pdf'];
        if (! in_array($file->getMimeType(), $allowed_types, true)) {
            session()->setFlashdata('error', 'Format file harus PDF.');
            return redirect()->back();
        }

        // Validasi ukuran file (max 2MB)
        $max_size = 2 * 1024 * 1024; // 2MB
        if ($file->getSize() > $max_size) {
            session()->setFlashdata('error', 'Ukuran file maksimal 2MB.');
            return redirect()->back();
        }

        if (! $file->isValid()) {
            session()->setFlashdata('error', 'File upload gagal, silakan coba lagi.');
            return redirect()->back();
        }

        // Generate nama file unik
        $new_name = $file->getRandomName();
        
        // Pindahkan file ke folder uploads
        try {
            $file->move(WRITEPATH . 'uploads', $new_name);
            
            $data = [
                'id_penempatan_magang' => $id_penempatan,
                'file_sertifikat'      => $new_name,
                'catatan'              => $this->request->getPost('catatan'),
                'tgl_upload'           => date('Y-m-d H:i:s'),
            ];

            $ok = $this->m_kabid->saveSertifikat($data);
            
            if ($ok) {
                session()->setFlashdata('success', 'Sertifikat berhasil diunggah.');
            } else {
                session()->setFlashdata('error', 'Gagal menyimpan sertifikat ke database.');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Gagal mengunggah file: ' . $e->getMessage());
        }

        return redirect()->back();
    }
}