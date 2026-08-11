<?php
$conn = new mysqli('localhost', 'root', '', 'db_elayanan_akademik_kominfo_final');
$res = $conn->query("SELECT * FROM m_file_permohonan");
while ($row = $res->fetch_assoc()) {
    print_r($row);
}
