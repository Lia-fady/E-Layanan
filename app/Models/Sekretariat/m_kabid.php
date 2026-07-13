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

        $select = ["{$alias}.*"];

        if ($permohonanTable) {
            $builder->join("{$permohonanTable} pm", "{$alias}.id_permohonan_magang = pm.id_permohonan_magang", 'left');
            $select[] = 'pm.deskripsi_magang';
            $select[] = 'pm.tgl_mulai';
            $select[] = 'pm.tgl_selesai';
        }

        if ($mahasiswaTable) {
            $builder->join("{$mahasiswaTable} m", 'pm.id_mahasiswa = m.id_mahasiswa', 'left');
            $select[] = 'm.nama_mahasiswa';
        }

        $builder->select($select);
        $builder->where("{$alias}.id_bidang", $id_bidang);

        return $builder->get()->getResultArray();
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

    public function getKomponenPenilaian(): array
    {
        $db = Database::connect();
        $table = 'm_komponen_penilaian';
        if (! $db->tableExists($table)) {
            $table = $this->resolveTable(['m_komponen_penilaian', 'komponen_penilaian']);
            if (! $table) {
                return [];
            }
        }

        return $db->table($table)
            ->where('status_aktif', '1')
            ->orderBy('komponen_penilaian', 'ASC')
            ->get()
            ->getResultArray();
    }

    // CRUD for komponen penilaian
    public function getAllKomponen(): array
    {
        $db = Database::connect();
        $table = 'm_komponen_penilaian';
        if (! $db->tableExists($table)) {
            $table = $this->resolveTable(['m_komponen_penilaian', 'komponen_penilaian']);
            if (! $table) {
                return [];
            }
        }

        return $db->table($table)->orderBy('komponen_penilaian','ASC')->get()->getResultArray();
    }

    public function saveKomponen(array $data): bool
    {
        $db = Database::connect();
        $table = 'm_komponen_penilaian';
        if (! $db->tableExists($table)) {
            $table = $this->resolveTable(['m_komponen_penilaian', 'komponen_penilaian']);
            if (! $table) {
                return false;
            }
        }

        $now = date('Y-m-d H:i:s');
        if (! empty($data['id_komponen_penilaian'])) {
            $id = $data['id_komponen_penilaian'];
            $update = [
                'komponen_penilaian' => $data['komponen_penilaian'] ?? '',
                'status_aktif' => $data['status_aktif'] ?? '1',
                'updated_at' => $now,
            ];
            return (bool) $db->table($table)->where('id_komponen_penilaian', $id)->update($update);
        }

        $insert = [
            'komponen_penilaian' => $data['komponen_penilaian'] ?? '',
            'status_aktif' => $data['status_aktif'] ?? '1',
            'created_at' => $now,
        ];
        return (bool) $db->table($table)->insert($insert);
    }

    public function deleteKomponen(int $id): bool
    {
        $db = Database::connect();
        $table = 'm_komponen_penilaian';
        if (! $db->tableExists($table)) {
            $table = $this->resolveTable(['m_komponen_penilaian', 'komponen_penilaian']);
            if (! $table) {
                return false;
            }
        }

        return (bool) $db->table($table)->where('id_komponen_penilaian', $id)->delete();
    }

    public function getPenilaian(?int $id_bidang = null): array
    {
        $db = Database::connect();
        $table = 't_penilaian_magang';
        if (! $db->tableExists($table)) {
            $table = $this->resolveTable(['t_penilaian_magang', 'penilaian_magang']);
            if (! $table) {
                return [];
            }
        }

        $penempatanTable = $this->resolveTable(['t_penempatan_magang', 'penempatan_magang', 't_penempatan', 'penempatan']);
        if (! $penempatanTable) {
            return [];
        }

        $mahasiswaTable = $this->resolveTable(['m_mahasiswa', 'mahasiswa']);
        $komponenTable = $this->resolveTable(['m_komponen_penilaian', 'komponen_penilaian']);
        $persetujuanTable = $this->resolveTable(['t_persetujuan_magang', 'persetujuan_magang']);
        $permohonanTable = $this->resolveTable(['t_permohonan_magang', 'permohonan_magang']);

        $builder = $db->table("{$table} tpm");
        $builder->join("{$penempatanTable} pm", 'tpm.id_penempatan_magang = pm.id_penempatan_magang', 'left');

        if ($mahasiswaTable) {
            $builder->join("{$mahasiswaTable} m", 'pm.id_mahasiswa = m.id_mahasiswa', 'left');
        }

        if ($komponenTable) {
            $builder->join("{$komponenTable} kp", 'tpm.id_komponen_penilaian = kp.id_komponen_penilaian', 'left');
        }

        if ($persetujuanTable) {
            $builder->join("{$persetujuanTable} per", 'pm.id_persetujuan_magang = per.id_persetujuan_magang', 'left');
        }

        if ($permohonanTable) {
            $builder->join("{$permohonanTable} perm", 'per.id_permohonan_magang = perm.id_permohonan_magang', 'left');
        }

        $select = [
            'tpm.*',
            'pm.id_bidang',
            'pm.id_mahasiswa',
            'pm.status_penempatan',
            'm.nama_mahasiswa',
            'kp.komponen_penilaian',
            'perm.deskripsi_magang',
            'perm.tgl_mulai',
            'perm.tgl_selesai',
        ];

        $builder->select($select);
        if ($id_bidang !== null) {
            $builder->where('pm.id_bidang', $id_bidang);
        }

        return $builder->get()->getResultArray();
    }

    public function savePenilaian(array $data): bool
    {
        $db = Database::connect();
        $table = 't_penilaian_magang';
        if (! $db->tableExists($table)) {
            $table = $this->resolveTable(['t_penilaian_magang', 'penilaian_magang']);
            if (! $table) {
                return false;
            }
        }

        $existing = $db->table($table)
            ->where('id_penempatan_magang', $data['id_penempatan_magang'])
            ->where('id_komponen_penilaian', $data['id_komponen_penilaian'])
            ->get()
            ->getRowArray();

        if ($existing) {
            return (bool) $db->table($table)
                ->where('id_penilaian_magang', $existing['id_penilaian_magang'])
                ->update([
                    'nilai' => $data['nilai'],
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
        }

        $data['created_at'] = date('Y-m-d H:i:s');
        return (bool) $db->table($table)->insert($data);
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

            if ($mahasiswaTable) {
                // join to mahasiswa only if permohonan was joined (perm alias exists)
                $builder->join("{$mahasiswaTable} m", 'perm.id_mahasiswa = m.id_mahasiswa', 'left');
                $select[] = 'm.nama_mahasiswa';
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
        if ($mahasiswa) {
            $builder->join("{$mahasiswa} m", 'pm.id_mahasiswa = m.id_mahasiswa', 'left');
        }

        $builder->select(['p.*', 'pm.deskripsi_magang', 'm.nama_mahasiswa']);
        $builder->orderBy('p.updated_at', 'DESC');
        $builder->limit($limit);

        return $builder->get()->getResultArray();
    }
}
