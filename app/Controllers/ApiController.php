<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\FakultasModel;
use App\Models\ProdiModel;

class ApiController extends Controller
{
    public function getFakultasByKampus($id_kampus)
    {
        $fakultasModel = new FakultasModel();
        $fakultas = $fakultasModel->where('id_instansi_pendidikan', $id_kampus)
                                  ->groupStart()
                                    ->where('status', 'aktif')
                                    ->orWhere('status', '1')
                                  ->groupEnd()
                                  ->findAll();
        
        return $this->response->setJSON($fakultas);
    }

    public function getProdiByFakultas($id_fakultas)
    {
        $prodiModel = new ProdiModel();
        $prodi = $prodiModel->where('id_fakultas', $id_fakultas)
                            ->groupStart()
                              ->where('status', 'aktif')
                              ->orWhere('status', '1')
                            ->groupEnd()
                            ->findAll();
        
        return $this->response->setJSON($prodi);
    }

    public function getKabupatenByProvinsi($id_provinsi)
    {
        $db = \Config\Database::connect();
        $kabupaten = $db->table('m_kabupaten')
                        ->where('id_provinsi', $id_provinsi)
                        ->get()
                        ->getResultArray();
        return $this->response->setJSON($kabupaten);
    }

    public function getKecamatanByKabupaten($id_kabupaten)
    {
        $db = \Config\Database::connect();
        $kecamatan = $db->table('m_kecamatan')
                        ->where('id_kabupaten', $id_kabupaten)
                        ->get()
                        ->getResultArray();
        return $this->response->setJSON($kecamatan);
    }

