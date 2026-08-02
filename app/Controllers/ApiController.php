<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Api\M_FakultasApi;
use App\Models\Api\M_ProdiApi;

class ApiController extends Controller
{
    public function getFakultasByKampus($id_kampus)
    {
        $fakultasModel = new M_FakultasApi();
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
        $prodiModel = new M_ProdiApi();
        $prodi = $prodiModel->where('id_fakultas', $id_fakultas)
                            ->groupStart()
                              ->where('status', 'aktif')
                              ->orWhere('status', '1')
                            ->groupEnd()
                            ->findAll();
        
        return $this->response->setJSON($prodi);
    }
}
