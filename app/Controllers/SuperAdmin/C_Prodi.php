<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;

class C_Prodi extends BaseController
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
            $model = new \App\Models\SuperAdmin\M_Prodi();
            $fakultasModel = new \App\Models\SuperAdmin\M_Fakultas();
            $data['prodiList'] = $model->getAllWithRelations();
            $data['fakultasList'] = $fakultasModel->where('status', 'aktif')->findAll();
            return $this->renderPage('dashboard/superadmin/prodi/v_index', 'Master Data Program Studi', 'program_studi', $data);
        }

    public function create()
        {
            $fakultasModel = new \App\Models\SuperAdmin\M_Fakultas();
            $data['fakultasList'] = $fakultasModel->where('status', 'aktif')->findAll();
            return $this->renderPage('dashboard/superadmin/prodi/v_create', 'Tambah Program Studi', 'program_studi', $data);
        }

    public function edit($id = null)
        {
            $fakultasModel = new \App\Models\SuperAdmin\M_Fakultas();
            $prodiModel = new \App\Models\SuperAdmin\M_Prodi();
            $data['fakultasList'] = $fakultasModel->where('status', 'aktif')->findAll();
            $data['prodi'] = $prodiModel->find($id);
            return $this->renderPage('dashboard/superadmin/prodi/v_edit', 'Edit Program Studi', 'program_studi', $data);
        }

    public function detail($id = null)
        {
            $prodiModel = new \App\Models\SuperAdmin\M_Prodi();
            $data['prodi'] = $prodiModel->find($id);
            return $this->renderPage('dashboard/superadmin/prodi/v_detail', 'Detail Program Studi', 'program_studi', $data);
        }

    public function store()
        {
            $model = new \App\Models\SuperAdmin\M_Prodi();
            $data = $this->request->getPost();
            if (empty($data)) {
                return redirect()->back()->with('error', 'Data tidak boleh kosong.');
            }
            try {
                if ($model->insert($data)) {
                    return redirect()->to(base_url('superadmin/program-studi'))->with('success', 'Data berhasil ditambahkan.');
                } else {
                    return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
                }
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }

    public function update($id)
        {
            $model = new \App\Models\SuperAdmin\M_Prodi();
            $data = $this->request->getPost();
            if (empty($data)) return redirect()->back()->with('error', 'Data tidak boleh kosong.');
            try {
                if ($model->update($id, $data)) {
                    return redirect()->to(base_url('superadmin/program-studi'))->with('success', 'Data berhasil diupdate.');
                } else {
                    return redirect()->back()->withInput()->with('error', 'Gagal mengupdate data.');
                }
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }

    public function delete($id)
        {
            $model = new \App\Models\SuperAdmin\M_Prodi();
            try {
                $model->delete($id);
                return redirect()->to(base_url('superadmin/program-studi'))->with('success', 'Data berhasil dihapus.');
            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                return redirect()->to(base_url('superadmin/program-studi'))->with('error', 'Data tidak dapat dihapus karena masih digunakan oleh data lain.');
            } catch (\Exception $e) {
                return redirect()->to(base_url('superadmin/program-studi'))->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }
}
