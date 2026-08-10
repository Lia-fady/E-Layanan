<?php
$mysqli = new mysqli('localhost', 'root', '');
$res = $mysqli->query("SELECT * FROM db_elayanan_akademik_kominfo_final.m_fakultas LIMIT 2");
if ($res) {
    while($row = $res->fetch_assoc()) {
        print_r($row);
    }
} else {
    echo $mysqli->error;
}
