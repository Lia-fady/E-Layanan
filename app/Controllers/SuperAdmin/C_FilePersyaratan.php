<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;

class C_FilePersyaratan extends BaseController
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
            $filePermohonanModel = new \App\Models\SuperAdmin\M_FilePermohonan();
            $jenisModel = new \App\Models\SuperAdmin\M_JenisPermohonan();
            $data['jenisPermohonanList'] = $jenisModel->findAll();
            $data['fileList'] = $filePermohonanModel->getAllWithRelations();
            return $this->renderPage('dashboard/superadmin/file_persyaratan/v_index', 'Master Data File Persyaratan', 'file_persyaratan', $data);
        }

    public function create()
        {
            $jenisModel = new \App\Models\SuperAdmin\M_JenisPermohonan();
            $fileModel = new \App\Models\SuperAdmin\M_File();
            $data['jenisPermohonanList'] = $jenisModel->findAll();
            $data['fileList'] = $fileModel->findAll();
            return $this->renderPage('dashboard/superadmin/file_persyaratan/v_create', 'Tambah File Persyaratan', 'file_persyaratan', $data);
        }

    public function edit($id = null)
        {
            $filePermohonanModel = new \App\Models\SuperAdmin\M_FilePermohonan();
            $jenisModel = new \App\Models\SuperAdmin\M_JenisPermohonan();
            $fileModel = new \App\Models\SuperAdmin\M_File();
    
            $data['filePermohonan'] = $filePermohonanModel->find($id);
            $data['jenisPermohonanList'] = $jenisModel->findAll();
            $data['fileList'] = $fileModel->findAll();
            return $this->renderPage('dashboard/superadmin/file_persyaratan/v_edit', 'Edit File Persyaratan', 'file_persyaratan', $data);
        }

    public function detail($id = null)
        {
            $filePermohonanModel = new \App\Models\SuperAdmin\M_FilePermohonan();
            $data['file'] = $filePermohonanModel->getAllWithRelations($id);
            return $this->renderPage('dashboard/superadmin/file_persyaratan/v_detail', 'Detail File Persyaratan', 'file_persyaratan', $data);
        }

    public function store()
        {
            $model = new \App\Models\SuperAdmin\M_FilePermohonan();
            $data = $this->request->getPost();
            if (empty($data)) {
                return redirect()->back()->with('error', 'Data tidak boleh kosong.');
            }
            try {
                if ($model->insert($data)) {
                    return redirect()->to(base_url('superadmin/file-persyaratan'))->with('success', 'Data berhasil ditambahkan.');
                } else {
                    return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
                }
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }

    public function update($id)
        {
            $model = new \App\Models\SuperAdmin\M_FilePermohonan();
            $data = $this->request->getPost();
            if (empty($data)) return redirect()->back()->with('error', 'Data tidak boleh kosong.');
            try {
                if ($model->update($id, $data)) {
                    return redirect()->to(base_url('superadmin/file-persyaratan'))->with('success', 'Data berhasil diupdate.');
                } else {
                    return redirect()->back()->withInput()->with('error', 'Gagal mengupdate data.');
                }
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }

    public function delete($id)
        {
            $model = new \App\Models\SuperAdmin\M_FilePermohonan();
            try {
                $model->delete($id);
                return redirect()->to(base_url('superadmin/file-persyaratan'))->with('success', 'Data berhasil dihapus.');
            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                return redirect()->to(base_url('superadmin/file-persyaratan'))->with('error', 'Data tidak dapat dihapus karena masih digunakan oleh data lain.');
            } catch (\Exception $e) {
                return redirect()->to(base_url('superadmin/file-persyaratan'))->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }
}
