/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE IF NOT EXISTS `izin` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `izin`;

CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('laravel-cache-tessiswa@smk13|127.0.0.1', 'i:1;', 1761186007),
	('laravel-cache-tessiswa@smk13|127.0.0.1:timer', 'i:1761186007;', 1761186007),
	('laravel-cache-tessiswa@smkn1|127.0.0.1', 'i:1;', 1758850183),
	('laravel-cache-tessiswa@smkn1|127.0.0.1:timer', 'i:1758850183;', 1758850183);

CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2024_01_01_000000_create_schools_table', 1),
	(2, '2024_01_01_000001_create_users_table', 1),
	(3, '2024_01_01_000002_create_students_table', 1),
	(4, '2024_01_01_000003_create_permission_requests_table', 1),
	(5, '2024_01_01_000004_create_cache_table', 1),
	(6, '2024_01_01_000005_create_qr_izin_table', 1),
	(7, '2024_01_01_000006_create_log_perizinan_table', 1),
	(8, '2024_01_01_000007_create_peringatan_table', 1),
	(9, '2024_01_01_000008_create_notifikasi_table', 1),
	(10, '2025_09_24_104045_add_remember_token_to_users_table', 2),
	(12, '2025_10_02_000001_update_permissions_add_guru_columns', 3),
	(13, '2025_10_02_000002_update_users_add_guru_role', 4),
	(14, '2025_10_02_999999_full_guru_permissions_fix', 5);

