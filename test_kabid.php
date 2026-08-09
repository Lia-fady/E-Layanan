<?php
// Simple test script for Kabid controllers
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);

// Load CodeIgniter
require_once FCPATH . '../app/Config/Paths.php';
$paths = new Config\Paths();
require_once $paths->systemDirectory . '/bootstrap.php';

// Instantiate controllers to check if they have fatal errors
try {
    $c1 = new \App\Controllers\Kabid\C_DisposisiMasuk();
    echo "C_DisposisiMasuk instantiated successfully.\n";
    
    $c2 = new \App\Controllers\Kabid\C_LogbookKabid();
    echo "C_LogbookKabid instantiated successfully.\n";
    
    $c3 = new \App\Controllers\Kabid\C_DashboardKabid();
    echo "C_DashboardKabid instantiated successfully.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
