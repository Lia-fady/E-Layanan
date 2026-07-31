<?php

/**
 * Kode: Routes.php
 * Path: app/Config/Routes.php
 * Deskripsi: Konfigurasi routing untuk seluruh modul aplikasi E-Layanan
 *            Permohonan & Kegiatan Akademik. Mencakup route autentikasi
 *            dan route grup Sekretariat yang dilindungi filter authSekretariat.
 */

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// =========================================================================
// Default Route - Redirect ke halaman login
// (Dipindahkan ke line bawah: '/' => Home::index untuk landing page)
// =========================================================================

// =========================================================================
// Auth Routes (tanpa filter autentikasi)
// =========================================================================
$routes->get('auth/login', '\App\Controllers\Sekretariat\C_Auth::login');
$routes->post('auth/login', '\App\Controllers\Sekretariat\C_Auth::login');
$routes->get('auth/logout', '\App\Controllers\Sekretariat\C_Auth::logout');

$routes->get('temp/update-db', static function() {
    $db = \Config\Database::connect();
    $db->table('t_persetujuan_magang')->where('status_persetujuan', 'DITOLAK')->update(['status_persetujuan' => 'PERBAIKAN_BERKAS']);
    echo "Database updated via route.";
});

// =========================================================================
// LOGIN Route Group (DANU)
// =========================================================================


$routes->get('/', 'Home::index');
$routes->get('landing', 'Home::index');

$routes->get('register', 'AuthController::register');
$routes->post('register/process', 'AuthController::processRegister');

$routes->get('login', 'AuthController::login');
$routes->post('login/process', 'AuthController::processLogin');
$routes->get('pegawai/login', 'AuthController::loginPegawai');
$routes->post('pegawai/login/process', 'AuthController::processLoginPegawai');
$routes->get('logout', 'AuthController::logout');

// =========================================================================
// MAHASISWA Route Group 
// =========================================================================

$routes->group('mahasiswa', ['namespace' => '\App\Controllers\Mahasiswa'], static function ($routes) {
    $routes->get('dashboard', 'C_Dashboard::dashboard');
    $routes->get('profil', 'C_Profil::profil');
    $routes->post('profil/update', 'C_Profil::updateProfil');

    $routes->get('permohonan', 'C_Permohonan::permohonan');
    $routes->post('permohonan/simpan', 'C_Permohonan::simpanPermohonan');
    $routes->get('permohonan/edit/(:num)', 'C_Permohonan::editPermohonan/$1');
    $routes->post('permohonan/update/(:num)', 'C_Permohonan::updatePermohonan/$1');

    $routes->get('status', 'C_Status::statusPermohonan');
    $routes->get('batalkan-permohonan/(:num)', 'C_Status::batalkanPermohonan/$1');
    $routes->get('view-file/(:num)', 'C_Status::viewFile/$1');
    $routes->get('view-file/(:num)/(:any)', 'C_Status::viewFile/$1/$2');
    
    // Surat Balasan dari Sekretariat
    $routes->get('download-surat-penerimaan/(:num)', 'C_Status::downloadSuratPenerimaan/$1');

    $routes->get('logbook', 'C_Logbook::logbook');
    $routes->post('logbook/simpan', 'C_Logbook::simpanLogbook');
    $routes->post('simpanLogbook', 'C_Logbook::simpanLogbook');
    $routes->get('logbook/cetak', 'C_Logbook::cetakLogbook');

    $routes->get('sertifikat', 'C_Sertifikat::sertifikat');
});

