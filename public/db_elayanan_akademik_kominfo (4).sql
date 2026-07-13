-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2026 at 04:46 AM
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
-- Database: `db_elayanan_akademik_kominfo`
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

--
-- Dumping data for table `c_menus`
--

INSERT INTO `c_menus` (`id`, `id_parent`, `name`, `url`, `position`, `icon`, `status`, `target_blank`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, NULL, 'Dashboard', 'dashboard', 1, 'mdi mdi-monitor-dashboard', 1, 0, '2026-03-10 10:16:26', NULL, '2026-03-10 10:16:26', NULL),
(2, NULL, 'System Setting', '#', 50, 'mdi mdi-cog-outline', 1, 0, '2026-03-10 10:16:26', NULL, '2026-03-10 10:16:26', NULL),
(3, 2, 'Menu Admin', 'menu-admin', 1, '', 1, 0, '2026-03-10 10:16:26', NULL, '2026-03-10 10:16:26', NULL),
(4, 2, 'Set Privileges', 'previleges', 2, '', 1, 0, '2026-03-10 10:16:26', NULL, '2026-03-10 10:16:26', NULL),
(5, 2, 'Users', 'users', 3, '', 1, 0, '2026-03-10 10:16:26', NULL, '2026-03-10 10:16:26', NULL),
(6, 2, 'Profile', 'setting-profile', 4, '', 1, 0, '2026-03-10 10:16:26', NULL, '2026-03-10 10:16:26', NULL),
(7, NULL, 'Data Master', '#', 49, 'mdi mdi-database-cog-outline', 1, 0, '2026-03-10 10:16:26', NULL, '2026-03-10 10:16:26', NULL),
(8, 7, 'Sekolah', 'master-sekolah', 1, '', 1, 0, '2026-03-10 10:16:26', NULL, '0000-00-00 00:00:00', NULL),
(9, 2, 'Jadwal Pelaksanaan', 'jadwal-pelaksanaan', 5, '', 1, 0, '0000-00-00 00:00:00', NULL, '2026-03-26 09:27:35', NULL),
(10, 7, 'Daya Tampung', 'master-daya-tampung', 2, '', 1, 0, '0000-00-00 00:00:00', NULL, '2026-04-09 15:21:30', NULL);

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

--
-- Dumping data for table `c_menus_privileges`
--

