-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 30, 2024 at 07:23 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `karib`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_11_16_113623_tambah_tabel_penialaian', 2),
(6, '2024_11_16_115254_tambah_tabel_pegawais', 2),
(7, '2024_11_17_031225_ganti_kolom_email_jadi_usernae', 3),
(8, '2024_11_17_032643_ganti_kolom_lagi', 4),
(9, '2024_11_17_032939_ganti_kolom_lagi_2', 5),
(11, '2024_11_17_082257_tambah_tabel_ruangan', 6),
(12, '2024_11_17_082120_tambah_tabel_penilaian_ruangan', 7),
(13, '2024_11_17_132756_rename_kolom', 8),
(14, '2024_11_17_144452_delete_column', 9);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pegawais`
--

CREATE TABLE `pegawais` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruangan` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pegawais`
--

INSERT INTO `pegawais` (`id`, `nama`, `ruangan`, `flag`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2', 'Dihapus', '2024-12-15 22:09:59', '2024-12-16 00:24:05'),
(3, 'Rustim, SE', '3', NULL, '2024-12-15 22:09:59', '2024-12-15 22:09:59'),
(4, 'Roni Rahmadi, SP', '3', NULL, '2024-12-15 22:09:59', '2024-12-15 22:09:59'),
(5, 'Zainal Amin, S.Si', '3', NULL, '2024-12-15 22:09:59', '2024-12-15 22:09:59'),
(6, 'Edhi Prabowo, SST', '1', NULL, '2024-12-15 22:09:59', '2024-12-15 22:09:59'),
(7, 'Widya Khairani, SST', '1', NULL, '2024-12-15 22:09:59', '2024-12-15 22:09:59'),
(8, 'Aulia Rachman, S.Stat.', '3', NULL, '2024-12-15 22:09:59', '2024-12-15 22:09:59'),
(9, 'Thariana Ayu Islami, S.Tr.Stat.', '5', NULL, '2024-12-15 22:09:59', '2024-12-15 22:09:59'),
(10, 'Alfredo Abdul Aziz, S.Tr.Stat.', '2', NULL, '2024-12-15 22:09:59', '2024-12-15 22:09:59'),
(11, 'Fajar Akhmad Anshori, S.Tr.Stat.', '1', NULL, '2024-12-15 22:09:59', '2024-12-15 22:09:59'),
(12, 'Salsabila Latifah Putri, S.Tr.Stat.', '3', NULL, '2024-12-15 22:09:59', '2024-12-15 22:09:59'),
(13, 'Jarlian', '4', NULL, '2024-12-15 22:09:59', '2024-12-15 22:09:59'),
(14, 'M. Rizal Zalmi', '4', NULL, '2024-12-15 22:09:59', '2024-12-15 22:09:59'),
(15, 'Djamaluddin', '4', NULL, '2024-12-15 22:09:59', '2024-12-15 22:09:59'),
(16, 'Zuhdi Ali Hisyam, S.Tr.Stat.', '2', NULL, '2024-12-15 22:09:59', '2024-12-15 22:09:59'),
(17, 'Roni Lahanta', '4', NULL, '2024-12-15 22:09:59', '2024-12-15 22:09:59'),
(18, 'Hendra Prabisma', '4', NULL, '2024-12-15 22:09:59', '2024-12-15 22:09:59'),
(19, 'Aidil Fajri, SST', '1', NULL, '2024-12-15 22:09:59', '2024-12-15 22:09:59'),
(20, 'Subarno', '4', NULL, '2024-12-15 22:09:59', '2024-12-15 22:09:59'),
(21, 'Dummy', '2', 'Dihapus', '2024-12-19 04:37:35', '2024-12-19 20:13:42'),
(22, 'Dummy 2', '2', 'Dihapus', '2024-12-19 04:39:20', '2024-12-19 20:20:38');

-- --------------------------------------------------------

--
-- Table structure for table `penilaians`
--

CREATE TABLE `penilaians` (
  `id` bigint UNSIGNED NOT NULL,
  `penilai` tinyint NOT NULL,
  `pegawai_id` tinyint NOT NULL,
  `tanggal_penilaian` date NOT NULL DEFAULT '2024-11-16',
  `kebersihan` tinyint NOT NULL,
  `keindahan` tinyint NOT NULL,
  `kerapian` tinyint NOT NULL,
  `penampilan` tinyint NOT NULL DEFAULT '0',
  `total_nilai` tinyint NOT NULL,
  `tanggal_awal_mingguan` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penilaians`
--

INSERT INTO `penilaians` (`id`, `penilai`, `pegawai_id`, `tanggal_penilaian`, `kebersihan`, `keindahan`, `kerapian`, `penampilan`, `total_nilai`, `tanggal_awal_mingguan`, `created_at`, `updated_at`) VALUES
(467, 3, 16, '2024-12-30', 10, 10, 10, 0, 30, '2024-12-30', '2024-12-29 19:08:35', '2024-12-29 19:08:58'),
(468, 3, 16, '2024-12-30', 10, 10, 10, 0, 30, '2024-12-30', '2024-12-29 19:08:42', '2024-12-29 19:09:05'),
(469, 3, 16, '2024-12-30', 5, 5, 5, 0, 15, '2024-12-30', '2024-12-29 20:22:39', '2024-12-29 20:22:39'),
(470, 7, 16, '2024-12-30', 5, 5, 5, 0, 15, '2024-12-30', '2024-12-29 20:24:00', '2024-12-29 20:24:00'),
(471, 7, 16, '2024-12-30', 5, 5, 5, 0, 15, '2024-12-30', '2024-12-29 20:24:10', '2024-12-29 20:24:10'),
(472, 7, 16, '2024-12-30', 5, 5, 5, 0, 15, '2024-12-30', '2024-12-29 20:24:19', '2024-12-29 20:24:19'),
(473, 3, 19, '2024-12-30', 5, 5, 5, 0, 15, '2024-12-30', '2024-12-30 00:21:53', '2024-12-30 00:21:53');

