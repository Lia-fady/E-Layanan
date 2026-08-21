<?php

namespace App\Models\SuperAdmin;

use CodeIgniter\Model;

class M_Dashboard_SuperAdmin extends Model
{
    /**
     * Dashboard Super Admin — Statistik agregat dari seluruh sistem.
     * Hanya method getSuperAdminStats() yang dimigrasikan.
     * Method dashboard actor lain sudah ada di project utama.
     */

    public function getSuperAdminStats()
    {
        $db = \Config\Database::connect();
        
        $stats = [
            'totalPengguna' => 0,
            'menuAktif' => 0,
            'totalPermohonan' => 0,
            'distribusiPeran' => [],
            'aktivitasTerbaru' => []
        ];

        // Distribusi Peran
        $mahasiswaCount = 0;
        if ($db->tableExists('m_mahasiswa')) {
            $mahasiswaCount = $db->table('m_mahasiswa')->countAllResults();
        }
        
        $pegawaiCounts = [];
        $totalPegawai = 0;
        if ($db->tableExists('c_user_pegawai')) {
            $roles = $db->table('c_user_pegawai')
                ->select('id_user_group, COUNT(id_user_pegawai) as total')
                ->groupBy('id_user_group')
                ->get()
                ->getResultArray();
            foreach ($roles as $r) {
                $groupId = $r['id_user_group'];
                $pegawaiCounts[$groupId] = $r['total'];
                $totalPegawai += $r['total'];
            }
        }

        $stats['totalPengguna'] = $mahasiswaCount + $totalPegawai;

        $stats['distribusiPeran'] = [
            'Mahasiswa' => $mahasiswaCount,
            'Sekretariat' => $pegawaiCounts[2] ?? 0,
            'Kepala Bidang' => $pegawaiCounts[3] ?? 0,
            'Super Admin' => $pegawaiCounts[1] ?? 0
        ];

        if ($db->tableExists('c_menus')) {
            $stats['menuAktif'] = $db->table('c_menus')
                ->where('status', 1)
                ->countAllResults();
        }

        if ($db->tableExists('t_permohonan_magang')) {
            $stats['totalPermohonan'] = $db->table('t_permohonan_magang')->countAllResults();
            
            // Aktivitas Terbaru (mengambil 5 permohonan magang terbaru)
            $stats['aktivitasTerbaru'] = $db->table('t_permohonan_magang as p')
                ->select('p.created_at, m.nama_mahasiswa, jp.jenis_permohonan')
                ->join('m_mahasiswa as m', 'm.id_mahasiswa = p.id_mahasiswa', 'left')
                ->join('m_jenis_permohonan as jp', 'jp.id_jenis_permohonan = p.id_jenis_permohonan', 'left')
                ->orderBy('p.created_at', 'DESC')
                ->limit(5)
                ->get()
                ->getResultArray();
        }

        return $stats;
    }
}
