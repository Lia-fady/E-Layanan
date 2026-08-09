<?php
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
require_once FCPATH . '../app/Config/Paths.php';
$paths = new Config\Paths();
require_once $paths->systemDirectory . '/bootstrap.php';

$model1 = new \App\Models\Kabid\M_Penempatan();
$model2 = new \App\Models\Kabid\M_LogbookKabid();
echo "Models instantiated successfully without syntax errors.\n";
