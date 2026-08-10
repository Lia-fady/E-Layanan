<?php
$mysqli = new mysqli('localhost', 'root', '');
$res = $mysqli->query("SELECT * FROM temp_db_final.m_fakultas LIMIT 2");
while($row = $res->fetch_assoc()) {
    print_r($row);
}
