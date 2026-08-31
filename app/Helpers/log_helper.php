<?php

if (!function_exists('catat_log')) {
    /**
     * Mencatat log pergerakan permohonan magang
     * 
     * @param int $id_permohonan ID Permohonan Magang
     * @param string $aktor Pihak yang melakukan aksi (Mahasiswa, Sekretariat, Kabid, Sistem)
     * @param string $aksi Judul/Nama Aksi (misal: "Mengajukan Permohonan")
     * @param string|null $catatan Pesan tambahan opsional
     */
    function catat_log($id_permohonan, $aktor, $aksi, $catatan = null)
    {
        $logModel = new \App\Models\Common\LogPermohonanModel();
        
        $data = [
            'id_permohonan_magang' => $id_permohonan,
            'aktor'                => $aktor,
            'aksi'                 => $aksi,
            'catatan'              => $catatan,
            'created_at'           => date('Y-m-d H:i:s')
        ];
        
        $logModel->insert($data);
    }
}

if (!function_exists('tgl_indo')) {
    /**
     * Format tanggal ke format Bahasa Indonesia
     * 
     * @param string|null $date Tanggal dalam format yang bisa diparsing strtotime
     * @param bool $withTime Apakah menyertakan waktu (jam:menit)
     * @return string Tanggal dalam format Indonesia, misal: 07 Agustus 2026
     */
    function tgl_indo($date, $withTime = false)
    {
        if (empty($date)) return '-';

        $bulan = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $timestamp = strtotime($date);
        if ($timestamp === false) return '-';

        $tgl = date('d', $timestamp);
        $bln = (int) date('m', $timestamp);
        $thn = date('Y', $timestamp);

        $result = $tgl . ' ' . ($bulan[$bln] ?? date('F', $timestamp)) . ' ' . $thn;

        if ($withTime) {
            $result .= ', ' . date('H:i', $timestamp);
        }

        return $result;
    }
}
