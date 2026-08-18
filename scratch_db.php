<?php
$mysqli = new mysqli("127.0.0.1", "root", "", "db_elayanan_akademik_kominfo_final(1)");

echo "=== m_kabupaten columns ===\n";
$res = $mysqli->query("SHOW COLUMNS FROM m_kabupaten");
while($row = $res->fetch_assoc()) echo $row['Field'] . "\n";

echo "\n=== m_kabupaten sample ===\n";
$res = $mysqli->query("SELECT * FROM m_kabupaten LIMIT 3");
while($row = $res->fetch_assoc()) print_r($row);
