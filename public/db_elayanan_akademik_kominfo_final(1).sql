-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2026 at 03:48 PM
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
(15, 3, 'Disposisi Penempatan', 'sekretariat/disposisi', 5, 'bi bi-person-lines-fill', 1, 0, NULL, NULL, NULL, NULL),
(18, NULL, 'Menu Utama', 'header', 10, '', 1, 0, NULL, NULL, NULL, NULL),
(19, 18, 'Dashboard', 'kabid/dashboard', 11, 'bi bi-grid-1x2', 1, 0, NULL, NULL, NULL, NULL),
(20, NULL, 'Proses Penempatan', 'header', 12, '', 1, 0, NULL, NULL, NULL, NULL),
(21, 20, 'Disposisi Masuk', 'kabid/penempatan', 13, 'bi bi-person-lines-fill', 1, 0, NULL, NULL, NULL, NULL),
(22, NULL, 'Pantauan Aktif', 'header', 14, '', 1, 0, NULL, NULL, NULL, NULL),
(23, 22, 'Mahasiswa Aktif', 'kabid/riwayat', 15, 'bi bi-people', 1, 0, NULL, NULL, NULL, NULL),
(24, 22, 'Verifikasi Logbook', 'kabid/verifikasi-logbook', 16, 'bi bi-journal-check', 1, 0, NULL, NULL, NULL, NULL),
(25, NULL, 'Dokumen & Kelulusan', 'header', 17, '', 1, 0, NULL, NULL, NULL, NULL),
(26, 25, 'Manajemen Dokumen', 'kabid/sertifikat', 18, 'bi bi-award', 1, 0, NULL, NULL, NULL, NULL),
(27, 0, 'Manajemen Dokumen', 'sekretariat/sertifikat', 99, 'bi bi-award', 1, 0, NULL, NULL, NULL, NULL),
(28, NULL, 'Menu Utama', 'header', 10, '', 1, 0, NULL, NULL, NULL, NULL),
(29, 18, 'Dashboard', 'kabid/dashboard', 11, 'bi bi-grid-1x2', 1, 0, NULL, NULL, NULL, NULL),
(30, NULL, 'Proses Penempatan', 'header', 12, '', 1, 0, NULL, NULL, NULL, NULL),
(31, 20, 'Disposisi Masuk', 'kabid/penempatan', 13, 'bi bi-person-lines-fill', 1, 0, NULL, NULL, NULL, NULL),
(32, NULL, 'Pantauan Aktif', 'header', 14, '', 1, 0, NULL, NULL, NULL, NULL),
(33, 22, 'Mahasiswa Aktif', 'kabid/riwayat', 15, 'bi bi-people', 1, 0, NULL, NULL, NULL, NULL),
(34, 22, 'Informasi Kuota', 'kabid/kuota', 16, 'bi bi-pie-chart', 1, 0, NULL, NULL, NULL, NULL),
(35, 22, 'Verifikasi Logbook', 'kabid/verifikasi-logbook', 17, 'bi bi-journal-check', 1, 0, NULL, NULL, NULL, NULL),
(36, NULL, 'Dokumen & Kelulusan', 'header', 18, '', 1, 0, NULL, NULL, NULL, NULL),
(37, 36, 'Manajemen Dokumen', 'kabid/sertifikat', 19, 'bi bi-award', 1, 0, NULL, NULL, NULL, NULL),
(38, NULL, 'Menu Utama', 'header', 10, '', 1, 0, NULL, NULL, NULL, NULL),
(39, 38, 'Dashboard', 'kabid/dashboard', 11, 'bi bi-grid-1x2', 1, 0, NULL, NULL, NULL, NULL),
(40, NULL, 'Proses Penempatan', 'header', 12, '', 1, 0, NULL, NULL, NULL, NULL),
(41, 40, 'Disposisi Masuk', 'kabid/penempatan', 13, 'bi bi-person-lines-fill', 1, 0, NULL, NULL, NULL, NULL),
(42, NULL, 'Pantauan Aktif', 'header', 14, '', 1, 0, NULL, NULL, NULL, NULL),
(43, 42, 'Mahasiswa Aktif', 'kabid/riwayat', 15, 'bi bi-people', 1, 0, NULL, NULL, NULL, NULL),
(44, 42, 'Informasi Kuota', 'kabid/kuota', 16, 'bi bi-pie-chart', 1, 0, NULL, NULL, NULL, NULL),
(45, 42, 'Verifikasi Logbook', 'kabid/verifikasi-logbook', 17, 'bi bi-journal-check', 1, 0, NULL, NULL, NULL, NULL),
(46, NULL, 'Dokumen & Kelulusan', 'header', 18, '', 1, 0, NULL, NULL, NULL, NULL),
(47, 46, 'Manajemen Dokumen', 'kabid/sertifikat', 19, 'bi bi-award', 1, 0, NULL, NULL, NULL, NULL),
(48, NULL, 'Menu Utama', 'header', 10, '', 1, 0, NULL, NULL, NULL, NULL),
(49, 48, 'Dashboard', 'kabid/dashboard', 11, 'bi bi-grid-1x2', 1, 0, NULL, NULL, NULL, NULL),
(50, NULL, 'Proses Penempatan', 'header', 12, '', 1, 0, NULL, NULL, NULL, NULL),
(51, 50, 'Disposisi Masuk', 'kabid/penempatan', 13, 'bi bi-person-lines-fill', 1, 0, NULL, NULL, NULL, NULL),
(52, NULL, 'Pantauan Aktif', 'header', 14, '', 1, 0, NULL, NULL, NULL, NULL),
(53, 52, 'Mahasiswa Aktif', 'kabid/riwayat', 15, 'bi bi-people', 1, 0, NULL, NULL, NULL, NULL),
(54, 52, 'Informasi Kuota', 'kabid/kuota', 16, 'bi bi-pie-chart', 1, 0, NULL, NULL, NULL, NULL),
(55, 52, 'Verifikasi Logbook', 'kabid/verifikasi-logbook', 17, 'bi bi-journal-check', 1, 0, NULL, NULL, NULL, NULL),
(56, NULL, 'Dokumen & Kelulusan', 'header', 18, '', 1, 0, NULL, NULL, NULL, NULL),
(57, 56, 'Manajemen Dokumen', 'kabid/sertifikat', 19, 'bi bi-award', 1, 0, NULL, NULL, NULL, NULL);

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
(0, 2, 15, NULL, NULL),
(1, 2, 27, NULL, NULL),
(0, 3, 48, NULL, NULL),
(0, 3, 49, NULL, NULL),
(0, 3, 50, NULL, NULL),
(0, 3, 51, NULL, NULL),
(0, 3, 52, NULL, NULL),
(0, 3, 53, NULL, NULL),
(0, 3, 54, NULL, NULL),
(0, 3, 55, NULL, NULL),
(0, 3, 56, NULL, NULL),
(0, 3, 57, NULL, NULL);

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

--
-- Dumping data for table `c_user_pegawai`
--

