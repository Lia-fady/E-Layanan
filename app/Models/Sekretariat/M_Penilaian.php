<?php
/**
 * ============================================================
 * Kode      : M_Penilaian.php
 * Path      : Models/Sekretariat/M_Penilaian.php
 * Deskripsi : Model untuk mengelola data penilaian magang mahasiswa,
 *             termasuk komponen penilaian dan nilai per penempatan
 * ============================================================
 */

namespace App\Models\Sekretariat;

use CodeIgniter\Model;

class M_Penilaian extends Model
{
    protected $table            = 't_penilaian_magang';
    protected $primaryKey       = 'id_penilaian_magang';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_penempatan_magang',
        'id_komponen_penilaian',
        'nilai',
        'created_by',
        
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Mengambil data mahasiswa yang sedang aktif magang atau sudah selesai.
     *
     * @return array
     */
    public function getMahasiswaAktif(): array
    {
        $builder = $this->db->table('t_penempatan_magang AS pn');

        $builder->select([
            'pn.id_penempatan_magang',
            'pn.status_penempatan',
            'm.nim',
            'm.nama_mahasiswa',
            'b.bidang',
        ]);

        $builder->join('m_mahasiswa AS m', 'm.id_mahasiswa = pn.id_mahasiswa', 'left');
        $builder->join('m_bidang AS b', 'b.id_bidang = pn.id_bidang', 'left');

        $builder->whereIn('pn.status_penempatan', ['BERJALAN', 'SELESAI']);

        return $builder->get()->getResultArray();
    }

    /**
     * Mengambil semua komponen penilaian yang aktif.
     *
     * @return array
     */
    public function getKomponenPenilaian(): array
    {
        $builder = $this->db->table('m_komponen_penilaian');

        $builder->where('status_aktif', '1');

        return $builder->get()->getResultArray();
    }

    /**
     * Mengambil data penilaian berdasarkan id penempatan magang.
     *
     * @param int $id_penempatan
     * @return array
     */
    public function getNilaiByPenempatan($id_penempatan): array
    {
        $builder = $this->db->table('t_penilaian_magang AS pnm');

        $builder->select([
            'pnm.id_penilaian_magang',
            'pnm.id_penempatan_magang',
            'pnm.id_komponen_penilaian',
            'pnm.nilai',
            'kp.komponen_penilaian',
        ]);

        $builder->join('m_komponen_penilaian AS kp', 'kp.id_komponen_penilaian = pnm.id_komponen_penilaian', 'left');
        $builder->where('pnm.id_penempatan_magang', $id_penempatan);

        return $builder->get()->getResultArray();
    }

    /**
     * Mengambil detail penempatan magang beserta informasi terkait.
     *
     * @param int $id_penempatan
     * @return array|null
     */
    public function getDetailPenempatan($id_penempatan)
    {
        $builder = $this->db->table('t_penempatan_magang AS pn');

        $builder->select([
            'pn.id_penempatan_magang',
            'pn.status_penempatan',
            'pn.catatan AS catatan_penempatan',
            'm.id_mahasiswa',
            'm.nim',
            'm.nama_mahasiswa',
            'm.jenis_kelamin',
            'm.email',
            'm.no_telp',
            'b.bidang',
            'ps.status_persetujuan',
            'pm.tgl_mulai',
            'pm.tgl_selesai',
            'pm.deskripsi_keahlian',
            'pm.deskripsi_magang',
        ]);

        $builder->join('m_mahasiswa AS m', 'm.id_mahasiswa = pn.id_mahasiswa', 'left');
        $builder->join('m_bidang AS b', 'b.id_bidang = pn.id_bidang', 'left');
        $builder->join('t_persetujuan_magang AS ps', 'ps.id_persetujuan_magang = pn.id_persetujuan_magang', 'left');
        $builder->join('t_permohonan_magang AS pm', 'pm.id_permohonan_magang = ps.id_permohonan_magang', 'left');

        $builder->where('pn.id_penempatan_magang', $id_penempatan);

        return $builder->get()->getRowArray();
    }

    /**
     * Menyimpan atau memperbarui nilai penilaian magang.
     * Jika record sudah ada (penempatan + komponen), lakukan update.
     * Jika belum ada, lakukan insert baru.
     *
     * @param int   $id_penempatan
     * @param int   $komponen_id
     * @param float $nilai
     * @return bool
     */
    public function simpanNilai($id_penempatan, $komponen_id, $nilai): bool
    {
        $builder = $this->db->table('t_penilaian_magang');

        // Cek apakah record sudah ada
        $existing = $builder
            ->where('id_penempatan_magang', $id_penempatan)
            ->where('id_komponen_penilaian', $komponen_id)
            ->get()
            ->getRowArray();

        if ($existing) {
            // Update record yang sudah ada
            $this->db->table('t_penilaian_magang')
                ->where('id_penilaian_magang', $existing['id_penilaian_magang'])
                ->update([
                    'nilai'      => $nilai, 
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
        } else {
            // Insert record baru
            $this->db->table('t_penilaian_magang')
                ->insert([
                    'id_penempatan_magang'  => $id_penempatan,
                    'id_komponen_penilaian' => $komponen_id,
                    'nilai'                 => $nilai,
                    'created_by'            => session('id_user_pegawai'),
                    'created_at'            => date('Y-m-d H:i:s'),
                ]);
        }

        return true;
    }
}
