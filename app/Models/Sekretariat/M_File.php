<?php
namespace App\Models\Sekretariat;

use CodeIgniter\Model;

class M_File extends Model
{
    protected $table            = 'm_file';
    protected $primaryKey       = 'id_file';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $allowedFields    = ['nama_file', 'kode_file', 'ekstensi', 'ukuran_maksimal', 'wajib_upload', 'status', 'created_at', 'updated_at', 'deleted_at'];
    protected $useSoftDeletes   = true;

    /**
     * Get active files
     */
    public function getActiveFiles()
    {
        return $this->where('status', 'AKTIF')->findAll();
    }
}
