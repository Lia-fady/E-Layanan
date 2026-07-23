<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // 1. Check if logged in
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Role Based Access Control (RBAC) Check
        // If it's a student (mahasiswa), we can skip RBAC check for now as they have their own routes
        if ($session->get('role') === 'mahasiswa') {
            $segments = $request->getUri()->getSegments();
            if (empty($segments) || $segments[0] !== 'mahasiswa') {
                return redirect()->to(base_url('mahasiswa/dashboard'))->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            }
            return;
        }

        // For Pegawai (Admin/Sekretariat/Kabid), check c_menus_privileges
        $id_user_group = $session->get('id_user_group');
        if (!$id_user_group) {
            return redirect()->to(base_url('login'))->with('error', 'Grup pengguna tidak ditemukan.');
        }

        // Get the current URI
        $uri = $request->getUri()->getPath();
        
        // Exclude root/dashboard check if needed, but let's strictly check based on first 2 segments
        $segments = $request->getUri()->getSegments();
        if (count($segments) >= 2) {
            $currentUrl = $segments[0] . '/' . $segments[1]; // e.g. sekretariat/dashboard
        } elseif (count($segments) == 1) {
            $currentUrl = $segments[0];
        } else {
            return; // No segment, probably home
        }

        // Allow some basic routes like logout/api to bypass DB checks
        if (strpos($currentUrl, 'logout') === 0 || strpos($currentUrl, 'api') === 0) {
            return;
        }

        $db = \Config\Database::connect();
        
        // Find matching menus in c_menus (might be duplicates in DB)
        $menus = $db->table('c_menus')->where('url', $currentUrl)->get()->getResultArray();
        
        // If menu exists in DB, check privilege
        if (!empty($menus)) {
            $hasPrivilege = false;

            // If Super Admin (group 1), allow all
            if ($id_user_group == 1) {
                $hasPrivilege = true;
            } else {
                foreach ($menus as $menu) {
                    $privilege = $db->table('c_menus_privileges')
                                    ->where('id_user_group', $id_user_group)
                                    ->where('id_menu', $menu['id'])
                                    ->get()
                                    ->getRowArray();
                    
                    if ($privilege) {
                        $hasPrivilege = true;
                        break;
                    }
                }
            }
                            
            if (!$hasPrivilege) {
                // Deny access securely (throw 403 / 404 instead of infinite redirect loop)
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Akses Ditolak: Anda tidak memiliki izin untuk mengakses halaman tersebut.');
            }
        }
        
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