-- --------------------------------------------------------

--
-- Table structure for table `penilaian_ruangans`
--

CREATE TABLE `penilaian_ruangans` (
  `id` bigint UNSIGNED NOT NULL,
  `penilai` tinyint NOT NULL,
  `ruangan_id` tinyint NOT NULL,
  `tanggal_penilaian` date NOT NULL,
  `kebersihan` tinyint NOT NULL,
  `keindahan` tinyint NOT NULL,
  `kerapian` tinyint NOT NULL,
  `total_nilai` tinyint NOT NULL,
  `tanggal_awal_mingguan` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penilaian_ruangans`
--

INSERT INTO `penilaian_ruangans` (`id`, `penilai`, `ruangan_id`, `tanggal_penilaian`, `kebersihan`, `keindahan`, `kerapian`, `total_nilai`, `tanggal_awal_mingguan`, `created_at`, `updated_at`) VALUES
(77, 3, 1, '2024-12-30', 5, 5, 5, 15, '2024-12-30', '2024-12-30 00:22:29', '2024-12-30 00:22:29'),
(78, 3, 2, '2024-12-30', 5, 5, 5, 15, '2024-12-30', '2024-12-30 00:22:49', '2024-12-30 00:22:49');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ruangans`
--

CREATE TABLE `ruangans` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ruangans`
--

INSERT INTO `ruangans` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'Ruang Umum', NULL, NULL),
(2, 'Ruang IPDS', NULL, NULL),
(3, 'Ruang Kasi', NULL, NULL),
(4, 'Ruang KSK', NULL, NULL),
(5, 'Ruang PST', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(0, 'Budi Kurniawan', 'kepala_bps', 'Admin', NULL, '$2y$10$F2wDY9LiXhzm9o5qbZQIeu.aUv/hvVWYxj0EfcloUYAxTtn57CYZe', NULL, '2024-11-17 19:38:12', '2024-11-17 19:38:12'),
(1, 'Admin', 'admin', 'Admin', NULL, '$2y$10$.l5j1Jt58kq4oSJAjyxAT.4R1dfIdTpIO3d02gzb1vJFDnqgNgyQK', NULL, '2024-11-16 03:55:48', '2024-11-18 20:03:29'),
(2, 'Dummy', 'Dummy', 'Penilai', NULL, '$2y$10$F2wDY9LiXhzm9o5qbZQIeu.aUv/hvVWYxj0EfcloUYAxTtn57CYZe', NULL, NULL, NULL),
(3, 'Aan', 'Aan', 'Penilai', NULL, '$2y$10$hsqTwNW3lqr/KRP13QXgFe2yXqFmAcva7VY95Q1iMKPWHtLKF9w0q', NULL, '2024-11-16 06:33:47', '2024-11-16 23:11:46'),
(4, 'Eri Alfanta', 'Eri', 'Penilai', NULL, '$2y$10$7vXByhG4r5emr10FVKDIo.jP1yT/VcP0lAO84uY8Al/.UdGEpeNgy', NULL, '2024-11-16 06:35:19', '2024-11-16 23:17:50'),
(5, 'Junansah', 'Ajun', 'Penilai', NULL, '$2y$10$jL1ikW.2xkKxTUcG6.bXM.bM7W9WzgN/DqfChjI4pL287IEwZQkE2', NULL, '2024-11-16 06:36:26', '2024-11-16 23:18:36'),
(6, 'Rahmad', 'Rahmad', 'Penilai', NULL, '$2y$10$epwuHN9mEWXKLdlK9JMtA.tq/LF2.cyNtPk4b3i9ayKwaoTgpn9Wq', NULL, '2024-11-16 06:37:28', '2024-11-16 23:18:13'),
(7, 'Bony', 'bony', 'Penilai', NULL, '$2y$10$9MACmWdn9KOIV.V.jNI9Ie9o0jiFPsSasqliPGbsbb3QL/RIvZl7W', NULL, '2024-11-16 06:38:49', '2024-11-16 23:18:23'),
(9, 'Zuhdi Ali Hisyam', 'zuhdi', 'Admin', NULL, '$2y$12$MdM3/AyF3f3b/yzhBW5OOO/Ex5gD/N/8PL3io.OuaP/8ulrDD5zeq', NULL, '2024-11-16 20:17:59', '2024-11-16 20:17:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pegawais`
--
ALTER TABLE `pegawais`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penilaians`
--
ALTER TABLE `penilaians`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penilaian_ruangans`
--
ALTER TABLE `penilaian_ruangans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `ruangans`
--
ALTER TABLE `ruangans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pegawais`
--
ALTER TABLE `pegawais`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `penilaians`
--
ALTER TABLE `penilaians`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=474;

--
-- AUTO_INCREMENT for table `penilaian_ruangans`
--
ALTER TABLE `penilaian_ruangans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ruangans`
--
ALTER TABLE `ruangans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
