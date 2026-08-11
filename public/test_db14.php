<?php
$conn = new mysqli('localhost', 'root', '', 'db_elayanan_akademik_kominfo_final');
$res = $conn->query("SHOW COLUMNS FROM t_instansi_mahasiswa");
while ($row = $res->fetch_assoc()) {
    print_r($row);
}
