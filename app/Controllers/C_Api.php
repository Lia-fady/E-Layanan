<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Api\M_Fakultas_Api;
use App\Models\Api\M_Prodi_Api;

class C_Api extends Controller
{
    public function getFakultasByKampus($id_kampus)
    {
        $fakultasModel = new M_Fakultas_Api();
        $fakultas = $fakultasModel->where('id_instansi_pendidikan', $id_kampus)
                                  ->groupStart()
                                    ->where('status', 'aktif')
                                    ->orWhere('status', '1')
                                  ->groupEnd()
                                  ->findAll();
        
        return $this->response->setJSON($fakultas);
    }

    public function getProdiByFakultas($id_fakultas)
    {
        $prodiModel = new M_Prodi_Api();
        $prodi = $prodiModel->where('id_fakultas', $id_fakultas)
                            ->groupStart()
                              ->where('status', 'aktif')
                              ->orWhere('status', '1')
                            ->groupEnd()
                            ->findAll();
        
        return $this->response->setJSON($prodi);
    }
}
