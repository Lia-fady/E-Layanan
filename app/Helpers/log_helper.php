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
        $logModel = new \App\Models\LogPermohonanModel();
        
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
