<?php
$mysqli = new mysqli('localhost', 'root', '', 'db_elayanan_akademik_kominfo_final');
echo "=== t_penilaian_magang COLUMNS ===\n";
$res = $mysqli->query("DESCRIBE t_penilaian_magang");
while($col = $res->fetch_assoc()) {
    echo $col['Field'] . " | " . $col['Type'] . "\n";
}
echo "\n=== t_notifikasi COLUMNS ===\n";
$res = $mysqli->query("DESCRIBE t_notifikasi");
while($col = $res->fetch_assoc()) {
    echo $col['Field'] . " | " . $col['Type'] . "\n";
}
$mysqli->close();
