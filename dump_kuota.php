<?php
$mysqli = new mysqli('localhost', 'root', '', 'db_elayanan_akademik_kominfo_final');
$tables = ['m_kuota'];

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
