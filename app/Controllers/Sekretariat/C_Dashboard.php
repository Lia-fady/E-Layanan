<?php

/**
 * Kode: C_Dashboard.php
 * Path: app/Controllers/Sekretariat/C_Dashboard.php
 * Deskripsi: Controller untuk menampilkan halaman Dashboard modul Sekretariat.
 *            Menyediakan data statistik ringkasan, daftar permohonan pending,
 *            status verifikasi administrasi, dan ringkasan hari ini.
 */

namespace App\Controllers\Sekretariat;

use App\Controllers\BaseController;

class C_Dashboard extends BaseController
{
    /**
     * Menampilkan halaman dashboard Sekretariat dengan data ringkasan.
     *
     * @return string
     */
    public function index(): string
    {
        $db = \Config\Database::connect();
        $bulanIni = date('m');
        $tahunIni = date('Y');
        $hariIni  = date('Y-m-d');

        // ============================================================
        // STAT CARDS
        // ============================================================

        // 1. Total Pemohon (semua yang sudah dikirim, kecuali yang penempatannya SELESAI)
        $total_permohonan = $db->table('t_permohonan_magang as pm')
            ->join('t_persetujuan_magang as ps', 'ps.id_permohonan_magang = pm.id_permohonan_magang', 'left')
            ->join('t_penempatan_magang as pn', 'pn.id_persetujuan_magang = ps.id_persetujuan_magang', 'left')
            ->where('pm.posting_data', 'kirim')
            ->groupStart()
                ->where('pn.status_penempatan !=', 'SELESAI')
                ->orWhere('pn.status_penempatan IS NULL')
            ->groupEnd()
            ->countAllResults();

        // 2. Menunggu Verifikasi
        $total_verifikasi = $db->table('t_persetujuan_magang')
            ->where('status_persetujuan', 'MENUNGGU')
            ->countAllResults();

        // 3. Sedang Diproses (disetujui tapi belum didisposisi)
        $total_sedang_diproses = $db->table('t_persetujuan_magang')
            ->where('status_persetujuan', 'DISETUJUI')
            ->groupStart()
                ->where('disposisi', '0')
                ->orWhere('disposisi IS NULL')
            ->groupEnd()
            ->countAllResults();

        // 4. Disetujui (kecuali yang penempatannya SELESAI)
        $total_disetujui = $db->table('t_persetujuan_magang as ps')
            ->join('t_penempatan_magang as pn', 'pn.id_persetujuan_magang = ps.id_persetujuan_magang', 'left')
            ->where('ps.status_persetujuan', 'DISETUJUI')
            ->groupStart()
                ->where('pn.status_penempatan !=', 'SELESAI')
                ->orWhere('pn.status_penempatan IS NULL')
            ->groupEnd()
            ->countAllResults();

        // 5. Mahasiswa Aktif (dari t_penempatan_magang WHERE status_penempatan = 'BERJALAN')
        $total_mahasiswa_aktif = $db->table('t_penempatan_magang')
            ->where('status_penempatan', 'BERJALAN')
            ->countAllResults();

        // ============================================================
        // PERMOHONAN PENDING (5 terbaru)
        // ============================================================
        $permohonan_pending = $db->table('t_persetujuan_magang as ps')
            ->select('
                ps.id_persetujuan_magang,
                ps.id_permohonan_magang,
                ps.status_persetujuan,
                pm.created_at as tgl_pengajuan,
                mhs.nim,
                mhs.nama_mahasiswa,
                jp.jenis_permohonan,
                (SELECT COUNT(*) FROM t_file_permohonan_magang fp WHERE fp.id_permohonan_magang = pm.id_permohonan_magang) as total_berkas
            ')
            ->join('t_permohonan_magang as pm', 'pm.id_permohonan_magang = ps.id_permohonan_magang', 'left')
            ->join('m_mahasiswa as mhs', 'mhs.id_mahasiswa = pm.id_mahasiswa', 'left')
            ->join('m_jenis_permohonan as jp', 'jp.id_jenis_permohonan = pm.id_jenis_permohonan', 'left')
            ->where('ps.status_persetujuan', 'MENUNGGU')
            ->orderBy('pm.created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResult();

        // Add required_berkas default
        foreach ($permohonan_pending as &$p) {
            $p->required_berkas = 3;
        }

        // ============================================================
        // STATUS VERIFIKASI ADMINISTRASI (Donut Chart)
        // ============================================================
        // Lengkap: permohonan dengan semua berkas (>= 3 file)
        $lengkap = $db->query("
            SELECT COUNT(*) as total FROM t_permohonan_magang pm
            WHERE pm.posting_data = 'kirim'
            AND (SELECT COUNT(*) FROM t_file_permohonan_magang fp WHERE fp.id_permohonan_magang = pm.id_permohonan_magang) >= 3
        ")->getRow()->total ?? 0;

        // Tidak Lengkap: permohonan dengan sebagian berkas (1-2 file)
        $tidak_lengkap = $db->query("
            SELECT COUNT(*) as total FROM t_permohonan_magang pm
            WHERE pm.posting_data = 'kirim'
            AND (SELECT COUNT(*) FROM t_file_permohonan_magang fp WHERE fp.id_permohonan_magang = pm.id_permohonan_magang) BETWEEN 1 AND 2
        ")->getRow()->total ?? 0;

        // Perlu Perbaikan: permohonan yang ditolak
        $perlu_perbaikan = $db->table('t_persetujuan_magang')
            ->where('status_persetujuan', 'DITOLAK')
            ->countAllResults();

        $total_status = (int)$lengkap + (int)$tidak_lengkap + (int)$perlu_perbaikan;
        $status_verifikasi = [
            [
                'label'  => 'Lengkap',
                'total'  => (int)$lengkap,
                'persen' => $total_status > 0 ? round(($lengkap / $total_status) * 100, 1) : 0,
            ],
            [
                'label'  => 'Tidak Lengkap',
                'total'  => (int)$tidak_lengkap,
                'persen' => $total_status > 0 ? round(($tidak_lengkap / $total_status) * 100, 1) : 0,
            ],
            [
                'label'  => 'Perlu Perbaikan',
                'total'  => (int)$perlu_perbaikan,
                'persen' => $total_status > 0 ? round(($perlu_perbaikan / $total_status) * 100, 1) : 0,
            ],
        ];

        // ============================================================
        // RINGKASAN HARI INI
        // ============================================================
        $ringkasan_masuk = $db->table('t_permohonan_magang')
            ->where('posting_data', 'kirim')
            ->where('DATE(created_at)', $hariIni)
            ->countAllResults();

        $ringkasan_verifikasi = $db->table('t_persetujuan_magang')
            ->whereIn('status_persetujuan', ['DISETUJUI'])
            ->where('DATE(tgl_persetujuan)', $hariIni)
            ->countAllResults();

        $ringkasan_disposisi = $db->table('t_penempatan_magang')
            ->where('DATE(created_at)', $hariIni)
            ->countAllResults();

        $ringkasan_ditolak = $db->table('t_persetujuan_magang')
            ->where('status_persetujuan', 'DITOLAK')
            ->where('DATE(tgl_persetujuan)', $hariIni)
            ->countAllResults();

        // ============================================================
        // FORMAT TANGGAL INDONESIA
        // ============================================================
        $namaBulan = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April',   '05' => 'Mei',      '06' => 'Juni',
            '07' => 'Juli',    '08' => 'Agustus',   '09' => 'September',
            '10' => 'Oktober', '11' => 'November',  '12' => 'Desember',
        ];
        $namaBulanIni = $namaBulan[date('m')] ?? date('F');

        $namaHari = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];
        $hariNamaIni = $namaHari[date('l')] ?? date('l');
        $tanggalFormatted = $hariNamaIni . ', ' . date('d') . ' ' . $namaBulanIni . ' ' . date('Y');

        // ============================================================
        // PREPARE DATA
        // ============================================================
        $data = [
            'title'                 => 'Dashboard Sekretariat',
            'active_menu'           => 'dashboard',
            'total_permohonan'      => (int) $total_permohonan,
            'total_verifikasi'      => (int) $total_verifikasi,
            'total_sedang_diproses' => (int) $total_sedang_diproses,
            'total_disetujui'       => (int) $total_disetujui,
            'total_mahasiswa_aktif' => (int) $total_mahasiswa_aktif,
            'permohonan_pending'    => $permohonan_pending,
            'status_verifikasi'     => $status_verifikasi,
            'ringkasan'             => [
                'masuk'      => (int) $ringkasan_masuk,
                'verifikasi' => (int) $ringkasan_verifikasi,
                'disposisi'  => (int) $ringkasan_disposisi,
                'ditolak'    => (int) $ringkasan_ditolak,
            ],
            'tanggal_formatted'     => $tanggalFormatted,
        ];

        return view('dashboard/sekretariat/v_dashboard', $data);
    }
}
