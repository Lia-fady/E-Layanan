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

        // 1. Total Permohonan (seluruh data di t_permohonan_magang)
        $total_permohonan = $db->table('t_permohonan_magang')
            ->countAllResults();

        // 2. Menunggu Verifikasi
        $total_verifikasi = $db->table('t_persetujuan_magang')
            ->where('status_persetujuan', 'MENUNGGU')
            ->countAllResults();

        // 3. Sedang Diproses oleh Kepala Bidang (dari t_penempatan_magang WHERE status_penempatan = 'MENUNGGU')
        $total_sedang_diproses = $db->table('t_penempatan_magang')
            ->where('status_penempatan', 'MENUNGGU')
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
        // RINGKASAN PERMOHONAN (Donut Chart)
        // ============================================================

        // Total seluruh permohonan masuk (untuk angka di tengah donut)
        $total_permohonan_chart = $db->table('t_permohonan_magang')
            ->countAllResults();

        // Rincian status persetujuan dari t_persetujuan_magang
        $status_row = $db->query("
            SELECT
                SUM(CASE WHEN status_persetujuan = 'MENUNGGU' THEN 1 ELSE 0 END) AS menunggu_verifikasi,
                SUM(CASE WHEN status_persetujuan = 'DITOLAK' THEN 1 ELSE 0 END) AS ditolak,
                SUM(CASE WHEN status_persetujuan = 'DISETUJUI' THEN 1 ELSE 0 END) AS disetujui
            FROM t_persetujuan_magang
        ")->getRow();

        $menunggu  = (int)($status_row->menunggu_verifikasi ?? 0);
        $ditolak   = (int)($status_row->ditolak ?? 0);
        $disetujui = (int)($status_row->disetujui ?? 0);

        // Persentase dihitung berdasarkan total data di t_persetujuan_magang
        $total_status = $menunggu + $ditolak + $disetujui;
        $status_verifikasi = [
            [
                'label'  => 'Berkas Disetujui',
                'total'  => $disetujui,
                'persen' => $total_status > 0 ? round(($disetujui / $total_status) * 100, 1) : 0,
            ],
            [
                'label'  => 'Menunggu Verifikasi',
                'total'  => $menunggu,
                'persen' => $total_status > 0 ? round(($menunggu / $total_status) * 100, 1) : 0,
            ],
            [
                'label'  => 'Ditolak',
                'total'  => $ditolak,
                'persen' => $total_status > 0 ? round(($ditolak / $total_status) * 100, 1) : 0,
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
            'total_permohonan_chart' => (int) $total_permohonan_chart,
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
