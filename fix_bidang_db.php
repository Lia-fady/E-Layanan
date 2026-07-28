<?php
$host = '192.168.133.117';
$user = 'remote_user';
$pass = '123456';
$db   = 'db_elayanan_akademik_kominfo';

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Ensure the kuota_total column exists
$result = $mysqli->query("SHOW COLUMNS FROM m_bidang LIKE 'kuota_total'");
if ($result->num_rows == 0) {
    $mysqli->query("ALTER TABLE m_bidang ADD COLUMN kuota_total INT DEFAULT 10");
    echo "Added kuota_total column.\n";
} else {
    echo "kuota_total column exists.\n";
}

$bidangs = [
    1 => 'Bidang Infrastruktur TIK',
    2 => 'Bidang Diseminasi Informasi Dan Komunikasi Publik',
    3 => 'Bidang Sarana, Prasarana TIK dan Persandian',
    4 => 'Bidang Statistik dan Pemberdayaan TIK',
    5 => 'Bidang Pengembangan E-Government'
];

foreach ($bidangs as $id => $nama) {
    // Check if exists
    $res = $mysqli->query("SELECT id_bidang FROM m_bidang WHERE id_bidang = $id");
    if ($res->num_rows == 0) {
        $stmt = $mysqli->prepare("INSERT INTO m_bidang (id_bidang, bidang, kuota_total) VALUES (?, ?, 10)");
        $stmt->bind_param("is", $id, $nama);
        $stmt->execute();
        echo "Inserted Bidang ID $id: $nama\n";
    } else {
        $stmt = $mysqli->prepare("UPDATE m_bidang SET bidang = ? WHERE id_bidang = ?");
        $stmt->bind_param("si", $nama, $id);
        $stmt->execute();
        echo "Updated Bidang ID $id: $nama\n";
    }
}

$res = $mysqli->query("SELECT * FROM m_bidang");
while ($row = $res->fetch_assoc()) {
    print_r($row);
}
