<?php
/**
 * ============================================================
 * Kode      : C_Riwayat.php
 * Path      : Controllers/Sekretariat/C_Riwayat.php
 * Deskripsi : Controller untuk halaman Riwayat Permohonan.
 *             Menampilkan semua permohonan dengan semua status.
 * ============================================================
 */

namespace App\Controllers\Sekretariat;

use App\Controllers\BaseController;
use App\Models\Sekretariat\M_Verifikasi;

class C_Riwayat extends BaseController
{
    protected $verifikasiModel;

    public function __construct()
    {
        $this->verifikasiModel = new M_Verifikasi();
    }

    /**
     * Halaman riwayat semua permohonan.
     */
    public function index()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('t_permohonan_magang as pm');
        $builder->select('
            pm.id_permohonan_magang,
            pm.created_at as tgl_pengajuan,
            mhs.nim,
            mhs.nama_mahasiswa,
            jp.jenis_permohonan,
            ip.instansi_pendidikan,
            COALESCE(ps.status_persetujuan, "MENUNGGU") as status_persetujuan,
            ps.disposisi,
            ps.id_bidang,
            bd.bidang
        ');
        $builder->join('m_mahasiswa as mhs', 'mhs.id_mahasiswa = pm.id_mahasiswa', 'left');
        $builder->join('m_jenis_permohonan as jp', 'jp.id_jenis_permohonan = pm.id_jenis_permohonan', 'left');
        $builder->join('t_instansi_mahasiswa as im', 'im.id_instansi_mahasiswa = pm.id_instansi_mahasiswa', 'left');
        $builder->join('m_instansi_pendidikan as ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan', 'left');
        $builder->join('t_persetujuan_magang as ps', 'ps.id_permohonan_magang = pm.id_permohonan_magang', 'left');
        $builder->join('m_bidang as bd', 'bd.id_bidang = ps.id_bidang', 'left');
        $builder->where('pm.posting_data', 'kirim');
        $builder->orderBy('pm.created_at', 'DESC');

        $data = [
            'title'       => 'Riwayat Permohonan',
            'active_menu' => 'riwayat',
            'permohonan'  => $builder->get()->getResult(),
        ];

        return view('dashboard/sekretariat/v_riwayat', $data);
    }

    /**
     * Setujui permohonan langsung dari halaman riwayat.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function setujui()
    {
        $id_permohonan = $this->request->getPost('id_permohonan_magang');

        $data = [
            'id_permohonan_magang' => $id_permohonan,
            'catatan'              => 'Disetujui dari halaman riwayat',
            'status_persetujuan'   => 'DISETUJUI',
            'created_by'           => session('id_user_pegawai'),
            'updated_by'           => session('id_user_pegawai'),
        ];

        $result = $this->verifikasiModel->simpanVerifikasi($data);

        if ($result) {
            session()->setFlashdata('success', 'Permohonan berhasil disetujui.');
        } else {
            session()->setFlashdata('error', 'Gagal menyetujui permohonan.');
        }

        return redirect()->to(base_url('sekretariat/riwayat'));
    }

    /**
     * Tolak permohonan langsung dari halaman riwayat.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function tolak()
    {
        $id_permohonan = $this->request->getPost('id_permohonan_magang');

        $result = $this->verifikasiModel->kembalikanPermohonan($id_permohonan);

        if ($result) {
            session()->setFlashdata('success', 'Permohonan berhasil ditolak.');
        } else {
            session()->setFlashdata('error', 'Gagal menolak permohonan.');
        }

        return redirect()->to(base_url('sekretariat/riwayat'));
    }
}
