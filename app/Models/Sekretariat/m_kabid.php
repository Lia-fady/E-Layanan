<?php

namespace App\Models\Sekretariat;

use CodeIgniter\Model;
use Config\Database;

class m_kabid extends Model
{
    protected $DBGroup = 'default';
    // Status constants (define here to avoid creating new files)
    public const PERSETUJUAN_MENUNGGU = 'MENUNGGU';
    public const PERSETUJUAN_DISETUJUI = 'DISETUJUI';
    public const PERSETUJUAN_DITOLAK = 'DITOLAK';

    public const PENEMPATAN_BERJALAN = 'BERJALAN';
    public const PENEMPATAN_SELESAI = 'SELESAI';
    public const PENEMPATAN_DIBATALKAN = 'DIBATALKAN';

    public function getPermohonanByBidang(int $id_bidang): array
    {
        $db = Database::connect();
        // Prefer transaction tables with 't_' prefix per SQL dump
        $persetujuanTable = 't_persetujuan_magang';
        $permohonanTable = 't_permohonan_magang';
        $mahasiswaTable = 'm_mahasiswa';

        // Fallback to non-prefixed names only if the t_/m_ variants don't exist
        if (! $db->tableExists($persetujuanTable)) {
            $persetujuanTable = $this->resolveTable(['persetujuan_magang', 't_persetujuan_magang']);
            if (! $persetujuanTable) {
                return [];
            }
        }

        $alias = 'per';
        $builder = $db->table("{$persetujuanTable} {$alias}");

        if (! $db->tableExists($permohonanTable)) {
            $permohonanTable = $this->resolveTable(['permohonan_magang', 't_permohonan_magang']);
        }

        if (! $db->tableExists($mahasiswaTable)) {
            $mahasiswaTable = $this->resolveTable(['m_mahasiswa', 'mahasiswa']);
        }
        $instansiTable = $this->resolveTable(['m_instansi_pendidikan', 'instansi_pendidikan']);
        $jenisPermohonanTable = $this->resolveTable(['m_jenis_permohonan', 'jenis_permohonan']);

        $select = ["{$alias}.*"];

        if ($permohonanTable) {
            $builder->join("{$permohonanTable} pm", "{$alias}.id_permohonan_magang = pm.id_permohonan_magang", 'left');
            $select[] = 'pm.deskripsi_magang';
            $select[] = 'pm.tgl_mulai';
            $select[] = 'pm.tgl_selesai';
            $select[] = 'pm.created_at as tgl_pengajuan';
        }

        if ($permohonanTable && $instansiTable) {
            $builder->join("{$instansiTable} inst", 'pm.id_instansi_mahasiswa = inst.id_instansi_pendidikan', 'left');
            $select[] = 'inst.instansi_pendidikan as universitas';
        }

        if ($permohonanTable && $jenisPermohonanTable) {
            $builder->join("{$jenisPermohonanTable} jp", 'pm.id_jenis_permohonan = jp.id_jenis_permohonan', 'left');
            $select[] = 'jp.jenis_permohonan';
        }

        if ($permohonanTable && $mahasiswaTable) {
            $builder->join("{$mahasiswaTable} m", 'pm.id_mahasiswa = m.id_mahasiswa', 'left');
            $select[] = 'm.nama_mahasiswa';
        }

        $builder->select($select);
        $builder->where("{$alias}.id_bidang", $id_bidang);

        return $builder->get()->getResultArray();
    }

