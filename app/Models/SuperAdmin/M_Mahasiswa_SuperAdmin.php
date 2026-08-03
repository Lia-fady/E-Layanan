<?php

namespace App\Models\SuperAdmin;

use CodeIgniter\Model;

class M_Mahasiswa_SuperAdmin extends Model
{
    protected $table            = 'M_Mahasiswa_Mahasiswa';
    protected $primaryKey       = 'id_mahasiswa';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_mahasiswa', 'nik', 'nim', 'nama_mahasiswa', 'jenis_kelamin', 'tgl_lahir', 'alamat', 'rt', 'rw', 'kelurahan', 'kecamatan', 'provinsi', 'no_telp', 'id_instansi_mahasiswa', 'email'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getAllWithRelations()
    {
        return $this->db->table($this->table)
            ->select('M_Mahasiswa_Mahasiswa.*, m_prodi.prodi as nama_prodi, m_instansi_pendidikan.instansi_pendidikan')
            ->join('t_instansi_mahasiswa', 't_instansi_mahasiswa.id_instansi_mahasiswa = M_Mahasiswa_Mahasiswa.id_instansi_mahasiswa', 'left')
            ->join('m_prodi', 'm_prodi.id_prodi = t_instansi_mahasiswa.id_prodi', 'left')
            ->join('m_instansi_pendidikan', 'm_instansi_pendidikan.id_instansi_pendidikan = t_instansi_mahasiswa.id_instansi_pendidikan', 'left')
            ->orderBy('m_instansi_pendidikan.instansi_pendidikan', 'ASC')
            ->orderBy('M_Mahasiswa_Mahasiswa.nama_mahasiswa', 'ASC')
            ->get()->getResultArray();
    }
}
