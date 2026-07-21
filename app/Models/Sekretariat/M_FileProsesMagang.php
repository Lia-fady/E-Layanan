<?php
namespace App\Models\Sekretariat;

use CodeIgniter\Model;

class M_FileProsesMagang extends Model
{
    protected $table            = 't_file_proses_magang';
    protected $primaryKey       = 'id_file_selesai_magang';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    
    protected $allowedFields    = [
        'id_persetujuan_magang',
        'id_file',
        'nama_file',
        'path_file',
        'proses_magang',
        'created_by',
        'updated_by'
    ];

    /**
     * Get surat penerimaan by id_persetujuan_magang
     */
    public function getSuratByPersetujuan($id_persetujuan)
    {
        return $this->select('t_file_proses_magang.*, m_file.nama_file as nama_file_master, c_user_pegawai.nama as pengunggah')
                    ->join('m_file', 'm_file.id_file = t_file_proses_magang.id_file', 'left')
                    ->join('c_user_pegawai', 'c_user_pegawai.id_user_pegawai = t_file_proses_magang.created_by', 'left')
                    ->where('t_file_proses_magang.id_persetujuan_magang', $id_persetujuan)
                    ->where('t_file_proses_magang.proses_magang', 'SURAT_PENERIMAAN_MAGANG')
                    ->findAll();
    }
    
    /**
     * Check if surat already exists
     */
    public function getExistingSurat($id_persetujuan)
    {
        return $this->where('id_persetujuan_magang', $id_persetujuan)
                    ->where('proses_magang', 'SURAT_PENERIMAAN_MAGANG')
                    ->first();
    }
}
