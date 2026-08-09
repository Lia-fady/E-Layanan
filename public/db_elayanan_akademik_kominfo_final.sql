-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2026 at 08:57 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_elayanan_akademik_kominfo_final`
--

-- --------------------------------------------------------

--
-- Table structure for table `c_menus`
--

CREATE TABLE `c_menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_parent` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `url` varchar(100) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `icon` varchar(100) DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=aktif, 0=tidak aktif',
  `target_blank` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `c_menus_privileges`
--

CREATE TABLE `c_menus_privileges` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_user_group` int(10) UNSIGNED NOT NULL,
  `id_menu` int(10) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `c_user_group`
--

CREATE TABLE `c_user_group` (
  `id` int(10) UNSIGNED NOT NULL,
  `group` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Aktif,0=Nonaktif',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `c_user_pegawai`
--

CREATE TABLE `c_user_pegawai` (
  `id_user_pegawai` int(10) UNSIGNED NOT NULL,
  `nama` varchar(150) NOT NULL,
  `nip` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `kode_unor` varchar(50) DEFAULT NULL,
  `id_user_group` int(10) UNSIGNED DEFAULT NULL,
  `id_bidang` int(10) UNSIGNED DEFAULT NULL,
  `status_aktif` enum('AKTIF','NONAKTIF') DEFAULT 'AKTIF',
  `file_tanda_tangan` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_bidang`
--

CREATE TABLE `m_bidang` (
  `id_bidang` int(11) UNSIGNED NOT NULL,
  `id_opd` int(10) UNSIGNED NOT NULL,
  `bidang` varchar(255) NOT NULL,
  `kode_bidang` varchar(30) DEFAULT NULL,
  `status_aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_fakultas`
--

CREATE TABLE `m_fakultas` (
  `id_fakultas` int(11) UNSIGNED NOT NULL,
  `id_instansi_pendidikan` int(11) UNSIGNED NOT NULL,
  `fakultas` varchar(255) NOT NULL,
  `status` enum('AKTIF','NONAKTIF') DEFAULT 'AKTIF',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_file`
--

CREATE TABLE `m_file` (
  `id_file` int(11) UNSIGNED NOT NULL,
  `nama_file` varchar(150) NOT NULL,
  `kode_file` varchar(50) DEFAULT NULL,
  `ekstensi` varchar(20) DEFAULT NULL,
  `ukuran_maksimal` int(11) DEFAULT NULL,
  `wajib_upload` enum('YA','TIDAK') DEFAULT 'YA',
  `status` enum('AKTIF','NONAKTIF') DEFAULT 'AKTIF',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_file_permohonan`
--

CREATE TABLE `m_file_permohonan` (
  `id_file_permohonan` int(11) UNSIGNED NOT NULL,
  `id_jenis_permohonan` int(10) UNSIGNED NOT NULL,
  `id_file` int(10) UNSIGNED NOT NULL,
  `status_aktif` varchar(50) DEFAULT NULL,
  `urutan` int(11) DEFAULT 1,
  `wajib` enum('YA','TIDAK') DEFAULT 'YA',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_instansi_pendidikan`
--

CREATE TABLE `m_instansi_pendidikan` (
  `id_instansi_pendidikan` int(11) UNSIGNED NOT NULL,
  `id_jenjang_pendidikan` int(10) UNSIGNED NOT NULL,
  `instansi_pendidikan` varchar(255) NOT NULL,
  `jenis_instansi` enum('NEGERI','SWASTA') DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `status` enum('AKTIF','NONAKTIF') DEFAULT 'AKTIF',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_jenis_permohonan`
--

CREATE TABLE `m_jenis_permohonan` (
  `id_jenis_permohonan` int(11) UNSIGNED NOT NULL,
  `jenis_permohonan` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `durasi_minimal` smallint(5) UNSIGNED NOT NULL COMMENT 'Minimal lama kegiatan (hari)',
  `durasi_maksimal` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'Maksimal lama kegiatan (hari)',
  `maksimal_hari_pengajuan` smallint(5) UNSIGNED NOT NULL COMMENT 'Maksimal hari sebelum tanggal mulai',
  `durasi_permohonan` int(11) DEFAULT NULL COMMENT 'Durasi dalam hari',
  `menggunakan_kuota` enum('YA','TIDAK') DEFAULT 'YA',
  `menggunakan_logbook` enum('YA','TIDAK') DEFAULT 'YA',
  `status` enum('AKTIF','NONAKTIF') DEFAULT 'AKTIF',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_jenjang_pendidikan`
--

CREATE TABLE `m_jenjang_pendidikan` (
  `id_jenjang_pendidikan` int(10) UNSIGNED NOT NULL,
  `nama_jenjang` varchar(50) NOT NULL,
  `status` enum('AKTIF','NONAKTIF') DEFAULT 'AKTIF',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_kabupaten`
--

CREATE TABLE `m_kabupaten` (
  `id_kabupaten` int(10) UNSIGNED NOT NULL,
  `id_provinsi` int(10) UNSIGNED NOT NULL,
  `nama_kabupaten` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_kecamatan`
--

CREATE TABLE `m_kecamatan` (
  `id_kecamatan` int(10) UNSIGNED NOT NULL,
  `id_kabupaten` int(10) UNSIGNED NOT NULL,
  `nama_kecamatan` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_kelurahan`
--

CREATE TABLE `m_kelurahan` (
  `id_kelurahan` int(10) UNSIGNED NOT NULL,
  `id_kecamatan` int(10) UNSIGNED NOT NULL,
  `nama_kelurahan` varchar(100) NOT NULL,
  `kode_pos` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_komponen_penilaian`
--

CREATE TABLE `m_komponen_penilaian` (
  `id_komponen_penilaian` int(10) UNSIGNED NOT NULL,
  `komponen_penilaian` varchar(200) NOT NULL,
  `status_aktif` varchar(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_kuota`
--

CREATE TABLE `m_kuota` (
  `id_kuota` int(10) UNSIGNED NOT NULL,
  `id_bidang` int(10) UNSIGNED NOT NULL,
  `tahun` year(4) NOT NULL,
  `bulan` tinyint(4) NOT NULL,
  `kuota` int(11) NOT NULL,
  `status` enum('AKTIF','NONAKTIF') DEFAULT 'AKTIF',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_mahasiswa`
--

CREATE TABLE `m_mahasiswa` (
  `id_mahasiswa` int(11) UNSIGNED NOT NULL,
  `nik` varchar(16) NOT NULL,
  `nim` varchar(50) NOT NULL,
  `nama_mahasiswa` varchar(150) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tgl_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `rt` varchar(5) DEFAULT NULL,
  `rw` varchar(5) DEFAULT NULL,
  `id_kelurahan` char(10) DEFAULT NULL,
  `no_telp` varchar(20) NOT NULL,
  `id_instansi_mahasiswa` int(10) UNSIGNED NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_opd`
--

CREATE TABLE `m_opd` (
  `id_opd` int(11) UNSIGNED NOT NULL,
  `opd` varchar(255) NOT NULL,
  `singkatan` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(150) DEFAULT NULL,
  `status_aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_prodi`
--

CREATE TABLE `m_prodi` (
  `id_prodi` int(11) UNSIGNED NOT NULL,
  `id_fakultas` int(10) UNSIGNED NOT NULL,
  `nama_prodi` varchar(150) NOT NULL,
  `id_jenjang_pendidikan` int(10) UNSIGNED NOT NULL,
  `status` enum('AKTIF','NONAKTIF') DEFAULT 'AKTIF',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_provinsi`
--

CREATE TABLE `m_provinsi` (
  `id_provinsi` int(10) UNSIGNED NOT NULL,
  `kode_provinsi` varchar(10) NOT NULL,
  `nama_provinsi` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_user_mahasiswa`
--

CREATE TABLE `m_user_mahasiswa` (
  `id_user_mahasiswa` int(11) UNSIGNED NOT NULL,
  `id_mahasiswa` int(10) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('AKTIF','NONAKTIF') DEFAULT 'AKTIF',
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_file_permohonan_magang`
--

CREATE TABLE `t_file_permohonan_magang` (
  `id_file_permohonan_magang` int(10) UNSIGNED NOT NULL,
  `id_permohonan_magang` int(10) UNSIGNED NOT NULL,
  `id_file_permohonan` int(10) UNSIGNED NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `path_file` varchar(255) NOT NULL,
  `status_verifikasi` enum('MENUNGGU','SESUAI','TIDAK_SESUAI') DEFAULT 'MENUNGGU',
  `catatan_verifikasi` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_file_proses_magang`
--

CREATE TABLE `t_file_proses_magang` (
  `id_file_proses_magang` int(10) UNSIGNED NOT NULL,
  `id_persetujuan_magang` int(10) UNSIGNED NOT NULL,
  `id_file` int(10) UNSIGNED NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `path_file` varchar(255) NOT NULL,
  `proses_magang` enum('persetujuan','selesai') DEFAULT 'persetujuan',
  `status` enum('AKTIF','NONAKTIF') DEFAULT 'AKTIF',
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_instansi_mahasiswa`
--

CREATE TABLE `t_instansi_mahasiswa` (
  `id_instansi_mahasiswa` int(10) UNSIGNED NOT NULL,
  `id_mahasiswa` int(10) UNSIGNED NOT NULL,
  `id_instansi_pendidikan` int(10) UNSIGNED NOT NULL,
  `id_fakultas` int(10) UNSIGNED DEFAULT NULL,
  `id_prodi` int(10) UNSIGNED NOT NULL,
  `id_jenjang_pendidikan` int(10) UNSIGNED NOT NULL,
  `jurusan` varchar(150) DEFAULT NULL,
  `angkatan_tahun` varchar(4) DEFAULT NULL,
  `semester` varchar(10) DEFAULT NULL,
  `tahun_akademik` varchar(20) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_logbook_magang`
--

CREATE TABLE `t_logbook_magang` (
  `id_logbook_magang` int(10) UNSIGNED NOT NULL,
  `id_penempatan_magang` int(10) UNSIGNED NOT NULL,
  `logbook_magang` text NOT NULL,
  `bukti_kegiatan` varchar(255) DEFAULT NULL,
  `tgl_logbook` date NOT NULL,
  `jam_logbook` time NOT NULL,
  `status_logbook` enum('BELUM_DISETUJUI','DISETUJUI','DITOLAK') DEFAULT 'BELUM_DISETUJUI',
  `catatan_revisi` text DEFAULT NULL,
  `disetujui_oleh` int(10) UNSIGNED DEFAULT NULL,
  `file_tanda_tangan` varchar(255) DEFAULT NULL,
  `tgl_disetujui` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_log_permohonan`
--

CREATE TABLE `t_log_permohonan` (
  `id_log` int(10) UNSIGNED NOT NULL,
  `id_permohonan_magang` int(10) UNSIGNED NOT NULL,
  `aktor` varchar(100) NOT NULL,
  `aksi` varchar(150) NOT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_notifikasi`
--

CREATE TABLE `t_notifikasi` (
  `id_notifikasi` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `jenis` varchar(50) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `isi` text NOT NULL,
  `dibaca` enum('YA','TIDAK') DEFAULT 'TIDAK',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_penempatan_magang`
--

CREATE TABLE `t_penempatan_magang` (
  `id_penempatan_magang` int(10) UNSIGNED NOT NULL,
  `id_persetujuan_magang` int(10) UNSIGNED NOT NULL,
  `id_mahasiswa` int(10) UNSIGNED NOT NULL,
  `id_bidang` int(10) UNSIGNED NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `tanggal_persetujuan` datetime DEFAULT NULL,
  `status_penempatan` enum('MENUNGGU','BERJALAN','SELESAI','DIBATALKAN') DEFAULT 'MENUNGGU',
  `is_log_book` enum('YA','TIDAK') DEFAULT 'YA',
  `catatan` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_penilaian_magang`
--

CREATE TABLE `t_penilaian_magang` (
  `id_penilaian_magang` int(10) UNSIGNED NOT NULL,
  `id_penempatan_magang` int(11) NOT NULL,
  `id_komponen_penilaian` int(11) NOT NULL,
  `nilai` decimal(5,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_permohonan_magang`
--

CREATE TABLE `t_permohonan_magang` (
  `id_permohonan_magang` int(10) UNSIGNED NOT NULL,
  `id_mahasiswa` int(10) UNSIGNED NOT NULL,
  `id_instansi_mahasiswa` int(10) UNSIGNED NOT NULL,
  `id_jenis_permohonan` int(10) UNSIGNED NOT NULL,
  `tujuan` varchar(255) NOT NULL,
  `deskripsi_keahlian` text DEFAULT NULL COMMENT 'Keahlian yang dimiliki',
  `rencana_kegiatan` text DEFAULT NULL COMMENT 'Rencana kegiatan secara rinci',
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `posting_data` enum('draft','kirim') DEFAULT 'draft',
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_persetujuan_magang`
--

CREATE TABLE `t_persetujuan_magang` (
  `id_persetujuan_magang` int(10) UNSIGNED NOT NULL,
  `id_permohonan_magang` int(10) UNSIGNED NOT NULL,
  `id_bidang` int(10) UNSIGNED DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `status_persetujuan` enum('MENUNGGU','DISETUJUI','PERBAIKAN_BERKAS','DITOLAK') DEFAULT 'MENUNGGU',
  `disposisi` enum('BELUM','DIKIRIM','DITERIMA') DEFAULT 'BELUM',
  `tanggal_disposisi` datetime DEFAULT NULL,
  `tanggal_persetujuan` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `group` varchar(100) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `c_menus`
--
ALTER TABLE `c_menus`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_parent` (`id_parent`) USING BTREE,
  ADD KEY `status` (`status`) USING BTREE;

--
-- Indexes for table `c_user_group`
--
ALTER TABLE `c_user_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `c_user_pegawai`
--
ALTER TABLE `c_user_pegawai`
  ADD PRIMARY KEY (`id_user_pegawai`),
  ADD UNIQUE KEY `uk_nip` (`nip`),
  ADD KEY `idx_group` (`id_user_group`),
  ADD KEY `idx_bidang` (`id_bidang`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_bidang`
--
ALTER TABLE `m_bidang`
  ADD PRIMARY KEY (`id_bidang`),
  ADD KEY `idx_opd` (`id_opd`);

--
-- Indexes for table `m_fakultas`
--
ALTER TABLE `m_fakultas`
  ADD PRIMARY KEY (`id_fakultas`),
  ADD KEY `id_instansi_pendidikan` (`id_instansi_pendidikan`);

--
-- Indexes for table `m_file`
--
ALTER TABLE `m_file`
  ADD PRIMARY KEY (`id_file`);

--
-- Indexes for table `m_file_permohonan`
--
ALTER TABLE `m_file_permohonan`
  ADD PRIMARY KEY (`id_file_permohonan`),
  ADD KEY `idx_permohonan` (`id_jenis_permohonan`),
  ADD KEY `idx_file` (`id_file`);

--
-- Indexes for table `m_instansi_pendidikan`
--
ALTER TABLE `m_instansi_pendidikan`
  ADD PRIMARY KEY (`id_instansi_pendidikan`),
  ADD KEY `idx_jenjang` (`id_jenjang_pendidikan`);

--
-- Indexes for table `m_jenis_permohonan`
--
ALTER TABLE `m_jenis_permohonan`
  ADD PRIMARY KEY (`id_jenis_permohonan`),
  ADD UNIQUE KEY `uk_permohonan` (`jenis_permohonan`);

--
-- Indexes for table `m_jenjang_pendidikan`
--
ALTER TABLE `m_jenjang_pendidikan`
  ADD PRIMARY KEY (`id_jenjang_pendidikan`),
  ADD UNIQUE KEY `uk_jenjang` (`nama_jenjang`);

--
-- Indexes for table `m_kabupaten`
--
ALTER TABLE `m_kabupaten`
  ADD PRIMARY KEY (`id_kabupaten`),
  ADD KEY `idx_provinsi` (`id_provinsi`);

--
-- Indexes for table `m_kecamatan`
--
ALTER TABLE `m_kecamatan`
  ADD PRIMARY KEY (`id_kecamatan`),
  ADD KEY `idx_kabupaten` (`id_kabupaten`);

--
-- Indexes for table `m_kelurahan`
--
ALTER TABLE `m_kelurahan`
  ADD PRIMARY KEY (`id_kelurahan`),
  ADD KEY `idx_kecamatan` (`id_kecamatan`);

--
-- Indexes for table `m_kuota`
--
ALTER TABLE `m_kuota`
  ADD PRIMARY KEY (`id_kuota`),
  ADD KEY `idx_bidang` (`id_bidang`);

--
-- Indexes for table `m_mahasiswa`
--
ALTER TABLE `m_mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`),
  ADD UNIQUE KEY `uk_nik` (`nik`),
  ADD UNIQUE KEY `uk_nim` (`nim`),
  ADD UNIQUE KEY `uk_email` (`email`),
  ADD KEY `m_mahasiswa_id_instansi_mahasiswa_foreign` (`id_instansi_mahasiswa`);

--
-- Indexes for table `m_opd`
--
ALTER TABLE `m_opd`
  ADD PRIMARY KEY (`id_opd`),
  ADD UNIQUE KEY `uk_nama_opd` (`opd`);

--
-- Indexes for table `m_prodi`
--
ALTER TABLE `m_prodi`
  ADD PRIMARY KEY (`id_prodi`),
  ADD KEY `id_fakultas` (`id_fakultas`),
  ADD KEY `t_prodi_ibfk_3` (`id_jenjang_pendidikan`);

--
-- Indexes for table `m_provinsi`
--
ALTER TABLE `m_provinsi`
  ADD PRIMARY KEY (`id_provinsi`),
  ADD UNIQUE KEY `uk_kode_provinsi` (`kode_provinsi`),
  ADD KEY `idx_nama_provinsi` (`nama_provinsi`);

--
-- Indexes for table `m_user_mahasiswa`
--
ALTER TABLE `m_user_mahasiswa`
  ADD PRIMARY KEY (`id_user_mahasiswa`),
  ADD UNIQUE KEY `uk_username` (`username`),
  ADD UNIQUE KEY `uk_user_mahasiswa` (`username`),
  ADD KEY `fk_user_mahasiswa` (`id_mahasiswa`);

--
-- Indexes for table `t_file_permohonan_magang`
--
ALTER TABLE `t_file_permohonan_magang`
  ADD PRIMARY KEY (`id_file_permohonan_magang`),
  ADD KEY `idx_permohonan` (`id_permohonan_magang`),
  ADD KEY `idx_file` (`id_file_permohonan`);

--
-- Indexes for table `t_file_proses_magang`
--
ALTER TABLE `t_file_proses_magang`
  ADD PRIMARY KEY (`id_file_proses_magang`),
  ADD KEY `fk_tfproses_persetujuan` (`id_persetujuan_magang`),
  ADD KEY `fk_tfproses_file` (`id_file`);

--
-- Indexes for table `t_instansi_mahasiswa`
--
ALTER TABLE `t_instansi_mahasiswa`
  ADD PRIMARY KEY (`id_instansi_mahasiswa`),
  ADD UNIQUE KEY `uk_mahasiswa_instansi` (`id_mahasiswa`),
  ADD KEY `idx_mahasiswa` (`id_mahasiswa`),
  ADD KEY `idx_instansi` (`id_instansi_pendidikan`),
  ADD KEY `idx_fakultas` (`id_fakultas`),
  ADD KEY `idx_prodi` (`id_prodi`),
  ADD KEY `idx_jenjang` (`id_jenjang_pendidikan`);

--
-- Indexes for table `t_logbook_magang`
--
ALTER TABLE `t_logbook_magang`
  ADD PRIMARY KEY (`id_logbook_magang`),
  ADD KEY `idx_penempatan` (`id_penempatan_magang`),
  ADD KEY `idx_status` (`status_logbook`),
  ADD KEY `idx_logbook_tanggal` (`tgl_logbook`),
  ADD KEY `idx_logbook_status` (`status_logbook`);

--
-- Indexes for table `t_log_permohonan`
--
ALTER TABLE `t_log_permohonan`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `idx_permohonan` (`id_permohonan_magang`);

--
-- Indexes for table `t_notifikasi`
--
ALTER TABLE `t_notifikasi`
  ADD PRIMARY KEY (`id_notifikasi`),
  ADD KEY `idx_user` (`id_user`),
  ADD KEY `idx_dibaca` (`dibaca`);

--
-- Indexes for table `t_penempatan_magang`
--
ALTER TABLE `t_penempatan_magang`
  ADD PRIMARY KEY (`id_penempatan_magang`),
  ADD KEY `idx_bidang` (`id_bidang`),
  ADD KEY `idx_persetujuan` (`id_persetujuan_magang`),
  ADD KEY `fk_penempatan_mahasiswa` (`id_mahasiswa`),
  ADD KEY `idx_status_penempatan` (`status_penempatan`),
  ADD KEY `idx_tanggal_persetujuan` (`tanggal_persetujuan`);

--
-- Indexes for table `t_permohonan_magang`
--
ALTER TABLE `t_permohonan_magang`
  ADD PRIMARY KEY (`id_permohonan_magang`),
  ADD KEY `idx_mahasiswa` (`id_mahasiswa`),
  ADD KEY `idx_instansi` (`id_instansi_mahasiswa`),
  ADD KEY `idx_jenis` (`id_jenis_permohonan`),
  ADD KEY `idx_permohonan_tanggal` (`created_at`),
  ADD KEY `idx_permohonan_mulai` (`tgl_mulai`),
  ADD KEY `idx_permohonan_selesai` (`tgl_selesai`);

--
-- Indexes for table `t_persetujuan_magang`
--
ALTER TABLE `t_persetujuan_magang`
  ADD PRIMARY KEY (`id_persetujuan_magang`),
  ADD KEY `idx_permohonan` (`id_permohonan_magang`),
  ADD KEY `idx_bidang` (`id_bidang`),
  ADD KEY `idx_status_persetujuan` (`status_persetujuan`),
  ADD KEY `idx_disposisi` (`disposisi`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `c_menus`
--
ALTER TABLE `c_menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `c_user_group`
--
ALTER TABLE `c_user_group`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `c_user_pegawai`
--
ALTER TABLE `c_user_pegawai`
  MODIFY `id_user_pegawai` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_bidang`
--
ALTER TABLE `m_bidang`
  MODIFY `id_bidang` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_fakultas`
--
ALTER TABLE `m_fakultas`
  MODIFY `id_fakultas` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_file`
--
ALTER TABLE `m_file`
  MODIFY `id_file` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_file_permohonan`
--
ALTER TABLE `m_file_permohonan`
  MODIFY `id_file_permohonan` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_instansi_pendidikan`
--
ALTER TABLE `m_instansi_pendidikan`
  MODIFY `id_instansi_pendidikan` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_jenis_permohonan`
--
ALTER TABLE `m_jenis_permohonan`
  MODIFY `id_jenis_permohonan` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_jenjang_pendidikan`
--
ALTER TABLE `m_jenjang_pendidikan`
  MODIFY `id_jenjang_pendidikan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_kabupaten`
--
ALTER TABLE `m_kabupaten`
  MODIFY `id_kabupaten` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_kecamatan`
--
ALTER TABLE `m_kecamatan`
  MODIFY `id_kecamatan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_kelurahan`
--
ALTER TABLE `m_kelurahan`
  MODIFY `id_kelurahan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_kuota`
--
ALTER TABLE `m_kuota`
  MODIFY `id_kuota` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_mahasiswa`
--
ALTER TABLE `m_mahasiswa`
  MODIFY `id_mahasiswa` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_opd`
--
ALTER TABLE `m_opd`
  MODIFY `id_opd` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_prodi`
--
ALTER TABLE `m_prodi`
  MODIFY `id_prodi` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_provinsi`
--
ALTER TABLE `m_provinsi`
  MODIFY `id_provinsi` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_user_mahasiswa`
--
ALTER TABLE `m_user_mahasiswa`
  MODIFY `id_user_mahasiswa` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_file_permohonan_magang`
--
ALTER TABLE `t_file_permohonan_magang`
  MODIFY `id_file_permohonan_magang` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_file_proses_magang`
--
ALTER TABLE `t_file_proses_magang`
  MODIFY `id_file_proses_magang` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_instansi_mahasiswa`
--
ALTER TABLE `t_instansi_mahasiswa`
  MODIFY `id_instansi_mahasiswa` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_logbook_magang`
--
ALTER TABLE `t_logbook_magang`
  MODIFY `id_logbook_magang` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_log_permohonan`
--
ALTER TABLE `t_log_permohonan`
  MODIFY `id_log` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_notifikasi`
--
ALTER TABLE `t_notifikasi`
  MODIFY `id_notifikasi` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_penempatan_magang`
--
ALTER TABLE `t_penempatan_magang`
  MODIFY `id_penempatan_magang` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_permohonan_magang`
--
ALTER TABLE `t_permohonan_magang`
  MODIFY `id_permohonan_magang` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_persetujuan_magang`
--
ALTER TABLE `t_persetujuan_magang`
  MODIFY `id_persetujuan_magang` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `c_user_pegawai`
--
ALTER TABLE `c_user_pegawai`
  ADD CONSTRAINT `fk_user_bidang` FOREIGN KEY (`id_bidang`) REFERENCES `m_bidang` (`id_bidang`),
  ADD CONSTRAINT `fk_user_group` FOREIGN KEY (`id_user_group`) REFERENCES `c_user_group` (`id`);

--
-- Constraints for table `m_bidang`
--
ALTER TABLE `m_bidang`
  ADD CONSTRAINT `fk_bidang_opd` FOREIGN KEY (`id_opd`) REFERENCES `m_opd` (`id_opd`) ON UPDATE CASCADE,
  ADD CONSTRAINT `m_bidang_id_opd_foreign` FOREIGN KEY (`id_opd`) REFERENCES `m_opd` (`id_opd`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `m_fakultas`
--
ALTER TABLE `m_fakultas`
  ADD CONSTRAINT `ib_fk_m_fakultas` FOREIGN KEY (`id_instansi_pendidikan`) REFERENCES `m_instansi_pendidikan` (`id_instansi_pendidikan`);

--
-- Constraints for table `m_file_permohonan`
--
ALTER TABLE `m_file_permohonan`
  ADD CONSTRAINT `m_file_permohonan_id_file_foreign` FOREIGN KEY (`id_file`) REFERENCES `m_file` (`id_file`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `m_file_permohonan_id_jenis_permohonan_foreign` FOREIGN KEY (`id_jenis_permohonan`) REFERENCES `m_jenis_permohonan` (`id_jenis_permohonan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `m_instansi_pendidikan`
--
ALTER TABLE `m_instansi_pendidikan`
  ADD CONSTRAINT `fk_instansi_jenjang` FOREIGN KEY (`id_jenjang_pendidikan`) REFERENCES `m_jenjang_pendidikan` (`id_jenjang_pendidikan`) ON UPDATE CASCADE;

--
-- Constraints for table `m_kabupaten`
--
ALTER TABLE `m_kabupaten`
  ADD CONSTRAINT `fk_kabupaten_provinsi` FOREIGN KEY (`id_provinsi`) REFERENCES `m_provinsi` (`id_provinsi`) ON UPDATE CASCADE;

--
-- Constraints for table `m_kecamatan`
--
ALTER TABLE `m_kecamatan`
  ADD CONSTRAINT `fk_kecamatan_kabupaten` FOREIGN KEY (`id_kabupaten`) REFERENCES `m_kabupaten` (`id_kabupaten`) ON UPDATE CASCADE;

--
-- Constraints for table `m_kelurahan`
--
ALTER TABLE `m_kelurahan`
  ADD CONSTRAINT `fk_kelurahan_kecamatan` FOREIGN KEY (`id_kecamatan`) REFERENCES `m_kecamatan` (`id_kecamatan`) ON UPDATE CASCADE;

--
-- Constraints for table `m_kuota`
--
ALTER TABLE `m_kuota`
  ADD CONSTRAINT `fk_kuota_bidang` FOREIGN KEY (`id_bidang`) REFERENCES `m_bidang` (`id_bidang`) ON UPDATE CASCADE;

--
-- Constraints for table `m_mahasiswa`
--
ALTER TABLE `m_mahasiswa`
  ADD CONSTRAINT `m_mahasiswa_id_instansi_mahasiswa_foreign` FOREIGN KEY (`id_instansi_mahasiswa`) REFERENCES `t_instansi_mahasiswa` (`id_instansi_mahasiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `m_prodi`
--
ALTER TABLE `m_prodi`
  ADD CONSTRAINT `fk_prodi_fakultas` FOREIGN KEY (`id_fakultas`) REFERENCES `m_fakultas` (`id_fakultas`) ON UPDATE CASCADE,
  ADD CONSTRAINT `m_prodi_id_fakultas_foreign` FOREIGN KEY (`id_fakultas`) REFERENCES `m_fakultas` (`id_fakultas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_prodi_ibfk_3` FOREIGN KEY (`id_jenjang_pendidikan`) REFERENCES `m_jenjang_pendidikan` (`id_jenjang_pendidikan`);

--
-- Constraints for table `m_user_mahasiswa`
--
ALTER TABLE `m_user_mahasiswa`
  ADD CONSTRAINT `fk_user_mahasiswa` FOREIGN KEY (`id_mahasiswa`) REFERENCES `m_mahasiswa` (`id_mahasiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_file_permohonan_magang`
--
ALTER TABLE `t_file_permohonan_magang`
  ADD CONSTRAINT `fk_file_permohonan` FOREIGN KEY (`id_permohonan_magang`) REFERENCES `t_permohonan_magang` (`id_permohonan_magang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tfpm_file_permohonan` FOREIGN KEY (`id_file_permohonan`) REFERENCES `m_file_permohonan` (`id_file_permohonan`) ON UPDATE CASCADE;

--
-- Constraints for table `t_file_proses_magang`
--
ALTER TABLE `t_file_proses_magang`
  ADD CONSTRAINT `fk_tfproses_file` FOREIGN KEY (`id_file`) REFERENCES `m_file` (`id_file`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tfproses_persetujuan` FOREIGN KEY (`id_persetujuan_magang`) REFERENCES `t_persetujuan_magang` (`id_persetujuan_magang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_instansi_mahasiswa`
--
ALTER TABLE `t_instansi_mahasiswa`
  ADD CONSTRAINT `fk_tim_fakultas` FOREIGN KEY (`id_fakultas`) REFERENCES `m_fakultas` (`id_fakultas`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tim_instansi` FOREIGN KEY (`id_instansi_pendidikan`) REFERENCES `m_instansi_pendidikan` (`id_instansi_pendidikan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tim_jenjang` FOREIGN KEY (`id_jenjang_pendidikan`) REFERENCES `m_jenjang_pendidikan` (`id_jenjang_pendidikan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tim_mahasiswa` FOREIGN KEY (`id_mahasiswa`) REFERENCES `m_mahasiswa` (`id_mahasiswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tim_prodi` FOREIGN KEY (`id_prodi`) REFERENCES `m_prodi` (`id_prodi`) ON UPDATE CASCADE;

--
-- Constraints for table `t_logbook_magang`
--
ALTER TABLE `t_logbook_magang`
  ADD CONSTRAINT `fk_logbook_penempatan` FOREIGN KEY (`id_penempatan_magang`) REFERENCES `t_penempatan_magang` (`id_penempatan_magang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_log_permohonan`
--
ALTER TABLE `t_log_permohonan`
  ADD CONSTRAINT `fk_log_permohonan` FOREIGN KEY (`id_permohonan_magang`) REFERENCES `t_permohonan_magang` (`id_permohonan_magang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_penempatan_magang`
--
ALTER TABLE `t_penempatan_magang`
  ADD CONSTRAINT `fk_penempatan_bidang` FOREIGN KEY (`id_bidang`) REFERENCES `m_bidang` (`id_bidang`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_penempatan_mahasiswa` FOREIGN KEY (`id_mahasiswa`) REFERENCES `m_mahasiswa` (`id_mahasiswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_penempatan_persetujuan` FOREIGN KEY (`id_persetujuan_magang`) REFERENCES `t_persetujuan_magang` (`id_persetujuan_magang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_permohonan_magang`
--
ALTER TABLE `t_permohonan_magang`
  ADD CONSTRAINT `fk_permohonan_instansi` FOREIGN KEY (`id_instansi_mahasiswa`) REFERENCES `t_instansi_mahasiswa` (`id_instansi_mahasiswa`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_permohonan_jenis` FOREIGN KEY (`id_jenis_permohonan`) REFERENCES `m_jenis_permohonan` (`id_jenis_permohonan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_permohonan_mahasiswa` FOREIGN KEY (`id_mahasiswa`) REFERENCES `m_mahasiswa` (`id_mahasiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_persetujuan_magang`
--
ALTER TABLE `t_persetujuan_magang`
  ADD CONSTRAINT `fk_persetujuan_bidang` FOREIGN KEY (`id_bidang`) REFERENCES `m_bidang` (`id_bidang`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_persetujuan_permohonan` FOREIGN KEY (`id_permohonan_magang`) REFERENCES `t_permohonan_magang` (`id_permohonan_magang`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
