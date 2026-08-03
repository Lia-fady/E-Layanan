<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;

class C_UserMahasiswa_SuperAdmin extends BaseController
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
            $model = new \App\Models\SuperAdmin\M_UserMahasiswa_SuperAdmin();
            $data['userMahasiswaList'] = $model->getAllWithRelations();
            return $this->renderPage('dashboard/superadmin/user_mahasiswa/v_index', 'Manajemen User Mahasiswa', 'user-mahasiswa', $data);
        }

    public function create()
        {
            $mahasiswaModel = new \App\Models\SuperAdmin\M_Mahasiswa_SuperAdmin();
            $userMahasiswaModel = new \App\Models\SuperAdmin\M_UserMahasiswa_SuperAdmin();
            $taken = $userMahasiswaModel->select('id_mahasiswa')->findAll();
            $takenIds = array_column($taken, 'id_mahasiswa');
            if (!empty($takenIds)) {
                $data['mahasiswaList'] = $mahasiswaModel
                    ->whereNotIn('id_mahasiswa', $takenIds)
                    ->orderBy('nama_mahasiswa', 'ASC')
                    ->findAll();
            } else {
                $data['mahasiswaList'] = $mahasiswaModel->orderBy('nama_mahasiswa', 'ASC')->findAll();
            }
            return $this->renderPage('dashboard/superadmin/user_mahasiswa/v_create', 'Tambah User Mahasiswa', 'user_mahasiswa', $data);
        }

    public function edit($id = null)
        {
            $model = new \App\Models\SuperAdmin\M_UserMahasiswa_SuperAdmin();
            $data['userMahasiswa'] = $model->find($id);
            return $this->renderPage('dashboard/superadmin/user_mahasiswa/v_edit', 'Edit User Mahasiswa', 'user_mahasiswa', $data);
        }

    public function detail($id = null)
        {
            $model = new \App\Models\SuperAdmin\M_UserMahasiswa_SuperAdmin();
            $data['userMahasiswa'] = $model->find($id);
            return $this->renderPage('dashboard/superadmin/user_mahasiswa/v_detail', 'Detail User Mahasiswa', 'user_mahasiswa', $data);
        }

    public function store()
        {
            $model = new \App\Models\SuperAdmin\M_UserMahasiswa_SuperAdmin();
            $data = $this->request->getPost();
            if (empty($data)) {
                return redirect()->back()->with('error', 'Data tidak boleh kosong.');
            }
            try {
                if (isset($data['password']) && !empty($data['password'])) {
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                }
                if ($model->insert($data)) {
                    return redirect()->to(base_url('superadmin/user-mahasiswa'))->with('success', 'Data berhasil ditambahkan.');
                } else {
                    return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
                }
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }

    public function update($id)
        {
            $model = new \App\Models\SuperAdmin\M_UserMahasiswa_SuperAdmin();
            $data = $this->request->getPost();
            if (empty($data)) return redirect()->back()->with('error', 'Data tidak boleh kosong.');
            try {
                if (isset($data['password']) && !empty($data['password'])) {
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                } else {
                    unset($data['password']);
                }
                if ($model->update($id, $data)) {
                    return redirect()->to(base_url('superadmin/user-mahasiswa'))->with('success', 'Data berhasil diupdate.');
                } else {
                    return redirect()->back()->withInput()->with('error', 'Gagal mengupdate data.');
                }
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }

    public function delete($id)
        {
            $model = new \App\Models\SuperAdmin\M_UserMahasiswa_SuperAdmin();
            try {
                $model->delete($id);
                return redirect()->to(base_url('superadmin/user-mahasiswa'))->with('success', 'Data berhasil dihapus.');
            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                return redirect()->to(base_url('superadmin/user-mahasiswa'))->with('error', 'Data tidak dapat dihapus karena masih digunakan oleh data lain.');
            } catch (\Exception $e) {
                return redirect()->to(base_url('superadmin/user-mahasiswa'))->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }
}

