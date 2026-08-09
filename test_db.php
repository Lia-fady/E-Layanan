<?php
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
require_once FCPATH . '../app/Config/Paths.php';
$paths = new Config\Paths();
require_once $paths->systemDirectory . '/bootstrap.php';

$model = new \App\Models\Kabid\M_Penempatan();
try {
    $res = $model->getSemuaPenempatan();
    echo "getSemuaPenempatan OK: " . count($res) . " results.\n";
} catch (\Exception $e) {
    echo "Error in getSemuaPenempatan: " . $e->getMessage() . "\n";
}

try {
    $res2 = $model->getDetailPenempatan(1);
    echo "getDetailPenempatan OK.\n";
} catch (\Exception $e) {
    echo "Error in getDetailPenempatan: " . $e->getMessage() . "\n";
}
