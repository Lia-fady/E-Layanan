<?php
$mysqli = new mysqli('localhost', 'root', '', 'db_elayanan_akademik_kominfo_final');
$res = $mysqli->query("DESCRIBE `t_file_proses_magang`");
if ($res) {
    while($col = $res->fetch_assoc()) {
        echo $col['Field'] . " | " . $col['Type'] . "\n";
    }
}
$mysqli->close();
