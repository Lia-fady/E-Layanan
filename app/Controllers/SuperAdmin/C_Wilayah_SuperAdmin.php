<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;
use App\Models\SuperAdmin\M_Provinsi_SuperAdmin;
use App\Models\SuperAdmin\M_Kabupaten_SuperAdmin;
use App\Models\SuperAdmin\M_Kecamatan_SuperAdmin;
use App\Models\SuperAdmin\M_Kelurahan_SuperAdmin;

class C_Wilayah_SuperAdmin extends BaseController
{
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
        $provinsiModel = new M_Provinsi_SuperAdmin();
        $kabupatenModel = new M_Kabupaten_SuperAdmin();
        $kecamatanModel = new M_Kecamatan_SuperAdmin();
        $kelurahanModel = new M_Kelurahan_SuperAdmin();

        $data['provinsiList'] = $provinsiModel->findAll();
        
        // Join to get parent names
        $data['kabupatenList'] = $kabupatenModel->select('m_kabupaten.*, m_provinsi.nama_provinsi')
            ->join('m_provinsi', 'm_provinsi.id_provinsi = m_kabupaten.id_provinsi', 'left')
            ->findAll();

        $data['kecamatanList'] = $kecamatanModel->select('m_kecamatan.*, m_kabupaten.nama_kabupaten, m_provinsi.nama_provinsi, m_provinsi.id_provinsi')
            ->join('m_kabupaten', 'm_kabupaten.id_kabupaten = m_kecamatan.id_kabupaten', 'left')
            ->join('m_provinsi', 'm_provinsi.id_provinsi = m_kabupaten.id_provinsi', 'left')
            ->findAll();

        // For kelurahan, if the table is too large, it might slow down.
        // We will fetch it anyway as per standard client-side datatables in this project, 
        // but if it's too big, it will need server-side processing later.
        $data['kelurahanList'] = $kelurahanModel->select('m_kelurahan.*, m_kecamatan.nama_kecamatan, m_kabupaten.nama_kabupaten, m_provinsi.nama_provinsi, m_kabupaten.id_kabupaten, m_provinsi.id_provinsi')
            ->join('m_kecamatan', 'm_kecamatan.id_kecamatan = m_kelurahan.id_kecamatan', 'left')
            ->join('m_kabupaten', 'm_kabupaten.id_kabupaten = m_kecamatan.id_kabupaten', 'left')
            ->join('m_provinsi', 'm_provinsi.id_provinsi = m_kabupaten.id_provinsi', 'left')
            ->findAll();

