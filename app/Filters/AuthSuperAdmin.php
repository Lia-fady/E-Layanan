<?php

/**
 * Kode    : AuthSuperAdmin.php
 * Path    : app/Filters/AuthSuperAdmin.php
 * Deskripsi : Filter autentikasi untuk modul Super Admin.
 *             Memeriksa apakah user sudah login DAN memiliki id_user_group = 1 (Super Admin).
 *             Jika belum login, redirect ke halaman login pegawai.
 *             Jika login tapi bukan Super Admin, redirect ke dashboard sesuai role.
 */

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthSuperAdmin implements FilterInterface
{
    /**
     * Cek autentikasi dan otorisasi sebelum request diproses.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek apakah user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('pegawai/login'));
        }

        // Cek apakah user adalah Super Admin (id_user_group = 1)
        $idUserGroup = session()->get('id_user_group');
        if ($idUserGroup != 1) {
            // Redirect ke dashboard sesuai role
            if ($idUserGroup == 2) {
                return redirect()->to(base_url('sekretariat/dashboard'));
            } elseif ($idUserGroup == 3) {
                return redirect()->to(base_url('kabid/dashboard'));
            } else {
                return redirect()->to(base_url('/'));
            }
        }
    }

    /**
     * After filter - tidak ada proses tambahan setelah response.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada implementasi
    }
}
