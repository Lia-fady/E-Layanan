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
// (Dipindahkan ke line bawah: '/' => C_Home::index untuk landing page)
// =========================================================================

// =========================================================================
// Auth Routes (tanpa filter autentikasi)
// =========================================================================
$routes->get('auth/login', '\App\Controllers\Sekretariat\C_Auth::login');
$routes->post('auth/login', '\App\Controllers\Sekretariat\C_Auth::login');
$routes->get('auth/logout', '\App\Controllers\Sekretariat\C_Auth::logout');

$routes->get('temp/update-db', static function () {
    $db = \Config\Database::connect();
    $db->table('t_persetujuan_magang')->where('status_persetujuan', 'DITOLAK')->update(['status_persetujuan' => 'PERBAIKAN_BERKAS']);
    echo "Database updated via route.";
});

// =========================================================================
// LOGIN Route Group (DANU)
// =========================================================================


$routes->get('/', 'C_Home::index');
$routes->get('landing', 'C_Home::index');

$routes->get('register', 'C_Auth::register');
$routes->post('register/process', 'C_Auth::processRegister');

$routes->get('login', 'C_Auth::login');
$routes->post('login/process', 'C_Auth::processLogin');
$routes->get('pegawai/login', 'C_Auth::loginPegawai');
$routes->post('pegawai/login/process', 'C_Auth::processLoginPegawai');
$routes->get('logout', 'C_Auth::logout');

// =========================================================================
// MAHASISWA Route Group 
// =========================================================================

$routes->group('mahasiswa', ['namespace' => '\App\Controllers\Mahasiswa'], static function ($routes) {
    $routes->get('dashboard', 'C_Dashboard_Mahasiswa::dashboard');
    $routes->get('profil', 'C_Profil_Mahasiswa::profil');
    $routes->post('profil/update', 'C_Profil_Mahasiswa::updateProfil');

    $routes->get('permohonan', 'C_Permohonan_Mahasiswa::permohonan');
    $routes->post('permohonan/simpan', 'C_Permohonan_Mahasiswa::simpanPermohonan');
    $routes->get('permohonan/edit/(:num)', 'C_Permohonan_Mahasiswa::editPermohonan/$1');
    $routes->post('permohonan/update/(:num)', 'C_Permohonan_Mahasiswa::updatePermohonan/$1');

    $routes->get('status', 'C_Status_Mahasiswa::statusPermohonan');
    $routes->get('batalkan-permohonan/(:num)', 'C_Status_Mahasiswa::batalkanPermohonan/$1');
    $routes->get('view-file/(:num)', 'C_Status_Mahasiswa::viewFile/$1');
    $routes->get('view-file/(:num)/(:any)', 'C_Status_Mahasiswa::viewFile/$1/$2');

    // Surat Balasan dari Sekretariat
    $routes->get('download-surat-penerimaan/(:num)', 'C_Status_Mahasiswa::downloadSuratPenerimaan/$1');

    $routes->get('logbook', 'C_Logbook_Mahasiswa::logbook');
    $routes->post('logbook/simpan', 'C_Logbook_Mahasiswa::simpanLogbook');
    $routes->post('simpanLogbook', 'C_Logbook_Mahasiswa::simpanLogbook');
    $routes->get('logbook/cetak', 'C_Logbook_Mahasiswa::cetakLogbook');

    $routes->get('sertifikat', 'C_Sertifikat_Mahasiswa::sertifikat');
});

