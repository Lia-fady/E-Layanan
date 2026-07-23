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
$routes->post('mahasiswa/permohonan/update/(:num)', 'MahasiswaController::updatePermohonan/$1');
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


