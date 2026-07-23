<?php

namespace App\Models\Mahasiswa;

use CodeIgniter\Model;

class PermohonanMagangModel extends Model
{
    protected $table            = 't_permohonan_magang';
    protected $primaryKey       = 'id_permohonan_magang';
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_mahasiswa', 'id_instansi_mahasiswa', 'id_jenis_permohonan', 
        'deskripsi_keahlian', 'deskripsi_magang', 'tgl_mulai', 
        'tgl_selesai', 'posting_data', 'created_at', 'updated_at'
    ];

    /**
     * Kueri untuk mengambil status tracking permohonan mahasiswa beserta join-nya
     */
   /**
     * Kueri untuk mengambil status tracking permohonan mahasiswa beserta join-nya
     */
   /**
     * Kueri untuk mengambil status tracking permohonan mahasiswa beserta join-nya
     */
    public function getStatusPermohonan($id_mahasiswa, $filterStatus = null)
    {
        $builder = $this->db->table($this->table)
            ->select('
                t_permohonan_magang.id_permohonan_magang,
                t_permohonan_magang.id_jenis_permohonan,
                t_permohonan_magang.id_instansi_mahasiswa,
                t_permohonan_magang.deskripsi_keahlian,
                t_permohonan_magang.deskripsi_magang,
                t_permohonan_magang.tgl_mulai,
                t_permohonan_magang.tgl_selesai,
                t_permohonan_magang.posting_data,
                t_permohonan_magang.created_at,
                t_permohonan_magang.id_mahasiswa,
                t_persetujuan_magang.status_persetujuan, 
                t_persetujuan_magang.id_bidang,
                t_persetujuan_magang.disposisi,
                t_persetujuan_magang.catatan as catatan_sekretariat,
                m_bidang.bidang,
                t_penempatan_magang.catatan,
                t_penempatan_magang.status_penempatan,
                t_penempatan_magang.is_log_book,
                m_mahasiswa.nim
            ') 
            ->join('m_mahasiswa', 'm_mahasiswa.id_mahasiswa = t_permohonan_magang.id_mahasiswa') 
            ->join('t_persetujuan_magang', 't_persetujuan_magang.id_permohonan_magang = t_permohonan_magang.id_permohonan_magang', 'left')
            ->join('m_bidang', 'm_bidang.id_bidang = t_persetujuan_magang.id_bidang', 'left')
            ->join('t_penempatan_magang', 't_penempatan_magang.id_persetujuan_magang = t_persetujuan_magang.id_persetujuan_magang', 'left')
            ->where('t_permohonan_magang.id_mahasiswa', $id_mahasiswa)
            ->groupBy('t_permohonan_magang.id_permohonan_magang')
            ->orderBy('t_permohonan_magang.created_at', 'DESC');
            // Hapus filter 'kirim' agar Mahasiswa juga bisa melihat permohonan berstatus 'draft'

        if (!empty($filterStatus)) {
            $builder->where('t_persetujuan_magang.status_persetujuan', $filterStatus);
        }

        return $builder;
    }
    /**
     * Tambahan untuk Sekretariat: Mengambil antrean berkas yang belum diverifikasi
     */
    /**
     * Tambahan untuk Sekretariat: Mengambil antrean berkas yang belum/sedang diverifikasi
     */
    public function getAntreanSekretariat()
    {
        return $this->select('t_permohonan_magang.*, t_persetujuan_magang.status_persetujuan, t_persetujuan_magang.catatan, m_mahasiswa.nama_mahasiswa, m_prodi.prodi')
            ->join('t_persetujuan_magang', 't_persetujuan_magang.id_permohonan_magang = t_permohonan_magang.id_permohonan_magang', 'left')
            ->join('m_mahasiswa', 'm_mahasiswa.id_mahasiswa = t_permohonan_magang.id_mahasiswa', 'left')
            ->join('t_instansi_mahasiswa', 't_instansi_mahasiswa.id_mahasiswa = m_mahasiswa.id_mahasiswa', 'left')
            ->join('m_prodi', 'm_prodi.id_prodi = t_instansi_mahasiswa.id_prodi', 'left')
            ->where('t_permohonan_magang.posting_data', 'kirim')
            ->where('t_persetujuan_magang.status_persetujuan IS NULL')
            ->orderBy('t_permohonan_magang.created_at', 'DESC')
            ->findAll();
    }

    /**
     * Mengambil detail lengkap satu permohonan beserta profil mahasiswa
     */
    public function getDetailPermohonan($id_permohonan)
    {
        return $this->select('t_permohonan_magang.*, m_mahasiswa.nama_mahasiswa, m_mahasiswa.nim, m_instansi_pendidikan.instansi_pendidikan as kampus, m_fakultas.fakultas, m_prodi.prodi, t_instansi_mahasiswa.jenjang_pendidikan, t_instansi_mahasiswa.semester')
            ->join('m_mahasiswa', 'm_mahasiswa.id_mahasiswa = t_permohonan_magang.id_mahasiswa', 'left')
            ->join('t_instansi_mahasiswa', 't_instansi_mahasiswa.id_mahasiswa = m_mahasiswa.id_mahasiswa', 'left')
            ->join('m_instansi_pendidikan', 'm_instansi_pendidikan.id_instansi_pendidikan = t_instansi_mahasiswa.id_instansi_pendidikan', 'left')
            ->join('m_fakultas', 'm_fakultas.id_fakultas = t_instansi_mahasiswa.id_fakultas', 'left')
            ->join('m_prodi', 'm_prodi.id_prodi = t_instansi_mahasiswa.id_prodi', 'left')
            ->where('t_permohonan_magang.id_permohonan_magang', $id_permohonan)
            ->first();
    }

    /**
     * Tambahan untuk Sekretariat: Mengambil riwayat berkas yang sudah diproses
     */
    public function getArsipSekretariat()
    {
        return $this->db->table($this->table)
            ->select('
                t_permohonan_magang.id_permohonan_magang,
                t_permohonan_magang.id_jenis_permohonan,
                t_permohonan_magang.created_at,
                t_permohonan_magang.id_mahasiswa,
                t_persetujuan_magang.status_persetujuan,
                t_persetujuan_magang.catatan,
                t_persetujuan_magang.tgl_persetujuan,
                t_persetujuan_magang.disposisi,
                m_mahasiswa.nama_mahasiswa,
                m_prodi.prodi,
                m_instansi_pendidikan.instansi_pendidikan as universitas
            ')
            ->join('t_persetujuan_magang', 't_persetujuan_magang.id_permohonan_magang = t_permohonan_magang.id_permohonan_magang')
            ->join('m_mahasiswa', 'm_mahasiswa.id_mahasiswa = t_permohonan_magang.id_mahasiswa', 'left')
            ->join('t_instansi_mahasiswa', 't_instansi_mahasiswa.id_mahasiswa = m_mahasiswa.id_mahasiswa', 'left')
            ->join('m_prodi', 'm_prodi.id_prodi = t_instansi_mahasiswa.id_prodi', 'left')
            ->join('m_instansi_pendidikan', 'm_instansi_pendidikan.id_instansi_pendidikan = t_instansi_mahasiswa.id_instansi_pendidikan', 'left')
            // KUNCI FIX: Arsip menampilkan yang sudah diteruskan ke kabid (1), selesai diplot kabid (2), ATAU yang sah DITOLAK
            ->where("(t_persetujuan_magang.disposisi IN ('1', '2') OR t_persetujuan_magang.status_persetujuan = 'DITOLAK')")
            ->orderBy('t_persetujuan_magang.tgl_persetujuan', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Tambahan untuk Sekretariat: Mengambil antrean berkas yang sudah VALID dan menunggu penempatan bidang
     */
    public function getAntreanDisposisi()
    {
        return $this->select('t_permohonan_magang.*, t_persetujuan_magang.status_persetujuan, m_mahasiswa.nama_mahasiswa, m_prodi.prodi')
            ->join('t_persetujuan_magang', 't_persetujuan_magang.id_permohonan_magang = t_permohonan_magang.id_permohonan_magang')
            ->join('m_mahasiswa', 'm_mahasiswa.id_mahasiswa = t_permohonan_magang.id_mahasiswa', 'left')
            ->join('t_instansi_mahasiswa', 't_instansi_mahasiswa.id_mahasiswa = m_mahasiswa.id_mahasiswa', 'left')
            ->join('m_prodi', 'm_prodi.id_prodi = t_instansi_mahasiswa.id_prodi', 'left')
            ->where('t_permohonan_magang.posting_data', 'kirim')
            ->where('t_persetujuan_magang.status_persetujuan', 'MENUNGGU')
            ->where('t_persetujuan_magang.disposisi', '0')
            ->orderBy('t_permohonan_magang.created_at', 'ASC')
            ->findAll();
    }

/**
     * Kueri khusus untuk mengambil antrean data mahasiswa yang siap di-plot oleh Kabid
     * (Hanya mengambil data dengan status MENUNGGU dan disposisi = 1)
     */
    public function getAntreanKabid($id_bidang = null)
    {
        $builder = $this->db->table($this->table)
            ->select('
                t_permohonan_magang.id_permohonan_magang,
                t_permohonan_magang.id_jenis_permohonan,
                t_permohonan_magang.deskripsi_keahlian,
                t_permohonan_magang.tgl_mulai,
                t_permohonan_magang.tgl_selesai,
                t_permohonan_magang.created_at,
                t_permohonan_magang.id_mahasiswa,
                t_persetujuan_magang.id_persetujuan_magang,
                t_persetujuan_magang.status_persetujuan,
                t_persetujuan_magang.disposisi,
                t_persetujuan_magang.catatan,
                m_mahasiswa.nama_mahasiswa,
                m_mahasiswa.nim,
                m_instansi_pendidikan.instansi_pendidikan
            ')
            ->join('m_mahasiswa', 'm_mahasiswa.id_mahasiswa = t_permohonan_magang.id_mahasiswa')
            ->join('t_instansi_mahasiswa', 't_instansi_mahasiswa.id_mahasiswa = m_mahasiswa.id_mahasiswa', 'left')
            ->join('m_instansi_pendidikan', 'm_instansi_pendidikan.id_instansi_pendidikan = t_instansi_mahasiswa.id_instansi_pendidikan', 'left')
            ->join('t_persetujuan_magang', 't_persetujuan_magang.id_permohonan_magang = t_permohonan_magang.id_permohonan_magang')
            ->where('t_persetujuan_magang.disposisi', '1'); // Menangkap operan dari sekretariat (mengabaikan status_persetujuan demi kompatibilitas data lama)
            
        if ($id_bidang) {
            $builder->where('t_persetujuan_magang.id_bidang', $id_bidang);
        }

        return $builder->orderBy('t_permohonan_magang.created_at', 'ASC')->get()->getResultArray();
    }

}
