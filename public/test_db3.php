<?php
$conn = new mysqli('localhost', 'root', '', 'db_elayanan_akademik_kominfo_final');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$res = $conn->query("SHOW TABLES LIKE '%provinsi%'");
while ($row = $res->fetch_array()) { echo $row[0] . "\n"; }
$res = $conn->query("SHOW TABLES LIKE '%kecamatan%'");
while ($row = $res->fetch_array()) { echo $row[0] . "\n"; }
$res = $conn->query("SHOW TABLES LIKE '%kelurahan%'");
while ($row = $res->fetch_array()) { echo $row[0] . "\n"; }
