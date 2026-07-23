<?php
namespace App\Models\Sekretariat;

use CodeIgniter\Model;

class M_File extends Model
{
    protected $table            = 'm_file';
    protected $primaryKey       = 'id_file';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useTimestamps    = false;
    protected $allowedFields    = [
        'nama_file',
        'status_aktif',
        'id_jenis_permohonan'
    ];

    /**
     * Get active files
     */
    public function getActiveFiles()
    {
        return $this->where('status_aktif', '1')->findAll();
    }
}