CREATE TABLE IF NOT EXISTS `notifications` (
  `notification_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `channel` enum('in_app','push') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'in_app',
  `status` enum('unread','read') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`notification_id`),
  KEY `idx_notifications_user` (`user_id`),
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=188 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `notifications` (`notification_id`, `user_id`, `title`, `message`, `channel`, `status`, `created_at`) VALUES
	(1, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-09-04 02:44:03'),
	(5, 1, 'Perizinan Baru', 'Ada perizinan baru yang menunggu persetujuan Anda.', 'in_app', 'read', '2025-09-04 02:44:04'),
	(6, 1, 'Izin Baru Diajukan', 'tes siswa mengajukan izin baru.', 'in_app', 'read', '2025-09-25 00:03:16'),
	(7, 9, 'Perizinan Ditolak', 'Perizinan Anda telah ditolak oleh admin.', 'in_app', 'read', '2025-09-25 00:23:12'),
	(8, 1, 'Izin Baru Diajukan', 'tes siswa 1 mengajukan izin baru.', 'in_app', 'read', '2025-09-26 01:44:33'),
	(10, 9, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-09-26 01:45:54'),
	(11, 1, 'Izin Baru Diajukan', 'tes siswa 1 mengajukan izin baru.', 'in_app', 'read', '2025-09-30 00:40:35'),
	(13, 9, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-09-30 00:40:52'),
	(14, 1, 'Izin Baru Diajukan', 'tes siswa 1 mengajukan izin baru.', 'in_app', 'read', '2025-10-01 00:57:58'),
	(16, 9, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-01 00:58:36'),
	(17, 1, 'Izin Baru Diajukan', 'tes siswa 1 mengajukan izin baru.', 'in_app', 'read', '2025-10-01 01:03:34'),
	(19, 9, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-01 01:04:00'),
	(20, 1, 'Izin Baru Diajukan', 'tes siswa 1 mengajukan izin baru.', 'in_app', 'read', '2025-10-01 01:51:37'),
	(22, 1, 'Izin Baru Diajukan', 'tes siswa 1 mengajukan izin baru.', 'in_app', 'read', '2025-10-01 02:02:57'),
	(24, 1, 'Izin Baru Diajukan', 'tes siswa 1 mengajukan izin baru.', 'in_app', 'read', '2025-10-01 02:13:51'),
	(26, 9, 'Perizinan Ditolak', 'Perizinan Anda telah ditolak oleh admin.', 'in_app', 'read', '2025-10-01 02:15:01'),
	(27, 9, 'Perizinan Ditolak', 'Perizinan Anda telah ditolak oleh admin.', 'in_app', 'read', '2025-10-01 02:15:07'),
	(28, 9, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-01 02:15:21'),
	(29, 1, 'Izin Baru Diajukan', 'tes siswa 1 mengajukan izin baru.', 'in_app', 'read', '2025-10-01 02:35:54'),
	(31, 9, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-01 02:37:26'),
	(32, 1, 'Izin Baru Diajukan', 'tes siswa 1 mengajukan izin baru.', 'in_app', 'read', '2025-10-02 02:39:03'),
	(34, 1, 'Izin Baru Diajukan', 'tes siswa 1 mengajukan izin baru.', 'in_app', 'read', '2025-10-02 02:49:49'),
	(36, 9, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-02 02:50:18'),
	(37, 9, 'Perizinan Ditolak', 'Perizinan Anda telah ditolak oleh admin.', 'in_app', 'read', '2025-10-02 02:50:28'),
	(38, 1, 'Izin Baru Diajukan', 'tes siswa 1 mengajukan izin baru.', 'in_app', 'read', '2025-10-02 02:50:44'),
	(40, 1, 'Izin Baru Diajukan', 'tes siswa 1 mengajukan izin baru.', 'in_app', 'read', '2025-10-02 02:59:29'),
	(42, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-10-13 02:47:19'),
	(44, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-13 03:08:42'),
	(45, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-10-13 03:21:02'),
	(47, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-13 03:21:20'),
	(48, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-10-22 13:26:22'),
	(50, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-22 13:28:23'),
	(51, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-10-22 13:30:16'),
	(53, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-22 13:31:27'),
	(54, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-10-22 13:32:59'),
	(56, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-22 13:34:16'),
	(57, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-10-23 02:12:11'),
	(59, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-23 02:13:54'),
	(60, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-10-23 02:17:35'),
	(62, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-23 02:18:12'),
	(63, 1, 'Izin Baru Diajukan', 'tes siswa 1 mengajukan izin baru.', 'in_app', 'read', '2025-10-23 02:24:22'),
	(65, 9, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-23 02:25:50'),
	(66, 1, 'Izin Baru Diajukan', 'tes siswa 1 mengajukan izin baru.', 'in_app', 'read', '2025-10-23 02:34:44'),
	(68, 1, 'Izin Baru Diajukan', 'tes siswa 1 mengajukan izin baru.', 'in_app', 'read', '2025-10-23 02:38:52'),
	(70, 9, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-23 02:39:42'),
	(71, 1, 'Izin Baru Diajukan', 'tes siswa 1 mengajukan izin baru.', 'in_app', 'read', '2025-10-23 02:41:26'),
	(73, 9, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-23 02:42:20'),
	(74, 1, 'Izin Baru Diajukan', 'tes siswa 1 mengajukan izin baru.', 'in_app', 'read', '2025-10-23 02:45:44'),
	(76, 9, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-23 02:46:28'),
	(77, 1, 'Izin Baru Diajukan', 'tes siswa 1 mengajukan izin baru.', 'in_app', 'read', '2025-10-23 02:50:10'),
	(79, 9, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-23 02:50:50'),
	(80, 1, 'Izin Baru Diajukan', 'tes siswa 1 mengajukan izin baru.', 'in_app', 'read', '2025-10-23 02:53:40'),
	(82, 9, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-23 02:54:30'),
	(83, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-10-23 02:57:03'),
	(85, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-23 02:58:05'),
	(86, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-10-23 03:02:43'),
	(88, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-23 03:03:52'),
	(89, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-10-23 03:05:16'),
	(91, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-23 03:06:09'),
	(92, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-10-23 03:08:50'),
	(94, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-23 03:11:27'),
	(95, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-10-23 03:14:11'),
	(97, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-23 03:14:53'),
	(98, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-10-23 03:19:23'),
	(100, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-23 03:20:13'),
	(101, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-10-23 03:31:27'),
	(103, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-23 03:32:23'),
	(104, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-10-23 03:34:47'),
	(106, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-23 03:35:25'),
	(107, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-10-23 03:37:12'),
	(109, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-23 03:38:00'),
	(110, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-10-23 03:58:33'),
	(112, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-23 03:59:39'),
	(113, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-10-23 04:03:44'),
	(115, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-23 04:04:35'),
	(116, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-10-23 04:22:04'),
	(118, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-23 04:23:12'),
	(119, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-10-23 04:32:10'),
	(121, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-23 04:33:04'),
	(122, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-10-23 04:40:59'),
	(124, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-23 04:41:58'),
	(125, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-10-23 05:04:16'),
	(127, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-10-23 05:04:57'),
	(128, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-11-25 07:00:46'),
	(130, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-11-25 07:01:15'),
	(131, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-11-25 07:04:18'),
	(133, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-11-25 07:16:09'),
	(134, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-11-25 07:16:50'),
	(136, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-11-25 07:21:07'),
	(137, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-11-25 07:22:47'),
	(139, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-11-25 07:23:10'),
	(140, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-11-25 07:24:25'),
	(142, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-11-25 09:06:04'),
	(143, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-11-26 01:54:07'),
	(145, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-11-26 02:00:11'),
	(147, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-11-26 02:02:51'),
	(149, 11, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-11-26 02:02:51'),
	(150, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-11-26 02:04:26'),
	(151, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-11-26 03:13:34'),
	(153, 11, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-11-26 03:13:34'),
	(154, 2, 'Perizinan Ditolak', 'Perizinan Anda telah ditolak oleh admin.', 'in_app', 'read', '2025-11-26 03:14:14'),
	(155, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-11-26 03:15:52'),
	(157, 11, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-11-26 03:15:52'),
	(158, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'unread', '2025-11-26 03:33:37'),
	(159, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-11-26 03:34:39'),
	(161, 11, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'unread', '2025-11-26 03:34:39'),
	(162, 2, 'Perizinan Ditolak', 'Perizinan Anda telah ditolak oleh admin.', 'in_app', 'unread', '2025-11-26 03:43:16'),
	(163, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-11-26 04:17:36'),
	(165, 11, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'unread', '2025-11-26 04:17:36'),
	(166, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'unread', '2025-11-26 04:19:51'),
	(167, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-11-27 02:54:24'),
	(168, 11, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'unread', '2025-11-27 02:54:24'),
	(169, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'unread', '2025-11-27 02:54:42'),
	(170, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-11-27 02:56:20'),
	(171, 11, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'unread', '2025-11-27 02:56:20'),
	(172, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'unread', '2025-11-27 02:57:34'),
	(173, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-11-27 03:24:49'),
	(174, 11, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'unread', '2025-11-27 03:24:49'),
	(175, 2, 'Perizinan Ditolak', 'Perizinan Anda telah ditolak oleh admin.', 'in_app', 'unread', '2025-11-27 03:45:27'),
	(176, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-11-27 03:45:34'),
	(177, 11, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'unread', '2025-11-27 03:45:34'),
	(178, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'unread', '2025-11-27 03:46:37'),
	(179, 1, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'read', '2025-11-27 03:50:22'),
	(180, 11, 'Izin Baru Diajukan', 'Udin mengajukan izin baru.', 'in_app', 'unread', '2025-11-27 03:50:22'),
	(181, 2, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'unread', '2025-11-27 04:04:46'),
	(182, 1, 'Izin Baru Diajukan', 'asep mengajukan izin baru.', 'in_app', 'read', '2025-11-27 04:12:36'),
	(183, 11, 'Izin Baru Diajukan', 'asep mengajukan izin baru.', 'in_app', 'unread', '2025-11-27 04:12:36'),
	(184, 8, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'unread', '2025-11-27 04:21:35'),
	(185, 1, 'Izin Baru Diajukan', 'tes siswa 1 mengajukan izin baru.', 'in_app', 'read', '2025-11-27 04:36:06'),
	(186, 11, 'Izin Baru Diajukan', 'tes siswa 1 mengajukan izin baru.', 'in_app', 'unread', '2025-11-27 04:36:06'),
	(187, 9, 'Perizinan Disetujui', 'Perizinan Anda telah disetujui oleh admin.', 'in_app', 'read', '2025-11-27 04:37:39');

CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `permissions` (
  `permission_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `school_id` bigint unsigned NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `evidence_path` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_start` datetime NOT NULL,
  `time_end` datetime DEFAULT NULL,
  `type` enum('temporary','leave') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'temporary',
  `status` enum('waiting_guru','submitted','approved','rejected','expired') COLLATE utf8mb4_unicode_ci DEFAULT 'waiting_guru',
  `guru_id` bigint unsigned DEFAULT NULL,
  `guru_approved_at` timestamp NULL DEFAULT NULL,
  `admin_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`permission_id`),
  KEY `permissions_admin_id_foreign` (`admin_id`),
  KEY `idx_permissions_student` (`student_id`),
  KEY `idx_permissions_school` (`school_id`),
  CONSTRAINT `permissions_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  CONSTRAINT `permissions_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`school_id`),
  CONSTRAINT `permissions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `permissions` (`permission_id`, `student_id`, `school_id`, `reason`, `evidence_path`, `time_start`, `time_end`, `type`, `status`, `guru_id`, `guru_approved_at`, `admin_id`, `created_at`, `updated_at`) VALUES
	(12, 1, 1, 'lomba kicau mania', 'evidence/1757559751_info kicau mania.jpg', '2025-09-11 12:01:00', '2025-09-11 14:01:00', 'temporary', 'rejected', NULL, NULL, 1, '2025-09-11 03:02:31', '2025-09-11 03:26:44'),
	(14, 1, 1, 'tes perizinan', 'evidence/1757564105_WhatsApp Image 2025-07-17 at 10.42.39_673289b1.jpg', '2025-09-11 12:14:00', '2025-09-11 13:14:00', 'temporary', 'approved', NULL, NULL, 1, '2025-09-11 04:15:05', '2025-09-11 04:15:42'),
	(15, 2, 1, 'tes beda akun', 'evidence/1757982731_518979989_1229059462292355_2508092962487943501_n.jpg', '2025-09-16 08:30:00', '2025-09-16 10:30:00', 'temporary', 'approved', NULL, NULL, 1, '2025-09-16 00:32:11', '2025-09-16 00:33:34'),
	(16, 7, 1, 'test', 'evidence/1757985482_531834872_1314662796692722_6195784388268165788_n.jpg', '2025-09-16 09:17:00', '2025-09-16 11:17:00', 'temporary', 'approved', NULL, NULL, 1, '2025-09-16 01:18:02', '2025-09-16 01:18:43'),
	(18, 1, 1, 'tes demo', 'evidence/1758507318_info kicau mania.jpg', '2025-09-22 10:13:00', '2025-09-23 09:14:00', 'temporary', 'approved', NULL, NULL, 1, '2025-09-22 02:15:18', '2025-09-22 02:17:19'),
	(19, 7, 1, 'tes ke sekian kalinya', 'evidence/1758722611_79b227699d3ef76526addecba644033e.jpg', '2025-09-24 22:59:00', '2025-09-25 20:59:00', 'temporary', 'approved', NULL, NULL, 1, '2025-09-24 14:03:31', '2025-09-24 23:49:36'),
	(20, 7, 1, 'tes notifikasi', 'evidence/1758758596_G0pVidFbIAARX5d.jpg', '2025-09-25 08:02:00', '2025-09-25 09:02:00', 'temporary', 'rejected', NULL, NULL, 1, '2025-09-25 00:03:16', '2025-09-25 00:23:12'),
	(22, 7, 1, 'tes bahan presentasi', 'evidence/1759192834_518979989_1229059462292355_2508092962487943501_n.jpg', '2025-09-30 08:39:00', '2025-09-30 10:39:00', 'temporary', 'approved', NULL, NULL, 1, '2025-09-30 00:40:35', '2025-09-30 00:40:52'),
	(61, 1, 1, 'keperluan keluarga', 'evidence/1761195856_Screenshot 2025-10-22 200802.png', '2025-10-23 12:03:00', '2025-10-23 20:00:00', 'temporary', 'approved', NULL, NULL, 1, '2025-10-23 05:04:16', '2025-10-23 05:04:57'),
	(62, 1, 1, 'mobil roti', 'evidence/1764054046_584803866_122150514896713255_3126138471494047965_n.jpg', '2025-11-25 13:58:00', '2025-11-25 20:00:00', 'temporary', 'approved', NULL, NULL, 1, '2025-11-25 07:00:46', '2025-11-25 07:01:15'),
	(67, 1, 1, 'loupan', 'evidence/1764122045_584423465_1163191432585359_6193626963750151203_n.jpg', '2025-11-26 08:53:00', '2025-11-26 20:00:00', 'temporary', 'approved', NULL, NULL, 1, '2025-11-26 01:54:06', '2025-11-26 02:04:26'),
	(78, 1, 1, 'tes overall aplikasi sebelum dikumpul', 'evidence/1764215422_Screenshot 2025-10-22 200802.png', '2025-11-27 10:46:00', '2025-11-27 20:00:00', 'temporary', 'approved', 11, '2025-11-27 04:04:08', 1, '2025-11-27 03:50:22', '2025-11-27 04:04:46'),
	(79, 6, 1, 'tes beda kelas lagi dikarenakan error', 'evidence/1764216756_cmstrat.png', '2025-11-27 11:10:00', '2025-11-27 15:12:00', 'temporary', 'approved', 11, '2025-11-27 04:20:36', 1, '2025-11-27 04:12:36', '2025-11-27 04:21:35'),
	(80, 7, 1, 'loupan 2 (tes lagi)', 'evidence/1764218166_loupan.jpg', '2025-11-27 11:34:00', '2025-11-27 12:24:00', 'temporary', 'approved', NULL, NULL, 1, '2025-11-27 04:36:06', '2025-11-27 05:22:43');

CREATE TABLE IF NOT EXISTS `permission_logs` (
  `log_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` bigint unsigned NOT NULL,
  `actor_id` bigint unsigned NOT NULL,
  `action` enum('submitted','approved','rejected','expired','scanned','qr_generated') COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`),
  KEY `permission_logs_actor_id_foreign` (`actor_id`),
  KEY `idx_permission_logs` (`permission_id`),
  CONSTRAINT `permission_logs_actor_id_foreign` FOREIGN KEY (`actor_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `permission_logs_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`permission_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `qr_passes` (
  `qr_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` bigint unsigned NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','used','expired') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `generated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expires_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`qr_id`),
  UNIQUE KEY `qr_passes_permission_id_unique` (`permission_id`),
  UNIQUE KEY `qr_passes_token_unique` (`token`),
  CONSTRAINT `qr_passes_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`permission_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `schools` (
  `school_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unique_code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`school_id`),
  UNIQUE KEY `schools_unique_code_unique` (`unique_code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `schools` (`school_id`, `name`, `unique_code`, `address`, `created_at`) VALUES
	(1, 'SMKN 13 Bandung', 'SMKN13BDG', 'Jl. Soekarno Hatta KM 10, Bandung, Jawa Barat', '2025-09-04 02:43:59');

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('grr0VnKrqN6bTgtyYrQszUnZpLYW6r7iYZPLOUyT', 11, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:145.0) Gecko/20100101 Firefox/145.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVUJwaUFUZHVoWTEzZlpZUWw1dGp6MENvenJtWXJTYzJSSjc4aGhIZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ndXJ1L3Blcm1pc3Npb25zLzc5Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTE7fQ==', 1764217245),
	('PxND84bYXsXzShpjwZGSjVZJt1TTa3HHQVKpDKVK', 9, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiODVaWWMxVnVFcGZaQzJKZ2VEaUt1NXBaRHIyNWlxTkdOOWJTVHN2SiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdHVkZW50L2Rhc2hib2FyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjk7fQ==', 1764220970),
	('T6bfndDRyYhKs6vAXETEIUvFioUX3EHgxkawaHgh', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:145.0) Gecko/20100101 Firefox/145.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibHRqRGlVanlGTXA5UEtSVUpVekFWNmJUTlEyVExoblhyOVgydTJobiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9wZXJtaXNzaW9ucy8xMiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1764220879);

CREATE TABLE IF NOT EXISTS `students` (
  `student_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `class_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `student_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `students_user_id_unique` (`user_id`),
  CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `students` (`student_id`, `user_id`, `class_name`, `student_number`, `created_at`) VALUES
	(1, 2, 'XII-RPL2', '01', '2025-09-04 02:44:02'),
	(2, 3, 'XII-RPL1', '15', '2025-09-04 02:44:02'),
	(6, 8, 'Tes Kelas', '05', '2025-09-16 00:54:24'),
	(7, 9, 'X RPL 2', '1312', '2025-09-16 01:07:39');

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin_bk','guru','student') COLLATE utf8mb4_unicode_ci NOT NULL,
  `school_id` bigint unsigned NOT NULL,
  `status` enum('active','banned','pending') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `idx_users_school` (`school_id`),
  CONSTRAINT `users_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`school_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`user_id`, `email`, `password_hash`, `name`, `phone`, `role`, `school_id`, `status`, `created_at`, `updated_at`, `remember_token`) VALUES
	(1, 'admin@smkn13', '$2y$12$WIdwFjDS1.z25WU6WXiKne2Y5UpYG0kPDMQ2vgF0Hgn88Gza.pp/G', 'Agus Admin', '081234567890', 'admin_bk', 1, 'active', '2025-09-03 19:44:00', '2025-11-27 05:00:40', 'dTzqO10iwbI72OSXZqUHEhhh56ZaS9behJPl2fP3Itrgw12TzC2SLMLcMSR2'),
	(2, 'udin@smkn13', '$2y$12$0qBCD04eSV6yZWSG5maPk.LL7yGWPRZMObsvO8jnjKAH3tw8svOVi', 'Udin', '081234567891', 'student', 1, 'active', '2025-09-03 19:44:02', '2025-11-27 04:05:28', '6BmIKrZi0wrnc7MIC9YaATajIeTvPJWBmU7GhEvGmbageazq7KCuurALU7nZ'),
	(3, 'agus@smkn13', '$2y$12$ERhauc1SjlzPMYwboOXxfOFpr5XeyUhw6nLoknPG4axOveeinS.V.', 'Agus', '081234567892', 'student', 1, 'banned', '2025-09-03 19:44:02', '2025-11-27 02:18:03', NULL),
	(8, 'asep@smkn13', '$2y$12$RwN4606osXjxQhZC2gB1guQUYbpgB4ai02veEXEHwlR6tUDxWvPYi', 'asep', '0812312231', 'student', 1, 'active', '2025-09-16 00:54:24', '2025-11-27 02:14:35', NULL),
	(9, 'tessiswa@smkn13', '$2y$12$VxnHIbg4j62iX1QDTc81xuubsKoCdUITdYkNSeOREnzammHhmRWF2', 'tes siswa 1', '0812312234', 'student', 1, 'active', '2025-09-16 01:07:39', '2025-11-27 02:14:21', NULL),
	(11, 'guru@smkn13', '$2y$12$5Fm6Us8NT29s5Ur.THiGrO/mNBN/GHsau1XfReTfRbevKYL//Qp5y', 'Guru', '08123122645', 'guru', 1, 'active', '2025-10-02 02:37:25', '2025-11-27 02:17:47', NULL);

CREATE TABLE IF NOT EXISTS `warnings` (
  `warning_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `permission_id` bigint unsigned DEFAULT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`warning_id`),
  KEY `warnings_permission_id_foreign` (`permission_id`),
  KEY `idx_warnings_student` (`student_id`),
  CONSTRAINT `warnings_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`permission_id`) ON DELETE SET NULL,
  CONSTRAINT `warnings_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
