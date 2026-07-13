<?php

/**
 * Kode: 2026-07-05-120000_CreateAllTables.php
 * Path: app/Database/Migrations/2026-07-05-120000_CreateAllTables.php
 * Deskripsi: Migration untuk membuat seluruh tabel yang dibutuhkan pada sistem
 *            E-Layanan Permohonan & Kegiatan Akademik Dinas Kominfo Kota Tangerang,
 *            beserta data awal (seed) untuk user_groups, c_user_pegawai, dan m_jenis_permohonan.
 */

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAllTables extends Migration
{
    public function up(): void
    {
        // =====================================================================
        // 1. user_groups
        // =====================================================================
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'group' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 1,
                'default'    => '1',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_by' => [
                'type' => 'INT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('user_groups', true);

        // =====================================================================
        // 2. m_opd
        // =====================================================================
        $this->forge->addField([
            'id_opd' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'opd' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'status_aktif' => [
                'type'       => 'VARCHAR',
                'constraint' => 1,
                'default'    => '1',
            ],
        ]);
        $this->forge->addKey('id_opd', true);
        $this->forge->createTable('m_opd', true);

        // =====================================================================
        // 3. m_bidang
        // =====================================================================
        $this->forge->addField([
            'id_bidang' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'bidang' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'status_aktif' => [
                'type'       => 'VARCHAR',
                'constraint' => 1,
                'default'    => '1',
            ],
            'id_opd' => [
                'type' => 'INT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_bidang', true);
        $this->forge->createTable('m_bidang', true);

        // =====================================================================
        // 4. m_kuota
        // =====================================================================
        $this->forge->addField([
            'id_kuota' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_bidang' => [
                'type' => 'INT',
            ],
            'kuota' => [
                'type'    => 'INT',
                'default' => 0,
            ],
            'status_aktif' => [
                'type'       => 'VARCHAR',
                'constraint' => 1,
                'default'    => '1',
            ],
        ]);
        $this->forge->addKey('id_kuota', true);
        $this->forge->createTable('m_kuota', true);

        // =====================================================================
        // 5. m_fakultas
        // =====================================================================
        $this->forge->addField([
            'id_fakultas' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'fakultas' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 1,
                'default'    => '1',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_fakultas', true);
        $this->forge->createTable('m_fakultas', true);

        // =====================================================================
        // 6. m_prodi
        // =====================================================================
        $this->forge->addField([
            'id_prodi' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_fakultas' => [
                'type' => 'INT',
            ],
            'prodi' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 1,
                'default'    => '1',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_prodi', true);
        $this->forge->createTable('m_prodi', true);

        // =====================================================================
        // 7. m_instansi_pendidikan
        // =====================================================================
        $this->forge->addField([
            'id_instansi_pendidikan' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'instansi_pendidikan' => [
                'type'       => 'VARCHAR',
                'constraint' => 300,
            ],
            'jenis_instansi' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 1,
                'default'    => '1',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_instansi_pendidikan', true);
        $this->forge->createTable('m_instansi_pendidikan', true);

        // =====================================================================
        // 8. m_jenis_permohonan
        // =====================================================================
        $this->forge->addField([
            'id_jenis_permohonan' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'jenis_permohonan' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 1,
                'default'    => '1',
            ],
        ]);
        $this->forge->addKey('id_jenis_permohonan', true);
        $this->forge->createTable('m_jenis_permohonan', true);

        // =====================================================================
        // 9. m_file
        // =====================================================================
        $this->forge->addField([
            'id_file' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'status_aktif' => [
                'type'       => 'VARCHAR',
                'constraint' => 1,
                'default'    => '1',
            ],
            'id_jenis_permohonan' => [
                'type' => 'INT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_file', true);
        $this->forge->createTable('m_file', true);

        // =====================================================================
        // 10. m_komponen_penilaian
        // =====================================================================
        $this->forge->addField([
            'id_komponen_penilaian' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'komponen_penilaian' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'status_aktif' => [
                'type'       => 'VARCHAR',
                'constraint' => 1,
                'default'    => '1',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_komponen_penilaian', true);
        $this->forge->createTable('m_komponen_penilaian', true);

        // =====================================================================
        // 11. m_mahasiswa
        // =====================================================================
        $this->forge->addField([
            'id_mahasiswa' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nim' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'nama_mahasiswa' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'jenis_kelamin' => [
                'type'       => 'VARCHAR',
                'constraint' => 2,
            ],
            'tgl_lahir' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'rt' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'rw' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'kelurahan' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'kecamatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'provinsi' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'no_telp' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => true,
            ],
            'id_instansi_mahasiswa' => [
                'type' => 'INT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_mahasiswa', true);
        $this->forge->createTable('m_mahasiswa', true);

        // =====================================================================
        // 12. m_user_mahasiswa
        // =====================================================================
        $this->forge->addField([
            'id_user_mahasiswa' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_mahasiswa' => [
                'type' => 'INT',
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'aktif',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_user_mahasiswa', true);
        $this->forge->createTable('m_user_mahasiswa', true);

        // =====================================================================
        // 13. c_user_pegawai
        // =====================================================================
        $this->forge->addField([
            'id_user_pegawai' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'group_id' => [
                'type' => 'INT',
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'nama_user' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'nip' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'kode_unor' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'id_bidang' => [
                'type' => 'INT',
                'null' => true,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 1,
                'default'    => '1',
            ],
            'status_aktif' => [
                'type'       => 'VARCHAR',
                'constraint' => 1,
                'default'    => '1',
            ],
            'file_tanda_tangan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'last_login' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'kode_path' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_by' => [
                'type' => 'INT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_user_pegawai', true);
        $this->forge->createTable('c_user_pegawai', true);

        // =====================================================================
        // 14. t_instansi_mahasiswa
        // =====================================================================
        $this->forge->addField([
            'id_instansi_mahasiswa' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_mahasiswa' => [
                'type' => 'INT',
            ],
            'id_instansi_pendidikan' => [
                'type' => 'INT',
            ],
            'id_prodi' => [
                'type' => 'INT',
                'null' => true,
            ],
            'jenjang_pendidikan' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'angkatan_tahun' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'semester' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'tahun_akademik' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_instansi_mahasiswa', true);
        $this->forge->createTable('t_instansi_mahasiswa', true);

        // =====================================================================
        // 15. t_permohonan_magang
        // =====================================================================
        $this->forge->addField([
            'id_permohonan_magang' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_mahasiswa' => [
                'type' => 'INT',
            ],
            'id_instansi_mahasiswa' => [
                'type' => 'INT',
                'null' => true,
            ],
            'id_jenis_permohonan' => [
                'type' => 'INT',
            ],
            'deskripsi_keahlian' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'deskripsi_magang' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tgl_mulai' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'tgl_selesai' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'posting_data' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'draft',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_permohonan_magang', true);
        $this->forge->createTable('t_permohonan_magang', true);

        // =====================================================================
        // 16. t_file_permohonan_magang
        // =====================================================================
        $this->forge->addField([
            'id_file_permohonan_magang' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_permohonan_magang' => [
                'type' => 'INT',
            ],
            'id_file' => [
                'type' => 'INT',
                'null' => true,
            ],
            'nama_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'path_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_file_permohonan_magang', true);
        $this->forge->createTable('t_file_permohonan_magang', true);

        // =====================================================================
        // 17. t_persetujuan_magang
        // =====================================================================
        $this->forge->addField([
            'id_persetujuan_magang' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_permohonan_magang' => [
                'type' => 'INT',
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status_persetujuan' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'MENUNGGU',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_by' => [
                'type' => 'INT',
                'null' => true,
            ],
            'disposisi' => [
                'type'       => 'VARCHAR',
                'constraint' => 1,
                'default'    => '0',
            ],
            'id_bidang' => [
                'type' => 'INT',
                'null' => true,
            ],
            'tgl_persetujuan' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_persetujuan_magang', true);
        $this->forge->createTable('t_persetujuan_magang', true);

        // =====================================================================
        // 18. t_penempatan_magang
        // =====================================================================
        $this->forge->addField([
            'id_penempatan_magang' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_bidang' => [
                'type' => 'INT',
                'null' => true,
            ],
            'id_persetujuan_magang' => [
                'type' => 'INT',
            ],
            'id_mahasiswa' => [
                'type' => 'INT',
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status_penempatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'BERJALAN',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_by' => [
                'type' => 'INT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_penempatan_magang', true);
        $this->forge->createTable('t_penempatan_magang', true);

        // =====================================================================
        // 19. t_logbook_magang
        // =====================================================================
        $this->forge->addField([
            'id_logbook_magang' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_penempatan_magang' => [
                'type' => 'INT',
            ],
            'logbook_magang' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tgl_logbook' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'disetujui_oleh' => [
                'type' => 'INT',
                'null' => true,
            ],
            'file_tanda_tangan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'tgl_disetujui' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_logbook_magang', true);
        $this->forge->createTable('t_logbook_magang', true);

        // =====================================================================
        // 20. t_penilaian_magang
        // =====================================================================
        $this->forge->addField([
            'id_penilaian_magang' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_penempatan_magang' => [
                'type' => 'INT',
            ],
            'id_komponen_penilaian' => [
                'type' => 'INT',
            ],
            'nilai' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_by' => [
                'type' => 'INT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_penilaian_magang', true);
        $this->forge->createTable('t_penilaian_magang', true);

        // =====================================================================
        // SEED DATA
        // =====================================================================

        // Seed user_groups
        $this->db->table('user_groups')->ignore(true)->insertBatch([
            [
                'id'         => 1,
                'group'      => 'Superadmin',
                'status'     => '1',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'         => 2,
                'group'      => 'Bidang Seketariat',
                'status'     => '1',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'         => 3,
                'group'      => 'Bidang E-Gov',
                'status'     => '1',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ]);

        // Seed c_user_pegawai
        $hashedPassword = password_hash('123456', PASSWORD_DEFAULT);

        $this->db->table('c_user_pegawai')->ignore(true)->insertBatch([
            [
                'id_user_pegawai' => 1,
                'group_id'        => 1,
                'username'        => 'superadmin',
                'password'        => $hashedPassword,
                'nama_user'       => 'Super Administrator',
                'status'          => '1',
                'created_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'id_user_pegawai' => 2,
                'group_id'        => 2,
                'username'        => 'sekretariat',
                'password'        => $hashedPassword,
                'nama_user'       => 'Staff Sekretariat',
                'status'          => '1',
                'created_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'id_user_pegawai' => 3,
                'group_id'        => 3,
                'username'        => 'kabid',
                'password'        => $hashedPassword,
                'nama_user'       => 'Kepala Bidang E-Gov',
                'status'          => '1',
                'created_at'      => date('Y-m-d H:i:s'),
            ],
        ]);

        // Seed m_jenis_permohonan
        $this->db->table('m_jenis_permohonan')->ignore(true)->insertBatch([
            [
                'jenis_permohonan' => 'Penelitian Skripsi/TA',
                'status'           => '1',
            ],
            [
                'jenis_permohonan' => 'Observasi/Pengambilan Data',
                'status'           => '1',
            ],
            [
                'jenis_permohonan' => 'Magang/PKL',
                'status'           => '1',
            ],
            [
                'jenis_permohonan' => 'Uji Coba Produk (Prototype)',
                'status'           => '1',
            ],
        ]);
    }

    public function down(): void
    {
        // Drop tables in REVERSE order to avoid FK constraint issues
        $this->forge->dropTable('t_penilaian_magang', true);
        $this->forge->dropTable('t_logbook_magang', true);
        $this->forge->dropTable('t_penempatan_magang', true);
        $this->forge->dropTable('t_persetujuan_magang', true);
        $this->forge->dropTable('t_file_permohonan_magang', true);
        $this->forge->dropTable('t_permohonan_magang', true);
        $this->forge->dropTable('t_instansi_mahasiswa', true);
        $this->forge->dropTable('c_user_pegawai', true);
        $this->forge->dropTable('m_user_mahasiswa', true);
        $this->forge->dropTable('m_mahasiswa', true);
        $this->forge->dropTable('m_komponen_penilaian', true);
        $this->forge->dropTable('m_file', true);
        $this->forge->dropTable('m_jenis_permohonan', true);
        $this->forge->dropTable('m_instansi_pendidikan', true);
        $this->forge->dropTable('m_prodi', true);
        $this->forge->dropTable('m_fakultas', true);
        $this->forge->dropTable('m_kuota', true);
        $this->forge->dropTable('m_bidang', true);
        $this->forge->dropTable('m_opd', true);
        $this->forge->dropTable('user_groups', true);
    }
}
