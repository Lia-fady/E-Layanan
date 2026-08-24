<?php
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
require FCPATH . '../app/Config/Paths.php';
$paths = new Config\Paths();
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';
$db = \Config\Database::connect();

$newFiles = [
    ['nama_file' => 'File Surat Keterangan Diterima Magang', 'status_aktif' => '1'],
    ['nama_file' => 'File Sertifikat', 'status_aktif' => '1'],
    ['nama_file' => 'File Surat Keterangan Selesai Magang', 'status_aktif' => '1'],
];

foreach ($newFiles as $file) {
    $existing = $db->table('m_file')->where('nama_file', $file['nama_file'])->get()->getRow();
    if (!$existing) {
        $db->table('m_file')->insert($file);
        echo "Inserted: " . $file['nama_file'] . "<br>";
    } else {
        echo "Exists: " . $file['nama_file'] . "<br>";
    }
}
echo "Done.";
