<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermohonanMagangModel; // Memanggil model secara global di atas

class Admin extends BaseController
{
    public function index()
    {
        $permohonanModel = new PermohonanMagangModel();

        // Ambil semua data permohonan magang yang masuk dari database
        $daftarPengajuan = $permohonanModel->findAll();

        // Lempar datanya ke view admin
        $data = [
            'pengajuan' => $daftarPengajuan
        ];

        return view('admin/daftar_pengajuan', $data);
    }

    public function updateStatus($id, $status)
    {
        $permohonanModel = new PermohonanMagangModel();

        // Konversi kata dari tombol menjadi angka ENUM database
        $enumStatus = '1'; 
        if ($status === 'diterima') {
            $enumStatus = '2';
        } elseif ($status === 'ditolak') {
            $enumStatus = '0'; 
        }

        $dataUpdate = [
            'posting_data' => $enumStatus
        ];

        // KUNCI PERBAIKAN: Gunakan format update resmi CI4 -> update(PRIMARY_KEY, DATA_ARRAY)
        $permohonanModel->update($id, $dataUpdate);

        // Set notifikasi sukses
        session()->setFlashdata('success', 'Status permohonan berhasil diperbarui menjadi ' . $status . '!');
        
        return redirect()->to(base_url('admin'));
    }
}