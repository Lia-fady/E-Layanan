<?php
$conn = new mysqli('localhost', 'root', '', 'db_elayanan_akademik_kominfo_final');
$res = $conn->query("SELECT * FROM m_file_permohonan WHERE id_jenis_permohonan = 5");
while ($row = $res->fetch_assoc()) {
    print_r($row);
}
