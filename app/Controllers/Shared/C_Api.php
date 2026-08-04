<?php

namespace App\Controllers\Shared;

use CodeIgniter\Controller;
use App\Models\Shared\M_Fakultas;
use App\Models\Shared\M_Prodi;

class C_Api extends Controller
{
    public function getFakultasByKampus($id_kampus)
    {
        $fakultasModel = new M_Fakultas_Mahasiswa();
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
        $prodiModel = new M_Prodi_Mahasiswa();
        $prodi = $prodiModel->where('id_fakultas', $id_fakultas)
                            ->groupStart()
                              ->where('status', 'aktif')
                              ->orWhere('status', '1')
                            ->groupEnd()
                            ->findAll();
        
        return $this->response->setJSON($prodi);
    }
}
