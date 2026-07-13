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

use App\Controllers\BaseController;
use App\Models\Sekretariat\M_StatusPermohonan;

class C_StatusPermohonan extends BaseController
{
    protected $statusPermohonanModel;

    public function __construct()
    {
        $this->statusPermohonanModel = new M_StatusPermohonan();
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

        return view('dashboard/sekretariat/v_status_permohonan', $data);
    }
}
