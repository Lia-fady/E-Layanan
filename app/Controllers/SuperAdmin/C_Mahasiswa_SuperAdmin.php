<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;

class C_Mahasiswa_SuperAdmin extends BaseController
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
        $model = new \App\Models\SuperAdmin\M_Mahasiswa_SuperAdmin();
        $data['mahasiswaList'] = $model->getAllWithRelations();
        return $this->renderPage('dashboard/superadmin/mahasiswa/v_index', 'Master Data Mahasiswa', 'mahasiswa', $data);
    }

    public function create()
    {
        return $this->renderPage('dashboard/superadmin/mahasiswa/v_create', 'Tambah Mahasiswa', 'mahasiswa');
    }

    public function edit($id = null)
    {
        $model = new \App\Models\SuperAdmin\M_Mahasiswa_SuperAdmin();
        $data['mahasiswa'] = $model->find($id);
        return $this->renderPage('dashboard/superadmin/mahasiswa/v_edit', 'Edit Mahasiswa', 'mahasiswa', $data);
    }

    public function detail($id = null)
    {
        $model = new \App\Models\SuperAdmin\M_Mahasiswa_SuperAdmin();
        $data['mahasiswa'] = $model->find($id);
        return $this->renderPage('dashboard/superadmin/mahasiswa/v_detail', 'Detail Mahasiswa', 'mahasiswa', $data);
    }

    public function store()
    {
        $model = new \App\Models\SuperAdmin\M_Mahasiswa_SuperAdmin();
        $data = $this->request->getPost();
        if (empty($data)) {
            return redirect()->back()->with('error', 'Data tidak boleh kosong.');
        }
        try {
            if ($model->insert($data)) {
                return redirect()->to(base_url('superadmin/mahasiswa'))->with('success', 'Data berhasil ditambahkan.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update($id)
    {
        $model = new \App\Models\SuperAdmin\M_Mahasiswa_SuperAdmin();
        $data = $this->request->getPost();
        if (empty($data)) return redirect()->back()->with('error', 'Data tidak boleh kosong.');
        try {
            if ($model->update($id, $data)) {
                return redirect()->to(base_url('superadmin/mahasiswa'))->with('success', 'Data berhasil diupdate.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupdate data.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $model = new \App\Models\SuperAdmin\M_Mahasiswa_SuperAdmin();
        try {
            $model->delete($id);
            return redirect()->to(base_url('superadmin/mahasiswa'))->with('success', 'Data berhasil dihapus.');
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            return redirect()->to(base_url('superadmin/mahasiswa'))->with('error', 'Data tidak dapat dihapus karena masih digunakan oleh data lain.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('superadmin/mahasiswa'))->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
