<?php

/**
 * Kode    : AuthSekretariat.php
 * Path    : app/Filters/AuthSekretariat.php
 * Deskripsi : Filter autentikasi untuk modul Sekretariat.
 *             Memeriksa apakah user sudah login melalui session 'logged_in'.
 *             Jika belum login, user akan di-redirect ke halaman login.
 *             Digunakan sebagai middleware pada route yang memerlukan autentikasi.
 */

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthSekretariat implements FilterInterface
{
    /**
     * Cek autentikasi sebelum request diproses.
     * Jika session 'logged_in' tidak bernilai true,
     * redirect ke halaman login.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('auth/login'));
        }
    }

    /**
     * After filter - tidak ada proses tambahan setelah response.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada implementasi
    }
}
