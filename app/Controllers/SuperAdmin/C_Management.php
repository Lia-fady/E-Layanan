<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;

class C_Management extends BaseController
{
    /**
     * Helper: Render halaman dengan layout L_master (SB Admin 2)
     * View yang dipanggil menggunakan extend('layout/L_master') secara mandiri.
     */
    private function renderPage(string $view, string $title, string $activeMenu, array $data = []): string
    {
        $pageData = array_merge($data, [
            'title'       => $title,
            'active_menu' => $activeMenu,
        ]);

        return view($view, $pageData);
    }

    // ==========================================
    // MANAJEMEN MENU
    // ==========================================
    public function menu()
    {
        $model = new \App\Models\SuperAdmin\M_Menu();
        $data['menuList'] = $model->findAll();
        return $this->renderPage('dashboard/superadmin/v_manajemen_menu', 'Manajemen Menu', 'manajemen_menu', $data);
    }

    // ==========================================
    // MANAJEMEN PENGGUNA
    // ==========================================
    public function pengguna()
    {
        $db = \Config\Database::connect();
        
        $users = $db->table('c_user_pegawai u')
            ->select('u.*, g.group as role_name')
            ->join('c_user_group g', 'g.id = u.id_user_group', 'left')
            ->get()->getResultArray();
            
        $roles = $db->table('c_user_group')->get()->getResultArray();

        $data = [
            'users' => $users,
            'roles' => $roles
        ];
        return $this->renderPage('dashboard/superadmin/v_manajemen_pengguna', 'Manajemen Pengguna', 'manajemen_pengguna', $data);
    }

    // ==========================================
    // FAKULTAS
    // ==========================================
    public function fakultas()
    {
        $model = new \App\Models\SuperAdmin\M_Fakultas();
        $data['fakultasList'] = $model->findAll();
        return $this->renderPage('dashboard/superadmin/fakultas/v_index', 'Master Data Fakultas', 'fakultas', $data);
    }
    public function fakultasCreate()
    {
        $instansiModel = new \App\Models\SuperAdmin\M_InstansiPendidikan();
        $data['instansiList'] = $instansiModel->where('status', 'aktif')->findAll();
        return $this->renderPage('dashboard/superadmin/fakultas/v_create', 'Tambah Fakultas', 'fakultas', $data);
    }
    public function fakultasEdit($id = null)
    {
        $instansiModel = new \App\Models\SuperAdmin\M_InstansiPendidikan();
        $fakultasModel = new \App\Models\SuperAdmin\M_Fakultas();
        $data['instansiList'] = $instansiModel->where('status', 'aktif')->findAll();
        $data['fakultas'] = $fakultasModel->find($id);
        return $this->renderPage('dashboard/superadmin/fakultas/v_edit', 'Edit Fakultas', 'fakultas', $data);
    }
    public function fakultasDetail($id = null)
    {
        $fakultasModel = new \App\Models\SuperAdmin\M_Fakultas();
        $data['fakultas'] = $fakultasModel->find($id);
        return $this->renderPage('dashboard/superadmin/fakultas/v_detail', 'Detail Fakultas', 'fakultas', $data);
    }

    // ==========================================
    // PRODI
    // ==========================================
    public function prodi()
    {
        $model = new \App\Models\SuperAdmin\M_Prodi();
        $data['prodiList'] = $model->getAllWithRelations();
        return $this->renderPage('dashboard/superadmin/prodi/v_index', 'Master Data Program Studi', 'prodi', $data);
    }
    public function prodiCreate()
    {
        $fakultasModel = new \App\Models\SuperAdmin\M_Fakultas();
        $data['fakultasList'] = $fakultasModel->where('status', 'aktif')->findAll();
        return $this->renderPage('dashboard/superadmin/prodi/v_create', 'Tambah Program Studi', 'prodi', $data);
    }
    public function prodiEdit($id = null)
    {
        $fakultasModel = new \App\Models\SuperAdmin\M_Fakultas();
        $prodiModel = new \App\Models\SuperAdmin\M_Prodi();
        $data['fakultasList'] = $fakultasModel->where('status', 'aktif')->findAll();
        $data['prodi'] = $prodiModel->find($id);
        return $this->renderPage('dashboard/superadmin/prodi/v_edit', 'Edit Program Studi', 'prodi', $data);
    }
    public function prodiDetail($id = null)
    {
        $prodiModel = new \App\Models\SuperAdmin\M_Prodi();
        $data['prodi'] = $prodiModel->find($id);
        return $this->renderPage('dashboard/superadmin/prodi/v_detail', 'Detail Program Studi', 'prodi', $data);
    }

