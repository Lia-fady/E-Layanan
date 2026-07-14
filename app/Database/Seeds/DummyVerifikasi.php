<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DummyVerifikasi extends Seeder
{
    public function run()
    {
        // 1. Ambil salah satu permohonan yang ada di database
        $permohonan = $this->db->table('t_permohonan_magang')->limit(1)->get()->getRow();
        if ($permohonan) {
            $id_permohonan = $permohonan->id_permohonan_magang;

            // Pastikan permohonan berstatus 'kirim'
            $this->db->table('t_permohonan_magang')
                ->where('id_permohonan_magang', $id_permohonan)
                ->update(['posting_data' => 'kirim']);

            // Ubah persetujuan agar permohonan kembali ke status "MENUNGGU" untuk verifikasi
            $this->db->table('t_persetujuan_magang')
                 ->where('id_permohonan_magang', $id_permohonan)
                 ->update(['status_persetujuan' => 'MENUNGGU']);

            // 2. Pastikan ada file master dan file permohonan untuk di-review
            $fileMaster = $this->db->table('m_file')->limit(1)->get()->getRow();
            if ($fileMaster) {
                $id_file = $fileMaster->id_file;
                
                // Pastikan ada file lampiran
                $filePermohonan = $this->db->table('t_file_permohonan_magang')->getWhere(['id_permohonan_magang' => $id_permohonan])->getRow();
                if (!$filePermohonan) {
                    $this->db->table('t_file_permohonan_magang')->insert([
                        'id_permohonan_magang' => $id_permohonan,
                        'id_file' => $id_file,
                        'nama_file' => 'dummy_surat_pengantar.pdf',
                        'path_file' => 'uploads/dummy_surat_pengantar.pdf',
                        'status_verifikasi' => null
                    ]);
                } else {
                    $this->db->table('t_file_permohonan_magang')
                        ->where('id_permohonan_magang', $id_permohonan)
                        ->update(['status_verifikasi' => null]);
                }
            }

            echo "Berhasil menyiapkan data untuk Verifikasi Berkas. Silakan cek Permohonan ID: " . $id_permohonan . "\n";
        } else {
            echo "Belum ada data permohonan di database. Silakan isi form permohonan magang terlebih dahulu.\n";
        }
    }
}