// =========================================================================
// Sekretariat Route Group (dilindungi filter authSekretariat)
// =========================================================================
$routes->group('sekretariat', ['filter' => 'authSekretariat'], static function ($routes) {

    // Dashboard
    $routes->get('dashboard', '\App\Controllers\Sekretariat\C_Dashboard::index');

    // Verifikasi Permohonan
    $routes->match(['get', 'post'], 'verifikasi', '\App\Controllers\Sekretariat\C_Verifikasi::index');
    $routes->get('verifikasi/detailModal/(:num)', '\App\Controllers\Sekretariat\C_Verifikasi::detailModal/$1');
    $routes->post('verifikasi/prosesModal', '\App\Controllers\Sekretariat\C_Verifikasi::prosesModal');
    // Riwayat
    $routes->get('riwayat', '\App\Controllers\Sekretariat\C_Riwayat::index');
    $routes->post('riwayat/delete', '\App\Controllers\Sekretariat\C_Riwayat::delete');
    $routes->post('riwayat/setujui', '\App\Controllers\Sekretariat\C_Riwayat::setujui');
    $routes->post('riwayat/tolak', '\App\Controllers\Sekretariat\C_Riwayat::tolak');

    // Disposisi (Disabled as integrated into Verifikasi)
    // $routes->get('disposisi', '\App\Controllers\Sekretariat\C_Disposisi::index');
    // $routes->get('disposisi/detail/(:num)', '\App\Controllers\Sekretariat\C_Disposisi::detail/$1');
    // $routes->post('disposisi/proses', '\App\Controllers\Sekretariat\C_Disposisi::proses');

    // Profile
    $routes->get('profile', '\App\Controllers\Sekretariat\C_Profile::index');
    $routes->post('profile/update', '\App\Controllers\Sekretariat\C_Profile::update');

    // Status Permohonan
    $routes->get('status-permohonan', '\App\Controllers\Sekretariat\C_StatusPermohonan::index');

    // Monitoring Status (halaman terpisah dari Status Permohonan)
    $routes->get('monitoring-status', '\App\Controllers\Sekretariat\C_MonitoringStatus::index');

    // Permohonan Masuk (placeholder)
    $routes->get('permohonan-masuk', '\App\Controllers\Sekretariat\C_Placeholder::permohonanMasuk');

    // Laporan (placeholder)
    $routes->get('laporan', '\App\Controllers\Sekretariat\C_Placeholder::laporan');

    // Pengaturan (placeholder)
    $routes->get('pengaturan', '\App\Controllers\Sekretariat\C_Placeholder::pengaturan');

    // Penilaian
    $routes->get('penilaian', '\App\Controllers\Sekretariat\C_Penilaian::index');
    $routes->get('penilaian/form/(:num)', '\App\Controllers\Sekretariat\C_Penilaian::form/$1');
    $routes->post('penilaian/simpan', '\App\Controllers\Sekretariat\C_Penilaian::simpan');
    $routes->get('penilaian/simpan', static function () {
        return redirect()->to(base_url('sekretariat/penilaian'));
    });

    // Riwayat - Edit Disposisi
    $routes->post('riwayat/edit-disposisi', '\App\Controllers\Sekretariat\C_Riwayat::editDisposisi');

    // Sertifikat
    $routes->get('sertifikat', '\App\Controllers\Sekretariat\C_Sertifikat::index');
    $routes->get('sertifikat/download/(:num)', '\App\Controllers\Sekretariat\C_Sertifikat::download/$1');

    // Surat Penerimaan Magang (Menu Baru)
    $routes->match(['get', 'post'], 'upload-surat-penerimaan', '\App\Controllers\Sekretariat\C_UploadSuratPenerimaan::index');
    $routes->post('upload-surat-penerimaan/store', '\App\Controllers\Sekretariat\C_UploadSuratPenerimaan::store');
    $routes->post('upload-surat-penerimaan/delete/(:num)', '\App\Controllers\Sekretariat\C_UploadSuratPenerimaan::delete/$1');
    $routes->get('upload-surat-penerimaan/download/(:num)', '\App\Controllers\Sekretariat\C_UploadSuratPenerimaan::download/$1');
});

// =========================================================================
// Kepala Bidang Route Group (dilindungi filter authKabid)
// =========================================================================
$routes->group('kabid', ['filter' => 'authKabid'], static function ($routes) {
    $routes->get('/', '\App\Controllers\Kabid\C_DashboardKabid::index');
    $routes->get('dashboard', '\App\Controllers\Kabid\C_DashboardKabid::index');

    // 1. Disposisi Masuk
    $routes->get('disposisi', '\App\Controllers\Kabid\C_DisposisiMasuk::index');
    $routes->post('disposisi/setujui', '\App\Controllers\Kabid\C_DisposisiMasuk::setujui');
    $routes->post('disposisi/tolak', '\App\Controllers\Kabid\C_DisposisiMasuk::tolak');
    $routes->post('disposisi/selesaikan', '\App\Controllers\Kabid\C_DisposisiMasuk::selesaikan');

    // 2. Logbook (Approval)
    $routes->get('logbook', '\App\Controllers\Kabid\C_LogbookKabid::index');
    $routes->get('logbook/detail/(:num)', '\App\Controllers\Kabid\C_LogbookKabid::detail/$1');
    $routes->post('logbook/approve', '\App\Controllers\Kabid\C_LogbookKabid::approve');
    $routes->post('logbook/bulkApprove', '\App\Controllers\Kabid\C_LogbookKabid::bulkApprove');

    // 3. (Menu Riwayat Magang dihapus dan digabung ke Disposisi Masuk)

    // 4. Kuota Bidang
    $routes->get('kuota', '\App\Controllers\Kabid\C_KuotaBidang::index');
    $routes->post('kuota/update', '\App\Controllers\Kabid\C_KuotaBidang::update');

    // 5. Upload Dokumen Magang
    $routes->get('upload-dokumen', '\App\Controllers\Kabid\C_UploadDokumen::index');
    $routes->get('upload-dokumen/form/(:num)', '\App\Controllers\Kabid\C_UploadDokumen::form/$1');
    $routes->post('upload-dokumen/store', '\App\Controllers\Kabid\C_UploadDokumen::store');
    $routes->post('upload-dokumen/delete/(:num)', '\App\Controllers\Kabid\C_UploadDokumen::delete/$1');
    $routes->get('upload-dokumen/download/(:num)', '\App\Controllers\Kabid\C_UploadDokumen::download/$1');
});

