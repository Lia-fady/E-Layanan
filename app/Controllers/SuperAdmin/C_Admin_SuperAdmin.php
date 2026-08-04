<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\Shared\C_Base;
use App\Models\Shared\M_PermohonanMagang; // Memanggil model secara global di atas

class C_Admin_SuperAdmin extends C_Base
{
    public function index()
    {
        $permohonanModel = new M_PermohonanMagang_Mahasiswa();

        // Ambil semua data permohonan magang yang masuk dari database
        $daftarPengajuan = $permohonanModel->findAll();

        // Lempar datanya ke view admin
        $data = [
            'pengajuan' => $daftarPengajuan
        ];

        return view('superadmin/V_DaftarPengajuan_SuperAdmin', $data);
    }

    public function updateStatus($id, $status)
    {
        $permohonanModel = new M_PermohonanMagang_Mahasiswa();

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