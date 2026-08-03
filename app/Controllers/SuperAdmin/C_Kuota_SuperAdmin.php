<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;

class C_Kuota_SuperAdmin extends BaseController
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
            $model = new \App\Models\SuperAdmin\M_Kuota_SuperAdmin();
            $bidangModel = new \App\Models\SuperAdmin\M_Bidang_SuperAdmin();
            $data['bidangList'] = $bidangModel->where('status_aktif', '1')->findAll();
            $data['kuotaList'] = $model->getAllWithRelations();
            return $this->renderPage('dashboard/superadmin/kuota/v_index', 'Master Data Kuota', 'kuota', $data);
        }

    public function create()
        {
            $bidangModel = new \App\Models\SuperAdmin\M_Bidang_SuperAdmin();
            $data['bidangList'] = $bidangModel->where('status_aktif', '1')->findAll();
            return $this->renderPage('dashboard/superadmin/kuota/v_create', 'Tambah Kuota', 'kuota', $data);
        }

    public function edit($id = null)
        {
            $bidangModel = new \App\Models\SuperAdmin\M_Bidang_SuperAdmin();
            $kuotaModel = new \App\Models\SuperAdmin\M_Kuota_SuperAdmin();
            $data['bidangList'] = $bidangModel->where('status_aktif', '1')->findAll();
            $data['kuota'] = $kuotaModel->find($id);
            return $this->renderPage('dashboard/superadmin/kuota/v_edit', 'Edit Kuota', 'kuota', $data);
        }

    public function detail($id = null)
        {
            $model = new \App\Models\SuperAdmin\M_Kuota_SuperAdmin();
            $data['kuota'] = $model->find($id);
            return $this->renderPage('dashboard/superadmin/kuota/v_detail', 'Detail Kuota', 'kuota', $data);
        }

    public function store()
        {
            $model = new \App\Models\SuperAdmin\M_Kuota_SuperAdmin();
            $data = $this->request->getPost();
            if (empty($data)) return redirect()->back()->with('error', 'Data tidak boleh kosong.');
    
            // Cek duplikasi
            $existing = $model->where('id_bidang', $data['id_bidang'])->first();
            if ($existing) return redirect()->back()->withInput()->with('error', 'Data Kuota untuk Bidang tersebut sudah ada.');
    
            if ($model->insert($data)) {
                return redirect()->to(base_url('superadmin/kuota'))->with('success', 'Data berhasil ditambahkan.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
            }
        }

    public function update($id)
        {
            $model = new \App\Models\SuperAdmin\M_Kuota_SuperAdmin();
            $data = $this->request->getPost();
            if (empty($data)) return redirect()->back()->with('error', 'Data tidak boleh kosong.');
    
            // Cek duplikasi
            $existing = $model->where('id_bidang', $data['id_bidang'])->where('id_kuota !=', $id)->first();
            if ($existing) return redirect()->back()->withInput()->with('error', 'Data Kuota untuk Bidang tersebut sudah ada.');
    
            if ($model->update($id, $data)) {
                return redirect()->to(base_url('superadmin/kuota'))->with('success', 'Data berhasil diupdate.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupdate data.');
            }
        }

    public function delete($id)
        {
            $model = new \App\Models\SuperAdmin\M_Kuota_SuperAdmin();
            try {
                $model->delete($id);
                return redirect()->to(base_url('superadmin/kuota'))->with('success', 'Data berhasil dihapus.');
            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                return redirect()->to(base_url('superadmin/kuota'))->with('error', 'Data tidak dapat dihapus karena masih digunakan oleh data lain.');
            } catch (\Exception $e) {
                return redirect()->to(base_url('superadmin/kuota'))->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }
}

