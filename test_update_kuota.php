<?php
$host = '192.168.133.117';
$user = 'remote_user';
$pass = '123456';
$db   = 'db_elayanan_akademik_kominfo';

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// 1. Let's manually set kuota_total for id_bidang = 2 to 99 to see if DB updates
$mysqli->query("UPDATE m_bidang SET kuota_total = 99 WHERE id_bidang = 2");

// 2. Fetch the data again to verify
echo "After UPDATE:\n";
$res = $mysqli->query("SELECT id_bidang, bidang, kuota_total FROM m_bidang WHERE id_bidang = 2");
print_r($res->fetch_assoc());