    public function getPermohonanById(int $id): array
    {
        $db = Database::connect();
        $persetujuanTable = 't_persetujuan_magang';
        if (! $db->tableExists($persetujuanTable)) {
            $persetujuanTable = $this->resolveTable(['persetujuan_magang', 't_persetujuan_magang']);
            if (! $persetujuanTable) {
                return [];
            }
        }

        $permohonanTable = $this->resolveTable(['t_permohonan_magang', 'permohonan_magang']);
        $mahasiswaTable = $this->resolveTable(['m_mahasiswa', 'mahasiswa']);
        $instansiTable = $this->resolveTable(['m_instansi_pendidikan', 'instansi_pendidikan']);
        $jenisPermohonanTable = $this->resolveTable(['m_jenis_permohonan', 'jenis_permohonan']);
        $bidangTable = $this->resolveTable(['m_bidang', 'bidang']);

        $alias = 'per';
        $builder = $db->table("{$persetujuanTable} {$alias}");

        if ($permohonanTable) {
            $builder->join("{$permohonanTable} pm", "{$alias}.id_permohonan_magang = pm.id_permohonan_magang", 'left');
        }

        if ($permohonanTable && $mahasiswaTable) {
            $builder->join("{$mahasiswaTable} m", 'pm.id_mahasiswa = m.id_mahasiswa', 'left');
        }

        if ($permohonanTable && $instansiTable) {
            $builder->join("{$instansiTable} inst", 'pm.id_instansi_mahasiswa = inst.id_instansi_pendidikan', 'left');
        }

        if ($permohonanTable && $jenisPermohonanTable) {
            $builder->join("{$jenisPermohonanTable} jp", 'pm.id_jenis_permohonan = jp.id_jenis_permohonan', 'left');
        }

        if ($bidangTable) {
            $builder->join("{$bidangTable} b", "{$alias}.id_bidang = b.id_bidang", 'left');
        }

        $select = ["{$alias}.*"];
        if ($permohonanTable) {
            $select = array_merge($select, [
                'pm.deskripsi_magang',
                'pm.tgl_mulai',
                'pm.tgl_selesai',
                'pm.created_at as tgl_pengajuan',
            ]);
        }
        if ($mahasiswaTable) {
            $select[] = 'm.nama_mahasiswa';
        }
        if ($instansiTable) {
            $select[] = 'inst.instansi_pendidikan as universitas';
        }
        if ($jenisPermohonanTable) {
            $select[] = 'jp.jenis_permohonan';
        }
        if ($bidangTable) {
            $select[] = 'b.bidang as nama_bidang';
        }

        $select[] = 'per.catatan as catatan_sekretariat';
        $select[] = 'per.tgl_persetujuan as tgl_disposisi';

        $builder->select($select);
        $builder->where("{$alias}.id_persetujuan_magang", $id);

        return $builder->get()->getRowArray() ?? [];
    }

    public function updatePersetujuan(int $id, array $data): bool
    {
        $db = Database::connect();
        $table = 't_persetujuan_magang';
        if (! $db->tableExists($table)) {
            $table = $this->resolveTable(['persetujuan_magang', 't_persetujuan_magang']);
            if (! $table) {
                return false;
            }
        }

        return $db->table($table)
            ->where('id_persetujuan_magang', $id)
            ->update($data);
    }

    public function updatePenempatan(int $id, array $data): bool
    {
        $db = Database::connect();
        $table = 't_penempatan_magang';
        if (! $db->tableExists($table)) {
            $table = $this->resolveTable(['t_penempatan_magang','penempatan_magang','t_penempatan','penempatan']);
            if (! $table) {
                return false;
            }
        }

        // Try common primary key names used in the dump
        $updated = $db->table($table)
            ->where('id_penempatan_magang', $id)
            ->update($data);

        if ($updated === false) {
            // fallback to alternate primary key name
            return (bool) $db->table($table)
                ->where('id_penempatan', $id)
                ->update($data);
        }

        return (bool) $updated;
    }

    public function deletePenempatan(int $id): bool
    {
        $db = Database::connect();
        $table = 't_penempatan_magang';
        if (! $db->tableExists($table)) {
            $table = $this->resolveTable(['t_penempatan_magang','penempatan_magang','t_penempatan','penempatan']);
            if (! $table) {
                return false;
            }
        }

        $deleted = $db->table($table)
            ->where('id_penempatan_magang', $id)
            ->delete();

        if ($deleted === false) {
            return (bool) $db->table($table)
                ->where('id_penempatan', $id)
                ->delete();
        }

        return (bool) $deleted;
    }

