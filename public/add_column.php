<?php
require 'index.php'; // Boot CI4
$db = \Config\Database::connect();
try {
    $db->query("ALTER TABLE t_file_permohonan_magang ADD COLUMN status_verifikasi VARCHAR(20) NULL DEFAULT NULL AFTER path_file;");
    echo "Column added successfully.\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
