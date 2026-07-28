<?php
$host = '192.168.133.117';
$user = 'remote_user';
$pass = '123456';
$db   = 'db_elayanan_akademik_kominfo';

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// 1. Tambah Bidang 1 (Infrastruktur TIK) dengan id_opd = 1
$res = $mysqli->query("SELECT id_bidang FROM m_bidang WHERE id_bidang = 1");
if ($res->num_rows == 0) {
    $mysqli->query("INSERT INTO m_bidang (id_bidang, bidang, status_aktif, id_opd, kuota_total) VALUES (1, 'Bidang Infrastruktur TIK', 1, 1, 10)");
    echo "Inserted Bidang 1.\n";
} else {
    echo "Bidang 1 already exists.\n";
}

// 2. Set default kuota untuk semua bidang jika kosong
$mysqli->query("UPDATE m_bidang SET kuota_total = 10 WHERE kuota_total IS NULL");

echo "Update complete.\n";
