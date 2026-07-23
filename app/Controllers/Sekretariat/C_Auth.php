<?php

/**
 * Kode    : C_Auth.php
 * Path    : app/Controllers/Sekretariat/C_Auth.php
 * Deskripsi : Controller autentikasi untuk modul Sekretariat.
 *             Menangani proses login (tampil form & validasi kredensial),
 *             pengaturan session user, dan proses logout.
 *             Menggunakan model M_Auth untuk verifikasi data login.
 */

namespace App\Controllers\Sekretariat;

use App\Controllers\BaseController;
use App\Models\Sekretariat\M_Auth;

class C_Auth extends BaseController
{
    protected $authModel;

    public function __construct()
    {
        $this->authModel = new M_Auth();
    }

    /**
     * Redirect ke halaman login.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function index()
    {
        return redirect()->to(base_url('auth/login'));
    }

    /**
     * Menampilkan halaman login (GET) atau memproses login (POST).
     *
     * GET  : Menampilkan view v_login.php
     * POST : Memvalidasi input, memverifikasi kredensial melalui M_Auth,
     *        mengatur session jika valid, atau menampilkan pesan error jika gagal.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function login()
    {
        // Jika sudah login, redirect ke dashboard
        if (session()->get('logged_in')) {
            if (session()->get('group_id') == 3) {
                return redirect()->to(base_url('kabid/dashboard'));
            }
            return redirect()->to(base_url('sekretariat/dashboard'));
        }

        // Jika bukan POST request, tampilkan halaman login
        if (!$this->request->is('post')) {
            return view('auth/v_login');
        }

        // Proses POST - Validasi input
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Validasi field tidak kosong
        if (empty($username) || empty($password)) {
            session()->setFlashdata('error', 'Username dan password harus diisi.');
            return redirect()->to(base_url('auth/login'));
        }

        // Verifikasi kredensial melalui model
        $user = $this->authModel->login($username, $password);
        

        if ($user) {
            // Ambil nama role dari tabel c_user_group
            $db = \Config\Database::connect();
            $group = $db->table('c_user_group')
                ->where('id', $user['id_user_group'])
                ->get()
                ->getRow();

            $roleName = $group ? $group->group : 'Sekretariat';

            // Login berhasil - Set session variables
            $sessionData = [
                'id_user_pegawai' => $user['id_user_pegawai'],
                'username'        => $user['nip'],
                'nama_user'       => $user['nama'],
                'group_id'        => $user['id_user_group'],
                'id_bidang'       => $user['id_bidang'],
                'role_name'       => $roleName,
                'logged_in'       => true,
            ];
            session()->set($sessionData);

            // Redirect berdasarkan role/group_id
            if ($user['id_user_group'] == 3) {
                // Kepala Bidang → dashboard kabid
                return redirect()->to(base_url('kabid/dashboard'));
            }

            // Sekretariat / Superadmin → dashboard sekretariat
            return redirect()->to(base_url('sekretariat/dashboard'));
        }

        // Login gagal
        session()->setFlashdata('error', 'Username atau password salah.');
        return redirect()->to(base_url('auth/login'));
    }

    /**
     * Proses logout.
     * Menghapus seluruh data session dan redirect ke halaman login.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('auth/login'));
    }
}
