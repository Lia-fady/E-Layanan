<?php
$conn = new mysqli('localhost', 'root', '', 'db_elayanan_akademik_kominfo_final');
$res = $conn->query("SELECT * FROM m_kuota LIMIT 5");
while($r = $res->fetch_assoc()) print_r($r);

$res2 = $conn->query("SELECT * FROM m_jenis_permohonan");
while($r = $res2->fetch_assoc()) print_r($r);
