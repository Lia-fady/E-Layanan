<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Sediakan rute default jika sewaktu-waktu diakses tanpa atau dengan index.php
$routes->get('/', 'Home::index');
$routes->get('landing', 'Home::index');

$routes->get('register', 'AuthController::register');
$routes->post('register/process', 'AuthController::processRegister');

$routes->get('login', 'AuthController::login');
$routes->post('login/process', 'AuthController::processLogin');
$routes->get('pegawai/login', 'AuthController::loginPegawai');
$routes->post('pegawai/login/process', 'AuthController::processLoginPegawai');
$routes->get('logout', 'AuthController::logout');

// Ganti routing API kamu di Routes.php menjadi seperti ini:
$routes->get('api/fakultas/(:num)', 'AuthController::getFakultasByKampus/$1');
$routes->get('api/prodi/(:num)', 'AuthController::getProdiByFakultas/$1');

$routes->get('mahasiswa/dashboard', 'MahasiswaController::dashboard');
$routes->get('mahasiswa/permohonan', 'MahasiswaController::permohonan');

$routes->post('mahasiswa/permohonan/simpan', 'MahasiswaController::simpanPermohonan');
$routes->get('mahasiswa/permohonan/edit/(:num)', 'MahasiswaController::editPermohonan/$1');
$routes->post('mahasiswa/logbook/update/(:num)', 'MahasiswaController::updateLogbook/$1');

// =========================================================================
// Sekretariat Route Group (dilindungi filter authSekretariat)
// =========================================================================
$routes->group('sekretariat', ['filter' => 'auth'], static function ($routes) {

    // Dashboard
    $routes->get('dashboard', '\App\Controllers\Sekretariat\C_Dashboard::index');

    // Verifikasi Permohonan
    $routes->get('verifikasi', '\App\Controllers\Sekretariat\C_Verifikasi::index');
    $routes->get('verifikasi/detailModal/(:num)', '\App\Controllers\Sekretariat\C_Verifikasi::detailModal/$1');
    $routes->post('verifikasi/prosesModal', '\App\Controllers\Sekretariat\C_Verifikasi::prosesModal');
    
    // Riwayat
    $routes->get('riwayat', '\App\Controllers\Sekretariat\C_Riwayat::index');
    $routes->post('riwayat/delete', '\App\Controllers\Sekretariat\C_Riwayat::delete');
    $routes->post('riwayat/setujui', '\App\Controllers\Sekretariat\C_Riwayat::setujui');
    $routes->post('riwayat/tolak', '\App\Controllers\Sekretariat\C_Riwayat::tolak');

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
    $routes->get('upload-surat-penerimaan', '\App\Controllers\Sekretariat\C_UploadSuratPenerimaan::index');
    $routes->get('upload-surat-penerimaan/form/(:num)', '\App\Controllers\Sekretariat\C_UploadSuratPenerimaan::form/$1');
    $routes->post('upload-surat-penerimaan/store', '\App\Controllers\Sekretariat\C_UploadSuratPenerimaan::store');
    $routes->post('upload-surat-penerimaan/delete/(:num)', '\App\Controllers\Sekretariat\C_UploadSuratPenerimaan::delete/$1');
    $routes->get('upload-surat-penerimaan/download/(:num)', '\App\Controllers\Sekretariat\C_UploadSuratPenerimaan::download/$1');
});

// =========================================================================
// Kepala Bidang Route Group (dilindungi filter authKabid)
// =========================================================================
$routes->group('kabid', ['filter' => 'auth'], static function ($routes) {

    // Dashboard Kepala Bidang
    $routes->get('dashboard', '\App\Controllers\Kabid\C_DashboardKabid::index');

    // Persetujuan Penempatan
    $routes->get('penempatan', '\App\Controllers\Kabid\C_KepalaBidang::index');
    $routes->post('penempatan/setujui', '\App\Controllers\Kabid\C_KepalaBidang::setujui');
    $routes->post('penempatan/tolak', '\App\Controllers\Kabid\C_KepalaBidang::tolak');

    // Surat Penerimaan Magang (Menu Baru)
    $routes->get('upload-surat-penerimaan', '\App\Controllers\Kabid\C_UploadSuratPenerimaan::index');
    $routes->get('upload-surat-penerimaan/form/(:num)', '\App\Controllers\Kabid\C_UploadSuratPenerimaan::form/$1');
    $routes->post('upload-surat-penerimaan/store', '\App\Controllers\Kabid\C_UploadSuratPenerimaan::store');
    $routes->post('upload-surat-penerimaan/delete/(:num)', '\App\Controllers\Kabid\C_UploadSuratPenerimaan::delete/$1');
    $routes->get('upload-surat-penerimaan/download/(:num)', '\App\Controllers\Kabid\C_UploadSuratPenerimaan::download/$1');
});

// TAMBAHKAN BARIS INI: Rute untuk memproses simpan data dari form permohonan
// (Sudah didefinisikan di atas menggunakan /simpan)

$routes->get('mahasiswa/profil', 'MahasiswaController::profil');
$routes->post('mahasiswa/profil/update', 'MahasiswaController::updateProfil');
$routes->get('mahasiswa/status', 'MahasiswaController::statusPermohonan');
$routes->get('mahasiswa/batalkan-permohonan/(:num)', 'MahasiswaController::batalkanPermohonan/$1');

$routes->get('mahasiswa/view-file/(:num)', 'MahasiswaController::viewFile/$1');
$routes->get('mahasiswa/view-file/(:num)/(:any)', 'MahasiswaController::viewFile/$1/$2');

$routes->get('mahasiswa/logbook', 'MahasiswaController::logbook');

$routes->post('mahasiswa/logbook/simpan', 'MahasiswaController::simpanLogbook');

$routes->get('mahasiswa/sertifikat', 'MahasiswaController::sertifikat');

$routes->post('mahasiswa/simpanLogbook', 'MahasiswaController::simpanLogbook');

// --- API ROUTES FOR DROPDOWNS ---
// --- API ROUTES FOR DROPDOWNS ---
$routes->get('api/fakultas/(:num)', 'ApiController::getFakultasByKampus/$1');
$routes->get('api/prodi/(:num)', 'ApiController::getProdiByFakultas/$1');


