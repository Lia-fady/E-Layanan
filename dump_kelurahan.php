<?php
$mysqli = new mysqli('localhost', 'root', '');
$res = $mysqli->query("SELECT COLUMN_NAME, COLUMN_TYPE, IS_NULLABLE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = 'temp_db_final' AND TABLE_NAME = 'm_kelurahan'");
while($row = $res->fetch_assoc()) {
    echo $row['COLUMN_NAME'] . " | " . $row['COLUMN_TYPE'] . "\n";
}