    public function getKelurahanByKecamatan($id_kecamatan)
    {
        $db = \Config\Database::connect();
        $kelurahan = $db->table('m_kelurahan')
                        ->where('id_kecamatan', $id_kecamatan)
                        ->get()
                        ->getResultArray();
        return $this->response->setJSON($kelurahan);
    }
    public function getLogRiwayat($id_permohonan)
    {
        $db = \Config\Database::connect();
        
        $p = $db->table('t_permohonan_magang')
                ->select('t_permohonan_magang.*, 
                          t_persetujuan_magang.status_persetujuan, 
                          t_persetujuan_magang.catatan as catatan_sekretariat, 
                          t_persetujuan_magang.updated_at as waktu_sekretariat, 
                          t_persetujuan_magang.created_at as waktu_sekretariat_fallback,
                          t_penempatan_magang.status_penempatan, 
                          t_penempatan_magang.updated_at as waktu_kabid,
                          t_penempatan_magang.created_at as waktu_kabid_fallback')
                ->join('t_persetujuan_magang', 't_persetujuan_magang.id_permohonan_magang = t_permohonan_magang.id_permohonan_magang', 'left')
                ->join('t_penempatan_magang', 't_penempatan_magang.id_persetujuan_magang = t_persetujuan_magang.id_persetujuan_magang', 'left')
                ->where('t_permohonan_magang.id_permohonan_magang', $id_permohonan)
                ->get()->getRowArray();

        if (!$p) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }

        $bln = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $dataLog = [];

        // 1. PENGIRIMAN (MAHASISWA)
        if ($p['posting_data'] == 'kirim') {
            $tglAju = strtotime($p['created_at']);
            $dataLog[] = [
                'color_class' => 'bg-primary',
                'icon' => 'bi-send-fill',
                'tanggal_format' => date('d', $tglAju) . ' ' . $bln[(int)date('m', $tglAju)] . ' ' . date('Y, H:i', $tglAju) . ' WIB',
                'aktor' => 'Anda (Pemohon)',
                'aksi' => 'Mengirimkan permohonan',
                'catatan' => ''
            ];
        } else {
            $tglAju = strtotime($p['created_at']);
            $dataLog[] = [
                'color_class' => 'bg-secondary',
                'icon' => 'bi-file-earmark',
                'tanggal_format' => date('d', $tglAju) . ' ' . $bln[(int)date('m', $tglAju)] . ' ' . date('Y, H:i', $tglAju) . ' WIB',
                'aktor' => 'Anda (Pemohon)',
                'aksi' => 'Menyimpan sebagai Draft',
                'catatan' => ''
            ];
            return $this->response->setJSON(['status' => 'success', 'data' => $dataLog]);
        }

        // 2. VERIFIKASI SEKRETARIAT
        if (!empty($p['status_persetujuan'])) {
            $waktuSekreRaw = !empty($p['waktu_sekretariat']) ? $p['waktu_sekretariat'] : $p['waktu_sekretariat_fallback'];
            $waktuSekre = strtotime($waktuSekreRaw);
            $fmtWaktuSekre = date('d', $waktuSekre) . ' ' . $bln[(int)date('m', $waktuSekre)] . ' ' . date('Y, H:i', $waktuSekre) . ' WIB';
            
            if ($p['status_persetujuan'] == 'DISETUJUI') {
                $dataLog[] = [
                    'color_class' => 'bg-success',
                    'icon' => 'bi-check-all',
                    'tanggal_format' => $fmtWaktuSekre,
                    'aktor' => 'Sekretariat',
                    'aksi' => 'Menyetujui verifikasi berkas',
                    'catatan' => ''
                ];
            } elseif ($p['status_persetujuan'] == 'PERBAIKAN_BERKAS') {
                $dataLog[] = [
                    'color_class' => 'bg-warning text-dark',
                    'icon' => 'bi-pencil-square',
                    'tanggal_format' => $fmtWaktuSekre,
                    'aktor' => 'Sekretariat',
                    'aksi' => 'Mengembalikan berkas untuk direvisi',
                    'catatan' => $p['catatan_sekretariat'] ?? ''
                ];
            } elseif ($p['status_persetujuan'] == 'DITOLAK') {
                $dataLog[] = [
                    'color_class' => 'bg-danger',
                    'icon' => 'bi-x-circle',
                    'tanggal_format' => $fmtWaktuSekre,
                    'aktor' => 'Sekretariat',
                    'aksi' => 'Menolak permohonan',
                    'catatan' => $p['catatan_sekretariat'] ?? ''
                ];
            }
        }

        // 3. PENEMPATAN KABID
        if (!empty($p['status_penempatan'])) {
            $waktuKabidRaw = !empty($p['waktu_kabid']) ? $p['waktu_kabid'] : $p['waktu_kabid_fallback'];
            $waktuKabid = strtotime($waktuKabidRaw);
            $fmtWaktuKabid = date('d', $waktuKabid) . ' ' . $bln[(int)date('m', $waktuKabid)] . ' ' . date('Y, H:i', $waktuKabid) . ' WIB';
            
            if ($p['status_penempatan'] == 'DISETUJUI' || $p['status_penempatan'] == 'BERJALAN' || $p['status_penempatan'] == 'SELESAI') {
                $dataLog[] = [
                    'color_class' => 'bg-success',
                    'icon' => 'bi-building-check',
                    'tanggal_format' => $fmtWaktuKabid,
                    'aktor' => 'Kepala Bidang',
                    'aksi' => 'Menyetujui disposisi penempatan magang',
                    'catatan' => ''
                ];
            }
            if ($p['status_penempatan'] == 'SELESAI') {
                $dataLog[] = [
                    'color_class' => 'bg-info',
                    'icon' => 'bi-flag-fill',
                    'tanggal_format' => $fmtWaktuKabid, // Waktu selesai akan sama dengan update terakhir
                    'aktor' => 'Sistem / Kepala Bidang',
                    'aksi' => 'Kegiatan Magang / PKL Selesai',
                    'catatan' => 'Masa kegiatan telah diselesaikan.'
                ];
            } elseif ($p['status_penempatan'] == 'DITOLAK') {
                $dataLog[] = [
                    'color_class' => 'bg-danger',
                    'icon' => 'bi-x-circle',
                    'tanggal_format' => $fmtWaktuKabid,
                    'aktor' => 'Kepala Bidang',
                    'aksi' => 'Menolak penempatan magang',
                    'catatan' => ''
                ];
            }
        }

        return $this->response->setJSON(['status' => 'success', 'data' => $dataLog]);
    }
}
