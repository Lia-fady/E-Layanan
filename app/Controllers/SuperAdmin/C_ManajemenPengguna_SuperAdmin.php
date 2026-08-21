<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;

class C_ManajemenPengguna_SuperAdmin extends BaseController
{
    /**
     * Helper: Render halaman dengan layout L_master (SB Admin 2)
     */
    private function renderPage(string $view, string $title, string $activeMenu, array $data = []): string
    {
        $pageData = array_merge($data, [
            'title'       => $title,
            'active_menu' => $activeMenu,
        ]);

        return view($view, $pageData);
    }

    public function index()
    {
        $model = new \App\Models\SuperAdmin\M_Pengguna_SuperAdmin();
        $users = $model->getAllWithGroup();

        $db = \Config\Database::connect();
        $userGroups = $db->table('c_user_group')->get()->getResultArray();

        $data = [
            'users' => $users,
            'userGroups' => $userGroups
        ];
        return $this->renderPage('dashboard/superadmin/v_manajemen_pengguna', 'Manajemen Pengguna', 'manajemen_pengguna', $data);
    }

    public function store()
    {
        $model = new \App\Models\SuperAdmin\M_Pengguna_SuperAdmin();
        $data = $this->request->getPost();
        if (empty($data)) return redirect()->back()->with('error', 'Data tidak boleh kosong.');
        try {
            if (isset($data['password']) && !empty($data['password'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }
            if ($model->insert($data)) {
                return redirect()->to(base_url('superadmin/manajemen-pengguna'))->with('success', 'Data berhasil ditambahkan.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update($id)
    {
        $model = new \App\Models\SuperAdmin\M_Pengguna_SuperAdmin();
        $data = $this->request->getPost();
        if (empty($data)) return redirect()->back()->with('error', 'Data tidak boleh kosong.');
        try {
            if (isset($data['password']) && !empty($data['password'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            } else {
                unset($data['password']); // Jangan update password jika kosong
            }
            if ($model->update($id, $data)) {
                return redirect()->to(base_url('superadmin/manajemen-pengguna'))->with('success', 'Data berhasil diupdate.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupdate data.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $model = new \App\Models\SuperAdmin\M_Pengguna_SuperAdmin();
        try {
            $model->delete($id);
            return redirect()->to(base_url('superadmin/manajemen-pengguna'))->with('success', 'Data berhasil dihapus.');
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            return redirect()->to(base_url('superadmin/manajemen-pengguna'))->with('error', 'Data tidak dapat dihapus karena masih digunakan oleh data lain.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('superadmin/manajemen-pengguna'))->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
