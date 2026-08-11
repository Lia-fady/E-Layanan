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
    protected $allowedFields    = ['id_bidang', 'kuota', 'status_aktif'];

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
     * Mengambil daftar rekapitulasi kuota bulanan untuk tahun tertentu
     */
    public function getRekapKuotaBulanan($id_bidang, $tahun)
    {
        // Ambil limit kuota dari m_kuota
        $kuotaRow = $this->where('id_bidang', $id_bidang)->where('status', 'AKTIF')->first();
        if (!$kuotaRow) {
            return [];
        }
        
        $total_kuota = (int) $kuotaRow['kuota'];
        
        $rekap = [];
        $bulan_nama = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        for ($b = 1; $b <= 12; $b++) {
            // Tentukan hari pertama dan hari terakhir bulan tersebut
            $start_date = sprintf("%04d-%02d-01", $tahun, $b);
            $end_date = date("Y-m-t", strtotime($start_date));

            // Hitung mahasiswa yg aktif di bulan tsb
            $terpakai = $this->db->table('t_penempatan_magang')
                ->where('id_bidang', $id_bidang)
                ->whereIn('status_penempatan', ['MENUNGGU', 'BERJALAN', 'SELESAI'])
                ->where("tanggal_mulai <= '$end_date'", null, false)
                ->where("tanggal_selesai >= '$start_date'", null, false)
                ->countAllResults();

            $rekap[] = [
                'bulan_angka' => $b,
                'bulan_nama'  => $bulan_nama[$b],
                'kuota'       => $total_kuota,
                'terpakai'    => $terpakai,
                'sisa'        => max(0, $total_kuota - $terpakai)
            ];
        }

        return $rekap;
    }

    /**
     * Mengecek ketersediaan kuota untuk rentang tanggal tertentu.
     * Return: array ['status' => true/false, 'pesan' => '...']
     */
    public function checkKetersediaanPeriode($id_bidang, $tgl_mulai, $tgl_selesai)
    {
        if (empty($tgl_mulai) || empty($tgl_selesai)) return ['status' => true, 'pesan' => ''];
        
        $start_ts = strtotime($tgl_mulai);
        $end_ts = strtotime($tgl_selesai);
        
        if ($start_ts > $end_ts) {
            return ['status' => false, 'pesan' => 'Format tanggal tidak valid.'];
        }

        $start_year = (int) date('Y', $start_ts);
        $start_month = (int) date('n', $start_ts);
        $end_year = (int) date('Y', $end_ts);
        $end_month = (int) date('n', $end_ts);

        // Kumpulkan bulan-bulan yang akan dilalui
        $bulan_dilalui = [];
        for ($y = $start_year; $y <= $end_year; $y++) {
            $m_start = ($y == $start_year) ? $start_month : 1;
            $m_end = ($y == $end_year) ? $end_month : 12;
            
            $rekap_tahun = $this->getRekapKuotaBulanan($id_bidang, $y);
            if (empty($rekap_tahun)) {
                return ['status' => false, 'pesan' => 'Bidang belum memiliki pengaturan kuota.'];
            }

            for ($m = $m_start; $m <= $m_end; $m++) {
                $sisa = $rekap_tahun[$m - 1]['sisa'];
                $nama_bulan = $rekap_tahun[$m - 1]['bulan_nama'];
                
                if ($sisa <= 0) {
                    $bulan_dilalui[] = "$nama_bulan $y (Penuh)";
                }
            }
        }

        if (count($bulan_dilalui) > 0) {
            return [
                'status' => false,
                'pesan'  => '⚠️ Kuota penuh pada periode: ' . implode(', ', $bulan_dilalui)
            ];
        }

        return ['status' => true, 'pesan' => 'Kuota tersedia.'];
    }
}