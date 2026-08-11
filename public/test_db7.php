<?php
$conn = new mysqli('localhost', 'root', '', 'db_elayanan_akademik_kominfo_final');
$res = $conn->query("SHOW TABLES");
while ($row = $res->fetch_array()) { echo $row[0] . "\n"; }
