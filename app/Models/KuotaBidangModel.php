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
     * Mengambil sisa kuota untuk bidang tertentu
     */
    public function getSisaKuota($id_bidang)
    {
        // Ambil kapasitas kuota dari m_kuota
        $kuotaRow = $this->where('id_bidang', $id_bidang)->where('status_aktif', '1')->first();
        if (!$kuotaRow) {
            return ['total_kuota' => 0, 'terpakai' => 0, 'sisa' => 0];
        }
        
        $total_kuota = (int) $kuotaRow['kuota'];

        // Hitung mahasiswa yang sedang aktif (BERJALAN) di bidang tersebut
        $terpakai = $this->db->table('t_penempatan_magang')
            ->where('id_bidang', $id_bidang)
            ->where('status_penempatan', 'BERJALAN')
            ->countAllResults();

        $sisa = max(0, $total_kuota - $terpakai);

        return [
            'total_kuota' => $total_kuota,
            'terpakai'    => $terpakai,
            'sisa'        => $sisa
        ];
    }
}