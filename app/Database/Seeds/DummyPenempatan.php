<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DummyPenempatan extends Seeder
{
    public function run()
    {
        // 1. Ambil data bidang yang tersedia
        $bidangList = $this->db->table('m_bidang')->get()->getResult();
        if (empty($bidangList)) {
            echo "Belum ada data bidang di tabel m_bidang. Silakan isi master bidang terlebih dahulu.\n";
            return;
        }

        // 2. Ambil data persetujuan yang sudah DISETUJUI dan sudah didisposisikan
        $persetujuanList = $this->db->table('t_persetujuan_magang')
            ->where('status_persetujuan', 'DISETUJUI')
            ->where('disposisi', '1')
            ->get()
            ->getResult();

        if (empty($persetujuanList)) {
            echo "Belum ada data persetujuan yang DISETUJUI & sudah didisposisikan.\n";
            echo "Membuat data dummy langsung ke tabel t_penempatan_magang...\n\n";

            // Ambil data mahasiswa yang tersedia
            $mahasiswaList = $this->db->table('m_mahasiswa')->limit(5)->get()->getResult();
            if (empty($mahasiswaList)) {
                echo "Belum ada data mahasiswa di tabel m_mahasiswa. Silakan isi master mahasiswa terlebih dahulu.\n";
                return;
            }

            // Insert dummy tanpa relasi persetujuan
            $now = date('Y-m-d H:i:s');
            $statusOptions = ['BERJALAN', 'SELESAI', 'BERJALAN', 'BERJALAN', 'SELESAI'];
            $catatanList = [
                'Mahasiswa ditempatkan sesuai kompetensi jurusan.',
                'Penempatan berdasarkan permintaan bidang terkait.',
                'Ditempatkan untuk membantu proyek digitalisasi.',
                'Penempatan sesuai hasil disposisi kepala dinas.',
                'Penempatan untuk mendukung kegiatan administrasi.',
            ];

            $inserted = 0;
            foreach ($mahasiswaList as $index => $mhs) {
                $bidang = $bidangList[$index % count($bidangList)];
                $status = $statusOptions[$index % count($statusOptions)];
                $catatan = $catatanList[$index % count($catatanList)];

                // Cek agar tidak duplikat
                $exists = $this->db->table('t_penempatan_magang')
                    ->where('id_mahasiswa', $mhs->id_mahasiswa)
                    ->countAllResults();

                if ($exists > 0) {
                    echo "Mahasiswa ID {$mhs->id_mahasiswa} ({$mhs->nama_mahasiswa}) sudah ada di penempatan, dilewati.\n";
                    continue;
                }

                $this->db->table('t_penempatan_magang')->insert([
                    'id_bidang'              => $bidang->id_bidang,
                    'id_persetujuan_magang'  => 0, // dummy, tidak ada relasi persetujuan
                    'id_mahasiswa'           => $mhs->id_mahasiswa,
                    'catatan'                => $catatan,
                    'status_penempatan'      => $status,
                    'created_by'             => 1,
                    'updated_by'             => null,
                    'created_at'             => $now,
                    'updated_at'             => null,
                ]);
                $inserted++;
                echo "Inserted penempatan untuk: {$mhs->nama_mahasiswa} -> Bidang: {$bidang->bidang} [{$status}]\n";
            }

            echo "\nTotal {$inserted} data dummy penempatan berhasil ditambahkan.\n";
            return;
        }

        // 3. Jika ada data persetujuan yang valid, gunakan relasi yang benar
        $now = date('Y-m-d H:i:s');
        $catatanList = [
            'Mahasiswa ditempatkan sesuai kompetensi jurusan.',
            'Penempatan berdasarkan permintaan bidang terkait.',
            'Ditempatkan untuk membantu proyek digitalisasi.',
            'Penempatan sesuai hasil disposisi kepala dinas.',
            'Penempatan untuk mendukung kegiatan administrasi.',
        ];

        $inserted = 0;
        foreach ($persetujuanList as $index => $persetujuan) {
            // Ambil data permohonan untuk mendapatkan id_mahasiswa
            $permohonan = $this->db->table('t_permohonan_magang')
                ->where('id_permohonan_magang', $persetujuan->id_permohonan_magang)
                ->get()
                ->getRow();

            if (!$permohonan) {
                continue;
            }

            // Gunakan bidang dari disposisi persetujuan, atau ambil dari master
            $id_bidang = $persetujuan->id_bidang ?? $bidangList[0]->id_bidang;
            $id_mahasiswa = $permohonan->id_mahasiswa;

            // Cek agar tidak duplikat
            $exists = $this->db->table('t_penempatan_magang')
                ->where('id_mahasiswa', $id_mahasiswa)
                ->where('id_persetujuan_magang', $persetujuan->id_persetujuan_magang)
                ->countAllResults();

            if ($exists > 0) {
                echo "Mahasiswa ID {$id_mahasiswa} sudah ada di penempatan persetujuan ini, dilewati.\n";
                continue;
            }

            $catatan = $catatanList[$inserted % count($catatanList)];
            $status = ($inserted % 3 === 0) ? 'SELESAI' : 'BERJALAN';

            $this->db->table('t_penempatan_magang')->insert([
                'id_bidang'              => $id_bidang,
                'id_persetujuan_magang'  => $persetujuan->id_persetujuan_magang,
                'id_mahasiswa'           => $id_mahasiswa,
                'catatan'                => $catatan,
                'status_penempatan'      => $status,
                'created_by'             => 1,
                'updated_by'             => null,
                'created_at'             => $now,
                'updated_at'             => null,
            ]);
            $inserted++;
            echo "Inserted penempatan: Mahasiswa ID {$id_mahasiswa} -> Bidang ID {$id_bidang} [{$status}]\n";
        }

        if ($inserted > 0) {
            echo "\nTotal {$inserted} data dummy penempatan berhasil ditambahkan.\n";
        } else {
            echo "Tidak ada data baru yang ditambahkan (mungkin sudah ada semua).\n";
        }
    }
}