INSERT INTO `c_menus_privileges` (`id`, `id_user_group`, `id_menu`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-04-15 10:52:27', NULL),
(2, 1, 7, '2026-04-15 10:52:27', NULL),
(3, 1, 8, '2026-04-15 10:52:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `c_user_group`
--

CREATE TABLE `c_user_group` (
  `id` int(10) UNSIGNED NOT NULL,
  `group` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=aktif, 0=tidak aktif',
  `created_at` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL COMMENT 'id_user',
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL COMMENT 'id_user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `c_user_group`
--

INSERT INTO `c_user_group` (`id`, `group`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Superadmin', 1, '2026-03-10 10:16:26', NULL, '2026-04-15 10:59:01', 1),
(2, 'Bidang Seketariat', 1, '2026-03-10 10:16:26', NULL, '2026-04-15 10:59:27', 1),
(3, 'Bidang E-Gov', 1, '2026-03-10 10:16:26', NULL, '2026-03-27 10:22:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `c_user_pegawai`
--

CREATE TABLE `c_user_pegawai` (
  `id_user_pegawai` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL COMMENT 'untuk user non asn, jika terisi maka non asn',
  `nama_user` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=aktif, 0=tidak aktif',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL COMMENT 'id_user',
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL COMMENT 'id_user',
  `last_login` datetime DEFAULT NULL,
  `kode_path` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `c_user_pegawai`
--

INSERT INTO `c_user_pegawai` (`id_user_pegawai`, `group_id`, `username`, `password`, `nama_user`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `last_login`, `kode_path`) VALUES
(1, 1, 'superadmin', '$2y$10$7p59wY4D3V2RaLsMreFZxORDTiPxIwug5gXBjrOGYDvUKJAdjDakG', 'superadmin', 1, '2026-03-10 10:28:22', 1, '2026-03-10 10:28:22', 1, '2026-06-30 09:27:50', NULL),
(2, 1, 'sekretariat', '$2y$10$7p59wY4D3V2RaLsMreFZxORDTiPxIwug5gXBjrOGYDvUKJAdjDakG', 'sekretariat', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 2, 'kabid', '$2y$10$7p59wY4D3V2RaLsMreFZxORDTiPxIwug5gXBjrOGYDvUKJAdjDakG', 'kabid', 1, NULL, NULL, NULL, NULL, NULL, NULL);

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
  `id_bidang` int(11) NOT NULL,
  `bidang` varchar(150) NOT NULL,
  `status_aktif` varchar(20) DEFAULT 'aktif',
  `id_opd` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_bidang`
--

INSERT INTO `m_bidang` (`id_bidang`, `bidang`, `status_aktif`, `id_opd`) VALUES
(2, 'Bidang Pengembangan e-Government', 'aktif', 1),
(3, 'Bidang Diseminasi Informasi dan Komunikasi Publik', 'aktif', 1),
(4, 'Bidang Sarana dan Prasarana TIK dan Persandian', 'aktif', 1),
(5, 'Bidang Statistik dan Pemberdayaan TIK ', 'aktif', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_fakultas`
--

CREATE TABLE `m_fakultas` (
  `id_fakultas` int(11) NOT NULL,
  `fakultas` varchar(150) NOT NULL,
  `status` varchar(20) DEFAULT 'aktif',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_file`
--

CREATE TABLE `m_file` (
  `id_file` int(11) NOT NULL,
  `nama_file` varchar(100) NOT NULL,
  `status_aktif` varchar(20) DEFAULT 'aktif',
  `id_jenis_permohonan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_instansi_pendidikan`
--

CREATE TABLE `m_instansi_pendidikan` (
  `id_instansi_pendidikan` int(11) NOT NULL,
  `instansi_pendidikan` varchar(250) NOT NULL,
  `jenis_instansi` enum('negeri','swasta') NOT NULL,
  `status` varchar(20) DEFAULT 'aktif',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_jenis_permohonan`
--

CREATE TABLE `m_jenis_permohonan` (
  `id_jenis_permohonan` int(11) NOT NULL,
  `jenis_permohonan` varchar(100) NOT NULL,
  `status` varchar(20) DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_jenis_permohonan`
--

INSERT INTO `m_jenis_permohonan` (`id_jenis_permohonan`, `jenis_permohonan`, `status`) VALUES
(1, 'Penelitian Skripsi/TA', 'aktif'),
(2, 'Observasi/Pengambilan Data', 'aktif'),
(3, 'Magang/PKL', 'aktif'),
(4, 'Uji Coba Produk (Prototype)', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `m_komponen_penilaian`
--

CREATE TABLE `m_komponen_penilaian` (
  `id_komponen_penilaian` int(11) NOT NULL,
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
  `id_kuota` int(11) NOT NULL,
  `id_bidang` int(11) NOT NULL,
  `kuota` int(11) NOT NULL,
  `status_aktif` varchar(20) DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_mahasiswa`
--

CREATE TABLE `m_mahasiswa` (
  `id_mahasiswa` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `nama_mahasiswa` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `rt` varchar(5) DEFAULT NULL,
  `rw` varchar(5) DEFAULT NULL,
  `kelurahan` varchar(50) DEFAULT NULL,
  `kecamatan` varchar(50) DEFAULT NULL,
  `provinsi` varchar(50) DEFAULT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `id_instansi_mahasiswa` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_mahasiswa`
--

INSERT INTO `m_mahasiswa` (`id_mahasiswa`, `nim`, `nama_mahasiswa`, `jenis_kelamin`, `tgl_lahir`, `alamat`, `rt`, `rw`, `kelurahan`, `kecamatan`, `provinsi`, `no_telp`, `email`, `id_instansi_mahasiswa`, `created_at`, `updated_at`) VALUES
(0, '1020', 'danu putra', 'L', '2026-07-06', 'wffefe', '01', '04', 'Buaran Indah', 'Tangerang', 'Banten', '081218501063', 'abijaksana87@gmail.com', 1, '2026-07-06 01:46:44', '2026-07-06 01:46:44'),
(1, '1202220001', 'Danu Putra', 'L', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'danu@example.com', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_opd`
--

CREATE TABLE `m_opd` (
  `id_opd` int(11) NOT NULL,
  `opd` varchar(150) NOT NULL,
  `status_aktif` varchar(20) DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_opd`
--

INSERT INTO `m_opd` (`id_opd`, `opd`, `status_aktif`) VALUES
(1, 'Dinas Komunikasi dan Informatika', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `m_prodi`
--

CREATE TABLE `m_prodi` (
  `id_prodi` int(11) NOT NULL,
  `id_fakultas` int(11) NOT NULL,
  `prodi` varchar(150) NOT NULL,
  `status` varchar(20) DEFAULT 'aktif',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_user_mahasiswa`
--

CREATE TABLE `m_user_mahasiswa` (
  `id_user_mahasiswa` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(20) DEFAULT 'aktif',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_user_mahasiswa`
--

INSERT INTO `m_user_mahasiswa` (`id_user_mahasiswa`, `id_mahasiswa`, `username`, `password`, `status`, `created_at`, `updated_at`) VALUES
(0, 0, 'danu123', '$2y$10$Ggi4WvOrvrx3qC0l5mIJvuY0sw4Zof7W99eLdX80MvYWfX4/QDlyS', 'AKTIF', '2026-07-06 01:46:45', '2026-07-06 01:46:45'),
(1, 1, 'danu', '12345', 'aktif', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_file_permohonan_magang`
--

CREATE TABLE `t_file_permohonan_magang` (
  `id_file_permohonan_magang` int(11) NOT NULL,
  `id_permohonan_magang` int(11) NOT NULL,
  `id_file` int(11) DEFAULT NULL,
  `nama_file` varchar(255) NOT NULL,
  `path_file` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_instansi_mahasiswa`
--

CREATE TABLE `t_instansi_mahasiswa` (
  `id_instansi_mahasiswa` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `id_instansi_pendidikan` int(11) NOT NULL,
  `id_prodi` int(11) NOT NULL,
  `jenjang_pendidikan` varchar(50) DEFAULT NULL,
  `angkatan_tahun` year(4) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `tahun_akademik` varchar(20) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_logbook_magang`
--

CREATE TABLE `t_logbook_magang` (
  `id_logbook_magang` int(11) NOT NULL,
  `id_penempatan_magang` int(11) NOT NULL,
  `logbook_magang` text NOT NULL,
  `tgl_logbook` date NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `disetujui_oleh` int(11) DEFAULT NULL,
  `file_tanda_tangan` varchar(255) DEFAULT NULL,
  `tgl_disetujui` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_penempatan_magang`
--

CREATE TABLE `t_penempatan_magang` (
  `id_penempatan_magang` int(11) NOT NULL,
  `id_bidang` int(11) DEFAULT NULL,
  `id_persetujuan_magang` int(11) DEFAULT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `status_penempatan` enum('BERJALAN','SELESAI','DIBATALKAN') DEFAULT 'BERJALAN',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_penempatan_magang`
--

INSERT INTO `t_penempatan_magang` (`id_penempatan_magang`, `id_bidang`, `id_persetujuan_magang`, `id_mahasiswa`, `catatan`, `status_penempatan`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(0, NULL, NULL, 0, '1212122121', 'BERJALAN', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_penilaian_magang`
--

CREATE TABLE `t_penilaian_magang` (
  `id_penilaian_magang` int(11) NOT NULL,
  `id_penempatan_magang` int(11) NOT NULL,
  `id_komponen_penilaian` int(11) DEFAULT NULL,
  `nilai` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_permohonan_magang`
--

CREATE TABLE `t_permohonan_magang` (
  `id_permohonan_magang` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `id_instansi_mahasiswa` int(11) DEFAULT NULL,
  `id_jenis_permohonan` int(11) DEFAULT NULL,
  `deskripsi_keahlian` text DEFAULT NULL,
  `deskripsi_magang` text DEFAULT NULL,
  `tgl_mulai` date DEFAULT NULL,
  `tgl_selesai` date DEFAULT NULL,
  `posting_data` enum('draft','kirim') DEFAULT 'draft',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_permohonan_magang`
--

INSERT INTO `t_permohonan_magang` (`id_permohonan_magang`, `id_mahasiswa`, `id_instansi_mahasiswa`, `id_jenis_permohonan`, `deskripsi_keahlian`, `deskripsi_magang`, `tgl_mulai`, `tgl_selesai`, `posting_data`, `created_at`, `updated_at`) VALUES
(0, 0, 1, 3, 'aafa', 'efefeef', '2026-07-06', '2026-08-31', 'kirim', '2026-07-06 01:49:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_persetujuan_magang`
--

CREATE TABLE `t_persetujuan_magang` (
  `id_persetujuan_magang` int(11) NOT NULL,
  `id_permohonan_magang` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `status_persetujuan` enum('MENUNGGU','DISETUJUI','DITOLAK') DEFAULT 'MENUNGGU',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `disposisi` enum('0','1','2') DEFAULT NULL,
  `id_bidang` int(11) DEFAULT NULL,
  `tgl_persetujuan` date DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_persetujuan_magang`
--

INSERT INTO `t_persetujuan_magang` (`id_persetujuan_magang`, `id_permohonan_magang`, `catatan`, `status_persetujuan`, `created_by`, `updated_by`, `disposisi`, `id_bidang`, `tgl_persetujuan`, `updated_at`) VALUES
(1, 0, '', 'DISETUJUI', 2, 2, '1', 2, '2026-07-06', '2026-07-07 08:19:43');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `group` varchar(100) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `group`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Superadmin', '1', '2026-07-05 12:41:00', NULL, NULL, NULL),
(2, 'Bidang Seketariat', '1', '2026-07-05 12:41:00', NULL, NULL, NULL),
(3, 'Bidang E-Gov', '1', '2026-07-05 12:41:00', NULL, NULL, NULL);

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
-- Indexes for table `c_menus_privileges`
--
ALTER TABLE `c_menus_privileges`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_user_group` (`id_user_group`) USING BTREE,
  ADD KEY `id_menu` (`id_menu`) USING BTREE;

--
-- Indexes for table `c_user_group`
--
ALTER TABLE `c_user_group`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `status` (`status`) USING BTREE;

--
-- Indexes for table `c_user_pegawai`
--
ALTER TABLE `c_user_pegawai`
  ADD PRIMARY KEY (`id_user_pegawai`) USING BTREE,
  ADD UNIQUE KEY `username` (`username`) USING BTREE,
  ADD KEY `group_id` (`group_id`) USING BTREE,
  ADD KEY `status` (`status`) USING BTREE;

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
  ADD KEY `fk_bidang_opd` (`id_opd`);

--
-- Indexes for table `m_fakultas`
--
ALTER TABLE `m_fakultas`
  ADD PRIMARY KEY (`id_fakultas`);

--
-- Indexes for table `m_file`
--
ALTER TABLE `m_file`
  ADD PRIMARY KEY (`id_file`),
  ADD KEY `fk_file_jenis_permohonan` (`id_jenis_permohonan`);

--
-- Indexes for table `m_instansi_pendidikan`
--
ALTER TABLE `m_instansi_pendidikan`
  ADD PRIMARY KEY (`id_instansi_pendidikan`);

--
-- Indexes for table `m_jenis_permohonan`
--
ALTER TABLE `m_jenis_permohonan`
  ADD PRIMARY KEY (`id_jenis_permohonan`);

--
-- Indexes for table `m_komponen_penilaian`
--
ALTER TABLE `m_komponen_penilaian`
  ADD PRIMARY KEY (`id_komponen_penilaian`);

--
-- Indexes for table `m_kuota`
--
ALTER TABLE `m_kuota`
  ADD PRIMARY KEY (`id_kuota`),
  ADD KEY `fk_kuota_bidang` (`id_bidang`);

--
-- Indexes for table `m_mahasiswa`
--
ALTER TABLE `m_mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`);

--
-- Indexes for table `m_opd`
--
ALTER TABLE `m_opd`
  ADD PRIMARY KEY (`id_opd`);

--
-- Indexes for table `m_prodi`
--
ALTER TABLE `m_prodi`
  ADD PRIMARY KEY (`id_prodi`),
  ADD KEY `fk_prodi_fakultas` (`id_fakultas`);

--
-- Indexes for table `m_user_mahasiswa`
--
ALTER TABLE `m_user_mahasiswa`
  ADD PRIMARY KEY (`id_user_mahasiswa`),
  ADD KEY `fk_user_mahasiswa` (`id_mahasiswa`);

--
-- Indexes for table `t_file_permohonan_magang`
--
ALTER TABLE `t_file_permohonan_magang`
  ADD PRIMARY KEY (`id_file_permohonan_magang`),
  ADD KEY `fk_file_permohonan` (`id_permohonan_magang`);

--
-- Indexes for table `t_instansi_mahasiswa`
--
ALTER TABLE `t_instansi_mahasiswa`
  ADD PRIMARY KEY (`id_instansi_mahasiswa`),
  ADD KEY `id_instansi_pendidikan` (`id_instansi_pendidikan`),
  ADD KEY `id_prodi` (`id_prodi`);

--
-- Indexes for table `t_logbook_magang`
--
ALTER TABLE `t_logbook_magang`
  ADD PRIMARY KEY (`id_logbook_magang`),
  ADD KEY `fk_logbook_penempatan` (`id_penempatan_magang`);

--
-- Indexes for table `t_penempatan_magang`
--
ALTER TABLE `t_penempatan_magang`
  ADD PRIMARY KEY (`id_penempatan_magang`),
  ADD KEY `fk_penempatan_mahasiswa` (`id_mahasiswa`);

--
-- Indexes for table `t_permohonan_magang`
--
ALTER TABLE `t_permohonan_magang`
  ADD PRIMARY KEY (`id_permohonan_magang`),
  ADD KEY `id_jenis_permohonan` (`id_jenis_permohonan`);

--
-- Indexes for table `t_persetujuan_magang`
--
ALTER TABLE `t_persetujuan_magang`
  ADD PRIMARY KEY (`id_persetujuan_magang`),
  ADD KEY `id_bidang` (`id_bidang`),
  ADD KEY `id_permohonan_magang` (`id_permohonan_magang`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `c_menus_privileges`
--
ALTER TABLE `c_menus_privileges`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=216;

--
-- AUTO_INCREMENT for table `c_user_group`
--
ALTER TABLE `c_user_group`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `c_user_pegawai`
--
ALTER TABLE `c_user_pegawai`
  MODIFY `id_user_pegawai` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `m_bidang`
--
ALTER TABLE `m_bidang`
  MODIFY `id_bidang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `m_fakultas`
--
ALTER TABLE `m_fakultas`
  MODIFY `id_fakultas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_file`
--
ALTER TABLE `m_file`
  MODIFY `id_file` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_instansi_pendidikan`
--
ALTER TABLE `m_instansi_pendidikan`
  MODIFY `id_instansi_pendidikan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_jenis_permohonan`
--
ALTER TABLE `m_jenis_permohonan`
  MODIFY `id_jenis_permohonan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `m_komponen_penilaian`
--
ALTER TABLE `m_komponen_penilaian`
  MODIFY `id_komponen_penilaian` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_kuota`
--
ALTER TABLE `m_kuota`
  MODIFY `id_kuota` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_opd`
--
ALTER TABLE `m_opd`
  MODIFY `id_opd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `m_prodi`
--
ALTER TABLE `m_prodi`
  MODIFY `id_prodi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_instansi_mahasiswa`
--
ALTER TABLE `t_instansi_mahasiswa`
  MODIFY `id_instansi_mahasiswa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_persetujuan_magang`
--
ALTER TABLE `t_persetujuan_magang`
  MODIFY `id_persetujuan_magang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `c_menus_privileges`
--
ALTER TABLE `c_menus_privileges`
  ADD CONSTRAINT `c_menus_privileges_ibfk_1` FOREIGN KEY (`id_user_group`) REFERENCES `c_user_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `c_menus_privileges_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `c_menus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `m_bidang`
--
ALTER TABLE `m_bidang`
  ADD CONSTRAINT `fk_bidang_opd` FOREIGN KEY (`id_opd`) REFERENCES `m_opd` (`id_opd`) ON UPDATE CASCADE,
  ADD CONSTRAINT `m_bidang_ibfk_1` FOREIGN KEY (`id_opd`) REFERENCES `m_opd` (`id_opd`) ON UPDATE CASCADE;

--
-- Constraints for table `m_file`
--
ALTER TABLE `m_file`
  ADD CONSTRAINT `fk_file_jenis_permohonan` FOREIGN KEY (`id_jenis_permohonan`) REFERENCES `m_jenis_permohonan` (`id_jenis_permohonan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `m_file_ibfk_1` FOREIGN KEY (`id_jenis_permohonan`) REFERENCES `m_jenis_permohonan` (`id_jenis_permohonan`) ON UPDATE CASCADE;

--
-- Constraints for table `m_kuota`
--
ALTER TABLE `m_kuota`
  ADD CONSTRAINT `fk_kuota_bidang` FOREIGN KEY (`id_bidang`) REFERENCES `m_bidang` (`id_bidang`) ON UPDATE CASCADE,
  ADD CONSTRAINT `m_kuota_ibfk_1` FOREIGN KEY (`id_bidang`) REFERENCES `m_bidang` (`id_bidang`) ON UPDATE CASCADE;

--
-- Constraints for table `m_prodi`
--
ALTER TABLE `m_prodi`
  ADD CONSTRAINT `fk_prodi_fakultas` FOREIGN KEY (`id_fakultas`) REFERENCES `m_fakultas` (`id_fakultas`) ON UPDATE CASCADE,
  ADD CONSTRAINT `m_prodi_ibfk_1` FOREIGN KEY (`id_fakultas`) REFERENCES `m_fakultas` (`id_fakultas`) ON UPDATE CASCADE;

--
-- Constraints for table `t_instansi_mahasiswa`
--
ALTER TABLE `t_instansi_mahasiswa`
  ADD CONSTRAINT `t_instansi_mahasiswa_ibfk_1` FOREIGN KEY (`id_instansi_pendidikan`) REFERENCES `m_instansi_pendidikan` (`id_instansi_pendidikan`),
  ADD CONSTRAINT `t_instansi_mahasiswa_ibfk_2` FOREIGN KEY (`id_prodi`) REFERENCES `m_prodi` (`id_prodi`);

--
-- Constraints for table `t_persetujuan_magang`
--
ALTER TABLE `t_persetujuan_magang`
  ADD CONSTRAINT `t_persetujuan_magang_ibfk_1` FOREIGN KEY (`id_bidang`) REFERENCES `m_bidang` (`id_bidang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
