<?php

namespace Config;

use Config\Services;

$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

// Router Setup
$routes->setDefaultNamespace('App\\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

// App Routes
$routes->get('/', '\App\Controllers\Sekretariat\C_kabid::index');

// Group Route untuk Sekretariat
$routes->group('sekretariat', ['namespace' => 'App\\Controllers\\Sekretariat'], function($routes) {
    $routes->get('c_kabid', 'C_kabid::index');
    $routes->get('c_kabid/persetujuan', 'C_kabid::persetujuan');
    $routes->get('c_kabid/detail_disposisi/(:segment)', 'C_kabid::detail_disposisi/$1');
    $routes->get('c_kabid/penempatan', 'C_kabid::penempatan');
    $routes->get('c_kabid/kelola-kuota', 'C_kabid::kelola_kuota');
    $routes->post('c_kabid/simpan-kuota', 'C_kabid::simpan_kuota');
    $routes->get('c_kabid/sertifikat', 'C_kabid::sertifikat');
    
    // Route untuk memproses form (POST)
    $routes->get('c_kabid/penempatan', 'C_kabid::penempatan');
    $routes->post('c_kabid/simpan_persetujuan', 'C_kabid::simpan_persetujuan');
    $routes->post('c_kabid/simpan_penempatan', 'C_kabid::simpan_penempatan');
    $routes->get('c_kabid/hapus_penempatan/(:num)', 'C_kabid::hapus_penempatan/$1');
    $routes->post('c_kabid/simpan_sertifikat', 'C_kabid::simpan_sertifikat');

    $routes->get('penerbitan-dokumen', 'PenerbitanDokumen::index');
    $routes->get('penerbitan-dokumen/detail/(:num)', 'PenerbitanDokumen::detail/$1');
    $routes->post('penerbitan-dokumen/upload', 'PenerbitanDokumen::upload');
    $routes->post('penerbitan-dokumen/ganti-file', 'PenerbitanDokumen::gantiFile');
    $routes->get('penerbitan-dokumen/lihat/(:num)', 'PenerbitanDokumen::lihat/$1');
    $routes->get('penerbitan-dokumen/download/(:num)', 'PenerbitanDokumen::download/$1');
    $routes->get('penerbitan-dokumen/hapus_file/(:num)', 'PenerbitanDokumen::hapus_file/$1');
});