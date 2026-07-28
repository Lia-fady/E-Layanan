-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2026 at 03:29 AM
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
(1, NULL, 'Menu Utama', 'header', 1, '', 1, 0, NULL, NULL, NULL, NULL),
(2, 1, 'Dashboard', 'sekretariat/dashboard', 2, 'bi bi-grid-1x2', 1, 0, NULL, NULL, NULL, NULL),
(3, NULL, 'Manajemen Berkas', 'header', 3, '', 1, 0, NULL, NULL, NULL, NULL),
(4, 3, 'Verifikasi Permohonan', 'sekretariat/verifikasi', 4, 'bi bi-file-earmark-check', 1, 0, NULL, NULL, NULL, NULL),
(5, 3, 'Arsip Data', 'sekretariat/arsip', 6, 'bi bi-archive', 1, 0, NULL, NULL, NULL, NULL),
(6, NULL, 'Informasi', 'header', 7, '', 1, 0, NULL, NULL, NULL, NULL),
(7, 6, 'Kuota Bidang', 'sekretariat/kuota', 8, 'bi bi-pie-chart', 1, 0, NULL, NULL, NULL, NULL),
(8, NULL, 'Menu Utama', 'header', 1, '', 1, 0, NULL, NULL, NULL, NULL),
(9, 8, 'Dashboard', 'kabid/dashboard', 2, 'bi bi-grid-1x2', 1, 0, NULL, NULL, NULL, NULL),
(10, NULL, 'Manajemen Disposisi', 'header', 3, '', 1, 0, NULL, NULL, NULL, NULL),
(11, 10, 'Antrean Penempatan', 'kabid/penempatan', 4, 'bi bi-person-plus', 1, 0, NULL, NULL, NULL, NULL),
(12, 10, 'Riwayat Aktif', 'kabid/riwayat', 6, 'bi bi-person-check', 1, 0, NULL, NULL, NULL, NULL),
(13, NULL, 'Laporan Mahasiswa', 'header', 7, '', 1, 0, NULL, NULL, NULL, NULL),
(14, 13, 'Verifikasi Logbook', 'kabid/verifikasi-logbook', 8, 'bi bi-journal-check', 1, 0, NULL, NULL, NULL, NULL),
(15, 3, 'Disposisi Penempatan', 'sekretariat/disposisi', 5, 'bi bi-person-lines-fill', 1, 0, NULL, NULL, NULL, NULL),
(16, 3, 'Sertifikat Magang', 'sekretariat/sertifikat', 7, 'bi bi-award', 1, 0, NULL, NULL, NULL, NULL);

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
(0, 2, 1, NULL, NULL),
(0, 2, 2, NULL, NULL),
(0, 2, 3, NULL, NULL),
(0, 2, 4, NULL, NULL),
(0, 2, 5, NULL, NULL),
(0, 2, 6, NULL, NULL),
(0, 2, 7, NULL, NULL),
(0, 3, 8, NULL, NULL),
(0, 3, 9, NULL, NULL),
(0, 3, 10, NULL, NULL),
(0, 3, 11, NULL, NULL),
(0, 3, 12, NULL, NULL),
(0, 3, 13, NULL, NULL),
(0, 3, 14, NULL, NULL),
(0, 2, 15, NULL, NULL),
(0, 2, 16, NULL, NULL);

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
(1, 'Super Admin', 1, '2026-07-17 06:39:40', NULL, NULL, NULL),
(2, 'Sekretariat', 1, '2026-07-17 06:39:40', NULL, NULL, NULL),
(3, 'Kabid', 1, '2026-07-17 06:39:40', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `c_user_pegawai`
--

CREATE TABLE `c_user_pegawai` (
  `id_user_pegawai` int(11) UNSIGNED NOT NULL,
  `nama` varchar(150) NOT NULL,
  `nip` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `kode_unor` varchar(50) DEFAULT NULL,
  `id_user_group` int(10) UNSIGNED DEFAULT NULL,
  `id_bidang` int(11) UNSIGNED DEFAULT NULL,
  `status_aktif` varchar(50) DEFAULT NULL,
  `file_tanda_tangan` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `c_user_pegawai`
--

INSERT INTO `c_user_pegawai` (`id_user_pegawai`, `nama`, `nip`, `password`, `kode_unor`, `id_user_group`, `id_bidang`, `status_aktif`, `file_tanda_tangan`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'Admin Sekretariat', '12345678', '$2y$10$rUi8GkQGZ19rnYZlgbyiu.2FuzcmupYK0si5m9ZUObINJPX/FyZ3u', 'SEKRETARIAT', 2, NULL, '1', NULL, NULL, NULL, NULL),
(2, 'Kepala Bidang Diseminasi Informasi', '87654321', '$2y$10$6GiTCr3yLI0BHFo28CptV.NJixAIk6hCxhK3DZyCfhnBP3kmlje0q', 'KABID', 3, 2, '1', NULL, NULL, NULL, NULL),
(3, 'Kepala Bidang Sarana & Prasarana TIK', '87654322', '$2y$10$6GiTCr3yLI0BHFo28CptV.NJixAIk6hCxhK3DZyCfhnBP3kmlje0q', 'KABID', 3, 3, '1', NULL, NULL, NULL, NULL),
(4, 'Kepala Bidang Statistik', '87654323', '$2y$10$6GiTCr3yLI0BHFo28CptV.NJixAIk6hCxhK3DZyCfhnBP3kmlje0q', 'KABID', 3, 4, '1', NULL, NULL, NULL, NULL),
(5, 'Kepala Bidang Pengembangan E-Gov', '87654324', '$2y$10$6GiTCr3yLI0BHFo28CptV.NJixAIk6hCxhK3DZyCfhnBP3kmlje0q', 'KABID', 3, 5, '1', NULL, NULL, NULL, NULL);

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

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2026-07-01-021102', 'App\\Database\\Migrations\\CreateJenisPermohonan', 'default', 'App', 1784121250, 1),
(2, '2026-07-01-021641', 'App\\Database\\Migrations\\CreateFakultas', 'default', 'App', 1784121250, 1),
(3, '2026-07-01-021859', 'App\\Database\\Migrations\\CreateProdi', 'default', 'App', 1784121250, 1),
(4, '2026-07-01-022011', 'App\\Database\\Migrations\\CreateInstansiPendidikan', 'default', 'App', 1784121250, 1),
(5, '2026-07-01-022301', 'App\\Database\\Migrations\\CreateInstansiMahasiswa', 'default', 'App', 1784121250, 1),
(6, '2026-07-01-022418', 'App\\Database\\Migrations\\CreateMahasiswa', 'default', 'App', 1784121250, 1),
(7, '2026-07-01-022622', 'App\\Database\\Migrations\\CreateUserMahasiswa', 'default', 'App', 1784121250, 1),
(8, '2026-07-01-022933', 'App\\Database\\Migrations\\CreateOpd', 'default', 'App', 1784121250, 1),
(9, '2026-07-01-023154', 'App\\Database\\Migrations\\CreateBidang', 'default', 'App', 1784121250, 1),
(10, '2026-07-01-023306', 'App\\Database\\Migrations\\CreateKuota', 'default', 'App', 1784121250, 1),
(11, '2026-07-01-023507', 'App\\Database\\Migrations\\CreateUserPegawai', 'default', 'App', 1784121250, 1),
(12, '2026-07-01-023818', 'App\\Database\\Migrations\\CreatePermohonanMagang', 'default', 'App', 1784121250, 1),
(13, '2026-07-01-024037', 'App\\Database\\Migrations\\CreateFile', 'default', 'App', 1784121250, 1),
(14, '2026-07-01-024100', 'App\\Database\\Migrations\\CreateFilePermohonan', 'default', 'App', 1784121250, 1),
(15, '2026-07-01-024252', 'App\\Database\\Migrations\\CreateFilePermohonanMagang', 'default', 'App', 1784121251, 1),
(16, '2026-07-01-024440', 'App\\Database\\Migrations\\CreatePersetujuanMagang', 'default', 'App', 1784121251, 1),
(17, '2026-07-01-025656', 'App\\Database\\Migrations\\CreatePenempatanMagang', 'default', 'App', 1784121251, 1),
(18, '2026-07-01-030016', 'App\\Database\\Migrations\\CreateLogbookMagang', 'default', 'App', 1784121251, 1),
(19, '2026-07-19-143442', 'App\\Database\\Migrations\\AddStatusToLogbookMagang', 'default', 'App', 1784471701, 2);

-- --------------------------------------------------------

--
-- Table structure for table `m_bidang`
--

CREATE TABLE `m_bidang` (
  `id_bidang` int(11) UNSIGNED NOT NULL,
  `bidang` varchar(150) NOT NULL,
  `status_aktif` varchar(50) DEFAULT NULL,
  `id_opd` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_bidang`
--

INSERT INTO `m_bidang` (`id_bidang`, `bidang`, `status_aktif`, `id_opd`) VALUES
(2, 'Bidang Diseminasi Informasi Dan Komunikasi Publik', '1', 1),
(3, 'Bidang Sarana, Prasarana TIK dan Persandian', '1', 1),
(4, 'Bidang Statistik Dan Pemberdayaan TIK', '1', 1),
(5, 'Bidang Pengembangan E-Goverment', '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_fakultas`
--

CREATE TABLE `m_fakultas` (
  `id_fakultas` int(11) UNSIGNED NOT NULL,
  `id_instansi_pendidikan` int(11) UNSIGNED DEFAULT NULL,
  `fakultas` varchar(100) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_fakultas`
--

INSERT INTO `m_fakultas` (`id_fakultas`, `id_instansi_pendidikan`, `fakultas`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Fakultas Ilmu Komputer', 'aktif', NULL, NULL),
(2, 1, 'Fakultas Teknik', 'aktif', NULL, NULL),
(3, 1, 'Fakultas Ekonomi dan Bisnis', 'aktif', NULL, NULL),
(4, 1, 'Fakultas Ilmu Sosial dan Ilmu Politik', 'aktif', NULL, NULL),
(5, 2, 'Fakultas Matematika dan Ilmu Pengetahuan Alam', 'aktif', '2026-07-17 12:45:45', NULL),
(6, 3, 'Fakultas Ilmu Komputer', 'aktif', '2026-07-17 12:45:45', NULL),
(7, 4, 'Fakultas Teknologi Industri', 'aktif', '2026-07-17 12:45:45', NULL),
(8, 5, 'School of Computer Science', 'aktif', '2026-07-17 12:45:45', NULL),
(9, 6, 'Fakultas Teknik', 'aktif', '2026-07-17 12:45:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_file`
--

CREATE TABLE `m_file` (
  `id_file` int(11) UNSIGNED NOT NULL,
  `nama_file` varchar(150) NOT NULL,
  `status_aktif` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_file`
--

INSERT INTO `m_file` (`id_file`, `nama_file`, `status_aktif`) VALUES
(1, 'Surat Pengantar Resmi Kampus', '1'),
(2, 'Surat Pengantar Resmi Kampus', '1'),
(3, 'Curriculum Vitae (CV)', '1'),
(4, 'Proposal / Sinopsis', '1'),
(5, 'Surat Pengantar Resmi Kampus', '1'),
(6, 'Surat Pengantar Resmi Kampus', '1'),
(7, 'Proposal Uji Coba Produk', '1');

-- --------------------------------------------------------

--
-- Table structure for table `m_file_permohonan`
--

CREATE TABLE `m_file_permohonan` (
  `id_file_permohonan` int(11) UNSIGNED NOT NULL,
  `id_file` int(11) UNSIGNED NOT NULL,
  `id_jenis_permohonan` int(11) UNSIGNED NOT NULL,
  `status_aktif` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_file_permohonan`
--

INSERT INTO `m_file_permohonan` (`id_file_permohonan`, `id_file`, `id_jenis_permohonan`, `status_aktif`) VALUES
(1, 1, 1, NULL),
(2, 4, 1, NULL),
(3, 5, 2, NULL),
(4, 2, 3, NULL),
(5, 3, 3, NULL),
(6, 6, 4, NULL),
(7, 7, 4, NULL),
(8, 1, 1, NULL),
(9, 4, 1, NULL),
(10, 5, 2, NULL),
(11, 2, 3, NULL),
(12, 3, 3, NULL),
(13, 6, 4, NULL),
(14, 7, 4, NULL),
(15, 1, 1, NULL),
(16, 4, 1, NULL),
(17, 5, 2, NULL),
(18, 2, 3, NULL),
(19, 3, 3, NULL),
(20, 6, 4, NULL),
(21, 7, 4, NULL),
(22, 1, 1, NULL),
(23, 4, 1, NULL),
(24, 5, 2, NULL),
(25, 2, 3, NULL),
(26, 3, 3, NULL),
(27, 6, 4, NULL),
(28, 7, 4, NULL),
(29, 1, 1, NULL),
(30, 4, 1, NULL),
(31, 5, 2, NULL),
(32, 2, 3, NULL),
(33, 3, 3, NULL),
(34, 6, 4, NULL),
(35, 7, 4, NULL),
(36, 1, 1, NULL),
(37, 4, 1, NULL),
(38, 5, 2, NULL),
(39, 2, 3, NULL),
(40, 3, 3, NULL),
(41, 6, 4, NULL),
(42, 7, 4, NULL),
(43, 1, 1, NULL),
(44, 4, 1, NULL),
(45, 5, 2, NULL),
(46, 2, 3, NULL),
(47, 3, 3, NULL),
(48, 6, 4, NULL),
(49, 7, 4, NULL),
(50, 1, 1, NULL),
(51, 4, 1, NULL),
(52, 5, 2, NULL),
(53, 2, 3, NULL),
(54, 3, 3, NULL),
(55, 6, 4, NULL),
(56, 7, 4, NULL),
(57, 1, 1, NULL),
(58, 4, 1, NULL),
(59, 5, 2, NULL),
(60, 2, 3, NULL),
(61, 3, 3, NULL),
(62, 6, 4, NULL),
(63, 7, 4, NULL),
(64, 1, 1, NULL),
(65, 4, 1, NULL),
(66, 5, 2, NULL),
(67, 2, 3, NULL),
(68, 3, 3, NULL),
(69, 6, 4, NULL),
(70, 7, 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_instansi_pendidikan`
--

CREATE TABLE `m_instansi_pendidikan` (
  `id_instansi_pendidikan` int(11) UNSIGNED NOT NULL,
  `instansi_pendidikan` varchar(150) NOT NULL,
  `jenis_instansi` enum('negeri','swasta') NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_instansi_pendidikan`
--

INSERT INTO `m_instansi_pendidikan` (`id_instansi_pendidikan`, `instansi_pendidikan`, `jenis_instansi`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Universitas Indonesia', 'negeri', 'aktif', NULL, NULL),
(2, 'Universitas Gadjah Mada', 'negeri', 'aktif', NULL, NULL),
(3, 'Universitas Brawijaya', 'negeri', 'aktif', NULL, NULL),
(4, 'Universitas Gunadarma', 'swasta', 'aktif', NULL, NULL),
(5, 'Bina Nusantara (Binus)', 'swasta', 'aktif', NULL, NULL),
(6, 'Universitas Muhammadiyah Tangerang', 'swasta', 'aktif', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_jenis_permohonan`
--

CREATE TABLE `m_jenis_permohonan` (
  `id_jenis_permohonan` int(11) UNSIGNED NOT NULL,
  `jenis_permohonan` varchar(100) NOT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_jenis_permohonan`
--

INSERT INTO `m_jenis_permohonan` (`id_jenis_permohonan`, `jenis_permohonan`, `status`) VALUES
(1, 'Penelitian Skripsi / TA', NULL),
(2, 'Observasi / Pengambilan Data', NULL),
(3, 'Magang / PKL', NULL),
(4, 'Uji Coba Produk (Prototype)', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_kuota`
--

CREATE TABLE `m_kuota` (
  `id_kuota` int(11) UNSIGNED NOT NULL,
  `id_bidang` int(11) UNSIGNED NOT NULL,
  `kuota` int(11) NOT NULL,
  `status_aktif` varchar(50) DEFAULT NULL
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
  `kelurahan` varchar(100) DEFAULT NULL,
  `kecamatan` varchar(100) DEFAULT NULL,
  `provinsi` varchar(100) DEFAULT NULL,
  `no_telp` varchar(20) NOT NULL,
  `id_instansi_mahasiswa` int(11) UNSIGNED NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_mahasiswa`
--

INSERT INTO `m_mahasiswa` (`id_mahasiswa`, `nik`, `nim`, `nama_mahasiswa`, `jenis_kelamin`, `tgl_lahir`, `alamat`, `rt`, `rw`, `kelurahan`, `kecamatan`, `provinsi`, `no_telp`, `id_instansi_mahasiswa`, `email`, `created_at`, `updated_at`) VALUES
(1, '3671020222040010', '10204230030', 'Kusuma Wijaya', 'L', '2004-07-15', 'JL Raya Cipondoh No.4', '01', '04', 'Ketapang', 'Cipondoh', 'Banten', '081313202498', 1, 'Kusumawij@gmail.com', '2026-07-17 09:58:20', '2026-07-17 09:58:20'),
(2, '3671020222040002', '102042330040', 'Putra WIjaya', 'L', '2006-01-01', 'JL RAYA KH ASHIM ASHARI', '01', '04', 'Buaran Indah', 'Tangerang', 'Banten', '081218501061', 2, 'Putrawjy@gmail.com', '2026-07-19 09:23:01', '2026-07-19 09:23:01');

-- --------------------------------------------------------

--
-- Table structure for table `m_opd`
--

CREATE TABLE `m_opd` (
  `id_opd` int(11) UNSIGNED NOT NULL,
  `opd` varchar(150) NOT NULL,
  `status_aktif` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_opd`
--

INSERT INTO `m_opd` (`id_opd`, `opd`, `status_aktif`) VALUES
(1, 'Dinas Kominfo', '1');

-- --------------------------------------------------------

--
-- Table structure for table `m_prodi`
--

CREATE TABLE `m_prodi` (
  `id_prodi` int(11) UNSIGNED NOT NULL,
  `id_fakultas` int(11) UNSIGNED NOT NULL,
  `prodi` varchar(100) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_prodi`
--

INSERT INTO `m_prodi` (`id_prodi`, `id_fakultas`, `prodi`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Teknik Informatika', 'aktif', NULL, NULL),
(2, 1, 'Sistem Informasi', 'aktif', NULL, NULL),
(3, 2, 'Teknik Elektro', 'aktif', NULL, NULL),
(4, 2, 'Teknik Industri', 'aktif', NULL, NULL),
(5, 3, 'Manajemen Bisnis', 'aktif', NULL, NULL),
(6, 4, 'Ilmu Komunikasi', 'aktif', NULL, NULL),
(7, 5, 'Ilmu Komputer', 'aktif', '2026-07-17 12:45:45', NULL),
(8, 5, 'Matematika', 'aktif', '2026-07-17 12:45:45', NULL),
(9, 6, 'Teknik Informatika', 'aktif', '2026-07-17 12:45:45', NULL),
(10, 7, 'Teknik Informatika', 'aktif', '2026-07-17 12:45:45', NULL),
(11, 8, 'Computer Science', 'aktif', '2026-07-17 12:45:45', NULL),
(12, 9, 'Teknik Informatika', 'aktif', '2026-07-17 12:45:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_user_mahasiswa`
--

CREATE TABLE `m_user_mahasiswa` (
  `id_user_mahasiswa` int(11) UNSIGNED NOT NULL,
  `id_mahasiswa` int(11) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_user_mahasiswa`
--

INSERT INTO `m_user_mahasiswa` (`id_user_mahasiswa`, `id_mahasiswa`, `username`, `password`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Kusuma', '$2y$10$3vz1lP.CcdSKFe1FFDdss.db5raUCX6LEg4Wyu7ii//ZmRGfoo3MO', 'AKTIF', '2026-07-17 09:58:21', '2026-07-17 09:58:21'),
(2, 2, 'Putra', '$2y$10$skfvdKnspYmV/mB.2FxUaO6Bs4TxEFsf8TeTMjLG2Y0AtBIL3Xq1q', 'AKTIF', '2026-07-19 09:23:01', '2026-07-19 09:23:01');

-- --------------------------------------------------------

--
-- Table structure for table `t_file_permohonan_magang`
--

CREATE TABLE `t_file_permohonan_magang` (
  `id_file_permohonan_magang` int(11) UNSIGNED NOT NULL,
  `id_permohonan_magang` int(11) UNSIGNED NOT NULL,
  `id_file_permohonan` int(11) UNSIGNED NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `path_file` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_file_permohonan_magang`
--

INSERT INTO `t_file_permohonan_magang` (`id_file_permohonan_magang`, `id_permohonan_magang`, `id_file_permohonan`, `nama_file`, `path_file`, `created_at`, `updated_at`) VALUES
(14, 4, 4, 'trial balance.pdf', 'uploads/dokumen/1784352144_f52bbbaa3a859798fadb.pdf', '2026-07-18 05:22:24', NULL),
(15, 4, 5, 'Journal_JICT.pdf', 'uploads/dokumen/1784352144_3caf9d6db426e648137e.pdf', '2026-07-18 05:22:24', NULL),
(17, 6, 3, 'trial balance.pdf', 'uploads/dokumen/1784465059_767151e5920b60bbddd9.pdf', '2026-07-19 12:44:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_instansi_mahasiswa`
--

CREATE TABLE `t_instansi_mahasiswa` (
  `id_instansi_mahasiswa` int(11) UNSIGNED NOT NULL,
  `id_mahasiswa` int(11) UNSIGNED NOT NULL,
  `id_instansi_pendidikan` int(11) UNSIGNED NOT NULL,
  `id_fakultas` int(11) UNSIGNED DEFAULT NULL,
  `id_prodi` int(11) UNSIGNED NOT NULL,
  `jenjang_pendidikan` varchar(50) DEFAULT NULL,
  `angkatan_tahun` varchar(4) DEFAULT NULL,
  `semester` varchar(10) DEFAULT NULL,
  `tahun_akademik` varchar(20) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_instansi_mahasiswa`
--

INSERT INTO `t_instansi_mahasiswa` (`id_instansi_mahasiswa`, `id_mahasiswa`, `id_instansi_pendidikan`, `id_fakultas`, `id_prodi`, `jenjang_pendidikan`, `angkatan_tahun`, `semester`, `tahun_akademik`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 2, 'S1', '2023', '6', '2025/2026', 'SYSTEM_REGISTRATION', NULL, NULL, NULL),
(2, 2, 2, 6, 9, 'S1', '2023', '7', '2025/2026', 'SYSTEM_REGISTRATION', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_logbook_magang`
--

CREATE TABLE `t_logbook_magang` (
  `id_logbook_magang` int(11) UNSIGNED NOT NULL,
  `id_penempatan_magang` int(11) UNSIGNED NOT NULL,
  `logbook_magang` text NOT NULL,
  `tgl_logbook` date NOT NULL,
  `status_logbook` enum('menunggu','disetujui','ditolak') DEFAULT 'menunggu',
  `catatan_revisi` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `disetujui_oleh` int(11) UNSIGNED DEFAULT NULL,
  `file_tanda_tangan` varchar(255) DEFAULT NULL,
  `tgl_disetujui` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_logbook_magang`
--

INSERT INTO `t_logbook_magang` (`id_logbook_magang`, `id_penempatan_magang`, `logbook_magang`, `tgl_logbook`, `status_logbook`, `catatan_revisi`, `created_at`, `updated_by`, `disetujui_oleh`, `file_tanda_tangan`, `tgl_disetujui`) VALUES
(1, 2, 'Membuat Tampilan Webiste', '2026-07-18', 'menunggu', NULL, '2026-07-18 14:04:00', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_penempatan_magang`
--

CREATE TABLE `t_penempatan_magang` (
  `id_penempatan_magang` int(11) UNSIGNED NOT NULL,
  `id_bidang` int(11) UNSIGNED NOT NULL,
  `id_persetujuan_magang` int(11) UNSIGNED NOT NULL,
  `id_mahasiswa` int(11) UNSIGNED NOT NULL,
  `catatan` text DEFAULT NULL,
  `status_penempatan` enum('BERJALAN','SELESAI','DIBATALKAN') NOT NULL DEFAULT 'BERJALAN',
  `is_log_book` enum('ya','tidak') NOT NULL DEFAULT 'ya',
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `file_sertifikat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_penempatan_magang`
--

INSERT INTO `t_penempatan_magang` (`id_penempatan_magang`, `id_bidang`, `id_persetujuan_magang`, `id_mahasiswa`, `catatan`, `status_penempatan`, `is_log_book`, `created_at`, `created_by`, `updated_at`, `updated_by`, `file_sertifikat`) VALUES
(2, 5, 5, 1, 'Membantu Pengembangan Aplikasi Website', 'BERJALAN', 'ya', '2026-07-18 13:56:18', '4', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_permohonan_magang`
--

CREATE TABLE `t_permohonan_magang` (
  `id_permohonan_magang` int(11) UNSIGNED NOT NULL,
  `id_mahasiswa` int(11) UNSIGNED NOT NULL,
  `id_instansi_mahasiswa` int(11) UNSIGNED NOT NULL,
  `id_jenis_permohonan` int(11) UNSIGNED NOT NULL,
  `deskripsi_keahlian` text DEFAULT NULL,
  `deskripsi_magang` text DEFAULT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `posting_data` enum('draft','kirim') NOT NULL DEFAULT 'draft',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_permohonan_magang`
--

INSERT INTO `t_permohonan_magang` (`id_permohonan_magang`, `id_mahasiswa`, `id_instansi_mahasiswa`, `id_jenis_permohonan`, `deskripsi_keahlian`, `deskripsi_magang`, `tgl_mulai`, `tgl_selesai`, `posting_data`, `created_at`, `updated_at`) VALUES
(4, 1, 1, 3, 'Python, PHP, HTML, CSS\r\n', 'Pengembangan Aplikasi Berbasis Website', '2026-07-18', '2026-08-31', 'kirim', '2026-07-18 05:22:24', '2026-07-18 05:22:39'),
(6, 2, 2, 2, 'Penyelesaian Mata kuliah Analisis Perancangan Interaksi', 'Pengambilan data sampel', '2026-07-19', '2026-07-31', 'kirim', '2026-07-19 12:44:19', '2026-07-19 12:45:31');

-- --------------------------------------------------------

--
-- Table structure for table `t_persetujuan_magang`
--

CREATE TABLE `t_persetujuan_magang` (
  `id_persetujuan_magang` int(11) UNSIGNED NOT NULL,
  `id_permohonan_magang` int(11) UNSIGNED NOT NULL,
  `catatan` text DEFAULT NULL,
  `status_persetujuan` enum('MENUNGGU','DISETUJUI','DITOLAK') NOT NULL DEFAULT 'MENUNGGU',
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `disposisi` enum('0','1','2') NOT NULL DEFAULT '0',
  `id_bidang` int(11) UNSIGNED DEFAULT NULL,
  `tgl_persetujuan` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_persetujuan_magang`
--

INSERT INTO `t_persetujuan_magang` (`id_persetujuan_magang`, `id_permohonan_magang`, `catatan`, `status_persetujuan`, `created_at`, `created_by`, `updated_at`, `updated_by`, `disposisi`, `id_bidang`, `tgl_persetujuan`) VALUES
(5, 4, 'Telah didisposisikan oleh Sekretariat.', 'DISETUJUI', NULL, '3', NULL, '4', '2', 5, '2026-07-18');

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
  ADD KEY `c_user_pegawai_id_bidang_foreign` (`id_bidang`);

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
  ADD KEY `m_bidang_id_opd_foreign` (`id_opd`);

--
-- Indexes for table `m_fakultas`
--
ALTER TABLE `m_fakultas`
  ADD PRIMARY KEY (`id_fakultas`);

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
  ADD KEY `m_file_permohonan_id_file_foreign` (`id_file`),
  ADD KEY `m_file_permohonan_id_jenis_permohonan_foreign` (`id_jenis_permohonan`);

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
-- Indexes for table `m_kuota`
--
ALTER TABLE `m_kuota`
  ADD PRIMARY KEY (`id_kuota`),
  ADD KEY `m_kuota_id_bidang_foreign` (`id_bidang`);

--
-- Indexes for table `m_mahasiswa`
--
ALTER TABLE `m_mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`),
  ADD KEY `m_mahasiswa_id_instansi_mahasiswa_foreign` (`id_instansi_mahasiswa`);

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
  ADD KEY `m_prodi_id_fakultas_foreign` (`id_fakultas`);

--
-- Indexes for table `m_user_mahasiswa`
--
ALTER TABLE `m_user_mahasiswa`
  ADD PRIMARY KEY (`id_user_mahasiswa`),
  ADD KEY `m_user_mahasiswa_id_mahasiswa_foreign` (`id_mahasiswa`);

--
-- Indexes for table `t_file_permohonan_magang`
--
ALTER TABLE `t_file_permohonan_magang`
  ADD PRIMARY KEY (`id_file_permohonan_magang`),
  ADD KEY `t_file_permohonan_magang_id_permohonan_magang_foreign` (`id_permohonan_magang`),
  ADD KEY `t_file_permohonan_magang_id_file_permohonan_foreign` (`id_file_permohonan`);

--
-- Indexes for table `t_instansi_mahasiswa`
--
ALTER TABLE `t_instansi_mahasiswa`
  ADD PRIMARY KEY (`id_instansi_mahasiswa`),
  ADD KEY `t_instansi_mahasiswa_id_instansi_pendidikan_foreign` (`id_instansi_pendidikan`),
  ADD KEY `t_instansi_mahasiswa_id_prodi_foreign` (`id_prodi`);

--
-- Indexes for table `t_logbook_magang`
--
ALTER TABLE `t_logbook_magang`
  ADD PRIMARY KEY (`id_logbook_magang`),
  ADD KEY `t_logbook_magang_id_penempatan_magang_foreign` (`id_penempatan_magang`),
  ADD KEY `t_logbook_magang_disetujui_oleh_foreign` (`disetujui_oleh`);

--
-- Indexes for table `t_penempatan_magang`
--
ALTER TABLE `t_penempatan_magang`
  ADD PRIMARY KEY (`id_penempatan_magang`),
  ADD KEY `t_penempatan_magang_id_bidang_foreign` (`id_bidang`),
  ADD KEY `t_penempatan_magang_id_persetujuan_magang_foreign` (`id_persetujuan_magang`),
  ADD KEY `t_penempatan_magang_id_mahasiswa_foreign` (`id_mahasiswa`);

--
-- Indexes for table `t_permohonan_magang`
--
ALTER TABLE `t_permohonan_magang`
  ADD PRIMARY KEY (`id_permohonan_magang`),
  ADD KEY `t_permohonan_magang_id_mahasiswa_foreign` (`id_mahasiswa`),
  ADD KEY `t_permohonan_magang_id_instansi_mahasiswa_foreign` (`id_instansi_mahasiswa`),
  ADD KEY `t_permohonan_magang_id_jenis_permohonan_foreign` (`id_jenis_permohonan`);

--
-- Indexes for table `t_persetujuan_magang`
--
ALTER TABLE `t_persetujuan_magang`
  ADD PRIMARY KEY (`id_persetujuan_magang`),
  ADD KEY `t_persetujuan_magang_id_permohonan_magang_foreign` (`id_permohonan_magang`),
  ADD KEY `t_persetujuan_magang_id_bidang_foreign` (`id_bidang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `c_menus`
--
ALTER TABLE `c_menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `c_user_pegawai`
--
ALTER TABLE `c_user_pegawai`
  MODIFY `id_user_pegawai` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `m_bidang`
--
ALTER TABLE `m_bidang`
  MODIFY `id_bidang` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `m_fakultas`
--
ALTER TABLE `m_fakultas`
  MODIFY `id_fakultas` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `m_file`
--
ALTER TABLE `m_file`
  MODIFY `id_file` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `m_file_permohonan`
--
ALTER TABLE `m_file_permohonan`
  MODIFY `id_file_permohonan` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `m_instansi_pendidikan`
--
ALTER TABLE `m_instansi_pendidikan`
  MODIFY `id_instansi_pendidikan` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `m_jenis_permohonan`
--
ALTER TABLE `m_jenis_permohonan`
  MODIFY `id_jenis_permohonan` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `m_kuota`
--
ALTER TABLE `m_kuota`
  MODIFY `id_kuota` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_mahasiswa`
--
ALTER TABLE `m_mahasiswa`
  MODIFY `id_mahasiswa` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `m_opd`
--
ALTER TABLE `m_opd`
  MODIFY `id_opd` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `m_prodi`
--
ALTER TABLE `m_prodi`
  MODIFY `id_prodi` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `m_user_mahasiswa`
--
ALTER TABLE `m_user_mahasiswa`
  MODIFY `id_user_mahasiswa` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_file_permohonan_magang`
--
ALTER TABLE `t_file_permohonan_magang`
  MODIFY `id_file_permohonan_magang` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `t_instansi_mahasiswa`
--
ALTER TABLE `t_instansi_mahasiswa`
  MODIFY `id_instansi_mahasiswa` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_logbook_magang`
--
ALTER TABLE `t_logbook_magang`
  MODIFY `id_logbook_magang` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t_penempatan_magang`
--
ALTER TABLE `t_penempatan_magang`
  MODIFY `id_penempatan_magang` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_permohonan_magang`
--
ALTER TABLE `t_permohonan_magang`
  MODIFY `id_permohonan_magang` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `t_persetujuan_magang`
--
ALTER TABLE `t_persetujuan_magang`
  MODIFY `id_persetujuan_magang` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `c_user_pegawai`
--
ALTER TABLE `c_user_pegawai`
  ADD CONSTRAINT `c_user_pegawai_id_bidang_foreign` FOREIGN KEY (`id_bidang`) REFERENCES `m_bidang` (`id_bidang`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `m_bidang`
--
ALTER TABLE `m_bidang`
  ADD CONSTRAINT `m_bidang_id_opd_foreign` FOREIGN KEY (`id_opd`) REFERENCES `m_opd` (`id_opd`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `m_file_permohonan`
--
ALTER TABLE `m_file_permohonan`
  ADD CONSTRAINT `m_file_permohonan_id_file_foreign` FOREIGN KEY (`id_file`) REFERENCES `m_file` (`id_file`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `m_file_permohonan_id_jenis_permohonan_foreign` FOREIGN KEY (`id_jenis_permohonan`) REFERENCES `m_jenis_permohonan` (`id_jenis_permohonan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `m_kuota`
--
ALTER TABLE `m_kuota`
  ADD CONSTRAINT `m_kuota_id_bidang_foreign` FOREIGN KEY (`id_bidang`) REFERENCES `m_bidang` (`id_bidang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `m_mahasiswa`
--
ALTER TABLE `m_mahasiswa`
  ADD CONSTRAINT `m_mahasiswa_id_instansi_mahasiswa_foreign` FOREIGN KEY (`id_instansi_mahasiswa`) REFERENCES `t_instansi_mahasiswa` (`id_instansi_mahasiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `m_prodi`
--
ALTER TABLE `m_prodi`
  ADD CONSTRAINT `m_prodi_id_fakultas_foreign` FOREIGN KEY (`id_fakultas`) REFERENCES `m_fakultas` (`id_fakultas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `m_user_mahasiswa`
--
ALTER TABLE `m_user_mahasiswa`
  ADD CONSTRAINT `m_user_mahasiswa_id_mahasiswa_foreign` FOREIGN KEY (`id_mahasiswa`) REFERENCES `m_mahasiswa` (`id_mahasiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_file_permohonan_magang`
--
ALTER TABLE `t_file_permohonan_magang`
  ADD CONSTRAINT `t_file_permohonan_magang_id_file_permohonan_foreign` FOREIGN KEY (`id_file_permohonan`) REFERENCES `m_file_permohonan` (`id_file_permohonan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_file_permohonan_magang_id_permohonan_magang_foreign` FOREIGN KEY (`id_permohonan_magang`) REFERENCES `t_permohonan_magang` (`id_permohonan_magang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_instansi_mahasiswa`
--
ALTER TABLE `t_instansi_mahasiswa`
  ADD CONSTRAINT `t_instansi_mahasiswa_id_instansi_pendidikan_foreign` FOREIGN KEY (`id_instansi_pendidikan`) REFERENCES `m_instansi_pendidikan` (`id_instansi_pendidikan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_instansi_mahasiswa_id_prodi_foreign` FOREIGN KEY (`id_prodi`) REFERENCES `m_prodi` (`id_prodi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_logbook_magang`
--
ALTER TABLE `t_logbook_magang`
  ADD CONSTRAINT `t_logbook_magang_disetujui_oleh_foreign` FOREIGN KEY (`disetujui_oleh`) REFERENCES `c_user_pegawai` (`id_user_pegawai`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `t_logbook_magang_id_penempatan_magang_foreign` FOREIGN KEY (`id_penempatan_magang`) REFERENCES `t_penempatan_magang` (`id_penempatan_magang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_penempatan_magang`
--
ALTER TABLE `t_penempatan_magang`
  ADD CONSTRAINT `t_penempatan_magang_id_bidang_foreign` FOREIGN KEY (`id_bidang`) REFERENCES `m_bidang` (`id_bidang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_penempatan_magang_id_mahasiswa_foreign` FOREIGN KEY (`id_mahasiswa`) REFERENCES `m_mahasiswa` (`id_mahasiswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_penempatan_magang_id_persetujuan_magang_foreign` FOREIGN KEY (`id_persetujuan_magang`) REFERENCES `t_persetujuan_magang` (`id_persetujuan_magang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_permohonan_magang`
--
ALTER TABLE `t_permohonan_magang`
  ADD CONSTRAINT `t_permohonan_magang_id_instansi_mahasiswa_foreign` FOREIGN KEY (`id_instansi_mahasiswa`) REFERENCES `t_instansi_mahasiswa` (`id_instansi_mahasiswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_permohonan_magang_id_jenis_permohonan_foreign` FOREIGN KEY (`id_jenis_permohonan`) REFERENCES `m_jenis_permohonan` (`id_jenis_permohonan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_permohonan_magang_id_mahasiswa_foreign` FOREIGN KEY (`id_mahasiswa`) REFERENCES `m_mahasiswa` (`id_mahasiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_persetujuan_magang`
--
ALTER TABLE `t_persetujuan_magang`
  ADD CONSTRAINT `t_persetujuan_magang_id_bidang_foreign` FOREIGN KEY (`id_bidang`) REFERENCES `m_bidang` (`id_bidang`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `t_persetujuan_magang_id_permohonan_magang_foreign` FOREIGN KEY (`id_permohonan_magang`) REFERENCES `t_permohonan_magang` (`id_permohonan_magang`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
