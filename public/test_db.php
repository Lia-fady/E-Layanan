<?php
$conn = new mysqli('localhost', 'root', '', 'db_elayanan_akademik_kominfo_final');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$res = $conn->query("SHOW COLUMNS FROM m_instansi_pendidikan");
while ($row = $res->fetch_assoc()) {
    print_r($row);
}
$res2 = $conn->query("SELECT * FROM m_instansi_pendidikan");
while ($row = $res2->fetch_assoc()) {
    print_r($row);
}
