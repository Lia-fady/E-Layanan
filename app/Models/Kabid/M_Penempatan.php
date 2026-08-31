<?php
/**
 * ============================================================
 * Kode      : M_Penempatan.php
 * Path      : Models/Kabid/M_Penempatan.php
 * Deskripsi : Model untuk modul Persetujuan Penempatan Kepala Bidang.
 *             Mengelola data penempatan magang yang menunggu
 *             persetujuan Kepala Bidang, termasuk setujui dan tolak.
 * ============================================================
 */

namespace App\Models\Kabid;

use CodeIgniter\Model;

class M_Penempatan extends Model
{
    protected $table            = 't_penempatan_magang';
    protected $primaryKey       = 'id_penempatan_magang';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = [
        'id_bidang',
        'id_persetujuan_magang',
        'id_mahasiswa',
        'catatan',
        'status_penempatan',
        'tgl_penetapan_magang',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Ambil daftar penempatan untuk bidang tertentu.
     *
     * @param int|null $id_bidang  Jika null, tampilkan semua
     * @param string|null $status_penempatan  Jika diset, filter berdasarkan status tertentu
     * @return array
     */
    public function getSemuaPenempatan($id_bidang = null, $status_penempatan = null)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('t_penempatan_magang as pn');
        $builder->select('
            pn.id_penempatan_magang,
            pn.id_bidang,
            pn.id_persetujuan_magang,
            pm.id_permohonan_magang,
            pn.id_mahasiswa,
            pn.catatan,
            pn.status_penempatan,
            pn.is_log_book,
            pn.created_at,
            mhs.nim,
            mhs.nik,
            mhs.nama_mahasiswa,
            mhs.jenis_kelamin,
            mhs.email,
            mhs.no_telp,
            mhs.tgl_lahir,
            im.semester,
            im.angkatan_tahun,
            im.id_jenjang_pendidikan,
            kls.nama_kelas as kelas,
            jur.nama_jurusan as jurusan,
            jnj.nama_jenjang as jenjang_pendidikan,
            pm.id_jenis_permohonan,
            bd.bidang,
            pm.deskripsi_keahlian,
            pm.tgl_mulai,
            pm.tgl_selesai,
            pm.tgl_mulai as tgl_mulai_pengajuan,
            pm.tgl_selesai as tgl_selesai_pengajuan,
            pn.tanggal_mulai as tgl_mulai_pelaksanaan,
            pn.tanggal_selesai as tgl_selesai_pelaksanaan,
            pm.created_at as tgl_pengajuan,
            jp.jenis_permohonan,
            ip.instansi_pendidikan,
            pr.nama_prodi as prodi,
            ps.catatan as catatan_sekretariat
        ');
        $builder->join('m_mahasiswa as mhs', 'mhs.id_mahasiswa = pn.id_mahasiswa', 'left');
        $builder->join('m_bidang as bd', 'bd.id_bidang = pn.id_bidang', 'left');
        $builder->join('t_persetujuan_magang as ps', 'ps.id_persetujuan_magang = pn.id_persetujuan_magang', 'left');
        $builder->join('t_permohonan_magang as pm', 'pm.id_permohonan_magang = ps.id_permohonan_magang', 'left');
        $builder->join('m_jenis_permohonan as jp', 'jp.id_jenis_permohonan = pm.id_jenis_permohonan', 'left');
        $builder->join('t_instansi_mahasiswa as im', 'im.id_instansi_mahasiswa = pm.id_instansi_mahasiswa', 'left');
        $builder->join('m_instansi_pendidikan as ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan', 'left');
        $builder->join('m_prodi as pr', 'pr.id_prodi = im.id_prodi', 'left');
        $builder->join('m_jurusan as jur', 'jur.id_jurusan = im.id_jurusan', 'left');
        $builder->join('m_kelas as kls', 'kls.id_kelas = im.id_kelas', 'left');
        $builder->join('m_jenjang_pendidikan as jnj', 'jnj.id_jenjang_pendidikan = im.id_jenjang_pendidikan', 'left');
        if ($id_bidang !== null) {
            $builder->where('pn.id_bidang', $id_bidang);
        }

        if ($status_penempatan !== null) {
            if (is_array($status_penempatan)) {
                $builder->whereIn('pn.status_penempatan', $status_penempatan);
            } else {
                $builder->where('pn.status_penempatan', $status_penempatan);
            }
        }

        $builder->orderBy('pn.created_at', 'ASC');

        return $builder->get()->getResult();
    }

    /**
     * Ambil detail penempatan berdasarkan ID.
     *
     * @param int $id_penempatan
     * @return object|null
     */
    public function getDetailPenempatan($id_penempatan)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('t_penempatan_magang as pn');
        $builder->select('
            pn.*,
            mhs.nim,
            mhs.nik,
            mhs.nama_mahasiswa,
            mhs.jenis_kelamin,
            mhs.email,
            mhs.no_telp,
            mhs.tgl_lahir,
            mhs.alamat,
            mhs.rt,
            mhs.rw,
            kel.nama_kelurahan as kelurahan,
            kec.nama_kecamatan as kecamatan,
            kab.nama_kabupaten as kabupaten,
            prov.nama_provinsi as provinsi,
            im.semester,
            im.angkatan_tahun,
            im.id_jenjang_pendidikan,
            im.jurusan as jurusan_siswa,
            kls.nama_kelas as kelas,
            jur.nama_jurusan as jurusan,
            jnj.nama_jenjang as jenjang_pendidikan,
            pm.id_jenis_permohonan,
            pr.nama_prodi as prodi,
            bd.bidang,
            pm.id_permohonan_magang,
            pm.deskripsi_keahlian,
            pm.rencana_kegiatan,
            pm.tgl_mulai,
            pm.tgl_selesai,
            pm.tgl_mulai as tgl_mulai_pengajuan,
            pm.tgl_selesai as tgl_selesai_pengajuan,
            pn.tanggal_mulai as tgl_mulai_pelaksanaan,
            pn.tanggal_selesai as tgl_selesai_pelaksanaan,
            pm.created_at as tgl_pengajuan,
            jp.jenis_permohonan,
            jp.durasi_minimal,
            ip.instansi_pendidikan,
            ps.catatan as catatan_sekretariat,
            ps.tanggal_persetujuan
        ');
        $builder->join('m_mahasiswa as mhs', 'mhs.id_mahasiswa = pn.id_mahasiswa', 'left');
        $builder->join('m_bidang as bd', 'bd.id_bidang = pn.id_bidang', 'left');
        $builder->join('t_persetujuan_magang as ps', 'ps.id_persetujuan_magang = pn.id_persetujuan_magang', 'left');
        $builder->join('t_permohonan_magang as pm', 'pm.id_permohonan_magang = ps.id_permohonan_magang', 'left');
        $builder->join('m_jenis_permohonan as jp', 'jp.id_jenis_permohonan = pm.id_jenis_permohonan', 'left');
        $builder->join('t_instansi_mahasiswa as im', 'im.id_instansi_mahasiswa = pm.id_instansi_mahasiswa', 'left');
        $builder->join('m_instansi_pendidikan as ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan', 'left');
        $builder->join('m_prodi as pr', 'pr.id_prodi = im.id_prodi', 'left');
        $builder->join('m_jurusan as jur', 'jur.id_jurusan = im.id_jurusan', 'left');
        $builder->join('m_kelas as kls', 'kls.id_kelas = im.id_kelas', 'left');
        $builder->join('m_jenjang_pendidikan as jnj', 'jnj.id_jenjang_pendidikan = im.id_jenjang_pendidikan', 'left');
        $builder->join('m_kelurahan as kel', 'kel.id_kelurahan = mhs.id_kelurahan', 'left');
        $builder->join('m_kecamatan as kec', 'kec.id_kecamatan = kel.id_kecamatan', 'left');
        $builder->join('m_kabupaten as kab', 'kab.id_kabupaten = kec.id_kabupaten', 'left');
        $builder->join('m_provinsi as prov', 'prov.id_provinsi = kab.id_provinsi', 'left');
        $builder->where('pn.id_penempatan_magang', $id_penempatan);

        return $builder->get()->getRow();
    }

    /**
     * Setujui penempatan: update status ke DISETUJUI dan set is_log_book.
     * Status akan otomatis berubah ke BERJALAN saat tanggal mulai tiba (lazy check).
     *
     * @param int $id_persetujuan_magang
     * @param string $tgl_mulai_disetujui
     * @param string $tgl_selesai_disetujui
     * @param string $is_log_book
     * @param string $catatan
     * @param int $updated_by
     * @return bool
     */
    public function setujuiPenempatan($id_penempatan, $id_persetujuan_magang, $tgl_mulai_disetujui, $tgl_selesai_disetujui, $is_log_book, $catatan, $updated_by)
    {
        $db = \Config\Database::connect();

        $db->transStart();

        $db->table('t_penempatan_magang')
            ->where('id_penempatan_magang', $id_penempatan)
            ->update([
                // Penempatan tetap DISETUJUI sampai tanggal mulai tiba
                'status_penempatan'  => 'DISETUJUI',
                'tanggal_mulai'      => $tgl_mulai_disetujui,
                'tanggal_selesai'    => $tgl_selesai_disetujui,
                'is_log_book'        => $is_log_book,
                'catatan'            => $catatan,
                'tanggal_persetujuan'=> date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ]);

        $persetujuan = $db->table('t_persetujuan_magang')->where('id_persetujuan_magang', $id_persetujuan_magang)->get()->getRow();
        $permohonan = $db->table('t_permohonan_magang')->where('id_permohonan_magang', $persetujuan->id_permohonan_magang)->get()->getRow();
        
        $status_mahasiswa = 'MENUNGGU';
        if ($tgl_mulai_disetujui == $permohonan->tgl_mulai && $tgl_selesai_disetujui == $permohonan->tgl_selesai) {
            $status_mahasiswa = 'DISETUJUI';
        }

        $db->table('t_persetujuan_magang')
            ->where('id_persetujuan_magang', $id_persetujuan_magang)
            ->update([
                'tgl_mulai_disetujui' => $tgl_mulai_disetujui,
                'tgl_selesai_disetujui' => $tgl_selesai_disetujui,
                'status_persetujuan_mahasiswa' => $status_mahasiswa,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        $db->transComplete();

        return $db->transStatus();
    }

    /**
     * Tolak penempatan oleh Kabid (saat status MENUNGGU).
     * Ubah status menjadi DITOLAK dan kembalikan ke Sekretariat untuk disposisi ulang.
     *
     * @param int    $id_penempatan
     * @param string $catatan
     * @param int    $updated_by
     * @return bool
     */
    public function tolakPenempatan($id_penempatan, $catatan, $updated_by)
    {
        $db = \Config\Database::connect();

        // Ambil data penempatan untuk mendapatkan id_persetujuan_magang
        $penempatan = $db->table('t_penempatan_magang')
            ->where('id_penempatan_magang', $id_penempatan)
            ->get()->getRow();

        if (!$penempatan) {
            return false;
        }

        // Update status di t_penempatan_magang menjadi DITOLAK
        $db->table('t_penempatan_magang')
            ->where('id_penempatan_magang', $id_penempatan)
            ->update([
                'status_penempatan' => 'DITOLAK',
                'catatan'           => $catatan,
                'updated_at'        => date('Y-m-d H:i:s'),
            ]);

        // Kembalikan status persetujuan ke MENUNGGU agar bisa didisposisi ulang ke bidang lain
        $db->table('t_persetujuan_magang')
            ->where('id_persetujuan_magang', $penempatan->id_persetujuan_magang)
            ->update([
                'status_persetujuan' => 'MENUNGGU',
                'updated_at'         => date('Y-m-d H:i:s'),
            ]);

        return true;
    }

    /**
     * Batalkan penempatan (saat status DISETUJUI atau BERJALAN).
     * Ini adalah status final — mahasiswa mengundurkan diri.
     * TIDAK mengembalikan ke Sekretariat untuk disposisi ulang.
     *
     * @param int    $id_penempatan
     * @param string $catatan
     * @param int    $updated_by
     * @return bool
     */
    public function batalkanPenempatan($id_penempatan, $catatan, $updated_by)
    {
        $db = \Config\Database::connect();

        $penempatan = $db->table('t_penempatan_magang')
            ->where('id_penempatan_magang', $id_penempatan)
            ->get()->getRow();

        if (!$penempatan) {
            return false;
        }

        // Hanya bisa dibatalkan jika status DISETUJUI atau BERJALAN
        if (!in_array($penempatan->status_penempatan, ['DISETUJUI', 'BERJALAN'])) {
            return false;
        }

        return $db->table('t_penempatan_magang')
            ->where('id_penempatan_magang', $id_penempatan)
            ->update([
                'status_penempatan' => 'DIBATALKAN',
                'catatan'           => $catatan,
                'updated_at'        => date('Y-m-d H:i:s'),
            ]);
    }

    /**
     * Lazy check: Update status otomatis berdasarkan tanggal.
     * - DISETUJUI → BERJALAN jika tanggal_mulai <= hari ini
     * - BERJALAN → SELESAI jika tanggal_selesai < hari ini
     *
     * Dipanggil setiap kali halaman riwayat/dashboard di-load.
     *
     * @param int|null $id_bidang Filter per bidang (opsional)
     * @return void
     */
    public function updateStatusOtomatis($id_bidang = null)
    {
        $db = \Config\Database::connect();
        $today = date('Y-m-d');

        // DISETUJUI → BERJALAN (tanggal mulai sudah tiba DAN mahasiswa sudah setuju)
        $builder1 = $db->table('t_penempatan_magang p')
            ->select('p.id_penempatan_magang')
            ->join('t_persetujuan_magang ps', 'ps.id_persetujuan_magang = p.id_persetujuan_magang', 'left')
            ->where('p.status_penempatan', 'DISETUJUI')
            ->where('ps.status_persetujuan_mahasiswa', 'DISETUJUI')
            ->where('p.tanggal_mulai <=', $today);
        if ($id_bidang !== null) $builder1->where('p.id_bidang', $id_bidang);
        
        $toBerjalan = $builder1->get()->getResultArray();
        if (!empty($toBerjalan)) {
            $idsToBerjalan = array_column($toBerjalan, 'id_penempatan_magang');
            $db->table('t_penempatan_magang')
                ->whereIn('id_penempatan_magang', $idsToBerjalan)
                ->update([
                    'status_penempatan' => 'BERJALAN',
                    'updated_at'        => date('Y-m-d H:i:s'),
                ]);
        }

        // BERJALAN → SELESAI (tanggal selesai sudah lewat)
        $builder2 = $db->table('t_penempatan_magang')
            ->where('status_penempatan', 'BERJALAN')
            ->where('tanggal_selesai <', $today);
        if ($id_bidang !== null) $builder2->where('id_bidang', $id_bidang);
        $builder2->update([
            'status_penempatan' => 'SELESAI',
            'updated_at'        => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Selesaikan penempatan:
     * Ubah status menjadi SELESAI.
     *
     * @param int $id_penempatan
     * @param int $updated_by
     * @return bool
     */
    public function selesaikanPenempatan($id_penempatan, $updated_by)
    {
        $db = \Config\Database::connect();

        return $db->table('t_penempatan_magang')
            ->where('id_penempatan_magang', $id_penempatan)
            ->update([
                'status_penempatan' => 'SELESAI',
                'updated_at'        => date('Y-m-d H:i:s'),
            ]);
    }

    /**
     * Hitung jumlah penempatan menunggu untuk bidang tertentu.
     *
     * @param int|null $id_bidang
     * @return int
     */
    public function countPenempatanMenunggu($id_bidang = null)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('t_penempatan_magang');
        $builder->where('status_penempatan', 'MENUNGGU');

        if ($id_bidang !== null) {
            $builder->where('id_bidang', $id_bidang);
        }

        return $builder->countAllResults();
    }

    /**
     * Ambil data penempatan magang terbaru berdasarkan status.
     *
     * @param int|null $id_bidang
     * @param int $limit
     * @return array
     */
    public function getPenempatanTerbaruMasuk($id_bidang = null, $limit = 5)
    {
        $db = \Config\Database::connect();
        
        $builder = $db->table('t_penempatan_magang as pn');
        $builder->select('
            pn.id_penempatan_magang,
            pn.id_bidang,
            pn.status_penempatan,
            mhs.nim,
            mhs.nama_mahasiswa,
            ip.instansi_pendidikan,
            jp.jenis_permohonan
        ');
        $builder->join('t_persetujuan_magang as ps', 'ps.id_persetujuan_magang = pn.id_persetujuan_magang', 'left');
        $builder->join('t_permohonan_magang as pm', 'pm.id_permohonan_magang = ps.id_permohonan_magang', 'left');
        $builder->join('m_mahasiswa as mhs', 'mhs.id_mahasiswa = pm.id_mahasiswa', 'left');
        $builder->join('m_jenis_permohonan as jp', 'jp.id_jenis_permohonan = pm.id_jenis_permohonan', 'left');
        $builder->join('t_instansi_mahasiswa as im', 'im.id_instansi_mahasiswa = pm.id_instansi_mahasiswa', 'left');
        $builder->join('m_instansi_pendidikan as ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan', 'left');
        
        $builder->where('pn.status_penempatan', 'MENUNGGU');
        
        if ($id_bidang !== null) {
            $builder->where('pn.id_bidang', $id_bidang);
        }

        $builder->orderBy('pn.created_at', 'ASC'); // Yang terlama (menunggu)
        $builder->limit($limit);

        return $builder->get()->getResult();
    }
}
