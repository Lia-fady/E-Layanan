<?php
namespace App\Models\Kabid;

use CodeIgniter\Model;

class M_LogbookKabid extends Model
{
    protected $table = 't_logbook_magang';
    protected $primaryKey = 'id_logbook_magang';
    protected $allowedFields = ['id_penempatan_magang', 'logbook_magang', 'tgl_logbook', 'status_logbook', 'created_at', 'disetujui_oleh', 'file_tanda_tangan', 'tgl_disetujui'];
    protected $useTimestamps = false;

    public function getActiveMahasiswa($id_bidang, $search = null, $jenis_permohonan = null, $status_filter = null)
    {
        $builder = $this->db->table('t_penempatan_magang p')
            ->select('p.id_penempatan_magang, p.status_penempatan, m.nama_mahasiswa, m.nim, ip.instansi_pendidikan, pr.nama_prodi as prodi, pm.tgl_mulai, pm.tgl_selesai, jp.jenis_permohonan')
            ->join('t_persetujuan_magang ps', 'ps.id_persetujuan_magang = p.id_persetujuan_magang')
            ->join('t_permohonan_magang pm', 'pm.id_permohonan_magang = ps.id_permohonan_magang')
            ->join('m_mahasiswa m', 'm.id_mahasiswa = pm.id_mahasiswa')
            ->join('t_instansi_mahasiswa im', 'im.id_instansi_mahasiswa = pm.id_instansi_mahasiswa')
            ->join('m_instansi_pendidikan ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan')
            ->join('m_prodi pr', 'pr.id_prodi = im.id_prodi')
            ->join('m_jenis_permohonan jp', 'jp.id_jenis_permohonan = pm.id_jenis_permohonan', 'left')
            ->where('p.id_bidang', $id_bidang)
            ->whereIn('p.status_penempatan', ['BERJALAN', 'SELESAI', 'DIBATALKAN']);

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('m.nama_mahasiswa', $search)
                    ->orLike('m.nim', $search)
                    ->groupEnd();
        }

        if (!empty($jenis_permohonan)) {
            $builder->where('pm.id_jenis_permohonan', $jenis_permohonan);
        }

        if (!empty($status_filter)) {
            if (is_array($status_filter)) {
                $builder->whereIn('p.status_penempatan', $status_filter);
            } elseif (in_array($status_filter, ['BERJALAN', 'SELESAI'])) {
                $builder->where('p.status_penempatan', $status_filter);
            }
        }

        return $builder->orderBy('p.status_penempatan', 'ASC')
                        ->orderBy('pm.tgl_mulai', 'DESC')
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
            ->select('p.id_penempatan_magang, m.nama_mahasiswa, m.nim, m.jenis_kelamin, m.no_telp, m.email, ip.instansi_pendidikan, pr.nama_prodi as prodi, pm.tgl_mulai, pm.tgl_selesai')
            ->join('t_persetujuan_magang ps', 'ps.id_persetujuan_magang = p.id_persetujuan_magang')
            ->join('t_permohonan_magang pm', 'pm.id_permohonan_magang = ps.id_permohonan_magang')
            ->join('m_mahasiswa m', 'm.id_mahasiswa = pm.id_mahasiswa')
            ->join('t_instansi_mahasiswa im', 'im.id_instansi_mahasiswa = pm.id_instansi_mahasiswa')
            ->join('m_instansi_pendidikan ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan')
            ->join('m_prodi pr', 'pr.id_prodi = im.id_prodi')
            ->where('p.id_penempatan_magang', $id_penempatan)
            ->get()->getRow();
    }

    public function getDetailPenempatan($id_penempatan)
    {
        return $this->db->table('t_penempatan_magang p')
            ->select('p.id_penempatan_magang, p.status_penempatan, ps.id_persetujuan_magang, pm.id_permohonan_magang, m.nama_mahasiswa, m.nim, ip.instansi_pendidikan, pr.nama_prodi as prodi, jp.jenis_permohonan, pm.tgl_mulai, pm.tgl_selesai')
            ->join('t_persetujuan_magang ps', 'ps.id_persetujuan_magang = p.id_persetujuan_magang')
            ->join('t_permohonan_magang pm', 'pm.id_permohonan_magang = ps.id_permohonan_magang')
            ->join('m_mahasiswa m', 'm.id_mahasiswa = pm.id_mahasiswa')
            ->join('t_instansi_mahasiswa im', 'im.id_instansi_mahasiswa = pm.id_instansi_mahasiswa')
            ->join('m_instansi_pendidikan ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan')
            ->join('m_prodi pr', 'pr.id_prodi = im.id_prodi')
            ->join('m_jenis_permohonan jp', 'jp.id_jenis_permohonan = pm.id_jenis_permohonan', 'left')
            ->where('p.id_penempatan_magang', $id_penempatan)
            ->get()->getRow();
    }

    public function bulkApproveSelected($id_penempatan, $selectedIds, $dataUpdate)
    {
        return $this->db->table($this->table)
            ->where('id_penempatan_magang', $id_penempatan)
            ->where('disetujui_oleh IS NULL', null, false)
            ->whereIn('id_logbook_magang', $selectedIds)
            ->update($dataUpdate);
    }
}
