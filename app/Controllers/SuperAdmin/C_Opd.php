<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;

class C_Opd extends BaseController
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
            $model = new \App\Models\SuperAdmin\M_Opd();
            $data['opdList'] = $model->findAll();
            return $this->renderPage('dashboard/superadmin/odp/v_index', 'Master Data OPD', 'opd', $data);
        }

    public function create()
        {
            return $this->renderPage('dashboard/superadmin/odp/v_create', 'Tambah OPD', 'odp');
        }

    public function edit($id = null)
        {
            $model = new \App\Models\SuperAdmin\M_Opd();
            $data['opd'] = $model->find($id);
            return $this->renderPage('dashboard/superadmin/odp/v_edit', 'Edit OPD', 'opd', $data);
        }

    public function detail($id = null)
        {
            $model = new \App\Models\SuperAdmin\M_Opd();
            $data['opd'] = $model->find($id);
            return $this->renderPage('dashboard/superadmin/odp/v_detail', 'Detail OPD', 'opd', $data);
        }

    public function store()
        {
            $model = new \App\Models\SuperAdmin\M_Opd();
            $data = $this->request->getPost();
            if (empty($data)) {
                return redirect()->back()->with('error', 'Data tidak boleh kosong.');
            }
            try {
                if ($model->insert($data)) {
                    return redirect()->to(base_url('superadmin/opd'))->with('success', 'Data berhasil ditambahkan.');
                } else {
                    return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
                }
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }

    public function update($id)
        {
            $model = new \App\Models\SuperAdmin\M_Opd();
            $data = $this->request->getPost();
            if (empty($data)) return redirect()->back()->with('error', 'Data tidak boleh kosong.');
    
            $data['opd'] = trim($data['opd']);
            
            // Cek duplikasi
            $existing = $model->where('LOWER(opd)', strtolower($data['opd']))->where('id_opd !=', $id)->first();
            if ($existing) return redirect()->back()->withInput()->with('error', 'Data OPD sudah tersedia.');
    
            if ($model->update($id, $data)) {
                return redirect()->to(base_url('superadmin/opd'))->with('success', 'Data berhasil diupdate.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupdate data.');
            }
        }

    public function delete($id)
        {
            $model = new \App\Models\SuperAdmin\M_Opd();
            try {
                $model->delete($id);
                return redirect()->to(base_url('superadmin/opd'))->with('success', 'Data berhasil dihapus.');
            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                return redirect()->to(base_url('superadmin/opd'))->with('error', 'Data tidak dapat dihapus karena masih digunakan oleh data lain.');
            } catch (\Exception $e) {
                return redirect()->to(base_url('superadmin/opd'))->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }
}