    // ==========================================
    // INSTANSI PENDIDIKAN
    // ==========================================
    public function instansi()
    {
        $model = new \App\Models\SuperAdmin\M_InstansiPendidikan();
        $data['instansiList'] = $model->findAll();
        return $this->renderPage('dashboard/superadmin/instansi_pendidikan/v_index', 'Master Data Instansi Pendidikan', 'instansi', $data);
    }
    public function instansiCreate()
    {
        return $this->renderPage('dashboard/superadmin/instansi_pendidikan/v_create', 'Tambah Instansi Pendidikan', 'instansi');
    }
    public function instansiEdit($id = null)
    {
        $model = new \App\Models\SuperAdmin\M_InstansiPendidikan();
        $data['instansi'] = $model->find($id);
        return $this->renderPage('dashboard/superadmin/instansi_pendidikan/v_edit', 'Edit Instansi Pendidikan', 'instansi', $data);
    }
    public function instansiDetail($id = null)
    {
        $model = new \App\Models\SuperAdmin\M_InstansiPendidikan();
        $data['instansi'] = $model->find($id);
        return $this->renderPage('dashboard/superadmin/instansi_pendidikan/v_detail', 'Detail Instansi Pendidikan', 'instansi', $data);
    }

    // ==========================================
    // MAHASISWA
    // ==========================================
    public function mahasiswa()
    {
        $model = new \App\Models\SuperAdmin\M_Mahasiswa();
        $data['mahasiswaList'] = $model->getAllWithRelations();
        return $this->renderPage('dashboard/superadmin/mahasiswa/v_index', 'Master Data Mahasiswa', 'mahasiswa', $data);
    }
    public function mahasiswaCreate()
    {
        return $this->renderPage('dashboard/superadmin/mahasiswa/v_create', 'Tambah Mahasiswa', 'mahasiswa');
    }
    public function mahasiswaEdit($id = null)
    {
        $model = new \App\Models\SuperAdmin\M_Mahasiswa();
        $data['mahasiswa'] = $model->find($id);
        return $this->renderPage('dashboard/superadmin/mahasiswa/v_edit', 'Edit Mahasiswa', 'mahasiswa', $data);
    }
    public function mahasiswaDetail($id = null)
    {
        $model = new \App\Models\SuperAdmin\M_Mahasiswa();
        $data['mahasiswa'] = $model->find($id);
        return $this->renderPage('dashboard/superadmin/mahasiswa/v_detail', 'Detail Mahasiswa', 'mahasiswa', $data);
    }

