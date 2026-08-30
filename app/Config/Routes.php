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
// API Routes
// =========================================================================
$routes->group('api', ['namespace' => '\App\Controllers\Api'], static function ($routes) {
    $routes->get('log/riwayat/(:num)', 'Log::get_riwayat/$1');
});

// --- API ROUTES FOR DROPDOWNS (from AuthController/ApiController) ---
$routes->get('api/fakultas/(:num)', 'ApiController::getFakultasByKampus/$1');
$routes->get('api/prodi/(:num)', 'ApiController::getProdiByFakultas/$1');
$routes->get('api/kabupaten/(:num)', 'ApiController::getKabupatenByProvinsi/$1');
$routes->get('api/kecamatan/(:num)', 'ApiController::getKecamatanByKabupaten/$1');
$routes->get('api/kelurahan/(:num)', 'ApiController::getKelurahanByKecamatan/$1');
$routes->get('api/log/riwayat/(:num)', 'ApiController::getLogRiwayat/$1');

// =========================================================================
// MAHASISWA Route Group 
// =========================================================================

$routes->group('mahasiswa', ['namespace' => '\App\Controllers\Mahasiswa'], static function ($routes) {
    $routes->get('dashboard', 'C_Dashboard::dashboard');
    $routes->get('profil', 'C_Profil::profil');
    $routes->post('profil/update', 'C_Profil::updateProfil');

    $routes->get('permohonan', 'C_Permohonan::permohonan');
    $routes->post('permohonan/simpan', 'C_Permohonan::simpanPermohonan');
    $routes->post('permohonan/update', 'C_Permohonan::updatePermohonan');

    $routes->get('status', 'C_Status::statusPermohonan');
    $routes->get('status/detail/(:num)', 'C_Status::detail/$1');
    $routes->get('batalkan-permohonan/(:num)', 'C_Status::batalkanPermohonan/$1');
    $routes->get('view-file/(:num)', 'C_Status::viewFile/$1');
    $routes->get('view-file/(:num)/(:any)', 'C_Status::viewFile/$1/$2');
    
    // Surat Balasan dari Sekretariat
    $routes->get('download-surat-penerimaan/(:num)', 'C_Status::downloadSuratPenerimaan/$1');

    $routes->match(['get', 'post'], 'logbook', 'C_Logbook::logbook');
    $routes->post('logbook/simpan', 'C_Logbook::simpanLogbook');
    $routes->post('simpanLogbook', 'C_Logbook::simpanLogbook');
    $routes->get('logbook/cetak', 'C_Logbook::cetakLogbook');
    $routes->get('logbook/cetak-excel', 'C_Logbook::cetakExcel');

    $routes->get('sertifikat', 'C_Sertifikat::sertifikat');
    $routes->get('sertifikat/file/(:num)', 'C_Sertifikat::serveFile/$1');
});

