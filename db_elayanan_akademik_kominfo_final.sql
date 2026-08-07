SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+07:00";

CREATE DATABASE IF NOT EXISTS db_elayanan_akademik_kominfo_final
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE db_elayanan_akademik_kominfo_final;

CREATE TABLE m_provinsi (
    id_provinsi INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode_provinsi VARCHAR(10) NOT NULL,
    nama_provinsi VARCHAR(100) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    deleted_at TIMESTAMP NULL DEFAULT NULL,

    UNIQUE KEY uk_kode_provinsi (kode_provinsi),
    KEY idx_nama_provinsi (nama_provinsi)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE m_kabupaten (
    id_kabupaten INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_provinsi INT UNSIGNED NOT NULL,
    kode_kabupaten VARCHAR(10) NOT NULL,
    nama_kabupaten VARCHAR(100) NOT NULL,

    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    deleted_at TIMESTAMP NULL DEFAULT NULL,

    UNIQUE KEY uk_kode_kabupaten (kode_kabupaten),

    KEY idx_provinsi (id_provinsi),

    CONSTRAINT fk_kabupaten_provinsi
        FOREIGN KEY (id_provinsi)
        REFERENCES m_provinsi(id_provinsi)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE m_kecamatan (
    id_kecamatan INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    id_kabupaten INT UNSIGNED NOT NULL,

    kode_kecamatan VARCHAR(10) NOT NULL,

    nama_kecamatan VARCHAR(100) NOT NULL,

    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    deleted_at TIMESTAMP NULL DEFAULT NULL,

    UNIQUE KEY uk_kecamatan (kode_kecamatan),

    KEY idx_kabupaten (id_kabupaten),

    CONSTRAINT fk_kecamatan_kabupaten
        FOREIGN KEY (id_kabupaten)
        REFERENCES m_kabupaten(id_kabupaten)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE m_kelurahan (

    id_kelurahan INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    id_kecamatan INT UNSIGNED NOT NULL,

    kode_kelurahan VARCHAR(10) NOT NULL,

    nama_kelurahan VARCHAR(100) NOT NULL,

    kode_pos VARCHAR(10),

    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    deleted_at TIMESTAMP NULL DEFAULT NULL,

    UNIQUE KEY uk_kelurahan (kode_kelurahan),

    KEY idx_kecamatan (id_kecamatan),

    CONSTRAINT fk_kelurahan_kecamatan
        FOREIGN KEY (id_kecamatan)
        REFERENCES m_kecamatan(id_kecamatan)
        ON UPDATE CASCADE
        ON DELETE RESTRICT

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE m_jenjang_pendidikan (

    id_jenjang_pendidikan INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    nama_jenjang VARCHAR(50) NOT NULL,

    status ENUM('AKTIF','NONAKTIF')
        DEFAULT 'AKTIF',

    created_at TIMESTAMP NULL DEFAULT NULL,

    updated_at TIMESTAMP NULL DEFAULT NULL,

    deleted_at TIMESTAMP NULL DEFAULT NULL,

    UNIQUE KEY uk_jenjang (nama_jenjang)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE m_opd (
    id_opd INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    nama_opd VARCHAR(150) NOT NULL,

    singkatan VARCHAR(50) NULL,

    alamat TEXT NULL,

    no_telepon VARCHAR(20) NULL,

    email VARCHAR(100) NULL,

    website VARCHAR(150) NULL,

    status ENUM('AKTIF','NONAKTIF') DEFAULT 'AKTIF',

    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    deleted_at TIMESTAMP NULL DEFAULT NULL,

    UNIQUE KEY uk_nama_opd (nama_opd)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE m_bidang (

    id_bidang INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    id_opd INT UNSIGNED NOT NULL,

    nama_bidang VARCHAR(150) NOT NULL,

    kode_bidang VARCHAR(30) NULL,

    status ENUM('AKTIF','NONAKTIF') DEFAULT 'AKTIF',

    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    deleted_at TIMESTAMP NULL DEFAULT NULL,

    KEY idx_opd (id_opd),

    CONSTRAINT fk_bidang_opd
        FOREIGN KEY (id_opd)
        REFERENCES m_opd(id_opd)
        ON UPDATE CASCADE
        ON DELETE RESTRICT

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE m_fakultas (

    id_fakultas INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    nama_fakultas VARCHAR(150) NOT NULL,

    status ENUM('AKTIF','NONAKTIF') DEFAULT 'AKTIF',

    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    deleted_at TIMESTAMP NULL DEFAULT NULL,

    UNIQUE KEY uk_fakultas (nama_fakultas)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE m_prodi (

    id_prodi INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    id_fakultas INT UNSIGNED NOT NULL,

    nama_prodi VARCHAR(150) NOT NULL,

    jenjang VARCHAR(20) NULL,

    status ENUM('AKTIF','NONAKTIF') DEFAULT 'AKTIF',

    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    deleted_at TIMESTAMP NULL DEFAULT NULL,

    KEY idx_fakultas (id_fakultas),

    CONSTRAINT fk_prodi_fakultas
        FOREIGN KEY (id_fakultas)
        REFERENCES m_fakultas(id_fakultas)
        ON UPDATE CASCADE
        ON DELETE RESTRICT

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE m_instansi_pendidikan (

    id_instansi_pendidikan INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    id_jenjang_pendidikan INT UNSIGNED NOT NULL,

    nama_instansi VARCHAR(200) NOT NULL,

    jenis_instansi ENUM('NEGERI','SWASTA') NULL,

    alamat TEXT NULL,

    email VARCHAR(100) NULL,

    no_telepon VARCHAR(20) NULL,

    status ENUM('AKTIF','NONAKTIF') DEFAULT 'AKTIF',

    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    deleted_at TIMESTAMP NULL DEFAULT NULL,

    KEY idx_jenjang (id_jenjang_pendidikan),

    CONSTRAINT fk_instansi_jenjang
        FOREIGN KEY (id_jenjang_pendidikan)
        REFERENCES m_jenjang_pendidikan(id_jenjang_pendidikan)
        ON UPDATE CASCADE
        ON DELETE RESTRICT

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE m_instansi_pendidikan (

    id_instansi_pendidikan INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    id_jenjang_pendidikan INT UNSIGNED NOT NULL,

    nama_instansi VARCHAR(200) NOT NULL,

    jenis_instansi ENUM('NEGERI','SWASTA') NULL,

    alamat TEXT NULL,

    email VARCHAR(100) NULL,

    no_telepon VARCHAR(20) NULL,

    status ENUM('AKTIF','NONAKTIF') DEFAULT 'AKTIF',

    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    deleted_at TIMESTAMP NULL DEFAULT NULL,

    KEY idx_jenjang (id_jenjang_pendidikan),

    CONSTRAINT fk_instansi_jenjang
        FOREIGN KEY (id_jenjang_pendidikan)
        REFERENCES m_jenjang_pendidikan(id_jenjang_pendidikan)
        ON UPDATE CASCADE
        ON DELETE RESTRICT

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE m_instansi_pendidikan (

    id_instansi_pendidikan INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    id_jenjang_pendidikan INT UNSIGNED NOT NULL,

    nama_instansi VARCHAR(200) NOT NULL,

    jenis_instansi ENUM('NEGERI','SWASTA') NULL,

    alamat TEXT NULL,

    email VARCHAR(100) NULL,

    no_telepon VARCHAR(20) NULL,

    status ENUM('AKTIF','NONAKTIF') DEFAULT 'AKTIF',

    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    deleted_at TIMESTAMP NULL DEFAULT NULL,

    KEY idx_jenjang (id_jenjang_pendidikan),

    CONSTRAINT fk_instansi_jenjang
        FOREIGN KEY (id_jenjang_pendidikan)
        REFERENCES m_jenjang_pendidikan(id_jenjang_pendidikan)
        ON UPDATE CASCADE
        ON DELETE RESTRICT

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE m_file (

    id_file INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    nama_file VARCHAR(150) NOT NULL,

    kode_file VARCHAR(50) NULL,

    ekstensi VARCHAR(20) NULL,

    ukuran_maksimal INT NULL,

    wajib_upload ENUM('YA','TIDAK') DEFAULT 'YA',

    status ENUM('AKTIF','NONAKTIF') DEFAULT 'AKTIF',

    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    deleted_at TIMESTAMP NULL DEFAULT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE m_file_permohonan (

    id_file_permohonan INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    id_jenis_permohonan INT UNSIGNED NOT NULL,

    id_file INT UNSIGNED NOT NULL,

    urutan INT DEFAULT 1,

    wajib ENUM('YA','TIDAK') DEFAULT 'YA',

    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,

    KEY idx_permohonan (id_jenis_permohonan),

    KEY idx_file (id_file)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE m_jenis_permohonan (

    id_jenis_permohonan INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    nama_jenis_permohonan VARCHAR(150) NOT NULL,

    deskripsi TEXT NULL,

    durasi_permohonan INT NULL COMMENT 'Durasi dalam hari',

    menggunakan_kuota ENUM('YA','TIDAK') DEFAULT 'YA',

    menggunakan_logbook ENUM('YA','TIDAK') DEFAULT 'YA',

    status ENUM('AKTIF','NONAKTIF') DEFAULT 'AKTIF',

    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    deleted_at TIMESTAMP NULL DEFAULT NULL,

    UNIQUE KEY uk_permohonan (nama_jenis_permohonan)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE m_kuota (

    id_kuota INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    id_bidang INT UNSIGNED NOT NULL,

    tahun YEAR NOT NULL,

    bulan TINYINT NOT NULL,

    kuota INT NOT NULL,

    status ENUM('AKTIF','NONAKTIF') DEFAULT 'AKTIF',

    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,

    KEY idx_bidang (id_bidang),

    CONSTRAINT fk_kuota_bidang
        FOREIGN KEY (id_bidang)
        REFERENCES m_bidang(id_bidang)
        ON UPDATE CASCADE
        ON DELETE RESTRICT

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE c_user_group (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    `group` VARCHAR(100) NOT NULL,

    status TINYINT(1) NOT NULL DEFAULT 1 COMMENT '1=Aktif,0=Nonaktif',

    created_at DATETIME NULL,
    created_by INT NULL,

    updated_at DATETIME NULL,
    updated_by INT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE c_user_pegawai (

    id_user_pegawai INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    nama VARCHAR(150) NOT NULL,

    nip VARCHAR(50) NOT NULL,

    password VARCHAR(255) NOT NULL,

    kode_unor VARCHAR(50) NULL,

    id_user_group INT UNSIGNED NULL,

    id_bidang INT UNSIGNED NULL,

    status_aktif ENUM('AKTIF','NONAKTIF')
        DEFAULT 'AKTIF',

    file_tanda_tangan VARCHAR(255) NULL,

    last_login DATETIME NULL,

    created_at DATETIME NULL,

    updated_at DATETIME NULL,

    deleted_at DATETIME NULL,

    KEY idx_group(id_user_group),

    KEY idx_bidang(id_bidang),

    CONSTRAINT fk_user_group
        FOREIGN KEY (id_user_group)
        REFERENCES c_user_group(id),

    CONSTRAINT fk_user_bidang
        FOREIGN KEY (id_bidang)
        REFERENCES m_bidang(id_bidang)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE m_mahasiswa (

    id_mahasiswa INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    nik VARCHAR(16) NOT NULL,

    nim VARCHAR(50) NOT NULL,

    nama_mahasiswa VARCHAR(150) NOT NULL,

    jenis_kelamin ENUM('L','P') NOT NULL,

    tgl_lahir DATE NOT NULL,

    alamat TEXT NOT NULL,

    rt VARCHAR(5),

    rw VARCHAR(5),

    id_kelurahan CHAR(10),

    no_telp VARCHAR(20) NOT NULL,

    id_instansi_mahasiswa INT UNSIGNED NOT NULL,

    email VARCHAR(100) NOT NULL,

    created_at DATETIME NULL,

    updated_at DATETIME NULL,

    deleted_at DATETIME NULL,

    UNIQUE KEY uk_nik(nik),

    UNIQUE KEY uk_nim(nim),

    UNIQUE KEY uk_email(email)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE m_user_mahasiswa (

    id_user_mahasiswa INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    id_mahasiswa INT UNSIGNED NOT NULL,

    username VARCHAR(100) NOT NULL,

    password VARCHAR(255) NOT NULL,

    status ENUM('AKTIF','NONAKTIF')
        DEFAULT 'AKTIF',

    last_login DATETIME NULL,

    created_at DATETIME NULL,

    updated_at DATETIME NULL,

    deleted_at DATETIME NULL,

    UNIQUE KEY uk_username(username),

    CONSTRAINT fk_user_mahasiswa
        FOREIGN KEY (id_mahasiswa)
        REFERENCES m_mahasiswa(id_mahasiswa)
        ON UPDATE CASCADE
        ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE t_instansi_mahasiswa (

    id_instansi_mahasiswa INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    id_mahasiswa INT UNSIGNED NOT NULL,

    id_instansi_pendidikan INT UNSIGNED NOT NULL,

    id_fakultas INT UNSIGNED NULL,

    id_prodi INT UNSIGNED NOT NULL,

    id_jenjang_pendidikan INT UNSIGNED NOT NULL,

    jurusan VARCHAR(150) NULL,

    angkatan_tahun VARCHAR(4) NULL,

    semester VARCHAR(10) NULL,

    tahun_akademik VARCHAR(20) NULL,

    created_by VARCHAR(100) NULL,

    updated_by VARCHAR(100) NULL,

    created_at DATETIME NULL,

    updated_at DATETIME NULL,

    deleted_at DATETIME NULL,

    KEY idx_mahasiswa(id_mahasiswa),

    KEY idx_instansi(id_instansi_pendidikan),

    KEY idx_fakultas(id_fakultas),

    KEY idx_prodi(id_prodi),

    KEY idx_jenjang(id_jenjang_pendidikan),

    CONSTRAINT fk_tim_mahasiswa
        FOREIGN KEY (id_mahasiswa)
        REFERENCES m_mahasiswa(id_mahasiswa)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_tim_instansi
        FOREIGN KEY (id_instansi_pendidikan)
        REFERENCES m_instansi_pendidikan(id_instansi_pendidikan)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_tim_fakultas
        FOREIGN KEY (id_fakultas)
        REFERENCES m_fakultas(id_fakultas)
        ON UPDATE CASCADE
        ON DELETE SET NULL,

    CONSTRAINT fk_tim_prodi
        FOREIGN KEY (id_prodi)
        REFERENCES m_prodi(id_prodi)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_tim_jenjang
        FOREIGN KEY (id_jenjang_pendidikan)
        REFERENCES m_jenjang_pendidikan(id_jenjang_pendidikan)
        ON UPDATE CASCADE
        ON DELETE RESTRICT

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE t_permohonan_magang (

    id_permohonan_magang INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    id_mahasiswa INT UNSIGNED NOT NULL,

    id_instansi_mahasiswa INT UNSIGNED NOT NULL,

    id_jenis_permohonan INT UNSIGNED NOT NULL,

    tujuan VARCHAR(255) NOT NULL,

    deskripsi_keahlian TEXT NULL COMMENT 'Keahlian yang dimiliki',

    deskripsi_kegiatan TEXT NULL COMMENT 'Apa yang ingin dikerjakan saat magang',

    rencana_kegiatan TEXT NULL COMMENT 'Rencana kegiatan secara rinci',

    tgl_mulai DATE NOT NULL,

    tgl_selesai DATE NOT NULL,

    posting_data ENUM('draft','kirim')
        DEFAULT 'draft',

    created_at DATETIME NULL,

    created_by VARCHAR(100) NULL,

    updated_at DATETIME NULL,

    updated_by VARCHAR(100) NULL,

    deleted_at DATETIME NULL,

    KEY idx_mahasiswa(id_mahasiswa),

    KEY idx_instansi(id_instansi_mahasiswa),

    KEY idx_jenis(id_jenis_permohonan),

    CONSTRAINT fk_permohonan_mahasiswa
        FOREIGN KEY(id_mahasiswa)
        REFERENCES m_mahasiswa(id_mahasiswa)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_permohonan_instansi
        FOREIGN KEY(id_instansi_mahasiswa)
        REFERENCES t_instansi_mahasiswa(id_instansi_mahasiswa)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_permohonan_jenis
        FOREIGN KEY(id_jenis_permohonan)
        REFERENCES m_jenis_permohonan(id_jenis_permohonan)
        ON UPDATE CASCADE
        ON DELETE RESTRICT

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE t_file_permohonan_magang (

    id_file_permohonan_magang INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    id_permohonan_magang INT UNSIGNED NOT NULL,

    id_file_permohonan INT UNSIGNED NOT NULL,

    nama_file VARCHAR(255) NOT NULL,

    path_file VARCHAR(255) NOT NULL,

    status_verifikasi ENUM(
        'MENUNGGU',
        'SESUAI',
        'TIDAK_SESUAI'
    ) DEFAULT 'MENUNGGU',

    catatan_verifikasi TEXT NULL,

    created_at DATETIME NULL,

    updated_at DATETIME NULL,

    KEY idx_permohonan(id_permohonan_magang),

    KEY idx_file(id_file_permohonan),

    CONSTRAINT fk_file_permohonan
        FOREIGN KEY(id_permohonan_magang)
        REFERENCES t_permohonan_magang(id_permohonan_magang)
        ON UPDATE CASCADE
        ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE t_persetujuan_magang (

    id_persetujuan_magang INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    id_permohonan_magang INT UNSIGNED NOT NULL,

    id_bidang INT UNSIGNED NULL,

    catatan TEXT NULL,

    status_persetujuan ENUM(

        'MENUNGGU',

        'DISETUJUI',

        'PERBAIKAN_BERKAS',

        'DITOLAK'

    ) DEFAULT 'MENUNGGU',

    disposisi ENUM(

        'BELUM',

        'DIKIRIM',

        'DITERIMA'

    ) DEFAULT 'BELUM',

    tanggal_disposisi DATETIME NULL,

    tanggal_persetujuan DATETIME NULL,

    created_at DATETIME NULL,

    created_by VARCHAR(100),

    updated_at DATETIME NULL,

    updated_by VARCHAR(100),

    KEY idx_permohonan(id_permohonan_magang),

    KEY idx_bidang(id_bidang)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE t_penempatan_magang (

    id_penempatan_magang INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    id_persetujuan_magang INT UNSIGNED NOT NULL,

    id_mahasiswa INT UNSIGNED NOT NULL,

    id_bidang INT UNSIGNED NOT NULL,

    tanggal_mulai DATE NOT NULL,

    tanggal_selesai DATE NOT NULL,

    tanggal_persetujuan DATETIME NULL,

    status_penempatan ENUM(

        'MENUNGGU',

        'BERJALAN',

        'SELESAI',

        'DIBATALKAN'

    ) DEFAULT 'MENUNGGU',

    is_log_book ENUM('YA','TIDAK')
        DEFAULT 'YA',

    catatan TEXT NULL,

    created_at DATETIME NULL,

    updated_at DATETIME NULL,

    KEY idx_bidang(id_bidang),

    KEY idx_persetujuan(id_persetujuan_magang)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE t_file_proses_magang (

    id_file_proses_magang INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    id_persetujuan_magang INT UNSIGNED NOT NULL,

    id_file INT UNSIGNED NOT NULL,

    nama_file VARCHAR(255) NOT NULL,

    path_file VARCHAR(255) NOT NULL,

    proses_magang ENUM(

        'persetujuan',

        'selesai'

    ) DEFAULT 'persetujuan',

    status ENUM(

        'AKTIF',

        'NONAKTIF'

    ) DEFAULT 'AKTIF',

    created_at DATETIME NULL,

    created_by VARCHAR(100),

    updated_at DATETIME NULL,

    updated_by VARCHAR(100)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE t_log_permohonan (

    id_log INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    id_permohonan_magang INT UNSIGNED NOT NULL,

    aktor VARCHAR(100) NOT NULL,

    aksi VARCHAR(150) NOT NULL,

    catatan TEXT NULL,

    created_at DATETIME NULL,

    KEY idx_permohonan(id_permohonan_magang),

    CONSTRAINT fk_log_permohonan
        FOREIGN KEY(id_permohonan_magang)
        REFERENCES t_permohonan_magang(id_permohonan_magang)
        ON UPDATE CASCADE
        ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE t_logbook_magang (

    id_logbook_magang INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    id_penempatan_magang INT UNSIGNED NOT NULL,

    logbook_magang TEXT NOT NULL,

    bukti_kegiatan VARCHAR(255) NULL,

    tgl_logbook DATE NOT NULL,

    jam_logbook TIME NOT NULL,

    status_logbook ENUM(

        'BELUM_DISETUJUI',

        'DISETUJUI',

        'DITOLAK'

    ) DEFAULT 'BELUM_DISETUJUI',

    catatan_revisi TEXT NULL,

    disetujui_oleh INT UNSIGNED NULL,

    file_tanda_tangan VARCHAR(255) NULL,

    tgl_disetujui DATETIME NULL,

    created_at DATETIME NULL,

    updated_at DATETIME NULL,

    deleted_at DATETIME NULL,

    KEY idx_penempatan(id_penempatan_magang),

    KEY idx_status(status_logbook),

    CONSTRAINT fk_logbook_penempatan
        FOREIGN KEY(id_penempatan_magang)
        REFERENCES t_penempatan_magang(id_penempatan_magang)
        ON UPDATE CASCADE
        ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE t_sertifikat_magang (

    id_sertifikat INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    id_penempatan_magang INT UNSIGNED NOT NULL,

    nomor_sertifikat VARCHAR(100),

    nama_file VARCHAR(255),

    path_file VARCHAR(255),

    tanggal_terbit DATE,

    status ENUM(

        'AKTIF',

        'NONAKTIF'

    ) DEFAULT 'AKTIF',

    created_at DATETIME,

    updated_at DATETIME,

    CONSTRAINT fk_sertifikat_penempatan
        FOREIGN KEY(id_penempatan_magang)
        REFERENCES t_penempatan_magang(id_penempatan_magang)
        ON UPDATE CASCADE
        ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE t_notifikasi (

    id_notifikasi INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    id_user INT UNSIGNED NOT NULL,

    jenis VARCHAR(50) NOT NULL,

    judul VARCHAR(150) NOT NULL,

    isi TEXT NOT NULL,

    dibaca ENUM('YA','TIDAK') DEFAULT 'TIDAK',

    created_at DATETIME,

    KEY idx_user(id_user),

    KEY idx_dibaca(dibaca)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE t_file_permohonan_magang
ADD CONSTRAINT fk_tfpm_file_permohonan
FOREIGN KEY (id_file_permohonan)
REFERENCES m_file_permohonan(id_file_permohonan)
ON UPDATE CASCADE
ON DELETE RESTRICT;

ALTER TABLE t_persetujuan_magang

ADD CONSTRAINT fk_persetujuan_permohonan
FOREIGN KEY (id_permohonan_magang)
REFERENCES t_permohonan_magang(id_permohonan_magang)
ON UPDATE CASCADE
ON DELETE CASCADE,

ADD CONSTRAINT fk_persetujuan_bidang
FOREIGN KEY (id_bidang)
REFERENCES m_bidang(id_bidang)
ON UPDATE CASCADE
ON DELETE SET NULL;

ALTER TABLE t_penempatan_magang

ADD CONSTRAINT fk_penempatan_persetujuan
FOREIGN KEY (id_persetujuan_magang)
REFERENCES t_persetujuan_magang(id_persetujuan_magang)
ON UPDATE CASCADE
ON DELETE CASCADE,

ADD CONSTRAINT fk_penempatan_mahasiswa
FOREIGN KEY (id_mahasiswa)
REFERENCES m_mahasiswa(id_mahasiswa)
ON UPDATE CASCADE
ON DELETE CASCADE,

ADD CONSTRAINT fk_penempatan_bidang
FOREIGN KEY (id_bidang)
REFERENCES m_bidang(id_bidang)
ON UPDATE CASCADE
ON DELETE RESTRICT;

ALTER TABLE t_file_proses_magang

ADD CONSTRAINT fk_tfproses_persetujuan
FOREIGN KEY (id_persetujuan_magang)
REFERENCES t_persetujuan_magang(id_persetujuan_magang)
ON UPDATE CASCADE
ON DELETE CASCADE,

ADD CONSTRAINT fk_tfproses_file
FOREIGN KEY (id_file)
REFERENCES m_file(id_file)
ON UPDATE CASCADE
ON DELETE RESTRICT;

CREATE INDEX idx_permohonan_tanggal
ON t_permohonan_magang(created_at);

CREATE INDEX idx_permohonan_mulai
ON t_permohonan_magang(tgl_mulai);

CREATE INDEX idx_permohonan_selesai
ON t_permohonan_magang(tgl_selesai);

CREATE INDEX idx_status_persetujuan
ON t_persetujuan_magang(status_persetujuan);

CREATE INDEX idx_disposisi
ON t_persetujuan_magang(disposisi);

CREATE INDEX idx_status_penempatan
ON t_penempatan_magang(status_penempatan);

CREATE INDEX idx_tanggal_persetujuan
ON t_penempatan_magang(tanggal_persetujuan);

CREATE INDEX idx_logbook_tanggal
ON t_logbook_magang(tgl_logbook);

CREATE INDEX idx_logbook_status
ON t_logbook_magang(status_logbook);

ALTER TABLE t_instansi_mahasiswa

ADD CONSTRAINT uk_mahasiswa_instansi
UNIQUE(id_mahasiswa);

ALTER TABLE m_user_mahasiswa

ADD CONSTRAINT uk_user_mahasiswa
UNIQUE(username);

ALTER TABLE c_user_pegawai

ADD CONSTRAINT uk_nip
UNIQUE(nip);

ALTER TABLE t_permohonan_magang

ADD CONSTRAINT chk_tanggal

CHECK(tgl_selesai>=tgl_mulai);

ALTER TABLE m_kuota

ADD CONSTRAINT chk_kuota

CHECK(kuota>=0);

ALTER TABLE t_penilaian_magang

ADD CONSTRAINT chk_nilai

CHECK(nilai>=0 AND nilai<=100);

CREATE VIEW v_dashboard_permohonan AS

SELECT

jp.nama_jenis_permohonan,

COUNT(*) jumlah

FROM t_permohonan_magang pm

JOIN m_jenis_permohonan jp

ON pm.id_jenis_permohonan=jp.id_jenis_permohonan

GROUP BY jp.nama_jenis_permohonan;

CREATE VIEW v_dashboard_status AS

SELECT

status_persetujuan,

COUNT(*) jumlah

FROM t_persetujuan_magang

GROUP BY status_persetujuan;

CREATE VIEW v_dashboard_kuota AS

SELECT

b.nama_bidang,

k.bulan,

k.tahun,

k.kuota,

COUNT(p.id_penempatan_magang) terisi,

(k.kuota-COUNT(p.id_penempatan_magang)) sisa_kuota

FROM m_kuota k

JOIN m_bidang b

ON k.id_bidang=b.id_bidang

LEFT JOIN t_penempatan_magang p

ON p.id_bidang=b.id_bidang

AND MONTH(p.tanggal_mulai)=k.bulan

AND YEAR(p.tanggal_mulai)=k.tahun

GROUP BY

b.nama_bidang,

k.id_kuota;

DELIMITER $$

CREATE TRIGGER trg_penempatan

AFTER INSERT

ON t_penempatan_magang

FOR EACH ROW

BEGIN

UPDATE t_persetujuan_magang

SET status_persetujuan='DISETUJUI'

WHERE id_persetujuan_magang=NEW.id_persetujuan_magang;

END$$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER trg_log_permohonan

AFTER INSERT

ON t_permohonan_magang

FOR EACH ROW

BEGIN

INSERT INTO t_log_permohonan(

id_permohonan_magang,

aktor,

aksi,

created_at

)

VALUES(

NEW.id_permohonan_magang,

'Mahasiswa',

'Mengajukan Permohonan',

NOW()

);

END$$

DELIMITER ;