// =========================================================================
// Super Admin Route Group (dilindungi filter authSekretariat)
// =========================================================================
$routes->group('superadmin', ['filter' => 'authSekretariat'], static function ($routes) {
    // Dashboard
    $routes->get('dashboard', '\App\Controllers\SuperAdmin\C_Dashboard::index');

    // Manajemen
    $routes->get('manajemen-menu', '\App\Controllers\SuperAdmin\C_Management::menu');
    $routes->post('manajemen-menu/store', '\App\Controllers\SuperAdmin\C_Management::menuStore');
    $routes->get('manajemen-pengguna', '\App\Controllers\SuperAdmin\C_Management::pengguna');
    $routes->post('manajemen-pengguna/store', '\App\Controllers\SuperAdmin\C_Management::penggunaStore');

    // Master Data - Fakultas
    $routes->get('fakultas', '\App\Controllers\SuperAdmin\C_Management::fakultas');
    $routes->get('fakultas/create', '\App\Controllers\SuperAdmin\C_Management::fakultasCreate');
    $routes->post('fakultas/store', '\App\Controllers\SuperAdmin\C_Management::fakultasStore');
    $routes->get('fakultas/edit/(:num)', '\App\Controllers\SuperAdmin\C_Management::fakultasEdit/$1');
    $routes->get('fakultas/detail/(:num)', '\App\Controllers\SuperAdmin\C_Management::fakultasDetail/$1');

    // Master Data - Prodi
    $routes->get('prodi', '\App\Controllers\SuperAdmin\C_Management::prodi');
    $routes->get('prodi/create', '\App\Controllers\SuperAdmin\C_Management::prodiCreate');
    $routes->post('prodi/store', '\App\Controllers\SuperAdmin\C_Management::prodiStore');
    $routes->get('prodi/edit/(:num)', '\App\Controllers\SuperAdmin\C_Management::prodiEdit/$1');
    $routes->get('prodi/detail/(:num)', '\App\Controllers\SuperAdmin\C_Management::prodiDetail/$1');

    // Master Data - Instansi Pendidikan
    $routes->get('instansi-pendidikan', '\App\Controllers\SuperAdmin\C_Management::instansi');
    $routes->get('instansi-pendidikan/create', '\App\Controllers\SuperAdmin\C_Management::instansiCreate');
    $routes->post('instansi-pendidikan/store', '\App\Controllers\SuperAdmin\C_Management::instansiStore');
    $routes->get('instansi-pendidikan/edit/(:num)', '\App\Controllers\SuperAdmin\C_Management::instansiEdit/$1');
    $routes->get('instansi-pendidikan/detail/(:num)', '\App\Controllers\SuperAdmin\C_Management::instansiDetail/$1');

    // Master Data - Mahasiswa
    $routes->get('mahasiswa', '\App\Controllers\SuperAdmin\C_Management::mahasiswa');
    $routes->get('mahasiswa/create', '\App\Controllers\SuperAdmin\C_Management::mahasiswaCreate');
    $routes->post('mahasiswa/store', '\App\Controllers\SuperAdmin\C_Management::mahasiswaStore');
    $routes->get('mahasiswa/edit/(:num)', '\App\Controllers\SuperAdmin\C_Management::mahasiswaEdit/$1');
    $routes->get('mahasiswa/detail/(:num)', '\App\Controllers\SuperAdmin\C_Management::mahasiswaDetail/$1');

    // Master Data - User Mahasiswa
    $routes->get('user-mahasiswa', '\App\Controllers\SuperAdmin\C_Management::userMahasiswa');
    $routes->get('user-mahasiswa/create', '\App\Controllers\SuperAdmin\C_Management::userMahasiswaCreate');
    $routes->post('user-mahasiswa/store', '\App\Controllers\SuperAdmin\C_Management::userMahasiswaStore');
    $routes->get('user-mahasiswa/edit/(:num)', '\App\Controllers\SuperAdmin\C_Management::userMahasiswaEdit/$1');
    $routes->get('user-mahasiswa/detail/(:num)', '\App\Controllers\SuperAdmin\C_Management::userMahasiswaDetail/$1');

    // Master Data - Jenis Permohonan
    $routes->get('jenis-permohonan', '\App\Controllers\SuperAdmin\C_Management::jenisPermohonan');
    $routes->get('jenis-permohonan/create', '\App\Controllers\SuperAdmin\C_Management::jenisPermohonanCreate');
    $routes->post('jenis-permohonan/store', '\App\Controllers\SuperAdmin\C_Management::jenisPermohonanStore');
    $routes->get('jenis-permohonan/edit/(:num)', '\App\Controllers\SuperAdmin\C_Management::jenisPermohonanEdit/$1');
    $routes->get('jenis-permohonan/detail/(:num)', '\App\Controllers\SuperAdmin\C_Management::jenisPermohonanDetail/$1');

    // Master Data - File Persyaratan
    $routes->get('file', '\App\Controllers\SuperAdmin\C_Management::file');
    $routes->get('file/create', '\App\Controllers\SuperAdmin\C_Management::fileCreate');
    $routes->post('file/store', '\App\Controllers\SuperAdmin\C_Management::fileStore');
    $routes->get('file/edit/(:num)', '\App\Controllers\SuperAdmin\C_Management::fileEdit/$1');
    $routes->get('file/detail/(:num)', '\App\Controllers\SuperAdmin\C_Management::fileDetail/$1');

    // Master Data - OPD
    $routes->get('odp', '\App\Controllers\SuperAdmin\C_Management::odp');
    $routes->get('odp/create', '\App\Controllers\SuperAdmin\C_Management::odpCreate');
    $routes->post('odp/store', '\App\Controllers\SuperAdmin\C_Management::odpStore');
    $routes->get('odp/edit/(:num)', '\App\Controllers\SuperAdmin\C_Management::odpEdit/$1');
    $routes->get('odp/detail/(:num)', '\App\Controllers\SuperAdmin\C_Management::odpDetail/$1');

    // Master Data - Bidang
    $routes->get('bidang', '\App\Controllers\SuperAdmin\C_Management::bidang');
    $routes->get('bidang/create', '\App\Controllers\SuperAdmin\C_Management::bidangCreate');
    $routes->post('bidang/store', '\App\Controllers\SuperAdmin\C_Management::bidangStore');
    $routes->get('bidang/edit/(:num)', '\App\Controllers\SuperAdmin\C_Management::bidangEdit/$1');
    $routes->get('bidang/detail/(:num)', '\App\Controllers\SuperAdmin\C_Management::bidangDetail/$1');

    // Master Data - Kuota
    $routes->get('kuota', '\App\Controllers\SuperAdmin\C_Management::kuota');
    $routes->get('kuota/create', '\App\Controllers\SuperAdmin\C_Management::kuotaCreate');
    $routes->post('kuota/store', '\App\Controllers\SuperAdmin\C_Management::kuotaStore');
    $routes->get('kuota/edit/(:num)', '\App\Controllers\SuperAdmin\C_Management::kuotaEdit/$1');
    $routes->get('kuota/detail/(:num)', '\App\Controllers\SuperAdmin\C_Management::kuotaDetail/$1');

    // Master Data - Komponen Penilaian
    $routes->get('komponen-penilaian', '\App\Controllers\SuperAdmin\C_Management::komponenPenilaian');
    $routes->get('komponen-penilaian/create', '\App\Controllers\SuperAdmin\C_Management::komponenPenilaianCreate');
    $routes->post('komponen-penilaian/store', '\App\Controllers\SuperAdmin\C_Management::komponenPenilaianStore');
    $routes->get('komponen-penilaian/edit/(:num)', '\App\Controllers\SuperAdmin\C_Management::komponenPenilaianEdit/$1');
    $routes->get('komponen-penilaian/detail/(:num)', '\App\Controllers\SuperAdmin\C_Management::komponenPenilaianDetail/$1');
});

// --- API ROUTES FOR DROPDOWNS ---
$routes->get('api/fakultas/(:num)', 'ApiController::getFakultasByKampus/$1');
$routes->get('api/prodi/(:num)', 'ApiController::getProdiByFakultas/$1');
