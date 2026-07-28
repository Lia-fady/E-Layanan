<?php
$host = '192.168.133.117';
$user = 'remote_user';
$pass = '123456';
$db   = 'db_elayanan_akademik_kominfo';

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

echo "Current m_bidang:\n";
$res = $mysqli->query("SELECT * FROM m_bidang");
while ($row = $res->fetch_assoc()) {
    print_r($row);
}

echo "\nCurrent m_opd:\n";
$res = $mysqli->query("SELECT * FROM m_opd LIMIT 5");
while ($row = $res->fetch_assoc()) {
    print_r($row);
}
