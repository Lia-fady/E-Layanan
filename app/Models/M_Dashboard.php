<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Dashboard extends Model
{
    // ============================================================
    // DASHBOARD SEKRETARIAT
    // ============================================================
    public function getSekretariatStats($hariIni)
    {
        $db = \Config\Database::connect();
        
        $stats = [];
        $stats['total_permohonan'] = $db->table('t_permohonan_magang')->countAllResults();
        
        $stats['total_verifikasi'] = $db->table('t_persetujuan_magang')
            ->where('status_persetujuan', 'MENUNGGU')
            ->countAllResults();
            
        $stats['total_sedang_diproses'] = $db->table('t_penempatan_magang')
            ->where('status_penempatan', 'MENUNGGU')
            ->countAllResults();
            
        $stats['total_disetujui'] = $db->table('t_persetujuan_magang as ps')
            ->join('t_penempatan_magang as pn', 'pn.id_persetujuan_magang = ps.id_persetujuan_magang', 'left')
            ->where('ps.status_persetujuan', 'DISETUJUI')
            ->groupStart()
                ->where('pn.status_penempatan !=', 'SELESAI')
                ->orWhere('pn.status_penempatan IS NULL')
            ->groupEnd()
            ->countAllResults();
            
        $stats['total_mahasiswa_aktif'] = $db->table('t_penempatan_magang')
            ->where('status_penempatan', 'BERJALAN')
            ->countAllResults();

        // Chart
        $status_row = $db->query("
            SELECT
                SUM(CASE WHEN status_persetujuan = 'MENUNGGU' THEN 1 ELSE 0 END) AS menunggu_verifikasi,
                SUM(CASE WHEN status_persetujuan = 'PERBAIKAN_BERKAS' THEN 1 ELSE 0 END) AS perbaikan_berkas,
                SUM(CASE WHEN status_persetujuan = 'DISETUJUI' THEN 1 ELSE 0 END) AS disetujui
            FROM t_persetujuan_magang
        ")->getRow();

        $menunggu  = (int)($status_row->menunggu_verifikasi ?? 0);
        $perbaikan = (int)($status_row->perbaikan_berkas ?? 0);
        $disetujui = (int)($status_row->disetujui ?? 0);
        $total_status = $menunggu + $perbaikan + $disetujui;

        $stats['status_verifikasi'] = [
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
                'label'  => 'Perbaikan Berkas',
                'total'  => $perbaikan,
                'persen' => $total_status > 0 ? round(($perbaikan / $total_status) * 100, 1) : 0,
            ],
        ];

        // Ringkasan Hari Ini
        $stats['ringkasan_masuk'] = $db->table('t_permohonan_magang')
            ->where('posting_data', 'kirim')
            ->where('DATE(created_at)', $hariIni)
            ->countAllResults();

        $stats['ringkasan_verifikasi'] = $db->table('t_persetujuan_magang')
            ->whereIn('status_persetujuan', ['DISETUJUI'])
            ->where('DATE(tgl_persetujuan)', $hariIni)
            ->countAllResults();

        $stats['ringkasan_disposisi'] = $db->table('t_penempatan_magang')
            ->where('DATE(created_at)', $hariIni)
            ->countAllResults();

        $stats['ringkasan_perbaikan'] = $db->table('t_persetujuan_magang')
            ->where('status_persetujuan', 'PERBAIKAN_BERKAS')
            ->where('DATE(tgl_persetujuan)', $hariIni)
            ->countAllResults();

        return $stats;
    }

    public function getSekretariatPendingPermohonan()
    {
        $db = \Config\Database::connect();
        return $db->table('t_persetujuan_magang as ps')
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
    }

    // ============================================================
    // DASHBOARD KEPALA BIDANG (KABID)
    // ============================================================
    public function getKabidStats($id_bidang)
    {
        $db = \Config\Database::connect();
        $stats = [];
        
        $mPenempatan = new \App\Models\Kabid\M_Penempatan();
        $stats['total_menunggu'] = $mPenempatan->countPenempatanMenunggu($id_bidang);
        
        $q_berjalan = $db->table('t_penempatan_magang')->where('status_penempatan', 'BERJALAN');
        if ($id_bidang) $q_berjalan->where('id_bidang', $id_bidang);
        $stats['total_berjalan'] = $q_berjalan->countAllResults();
        
        $q_selesai = $db->table('t_penempatan_magang')->where('status_penempatan', 'SELESAI');
        if ($id_bidang) $q_selesai->where('id_bidang', $id_bidang);
        $stats['total_selesai'] = $q_selesai->countAllResults();
        
        $stats['bidang_info'] = null;
        if ($id_bidang) {
            $stats['bidang_info'] = $db->table('m_bidang')
                ->where('id_bidang', $id_bidang)
                ->get()
                ->getRow();
        }
        
        $kuotaRow = $db->table('m_kuota')->where('id_bidang', $id_bidang)->get()->getRow();
        $stats['sisa_kuota'] = 0;
        if ($kuotaRow) {
            $stats['sisa_kuota'] = max(0, $kuotaRow->kuota - $stats['total_berjalan']);
        }
        
        $stats['logbook_list'] = $db->table('t_logbook_magang l')
            ->select('l.id_logbook_magang, l.tgl_logbook, l.logbook_magang, m.nama_mahasiswa')
            ->join('t_penempatan_magang p', 'p.id_penempatan_magang = l.id_penempatan_magang')
            ->join('t_persetujuan_magang ps', 'ps.id_persetujuan_magang = p.id_persetujuan_magang')
            ->join('t_permohonan_magang pm', 'pm.id_permohonan_magang = ps.id_permohonan_magang')
            ->join('m_mahasiswa m', 'm.id_mahasiswa = pm.id_mahasiswa')
            ->where('p.id_bidang', $id_bidang)
            ->where('l.disetujui_oleh', null)
            ->orderBy('l.tgl_logbook', 'ASC')
            ->limit(5)
            ->get()->getResult();
            
        $semua_penempatan = $mPenempatan->getSemuaPenempatan($id_bidang);
        $penempatan_menunggu = array_filter($semua_penempatan, function($p) {
            return $p->status_penempatan == 'MENUNGGU';
        });
        $stats['penempatan_menunggu'] = array_slice($penempatan_menunggu, 0, 5);
        
        $penempatan_berjalan = array_filter($semua_penempatan, function($p) {
            return $p->status_penempatan == 'BERJALAN';
        });
        $stats['penempatan_berjalan'] = array_slice($penempatan_berjalan, 0, 5);
        
        return $stats;
    }

    // ============================================================
    // DASHBOARD MAHASISWA
    // ============================================================
    public function getMahasiswaStats($stateData, $id_mahasiswa)
    {
        $db = \Config\Database::connect();
        $stats = [
            'total_logbook' => 0,
            'target_logbook' => 0,
            'total_hadir' => 0,
            'target_hadir' => 0,
            'nilai_akhir' => '-',
            'predikat_akhir' => 'Belum Ada',
            'file_penerimaan' => null,
            'file_sertifikat' => null,
            'file_piagam' => null
        ];

        if ($stateData['state'] >= 4) {
            $mLogbook = new \App\Models\Mahasiswa\M_Logbook();
            $penempatan = $mLogbook->cekPenempatanAktif($id_mahasiswa);

            if ($penempatan) {
                $id_penempatan = $penempatan['id_penempatan_magang'];

                $stats['total_logbook'] = $db->table('t_logbook_magang')
                    ->where('id_penempatan_magang', $id_penempatan)
                    ->countAllResults();

                $permohonan_aktif = $stateData['permohonan_aktif'];
                if (!empty($permohonan_aktif['tgl_mulai']) && !empty($permohonan_aktif['tgl_selesai'])) {
                    $start = new \DateTime($permohonan_aktif['tgl_mulai']);
                    $end   = new \DateTime($permohonan_aktif['tgl_selesai']);
                    $end->modify('+1 day');
                    $interval  = new \DateInterval('P1D');
                    $dateRange = new \DatePeriod($start, $interval, $end);
                    foreach ($dateRange as $date) {
                        $dow = (int) $date->format('N');
                        if ($dow <= 5) $stats['target_logbook']++;
                    }
                }

                $stats['total_hadir'] = $db->table('t_logbook_magang')
                    ->where('id_penempatan_magang', $id_penempatan)
                    ->where('disetujui_oleh IS NOT NULL', null, false)
                    ->countAllResults();
                $stats['target_hadir'] = $stats['total_logbook'];

                if ($stateData['state'] == 5) {
                    $stats['nilai_akhir'] = '-';
                    $stats['predikat_akhir'] = 'Selesai Magang';
                }
            }
        }

        if (!empty($stateData['permohonan_aktif']) && isset($stateData['permohonan_aktif']['id_persetujuan_magang'])) {
            $dokumen = $db->table('t_file_proses_magang')
                ->where('id_persetujuan_magang', $stateData['permohonan_aktif']['id_persetujuan_magang'])
                ->get()->getResultArray();
                
            foreach ($dokumen as $d) {
                if ($d['id_file'] == 8) {
                    $stats['file_penerimaan'] = $d['path_file'];
                } elseif ($d['id_file'] == 9) {
                    $stats['file_sertifikat'] = $d['path_file'];
                } elseif ($d['id_file'] == 10) {
                    $stats['file_piagam'] = $d['path_file'];
                }
            }
        }

        return $stats;
    }

    // ============================================================
    // DASHBOARD SUPER ADMIN
    // ============================================================
    public function getSuperAdminStats()
    {
        $db = \Config\Database::connect();
        
        $stats = [
            'totalPengguna' => 0,
            'menuAktif' => 0,
            'totalPermohonan' => 0
        ];

        if ($db->tableExists('m_mahasiswa')) {
            $stats['totalPengguna'] = $db->table('m_mahasiswa')->countAllResults();
        }

        if ($db->tableExists('c_menus')) {
            $stats['menuAktif'] = $db->table('c_menus')
                ->where('status', 1)
                ->countAllResults();
        }

        if ($db->tableExists('t_permohonan_magang')) {
            $stats['totalPermohonan'] = $db->table('t_permohonan_magang')->countAllResults();
        }

        return $stats;
    }
}
