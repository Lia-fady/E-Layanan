<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;

class C_Bidang extends BaseController
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
            $model = new \App\Models\SuperAdmin\M_Bidang();
            $opdModel = new \App\Models\SuperAdmin\M_Opd();
            $data['bidangList'] = $model->getAllWithRelations();
            $data['opdList'] = $opdModel->where('status', 'aktif')->findAll();
            return $this->renderPage('dashboard/superadmin/bidang/v_index', 'Master Data Bidang', 'bidang', $data);
        }

    public function create()
        {
            $opdModel = new \App\Models\SuperAdmin\M_Opd();
            $data['opdList'] = $opdModel->where('status', 'aktif')->findAll();
            return $this->renderPage('dashboard/superadmin/bidang/v_create', 'Tambah Bidang', 'bidang', $data);
        }

    public function edit($id = null)
        {
            $opdModel = new \App\Models\SuperAdmin\M_Opd();
            $bidangModel = new \App\Models\SuperAdmin\M_Bidang();
            $data['opdList'] = $opdModel->where('status', 'aktif')->findAll();
            $data['bidang'] = $bidangModel->find($id);
            return $this->renderPage('dashboard/superadmin/bidang/v_edit', 'Edit Bidang', 'bidang', $data);
        }

    public function detail($id = null)
        {
            $model = new \App\Models\SuperAdmin\M_Bidang();
            $data['bidang'] = $model->find($id);
            return $this->renderPage('dashboard/superadmin/bidang/v_detail', 'Detail Bidang', 'bidang', $data);
        }

    public function store()
        {
            $model = new \App\Models\SuperAdmin\M_Bidang();
            $data = $this->request->getPost();
            if (empty($data)) return redirect()->back()->with('error', 'Data tidak boleh kosong.');
    
            $data['nama_bidang'] = trim($data['nama_bidang']);
    
            // Cek duplikasi di OPD yang sama
            $existing = $model->where('LOWER(nama_bidang)', strtolower($data['nama_bidang']))
                              ->where('id_opd', $data['id_opd'])
                              ->first();
            if ($existing) return redirect()->back()->withInput()->with('error', 'Nama Bidang sudah digunakan pada OPD tersebut.');
    
            if ($model->insert($data)) {
                return redirect()->to(base_url('superadmin/bidang'))->with('success', 'Data berhasil ditambahkan.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
            }
        }

    public function update($id)
        {
            $model = new \App\Models\SuperAdmin\M_Bidang();
            $data = $this->request->getPost();
            if (empty($data)) return redirect()->back()->with('error', 'Data tidak boleh kosong.');
    
            $data['nama_bidang'] = trim($data['nama_bidang']);
    
            // Cek duplikasi
            $existing = $model->where('LOWER(nama_bidang)', strtolower($data['nama_bidang']))
                              ->where('id_opd', $data['id_opd'])
                              ->where('id_bidang !=', $id)
                              ->first();
            if ($existing) return redirect()->back()->withInput()->with('error', 'Nama Bidang sudah digunakan pada OPD tersebut.');
    
            if ($model->update($id, $data)) {
                return redirect()->to(base_url('superadmin/bidang'))->with('success', 'Data berhasil diupdate.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupdate data.');
            }
        }

    public function delete($id)
        {
            $model = new \App\Models\SuperAdmin\M_Bidang();
            try {
                $model->delete($id);
                return redirect()->to(base_url('superadmin/bidang'))->with('success', 'Data berhasil dihapus.');
            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                return redirect()->to(base_url('superadmin/bidang'))->with('error', 'Data tidak dapat dihapus karena masih digunakan oleh data lain.');
            } catch (\Exception $e) {
                return redirect()->to(base_url('superadmin/bidang'))->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }
}
