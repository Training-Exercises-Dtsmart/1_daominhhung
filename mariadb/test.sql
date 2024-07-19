-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               11.4.2-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping data for table test.auth_assignment: ~3 rows (approximately)
DELETE FROM `auth_assignment`;
INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
	('admin', '2', 1721011657),
	('admin', '31', 1721011657),
	('author', '34', 1721011657);

-- Dumping data for table test.auth_item: ~4 rows (approximately)
DELETE FROM `auth_item`;
INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
	('admin', 1, NULL, NULL, NULL, 1721011657, 1721011657),
	('author', 1, NULL, NULL, NULL, 1721011656, 1721011656),
	('create', 2, 'Create', NULL, NULL, 1721011656, 1721011656),
	('update', 2, 'Update', NULL, NULL, 1721011656, 1721011656);

-- Dumping data for table test.auth_item_child: ~3 rows (approximately)
DELETE FROM `auth_item_child`;
INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
	('admin', 'author'),
	('author', 'create'),
	('admin', 'update');

-- Dumping data for table test.auth_rule: ~0 rows (approximately)
DELETE FROM `auth_rule`;

-- Dumping data for table test.category_post: ~0 rows (approximately)
DELETE FROM `category_post`;

-- Dumping data for table test.category_product: ~2 rows (approximately)
DELETE FROM `category_product`;
INSERT INTO `category_product` (`id`, `user_id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 8, 'Điện thoại', '2024-07-12 14:53:55', NULL, NULL),
	(2, 8, 'Laptop', '2024-07-17 10:38:08', NULL, NULL);

-- Dumping data for table test.complete_job: ~0 rows (approximately)
DELETE FROM `complete_job`;

-- Dumping data for table test.migration: ~15 rows (approximately)
DELETE FROM `migration`;
INSERT INTO `migration` (`version`, `apply_time`) VALUES
	('m140506_102106_rbac_init', 1720750916),
	('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1720750916),
	('m180523_151638_rbac_updates_indexes_without_prefix', 1720750916),
	('m200409_110543_rbac_update_mssql_trigger', 1720750916),
	('m240702_033518_create_user_table', 1720592032),
	('m240702_081423_create_category_product_table', 1720513726),
	('m240702_081424_create_category_post_table', 1720513726),
	('m240702_094712_create_post_table', 1720513726),
	('m240702_094716_create_product_table', 1720592032),
	('m240702_100327_create_order_table', 1720584167),
	('m240702_100630_create_order_detail_table', 1720513727),
	('m240708_102617_create_review_table', 1720513727),
	('m240710_025358_init_rbac', 1720750885),
	('m240711_043120_create_queue_table', 1720672570),
	('m240715_080322_create_complete_job_table', 1721030676);

-- Dumping data for table test.order: ~0 rows (approximately)
DELETE FROM `order`;

-- Dumping data for table test.order_detail: ~0 rows (approximately)
DELETE FROM `order_detail`;

-- Dumping data for table test.post: ~0 rows (approximately)
DELETE FROM `post`;

-- Dumping data for table test.product: ~14 rows (approximately)
DELETE FROM `product`;
INSERT INTO `product` (`id`, `user_id`, `name`, `image`, `price`, `stock`, `description`, `category_id`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES
	(17, 8, 'Iphone15', '6690f2e832a2f.png', 15000000, 100, 'Điện thoại, Điện thoại,Điện thoại,Điện thoai', 1, '2024-07-12 11:10:00', '2024-07-15 05:33:29', NULL, 0),
	(43, 8, 'Iphone 16ProMax', NULL, 12000000, 90, 'Iphone 15', 1, '2024-07-15 08:57:52', '2024-07-15 08:57:52', NULL, 0),
	(44, 31, NULL, '66973d9597e56.jpg', NULL, NULL, NULL, NULL, '2024-07-17 05:42:13', '2024-07-17 05:42:13', NULL, 0),
	(45, 31, NULL, '66973dab38ffd.jpg', NULL, NULL, NULL, NULL, '2024-07-17 05:42:35', '2024-07-17 05:42:35', NULL, 0),
	(46, 31, 'Laptop Asus Gaming', NULL, 24000000, 90, 'Laptop Asus Gaming', 2, '2024-07-17 05:46:35', '2024-07-17 05:46:35', NULL, 0),
	(47, NULL, NULL, '66973e9bf34c7.jpg', NULL, NULL, NULL, NULL, '2024-07-17 05:46:35', '2024-07-17 05:46:35', NULL, 0),
	(48, 31, 'Laptop Asus Gaming', NULL, 24000000, 90, 'Laptop Asus Gaming', 2, '2024-07-17 05:47:02', '2024-07-17 05:47:02', NULL, 0),
	(49, NULL, NULL, '66973eb61d648.jpg', NULL, NULL, NULL, NULL, '2024-07-17 05:47:02', '2024-07-17 05:47:02', NULL, 0),
	(50, 31, 'Laptop Asus Gaming', NULL, 24000000, 90, 'Laptop Asus Gaming', 2, '2024-07-17 05:48:20', '2024-07-17 05:48:20', NULL, 0),
	(51, 31, 'Laptop Asus Gaming', NULL, 24000000, 90, 'Laptop Asus Gaming', 2, '2024-07-17 05:54:49', '2024-07-17 05:54:49', NULL, 0),
	(52, 31, 'Laptop Asus Gaming', NULL, 24000000, 90, 'Laptop Asus Gaming', 2, '2024-07-17 05:55:11', '2024-07-17 05:55:11', NULL, 0),
	(53, 22, 'Laptop Asus Gaming', '6697437e58bb5.jpg', 24000000, 90, 'Laptop Asus Gaming', 2, '2024-07-17 05:56:32', '2024-07-17 06:07:26', NULL, 0),
	(54, 31, 'Laptop Asus Gaming 1', '66976d9e7d6b7.jpg,66976d9e7e11a.png', 24000000, 90, 'Laptop Asus Gaming 1', 2, '2024-07-17 09:02:11', '2024-07-17 09:07:10', NULL, 0),
	(55, 31, 'Laptop Asus Gaming 2', '66976ceb28b55.jpg,66976ceb29363.jpg', 24000000, 90, 'Laptop Asus Gaming 2', 2, '2024-07-17 09:04:11', '2024-07-17 09:04:11', NULL, 0);

-- Dumping data for table test.queue: ~0 rows (approximately)
DELETE FROM `queue`;

-- Dumping data for table test.review: ~0 rows (approximately)
DELETE FROM `review`;

-- Dumping data for table test.user: ~15 rows (approximately)
DELETE FROM `user`;
INSERT INTO `user` (`id`, `image`, `username`, `password`, `address`, `phone`, `access_token`, `password_reset_token`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES
	(8, 'https://i.pinimg.com/originals/43/8a/5b/438a5b048e1d07c5b64f4147203b58bc.jpg', 'toan70868@gmail.com', '$2y$13$.dYWCIIRCP2sItiTEPr8Rew/clbXEw2PFBJG4uPyOZNyatqiJzilO', NULL, NULL, NULL, NULL, '2024-07-12 09:02:42', '2024-07-16 12:26:17', NULL, 0),
	(22, NULL, 'husyanti@gmail.com', '$2y$13$t41pc40vlUgJfPS5WcoZv./yZWyxFzctidry3IVy0JIs.deEclNIO', NULL, 123456789, '3yMSB2AurrRufdf_5L-jjonLN8zVYuyI', NULL, '2024-07-12 12:04:53', '2024-07-17 06:57:30', NULL, 0),
	(23, NULL, 'toan70868@gmail.com', '$2y$13$N1kx.iMfKTmOnaW9gntX.ef6RwDrh5KO15h2zNtM.x8lJ7.6nJMzW', NULL, NULL, '_MyBu1SVlYYqaT_i-SwROEOTou5dhTTY', NULL, '2024-07-12 12:05:00', '2024-07-12 12:05:00', NULL, 0),
	(24, NULL, 'toan70868@gmail.com', '$2y$13$UQPSIKOM8/IQuIBqSTklOOb..R2yAQ1D8ODxLgjoSOrvRcUt2n2we', NULL, NULL, 'avGH9Z1rpHF4G0B3Mchd3COfRrLUVsuY', NULL, '2024-07-12 12:05:03', '2024-07-12 12:05:03', NULL, 0),
	(25, NULL, ' ', '$2y$13$.viN.BPECdn5TTbXCVcDTe3.sZeDp2W1j1023MfbWTZ7DrjyDmi9.', NULL, NULL, 'I0QuYKXReKqFlsejMT7_y9zSwQQSNF1o', NULL, '2024-07-12 12:05:05', '2024-07-12 12:05:05', NULL, 0),
	(26, NULL, 'toan70868@gmail.com', '$2y$13$S/76qhoyvkyFZs3izqbUC.dn5RhskkmCgrlIvZjlrOB3azFv7M9oy', NULL, NULL, 'fFkuSTXuJaDkMJpozpr-EStN3g16GiTj', NULL, '2024-07-12 12:05:08', '2024-07-12 12:05:08', NULL, 0),
	(27, NULL, 'toan70868@gmail.com', '$2y$13$K31MOme7kA06cekb/VHRoOd4lH5gioskz2bOXOJMOzohw7J5d3tBi', NULL, NULL, 'QQqxIsFRxQH2HITd4LdDSQj-wGn9iYk9', NULL, '2024-07-12 12:05:11', '2024-07-12 12:05:11', NULL, 0),
	(28, '66910129633d6.jfif', 'toan70868@gmail.com', '$2y$13$eTGENyK47WL3WDop2FzzzuiGWVMC.KsyWZSGBXWIBoT187CJv.Tau', NULL, NULL, 'MoL1XkRaXIw7SFKLCllbV7MKZKe8z8t-', NULL, '2024-07-12 12:10:49', '2024-07-12 12:10:49', NULL, 0),
	(29, '66910204e1efa.jfif', 'toan70868@gmail.com', '$2y$13$eh8VEOktw2JnHNc.QIRgbe6Vqjax68adb1UG.iwG.vQy0NttBIgpe', NULL, NULL, 'haIbxGM8OkmjuZsr6eggwmzPUHpCMF4f', NULL, '2024-07-12 12:14:28', '2024-07-12 12:14:28', NULL, 0),
	(30, '66910224aa6fb.jpg', 'toan70868@gmail.com', '$2y$13$5fNv.dKIxO/JUHBoumwml.4nwt6g.T9tr/AdnswRsR8uQMqmx.64q', NULL, NULL, 'BB3huGmHVRgG_97U3A6_OcrMQGmr73Ai', NULL, '2024-07-12 12:15:00', '2024-07-12 12:15:00', NULL, 0),
	(31, 'i_fsqp40_qZr0KGuT5YXAZHMy_LOfRZc', 'daominhhung2203@gmail.com', '$2y$13$T77ugjXpC9uGn3WiJ5/Y2.thazTCtwu.mPhue2uGx.Jpyzjo96ypW', NULL, NULL, 'i_fsqp40_qZr0KGuT5YXAZHMy_LOfRZc', NULL, '2024-07-15 05:37:03', '2024-07-16 05:22:12', NULL, 0),
	(32, NULL, 'daominhhung1@gmail.com', '$2y$13$r/4iY37U5SKW6hwLPWnNXembkJeJfZyXg8NxNq1PHLm4DjQc1WxVe', NULL, 123456789, 'AnM-LPW52NJhh5pPQAB09nGTuqfb50SW', NULL, '2024-07-16 05:11:51', '2024-07-17 06:36:43', NULL, 0),
	(33, NULL, '@gmail.com', '$2y$13$Wc4781pxZHDOZLX/wa4nmOy9NHN5T.YeJ0F9X2i6BO/QOoGOG6FD6', NULL, NULL, 'lKN3YzcukLIthxIJWhiyDQJslZeXQ1S7', NULL, '2024-07-16 12:22:36', '2024-07-17 05:27:41', NULL, 1),
	(34, '66964bada89db.jpg', 'daominhhung2@gmail.com', '$2y$13$3rwFjC1JDQU0UXvIVc8jceGzYwy0CtgqE.3xqh.wlCY7GezrQJjRW', NULL, NULL, 'rvBDdVgSr-xSO5cq84oQi3hmVVZCA6ZG', NULL, '2024-07-16 12:30:05', '2024-07-16 12:30:05', NULL, 0),
	(35, '66973ff40c1d1.jpg', 'toan70869@gmail.com', '$2y$13$YUu0uezkHuW2hm/hignUsuU9ceTcmuqQ/A4ra9lNBslyMBpvwlO3m', NULL, NULL, '9kAE69fFv5ISg8q8RR-qQ8XQSyFpny9-', NULL, '2024-07-17 05:52:20', '2024-07-17 06:56:13', NULL, 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