INSERT INTO `c_user_pegawai` (`id_user_pegawai`, `nama`, `nip`, `password`, `kode_unor`, `id_user_group`, `id_bidang`, `status_aktif`, `file_tanda_tangan`, `last_login`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin Sekretariat', '12345678', '$2y$10$rUi8GkQGZ19rnYZlgbyiu.2FuzcmupYK0si5m9ZUObINJPX/FyZ3u', 'SEKRETARIAT', 2, NULL, 'AKTIF', NULL, NULL, NULL, NULL, NULL),
(2, 'Kepala Bidang Diseminasi Informasi', '87654321', '$2y$10$6GiTCr3yLI0BHFo28CptV.NJixAIk6hCxhK3DZyCfhnBP3kmlje0q', 'KABID', 3, 2, 'AKTIF', NULL, NULL, NULL, NULL, NULL),
(3, 'Kepala Bidang Sarana & Prasarana TIK', '87654322', '$2y$10$6GiTCr3yLI0BHFo28CptV.NJixAIk6hCxhK3DZyCfhnBP3kmlje0q', 'KABID', 3, 3, 'AKTIF', NULL, NULL, NULL, NULL, NULL),
(4, 'Kepala Bidang Statistik', '87654323', '$2y$10$6GiTCr3yLI0BHFo28CptV.NJixAIk6hCxhK3DZyCfhnBP3kmlje0q', 'KABID', 3, 4, 'AKTIF', NULL, NULL, NULL, NULL, NULL),
(5, 'Kepala Bidang Pengembangan E-Gov', '87654324', '$2y$10$6GiTCr3yLI0BHFo28CptV.NJixAIk6hCxhK3DZyCfhnBP3kmlje0q', 'KABID', 3, 5, 'AKTIF', NULL, NULL, NULL, NULL, NULL),
(6, 'Super Admin', '00000001', '$2y$12$jyxVZdiNdzAKeg7L1Opfd.jA4kWhwhZjrDdSTX1inbqX1ZVVE2wfa', 'SUPERADMIN', 1, NULL, 'AKTIF', NULL, NULL, NULL, NULL, NULL);

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
(0, '2026-08-09-000001', 'App\\Database\\Migrations\\MakeIdProdiNullable', 'default', 'App', 1786266000, 7),
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
(19, '2026-07-19-143442', 'App\\Database\\Migrations\\AddStatusToLogbookMagang', 'default', 'App', 1784471701, 2),
(20, '2026-07-20-014402', 'App\\Database\\Migrations\\CreateFileSelesaiMagang', 'default', 'App', 1784511912, 3),
(21, '2026-07-20-025916', 'App\\Database\\Migrations\\FixSertifikatMenus', 'default', 'App', 1784551157, 4),
(22, '2026-07-20-123852', 'App\\Database\\Migrations\\UpdateFileSelesaiToProses', 'default', 'App', 1784551157, 4),
(23, '2026-07-13-050000', 'App\\Database\\Migrations\\AddStatusVerifikasiToFilePermohonan', 'default', 'App', 1785483913, 5),
(24, '2026-07-28-023216', 'App\\Database\\Migrations\\RenameDeskripsiMagang', 'default', 'App', 1785483980, 6),
(25, '2026-07-29-132532', 'App\\Database\\Migrations\\AddBuktiKegiatanToLogbookMagang', 'default', 'App', 1785483980, 6),
(26, '2026-07-31-074358', 'App\\Database\\Migrations\\CreateLogPermohonanMagang', 'default', 'App', 1785483981, 6);

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

--
-- Dumping data for table `m_bidang`
--

INSERT INTO `m_bidang` (`id_bidang`, `id_opd`, `bidang`, `kode_bidang`, `status_aktif`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 1, 'Bidang Diseminasi Informasi Dan Komunikasi Publik', NULL, 1, NULL, NULL, NULL),
(3, 1, 'Bidang Sarana, Prasarana TIK dan Persandian', NULL, 1, NULL, NULL, NULL),
(4, 1, 'Bidang Statistik Dan Pemberdayaan TIK', NULL, 1, NULL, NULL, NULL),
(5, 1, 'Bidang Pengembangan E-Goverment', NULL, 1, NULL, NULL, NULL),
(6, 2, 'Bidang Pembinaan Pendidikan Anak Usia Dini (PAUD) dan Pendidikan Non Formal', NULL, 0, NULL, NULL, NULL),
(7, 2, 'Bidang Pembinaan Sekolah Dasar (SD/MI)', NULL, 0, NULL, NULL, NULL),
(8, 2, 'Bidang Pembinaan Sekolah Menengah (SMP/MTs)', NULL, 0, NULL, NULL, NULL),
(9, 2, 'Bidang Pembinaan Ketenagaan', NULL, 0, NULL, NULL, NULL),
(10, 3, 'Bidang Kepemudaan', NULL, 0, NULL, NULL, NULL),
(11, 3, 'Bidang Olahraga', NULL, 0, NULL, NULL, NULL),
(12, 4, 'Bidang Pengelolaan Informasi Administrasi Kependudukan dan Pemanfaatan Data', NULL, 0, NULL, NULL, NULL);

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

--
-- Dumping data for table `m_fakultas`
--

INSERT INTO `m_fakultas` (`id_fakultas`, `id_instansi_pendidikan`, `fakultas`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(10, 7, 'Ilmu Komputer', 'AKTIF', '2026-08-07 04:57:28', NULL, NULL),
(11, 7, 'Teknik', 'AKTIF', '2026-08-07 04:57:28', NULL, NULL);

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

--
-- Dumping data for table `m_file`
--

INSERT INTO `m_file` (`id_file`, `nama_file`, `kode_file`, `ekstensi`, `ukuran_maksimal`, `wajib_upload`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Surat Pengantar', NULL, NULL, NULL, 'YA', 'AKTIF', NULL, NULL, NULL),
(2, 'Surat Pengantar', NULL, NULL, NULL, 'YA', 'AKTIF', NULL, NULL, NULL),
(3, 'Curriculum Vitae (CV)', NULL, NULL, NULL, 'YA', 'AKTIF', NULL, NULL, NULL),
(4, 'Proposal / Sinopsis', NULL, NULL, NULL, 'YA', 'AKTIF', NULL, NULL, NULL),
(5, 'Surat Pengantar', NULL, NULL, NULL, 'YA', 'AKTIF', NULL, NULL, NULL),
(6, 'Surat Pengantar', NULL, NULL, NULL, 'YA', 'AKTIF', NULL, NULL, NULL),
(7, 'Proposal Uji Coba Produk', NULL, NULL, NULL, 'YA', 'AKTIF', NULL, NULL, NULL),
(8, 'Surat Keterangan Diterima', NULL, NULL, NULL, 'YA', 'AKTIF', NULL, NULL, NULL),
(9, 'Surat Keterangan Selesai Kegiatan', NULL, NULL, NULL, 'YA', 'AKTIF', NULL, NULL, NULL),
(10, 'Sertifikat / Bukti Kegiatan', NULL, NULL, NULL, 'YA', 'AKTIF', NULL, NULL, NULL),
(11, 'Kartu Tanda Mahasiswa (KTM)', NULL, NULL, NULL, 'YA', 'AKTIF', NULL, NULL, NULL),
(12, 'Kartu Pelajar', NULL, NULL, NULL, 'YA', 'AKTIF', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_file_permohonan`
--

CREATE TABLE `m_file_permohonan` (
  `id_file_permohonan` int(11) UNSIGNED NOT NULL,
  `id_jenis_permohonan` int(10) UNSIGNED NOT NULL,
  `id_file` int(10) UNSIGNED NOT NULL,
  `urutan` int(11) DEFAULT 1,
  `wajib` enum('YA','TIDAK') DEFAULT 'YA',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_file_permohonan`
--

INSERT INTO `m_file_permohonan` (`id_file_permohonan`, `id_jenis_permohonan`, `id_file`, `urutan`, `wajib`, `created_at`, `updated_at`) VALUES
(82, 1, 1, 1, 'YA', NULL, NULL),
(83, 1, 4, 1, 'YA', NULL, NULL),
(84, 1, 11, 1, 'YA', NULL, NULL),
(85, 2, 5, 1, 'YA', NULL, NULL),
(86, 2, 11, 1, 'YA', NULL, NULL),
(87, 3, 2, 1, 'YA', NULL, NULL),
(88, 3, 3, 1, 'YA', NULL, NULL),
(89, 3, 11, 1, 'YA', NULL, NULL),
(90, 4, 6, 1, 'YA', NULL, NULL),
(91, 4, 7, 1, 'YA', NULL, NULL),
(92, 4, 11, 1, 'YA', NULL, NULL),
(93, 5, 1, 1, 'YA', NULL, NULL),
(94, 5, 12, 2, 'YA', NULL, NULL),
(95, 5, 3, 3, 'YA', NULL, NULL);

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

--
-- Dumping data for table `m_instansi_pendidikan`
--

INSERT INTO `m_instansi_pendidikan` (`id_instansi_pendidikan`, `id_jenjang_pendidikan`, `instansi_pendidikan`, `jenis_instansi`, `alamat`, `email`, `no_telepon`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 5, 'Universitas Indonesia', 'NEGERI', NULL, NULL, NULL, 'AKTIF', '2026-08-07 04:57:28', NULL, NULL),
(8, 1, 'SMKN 1 Tangerang', 'NEGERI', NULL, NULL, NULL, 'AKTIF', '2026-08-07 04:57:28', NULL, NULL),
(16, 1, 'SMK PGRI 1 TANGERANG', 'SWASTA', NULL, NULL, NULL, 'AKTIF', '2026-08-09 09:17:04', NULL, NULL);

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

--
-- Dumping data for table `m_jenis_permohonan`
--

INSERT INTO `m_jenis_permohonan` (`id_jenis_permohonan`, `jenis_permohonan`, `deskripsi`, `durasi_minimal`, `durasi_maksimal`, `maksimal_hari_pengajuan`, `durasi_permohonan`, `menggunakan_kuota`, `menggunakan_logbook`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Skripsi / Tugas Akhir', NULL, 0, NULL, 0, NULL, 'YA', 'YA', NULL, NULL, NULL, NULL),
(2, 'Observasi / Pengambilan Data', NULL, 0, NULL, 0, NULL, 'YA', 'YA', NULL, NULL, NULL, NULL),
(3, 'Magang', NULL, 0, NULL, 0, NULL, 'YA', 'YA', NULL, NULL, NULL, NULL),
(4, 'Uji Coba Produk (Prototype)', NULL, 0, NULL, 0, NULL, 'YA', 'YA', NULL, NULL, NULL, NULL),
(5, 'Praktik Kerja Lapangan (PKL)', NULL, 0, NULL, 0, NULL, 'YA', 'YA', 'AKTIF', NULL, NULL, NULL);

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

--
-- Dumping data for table `m_jenjang_pendidikan`
--

INSERT INTO `m_jenjang_pendidikan` (`id_jenjang_pendidikan`, `nama_jenjang`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'SMA/SMK', 'AKTIF', '2026-08-07 04:57:28', NULL, NULL),
(3, 'D3', 'AKTIF', '2026-08-07 04:57:28', NULL, NULL),
(4, 'D4', 'AKTIF', '2026-08-07 04:57:28', NULL, NULL),
(5, 'S1', 'AKTIF', '2026-08-07 04:57:28', NULL, NULL),
(6, 'S2', 'AKTIF', '2026-08-07 04:57:28', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_kabupaten`
--

CREATE TABLE `m_kabupaten` (
  `id_kabupaten` int(10) UNSIGNED NOT NULL,
  `id_provinsi` int(10) UNSIGNED NOT NULL,
  `kode_kabupaten` varchar(10) NOT NULL,
  `nama_kabupaten` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_kabupaten`
--

INSERT INTO `m_kabupaten` (`id_kabupaten`, `id_provinsi`, `kode_kabupaten`, `nama_kabupaten`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '3601', 'KABUPATEN PANDEGLANG', '2026-08-07 06:38:25', NULL, NULL),
(2, 1, '3602', 'KABUPATEN LEBAK', '2026-08-07 06:38:53', NULL, NULL),
(3, 1, '3603', 'KABUPATEN TANGERANG', '2026-08-07 06:39:14', NULL, NULL),
(4, 1, '3604', 'KABUPATEN SERANG', '2026-08-07 06:39:34', NULL, NULL),
(5, 1, '3671', 'KOTA TANGERANG', '2026-08-07 06:39:56', NULL, NULL),
(6, 1, '3672', 'KOTA CILEGON', '2026-08-07 06:40:06', NULL, NULL),
(7, 1, '3673', 'KOTA SERANG', '2026-08-07 06:40:13', NULL, NULL),
(8, 1, '3674', 'KOTA TANGERANG SELATAN', '2026-08-07 06:40:18', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_kecamatan`
--

CREATE TABLE `m_kecamatan` (
  `id_kecamatan` int(10) UNSIGNED NOT NULL,
  `id_kabupaten` int(10) UNSIGNED NOT NULL,
  `kode_kecamatan` varchar(10) NOT NULL,
  `nama_kecamatan` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_kecamatan`
--

INSERT INTO `m_kecamatan` (`id_kecamatan`, `id_kabupaten`, `kode_kecamatan`, `nama_kecamatan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '3601010', 'SUMUR', '2026-08-07 06:38:25', NULL, NULL),
(2, 1, '3601020', 'CIMANGGU', '2026-08-07 06:38:26', NULL, NULL),
(3, 1, '3601030', 'CIBALIUNG', '2026-08-07 06:38:27', NULL, NULL),
(4, 1, '3601031', 'CIBITUNG', '2026-08-07 06:38:28', NULL, NULL),
(5, 1, '3601040', 'CIKEUSIK', '2026-08-07 06:38:28', NULL, NULL),
(6, 1, '3601050', 'CIGEULIS', '2026-08-07 06:38:29', NULL, NULL),
(7, 1, '3601060', 'PANIMBANG', '2026-08-07 06:38:30', NULL, NULL),
(8, 1, '3601061', 'SOBANG', '2026-08-07 06:38:31', NULL, NULL),
(9, 1, '3601070', 'MUNJUL', '2026-08-07 06:38:32', NULL, NULL),
(10, 1, '3601071', 'ANGSANA', '2026-08-07 06:38:32', NULL, NULL),
(11, 1, '3601072', 'SINDANGRESMI', '2026-08-07 06:38:33', NULL, NULL),
(12, 1, '3601080', 'PICUNG', '2026-08-07 06:38:34', NULL, NULL),
(13, 1, '3601090', 'BOJONG', '2026-08-07 06:38:34', NULL, NULL),
(14, 1, '3601100', 'SAKETI', '2026-08-07 06:38:35', NULL, NULL),
(15, 1, '3601101', 'CISATA', '2026-08-07 06:38:36', NULL, NULL),
(16, 1, '3601110', 'PAGELARAN', '2026-08-07 06:38:36', NULL, NULL),
(17, 1, '3601111', 'PATIA', '2026-08-07 06:38:37', NULL, NULL),
(18, 1, '3601112', 'SUKARESMI', '2026-08-07 06:38:38', NULL, NULL),
(19, 1, '3601120', 'LABUAN', '2026-08-07 06:38:38', NULL, NULL),
(20, 1, '3601121', 'CARITA', '2026-08-07 06:38:39', NULL, NULL),
(21, 1, '3601130', 'JIPUT', '2026-08-07 06:38:41', NULL, NULL),
(22, 1, '3601131', 'CIKEDAL', '2026-08-07 06:38:42', NULL, NULL),
(23, 1, '3601140', 'MENES', '2026-08-07 06:38:42', NULL, NULL),
(24, 1, '3601141', 'PULOSARI', '2026-08-07 06:38:43', NULL, NULL),
(25, 1, '3601150', 'MANDALAWANGI', '2026-08-07 06:38:44', NULL, NULL),
(26, 1, '3601160', 'CIMANUK', '2026-08-07 06:38:45', NULL, NULL),
(27, 1, '3601161', 'CIPEUCANG', '2026-08-07 06:38:45', NULL, NULL),
(28, 1, '3601170', 'BANJAR', '2026-08-07 06:38:46', NULL, NULL),
(29, 1, '3601171', 'KADUHEJO', '2026-08-07 06:38:47', NULL, NULL),
(30, 1, '3601172', 'MEKARJAYA', '2026-08-07 06:38:49', NULL, NULL),
(31, 1, '3601180', 'PANDEGLANG', '2026-08-07 06:38:49', NULL, NULL),
(32, 1, '3601181', 'MAJASARI', '2026-08-07 06:38:50', NULL, NULL),
(33, 1, '3601190', 'CADASARI', '2026-08-07 06:38:51', NULL, NULL),
(34, 1, '3601191', 'KARANGTANJUNG', '2026-08-07 06:38:52', NULL, NULL),
(35, 1, '3601192', 'KORONCONG', '2026-08-07 06:38:53', NULL, NULL),
(36, 2, '3602010', 'MALINGPING', '2026-08-07 06:38:54', NULL, NULL),
(37, 2, '3602011', 'WANASALAM', '2026-08-07 06:38:55', NULL, NULL),
(38, 2, '3602020', 'PANGGARANGAN', '2026-08-07 06:38:56', NULL, NULL),
(39, 2, '3602021', 'CIHARA', '2026-08-07 06:38:56', NULL, NULL),
(40, 2, '3602030', 'BAYAH', '2026-08-07 06:38:57', NULL, NULL),
(41, 2, '3602031', 'CILOGRANG', '2026-08-07 06:38:58', NULL, NULL),
(42, 2, '3602040', 'CIBEBER', '2026-08-07 06:38:58', NULL, NULL),
(43, 2, '3602050', 'CIJAKU', '2026-08-07 06:38:59', NULL, NULL),
(44, 2, '3602051', 'CIGEMBLONG', '2026-08-07 06:39:00', NULL, NULL),
(45, 2, '3602060', 'BANJARSARI', '2026-08-07 06:39:00', NULL, NULL),
(46, 2, '3602070', 'CILELES', '2026-08-07 06:39:01', NULL, NULL),
(47, 2, '3602080', 'GUNUNG KENCANA', '2026-08-07 06:39:02', NULL, NULL),
(48, 2, '3602090', 'BOJONGMANIK', '2026-08-07 06:39:02', NULL, NULL),
(49, 2, '3602091', 'CIRINTEN', '2026-08-07 06:39:03', NULL, NULL),
(50, 2, '3602100', 'LEUWIDAMAR', '2026-08-07 06:39:04', NULL, NULL),
(51, 2, '3602110', 'MUNCANG', '2026-08-07 06:39:04', NULL, NULL),
(52, 2, '3602111', 'SOBANG', '2026-08-07 06:39:05', NULL, NULL),
(53, 2, '3602120', 'CIPANAS', '2026-08-07 06:39:06', NULL, NULL),
(54, 2, '3602121', 'LEBAKGEDONG', '2026-08-07 06:39:07', NULL, NULL),
(55, 2, '3602130', 'SAJIRA', '2026-08-07 06:39:08', NULL, NULL),
(56, 2, '3602140', 'CIMARGA', '2026-08-07 06:39:09', NULL, NULL),
(57, 2, '3602150', 'CIKULUR', '2026-08-07 06:39:10', NULL, NULL),
(58, 2, '3602160', 'WARUNGGUNUNG', '2026-08-07 06:39:10', NULL, NULL),
(59, 2, '3602170', 'CIBADAK', '2026-08-07 06:39:11', NULL, NULL),
(60, 2, '3602180', 'RANGKASBITUNG', '2026-08-07 06:39:12', NULL, NULL),
(61, 2, '3602181', 'KALANGANYAR', '2026-08-07 06:39:12', NULL, NULL),
(62, 2, '3602190', 'MAJA', '2026-08-07 06:39:13', NULL, NULL),
(63, 2, '3602191', 'CURUGBITUNG', '2026-08-07 06:39:13', NULL, NULL),
(64, 3, '3603010', 'CISOKA', '2026-08-07 06:39:14', NULL, NULL),
(65, 3, '3603011', 'SOLEAR', '2026-08-07 06:39:15', NULL, NULL),
(66, 3, '3603020', 'TIGARAKSA', '2026-08-07 06:39:16', NULL, NULL),
(67, 3, '3603021', 'JAMBE', '2026-08-07 06:39:16', NULL, NULL),
(68, 3, '3603030', 'CIKUPA', '2026-08-07 06:39:17', NULL, NULL),
(69, 3, '3603040', 'PANONGAN', '2026-08-07 06:39:18', NULL, NULL),
(70, 3, '3603050', 'CURUG', '2026-08-07 06:39:19', NULL, NULL),
(71, 3, '3603051', 'KELAPA DUA', '2026-08-07 06:39:19', NULL, NULL),
(72, 3, '3603060', 'LEGOK', '2026-08-07 06:39:20', NULL, NULL),
(73, 3, '3603070', 'PAGEDANGAN', '2026-08-07 06:39:21', NULL, NULL),
(74, 3, '3603081', 'CISAUK', '2026-08-07 06:39:21', NULL, NULL),
(75, 3, '3603120', 'PASARKEMIS', '2026-08-07 06:39:22', NULL, NULL),
(76, 3, '3603121', 'SINDANG JAYA', '2026-08-07 06:39:22', NULL, NULL),
(77, 3, '3603130', 'BALARAJA', '2026-08-07 06:39:23', NULL, NULL),
(78, 3, '3603131', 'JAYANTI', '2026-08-07 06:39:24', NULL, NULL),
(79, 3, '3603132', 'SUKAMULYA', '2026-08-07 06:39:24', NULL, NULL),
(80, 3, '3603140', 'KRESEK', '2026-08-07 06:39:25', NULL, NULL),
(81, 3, '3603141', 'GUNUNG KALER', '2026-08-07 06:39:26', NULL, NULL),
(82, 3, '3603150', 'KRONJO', '2026-08-07 06:39:27', NULL, NULL),
(83, 3, '3603151', 'MEKAR BARU', '2026-08-07 06:39:27', NULL, NULL),
(84, 3, '3603160', 'MAUK', '2026-08-07 06:39:28', NULL, NULL),
(85, 3, '3603161', 'KEMIRI', '2026-08-07 06:39:28', NULL, NULL),
(86, 3, '3603162', 'SUKADIRI', '2026-08-07 06:39:29', NULL, NULL),
(87, 3, '3603170', 'RAJEG', '2026-08-07 06:39:30', NULL, NULL),
(88, 3, '3603180', 'SEPATAN', '2026-08-07 06:39:31', NULL, NULL),
(89, 3, '3603181', 'SEPATAN TIMUR', '2026-08-07 06:39:31', NULL, NULL),
(90, 3, '3603190', 'PAKUHAJI', '2026-08-07 06:39:32', NULL, NULL),
(91, 3, '3603200', 'TELUKNAGA', '2026-08-07 06:39:33', NULL, NULL),
(92, 3, '3603210', 'KOSAMBI', '2026-08-07 06:39:34', NULL, NULL),
(93, 4, '3604010', 'CINANGKA', '2026-08-07 06:39:35', NULL, NULL),
(94, 4, '3604020', 'PADARINCANG', '2026-08-07 06:39:36', NULL, NULL),
(95, 4, '3604030', 'CIOMAS', '2026-08-07 06:39:37', NULL, NULL),
(96, 4, '3604040', 'PABUARAN', '2026-08-07 06:39:37', NULL, NULL),
(97, 4, '3604041', 'GUNUNG SARI', '2026-08-07 06:39:38', NULL, NULL),
(98, 4, '3604050', 'BAROS', '2026-08-07 06:39:39', NULL, NULL),
(99, 4, '3604060', 'PETIR', '2026-08-07 06:39:40', NULL, NULL),
(100, 4, '3604061', 'TUNJUNG TEJA', '2026-08-07 06:39:40', NULL, NULL),
(101, 4, '3604080', 'CIKEUSAL', '2026-08-07 06:39:41', NULL, NULL),
(102, 4, '3604090', 'PAMARAYAN', '2026-08-07 06:39:42', NULL, NULL),
(103, 4, '3604091', 'BANDUNG', '2026-08-07 06:39:42', NULL, NULL),
(104, 4, '3604100', 'JAWILAN', '2026-08-07 06:39:43', NULL, NULL),
(105, 4, '3604110', 'KOPO', '2026-08-07 06:39:44', NULL, NULL),
(106, 4, '3604120', 'CIKANDE', '2026-08-07 06:39:45', NULL, NULL),
(107, 4, '3604121', 'KIBIN', '2026-08-07 06:39:45', NULL, NULL),
(108, 4, '3604130', 'KRAGILAN', '2026-08-07 06:39:46', NULL, NULL),
(109, 4, '3604180', 'WARINGINKURUNG', '2026-08-07 06:39:47', NULL, NULL),
(110, 4, '3604190', 'MANCAK', '2026-08-07 06:39:48', NULL, NULL),
(111, 4, '3604200', 'ANYAR', '2026-08-07 06:39:49', NULL, NULL),
(112, 4, '3604210', 'BOJONEGARA', '2026-08-07 06:39:49', NULL, NULL),
(113, 4, '3604211', 'PULO AMPEL', '2026-08-07 06:39:50', NULL, NULL),
(114, 4, '3604220', 'KRAMATWATU', '2026-08-07 06:39:51', NULL, NULL),
(115, 4, '3604240', 'CIRUAS', '2026-08-07 06:39:51', NULL, NULL),
(116, 4, '3604250', 'PONTANG', '2026-08-07 06:39:52', NULL, NULL),
(117, 4, '3604251', 'LEBAK WANGI', '2026-08-07 06:39:53', NULL, NULL),
(118, 4, '3604260', 'CARENANG', '2026-08-07 06:39:53', NULL, NULL),
(119, 4, '3604261', 'BINUANG', '2026-08-07 06:39:54', NULL, NULL),
(120, 4, '3604270', 'TIRTAYASA', '2026-08-07 06:39:55', NULL, NULL),
(121, 4, '3604271', 'TANARA', '2026-08-07 06:39:56', NULL, NULL),
(122, 5, '3671010', 'CILEDUG', '2026-08-07 06:39:57', NULL, NULL),
(123, 5, '3671011', 'LARANGAN', '2026-08-07 06:39:58', NULL, NULL),
(124, 5, '3671012', 'KARANG TENGAH', '2026-08-07 06:39:58', NULL, NULL),
(125, 5, '3671020', 'CIPONDOH', '2026-08-07 06:39:59', NULL, NULL),
(126, 5, '3671021', 'PINANG', '2026-08-07 06:40:00', NULL, NULL),
(127, 5, '3671030', 'TANGERANG', '2026-08-07 06:40:00', NULL, NULL),
(128, 5, '3671031', 'KARAWACI', '2026-08-07 06:40:01', NULL, NULL),
(129, 5, '3671040', 'JATI UWUNG', '2026-08-07 06:40:02', NULL, NULL),
(130, 5, '3671041', 'CIBODAS', '2026-08-07 06:40:02', NULL, NULL),
(131, 5, '3671042', 'PERIUK', '2026-08-07 06:40:03', NULL, NULL),
(132, 5, '3671050', 'BATUCEPER', '2026-08-07 06:40:04', NULL, NULL),
(133, 5, '3671051', 'NEGLASARI', '2026-08-07 06:40:04', NULL, NULL),
(134, 5, '3671060', 'BENDA', '2026-08-07 06:40:05', NULL, NULL),
(135, 6, '3672010', 'CIWANDAN', '2026-08-07 06:40:06', NULL, NULL),
(136, 6, '3672011', 'CITANGKIL', '2026-08-07 06:40:07', NULL, NULL),
(137, 6, '3672020', 'PULOMERAK', '2026-08-07 06:40:08', NULL, NULL),
(138, 6, '3672021', 'PURWAKARTA', '2026-08-07 06:40:09', NULL, NULL),
(139, 6, '3672022', 'GROGOL', '2026-08-07 06:40:10', NULL, NULL),
(140, 6, '3672030', 'CILEGON', '2026-08-07 06:40:10', NULL, NULL),
(141, 6, '3672031', 'JOMBANG', '2026-08-07 06:40:11', NULL, NULL),
(142, 6, '3672040', 'CIBEBER', '2026-08-07 06:40:11', NULL, NULL),
(143, 7, '3673010', 'CURUG', '2026-08-07 06:40:13', NULL, NULL),
(144, 7, '3673020', 'WALANTAKA', '2026-08-07 06:40:14', NULL, NULL),
(145, 7, '3673030', 'CIPOCOK JAYA', '2026-08-07 06:40:15', NULL, NULL),
(146, 7, '3673040', 'SERANG', '2026-08-07 06:40:16', NULL, NULL),
(147, 7, '3673050', 'TAKTAKAN', '2026-08-07 06:40:17', NULL, NULL),
(148, 7, '3673060', 'KASEMEN', '2026-08-07 06:40:17', NULL, NULL),
(149, 8, '3674010', 'SETU', '2026-08-07 06:40:19', NULL, NULL),
(150, 8, '3674020', 'SERPONG', '2026-08-07 06:40:19', NULL, NULL),
(151, 8, '3674030', 'PAMULANG', '2026-08-07 06:40:20', NULL, NULL),
(152, 8, '3674040', 'CIPUTAT', '2026-08-07 06:40:21', NULL, NULL),
(153, 8, '3674050', 'CIPUTAT TIMUR', '2026-08-07 06:40:21', NULL, NULL),
(154, 8, '3674060', 'PONDOK AREN', '2026-08-07 06:40:22', NULL, NULL),
(155, 8, '3674070', 'SERPONG UTARA', '2026-08-07 06:40:22', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_kelurahan`
--

CREATE TABLE `m_kelurahan` (
  `id_kelurahan` int(10) UNSIGNED NOT NULL,
  `id_kecamatan` int(10) UNSIGNED NOT NULL,
  `kode_kelurahan` varchar(10) NOT NULL,
  `nama_kelurahan` varchar(100) NOT NULL,
  `kode_pos` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_kelurahan`
--

INSERT INTO `m_kelurahan` (`id_kelurahan`, `id_kecamatan`, `kode_kelurahan`, `nama_kelurahan`, `kode_pos`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '3601010001', 'UJUNGJAYA', '00000', '2026-08-07 06:38:26', NULL, NULL),
(2, 1, '3601010002', 'TAMANJAYA', '00000', '2026-08-07 06:38:26', NULL, NULL),
(3, 1, '3601010003', 'CIGORONDONG', '00000', '2026-08-07 06:38:26', NULL, NULL),
(4, 1, '3601010004', 'TUNGGALJAYA', '00000', '2026-08-07 06:38:26', NULL, NULL),
(5, 1, '3601010005', 'KERTAMUKTI', '00000', '2026-08-07 06:38:26', NULL, NULL),
(6, 1, '3601010006', 'KERTAJAYA', '00000', '2026-08-07 06:38:26', NULL, NULL),
(7, 1, '3601010007', 'SUMBERJAYA', '00000', '2026-08-07 06:38:26', NULL, NULL),
(8, 2, '3601020001', 'RANCAPINANG', '00000', '2026-08-07 06:38:27', NULL, NULL),
(9, 2, '3601020002', 'CIBADAK', '00000', '2026-08-07 06:38:27', NULL, NULL),
(10, 2, '3601020003', 'BATUHIDEUNG', '00000', '2026-08-07 06:38:27', NULL, NULL),
(11, 2, '3601020005', 'KRAMATJAYA', '00000', '2026-08-07 06:38:27', NULL, NULL),
(12, 2, '3601020006', 'MANGKUALAM', '00000', '2026-08-07 06:38:27', NULL, NULL),
(13, 2, '3601020007', 'PADASUKA', '00000', '2026-08-07 06:38:27', NULL, NULL),
(14, 2, '3601020008', 'CIBURIAL', '00000', '2026-08-07 06:38:27', NULL, NULL),
(15, 2, '3601020009', 'WARINGINKURUNG', '00000', '2026-08-07 06:38:27', NULL, NULL),
(16, 2, '3601020010', 'CIJARALANG', '00000', '2026-08-07 06:38:27', NULL, NULL),
(17, 2, '3601020011', 'CIMANGGU', '00000', '2026-08-07 06:38:27', NULL, NULL),
(18, 2, '3601020012', 'TANGKILSARI', '00000', '2026-08-07 06:38:27', NULL, NULL),
(19, 3, '3601030011', 'SUKAJADI', '00000', '2026-08-07 06:38:28', NULL, NULL),
(20, 3, '3601030012', 'SUDIMANIK', '00000', '2026-08-07 06:38:28', NULL, NULL),
(21, 3, '3601030013', 'SORONGAN', '00000', '2026-08-07 06:38:28', NULL, NULL),
(22, 3, '3601030015', 'CIHANJUANG', '00000', '2026-08-07 06:38:28', NULL, NULL),
(23, 3, '3601030016', 'CIBINGBIN', '00000', '2026-08-07 06:38:28', NULL, NULL),
(24, 3, '3601030017', 'CIBALIUNG', '00000', '2026-08-07 06:38:28', NULL, NULL),
(25, 3, '3601030019', 'MAHENDRA', '00000', '2026-08-07 06:38:28', NULL, NULL),
(26, 4, '3601031001', 'CITELUK', '00000', '2026-08-07 06:38:28', NULL, NULL),
(27, 4, '3601031002', 'SINDANGKERTA', '00000', '2026-08-07 06:38:28', NULL, NULL),
(28, 4, '3601031003', 'KIARAJANGKUNG', '00000', '2026-08-07 06:38:28', NULL, NULL),
(29, 4, '3601031004', 'KUTAKARANG', '00000', '2026-08-07 06:38:28', NULL, NULL),
(30, 4, '3601031005', 'CIKIRUH', '00000', '2026-08-07 06:38:28', NULL, NULL),
(31, 4, '3601031006', 'MALANGNENGAH', '00000', '2026-08-07 06:38:28', NULL, NULL),
(32, 4, '3601031007', 'CIKADU', '00000', '2026-08-07 06:38:28', NULL, NULL),
(33, 4, '3601031008', 'MANGLID', '00000', '2026-08-07 06:38:28', NULL, NULL),
(34, 4, '3601031009', 'KIARAPAYUNG', '00000', '2026-08-07 06:38:28', NULL, NULL),
(35, 4, '3601031010', 'CIKALONG', '00000', '2026-08-07 06:38:28', NULL, NULL),
(36, 5, '3601040001', 'TANJUNGAN', '00000', '2026-08-07 06:38:29', NULL, NULL),
(37, 5, '3601040002', 'CIKIRUHWETAN', '00000', '2026-08-07 06:38:29', NULL, NULL),
(38, 5, '3601040003', 'SUKAWARIS', '00000', '2026-08-07 06:38:29', NULL, NULL),
(39, 5, '3601040004', 'SUMURBATU', '00000', '2026-08-07 06:38:29', NULL, NULL),
(40, 5, '3601040005', 'UMBULAN', '00000', '2026-08-07 06:38:29', NULL, NULL),
(41, 5, '3601040006', 'SUKAMULYA', '00000', '2026-08-07 06:38:29', NULL, NULL),
(42, 5, '3601040007', 'PARUNGKOKOSAN', '00000', '2026-08-07 06:38:29', NULL, NULL),
(43, 5, '3601040008', 'NANGGALA', '00000', '2026-08-07 06:38:29', NULL, NULL),
(44, 5, '3601040009', 'RANCASENENG', '00000', '2026-08-07 06:38:29', NULL, NULL),
(45, 5, '3601040010', 'SUKASENENG', '00000', '2026-08-07 06:38:29', NULL, NULL),
(46, 5, '3601040011', 'CIKEUSIK', '00000', '2026-08-07 06:38:29', NULL, NULL),
(47, 5, '3601040012', 'LEUWIBALANG', '00000', '2026-08-07 06:38:29', NULL, NULL),
(48, 5, '3601040013', 'CURUGCIUNG', '00000', '2026-08-07 06:38:29', NULL, NULL),
(49, 5, '3601040014', 'CIKADONGDONG', '00000', '2026-08-07 06:38:29', NULL, NULL),
(50, 6, '3601050001', 'BANYUASIH', '00000', '2026-08-07 06:38:30', NULL, NULL),
(51, 6, '3601050002', 'KARANGBOLONG', '00000', '2026-08-07 06:38:30', NULL, NULL),
(52, 6, '3601050003', 'KARYABUANA', '00000', '2026-08-07 06:38:30', NULL, NULL),
(53, 6, '3601050004', 'KATUMBIRI', '00000', '2026-08-07 06:38:30', NULL, NULL),
(54, 6, '3601050005', 'WARINGINJAYA', '00000', '2026-08-07 06:38:30', NULL, NULL),
(55, 6, '3601050006', 'SINARJAYA', '00000', '2026-08-07 06:38:30', NULL, NULL),
(56, 6, '3601050007', 'CISEUREUHEUN', '00000', '2026-08-07 06:38:30', NULL, NULL),
(57, 6, '3601050009', 'CIGEULIS', '00000', '2026-08-07 06:38:30', NULL, NULL),
(58, 6, '3601050010', 'TARUMANAGARA', '00000', '2026-08-07 06:38:30', NULL, NULL),
(59, 7, '3601060007', 'MEKARJAYA', '00000', '2026-08-07 06:38:31', NULL, NULL),
(60, 7, '3601060008', 'GOMBONG', '00000', '2026-08-07 06:38:31', NULL, NULL),
(61, 7, '3601060009', 'PANIMBANGJAYA', '00000', '2026-08-07 06:38:31', NULL, NULL),
(62, 7, '3601060010', 'MEKARSARI', '00000', '2026-08-07 06:38:31', NULL, NULL),
(63, 7, '3601060011', 'CITEUREUP', '00000', '2026-08-07 06:38:31', NULL, NULL),
(64, 7, '3601060012', 'TANJUNGJAYA', '00000', '2026-08-07 06:38:31', NULL, NULL),
(65, 8, '3601061001', 'CIMANIS', '00000', '2026-08-07 06:38:32', NULL, NULL),
(66, 8, '3601061002', 'PANGKALAN', '00000', '2026-08-07 06:38:32', NULL, NULL),
(67, 8, '3601061003', 'SOBANG', '00000', '2026-08-07 06:38:32', NULL, NULL),
(68, 8, '3601061004', 'KUTAMEKAR', '00000', '2026-08-07 06:38:32', NULL, NULL),
(69, 8, '3601061005', 'BOJEN', '00000', '2026-08-07 06:38:32', NULL, NULL),
(70, 8, '3601061006', 'KERTARAHARJA', '00000', '2026-08-07 06:38:32', NULL, NULL),
(71, 8, '3601061007', 'TELUKLADA', '00000', '2026-08-07 06:38:32', NULL, NULL),
(72, 8, '3601061008', 'BOJENWETAN', '00000', '2026-08-07 06:38:32', NULL, NULL),
(73, 9, '3601070003', 'LEBAK', '00000', '2026-08-07 06:38:32', NULL, NULL),
(74, 9, '3601070004', 'GUNUNGBATU', '00000', '2026-08-07 06:38:32', NULL, NULL),
(75, 9, '3601070005', 'PANACARAN', '00000', '2026-08-07 06:38:32', NULL, NULL),
(76, 9, '3601070006', 'CURUGLANGLANG', '00000', '2026-08-07 06:38:32', NULL, NULL),
(77, 9, '3601070008', 'CIBITUNG', '00000', '2026-08-07 06:38:32', NULL, NULL),
(78, 9, '3601070018', 'KOTADUKUH', '00000', '2026-08-07 06:38:32', NULL, NULL),
(79, 9, '3601070019', 'PASANGGRAHAN', '00000', '2026-08-07 06:38:32', NULL, NULL),
(80, 9, '3601070020', 'SUKASABA', '00000', '2026-08-07 06:38:32', NULL, NULL),
(81, 10, '3601071001', 'CIPINANG', '00000', '2026-08-07 06:38:33', NULL, NULL),
(82, 10, '3601071002', 'KADUBADAK', '00000', '2026-08-07 06:38:33', NULL, NULL),
(83, 10, '3601071004', 'CIKAYAS', '00000', '2026-08-07 06:38:33', NULL, NULL),
(84, 10, '3601071005', 'SUMURLABAN', '00000', '2026-08-07 06:38:33', NULL, NULL),
(85, 10, '3601071006', 'PADAMULYA', '00000', '2026-08-07 06:38:33', NULL, NULL),
(86, 10, '3601071007', 'PADAHERANG', '00000', '2026-08-07 06:38:33', NULL, NULL),
(87, 10, '3601071008', 'KARANGSARI', '00000', '2026-08-07 06:38:33', NULL, NULL),
(88, 10, '3601071009', 'ANGSANA', '00000', '2026-08-07 06:38:33', NULL, NULL),
(89, 10, '3601071010', 'KRAMATMANIK', '00000', '2026-08-07 06:38:33', NULL, NULL),
(90, 11, '3601072001', 'PASIRLOA', '00000', '2026-08-07 06:38:34', NULL, NULL),
(91, 11, '3601072002', 'BOJONGMANIK', '00000', '2026-08-07 06:38:34', NULL, NULL),
(92, 11, '3601072003', 'CAMPAKAWARNA', '00000', '2026-08-07 06:38:34', NULL, NULL),
(93, 11, '3601072004', 'CIODENG', '00000', '2026-08-07 06:38:34', NULL, NULL),
(94, 11, '3601072005', 'PASIRTENJO', '00000', '2026-08-07 06:38:34', NULL, NULL),
(95, 11, '3601072006', 'SINDANGRESMI', '00000', '2026-08-07 06:38:34', NULL, NULL),
(96, 11, '3601072007', 'PASIRLANCAR', '00000', '2026-08-07 06:38:34', NULL, NULL),
(97, 11, '3601072008', 'PASIRDURUNG', '00000', '2026-08-07 06:38:34', NULL, NULL),
(98, 11, '3601072009', 'KADUMALATI', '00000', '2026-08-07 06:38:34', NULL, NULL),
(99, 12, '3601080001', 'CIHERANG', '00000', '2026-08-07 06:38:34', NULL, NULL),
(100, 12, '3601080002', 'KOLELET', '00000', '2026-08-07 06:38:34', NULL, NULL),
(101, 12, '3601080003', 'CILILITAN', '00000', '2026-08-07 06:38:34', NULL, NULL),
(102, 12, '3601080004', 'KADUPANDAK', '00000', '2026-08-07 06:38:34', NULL, NULL),
(103, 12, '3601080005', 'BUNGURCOPONG', '00000', '2026-08-07 06:38:34', NULL, NULL),
(104, 12, '3601080006', 'PASIRSEDANG', '00000', '2026-08-07 06:38:34', NULL, NULL),
(105, 12, '3601080007', 'PASIRPANJANG', '00000', '2026-08-07 06:38:34', NULL, NULL),
(106, 12, '3601080008', 'KADUBERA', '00000', '2026-08-07 06:38:34', NULL, NULL),
(107, 12, '3601080009', 'GANGGAENG', '00000', '2026-08-07 06:38:34', NULL, NULL),
(108, 13, '3601090002', 'MEKARSARI', '00000', '2026-08-07 06:38:35', NULL, NULL),
(109, 13, '3601090003', 'CIJAKAN', '00000', '2026-08-07 06:38:35', NULL, NULL),
(110, 13, '3601090004', 'CITUMENGGUNG', '00000', '2026-08-07 06:38:35', NULL, NULL),
(111, 13, '3601090005', 'CAHAYAMEKAR', '00000', '2026-08-07 06:38:35', NULL, NULL),
(112, 13, '3601090006', 'BOJONG', '00000', '2026-08-07 06:38:35', NULL, NULL),
(113, 13, '3601090007', 'BANYUMAS', '00000', '2026-08-07 06:38:35', NULL, NULL),
(114, 13, '3601090008', 'MANGGUNGJAYA', '00000', '2026-08-07 06:38:35', NULL, NULL),
(115, 14, '3601100005', 'SUKALANGU', '00000', '2026-08-07 06:38:36', NULL, NULL),
(116, 14, '3601100006', 'LANGENSARI', '00000', '2026-08-07 06:38:36', NULL, NULL),
(117, 14, '3601100008', 'MAJAU', '00000', '2026-08-07 06:38:36', NULL, NULL),
(118, 14, '3601100009', 'MEDALSARI', '00000', '2026-08-07 06:38:36', NULL, NULL),
(119, 14, '3601100010', 'SODONG', '00000', '2026-08-07 06:38:36', NULL, NULL),
(120, 14, '3601100011', 'MEKARWANGI', '00000', '2026-08-07 06:38:36', NULL, NULL),
(121, 14, '3601100012', 'CIANDUR', '00000', '2026-08-07 06:38:36', NULL, NULL),
(122, 14, '3601100013', 'SAKETI', '00000', '2026-08-07 06:38:36', NULL, NULL),
(123, 14, '3601100014', 'KADUDAMPIT', '00000', '2026-08-07 06:38:36', NULL, NULL),
(124, 14, '3601100015', 'GIRIJAYA', '00000', '2026-08-07 06:38:36', NULL, NULL),
(125, 14, '3601100016', 'WANAGIRI', '00000', '2026-08-07 06:38:36', NULL, NULL),
(126, 14, '3601100017', 'PARIGI', '00000', '2026-08-07 06:38:36', NULL, NULL),
(127, 14, '3601100018', 'TALAGASARI', '00000', '2026-08-07 06:38:36', NULL, NULL),
(128, 14, '3601100019', 'SINDANGHAYU', '00000', '2026-08-07 06:38:36', NULL, NULL),
(129, 15, '3601101001', 'KONDANGJAYA', '00000', '2026-08-07 06:38:36', NULL, NULL),
(130, 15, '3601101002', 'KUBANGKONDANG', '00000', '2026-08-07 06:38:36', NULL, NULL),
(131, 15, '3601101003', 'CISEREH', '00000', '2026-08-07 06:38:36', NULL, NULL),
(132, 15, '3601101004', 'CIBARANI', '00000', '2026-08-07 06:38:36', NULL, NULL),
(133, 15, '3601101005', 'RAWASARI', '00000', '2026-08-07 06:38:36', NULL, NULL),
(134, 15, '3601101006', 'PASIREURIH', '00000', '2026-08-07 06:38:36', NULL, NULL),
(135, 15, '3601101007', 'KADURONYOK', '00000', '2026-08-07 06:38:36', NULL, NULL),
(136, 15, '3601101008', 'CIHERANGJAYA', '00000', '2026-08-07 06:38:36', NULL, NULL),
(137, 15, '3601101009', 'PALEMBANG', '00000', '2026-08-07 06:38:36', NULL, NULL),
(138, 16, '3601110020', 'TEGALPAPAK', '00000', '2026-08-07 06:38:37', NULL, NULL),
(139, 16, '3601110021', 'MARGAGIRI', '00000', '2026-08-07 06:38:37', NULL, NULL),
(140, 16, '3601110022', 'BAMA', '00000', '2026-08-07 06:38:37', NULL, NULL),
(141, 16, '3601110023', 'PAGELARAN', '00000', '2026-08-07 06:38:37', NULL, NULL),
(142, 16, '3601110024', 'SUKADAME', '00000', '2026-08-07 06:38:37', NULL, NULL),
(143, 16, '3601110025', 'BULAGOR', '00000', '2026-08-07 06:38:37', NULL, NULL),
(144, 16, '3601110026', 'SURAKARTA', '00000', '2026-08-07 06:38:37', NULL, NULL),
(145, 16, '3601110027', 'HARAPANKARYA', '00000', '2026-08-07 06:38:37', NULL, NULL),
(146, 16, '3601110029', 'MONTOR', '00000', '2026-08-07 06:38:37', NULL, NULL),
(147, 16, '3601110030', 'KARTASANA', '00000', '2026-08-07 06:38:37', NULL, NULL),
(148, 16, '3601110031', 'SENANGSARI', '00000', '2026-08-07 06:38:37', NULL, NULL),
(149, 16, '3601110032', 'SINDANGLAYA', '00000', '2026-08-07 06:38:37', NULL, NULL),
(150, 16, '3601110033', 'MARGASANA', '00000', '2026-08-07 06:38:37', NULL, NULL),
(151, 17, '3601111009', 'PASIRGADUNG', '00000', '2026-08-07 06:38:38', NULL, NULL),
(152, 17, '3601111010', 'PATIA', '00000', '2026-08-07 06:38:38', NULL, NULL),
(153, 17, '3601111011', 'BABAKANKEUSIK', '00000', '2026-08-07 06:38:38', NULL, NULL),
(154, 17, '3601111012', 'CIMOYAN', '00000', '2026-08-07 06:38:38', NULL, NULL),
(155, 17, '3601111013', 'IDAMAN', '00000', '2026-08-07 06:38:38', NULL, NULL),
(156, 17, '3601111014', 'CIAWI', '00000', '2026-08-07 06:38:38', NULL, NULL),
(157, 17, '3601111015', 'SURIANEUN', '00000', '2026-08-07 06:38:38', NULL, NULL),
(158, 17, '3601111016', 'RAHAYU', '00000', '2026-08-07 06:38:38', NULL, NULL),
(159, 17, '3601111017', 'SIMPANGTIGA', '00000', '2026-08-07 06:38:38', NULL, NULL),
(160, 18, '3601112001', 'SEUSEUPAN', '00000', '2026-08-07 06:38:38', NULL, NULL),
(161, 18, '3601112002', 'KARYASARI', '00000', '2026-08-07 06:38:38', NULL, NULL),
(162, 18, '3601112003', 'PASIRKADU', '00000', '2026-08-07 06:38:38', NULL, NULL),
(163, 18, '3601112004', 'PERDANA', '00000', '2026-08-07 06:38:38', NULL, NULL),
(164, 18, '3601112005', 'SUKARESMI', '00000', '2026-08-07 06:38:38', NULL, NULL),
(165, 18, '3601112006', 'KUBANGKAMPIL', '00000', '2026-08-07 06:38:38', NULL, NULL),
(166, 18, '3601112007', 'SIDAMUKTI', '00000', '2026-08-07 06:38:38', NULL, NULL),
(167, 18, '3601112008', 'CIBUNGUR', '00000', '2026-08-07 06:38:38', NULL, NULL),
(168, 18, '3601112010', 'CIKUYA', '00000', '2026-08-07 06:38:38', NULL, NULL),
(169, 19, '3601120001', 'CIGONDANG', '00000', '2026-08-07 06:38:39', NULL, NULL),
(170, 19, '3601120002', 'SUKAMAJU', '00000', '2026-08-07 06:38:39', NULL, NULL),
(171, 19, '3601120003', 'RANCATEUREUP', '00000', '2026-08-07 06:38:39', NULL, NULL),
(172, 19, '3601120004', 'KALANGANYAR', '00000', '2026-08-07 06:38:39', NULL, NULL),
(173, 19, '3601120005', 'LABUAN', '00000', '2026-08-07 06:38:39', NULL, NULL),
(174, 19, '3601120007', 'BANYUMEKAR', '00000', '2026-08-07 06:38:39', NULL, NULL),
(175, 19, '3601120008', 'BANYUBIRU', '00000', '2026-08-07 06:38:39', NULL, NULL),
(176, 19, '3601120009', 'CARINGIN', '00000', '2026-08-07 06:38:39', NULL, NULL),
(177, 20, '3601121001', 'PEJAMBEN', '00000', '2026-08-07 06:38:41', NULL, NULL),
(178, 20, '3601121002', 'BANJARMASIN', '00000', '2026-08-07 06:38:41', NULL, NULL),
(179, 20, '3601121003', 'TEMBONG', '00000', '2026-08-07 06:38:41', NULL, NULL),
(180, 20, '3601121004', 'SINDANGLAUT', '00000', '2026-08-07 06:38:41', NULL, NULL),
(181, 20, '3601121005', 'CARITA', '00000', '2026-08-07 06:38:41', NULL, NULL),
(182, 20, '3601121006', 'SUKAJADI', '00000', '2026-08-07 06:38:41', NULL, NULL),
(183, 20, '3601121007', 'SUKARAME', '00000', '2026-08-07 06:38:41', NULL, NULL),
(184, 20, '3601121008', 'SUKANAGARA', '00000', '2026-08-07 06:38:41', NULL, NULL),
(185, 20, '3601121009', 'KAWOYANG', '00000', '2026-08-07 06:38:41', NULL, NULL),
(186, 20, '3601121010', 'CINOYONG', '00000', '2026-08-07 06:38:41', NULL, NULL),
(187, 21, '3601130007', 'BANYURESMI', '00000', '2026-08-07 06:38:42', NULL, NULL),
(188, 21, '3601130008', 'SALAPRAYA', '00000', '2026-08-07 06:38:42', NULL, NULL),
(189, 21, '3601130009', 'PAMARAYAN', '00000', '2026-08-07 06:38:42', NULL, NULL),
(190, 21, '3601130010', 'SAMPANGBITUNG', '00000', '2026-08-07 06:38:42', NULL, NULL),
(191, 21, '3601130011', 'JIPUT', '00000', '2026-08-07 06:38:42', NULL, NULL),
(192, 21, '3601130012', 'SUKACAI', '00000', '2026-08-07 06:38:42', NULL, NULL),
(193, 21, '3601130013', 'TENJOLAHANG', '00000', '2026-08-07 06:38:42', NULL, NULL),
(194, 21, '3601130014', 'BABADSARI', '00000', '2026-08-07 06:38:42', NULL, NULL),
(195, 21, '3601130015', 'JANAKA', '00000', '2026-08-07 06:38:42', NULL, NULL),
(196, 21, '3601130016', 'SUKAMANAH', '00000', '2026-08-07 06:38:42', NULL, NULL),
(197, 21, '3601130018', 'SIKULAN', '00000', '2026-08-07 06:38:42', NULL, NULL),
(198, 21, '3601130019', 'CITAMAN', '00000', '2026-08-07 06:38:42', NULL, NULL),
(199, 21, '3601130020', 'JAYAMEKAR', '00000', '2026-08-07 06:38:42', NULL, NULL),
(200, 22, '3601131001', 'KARYAUTAMA', '00000', '2026-08-07 06:38:42', NULL, NULL),
(201, 22, '3601131002', 'TEGAL', '00000', '2026-08-07 06:38:42', NULL, NULL),
(202, 22, '3601131003', 'CIPICUNG', '00000', '2026-08-07 06:38:42', NULL, NULL),
(203, 22, '3601131004', 'KARYASARI', '00000', '2026-08-07 06:38:42', NULL, NULL),
(204, 22, '3601131005', 'DAHU', '00000', '2026-08-07 06:38:42', NULL, NULL),
(205, 22, '3601131006', 'BABAKANLOR', '00000', '2026-08-07 06:38:42', NULL, NULL),
(206, 22, '3601131007', 'MEKARJAYA', '00000', '2026-08-07 06:38:42', NULL, NULL),
(207, 22, '3601131008', 'PADAHAYU', '00000', '2026-08-07 06:38:42', NULL, NULL),
(208, 22, '3601131009', 'BANGKUYUNG', '00000', '2026-08-07 06:38:42', NULL, NULL),
(209, 22, '3601131010', 'CENING', '00000', '2026-08-07 06:38:42', NULL, NULL),
(210, 23, '3601140003', 'ALASWANGI', '00000', '2026-08-07 06:38:43', NULL, NULL),
(211, 23, '3601140004', 'TEGALWANGI', '00000', '2026-08-07 06:38:43', NULL, NULL),
(212, 23, '3601140006', 'KANANGA', '00000', '2026-08-07 06:38:43', NULL, NULL),
(213, 23, '3601140007', 'CILABANBULAN', '00000', '2026-08-07 06:38:43', NULL, NULL),
(214, 23, '3601140008', 'SINDANGKARYA', '00000', '2026-08-07 06:38:43', NULL, NULL),
(215, 23, '3601140009', 'CIGANDENG', '00000', '2026-08-07 06:38:43', NULL, NULL),
(216, 23, '3601140010', 'PURWARAJA', '00000', '2026-08-07 06:38:43', NULL, NULL),
(217, 23, '3601140013', 'KADUPAYUNG', '00000', '2026-08-07 06:38:43', NULL, NULL),
(218, 23, '3601140014', 'SUKAMANAH', '00000', '2026-08-07 06:38:43', NULL, NULL),
(219, 23, '3601140015', 'RAMAYA', '00000', '2026-08-07 06:38:43', NULL, NULL),
(220, 24, '3601141001', 'BANJARNEGARA', '00000', '2026-08-07 06:38:44', NULL, NULL),
(221, 24, '3601141002', 'KADUHEJO', '00000', '2026-08-07 06:38:44', NULL, NULL),
(222, 24, '3601141003', 'KORANJI', '00000', '2026-08-07 06:38:44', NULL, NULL),
(223, 24, '3601141004', 'SANGHIANGDENGDEK', '00000', '2026-08-07 06:38:44', NULL, NULL),
(224, 24, '3601141005', 'CILENTUNG', '00000', '2026-08-07 06:38:44', NULL, NULL),
(225, 24, '3601141006', 'KARYAWANGI', '00000', '2026-08-07 06:38:44', NULL, NULL),
(226, 24, '3601141007', 'BANJARWANGI', '00000', '2026-08-07 06:38:44', NULL, NULL),
(227, 24, '3601141008', 'SUKASARI', '00000', '2026-08-07 06:38:44', NULL, NULL),
(228, 24, '3601141009', 'SUKARAJA', '00000', '2026-08-07 06:38:44', NULL, NULL),
(229, 25, '3601150001', 'PANDAT', '00000', '2026-08-07 06:38:45', NULL, NULL),
(230, 25, '3601150002', 'CIKONENG', '00000', '2026-08-07 06:38:45', NULL, NULL),
(231, 25, '3601150003', 'GIRIPAWANA', '00000', '2026-08-07 06:38:45', NULL, NULL),
(232, 25, '3601150004', 'NEMBOL', '00000', '2026-08-07 06:38:45', NULL, NULL),
(233, 25, '3601150005', 'GUNUNGSARI', '00000', '2026-08-07 06:38:45', NULL, NULL),
(234, 25, '3601150006', 'KURUNGKAMBING', '00000', '2026-08-07 06:38:45', NULL, NULL),
(235, 25, '3601150007', 'MANDALASARI', '00000', '2026-08-07 06:38:45', NULL, NULL),
(236, 25, '3601150008', 'MANDALAWANGI', '00000', '2026-08-07 06:38:45', NULL, NULL),
(237, 25, '3601150009', 'PARI', '00000', '2026-08-07 06:38:45', NULL, NULL),
(238, 25, '3601150010', 'SINARJAYA', '00000', '2026-08-07 06:38:45', NULL, NULL),
(239, 25, '3601150011', 'SIRNAGALIH', '00000', '2026-08-07 06:38:45', NULL, NULL),
(240, 25, '3601150012', 'CURUGLEMO', '00000', '2026-08-07 06:38:45', NULL, NULL),
(241, 25, '3601150013', 'PANJANGJAYA', '00000', '2026-08-07 06:38:45', NULL, NULL),
(242, 25, '3601150014', 'CIKUMBUEUN', '00000', '2026-08-07 06:38:45', NULL, NULL),
(243, 25, '3601150015', 'RAMEA', '00000', '2026-08-07 06:38:45', NULL, NULL),
(244, 26, '3601160008', 'KADUDODOL', '00000', '2026-08-07 06:38:45', NULL, NULL),
(245, 26, '3601160009', 'GUNUNGDATAR', '00000', '2026-08-07 06:38:45', NULL, NULL),
(246, 26, '3601160011', 'SEKONG', '00000', '2026-08-07 06:38:45', NULL, NULL),
(247, 26, '3601160019', 'CIMANUK', '00000', '2026-08-07 06:38:45', NULL, NULL),
(248, 26, '3601160020', 'BATUBANTAR', '00000', '2026-08-07 06:38:45', NULL, NULL),
(249, 26, '3601160021', 'ROCEK', '00000', '2026-08-07 06:38:45', NULL, NULL),
(250, 26, '3601160022', 'KADUMADANG', '00000', '2026-08-07 06:38:45', NULL, NULL),
(251, 26, '3601160023', 'DALEMBALAR', '00000', '2026-08-07 06:38:45', NULL, NULL),
(252, 26, '3601160024', 'KUPAHANDAP', '00000', '2026-08-07 06:38:45', NULL, NULL),
(253, 26, '3601160025', 'KADUBUNGBANG', '00000', '2026-08-07 06:38:45', NULL, NULL),
(254, 27, '3601161001', 'CIKADUEUN', '00000', '2026-08-07 06:38:46', NULL, NULL),
(255, 27, '3601161002', 'KONCANG', '00000', '2026-08-07 06:38:46', NULL, NULL),
(256, 27, '3601161003', 'PASIRMAE', '00000', '2026-08-07 06:38:46', NULL, NULL),
(257, 27, '3601161004', 'PARUMASAN', '00000', '2026-08-07 06:38:46', NULL, NULL),
(258, 27, '3601161005', 'KADUGADUNG', '00000', '2026-08-07 06:38:46', NULL, NULL),
(259, 27, '3601161006', 'PALANYAR', '00000', '2026-08-07 06:38:46', NULL, NULL),
(260, 27, '3601161007', 'BATURANJANG', '00000', '2026-08-07 06:38:46', NULL, NULL),
(261, 27, '3601161008', 'KALANGGUNUNG', '00000', '2026-08-07 06:38:46', NULL, NULL),
(262, 27, '3601161009', 'CURUGBARANG', '00000', '2026-08-07 06:38:46', NULL, NULL),
(263, 27, '3601161010', 'PASIREURIH', '00000', '2026-08-07 06:38:46', NULL, NULL),
(264, 28, '3601170004', 'CIBEUREUM', '00000', '2026-08-07 06:38:47', NULL, NULL),
(265, 28, '3601170005', 'CIBODAS', '00000', '2026-08-07 06:38:47', NULL, NULL),
(266, 28, '3601170007', 'KADULIMUS', '00000', '2026-08-07 06:38:47', NULL, NULL),
(267, 28, '3601170008', 'BANDUNG', '00000', '2026-08-07 06:38:47', NULL, NULL),
(268, 28, '3601170009', 'KADUMANEUH', '00000', '2026-08-07 06:38:47', NULL, NULL),
(269, 28, '3601170010', 'CITALAHAB', '00000', '2026-08-07 06:38:47', NULL, NULL),
(270, 28, '3601170011', 'PASIRAWI', '00000', '2026-08-07 06:38:47', NULL, NULL),
(271, 28, '3601170012', 'MOGANA', '00000', '2026-08-07 06:38:47', NULL, NULL),
(272, 28, '3601170013', 'KADUBALE', '00000', '2026-08-07 06:38:47', NULL, NULL),
(273, 28, '3601170014', 'BANJAR', '00000', '2026-08-07 06:38:47', NULL, NULL),
(274, 28, '3601170015', 'GUNUNGPUTRI', '00000', '2026-08-07 06:38:47', NULL, NULL),
(275, 29, '3601171001', 'BANJARSARI', '00000', '2026-08-07 06:38:49', NULL, NULL),
(276, 29, '3601171002', 'SUKAMANAH', '00000', '2026-08-07 06:38:49', NULL, NULL),
(277, 29, '3601171003', 'PALURAHAN', '00000', '2026-08-07 06:38:49', NULL, NULL),
(278, 29, '3601171004', 'KADUGEMBLO', '00000', '2026-08-07 06:38:49', NULL, NULL),
(279, 29, '3601171005', 'SUKASARI', '00000', '2026-08-07 06:38:49', NULL, NULL),
(280, 29, '3601171006', 'MANDALASARI', '00000', '2026-08-07 06:38:49', NULL, NULL),
(281, 29, '3601171007', 'SANINTEN', '00000', '2026-08-07 06:38:49', NULL, NULL),
(282, 29, '3601171008', 'BAYUMUNDU', '00000', '2026-08-07 06:38:49', NULL, NULL),
(283, 29, '3601171009', 'CAMPAKA', '00000', '2026-08-07 06:38:49', NULL, NULL),
(284, 29, '3601171010', 'CIPUTRI', '00000', '2026-08-07 06:38:49', NULL, NULL),
(285, 30, '3601172001', 'RANCABUGEL', '00000', '2026-08-07 06:38:49', NULL, NULL),
(286, 30, '3601172002', 'WIRASINGA', '00000', '2026-08-07 06:38:49', NULL, NULL),
(287, 30, '3601172003', 'PAREANG', '00000', '2026-08-07 06:38:49', NULL, NULL),
(288, 30, '3601172004', 'KADUBELANG', '00000', '2026-08-07 06:38:49', NULL, NULL),
(289, 30, '3601172005', 'MEKARJAYA', '00000', '2026-08-07 06:38:49', NULL, NULL),
(290, 30, '3601172006', 'KADUJANGKUNG', '00000', '2026-08-07 06:38:49', NULL, NULL),
(291, 30, '3601172007', 'MEDONG', '00000', '2026-08-07 06:38:49', NULL, NULL),
(292, 30, '3601172008', 'SUKAMULYA', '00000', '2026-08-07 06:38:49', NULL, NULL),
(293, 31, '3601180003', 'KADOMAS', '00000', '2026-08-07 06:38:50', NULL, NULL),
(294, 31, '3601180004', 'BABAKAN KALANGANYAR', '00000', '2026-08-07 06:38:50', NULL, NULL),
(295, 31, '3601180005', 'KABAYAN', '00000', '2026-08-07 06:38:50', NULL, NULL),
(296, 31, '3601180006', 'PANDEGLANG', '00000', '2026-08-07 06:38:50', NULL, NULL),
(297, 32, '3601181001', 'SUKARATU', '00000', '2026-08-07 06:38:51', NULL, NULL),
(298, 32, '3601181002', 'KARATON', '00000', '2026-08-07 06:38:51', NULL, NULL),
(299, 32, '3601181003', 'CILAJA', '00000', '2026-08-07 06:38:51', NULL, NULL),
(300, 32, '3601181004', 'SARUNI', '00000', '2026-08-07 06:38:51', NULL, NULL),
(301, 32, '3601181005', 'PAGERBATU', '00000', '2026-08-07 06:38:51', NULL, NULL),
(302, 33, '3601190017', 'CIKENTRUNG', '00000', '2026-08-07 06:38:52', NULL, NULL),
(303, 33, '3601190018', 'KAUNGCAANG', '00000', '2026-08-07 06:38:52', NULL, NULL),
(304, 33, '3601190019', 'CIINJUK', '00000', '2026-08-07 06:38:52', NULL, NULL),
(305, 33, '3601190020', 'CADASARI', '00000', '2026-08-07 06:38:52', NULL, NULL),
(306, 33, '3601190021', 'TAPOS', '00000', '2026-08-07 06:38:52', NULL, NULL),
(307, 33, '3601190022', 'TANAGARA', '00000', '2026-08-07 06:38:52', NULL, NULL),
(308, 33, '3601190023', 'KURUNGDAHU', '00000', '2026-08-07 06:38:52', NULL, NULL),
(309, 33, '3601190024', 'PASIRPEUTEUY', '00000', '2026-08-07 06:38:52', NULL, NULL),
(310, 33, '3601190025', 'KADUENGANG', '00000', '2026-08-07 06:38:52', NULL, NULL),
(311, 33, '3601190026', 'KADUELA', '00000', '2026-08-07 06:38:52', NULL, NULL),
(312, 33, '3601190027', 'KORANJI', '00000', '2026-08-07 06:38:52', NULL, NULL),
(313, 34, '3601191005', 'KADUMERAK', '00000', '2026-08-07 06:38:53', NULL, NULL),
(314, 34, '3601191006', 'PAGADUNGAN', '00000', '2026-08-07 06:38:53', NULL, NULL),
(315, 34, '3601191007', 'CIGADUNG', '00000', '2026-08-07 06:38:53', NULL, NULL),
(316, 35, '3601192001', 'PASIRJAKSA', '00000', '2026-08-07 06:38:53', NULL, NULL),
(317, 35, '3601192002', 'BANGKONOL', '00000', '2026-08-07 06:38:53', NULL, NULL),
(318, 35, '3601192003', 'TEGALONGOK', '00000', '2026-08-07 06:38:53', NULL, NULL),
(319, 35, '3601192004', 'PASIRKARAG', '00000', '2026-08-07 06:38:53', NULL, NULL),
(320, 35, '3601192005', 'PANIIS', '00000', '2026-08-07 06:38:53', NULL, NULL),
(321, 35, '3601192006', 'SETRAJAYA', '00000', '2026-08-07 06:38:53', NULL, NULL),
(322, 35, '3601192007', 'KARANGSETRA', '00000', '2026-08-07 06:38:53', NULL, NULL),
(323, 35, '3601192008', 'PAKULURAN', '00000', '2026-08-07 06:38:53', NULL, NULL),
(324, 35, '3601192009', 'KORONCONG', '00000', '2026-08-07 06:38:53', NULL, NULL),
(325, 35, '3601192010', 'GERENDONG', '00000', '2026-08-07 06:38:53', NULL, NULL),
(326, 35, '3601192011', 'AWILEGA', '00000', '2026-08-07 06:38:53', NULL, NULL),
(327, 35, '3601192012', 'SUKAJAYA', '00000', '2026-08-07 06:38:53', NULL, NULL),
(328, 36, '3602010004', 'SUKAMANAH', '00000', '2026-08-07 06:38:55', NULL, NULL),
(329, 36, '3602010005', 'MALINGPING SELATAN', '00000', '2026-08-07 06:38:55', NULL, NULL),
(330, 36, '3602010006', 'CILANGKAHAN', '00000', '2026-08-07 06:38:55', NULL, NULL),
(331, 36, '3602010007', 'PAGELARAN', '00000', '2026-08-07 06:38:55', NULL, NULL),
(332, 36, '3602010008', 'KERSARATU', '00000', '2026-08-07 06:38:55', NULL, NULL),
(333, 36, '3602010009', 'SUKARAJA', '00000', '2026-08-07 06:38:55', NULL, NULL),
(334, 36, '3602010010', 'KADUJAJAR', '00000', '2026-08-07 06:38:55', NULL, NULL),
(335, 36, '3602010011', 'MALINGPING UTARA', '00000', '2026-08-07 06:38:55', NULL, NULL),
(336, 36, '3602010012', 'RAHONG', '00000', '2026-08-07 06:38:55', NULL, NULL),
(337, 36, '3602010013', 'SANGHIANG', '00000', '2026-08-07 06:38:55', NULL, NULL),
(338, 36, '3602010014', 'BOLANG', '00000', '2026-08-07 06:38:55', NULL, NULL),
(339, 36, '3602010023', 'SUMBER WARAS', '00000', '2026-08-07 06:38:55', NULL, NULL),
(340, 36, '3602010024', 'CIPEUNDEUY', '00000', '2026-08-07 06:38:55', NULL, NULL),
(341, 36, '3602010025', 'SENANGHATI', '00000', '2026-08-07 06:38:55', NULL, NULL),
(342, 37, '3602011001', 'MUARA', '00000', '2026-08-07 06:38:56', NULL, NULL),
(343, 37, '3602011002', 'WANASALAM', '00000', '2026-08-07 06:38:56', NULL, NULL),
(344, 37, '3602011003', 'SUKATANI', '00000', '2026-08-07 06:38:56', NULL, NULL),
(345, 37, '3602011004', 'CIKEUSIK', '00000', '2026-08-07 06:38:56', NULL, NULL),
(346, 37, '3602011005', 'BEJOD', '00000', '2026-08-07 06:38:56', NULL, NULL),
(347, 37, '3602011006', 'CIPEDANG', '00000', '2026-08-07 06:38:56', NULL, NULL),
(348, 37, '3602011007', 'CISARAP', '00000', '2026-08-07 06:38:56', NULL, NULL),
(349, 37, '3602011008', 'PARUNGSARI', '00000', '2026-08-07 06:38:56', NULL, NULL),
(350, 37, '3602011009', 'CIPEUCANG', '00000', '2026-08-07 06:38:56', NULL, NULL),
(351, 37, '3602011010', 'PARUNGPANJANG', '00000', '2026-08-07 06:38:56', NULL, NULL),
(352, 37, '3602011011', 'KETAPANG', '00000', '2026-08-07 06:38:56', NULL, NULL),
(353, 37, '3602011012', 'CILANGKAP', '00000', '2026-08-07 06:38:56', NULL, NULL),
(354, 37, '3602011013', 'KARANG PAMINDANGAN', '00000', '2026-08-07 06:38:56', NULL, NULL),
(355, 38, '3602020006', 'SITUREGEN', '00000', '2026-08-07 06:38:56', NULL, NULL),
(356, 38, '3602020007', 'SUKAJADI', '00000', '2026-08-07 06:38:56', NULL, NULL),
(357, 38, '3602020008', 'HEGARMANAH', '00000', '2026-08-07 06:38:56', NULL, NULL),
(358, 38, '3602020009', 'PANGGARANGAN', '00000', '2026-08-07 06:38:56', NULL, NULL),
(359, 38, '3602020010', 'MEKARJAYA', '00000', '2026-08-07 06:38:56', NULL, NULL),
(360, 38, '3602020011', 'SINDANGRATU', '00000', '2026-08-07 06:38:56', NULL, NULL),
(361, 38, '3602020012', 'CIMANDIRI', '00000', '2026-08-07 06:38:56', NULL, NULL),
(362, 38, '3602020017', 'SOGONG', '00000', '2026-08-07 06:38:56', NULL, NULL),
(363, 38, '3602020018', 'JATAKE', '00000', '2026-08-07 06:38:56', NULL, NULL),
(364, 38, '3602020019', 'CIBARENGKOK', '00000', '2026-08-07 06:38:56', NULL, NULL),
(365, 39, '3602021001', 'PONDOKPANJANG', '00000', '2026-08-07 06:38:57', NULL, NULL),
(366, 39, '3602021002', 'CIPARAHU', '00000', '2026-08-07 06:38:57', NULL, NULL),
(367, 39, '3602021003', 'CIHARA', '00000', '2026-08-07 06:38:57', NULL, NULL),
(368, 39, '3602021004', 'KARANGKAMULYAN', '00000', '2026-08-07 06:38:57', NULL, NULL),
(369, 39, '3602021005', 'PANYAUNGAN', '00000', '2026-08-07 06:38:57', NULL, NULL),
(370, 39, '3602021006', 'MEKARSARI', '00000', '2026-08-07 06:38:57', NULL, NULL),
(371, 39, '3602021007', 'LEBAK PEUNDEUY', '00000', '2026-08-07 06:38:57', NULL, NULL),
(372, 39, '3602021008', 'CITEPUSEUN', '00000', '2026-08-07 06:38:57', NULL, NULL),
(373, 39, '3602021009', 'BARUNAI', '00000', '2026-08-07 06:38:57', NULL, NULL),
(374, 40, '3602030001', 'BAYAH BARAT', '00000', '2026-08-07 06:38:58', NULL, NULL),
(375, 40, '3602030002', 'DARMASARI', '00000', '2026-08-07 06:38:58', NULL, NULL),
(376, 40, '3602030003', 'SAWARNA', '00000', '2026-08-07 06:38:58', NULL, NULL),
(377, 40, '3602030011', 'CIDIKIT', '00000', '2026-08-07 06:38:58', NULL, NULL),
(378, 40, '3602030012', 'BAYAH TIMUR', '00000', '2026-08-07 06:38:58', NULL, NULL),
(379, 40, '3602030013', 'CIMANCAK', '00000', '2026-08-07 06:38:58', NULL, NULL),
(380, 40, '3602030014', 'SUWAKAN', '00000', '2026-08-07 06:38:58', NULL, NULL),
(381, 40, '3602030015', 'PASIRGOMBONG', '00000', '2026-08-07 06:38:58', NULL, NULL),
(382, 40, '3602030016', 'CISUREN', '00000', '2026-08-07 06:38:58', NULL, NULL),
(383, 40, '3602030017', 'PAMUBULAN', '00000', '2026-08-07 06:38:58', NULL, NULL),
(384, 40, '3602030018', 'SAWARNA TIMUR', '00000', '2026-08-07 06:38:58', NULL, NULL),
(385, 41, '3602031001', 'CIBARENO', '00000', '2026-08-07 06:38:58', NULL, NULL),
(386, 41, '3602031002', 'CILOGRANG', '00000', '2026-08-07 06:38:58', NULL, NULL),
(387, 41, '3602031003', 'LEBAKTIPAR', '00000', '2026-08-07 06:38:58', NULL, NULL),
(388, 41, '3602031004', 'CIKATOMAS', '00000', '2026-08-07 06:38:58', NULL, NULL),
(389, 41, '3602031005', 'CIJENGKOL', '00000', '2026-08-07 06:38:58', NULL, NULL),
(390, 41, '3602031006', 'PASIRBUNGUR', '00000', '2026-08-07 06:38:58', NULL, NULL),
(391, 41, '3602031007', 'CIKAMUNDING', '00000', '2026-08-07 06:38:58', NULL, NULL),
(392, 41, '3602031008', 'GIRIMUKTI', '00000', '2026-08-07 06:38:58', NULL, NULL),
(393, 41, '3602031009', 'CIREUNDEU', '00000', '2026-08-07 06:38:58', NULL, NULL),
(394, 41, '3602031010', 'GUNUNGBATU', '00000', '2026-08-07 06:38:58', NULL, NULL),
(395, 42, '3602040001', 'CIKOTOK', '00000', '2026-08-07 06:38:59', NULL, NULL),
(396, 42, '3602040002', 'CIBEBER', '00000', '2026-08-07 06:38:59', NULL, NULL),
(397, 42, '3602040003', 'WARUNGBANTEN', '00000', '2026-08-07 06:38:59', NULL, NULL),
(398, 42, '3602040004', 'NEGLASARI', '00000', '2026-08-07 06:38:59', NULL, NULL),
(399, 42, '3602040005', 'MEKARSARI', '00000', '2026-08-07 06:38:59', NULL, NULL),
(400, 42, '3602040007', 'CIKADU', '00000', '2026-08-07 06:38:59', NULL, NULL),
(401, 42, '3602040008', 'KUJANGJAYA', '00000', '2026-08-07 06:38:59', NULL, NULL),
(402, 42, '3602040009', 'CISUNGSANG', '00000', '2026-08-07 06:38:59', NULL, NULL),
(403, 42, '3602040010', 'HEGARMANAH', '00000', '2026-08-07 06:38:59', NULL, NULL),
(404, 42, '3602040011', 'CIHAMBALI', '00000', '2026-08-07 06:38:59', NULL, NULL),
(405, 42, '3602040012', 'SUKAMULYA', '00000', '2026-08-07 06:38:59', NULL, NULL),
(406, 42, '3602040013', 'CITOREK TENGAH', '00000', '2026-08-07 06:38:59', NULL, NULL),
(407, 42, '3602040014', 'CITOREK TIMUR', '00000', '2026-08-07 06:38:59', NULL, NULL),
(408, 42, '3602040015', 'CITOREK KIDUL', '00000', '2026-08-07 06:38:59', NULL, NULL),
(409, 42, '3602040016', 'KUJANGSARI', '00000', '2026-08-07 06:38:59', NULL, NULL),
(410, 42, '3602040017', 'SITUMULYA', '00000', '2026-08-07 06:38:59', NULL, NULL),
(411, 42, '3602040018', 'SINARGALIH', '00000', '2026-08-07 06:38:59', NULL, NULL),
(412, 42, '3602040019', 'WANASARI', '00000', '2026-08-07 06:38:59', NULL, NULL),
(413, 42, '3602040020', 'GUNUNG WANGUN', '00000', '2026-08-07 06:38:59', NULL, NULL),
(414, 42, '3602040021', 'CITOREK BARAT', '00000', '2026-08-07 06:38:59', NULL, NULL),
(415, 42, '3602040022', 'CIHERANG', '00000', '2026-08-07 06:38:59', NULL, NULL),
(416, 42, '3602040023', 'CITOREK SABRANG', '00000', '2026-08-07 06:38:59', NULL, NULL),
(417, 43, '3602050001', 'KANDANGSAPI', '00000', '2026-08-07 06:39:00', NULL, NULL),
(418, 43, '3602050002', 'CIHUJAN', '00000', '2026-08-07 06:39:00', NULL, NULL),
(419, 43, '3602050003', 'CIAPUS', '00000', '2026-08-07 06:39:00', NULL, NULL),
(420, 43, '3602050005', 'CIJAKU', '00000', '2026-08-07 06:39:00', NULL, NULL),
(421, 43, '3602050006', 'MEKARJAYA', '00000', '2026-08-07 06:39:00', NULL, NULL),
(422, 43, '3602050007', 'CIPALABUH', '00000', '2026-08-07 06:39:00', NULL, NULL),
(423, 43, '3602050008', 'CIBEUREUM', '00000', '2026-08-07 06:39:00', NULL, NULL),
(424, 43, '3602050009', 'CIMENGA', '00000', '2026-08-07 06:39:00', NULL, NULL),
(425, 43, '3602050010', 'SUKASENANG', '00000', '2026-08-07 06:39:00', NULL, NULL),
(426, 43, '3602050011', 'KAPUNDUHAN', '00000', '2026-08-07 06:39:00', NULL, NULL),
(427, 44, '3602051001', 'PEUCANGPARI', '00000', '2026-08-07 06:39:00', NULL, NULL),
(428, 44, '3602051002', 'CIBUNGUR', '00000', '2026-08-07 06:39:00', NULL, NULL),
(429, 44, '3602051003', 'CIKARET', '00000', '2026-08-07 06:39:00', NULL, NULL),
(430, 44, '3602051004', 'CIKADONGDONG', '00000', '2026-08-07 06:39:00', NULL, NULL),
(431, 44, '3602051005', 'CIKARATUAN', '00000', '2026-08-07 06:39:00', NULL, NULL),
(432, 44, '3602051006', 'MUGIJAYA', '00000', '2026-08-07 06:39:00', NULL, NULL),
(433, 44, '3602051007', 'CIGEMBLONG', '00000', '2026-08-07 06:39:00', NULL, NULL),
(434, 44, '3602051008', 'CIKATE', '00000', '2026-08-07 06:39:00', NULL, NULL),
(435, 44, '3602051009', 'WANGUNJAYA', '00000', '2026-08-07 06:39:00', NULL, NULL),
(436, 45, '3602060001', 'KERTARAHARJA', '00000', '2026-08-07 06:39:01', NULL, NULL),
(437, 45, '3602060002', 'KERTA', '00000', '2026-08-07 06:39:01', NULL, NULL),
(438, 45, '3602060003', 'BOJONGJURUH', '00000', '2026-08-07 06:39:01', NULL, NULL),
(439, 45, '3602060004', 'LEBAKKEUSIK', '00000', '2026-08-07 06:39:01', NULL, NULL),
(440, 45, '3602060005', 'LEUWIIPUH', '00000', '2026-08-07 06:39:01', NULL, NULL),
(441, 45, '3602060006', 'TAMANSARI', '00000', '2026-08-07 06:39:01', NULL, NULL),
(442, 45, '3602060007', 'CILEGONG ILIR', '00000', '2026-08-07 06:39:01', NULL, NULL),
(443, 45, '3602060008', 'CISAMPIH', '00000', '2026-08-07 06:39:01', NULL, NULL),
(444, 45, '3602060009', 'JALUPANG GIRANG', '00000', '2026-08-07 06:39:01', NULL, NULL),
(445, 45, '3602060010', 'CIDAHU', '00000', '2026-08-07 06:39:01', NULL, NULL),
(446, 45, '3602060011', 'KEUSIK', '00000', '2026-08-07 06:39:01', NULL, NULL),
(447, 45, '3602060012', 'CIRUJI', '00000', '2026-08-07 06:39:01', NULL, NULL),
(448, 45, '3602060013', 'CIBATURKEUSIK', '00000', '2026-08-07 06:39:01', NULL, NULL),
(449, 45, '3602060014', 'BENDUNGAN', '00000', '2026-08-07 06:39:01', NULL, NULL),
(450, 45, '3602060015', 'KUMPAY', '00000', '2026-08-07 06:39:01', NULL, NULL),
(451, 45, '3602060016', 'GUNUNGSARI', '00000', '2026-08-07 06:39:01', NULL, NULL),
(452, 45, '3602060017', 'KADUHAUK', '00000', '2026-08-07 06:39:01', NULL, NULL),
(453, 45, '3602060018', 'LABANJAYA', '00000', '2026-08-07 06:39:01', NULL, NULL),
(454, 45, '3602060019', 'UMBULJAYA', '00000', '2026-08-07 06:39:01', NULL, NULL),
(455, 45, '3602060020', 'KERTARAHAYU', '00000', '2026-08-07 06:39:01', NULL, NULL),
(456, 46, '3602070001', 'MEKARJAYA', '00000', '2026-08-07 06:39:02', NULL, NULL),
(457, 46, '3602070002', 'PASINDANGAN', '00000', '2026-08-07 06:39:02', NULL, NULL),
(458, 46, '3602070003', 'KUJANGSARI', '00000', '2026-08-07 06:39:02', NULL, NULL),
(459, 46, '3602070004', 'PARUNGKUJANG', '00000', '2026-08-07 06:39:02', NULL, NULL),
(460, 46, '3602070005', 'CIKAREO', '00000', '2026-08-07 06:39:02', NULL, NULL),
(461, 46, '3602070006', 'CILELES', '00000', '2026-08-07 06:39:02', NULL, NULL),
(462, 46, '3602070007', 'MARGAMULYA', '00000', '2026-08-07 06:39:02', NULL, NULL),
(463, 46, '3602070008', 'CIPADANG', '00000', '2026-08-07 06:39:02', NULL, NULL),
(464, 46, '3602070009', 'DAROYON', '00000', '2026-08-07 06:39:02', NULL, NULL),
(465, 46, '3602070010', 'PRABUGANTUNGAN', '00000', '2026-08-07 06:39:02', NULL, NULL),
(466, 46, '3602070012', 'BANJARSARI', '00000', '2026-08-07 06:39:02', NULL, NULL),
(467, 47, '3602080002', 'CIMANYANGRAY', '00000', '2026-08-07 06:39:02', NULL, NULL),
(468, 47, '3602080003', 'KERAMATJAYA', '00000', '2026-08-07 06:39:02', NULL, NULL),
(469, 47, '3602080004', 'BULAKAN', '00000', '2026-08-07 06:39:02', NULL, NULL),
(470, 47, '3602080005', 'CICARINGIN', '00000', '2026-08-07 06:39:02', NULL, NULL),
(471, 47, '3602080006', 'CIAKAR', '00000', '2026-08-07 06:39:02', NULL, NULL),
(472, 47, '3602080007', 'CISAMPANG', '00000', '2026-08-07 06:39:02', NULL, NULL),
(473, 47, '3602080008', 'BOJONG KONENG', '00000', '2026-08-07 06:39:02', NULL, NULL),
(474, 47, '3602080009', 'CIGINGGANG', '00000', '2026-08-07 06:39:02', NULL, NULL),
(475, 47, '3602080010', 'GUNUNG KENCANA', '00000', '2026-08-07 06:39:02', NULL, NULL),
(476, 47, '3602080011', 'SUKANEGARA', '00000', '2026-08-07 06:39:02', NULL, NULL),
(477, 47, '3602080012', 'TANJUNGSARI INDAH', '00000', '2026-08-07 06:39:02', NULL, NULL),
(478, 48, '3602090007', 'KEBONCAU', '00000', '2026-08-07 06:39:03', NULL, NULL),
(479, 48, '3602090008', 'CIMAYANG', '00000', '2026-08-07 06:39:03', NULL, NULL),
(480, 48, '3602090009', 'PARAKANBEUSI', '00000', '2026-08-07 06:39:03', NULL, NULL),
(481, 48, '3602090010', 'BOJONGMANIK', '00000', '2026-08-07 06:39:03', NULL, NULL),
(482, 48, '3602090011', 'MEKARMANIK', '00000', '2026-08-07 06:39:03', NULL, NULL),
(483, 48, '3602090014', 'KADURAHAYU', '00000', '2026-08-07 06:39:03', NULL, NULL),
(484, 48, '3602090015', 'HARJAWANA', '00000', '2026-08-07 06:39:03', NULL, NULL),
(485, 48, '3602090016', 'MEKAR RAHAYU', '00000', '2026-08-07 06:39:03', NULL, NULL),
(486, 48, '3602090017', 'PASIR BITUNG', '00000', '2026-08-07 06:39:03', NULL, NULL),
(487, 49, '3602091001', 'PARAKANLIMA', '00000', '2026-08-07 06:39:04', NULL, NULL),
(488, 49, '3602091002', 'KADUDAMAS', '00000', '2026-08-07 06:39:04', NULL, NULL),
(489, 49, '3602091003', 'DATARCAE', '00000', '2026-08-07 06:39:04', NULL, NULL),
(490, 49, '3602091004', 'KAROYA', '00000', '2026-08-07 06:39:04', NULL, NULL),
(491, 49, '3602091005', 'NANGERANG', '00000', '2026-08-07 06:39:04', NULL, NULL),
(492, 49, '3602091006', 'CIRINTEN', '00000', '2026-08-07 06:39:04', NULL, NULL),
(493, 49, '3602091007', 'KARANGNUNGGAL', '00000', '2026-08-07 06:39:04', NULL, NULL),
(494, 49, '3602091008', 'CEMPAKA', '00000', '2026-08-07 06:39:04', NULL, NULL),
(495, 49, '3602091009', 'BADUR', '00000', '2026-08-07 06:39:04', NULL, NULL),
(496, 49, '3602091010', 'CIBARANI', '00000', '2026-08-07 06:39:04', NULL, NULL),
(497, 50, '3602100001', 'KANEKES', '00000', '2026-08-07 06:39:04', NULL, NULL),
(498, 50, '3602100002', 'NAYAGATI', '00000', '2026-08-07 06:39:04', NULL, NULL),
(499, 50, '3602100003', 'BOJONG MENTENG', '00000', '2026-08-07 06:39:04', NULL, NULL),
(500, 50, '3602100004', 'CISIMEUT', '00000', '2026-08-07 06:39:04', NULL, NULL),
(501, 50, '3602100005', 'MARGAWANGI', '00000', '2026-08-07 06:39:04', NULL, NULL),
(502, 50, '3602100006', 'SANGKANWANGI', '00000', '2026-08-07 06:39:04', NULL, NULL),
(503, 50, '3602100007', 'JALUPANG MULYA', '00000', '2026-08-07 06:39:04', NULL, NULL),
(504, 50, '3602100008', 'LEUWIDAMAR', '00000', '2026-08-07 06:39:04', NULL, NULL),
(505, 50, '3602100009', 'CIBUNGUR', '00000', '2026-08-07 06:39:04', NULL, NULL),
(506, 50, '3602100010', 'LEBAK PARAHIANG', '00000', '2026-08-07 06:39:04', NULL, NULL),
(507, 50, '3602100011', 'WANTISARI', '00000', '2026-08-07 06:39:04', NULL, NULL),
(508, 50, '3602100012', 'CISIMEUT RAYA', '00000', '2026-08-07 06:39:04', NULL, NULL),
(509, 51, '3602110010', 'PASIREURIH', '00000', '2026-08-07 06:39:05', NULL, NULL),
(510, 51, '3602110011', 'PASIRNANGKA', '00000', '2026-08-07 06:39:05', NULL, NULL),
(511, 51, '3602110012', 'CIKARANG', '00000', '2026-08-07 06:39:05', NULL, NULL),
(512, 51, '3602110013', 'CIMINYAK', '00000', '2026-08-07 06:39:05', NULL, NULL),
(513, 51, '3602110014', 'LEUWICOO', '00000', '2026-08-07 06:39:05', NULL, NULL),
(514, 51, '3602110015', 'MUNCANG', '00000', '2026-08-07 06:39:05', NULL, NULL),
(515, 51, '3602110016', 'SUKANAGARA', '00000', '2026-08-07 06:39:05', NULL, NULL),
(516, 51, '3602110017', 'SINDANGWANGI', '00000', '2026-08-07 06:39:05', NULL, NULL),
(517, 51, '3602110018', 'JAGARAKSA', '00000', '2026-08-07 06:39:05', NULL, NULL),
(518, 51, '3602110019', 'TANJUNGWANGI', '00000', '2026-08-07 06:39:05', NULL, NULL),
(519, 51, '3602110020', 'MEKARWANGI', '00000', '2026-08-07 06:39:05', NULL, NULL),
(520, 51, '3602110021', 'GIRI JAGABAYA', '00000', '2026-08-07 06:39:05', NULL, NULL),
(521, 52, '3602111001', 'SINARJAYA', '00000', '2026-08-07 06:39:06', NULL, NULL),
(522, 52, '3602111002', 'CIROMPANG', '00000', '2026-08-07 06:39:06', NULL, NULL),
(523, 52, '3602111003', 'SUKAMAJU', '00000', '2026-08-07 06:39:06', NULL, NULL),
(524, 52, '3602111004', 'MAJASARI', '00000', '2026-08-07 06:39:06', NULL, NULL),
(525, 52, '3602111005', 'CIPARASI', '00000', '2026-08-07 06:39:06', NULL, NULL),
(526, 52, '3602111006', 'SINDANGLAYA', '00000', '2026-08-07 06:39:06', NULL, NULL),
(527, 52, '3602111007', 'SOBANG', '00000', '2026-08-07 06:39:06', NULL, NULL),
(528, 52, '3602111008', 'SUKAJAYA', '00000', '2026-08-07 06:39:06', NULL, NULL),
(529, 52, '3602111009', 'HARIANG', '00000', '2026-08-07 06:39:06', NULL, NULL),
(530, 52, '3602111010', 'SUKARESMI', '00000', '2026-08-07 06:39:06', NULL, NULL),
(531, 53, '3602120006', 'PASIRHAUR', '00000', '2026-08-07 06:39:07', NULL, NULL),
(532, 53, '3602120007', 'GIRILAYA', '00000', '2026-08-07 06:39:07', NULL, NULL),
(533, 53, '3602120008', 'JAYAPURA', '00000', '2026-08-07 06:39:07', NULL, NULL),
(534, 53, '3602120009', 'GIRIHARJA', '00000', '2026-08-07 06:39:07', NULL, NULL),
(535, 53, '3602120010', 'BINTANGSARI', '00000', '2026-08-07 06:39:07', NULL, NULL),
(536, 53, '3602120011', 'CIPANAS', '00000', '2026-08-07 06:39:07', NULL, NULL),
(537, 53, '3602120013', 'LUHURJAYA', '00000', '2026-08-07 06:39:07', NULL, NULL),
(538, 53, '3602120014', 'SIPAYUNG', '00000', '2026-08-07 06:39:07', NULL, NULL),
(539, 53, '3602120015', 'BINTANGRESMI', '00000', '2026-08-07 06:39:07', NULL, NULL),
(540, 53, '3602120016', 'MALANGSARI', '00000', '2026-08-07 06:39:07', NULL, NULL),
(541, 53, '3602120017', 'SUKASARI', '00000', '2026-08-07 06:39:07', NULL, NULL),
(542, 53, '3602120018', 'HAURGAJRUG', '00000', '2026-08-07 06:39:07', NULL, NULL),
(543, 53, '3602120019', 'TALAGAHIANG', '00000', '2026-08-07 06:39:07', NULL, NULL),
(544, 53, '3602120020', 'HARUMSARI', '00000', '2026-08-07 06:39:07', NULL, NULL),
(545, 54, '3602121001', 'LEBAKGEDONG', '00000', '2026-08-07 06:39:08', NULL, NULL),
(546, 54, '3602121002', 'LEBAKSITU', '00000', '2026-08-07 06:39:08', NULL, NULL),
(547, 54, '3602121003', 'CILADAEUN', '00000', '2026-08-07 06:39:08', NULL, NULL),
(548, 54, '3602121004', 'BANJARSARI', '00000', '2026-08-07 06:39:08', NULL, NULL),
(549, 54, '3602121005', 'LEBAKSANGKA', '00000', '2026-08-07 06:39:08', NULL, NULL),
(550, 54, '3602121006', 'BANJAR IRIGASI', '00000', '2026-08-07 06:39:08', NULL, NULL),
(551, 55, '3602130001', 'MARAYA', '00000', '2026-08-07 06:39:09', NULL, NULL),
(552, 55, '3602130002', 'MARGALUYU', '00000', '2026-08-07 06:39:09', NULL, NULL),
(553, 55, '3602130003', 'SUKAMARGA', '00000', '2026-08-07 06:39:09', NULL, NULL),
(554, 55, '3602130004', 'SINDANGSARI', '00000', '2026-08-07 06:39:09', NULL, NULL),
(555, 55, '3602130005', 'SAJIRAMEKAR', '00000', '2026-08-07 06:39:09', NULL, NULL),
(556, 55, '3602130006', 'SAJIRA', '00000', '2026-08-07 06:39:09', NULL, NULL),
(557, 55, '3602130007', 'SUKARAME', '00000', '2026-08-07 06:39:09', NULL, NULL),
(558, 55, '3602130008', 'CALUNGBUNGUR', '00000', '2026-08-07 06:39:09', NULL, NULL),
(559, 55, '3602130009', 'SUKAJAYA', '00000', '2026-08-07 06:39:09', NULL, NULL),
(560, 55, '3602130010', 'PAJA', '00000', '2026-08-07 06:39:09', NULL, NULL),
(561, 55, '3602130011', 'MEKARSARI', '00000', '2026-08-07 06:39:09', NULL, NULL),
(562, 55, '3602130012', 'PAJAGAN', '00000', '2026-08-07 06:39:09', NULL, NULL),
(563, 55, '3602130013', 'PARUNGSARI', '00000', '2026-08-07 06:39:09', NULL, NULL),
(564, 55, '3602130014', 'BUNGUR MEKAR', '00000', '2026-08-07 06:39:09', NULL, NULL),
(565, 55, '3602130015', 'CIUYAH', '00000', '2026-08-07 06:39:09', NULL, NULL),
(566, 56, '3602140001', 'SARAGENI', '00000', '2026-08-07 06:39:10', NULL, NULL),
(567, 56, '3602140002', 'JAYASARI', '00000', '2026-08-07 06:39:10', NULL, NULL),
(568, 56, '3602140003', 'MARGATIRTA', '00000', '2026-08-07 06:39:10', NULL, NULL),
(569, 56, '3602140004', 'GUNUNG ANTEN', '00000', '2026-08-07 06:39:10', NULL, NULL),
(570, 56, '3602140005', 'SANGKAN MANIK', '00000', '2026-08-07 06:39:10', NULL, NULL),
(571, 56, '3602140006', 'SUDAMANIK', '00000', '2026-08-07 06:39:10', NULL, NULL),
(572, 56, '3602140007', 'GIRIMUKTI', '00000', '2026-08-07 06:39:10', NULL, NULL),
(573, 56, '3602140008', 'JAYAMANIK', '00000', '2026-08-07 06:39:10', NULL, NULL),
(574, 56, '3602140009', 'MARGALUYU', '00000', '2026-08-07 06:39:10', NULL, NULL),
(575, 56, '3602140010', 'SANGIANG JAYA', '00000', '2026-08-07 06:39:10', NULL, NULL),
(576, 56, '3602140011', 'TAMBAK', '00000', '2026-08-07 06:39:10', NULL, NULL),
(577, 56, '3602140012', 'MARGA JAYA', '00000', '2026-08-07 06:39:10', NULL, NULL),
(578, 56, '3602140013', 'CIMARGA', '00000', '2026-08-07 06:39:10', NULL, NULL),
(579, 56, '3602140014', 'MEKAR JAYA', '00000', '2026-08-07 06:39:10', NULL, NULL),
(580, 56, '3602140015', 'INTEN JAYA', '00000', '2026-08-07 06:39:10', NULL, NULL),
(581, 56, '3602140016', 'KARYA JAYA', '00000', '2026-08-07 06:39:10', NULL, NULL),
(582, 56, '3602140017', 'MEKARMULYA', '00000', '2026-08-07 06:39:10', NULL, NULL),
(583, 57, '3602150001', 'ANGGALAN', '00000', '2026-08-07 06:39:10', NULL, NULL),
(584, 57, '3602150002', 'MUARADUA', '00000', '2026-08-07 06:39:10', NULL, NULL),
(585, 57, '3602150003', 'MUNCANGKOPONG', '00000', '2026-08-07 06:39:10', NULL, NULL),
(586, 57, '3602150004', 'TAMAN JAYA', '00000', '2026-08-07 06:39:10', NULL, NULL),
(587, 57, '3602150005', 'CURUGPANJANG', '00000', '2026-08-07 06:39:10', NULL, NULL),
(588, 57, '3602150006', 'CIKULUR', '00000', '2026-08-07 06:39:10', NULL, NULL),
(589, 57, '3602150007', 'CIGOONG SELATAN', '00000', '2026-08-07 06:39:10', NULL, NULL),
(590, 57, '3602150008', 'CIGOONG UTARA', '00000', '2026-08-07 06:39:10', NULL, NULL),
(591, 57, '3602150009', 'SUMURBANDUNG', '00000', '2026-08-07 06:39:10', NULL, NULL),
(592, 57, '3602150010', 'SUKAHARJA', '00000', '2026-08-07 06:39:10', NULL, NULL),
(593, 57, '3602150011', 'SUKADAYA', '00000', '2026-08-07 06:39:10', NULL, NULL),
(594, 57, '3602150012', 'PARAGE', '00000', '2026-08-07 06:39:10', NULL, NULL),
(595, 57, '3602150013', 'PASIR GINTUNG', '00000', '2026-08-07 06:39:10', NULL, NULL),
(596, 58, '3602160001', 'PASIRTANGKIL', '00000', '2026-08-07 06:39:11', NULL, NULL),
(597, 58, '3602160002', 'SUKARENDAH', '00000', '2026-08-07 06:39:11', NULL, NULL),
(598, 58, '3602160003', 'SELARAJA', '00000', '2026-08-07 06:39:11', NULL, NULL),
(599, 58, '3602160004', 'WARUNGGUNUNG', '00000', '2026-08-07 06:39:11', NULL, NULL),
(600, 58, '3602160005', 'CIBUAH', '00000', '2026-08-07 06:39:11', NULL, NULL),
(601, 58, '3602160006', 'BAROS', '00000', '2026-08-07 06:39:11', NULL, NULL),
(602, 58, '3602160007', 'SINDANGSARI', '00000', '2026-08-07 06:39:11', NULL, NULL),
(603, 58, '3602160008', 'BANJARSARI', '00000', '2026-08-07 06:39:11', NULL, NULL),
(604, 58, '3602160009', 'CEMPAKA', '00000', '2026-08-07 06:39:11', NULL, NULL),
(605, 58, '3602160010', 'PADASUKA', '00000', '2026-08-07 06:39:11', NULL, NULL),
(606, 58, '3602160011', 'SUKARAJA', '00000', '2026-08-07 06:39:11', NULL, NULL),
(607, 58, '3602160012', 'JAGABAYA', '00000', '2026-08-07 06:39:11', NULL, NULL),
(608, 59, '3602170001', 'TAMBAKBAYA', '00000', '2026-08-07 06:39:12', NULL, NULL),
(609, 59, '3602170002', 'BOJONGLELES', '00000', '2026-08-07 06:39:12', NULL, NULL),
(610, 59, '3602170003', 'KADUAGUNG TIMUR', '00000', '2026-08-07 06:39:12', NULL, NULL),
(611, 59, '3602170004', 'KADUAGUNG BARAT', '00000', '2026-08-07 06:39:12', NULL, NULL),
(612, 59, '3602170005', 'MALABAR', '00000', '2026-08-07 06:39:12', NULL, NULL),
(613, 59, '3602170006', 'PASAR KEONG', '00000', '2026-08-07 06:39:12', NULL, NULL),
(614, 59, '3602170007', 'CIBADAK', '00000', '2026-08-07 06:39:12', NULL, NULL),
(615, 59, '3602170008', 'PANANCANGAN', '00000', '2026-08-07 06:39:12', NULL, NULL),
(616, 59, '3602170009', 'ASEM', '00000', '2026-08-07 06:39:12', NULL, NULL),
(617, 59, '3602170010', 'CISANGU', '00000', '2026-08-07 06:39:12', NULL, NULL),
(618, 59, '3602170011', 'BOJONGCAE', '00000', '2026-08-07 06:39:12', NULL, NULL),
(619, 59, '3602170012', 'KADUAGUNG TENGAH', '00000', '2026-08-07 06:39:12', NULL, NULL),
(620, 59, '3602170013', 'MEKAR AGUNG', '00000', '2026-08-07 06:39:12', NULL, NULL),
(621, 59, '3602170014', 'ASEM MARGALUYU', '00000', '2026-08-07 06:39:12', NULL, NULL),
(622, 59, '3602170015', 'CIMENTENG JAYA', '00000', '2026-08-07 06:39:12', NULL, NULL),
(623, 60, '3602180007', 'PASIR TANJUNG', '00000', '2026-08-07 06:39:12', NULL, NULL);
INSERT INTO `m_kelurahan` (`id_kelurahan`, `id_kecamatan`, `kode_kelurahan`, `nama_kelurahan`, `kode_pos`, `created_at`, `updated_at`, `deleted_at`) VALUES
(624, 60, '3602180008', 'RANGKASBITUNG TIMUR', '00000', '2026-08-07 06:39:12', NULL, NULL),
(625, 60, '3602180009', 'RANGKASBITUNG BARAT', '00000', '2026-08-07 06:39:12', NULL, NULL),
(626, 60, '3602180010', 'MUARA CIUJUNG TIMUR', '00000', '2026-08-07 06:39:12', NULL, NULL),
(627, 60, '3602180011', 'JATIMULYA', '00000', '2026-08-07 06:39:12', NULL, NULL),
(628, 60, '3602180012', 'CIMANGEUNGTEUNG', '00000', '2026-08-07 06:39:12', NULL, NULL),
(629, 60, '3602180013', 'CITERAS', '00000', '2026-08-07 06:39:12', NULL, NULL),
(630, 60, '3602180014', 'MEKARSARI', '00000', '2026-08-07 06:39:12', NULL, NULL),
(631, 60, '3602180015', 'NAMENG', '00000', '2026-08-07 06:39:12', NULL, NULL),
(632, 60, '3602180016', 'KOLELET WETAN', '00000', '2026-08-07 06:39:12', NULL, NULL),
(633, 60, '3602180017', 'SUKAMANAH', '00000', '2026-08-07 06:39:12', NULL, NULL),
(634, 60, '3602180018', 'PABUARAN', '00000', '2026-08-07 06:39:12', NULL, NULL),
(635, 60, '3602180019', 'CIJORO PASIR', '00000', '2026-08-07 06:39:12', NULL, NULL),
(636, 60, '3602180020', 'CIJORO LEBAK', '00000', '2026-08-07 06:39:12', NULL, NULL),
(637, 60, '3602180021', 'MUARA CIUJUNG BARAT', '00000', '2026-08-07 06:39:12', NULL, NULL),
(638, 60, '3602180022', 'NARIMBANG MULIA', '00000', '2026-08-07 06:39:12', NULL, NULL),
(639, 61, '3602181001', 'CILANGKAP', '00000', '2026-08-07 06:39:13', NULL, NULL),
(640, 61, '3602181002', 'PASIR KUPA', '00000', '2026-08-07 06:39:13', NULL, NULL),
(641, 61, '3602181003', 'AWEH', '00000', '2026-08-07 06:39:13', NULL, NULL),
(642, 61, '3602181004', 'SUKAMEKARSARI', '00000', '2026-08-07 06:39:13', NULL, NULL),
(643, 61, '3602181005', 'KALANGANYAR', '00000', '2026-08-07 06:39:13', NULL, NULL),
(644, 61, '3602181006', 'SANGIANG TANJUNG', '00000', '2026-08-07 06:39:13', NULL, NULL),
(645, 61, '3602181007', 'CIKATAPIS', '00000', '2026-08-07 06:39:13', NULL, NULL),
(646, 62, '3602190008', 'CILANGKAP', '00000', '2026-08-07 06:39:13', NULL, NULL),
(647, 62, '3602190009', 'PASIR KECAPI', '00000', '2026-08-07 06:39:13', NULL, NULL),
(648, 62, '3602190012', 'MEKARSARI', '00000', '2026-08-07 06:39:13', NULL, NULL),
(649, 62, '3602190013', 'SANGIANG', '00000', '2026-08-07 06:39:13', NULL, NULL),
(650, 62, '3602190014', 'TANJUNG SARI', '00000', '2026-08-07 06:39:13', NULL, NULL),
(651, 62, '3602190015', 'MAJA', '00000', '2026-08-07 06:39:13', NULL, NULL),
(652, 62, '3602190016', 'CURUG BADAK', '00000', '2026-08-07 06:39:13', NULL, NULL),
(653, 62, '3602190017', 'PASIR KEMBANG', '00000', '2026-08-07 06:39:13', NULL, NULL),
(654, 62, '3602190018', 'PADASUKA', '00000', '2026-08-07 06:39:13', NULL, NULL),
(655, 62, '3602190019', 'GUBUGANCIBEUREUM', '00000', '2026-08-07 06:39:13', NULL, NULL),
(656, 62, '3602190020', 'BINONG', '00000', '2026-08-07 06:39:13', NULL, NULL),
(657, 62, '3602190021', 'SINDANGMULYA', '00000', '2026-08-07 06:39:13', NULL, NULL),
(658, 62, '3602190022', 'BUYUT MEKAR', '00000', '2026-08-07 06:39:13', NULL, NULL),
(659, 62, '3602190023', 'MAJA BARU', '00000', '2026-08-07 06:39:13', NULL, NULL),
(660, 63, '3602191001', 'GURADOG', '00000', '2026-08-07 06:39:14', NULL, NULL),
(661, 63, '3602191002', 'CANDI', '00000', '2026-08-07 06:39:14', NULL, NULL),
(662, 63, '3602191003', 'SEKARWANGI', '00000', '2026-08-07 06:39:14', NULL, NULL),
(663, 63, '3602191004', 'CURUGBITUNG', '00000', '2026-08-07 06:39:14', NULL, NULL),
(664, 63, '3602191005', 'CIBURUY', '00000', '2026-08-07 06:39:14', NULL, NULL),
(665, 63, '3602191006', 'MAYAK', '00000', '2026-08-07 06:39:14', NULL, NULL),
(666, 63, '3602191007', 'CILAYANG', '00000', '2026-08-07 06:39:14', NULL, NULL),
(667, 63, '3602191008', 'CIPINING', '00000', '2026-08-07 06:39:14', NULL, NULL),
(668, 63, '3602191009', 'CIDADAP', '00000', '2026-08-07 06:39:14', NULL, NULL),
(669, 63, '3602191010', 'LEBAKASIH', '00000', '2026-08-07 06:39:14', NULL, NULL),
(670, 64, '3603010008', 'JEUNG JING', '00000', '2026-08-07 06:39:15', NULL, NULL),
(671, 64, '3603010009', 'CISOKA', '00000', '2026-08-07 06:39:15', NULL, NULL),
(672, 64, '3603010010', 'SUKATANI', '00000', '2026-08-07 06:39:15', NULL, NULL),
(673, 64, '3603010011', 'CEMPAKA', '00000', '2026-08-07 06:39:15', NULL, NULL),
(674, 64, '3603010012', 'KARANGHARJA', '00000', '2026-08-07 06:39:15', NULL, NULL),
(675, 64, '3603010013', 'CARENANG', '00000', '2026-08-07 06:39:15', NULL, NULL),
(676, 64, '3603010014', 'BOJONGLOA', '00000', '2026-08-07 06:39:15', NULL, NULL),
(677, 64, '3603010015', 'CARINGIN', '00000', '2026-08-07 06:39:15', NULL, NULL),
(678, 64, '3603010016', 'SELAPAJANG', '00000', '2026-08-07 06:39:15', NULL, NULL),
(679, 64, '3603010017', 'CIBUGEL', '00000', '2026-08-07 06:39:15', NULL, NULL),
(680, 65, '3603011001', 'CIKASUNGKA', '00000', '2026-08-07 06:39:16', NULL, NULL),
(681, 65, '3603011002', 'CIKUYA', '00000', '2026-08-07 06:39:16', NULL, NULL),
(682, 65, '3603011003', 'CIKAREO', '00000', '2026-08-07 06:39:16', NULL, NULL),
(683, 65, '3603011004', 'CIREUNDEU', '00000', '2026-08-07 06:39:16', NULL, NULL),
(684, 65, '3603011005', 'SOLEAR', '00000', '2026-08-07 06:39:16', NULL, NULL),
(685, 65, '3603011006', 'PASANGGRAHAN', '00000', '2026-08-07 06:39:16', NULL, NULL),
(686, 66, '3603020001', 'CILELES', '00000', '2026-08-07 06:39:16', NULL, NULL),
(687, 66, '3603020002', 'BANTAR PANJANG', '00000', '2026-08-07 06:39:16', NULL, NULL),
(688, 66, '3603020003', 'SODONG', '00000', '2026-08-07 06:39:16', NULL, NULL),
(689, 66, '3603020004', 'TAPOS', '00000', '2026-08-07 06:39:16', NULL, NULL),
(690, 66, '3603020013', 'MARGA SARI', '00000', '2026-08-07 06:39:16', NULL, NULL),
(691, 66, '3603020014', 'KADU AGUNG', '00000', '2026-08-07 06:39:16', NULL, NULL),
(692, 66, '3603020015', 'MATA GARA', '00000', '2026-08-07 06:39:16', NULL, NULL),
(693, 66, '3603020016', 'TIGARAKSA', '00000', '2026-08-07 06:39:16', NULL, NULL),
(694, 66, '3603020018', 'TEGALSARI', '00000', '2026-08-07 06:39:16', NULL, NULL),
(695, 66, '3603020019', 'PEMATANG', '00000', '2026-08-07 06:39:16', NULL, NULL),
(696, 66, '3603020020', 'PASIR NANGKA', '00000', '2026-08-07 06:39:16', NULL, NULL),
(697, 66, '3603020021', 'CISEREH', '00000', '2026-08-07 06:39:16', NULL, NULL),
(698, 66, '3603020022', 'PASIR BOLANG', '00000', '2026-08-07 06:39:16', NULL, NULL),
(699, 67, '3603021001', 'MEKARSARI', '00000', '2026-08-07 06:39:17', NULL, NULL),
(700, 67, '3603021002', 'DARU', '00000', '2026-08-07 06:39:17', NULL, NULL),
(701, 67, '3603021003', 'SUKA MANAH', '00000', '2026-08-07 06:39:17', NULL, NULL),
(702, 67, '3603021004', 'TABAN', '00000', '2026-08-07 06:39:17', NULL, NULL),
(703, 67, '3603021005', 'ANCOL PASIR', '00000', '2026-08-07 06:39:17', NULL, NULL),
(704, 67, '3603021006', 'RANCABUAYA', '00000', '2026-08-07 06:39:17', NULL, NULL),
(705, 67, '3603021007', 'TIPARRAYA', '00000', '2026-08-07 06:39:17', NULL, NULL),
(706, 67, '3603021008', 'JAMBE', '00000', '2026-08-07 06:39:17', NULL, NULL),
(707, 67, '3603021010', 'PASIR BARAT', '00000', '2026-08-07 06:39:17', NULL, NULL),
(708, 68, '3603030001', 'BUDI MULYA', '00000', '2026-08-07 06:39:18', NULL, NULL),
(709, 68, '3603030002', 'BOJONG', '00000', '2026-08-07 06:39:18', NULL, NULL),
(710, 68, '3603030003', 'SUKA MULYA', '00000', '2026-08-07 06:39:18', NULL, NULL),
(711, 68, '3603030004', 'CIKUPA', '00000', '2026-08-07 06:39:18', NULL, NULL),
(712, 68, '3603030006', 'BITUNG JAYA', '00000', '2026-08-07 06:39:18', NULL, NULL),
(713, 68, '3603030008', 'SUKA DAMAI', '00000', '2026-08-07 06:39:18', NULL, NULL),
(714, 68, '3603030009', 'PASIR JAYA', '00000', '2026-08-07 06:39:18', NULL, NULL),
(715, 68, '3603030010', 'PASIR GADUNG', '00000', '2026-08-07 06:39:18', NULL, NULL),
(716, 68, '3603030011', 'TALAGA SARI', '00000', '2026-08-07 06:39:18', NULL, NULL),
(717, 68, '3603030012', 'TALAGA', '00000', '2026-08-07 06:39:18', NULL, NULL),
(718, 68, '3603030013', 'SUKA NAGARA', '00000', '2026-08-07 06:39:18', NULL, NULL),
(719, 68, '3603030014', 'CIBADAK', '00000', '2026-08-07 06:39:18', NULL, NULL),
(720, 69, '3603040001', 'RANCA IYUH', '00000', '2026-08-07 06:39:19', NULL, NULL),
(721, 69, '3603040002', 'MEKAR JAYA', '00000', '2026-08-07 06:39:19', NULL, NULL),
(722, 69, '3603040003', 'RANCA KALAPA', '00000', '2026-08-07 06:39:19', NULL, NULL),
(723, 69, '3603040004', 'PANONGAN', '00000', '2026-08-07 06:39:19', NULL, NULL),
(724, 69, '3603040005', 'SERDANG KULON', '00000', '2026-08-07 06:39:19', NULL, NULL),
(725, 69, '3603040006', 'CIAKAR', '00000', '2026-08-07 06:39:19', NULL, NULL),
(726, 69, '3603040007', 'MEKAR BAKTI', '00000', '2026-08-07 06:39:19', NULL, NULL),
(727, 69, '3603040008', 'PEUSAR', '00000', '2026-08-07 06:39:19', NULL, NULL),
(728, 70, '3603050001', 'CURUG KULON', '00000', '2026-08-07 06:39:19', NULL, NULL),
(729, 70, '3603050002', 'CURUG WETAN', '00000', '2026-08-07 06:39:19', NULL, NULL),
(730, 70, '3603050003', 'SUKA BAKTI', '00000', '2026-08-07 06:39:19', NULL, NULL),
(731, 70, '3603050004', 'CUKANG GALIH', '00000', '2026-08-07 06:39:19', NULL, NULL),
(732, 70, '3603050005', 'KADU JAYA', '00000', '2026-08-07 06:39:19', NULL, NULL),
(733, 70, '3603050006', 'KADU', '00000', '2026-08-07 06:39:19', NULL, NULL),
(734, 70, '3603050007', 'BINONG', '00000', '2026-08-07 06:39:19', NULL, NULL),
(735, 71, '3603051001', 'BOJONG NANGKA', '00000', '2026-08-07 06:39:20', NULL, NULL),
(736, 71, '3603051002', 'CURUG SANGERENG', '00000', '2026-08-07 06:39:20', NULL, NULL),
(737, 71, '3603051003', 'PAKULONAN BARAT', '00000', '2026-08-07 06:39:20', NULL, NULL),
(738, 71, '3603051004', 'KELAPA DUA', '00000', '2026-08-07 06:39:20', NULL, NULL),
(739, 71, '3603051005', 'BENCONGAN INDAH', '00000', '2026-08-07 06:39:20', NULL, NULL),
(740, 71, '3603051006', 'BENCONGAN', '00000', '2026-08-07 06:39:20', NULL, NULL),
(741, 72, '3603060001', 'CIANGIR', '00000', '2026-08-07 06:39:21', NULL, NULL),
(742, 72, '3603060002', 'BABAT', '00000', '2026-08-07 06:39:21', NULL, NULL),
(743, 72, '3603060003', 'BOJONG KAMAL', '00000', '2026-08-07 06:39:21', NULL, NULL),
(744, 72, '3603060004', 'CIRARAB', '00000', '2026-08-07 06:39:21', NULL, NULL),
(745, 72, '3603060005', 'CARINGIN', '00000', '2026-08-07 06:39:21', NULL, NULL),
(746, 72, '3603060006', 'BABAKAN', '00000', '2026-08-07 06:39:21', NULL, NULL),
(747, 72, '3603060007', 'KAMUNING', '00000', '2026-08-07 06:39:21', NULL, NULL),
(748, 72, '3603060008', 'PALA SARI', '00000', '2026-08-07 06:39:21', NULL, NULL),
(749, 72, '3603060009', 'SERDANG WETAN', '00000', '2026-08-07 06:39:21', NULL, NULL),
(750, 72, '3603060010', 'RANCAGONG', '00000', '2026-08-07 06:39:21', NULL, NULL),
(751, 72, '3603060011', 'LEGOK', '00000', '2026-08-07 06:39:21', NULL, NULL),
(752, 73, '3603070001', 'KARANG TENGAH', '00000', '2026-08-07 06:39:21', NULL, NULL),
(753, 73, '3603070002', 'MALANG NENGAH', '00000', '2026-08-07 06:39:21', NULL, NULL),
(754, 73, '3603070003', 'JATAKE', '00000', '2026-08-07 06:39:21', NULL, NULL),
(755, 73, '3603070004', 'KADU SIRUNG', '00000', '2026-08-07 06:39:21', NULL, NULL),
(756, 73, '3603070005', 'SITU GADUNG', '00000', '2026-08-07 06:39:21', NULL, NULL),
(757, 73, '3603070006', 'PAGEDANGAN', '00000', '2026-08-07 06:39:21', NULL, NULL),
(758, 73, '3603070007', 'CICALENGKA', '00000', '2026-08-07 06:39:21', NULL, NULL),
(759, 73, '3603070008', 'LENGKONG KULON', '00000', '2026-08-07 06:39:21', NULL, NULL),
(760, 73, '3603070009', 'CIJANTRA', '00000', '2026-08-07 06:39:21', NULL, NULL),
(761, 73, '3603070010', 'MEDANG', '00000', '2026-08-07 06:39:21', NULL, NULL),
(762, 73, '3603070012', 'CIHUNI', '00000', '2026-08-07 06:39:21', NULL, NULL),
(763, 74, '3603081001', 'MEKARWANGI', '00000', '2026-08-07 06:39:22', NULL, NULL),
(764, 74, '3603081002', 'DANGDANG', '00000', '2026-08-07 06:39:22', NULL, NULL),
(765, 74, '3603081003', 'SURADITA', '00000', '2026-08-07 06:39:22', NULL, NULL),
(766, 74, '3603081004', 'CISAUK', '00000', '2026-08-07 06:39:22', NULL, NULL),
(767, 74, '3603081005', 'SAMPORA', '00000', '2026-08-07 06:39:22', NULL, NULL),
(768, 74, '3603081006', 'CIBOGO', '00000', '2026-08-07 06:39:22', NULL, NULL),
(769, 75, '3603120004', 'SUKAASIH', '00000', '2026-08-07 06:39:22', NULL, NULL),
(770, 75, '3603120005', 'PASAR KEMIS', '00000', '2026-08-07 06:39:22', NULL, NULL),
(771, 75, '3603120006', 'SUKAMANTRI', '00000', '2026-08-07 06:39:22', NULL, NULL),
(772, 75, '3603120007', 'KUTA JAYA', '00000', '2026-08-07 06:39:22', NULL, NULL),
(773, 75, '3603120008', 'GELAM JAYA', '00000', '2026-08-07 06:39:22', NULL, NULL),
(774, 75, '3603120009', 'KUTA BARU', '00000', '2026-08-07 06:39:22', NULL, NULL),
(775, 75, '3603120010', 'KUTA BUMI', '00000', '2026-08-07 06:39:22', NULL, NULL),
(776, 75, '3603120011', 'PANGADEGAN', '00000', '2026-08-07 06:39:22', NULL, NULL),
(777, 75, '3603120012', 'SINDANG SARI', '00000', '2026-08-07 06:39:22', NULL, NULL),
(778, 76, '3603121001', 'WANA KERTA', '00000', '2026-08-07 06:39:23', NULL, NULL),
(779, 76, '3603121002', 'SUKA HARJA', '00000', '2026-08-07 06:39:23', NULL, NULL),
(780, 76, '3603121003', 'SINDANG PANON', '00000', '2026-08-07 06:39:23', NULL, NULL),
(781, 76, '3603121004', 'SINDANG JAYA', '00000', '2026-08-07 06:39:23', NULL, NULL),
(782, 76, '3603121005', 'SINDANG ASIH', '00000', '2026-08-07 06:39:23', NULL, NULL),
(783, 76, '3603121006', 'SINDANG SONO', '00000', '2026-08-07 06:39:23', NULL, NULL),
(784, 76, '3603121007', 'BADAK ANOM', '00000', '2026-08-07 06:39:23', NULL, NULL),
(785, 77, '3603130001', 'GEMBONG', '00000', '2026-08-07 06:39:24', NULL, NULL),
(786, 77, '3603130002', 'CANGKUDU', '00000', '2026-08-07 06:39:24', NULL, NULL),
(787, 77, '3603130004', 'SENTUL JAYA', '00000', '2026-08-07 06:39:24', NULL, NULL),
(788, 77, '3603130005', 'TALAGASARI', '00000', '2026-08-07 06:39:24', NULL, NULL),
(789, 77, '3603130006', 'BALA RAJA', '00000', '2026-08-07 06:39:24', NULL, NULL),
(790, 77, '3603130007', 'TOBAT', '00000', '2026-08-07 06:39:24', NULL, NULL),
(791, 77, '3603130008', 'SUKA MURNI', '00000', '2026-08-07 06:39:24', NULL, NULL),
(792, 77, '3603130015', 'SAGA', '00000', '2026-08-07 06:39:24', NULL, NULL),
(793, 78, '3603131001', 'JAYANTI', '00000', '2026-08-07 06:39:24', NULL, NULL),
(794, 78, '3603131002', 'PASIR MUNCANG', '00000', '2026-08-07 06:39:24', NULL, NULL),
(795, 78, '3603131003', 'SUMUR BANDUNG', '00000', '2026-08-07 06:39:24', NULL, NULL),
(796, 78, '3603131004', 'CIKANDE', '00000', '2026-08-07 06:39:24', NULL, NULL),
(797, 78, '3603131005', 'PASIR GINTUNG', '00000', '2026-08-07 06:39:24', NULL, NULL),
(798, 78, '3603131006', 'PANGKAT', '00000', '2026-08-07 06:39:24', NULL, NULL),
(799, 78, '3603131007', 'DANG DEUR', '00000', '2026-08-07 06:39:24', NULL, NULL),
(800, 78, '3603131008', 'PABUARAN', '00000', '2026-08-07 06:39:24', NULL, NULL),
(801, 79, '3603132001', 'KUBANG', '00000', '2026-08-07 06:39:25', NULL, NULL),
(802, 79, '3603132002', 'PARAHU', '00000', '2026-08-07 06:39:25', NULL, NULL),
(803, 79, '3603132003', 'SUKA MULYA', '00000', '2026-08-07 06:39:25', NULL, NULL),
(804, 79, '3603132004', 'KALI ASIN', '00000', '2026-08-07 06:39:25', NULL, NULL),
(805, 79, '3603132005', 'MERAK', '00000', '2026-08-07 06:39:25', NULL, NULL),
(806, 79, '3603132006', 'BUNAR', '00000', '2026-08-07 06:39:25', NULL, NULL),
(807, 79, '3603132007', 'BENDA', '00000', '2026-08-07 06:39:25', NULL, NULL),
(808, 79, '3603132008', 'BUNI AYU', '00000', '2026-08-07 06:39:25', NULL, NULL),
(809, 80, '3603140001', 'KOPER', '00000', '2026-08-07 06:39:26', NULL, NULL),
(810, 80, '3603140002', 'PASIR AMPO', '00000', '2026-08-07 06:39:26', NULL, NULL),
(811, 80, '3603140003', 'PATRA SANA', '00000', '2026-08-07 06:39:26', NULL, NULL),
(812, 80, '3603140005', 'TALOK', '00000', '2026-08-07 06:39:26', NULL, NULL),
(813, 80, '3603140006', 'JENGKOL', '00000', '2026-08-07 06:39:26', NULL, NULL),
(814, 80, '3603140007', 'KEMUNING', '00000', '2026-08-07 06:39:26', NULL, NULL),
(815, 80, '3603140008', 'RANCA ILAT', '00000', '2026-08-07 06:39:26', NULL, NULL),
(816, 81, '3603141001', 'KANDA WATI', '00000', '2026-08-07 06:39:27', NULL, NULL),
(817, 81, '3603141002', 'CIBETOK', '00000', '2026-08-07 06:39:27', NULL, NULL),
(818, 81, '3603141003', 'TAMIANG', '00000', '2026-08-07 06:39:27', NULL, NULL),
(819, 81, '3603141004', 'CIPAEH', '00000', '2026-08-07 06:39:27', NULL, NULL),
(820, 81, '3603141006', 'ONYAM', '00000', '2026-08-07 06:39:27', NULL, NULL),
(821, 81, '3603141007', 'GUNUNG KALER', '00000', '2026-08-07 06:39:27', NULL, NULL),
(822, 81, '3603141008', 'SIDOKO', '00000', '2026-08-07 06:39:27', NULL, NULL),
(823, 81, '3603141009', 'RANCA GEDE', '00000', '2026-08-07 06:39:27', NULL, NULL),
(824, 82, '3603150003', 'BAKUNG', '00000', '2026-08-07 06:39:27', NULL, NULL),
(825, 82, '3603150004', 'PASIR', '00000', '2026-08-07 06:39:27', NULL, NULL),
(826, 82, '3603150005', 'CIRUMPAK', '00000', '2026-08-07 06:39:27', NULL, NULL),
(827, 82, '3603150006', 'PAGEDANGAN UDIK', '00000', '2026-08-07 06:39:27', NULL, NULL),
(828, 82, '3603150007', 'PASILIAN', '00000', '2026-08-07 06:39:27', NULL, NULL),
(829, 82, '3603150008', 'PAGENJAHAN', '00000', '2026-08-07 06:39:27', NULL, NULL),
(830, 82, '3603150017', 'KRONJO', '00000', '2026-08-07 06:39:27', NULL, NULL),
(831, 82, '3603150018', 'PAGEDANGAN ILIR', '00000', '2026-08-07 06:39:27', NULL, NULL),
(832, 83, '3603151001', 'GANDA RIA', '00000', '2026-08-07 06:39:28', NULL, NULL),
(833, 83, '3603151002', 'KOSAMBI DALAM', '00000', '2026-08-07 06:39:28', NULL, NULL),
(834, 83, '3603151004', 'MEKAR BARU', '00000', '2026-08-07 06:39:28', NULL, NULL),
(835, 83, '3603151005', 'WALIWIS', '00000', '2026-08-07 06:39:28', NULL, NULL),
(836, 83, '3603151006', 'CIJERUK', '00000', '2026-08-07 06:39:28', NULL, NULL),
(837, 83, '3603151007', 'KEDAUNG', '00000', '2026-08-07 06:39:28', NULL, NULL),
(838, 83, '3603151008', 'JENGGOT', '00000', '2026-08-07 06:39:28', NULL, NULL),
(839, 84, '3603160007', 'GUNUNG SARI', '00000', '2026-08-07 06:39:28', NULL, NULL),
(840, 84, '3603160008', 'SASAK', '00000', '2026-08-07 06:39:28', NULL, NULL),
(841, 84, '3603160009', 'KEDUNG DALEM', '00000', '2026-08-07 06:39:28', NULL, NULL),
(842, 84, '3603160010', 'TEGAL KUNIR KIDUL', '00000', '2026-08-07 06:39:28', NULL, NULL),
(843, 84, '3603160011', 'JATI WARINGIN', '00000', '2026-08-07 06:39:28', NULL, NULL),
(844, 84, '3603160019', 'TEGAL KUNIR LOR', '00000', '2026-08-07 06:39:28', NULL, NULL),
(845, 84, '3603160020', 'BANYU ASIH', '00000', '2026-08-07 06:39:28', NULL, NULL),
(846, 84, '3603160021', 'MAUK TIMUR', '00000', '2026-08-07 06:39:28', NULL, NULL),
(847, 84, '3603160022', 'MAUK BARAT', '00000', '2026-08-07 06:39:28', NULL, NULL),
(848, 84, '3603160023', 'KETAPANG', '00000', '2026-08-07 06:39:28', NULL, NULL),
(849, 84, '3603160024', 'MARGA MULYA', '00000', '2026-08-07 06:39:28', NULL, NULL),
(850, 84, '3603160025', 'TANJUNG ANOM', '00000', '2026-08-07 06:39:28', NULL, NULL),
(851, 85, '3603161001', 'LEGOK SUKAMAJU', '00000', '2026-08-07 06:39:29', NULL, NULL),
(852, 85, '3603161002', 'RANCA LABUH', '00000', '2026-08-07 06:39:29', NULL, NULL),
(853, 85, '3603161003', 'KEMIRI', '00000', '2026-08-07 06:39:29', NULL, NULL),
(854, 85, '3603161005', 'PATRA MANGGALA', '00000', '2026-08-07 06:39:29', NULL, NULL),
(855, 85, '3603161006', 'KARANG ANYAR', '00000', '2026-08-07 06:39:29', NULL, NULL),
(856, 85, '3603161007', 'LONTAR', '00000', '2026-08-07 06:39:29', NULL, NULL),
(857, 86, '3603162001', 'BUARAN JATI', '00000', '2026-08-07 06:39:30', NULL, NULL),
(858, 86, '3603162002', 'GINTUNG', '00000', '2026-08-07 06:39:30', NULL, NULL),
(859, 86, '3603162003', 'KOSAMBI', '00000', '2026-08-07 06:39:30', NULL, NULL),
(860, 86, '3603162004', 'MEKAR KONDANG', '00000', '2026-08-07 06:39:30', NULL, NULL),
(861, 86, '3603162005', 'PEKAYON', '00000', '2026-08-07 06:39:30', NULL, NULL),
(862, 86, '3603162006', 'SUKADIRI', '00000', '2026-08-07 06:39:30', NULL, NULL),
(863, 86, '3603162007', 'RAWA KIDANG', '00000', '2026-08-07 06:39:30', NULL, NULL),
(864, 86, '3603162008', 'KARANG SERANG', '00000', '2026-08-07 06:39:30', NULL, NULL),
(865, 87, '3603170002', 'JAMBU KARYA', '00000', '2026-08-07 06:39:31', NULL, NULL),
(866, 87, '3603170003', 'DAON', '00000', '2026-08-07 06:39:31', NULL, NULL),
(867, 87, '3603170004', 'SUKA TANI', '00000', '2026-08-07 06:39:31', NULL, NULL),
(868, 87, '3603170005', 'MEKARSARI', '00000', '2026-08-07 06:39:31', NULL, NULL),
(869, 87, '3603170006', 'SUKA SARI', '00000', '2026-08-07 06:39:31', NULL, NULL),
(870, 87, '3603170007', 'RAJEGMULYA', '00000', '2026-08-07 06:39:31', NULL, NULL),
(871, 87, '3603170008', 'RAJEG', '00000', '2026-08-07 06:39:31', NULL, NULL),
(872, 87, '3603170009', 'SUKA MANAH', '00000', '2026-08-07 06:39:31', NULL, NULL),
(873, 87, '3603170010', 'PANGARENGAN', '00000', '2026-08-07 06:39:31', NULL, NULL),
(874, 87, '3603170011', 'RANCA BANGO', '00000', '2026-08-07 06:39:31', NULL, NULL),
(875, 87, '3603170012', 'LEMBANG SARI', '00000', '2026-08-07 06:39:31', NULL, NULL),
(876, 87, '3603170013', 'TANJAKAN', '00000', '2026-08-07 06:39:31', NULL, NULL),
(877, 87, '3603170014', 'TANJAKAN MEKAR', '00000', '2026-08-07 06:39:31', NULL, NULL),
(878, 88, '3603180001', 'MEKAR JAYA', '00000', '2026-08-07 06:39:31', NULL, NULL),
(879, 88, '3603180002', 'KARET', '00000', '2026-08-07 06:39:31', NULL, NULL),
(880, 88, '3603180007', 'PONDOK JAYA', '00000', '2026-08-07 06:39:31', NULL, NULL),
(881, 88, '3603180008', 'SEPATAN', '00000', '2026-08-07 06:39:31', NULL, NULL),
(882, 88, '3603180009', 'PISANGAN JAYA', '00000', '2026-08-07 06:39:31', NULL, NULL),
(883, 88, '3603180010', 'SARAKAN', '00000', '2026-08-07 06:39:31', NULL, NULL),
(884, 88, '3603180011', 'KAYU BONGKOK', '00000', '2026-08-07 06:39:31', NULL, NULL),
(885, 88, '3603180012', 'KAYU AGUNG', '00000', '2026-08-07 06:39:31', NULL, NULL),
(886, 89, '3603181001', 'LEBAK WANGI', '00000', '2026-08-07 06:39:32', NULL, NULL),
(887, 89, '3603181002', 'KEDAUNG BARAT', '00000', '2026-08-07 06:39:32', NULL, NULL),
(888, 89, '3603181003', 'JATI MULYA', '00000', '2026-08-07 06:39:32', NULL, NULL),
(889, 89, '3603181004', 'TANAH MERAH', '00000', '2026-08-07 06:39:32', NULL, NULL),
(890, 89, '3603181005', 'SANGIANG', '00000', '2026-08-07 06:39:32', NULL, NULL),
(891, 89, '3603181006', 'GEMPOL SARI', '00000', '2026-08-07 06:39:32', NULL, NULL),
(892, 89, '3603181007', 'PONDOK KELOR', '00000', '2026-08-07 06:39:32', NULL, NULL),
(893, 89, '3603181008', 'KAMPUNG KELOR', '00000', '2026-08-07 06:39:32', NULL, NULL),
(894, 90, '3603190001', 'BUNISARI', '00000', '2026-08-07 06:39:33', NULL, NULL),
(895, 90, '3603190002', 'RAWA BONI', '00000', '2026-08-07 06:39:33', NULL, NULL),
(896, 90, '3603190003', 'KIARA PAYUNG', '00000', '2026-08-07 06:39:33', NULL, NULL),
(897, 90, '3603190004', 'GAGA', '00000', '2026-08-07 06:39:33', NULL, NULL),
(898, 90, '3603190005', 'LAKSANA', '00000', '2026-08-07 06:39:33', NULL, NULL),
(899, 90, '3603190006', 'BUARAN BAMBU', '00000', '2026-08-07 06:39:33', NULL, NULL),
(900, 90, '3603190007', 'PAKU HAJI', '00000', '2026-08-07 06:39:33', NULL, NULL),
(901, 90, '3603190008', 'PAKU ALAM', '00000', '2026-08-07 06:39:33', NULL, NULL),
(902, 90, '3603190009', 'BUARAN MANGGA', '00000', '2026-08-07 06:39:33', NULL, NULL),
(903, 90, '3603190010', 'SURYA BAHARI', '00000', '2026-08-07 06:39:33', NULL, NULL),
(904, 90, '3603190011', 'SUKAWALI', '00000', '2026-08-07 06:39:33', NULL, NULL),
(905, 90, '3603190012', 'KRAMAT', '00000', '2026-08-07 06:39:33', NULL, NULL),
(906, 90, '3603190013', 'KALIBARU', '00000', '2026-08-07 06:39:33', NULL, NULL),
(907, 90, '3603190014', 'KOHOD', '00000', '2026-08-07 06:39:33', NULL, NULL),
(908, 91, '3603200001', 'BOJONG RENGED', '00000', '2026-08-07 06:39:34', NULL, NULL),
(909, 91, '3603200002', 'KEBON CAU', '00000', '2026-08-07 06:39:34', NULL, NULL),
(910, 91, '3603200003', 'TELUK NAGA', '00000', '2026-08-07 06:39:34', NULL, NULL),
(911, 91, '3603200004', 'BABAKAN ASEM', '00000', '2026-08-07 06:39:34', NULL, NULL),
(912, 91, '3603200005', 'KAMPUNG MELAYU TIMUR', '00000', '2026-08-07 06:39:34', NULL, NULL),
(913, 91, '3603200006', 'KAMPUNG MELAYU BARAT', '00000', '2026-08-07 06:39:34', NULL, NULL),
(914, 91, '3603200007', 'KAMPUNG BESAR', '00000', '2026-08-07 06:39:34', NULL, NULL),
(915, 91, '3603200008', 'L E M O', '00000', '2026-08-07 06:39:34', NULL, NULL),
(916, 91, '3603200009', 'TEGAL ANGUS', '00000', '2026-08-07 06:39:34', NULL, NULL),
(917, 91, '3603200010', 'PANGKALAN', '00000', '2026-08-07 06:39:34', NULL, NULL),
(918, 91, '3603200011', 'TANJUNG BURUNG', '00000', '2026-08-07 06:39:34', NULL, NULL),
(919, 91, '3603200012', 'TANJUNG PASIR', '00000', '2026-08-07 06:39:34', NULL, NULL),
(920, 91, '3603200013', 'MUARA', '00000', '2026-08-07 06:39:34', NULL, NULL),
(921, 92, '3603210001', 'RAWA RENGAS', '00000', '2026-08-07 06:39:34', NULL, NULL),
(922, 92, '3603210002', 'RAWA BURUNG', '00000', '2026-08-07 06:39:34', NULL, NULL),
(923, 92, '3603210003', 'BELIMBING', '00000', '2026-08-07 06:39:34', NULL, NULL),
(924, 92, '3603210004', 'JATIMULYA', '00000', '2026-08-07 06:39:34', NULL, NULL),
(925, 92, '3603210005', 'D A D A P', '00000', '2026-08-07 06:39:34', NULL, NULL),
(926, 92, '3603210006', 'KOSAMBI TIMUR', '00000', '2026-08-07 06:39:34', NULL, NULL),
(927, 92, '3603210007', 'KOSAMBI BARAT', '00000', '2026-08-07 06:39:34', NULL, NULL),
(928, 92, '3603210008', 'CENGKLONG', '00000', '2026-08-07 06:39:34', NULL, NULL),
(929, 92, '3603210009', 'SALEMBARAN JATI', '00000', '2026-08-07 06:39:34', NULL, NULL),
(930, 92, '3603210010', 'SALEMBARAN', '00000', '2026-08-07 06:39:34', NULL, NULL),
(931, 93, '3604010001', 'UMBUL TANJUNG', '00000', '2026-08-07 06:39:36', NULL, NULL),
(932, 93, '3604010002', 'PASAURAN', '00000', '2026-08-07 06:39:36', NULL, NULL),
(933, 93, '3604010003', 'BANTARWANGI', '00000', '2026-08-07 06:39:36', NULL, NULL),
(934, 93, '3604010004', 'BANTARWARU', '00000', '2026-08-07 06:39:36', NULL, NULL),
(935, 93, '3604010005', 'BULAKAN', '00000', '2026-08-07 06:39:36', NULL, NULL),
(936, 93, '3604010006', 'KARANG SURAGA', '00000', '2026-08-07 06:39:36', NULL, NULL),
(937, 93, '3604010007', 'CINANGKA', '00000', '2026-08-07 06:39:36', NULL, NULL),
(938, 93, '3604010008', 'KUBANG BAROS', '00000', '2026-08-07 06:39:36', NULL, NULL),
(939, 93, '3604010009', 'RANCASANGGAL', '00000', '2026-08-07 06:39:36', NULL, NULL),
(940, 93, '3604010010', 'CIKOLELET', '00000', '2026-08-07 06:39:36', NULL, NULL),
(941, 93, '3604010011', 'MEKARSARI', '00000', '2026-08-07 06:39:36', NULL, NULL),
(942, 93, '3604010012', 'SINDANGLAYA', '00000', '2026-08-07 06:39:36', NULL, NULL),
(943, 93, '3604010013', 'KAMASAN', '00000', '2026-08-07 06:39:36', NULL, NULL),
(944, 93, '3604010014', 'BAROS JAYA', '00000', '2026-08-07 06:39:36', NULL, NULL),
(945, 94, '3604020001', 'CIBOJONG', '00000', '2026-08-07 06:39:37', NULL, NULL),
(946, 94, '3604020002', 'KRAMATLABAN', '00000', '2026-08-07 06:39:37', NULL, NULL),
(947, 94, '3604020003', 'KADUBEUREUM', '00000', '2026-08-07 06:39:37', NULL, NULL),
(948, 94, '3604020004', 'PADARINCANG', '00000', '2026-08-07 06:39:37', NULL, NULL),
(949, 94, '3604020006', 'KALUMPANG', '00000', '2026-08-07 06:39:37', NULL, NULL),
(950, 94, '3604020007', 'CITASUK', '00000', '2026-08-07 06:39:37', NULL, NULL),
(951, 94, '3604020008', 'BATUKUWUNG', '00000', '2026-08-07 06:39:37', NULL, NULL),
(952, 94, '3604020009', 'CURUG GOONG', '00000', '2026-08-07 06:39:37', NULL, NULL),
(953, 94, '3604020010', 'CISAAT', '00000', '2026-08-07 06:39:37', NULL, NULL),
(954, 94, '3604020011', 'CIPAYUNG', '00000', '2026-08-07 06:39:37', NULL, NULL),
(955, 94, '3604020012', 'CIOMAS', '00000', '2026-08-07 06:39:37', NULL, NULL),
(956, 94, '3604020013', 'BARUGBUG', '00000', '2026-08-07 06:39:37', NULL, NULL),
(957, 94, '3604020014', 'KADUKEMPONG', '00000', '2026-08-07 06:39:37', NULL, NULL),
(958, 95, '3604030002', 'CISITU', '00000', '2026-08-07 06:39:37', NULL, NULL),
(959, 95, '3604030003', 'SIKETUG', '00000', '2026-08-07 06:39:37', NULL, NULL),
(960, 95, '3604030004', 'LEBAK', '00000', '2026-08-07 06:39:37', NULL, NULL),
(961, 95, '3604030005', 'CITAMAN', '00000', '2026-08-07 06:39:37', NULL, NULL),
(962, 95, '3604030006', 'PONDOK KAHURU', '00000', '2026-08-07 06:39:37', NULL, NULL),
(963, 95, '3604030007', 'SUKADANA', '00000', '2026-08-07 06:39:37', NULL, NULL),
(964, 95, '3604030008', 'SUKABARES', '00000', '2026-08-07 06:39:37', NULL, NULL),
(965, 95, '3604030009', 'SUKARENA', '00000', '2026-08-07 06:39:37', NULL, NULL),
(966, 95, '3604030010', 'CEMPLANG', '00000', '2026-08-07 06:39:37', NULL, NULL),
(967, 95, '3604030011', 'PANYAUNGAN JAYA', '00000', '2026-08-07 06:39:37', NULL, NULL),
(968, 96, '3604040001', 'TANJUNGSARI', '00000', '2026-08-07 06:39:38', NULL, NULL),
(969, 96, '3604040002', 'KADUBEUREUM', '00000', '2026-08-07 06:39:38', NULL, NULL),
(970, 96, '3604040003', 'PASANGGRAHAN', '00000', '2026-08-07 06:39:38', NULL, NULL),
(971, 96, '3604040004', 'PABUARAN', '00000', '2026-08-07 06:39:38', NULL, NULL),
(972, 96, '3604040005', 'PANCANEGARA', '00000', '2026-08-07 06:39:38', NULL, NULL),
(973, 96, '3604040006', 'SINDANGHEULA', '00000', '2026-08-07 06:39:38', NULL, NULL),
(974, 96, '3604040007', 'SINDANGSARI', '00000', '2026-08-07 06:39:38', NULL, NULL),
(975, 96, '3604040008', 'TALAGA WARNA', '00000', '2026-08-07 06:39:38', NULL, NULL),
(976, 97, '3604041001', 'CIHERANG', '00000', '2026-08-07 06:39:39', NULL, NULL),
(977, 97, '3604041002', 'GUNUNGSARI', '00000', '2026-08-07 06:39:39', NULL, NULL),
(978, 97, '3604041003', 'TAMIANG', '00000', '2026-08-07 06:39:39', NULL, NULL),
(979, 97, '3604041004', 'SUKALABA', '00000', '2026-08-07 06:39:39', NULL, NULL),
(980, 97, '3604041005', 'KADU AGUNG', '00000', '2026-08-07 06:39:39', NULL, NULL),
(981, 97, '3604041007', 'CURUG SULANJANA', '00000', '2026-08-07 06:39:39', NULL, NULL),
(982, 98, '3604050001', 'SUKACAI', '00000', '2026-08-07 06:39:40', NULL, NULL),
(983, 98, '3604050002', 'SUKAMENAK', '00000', '2026-08-07 06:39:40', NULL, NULL),
(984, 98, '3604050003', 'TEJAMARI', '00000', '2026-08-07 06:39:40', NULL, NULL),
(985, 98, '3604050004', 'PANYIRAPAN', '00000', '2026-08-07 06:39:40', NULL, NULL),
(986, 98, '3604050005', 'TAMANSARI', '00000', '2026-08-07 06:39:40', NULL, NULL),
(987, 98, '3604050006', 'SINDANGMANDI', '00000', '2026-08-07 06:39:40', NULL, NULL),
(988, 98, '3604050007', 'CURUG AGUNG', '00000', '2026-08-07 06:39:40', NULL, NULL),
(989, 98, '3604050008', 'SUKAMANAH', '00000', '2026-08-07 06:39:40', NULL, NULL),
(990, 98, '3604050009', 'PADASUKA', '00000', '2026-08-07 06:39:40', NULL, NULL),
(991, 98, '3604050010', 'SINARMUKTI', '00000', '2026-08-07 06:39:40', NULL, NULL),
(992, 98, '3604050011', 'SIDAMUKTI', '00000', '2026-08-07 06:39:40', NULL, NULL),
(993, 98, '3604050012', 'BAROS', '00000', '2026-08-07 06:39:40', NULL, NULL),
(994, 98, '3604050013', 'CISALAM', '00000', '2026-08-07 06:39:40', NULL, NULL),
(995, 98, '3604050014', 'SUKA INDAH', '00000', '2026-08-07 06:39:40', NULL, NULL),
(996, 99, '3604060009', 'KADUGENEP', '00000', '2026-08-07 06:39:40', NULL, NULL),
(997, 99, '3604060010', 'PADASUKA', '00000', '2026-08-07 06:39:40', NULL, NULL),
(998, 99, '3604060011', 'SANDING', '00000', '2026-08-07 06:39:40', NULL, NULL),
(999, 99, '3604060012', 'SINDANGSARI', '00000', '2026-08-07 06:39:40', NULL, NULL),
(1000, 99, '3604060013', 'CIREUNDEU', '00000', '2026-08-07 06:39:40', NULL, NULL),
(1001, 99, '3604060014', 'CIRANGKONG', '00000', '2026-08-07 06:39:40', NULL, NULL),
(1002, 99, '3604060015', 'TAMBILUK', '00000', '2026-08-07 06:39:40', NULL, NULL),
(1003, 99, '3604060016', 'MEKARBARU', '00000', '2026-08-07 06:39:40', NULL, NULL),
(1004, 99, '3604060017', 'PETIR', '00000', '2026-08-07 06:39:40', NULL, NULL),
(1005, 99, '3604060018', 'NAGARA PADANG', '00000', '2026-08-07 06:39:40', NULL, NULL),
(1006, 99, '3604060019', 'KAMPUNG BARU', '00000', '2026-08-07 06:39:40', NULL, NULL),
(1007, 99, '3604060020', 'SEUAT', '00000', '2026-08-07 06:39:40', NULL, NULL),
(1008, 99, '3604060021', 'SEUAT JAYA', '00000', '2026-08-07 06:39:40', NULL, NULL),
(1009, 99, '3604060022', 'KUBANG JAYA', '00000', '2026-08-07 06:39:40', NULL, NULL),
(1010, 99, '3604060023', 'BOJONG NANGKA', '00000', '2026-08-07 06:39:40', NULL, NULL),
(1011, 100, '3604061001', 'PANUNGGULAN', '00000', '2026-08-07 06:39:41', NULL, NULL),
(1012, 100, '3604061002', 'SUKASARI', '00000', '2026-08-07 06:39:41', NULL, NULL),
(1013, 100, '3604061003', 'BOJONG MENTENG', '00000', '2026-08-07 06:39:41', NULL, NULL),
(1014, 100, '3604061004', 'KAMUNING', '00000', '2026-08-07 06:39:41', NULL, NULL),
(1015, 100, '3604061005', 'BOJONG PANDAN', '00000', '2026-08-07 06:39:41', NULL, NULL),
(1016, 100, '3604061006', 'BOJONG CATANG', '00000', '2026-08-07 06:39:41', NULL, NULL),
(1017, 100, '3604061007', 'MALANGGAH', '00000', '2026-08-07 06:39:41', NULL, NULL),
(1018, 100, '3604061008', 'TUNJUNG JAYA', '00000', '2026-08-07 06:39:41', NULL, NULL),
(1019, 100, '3604061009', 'PANCAREGANG', '00000', '2026-08-07 06:39:41', NULL, NULL),
(1020, 101, '3604080001', 'PANYABRANGAN', '00000', '2026-08-07 06:39:42', NULL, NULL),
(1021, 101, '3604080002', 'DAHU', '00000', '2026-08-07 06:39:42', NULL, NULL),
(1022, 101, '3604080003', 'BANTAR PANJANG', '00000', '2026-08-07 06:39:42', NULL, NULL),
(1023, 101, '3604080004', 'KATULISAN', '00000', '2026-08-07 06:39:42', NULL, NULL),
(1024, 101, '3604080005', 'PANOSOGAN', '00000', '2026-08-07 06:39:42', NULL, NULL),
(1025, 101, '3604080006', 'CIKEUSAL', '00000', '2026-08-07 06:39:42', NULL, NULL),
(1026, 101, '3604080007', 'SUKAMAJU', '00000', '2026-08-07 06:39:42', NULL, NULL),
(1027, 101, '3604080008', 'HARUNDANG', '00000', '2026-08-07 06:39:42', NULL, NULL),
(1028, 101, '3604080009', 'GANDAYASA', '00000', '2026-08-07 06:39:42', NULL, NULL),
(1029, 101, '3604080010', 'MONGPOK', '00000', '2026-08-07 06:39:42', NULL, NULL),
(1030, 101, '3604080011', 'SUKARAME', '00000', '2026-08-07 06:39:42', NULL, NULL),
(1031, 101, '3604080012', 'CILAYANG', '00000', '2026-08-07 06:39:42', NULL, NULL),
(1032, 101, '3604080013', 'SUKARATU', '00000', '2026-08-07 06:39:42', NULL, NULL),
(1033, 101, '3604080014', 'SUKAMENAK', '00000', '2026-08-07 06:39:42', NULL, NULL),
(1034, 101, '3604080015', 'CIMAUNG', '00000', '2026-08-07 06:39:42', NULL, NULL),
(1035, 101, '3604080016', 'SUKARAJA', '00000', '2026-08-07 06:39:42', NULL, NULL),
(1036, 101, '3604080017', 'CILAYANG GUHA', '00000', '2026-08-07 06:39:42', NULL, NULL),
(1037, 102, '3604090001', 'WIRANA', '00000', '2026-08-07 06:39:42', NULL, NULL),
(1038, 102, '3604090002', 'SANGIANG', '00000', '2026-08-07 06:39:42', NULL, NULL),
(1039, 102, '3604090003', 'DAMPING', '00000', '2026-08-07 06:39:42', NULL, NULL),
(1040, 102, '3604090004', 'KEBON CAU', '00000', '2026-08-07 06:39:42', NULL, NULL),
(1041, 102, '3604090005', 'PUDAR', '00000', '2026-08-07 06:39:42', NULL, NULL),
(1042, 102, '3604090006', 'BINONG', '00000', '2026-08-07 06:39:42', NULL, NULL),
(1043, 102, '3604090007', 'PAMARAYAN', '00000', '2026-08-07 06:39:42', NULL, NULL),
(1044, 102, '3604090008', 'KAMPUNG BARU', '00000', '2026-08-07 06:39:42', NULL, NULL),
(1045, 102, '3604090010', 'PASIRLIMUS', '00000', '2026-08-07 06:39:42', NULL, NULL),
(1046, 102, '3604090011', 'PASIR KEMBANG', '00000', '2026-08-07 06:39:42', NULL, NULL),
(1047, 103, '3604091001', 'PANGAWINAN', '00000', '2026-08-07 06:39:43', NULL, NULL),
(1048, 103, '3604091002', 'MANDER', '00000', '2026-08-07 06:39:43', NULL, NULL),
(1049, 103, '3604091003', 'PANAMPING', '00000', '2026-08-07 06:39:43', NULL, NULL),
(1050, 103, '3604091004', 'BANDUNG', '00000', '2026-08-07 06:39:43', NULL, NULL),
(1051, 103, '3604091005', 'MALABAR', '00000', '2026-08-07 06:39:43', NULL, NULL),
(1052, 103, '3604091006', 'BLOKANG', '00000', '2026-08-07 06:39:43', NULL, NULL),
(1053, 103, '3604091007', 'BABAKAN', '00000', '2026-08-07 06:39:43', NULL, NULL),
(1054, 103, '3604091008', 'PRINGWULUNG', '00000', '2026-08-07 06:39:43', NULL, NULL),
(1055, 104, '3604100001', 'PAGINTUNGAN', '00000', '2026-08-07 06:39:44', NULL, NULL),
(1056, 104, '3604100002', 'CEMPLANG', '00000', '2026-08-07 06:39:44', NULL, NULL),
(1057, 104, '3604100003', 'BOJOT', '00000', '2026-08-07 06:39:44', NULL, NULL),
(1058, 104, '3604100004', 'JAWILAN', '00000', '2026-08-07 06:39:44', NULL, NULL),
(1059, 104, '3604100005', 'PASIRBUYUT', '00000', '2026-08-07 06:39:44', NULL, NULL),
(1060, 104, '3604100006', 'MAJASARI', '00000', '2026-08-07 06:39:44', NULL, NULL),
(1061, 104, '3604100007', 'PARAKAN', '00000', '2026-08-07 06:39:44', NULL, NULL),
(1062, 104, '3604100008', 'KAREO', '00000', '2026-08-07 06:39:44', NULL, NULL),
(1063, 104, '3604100009', 'JUNTI', '00000', '2026-08-07 06:39:44', NULL, NULL),
(1064, 105, '3604110001', 'NANGGUNG', '00000', '2026-08-07 06:39:45', NULL, NULL),
(1065, 105, '3604110002', 'KOPO', '00000', '2026-08-07 06:39:45', NULL, NULL),
(1066, 105, '3604110003', 'MEKARBARU', '00000', '2026-08-07 06:39:45', NULL, NULL),
(1067, 105, '3604110004', 'GARUT', '00000', '2026-08-07 06:39:45', NULL, NULL),
(1068, 105, '3604110005', 'RANCASUMUR', '00000', '2026-08-07 06:39:45', NULL, NULL),
(1069, 105, '3604110006', 'CIDAHU', '00000', '2026-08-07 06:39:45', NULL, NULL),
(1070, 105, '3604110007', 'NYOMPOK', '00000', '2026-08-07 06:39:45', NULL, NULL),
(1071, 105, '3604110008', 'CARENANG UDIK', '00000', '2026-08-07 06:39:45', NULL, NULL),
(1072, 105, '3604110009', 'BABAKAN JAYA', '00000', '2026-08-07 06:39:45', NULL, NULL),
(1073, 105, '3604110010', 'GABUS', '00000', '2026-08-07 06:39:45', NULL, NULL),
(1074, 106, '3604120001', 'NAMBO UDIK', '00000', '2026-08-07 06:39:45', NULL, NULL),
(1075, 106, '3604120002', 'SITUTERATE', '00000', '2026-08-07 06:39:45', NULL, NULL),
(1076, 106, '3604120003', 'CIKANDE', '00000', '2026-08-07 06:39:45', NULL, NULL),
(1077, 106, '3604120004', 'LEUWILIMUS', '00000', '2026-08-07 06:39:45', NULL, NULL),
(1078, 106, '3604120005', 'PARIGI', '00000', '2026-08-07 06:39:45', NULL, NULL),
(1079, 106, '3604120006', 'SONGGOM JAYA', '00000', '2026-08-07 06:39:45', NULL, NULL),
(1080, 106, '3604120007', 'KOPER', '00000', '2026-08-07 06:39:45', NULL, NULL),
(1081, 106, '3604120008', 'KAMURANG', '00000', '2026-08-07 06:39:45', NULL, NULL),
(1082, 106, '3604120009', 'BAKUNG', '00000', '2026-08-07 06:39:45', NULL, NULL),
(1083, 106, '3604120010', 'GEMBOR UDIK', '00000', '2026-08-07 06:39:45', NULL, NULL),
(1084, 106, '3604120011', 'JULANG', '00000', '2026-08-07 06:39:45', NULL, NULL),
(1085, 106, '3604120013', 'SUKATANI', '00000', '2026-08-07 06:39:45', NULL, NULL),
(1086, 106, '3604120014', 'CIKANDE PERMAI', '00000', '2026-08-07 06:39:45', NULL, NULL),
(1087, 107, '3604121001', 'NAGARA', '00000', '2026-08-07 06:39:46', NULL, NULL),
(1088, 107, '3604121002', 'CIJERUK', '00000', '2026-08-07 06:39:46', NULL, NULL),
(1089, 107, '3604121003', 'BARENGKOK', '00000', '2026-08-07 06:39:46', NULL, NULL),
(1090, 107, '3604121004', 'NAMBO ILIR', '00000', '2026-08-07 06:39:46', NULL, NULL),
(1091, 107, '3604121005', 'KIBIN', '00000', '2026-08-07 06:39:46', NULL, NULL),
(1092, 107, '3604121006', 'TAMBAK', '00000', '2026-08-07 06:39:46', NULL, NULL),
(1093, 107, '3604121007', 'CIAGEL', '00000', '2026-08-07 06:39:46', NULL, NULL),
(1094, 107, '3604121008', 'KETOS', '00000', '2026-08-07 06:39:46', NULL, NULL),
(1095, 107, '3604121009', 'SUKAMAJU', '00000', '2026-08-07 06:39:46', NULL, NULL),
(1096, 108, '3604130001', 'SILEBU', '00000', '2026-08-07 06:39:47', NULL, NULL),
(1097, 108, '3604130002', 'SUKAJADI', '00000', '2026-08-07 06:39:47', NULL, NULL),
(1098, 108, '3604130003', 'PEMATANG', '00000', '2026-08-07 06:39:47', NULL, NULL),
(1099, 108, '3604130004', 'KRAMATJATI', '00000', '2026-08-07 06:39:47', NULL, NULL),
(1100, 108, '3604130006', 'UNDAR ANDIR', '00000', '2026-08-07 06:39:47', NULL, NULL),
(1101, 108, '3604130007', 'KENDAYAKAN', '00000', '2026-08-07 06:39:47', NULL, NULL),
(1102, 108, '3604130008', 'CISAIT', '00000', '2026-08-07 06:39:47', NULL, NULL),
(1103, 108, '3604130010', 'KRAGILAN', '00000', '2026-08-07 06:39:47', NULL, NULL),
(1104, 108, '3604130011', 'TEGALMAJA', '00000', '2026-08-07 06:39:47', NULL, NULL),
(1105, 108, '3604130012', 'JERUKTIPIS', '00000', '2026-08-07 06:39:47', NULL, NULL),
(1106, 109, '3604180001', 'SASAHAN', '00000', '2026-08-07 06:39:48', NULL, NULL),
(1107, 109, '3604180002', 'COKOPSULANJANA', '00000', '2026-08-07 06:39:48', NULL, NULL),
(1108, 109, '3604180003', 'TELAGA LUHUR', '00000', '2026-08-07 06:39:48', NULL, NULL),
(1109, 109, '3604180004', 'BINANGUN', '00000', '2026-08-07 06:39:48', NULL, NULL),
(1110, 109, '3604180005', 'KEMUNING', '00000', '2026-08-07 06:39:48', NULL, NULL),
(1111, 109, '3604180006', 'SUKABARES', '00000', '2026-08-07 06:39:48', NULL, NULL),
(1112, 109, '3604180007', 'SAMBILAWANG', '00000', '2026-08-07 06:39:48', NULL, NULL),
(1113, 109, '3604180008', 'MELATI', '00000', '2026-08-07 06:39:48', NULL, NULL),
(1114, 109, '3604180009', 'SAMPIR', '00000', '2026-08-07 06:39:48', NULL, NULL),
(1115, 109, '3604180010', 'WARINGINKURUNG', '00000', '2026-08-07 06:39:48', NULL, NULL),
(1116, 109, '3604180011', 'SUKADALEM', '00000', '2026-08-07 06:39:48', NULL, NULL),
(1117, 110, '3604190001', 'CIKEDUNG', '00000', '2026-08-07 06:39:49', NULL, NULL),
(1118, 110, '3604190002', 'CIWARNA', '00000', '2026-08-07 06:39:49', NULL, NULL),
(1119, 110, '3604190003', 'ANGSANA', '00000', '2026-08-07 06:39:49', NULL, NULL),
(1120, 110, '3604190004', 'TALAGA', '00000', '2026-08-07 06:39:49', NULL, NULL),
(1121, 110, '3604190005', 'BALEKAMBANG', '00000', '2026-08-07 06:39:49', NULL, NULL),
(1122, 110, '3604190006', 'LABUHAN', '00000', '2026-08-07 06:39:49', NULL, NULL),
(1123, 110, '3604190007', 'SANGIANG', '00000', '2026-08-07 06:39:49', NULL, NULL),
(1124, 110, '3604190008', 'PASIRWARU', '00000', '2026-08-07 06:39:49', NULL, NULL),
(1125, 110, '3604190009', 'WARINGIN', '00000', '2026-08-07 06:39:49', NULL, NULL),
(1126, 110, '3604190010', 'MANCAK', '00000', '2026-08-07 06:39:49', NULL, NULL),
(1127, 110, '3604190011', 'SIGEDONG', '00000', '2026-08-07 06:39:49', NULL, NULL),
(1128, 110, '3604190012', 'BATUKUDA', '00000', '2026-08-07 06:39:49', NULL, NULL),
(1129, 110, '3604190013', 'WINONG', '00000', '2026-08-07 06:39:49', NULL, NULL),
(1130, 110, '3604190014', 'BALE KENCANA', '00000', '2026-08-07 06:39:49', NULL, NULL),
(1131, 111, '3604200001', 'BANDULU', '00000', '2026-08-07 06:39:49', NULL, NULL),
(1132, 111, '3604200002', 'SINDANGMANDI', '00000', '2026-08-07 06:39:49', NULL, NULL),
(1133, 111, '3604200003', 'BANJARSARI', '00000', '2026-08-07 06:39:49', NULL, NULL),
(1134, 111, '3604200004', 'BUNIHARA', '00000', '2026-08-07 06:39:49', NULL, NULL),
(1135, 111, '3604200005', 'TANJUNGMANIS', '00000', '2026-08-07 06:39:49', NULL, NULL),
(1136, 111, '3604200006', 'CIKONENG', '00000', '2026-08-07 06:39:49', NULL, NULL),
(1137, 111, '3604200007', 'ANYAR', '00000', '2026-08-07 06:39:49', NULL, NULL),
(1138, 111, '3604200008', 'KOSAMBI RONYOK', '00000', '2026-08-07 06:39:49', NULL, NULL),
(1139, 111, '3604200009', 'SINDANGKARYA', '00000', '2026-08-07 06:39:49', NULL, NULL),
(1140, 111, '3604200010', 'MEKARSARI', '00000', '2026-08-07 06:39:49', NULL, NULL),
(1141, 111, '3604200011', 'TAMBANG AYAM', '00000', '2026-08-07 06:39:49', NULL, NULL),
(1142, 111, '3604200012', 'GROGOL INDAH', '00000', '2026-08-07 06:39:49', NULL, NULL),
(1143, 112, '3604210001', 'WANAKARTA', '00000', '2026-08-07 06:39:50', NULL, NULL),
(1144, 112, '3604210002', 'KERTASANA', '00000', '2026-08-07 06:39:50', NULL, NULL),
(1145, 112, '3604210003', 'MANGKUNEGARA', '00000', '2026-08-07 06:39:50', NULL, NULL),
(1146, 112, '3604210004', 'KARANGKEPUH', '00000', '2026-08-07 06:39:50', NULL, NULL),
(1147, 112, '3604210005', 'LAMBANGSARI', '00000', '2026-08-07 06:39:50', NULL, NULL),
(1148, 112, '3604210006', 'BOJONEGARA', '00000', '2026-08-07 06:39:50', NULL, NULL),
(1149, 112, '3604210007', 'MARGAGIRI', '00000', '2026-08-07 06:39:50', NULL, NULL),
(1150, 112, '3604210008', 'UKIRSARI', '00000', '2026-08-07 06:39:50', NULL, NULL),
(1151, 112, '3604210009', 'PAKUNCEN', '00000', '2026-08-07 06:39:50', NULL, NULL),
(1152, 112, '3604210010', 'PENGARENGAN', '00000', '2026-08-07 06:39:50', NULL, NULL),
(1153, 112, '3604210011', 'MEKAR  JAYA', '00000', '2026-08-07 06:39:50', NULL, NULL),
(1154, 113, '3604211001', 'ARGAWANA', '00000', '2026-08-07 06:39:51', NULL, NULL),
(1155, 113, '3604211002', 'BANYUWANGI', '00000', '2026-08-07 06:39:51', NULL, NULL),
(1156, 113, '3604211003', 'MARGASARI', '00000', '2026-08-07 06:39:51', NULL, NULL),
(1157, 113, '3604211004', 'PULOAMPEL', '00000', '2026-08-07 06:39:51', NULL, NULL),
(1158, 113, '3604211005', 'SUMURANJA', '00000', '2026-08-07 06:39:51', NULL, NULL),
(1159, 113, '3604211006', 'KEDUNG SOKA', '00000', '2026-08-07 06:39:51', NULL, NULL),
(1160, 113, '3604211007', 'MANGUNREJA', '00000', '2026-08-07 06:39:51', NULL, NULL),
(1161, 113, '3604211008', 'SALIRA', '00000', '2026-08-07 06:39:51', NULL, NULL),
(1162, 113, '3604211009', 'PULO PANJANG', '00000', '2026-08-07 06:39:51', NULL, NULL),
(1163, 114, '3604220001', 'LEBAKWANA', '00000', '2026-08-07 06:39:51', NULL, NULL),
(1164, 114, '3604220002', 'PELAMUNAN', '00000', '2026-08-07 06:39:51', NULL, NULL),
(1165, 114, '3604220003', 'MARGASANA', '00000', '2026-08-07 06:39:51', NULL, NULL),
(1166, 114, '3604220004', 'KRAMATWATU', '00000', '2026-08-07 06:39:51', NULL, NULL),
(1167, 114, '3604220005', 'PEJATEN', '00000', '2026-08-07 06:39:51', NULL, NULL),
(1168, 114, '3604220006', 'WANAYASA', '00000', '2026-08-07 06:39:51', NULL, NULL),
(1169, 114, '3604220007', 'HARJATANI', '00000', '2026-08-07 06:39:51', NULL, NULL),
(1170, 114, '3604220008', 'SERDANG', '00000', '2026-08-07 06:39:51', NULL, NULL),
(1171, 114, '3604220009', 'TOYOMERTO', '00000', '2026-08-07 06:39:51', NULL, NULL),
(1172, 114, '3604220010', 'PEGADINGAN', '00000', '2026-08-07 06:39:51', NULL, NULL),
(1173, 114, '3604220011', 'PAMENGKANG', '00000', '2026-08-07 06:39:51', NULL, NULL),
(1174, 114, '3604220012', 'TONJONG', '00000', '2026-08-07 06:39:51', NULL, NULL),
(1175, 114, '3604220013', 'TERATE', '00000', '2026-08-07 06:39:51', NULL, NULL),
(1176, 114, '3604220014', 'TELUK TERATE', '00000', '2026-08-07 06:39:51', NULL, NULL),
(1177, 114, '3604220015', 'MARGATANI', '00000', '2026-08-07 06:39:51', NULL, NULL),
(1178, 115, '3604240001', 'CITEREP', '00000', '2026-08-07 06:39:52', NULL, NULL),
(1179, 115, '3604240002', 'RANJENG', '00000', '2026-08-07 06:39:52', NULL, NULL),
(1180, 115, '3604240003', 'CIRUAS', '00000', '2026-08-07 06:39:52', NULL, NULL),
(1181, 115, '3604240004', 'KADIKARAN', '00000', '2026-08-07 06:39:52', NULL, NULL),
(1182, 115, '3604240005', 'SINGAMERTA', '00000', '2026-08-07 06:39:52', NULL, NULL),
(1183, 115, '3604240006', 'PULO', '00000', '2026-08-07 06:39:52', NULL, NULL),
(1184, 115, '3604240008', 'GOSARA', '00000', '2026-08-07 06:39:52', NULL, NULL),
(1185, 115, '3604240009', 'KEPANDEAN', '00000', '2026-08-07 06:39:52', NULL, NULL),
(1186, 115, '3604240010', 'PAMONG', '00000', '2026-08-07 06:39:52', NULL, NULL),
(1187, 115, '3604240011', 'CIGELAM', '00000', '2026-08-07 06:39:52', NULL, NULL),
(1188, 115, '3604240012', 'PENGGALANG', '00000', '2026-08-07 06:39:52', NULL, NULL),
(1189, 115, '3604240013', 'BUMIJAYA', '00000', '2026-08-07 06:39:52', NULL, NULL),
(1190, 115, '3604240015', 'KESERANGAN', '00000', '2026-08-07 06:39:52', NULL, NULL),
(1191, 115, '3604240016', 'BEBERAN', '00000', '2026-08-07 06:39:52', NULL, NULL),
(1192, 115, '3604240017', 'PELAWAD', '00000', '2026-08-07 06:39:52', NULL, NULL),
(1193, 116, '3604250001', 'SUKAJAYA', '00000', '2026-08-07 06:39:53', NULL, NULL),
(1194, 116, '3604250002', 'SUKANEGARA', '00000', '2026-08-07 06:39:53', NULL, NULL),
(1195, 116, '3604250007', 'KALAPIAN', '00000', '2026-08-07 06:39:53', NULL, NULL),
(1196, 116, '3604250008', 'KESERANGAN', '00000', '2026-08-07 06:39:53', NULL, NULL),
(1197, 116, '3604250009', 'PULO KENCANA', '00000', '2026-08-07 06:39:53', NULL, NULL),
(1198, 116, '3604250010', 'LINDUK', '00000', '2026-08-07 06:39:53', NULL, NULL),
(1199, 116, '3604250011', 'KUBANG PUJI', '00000', '2026-08-07 06:39:53', NULL, NULL),
(1200, 116, '3604250012', 'SINGARAJAN', '00000', '2026-08-07 06:39:53', NULL, NULL),
(1201, 116, '3604250013', 'PONTANG', '00000', '2026-08-07 06:39:53', NULL, NULL),
(1202, 116, '3604250014', 'WANAYASA', '00000', '2026-08-07 06:39:53', NULL, NULL),
(1203, 116, '3604250015', 'DOMAS', '00000', '2026-08-07 06:39:53', NULL, NULL),
(1204, 117, '3604251001', 'KEBONRATU', '00000', '2026-08-07 06:39:53', NULL, NULL),
(1205, 117, '3604251002', 'TERASBENDUNG', '00000', '2026-08-07 06:39:53', NULL, NULL),
(1206, 117, '3604251003', 'KAMARUTON', '00000', '2026-08-07 06:39:53', NULL, NULL),
(1207, 117, '3604251004', 'PURWADADI', '00000', '2026-08-07 06:39:53', NULL, NULL),
(1208, 117, '3604251005', 'LEBAKWANGI', '00000', '2026-08-07 06:39:53', NULL, NULL),
(1209, 117, '3604251006', 'TIREM', '00000', '2026-08-07 06:39:53', NULL, NULL),
(1210, 117, '3604251007', 'LEBAK KEPUH', '00000', '2026-08-07 06:39:53', NULL, NULL),
(1211, 117, '3604251008', 'KENCANA HARAPAN', '00000', '2026-08-07 06:39:53', NULL, NULL),
(1212, 117, '3604251009', 'BOLANG', '00000', '2026-08-07 06:39:53', NULL, NULL),
(1213, 117, '3604251010', 'PEGANDIKAN', '00000', '2026-08-07 06:39:53', NULL, NULL),
(1214, 118, '3604260008', 'MANDAYA', '00000', '2026-08-07 06:39:54', NULL, NULL),
(1215, 118, '3604260009', 'TERAS', '00000', '2026-08-07 06:39:54', NULL, NULL),
(1216, 118, '3604260010', 'WALIKUKUN', '00000', '2026-08-07 06:39:54', NULL, NULL),
(1217, 118, '3604260011', 'PANENJOAN', '00000', '2026-08-07 06:39:54', NULL, NULL),
(1218, 118, '3604260012', 'MEKARSARI', '00000', '2026-08-07 06:39:54', NULL, NULL),
(1219, 118, '3604260013', 'PAMANUK', '00000', '2026-08-07 06:39:54', NULL, NULL),
(1220, 118, '3604260014', 'CARENANG', '00000', '2026-08-07 06:39:54', NULL, NULL),
(1221, 118, '3604260015', 'RAGASMESIGIT', '00000', '2026-08-07 06:39:54', NULL, NULL),
(1222, 119, '3604261001', 'GEMBOR', '00000', '2026-08-07 06:39:55', NULL, NULL),
(1223, 119, '3604261003', 'CAKUNG', '00000', '2026-08-07 06:39:55', NULL, NULL),
(1224, 119, '3604261004', 'LAMARAN', '00000', '2026-08-07 06:39:55', NULL, NULL),
(1225, 119, '3604261005', 'WARAKAS', '00000', '2026-08-07 06:39:55', NULL, NULL),
(1226, 119, '3604261006', 'BINUANG', '00000', '2026-08-07 06:39:55', NULL, NULL),
(1227, 119, '3604261007', 'SUKAMAMPIR', '00000', '2026-08-07 06:39:55', NULL, NULL),
(1228, 120, '3604270010', 'TENGKURAK', '00000', '2026-08-07 06:39:56', NULL, NULL),
(1229, 120, '3604270011', 'TIRTAYASA', '00000', '2026-08-07 06:39:56', NULL, NULL),
(1230, 120, '3604270012', 'LABAN', '00000', '2026-08-07 06:39:56', NULL, NULL),
(1231, 120, '3604270014', 'SAMPARWADI', '00000', '2026-08-07 06:39:56', NULL, NULL),
(1232, 120, '3604270016', 'KEBON', '00000', '2026-08-07 06:39:56', NULL, NULL),
(1233, 120, '3604270017', 'KEBUYUTAN', '00000', '2026-08-07 06:39:56', NULL, NULL),
(1234, 120, '3604270018', 'KEMANISAN', '00000', '2026-08-07 06:39:56', NULL, NULL),
(1235, 120, '3604270019', 'PONTANG LEGON', '00000', '2026-08-07 06:39:56', NULL, NULL),
(1236, 120, '3604270020', 'SUSUKAN', '00000', '2026-08-07 06:39:56', NULL, NULL),
(1237, 120, '3604270021', 'ALANG ALANG', '00000', '2026-08-07 06:39:56', NULL, NULL),
(1238, 120, '3604270022', 'LONTAR', '00000', '2026-08-07 06:39:56', NULL, NULL);
INSERT INTO `m_kelurahan` (`id_kelurahan`, `id_kecamatan`, `kode_kelurahan`, `nama_kelurahan`, `kode_pos`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1239, 120, '3604270023', 'WARGASARA', '00000', '2026-08-07 06:39:56', NULL, NULL),
(1240, 121, '3604271001', 'SIREMEN', '00000', '2026-08-07 06:39:56', NULL, NULL),
(1241, 121, '3604271002', 'CIBODAS', '00000', '2026-08-07 06:39:56', NULL, NULL),
(1242, 121, '3604271004', 'LEMPUYANG', '00000', '2026-08-07 06:39:56', NULL, NULL),
(1243, 121, '3604271006', 'SUKAMANAH', '00000', '2026-08-07 06:39:56', NULL, NULL),
(1244, 121, '3604271007', 'TANARA', '00000', '2026-08-07 06:39:56', NULL, NULL),
(1245, 121, '3604271008', 'PEDALEMAN', '00000', '2026-08-07 06:39:56', NULL, NULL),
(1246, 121, '3604271009', 'TENJO AYU', '00000', '2026-08-07 06:39:56', NULL, NULL),
(1247, 122, '3671010001', 'TAJUR', '00000', '2026-08-07 06:39:58', NULL, NULL),
(1248, 122, '3671010002', 'PARUNG SERAB', '00000', '2026-08-07 06:39:58', NULL, NULL),
(1249, 122, '3671010003', 'PANINGGILAN', '00000', '2026-08-07 06:39:58', NULL, NULL),
(1250, 122, '3671010012', 'PANINGGILAN UTARA', '00000', '2026-08-07 06:39:58', NULL, NULL),
(1251, 122, '3671010013', 'SUDIMARA SELATAN', '00000', '2026-08-07 06:39:58', NULL, NULL),
(1252, 122, '3671010014', 'SUDIMARA BARAT', '00000', '2026-08-07 06:39:58', NULL, NULL),
(1253, 122, '3671010015', 'SUDIMARA JAYA', '00000', '2026-08-07 06:39:58', NULL, NULL),
(1254, 122, '3671010016', 'SUDIMARA TIMUR', '00000', '2026-08-07 06:39:58', NULL, NULL),
(1255, 123, '3671011001', 'LARANGAN SELATAN', '00000', '2026-08-07 06:39:58', NULL, NULL),
(1256, 123, '3671011002', 'GAGA', '00000', '2026-08-07 06:39:58', NULL, NULL),
(1257, 123, '3671011003', 'CIPADU JAYA', '00000', '2026-08-07 06:39:58', NULL, NULL),
(1258, 123, '3671011004', 'KEREO SELATAN', '00000', '2026-08-07 06:39:58', NULL, NULL),
(1259, 123, '3671011005', 'CIPADU', '00000', '2026-08-07 06:39:58', NULL, NULL),
(1260, 123, '3671011006', 'KEREO', '00000', '2026-08-07 06:39:58', NULL, NULL),
(1261, 123, '3671011007', 'LARANGAN INDAH', '00000', '2026-08-07 06:39:58', NULL, NULL),
(1262, 123, '3671011008', 'LARANGAN UTARA', '00000', '2026-08-07 06:39:58', NULL, NULL),
(1263, 124, '3671012001', 'PEDURENAN', '00000', '2026-08-07 06:39:59', NULL, NULL),
(1264, 124, '3671012002', 'PONDOK PUCUNG', '00000', '2026-08-07 06:39:59', NULL, NULL),
(1265, 124, '3671012003', 'KARANG TENGAH', '00000', '2026-08-07 06:39:59', NULL, NULL),
(1266, 124, '3671012004', 'KARANG TIMUR', '00000', '2026-08-07 06:39:59', NULL, NULL),
(1267, 124, '3671012005', 'KARANG MULYA', '00000', '2026-08-07 06:39:59', NULL, NULL),
(1268, 124, '3671012006', 'PARUNG JAYA', '00000', '2026-08-07 06:39:59', NULL, NULL),
(1269, 124, '3671012007', 'PONDOK BAHAR', '00000', '2026-08-07 06:39:59', NULL, NULL),
(1270, 125, '3671020012', 'PORIS PLAWAD INDAH', '00000', '2026-08-07 06:40:00', NULL, NULL),
(1271, 125, '3671020013', 'CIPONDOH', '00000', '2026-08-07 06:40:00', NULL, NULL),
(1272, 125, '3671020014', 'KENANGA', '00000', '2026-08-07 06:40:00', NULL, NULL),
(1273, 125, '3671020015', 'GONDRONG', '00000', '2026-08-07 06:40:00', NULL, NULL),
(1274, 125, '3671020016', 'PETIR', '00000', '2026-08-07 06:40:00', NULL, NULL),
(1275, 125, '3671020017', 'KETAPANG', '00000', '2026-08-07 06:40:00', NULL, NULL),
(1276, 125, '3671020018', 'CIPONDOH INDAH', '00000', '2026-08-07 06:40:00', NULL, NULL),
(1277, 125, '3671020019', 'CIPONDOH MAKMUR', '00000', '2026-08-07 06:40:00', NULL, NULL),
(1278, 125, '3671020020', 'PORIS PLAWAD UTARA', '00000', '2026-08-07 06:40:00', NULL, NULL),
(1279, 125, '3671020021', 'PORIS PLAWAD', '00000', '2026-08-07 06:40:00', NULL, NULL),
(1280, 126, '3671021001', 'PANUNGGANGAN UTARA', '00000', '2026-08-07 06:40:00', NULL, NULL),
(1281, 126, '3671021002', 'PANUNGGANGAN', '00000', '2026-08-07 06:40:00', NULL, NULL),
(1282, 126, '3671021003', 'PANUNGGANGAN TIMUR', '00000', '2026-08-07 06:40:00', NULL, NULL),
(1283, 126, '3671021004', 'KUNCIRAN', '00000', '2026-08-07 06:40:00', NULL, NULL),
(1284, 126, '3671021005', 'KUNCIRAN INDAH', '00000', '2026-08-07 06:40:00', NULL, NULL),
(1285, 126, '3671021006', 'SUDIMARA PINANG', '00000', '2026-08-07 06:40:00', NULL, NULL),
(1286, 126, '3671021007', 'PINANG', '00000', '2026-08-07 06:40:00', NULL, NULL),
(1287, 126, '3671021008', 'NEROKTOG', '00000', '2026-08-07 06:40:00', NULL, NULL),
(1288, 126, '3671021009', 'KUNCIRAN JAYA', '00000', '2026-08-07 06:40:00', NULL, NULL),
(1289, 126, '3671021010', 'PAKOJAN', '00000', '2026-08-07 06:40:00', NULL, NULL),
(1290, 126, '3671021011', 'CIPETE', '00000', '2026-08-07 06:40:00', NULL, NULL),
(1291, 127, '3671030004', 'CIKOKOL', '00000', '2026-08-07 06:40:01', NULL, NULL),
(1292, 127, '3671030005', 'KELAPA INDAH', '00000', '2026-08-07 06:40:01', NULL, NULL),
(1293, 127, '3671030006', 'BABAKAN', '00000', '2026-08-07 06:40:01', NULL, NULL),
(1294, 127, '3671030014', 'SUKASARI', '00000', '2026-08-07 06:40:01', NULL, NULL),
(1295, 127, '3671030015', 'BUARAN INDAH', '00000', '2026-08-07 06:40:01', NULL, NULL),
(1296, 127, '3671030016', 'TANAH TINGGI', '00000', '2026-08-07 06:40:01', NULL, NULL),
(1297, 127, '3671030017', 'SUKAASIH', '00000', '2026-08-07 06:40:01', NULL, NULL),
(1298, 127, '3671030018', 'SUKARASA', '00000', '2026-08-07 06:40:01', NULL, NULL),
(1299, 128, '3671031001', 'KARAWACI BARU', '00000', '2026-08-07 06:40:02', NULL, NULL),
(1300, 128, '3671031002', 'NUSAJAYA', '00000', '2026-08-07 06:40:02', NULL, NULL),
(1301, 128, '3671031003', 'BOJONGJAYA', '00000', '2026-08-07 06:40:02', NULL, NULL),
(1302, 128, '3671031004', 'KARAWACI', '00000', '2026-08-07 06:40:02', NULL, NULL),
(1303, 128, '3671031005', 'CIMONE JAYA', '00000', '2026-08-07 06:40:02', NULL, NULL),
(1304, 128, '3671031006', 'CIMONE', '00000', '2026-08-07 06:40:02', NULL, NULL),
(1305, 128, '3671031008', 'MARGASARI', '00000', '2026-08-07 06:40:02', NULL, NULL),
(1306, 128, '3671031009', 'PABUARAN', '00000', '2026-08-07 06:40:02', NULL, NULL),
(1307, 128, '3671031010', 'SUKAJADI', '00000', '2026-08-07 06:40:02', NULL, NULL),
(1308, 128, '3671031012', 'KOANGJAYA', '00000', '2026-08-07 06:40:02', NULL, NULL),
(1309, 128, '3671031013', 'PASARBARU', '00000', '2026-08-07 06:40:02', NULL, NULL),
(1310, 128, '3671031014', 'SUMUR PACING', '00000', '2026-08-07 06:40:02', NULL, NULL),
(1311, 128, '3671031015', 'PABUARAN TUMPENG', '00000', '2026-08-07 06:40:02', NULL, NULL),
(1312, 128, '3671031016', 'NAMBOJAYA', '00000', '2026-08-07 06:40:02', NULL, NULL),
(1313, 129, '3671040001', 'MANIS JAYA', '00000', '2026-08-07 06:40:02', NULL, NULL),
(1314, 129, '3671040002', 'JATAKE', '00000', '2026-08-07 06:40:02', NULL, NULL),
(1315, 129, '3671040003', 'GANDASARI', '00000', '2026-08-07 06:40:02', NULL, NULL),
(1316, 129, '3671040010', 'KRONCONG', '00000', '2026-08-07 06:40:02', NULL, NULL),
(1317, 129, '3671040011', 'ALAM JAYA', '00000', '2026-08-07 06:40:02', NULL, NULL),
(1318, 129, '3671040012', 'PASIR JAYA', '00000', '2026-08-07 06:40:02', NULL, NULL),
(1319, 130, '3671041001', 'PANUNGGANGAN BARAT', '00000', '2026-08-07 06:40:03', NULL, NULL),
(1320, 130, '3671041002', 'CIBODASARI', '00000', '2026-08-07 06:40:03', NULL, NULL),
(1321, 130, '3671041003', 'CIBODAS BARU', '00000', '2026-08-07 06:40:03', NULL, NULL),
(1322, 130, '3671041004', 'CIBODAS', '00000', '2026-08-07 06:40:03', NULL, NULL),
(1323, 130, '3671041005', 'UWUNG JAYA', '00000', '2026-08-07 06:40:03', NULL, NULL),
(1324, 130, '3671041006', 'JATIUWUNG', '00000', '2026-08-07 06:40:03', NULL, NULL),
(1325, 131, '3671042001', 'GEMBOR', '00000', '2026-08-07 06:40:04', NULL, NULL),
(1326, 131, '3671042002', 'GEBANG RAYA', '00000', '2026-08-07 06:40:04', NULL, NULL),
(1327, 131, '3671042003', 'SANGIANG JAYA', '00000', '2026-08-07 06:40:04', NULL, NULL),
(1328, 131, '3671042004', 'PERIUK', '00000', '2026-08-07 06:40:04', NULL, NULL),
(1329, 131, '3671042005', 'PERIUK JAYA', '00000', '2026-08-07 06:40:04', NULL, NULL),
(1330, 132, '3671050001', 'PORISGAGA BARU', '00000', '2026-08-07 06:40:04', NULL, NULL),
(1331, 132, '3671050002', 'PORIS JAYA', '00000', '2026-08-07 06:40:04', NULL, NULL),
(1332, 132, '3671050003', 'PORISGAGA', '00000', '2026-08-07 06:40:04', NULL, NULL),
(1333, 132, '3671050004', 'KEBON BESAR', '00000', '2026-08-07 06:40:04', NULL, NULL),
(1334, 132, '3671050005', 'BATUCEPER', '00000', '2026-08-07 06:40:04', NULL, NULL),
(1335, 132, '3671050006', 'BATUJAYA', '00000', '2026-08-07 06:40:04', NULL, NULL),
(1336, 132, '3671050007', 'BATUSARI', '00000', '2026-08-07 06:40:04', NULL, NULL),
(1337, 133, '3671051001', 'KARANG ANYAR', '00000', '2026-08-07 06:40:05', NULL, NULL),
(1338, 133, '3671051002', 'KARANG SARI', '00000', '2026-08-07 06:40:05', NULL, NULL),
(1339, 133, '3671051003', 'NEGLASARI', '00000', '2026-08-07 06:40:05', NULL, NULL),
(1340, 133, '3671051004', 'MEKARSARI', '00000', '2026-08-07 06:40:05', NULL, NULL),
(1341, 133, '3671051005', 'KEDAUNG BARU', '00000', '2026-08-07 06:40:05', NULL, NULL),
(1342, 133, '3671051006', 'KEDAUNG WETAN', '00000', '2026-08-07 06:40:05', NULL, NULL),
(1343, 133, '3671051007', 'SELAPAJANG JAYA', '00000', '2026-08-07 06:40:05', NULL, NULL),
(1344, 134, '3671060002', 'JURUMUDI BARU', '00000', '2026-08-07 06:40:06', NULL, NULL),
(1345, 134, '3671060003', 'JURUMUDI', '00000', '2026-08-07 06:40:06', NULL, NULL),
(1346, 134, '3671060004', 'PAJANG', '00000', '2026-08-07 06:40:06', NULL, NULL),
(1347, 134, '3671060005', 'BENDA', '00000', '2026-08-07 06:40:06', NULL, NULL),
(1348, 135, '3672010001', 'GUNUNGSUGIH', '00000', '2026-08-07 06:40:07', NULL, NULL),
(1349, 135, '3672010003', 'RANDAKARI', '00000', '2026-08-07 06:40:07', NULL, NULL),
(1350, 135, '3672010004', 'TEGALRATU', '00000', '2026-08-07 06:40:07', NULL, NULL),
(1351, 135, '3672010005', 'BANJAR NEGARA', '00000', '2026-08-07 06:40:07', NULL, NULL),
(1352, 135, '3672010013', 'KUBANGSARI', '00000', '2026-08-07 06:40:07', NULL, NULL),
(1353, 136, '3672011006', 'DERINGO', '00000', '2026-08-07 06:40:08', NULL, NULL),
(1354, 136, '3672011007', 'LEBAKDENOK', '00000', '2026-08-07 06:40:08', NULL, NULL),
(1355, 136, '3672011008', 'TAMANBARU', '00000', '2026-08-07 06:40:08', NULL, NULL),
(1356, 136, '3672011009', 'CITANGKIL', '00000', '2026-08-07 06:40:08', NULL, NULL),
(1357, 136, '3672011010', 'KEBONSARI', '00000', '2026-08-07 06:40:08', NULL, NULL),
(1358, 136, '3672011011', 'WARNASARI', '00000', '2026-08-07 06:40:08', NULL, NULL),
(1359, 136, '3672011012', 'SAMANGRAYA', '00000', '2026-08-07 06:40:08', NULL, NULL),
(1360, 137, '3672020011', 'MEKARSARI', '00000', '2026-08-07 06:40:09', NULL, NULL),
(1361, 137, '3672020012', 'TAMANSARI', '00000', '2026-08-07 06:40:09', NULL, NULL),
(1362, 137, '3672020013', 'LEBAK GEDE', '00000', '2026-08-07 06:40:09', NULL, NULL),
(1363, 137, '3672020014', 'SURALAYA', '00000', '2026-08-07 06:40:09', NULL, NULL),
(1364, 138, '3672021001', 'RAMANUJU', '00000', '2026-08-07 06:40:10', NULL, NULL),
(1365, 138, '3672021002', 'KEBONDALEM', '00000', '2026-08-07 06:40:10', NULL, NULL),
(1366, 138, '3672021003', 'PURWAKARTA', '00000', '2026-08-07 06:40:10', NULL, NULL),
(1367, 138, '3672021004', 'TEGAL BUNDER', '00000', '2026-08-07 06:40:10', NULL, NULL),
(1368, 138, '3672021005', 'PABEAN', '00000', '2026-08-07 06:40:10', NULL, NULL),
(1369, 138, '3672021006', 'KOTABUMI', '00000', '2026-08-07 06:40:10', NULL, NULL),
(1370, 139, '3672022007', 'KOTASARI', '00000', '2026-08-07 06:40:10', NULL, NULL),
(1371, 139, '3672022008', 'GROGOL', '00000', '2026-08-07 06:40:10', NULL, NULL),
(1372, 139, '3672022009', 'RAWA ARUM', '00000', '2026-08-07 06:40:10', NULL, NULL),
(1373, 140, '3672030001', 'BAGENDUNG', '00000', '2026-08-07 06:40:11', NULL, NULL),
(1374, 140, '3672030002', 'CIWEDUS', '00000', '2026-08-07 06:40:11', NULL, NULL),
(1375, 140, '3672030003', 'BENDUNGAN', '00000', '2026-08-07 06:40:11', NULL, NULL),
(1376, 140, '3672030004', 'CIWADUK', '00000', '2026-08-07 06:40:11', NULL, NULL),
(1377, 140, '3672030005', 'KETILENG', '00000', '2026-08-07 06:40:11', NULL, NULL),
(1378, 141, '3672031001', 'JOMBANG WETAN', '00000', '2026-08-07 06:40:11', NULL, NULL),
(1379, 141, '3672031002', 'MASIGIT', '00000', '2026-08-07 06:40:11', NULL, NULL),
(1380, 141, '3672031003', 'PANGGUNG RAWI', '00000', '2026-08-07 06:40:11', NULL, NULL),
(1381, 141, '3672031004', 'GEDONG DALEM', '00000', '2026-08-07 06:40:11', NULL, NULL),
(1382, 141, '3672031005', 'SUKMAJAYA', '00000', '2026-08-07 06:40:11', NULL, NULL),
(1383, 142, '3672040001', 'BULAKAN', '00000', '2026-08-07 06:40:13', NULL, NULL),
(1384, 142, '3672040002', 'CIKERAI', '00000', '2026-08-07 06:40:13', NULL, NULL),
(1385, 142, '3672040003', 'KALITIMBANG', '00000', '2026-08-07 06:40:13', NULL, NULL),
(1386, 142, '3672040004', 'KARANGASEM', '00000', '2026-08-07 06:40:13', NULL, NULL),
(1387, 142, '3672040005', 'CIBEBER', '00000', '2026-08-07 06:40:13', NULL, NULL),
(1388, 142, '3672040006', 'KEDALEMAN', '00000', '2026-08-07 06:40:13', NULL, NULL),
(1389, 143, '3673010001', 'KAMANISAN', '00000', '2026-08-07 06:40:14', NULL, NULL),
(1390, 143, '3673010002', 'PANCALAKSANA', '00000', '2026-08-07 06:40:14', NULL, NULL),
(1391, 143, '3673010003', 'TINGGAR', '00000', '2026-08-07 06:40:14', NULL, NULL),
(1392, 143, '3673010004', 'CIPETE', '00000', '2026-08-07 06:40:14', NULL, NULL),
(1393, 143, '3673010005', 'CURUGMANIS', '00000', '2026-08-07 06:40:14', NULL, NULL),
(1394, 143, '3673010006', 'SUKALAKSANA', '00000', '2026-08-07 06:40:14', NULL, NULL),
(1395, 143, '3673010007', 'SUKAWANA', '00000', '2026-08-07 06:40:14', NULL, NULL),
(1396, 143, '3673010009', 'SUKAJAYA', '00000', '2026-08-07 06:40:14', NULL, NULL),
(1397, 143, '3673010010', 'CILAKU', '00000', '2026-08-07 06:40:14', NULL, NULL),
(1398, 144, '3673020001', 'NYAPAH', '00000', '2026-08-07 06:40:15', NULL, NULL),
(1399, 144, '3673020002', 'LEBAKWANGI', '00000', '2026-08-07 06:40:15', NULL, NULL),
(1400, 144, '3673020003', 'CIGOONG', '00000', '2026-08-07 06:40:15', NULL, NULL),
(1401, 144, '3673020004', 'TEGALSARI', '00000', '2026-08-07 06:40:15', NULL, NULL),
(1402, 144, '3673020005', 'PASULUHAN', '00000', '2026-08-07 06:40:15', NULL, NULL),
(1403, 144, '3673020006', 'PABUARAN', '00000', '2026-08-07 06:40:15', NULL, NULL),
(1404, 144, '3673020007', 'WALANTAKA', '00000', '2026-08-07 06:40:15', NULL, NULL),
(1405, 144, '3673020008', 'PENGAMPELAN', '00000', '2026-08-07 06:40:15', NULL, NULL),
(1406, 144, '3673020009', 'PIPITAN', '00000', '2026-08-07 06:40:15', NULL, NULL),
(1407, 144, '3673020010', 'KIARA', '00000', '2026-08-07 06:40:15', NULL, NULL),
(1408, 144, '3673020011', 'PAGERAGUNG', '00000', '2026-08-07 06:40:15', NULL, NULL),
(1409, 144, '3673020012', 'KALODRAN', '00000', '2026-08-07 06:40:15', NULL, NULL),
(1410, 144, '3673020014', 'TERITIH', '00000', '2026-08-07 06:40:15', NULL, NULL),
(1411, 145, '3673030001', 'GELAM', '00000', '2026-08-07 06:40:16', NULL, NULL),
(1412, 145, '3673030002', 'DALUNG', '00000', '2026-08-07 06:40:16', NULL, NULL),
(1413, 145, '3673030003', 'TEMBONG', '00000', '2026-08-07 06:40:16', NULL, NULL),
(1414, 145, '3673030004', 'KARUNDANG', '00000', '2026-08-07 06:40:16', NULL, NULL),
(1415, 145, '3673030005', 'CIPOCOK JAYA', '00000', '2026-08-07 06:40:16', NULL, NULL),
(1416, 145, '3673030006', 'BANJARSARI', '00000', '2026-08-07 06:40:16', NULL, NULL),
(1417, 145, '3673030007', 'BANJARAGUNG', '00000', '2026-08-07 06:40:16', NULL, NULL),
(1418, 145, '3673030008', 'PANANCANGAN', '00000', '2026-08-07 06:40:16', NULL, NULL),
(1419, 146, '3673040001', 'SERANG', '00000', '2026-08-07 06:40:17', NULL, NULL),
(1420, 146, '3673040002', 'CIPARE', '00000', '2026-08-07 06:40:17', NULL, NULL),
(1421, 146, '3673040004', 'CIMUNCANG', '00000', '2026-08-07 06:40:17', NULL, NULL),
(1422, 146, '3673040005', 'KOTABARU', '00000', '2026-08-07 06:40:17', NULL, NULL),
(1423, 146, '3673040006', 'LONTARBARU', '00000', '2026-08-07 06:40:17', NULL, NULL),
(1424, 146, '3673040007', 'KAGUNGAN', '00000', '2026-08-07 06:40:17', NULL, NULL),
(1425, 146, '3673040008', 'LOPANG', '00000', '2026-08-07 06:40:17', NULL, NULL),
(1426, 146, '3673040010', 'KALIGANDU', '00000', '2026-08-07 06:40:17', NULL, NULL),
(1427, 146, '3673040011', 'TERONDOL', '00000', '2026-08-07 06:40:17', NULL, NULL),
(1428, 146, '3673040012', 'SUKAWANA', '00000', '2026-08-07 06:40:17', NULL, NULL),
(1429, 147, '3673050001', 'CILOWONG', '00000', '2026-08-07 06:40:17', NULL, NULL),
(1430, 147, '3673050002', 'SAYAR', '00000', '2026-08-07 06:40:17', NULL, NULL),
(1431, 147, '3673050003', 'SEPANG', '00000', '2026-08-07 06:40:17', NULL, NULL),
(1432, 147, '3673050004', 'PANCUR', '00000', '2026-08-07 06:40:17', NULL, NULL),
(1433, 147, '3673050005', 'KALANG ANYAR', '00000', '2026-08-07 06:40:17', NULL, NULL),
(1434, 147, '3673050006', 'KURANJI', '00000', '2026-08-07 06:40:17', NULL, NULL),
(1435, 147, '3673050007', 'PANGGUNGJATI', '00000', '2026-08-07 06:40:17', NULL, NULL),
(1436, 147, '3673050008', 'DRANGONG', '00000', '2026-08-07 06:40:17', NULL, NULL),
(1437, 147, '3673050009', 'TAKTAKAN', '00000', '2026-08-07 06:40:17', NULL, NULL),
(1438, 147, '3673050010', 'UMBUL TENGAH', '00000', '2026-08-07 06:40:17', NULL, NULL),
(1439, 147, '3673050011', 'LIALANG', '00000', '2026-08-07 06:40:17', NULL, NULL),
(1440, 147, '3673050012', 'TAMANBARU', '00000', '2026-08-07 06:40:17', NULL, NULL),
(1441, 147, '3673050013', 'CIBENDUNG', '00000', '2026-08-07 06:40:17', NULL, NULL),
(1442, 148, '3673060001', 'KASEMEN', '00000', '2026-08-07 06:40:18', NULL, NULL),
(1443, 148, '3673060002', 'WARUNG JAUD', '00000', '2026-08-07 06:40:18', NULL, NULL),
(1444, 148, '3673060003', 'MESJID PRIYAYI', '00000', '2026-08-07 06:40:18', NULL, NULL),
(1445, 148, '3673060006', 'SAWAH LUHUR', '00000', '2026-08-07 06:40:18', NULL, NULL),
(1446, 148, '3673060007', 'KILASAH', '00000', '2026-08-07 06:40:18', NULL, NULL),
(1447, 148, '3673060008', 'MARGALUYU', '00000', '2026-08-07 06:40:18', NULL, NULL),
(1448, 148, '3673060009', 'KASUNYATAN', '00000', '2026-08-07 06:40:18', NULL, NULL),
(1449, 148, '3673060010', 'BANTEN', '00000', '2026-08-07 06:40:18', NULL, NULL),
(1450, 149, '3674010001', 'KRANGGAN', '00000', '2026-08-07 06:40:19', NULL, NULL),
(1451, 149, '3674010003', 'KADEMANGAN', '00000', '2026-08-07 06:40:19', NULL, NULL),
(1452, 149, '3674010005', 'BABAKAN', '00000', '2026-08-07 06:40:19', NULL, NULL),
(1453, 149, '3674010006', 'BAKTI JAYA', '00000', '2026-08-07 06:40:19', NULL, NULL),
(1454, 150, '3674020009', 'BUARAN', '00000', '2026-08-07 06:40:20', NULL, NULL),
(1455, 150, '3674020010', 'CIATER', '00000', '2026-08-07 06:40:20', NULL, NULL),
(1456, 150, '3674020011', 'RAWA MEKAR JAYA', '00000', '2026-08-07 06:40:20', NULL, NULL),
(1457, 150, '3674020012', 'RAWA BUNTU', '00000', '2026-08-07 06:40:20', NULL, NULL),
(1458, 150, '3674020013', 'SERPONG', '00000', '2026-08-07 06:40:20', NULL, NULL),
(1459, 150, '3674020018', 'CILENGGANG', '00000', '2026-08-07 06:40:20', NULL, NULL),
(1460, 150, '3674020019', 'LENGKONG GUDANG', '00000', '2026-08-07 06:40:20', NULL, NULL),
(1461, 150, '3674020020', 'LENGKONG GUDANG TIMUR', '00000', '2026-08-07 06:40:20', NULL, NULL),
(1462, 150, '3674020021', 'LENGKONG WETAN', '00000', '2026-08-07 06:40:20', NULL, NULL),
(1463, 151, '3674030001', 'PONDOK BENDA', '00000', '2026-08-07 06:40:21', NULL, NULL),
(1464, 151, '3674030002', 'PAMULANG BARAT', '00000', '2026-08-07 06:40:21', NULL, NULL),
(1465, 151, '3674030003', 'PAMULANG TIMUR', '00000', '2026-08-07 06:40:21', NULL, NULL),
(1466, 151, '3674030004', 'PONDOK CABE UDIK', '00000', '2026-08-07 06:40:21', NULL, NULL),
(1467, 151, '3674030005', 'PONDOK CABE ILIR', '00000', '2026-08-07 06:40:21', NULL, NULL),
(1468, 151, '3674030006', 'KEDAUNG', '00000', '2026-08-07 06:40:21', NULL, NULL),
(1469, 151, '3674030007', 'BAMBU APUS', '00000', '2026-08-07 06:40:21', NULL, NULL),
(1470, 151, '3674030008', 'BENDA BARU', '00000', '2026-08-07 06:40:21', NULL, NULL),
(1471, 152, '3674040001', 'SARUA', '00000', '2026-08-07 06:40:21', NULL, NULL),
(1472, 152, '3674040002', 'JOMBANG', '00000', '2026-08-07 06:40:21', NULL, NULL),
(1473, 152, '3674040003', 'SAWAH BARU', '00000', '2026-08-07 06:40:21', NULL, NULL),
(1474, 152, '3674040004', 'SARUA INDAH', '00000', '2026-08-07 06:40:21', NULL, NULL),
(1475, 152, '3674040005', 'SAWAH', '00000', '2026-08-07 06:40:21', NULL, NULL),
(1476, 152, '3674040006', 'CIPUTAT', '00000', '2026-08-07 06:40:21', NULL, NULL),
(1477, 152, '3674040007', 'CIPAYUNG', '00000', '2026-08-07 06:40:21', NULL, NULL),
(1478, 153, '3674050001', 'PISANGAN', '00000', '2026-08-07 06:40:22', NULL, NULL),
(1479, 153, '3674050002', 'CIREUNDEU', '00000', '2026-08-07 06:40:22', NULL, NULL),
(1480, 153, '3674050003', 'CEMPAKA PUTIH', '00000', '2026-08-07 06:40:22', NULL, NULL),
(1481, 153, '3674050004', 'REMPOA', '00000', '2026-08-07 06:40:22', NULL, NULL),
(1482, 153, '3674050005', 'RENGAS', '00000', '2026-08-07 06:40:22', NULL, NULL),
(1483, 153, '3674050006', 'PONDOK RANJI', '00000', '2026-08-07 06:40:22', NULL, NULL),
(1484, 154, '3674060001', 'PERIGI BARU', '00000', '2026-08-07 06:40:22', NULL, NULL),
(1485, 154, '3674060002', 'PONDOK KACANG BARAT', '00000', '2026-08-07 06:40:22', NULL, NULL),
(1486, 154, '3674060003', 'PONDOK KACANG TIMUR', '00000', '2026-08-07 06:40:22', NULL, NULL),
(1487, 154, '3674060004', 'PERIGI', '00000', '2026-08-07 06:40:22', NULL, NULL),
(1488, 154, '3674060005', 'PONDOK PUCUNG', '00000', '2026-08-07 06:40:22', NULL, NULL),
(1489, 154, '3674060006', 'PONDOK JAYA', '00000', '2026-08-07 06:40:22', NULL, NULL),
(1490, 154, '3674060007', 'PONDOK AREN', '00000', '2026-08-07 06:40:22', NULL, NULL),
(1491, 154, '3674060008', 'JURANG MANGGU BARAT', '00000', '2026-08-07 06:40:22', NULL, NULL),
(1492, 154, '3674060009', 'JURANG MANGGU TIMUR', '00000', '2026-08-07 06:40:22', NULL, NULL),
(1493, 154, '3674060010', 'PONDOK KARYA', '00000', '2026-08-07 06:40:22', NULL, NULL),
(1494, 154, '3674060011', 'PONDOK BETUNG', '00000', '2026-08-07 06:40:22', NULL, NULL),
(1495, 155, '3674070001', 'LENGKONG KARYA', '00000', '2026-08-07 06:40:23', NULL, NULL),
(1496, 155, '3674070002', 'JELUPANG', '00000', '2026-08-07 06:40:23', NULL, NULL),
(1497, 155, '3674070003', 'PONDOK JAGUNG', '00000', '2026-08-07 06:40:23', NULL, NULL),
(1498, 155, '3674070004', 'PONDOK JAGUNG TIMUR', '00000', '2026-08-07 06:40:23', NULL, NULL),
(1499, 155, '3674070005', 'PAKULONAN', '00000', '2026-08-07 06:40:23', NULL, NULL),
(1500, 155, '3674070006', 'PAKU ALAM', '00000', '2026-08-07 06:40:23', NULL, NULL),
(1501, 155, '3674070007', 'PAKU JAYA', '00000', '2026-08-07 06:40:23', NULL, NULL);

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

--
-- Dumping data for table `m_kuota`
--

INSERT INTO `m_kuota` (`id_kuota`, `id_bidang`, `tahun`, `bulan`, `kuota`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, '0000', 0, 5, 'AKTIF', NULL, NULL);

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
  `id_instansi_mahasiswa` int(10) UNSIGNED DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_mahasiswa`
--

INSERT INTO `m_mahasiswa` (`id_mahasiswa`, `nik`, `nim`, `nama_mahasiswa`, `jenis_kelamin`, `tgl_lahir`, `alamat`, `rt`, `rw`, `id_kelurahan`, `no_telp`, `id_instansi_mahasiswa`, `email`, `created_at`, `updated_at`, `deleted_at`) VALUES
(13, '3671020222040099', '10204230030', 'Danu Putra', 'L', '2004-06-01', 'JL RAYA PROF DR SOEPOMO', '01', '04', NULL, '081218501029', 4, 'abijaksana87@gmail.com', '2026-08-09 14:52:55', '2026-08-09 14:52:55', NULL),
(16, '3671020222040011', '1020423', 'Abi Dahlan', 'L', '2006-02-01', 'Jl. Prof Dr. Soepomo Raya No. 03', '01', '04', NULL, '081218501061', 12, 'abidahlan@gmail.com', '2026-08-09 16:17:04', '2026-08-09 16:17:04', NULL),
(17, '3671020222040002', '10204230033', 'Kusuma Wijaya', 'L', '2026-08-09', 'Jl. Prof Dr. Soepomo Raya No. 03', '01', '04', '1328', '081218501029', 13, 'Kusumawij@gmail.com', '2026-08-09 20:39:40', '2026-08-09 20:39:40', NULL);

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

--
-- Dumping data for table `m_opd`
--

INSERT INTO `m_opd` (`id_opd`, `opd`, `singkatan`, `alamat`, `no_telepon`, `email`, `website`, `status_aktif`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Dinas Komunikasi dan Informatika Kota Tangerang', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL),
(2, 'Dinas Pendidikan', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(3, 'Dinas Kepemudaan dan Olahraga', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(4, 'Dinas Kependudukan dan Pencatatan Sipil', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_prodi`
--

CREATE TABLE `m_prodi` (
  `id_prodi` int(11) UNSIGNED NOT NULL,
  `id_fakultas` int(10) UNSIGNED NOT NULL,
  `nama_prodi` varchar(150) NOT NULL,
  `jenjang` varchar(20) DEFAULT NULL,
  `status` enum('AKTIF','NONAKTIF') DEFAULT 'AKTIF',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_prodi`
--

INSERT INTO `m_prodi` (`id_prodi`, `id_fakultas`, `nama_prodi`, `jenjang`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(13, 10, 'Teknik Informatika', 'S1', 'AKTIF', '2026-08-07 04:57:28', NULL, NULL),
(14, 10, 'Sistem Informasi', 'S1', 'AKTIF', '2026-08-07 04:57:28', NULL, NULL),
(15, 11, 'Teknik Sipil', 'S1', 'AKTIF', '2026-08-07 04:57:28', NULL, NULL),
(16, 11, 'Teknik Mesin', 'S1', 'AKTIF', '2026-08-07 04:57:28', NULL, NULL);

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

--
-- Dumping data for table `m_provinsi`
--

INSERT INTO `m_provinsi` (`id_provinsi`, `kode_provinsi`, `nama_provinsi`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '36', 'BANTEN', '2026-08-07 04:57:28', NULL, NULL);

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

--
-- Dumping data for table `m_user_mahasiswa`
--

INSERT INTO `m_user_mahasiswa` (`id_user_mahasiswa`, `id_mahasiswa`, `username`, `password`, `status`, `last_login`, `created_at`, `updated_at`, `deleted_at`) VALUES
(12, 13, 'Danuputra', '$2y$10$77lJ9UOYeAlLNMyzVDYmQuJoH6w582unAL9NnAhXmd3XLVy1hjlFO', 'AKTIF', NULL, '2026-08-09 14:52:55', '2026-08-09 14:52:55', NULL),
(13, 16, 'Abidahlan', '$2y$10$AbLvSHQjzWasIQv2RKaNB.eHw3HQhCJy8AgKoQ8YSEVPUzjM8O.Tu', 'AKTIF', NULL, '2026-08-09 16:17:04', '2026-08-09 16:17:04', NULL),
(14, 17, 'Kusuma', '$2y$10$mQCcNouaAyvT9AgeDmDZFua6MW.y86QPygaegwONZyt/u7.F8s8TC', 'AKTIF', NULL, '2026-08-09 20:39:40', '2026-08-09 20:39:40', NULL);

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

--
-- Dumping data for table `t_file_permohonan_magang`
--

INSERT INTO `t_file_permohonan_magang` (`id_file_permohonan_magang`, `id_permohonan_magang`, `id_file_permohonan`, `nama_file`, `path_file`, `status_verifikasi`, `catatan_verifikasi`, `created_at`, `updated_at`) VALUES
(16, 7, 87, 'Backend_PBI_aing_Sprint_1.pdf', 'uploads/dokumen/1786262131_982084092f8aaa24fe3b.pdf', '', NULL, '2026-08-09 14:55:31', NULL),
(17, 7, 88, 'Kertas_Kerja_1_-_Kelompok_2_-_Day_3.pdf', 'uploads/dokumen/1786262131_895a6c763bb005ba2562.pdf', '', NULL, '2026-08-09 14:55:31', NULL),
(18, 7, 89, 'erd_update_ori.jpeg', 'uploads/dokumen/1786262131_9fbb4bae9aa41b9c6e7a.jpeg', '', NULL, '2026-08-09 14:55:31', NULL),
(26, 12, 93, 'Backend_PBI_aing_Sprint_1.pdf', 'uploads/dokumen/1786271690_17c1f90ff941a588124a.pdf', '', NULL, '2026-08-09 17:34:51', NULL),
(27, 12, 95, 'Backend_PBI_aing_Sprint_1.pdf', 'uploads/dokumen/1786271691_be6e7aa95a89ffc6aca1.pdf', '', NULL, '2026-08-09 17:34:51', NULL),
(28, 12, 94, 'erd_update_ori.jpeg', 'uploads/dokumen/1786271691_41a29eaf7dc2a57f92d4.jpeg', '', NULL, '2026-08-09 17:34:51', NULL);

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
  `id_mahasiswa` int(10) UNSIGNED DEFAULT NULL,
  `id_instansi_pendidikan` int(10) UNSIGNED NOT NULL,
  `id_fakultas` int(10) UNSIGNED DEFAULT NULL,
  `id_prodi` int(11) UNSIGNED DEFAULT NULL,
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

--
-- Dumping data for table `t_instansi_mahasiswa`
--

INSERT INTO `t_instansi_mahasiswa` (`id_instansi_mahasiswa`, `id_mahasiswa`, `id_instansi_pendidikan`, `id_fakultas`, `id_prodi`, `id_jenjang_pendidikan`, `jurusan`, `angkatan_tahun`, `semester`, `tahun_akademik`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 13, 7, 10, 13, 5, NULL, '2023', '4', '2025/2026', 'SYSTEM_REGISTRATION', NULL, NULL, NULL, NULL),
(12, 16, 16, NULL, NULL, 1, 'Multimedia', '', '12', NULL, 'SYSTEM_REGISTRATION', NULL, NULL, NULL, NULL),
(13, 17, 7, 10, 13, 5, NULL, '2023', '7', '2025/2026', 'SYSTEM_REGISTRATION', NULL, NULL, NULL, NULL);

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

--
-- Dumping data for table `t_log_permohonan`
--

INSERT INTO `t_log_permohonan` (`id_log`, `id_permohonan_magang`, `aktor`, `aksi`, `catatan`, `created_at`) VALUES
(15, 7, 'Mahasiswa', 'Mengajukan Permohonan', 'Permohonan baru diajukan dan menunggu verifikasi Sekretariat.', '2026-08-09 14:55:31'),
(16, 7, 'Sekretariat', 'Verifikasi & Disposisi', 'Berkas dinyatakan VALID dan didisposisikan ke Bidang Pengembangan E-Goverment', '2026-08-09 15:16:38'),
(21, 12, 'Mahasiswa', 'Menyimpan Draft Permohonan', 'Permohonan disimpan sebagai draf sementara.', '2026-08-09 17:34:51'),
(22, 12, 'Mahasiswa', 'Mengirim Permohonan', 'Draft permohonan telah dikirim dan menunggu verifikasi Sekretariat.', '2026-08-09 17:35:13'),
(23, 12, 'Sekretariat', 'Verifikasi Berkas Ditolak', 'Permohonan dikembalikan untuk perbaikan. Catatan: Gambar Kartu Pelajar Buram silahkan upload ulang', '2026-08-09 17:45:54'),
(24, 12, 'Mahasiswa', 'Mengirim Ulang Revisi Berkas', 'Mahasiswa telah memperbaiki berkas/data sesuai catatan Sekretariat.', '2026-08-09 17:46:53'),
(25, 12, 'Sekretariat', 'Verifikasi Berkas Ditolak', 'Permohonan dikembalikan untuk perbaikan. Catatan: Ada berkas yang tidak valid', '2026-08-09 17:47:57'),
(26, 12, 'Mahasiswa', 'Mengirim Ulang Revisi Berkas', 'Mahasiswa telah memperbaiki berkas/data sesuai catatan Sekretariat.', '2026-08-09 17:51:20'),
(27, 12, 'Sekretariat', 'Verifikasi & Disposisi', 'Berkas dinyatakan VALID dan didisposisikan ke Bidang Pengembangan E-Goverment', '2026-08-09 17:54:13'),
(28, 12, 'Kepala Bidang', 'Penempatan Disetujui', 'Mahasiswa telah disetujui dan berstatus AKTIF PRAKTIK KERJA LAPANGAN (PKL).', '2026-08-09 17:55:22');

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

--
-- Dumping data for table `t_penempatan_magang`
--

INSERT INTO `t_penempatan_magang` (`id_penempatan_magang`, `id_persetujuan_magang`, `id_mahasiswa`, `id_bidang`, `tanggal_mulai`, `tanggal_selesai`, `tanggal_persetujuan`, `status_penempatan`, `is_log_book`, `catatan`, `created_at`, `updated_at`) VALUES
(2, 8, 13, 5, '0000-00-00', '0000-00-00', NULL, 'MENUNGGU', 'YA', 'Disposisi dari Verifikasi', '2026-08-09 15:16:38', NULL),
(3, 9, 16, 5, '0000-00-00', '0000-00-00', NULL, 'BERJALAN', 'YA', '', '2026-08-09 17:54:13', '2026-08-09 17:55:22');

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

--
-- Dumping data for table `t_permohonan_magang`
--

INSERT INTO `t_permohonan_magang` (`id_permohonan_magang`, `id_mahasiswa`, `id_instansi_mahasiswa`, `id_jenis_permohonan`, `tujuan`, `deskripsi_keahlian`, `rencana_kegiatan`, `tgl_mulai`, `tgl_selesai`, `posting_data`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`) VALUES
(7, 13, 4, 3, '', 'Php, Html, Css', 'Pengembangan Aplikasi Website', '2026-09-08', '2026-11-09', 'kirim', '2026-08-09 14:55:31', NULL, NULL, NULL, NULL),
(12, 16, 12, 5, '', 'Php, Html, Css', 'Pengembangan Aplikasi Website', '2026-08-10', '2026-09-30', 'kirim', '2026-08-09 17:34:50', NULL, '2026-08-09 17:51:20', NULL, NULL);

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

--
-- Dumping data for table `t_persetujuan_magang`
--

INSERT INTO `t_persetujuan_magang` (`id_persetujuan_magang`, `id_permohonan_magang`, `id_bidang`, `catatan`, `status_persetujuan`, `disposisi`, `tanggal_disposisi`, `tanggal_persetujuan`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(8, 7, 5, 'Semua Berkas Valid', 'DISETUJUI', 'DIKIRIM', NULL, '2026-08-09 15:16:38', '2026-08-09 14:55:31', NULL, '2026-08-09 15:16:38', '1'),
(9, 12, 5, 'Semua berkas valid', 'DISETUJUI', 'DIKIRIM', NULL, '2026-08-09 17:54:13', '2026-08-09 17:35:13', NULL, '2026-08-09 17:54:13', '1');

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
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `group`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Superadmin', '1', '2026-07-28 02:34:55', NULL, NULL, NULL),
(2, 'Bidang Seketariat', '1', '2026-07-28 02:34:55', NULL, NULL, NULL),
(3, 'Bidang E-Gov', '1', '2026-07-28 02:34:55', NULL, NULL, NULL);

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
  ADD UNIQUE KEY `uk_kode_kabupaten` (`kode_kabupaten`),
  ADD KEY `idx_provinsi` (`id_provinsi`);

--
-- Indexes for table `m_kecamatan`
--
ALTER TABLE `m_kecamatan`
  ADD PRIMARY KEY (`id_kecamatan`),
  ADD UNIQUE KEY `uk_kecamatan` (`kode_kecamatan`),
  ADD KEY `idx_kabupaten` (`id_kabupaten`);

--
-- Indexes for table `m_kelurahan`
--
ALTER TABLE `m_kelurahan`
  ADD PRIMARY KEY (`id_kelurahan`),
  ADD UNIQUE KEY `uk_kelurahan` (`kode_kelurahan`),
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
  ADD KEY `idx_fakultas` (`id_fakultas`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `c_user_group`
--
ALTER TABLE `c_user_group`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `c_user_pegawai`
--
ALTER TABLE `c_user_pegawai`
  MODIFY `id_user_pegawai` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `m_bidang`
--
ALTER TABLE `m_bidang`
  MODIFY `id_bidang` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `m_fakultas`
--
ALTER TABLE `m_fakultas`
  MODIFY `id_fakultas` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `m_file`
--
ALTER TABLE `m_file`
  MODIFY `id_file` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `m_file_permohonan`
--
ALTER TABLE `m_file_permohonan`
  MODIFY `id_file_permohonan` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `m_instansi_pendidikan`
--
ALTER TABLE `m_instansi_pendidikan`
  MODIFY `id_instansi_pendidikan` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `m_jenis_permohonan`
--
ALTER TABLE `m_jenis_permohonan`
  MODIFY `id_jenis_permohonan` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `m_jenjang_pendidikan`
--
ALTER TABLE `m_jenjang_pendidikan`
  MODIFY `id_jenjang_pendidikan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `m_kabupaten`
--
ALTER TABLE `m_kabupaten`
  MODIFY `id_kabupaten` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `m_kecamatan`
--
ALTER TABLE `m_kecamatan`
  MODIFY `id_kecamatan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT for table `m_kelurahan`
--
ALTER TABLE `m_kelurahan`
  MODIFY `id_kelurahan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1502;

--
-- AUTO_INCREMENT for table `m_kuota`
--
ALTER TABLE `m_kuota`
  MODIFY `id_kuota` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `m_mahasiswa`
--
ALTER TABLE `m_mahasiswa`
  MODIFY `id_mahasiswa` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `m_opd`
--
ALTER TABLE `m_opd`
  MODIFY `id_opd` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `m_prodi`
--
ALTER TABLE `m_prodi`
  MODIFY `id_prodi` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `m_provinsi`
--
ALTER TABLE `m_provinsi`
  MODIFY `id_provinsi` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `m_user_mahasiswa`
--
ALTER TABLE `m_user_mahasiswa`
  MODIFY `id_user_mahasiswa` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `t_file_permohonan_magang`
--
ALTER TABLE `t_file_permohonan_magang`
  MODIFY `id_file_permohonan_magang` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `t_file_proses_magang`
--
ALTER TABLE `t_file_proses_magang`
  MODIFY `id_file_proses_magang` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_instansi_mahasiswa`
--
ALTER TABLE `t_instansi_mahasiswa`
  MODIFY `id_instansi_mahasiswa` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `t_logbook_magang`
--
ALTER TABLE `t_logbook_magang`
  MODIFY `id_logbook_magang` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t_log_permohonan`
--
ALTER TABLE `t_log_permohonan`
  MODIFY `id_log` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `t_notifikasi`
--
ALTER TABLE `t_notifikasi`
  MODIFY `id_notifikasi` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_penempatan_magang`
--
ALTER TABLE `t_penempatan_magang`
  MODIFY `id_penempatan_magang` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t_permohonan_magang`
--
ALTER TABLE `t_permohonan_magang`
  MODIFY `id_permohonan_magang` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `t_persetujuan_magang`
--
ALTER TABLE `t_persetujuan_magang`
  MODIFY `id_persetujuan_magang` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  ADD CONSTRAINT `m_prodi_id_fakultas_foreign` FOREIGN KEY (`id_fakultas`) REFERENCES `m_fakultas` (`id_fakultas`) ON DELETE CASCADE ON UPDATE CASCADE;

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
