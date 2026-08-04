<?php
/**
 * ============================================================
 * Kode      : C_StatusPermohonan.php
 * Path      : Controllers/Sekretariat/C_StatusPermohonan.php
 * Deskripsi : Controller untuk menampilkan halaman status
 *             permohonan magang beserta tracking status
 *             verifikasi, disposisi, dan penempatan
 * ============================================================
 */

namespace App\Controllers\Sekretariat;

use App\Controllers\Shared\C_Base;
use App\Models\Sekretariat\M_StatusPermohonan_Sekretariat;

class C_StatusPermohonan_Sekretariat extends C_Base
{
    protected $statusPermohonanModel;

    public function __construct()
    {
        $this->statusPermohonanModel = new M_StatusPermohonan_Sekretariat();
    }

    /**
     * Halaman utama status permohonan.
     * Menampilkan daftar seluruh permohonan dengan tracking status.
     *
     * @return string
     */
    public function index()
    {
        $data = [
            'title'       => 'Status Permohonan',
            'active_menu' => 'status',
            'permohonan'  => $this->statusPermohonanModel->getAllPermohonan(),
        ];

        return view('sekretariat/V_StatusPermohonan_Sekretariat', $data);
    }
}
