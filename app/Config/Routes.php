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
    $routes->get('status/detail/(:num)', 'C_Status::detail/$1');
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

    // Kuota Bidang (Pemantauan Bulanan)
    $routes->get('kuota', '\App\Controllers\Sekretariat\C_Kuota::index');
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
    $routes->match(['get', 'post'], 'logbook', '\App\Controllers\Kabid\C_LogbookKabid::index');
    $routes->get('logbook/detail/(:num)', '\App\Controllers\Kabid\C_LogbookKabid::detail/$1');
    $routes->post('logbook/approve', '\App\Controllers\Kabid\C_LogbookKabid::approve');
    $routes->post('logbook/bulkApprove', '\App\Controllers\Kabid\C_LogbookKabid::bulkApprove');

    // 3. (Menu Riwayat Magang dihapus dan digabung ke Disposisi Masuk)

    // 4. Kuota Bidang
    $routes->get('kuota', '\App\Controllers\Kabid\C_KuotaBidang::index');
    $routes->post('kuota/update', '\App\Controllers\Kabid\C_KuotaBidang::update');

    // 5. Upload Dokumen Magang
    $routes->match(['get', 'post'], 'upload-dokumen', '\App\Controllers\Kabid\C_UploadDokumen::index');
    $routes->get('upload-dokumen/form/(:num)', '\App\Controllers\Kabid\C_UploadDokumen::form/$1');
    $routes->post('upload-dokumen/store', '\App\Controllers\Kabid\C_UploadDokumen::store');
    $routes->post('upload-dokumen/delete/(:num)', '\App\Controllers\Kabid\C_UploadDokumen::delete/$1');
    $routes->get('upload-dokumen/download/(:num)', '\App\Controllers\Kabid\C_UploadDokumen::download/$1');
});

// --- API ROUTES FOR DROPDOWNS ---
$routes->get('api/fakultas/(:num)', 'ApiController::getFakultasByKampus/$1');
$routes->get('api/prodi/(:num)', 'ApiController::getProdiByFakultas/$1');

// Wilayah
$routes->get('api/kabupaten/(:num)', 'ApiController::getKabupatenByProvinsi/$1');
$routes->get('api/kecamatan/(:num)', 'ApiController::getKecamatanByKabupaten/$1');
$routes->get('api/kelurahan/(:num)', 'ApiController::getKelurahanByKecamatan/$1');

// --- API ROUTES FOR LOG RIWAYAT ---
$routes->get('api/log/riwayat/(:num)', 'ApiController::getLogRiwayat/$1');

