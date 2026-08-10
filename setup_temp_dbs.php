<?php
$mysqli = new mysqli('localhost', 'root', '');
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$mysqli->query("DROP DATABASE IF EXISTS temp_db_final");
$mysqli->query("CREATE DATABASE temp_db_final");
$mysqli->query("DROP DATABASE IF EXISTS temp_db_final1");
$mysqli->query("CREATE DATABASE temp_db_final1");

echo "Databases created.\n";

function import_sql($mysqli, $db_name, $file_path) {
    $mysqli->select_db($db_name);
    $query = '';
    $sqlScript = file($file_path);
    foreach ($sqlScript as $line) {
        $startWith = substr(trim($line), 0, 2);
        if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
            continue;
        }
        $query = $query . $line;
        if (substr(trim($line), -1, 1) == ';') {
            if (!$mysqli->query($query)) {
                echo "Error performing query '$query': " . $mysqli->error . "\n";
            }
            $query = '';
        }
    }
}

echo "Importing final...\n";
import_sql($mysqli, 'temp_db_final', __DIR__ . '/public/db_elayanan_akademik_kominfo_final.sql');
echo "Importing final(1)...\n";
import_sql($mysqli, 'temp_db_final1', __DIR__ . '/public/db_elayanan_akademik_kominfo_final(1).sql');

echo "Done importing.\n";
$mysqli->close();