    // ==========================================
    // USER MAHASISWA
    // ==========================================
    public function userMahasiswa()
    {
        $model = new \App\Models\SuperAdmin\M_UserMahasiswa();
        $data['userMahasiswaList'] = $model->getAllWithRelations();
        return $this->renderPage('dashboard/superadmin/user_mahasiswa/v_index', 'Manajemen User Mahasiswa', 'user-mahasiswa', $data);
    }
    public function userMahasiswaCreate()
    {
        $mahasiswaModel = new \App\Models\SuperAdmin\M_Mahasiswa();
        $userMahasiswaModel = new \App\Models\SuperAdmin\M_UserMahasiswa();
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
    public function userMahasiswaEdit($id = null)
    {
        $model = new \App\Models\SuperAdmin\M_UserMahasiswa();
        $data['userMahasiswa'] = $model->find($id);
        return $this->renderPage('dashboard/superadmin/user_mahasiswa/v_edit', 'Edit User Mahasiswa', 'user_mahasiswa', $data);
    }
    public function userMahasiswaDetail($id = null)
    {
        $model = new \App\Models\SuperAdmin\M_UserMahasiswa();
        $data['userMahasiswa'] = $model->find($id);
        return $this->renderPage('dashboard/superadmin/user_mahasiswa/v_detail', 'Detail User Mahasiswa', 'user_mahasiswa', $data);
    }

    // ==========================================
    // JENIS PERMOHONAN
    // ==========================================
    public function jenisPermohonan()
    {
        $model = new \App\Models\SuperAdmin\M_JenisPermohonan();
        $data['jenisPermohonanList'] = $model->findAll();
        return $this->renderPage('dashboard/superadmin/jenis_permohonan/v_index', 'Master Data Jenis Permohonan', 'jenis_permohonan', $data);
    }
    public function jenisPermohonanCreate()
    {
        return $this->renderPage('dashboard/superadmin/jenis_permohonan/v_create', 'Tambah Jenis Permohonan', 'jenis_permohonan');
    }
    public function jenisPermohonanEdit($id = null)
    {
        $model = new \App\Models\SuperAdmin\M_JenisPermohonan();
        $data['jenisPermohonan'] = $model->find($id);
        return $this->renderPage('dashboard/superadmin/jenis_permohonan/v_edit', 'Edit Jenis Permohonan', 'jenis_permohonan', $data);
    }
    public function jenisPermohonanDetail($id = null)
    {
        $model = new \App\Models\SuperAdmin\M_JenisPermohonan();
        $data['jenisPermohonan'] = $model->find($id);
        return $this->renderPage('dashboard/superadmin/jenis_permohonan/v_detail', 'Detail Jenis Permohonan', 'jenis_permohonan', $data);
    }

    // ==========================================
    // FILE PERSYARATAN (m_file + m_file_permohonan)
    // ==========================================
    public function file()
    {
        $filePermohonanModel = new \App\Models\SuperAdmin\M_FilePermohonan();
        $data['fileList'] = $filePermohonanModel->getAllWithRelations();
        return $this->renderPage('dashboard/superadmin/file_persyaratan/v_index', 'Master Data File Persyaratan', 'file', $data);
    }
    public function fileCreate()
    {
        $jenisModel = new \App\Models\SuperAdmin\M_JenisPermohonan();
        $fileModel = new \App\Models\SuperAdmin\M_File();
        $data['jenisPermohonanList'] = $jenisModel->findAll();
        $data['fileList'] = $fileModel->findAll();
        return $this->renderPage('dashboard/superadmin/file_persyaratan/v_create', 'Tambah File Persyaratan', 'file', $data);
    }
    public function fileEdit($id = null)
    {
        $filePermohonanModel = new \App\Models\SuperAdmin\M_FilePermohonan();
        $jenisModel = new \App\Models\SuperAdmin\M_JenisPermohonan();
        $fileModel = new \App\Models\SuperAdmin\M_File();

        $data['filePermohonan'] = $filePermohonanModel->find($id);
        $data['jenisPermohonanList'] = $jenisModel->findAll();
        $data['fileList'] = $fileModel->findAll();
        return $this->renderPage('dashboard/superadmin/file_persyaratan/v_edit', 'Edit File Persyaratan', 'file', $data);
    }
    public function fileDetail($id = null)
    {
        $filePermohonanModel = new \App\Models\SuperAdmin\M_FilePermohonan();
        $data['file'] = $filePermohonanModel->getAllWithRelations($id);
        return $this->renderPage('dashboard/superadmin/file_persyaratan/v_detail', 'Detail File Persyaratan', 'file', $data);
    }

    // ==========================================
    // OPD
    // ==========================================
    public function odp()
    {
        $model = new \App\Models\SuperAdmin\M_Opd();
        $data['opdList'] = $model->findAll();
        return $this->renderPage('dashboard/superadmin/odp/v_index', 'Master Data OPD', 'odp', $data);
    }
    public function odpCreate()
    {
        return $this->renderPage('dashboard/superadmin/odp/v_create', 'Tambah OPD', 'odp');
    }
    public function odpEdit($id = null)
    {
        $model = new \App\Models\SuperAdmin\M_Opd();
        $data['opd'] = $model->find($id);
        return $this->renderPage('dashboard/superadmin/odp/v_edit', 'Edit OPD', 'odp', $data);
    }
    public function odpDetail($id = null)
    {
        $model = new \App\Models\SuperAdmin\M_Opd();
        $data['opd'] = $model->find($id);
        return $this->renderPage('dashboard/superadmin/odp/v_detail', 'Detail OPD', 'odp', $data);
    }

    // ==========================================
    // BIDANG
    // ==========================================
    public function bidang()
    {
        $model = new \App\Models\SuperAdmin\M_Bidang();
        $data['bidangList'] = $model->getAllWithRelations();
        return $this->renderPage('dashboard/superadmin/bidang/v_index', 'Master Data Bidang', 'bidang', $data);
    }
    public function bidangCreate()
    {
        $opdModel = new \App\Models\SuperAdmin\M_Opd();
        $data['opdList'] = $opdModel->where('status_aktif', '1')->findAll();
        return $this->renderPage('dashboard/superadmin/bidang/v_create', 'Tambah Bidang', 'bidang', $data);
    }
    public function bidangEdit($id = null)
    {
        $opdModel = new \App\Models\SuperAdmin\M_Opd();
        $bidangModel = new \App\Models\SuperAdmin\M_Bidang();
        $data['opdList'] = $opdModel->where('status_aktif', '1')->findAll();
        $data['bidang'] = $bidangModel->find($id);
        return $this->renderPage('dashboard/superadmin/bidang/v_edit', 'Edit Bidang', 'bidang', $data);
    }
    public function bidangDetail($id = null)
    {
        $model = new \App\Models\SuperAdmin\M_Bidang();
        $data['bidang'] = $model->find($id);
        return $this->renderPage('dashboard/superadmin/bidang/v_detail', 'Detail Bidang', 'bidang', $data);
    }

    // ==========================================
    // KUOTA
    // ==========================================
    public function kuota()
    {
        $model = new \App\Models\SuperAdmin\M_Kuota();
        $data['kuotaList'] = $model->getAllWithRelations();
        return $this->renderPage('dashboard/superadmin/kuota/v_index', 'Master Data Kuota', 'kuota', $data);
    }
    public function kuotaCreate()
    {
        $bidangModel = new \App\Models\SuperAdmin\M_Bidang();
        $data['bidangList'] = $bidangModel->where('status_aktif', '1')->findAll();
        return $this->renderPage('dashboard/superadmin/kuota/v_create', 'Tambah Kuota', 'kuota', $data);
    }
    public function kuotaEdit($id = null)
    {
        $bidangModel = new \App\Models\SuperAdmin\M_Bidang();
        $kuotaModel = new \App\Models\SuperAdmin\M_Kuota();
        $data['bidangList'] = $bidangModel->where('status_aktif', '1')->findAll();
        $data['kuota'] = $kuotaModel->find($id);
        return $this->renderPage('dashboard/superadmin/kuota/v_edit', 'Edit Kuota', 'kuota', $data);
    }
    public function kuotaDetail($id = null)
    {
        $model = new \App\Models\SuperAdmin\M_Kuota();
        $data['kuota'] = $model->find($id);
        return $this->renderPage('dashboard/superadmin/kuota/v_detail', 'Detail Kuota', 'kuota', $data);
    }

    // ==========================================
    // KOMPONEN PENILAIAN
    // ==========================================
    public function komponenPenilaian()
    {
        $model = new \App\Models\SuperAdmin\M_KomponenPenilaian();
        $data['komponenPenilaianList'] = $model->findAll();
        return $this->renderPage('dashboard/superadmin/komponen_penilaian/v_index', 'Master Data Komponen Penilaian', 'komponen_penilaian', $data);
    }
    public function komponenPenilaianCreate()
    {
        return $this->renderPage('dashboard/superadmin/komponen_penilaian/v_create', 'Tambah Komponen Penilaian', 'komponen_penilaian');
    }
    public function komponenPenilaianEdit($id = null)
    {
        $model = new \App\Models\SuperAdmin\M_KomponenPenilaian();
        $data['komponenPenilaian'] = $model->find($id);
        return $this->renderPage('dashboard/superadmin/komponen_penilaian/v_edit', 'Edit Komponen Penilaian', 'komponen_penilaian', $data);
    }
    public function komponenPenilaianDetail($id = null)
    {
        $model = new \App\Models\SuperAdmin\M_KomponenPenilaian();
        $data['komponenPenilaian'] = $model->find($id);
        return $this->renderPage('dashboard/superadmin/komponen_penilaian/v_detail', 'Detail Komponen Penilaian', 'komponen_penilaian', $data);
    }

    // ==========================================
    // STORE ACTIONS (REDIRECT WITH FLASHDATA)
    // ==========================================

    public function menuStore()
    {
        $model = new \App\Models\SuperAdmin\M_Menu();
        $data = $this->request->getPost();
        if (empty($data)) {
            return redirect()->back()->with('error', 'Data tidak boleh kosong.');
        }
        try {
            if (isset($data['status'])) {
                $data['status'] = ($data['status'] == 'on') ? 1 : 0;
            }
            if ($model->insert($data)) {
                return redirect()->to(base_url('superadmin/manajemen-menu'))->with('success', 'Data berhasil ditambahkan.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function penggunaStore()
    {
        $model = new \App\Models\SuperAdmin\M_Pengguna();
        $data = $this->request->getPost();
        if (empty($data)) {
            return redirect()->back()->with('error', 'Data tidak boleh kosong.');
        }
        try {
            if (isset($data['password']) && !empty($data['password'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }
            if ($model->insert($data)) {
                return redirect()->to(base_url('superadmin/manajemen-pengguna'))->with('success', 'Data berhasil ditambahkan.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function fakultasStore()
    {
        $model = new \App\Models\SuperAdmin\M_Fakultas();
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

    public function prodiStore()
    {
        $model = new \App\Models\SuperAdmin\M_Prodi();
        $data = $this->request->getPost();
        if (empty($data)) {
            return redirect()->back()->with('error', 'Data tidak boleh kosong.');
        }
        try {
            if ($model->insert($data)) {
                return redirect()->to(base_url('superadmin/prodi'))->with('success', 'Data berhasil ditambahkan.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function instansiStore()
    {
        $model = new \App\Models\SuperAdmin\M_InstansiPendidikan();
        $data = $this->request->getPost();
        if (empty($data)) {
            return redirect()->back()->with('error', 'Data tidak boleh kosong.');
        }
        try {
            if ($model->insert($data)) {
                return redirect()->to(base_url('superadmin/instansi-pendidikan'))->with('success', 'Data berhasil ditambahkan.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function mahasiswaStore()
    {
        $model = new \App\Models\SuperAdmin\M_Mahasiswa();
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

    public function userMahasiswaStore()
    {
        $model = new \App\Models\SuperAdmin\M_UserMahasiswa();
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

    public function jenisPermohonanStore()
    {
        $model = new \App\Models\SuperAdmin\M_JenisPermohonan();
        $data = $this->request->getPost();
        if (empty($data)) {
            return redirect()->back()->with('error', 'Data tidak boleh kosong.');
        }
        try {
            if ($model->insert($data)) {
                return redirect()->to(base_url('superadmin/jenis-permohonan'))->with('success', 'Data berhasil ditambahkan.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function fileStore()
    {
        $model = new \App\Models\SuperAdmin\M_FilePermohonan();
        $data = $this->request->getPost();
        if (empty($data)) {
            return redirect()->back()->with('error', 'Data tidak boleh kosong.');
        }
        try {
            if ($model->insert($data)) {
                return redirect()->to(base_url('superadmin/file'))->with('success', 'Data berhasil ditambahkan.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function odpStore()
    {
        $model = new \App\Models\SuperAdmin\M_Opd();
        $data = $this->request->getPost();
        if (empty($data)) {
            return redirect()->back()->with('error', 'Data tidak boleh kosong.');
        }
        try {
            if ($model->insert($data)) {
                return redirect()->to(base_url('superadmin/odp'))->with('success', 'Data berhasil ditambahkan.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function bidangStore()
    {
        $model = new \App\Models\SuperAdmin\M_Bidang();
        $data = $this->request->getPost();
        if (empty($data)) {
            return redirect()->back()->with('error', 'Data tidak boleh kosong.');
        }
        try {
            if ($model->insert($data)) {
                return redirect()->to(base_url('superadmin/bidang'))->with('success', 'Data berhasil ditambahkan.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function kuotaStore()
    {
        $model = new \App\Models\SuperAdmin\M_Kuota();
        $data = $this->request->getPost();
        if (empty($data)) {
            return redirect()->back()->with('error', 'Data tidak boleh kosong.');
        }
        try {
            if ($model->insert($data)) {
                return redirect()->to(base_url('superadmin/kuota'))->with('success', 'Data berhasil ditambahkan.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function komponenPenilaianStore()
    {
        $model = new \App\Models\SuperAdmin\M_KomponenPenilaian();
        $data = $this->request->getPost();
        if (empty($data)) {
            return redirect()->back()->with('error', 'Data tidak boleh kosong.');
        }
        try {
            if ($model->insert($data)) {
                return redirect()->to(base_url('superadmin/komponen-penilaian'))->with('success', 'Data berhasil ditambahkan.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
