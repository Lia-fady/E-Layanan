<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;

class C_ManajemenMenu_SuperAdmin extends BaseController
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
        $model = new \App\Models\SuperAdmin\M_Menu_SuperAdmin();
        $data['menuList'] = $model->findAll();
        return $this->renderPage('dashboard/superadmin/v_manajemen_menu', 'Manajemen Menu', 'manajemen_menu', $data);
    }

    public function store()
    {
        $model = new \App\Models\SuperAdmin\M_Menu_SuperAdmin();
        $data = $this->request->getPost();
        if (empty($data)) return redirect()->back()->with('error', 'Data tidak boleh kosong.');
        try {
            if (isset($data['status'])) {
                $data['status'] = ($data['status'] == 'on' || $data['status'] == '1') ? 1 : 0;
            } else {
                $data['status'] = 0;
            }
            // default position or parent if needed
            if (empty($data['id_parent'])) $data['id_parent'] = 0;
            
            if ($model->insert($data)) {
                return redirect()->to(base_url('superadmin/manajemen-menu'))->with('success', 'Data berhasil ditambahkan.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update($id)
    {
        $model = new \App\Models\SuperAdmin\M_Menu_SuperAdmin();
        $data = $this->request->getPost();
        if (empty($data)) return redirect()->back()->with('error', 'Data tidak boleh kosong.');
        try {
            if (isset($data['status'])) {
                $data['status'] = ($data['status'] == 'on' || $data['status'] == '1') ? 1 : 0;
            } else {
                $data['status'] = 0;
            }
            if ($model->update($id, $data)) {
                return redirect()->to(base_url('superadmin/manajemen-menu'))->with('success', 'Data berhasil diupdate.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupdate data.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $model = new \App\Models\SuperAdmin\M_Menu_SuperAdmin();
        try {
            $model->delete($id);
            return redirect()->to(base_url('superadmin/manajemen-menu'))->with('success', 'Data berhasil dihapus.');
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            return redirect()->to(base_url('superadmin/manajemen-menu'))->with('error', 'Data tidak dapat dihapus karena masih digunakan oleh data lain.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('superadmin/manajemen-menu'))->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
