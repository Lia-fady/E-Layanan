<?php
$conn = new mysqli('localhost', 'root', '', 'db_elayanan_akademik_kominfo_final');

$res = $conn->query("SHOW TABLES");
echo "=== ALL TABLES ===\n";
while($r = $res->fetch_array()) {
    echo $r[0] . "\n";
}

$tables = ['m_kuota', 'm_bidang', 't_permohonan_magang', 'm_jenis_permohonan'];
foreach($tables as $t) {
    echo "=== $t ===\n";
    $res = $conn->query("DESCRIBE $t");
    if($res) {
        while($r = $res->fetch_assoc()) echo $r['Field'] . " | " . $r['Type'] . "\n";
    } else {
        echo "Table not found.\n";
    }
}
