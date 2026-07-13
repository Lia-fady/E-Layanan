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
$routes->get('/', '\App\Controllers\Sekretariat\c_kabid::index');

// Group Route untuk Sekretariat
$routes->group('sekretariat', ['namespace' => 'App\\Controllers\\Sekretariat'], function($routes) {
    $routes->get('c_kabid', 'C_kabid::index');
    $routes->get('c_kabid/persetujuan', 'C_kabid::persetujuan');
    $routes->get('c_kabid/penempatan', 'C_kabid::penempatan');
    $routes->get('c_kabid/penilaian', 'C_kabid::penilaian');
    
    // Route untuk memproses form (POST)
    $routes->post('c_kabid/simpan_persetujuan', 'c_kabid::simpan_persetujuan');
    $routes->post('c_kabid/simpan_penempatan', 'c_kabid::simpan_penempatan');
    $routes->post('c_kabid/simpan_penilaian', 'c_kabid::simpan_penilaian');
});