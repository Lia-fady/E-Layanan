<?php

namespace App\Controllers\Mahasiswa;

class C_Dashboard_Mahasiswa extends C_Base_Mahasiswa
{
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
                    $file_sertifikat = $d['path_file'];
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

        return view('dashboard/mahasiswa/v_dashboard', $data);
    }
}
