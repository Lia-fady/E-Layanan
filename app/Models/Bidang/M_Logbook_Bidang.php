<?php
namespace App\Models\Bidang;

use CodeIgniter\Model;

class M_Logbook_Bidang extends Model
{
    protected $table = 't_logbook_magang';
    protected $primaryKey = 'id_logbook_magang';
    protected $allowedFields = ['id_penempatan_magang', 'logbook_magang', 'tgl_logbook', 'created_at', 'updated_by', 'disetujui_oleh', 'file_tanda_tangan', 'tgl_disetujui'];
    protected $useTimestamps = true;

    public function getActiveMahasiswa($id_bidang)
    {
        return $this->db->table('t_penempatan_magang p')
            ->select('p.id_penempatan_magang, m.nama_mahasiswa, m.nim, ip.instansi_pendidikan, pr.prodi, pm.tgl_mulai, pm.tgl_selesai')
            ->join('t_persetujuan_magang ps', 'ps.id_persetujuan_magang = p.id_persetujuan_magang')
            ->join('t_permohonan_magang pm', 'pm.id_permohonan_magang = ps.id_permohonan_magang')
            ->join('M_Mahasiswa_Mahasiswa m', 'm.id_mahasiswa = pm.id_mahasiswa')
            ->join('t_instansi_mahasiswa im', 'im.id_instansi_mahasiswa = pm.id_instansi_mahasiswa')
            ->join('m_instansi_pendidikan ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan')
            ->join('m_prodi pr', 'pr.id_prodi = im.id_prodi')
            ->where('p.id_bidang', $id_bidang)
            ->where('p.status_penempatan', 'BERJALAN')
            ->get()->getResult();
    }

    public function getLogbooks($id_penempatan)
    {
        return $this->where('id_penempatan_magang', $id_penempatan)
                    ->orderBy('tgl_logbook', 'ASC')
                    ->findAll();
    }

    public function getMahasiswaInfo($id_penempatan)
    {
        return $this->db->table('t_penempatan_magang p')
            ->select('p.id_penempatan_magang, m.nama_mahasiswa, m.nim, m.jenis_kelamin, m.no_telp, m.email, ip.instansi_pendidikan, pr.prodi, pm.tgl_mulai, pm.tgl_selesai')
            ->join('t_persetujuan_magang ps', 'ps.id_persetujuan_magang = p.id_persetujuan_magang')
            ->join('t_permohonan_magang pm', 'pm.id_permohonan_magang = ps.id_permohonan_magang')
            ->join('M_Mahasiswa_Mahasiswa m', 'm.id_mahasiswa = pm.id_mahasiswa')
            ->join('t_instansi_mahasiswa im', 'im.id_instansi_mahasiswa = pm.id_instansi_mahasiswa')
            ->join('m_instansi_pendidikan ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan')
            ->join('m_prodi pr', 'pr.id_prodi = im.id_prodi')
            ->where('p.id_penempatan_magang', $id_penempatan)
            ->get()->getRow();
    }

    public function bulkApprovePending($id_penempatan, $dataUpdate)
    {
        return $this->db->table($this->table)
            ->where('id_penempatan_magang', $id_penempatan)
            ->where('disetujui_oleh IS NULL', null, false)
            ->update($dataUpdate);
    }
}
