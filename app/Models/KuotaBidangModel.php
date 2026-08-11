<?php

namespace App\Models;

use CodeIgniter\Model;

class KuotaBidangModel extends Model
{
    protected $table            = 'm_kuota';
    protected $primaryKey       = 'id_kuota';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // Field yang diizinkan untuk proses update kuota oleh sekretariat
    protected $allowedFields    = ['id_bidang', 'tahun', 'bulan', 'kuota', 'status', 'created_at', 'updated_at'];
    protected $useSoftDeletes   = false;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    /**
     * Mengambil daftar master kuota beserta nama bidangnya untuk tabel sekretariat
     */
    public function getKuotaBidangDetail()
    {
        return $this->db->table($this->table)
            ->select('m_kuota.*, m_bidang.bidang')
            ->join('m_bidang', 'm_bidang.id_bidang = m_kuota.id_bidang')
            ->get()->getResultArray();
    }

    /**
     * Menghitung kuota secara per-bulan berdasarkan rentang tanggal penempatan.
     * (Menggunakan tanggal_selesai existing, DIBATALKAN menggunakan updated_at)
     */
    public function getKuotaPerBulan($id_bidang, $tahun = null)
    {
        if (!$tahun) {
            $tahun = date('Y');
        }

        $db = \Config\Database::connect();
        
        // 1. Dapatkan atau buat data master kuota untuk 12 bulan di tahun tersebut
        $kuotaBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $row = $this->where('id_bidang', $id_bidang)
                        ->where('tahun', $tahun)
                        ->where('bulan', $i)
                        ->first();
                        
            if (!$row) {
                // Auto create jika belum ada (default 5)
                $this->insert([
                    'id_bidang' => $id_bidang,
                    'tahun'     => $tahun,
                    'bulan'     => $i,
                    'kuota'     => 5,
                    'status'    => 'AKTIF'
                ]);
                $row = $this->where('id_bidang', $id_bidang)->where('tahun', $tahun)->where('bulan', $i)->first();
            }
            $kuotaBulan[$i] = $row;
        }

        // 2. Ambil semua penempatan yang relevan
        $penempatan = $db->table('t_penempatan_magang')
            ->where('id_bidang', $id_bidang)
            ->where('status_penempatan', 'BERJALAN')
            ->get()->getResultArray();

        $hasil = [];
        $nama_bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        // 3. Hitung overlap per bulan
        for ($i = 1; $i <= 12; $i++) {
            $batas_kuota = (int)$kuotaBulan[$i]['kuota'];
            
            $awalBulan = sprintf('%04d-%02d-01', $tahun, $i);
            $akhirBulan = date('Y-m-t', strtotime($awalBulan));
            
            $terpakai = 0;
            
            foreach ($penempatan as $p) {
                $tgl_mulai = $p['tanggal_mulai'];
                $tgl_selesai = $p['tanggal_selesai'];
                // Logika overlap: (Mulai <= AkhirBulan) AND (Selesai >= AwalBulan)
                if ($tgl_mulai && $tgl_selesai) {
                    if ($tgl_mulai <= $akhirBulan && $tgl_selesai >= $awalBulan) {
                        $terpakai++;
                    }
                }
            }
            
            $sisa = max(0, $batas_kuota - $terpakai);
            $status_kuota = ($sisa > 0) ? 'Tersedia' : 'Penuh';
            
            $hasil[] = [
                'id_kuota'    => $kuotaBulan[$i]['id_kuota'],
                'bulan_angka' => $i,
                'bulan_nama'  => $nama_bulan[$i],
                'batas_kuota' => $batas_kuota,
                'terpakai'    => $terpakai,
                'sisa_kuota'  => $sisa,
                'status'      => $status_kuota
            ];
        }
        
