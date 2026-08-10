<?php
$mysqli = new mysqli('localhost', 'root', '');
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

function dump_table($mysqli, $db_name, $table) {
    echo "=== $table ===\n";
    $res = $mysqli->query("SELECT COLUMN_NAME, COLUMN_TYPE, IS_NULLABLE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '$db_name' AND TABLE_NAME = '$table'");
    while($row = $res->fetch_assoc()) {
        echo $row['COLUMN_NAME'] . " | " . $row['COLUMN_TYPE'] . " | " . $row['IS_NULLABLE'] . "\n";
    }
    echo "\n";
}

dump_table($mysqli, 'temp_db_final', 'm_mahasiswa');
dump_table($mysqli, 'temp_db_final', 't_instansi_mahasiswa');
dump_table($mysqli, 'temp_db_final', 'm_user_mahasiswa');

$mysqli->close();