    public function getPenempatan(?int $id_bidang = null): array
    {
        $db = Database::connect();
        $table = 't_penempatan_magang';
        if (! $db->tableExists($table)) {
            $table = $this->resolveTable(['penempatan_magang', 't_penempatan_magang', 'penempatan', 't_penempatan']);
            if (! $table) {
                return [];
            }
        }
        // If this table is a penempatan table, attempt to join related
        // persetujuan/permohonan/mahasiswa tables if they exist. Do not
        // reference any 'pengajuan' tables since they are not present.
        $penempatanCandidates = ['t_penempatan_magang', 'penempatan_magang', 't_penempatan', 'penempatan', 't_penempatan_magangs', 'penempatan_magangs'];
        if (in_array($table, $penempatanCandidates, true)) {
            $alias = 'pm';
            $builder = $db->table("{$table} {$alias}");

            $persetujuanTable = $this->resolveTable(['t_persetujuan_magang', 'persetujuan_magang']);
            $permohonanTable = $this->resolveTable(['t_permohonan_magang', 'permohonan_magang']);
            $mahasiswaTable = $this->resolveTable(['m_mahasiswa', 'mahasiswa']);

            $select = ["{$alias}.*"];

            if ($persetujuanTable) {
                $builder->join("{$persetujuanTable} per", "{$alias}.id_persetujuan_magang = per.id_persetujuan_magang", 'left');
                $select[] = 'per.id_permohonan_magang';
            }

            if ($permohonanTable) {
                $builder->join("{$permohonanTable} perm", 'per.id_permohonan_magang = perm.id_permohonan_magang', 'left');
                $select[] = 'perm.deskripsi_magang';
                $select[] = 'perm.tgl_mulai';
                $select[] = 'perm.tgl_selesai';
            }

            $bidangTable = $this->resolveTable(['m_bidang', 'bidang']);

            if ($permohonanTable && $mahasiswaTable) {
                // join to mahasiswa only if permohonan was joined (perm alias exists)
                $builder->join("{$mahasiswaTable} m", 'perm.id_mahasiswa = m.id_mahasiswa', 'left');
                $select[] = 'm.nama_mahasiswa';
            }

        if ($bidangTable) {
            $builder->join("{$bidangTable} b", 'pm.id_bidang = b.id_bidang', 'left');
            $select[] = 'b.bidang as nama_bidang';
            }

            $builder->select($select);
            if ($id_bidang !== null) {
                $builder->where("{$alias}.id_bidang", $id_bidang);
            }

            return $builder->get()->getResultArray();
        }

        // Fallback: simple table read for other table name variations
        $qb = $db->table($table);
        if ($id_bidang !== null) {
            $qb->where('id_bidang', $id_bidang);
        }

        return $qb->get()->getResultArray();
    }

    /**
     * Ambil data kuota setiap bidang (terisi & total).
     * Mengembalikan array berindeks id_bidang untuk akses cepat di view.
     *
     * @return array  [id_bidang => ['kuota_total', 'kuota_terisi', 'aktif', 'selesai'], ...]
     */
    public function getKuotaBidang(): array
    {
        $db         = Database::connect();
        $bidangTable = $this->resolveTable(['m_bidang', 'bidang']);
        $penempatanTable = $this->resolveTable(['t_penempatan_magang', 'penempatan_magang']);

        if (! $bidangTable) {
            return [];
        }

        // Ambil semua bidang beserta kuota jika kolom tersedia
        $bidangRows = $db->table($bidangTable)->get()->getResultArray();

        $result = [];
        foreach ($bidangRows as $row) {
            $id = (int) ($row['id_bidang'] ?? 0);
            if (! $id) continue;

            $kuota_total = (int) ($row['kuota_total'] ?? $row['kuota'] ?? 10);

            // Hitung terisi dari tabel penempatan jika ada
            $aktif   = 0;
            $selesai = 0;
            if ($penempatanTable) {
                $aktif   = (int) $db->table($penempatanTable)
                    ->where('id_bidang', $id)
                    ->where('status_penempatan', self::PENEMPATAN_BERJALAN)
                    ->countAllResults();
                $selesai = (int) $db->table($penempatanTable)
                    ->where('id_bidang', $id)
                    ->where('status_penempatan', self::PENEMPATAN_SELESAI)
                    ->countAllResults();
            }

            $result[$id] = [
                'kuota_total'  => $kuota_total,
                'kuota_terisi' => $aktif + $selesai,
                'aktif'        => $aktif,
                'selesai'      => $selesai,
            ];
        }

        return $result;
    }

    /**
     * Perbarui kuota total sebuah bidang.
     *
     * @param int $id_bidang
     * @param int $kuota_total
     * @return bool
     */
    public function updateKuotaBidang(int $id_bidang, int $kuota_total): bool
    {
        $db          = Database::connect();
        $bidangTable = $this->resolveTable(['m_bidang', 'bidang']);

        if (! $bidangTable) {
            return false;
        }

        // Coba kolom 'kuota_total' dulu, fallback ke 'kuota'
        $columns = $db->getFieldNames($bidangTable);
        $col     = in_array('kuota_total', $columns) ? 'kuota_total' : (in_array('kuota', $columns) ? 'kuota' : null);

        if (! $col) {
            return false;
        }

        return (bool) $db->table($bidangTable)
            ->where('id_bidang', $id_bidang)
            ->update([$col => $kuota_total]);
    }

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