// =========================================================================
// Sekretariat Route Group (dilindungi filter authSekretariat)
// =========================================================================
$routes->group('sekretariat', ['filter' => 'authSekretariat'], static function ($routes) {

    // Dashboard
    $routes->get('dashboard', '\App\Controllers\Sekretariat\C_Dashboard::index');

    // Verifikasi Permohonan
    $routes->match(['get', 'post'], 'verifikasi', '\App\Controllers\Sekretariat\C_Verifikasi::index');
    $routes->get('verifikasi/detail/(:num)', '\App\Controllers\Sekretariat\C_Verifikasi::detailStandalone/$1');
    $routes->post('verifikasi/prosesModal', '\App\Controllers\Sekretariat\C_Verifikasi::prosesModal');
    $routes->post('verifikasi/tolakCepat', '\App\Controllers\Sekretariat\C_Verifikasi::tolakCepat');
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

    // Kuota Bidang (Monitoring)
    $routes->get('kuota', '\App\Controllers\Sekretariat\C_KuotaBidang::index');
    $routes->get('kuota/detail/(:num)', '\App\Controllers\Sekretariat\C_KuotaBidang::detail/$1');

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
    $routes->match(['get', 'post'], 'disposisi', '\App\Controllers\Kabid\C_DisposisiMasuk::index');
    $routes->post('disposisi/setujui', '\App\Controllers\Kabid\C_DisposisiMasuk::setujui');
    $routes->post('disposisi/tolak', '\App\Controllers\Kabid\C_DisposisiMasuk::tolak');
    $routes->post('disposisi/selesaikan', '\App\Controllers\Kabid\C_DisposisiMasuk::selesaikan');
    $routes->post('disposisi/simpan-tgl-penetapan', '\App\Controllers\Kabid\C_DisposisiMasuk::simpanTglPenetapan');

    $routes->match(['get', 'post'], 'riwayat', '\App\Controllers\Kabid\C_RiwayatKabid::index');

    // 2. Logbook (Approval)
    // 2. Logbook (Approval)
    $routes->match(['get', 'post'], 'logbook', '\App\Controllers\Kabid\C_LogbookKabid::index');
    $routes->post('logbook/approve', '\App\Controllers\Kabid\C_LogbookKabid::approve');
    $routes->post('logbook/reject', '\App\Controllers\Kabid\C_LogbookKabid::reject');
    $routes->post('logbook/bulkApprove', '\App\Controllers\Kabid\C_LogbookKabid::bulkApprove');

    // 3. Riwayat Selesai Magang
    $routes->get('riwayat-selesai', '\App\Controllers\Kabid\C_LogbookKabid::riwayatSelesai');
    // 4. Kuota Bidang
    $routes->get('kuota', '\App\Controllers\Kabid\C_KuotaBidang::index');
    $routes->get('kuota/(:num)/(:num)', '\App\Controllers\Kabid\C_KuotaBidang::detail/$1/$2');
    $routes->post('kuota/update', '\App\Controllers\Kabid\C_KuotaBidang::update');
    $routes->post('kuota/deleteTahun', '\App\Controllers\Kabid\C_KuotaBidang::deleteTahun');
    
    // 5. Upload Dokumen Magang
    // 3. Upload Surat Tugas / Dokumen
    $routes->match(['get', 'post'], 'upload-dokumen', '\App\Controllers\Kabid\C_UploadDokumen::index');
    $routes->post('upload-dokumen/store', '\App\Controllers\Kabid\C_UploadDokumen::store');
    $routes->post('upload-dokumen/delete/(:num)', '\App\Controllers\Kabid\C_UploadDokumen::delete/$1');
    $routes->get('upload-dokumen/download/(:num)', '\App\Controllers\Kabid\C_UploadDokumen::download/$1');
});
// =========================================================================
// Super Admin Route Group (dilindungi filter authSuperAdmin)
// =========================================================================
$routes->group('superadmin', ['filter' => 'authSuperAdmin', 'namespace' => 'App\Controllers\SuperAdmin'], static function ($routes) {
    $routes->get('/', 'C_Dashboard_SuperAdmin::index');
    $routes->get('dashboard', 'C_Dashboard_SuperAdmin::index');

    // Manajemen Pengguna
    $routes->get('manajemen-pengguna', 'C_ManajemenPengguna_SuperAdmin::index');
    $routes->post('manajemen-pengguna/store', 'C_ManajemenPengguna_SuperAdmin::store');
    $routes->post('manajemen-pengguna/update/(:num)', 'C_ManajemenPengguna_SuperAdmin::update/$1');
    $routes->post('manajemen-pengguna/delete/(:num)', 'C_ManajemenPengguna_SuperAdmin::delete/$1');

    // Manajemen Menu
    $routes->get('manajemen-menu', 'C_ManajemenMenu_SuperAdmin::index');
    $routes->post('manajemen-menu/store', 'C_ManajemenMenu_SuperAdmin::store');
    $routes->post('manajemen-menu/update/(:num)', 'C_ManajemenMenu_SuperAdmin::update/$1');
    $routes->post('manajemen-menu/delete/(:num)', 'C_ManajemenMenu_SuperAdmin::delete/$1');

    // Instansi Pendidikan
    $routes->get('instansi-pendidikan', 'C_InstansiPendidikan_SuperAdmin::index');
    $routes->get('instansi-pendidikan/create', 'C_InstansiPendidikan_SuperAdmin::create');
    $routes->get('instansi-pendidikan/edit/(:num)', 'C_InstansiPendidikan_SuperAdmin::edit/$1');
    $routes->get('instansi-pendidikan/detail/(:num)', 'C_InstansiPendidikan_SuperAdmin::detail/$1');
    $routes->post('instansi-pendidikan/store', 'C_InstansiPendidikan_SuperAdmin::store');
    $routes->post('instansi-pendidikan/update/(:num)', 'C_InstansiPendidikan_SuperAdmin::update/$1');
    $routes->post('instansi-pendidikan/delete/(:num)', 'C_InstansiPendidikan_SuperAdmin::delete/$1');

    // Fakultas
    $routes->get('fakultas', 'C_Fakultas_SuperAdmin::index');
    $routes->get('fakultas/create', 'C_Fakultas_SuperAdmin::create');
    $routes->get('fakultas/edit/(:num)', 'C_Fakultas_SuperAdmin::edit/$1');
    $routes->get('fakultas/detail/(:num)', 'C_Fakultas_SuperAdmin::detail/$1');
    $routes->post('fakultas/store', 'C_Fakultas_SuperAdmin::store');
    $routes->post('fakultas/update/(:num)', 'C_Fakultas_SuperAdmin::update/$1');
    $routes->post('fakultas/delete/(:num)', 'C_Fakultas_SuperAdmin::delete/$1');

    // Program Studi & Jurusan
    $routes->get('program-studi', 'C_Prodi_SuperAdmin::index');
    $routes->get('program-studi/create', 'C_Prodi_SuperAdmin::create');
    $routes->get('program-studi/edit/(:num)', 'C_Prodi_SuperAdmin::edit/$1');
    $routes->get('program-studi/detail/(:num)', 'C_Prodi_SuperAdmin::detail/$1');
    $routes->post('program-studi/store', 'C_Prodi_SuperAdmin::store');
    $routes->post('program-studi/update/(:num)', 'C_Prodi_SuperAdmin::update/$1');
    $routes->post('program-studi/delete/(:num)', 'C_Prodi_SuperAdmin::delete/$1');

    // Jurusan Routes
    $routes->post('program-studi/storeJurusan', 'C_Prodi_SuperAdmin::storeJurusan');
    $routes->post('program-studi/updateJurusan/(:num)', 'C_Prodi_SuperAdmin::updateJurusan/$1');
    $routes->post('program-studi/deleteJurusan/(:num)', 'C_Prodi_SuperAdmin::deleteJurusan/$1');

    // Jenis Permohonan
    $routes->get('jenis-permohonan', 'C_JenisPermohonan_SuperAdmin::index');
    $routes->get('jenis-permohonan/create', 'C_JenisPermohonan_SuperAdmin::create');
    $routes->get('jenis-permohonan/edit/(:num)', 'C_JenisPermohonan_SuperAdmin::edit/$1');
    $routes->get('jenis-permohonan/detail/(:num)', 'C_JenisPermohonan_SuperAdmin::detail/$1');
    $routes->post('jenis-permohonan/store', 'C_JenisPermohonan_SuperAdmin::store');
    $routes->post('jenis-permohonan/update/(:num)', 'C_JenisPermohonan_SuperAdmin::update/$1');
    $routes->post('jenis-permohonan/delete/(:num)', 'C_JenisPermohonan_SuperAdmin::delete/$1');

    // File Persyaratan
    $routes->get('file-persyaratan', 'C_FilePersyaratan_SuperAdmin::index');
    $routes->get('file-persyaratan/create', 'C_FilePersyaratan_SuperAdmin::create');
    $routes->get('file-persyaratan/edit/(:num)', 'C_FilePersyaratan_SuperAdmin::edit/$1');
    $routes->get('file-persyaratan/detail/(:num)', 'C_FilePersyaratan_SuperAdmin::detail/$1');
    $routes->post('file-persyaratan/store', 'C_FilePersyaratan_SuperAdmin::store');
    $routes->post('file-persyaratan/update/(:num)', 'C_FilePersyaratan_SuperAdmin::update/$1');
    $routes->post('file-persyaratan/delete/(:num)', 'C_FilePersyaratan_SuperAdmin::delete/$1');

    // OPD
    $routes->get('opd', 'C_Opd_SuperAdmin::index');
    $routes->get('opd/create', 'C_Opd_SuperAdmin::create');
    $routes->get('opd/edit/(:num)', 'C_Opd_SuperAdmin::edit/$1');
    $routes->get('opd/detail/(:num)', 'C_Opd_SuperAdmin::detail/$1');
    $routes->post('opd/store', 'C_Opd_SuperAdmin::store');
    $routes->post('opd/update/(:num)', 'C_Opd_SuperAdmin::update/$1');
    $routes->post('opd/delete/(:num)', 'C_Opd_SuperAdmin::delete/$1');

    // Bidang
    $routes->get('bidang', 'C_Bidang_SuperAdmin::index');
    $routes->get('bidang/create', 'C_Bidang_SuperAdmin::create');
    $routes->get('bidang/edit/(:num)', 'C_Bidang_SuperAdmin::edit/$1');
    $routes->get('bidang/detail/(:num)', 'C_Bidang_SuperAdmin::detail/$1');
    $routes->post('bidang/store', 'C_Bidang_SuperAdmin::store');
    $routes->post('bidang/update/(:num)', 'C_Bidang_SuperAdmin::update/$1');
    $routes->post('bidang/delete/(:num)', 'C_Bidang_SuperAdmin::delete/$1');

    // Kuota
    $routes->get('kuota', 'C_Kuota_SuperAdmin::index');
    $routes->get('kuota/create', 'C_Kuota_SuperAdmin::create');
    $routes->get('kuota/edit/(:num)', 'C_Kuota_SuperAdmin::edit/$1');
    $routes->get('kuota/detail/(:num)', 'C_Kuota_SuperAdmin::detail/$1');
    $routes->post('kuota/store', 'C_Kuota_SuperAdmin::store');
    $routes->post('kuota/update/(:num)', 'C_Kuota_SuperAdmin::update/$1');
    $routes->post('kuota/delete/(:num)', 'C_Kuota_SuperAdmin::delete/$1');

    // Mahasiswa
    $routes->get('mahasiswa', 'C_Mahasiswa_SuperAdmin::index');
    $routes->get('mahasiswa/create', 'C_Mahasiswa_SuperAdmin::create');
    $routes->get('mahasiswa/edit/(:num)', 'C_Mahasiswa_SuperAdmin::edit/$1');
    $routes->get('mahasiswa/detail/(:num)', 'C_Mahasiswa_SuperAdmin::detail/$1');
    $routes->post('mahasiswa/store', 'C_Mahasiswa_SuperAdmin::store');
    $routes->post('mahasiswa/update/(:num)', 'C_Mahasiswa_SuperAdmin::update/$1');
    $routes->post('mahasiswa/delete/(:num)', 'C_Mahasiswa_SuperAdmin::delete/$1');

    // User Mahasiswa
    $routes->get('user-mahasiswa', 'C_UserMahasiswa_SuperAdmin::index');
    $routes->get('user-mahasiswa/create', 'C_UserMahasiswa_SuperAdmin::create');
    $routes->get('user-mahasiswa/edit/(:num)', 'C_UserMahasiswa_SuperAdmin::edit/$1');
    $routes->get('user-mahasiswa/detail/(:num)', 'C_UserMahasiswa_SuperAdmin::detail/$1');
    $routes->post('user-mahasiswa/store', 'C_UserMahasiswa_SuperAdmin::store');
    $routes->post('user-mahasiswa/update/(:num)', 'C_UserMahasiswa_SuperAdmin::update/$1');
    $routes->post('user-mahasiswa/delete/(:num)', 'C_UserMahasiswa_SuperAdmin::delete/$1');

    // Wilayah
    $routes->group('wilayah', function($routes) {
        $routes->get('/', 'C_Wilayah_SuperAdmin::index');
        
        // Provinsi
        $routes->post('store-provinsi', 'C_Wilayah_SuperAdmin::storeProvinsi');
        $routes->post('update-provinsi/(:num)', 'C_Wilayah_SuperAdmin::updateProvinsi/$1');
        $routes->post('delete-provinsi/(:num)', 'C_Wilayah_SuperAdmin::deleteProvinsi/$1');

        // Kabupaten
        $routes->post('store-kabupaten', 'C_Wilayah_SuperAdmin::storeKabupaten');
        $routes->post('update-kabupaten/(:num)', 'C_Wilayah_SuperAdmin::updateKabupaten/$1');
        $routes->post('delete-kabupaten/(:num)', 'C_Wilayah_SuperAdmin::deleteKabupaten/$1');

        // Kecamatan
        $routes->post('store-kecamatan', 'C_Wilayah_SuperAdmin::storeKecamatan');
        $routes->post('update-kecamatan/(:num)', 'C_Wilayah_SuperAdmin::updateKecamatan/$1');
        $routes->post('delete-kecamatan/(:num)', 'C_Wilayah_SuperAdmin::deleteKecamatan/$1');

        // Kelurahan
        $routes->post('store-kelurahan', 'C_Wilayah_SuperAdmin::storeKelurahan');
        $routes->post('update-kelurahan/(:num)', 'C_Wilayah_SuperAdmin::updateKelurahan/$1');
        $routes->post('delete-kelurahan/(:num)', 'C_Wilayah_SuperAdmin::deleteKelurahan/$1');

        // AJAX Dropdowns
        $routes->get('get-kabupaten/(:num)', 'C_Wilayah_SuperAdmin::getKabupatenByProvinsi/$1');
        $routes->get('get-kecamatan/(:num)', 'C_Wilayah_SuperAdmin::getKecamatanByKabupaten/$1');
        $routes->get('get-kelurahan/(:num)', 'C_Wilayah_SuperAdmin::getKelurahanByKecamatan/$1');
    });
});

// --- API ROUTES FOR DROPDOWNS ---
$routes->get('api/fakultas/(:num)', 'ApiController::getFakultasByKampus/$1');
$routes->get('api/prodi/(:num)', 'ApiController::getProdiByFakultas/$1');
$routes->get('api/kabupaten/(:any)', 'ApiController::getKabupatenByProvinsi/$1');
$routes->get('api/kecamatan/(:any)', 'ApiController::getKecamatanByKabupaten/$1');
$routes->get('api/kelurahan/(:any)', 'ApiController::getKelurahanByKecamatan/$1');