        return $hasil;
    }

    /**
     * Menghitung kuota seluruh bidang untuk satu bulan spesifik.
     * Digunakan oleh aktor Sekretariat untuk monitoring.
     */
    public function getKuotaAllBidangPerBulan($bulan, $tahun = null)
    {
        if (!$tahun) {
            $tahun = date('Y');
        }

        $db = \Config\Database::connect();
        $list_bidang = $db->table('m_bidang')->get()->getResultArray();
        
        $hasil = [];
        foreach ($list_bidang as $bidang) {
            // Get all 12 months for this bidang (auto-creates if missing)
            $kuota_12_bulan = $this->getKuotaPerBulan($bidang['id_bidang'], $tahun);
            
            // Find the specific month
            foreach ($kuota_12_bulan as $k) {
                if ($k['bulan_angka'] == $bulan) {
                    $hasil[] = [
                        'id_bidang'   => $bidang['id_bidang'],
                        'nama_bidang' => $bidang['bidang'],
                        'batas_kuota' => $k['batas_kuota'],
                        'terpakai'    => $k['terpakai'],
                        'sisa_kuota'  => $k['sisa_kuota'],
                        'status'      => $k['status']
                    ];
                    break;
                }
            }
        }
        
        return $hasil;
    }

    /**
     * Menghitung kuota secara per-bulan berdasarkan PRD khusus Sekretariat.
     * Hanya menghitung status_penempatan = BERJALAN.
     */
    public function getKuotaDetailSekretariat($id_bidang, $tahun = null)
    {
        if (!$tahun) {
            $tahun = date('Y');
        }

        $db = \Config\Database::connect();
        
        // 1. Dapatkan atau buat data master kuota untuk 12 bulan di tahun tersebut
        $kuotaBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $row = $this->where('id_bidang', $id_bidang)
                        ->where('tahun', $tahun)
                        ->where('bulan', $i)
                        ->first();
                        
            if (!$row) {
                // Auto create jika belum ada (default 5)
                $this->insert([
                    'id_bidang' => $id_bidang,
                    'tahun'     => $tahun,
                    'bulan'     => $i,
                    'kuota'     => 5,
                    'status'    => 'AKTIF'
                ]);
                $row = $this->where('id_bidang', $id_bidang)->where('tahun', $tahun)->where('bulan', $i)->first();
            }
            $kuotaBulan[$i] = $row;
        }

        // 2. Ambil penempatan KHUSUS BERJALAN
        $penempatan = $db->table('t_penempatan_magang')
            ->where('id_bidang', $id_bidang)
            ->where('status_penempatan', 'BERJALAN')
            ->get()->getResultArray();

        $nama_bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $hasilBulan = [];
        $total_kuota = 0;
        $bulanTerpakaiArr = [];

        // 3. Hitung per bulan (overlap)
        for ($i = 1; $i <= 12; $i++) {
            $batas_kuota = (int)$kuotaBulan[$i]['kuota'];
            $total_kuota += $batas_kuota;
            
            $awalBulan = sprintf('%04d-%02d-01', $tahun, $i);
            $akhirBulan = date('Y-m-t', strtotime($awalBulan));
            
            $terpakaiBulanIni = [];
            
            foreach ($penempatan as $p) {
                $tgl_mulai = $p['tanggal_mulai'];
                $tgl_selesai = $p['tanggal_selesai'];
                
                if ($tgl_mulai && $tgl_selesai) {
                    if ($tgl_mulai <= $akhirBulan && $tgl_selesai >= $awalBulan) {
                        $terpakaiBulanIni[$p['id_penempatan_magang']] = true;
                    }
                }
            }
            
            $terpakai = count($terpakaiBulanIni);
            $sisa = max(0, $batas_kuota - $terpakai);
            $status_kuota = ($sisa > 0) ? 'Tersedia' : 'Penuh';
            
            $hasilBulan[] = [
                'id_kuota'    => $kuotaBulan[$i]['id_kuota'],
                'bulan_angka' => $i,
                'bulan_nama'  => $nama_bulan[$i],
                'batas_kuota' => $batas_kuota,
                'terpakai'    => $terpakai,
                'sisa_kuota'  => $sisa,
                'status'      => $status_kuota
            ];
            
            if ($terpakai > 0) {
                $bulanTerpakaiArr[] = $nama_bulan[$i] . ' &middot; ' . $terpakai;
            }
        }
        
        // 4. Hitung Total Terpakai dalam tahun tersebut (Distinct id_permohonan)
        $terpakaiTahunIni = [];
        $awalTahun = "$tahun-01-01";
        $akhirTahun = "$tahun-12-31";
        foreach ($penempatan as $p) {
            $tgl_mulai = $p['tanggal_mulai'];
            $tgl_selesai = $p['tanggal_selesai'];
            if ($tgl_mulai && $tgl_selesai) {
                if ($tgl_mulai <= $akhirTahun && $tgl_selesai >= $awalTahun) {
                    $terpakaiTahunIni[$p['id_penempatan_magang']] = true;
                }
            }
        }
        $total_terpakai = count($terpakaiTahunIni);
        
        $total_sisa = max(0, $total_kuota - $total_terpakai);
        
        $str_bulan_terpakai = !empty($bulanTerpakaiArr) ? implode(', ', $bulanTerpakaiArr) : 'Belum ada kuota yang terpakai';

        return [
            'kuota_bulan' => $hasilBulan,
            'ringkasan'   => [
                'total_kuota'    => $total_kuota,
                'total_terpakai' => $total_terpakai,
                'total_sisa'     => $total_sisa,
                'bulan_terpakai' => $str_bulan_terpakai
            ]
        ];
    }
}