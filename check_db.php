<?php
require 'vendor/autoload.php';
$app = new \Config\App();
require_once SYSTEMPATH . 'bootstrap.php';
\Config\Services::session(); // Initialize session if needed

$db = \Config\Database::connect();
echo "Tables:\n";
print_r($db->listTables());

if ($db->tableExists('m_bidang')) {
    echo "\nm_bidang columns:\n";
    print_r($db->getFieldNames('m_bidang'));
    echo "\nm_bidang data:\n";
    print_r($db->query('SELECT * FROM m_bidang')->getResultArray());
} else {
    echo "\nTabel m_bidang tidak ditemukan.\n";
}
