<?php
/**
 * ============================================================
 * Kode      : C_Profile.php
 * Path      : Controllers/Sekretariat/C_Profile.php
 * Deskripsi : Controller untuk halaman Profil user Sekretariat.
 *             Menampilkan dan mengupdate data profil.
 * ============================================================
 */

namespace App\Controllers\Sekretariat;

use App\Controllers\BaseController;

class C_Profile extends BaseController
{
    /**
     * Halaman profil user.
     */
    public function index()
    {
        $db = \Config\Database::connect();

        $user = $db->table('c_user_pegawai as u')
            ->select('u.*, b.bidang')
            ->join('m_bidang as b', 'b.id_bidang = u.group_id', 'left')
            ->where('u.id_user_pegawai', session('id_user_pegawai'))
            ->get()
            ->getRow();

        $data = [
            'title'       => 'Profil Saya',
            'active_menu' => '',
            'user'        => $user,
        ];

        return view('dashboard/sekretariat/v_profile', $data);
    }

    /**
     * Update data profil.
     */
    public function update()
    {
        $db = \Config\Database::connect();

        $updateData = [
            'nama_user' => $this->request->getPost('nama_user'),
            'email'     => $this->request->getPost('email'),
            'no_telp'   => $this->request->getPost('no_telp'),
            'nip'       => $this->request->getPost('nip'),
        ];

        $result = $db->table('c_user_pegawai')
            ->where('id_user_pegawai', session('id_user_pegawai'))
            ->update($updateData);

        if ($result) {
            // Update session nama
            session()->set('nama_user', $updateData['nama_user']);
            session()->setFlashdata('success', 'Profil berhasil diperbarui.');
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui profil.');
        }

        return redirect()->to(base_url('sekretariat/profile'));
    }
}
