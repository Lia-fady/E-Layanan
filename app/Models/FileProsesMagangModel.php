<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;

/**
 * Model untuk tabel t_file_proses_magang
 * 
 * Mengelola file sertifikat magang yang diupload oleh user.
 * Satu id_persetujuan_magang hanya boleh memiliki satu data
 * dengan proses_magang = 'selesai'.
 */
class FileProsesMagangModel extends Model
{
    protected $table            = 't_file_proses_magang';
    protected $primaryKey       = 'id_file_selesai_magang';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $useTimestamps    = false; // Kita handle manual

    protected $allowedFields = [
        'id_persetujuan_magang',
        'id_file',
        'jenis_dokumen',
        'catatan',
        'nama_file',
        'path_file',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'proses_magang',
    ];

    /**
     * Ambil data sertifikat (proses_magang = 'selesai') berdasarkan id_persetujuan_magang
     *
     * @param int $idPersetujuan
     * @return array|null
     */
    public function getSertifikatByPersetujuan(int $idPersetujuan): ?array
    {
        return $this->where('id_persetujuan_magang', $idPersetujuan)
                    ->where('proses_magang', 'selesai')
                    ->first();
    }

    /**
     * Simpan sertifikat baru atau update jika sudah ada
     * 
     * Jika sudah ada data dengan id_persetujuan_magang & proses_magang = 'selesai',
     * maka lakukan UPDATE. Jika belum ada, lakukan INSERT.
     *
     * @param array $data
     * @return bool
     */
    public function simpanSertifikat(array $data): bool
    {
        $existing = $this->getSertifikatByPersetujuan($data['id_persetujuan_magang']);

        if ($existing) {
            // UPDATE — hanya update file & timestamp
            return $this->update($existing['id_file_selesai_magang'], [
                'nama_file'  => $data['nama_file'],
                'path_file'  => $data['path_file'],
                'updated_at' => $data['updated_at'],
                'updated_by' => $data['updated_by'],
            ]);
        }

        // INSERT
        return (bool) $this->insert($data);
    }

    /**
     * Ambil informasi permohonan berdasarkan id_persetujuan_magang
     * dengan join ke tabel persetujuan → permohonan → mahasiswa
     *
     * @param int $idPersetujuan
     * @return array
     */
    public function getInfoPermohonan($idPersetujuan)
    {
        $db = \Config\Database::connect();

        $persetujuanTable    = $this->resolveTable(['t_persetujuan_magang']);
        $permohonanTable     = $this->resolveTable(['t_permohonan_magang']);
        $mahasiswaTable      = $this->resolveTable(['m_mahasiswa', 'mahasiswa']);
        $bidangTable         = $this->resolveTable(['m_bidang', 'bidang']);
        $jenisPermohonanTable = $this->resolveTable(['m_jenis_permohonan', 'jenis_permohonan']);
        $filePermohonanTable = $this->resolveTable(['t_file_permohonan_magang']);

        if (! $persetujuanTable) {
            return [];
        }

        $builder = $db->table("{$persetujuanTable} per");
        $select  = ['per.*'];

        if ($permohonanTable) {
            $builder->join("{$permohonanTable} pm", 'per.id_permohonan_magang = pm.id_permohonan_magang', 'left');
            $select[] = 'pm.deskripsi_magang';
            $select[] = 'pm.tgl_mulai';
            $select[] = 'pm.tgl_selesai';
        }

        if ($filePermohonanTable && $permohonanTable) {
            $builder->join("{$filePermohonanTable} fpm", 'pm.id_permohonan_magang = fpm.id_permohonan_magang', 'left');
            $select[] = 'fpm.id_file_permohonan';
        }

        if ($permohonanTable && $mahasiswaTable) {
            $builder->join("{$mahasiswaTable} m", 'pm.id_mahasiswa = m.id_mahasiswa', 'left');
            $builder->join("t_instansi_mahasiswa tm", 'm.id_instansi_mahasiswa = tm.id_instansi_mahasiswa', 'left');
            $builder->join("m_instansi_pendidikan inst", 'tm.id_instansi_pendidikan = inst.id_instansi_pendidikan', 'left');
            $builder->join("m_prodi pr", 'tm.id_prodi = pr.id_prodi', 'left');
            
            $select[] = 'm.nama_mahasiswa';
            $select[] = 'm.nim';
            $select[] = 'inst.instansi_pendidikan as universitas';
            $select[] = 'pr.prodi as prodi';
        }

        if ($bidangTable) {
            $builder->join("{$bidangTable} b", 'per.id_bidang = b.id_bidang', 'left');
            $select[] = 'b.bidang as nama_bidang';
        }

        if ($permohonanTable && $jenisPermohonanTable) {
            $builder->join("{$jenisPermohonanTable} jp", 'pm.id_jenis_permohonan = jp.id_jenis_permohonan', 'left');
            $select[] = 'jp.jenis_permohonan';
        }

        $builder->select(implode(', ', $select));
        $builder->where('per.id_persetujuan_magang', $idPersetujuan);

        return $builder->get()->getRowArray() ?? [];
    }

    public function getListMahasiswa()
    {
        $db = \Config\Database::connect();
        
        $persetujuanTable = $this->resolveTable(['t_persetujuan_magang']);
        $permohonanTable  = $this->resolveTable(['t_permohonan_magang']);
        $mahasiswaTable   = $this->resolveTable(['m_mahasiswa', 'mahasiswa']);

        if (!$persetujuanTable || !$permohonanTable || !$mahasiswaTable) {
            return [];
        }

        $builder = $db->table("{$persetujuanTable} per")
            ->select('per.id_persetujuan_magang, m.nama_mahasiswa, m.nim, inst.instansi_pendidikan as universitas, pr.prodi as prodi, pm.tgl_mulai, pm.tgl_selesai')
            ->join("{$permohonanTable} pm", 'per.id_permohonan_magang = pm.id_permohonan_magang', 'left')
            ->join("{$mahasiswaTable} m", 'pm.id_mahasiswa = m.id_mahasiswa', 'left')
            ->join("t_instansi_mahasiswa tm", 'm.id_instansi_mahasiswa = tm.id_instansi_mahasiswa', 'left')
            ->join("m_instansi_pendidikan inst", 'tm.id_instansi_pendidikan = inst.id_instansi_pendidikan', 'left')
            ->join("m_prodi pr", 'tm.id_prodi = pr.id_prodi', 'left');
            
        return $builder->get()->getResultArray();
    }

    /**
     * Resolve table name dari beberapa kandidat nama tabel
     *
     * @param array $candidates
     * @return string|null
     */
    protected function resolveTable(array $candidates): ?string
    {
        $db = Database::connect();
        foreach ($candidates as $table) {
            if ($db->tableExists($table)) {
                return $table;
            }
        }

        return null;
    }
}
