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
        
        // 1. Dapatkan data master kuota untuk 12 bulan di tahun tersebut (TANPA auto-insert)
        $kuotaBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $row = $this->where('id_bidang', $id_bidang)
                        ->where('tahun', $tahun)
                        ->where('bulan', $i)
                        ->first();
            $kuotaBulan[$i] = $row; // null jika belum ada
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
            $row = $kuotaBulan[$i];
            $has_data = ($row !== null);
            $batas_kuota = $has_data ? (int)$row['kuota'] : null;
            
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
            
            // Tentukan status
            if (!$has_data) {
                $sisa = null;
                $status_kuota = 'Belum Diatur';
            } else {
                $sisa = max(0, $batas_kuota - $terpakai);
                $status_kuota = ($sisa > 0) ? 'Tersedia' : 'Penuh';
            }
            
            $hasil[] = [
                'id_kuota'    => $has_data ? $row['id_kuota'] : null,
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
        
        // 1. Dapatkan data master kuota untuk 12 bulan di tahun tersebut (TANPA auto-insert)
        $kuotaBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $row = $this->where('id_bidang', $id_bidang)
                        ->where('tahun', $tahun)
                        ->where('bulan', $i)
                        ->first();
            $kuotaBulan[$i] = $row; // null jika belum ada
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
            $row = $kuotaBulan[$i];
            $has_data = ($row !== null);
            $batas_kuota = $has_data ? (int)$row['kuota'] : null;
            if ($has_data) {
                $total_kuota += (int)$row['kuota'];
            }
            
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
            
            // Tentukan status
            if (!$has_data) {
                $sisa = null;
                $status_kuota = 'Belum Diatur';
            } else {
                $sisa = max(0, $batas_kuota - $terpakai);
                $status_kuota = ($sisa > 0) ? 'Tersedia' : 'Penuh';
            }
            
            $hasilBulan[] = [
                'id_kuota'    => $has_data ? $row['id_kuota'] : null,
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

    /**
     * Mendapatkan daftar bulan (angka 1-12) yang kuotanya sudah penuh secara global (seluruh bidang)
     */
    public function getBulanPenuhGlobal($tahun = null)
    {
        if (!$tahun) {
            $tahun = date('Y');
        }

        $db = \Config\Database::connect();
        $semuaBidang = $db->table('m_bidang')->get()->getResultArray();
        
        $kuotaPerBidang = [];
        foreach ($semuaBidang as $bidang) {
            $kuotaPerBidang[] = $this->getKuotaPerBulan($bidang['id_bidang'], $tahun);
        }
        
        $bulanPenuh = [];
        for ($i = 1; $i <= 12; $i++) {
            $totalBatas = 0;
            $totalTerpakai = 0;
            foreach ($kuotaPerBidang as $kb) {
                // Cari data bulan ke-$i
                foreach ($kb as $bulanData) {
                    if ($bulanData['bulan_angka'] == $i) {
                        $totalBatas += (int)($bulanData['batas_kuota'] ?? 0);
                        $totalTerpakai += $bulanData['terpakai'];
                        break;
                    }
                }
            }
            if ($totalBatas > 0 && $totalTerpakai >= $totalBatas) {
                $bulanPenuh[] = $i;
            }
        }
        
        return $bulanPenuh;
    }

    /**
     * Mendapatkan daftar tahun yang tersedia dari database + tahun berjalan + tahun berikutnya.
     * Jika $id_bidang diberikan, filter per bidang.
     */
    public function getAvailableYears($id_bidang = null, $requestedYear = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('m_kuota')->select('tahun')->distinct()->orderBy('tahun', 'ASC');
        
        if ($id_bidang) {
            $builder->where('id_bidang', $id_bidang);
        }
        
        $rows = $builder->get()->getResultArray();
        $years = array_map(function($r) { return (int)$r['tahun']; }, $rows);
        
        // Pastikan tahun berjalan dan tahun berikutnya selalu tersedia
        $currentYear = (int)date('Y');
        if (!in_array($currentYear, $years)) {
            $years[] = $currentYear;
        }
        if (!in_array($currentYear + 1, $years)) {
            $years[] = $currentYear + 1;
        }
        
        if ($requestedYear && !in_array((int)$requestedYear, $years)) {
            $years[] = (int)$requestedYear;
        }
        
        sort($years);
        return $years;
    }

    /**
     * Mengambil data kuota satu bulan spesifik beserta terpakai.
     * Digunakan oleh halaman detail Bidang.
     */
    public function getKuotaSingleBulan($id_bidang, $tahun, $bulan)
    {
        $nama_bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        if ($bulan < 1 || $bulan > 12) {
            return null;
        }

        $db = \Config\Database::connect();

        // Ambil record kuota
        $row = $this->where('id_bidang', $id_bidang)
                    ->where('tahun', $tahun)
                    ->where('bulan', $bulan)
                    ->first();

        $has_data = ($row !== null);
        $batas_kuota = $has_data ? (int)$row['kuota'] : null;

        // Hitung terpakai
        $awalBulan = sprintf('%04d-%02d-01', $tahun, $bulan);
        $akhirBulan = date('Y-m-t', strtotime($awalBulan));

        $penempatan = $db->table('t_penempatan_magang')
            ->where('id_bidang', $id_bidang)
            ->where('status_penempatan', 'BERJALAN')
            ->get()->getResultArray();

        $terpakai = 0;
        foreach ($penempatan as $p) {
            $tgl_mulai = $p['tanggal_mulai'];
            $tgl_selesai = $p['tanggal_selesai'];
            if ($tgl_mulai && $tgl_selesai) {
                if ($tgl_mulai <= $akhirBulan && $tgl_selesai >= $awalBulan) {
                    $terpakai++;
                }
            }
        }

        if (!$has_data) {
            $sisa = null;
            $status_kuota = 'Belum Diatur';
        } else {
            $sisa = max(0, $batas_kuota - $terpakai);
            $status_kuota = ($sisa > 0) ? 'Tersedia' : 'Penuh';
        }

        return [
            'id_kuota'    => $has_data ? $row['id_kuota'] : null,
            'bulan_angka' => (int)$bulan,
            'bulan_nama'  => $nama_bulan[$bulan] ?? '',
            'batas_kuota' => $batas_kuota,
            'terpakai'    => $terpakai,
            'sisa_kuota'  => $sisa,
            'status'      => $status_kuota,
            'has_data'    => $has_data
        ];
    }

    /**
     * Simpan kuota (INSERT jika belum ada, UPDATE jika sudah ada).
     * Identitas logis: id_bidang + tahun + bulan.
     */
    public function simpanKuota($id_bidang, $tahun, $bulan, $kuota)
    {
        $existing = $this->where('id_bidang', $id_bidang)
                         ->where('tahun', $tahun)
                         ->where('bulan', $bulan)
                         ->first();

        if ($existing) {
            // UPDATE
            return $this->update($existing['id_kuota'], [
                'kuota'      => $kuota,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            // INSERT
            return $this->insert([
                'id_bidang'  => $id_bidang,
                'tahun'      => $tahun,
                'bulan'      => $bulan,
                'kuota'      => $kuota,
                'status'     => 'AKTIF'
            ]);
        }
    }
}