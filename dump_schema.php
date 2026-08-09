<?php
$mysqli = new mysqli('localhost', 'root', '', 'db_elayanan_akademik_kominfo_final');
$tables = [
    't_penempatan_magang', 
    't_persetujuan_magang', 
    't_permohonan_magang', 
    't_logbook_magang', 
    't_file_permohonan_magang', 
    'm_file', 
    'm_bidang', 
    'c_user_pegawai'
];

foreach ($tables as $table) {
    echo "=== $table ===\n";
    $res = $mysqli->query("DESCRIBE `$table`");
    if ($res) {
        while($col = $res->fetch_assoc()) {
            echo $col['Field'] . " | " . $col['Type'] . " | " . $col['Null'] . " | " . $col['Default'] . "\n";
        }
    } else {
        echo "Table not found.\n";
    }
    echo "\n";
}
$mysqli->close();
