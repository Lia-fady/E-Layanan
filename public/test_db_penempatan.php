<?php
$conn = new mysqli('localhost', 'root', '', 'db_elayanan_akademik_kominfo_final');
$res = $conn->query("SHOW COLUMNS FROM t_penempatan_magang LIKE 'status_penempatan'");
print_r($res->fetch_assoc());
