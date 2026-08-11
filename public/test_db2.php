<?php
$conn = new mysqli('localhost', 'root', '', 'db_elayanan_akademik_kominfo_final');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$res = $conn->query("SHOW COLUMNS FROM m_mahasiswa");
while ($row = $res->fetch_assoc()) {
    print_r($row);
}