    // Dashboard helpers
    public function countPermohonan(): int
    {
        $db = Database::connect();
        $table = $this->resolveTable(['t_permohonan_magang', 'permohonan_magang']);
        if (! $table) {
            return 0;
        }

        return (int) $db->table($table)->countAllResults();
    }

    public function countPendingPersetujuan(): int
    {
        $db = Database::connect();
        $table = $this->resolveTable(['t_persetujuan_magang', 'persetujuan_magang']);
        if (! $table) {
            return 0;
        }

        return (int) $db->table($table)->where('status_persetujuan', self::PERSETUJUAN_MENUNGGU)->countAllResults();
    }

    public function countPenempatanAktif(): int
    {
        $db = Database::connect();
        $table = $this->resolveTable(['t_penempatan_magang', 'penempatan_magang']);
        if (! $table) {
            return 0;
        }

        return (int) $db->table($table)->where('status_penempatan', self::PENEMPATAN_BERJALAN)->countAllResults();
    }

    public function getRecentPendingPersetujuan(int $limit = 5): array
    {
        $db = Database::connect();
        $persetujuan = $this->resolveTable(['t_persetujuan_magang', 'persetujuan_magang']);
        $permohonan = $this->resolveTable(['t_permohonan_magang', 'permohonan_magang']);
        $mahasiswa = $this->resolveTable(['m_mahasiswa', 'mahasiswa']);

        if (! $persetujuan || ! $permohonan) {
            return [];
        }

        $builder = $db->table("{$persetujuan} p");
        $builder->where('p.status_persetujuan', self::PERSETUJUAN_MENUNGGU);
        $builder->join("{$permohonan} pm", 'p.id_permohonan_magang = pm.id_permohonan_magang', 'left');

        $select = ['p.*', 'pm.deskripsi_magang'];
        if ($mahasiswa) {
            $builder->join("{$mahasiswa} m", 'pm.id_mahasiswa = m.id_mahasiswa', 'left');
            $select[] = 'm.nama_mahasiswa';
        }

        $builder->select($select);
        $builder->orderBy('p.updated_at', 'DESC');
        $builder->limit($limit);

        return $builder->get()->getResultArray();
    }

    /**
     * Hitung logbook yang masih pending (belum disetujui)
     * 
     * @return int Jumlah logbook pending
     */
    public function countPendingLogbook(): int
    {
        $db = Database::connect();
        $table = $this->resolveTable(['t_logbook_magang', 'logbook_magang']);
        if (! $table) {
            return 0;
        }

        return (int) $db->table($table)->where('disetujui_oleh', null)->countAllResults();
    }

    /**
     * Hitung penempatan yang sudah selesai (siap untuk sertifikat)
     * 
     * @return int Jumlah penempatan selesai
     */
    public function countSertifikatSiap(): int
    {
        $db = Database::connect();
        $table = $this->resolveTable(['t_penempatan_magang', 'penempatan_magang']);
        if (! $table) {
            return 0;
        }

        return (int) $db->table($table)->where('status_penempatan', self::PENEMPATAN_SELESAI)->countAllResults();
    }

    /**
     * Simpan atau update data sertifikat
     * 
     * @param array $data Data sertifikat (id_penempatan_magang, file_sertifikat, catatan, tgl_upload)
     * @return bool True jika berhasil, false jika gagal
     */
    public function saveSertifikat(array $data): bool
    {
        $db = Database::connect();
        $table = $this->resolveTable(['t_sertifikat', 'sertifikat']);

        if (! $table) {
            // Table tidak ditemukan, simpan ke table penempatan dengan field tambahan
            $table = $this->resolveTable(['t_penempatan_magang', 'penempatan_magang']);
            if (! $table) {
                return false;
            }

            // Update penempatan dengan data sertifikat
            $update_data = [
                'file_sertifikat' => $data['file_sertifikat'] ?? null,
                'catatan_sertifikat' => $data['catatan'] ?? null,
                'tgl_upload_sertifikat' => $data['tgl_upload'] ?? date('Y-m-d H:i:s'),
            ];

            return $db->table($table)
                ->where('id_penempatan_magang', $data['id_penempatan_magang'])
                ->update($update_data);
        }

        // Table sertifikat ada, insert data
        return $db->table($table)->insert($data);
    }
}
