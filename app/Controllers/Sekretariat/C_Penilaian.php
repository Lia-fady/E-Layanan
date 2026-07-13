<?php
/**
 * ============================================================
 * Kode      : C_Penilaian.php
 * Path      : Controllers/Sekretariat/C_Penilaian.php
 * Deskripsi : Controller untuk mengelola penilaian magang mahasiswa,
 *             termasuk form penilaian dan penyimpanan nilai
 * ============================================================
 */

namespace App\Controllers\Sekretariat;

use App\Controllers\BaseController;
use App\Models\Sekretariat\M_Penilaian;

class C_Penilaian extends BaseController
{
    protected $penilaianModel;

    public function __construct()
    {
        $this->penilaianModel = new M_Penilaian();
    }

    /**
     * Halaman utama penilaian magang.
     * Menampilkan daftar mahasiswa aktif yang bisa dinilai.
     *
     * @return string
     */
    public function index()
    {
        $data = [
            'title'       => 'Penilaian Magang',
            'active_menu' => 'penilaian',
            'mahasiswa'   => $this->penilaianModel->getMahasiswaAktif(),
        ];

        return view('dashboard/sekretariat/v_penilaian', $data);
    }

    /**
     * Halaman form penilaian untuk penempatan tertentu.
     *
     * @param int $id_penempatan
     * @return string
     */
    public function form($id_penempatan)
    {
        $detail   = $this->penilaianModel->getDetailPenempatan($id_penempatan);
        $komponen = $this->penilaianModel->getKomponenPenilaian();
        $nilai    = $this->penilaianModel->getNilaiByPenempatan($id_penempatan);

        // Index nilai berdasarkan id_komponen_penilaian untuk kemudahan akses di view
        $nilaiIndexed = [];
        foreach ($nilai as $n) {
            $nilaiIndexed[$n['id_komponen_penilaian']] = $n['nilai'];
        }

        $data = [
            'title'         => 'Form Penilaian',
            'active_menu'   => 'penilaian',
            'detail'        => $detail,
            'komponen'      => $komponen,
            'nilaiIndexed'  => $nilaiIndexed,
            'id_penempatan' => $id_penempatan,
        ];

        return view('dashboard/sekretariat/v_penilaian_form', $data);
    }

    /**
     * Menyimpan data penilaian dari form.
     * Melakukan loop untuk setiap komponen penilaian dan menyimpan nilainya.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function simpan()
    {
        $id_penempatan = $this->request->getPost('id_penempatan_magang');
        $nilaiArray    = $this->request->getPost('nilai');

        if (!empty($nilaiArray) && is_array($nilaiArray)) {
            foreach ($nilaiArray as $komponen_id => $nilai) {
                // Hanya simpan jika nilai tidak kosong
                if ($nilai !== '' && $nilai !== null) {
                    $this->penilaianModel->simpanNilai($id_penempatan, $komponen_id, $nilai);
                }
            }
            session()->setFlashdata('success', 'Data penilaian berhasil disimpan.');
        } else {
            session()->setFlashdata('error', 'Tidak ada data penilaian yang dikirim.');
        }

        return redirect()->to(base_url('sekretariat/penilaian'));
    }
}
