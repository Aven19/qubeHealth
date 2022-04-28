-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.37 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for qubehealth
CREATE DATABASE IF NOT EXISTS `qubehealth` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `qubehealth`;

-- Dumping structure for table qubehealth.documents
CREATE TABLE IF NOT EXISTS `documents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `img_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table qubehealth.documents: ~0 rows (approximately)
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
INSERT INTO `documents` (`id`, `user_id`, `img_name`, `file`, `status`, `created_at`, `updated_at`) VALUES
	(1, 4, 'Test.png', 'image/png', 0, '2022-04-28 16:38:21', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;

-- Dumping structure for table qubehealth.otp
CREATE TABLE IF NOT EXISTS `otp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `otp` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `otp_count` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table qubehealth.otp: ~4 rows (approximately)
/*!40000 ALTER TABLE `otp` DISABLE KEYS */;
INSERT INTO `otp` (`id`, `phone`, `otp`, `otp_count`, `created_at`, `updated_at`) VALUES
	(1, '9702620184', '6754', '', '2022-04-25 11:33:26', '2022-04-28 16:38:46'),
	(2, '970262184', '5008', '', '2022-04-27 13:58:14', '2022-04-27 14:28:28'),
	(3, '9702525888', '7731', '', '2022-04-28 10:50:26', '2022-04-28 10:50:26'),
	(4, '9702620181', '5895', '', '2022-04-28 11:21:07', '2022-04-28 12:30:31'),
	(5, '9876545688', '3532', '', '2022-04-28 16:28:19', '2022-04-28 16:28:19');
/*!40000 ALTER TABLE `otp` ENABLE KEYS */;

-- Dumping structure for table qubehealth.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('admin','user') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `users_phone_unique` (`phone`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table qubehealth.users: ~10 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `type`, `is_verified`, `status`, `created_at`, `updated_at`) VALUES
	(1, '', '', '9702620184', 'admin', 0, 0, '2022-04-25 11:33:26', '0000-00-00 00:00:00'),
	(2, 'asd', 'asdad@gmail.com', '9702620181', 'user', 0, 0, '2022-04-25 11:45:45', '0000-00-00 00:00:00'),
	(3, 'test', 'test@gmail.com', '9702525888', 'user', 0, 0, '2022-04-27 12:02:37', '0000-00-00 00:00:00'),
	(4, 'qwe', 'qwe@gmail.com', '9876545688', 'user', 0, 0, '2022-04-27 12:57:15', '0000-00-00 00:00:00'),
	(5, 'test', 'test@gmail.com', '1111111111', 'user', 0, 0, '2022-04-27 14:30:27', '0000-00-00 00:00:00'),
	(6, 'test', 'test@gmail.com', '1111111112', 'user', 0, 0, '2022-04-27 14:31:07', '0000-00-00 00:00:00'),
	(7, 'test', 'test@gmail.com', '1111111113', 'user', 0, 0, '2022-04-27 14:31:23', '0000-00-00 00:00:00'),
	(9, 'te', 'qwe@gmail.com', '1231232222', 'user', 0, 0, '2022-04-27 14:33:41', '0000-00-00 00:00:00'),
	(10, 'qwe', 'qwe@gmail.com', '1231231233', 'user', 0, 0, '2022-04-27 14:34:15', '0000-00-00 00:00:00'),
	(11, 'qwe', 'qwe@gmail.com', '1231231232', 'user', 0, 0, '2022-04-27 14:34:38', '0000-00-00 00:00:00'),
	(12, 'asd', 'asd@gmail.com', '9702621842', 'user', 0, 0, '2022-04-27 14:59:29', '0000-00-00 00:00:00'),
	(13, 'test', 'qwe@gmail.com', '9876542122', 'user', 0, 0, '2022-04-28 16:39:19', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
