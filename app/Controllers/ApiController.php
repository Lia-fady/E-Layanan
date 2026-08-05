<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\FakultasModel;
use App\Models\ProdiModel;

class ApiController extends Controller
{
    public function getFakultasByKampus($id_kampus)
    {
        $fakultasModel = new FakultasModel();
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
        $prodiModel = new ProdiModel();
        $prodi = $prodiModel->where('id_fakultas', $id_fakultas)
                            ->groupStart()
                              ->where('status', 'aktif')
                              ->orWhere('status', '1')
                            ->groupEnd()
                            ->findAll();
        
        return $this->response->setJSON($prodi);
    }
    public function getKabupatenByProvinsi($id_provinsi)
    {
        $db = \Config\Database::connect();
        $kabupaten = $db->table('m_kabupaten')
                        ->where('id_provinsi', $id_provinsi)
                        ->get()->getResultArray();
        return $this->response->setJSON($kabupaten);
    }

    public function getKecamatanByKabupaten($id_kabupaten)
    {
        $db = \Config\Database::connect();
        $kecamatan = $db->table('m_kecamatan')
                        ->where('id_kabupaten', $id_kabupaten)
                        ->get()->getResultArray();
        return $this->response->setJSON($kecamatan);
    }

    public function getKelurahanByKecamatan($id_kecamatan)
    {
        $db = \Config\Database::connect();
        $kelurahan = $db->table('m_kelurahan')
                        ->where('id_kecamatan', $id_kecamatan)
                        ->get()->getResultArray();
        return $this->response->setJSON($kelurahan);
    }
}
