<?php
$conn = @new mysqli('192.168.133.95','remote_user','123456','db_elayanan_akademik_kominfo',3306);
if ($conn->connect_error) {
    echo 'ERROR: ' . $conn->connect_error;
} else {
    echo 'OK';
    $conn->close();
}

