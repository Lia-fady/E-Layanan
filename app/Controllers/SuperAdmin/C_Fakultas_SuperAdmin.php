<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;

class C_Fakultas_SuperAdmin extends BaseController
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
            $model = new \App\Models\SuperAdmin\M_Fakultas_SuperAdmin();
            // Perform JOIN to get instansi_pendidikan name
            $data['fakultasList'] = $model->select('m_fakultas.*, m_instansi_pendidikan.instansi_pendidikan')
                                          ->join('m_instansi_pendidikan', 'm_instansi_pendidikan.id_instansi_pendidikan = m_fakultas.id_instansi_pendidikan', 'left')
                                          ->findAll();
            
            // Get instansi list for inline edit modal
            $instansiModel = new \App\Models\SuperAdmin\M_InstansiPendidikan_SuperAdmin();
            $data['instansiList'] = $instansiModel->where('status', 'aktif')->orWhere('status', '1')->findAll();
            
            return $this->renderPage('dashboard/superadmin/fakultas/v_index', 'Master Data Fakultas', 'fakultas', $data);
        }

    public function create()
        {
            $instansiModel = new \App\Models\SuperAdmin\M_InstansiPendidikan_SuperAdmin();
            $data['instansiList'] = $instansiModel->where('status', 'aktif')->findAll();
            return $this->renderPage('dashboard/superadmin/fakultas/v_create', 'Tambah Fakultas', 'fakultas', $data);
        }

    public function edit($id = null)
        {
            $instansiModel = new \App\Models\SuperAdmin\M_InstansiPendidikan_SuperAdmin();
            $fakultasModel = new \App\Models\SuperAdmin\M_Fakultas_SuperAdmin();
            $data['instansiList'] = $instansiModel->where('status', 'aktif')->findAll();
            $data['fakultas'] = $fakultasModel->find($id);
            return $this->renderPage('dashboard/superadmin/fakultas/v_edit', 'Edit Fakultas', 'fakultas', $data);
        }

    public function detail($id = null)
        {
            $fakultasModel = new \App\Models\SuperAdmin\M_Fakultas_SuperAdmin();
            $data['fakultas'] = $fakultasModel->find($id);
            return $this->renderPage('dashboard/superadmin/fakultas/v_detail', 'Detail Fakultas', 'fakultas', $data);
        }

    public function store()
        {
            $model = new \App\Models\SuperAdmin\M_Fakultas_SuperAdmin();
            $data = $this->request->getPost();
            if (empty($data)) {
                return redirect()->back()->with('error', 'Data tidak boleh kosong.');
            }
            try {
                if ($model->insert($data)) {
                    return redirect()->to(base_url('superadmin/fakultas'))->with('success', 'Data berhasil ditambahkan.');
                } else {
                    return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
                }
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }

    public function update($id)
        {
            $model = new \App\Models\SuperAdmin\M_Fakultas_SuperAdmin();
            $data = $this->request->getPost();
            if (empty($data)) return redirect()->back()->with('error', 'Data tidak boleh kosong.');
            try {
                if ($model->update($id, $data)) {
                    return redirect()->to(base_url('superadmin/fakultas'))->with('success', 'Data berhasil diupdate.');
                } else {
                    return redirect()->back()->withInput()->with('error', 'Gagal mengupdate data.');
                }
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }

    public function delete($id)
        {
            $model = new \App\Models\SuperAdmin\M_Fakultas_SuperAdmin();
            try {
                $model->delete($id);
                return redirect()->to(base_url('superadmin/fakultas'))->with('success', 'Data berhasil dihapus.');
            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                return redirect()->to(base_url('superadmin/fakultas'))->with('error', 'Data tidak dapat dihapus karena masih digunakan oleh data lain.');
            } catch (\Exception $e) {
                return redirect()->to(base_url('superadmin/fakultas'))->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }
}

