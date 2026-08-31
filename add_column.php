<?php
define('FCPATH', __DIR__ . '/public/');
require_once __DIR__ . '/vendor/autoload.php';

// Load env
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
try { $dotenv->load(); } catch (Exception $e) {}

// Read .env manually
$env = file_get_contents(__DIR__ . '/.env');
preg_match('/database\.default\.hostname\s*=\s*(.+)/', $env, $mHost);
preg_match('/database\.default\.database\s*=\s*(.+)/', $env, $mDb);
preg_match('/database\.default\.username\s*=\s*(.+)/', $env, $mUser);
preg_match('/database\.default\.password\s*=\s*(.+)/', $env, $mPass);
preg_match('/database\.default\.port\s*=\s*(.+)/', $env, $mPort);

$host = trim($mHost[1] ?? 'localhost');
$dbname = trim($mDb[1] ?? '');
$username = trim($mUser[1] ?? 'root');
$password = trim($mPass[1] ?? '');
$port = (int)trim($mPort[1] ?? 3306);

echo "Connecting to: $host:$port / $dbname as $username\n";

$mysqli = new mysqli($host, $username, $password, $dbname, $port);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error . "\n");
}

// Check if column exists
$checkQuery = "SHOW COLUMNS FROM `t_penempatan_magang` LIKE 'tgl_penetapan_magang'";
$result = $mysqli->query($checkQuery);
if ($result && $result->num_rows > 0) {
    echo "Kolom 'tgl_penetapan_magang' sudah ada.\n";
} else {
    $alterQuery = "ALTER TABLE `t_penempatan_magang` ADD COLUMN `tgl_penetapan_magang` DATE NULL AFTER `is_log_book`";
    if ($mysqli->query($alterQuery)) {
        echo "Kolom 'tgl_penetapan_magang' berhasil ditambahkan ke t_penempatan_magang.\n";
    } else {
        echo "Error: " . $mysqli->error . "\n";
    }
}

$mysqli->close();
echo "Selesai.\n";
