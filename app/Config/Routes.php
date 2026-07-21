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
// =========================================================================
$routes->get('/', static function () {
    return redirect()->to('auth/login');
});

// =========================================================================
// Auth Routes (tanpa filter autentikasi)
// =========================================================================
$routes->get('auth/login', '\App\Controllers\Sekretariat\C_Auth::login');
$routes->post('auth/login', '\App\Controllers\Sekretariat\C_Auth::login');
$routes->get('auth/logout', '\App\Controllers\Sekretariat\C_Auth::logout');

// =========================================================================
// Sekretariat Route Group (dilindungi filter authSekretariat)
// =========================================================================
$routes->group('sekretariat', ['filter' => 'authSekretariat'], static function ($routes) {

    // Dashboard
    $routes->get('dashboard', '\App\Controllers\Sekretariat\C_Dashboard::index');

    // Verifikasi Permohonan
    $routes->get('verifikasi', '\App\Controllers\Sekretariat\C_Verifikasi::index');
    $routes->get('verifikasi/detail/(:num)', '\App\Controllers\Sekretariat\C_Verifikasi::detail/$1');
    $routes->post('verifikasi/proses', '\App\Controllers\Sekretariat\C_Verifikasi::proses');
    $routes->post('verifikasi/kembalikan', '\App\Controllers\Sekretariat\C_Verifikasi::kembalikan');
    $routes->get('verifikasi/proses', static function () {
        return redirect()->to(base_url('sekretariat/verifikasi'));
    });

    // Riwayat
    $routes->get('riwayat', '\App\Controllers\Sekretariat\C_Riwayat::index');
    $routes->post('riwayat/setujui', '\App\Controllers\Sekretariat\C_Riwayat::setujui');
    $routes->post('riwayat/tolak', '\App\Controllers\Sekretariat\C_Riwayat::tolak');

    // Disposisi
    $routes->get('disposisi', '\App\Controllers\Sekretariat\C_Disposisi::index');
    $routes->get('disposisi/detail/(:num)', '\App\Controllers\Sekretariat\C_Disposisi::detail/$1');
    $routes->post('disposisi/proses', '\App\Controllers\Sekretariat\C_Disposisi::proses');
    $routes->get('disposisi/proses', static function () {
        return redirect()->to(base_url('sekretariat/disposisi'));
    });

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

    // Surat Penerimaan Magang
    $routes->get('file-proses-magang/create/(:num)', '\App\Controllers\Sekretariat\C_FileProsesMagang::create/$1');
    $routes->post('file-proses-magang/store', '\App\Controllers\Sekretariat\C_FileProsesMagang::store');
    $routes->post('file-proses-magang/update/(:num)', '\App\Controllers\Sekretariat\C_FileProsesMagang::update/$1');
    $routes->get('file-proses-magang/download/(:num)', '\App\Controllers\Sekretariat\C_FileProsesMagang::download/$1');
});

// =========================================================================
// Kepala Bidang Route Group (dilindungi filter authKabid)
// =========================================================================
$routes->group('kabid', ['filter' => 'authKabid'], static function ($routes) {

    // Dashboard Kepala Bidang
    $routes->get('dashboard', '\App\Controllers\Kabid\C_DashboardKabid::index');

    // Persetujuan Penempatan
    $routes->get('penempatan', '\App\Controllers\Kabid\C_KepalaBidang::index');
    $routes->post('penempatan/setujui', '\App\Controllers\Kabid\C_KepalaBidang::setujui');
    $routes->post('penempatan/tolak', '\App\Controllers\Kabid\C_KepalaBidang::tolak');

    // Surat Penerimaan Magang
    $routes->get('file-proses-magang/create/(:num)', '\App\Controllers\Kabid\C_FileProsesMagangKabid::create/$1');
    $routes->post('file-proses-magang/store', '\App\Controllers\Kabid\C_FileProsesMagangKabid::store');
    $routes->post('file-proses-magang/update/(:num)', '\App\Controllers\Kabid\C_FileProsesMagangKabid::update/$1');
    $routes->get('file-proses-magang/download/(:num)', '\App\Controllers\Kabid\C_FileProsesMagangKabid::download/$1');
});
