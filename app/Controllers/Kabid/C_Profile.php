<?php
/**
 * ============================================================
 * Kode      : C_Profile.php
 * Path      : Controllers/Kabid/C_Profile.php
 * Deskripsi : Controller untuk halaman Profil user Kabid.
 *             Menampilkan dan mengupdate data profil.
 * ============================================================
 */

namespace App\Controllers\Kabid;

use App\Controllers\BaseController;

class C_Profile extends BaseController
{
    /**
     * Halaman profil user Kabid.
     */
    public function index()
    {
        $db = \Config\Database::connect();

        $user = $db->table('c_user_pegawai as u')
            ->select('u.*, b.bidang')
            ->join('m_bidang as b', 'b.id_bidang = u.id_bidang', 'left')
            ->where('u.id_user_pegawai', session('id_pegawai'))
            ->get()
            ->getRow();

        $data = [
            'title'       => 'Profil Saya',
            'active_menu' => '',
            'user'        => $user,
        ];

        return view('dashboard/kabid/v_profile', $data);
    }

    /**
     * Update data profil Kabid.
     */
    public function update()
    {
        $db = \Config\Database::connect();

        // Validation rules
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama' => 'required|min_length[2]|max_length[150]',
            'email'     => 'required|valid_email',
            'no_telp'   => 'required|min_length[5]|max_length[20]',
            'foto'      => 'if_exist|is_image[foto]|max_size[foto,2048]',
        ]);

        if (! $validation->withRequest($this->request)->run()) {
            // Validation failed
            session()->setFlashdata('error', $validation->listErrors());
            return redirect()->back()->withInput();
        }

        $updateData = [
            'nama' => $this->request->getPost('nama'),
            'email'     => $this->request->getPost('email'),
            'no_telp'   => $this->request->getPost('no_telp'),
        ];

        // Handle optional foto upload
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && ! $foto->hasMoved()) {
            $newName = $foto->getRandomName();
            $foto->move(WRITEPATH . 'uploads/profile/', $newName);
            $updateData['foto'] = $newName;
        }

        $result = $db->table('c_user_pegawai')
            ->where('id_user_pegawai', session('id_user_pegawai'))
            ->update($updateData);

        if ($result) {
            session()->set('nama', $updateData['nama']);
            session()->setFlashdata('success', 'Profil berhasil diperbarui.');
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui profil.');
        }

        return redirect()->to(base_url('kabid/profile'));
    }
}
?>
