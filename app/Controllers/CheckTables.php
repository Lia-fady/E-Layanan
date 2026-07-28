<?php
namespace App\Controllers;
use CodeIgniter\Controller;
class CheckTables extends Controller
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        $response = [
            'tables' => $db->listTables(),
            'm_bidang_exists' => $db->tableExists('m_bidang')
        ];
        
        if ($response['m_bidang_exists']) {
            $response['m_bidang_columns'] = $db->getFieldNames('m_bidang');
            $response['m_bidang_data'] = $db->query('SELECT * FROM m_bidang')->getResultArray();
        }
        
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
}