// =========================================================================
// Sekretariat Route Group (dilindungi filter authSekretariat)
// =========================================================================
$routes->group('sekretariat', ['filter' => 'authSekretariat'], static function ($routes) {

    // Dashboard
    $routes->get('dashboard', '\App\Controllers\Sekretariat\C_Dashboard_Sekretariat::index');

    // Verifikasi Permohonan
    $routes->match(['get', 'post'], 'verifikasi', '\App\Controllers\Sekretariat\C_Verifikasi_Sekretariat::index');
    $routes->get('verifikasi/detailModal/(:num)', '\App\Controllers\Sekretariat\C_Verifikasi_Sekretariat::detailModal/$1');
    $routes->post('verifikasi/prosesModal', '\App\Controllers\Sekretariat\C_Verifikasi_Sekretariat::prosesModal');
    // Riwayat
    $routes->get('riwayat', '\App\Controllers\Sekretariat\C_Riwayat_Sekretariat::index');
    $routes->post('riwayat/delete', '\App\Controllers\Sekretariat\C_Riwayat_Sekretariat::delete');
    $routes->post('riwayat/setujui', '\App\Controllers\Sekretariat\C_Riwayat_Sekretariat::setujui');
    $routes->post('riwayat/tolak', '\App\Controllers\Sekretariat\C_Riwayat_Sekretariat::tolak');

    // Disposisi (Disabled as integrated into Verifikasi)
    // $routes->get('disposisi', '\App\Controllers\Sekretariat\C_Disposisi::index');
    // $routes->get('disposisi/detail/(:num)', '\App\Controllers\Sekretariat\C_Disposisi::detail/$1');
    // $routes->post('disposisi/proses', '\App\Controllers\Sekretariat\C_Disposisi::proses');

    // Profile
    $routes->get('profile', '\App\Controllers\Sekretariat\C_Profile_Sekretariat::index');
    $routes->post('profile/update', '\App\Controllers\Sekretariat\C_Profile_Sekretariat::update');

    // Status Permohonan
    $routes->get('status-permohonan', '\App\Controllers\Sekretariat\C_StatusPermohonan_Sekretariat::index');

    // Monitoring Status (halaman terpisah dari Status Permohonan)
    $routes->get('monitoring-status', '\App\Controllers\Sekretariat\C_MonitoringStatus_Sekretariat::index');

    // Permohonan Masuk (placeholder)
    $routes->get('permohonan-masuk', '\App\Controllers\Sekretariat\C_Placeholder_Sekretariat::permohonanMasuk');

    // Laporan (placeholder)
    $routes->get('laporan', '\App\Controllers\Sekretariat\C_Placeholder_Sekretariat::laporan');

    // Pengaturan (placeholder)
    $routes->get('pengaturan', '\App\Controllers\Sekretariat\C_Placeholder_Sekretariat::pengaturan');

    // Penilaian
    $routes->get('penilaian', '\App\Controllers\Sekretariat\C_Penilaian_Sekretariat::index');
    $routes->get('penilaian/form/(:num)', '\App\Controllers\Sekretariat\C_Penilaian_Sekretariat::form/$1');
    $routes->post('penilaian/simpan', '\App\Controllers\Sekretariat\C_Penilaian_Sekretariat::simpan');
    $routes->get('penilaian/simpan', static function () {
        return redirect()->to(base_url('sekretariat/penilaian'));
    });

    // Riwayat - Edit Disposisi
    $routes->post('riwayat/edit-disposisi', '\App\Controllers\Sekretariat\C_Riwayat_Sekretariat::editDisposisi');

    // Sertifikat
    $routes->get('sertifikat', '\App\Controllers\Sekretariat\C_Sertifikat_Sekretariat::index');
    $routes->get('sertifikat/download/(:num)', '\App\Controllers\Sekretariat\C_Sertifikat_Sekretariat::download/$1');

    // Surat Penerimaan Magang (Menu Baru)
    $routes->match(['get', 'post'], 'upload-surat-penerimaan', '\App\Controllers\Sekretariat\C_UploadSuratPenerimaan_Sekretariat::index');
    $routes->post('upload-surat-penerimaan/store', '\App\Controllers\Sekretariat\C_UploadSuratPenerimaan_Sekretariat::store');
    $routes->post('upload-surat-penerimaan/delete/(:num)', '\App\Controllers\Sekretariat\C_UploadSuratPenerimaan_Sekretariat::delete/$1');
    $routes->get('upload-surat-penerimaan/download/(:num)', '\App\Controllers\Sekretariat\C_UploadSuratPenerimaan_Sekretariat::download/$1');
});

// =========================================================================
// Kepala Bidang Route Group (dilindungi filter authKabid)
// =========================================================================
$routes->group('kabid', ['filter' => 'authKabid'], static function ($routes) {
    $routes->get('/', '\App\Controllers\Bidang\C_Dashboard_Bidang::index');
    $routes->get('dashboard', '\App\Controllers\Bidang\C_Dashboard_Bidang::index');

    // 1. Disposisi Masuk
    $routes->get('disposisi', '\App\Controllers\Bidang\C_DisposisiMasuk_Bidang::index');
    $routes->post('disposisi/setujui', '\App\Controllers\Bidang\C_DisposisiMasuk_Bidang::setujui');
    $routes->post('disposisi/tolak', '\App\Controllers\Bidang\C_DisposisiMasuk_Bidang::tolak');
    $routes->post('disposisi/selesaikan', '\App\Controllers\Bidang\C_DisposisiMasuk_Bidang::selesaikan');

    // 2. Logbook (Approval)
    $routes->get('logbook', '\App\Controllers\Bidang\C_Logbook_Bidang::index');
    $routes->get('logbook/detail/(:num)', '\App\Controllers\Bidang\C_Logbook_Bidang::detail/$1');
    $routes->post('logbook/approve', '\App\Controllers\Bidang\C_Logbook_Bidang::approve');
    $routes->post('logbook/bulkApprove', '\App\Controllers\Bidang\C_Logbook_Bidang::bulkApprove');

    // 3. (Menu Riwayat Magang dihapus dan digabung ke Disposisi Masuk)

    // 4. Kuota Bidang
    $routes->get('kuota', '\App\Controllers\Bidang\C_Kuota_Bidang::index');
    $routes->post('kuota/update', '\App\Controllers\Bidang\C_Kuota_Bidang::update');

    // 5. Upload Dokumen Magang
    $routes->get('upload-dokumen', '\App\Controllers\Bidang\C_UploadDokumen_Bidang::index');
    $routes->get('upload-dokumen/form/(:num)', '\App\Controllers\Bidang\C_UploadDokumen_Bidang::form/$1');
    $routes->post('upload-dokumen/store', '\App\Controllers\Bidang\C_UploadDokumen_Bidang::store');
    $routes->post('upload-dokumen/delete/(:num)', '\App\Controllers\Bidang\C_UploadDokumen_Bidang::delete/$1');
    $routes->get('upload-dokumen/download/(:num)', '\App\Controllers\Bidang\C_UploadDokumen_Bidang::download/$1');
});