        return $this->renderPage('dashboard/superadmin/wilayah/v_index', 'Master Data Wilayah', 'wilayah', $data);
    }

    // ==========================================
    // PROVINSI CRUD
    // ==========================================
    public function storeProvinsi()
    {
        $model = new M_Provinsi_SuperAdmin();
        $data = $this->request->getPost();
        if (empty($data)) return redirect()->back()->with('error', 'Data tidak boleh kosong.');
        
        try {
            if ($model->insert($data)) {
                return redirect()->to(base_url('superadmin/wilayah'))->with('success', 'Data berhasil ditambahkan.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateProvinsi($id)
    {
        $model = new M_Provinsi_SuperAdmin();
        $data = $this->request->getPost();
        if (empty($data)) return redirect()->back()->with('error', 'Data tidak boleh kosong.');
        try {
            if ($model->update($id, $data)) {
                return redirect()->to(base_url('superadmin/wilayah'))->with('success', 'Data berhasil diupdate.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupdate data.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function deleteProvinsi($id)
    {
        $model = new M_Provinsi_SuperAdmin();
        $kabModel = new M_Kabupaten_SuperAdmin();
        
        if ($kabModel->where('id_provinsi', $id)->countAllResults() > 0) {
            return redirect()->to(base_url('superadmin/wilayah'))->with('error', 'Data tidak dapat dihapus karena Provinsi masih memiliki data Kabupaten/Kota.');
        }

        try {
            $model->delete($id);
            return redirect()->to(base_url('superadmin/wilayah'))->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('superadmin/wilayah'))->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ==========================================
    // KABUPATEN CRUD
    // ==========================================
    public function storeKabupaten()
    {
        $model = new M_Kabupaten_SuperAdmin();
        $data = $this->request->getPost();
        if (empty($data)) return redirect()->back()->with('error', 'Data tidak boleh kosong.');
        
        try {
            if ($model->insert($data)) {
                return redirect()->to(base_url('superadmin/wilayah'))->with('success', 'Data berhasil ditambahkan.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateKabupaten($id)
    {
        $model = new M_Kabupaten_SuperAdmin();
        $data = $this->request->getPost();
        if (empty($data)) return redirect()->back()->with('error', 'Data tidak boleh kosong.');
        try {
            if ($model->update($id, $data)) {
                return redirect()->to(base_url('superadmin/wilayah'))->with('success', 'Data berhasil diupdate.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupdate data.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function deleteKabupaten($id)
    {
        $model = new M_Kabupaten_SuperAdmin();
        $kecModel = new M_Kecamatan_SuperAdmin();
        
        if ($kecModel->where('id_kabupaten', $id)->countAllResults() > 0) {
            return redirect()->to(base_url('superadmin/wilayah'))->with('error', 'Data tidak dapat dihapus karena Kabupaten/Kota masih memiliki data Kecamatan.');
        }

        try {
            $model->delete($id);
            return redirect()->to(base_url('superadmin/wilayah'))->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('superadmin/wilayah'))->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ==========================================
    // KECAMATAN CRUD
    // ==========================================
    public function storeKecamatan()
    {
        $model = new M_Kecamatan_SuperAdmin();
        $data = $this->request->getPost();
        if (empty($data)) return redirect()->back()->with('error', 'Data tidak boleh kosong.');
        
        try {
            if ($model->insert($data)) {
                return redirect()->to(base_url('superadmin/wilayah'))->with('success', 'Data berhasil ditambahkan.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateKecamatan($id)
    {
        $model = new M_Kecamatan_SuperAdmin();
        $data = $this->request->getPost();
        if (empty($data)) return redirect()->back()->with('error', 'Data tidak boleh kosong.');
        try {
            if ($model->update($id, $data)) {
                return redirect()->to(base_url('superadmin/wilayah'))->with('success', 'Data berhasil diupdate.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupdate data.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function deleteKecamatan($id)
    {
        $model = new M_Kecamatan_SuperAdmin();
        $kelModel = new M_Kelurahan_SuperAdmin();
        
        if ($kelModel->where('id_kecamatan', $id)->countAllResults() > 0) {
            return redirect()->to(base_url('superadmin/wilayah'))->with('error', 'Data tidak dapat dihapus karena Kecamatan masih memiliki data Kelurahan/Desa.');
        }

        try {
            $model->delete($id);
            return redirect()->to(base_url('superadmin/wilayah'))->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('superadmin/wilayah'))->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ==========================================
    // KELURAHAN CRUD
    // ==========================================
    public function storeKelurahan()
    {
        $model = new M_Kelurahan_SuperAdmin();
        $data = $this->request->getPost();
        if (empty($data)) return redirect()->back()->with('error', 'Data tidak boleh kosong.');
        
        try {
            if ($model->insert($data)) {
                return redirect()->to(base_url('superadmin/wilayah'))->with('success', 'Data berhasil ditambahkan.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateKelurahan($id)
    {
        $model = new M_Kelurahan_SuperAdmin();
        $data = $this->request->getPost();
        if (empty($data)) return redirect()->back()->with('error', 'Data tidak boleh kosong.');
        try {
            if ($model->update($id, $data)) {
                return redirect()->to(base_url('superadmin/wilayah'))->with('success', 'Data berhasil diupdate.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupdate data.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function deleteKelurahan($id)
    {
        $model = new M_Kelurahan_SuperAdmin();
        try {
            $model->delete($id);
            return redirect()->to(base_url('superadmin/wilayah'))->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('superadmin/wilayah'))->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ==========================================
    // AJAX DEPENDENT DROPDOWNS
    // ==========================================
    public function getKabupatenByProvinsi($id_provinsi)
    {
        $model = new M_Kabupaten_SuperAdmin();
        $data = $model->where('id_provinsi', $id_provinsi)->where('status', 'AKTIF')->findAll();
        
        return $this->response->setJSON([
            'status' => true,
            'data' => $data
        ]);
    }

    public function getKecamatanByKabupaten($id_kabupaten)
    {
        $model = new M_Kecamatan_SuperAdmin();
        $data = $model->where('id_kabupaten', $id_kabupaten)->where('status', 'AKTIF')->findAll();
        
        return $this->response->setJSON([
            'status' => true,
            'data' => $data
        ]);
    }

    public function getKelurahanByKecamatan($id_kecamatan)
    {
        $model = new M_Kelurahan_SuperAdmin();
        $data = $model->where('id_kecamatan', $id_kecamatan)->where('status', 'AKTIF')->findAll();
        
        return $this->response->setJSON([
            'status' => true,
            'data' => $data
        ]);
    }
}
