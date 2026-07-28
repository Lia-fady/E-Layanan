<?php
require 'vendor/autoload.php';
$app = new \Config\App();
require_once SYSTEMPATH . 'bootstrap.php';

$db = \Config\Database::connect();
if ($db->tableExists('m_bidang')) {
    $res = $db->query('SELECT * FROM m_bidang')->getResultArray();
    print_r($res);
} else {
    echo "Tabel m_bidang tidak ada\n";
}