// =========================================================================
// Super Admin Route Group (dilindungi filter authSekretariat)
// =========================================================================
// Fallback redirects untuk mencegah error typo "super admin" atau "super-admin"
$routes->get('super admin/(.*)', static function ($path) {
    return redirect()->to(base_url('superadmin/' . $path));
});
$routes->get('super-admin/(.*)', static function ($path) {
    return redirect()->to(base_url('superadmin/' . $path));
});
$routes->get('super admin', static function () {
    return redirect()->to(base_url('superadmin/dashboard'));
});
$routes->get('super-admin', static function () {
    return redirect()->to(base_url('superadmin/dashboard'));
});

$routes->group('superadmin', ['filter' => 'authSekretariat'], static function ($routes) {
    $routes->get('dashboard', '\App\Controllers\SuperAdmin\C_Dashboard_SuperAdmin::index');

    // Helper untuk mendaftarkan standard CRUD routes
    $setupStandardRoutes = function ($prefix, $controller) use ($routes) {
        $routes->get($prefix, "\\App\\Controllers\\SuperAdmin\\$controller::index");
        $routes->get("$prefix/create", "\\App\\Controllers\\SuperAdmin\\$controller::create");
        $routes->post("$prefix/store", "\\App\\Controllers\\SuperAdmin\\$controller::store");
        $routes->get("$prefix/edit/(:num)", "\\App\\Controllers\\SuperAdmin\\$controller::edit/$1");
        $routes->post("$prefix/update/(:num)", "\\App\\Controllers\\SuperAdmin\\$controller::update/$1");
        $routes->post("$prefix/delete/(:num)", "\\App\\Controllers\\SuperAdmin\\$controller::delete/$1");
        $routes->get("$prefix/detail/(:num)", "\\App\\Controllers\\SuperAdmin\\$controller::detail/$1");
        $routes->get("$prefix/show/(:num)", "\\App\\Controllers\\SuperAdmin\\$controller::detail/$1"); // Alias detail
        $routes->get("$prefix/download/(:num)", "\\App\\Controllers\\SuperAdmin\\$controller::download/$1");
    };

    // Manajemen
    $setupStandardRoutes('manajemen-menu', 'C_ManajemenMenu_SuperAdmin');
    $setupStandardRoutes('manajemen-pengguna', 'C_ManajemenPengguna_SuperAdmin');

    // Master Data
    $setupStandardRoutes('fakultas', 'C_Fakultas_SuperAdmin');
    $setupStandardRoutes('program-studi', 'C_Prodi_SuperAdmin');
    $setupStandardRoutes('instansi-pendidikan', 'C_InstansiPendidikan_SuperAdmin');
    $setupStandardRoutes('mahasiswa', 'C_Mahasiswa_SuperAdmin');
    $setupStandardRoutes('user-mahasiswa', 'C_UserMahasiswa_SuperAdmin');
    $setupStandardRoutes('jenis-permohonan', 'C_JenisPermohonan_SuperAdmin');
    $setupStandardRoutes('file-persyaratan', 'C_FilePersyaratan_SuperAdmin');
    $setupStandardRoutes('opd', 'C_Opd_SuperAdmin');
    $setupStandardRoutes('bidang', 'C_Bidang_SuperAdmin');
    $setupStandardRoutes('kuota', 'C_Kuota_SuperAdmin');
    $setupStandardRoutes('komponen-penilaian', 'C_KomponenPenilaian_SuperAdmin');
});

// --- API ROUTES FOR DROPDOWNS ---
$routes->get('api/fakultas/(:num)', 'C_Api::getFakultasByKampus/$1');
$routes->get('api/prodi/(:num)', 'C_Api::getProdiByFakultas/$1');
