<?php
/**
 * ============================================================
 * Kode      : C_Placeholder.php
 * Path      : Controllers/Sekretariat/C_Placeholder.php
 * Deskripsi : Controller untuk halaman placeholder yang sedang
 *             dalam pengembangan (Permohonan Masuk, Laporan,
 *             Pengaturan).
 * ============================================================
 */

namespace App\Controllers\Sekretariat;

use App\Controllers\Shared\C_Base;
class C_Placeholder_Sekretariat extends C_Base
{
    /**
     * Halaman Permohonan Masuk (placeholder).
     *
     * @return string
     */
    public function permohonanMasuk()
    {
        $data = [
            'title'       => 'Permohonan Masuk',
            'active_menu' => 'permohonan_masuk',
        ];

        return view('sekretariat/V_Placeholder_Sekretariat', $data);
    }

    /**
     * Halaman Laporan (placeholder).
     *
     * @return string
     */
    public function laporan()
    {
        $data = [
            'title'       => 'Laporan',
            'active_menu' => 'laporan',
        ];

        return view('sekretariat/V_Placeholder_Sekretariat', $data);
    }

    /**
     * Halaman Pengaturan (placeholder).
     *
     * @return string
     */
    public function pengaturan()
    {
        $data = [
            'title'       => 'Pengaturan',
            'active_menu' => 'pengaturan',
        ];

        return view('sekretariat/V_Placeholder_Sekretariat', $data);
    }
}
