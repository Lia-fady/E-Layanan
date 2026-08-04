<?php
/**
 * ============================================================
 * Kode      : C_ProfilBidang.php
 * Path      : Controllers/Kabid/C_ProfilBidang.php
 * Deskripsi : Controller untuk halaman Profil Bidang.
 *             Kepala Bidang dapat melihat dan mengedit
 *             informasi bidang yang dikelolanya.
 * ============================================================
 */

namespace App\Controllers\Kabid;

use App\Controllers\BaseController;

class C_ProfilBidang extends BaseController
{
    /**
     * Tampilkan halaman profil bidang.
     */
    public function index()
    {
        $db         = \Config\Database::connect();
        $id_bidang  = session('id_bidang');
        $id_user    = session('id_user_pegawai');

        // Data user yang login
        $user = $db->table('c_user_pegawai')
            ->where('id_user_pegawai', $id_user)
            ->get()->getRow();

        // Data bidang
        $bidang = null;
        if ($id_bidang) {
            $bidang = $db->table('m_bidang as b')
                ->select('b.*, o.opd')
                ->join('m_opd as o', 'o.id_opd = b.id_opd', 'left')
                ->where('b.id_bidang', $id_bidang)
                ->get()->getRow();
        }

        // Statistik bidang
        $total_berjalan = $db->table('t_penempatan_magang')
            ->where('id_bidang', $id_bidang)
            ->where('status_penempatan', 'BERJALAN')
            ->countAllResults();

        $total_selesai = $db->table('t_penempatan_magang')
            ->where('id_bidang', $id_bidang)
            ->where('status_penempatan', 'SELESAI')
            ->countAllResults();

        $total_menunggu = $db->table('t_penempatan_magang')
            ->where('id_bidang', $id_bidang)
            ->where('status_penempatan', 'MENUNGGU')
            ->countAllResults();

        // Kuota bidang
        $kuota = $db->table('m_kuota')
            ->where('id_bidang', $id_bidang)
            ->get()->getRow();

        $data = [
            'title'           => 'Profil Bidang',
            'active_menu'     => 'profil_bidang',
            'user'            => $user,
            'bidang'          => $bidang,
            'total_berjalan'  => $total_berjalan,
            'total_selesai'   => $total_selesai,
            'total_menunggu'  => $total_menunggu,
            'kuota'           => $kuota,
        ];

        return view('dashboard/kabid/v_profil_bidang', $data);
    }

    /**
     * Update nama/deskripsi bidang.
     */
    public function update()
    {
        $db        = \Config\Database::connect();
        $id_bidang = session('id_bidang');

        if (!$id_bidang) {
            return redirect()->back()->with('error', 'Bidang tidak ditemukan.');
        }

        $nama_bidang = $this->request->getPost('bidang');
        if (empty($nama_bidang)) {
            return redirect()->back()->with('error', 'Nama bidang tidak boleh kosong.');
        }

        $db->table('m_bidang')
            ->where('id_bidang', $id_bidang)
            ->update(['bidang' => $nama_bidang]);

        return redirect()->to(base_url('kabid/profil-bidang'))->with('success', 'Profil bidang berhasil diperbarui.');
    }

    /**
     * Update password Kepala Bidang
     */
    public function updatePassword()
    {
        $db = \Config\Database::connect();
        $id_user = session('id_user_pegawai');

        if (!$id_user) {
            return redirect()->back()->with('error', 'Sesi tidak valid, silakan login ulang.');
        }

        $password_lama = $this->request->getPost('password_lama');
        $password_baru = $this->request->getPost('password_baru');
        $konfirmasi_password = $this->request->getPost('konfirmasi_password');

        // Validasi kesamaan password baru dan konfirmasi
        if ($password_baru !== $konfirmasi_password) {
            return redirect()->back()->with('error', 'Password baru dan konfirmasi tidak cocok.');
        }

        $user = $db->table('c_user_pegawai')
            ->where('id_user_pegawai', $id_user)
            ->get()->getRow();

        if (!$user) {
            return redirect()->back()->with('error', 'Data pengguna tidak ditemukan.');
        }

        // Verifikasi password lama
        if (!password_verify($password_lama, $user->password)) {
            return redirect()->back()->with('error', 'Password lama yang Anda masukkan salah.');
        }

        // Update ke password baru
        $hashed_password = password_hash($password_baru, PASSWORD_DEFAULT);
        
        $db->table('c_user_pegawai')
            ->where('id_user_pegawai', $id_user)
            ->update([
                'password' => $hashed_password,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return redirect()->to(base_url('kabid/profil-bidang'))->with('success', 'Kata sandi berhasil diperbarui.');
    }
}
