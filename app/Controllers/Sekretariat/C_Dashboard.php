<?php

/**
 * Kode: C_Dashboard.php
 * Path: app/Controllers/Sekretariat/C_Dashboard.php
 * Deskripsi: Controller untuk menampilkan halaman Dashboard modul Sekretariat.
 *            Menyediakan data statistik ringkasan, daftar permohonan pending,
 *            distribusi jenis permohonan, ringkasan hari ini, dan tren bulanan.
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

        // 1. Permohonan Masuk (bulan ini, yang sudah dikirim)
        $total_permohonan = $db->table('t_permohonan_magang')
            ->where('posting_data', 'kirim')
            ->where('MONTH(created_at)', $bulanIni)
            ->where('YEAR(created_at)', $tahunIni)
            ->countAllResults();

        // 2. Menunggu Verifikasi
        $total_verifikasi = $db->table('t_persetujuan_magang')
            ->where('status_persetujuan', 'MENUNGGU')
            ->countAllResults();

        // 3. Berkas Terverifikasi (bulan ini)
        $total_terverifikasi = $db->table('t_persetujuan_magang')
            ->where('status_persetujuan', 'DISETUJUI')
            ->where('MONTH(tgl_persetujuan)', $bulanIni)
            ->where('YEAR(tgl_persetujuan)', $tahunIni)
            ->countAllResults();

        // 4. Sudah Didisposisi
        $total_disposisi = $db->table('t_persetujuan_magang')
            ->where('disposisi', '1')
            ->countAllResults();

        // ============================================================
        // PERMOHONAN PENDING (5 terbaru)
        // ============================================================
        $permohonan_pending = $db->table('t_persetujuan_magang as ps')
            ->select('
                ps.id_persetujuan_magang,
                ps.status_persetujuan,
                pm.created_at as tgl_pengajuan,
                mhs.nim,
                mhs.nama_mahasiswa,
                jp.jenis_permohonan
            ')
            ->join('t_permohonan_magang as pm', 'pm.id_permohonan_magang = ps.id_permohonan_magang', 'left')
            ->join('m_mahasiswa as mhs', 'mhs.id_mahasiswa = pm.id_mahasiswa', 'left')
            ->join('m_jenis_permohonan as jp', 'jp.id_jenis_permohonan = pm.id_jenis_permohonan', 'left')
            ->where('ps.status_persetujuan', 'MENUNGGU')
            ->orderBy('pm.created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResult();

        // ============================================================
        // DISTRIBUSI JENIS PERMOHONAN (Donut Chart)
        // ============================================================
        $distribusi_raw = $db->table('t_permohonan_magang as pm')
            ->select('jp.jenis_permohonan, COUNT(*) as total')
            ->join('m_jenis_permohonan as jp', 'jp.id_jenis_permohonan = pm.id_jenis_permohonan', 'left')
            ->where('pm.posting_data', 'kirim')
            ->groupBy('jp.jenis_permohonan')
            ->get()
            ->getResult();

        $distribusi_jenis = [];
        $total_semua = 0;
        foreach ($distribusi_raw as $d) {
            $total_semua += $d->total;
        }
        foreach ($distribusi_raw as $d) {
            $persen = $total_semua > 0 ? round(($d->total / $total_semua) * 100) : 0;
            $distribusi_jenis[] = [
                'label'   => $d->jenis_permohonan ?? 'Lainnya',
                'total'   => (int) $d->total,
                'persen'  => $persen,
            ];
        }

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

        $ringkasan_disposisi = $db->table('t_persetujuan_magang')
            ->where('disposisi', '1')
            ->where('DATE(updated_at)', $hariIni)
            ->countAllResults();

        $ringkasan_ditolak = $db->table('t_persetujuan_magang')
            ->where('status_persetujuan', 'DITOLAK')
            ->where('DATE(tgl_persetujuan)', $hariIni)
            ->countAllResults();

        // ============================================================
        // TREN PERMOHONAN BULANAN (Line Chart - 6 bulan terakhir + bulan ini)
        // ============================================================
        $tren_bulanan = [];
        $bulanLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $bln = date('m', strtotime("-$i months"));
            $thn = date('Y', strtotime("-$i months"));
            $label = date('M', strtotime("-$i months")); // Jan, Feb, etc.

            $bulanLabels[] = $label;

            $masuk = $db->table('t_permohonan_magang')
                ->where('posting_data', 'kirim')
                ->where('MONTH(created_at)', $bln)
                ->where('YEAR(created_at)', $thn)
                ->countAllResults();

            $disetujui = $db->table('t_persetujuan_magang')
                ->where('status_persetujuan', 'DISETUJUI')
                ->where('MONTH(tgl_persetujuan)', $bln)
                ->where('YEAR(tgl_persetujuan)', $thn)
                ->countAllResults();

            $ditolak = $db->table('t_persetujuan_magang')
                ->where('status_persetujuan', 'DITOLAK')
                ->where('MONTH(tgl_persetujuan)', $bln)
                ->where('YEAR(tgl_persetujuan)', $thn)
                ->countAllResults();

            $tren_bulanan[] = [
                'masuk'     => $masuk,
                'disetujui' => $disetujui,
                'ditolak'   => $ditolak,
            ];
        }

        // ============================================================
        // NAMA BULAN (Indonesia)
        // ============================================================
        $namaBulan = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April',   '05' => 'Mei',      '06' => 'Juni',
            '07' => 'Juli',    '08' => 'Agustus',   '09' => 'September',
            '10' => 'Oktober', '11' => 'November',  '12' => 'Desember',
        ];
        $namaBulanIni = $namaBulan[date('m')] ?? date('F');

        // Format hari ini dalam Bahasa Indonesia
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
            'title'               => 'Dashboard Sekretariat',
            'active_menu'         => 'dashboard',
            'total_permohonan'    => (int) $total_permohonan,
            'total_verifikasi'    => (int) $total_verifikasi,
            'total_terverifikasi' => (int) $total_terverifikasi,
            'total_disposisi'     => (int) $total_disposisi,
            'permohonan_pending'  => $permohonan_pending,
            'distribusi_jenis'    => $distribusi_jenis,
            'ringkasan'           => [
                'masuk'      => (int) $ringkasan_masuk,
                'verifikasi' => (int) $ringkasan_verifikasi,
                'disposisi'  => (int) $ringkasan_disposisi,
                'ditolak'    => (int) $ringkasan_ditolak,
            ],
            'tren_labels'         => $bulanLabels,
            'tren_bulanan'        => $tren_bulanan,
            'tanggal_formatted'   => $tanggalFormatted,
            'nama_bulan'          => $namaBulanIni,
        ];

        return view('dashboard/sekretariat/v_dashboard', $data);
    }
}
