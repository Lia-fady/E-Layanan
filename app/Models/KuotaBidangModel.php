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
            ->whereIn('status_penempatan', ['MENUNGGU', 'BERJALAN', 'SELESAI', 'DIBATALKAN'])
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
                $status = $p['status_penempatan'];
                
                if ($status === 'DIBATALKAN') {
                    if (!empty($p['updated_at'])) {
                        $tgl_batal = date('Y-m-d', strtotime($p['updated_at']));
                        if ($tgl_batal < $tgl_selesai) {
                            $tgl_selesai = $tgl_batal;
                        }
                    } else {
                        continue;
                    }
                }
                
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
}