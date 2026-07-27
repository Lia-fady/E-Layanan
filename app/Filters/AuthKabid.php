<?php

/**
 * Kode    : AuthKabid.php
 * Path    : app/Filters/AuthKabid.php
 * Deskripsi : Filter autentikasi untuk modul Kepala Bidang.
 *             Memeriksa apakah user sudah login dan memiliki group_id == 3
 *             (Bidang E-Gov / Kepala Bidang).
 *             Jika tidak memenuhi syarat, user akan di-redirect ke halaman login.
 */

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthKabid implements FilterInterface
{
    /**
     * Cek autentikasi dan otorisasi sebelum request diproses.
     * User harus logged_in DAN memiliki group_id == 3.
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

        // Cek apakah user memiliki role Kepala Bidang (group_id == 3)
        if (session()->get('group_id') != 3) {
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
