-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 29, 2025 at 12:04 PM
-- Server version: 10.11.10-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u557007429_mybaby_v2`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(127) DEFAULT NULL,
  `auth_key` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varbinary(32) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `name`, `email`, `auth_key`, `password_hash`, `password_reset_token`, `status`, `create_time`, `update_time`) VALUES
(1, 'yyounus', 'Yawar', 'yawar217@live.com', 'yawarauthkeyadmin', '$2y$13$8MpCYauhy/0dQSoyOyv4f.ImGEof8Z1Av0X3beSrqeGOCQeWrbcku', NULL, 1, '2023-12-12 17:02:57', '2023-12-12 17:02:57'),
(2, 'mylakhana', 'Mubashir', 'mubashirlakhana@gmail.com', 'mubashirauthkeyadmin', '$2y$13$vr6bxnDHW1gtaIxatc9UHuf0DoKVPUENTUlHCdNFxsFKQ.uM9pRYK', NULL, 1, '2023-12-12 17:02:57', '2023-12-12 16:44:52');

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `grade_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `type` enum('announcement','event','result') DEFAULT 'announcement',
  `time` timestamp NULL DEFAULT NULL,
  `status` varchar(255) DEFAULT 'active',
  `create_time` timestamp NULL DEFAULT current_timestamp(),
  `update_time` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`id`, `user_id`, `grade_id`, `title`, `body`, `type`, `time`, `status`, `create_time`, `update_time`) VALUES
(1, 1, 1, 'We are here', 'hello everyone! exciting news. we finally have an app!', 'announcement', '2024-09-25 14:46:29', 'active', '2024-09-25 14:46:29', '2024-10-15 16:57:16'),
(2, 1, 1, 'Birthday celebration', 'Ali\'s birthday will be celebrated in the evening', 'event', '2024-10-15 15:22:01', 'active', '2024-10-01 14:56:41', '2024-10-16 18:15:52'),
(3, 1, 1, 'hello boys', 'come early tomorrow', 'announcement', '2024-10-15 16:55:36', 'active', '2024-10-15 16:55:44', '2024-10-15 16:55:44'),
(4, 46, 40, 'يوم البحاما', 'اللبس ازرق', 'announcement', '2024-11-17 00:00:00', 'active', '2024-11-17 19:09:59', '2024-11-17 19:09:59'),
(5, 46, 40, 'حفل تخرج', 'الحضور في قاعة الليلة', 'event', '2024-11-19 00:00:00', 'active', '2024-11-17 19:10:42', '2024-11-17 19:10:42'),
(6, 46, 40, 'تسميع ', 'حضور حضور وتسميع حضور حضور وتسميع حضور حضور وتسميع حضور حضور وتسميعحضور حضور وتسميع حضور حضور وتسميعحضور حضور وتسميع حضور حضور وتسميعحضور حضور وتسميع حضور حضور وتسميعحضور حضور وتسميع حضور حضور وتسميعحضور حضور وتسميع حضور حضور وتسميعحضورز حضور وتسميع حضور حضور وتسميعحضور حضور وتسميع حضور حضور وتسميع', 'event', '2024-12-13 15:18:00', 'active', '2024-12-12 20:31:25', '2024-12-12 20:31:25'),
(7, 46, 40, 'hdhc', 'hsbdncn', 'announcement', '2024-12-17 00:00:00', 'active', '2024-12-12 20:32:31', '2024-12-12 20:32:31'),
(8, 46, 40, 'Graduation Day', 'yayy\n', 'event', '2024-12-20 00:00:00', 'active', '2024-12-13 17:09:23', '2024-12-13 17:09:23'),
(9, 46, 40, 'zjd', 'jdnd', 'event', '2024-12-18 00:00:00', 'active', '2024-12-17 18:00:33', '2024-12-17 18:00:33'),
(10, 46, 40, 'physics', '58', 'result', '2024-12-19 17:37:40', 'active', '2024-12-19 17:37:50', '2024-12-19 17:37:50'),
(11, 46, 40, 'math', '12', 'result', '2024-12-19 17:38:38', 'active', '2024-12-19 17:38:49', '2024-12-19 17:38:49'),
(12, 65, 42, 'chemistry', '58', 'result', '2024-12-19 18:17:00', 'active', '2024-12-19 18:17:08', '2024-12-19 18:17:08'),
(13, 65, 42, 'basic_math', '55', 'result', '2024-12-29 03:27:42', 'active', '2024-12-29 03:28:17', '2024-12-29 03:28:17'),
(14, 65, 42, 'يوم التخرج ٣٠-١٢-٢٠٢٤', 'نبارك لكم التخرج 🎓 \n\nيرجى احضار قميص 👕 أزرق وبنطال أسود', 'announcement', '2024-12-29 03:29:04', 'active', '2024-12-29 03:29:57', '2024-12-29 03:29:57'),
(15, 74, 45, 'reading', '100', 'result', '2024-12-30 12:46:43', 'active', '2024-12-30 12:47:31', '2024-12-30 12:47:31'),
(16, 78, 47, 'drawing', '99', 'result', '2025-01-13 09:56:51', 'active', '2025-01-13 09:57:19', '2025-01-13 09:57:19'),
(17, 67, 42, 'drawing', '56', 'result', '2025-01-23 16:57:29', 'active', '2025-01-23 16:57:41', '2025-01-23 16:57:41');

-- --------------------------------------------------------

--
-- Table structure for table `announcement_items`
--

CREATE TABLE `announcement_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `announcement_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement_items`
--

INSERT INTO `announcement_items` (`id`, `announcement_id`, `student_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 2, 1),
(4, 3, 1),
(5, 3, 2),
(6, 4, 12),
(7, 5, 12),
(8, 6, 12),
(9, 7, 12),
(10, 8, 12),
(11, 9, 12),
(12, 10, 12),
(13, 11, 12),
(14, 12, 15),
(15, 12, 16),
(16, 13, 15),
(17, 13, 16),
(18, 13, 18),
(19, 14, 15),
(20, 14, 16),
(21, 14, 18),
(22, 15, 19),
(23, 16, 21),
(24, 17, 15),
(25, 17, 16),
(26, 17, 18);

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `grade_id` int(11) DEFAULT NULL,
  `time_in` timestamp NULL DEFAULT NULL,
  `time_out` timestamp NULL DEFAULT NULL,
  `lunch` enum('no','half','full') DEFAULT NULL,
  `nap` int(11) DEFAULT NULL COMMENT 'minutes',
  `bathroom_breaks` int(11) DEFAULT NULL,
  `status` enum('present','absent','leave','holiday') DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT current_timestamp(),
  `update_time` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `user_id`, `student_id`, `grade_id`, `time_in`, `time_out`, `lunch`, `nap`, `bathroom_breaks`, `status`, `create_time`, `update_time`) VALUES
(1, 1, 1, 1, '2024-10-14 16:49:00', NULL, 'half', NULL, 3, 'present', '2024-10-15 16:49:51', '2024-10-16 17:57:12'),
(2, 1, 1, 1, '2024-10-15 16:52:00', '2024-10-15 21:57:00', NULL, NULL, NULL, 'present', '2024-10-15 16:52:52', '2024-10-16 18:18:28'),
(3, 1, 1, 1, '2024-10-17 20:48:00', NULL, NULL, NULL, NULL, 'present', '2024-10-17 20:48:46', '2024-10-17 20:48:46'),
(4, 1, 2, 1, '2024-10-17 20:48:00', '2024-10-17 22:55:00', NULL, NULL, NULL, 'present', '2024-10-17 20:48:46', '2024-10-17 21:25:38'),
(5, 1, 2, 1, '2024-10-14 12:10:00', NULL, NULL, NULL, NULL, 'absent', '2024-10-17 20:51:04', '2024-10-17 20:51:04'),
(6, 1, 2, 1, '2024-10-15 12:10:00', NULL, NULL, NULL, NULL, 'present', '2024-10-17 21:25:26', '2024-10-17 21:25:26'),
(7, 46, 12, 40, '2024-11-17 23:04:20', NULL, NULL, NULL, NULL, 'present', '2024-11-17 18:12:32', '2024-11-17 19:04:42'),
(8, 46, 12, 40, '2024-12-11 16:18:00', NULL, NULL, NULL, NULL, 'present', '2024-12-11 13:18:00', '2024-12-11 13:18:00'),
(9, 46, 12, 40, '2024-12-17 21:00:00', '2024-12-17 23:50:00', NULL, 30, 0, 'present', '2024-12-17 18:00:44', '2024-12-17 18:51:26'),
(10, 65, 15, 42, '2024-12-17 23:54:00', NULL, NULL, NULL, NULL, 'present', '2024-12-17 20:54:10', '2024-12-17 20:54:10'),
(11, 65, 15, 42, '2024-12-29 03:28:31', NULL, NULL, NULL, NULL, 'absent', '2024-12-29 03:28:37', '2024-12-29 03:28:37'),
(12, 65, 16, 42, '2024-12-29 03:28:31', NULL, NULL, NULL, NULL, 'absent', '2024-12-29 03:28:37', '2024-12-29 03:28:37'),
(13, 65, 18, 42, '2024-12-29 03:28:31', NULL, NULL, NULL, NULL, 'absent', '2024-12-29 03:28:37', '2024-12-29 03:28:37'),
(14, 74, 19, 45, '2024-12-30 12:44:50', '2024-12-30 12:05:00', 'half', 90, 2, 'present', '2024-12-30 12:45:16', '2024-12-30 12:45:16'),
(15, 76, 20, 47, '2025-01-09 18:51:00', NULL, 'half', 60, 3, 'present', '2025-01-09 18:51:12', '2025-01-09 18:54:07'),
(16, 78, 21, 47, '2025-01-13 09:55:51', '2025-01-13 09:30:00', 'half', 120, 2, 'present', '2025-01-13 09:56:38', '2025-01-13 09:56:38');

-- --------------------------------------------------------

--
-- Table structure for table `audit_trail`
--

CREATE TABLE `audit_trail` (
  `id` int(11) NOT NULL,
  `old_value` text DEFAULT NULL,
  `new_value` text DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `field` varchar(255) DEFAULT NULL,
  `stamp` datetime NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `model_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`, `updated_at`, `rule_name`, `data`) VALUES
('admin', '5', NULL, NULL, NULL, NULL),
('developer', '1', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 2, 'Access to all functions except dev configurations', NULL, NULL, NULL, NULL),
('developer', 1, 'Access to ALL Functions', NULL, NULL, NULL, NULL),
('school', 4, 'Basic Access', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', 'school'),
('developer', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `device`
--

CREATE TABLE `device` (
  `id` int(11) NOT NULL,
  `device_id` varchar(500) DEFAULT NULL,
  `device_type` varchar(500) DEFAULT NULL COMMENT 'Android/iOS etc',
  `make` varchar(255) DEFAULT NULL COMMENT 'iphone',
  `model` varchar(255) DEFAULT NULL COMMENT '14 pro max',
  `os` varchar(255) DEFAULT NULL COMMENT '16.1',
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT current_timestamp() COMMENT 'when did user started using our app',
  `update_time` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `device`
--

INSERT INTO `device` (`id`, `device_id`, `device_type`, `make`, `model`, `os`, `name`, `email`, `mobile`, `create_time`, `update_time`) VALUES
(1, '42AEDEFA-B731-4557-A9F1-1944EEC40FC0', 'ios', 'iPhone', 'iPhone 15 Pro Max', '17.0.1', NULL, NULL, NULL, '2024-03-18 02:07:17', '2024-03-18 02:07:17'),
(2, 'samsung/b0qxxx/b0q:14/UP1A.231005.007/S908EXXS8DXD2:user/release-keys', 'android', 'samsung', 'b0qxxx', '14', NULL, NULL, NULL, '2024-05-26 19:06:57', '2024-05-26 19:06:57'),
(3, 'samsung/e3qxxx/e3q:14/UP1A.231005.007/S928BXXU1AXCA:user/release-keys', 'android', 'samsung', 'e3qxxx', '14', NULL, NULL, NULL, '2024-05-26 19:57:03', '2024-05-26 19:57:03'),
(4, 'samsung/e3qxxx/e3q:14/UP1A.231005.007/S928BXXS2AXD5:user/release-keys', 'android', 'samsung', 'e3qxxx', '14', NULL, NULL, NULL, '2024-05-27 10:00:51', '2024-05-27 10:00:51'),
(5, 'EC89F392-EA29-4951-BBFB-50023E395AC1', 'ios', 'iPhone', 'iPhone 15 Pro Max', '17.0.1', NULL, NULL, NULL, '2024-07-05 00:53:40', '2024-07-05 00:53:40'),
(6, '893EFEC0-5A4E-41FC-B289-792CDC323C58', 'ios', 'iPhone', 'iPhone 15 Pro Max', '17.5', NULL, NULL, NULL, '2024-11-12 03:03:35', '2024-11-12 03:03:35'),
(7, 'google/raven_beta/raven:15/AP41.240925.009/12534705:user/release-keys', 'android', 'google', 'raven_beta', '15', NULL, NULL, NULL, '2024-11-13 01:58:49', '2024-11-13 01:58:49'),
(8, 'samsung/b0qxxx/b0q:14/UP1A.231005.007/S908EXXUAEXH7:user/release-keys', 'android', 'samsung', 'b0qxxx', '14', NULL, NULL, NULL, '2024-11-13 19:29:10', '2024-11-13 19:29:10'),
(9, 'google/raven_beta/raven:15/BP11.241025.006/12620009:user/release-keys', 'android', 'google', 'raven_beta', '15', NULL, NULL, NULL, '2024-11-16 20:13:20', '2024-11-16 20:13:20'),
(10, '093CA991-B4F1-4C37-BDE5-27B9E69249F5', 'ios', 'iPhone', 'iPhone', '18.0.1', NULL, NULL, NULL, '2024-11-16 20:21:03', '2024-11-16 20:21:03'),
(11, '9EE3ED6C-57A7-42C3-82FF-B8E14CE89EF5', 'ios', 'iPhone', 'iPhone 16 Pro', '18.2', NULL, NULL, NULL, '2024-12-18 17:01:51', '2024-12-18 17:01:51'),
(12, 'google/raven_beta/raven:15/BP11.241121.010/12780007:user/release-keys', 'android', 'google', 'raven_beta', '15', NULL, NULL, NULL, '2024-12-18 20:46:33', '2024-12-18 20:46:33'),
(13, 'D8B71C31-AD83-4806-AB63-6ED267631288', 'ios', 'iPhone', 'Farzana\'s iPhone (2)', '15.8.3', NULL, NULL, NULL, '2024-12-19 15:38:57', '2024-12-19 15:38:57'),
(14, '7D89F41A-08B5-4A4B-B2DE-5356E4A17D81', 'ios', 'iPhone', 'iPhone 16 Pro Max', '18.2', NULL, NULL, NULL, '2024-12-19 21:25:12', '2024-12-19 21:25:12'),
(15, '2A2958F6-4A50-4AA6-B51C-DE399A0EAEEB', 'ios', 'iPad', 'iPad Pro 13-inch (M4)', '18.2', NULL, NULL, NULL, '2024-12-19 21:51:41', '2024-12-19 21:51:41'),
(16, 'B25DF67E-2CE5-4ED2-8239-04D30D122E59', 'ios', 'iPad', 'iPad', '18.2', NULL, NULL, NULL, '2024-12-20 12:20:41', '2024-12-20 12:20:41'),
(17, '7941E1C4-833A-4145-A189-22D4B3942971', 'ios', 'iPhone', 'iPhone', '18.1.1', NULL, NULL, NULL, '2024-12-20 12:45:22', '2024-12-20 12:45:22'),
(18, 'AE049786-0921-44D5-85EA-6538A6A17996', 'ios', 'iPhone', 'iPhone 16 Pro Max', '18.0', NULL, NULL, NULL, '2024-12-24 12:13:06', '2024-12-24 12:13:06'),
(19, 'ED00376C-4AF3-46E6-AF02-06A4FB748E34', 'ios', 'iPhone', 'iPhone', '17.6.1', NULL, NULL, NULL, '2024-12-30 15:12:29', '2024-12-30 15:12:29'),
(20, 'DA179685-24EE-4F29-BA59-0C3743FF4FFE', 'ios', 'iPhone', 'iPhone', '18.1.1', NULL, NULL, NULL, '2025-01-03 13:06:45', '2025-01-03 13:06:45'),
(21, '0EC8A3EB-7F7B-4A6A-8D96-63CEFD248DCB', 'ios', 'iPhone', 'iPhone', '18.1.1', NULL, NULL, NULL, '2025-01-05 16:50:56', '2025-01-05 16:50:56'),
(22, 'samsung/r11sxxx/r11s:14/UP1A.231005.007/S711BXXS6DXK8:user/release-keys', 'android', 'samsung', 'r11sxxx', '14', NULL, NULL, NULL, '2025-01-09 10:45:15', '2025-01-09 10:45:15'),
(23, 'samsung/d2sxx/d2s:12/SP1A.210812.016/N975FXXS9HWHB:user/release-keys', 'android', 'samsung', 'd2sxx', '12', NULL, NULL, NULL, '2025-01-09 21:44:27', '2025-01-09 21:44:27'),
(24, 'samsung/dm3qxxx/dm3q:14/UP1A.231005.007/S918BXXS7CXK6:user/release-keys', 'android', 'samsung', 'dm3qxxx', '14', NULL, NULL, NULL, '2025-01-12 13:56:58', '2025-01-12 13:56:58'),
(25, 'samsung/beyond2ltexx/beyond2:12/SP1A.210812.016/G975FXXSGHWC1:user/release-keys', 'android', 'samsung', 'beyond2ltexx', '12', NULL, NULL, NULL, '2025-01-12 15:16:39', '2025-01-12 15:16:39'),
(26, 'samsung/b0qxxx/b0q:14/UP1A.231005.007/S908EXXSBEXL2:user/release-keys', 'android', 'samsung', 'b0qxxx', '14', NULL, NULL, NULL, '2025-01-13 12:07:57', '2025-01-13 12:07:57'),
(27, '5EBD83EF-11B6-4B70-8313-E90C4EB4F474', 'ios', 'iPhone', 'iPhone', '18.1.1', NULL, NULL, NULL, '2025-01-29 11:24:57', '2025-01-29 11:24:57'),
(28, 'EADEDDC6-10E6-49F0-88D3-EE7379D94DCE', 'ios', 'iPhone', 'iPhone', '18.2.1', NULL, NULL, NULL, '2025-01-29 13:01:59', '2025-01-29 13:01:59');

-- --------------------------------------------------------

--
-- Table structure for table `device_preferences`
--

CREATE TABLE `device_preferences` (
  `id` int(11) NOT NULL,
  `device_id` int(11) DEFAULT NULL,
  `project` varchar(255) DEFAULT NULL COMMENT 'provider_app, client_app, etc.',
  `title` varchar(255) DEFAULT NULL COMMENT 'last_used, views, likes, etc.',
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `device_preferences`
--

INSERT INTO `device_preferences` (`id`, `device_id`, `project`, `title`, `value`) VALUES
(1, 1, 'teacher', 'last_used', '2024-06-27 18:04:22'),
(2, 1, 'teacher', 'fcm_token', 'your_device_token_here'),
(3, 1, 'teacher', 'user_id', '1'),
(4, 1, 'teacher', 'app_version', '1.0'),
(5, 1, 'parent', 'last_used', '2024-06-27 18:48:20'),
(6, 1, 'parent', 'fcm_token', 'your_device_token_here'),
(7, 1, 'parent', 'user_id', '4'),
(8, 1, 'parent', 'app_version', '1.0'),
(13, 6, 'app-api', 'last_used', '2024-11-12 00:19:12'),
(14, 6, 'app-api', 'fcm_token', 'ekrYNQMiaUwIljPs3kIUqI:APA91bHJufB7PszD0CSknIC9dXesPRrMz2VNN2B4d3qyz4ijwzvYyelvBk6sJ9mYqHbQFumPlX_NFoccingWqCUQJd3NyRcTCJeBDTcfWXM-WZHMfBrs4IY'),
(15, 6, 'app-api', 'user_id', ''),
(16, 6, 'app-api', 'app_version', ''),
(565, 18, 'mybaby', 'last_used', '2024-12-26 01:06:33'),
(566, 18, 'mybaby', 'fcm_token', 'dKHBibFcVkUyuJdL8Yy0cK:APA91bEgaliQqnSOps360jI0sO1hIf6la7giOaw2Nz9OE8Q8w06xIP249BvKi5q8v6zal61K8AgXr4ORwWKtFw_DC5zGOBrjFUOPIxClAU3BP0Gtqw-yWhI'),
(567, 18, 'mybaby', 'user_id', '2'),
(568, 18, 'mybaby', 'app_version', '1.0'),
(837, 25, 'mybaby', 'last_used', '2025-01-12 15:18:33'),
(838, 25, 'mybaby', 'fcm_token', 'chQoIZ8FRyWHCokwxueXx3:APA91bGo1eVgNX1rl75UPXDKBrAEZnb1SFPaHlCQL4Mepq9O2OI4bohOsikOHtKP-xzt2ezhKjk7gW32xMAIT6q6hjOHqk9eLqaJoM85h8Ss_71gM8Eb_iQ'),
(839, 25, 'mybaby', 'user_id', '79'),
(840, 25, 'mybaby', 'app_version', '1.0'),
(841, 23, 'mybaby', 'last_used', '2025-01-12 17:40:06'),
(842, 23, 'mybaby', 'fcm_token', 'cjb_iGKPRL-cH44jJ2j5zQ:APA91bGTlmHLdP8PDW4Y8XBI7-CnUgbEGRhtkAKHQFbHgFyXJ1WV-uKjOJET7Cij2UOwC631JiJQyiw0d9RQNbLbfmlIU6islQXIqDJu6Vw2sFj0jyAl6ws'),
(843, 23, 'mybaby', 'user_id', '77'),
(844, 23, 'mybaby', 'app_version', ''),
(849, 22, 'mybaby', 'last_used', '2025-01-12 17:52:33'),
(850, 22, 'mybaby', 'fcm_token', 'dDMIQru9Ttir8Un0_5OibD:APA91bFgs6sDbsWNn5G2-9IcdlqP2GGoiEYvU015U2Cl5TXrqyLPCQSB3S92GmaQjoaM_Ztp7NdpS3ZycB8Sd0uBvRFmDohXt-e18JfQVeIoHzx4ZPkDHTo'),
(851, 22, 'mybaby', 'user_id', '76'),
(852, 22, 'mybaby', 'app_version', ''),
(881, 24, 'mybaby', 'last_used', '2025-01-14 14:05:51'),
(882, 24, 'mybaby', 'fcm_token', 'd3ApzGBHT0ebv4DbjjPyS7:APA91bG8ZLEE4UzMqvn9fOmsEfYIMLt8xsc8RbwC2hK8W8_J-3uCwIwnr_8lJgJ_U7zL3x3RqLSj5wShFk-Q99C6CAE4gSg7YLbIqgVV21ztXIysbEHNkZg'),
(883, 24, 'mybaby', 'user_id', '78'),
(884, 24, 'mybaby', 'app_version', '1.0'),
(897, 19, 'mybaby', 'last_used', '2025-01-16 13:03:49'),
(898, 19, 'mybaby', 'fcm_token', ''),
(899, 19, 'mybaby', 'user_id', '74'),
(900, 19, 'mybaby', 'app_version', ''),
(905, 26, 'mybaby', 'last_used', '2025-01-17 03:28:23'),
(906, 26, 'mybaby', 'fcm_token', 'dh50-emmRSmaiVY4fFPjZB:APA91bG2qSfq_KyA1m8xP4glhlo6oJqEL8YBAGVYVypXrkC6y82U1As7ZGgcFKrvN7sDcKdNSwF4EbkSTQGhzLWeuIjqHxc2aYv-lLQ6Go50rcmxZn8As3M'),
(907, 26, 'mybaby', 'user_id', '80'),
(908, 26, 'mybaby', 'app_version', ''),
(917, 14, 'mybaby', 'last_used', '2025-01-23 20:02:55'),
(918, 14, 'mybaby', 'fcm_token', 'd97xxvwFVUvclh2KWXD82H:APA91bFCWhZOcXwbIm9MSGmTJMfFW8brGhvk3g874tK0LY4Qc_A6nXF4ECycZluAsTicH1b6hGxxnkJ6ZTkCBmBaF6DyMUpyLDRpruJwrt3-Gr0_lUhbwRE'),
(919, 14, 'mybaby', 'user_id', '68'),
(920, 14, 'mybaby', 'app_version', '1.3'),
(925, 17, 'mybaby', 'last_used', '2025-01-26 08:47:16'),
(926, 17, 'mybaby', 'fcm_token', ''),
(927, 17, 'mybaby', 'user_id', '66'),
(928, 17, 'mybaby', 'app_version', '1.3'),
(933, 28, 'mybaby', 'last_used', '2025-01-29 13:01:59'),
(934, 28, 'mybaby', 'fcm_token', 'frmAY-zzO0cItmbgpEdsDN:APA91bHq9DwccCEFgba8VEsPy0C2Qa9--wyv88cYmVld20DdmP03iMow4a0ROrDyhj-KQ0CohB7rOoNxalEEqhsJmLBu72S7X-qBNzscpZWaYb3clP1_rN0'),
(935, 28, 'mybaby', 'user_id', '85'),
(936, 28, 'mybaby', 'app_version', '1.3');

-- --------------------------------------------------------

--
-- Table structure for table `feed`
--

CREATE TABLE `feed` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `grade_id` int(11) DEFAULT NULL,
  `caption` varchar(500) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'active',
  `create_time` timestamp NULL DEFAULT current_timestamp(),
  `update_time` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feed`
--

INSERT INTO `feed` (`id`, `user_id`, `grade_id`, `caption`, `status`, `create_time`, `update_time`) VALUES
(1, 1, 1, 'hello bros. this is my new feed post', 'active', '2024-10-15 17:04:16', '2024-10-15 17:05:03'),
(2, 1, 1, 'my 2nd post woohoo', 'active', '2024-10-15 19:05:24', '2024-10-15 19:05:24'),
(3, 1, 1, 'one post, 3 pics. waterfall is first', 'active', '2024-10-16 14:30:27', '2024-10-16 14:30:27'),
(4, 46, 40, 'يوم جميل لجوجو', 'active', '2024-11-17 17:12:25', '2024-11-17 17:12:25'),
(5, 46, 40, 'توبولو', 'active', '2024-11-17 19:11:46', '2024-11-17 19:11:46'),
(6, 46, 40, 'مقلوبة\nرأيك؟', 'active', '2024-12-11 17:42:29', '2024-12-11 17:42:29'),
(7, 46, 40, 'testt', 'active', '2024-12-12 20:36:11', '2024-12-12 20:36:11'),
(8, 46, 40, 'bdbdj', 'active', '2024-12-17 17:36:00', '2024-12-17 17:36:00'),
(9, 46, 40, 'يوم جميل', 'active', '2024-12-17 17:45:51', '2024-12-17 17:45:51'),
(10, 46, 40, 'سعادة', 'active', '2024-12-17 18:52:22', '2024-12-17 18:52:22'),
(11, 46, 40, 'نهاية يوم الأحد الجميل', 'active', '2024-12-17 18:53:10', '2024-12-17 18:53:10'),
(12, 65, 42, 'أحلى توأم', 'active', '2024-12-17 19:39:27', '2024-12-17 19:39:27'),
(13, 65, 42, 'How is it? ', 'active', '2024-12-18 13:34:12', '2024-12-18 13:34:12'),
(14, 65, 42, 'يوم تلوين جميل 😍😍👏🏽👏🏽', 'active', '2024-12-20 13:36:25', '2024-12-20 13:36:25'),
(15, 65, 43, 'Good Evening', 'active', '2024-12-24 13:51:29', '2024-12-24 13:51:29'),
(16, 65, 42, 'بابتسامة 💛', 'active', '2024-12-24 14:16:08', '2024-12-24 14:16:08'),
(17, 65, 42, 'عمل اليوم 👏🏽👏🏽', 'active', '2024-12-27 11:57:36', '2024-12-27 11:57:36'),
(18, 74, 45, 'الجو رائع', 'deleted', '2024-12-30 17:25:32', '2024-12-31 11:00:38'),
(19, 74, 45, 'يوم رائع مليان بالألعاب الحركية والإبداع 😍🌸🌸🌸', 'deleted', '2024-12-31 10:59:42', '2024-12-31 11:00:14'),
(20, 74, 45, '💜💜', 'deleted', '2024-12-31 11:01:32', '2025-01-01 17:48:54'),
(21, 74, 45, 'متحمسين لحصة اليوم ⭐️ ⭐️', 'active', '2025-01-01 15:51:26', '2025-01-01 15:51:26'),
(22, 74, 45, 'يوم جميل مليان لعب بالاجواء الجميلة😍😍', 'active', '2025-01-02 13:55:41', '2025-01-02 13:55:41'),
(23, 74, 45, ' We\'re excited for the party tomorrow to celebrate KG3!', 'active', '2025-01-02 13:58:26', '2025-01-02 13:58:26'),
(24, 74, 45, 'اعلان📣\nرحلة مدرسية🚌 الى مونكي بزنس⭐️ \n\nيوم الثلاثاء القادم باذن الله. فضلاً تعبئة الاستبيان المرفق', 'active', '2025-01-02 14:06:48', '2025-01-02 14:06:48'),
(25, 74, 45, 'استمتعنا كثيرًا باستكشاف أجزاء الشجرة عمليًا مع أطفالنا وتعلم كيف تنمو🌳🌳⭐️', 'active', '2025-01-03 09:42:34', '2025-01-03 09:42:34'),
(26, 76, 47, ' نرحب بكم في اليوم الأول', 'active', '2025-01-09 18:38:22', '2025-01-09 18:38:22'),
(27, 76, 47, 'رحلة الجمعة مع الأطفال البائعين.. ☀️', 'deleted', '2025-01-10 07:55:53', '2025-01-10 07:56:27'),
(28, 76, 47, 'في الطريق إلى رحلة الجمعة مع الأطفال الرائعين..☀️\n', 'active', '2025-01-10 08:03:42', '2025-01-10 08:03:42'),
(29, 76, 47, 'اليوم مع الوجبة حليب الكراميل اللذيذ', 'active', '2025-01-12 14:52:07', '2025-01-12 14:52:07'),
(30, 74, 45, 'سنحتفل بالثقافة اليابانية الاسبوع المقبل ان شاءالله 😍🎎🍣🍱 ', 'active', '2025-01-13 20:26:41', '2025-01-13 20:26:41'),
(31, 74, 45, 'يوم  الطفل العالمي', 'active', '2025-01-13 20:42:33', '2025-01-13 20:42:33'),
(32, 74, 45, 'ABC🎵', 'active', '2025-01-13 20:43:02', '2025-01-13 20:43:02'),
(33, 74, 45, '🧑‍🍳 الطباخين الصغار ', 'active', '2025-01-13 20:43:29', '2025-01-13 20:43:29'),
(34, 74, 45, '🍃', 'active', '2025-01-13 20:45:12', '2025-01-13 20:45:12'),
(35, 67, 42, 'Hey', 'active', '2025-01-23 17:00:27', '2025-01-23 17:00:27'),
(36, 84, 49, 'Testing Feed Student is Playing Games', 'active', '2025-01-29 08:32:45', '2025-01-29 08:32:45');

-- --------------------------------------------------------

--
-- Table structure for table `feed_comments`
--

CREATE TABLE `feed_comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `feed_id` int(11) DEFAULT NULL,
  `comment` varchar(500) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT current_timestamp(),
  `update_time` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feed_comments`
--

INSERT INTO `feed_comments` (`id`, `user_id`, `student_id`, `feed_id`, `comment`, `create_time`, `update_time`) VALUES
(1, 2, 1, 1, 'nice post. 10 out of 10', '2024-10-15 17:33:41', '2024-10-15 18:00:46'),
(2, 2, 1, 1, 'i didn\'t like it at all', '2024-10-15 17:33:41', '2024-10-15 18:00:47'),
(3, 1, NULL, 1, 'hello both', '2024-10-15 18:29:23', '2024-10-15 18:34:26'),
(4, 1, 1, 1, 'assign', '2024-10-15 18:33:27', '2024-10-15 18:33:27'),
(5, 1, 1, 2, 'hello', '2024-10-15 19:08:20', '2024-10-15 19:08:20'),
(6, 1, NULL, 3, 'meta legal comment', '2024-10-16 15:10:58', '2024-10-16 15:10:58'),
(7, 1, NULL, 3, 'second comm', '2024-10-16 15:11:42', '2024-10-16 15:11:42'),
(8, 2, 2, 3, 'test comment from an', '2024-10-16 16:26:45', '2024-10-16 16:26:45'),
(9, 2, 1, 3, 'Abdullah here', '2024-10-16 16:26:59', '2024-10-16 16:26:59'),
(10, 1, NULL, 3, 'test', '2024-10-17 20:46:53', '2024-10-17 20:46:53'),
(11, 2, 1, 3, 'hello world', '2024-10-17 21:22:48', '2024-10-17 21:22:48'),
(12, 2, 2, 3, 'has him', '2024-10-25 23:21:25', '2024-10-25 23:21:25'),
(13, 2, 2, 3, 'tgdfgdf', '2024-10-25 23:30:07', '2024-10-25 23:30:07'),
(14, 46, NULL, 4, '????????', '2024-11-17 18:12:12', '2024-11-17 18:12:12'),
(15, 46, NULL, 4, 'رروو', '2024-11-17 18:56:41', '2024-11-17 18:56:41'),
(16, 54, 12, 5, 'nnn', '2024-12-10 00:57:22', '2024-12-10 00:57:22'),
(17, 54, 12, 4, 'جميللل', '2024-12-10 00:57:51', '2024-12-10 00:57:51'),
(18, 54, 12, 5, 'gigg', '2024-12-10 08:41:30', '2024-12-10 08:41:30'),
(19, 54, 12, 5, 'زاناف', '2024-12-11 12:27:25', '2024-12-11 12:27:25'),
(20, 54, 12, 5, 'السلام عليكم ', '2024-12-11 12:34:39', '2024-12-11 12:34:39'),
(21, 54, 12, 6, 'ok', '2024-12-12 08:22:35', '2024-12-12 08:22:35'),
(22, 46, 12, 7, 'okkkkk', '2024-12-12 20:37:59', '2024-12-12 20:37:59'),
(23, 54, 12, 7, 'ghfds', '2024-12-13 07:31:38', '2024-12-13 07:31:38'),
(24, 54, 12, 7, 'gfdxf', '2024-12-13 16:16:33', '2024-12-13 16:16:33'),
(25, 54, 12, 7, 'jfnf', '2024-12-13 16:38:57', '2024-12-13 16:38:57'),
(26, 54, 12, 7, 'vhjn', '2024-12-17 17:30:36', '2024-12-17 17:30:36'),
(27, 46, 12, 8, '❄️❄️????????', '2024-12-17 17:39:29', '2024-12-17 17:39:29'),
(28, 46, 12, 8, '????????1️⃣????????????????????????????????????????????????????????????????????????????????????????❤️‍????❤️‍????????????????️⚽️', '2024-12-17 17:40:01', '2024-12-17 17:40:01'),
(29, 46, 12, 6, '????????????????????????', '2024-12-17 17:41:14', '2024-12-17 17:41:14'),
(30, 54, 12, 9, 'ماشاء الله ????????????????????????', '2024-12-17 17:48:58', '2024-12-17 17:48:58'),
(31, 66, 15, 12, 'hi', '2024-12-18 13:13:30', '2024-12-18 13:13:30'),
(32, 66, 15, 12, 'hey', '2024-12-18 13:32:33', '2024-12-18 13:32:33'),
(33, 65, 15, 13, '❣️', '2024-12-18 13:34:45', '2024-12-18 13:34:45'),
(34, 65, 15, 13, '????????????????????????????', '2024-12-18 13:35:13', '2024-12-18 13:35:13'),
(35, 54, 12, 11, '👍🏽👍🏽👍🏽🧡🧡🧡🧡🤍🤍🤍🤍', '2024-12-19 17:31:38', '2024-12-19 17:31:38'),
(36, 66, 15, 13, '🩷🆚❤️‍🩹🔥🤩⚽️🩵⚽️❤️‍🩹🆚🏳️🤍🥶👍🏽🥶🆚❤️‍🩹🆚🥶🤍🥶🥶🥶🏳️😍😍💛😂🏳️😂❤️‍🩹', '2024-12-19 17:47:01', '2024-12-19 17:47:01'),
(37, 65, 15, 12, 'ماشاء الله', '2024-12-20 13:34:22', '2024-12-20 13:34:22'),
(38, 65, 15, 14, 'ماشاء الله تبارك الله 🧡🧡', '2024-12-20 13:37:53', '2024-12-20 13:37:53'),
(39, 70, 18, 14, 'حفظكم الله', '2024-12-20 18:19:08', '2024-12-20 18:19:08'),
(40, 70, 18, 14, 'روعة', '2024-12-23 11:38:31', '2024-12-23 11:38:31'),
(41, 65, 15, 15, 'hey everyone', '2024-12-24 13:51:50', '2024-12-24 13:51:50'),
(42, 65, 18, 14, 'جميل 👏🏽👏🏽', '2024-12-24 14:00:17', '2024-12-24 14:00:17'),
(43, 65, 18, 15, 'ماشاء الله', '2024-12-24 14:01:09', '2024-12-24 14:01:09'),
(44, 65, 18, 14, '👍🏽👍🏽', '2024-12-24 14:01:52', '2024-12-24 14:01:52'),
(45, 65, 18, 14, '👏🏽👏🏽✔️', '2024-12-24 14:02:19', '2024-12-24 14:02:19'),
(46, 65, 18, 16, '👏🏽👏🏽👏🏽', '2024-12-24 14:16:25', '2024-12-24 14:16:25'),
(47, 65, NULL, 16, 'test', '2024-12-25 15:05:20', '2024-12-25 15:05:20'),
(48, 65, NULL, 16, 'رائع', '2024-12-27 07:34:02', '2024-12-27 07:34:02'),
(49, 65, NULL, 17, '👏🏽👏🏽', '2024-12-27 12:01:53', '2024-12-27 12:01:53'),
(50, 65, NULL, 14, '💛💛💛', '2024-12-27 13:06:22', '2024-12-27 13:06:22'),
(51, 75, 19, 18, 'ماشاء الله 👏🏽👏🏽', '2024-12-30 17:26:37', '2024-12-30 17:26:37'),
(52, 74, NULL, 18, '👍🏻اتفق', '2024-12-30 17:27:13', '2024-12-30 17:27:13'),
(53, 75, 19, 20, '👏🏽👏🏽', '2024-12-31 11:01:57', '2024-12-31 11:01:57'),
(54, 75, 19, 21, 'جداً ', '2025-01-01 20:11:49', '2025-01-01 20:11:49'),
(55, 75, 19, 21, '☀️☀️☀️', '2025-01-01 20:11:57', '2025-01-01 20:11:57'),
(56, 75, 19, 22, '👍🏽👍🏽👍🏽👏🏽👏🏽', '2025-01-02 14:37:10', '2025-01-02 14:37:10'),
(57, 75, 19, 23, '☀️☀️☀️', '2025-01-02 14:37:28', '2025-01-02 14:37:28'),
(58, 75, 19, 24, '🎉🎉🎉🎉', '2025-01-02 14:37:47', '2025-01-02 14:37:47'),
(59, 75, 19, 25, '👏🏽👏🏽👏🏽👏🏽☀️☀️☀️', '2025-01-03 17:32:46', '2025-01-03 17:32:46'),
(60, 70, 18, 16, 'ماشاء الله 🧡🧡🧡', '2025-01-09 14:52:42', '2025-01-09 14:52:42'),
(61, 76, NULL, 26, 'سعدنا بكم 💚', '2025-01-09 18:39:02', '2025-01-09 18:39:02'),
(62, 77, 20, 26, 'الله يسعدك استاذة علياء ', '2025-01-09 18:46:43', '2025-01-09 18:46:43'),
(63, 77, 20, 26, '🥰', '2025-01-09 18:46:51', '2025-01-09 18:46:51'),
(64, 77, 20, 28, 'شاكر ومقدر استاذه علياء ', '2025-01-12 14:40:35', '2025-01-12 14:40:35'),
(65, 77, 20, 28, 'ارسلي صور للرحله لاهنتي اول بأول ', '2025-01-12 14:41:00', '2025-01-12 14:41:00'),
(66, 74, NULL, 34, '', '2025-01-15 19:52:19', '2025-01-15 19:52:19'),
(67, 66, 15, 17, 'abc', '2025-01-23 16:53:29', '2025-01-23 16:53:29');

-- --------------------------------------------------------

--
-- Table structure for table `feed_likes`
--

CREATE TABLE `feed_likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `feed_id` int(11) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT current_timestamp(),
  `update_time` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feed_likes`
--

INSERT INTO `feed_likes` (`id`, `user_id`, `student_id`, `feed_id`, `create_time`, `update_time`) VALUES
(14, 1, NULL, 1, '2024-10-16 15:15:28', '2024-10-16 15:15:28'),
(15, 1, NULL, 3, '2024-10-16 15:15:58', '2024-10-16 15:15:58'),
(22, 2, 1, 3, '2024-10-17 21:23:02', '2024-10-17 21:23:02'),
(46, 46, 12, 6, '2024-12-13 18:51:33', '2024-12-13 18:51:33'),
(47, 46, 12, 5, '2024-12-13 18:51:39', '2024-12-13 18:51:39'),
(64, 54, 12, 5, '2024-12-17 17:30:12', '2024-12-17 17:30:12'),
(65, 54, 12, 6, '2024-12-17 17:30:16', '2024-12-17 17:30:16'),
(67, 54, 12, 7, '2024-12-17 17:30:32', '2024-12-17 17:30:32'),
(75, 46, 12, 7, '2024-12-17 17:36:46', '2024-12-17 17:36:46'),
(76, 46, 12, 8, '2024-12-17 17:39:12', '2024-12-17 17:39:12'),
(77, 54, 12, 9, '2024-12-17 18:49:23', '2024-12-17 18:49:23'),
(85, 65, NULL, 13, '2024-12-20 09:52:31', '2024-12-20 09:52:31'),
(86, 65, 15, 12, '2024-12-20 13:34:16', '2024-12-20 13:34:16'),
(87, 70, 18, 14, '2024-12-20 18:18:24', '2024-12-20 18:18:24'),
(88, 70, 18, 12, '2024-12-23 11:38:42', '2024-12-23 11:38:42'),
(89, 65, 18, 14, '2024-12-24 14:00:04', '2024-12-24 14:00:04'),
(90, 65, 18, 15, '2024-12-24 14:20:16', '2024-12-24 14:20:16'),
(91, 65, 18, 16, '2024-12-24 14:20:27', '2024-12-24 14:20:27'),
(96, 65, NULL, 17, '2024-12-29 03:30:12', '2024-12-29 03:30:12'),
(97, 75, 19, 18, '2024-12-30 17:26:09', '2024-12-30 17:26:09'),
(98, 75, 19, 20, '2024-12-31 11:01:50', '2024-12-31 11:01:50'),
(99, 75, 19, 21, '2025-01-01 17:48:18', '2025-01-01 17:48:18'),
(100, 75, 19, 22, '2025-01-02 14:37:00', '2025-01-02 14:37:00'),
(101, 75, 19, 23, '2025-01-02 14:37:23', '2025-01-02 14:37:23'),
(102, 75, 19, 24, '2025-01-02 14:37:36', '2025-01-02 14:37:36'),
(108, 75, 19, 25, '2025-01-08 19:45:33', '2025-01-08 19:45:33'),
(111, 66, 15, 16, '2025-01-09 07:14:12', '2025-01-09 07:14:12'),
(117, 70, 18, 17, '2025-01-09 15:40:50', '2025-01-09 15:40:50'),
(119, 76, 15, 26, '2025-01-09 18:38:37', '2025-01-09 18:38:37'),
(120, 77, 20, 26, '2025-01-09 18:46:26', '2025-01-09 18:46:26'),
(121, 77, 20, 28, '2025-01-12 14:40:19', '2025-01-12 14:40:19'),
(122, 70, 18, 16, '2025-01-12 23:39:42', '2025-01-12 23:39:42'),
(123, 74, 15, 33, '2025-01-14 07:13:15', '2025-01-14 07:13:15'),
(124, 74, 15, 34, '2025-01-14 07:13:19', '2025-01-14 07:13:19'),
(125, 66, 15, 17, '2025-01-23 16:53:24', '2025-01-23 16:53:24');

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

CREATE TABLE `grade` (
  `id` int(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL COMMENT 'user table',
  `title` varchar(255) DEFAULT NULL,
  `per_hour_rate` int(11) DEFAULT 1 COMMENT 'The default value for per hour rate will be taken from here'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grade`
--

INSERT INTO `grade` (`id`, `school_id`, `title`, `per_hour_rate`) VALUES
(1, 7, 'Grade 1', 1),
(37, 7, 'Grade 2', 1),
(38, 7, 'Grade 3', 1),
(39, 44, 'Grade 1', 1),
(40, 44, 'KG2', 1),
(42, 64, 'KG5', 1),
(43, 64, 'كيجي 5\r\n\r\n\r\n\r\n\r\n', 2),
(44, 64, 'KG1', 1),
(45, 72, 'Kg2', 1),
(46, 64, 'KG1', 1),
(47, 64, 'KG5b', 1),
(48, 81, 'Kindergarden', 1),
(49, 83, 'Grade 1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `grade_ratio`
--

CREATE TABLE `grade_ratio` (
  `id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `teacher_ratio` int(11) NOT NULL DEFAULT 1,
  `student_ratio` int(11) NOT NULL DEFAULT 4,
  `create_time` datetime DEFAULT current_timestamp(),
  `update_time` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grade_ratio`
--

INSERT INTO `grade_ratio` (`id`, `grade_id`, `teacher_ratio`, `student_ratio`, `create_time`, `update_time`) VALUES
(2, 1, 1, 4, '2024-11-04 20:31:36', '2024-11-04 20:31:36'),
(3, 37, 1, 3, '2024-11-05 20:41:53', '2025-01-09 14:09:54'),
(4, 38, 1, 4, '2024-11-06 20:26:21', '2024-11-06 20:26:21'),
(5, 40, 1, 4, '2024-11-16 20:43:19', '2024-11-16 20:43:19'),
(7, 42, 1, 4, '2024-12-17 19:05:50', '2024-12-17 19:05:50'),
(8, 44, 1, 4, '2024-12-30 14:43:06', '2024-12-30 11:43:06'),
(9, 45, 1, 4, '2024-12-30 15:07:37', '2024-12-30 12:07:37'),
(10, 46, 1, 4, '2025-01-05 11:11:56', '2025-01-05 08:11:56'),
(11, 47, 1, 4, '2025-01-05 22:11:14', '2025-01-05 19:11:14'),
(16, 48, 1, 4, '2025-01-27 16:10:24', '2025-01-27 13:10:24'),
(17, 49, 1, 10, '2025-01-29 10:40:10', '2025-01-29 07:40:10');

-- --------------------------------------------------------

--
-- Table structure for table `grade_teacher`
--

CREATE TABLE `grade_teacher` (
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `grade_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grade_teacher`
--

INSERT INTO `grade_teacher` (`id`, `school_id`, `grade_id`, `teacher_id`) VALUES
(1, 7, 1, 2),
(2, 7, 37, 2),
(3, 7, 1, 1),
(11, 7, 37, 42),
(12, 7, 38, 42),
(14, 44, 40, 46),
(17, 64, 42, 65),
(18, 64, 43, 65),
(19, 64, 42, 67),
(20, 64, 43, 67),
(21, 64, 43, 69),
(22, 64, 44, 71),
(23, 72, 45, 74),
(24, 64, 47, 65),
(25, 64, 47, 67),
(26, 64, 47, 64),
(27, 64, 47, 76),
(28, 64, 47, 78),
(29, 64, 47, 80),
(30, 81, 48, 82),
(31, 83, 49, 84);

-- --------------------------------------------------------

--
-- Table structure for table `grade_teacher_schedule`
--

CREATE TABLE `grade_teacher_schedule` (
  `id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `day_of_week` enum('monday','tuesday','wednesday','thursday','friday','saturday','sunday') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `start_date` datetime NOT NULL DEFAULT current_timestamp(),
  `end_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grade_teacher_schedule`
--

INSERT INTO `grade_teacher_schedule` (`id`, `grade_id`, `teacher_id`, `day_of_week`, `start_time`, `end_time`, `start_date`, `end_date`) VALUES
(48, 37, 42, 'monday', '09:00:00', '10:00:00', '2024-12-01 00:00:00', '2024-12-30 00:00:00'),
(49, 37, 42, 'tuesday', '09:00:00', '10:00:00', '2024-12-01 00:00:00', '2024-12-30 00:00:00'),
(50, 37, 42, 'wednesday', '09:00:00', '10:00:00', '2024-12-01 00:00:00', '2024-12-30 00:00:00'),
(51, 37, 42, 'thursday', '09:00:00', '10:00:00', '2024-12-01 00:00:00', '2024-12-30 00:00:00'),
(52, 37, 42, 'sunday', '09:00:00', '10:00:00', '2024-12-01 00:00:00', '2024-12-30 00:00:00'),
(53, 38, 42, 'monday', '10:00:00', '11:00:00', '2024-12-10 00:00:00', '2025-01-10 00:00:00'),
(54, 38, 42, 'tuesday', '10:00:00', '11:00:00', '2024-12-10 00:00:00', '2025-01-10 00:00:00'),
(55, 38, 42, 'wednesday', '10:00:00', '11:00:00', '2024-12-10 00:00:00', '2025-01-10 00:00:00'),
(56, 38, 42, 'thursday', '10:00:00', '11:00:00', '2024-12-10 00:00:00', '2025-01-10 00:00:00'),
(57, 38, 42, 'saturday', '10:00:00', '11:00:00', '2024-12-10 00:00:00', '2025-01-10 00:00:00'),
(58, 38, 42, 'sunday', '10:00:00', '11:00:00', '2024-12-10 00:00:00', '2025-01-10 00:00:00'),
(59, 38, 42, 'sunday', '11:00:00', '12:00:00', '2024-12-10 00:00:00', '2025-01-10 00:00:00'),
(61, 40, 46, 'monday', '07:00:00', '08:00:00', '2024-11-11 00:00:00', '2024-11-30 00:00:00'),
(62, 40, 46, 'monday', '08:00:00', '09:00:00', '2024-11-11 00:00:00', '2024-11-30 00:00:00'),
(63, 40, 46, 'monday', '09:00:00', '10:00:00', '2024-11-11 00:00:00', '2024-11-30 00:00:00'),
(64, 40, 46, 'thursday', '16:00:00', '17:00:00', '2024-11-11 00:00:00', '2024-11-30 00:00:00'),
(65, 1, 1, 'monday', '09:00:00', '10:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(66, 1, 1, 'monday', '10:00:00', '11:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(67, 1, 1, 'monday', '11:00:00', '12:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(68, 1, 1, 'monday', '12:00:00', '13:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(69, 1, 1, 'monday', '13:00:00', '14:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(70, 1, 1, 'monday', '14:00:00', '15:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(71, 1, 1, 'monday', '15:00:00', '16:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(72, 1, 1, 'tuesday', '09:00:00', '10:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(73, 1, 1, 'tuesday', '10:00:00', '11:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(74, 1, 1, 'tuesday', '11:00:00', '12:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(75, 1, 1, 'tuesday', '12:00:00', '13:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(76, 1, 1, 'tuesday', '13:00:00', '14:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(77, 1, 1, 'tuesday', '14:00:00', '15:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(78, 1, 1, 'tuesday', '15:00:00', '16:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(79, 1, 1, 'wednesday', '08:00:00', '09:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(80, 1, 1, 'wednesday', '09:00:00', '10:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(81, 1, 1, 'wednesday', '10:00:00', '11:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(82, 1, 1, 'wednesday', '11:00:00', '12:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(83, 1, 1, 'wednesday', '12:00:00', '13:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(84, 1, 1, 'wednesday', '13:00:00', '14:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(85, 1, 1, 'thursday', '09:00:00', '10:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(86, 1, 1, 'thursday', '10:00:00', '11:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(87, 1, 1, 'thursday', '11:00:00', '12:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(88, 1, 1, 'thursday', '12:00:00', '13:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(89, 1, 1, 'sunday', '09:00:00', '10:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(90, 1, 1, 'sunday', '10:00:00', '11:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(91, 1, 1, 'sunday', '11:00:00', '12:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(92, 1, 1, 'sunday', '12:00:00', '13:00:00', '2024-11-01 00:00:00', '2024-12-31 00:00:00'),
(102, 42, 65, 'monday', '08:00:00', '09:00:00', '2024-12-08 00:00:00', '2024-12-25 00:00:00'),
(103, 42, 65, 'monday', '09:00:00', '10:00:00', '2024-12-08 00:00:00', '2024-12-25 00:00:00'),
(104, 42, 65, 'thursday', '10:00:00', '11:00:00', '2024-12-08 00:00:00', '2024-12-25 00:00:00'),
(105, 43, 65, 'monday', '06:00:00', '07:00:00', '2025-01-01 00:00:00', '2025-01-10 00:00:00'),
(106, 43, 65, 'monday', '07:00:00', '08:00:00', '2025-01-01 00:00:00', '2025-01-10 00:00:00'),
(107, 43, 65, 'wednesday', '09:00:00', '10:00:00', '2025-01-01 00:00:00', '2025-01-10 00:00:00'),
(108, 47, 65, 'monday', '06:00:00', '07:00:00', '2025-01-03 00:00:00', '2025-01-10 00:00:00'),
(109, 47, 65, 'monday', '07:00:00', '08:00:00', '2025-01-03 00:00:00', '2025-01-10 00:00:00'),
(110, 47, 65, 'monday', '08:00:00', '09:00:00', '2025-01-03 00:00:00', '2025-01-10 00:00:00'),
(111, 47, 65, 'wednesday', '09:00:00', '10:00:00', '2025-01-03 00:00:00', '2025-01-10 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `create_time` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `school_id`, `name`, `create_time`) VALUES
(1, 7, 'Test shavi1', '2024-11-11 18:42:00'),
(2, 7, 'Test1', '2024-11-11 18:42:10'),
(3, 7, 'Parent Teacher Meeting', '2024-11-11 19:46:57'),
(4, 7, 'Midnight talks', '2024-11-12 03:57:07'),
(5, 7, 'WHY Cafe', '2024-11-13 19:24:30'),
(6, 44, 'Kg2Chat', '2024-11-17 17:14:20'),
(7, 64, 'مناقشة مواعيد الحفل', '2024-12-17 19:21:41'),
(8, 64, 'Parent Teacher Meeting', '2024-12-19 17:25:07'),
(9, 5, 'Mini 2', '2024-12-29 05:55:06'),
(10, 64, 'تجربة ٣', '2024-12-29 06:02:40'),
(11, 64, 'تسليم الشهادات', '2024-12-30 11:57:46'),
(12, 72, 'welcome ', '2024-12-30 12:35:35');

-- --------------------------------------------------------

--
-- Table structure for table `group_members`
--

CREATE TABLE `group_members` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_time` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `group_members`
--

INSERT INTO `group_members` (`id`, `group_id`, `user_id`, `create_time`) VALUES
(11, 1, 7, '2024-11-11 18:42:00'),
(12, 2, 7, '2024-11-11 18:42:10'),
(13, 2, 2, '2024-11-11 19:46:05'),
(14, 2, 42, '2024-11-11 19:46:07'),
(15, 2, 43, '2024-11-11 19:46:09'),
(16, 3, 7, '2024-11-11 19:46:57'),
(17, 2, 1, '2024-11-11 18:42:10'),
(18, 3, 1, '2024-11-12 03:38:34'),
(19, 4, 7, '2024-11-12 03:57:07'),
(20, 4, 1, '2024-11-12 03:57:27'),
(21, 5, 7, '2024-11-13 19:24:30'),
(22, 5, 1, '2024-11-13 19:24:39'),
(23, 6, 44, '2024-11-17 17:14:20'),
(24, 6, 46, '2024-11-17 17:14:38'),
(25, 6, 54, '2024-11-17 18:50:02'),
(26, 7, 64, '2024-12-17 19:21:41'),
(27, 7, 65, '2024-12-17 19:21:55'),
(28, 7, 66, '2024-12-17 19:21:58'),
(29, 8, 64, '2024-12-19 17:25:07'),
(30, 8, 65, '2024-12-19 17:25:17'),
(31, 8, 66, '2024-12-19 17:25:19'),
(32, 8, 67, '2024-12-19 17:25:22'),
(33, 8, 68, '2024-12-19 17:25:23'),
(34, 10, 64, '2024-12-29 06:02:40'),
(35, 10, 65, '2024-12-29 06:02:52'),
(36, 10, 70, '2024-12-29 06:03:48'),
(37, 11, 64, '2024-12-30 11:57:46'),
(38, 11, 65, '2024-12-30 11:58:02'),
(40, 12, 72, '2024-12-30 12:35:35'),
(41, 12, 74, '2024-12-30 12:36:18');

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `model` varchar(255) DEFAULT NULL COMMENT 'user, order, product, etc.',
  `model_id` int(11) DEFAULT NULL,
  `category` varchar(500) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `image_src` varchar(255) DEFAULT NULL,
  `thumb_src` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT current_timestamp(),
  `update_time` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `model`, `model_id`, `category`, `filename`, `image_src`, `thumb_src`, `description`, `create_time`, `update_time`) VALUES
(1, 'feed', 1, NULL, '670e766033424.jpg', 'uploads/feed/670e766033424.jpg', NULL, NULL, '2024-10-15 17:04:16', '2024-10-15 17:04:16'),
(2, 'feed', 2, NULL, '670e92c517aac.jpg', 'uploads/feed/670e92c517aac.jpg', NULL, NULL, '2024-10-15 19:05:25', '2024-10-15 19:05:25'),
(3, 'feed', 2, NULL, '670e92c518163.jpg', 'uploads/feed/670e92c518163.jpg', NULL, NULL, '2024-10-15 19:05:25', '2024-10-15 19:05:25'),
(4, 'feed', 3, NULL, '670fa3d427420.jpg', 'uploads/feed/670fa3d427420.jpg', NULL, NULL, '2024-10-16 14:30:28', '2024-10-16 14:30:28'),
(5, 'feed', 3, NULL, '670fa3d427713.jpg', 'uploads/feed/670fa3d427713.jpg', NULL, NULL, '2024-10-16 14:30:28', '2024-10-16 14:30:28'),
(6, 'feed', 3, NULL, '670fa3d4277ae.jpg', 'uploads/feed/670fa3d4277ae.jpg', NULL, NULL, '2024-10-16 14:30:28', '2024-10-16 14:30:28'),
(7, 'user', 2, NULL, '671147a906a95.jpg', 'uploads/user/671147a906a95.jpg', NULL, NULL, '2024-10-17 20:21:45', '2024-10-17 20:21:45'),
(8, 'user', 2, NULL, '67114806cde05.jpg', 'uploads/user/67114806cde05.jpg', NULL, NULL, '2024-10-17 20:23:18', '2024-10-17 20:23:18'),
(9, 'student', 1, NULL, '671155ea301ec.jpg', 'uploads/user/671155ea301ec.jpg', NULL, NULL, '2024-10-17 20:27:41', '2024-10-17 21:22:34'),
(10, 'student', 2, NULL, '67114bd43e93f.jpg', 'uploads/user/67114bd43e93f.jpg', NULL, NULL, '2024-10-17 20:30:03', '2024-10-17 20:39:32'),
(12, 'user', 1, NULL, '67114d861231e.jpg', 'uploads/user/67114d861231e.jpg', NULL, NULL, '2024-10-17 20:39:56', '2024-10-17 20:46:46'),
(15, 'user', 26, NULL, '6728f80257f49.jpg', 'uploads/user/6728f80257f49.jpg', NULL, NULL, '2024-11-04 19:36:18', '2024-11-04 19:36:18'),
(16, 'feed', 4, NULL, '673a23fb4c449.png', 'uploads/feed/673a23fb4c449.png', NULL, NULL, '2024-11-17 17:12:27', '2024-11-17 17:12:27'),
(17, 'feed', 5, NULL, '673a3ff36dbff.png', 'uploads/feed/673a3ff36dbff.png', NULL, NULL, '2024-11-17 19:11:47', '2024-11-17 19:11:47'),
(18, 'user', 54, NULL, '675791d854eaa.jpg', 'uploads/user/675791d854eaa.jpg', NULL, NULL, '2024-12-10 00:56:56', '2024-12-10 00:56:56'),
(19, 'user', 54, NULL, '6759711f0beaf.jpg', 'uploads/user/6759711f0beaf.jpg', NULL, NULL, '2024-12-11 11:01:51', '2024-12-11 11:01:51'),
(20, 'student', 12, NULL, '675973408d843.jpg', 'uploads/user/675973408d843.jpg', NULL, NULL, '2024-12-11 11:10:56', '2024-12-11 11:10:56'),
(21, 'user', 54, NULL, '67598fa7c0780.png', 'uploads/user/67598fa7c0780.png', NULL, NULL, '2024-12-11 13:12:07', '2024-12-11 13:12:07'),
(22, 'feed', 6, NULL, '6759cf07f2833.png', 'uploads/feed/6759cf07f2833.png', NULL, NULL, '2024-12-11 17:42:31', '2024-12-11 17:42:31'),
(23, 'student', 12, NULL, '675a9b23558cd.png', 'uploads/user/675a9b23558cd.png', NULL, NULL, '2024-12-12 08:13:23', '2024-12-12 08:13:23'),
(24, 'user', 46, NULL, '675b48c9d9154.png', 'uploads/user/675b48c9d9154.png', NULL, NULL, '2024-12-12 20:34:17', '2024-12-12 20:34:17'),
(25, 'feed', 7, NULL, '675b493dbe525.png', 'uploads/feed/675b493dbe525.png', NULL, NULL, '2024-12-12 20:36:13', '2024-12-12 20:36:13'),
(26, 'student', 12, NULL, '675be30068188.jpg', 'uploads/user/675be30068188.jpg', NULL, NULL, '2024-12-13 07:32:16', '2024-12-13 07:32:16'),
(27, 'feed', 8, NULL, '6761b683e6cae.png', 'uploads/feed/6761b683e6cae.png', NULL, NULL, '2024-12-17 17:36:03', '2024-12-17 17:36:03'),
(28, 'feed', 9, NULL, '6761b8d5c7977.jpg', 'uploads/feed/6761b8d5c7977.jpg', NULL, NULL, '2024-12-17 17:45:57', '2024-12-17 17:45:57'),
(29, 'feed', 9, NULL, '6761b8d5c7b55.jpg', 'uploads/feed/6761b8d5c7b55.jpg', NULL, NULL, '2024-12-17 17:45:57', '2024-12-17 17:45:57'),
(30, 'feed', 10, NULL, '6761c86826d73.png', 'uploads/feed/6761c86826d73.png', NULL, NULL, '2024-12-17 18:52:24', '2024-12-17 18:52:24'),
(31, 'feed', 11, NULL, '6761c89807aeb.jpg', 'uploads/feed/6761c89807aeb.jpg', NULL, NULL, '2024-12-17 18:53:12', '2024-12-17 18:53:12'),
(32, 'feed', 11, NULL, '6761c89807d23.jpg', 'uploads/feed/6761c89807d23.jpg', NULL, NULL, '2024-12-17 18:53:12', '2024-12-17 18:53:12'),
(33, 'feed', 11, NULL, '6761c89807f67.png', 'uploads/feed/6761c89807f67.png', NULL, NULL, '2024-12-17 18:53:12', '2024-12-17 18:53:12'),
(34, 'feed', 11, NULL, '6761c89808987.jpg', 'uploads/feed/6761c89808987.jpg', NULL, NULL, '2024-12-17 18:53:12', '2024-12-17 18:53:12'),
(35, 'student', 15, NULL, '6761cd6214001.jpg', 'uploads/user/6761cd6214001.jpg', NULL, NULL, '2024-12-17 19:13:38', '2024-12-17 19:13:38'),
(36, 'user', 65, NULL, '6761d33d8b877.jpg', 'uploads/user/6761d33d8b877.jpg', NULL, NULL, '2024-12-17 19:38:37', '2024-12-17 19:38:37'),
(37, 'feed', 12, NULL, '6761d370ba6de.jpg', 'uploads/feed/6761d370ba6de.jpg', NULL, NULL, '2024-12-17 19:39:28', '2024-12-17 19:39:28'),
(38, 'feed', 12, NULL, '6761d370ba986.jpg', 'uploads/feed/6761d370ba986.jpg', NULL, NULL, '2024-12-17 19:39:28', '2024-12-17 19:39:28'),
(39, 'feed', 13, NULL, '6762cf561e24d.jpg', 'uploads/feed/6762cf561e24d.jpg', NULL, NULL, '2024-12-18 13:34:14', '2024-12-18 13:34:14'),
(40, 'feed', 14, NULL, '676572db87a8c.png', 'uploads/feed/676572db87a8c.png', NULL, NULL, '2024-12-20 13:36:27', '2024-12-20 13:36:27'),
(41, 'feed', 15, NULL, '676abc6409e88.jpg', 'uploads/feed/676abc6409e88.jpg', NULL, NULL, '2024-12-24 13:51:32', '2024-12-24 13:51:32'),
(42, 'feed', 16, NULL, '676ac22951e75.jpg', 'uploads/feed/676ac22951e75.jpg', NULL, NULL, '2024-12-24 14:16:09', '2024-12-24 14:16:09'),
(43, 'feed', 17, NULL, '676e96389df44.jpg', 'uploads/feed/676e96389df44.jpg', NULL, NULL, '2024-12-27 11:57:44', '2024-12-27 11:57:44'),
(44, 'feed', 17, NULL, '676e96389e27b.png', 'uploads/feed/676e96389e27b.png', NULL, NULL, '2024-12-27 11:57:44', '2024-12-27 11:57:44'),
(45, 'student', 19, NULL, '67729566da312.png', 'uploads/user/67729566da312.png', NULL, NULL, '2024-12-30 12:43:18', '2024-12-30 12:43:18'),
(46, 'feed', 18, NULL, '6772d78dd1c6a.jpg', 'uploads/feed/6772d78dd1c6a.jpg', NULL, NULL, '2024-12-30 17:25:33', '2024-12-30 17:25:33'),
(47, 'feed', 19, NULL, '6773cea0b15ff.jpg', 'uploads/feed/6773cea0b15ff.jpg', NULL, NULL, '2024-12-31 10:59:44', '2024-12-31 10:59:44'),
(48, 'feed', 20, NULL, '6773cf0de4afa.jpg', 'uploads/feed/6773cf0de4afa.jpg', NULL, NULL, '2024-12-31 11:01:33', '2024-12-31 11:01:33'),
(49, 'feed', 21, NULL, '6775647f92021.jpg', 'uploads/feed/6775647f92021.jpg', NULL, NULL, '2025-01-01 15:51:27', '2025-01-01 15:51:27'),
(50, 'feed', 22, NULL, '67769ade46c85.jpg', 'uploads/feed/67769ade46c85.jpg', NULL, NULL, '2025-01-02 13:55:42', '2025-01-02 13:55:42'),
(51, 'feed', 23, NULL, '67769b838c1cb.jpg', 'uploads/feed/67769b838c1cb.jpg', NULL, NULL, '2025-01-02 13:58:27', '2025-01-02 13:58:27'),
(52, 'feed', 24, NULL, '67769d78ee094.jpg', 'uploads/feed/67769d78ee094.jpg', NULL, NULL, '2025-01-02 14:06:48', '2025-01-02 14:06:48'),
(53, 'feed', 25, NULL, '6777b10b50276.jpg', 'uploads/feed/6777b10b50276.jpg', NULL, NULL, '2025-01-03 09:42:35', '2025-01-03 09:42:35'),
(54, 'feed', 26, NULL, '678017a523367.jpg', 'uploads/feed/678017a523367.jpg', NULL, NULL, '2025-01-09 18:38:29', '2025-01-09 18:38:29'),
(55, 'student', 20, NULL, '67801aa3163e1.jpg', 'uploads/user/67801aa3163e1.jpg', NULL, NULL, '2025-01-09 18:51:15', '2025-01-09 18:51:15'),
(56, 'feed', 27, NULL, '6780d28be5d2a.jpg', 'uploads/feed/6780d28be5d2a.jpg', NULL, NULL, '2025-01-10 07:55:55', '2025-01-10 07:55:55'),
(57, 'feed', 28, NULL, '6780d4610a017.jpg', 'uploads/feed/6780d4610a017.jpg', NULL, NULL, '2025-01-10 08:03:45', '2025-01-10 08:03:45'),
(58, 'feed', 29, NULL, '6783d71bba694.jpg', 'uploads/feed/6783d71bba694.jpg', NULL, NULL, '2025-01-12 14:52:11', '2025-01-12 14:52:11'),
(59, 'feed', 30, NULL, '67857707a288c.png', 'uploads/feed/67857707a288c.png', NULL, NULL, '2025-01-13 20:26:47', '2025-01-13 20:26:47'),
(60, 'feed', 30, NULL, '67857707a33a7.jpg', 'uploads/feed/67857707a33a7.jpg', NULL, NULL, '2025-01-13 20:26:47', '2025-01-13 20:26:47'),
(61, 'feed', 30, NULL, '67857707a41a4.png', 'uploads/feed/67857707a41a4.png', NULL, NULL, '2025-01-13 20:26:47', '2025-01-13 20:26:47'),
(62, 'feed', 31, NULL, '67857aba407b4.jpg', 'uploads/feed/67857aba407b4.jpg', NULL, NULL, '2025-01-13 20:42:34', '2025-01-13 20:42:34'),
(63, 'feed', 32, NULL, '67857ad77b423.jpg', 'uploads/feed/67857ad77b423.jpg', NULL, NULL, '2025-01-13 20:43:03', '2025-01-13 20:43:03'),
(64, 'feed', 33, NULL, '67857af26ea69.jpg', 'uploads/feed/67857af26ea69.jpg', NULL, NULL, '2025-01-13 20:43:30', '2025-01-13 20:43:30'),
(65, 'feed', 34, NULL, '67857b5937820.jpg', 'uploads/feed/67857b5937820.jpg', NULL, NULL, '2025-01-13 20:45:13', '2025-01-13 20:45:13'),
(66, 'feed', 35, NULL, '679275ad5d451.jpg', 'uploads/feed/679275ad5d451.jpg', NULL, NULL, '2025-01-23 17:00:29', '2025-01-23 17:00:29'),
(67, 'feed', 36, NULL, '6799e7b0397a8.png', 'uploads/feed/6799e7b0397a8.png', NULL, NULL, '2025-01-29 08:32:48', '2025-01-29 08:32:48');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `model` varchar(255) DEFAULT NULL,
  `model_id` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `color` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `create_time` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `group_id`, `sender_id`, `message`, `create_time`) VALUES
(9, 2, 7, 'Hey everyone', '2024-11-11 20:01:32'),
(10, 2, 42, 'Hello I am MYL', '2024-11-11 20:01:32'),
(11, 2, 42, 'Sorry, I am Yawar', '2024-11-11 20:04:24'),
(12, 2, 7, 'Kese ho sab?', '2024-11-11 22:17:55'),
(13, 2, 1, '2', '2024-11-12 00:22:21'),
(14, 2, 1, 'Fit', '2024-11-12 00:22:46'),
(15, 2, 1, 'Allah is shukr hai sb theek hain aap sunao less ho kahan ho Kia Chan Rhea hai etc etc etc?', '2024-11-12 00:24:27'),
(16, 2, 1, 'Allah is shukr hai sb theek hain aap sunao less ho kahan ho Kia Chan Rhea hai etc etc etc?\n\nAllah is shukr hai sb theek hain aap sunao less ho kahan ho Kia Chan Rhea hai etc etc etc?', '2024-11-12 00:24:48'),
(17, 2, 1, 'Hi', '2024-11-12 03:28:13'),
(18, 2, 7, '11', '2024-11-12 03:30:20'),
(19, 3, 7, 'Welcome to the group @myl', '2024-11-12 03:39:27'),
(20, 3, 1, 'Yo', '2024-11-12 03:55:45'),
(21, 4, 1, 'Heyyyy', '2024-11-12 03:57:45'),
(22, 4, 7, 'KOi hai?', '2024-11-12 03:58:07'),
(23, 4, 1, 'Hello', '2024-11-12 03:58:45'),
(24, 3, 7, 'Hi again', '2024-11-13 01:59:37'),
(25, 3, 7, 'Hi again1', '2024-11-13 01:59:50'),
(26, 3, 7, 'Hi again1', '2024-11-13 02:00:47'),
(27, 3, 7, 'Hi again2', '2024-11-13 02:04:45'),
(28, 3, 7, 'Hey bro', '2024-11-13 02:21:03'),
(29, 3, 7, 'YoOoOo', '2024-11-13 02:24:04'),
(30, 3, 7, 'Yes?', '2024-11-13 02:28:57'),
(31, 3, 7, 'Hellooooo?', '2024-11-13 02:30:34'),
(32, 3, 7, 'Suno', '2024-11-13 02:33:18'),
(33, 3, 7, 'kese ho?', '2024-11-13 02:33:28'),
(34, 3, 1, 'Fit', '2024-11-13 02:33:36'),
(35, 3, 7, 'Yawar here', '2024-11-13 02:36:36'),
(36, 3, 7, '??', '2024-11-13 02:36:43'),
(37, 3, 1, 'Yoo', '2024-11-13 02:36:51'),
(38, 3, 1, '11', '2024-11-13 02:39:01'),
(39, 3, 1, '22', '2024-11-13 02:40:25'),
(40, 3, 1, '3', '2024-11-13 02:43:03'),
(41, 3, 1, '4', '2024-11-13 02:54:33'),
(42, 3, 1, '5', '2024-11-13 02:55:27'),
(43, 3, 1, 'Hey', '2024-11-13 02:55:43'),
(44, 3, 1, 'Hi', '2024-11-13 02:55:44'),
(45, 3, 1, 'How', '2024-11-13 02:55:45'),
(46, 3, 1, 'Are', '2024-11-13 02:55:47'),
(47, 3, 1, 'You?', '2024-11-13 02:56:26'),
(48, 3, 7, 'bolo', '2024-11-13 02:56:37'),
(49, 5, 7, 'Hello', '2024-11-13 19:24:57'),
(50, 5, 7, 'hey', '2024-11-13 19:25:12'),
(51, 5, 7, 'hey', '2024-11-13 19:25:35'),
(52, 5, 7, 'yes?', '2024-11-13 19:28:27'),
(53, 5, 1, 'Hi', '2024-11-13 19:28:46'),
(54, 5, 1, 'Yooo', '2024-11-13 19:29:15'),
(55, 5, 7, 'hey', '2024-11-13 19:29:22'),
(56, 6, 44, 'hello]', '2024-11-17 17:14:50'),
(57, 6, 44, 'hello', '2024-11-17 17:14:52'),
(58, 6, 46, 'Hhhhggj', '2024-11-17 18:53:48'),
(59, 6, 54, 'Hhh', '2024-12-10 00:52:41'),
(60, 6, 44, 'ردخ', '2024-12-12 20:08:03'),
(61, 6, 44, '', '2024-12-12 20:08:06'),
(62, 6, 46, 'Hello', '2024-12-14 13:35:43'),
(63, 6, 46, '????????', '2024-12-17 17:42:15'),
(64, 6, 46, '????', '2024-12-17 17:42:17'),
(65, 6, 46, '????', '2024-12-17 17:42:19'),
(66, 6, 54, '????????????????', '2024-12-17 17:47:52'),
(67, 6, 54, 'السلام عليكم', '2024-12-17 17:47:59'),
(68, 6, 54, '????????', '2024-12-17 17:48:08'),
(69, 6, 54, '????????????????', '2024-12-17 17:48:09'),
(70, 6, 54, 'Ndbd', '2024-12-17 17:59:12'),
(71, 6, 46, 'Cfd', '2024-12-17 18:01:35'),
(72, 7, 64, 'السلام عليكم ', '2024-12-17 19:22:03'),
(73, 7, 64, 'السلام عليكم ', '2024-12-17 19:22:06'),
(74, 7, 64, 'كيف الحال', '2024-12-17 19:25:39'),
(75, 7, 64, 'كيف الحال', '2024-12-17 19:25:41'),
(76, 7, 65, 'اهلاً', '2024-12-17 19:37:23'),
(77, 7, 66, 'Hi', '2024-12-17 19:39:13'),
(78, 7, 66, 'Did you get the message?', '2024-12-17 19:39:34'),
(79, 7, 64, 'the teacher chat is working', '2024-12-17 19:39:59'),
(80, 7, 66, 'It should be working for the parent also', '2024-12-17 19:40:20'),
(81, 7, 65, 'Working the teacher side', '2024-12-17 19:40:26'),
(82, 7, 66, '????????', '2024-12-17 19:40:43'),
(83, 7, 65, 'Very very slow though', '2024-12-17 19:40:46'),
(84, 7, 66, 'Internet is slow maybe.', '2024-12-17 19:42:44'),
(85, 7, 66, 'No its not', '2024-12-18 14:22:11'),
(86, 7, 64, 'you sure?', '2024-12-18 14:22:27'),
(87, 6, 44, 'aa', '2024-12-18 17:51:25'),
(88, 6, 44, 'bb', '2024-12-18 17:57:14'),
(89, 6, 44, 'cc', '2024-12-18 17:57:23'),
(90, 6, 44, 'dd', '2024-12-18 17:57:31'),
(91, 6, 54, 'Ee', '2024-12-18 17:57:40'),
(92, 6, 44, 'ff', '2024-12-18 17:57:50'),
(93, 6, 54, 'Gg', '2024-12-18 17:57:50'),
(94, 6, 44, 'aa', '2024-12-18 18:10:18'),
(95, 7, 65, '????????', '2024-12-19 06:11:18'),
(96, 7, 65, 'U', '2024-12-19 06:11:25'),
(97, 7, 65, '????⚽️⚽️????⚽️????????????????????????????⚽️????⚽️', '2024-12-19 06:11:31'),
(98, 7, 66, 'Hey', '2024-12-19 12:39:22'),
(99, 7, 65, 'Hello', '2024-12-19 12:41:54'),
(100, 7, 65, 'How are you?', '2024-12-19 12:44:15'),
(101, 7, 65, '?', '2024-12-19 12:44:29'),
(102, 7, 66, 'Fine', '2024-12-19 12:44:38'),
(103, 7, 66, '?', '2024-12-19 12:47:29'),
(104, 7, 65, '..', '2024-12-19 12:47:39'),
(105, 7, 64, 'hello everyone', '2024-12-19 12:48:57'),
(106, 7, 64, 'This message is from you school', '2024-12-19 12:49:14'),
(107, 7, 64, 'your*', '2024-12-19 12:49:57'),
(108, 7, 64, '?', '2024-12-19 12:50:59'),
(109, 7, 64, '..', '2024-12-19 12:51:08'),
(110, 7, 66, 'A', '2024-12-19 12:57:28'),
(111, 7, 66, 'B', '2024-12-19 12:58:05'),
(112, 7, 64, 'C', '2024-12-19 13:01:00'),
(113, 7, 64, 'D', '2024-12-19 13:02:13'),
(114, 7, 64, 'DD', '2024-12-19 13:02:33'),
(115, 7, 66, 'Cc', '2024-12-19 13:09:13'),
(116, 7, 66, 'Ee', '2024-12-19 13:09:55'),
(117, 7, 66, 'K', '2024-12-19 13:10:04'),
(118, 7, 66, 'E', '2024-12-19 13:10:05'),
(119, 7, 66, 'S', '2024-12-19 13:10:06'),
(120, 7, 66, 'E', '2024-12-19 13:10:07'),
(121, 7, 66, 'H', '2024-12-19 13:10:12'),
(122, 7, 66, 'O', '2024-12-19 13:10:13'),
(123, 7, 66, '?', '2024-12-19 13:10:15'),
(124, 7, 64, 'Sshhhhh', '2024-12-19 13:10:33'),
(125, 7, 64, 'This chat is not for fun', '2024-12-19 13:10:42'),
(126, 7, 64, 'be serious', '2024-12-19 13:44:13'),
(127, 7, 64, '..', '2024-12-19 14:33:52'),
(128, 7, 64, ':/', '2024-12-19 14:38:54'),
(129, 7, 64, 'Are you guys getting my messages?', '2024-12-19 14:39:46'),
(130, 7, 64, 'hey?', '2024-12-19 14:41:46'),
(131, 7, 64, 'Talking to you guys!!!', '2024-12-19 14:41:58'),
(132, 7, 64, 'hello1', '2024-12-19 14:45:37'),
(133, 7, 64, 'hello2', '2024-12-19 14:45:41'),
(134, 7, 64, 'hello3', '2024-12-19 14:47:45'),
(135, 7, 64, 'hello4', '2024-12-19 14:47:57'),
(136, 7, 64, 'hello5', '2024-12-19 14:53:49'),
(137, 7, 64, 'hello6', '2024-12-19 14:54:14'),
(138, 7, 64, 'hello7', '2024-12-19 14:56:27'),
(139, 7, 64, '7', '2024-12-19 14:58:31'),
(140, 7, 64, '8', '2024-12-19 14:59:29'),
(141, 7, 64, '9', '2024-12-19 15:05:37'),
(142, 7, 64, '9', '2024-12-19 15:06:13'),
(143, 7, 64, '10', '2024-12-19 15:13:08'),
(144, 7, 64, 'so, hows everyone doing?', '2024-12-19 15:13:56'),
(145, 7, 64, 'hope all good?', '2024-12-19 15:16:54'),
(146, 7, 64, 'any problems?', '2024-12-19 15:17:04'),
(147, 7, 64, '1', '2024-12-19 15:28:21'),
(148, 7, 64, '12', '2024-12-19 15:28:25'),
(149, 7, 64, '3', '2024-12-19 15:28:29'),
(150, 7, 64, '4', '2024-12-19 15:28:33'),
(151, 7, 64, '45', '2024-12-19 15:28:35'),
(152, 7, 64, '456', '2024-12-19 15:28:37'),
(153, 7, 64, 'how is everyone?', '2024-12-19 15:28:48'),
(154, 7, 64, 'hope all good?', '2024-12-19 15:28:57'),
(155, 7, 65, 'Yes', '2024-12-19 15:29:08'),
(156, 7, 65, 'All good', '2024-12-19 15:29:22'),
(157, 7, 64, 'perfect', '2024-12-19 15:30:07'),
(158, 7, 66, '????', '2024-12-19 16:53:59'),
(159, 8, 68, 'Hey 🙏', '2024-12-19 17:25:48'),
(160, 8, 67, 'Hi 🙏', '2024-12-19 17:26:18'),
(161, 8, 64, 'Welcome to the group', '2024-12-19 17:28:06'),
(162, 6, 54, '🔥🔥😙😙🆚⚽️😙😙🆚🆚⚽️⚽️😙😙😙🔥🆚⚽️⚽️⚽️🆚💙', '2024-12-19 17:31:07'),
(163, 6, 44, 'jhkjn', '2024-12-19 17:33:31'),
(164, 6, 54, '👍🏽', '2024-12-19 17:33:51'),
(165, 6, 44, '١٢', '2024-12-19 17:34:10'),
(166, 6, 44, 'السلام عليكم ', '2024-12-19 17:40:04'),
(167, 6, 44, 'كيف الحال', '2024-12-19 17:40:38'),
(168, 6, 44, 'الحمدلله ', '2024-12-19 17:41:03'),
(169, 6, 46, 'الدوماً', '2024-12-19 17:41:23'),
(170, 6, 46, 'السلام عليكم', '2024-12-19 17:42:16'),
(171, 8, 64, 'السلام عليكم ,,,', '2024-12-19 17:43:59'),
(172, 8, 67, 'Hi 👋', '2024-12-19 17:44:12'),
(173, 8, 64, 'السلام عليكمممممم', '2024-12-19 17:44:51'),
(174, 8, 64, 'كيف الحال', '2024-12-19 17:45:20'),
(175, 8, 66, 'الحمدلله', '2024-12-19 17:45:33'),
(176, 8, 66, 'اختبار', '2024-12-19 17:47:32'),
(177, 8, 66, 'ماذا؟', '2024-12-19 17:47:53'),
(178, 8, 66, 'كيف', '2024-12-19 17:48:24'),
(179, 8, 64, 'ماذا عنك ؟', '2024-12-19 17:48:38'),
(180, 8, 66, 'تمام', '2024-12-19 17:48:44'),
(181, 8, 66, 'انا هنا شكراً', '2024-12-19 17:49:00'),
(182, 8, 65, 'بانتظاركم', '2024-12-24 14:19:39'),
(183, 2, 1, '12', '2024-12-25 19:35:36'),
(184, 2, 1, '13', '2024-12-25 19:35:42'),
(185, 2, 1, '123', '2024-12-25 21:56:13'),
(186, 2, 1, '123', '2024-12-25 21:56:38'),
(187, 2, 1, '11', '2024-12-25 22:02:45'),
(188, 3, 1, 'Nothing', '2024-12-25 22:05:41'),
(189, 2, 2, 'Yes?', '2024-12-25 22:06:42'),
(190, 8, 65, '👍🏽', '2024-12-29 03:27:17'),
(191, 7, 65, 'تذهب', '2024-12-29 03:30:41'),
(192, 10, 64, 'السلام عليكم ورحمة الله ', '2024-12-29 06:03:12'),
(193, 10, 65, 'وعليكم السلام ورحمة الله وبركاته', '2024-12-29 06:03:35'),
(194, 10, 64, 'معنا والد الطفل محمد سالم ', '2024-12-29 06:04:09'),
(195, 10, 65, 'حياكم الله', '2024-12-29 06:04:21'),
(196, 11, 64, 'السلام عليكم', '2024-12-30 11:58:17'),
(197, 12, 72, 'اهلا', '2024-12-30 12:36:30'),
(198, 12, 74, 'هلا السلام عليكم', '2024-12-30 12:39:21'),
(199, 10, 70, 'السلامعليكم', '2025-01-09 14:53:03'),
(200, 7, 66, 'J', '2025-01-25 10:05:51');

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1729092977),
('m241016_153445_init', 1729092978),
('m241022_154839_grade_ratio_table', 1730737752),
('m241022_165122_teacher_schedule_and_availability', 1730737752),
('m241104_141711_create_sales_tables', 1730897104),
('m241104_171318_user_social_media', 1730740513),
('m241104_180414_student_iqama_number', 1730743515),
('m241107_015324_plan_table', 1730944546),
('m241107_020424_add_plan_columns_to_user_table', 1730945121),
('m241107_173229_sale_gateway_invoice_url', 1731003322),
('m241111_012859_groups', 1731289144),
('m241111_012931_group_members', 1731290216),
('m241111_013004_messages', 1731290216),
('m241111_153533_groups_to_school_link', 1731339557),
('m241113_030608_fk_sender_id_user_id_messages', 1731468054),
('m241119_122308_grade_add_columns', 1732200839),
('m241119_145404_sale_status_enum_added', 1732200839),
('m241208_171439_sale_due_date_column', 1733771466),
('m241212_174200_sale_status_enum', 1734028864),
('m241216_175801_announcement_table_modify_for_results', 1734457775),
('m241224_132346_update_translation_add_ar', 1735048458);

-- --------------------------------------------------------

--
-- Table structure for table `plan`
--

CREATE TABLE `plan` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `name_ar` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `description_ar` varchar(255) DEFAULT NULL,
  `sub_users` int(11) DEFAULT NULL,
  `subscription_period` int(11) DEFAULT NULL,
  `price` decimal(19,2) DEFAULT 0.00,
  `highlighted` int(11) DEFAULT 0,
  `upgrade_to` varchar(255) DEFAULT NULL,
  `status` smallint(6) DEFAULT 1,
  `status_ex` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT current_timestamp(),
  `update_time` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plan`
--

INSERT INTO `plan` (`id`, `name`, `name_ar`, `description`, `description_ar`, `sub_users`, `subscription_period`, `price`, `highlighted`, `upgrade_to`, `status`, `status_ex`, `create_time`, `update_time`) VALUES
(1, 'Free Trial', 'فترة تجريبية مجانية', '14 Days Free Trial', 'فترة تجريبية لمدة 14 يومًا', 3, 14, 0.00, 0, '2,3', 1, 'free', '2024-02-13 12:10:14', '2024-12-29 13:32:40'),
(2, 'Basic', 'أساسي', '30 Days', '30 يومًا', 5, 30, 250.00, 0, '2,3', 1, NULL, '2024-02-13 12:10:14', '2024-12-29 13:32:45'),
(3, 'Premuim', 'بريميوم', '30 Days', '30 يومًا', 30, 30, 350.00, 1, '3', 1, NULL, '2024-02-13 12:10:14', '2024-12-29 13:32:49');

-- --------------------------------------------------------

--
-- Table structure for table `preferences`
--

CREATE TABLE `preferences` (
  `id` int(11) NOT NULL,
  `project` varchar(255) DEFAULT NULL COMMENT 'Project name',
  `title` varchar(255) DEFAULT NULL,
  `value` text DEFAULT NULL,
  `status` smallint(6) DEFAULT 1,
  `create_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `preferences`
--

INSERT INTO `preferences` (`id`, `project`, `title`, `value`, `status`, `create_time`, `update_time`) VALUES
(16, 'provider_app', 'android_version', '2.23', 1, '2023-05-09 18:05:36', '2023-05-09 18:59:41'),
(17, 'provider_app', 'ios_version', '1.0', 1, '2023-05-09 18:13:03', '2024-03-16 22:07:06'),
(18, 'client_app', 'ios_version', '1.0', 1, '2020-06-25 10:29:10', '2023-03-15 02:11:11'),
(19, 'mybaby', 'image_url', 'https://api.mybaby.test/', 1, '2024-07-15 20:00:06', '2024-10-15 17:05:49');

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
  `id` int(11) NOT NULL,
  `creator_model` varchar(50) DEFAULT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `payer_model` varchar(50) DEFAULT NULL,
  `payer_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL COMMENT 'sale, plan-upgrade, etc.',
  `status` enum('paid','unpaid','cancelled','failed') DEFAULT 'unpaid',
  `status_ex` varchar(255) DEFAULT NULL,
  `invoice_id` varchar(255) DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `order_date` datetime DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `gateway_invoice_id` varchar(500) DEFAULT NULL,
  `gateway_invoice_url` varchar(500) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT current_timestamp(),
  `update_time` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`id`, `creator_model`, `creator_id`, `payer_model`, `payer_id`, `type`, `status`, `status_ex`, `invoice_id`, `metadata`, `order_date`, `due_date`, `gateway_invoice_id`, `gateway_invoice_url`, `create_time`, `update_time`) VALUES
(800000, 'mybaby', NULL, 'school', 7, 'sale', 'unpaid', NULL, 'GmpfdzBrGQaa', '{\"items\": [{\"title\": \"Annual Subscription\", \"amount\": 2199, \"quantity\": 1}], \"invoice\": {\"vat\": 329.85, \"total\": 2528.85, \"subtotal\": 2199}}', NULL, NULL, '33f72913-7848-453b-bd12-525e3b7aa802', 'https://checkout.moyasar.com/invoices/33f72913-7848-453b-bd12-525e3b7aa802?lang=en', '2024-11-06 15:54:06', '2024-11-07 21:23:55'),
(800001, 'mybaby', NULL, 'school', 7, 'sale', 'paid', NULL, 'GmpfdzBrGQbb', '{\"items\": [{\"title\": \"Annual Subscription\", \"amount\": 100, \"quantity\": 1}], \"invoice\": {\"vat\": 15, \"total\": 115, \"subtotal\": 100}}', NULL, NULL, 'b0f04423-eb0c-48cb-be43-39be27a7d62c', 'https://checkout.moyasar.com/invoices/b0f04423-eb0c-48cb-be43-39be27a7d62c?lang=en', '2024-11-06 15:54:06', '2024-11-07 21:18:36'),
(800002, 'mybaby', NULL, 'school', 7, 'plan-upgrade', 'unpaid', NULL, 'WDy8tjfsjnta', '{\"items\": [{\"title\": \"Plan subscription\", \"amount\": \"100.00\", \"quantity\": 1}], \"invoice\": {\"vat\": 15, \"total\": 115, \"subtotal\": 100}}', NULL, NULL, NULL, NULL, '2024-11-11 03:36:40', '2024-11-11 03:36:40'),
(800003, 'mybaby', NULL, 'school', 7, 'plan-upgrade', 'unpaid', NULL, 'hKYvvbRgp7wj', '{\"items\": [{\"title\": \"Plan subscription\", \"amount\": \"100.00\", \"quantity\": 1}], \"invoice\": {\"vat\": 15, \"total\": 115, \"subtotal\": 100}}', NULL, NULL, NULL, NULL, '2024-11-11 03:36:44', '2024-11-11 03:36:44'),
(800004, 'mybaby', NULL, 'school', 7, 'plan-upgrade', 'unpaid', NULL, 'IK8BByahhB5H', '{\"items\": [{\"title\": \"Plan subscription\", \"amount\": \"100.00\", \"quantity\": 1}], \"invoice\": {\"vat\": 15, \"total\": 115, \"subtotal\": 100}}', NULL, NULL, NULL, NULL, '2024-11-11 03:37:29', '2024-11-11 03:37:29'),
(800005, 'mybaby', NULL, 'school', 7, 'plan-upgrade', 'unpaid', NULL, 'VNSop6lDze4h', '{\"items\": [{\"title\": \"Plan subscription\", \"amount\": \"100.00\", \"quantity\": 1}], \"invoice\": {\"vat\": 15, \"total\": 115, \"subtotal\": 100}}', NULL, NULL, NULL, NULL, '2024-11-11 03:37:51', '2024-11-11 03:37:51'),
(800006, 'mybaby', NULL, 'school', 7, 'plan-upgrade', 'unpaid', NULL, '5IHEnPNFgkv5', '{\"items\": [{\"title\": \"Plan subscription\", \"amount\": \"100.00\", \"quantity\": 1}], \"invoice\": {\"vat\": 15, \"total\": 115, \"subtotal\": 100}}', NULL, NULL, NULL, NULL, '2024-11-11 03:43:56', '2024-11-11 03:43:56'),
(800007, 'mybaby', NULL, 'school', 7, 'plan-upgrade', 'unpaid', NULL, 'ZNJ2MEOTOdJ5', '{\"items\": [{\"title\": \"Plan subscription\", \"amount\": \"100.00\", \"quantity\": 1}], \"invoice\": {\"vat\": 15, \"total\": 115, \"subtotal\": 100}}', NULL, NULL, NULL, NULL, '2024-11-11 03:56:15', '2024-11-11 03:56:15'),
(800008, 'mybaby', NULL, 'school', 7, 'plan-upgrade', 'unpaid', NULL, 'b5GucepUNFYu', '{\"items\": [{\"title\": \"Plan subscription\", \"amount\": \"100.00\", \"quantity\": 1}], \"invoice\": {\"vat\": 15, \"total\": 115, \"subtotal\": 100}}', NULL, NULL, NULL, NULL, '2024-11-11 03:58:23', '2024-11-11 03:58:23'),
(800009, 'mybaby', NULL, 'school', 7, 'plan-upgrade', 'unpaid', NULL, 'yNYyr30G4vsx', '{\"items\": [{\"title\": \"Plan subscription\", \"amount\": \"100.00\", \"quantity\": 1}], \"invoice\": {\"vat\": 15, \"total\": 115, \"subtotal\": 100}}', NULL, NULL, NULL, NULL, '2024-11-11 03:59:26', '2024-11-11 03:59:26'),
(800010, 'mybaby', NULL, 'school', 7, 'plan-upgrade', 'unpaid', NULL, 'hzWTuju7Dsie', '{\"items\": [{\"title\": \"Plan subscription\", \"amount\": \"100.00\", \"quantity\": 1}], \"invoice\": {\"vat\": 15, \"total\": 115, \"subtotal\": 100}}', NULL, NULL, NULL, NULL, '2024-11-12 04:00:35', '2024-11-12 04:00:35'),
(800011, 'mybaby', NULL, 'school', 44, 'plan-upgrade', 'unpaid', NULL, 'bW6I0frrDUgM', '{\"items\":[{\"title\":\"Plan subscription\",\"quantity\":1,\"amount\":\"100.00\"}],\"invoice\":{\"subtotal\":100,\"vat\":15,\"total\":115}}', NULL, NULL, NULL, NULL, '2024-11-17 17:08:24', '2024-11-17 17:08:24'),
(800012, 'mybaby', NULL, 'school', 44, 'plan-upgrade', 'unpaid', NULL, 'vWbJ5EdXpmg9', '{\"items\":[{\"title\":\"Plan subscription\",\"quantity\":1,\"amount\":\"100.00\"}],\"invoice\":{\"subtotal\":100,\"vat\":15,\"total\":115}}', NULL, NULL, NULL, NULL, '2024-11-17 17:08:38', '2024-11-17 17:08:38'),
(800013, 'mybaby', NULL, 'school', 44, 'plan-upgrade', 'unpaid', NULL, 'ZWZznC9KHL7P', '{\"items\":[{\"title\":\"Plan subscription\",\"quantity\":1,\"amount\":\"100.00\"}],\"invoice\":{\"subtotal\":100,\"vat\":15,\"total\":115}}', NULL, NULL, NULL, NULL, '2024-11-17 19:32:39', '2024-11-17 19:32:39'),
(800014, 'mybaby', NULL, 'school', 44, 'plan-upgrade', 'unpaid', NULL, 'OUEFhjUH7yRJ', '{\"items\":[{\"title\":\"Plan subscription\",\"quantity\":1,\"amount\":\"100.00\"}],\"invoice\":{\"subtotal\":100,\"vat\":15,\"total\":115}}', NULL, NULL, NULL, NULL, '2024-11-17 19:33:03', '2024-11-17 19:33:03'),
(800015, 'mybaby', NULL, 'school', 44, 'plan-upgrade', 'unpaid', NULL, '75JAAuxvBgQk', '{\"items\":[{\"title\":\"Plan subscription\",\"quantity\":1,\"amount\":\"100.00\"}],\"invoice\":{\"subtotal\":100,\"vat\":15,\"total\":115}}', NULL, NULL, 'c9eb721d-fafb-4c07-bf81-ce00be50940a', 'https://checkout.moyasar.com/invoices/c9eb721d-fafb-4c07-bf81-ce00be50940a?lang=en', '2024-11-22 17:13:54', '2024-12-30 11:56:38'),
(800016, 'school', 44, 'parent', 54, 'fee', 'unpaid', NULL, 'u60djMl2UoG6', '{\"metadata\":{\"student_id\":12,\"starting_date\":\"2024-11-11\",\"ending_date\":\"2024-11-30\",\"invoice_hours\":18,\"invoice_total\":900,\"invoice_start\":\"2024-11-11\",\"invoice_end\":\"2024-11-28\"},\"items\":[{\"title\":\"Fee - Nov 11, 2024 to Nov 28, 2024\",\"quantity\":1,\"amount\":900}],\"invoice\":{\"subtotal\":900,\"vat\":135,\"total\":1035}}', NULL, '2024-11-11 00:00:00', NULL, NULL, '2024-12-10 06:56:34', '2024-12-10 06:56:34'),
(800017, 'school', 44, 'parent', 54, 'fee', 'paid', NULL, 'Fm1VDXNOaS2R', '{\"metadata\":{\"student_id\":12,\"starting_date\":\"2024-11-11\",\"ending_date\":\"2024-11-30\",\"invoice_hours\":2,\"invoice_total\":100,\"invoice_start\":\"2024-11-29\",\"invoice_end\":\"2024-11-30\"},\"items\":[{\"title\":\"Fee - Nov 29, 2024 to Nov 30, 2024\",\"quantity\":1,\"amount\":100}],\"invoice\":{\"subtotal\":100,\"vat\":15,\"total\":115}}', NULL, '2024-11-29 00:00:00', NULL, NULL, '2024-12-10 06:56:34', '2024-12-10 06:57:05'),
(800018, 'mybaby', NULL, 'school', 7, 'plan-upgrade', 'paid', '', 'Qnx3aMTcub99', '{\"items\": [{\"title\": \"Plan subscription\", \"amount\": \"100.00\", \"quantity\": 1}], \"invoice\": {\"vat\": 15, \"total\": 115, \"subtotal\": 100}, \"metadata\": {\"new_plan_id\": 2, \"current_plan_id\": 1}}', NULL, NULL, '0dd07eb0-caf6-447e-852f-9b1c2bbeabfb', 'https://checkout.moyasar.com/invoices/cda3a4ac-b282-4b9b-9936-2dc8cb362f53?lang=en', '2024-12-12 21:42:16', '2024-12-12 18:46:55'),
(800019, 'mybaby', NULL, 'school', 5, 'plan-upgrade', 'unpaid', NULL, 'rHuGCfqd42M4', '{\"metadata\":{\"current_plan_id\":1,\"new_plan_id\":2},\"items\":[{\"title\":\"اشتراك الخطة\",\"quantity\":1,\"amount\":\"250.00\"}],\"invoice\":{\"subtotal\":250,\"vat\":37.5,\"total\":287.5}}', NULL, NULL, 'a29b134b-8183-41e1-8179-9f703b1ef3fb', 'https://checkout.moyasar.com/invoices/a29b134b-8183-41e1-8179-9f703b1ef3fb?lang=en', '2024-12-17 18:41:33', '2024-12-17 18:41:49'),
(800020, 'school', 64, 'parent', 66, 'fee', 'unpaid', NULL, 'EpzYph5J268z', '{\"metadata\":{\"student_id\":15,\"starting_date\":\"2024-12-11\",\"ending_date\":\"2024-12-12\",\"invoice_hours\":4,\"invoice_total\":100,\"invoice_start\":\"2024-12-11\",\"invoice_end\":\"2024-12-12\"},\"items\":[{\"title\":\"Fee - Dec 11, 2024 to Dec 12, 2024\",\"quantity\":1,\"amount\":100}],\"invoice\":{\"subtotal\":100,\"vat\":15,\"total\":115}}', NULL, '2024-12-11 00:00:00', NULL, NULL, '2024-12-17 19:15:52', '2024-12-17 19:15:52'),
(800021, 'school', 64, 'parent', 66, 'fee', 'unpaid', NULL, 'rbkmMfqF1Zbh', '{\"metadata\":{\"student_id\":15,\"starting_date\":\"2024-12-11\",\"ending_date\":\"2024-12-12\",\"invoice_hours\":4,\"invoice_total\":200,\"invoice_start\":\"2024-12-11\",\"invoice_end\":\"2024-12-12\"},\"items\":[{\"title\":\"Fee - Dec 11, 2024 to Dec 12, 2024\",\"quantity\":1,\"amount\":200}],\"invoice\":{\"subtotal\":200,\"vat\":30,\"total\":230}}', NULL, '2024-12-11 00:00:00', NULL, NULL, '2024-12-17 19:17:20', '2024-12-17 19:17:20'),
(800022, 'school', 64, 'parent', 66, 'fee', 'unpaid', NULL, 'XcCSxcAfyCgC', '{\"metadata\":{\"student_id\":15,\"starting_date\":\"2024-12-11\",\"ending_date\":\"2024-12-12\",\"invoice_hours\":4,\"invoice_total\":80,\"invoice_start\":\"2024-12-11\",\"invoice_end\":\"2024-12-12\"},\"items\":[{\"title\":\"Fee - Dec 11, 2024 to Dec 12, 2024\",\"quantity\":1,\"amount\":80}],\"invoice\":{\"subtotal\":80,\"vat\":12,\"total\":92}}', NULL, '2024-12-11 00:00:00', NULL, NULL, '2024-12-19 17:35:44', '2024-12-19 17:35:44'),
(800023, 'school', 64, 'parent', 66, 'fee', 'paid', NULL, 'ISb6PegaZRf3', '{\"metadata\":{\"student_id\":15,\"starting_date\":\"2024-12-11\",\"ending_date\":\"2024-12-12\",\"invoice_hours\":4,\"invoice_total\":1120,\"invoice_start\":\"2024-12-11\",\"invoice_end\":\"2024-12-12\"},\"items\":[{\"title\":\"Fee - Dec 11, 2024 to Dec 12, 2024\",\"quantity\":1,\"amount\":1120}],\"invoice\":{\"subtotal\":1120,\"vat\":168,\"total\":1288}}', NULL, '2024-12-11 00:00:00', NULL, NULL, '2024-12-19 17:35:59', '2024-12-19 18:05:18'),
(800024, 'school', 64, 'parent', 66, 'fee', 'paid', NULL, 'TMSlG6eUGeqV', '{\"metadata\":{\"student_id\":15,\"starting_date\":\"2025-01-01\",\"ending_date\":\"2025-04-15\",\"invoice_hours\":56,\"invoice_total\":1400,\"invoice_start\":\"2025-01-01\",\"invoice_end\":\"2025-01-28\"},\"items\":[{\"title\":\"Fee - Jan 01, 2025 to Jan 28, 2025\",\"quantity\":1,\"amount\":1400}],\"invoice\":{\"subtotal\":1400,\"vat\":210,\"total\":1610}}', NULL, '2025-01-01 00:00:00', NULL, NULL, '2024-12-19 18:11:00', '2024-12-30 11:55:58'),
(800025, 'school', 64, 'parent', 66, 'fee', 'unpaid', NULL, 'NieAea9yE8mz', '{\"metadata\":{\"student_id\":15,\"starting_date\":\"2025-01-01\",\"ending_date\":\"2025-04-15\",\"invoice_hours\":62,\"invoice_total\":1550,\"invoice_start\":\"2025-01-29\",\"invoice_end\":\"2025-02-28\"},\"items\":[{\"title\":\"Fee - Jan 29, 2025 to Feb 28, 2025\",\"quantity\":1,\"amount\":1550}],\"invoice\":{\"subtotal\":1550,\"vat\":232.5,\"total\":1782.5}}', NULL, '2025-01-29 00:00:00', NULL, NULL, '2024-12-19 18:11:00', '2024-12-19 18:11:00'),
(800026, 'school', 64, 'parent', 66, 'fee', 'unpaid', NULL, 'Sg7v0rAvm7Qr', '{\"metadata\":{\"student_id\":15,\"starting_date\":\"2025-01-01\",\"ending_date\":\"2025-04-15\",\"invoice_hours\":56,\"invoice_total\":1400,\"invoice_start\":\"2025-03-01\",\"invoice_end\":\"2025-03-28\"},\"items\":[{\"title\":\"Fee - Mar 01, 2025 to Mar 28, 2025\",\"quantity\":1,\"amount\":1400}],\"invoice\":{\"subtotal\":1400,\"vat\":210,\"total\":1610}}', NULL, '2025-03-01 00:00:00', NULL, NULL, '2024-12-19 18:11:00', '2024-12-19 18:11:00'),
(800027, 'school', 64, 'parent', 66, 'fee', 'unpaid', NULL, 'CET7ZO4I30M6', '{\"metadata\":{\"student_id\":15,\"starting_date\":\"2025-01-01\",\"ending_date\":\"2025-04-15\",\"invoice_hours\":36,\"invoice_total\":900,\"invoice_start\":\"2025-03-29\",\"invoice_end\":\"2025-04-15\"},\"items\":[{\"title\":\"Fee - Mar 29, 2025 to Apr 15, 2025\",\"quantity\":1,\"amount\":900}],\"invoice\":{\"subtotal\":900,\"vat\":135,\"total\":1035}}', NULL, '2025-03-29 00:00:00', NULL, NULL, '2024-12-19 18:11:00', '2024-12-19 18:11:00'),
(800028, 'mybaby', NULL, 'school', 64, 'plan-upgrade', 'paid', '', 'z5OuHE1ipWV9', '{\"metadata\":{\"current_plan_id\":1,\"new_plan_id\":2},\"items\":[{\"title\":\"Plan subscription\",\"quantity\":1,\"amount\":\"250.00\"}],\"invoice\":{\"subtotal\":250,\"vat\":37.5,\"total\":287.5}}', NULL, NULL, 'a6bc13f3-e806-458b-9f85-f09cc7138d8d', 'https://checkout.moyasar.com/invoices/a6bc13f3-e806-458b-9f85-f09cc7138d8d?lang=en', '2024-12-19 18:14:30', '2024-12-19 18:14:57'),
(800029, 'mybaby', NULL, 'school', 64, 'plan-upgrade', 'unpaid', NULL, 'C14sOT922Xiv', '{\"metadata\":{\"current_plan_id\":2,\"new_plan_id\":2},\"items\":[{\"title\":\"Plan subscription\",\"quantity\":1,\"amount\":\"250.00\"}],\"invoice\":{\"subtotal\":250,\"vat\":37.5,\"total\":287.5}}', NULL, NULL, NULL, NULL, '2024-12-19 18:15:33', '2024-12-19 18:15:33'),
(800030, 'mybaby', NULL, 'school', 64, 'plan-upgrade', 'unpaid', NULL, 'jlI7jnHpkV9t', '{\"metadata\":{\"current_plan_id\":2,\"new_plan_id\":3},\"items\":[{\"title\":\"اشتراك الخطة\",\"quantity\":1,\"amount\":\"350.00\"}],\"invoice\":{\"subtotal\":350,\"vat\":52.5,\"total\":402.5}}', NULL, NULL, NULL, NULL, '2024-12-30 11:54:13', '2024-12-30 11:54:13'),
(800031, 'mybaby', NULL, 'school', 64, 'plan-upgrade', 'unpaid', NULL, 'G5SQpg6FGF9q', '{\"metadata\":{\"current_plan_id\":2,\"new_plan_id\":2},\"items\":[{\"title\":\"اشتراك الخطة\",\"quantity\":1,\"amount\":\"250.00\"}],\"invoice\":{\"subtotal\":250,\"vat\":37.5,\"total\":287.5}}', NULL, NULL, NULL, NULL, '2025-01-05 08:11:12', '2025-01-05 08:11:12'),
(800032, 'mybaby', NULL, 'school', 64, 'plan-upgrade', 'paid', '', '8n2jEPDkL5yr', '{\"metadata\":{\"current_plan_id\":2,\"new_plan_id\":3},\"items\":[{\"title\":\"اشتراك الخطة\",\"quantity\":1,\"amount\":\"350.00\"}],\"invoice\":{\"subtotal\":350,\"vat\":52.5,\"total\":402.5}}', NULL, NULL, 'a1e69fd6-7bda-420d-a699-ca67cad1c614', 'https://checkout.moyasar.com/invoices/a1e69fd6-7bda-420d-a699-ca67cad1c614?lang=en', '2025-01-05 08:20:19', '2025-01-05 08:22:02'),
(800033, 'school', 64, 'parent', 70, 'fee', 'unpaid', NULL, 'PjurPVFJoeoi', '{\"metadata\":{\"student_id\":18,\"starting_date\":\"2025-01-01\",\"ending_date\":\"2025-01-05\",\"invoice_hours\":10,\"invoice_total\":1000,\"invoice_start\":\"2025-01-01\",\"invoice_end\":\"2025-01-05\"},\"items\":[{\"title\":\"Fee - Jan 01, 2025 to Jan 05, 2025\",\"quantity\":1,\"amount\":1000}],\"invoice\":{\"subtotal\":1000,\"vat\":150,\"total\":1150}}', NULL, '2025-01-01 00:00:00', NULL, NULL, '2025-01-05 08:26:22', '2025-01-05 08:26:22'),
(800034, 'mybaby', NULL, 'school', 5, 'plan-upgrade', 'paid', '', 'Ad7j65K9NG4L', '{\"metadata\":{\"current_plan_id\":1,\"new_plan_id\":3},\"items\":[{\"title\":\"اشتراك الخطة\",\"quantity\":1,\"amount\":\"350.00\"}],\"invoice\":{\"subtotal\":350,\"vat\":52.5,\"total\":402.5}}', NULL, NULL, '49626b59-37aa-4bed-90ac-4943e4ddeb88', 'https://checkout.moyasar.com/invoices/49626b59-37aa-4bed-90ac-4943e4ddeb88?lang=en', '2025-01-06 08:52:58', '2025-01-06 08:56:55'),
(800035, 'mybaby', NULL, 'school', 72, 'plan-upgrade', 'unpaid', NULL, 'ebtM2XNJOALm', '{\"metadata\":{\"current_plan_id\":1,\"new_plan_id\":3},\"items\":[{\"title\":\"اشتراك الخطة\",\"quantity\":1,\"amount\":\"350.00\"}],\"invoice\":{\"subtotal\":350,\"vat\":52.5,\"total\":402.5}}', NULL, NULL, NULL, NULL, '2025-01-13 20:39:07', '2025-01-13 20:39:07'),
(800036, 'mybaby', NULL, 'school', 72, 'plan-upgrade', 'unpaid', NULL, 'OqQINJfdOasi', '{\"metadata\":{\"current_plan_id\":1,\"new_plan_id\":2},\"items\":[{\"title\":\"اشتراك الخطة\",\"quantity\":1,\"amount\":\"250.00\"}],\"invoice\":{\"subtotal\":250,\"vat\":37.5,\"total\":287.5}}', NULL, NULL, NULL, NULL, '2025-01-13 20:39:12', '2025-01-13 20:39:12'),
(800037, 'mybaby', NULL, 'school', 72, 'plan-upgrade', 'unpaid', NULL, 'Plua8hlCof12', '{\"metadata\":{\"current_plan_id\":1,\"new_plan_id\":3},\"items\":[{\"title\":\"اشتراك الخطة\",\"quantity\":1,\"amount\":\"350.00\"}],\"invoice\":{\"subtotal\":350,\"vat\":52.5,\"total\":402.5}}', NULL, NULL, NULL, NULL, '2025-01-13 20:39:28', '2025-01-13 20:39:28'),
(800038, 'mybaby', NULL, 'school', 72, 'plan-upgrade', 'unpaid', NULL, 'YSgLK78p4XJt', '{\"metadata\":{\"current_plan_id\":1,\"new_plan_id\":3},\"items\":[{\"title\":\"اشتراك الخطة\",\"quantity\":1,\"amount\":\"350.00\"}],\"invoice\":{\"subtotal\":350,\"vat\":52.5,\"total\":402.5}}', NULL, NULL, NULL, NULL, '2025-01-13 20:39:35', '2025-01-13 20:39:35'),
(800039, 'mybaby', NULL, 'school', 72, 'plan-upgrade', 'unpaid', NULL, 'iRAFmE5OvjUM', '{\"metadata\":{\"current_plan_id\":1,\"new_plan_id\":2},\"items\":[{\"title\":\"اشتراك الخطة\",\"quantity\":1,\"amount\":\"250.00\"}],\"invoice\":{\"subtotal\":250,\"vat\":37.5,\"total\":287.5}}', NULL, NULL, NULL, NULL, '2025-01-13 20:40:42', '2025-01-13 20:40:42'),
(800040, 'mybaby', NULL, 'school', 5, 'plan-upgrade', 'unpaid', NULL, 'vvatoZH1kI2X', '{\"metadata\":{\"current_plan_id\":3,\"new_plan_id\":3},\"items\":[{\"title\":\"اشتراك الخطة\",\"quantity\":1,\"amount\":\"350.00\"}],\"invoice\":{\"subtotal\":350,\"vat\":52.5,\"total\":402.5}}', NULL, NULL, NULL, NULL, '2025-01-14 12:46:46', '2025-01-14 12:46:46'),
(800041, 'mybaby', NULL, 'school', 64, 'plan-upgrade', 'unpaid', NULL, '0uwbUckPPDCj', '{\"metadata\":{\"current_plan_id\":3,\"new_plan_id\":3},\"items\":[{\"title\":\"Plan subscription\",\"quantity\":1,\"amount\":\"350.00\"}],\"invoice\":{\"subtotal\":350,\"vat\":52.5,\"total\":402.5}}', NULL, NULL, NULL, NULL, '2025-01-20 08:26:10', '2025-01-20 08:26:10'),
(800042, 'school', 64, 'parent', 66, 'fee', 'paid', NULL, 'M6tjlMlFd7mm', '{\"metadata\":{\"student_id\":15,\"starting_date\":\"2025-01-01\",\"ending_date\":\"2025-01-31\",\"invoice_hours\":980,\"invoice_total\":1445.5,\"invoice_start\":\"2025-01-01\",\"invoice_end\":\"2025-01-28\"},\"items\":[{\"title\":\"Fee - Jan 01, 2025 to Jan 28, 2025\",\"quantity\":1,\"amount\":1445.5}],\"invoice\":{\"subtotal\":1445.5,\"vat\":216.825,\"total\":1662.325}}', NULL, '2025-01-01 00:00:00', NULL, NULL, '2025-01-20 08:34:16', '2025-01-20 08:35:08'),
(800043, 'school', 64, 'parent', 66, 'fee', 'unpaid', NULL, 'uT5gzQ6EvAKv', '{\"metadata\":{\"student_id\":15,\"starting_date\":\"2025-01-01\",\"ending_date\":\"2025-01-31\",\"invoice_hours\":105,\"invoice_total\":154.875,\"invoice_start\":\"2025-01-29\",\"invoice_end\":\"2025-01-31\"},\"items\":[{\"title\":\"Fee - Jan 29, 2025 to Jan 31, 2025\",\"quantity\":1,\"amount\":154.875}],\"invoice\":{\"subtotal\":154.875,\"vat\":23.23125,\"total\":178.10625}}', NULL, '2025-01-29 00:00:00', NULL, NULL, '2025-01-20 08:34:16', '2025-01-20 08:34:16'),
(800044, 'mybaby', NULL, 'school', 72, 'plan-upgrade', 'paid', '', '8CC9k8iF917s', '{\"metadata\":{\"current_plan_id\":1,\"new_plan_id\":3},\"items\":[{\"title\":\"Plan subscription\",\"quantity\":1,\"amount\":\"350.00\"}],\"invoice\":{\"subtotal\":350,\"vat\":52.5,\"total\":402.5}}', NULL, NULL, 'b3d725a3-bccd-4a24-bcc9-20bd21671fc7', 'https://checkout.moyasar.com/invoices/b3d725a3-bccd-4a24-bcc9-20bd21671fc7?lang=en', '2025-01-22 07:14:03', '2025-01-22 07:14:45'),
(800045, 'mybaby', NULL, 'school', 44, 'plan-upgrade', 'unpaid', NULL, 'NsqxQca4LCX1', '{\"metadata\":{\"current_plan_id\":1,\"new_plan_id\":2},\"items\":[{\"title\":\"Plan subscription\",\"quantity\":1,\"amount\":\"250.00\"}],\"invoice\":{\"subtotal\":250,\"vat\":37.5,\"total\":287.5}}', NULL, NULL, NULL, NULL, '2025-01-27 12:45:03', '2025-01-27 12:45:03');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `code` varchar(255) DEFAULT NULL,
  `en` varchar(255) DEFAULT NULL,
  `ar` varchar(255) DEFAULT NULL,
  `bg_color` varchar(255) DEFAULT '#FFFFFF',
  `fg_color` varchar(255) DEFAULT '#000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`code`, `en`, `ar`, `bg_color`, `fg_color`) VALUES
('paid', 'Paid', 'مدفوع', '#d4edda', '#155724'),
('unpaid', 'Unpaid', 'غير مدفوع', '#f8d7da', '#721c24'),
('processing', 'Processing', 'قيد المعالجة', '#fff3cd', '#856404'),
('cancelled', 'Cancelled', 'ملغى', '#e2e3e5', '#6c757d'),
('finished', 'Finished', 'منتهي', '#cce5ff', '#004085'),
('failed', 'Failed', 'فشل', '#f8d7da', '#721c24'),
('waiting_for_payment', 'Waiting for Payment', 'في انتظار الدفع', '#fff3cd', '#856404'),
('waiting_for_approval', 'Waiting for Approval', 'في انتظار الموافقة', '#fff3cd', '#856404'),
('in_review', 'In Review', 'قيد المراجعة', '#d1ecf1', '#0c5460'),
('available', 'Available', 'متوفر', '#d4edda', '#155724'),
('unavailable', 'Unavailable', 'غير متوفر', '#f8d7da', '#721c24'),
('out_of_stock', 'Out of Stock', 'نفد المخزون', '#e2e3e5', '#6c757d'),
('premise', 'Premise', 'الموقع', '#d1ecf1', '#0c5460'),
('mobile', 'Mobile', 'محمول', '#cce5ff', '#004085'),
('both', 'Premise & Mobile', 'كلاهما', '#fff3cd', '#856404'),
('invited', 'Invitation sent', 'تم إرسال الدعوة', '#FFFFFF', '#000000'),
('profile', 'Incomplete Profile', 'الملف الشخصي غير مكتمل', '#FFFFFF', '#000000'),
('school', 'SCHOOL', 'مدرسة', '#FFFFFF', '#000000'),
('mybaby', 'MYBABY', 'MYBABY', '#FFFFFF', '#000000');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `grade_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `id_number` int(11) DEFAULT NULL,
  `name_ar` varchar(255) DEFAULT NULL,
  `dob` datetime DEFAULT NULL,
  `gender` enum('m','f') DEFAULT NULL,
  `health` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`health`)),
  `allergies` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`allergies`)),
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `status_ex` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT current_timestamp(),
  `update_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `parent_id`, `grade_id`, `name`, `id_number`, `name_ar`, `dob`, `gender`, `health`, `allergies`, `status`, `status_ex`, `create_time`, `update_time`) VALUES
(1, 2, 1, 'Abdulla Ahmed', 111, 'Abdullah Saleem', '2022-06-05 00:00:00', 'm', '[\"covid\", \"is very sick\", \"ffdsfs\", \"dsfgdfgf\", \"fhgjh\"]', '[\"no allergy\", \"12312312\"]', 'active', NULL, '2024-10-01 14:24:25', '2024-11-05 02:14:17'),
(2, 2, 1, 'Hashim Ilyas', 222, 'Hashim Ilyas', '2012-06-03 00:00:00', 'f', '[\"perfect child\", \"sometimes bad\"]', '[\"every food\"]', 'active', NULL, '2024-10-01 14:24:25', '2024-11-06 18:03:01'),
(7, 31, 1, NULL, 2117918231, NULL, NULL, NULL, NULL, NULL, 'pending', 'profile', '2024-11-05 20:38:28', '2024-11-05 20:39:13'),
(8, 43, 37, 'Ahsan', 1, NULL, '2004-07-23 00:00:00', 'm', NULL, NULL, 'active', NULL, '2024-11-06 20:33:05', '2024-11-17 17:39:50'),
(12, 54, 40, 'Demo Student', 123456789, 'Demo Student', '2004-07-23 00:00:00', 'm', '[\"perfect child\", \"sometimes bad\"]', '[\"no allergy\",\"12312312\",\"allergic to humans\"]', 'active', NULL, '2024-11-16 22:59:14', '2024-12-11 11:09:33'),
(15, 66, 42, 'سارة محمود', 1010112233, NULL, '2024-12-03 00:00:00', NULL, '[]', '[]', 'active', NULL, '2024-12-17 19:08:14', '2024-12-18 14:14:28'),
(16, 68, 42, 'Khan Ahmed', 10001, NULL, '2012-12-12 00:00:00', NULL, '[]', '[]', 'active', NULL, '2024-12-19 20:20:36', '2024-12-19 17:54:16'),
(17, 64, 42, NULL, 1010101010, NULL, NULL, NULL, NULL, NULL, 'pending', 'profile', '2024-12-20 16:43:18', '2024-12-20 13:43:18'),
(18, 70, 42, 'ياسر مساعد', 1010101022, NULL, '2024-12-19 00:00:00', NULL, '[]', '[]', 'active', NULL, '2024-12-20 16:44:57', '2024-12-20 18:13:25'),
(19, 75, 45, 'محمد عمر', 1107493456, NULL, '2024-11-05 00:00:00', NULL, '[]', '[]', 'active', NULL, '2024-12-30 15:19:07', '2024-12-30 12:42:09'),
(20, 77, 47, 'رزان فيصل ', 113455324, NULL, '2024-01-01 00:00:00', NULL, '[\"خوف من القطط\",\"خوف من المرتفعات\"]', '[\"لوز\",\"كيوي\"]', 'active', NULL, '2025-01-09 21:42:49', '2025-01-09 18:46:14'),
(21, 79, 47, 'فهد ريان', 2147483647, NULL, '2020-01-01 00:00:00', NULL, '[]', '[]', 'active', NULL, '2025-01-12 15:14:49', '2025-01-12 12:18:04'),
(22, 79, 47, NULL, 2147483647, NULL, NULL, NULL, NULL, NULL, 'pending', 'profile', '2025-01-12 15:14:49', '2025-01-12 12:14:49'),
(23, 85, 49, 'Test Child ', 123456, NULL, '2022-01-05 00:00:00', NULL, '[\"Asthma Issue\",\"weak eyesight\"]', '[\"Pollen Allergy\"]', 'active', NULL, '2025-01-29 11:37:26', '2025-01-29 08:40:13');

-- --------------------------------------------------------

--
-- Table structure for table `student_schedule`
--

CREATE TABLE `student_schedule` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `day_of_week` enum('monday','tuesday','wednesday','thursday','friday','saturday','sunday') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `start_date` datetime NOT NULL DEFAULT current_timestamp(),
  `end_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_schedule`
--

INSERT INTO `student_schedule` (`id`, `student_id`, `grade_id`, `day_of_week`, `start_time`, `end_time`, `start_date`, `end_date`) VALUES
(37, 1, 1, 'monday', '10:00:00', '11:00:00', '2024-11-01 00:00:00', '2024-11-15 00:00:00'),
(38, 1, 1, 'tuesday', '11:00:00', '12:00:00', '2024-11-01 00:00:00', '2024-11-15 00:00:00'),
(45, 2, 1, 'monday', '09:00:00', '10:00:00', '2024-11-01 00:00:00', '2024-11-15 00:00:00'),
(46, 2, 1, 'tuesday', '09:00:00', '10:00:00', '2024-11-01 00:00:00', '2024-11-15 00:00:00'),
(47, 2, 1, 'wednesday', '09:00:00', '10:00:00', '2024-11-01 00:00:00', '2024-11-15 00:00:00'),
(48, 2, 1, 'thursday', '09:00:00', '10:00:00', '2024-11-01 00:00:00', '2024-11-15 00:00:00'),
(49, 2, 1, 'sunday', '09:00:00', '10:00:00', '2024-11-01 00:00:00', '2024-11-15 00:00:00'),
(50, 2, 1, 'sunday', '10:00:00', '11:00:00', '2024-11-01 00:00:00', '2024-11-15 00:00:00'),
(51, 2, 1, 'sunday', '23:00:00', '00:00:00', '2024-11-01 00:00:00', '2024-11-15 00:00:00'),
(52, 8, 37, 'monday', '09:00:00', '10:00:00', '2024-12-11 00:00:00', '2024-12-16 00:00:00'),
(53, 8, 37, 'tuesday', '09:00:00', '10:00:00', '2024-12-11 00:00:00', '2024-12-16 00:00:00'),
(54, 8, 37, 'wednesday', '09:00:00', '10:00:00', '2024-12-11 00:00:00', '2024-12-16 00:00:00'),
(55, 12, 40, 'monday', '07:00:00', '08:00:00', '2024-11-11 00:00:00', '2024-11-30 00:00:00'),
(62, 18, 42, 'monday', '11:00:00', '12:00:00', '2025-01-01 00:00:00', '2025-01-05 00:00:00'),
(63, 18, 42, 'thursday', '08:00:00', '09:00:00', '2025-01-01 00:00:00', '2025-01-05 00:00:00'),
(64, 20, 47, 'monday', '07:00:00', '08:00:00', '2025-01-01 00:00:00', '2025-01-14 00:00:00'),
(65, 20, 47, 'wednesday', '09:00:00', '10:00:00', '2025-01-01 00:00:00', '2025-01-14 00:00:00'),
(66, 15, 42, 'monday', '07:00:00', '08:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(67, 15, 42, 'monday', '08:00:00', '09:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(68, 15, 42, 'monday', '09:00:00', '10:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(69, 15, 42, 'monday', '10:00:00', '11:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(70, 15, 42, 'monday', '11:00:00', '12:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(71, 15, 42, 'monday', '12:00:00', '13:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(72, 15, 42, 'monday', '13:00:00', '14:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(73, 15, 42, 'tuesday', '07:00:00', '08:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(74, 15, 42, 'tuesday', '08:00:00', '09:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(75, 15, 42, 'tuesday', '09:00:00', '10:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(76, 15, 42, 'tuesday', '10:00:00', '11:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(77, 15, 42, 'tuesday', '11:00:00', '12:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(78, 15, 42, 'tuesday', '12:00:00', '13:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(79, 15, 42, 'tuesday', '13:00:00', '14:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(80, 15, 42, 'wednesday', '07:00:00', '08:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(81, 15, 42, 'wednesday', '08:00:00', '09:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(82, 15, 42, 'wednesday', '09:00:00', '10:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(83, 15, 42, 'wednesday', '10:00:00', '11:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(84, 15, 42, 'wednesday', '11:00:00', '12:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(85, 15, 42, 'wednesday', '12:00:00', '13:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(86, 15, 42, 'wednesday', '13:00:00', '14:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(87, 15, 42, 'thursday', '07:00:00', '08:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(88, 15, 42, 'thursday', '08:00:00', '09:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(89, 15, 42, 'thursday', '09:00:00', '10:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(90, 15, 42, 'thursday', '10:00:00', '11:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(91, 15, 42, 'thursday', '11:00:00', '12:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(92, 15, 42, 'thursday', '12:00:00', '13:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(93, 15, 42, 'thursday', '13:00:00', '14:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(94, 15, 42, 'sunday', '07:00:00', '08:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(95, 15, 42, 'sunday', '08:00:00', '09:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(96, 15, 42, 'sunday', '09:00:00', '10:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(97, 15, 42, 'sunday', '10:00:00', '11:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(98, 15, 42, 'sunday', '11:00:00', '12:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(99, 15, 42, 'sunday', '12:00:00', '13:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(100, 15, 42, 'sunday', '13:00:00', '14:00:00', '2025-01-01 00:00:00', '2025-01-31 00:00:00'),
(101, 19, 45, 'monday', '07:00:00', '08:00:00', '2025-01-04 00:00:00', '2025-01-31 00:00:00'),
(102, 19, 45, 'thursday', '06:00:00', '07:00:00', '2025-01-04 00:00:00', '2025-01-31 00:00:00'),
(103, 19, 45, 'friday', '09:00:00', '10:00:00', '2025-01-04 00:00:00', '2025-01-31 00:00:00'),
(144, 23, 49, 'monday', '07:00:00', '08:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(145, 23, 49, 'monday', '08:00:00', '09:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(146, 23, 49, 'monday', '09:00:00', '10:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(147, 23, 49, 'monday', '10:00:00', '11:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(148, 23, 49, 'monday', '11:00:00', '12:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(149, 23, 49, 'monday', '12:00:00', '13:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(150, 23, 49, 'monday', '13:00:00', '14:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(151, 23, 49, 'monday', '14:00:00', '15:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(152, 23, 49, 'tuesday', '09:00:00', '10:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(153, 23, 49, 'tuesday', '10:00:00', '11:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(154, 23, 49, 'tuesday', '11:00:00', '12:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(155, 23, 49, 'tuesday', '12:00:00', '13:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(156, 23, 49, 'tuesday', '13:00:00', '14:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(157, 23, 49, 'tuesday', '14:00:00', '15:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(158, 23, 49, 'tuesday', '15:00:00', '16:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(159, 23, 49, 'tuesday', '16:00:00', '17:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(160, 23, 49, 'wednesday', '07:00:00', '08:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(161, 23, 49, 'wednesday', '08:00:00', '09:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(162, 23, 49, 'wednesday', '09:00:00', '10:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(163, 23, 49, 'wednesday', '10:00:00', '11:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(164, 23, 49, 'wednesday', '11:00:00', '12:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(165, 23, 49, 'wednesday', '12:00:00', '13:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(166, 23, 49, 'wednesday', '13:00:00', '14:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(167, 23, 49, 'thursday', '08:00:00', '09:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(168, 23, 49, 'thursday', '09:00:00', '10:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(169, 23, 49, 'thursday', '10:00:00', '11:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(170, 23, 49, 'thursday', '11:00:00', '12:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(171, 23, 49, 'thursday', '12:00:00', '13:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(172, 23, 49, 'thursday', '13:00:00', '14:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(173, 23, 49, 'thursday', '14:00:00', '15:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(174, 23, 49, 'thursday', '15:00:00', '16:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(175, 23, 49, 'sunday', '08:00:00', '09:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(176, 23, 49, 'sunday', '09:00:00', '10:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(177, 23, 49, 'sunday', '10:00:00', '11:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(178, 23, 49, 'sunday', '11:00:00', '12:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(179, 23, 49, 'sunday', '12:00:00', '13:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(180, 23, 49, 'sunday', '13:00:00', '14:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(181, 23, 49, 'sunday', '14:00:00', '15:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(182, 23, 49, 'sunday', '15:00:00', '16:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00'),
(183, 23, 49, 'sunday', '16:00:00', '17:00:00', '2025-01-28 00:00:00', '2025-06-30 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `model` varchar(255) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `debit` varchar(255) DEFAULT NULL COMMENT 'amount taken from',
  `credit` varchar(255) DEFAULT NULL COMMENT 'amount added to',
  `description` varchar(500) DEFAULT NULL,
  `base_amount` decimal(19,4) DEFAULT NULL,
  `vat_amount` decimal(19,4) DEFAULT 0.0000,
  `total_amount` decimal(19,4) DEFAULT 0.0000,
  `vat_percent` decimal(19,4) DEFAULT NULL,
  `currency` varchar(32) DEFAULT 'SAR',
  `method` varchar(255) DEFAULT NULL COMMENT 'cash, card, applepay, gpay, etc.',
  `card_type` varchar(255) DEFAULT NULL COMMENT 'mada, visa, mastercard, etc.',
  `gateway` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT 'moyasar, etc.',
  `gateway_amount` decimal(19,2) DEFAULT 0.00,
  `gateway_cost` decimal(19,2) DEFAULT 0.00,
  `gateway_live` tinyint(1) DEFAULT 1,
  `status` enum('created','initiated','paid','cancelled','refunded','failed','unknown') DEFAULT 'created',
  `status_ex` varchar(255) DEFAULT NULL,
  `payment_url` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `return_url` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT current_timestamp(),
  `update_time` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translation`
--

CREATE TABLE `translation` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `en` text DEFAULT NULL,
  `ur` text DEFAULT NULL,
  `ar` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `translation`
--

INSERT INTO `translation` (`id`, `title`, `en`, `ur`, `ar`) VALUES
(1, 'en', 'English', NULL, NULL),
(2, 'ur', 'Urdu', NULL, NULL),
(3, 'unconfirmed', 'Unconfirmed', NULL, NULL),
(4, 'finished', 'Finished', NULL, NULL),
(5, 'drawing', 'Drawing', NULL, 'رسم'),
(6, 'painting', 'Painting', NULL, 'طلاء'),
(7, 'crafts', 'Crafts', NULL, 'حرف يدوية'),
(8, 'music', 'Music', NULL, 'موسيقى'),
(9, 'dancing', 'Dancing', NULL, 'رقص'),
(10, 'storytelling', 'Storytelling', NULL, 'قص الحكايات'),
(11, 'basic_math', 'Basic Math', NULL, 'رياضيات أساسية'),
(12, 'reading', 'Reading', NULL, 'قراءة'),
(13, 'writing', 'Writing', NULL, 'كتابة'),
(14, 'science_experiments', 'Science Experiments', NULL, 'تجارب علمية'),
(15, 'animal_studies', 'Animal Studies', NULL, 'دراسات الحيوانات'),
(16, 'shapes_and_colors', 'Shapes & Colors', NULL, 'الأشكال والألوان'),
(17, 'nature_walks', 'Nature Walks', NULL, 'تنزه في الطبيعة'),
(18, 'games_and_puzzles', 'Games & Puzzles', NULL, 'ألعاب وألغاز'),
(19, 'yoga_for_kids', 'Yoga for Kids', NULL, 'يوغا للأطفال'),
(20, 'moral_education', 'Moral Education', NULL, 'التربية الأخلاقية'),
(21, 'social_skills', 'Social Skills', NULL, 'مهارات اجتماعية'),
(22, 'gardening', 'Gardening', NULL, 'البستنة'),
(23, 'rhymes_and_poems', 'Rhymes & Poems', NULL, 'أغاني وقصائد'),
(24, 'cooking_simple_recipes', 'Cooking (Simple Recipes)', NULL, 'الطبخ (وصفات بسيطة)');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `name_ar` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `dob` datetime DEFAULT NULL,
  `gender` enum('m','f') DEFAULT NULL,
  `role` enum('admin','school','teacher','parent') DEFAULT NULL,
  `auth_key` varchar(255) NOT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `show_notification` tinyint(1) DEFAULT 1,
  `language` varchar(255) DEFAULT NULL,
  `status` enum('active','pending','blocked') DEFAULT 'pending',
  `status_ex` varchar(255) DEFAULT NULL,
  `business_website` varchar(500) DEFAULT NULL,
  `social_instagram` varchar(500) DEFAULT NULL,
  `social_facebook` varchar(500) DEFAULT NULL,
  `create_time` datetime DEFAULT current_timestamp(),
  `update_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `plan_id` int(11) NOT NULL DEFAULT 1,
  `plan_renewal_date` datetime DEFAULT NULL,
  `plan_expiry_date` datetime DEFAULT NULL,
  `plan_amount` decimal(19,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `name`, `name_ar`, `email`, `mobile`, `dob`, `gender`, `role`, `auth_key`, `password_hash`, `password_reset_token`, `show_notification`, `language`, `status`, `status_ex`, `business_website`, `social_instagram`, `social_facebook`, `create_time`, `update_time`, `plan_id`, `plan_renewal_date`, `plan_expiry_date`, `plan_amount`) VALUES
(1, 'mylakhana', 'Mubashir Younus', '', 'abdullah@gmail.com', '123456', NULL, 'm', 'teacher', 'myl-teacher', '$2y$13$gqR55p/lr3TktY5irUhQkOdYkCgHsc7rFWHb0V3Xx3uvLeOchiqzq', '123132456789', 1, 'en', 'active', '', NULL, NULL, NULL, '2024-01-02 19:12:23', '2025-01-26 14:15:06', 1, NULL, NULL, 0.00),
(2, 'ahmed123', 'Muhammad', '', 'mabdo@gmail.com', '', NULL, 'm', 'parent', 'myl-parent', '$2y$13$AOhzJHLxdsGLlnn31yfSOuueQ/2I9MFRZRJKwc5yZ3Mgu1FXyDrh6', '12313245678', 1, 'en', 'active', '', NULL, NULL, NULL, '2024-01-02 19:12:23', '2024-12-17 17:24:00', 1, NULL, NULL, 0.00),
(5, 'admin', 'admin', '', 'admin@mybabyapp.net', '123456', NULL, 'm', 'admin', 'adminauthkey', '$2y$13$fPTCpac6MlUELMh0z/vcxeNp/2pYhH6B56XGXFE/CTOsP5SKb4Umi', '12345678', 1, 'en', 'active', NULL, NULL, NULL, NULL, '2024-01-02 19:12:23', '2025-01-26 14:15:10', 3, '2025-01-06 11:56:55', '2095-02-05 11:56:55', 0.00),
(7, 'shavi-school', 'Dar ul HIjra International School', 'jbbEUj_b', 'shavi@gmail.com', '11111', NULL, NULL, 'school', 'KokjN4GIc5z4URP_rcD0_oXm2sgy5QcQ', '$2y$13$V4jgyeSpQ/JTGAP.hUmbfOhtigVLPcQ5gIGIDdvj7fHTPqmzHT3im', NULL, 1, 'en', 'active', 'plan_expired', '', 'https://instagram.com/shavischool', 'https://facebook.com/shavischool', '2024-10-08 22:13:36', '2025-01-27 12:36:29', 1, '2024-12-12 18:46:55', '2025-01-11 18:46:55', 0.00),
(8, 'alaqeeq', 'Al Aqeeq School', NULL, 'alaqeeq@gmail.com', '1111', NULL, NULL, 'school', '782hduY8dhp57gZN-50hrgi06LQERQLz', '$2y$13$5JqxFjZS2Lyt8GGY3t3qxuGN1pd90pEhO4hbCpuCCZssUy795prYu', NULL, 1, NULL, 'active', NULL, NULL, NULL, NULL, '2024-10-14 17:14:17', '2025-01-27 12:37:53', 1, '2025-01-27 15:37:53', '2025-02-10 15:37:53', 0.00),
(29, NULL, NULL, NULL, 'y@w.com', NULL, NULL, NULL, 'parent', 'PD5h3GPnky3L_FoNPVmt9SzSXKQJdSJl', '$2y$13$EGB2tDqlPBMLEYNtbFGUWeYKftnBKbugNZx4TKOp3wtUAorSrIm6C', NULL, 1, NULL, 'active', NULL, NULL, NULL, NULL, '2024-11-05 20:35:14', '2024-12-17 17:24:12', 1, NULL, NULL, 0.00),
(30, NULL, NULL, NULL, 'teacher@gmail.com', NULL, NULL, NULL, 'parent', 'oBQc8blNKXaR_Eo4r6XriMfR4aAlMO2M', '$2y$13$XI/k2gQEr4q69TNNA7sRQurtr8Cwudp4602JDsBOfS3ZDtZuU07Le', NULL, 1, NULL, 'active', NULL, NULL, NULL, NULL, '2024-11-05 20:38:28', '2024-12-17 17:24:14', 1, NULL, NULL, 0.00),
(31, NULL, NULL, NULL, 'abc@gmail.com', NULL, NULL, NULL, 'parent', 'kOSFiH6WyppOIJxJNA3As6eW42KZed1l', '$2y$13$qiVu.Ih3ZxdNBeAJ2hHaZO1TFco5ewX/qC75IgDldHneA3zcG2TnK', NULL, 1, NULL, 'active', NULL, NULL, NULL, NULL, '2024-11-05 20:39:13', '2024-12-17 17:24:18', 1, NULL, NULL, 0.00),
(42, 'yawar2171', 'Yawar', NULL, 'yyy@abc.com', NULL, NULL, NULL, 'teacher', 'LlJhNRza2V7ltgkdmpa6Uzk2xB1adyEW', '$2y$13$/WlwWv8/X.GAm6NB0fveIOUhD.hgjZjmgVqB/Sa6kZVZjoC1mnAwu', NULL, 1, NULL, 'active', NULL, NULL, NULL, NULL, '2024-11-06 20:27:21', '2025-01-26 14:14:14', 1, NULL, NULL, 0.00),
(43, 'parent001', 'Mohsin', NULL, 'parent001@gmail.com', NULL, NULL, NULL, 'parent', 'eu34cx2TLUNF2RQzYN5LWjWYByJDGe_X', '$2y$13$3yTR0.Usy3.raBkh/OKLa.M9NnufQhK2YxkNHyljixWBaDIUG3n6i', NULL, 1, NULL, 'active', NULL, NULL, NULL, NULL, '2024-11-06 20:33:05', '2024-12-17 17:24:24', 1, NULL, NULL, 0.00),
(44, 'demo-school', 'Demo Internation School and College', 'jbbEUj_b', 'demoschool@gmail.com', '', NULL, NULL, 'school', 'demo-school-auth-key', '$2y$13$V4jgyeSpQ/JTGAP.hUmbfOhtigVLPcQ5gIGIDdvj7fHTPqmzHT3im', 'jbbEUj_b', 1, 'en', 'pending', 'plan_expired', '', NULL, NULL, '2024-10-08 22:13:36', '2025-01-26 14:02:56', 1, '2024-11-07 19:04:20', '2025-01-01 19:04:20', 0.00),
(46, 'demoteacher', 'Demo Teacher', '', 'demoteacher@gmail.com', '534567890', NULL, NULL, 'teacher', 'FB6Xmt4KOxcB-djmiVQsa08RCZ0K4ZCr', '$2y$13$20NDm0.5HNLvFnOJOEClhep6B8HBnwjxuKUxagPgq4DlvI7iTf31.', 'KtTIc_U8', 1, NULL, 'active', '', NULL, NULL, NULL, '2024-11-16 22:38:46', '2024-12-17 17:24:30', 1, NULL, NULL, 0.00),
(54, 'demoparent', 'Demo Parent', '', 'demoparent@gmail.com', '544856525', NULL, NULL, 'parent', 'xrVf5qPLM6SEv6gBxxHNoLOdjJz1KQ23', '$2y$13$zepo5z8RfbthicPca/EZYOFOu/8C02WSseqrH4GSEdqHGKIoi8z.O', 'dF4ZK15T', 1, NULL, 'active', '', NULL, NULL, NULL, '2024-11-16 22:56:26', '2024-12-17 17:24:33', 1, NULL, NULL, 0.00),
(64, 'ahmadallvision', 'مدرسة المستقبل', NULL, 'ahmadallvision@gmail.com', '0556655665', NULL, NULL, 'school', 'ro-Ou3XbPhupYPmeFZc7yioQMVb9svf8', '$2y$13$sWN/PSS/YVTg5Mo33jRpFes4yu9sgb6O6OPjQTPdN9E9NvAHfzN2.', NULL, 1, 'en', 'active', NULL, NULL, NULL, NULL, '2024-12-17 18:53:52', '2025-01-20 08:45:15', 3, '2025-01-05 11:22:02', '2025-03-01 18:53:52', 0.00),
(65, 'testteacher', 'سميرة', '', 'developer.mybabyapp@gmail.com', '556655665', NULL, NULL, 'teacher', 'wB18fDQaf2qLTx8edXCTA3aL947NkuK-', '$2y$13$7oV2pYtxLbD4W3ZvIL2pju/A4umnoWjXPI.GtKZoCTP9sDnMBlbUS', '_wTLQdOI', 1, NULL, 'active', NULL, NULL, NULL, NULL, '2024-12-17 18:58:26', '2024-12-19 17:54:35', 1, NULL, NULL, 0.00),
(66, 'solution', 'محمد خالد', '', 'solution@tatabu.co', '565656564', NULL, NULL, 'parent', '8c9eCdw-03mphnforucjhieJ8X6NZrVX', '$2y$13$DmTynVQyO7P/QhyDWXA0EeqIsAvf21c.JbR9Hb01eNhT5TNtuqYPC', 'ZjNy5vUt', 1, NULL, 'active', NULL, NULL, NULL, NULL, '2024-12-17 19:08:09', '2024-12-18 13:12:48', 1, NULL, NULL, 0.00),
(67, 'teacherpro', 'Yawar Teacher', '', 'aaa@aaaa.comteacher', '11111', NULL, NULL, 'teacher', 'rPjEWivOGobs21l_dYr2z9h9EuxbXxWL', '$2y$13$SDkApOyAKywGfb/67.6zG.IqSxT21f9mK8iKnskOoD9QP8Ql.wcOu', 'cWjgTbMH', 1, NULL, 'active', '', NULL, NULL, NULL, '2024-12-19 20:18:31', '2025-01-26 14:19:06', 1, NULL, NULL, 0.00),
(68, 'parentpro', 'Yawar Parent', '', 'aaa@bbb.comparent', '123456789', NULL, NULL, 'parent', 'VHzZ-MIW96QJxUXcWdWAUYwy7WntBGj5', '$2y$13$/3OQHcKQzxs/oKWE24u2V.0q.UnVkK9KKtOJpACG4R3uKYBe7K1K2', 'PhaTMdQc', 1, NULL, 'active', '', NULL, NULL, NULL, '2024-12-19 20:20:31', '2025-01-26 14:14:35', 1, NULL, NULL, 0.00),
(69, 'yawar217', NULL, NULL, 'aaa@aaa.com', NULL, NULL, NULL, 'teacher', 'SxwjO0Z57BGK_FWWV9fQChxjx2mtj-Nk', '$2y$13$/DkkiCnQXnz7ABTGXlIvEu8vljd39kUP9RJakin1QMvo8TcnjpzHi', 'sWmk6JlC', 1, NULL, 'pending', 'invited', NULL, NULL, NULL, '2024-12-19 20:50:43', '2025-01-26 14:14:41', 1, NULL, NULL, 0.00),
(70, 'info', 'سالم مساعد', '', 'info@tatabu.co', '555563737', NULL, NULL, 'parent', 'jtloIVcxFtq5dhx_GQE76InoFKCBoeZf', '$2y$13$/smtL9rKooNce3TQA5WSw.kzjQAVduHV8xC1lIui3yMHW299/628m', 'PlbmecAa', 1, NULL, 'active', '', NULL, NULL, NULL, '2024-12-20 16:44:52', '2025-01-09 14:52:18', 1, NULL, NULL, 0.00),
(71, 'ss', NULL, NULL, 'SS@gmail.com', NULL, NULL, NULL, 'teacher', 'Vv2anCRSCOpZ59iUg95wo8dAra0dO-bF', '$2y$13$FDdNbGL6XMU34jwYBpLS1.Yb6h/t6qEGvZWa5qULLU4rAGRAWXcP6', 'nc-mu4NL', 1, NULL, 'pending', 'invited', NULL, NULL, NULL, '2024-12-30 14:43:23', '2024-12-30 11:43:23', 1, NULL, NULL, 0.00),
(72, 'alharbisumayyah', 'مدارس المتقدمة', NULL, 'alharbisumayyah@gmail.com', '', NULL, NULL, 'school', 'B-_ZtrYcsr2xDTzXOdVFhVat-U4nGWv8', '$2y$13$/f5rCwzHTBHW7NKYJEIqBOAfETQqxQeJjvUVDrv6oXw7CgI00JrZe', 'ZRlcaJSH', 1, 'ar', 'active', NULL, NULL, NULL, NULL, '2024-12-30 15:00:22', '2025-01-22 07:14:45', 3, '2025-01-22 10:14:45', '2025-02-21 10:14:45', 0.00),
(73, 'hnadi', NULL, NULL, 'hnadi@gmail.com', NULL, NULL, NULL, 'teacher', 'jnyxXr-rR8H1OSlrGlEOcQhFvPr1M8O5', '$2y$13$s2hRha4CY38.Jy1BvyaAmuesPthHQG./DTvDqBhJpb.0asw25pNcW', 'BU3UpckP', 1, NULL, 'pending', 'invited', NULL, NULL, NULL, '2024-12-30 15:06:37', '2024-12-30 12:06:37', 1, NULL, NULL, 0.00),
(74, 'smaasabus', 'Shahd', '', 'smaa.sa.bus@gmail.com', '548217050', NULL, NULL, 'teacher', 't5TE_pRQZH38mlmJZZw_QJWz_7FQjTHJ', '$2y$13$4aOzXyFgJSX1h1U8wUbwTOYVibNjTNkbCRgRm.xHlfme3r1CKFizq', '4UFpw_PY', 1, NULL, 'active', '', NULL, NULL, NULL, '2024-12-30 15:09:36', '2025-01-13 20:32:12', 1, NULL, NULL, 0.00),
(75, 'ahmadalharbia', 'عمر أحمد', '', 'ahmad.alharbi.a@hotmail.com', '553355335', NULL, NULL, 'parent', 'AaR6Wf1WwYpw2MGBy-HwOYUvzUehCS0y', '$2y$13$bbaUB.JcUUv4dsx26vLBnuWWDnN3aOY5d3R7Zz/80d7M.ULOqrX0q', 'pZZkx0fg', 1, NULL, 'active', NULL, NULL, NULL, NULL, '2024-12-30 15:22:20', '2024-12-30 12:37:13', 1, NULL, NULL, 0.00),
(76, 'hsalharbii77', 'علياء محمد', '', 'h.s.alharbii77@gmail.com', '555898768', NULL, NULL, 'teacher', 'sS1fUMRDRLfS3z9zQ8GBLKYDtJxva4Hq', '$2y$13$VZrzoO7T6ZPW7e2jWXApKecaUgM5GQCiWqGLhId9leiCxNZg9zQ/S', 'E2xc6bSB', 1, NULL, 'active', NULL, NULL, NULL, NULL, '2025-01-09 20:11:08', '2025-01-09 18:37:41', 1, NULL, NULL, 0.00),
(77, 'almoghair1418', 'فيصل فهد ', '', 'Almoghair1418@gmail.com', '569009165', NULL, NULL, 'parent', '8opNVQpOepm1KydP68HtXMqBvighvtKI', '$2y$13$qxUCioaxGSE1yu5x/.srNettMImeKEU.QG3vumzHwhjis1NYcYYv.', 'AlHnKxdr', 1, NULL, 'active', '', NULL, NULL, NULL, '2025-01-09 21:42:45', '2025-01-09 18:48:43', 1, NULL, NULL, 0.00),
(78, 'ro14ro8', 'ريان', '', 'Ro14ro8@gmail.com', '541614121', NULL, NULL, 'teacher', 'y1qOuKXfrz2-zHYVh6Qq0AcSOmomH-sP', '$2y$13$dSAyl6fR1N1srCuf8OV.Yux6Y8dDvXY5rmiPgY7CKS2kr/HtnKgZO', 'NPpbzCSi', 1, NULL, 'active', NULL, NULL, NULL, NULL, '2025-01-12 13:52:57', '2025-01-12 10:57:24', 1, NULL, NULL, 0.00),
(79, 'gloriarr121', 'فهد', '', 'Gloriarr121@gmail.com', '541614121', NULL, NULL, 'parent', 'hwv1IncOxa1I2Q69V7p5n8-YwA_eeMPz', '$2y$13$Z8gtLWv7xIzFPlRRgtYVxewgIMAz00TLJv9DYhQNarTPFRqcagPle', '-is_MAui', 1, NULL, 'active', NULL, NULL, NULL, NULL, '2025-01-12 15:14:44', '2025-01-12 12:17:21', 1, NULL, NULL, 0.00),
(80, 'safaaalharby', 'safaa', '', 'safaaalharby@gmail.com', '583847300', NULL, NULL, 'teacher', '1U0EigsIjfGIKbX-pb-O80ExCZdMNNoA', '$2y$13$Uk6FSkjIu2ZnC/.4l46QDe/EhF/gpUGFlA1hQxhgNNNpMEkw8NBGS', 'QWmDi_rN', 1, NULL, 'active', NULL, NULL, NULL, NULL, '2025-01-12 15:32:04', '2025-01-13 09:08:16', 1, NULL, NULL, 0.00),
(81, 'munirahmad', 'Educators School', NULL, 'munirahmad@gmail.com', '', NULL, NULL, 'school', 'YyPh_G0ASRkRWQVUgRvi5ZvsK9VxOqg9', '$2y$13$US4k06d07L9nsjgTwP2YFeZF/dKbGF6LrsBJvwhfPjcqjObIiGXzq', NULL, 1, NULL, 'active', NULL, NULL, NULL, NULL, '2025-01-27 16:06:53', '2025-01-27 13:09:49', 1, '2025-01-27 16:06:53', '2025-02-10 16:06:53', 0.00),
(82, 'mrmunirahmad', NULL, NULL, 'mrmunirahmad@hotmail.com', NULL, NULL, NULL, 'teacher', 'AX1klhMQL79GoVbAMWxDjSRlPiVXnukt', '$2y$13$pRPYoQiEmV9UqdGnXLHOKegyC67ygejLDJIb2chzf.vnQIkb/3Bzy', 'WY2KC1Uj', 1, NULL, 'pending', 'invited', NULL, NULL, NULL, '2025-01-27 16:10:19', '2025-01-27 13:10:19', 1, NULL, NULL, 0.00),
(83, 'hamzaalibhatti', 'Test School ', NULL, 'hamza_ali_bhatti@yahoo.com', '977 333 4444', NULL, NULL, 'school', '-8tRvL0ruO2RHvjzdE4MI3FIeTPgkZZe', '$2y$13$icw0EqPtGlMYVxzMgJxQSeikY4NeTJOY9AURrKlgWL4zpRBj2cCTC', NULL, 1, NULL, 'active', NULL, NULL, NULL, NULL, '2025-01-29 10:32:04', '2025-01-29 07:38:31', 1, '2025-01-29 10:32:04', '2025-02-12 10:32:04', 0.00),
(84, 'hamzahussainbhatti', 'Test Teacher', '', 'hamzahussainbhatti@gmail.com', '531234567', NULL, NULL, 'teacher', 'Zo44mss8r4c071p_TgUkfnroRc29aqiA', '$2y$13$.7Bgq5GXA5cFlSHFH4Yzbuybjb0GQLPbKvMitUz6mKaZIR35i0GdS', 'qV2o94oZ', 1, NULL, 'active', NULL, NULL, NULL, NULL, '2025-01-29 10:40:27', '2025-01-29 08:25:52', 1, NULL, NULL, 0.00),
(85, 'kturnsolutions', 'Parent Test', '', 'kturnsolutions@gmail.com', '567654321', NULL, NULL, 'parent', 'ZTWelEA2Rjzr3S4aQblo-vHKlp8Eb60Q', '$2y$13$rDu7iwyLcaK3C.3iBntcUOdynAQixXjB5ee2H3ZWp9c.xDSFoppz.', '363djwgJ', 1, NULL, 'active', NULL, NULL, NULL, NULL, '2025-01-29 11:37:22', '2025-01-29 08:38:49', 1, NULL, NULL, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `user_attributes`
--

CREATE TABLE `user_attributes` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `key` varchar(255) DEFAULT NULL,
  `value` varchar(1000) DEFAULT NULL,
  `type` enum('public','private') DEFAULT 'public'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_attributes`
--

INSERT INTO `user_attributes` (`id`, `user_id`, `key`, `value`, `type`) VALUES
(1, 1, 'homepage_access', 'announcement,upcoming_event,attendance,result,social_media', 'public'),
(2, 46, 'homepage_access', 'announcement,upcoming_event,attendance,result,social_media', 'public'),
(3, 65, 'homepage_access', 'announcement,upcoming_event,attendance,result,social_media', 'public'),
(4, 67, 'homepage_access', 'announcement,upcoming_event,attendance,result,social_media', 'public'),
(5, 69, 'homepage_access', 'announcement,upcoming_event,attendance,result,social_media', 'public'),
(6, 71, 'homepage_access', 'announcement,upcoming_event,attendance,result,social_media', 'public'),
(7, 73, 'homepage_access', 'announcement,upcoming_event,attendance,result,social_media', 'public'),
(8, 74, 'homepage_access', 'announcement,upcoming_event,attendance,result,social_media', 'public'),
(9, 76, 'homepage_access', 'announcement,upcoming_event,attendance,result,social_media', 'public'),
(10, 78, 'homepage_access', 'announcement,upcoming_event,attendance,result,social_media', 'public'),
(11, 80, 'homepage_access', 'announcement,upcoming_event,attendance,result,social_media', 'public'),
(12, 82, 'homepage_access', 'announcement,upcoming_event,attendance,result,social_media', 'public'),
(13, 84, 'homepage_access', 'announcement,upcoming_event,attendance,result,social_media', 'public');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `grade_id` (`grade_id`);

--
-- Indexes for table `announcement_items`
--
ALTER TABLE `announcement_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcement_id` (`announcement_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `grade_id` (`grade_id`);

--
-- Indexes for table `audit_trail`
--
ALTER TABLE `audit_trail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_audit_trail_user_id` (`user_id`),
  ADD KEY `idx_audit_trail_model_id` (`model_id`),
  ADD KEY `idx_audit_trail_model` (`model`),
  ADD KEY `idx_audit_trail_field` (`field`),
  ADD KEY `idx_audit_trail_action` (`action`);

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `rule_name` (`rule_name`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device_preferences`
--
ALTER TABLE `device_preferences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_devicePreferences_to_device` (`device_id`);

--
-- Indexes for table `feed`
--
ALTER TABLE `feed`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `grade_id` (`grade_id`);

--
-- Indexes for table `feed_comments`
--
ALTER TABLE `feed_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `feed_id` (`feed_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `feed_likes`
--
ALTER TABLE `feed_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `feed_id` (`feed_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_id` (`school_id`);

--
-- Indexes for table `grade_ratio`
--
ALTER TABLE `grade_ratio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-grade_ratio-grade_id` (`grade_id`);

--
-- Indexes for table `grade_teacher`
--
ALTER TABLE `grade_teacher`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-grade_teacher-school_id` (`school_id`),
  ADD KEY `idx-grade_teacher-grade_id` (`grade_id`),
  ADD KEY `idx-grade_teacher-teacher_id` (`teacher_id`);

--
-- Indexes for table `grade_teacher_schedule`
--
ALTER TABLE `grade_teacher_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-grade_teacher_schedule-grade_id` (`grade_id`),
  ADD KEY `fk-grade_teacher_schedule-teacher_id` (`teacher_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-user-id-group_school_id` (`school_id`);

--
-- Indexes for table `group_members`
--
ALTER TABLE `group_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-group_members-group_id` (`group_id`),
  ADD KEY `fk-group_members-user_id` (`user_id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-messages-group_id` (`group_id`),
  ADD KEY `fk-messages-sender_id` (`sender_id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `plan`
--
ALTER TABLE `plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `preferences`
--
ALTER TABLE `preferences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `grade_id` (`grade_id`);

--
-- Indexes for table `student_schedule`
--
ALTER TABLE `student_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-student_schedule-student_id` (`student_id`),
  ADD KEY `fk-student_schedule-grade_id` (`grade_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_id` (`sale_id`);

--
-- Indexes for table `translation`
--
ALTER TABLE `translation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`),
  ADD KEY `idx-user-plan_id` (`plan_id`);

--
-- Indexes for table `user_attributes`
--
ALTER TABLE `user_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `announcement_items`
--
ALTER TABLE `announcement_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `audit_trail`
--
ALTER TABLE `audit_trail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `device`
--
ALTER TABLE `device`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `device_preferences`
--
ALTER TABLE `device_preferences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=937;

--
-- AUTO_INCREMENT for table `feed`
--
ALTER TABLE `feed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `feed_comments`
--
ALTER TABLE `feed_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `feed_likes`
--
ALTER TABLE `feed_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `grade`
--
ALTER TABLE `grade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `grade_ratio`
--
ALTER TABLE `grade_ratio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `grade_teacher`
--
ALTER TABLE `grade_teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `grade_teacher_schedule`
--
ALTER TABLE `grade_teacher_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `group_members`
--
ALTER TABLE `group_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `plan`
--
ALTER TABLE `plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `preferences`
--
ALTER TABLE `preferences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=800046;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `student_schedule`
--
ALTER TABLE `student_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `translation`
--
ALTER TABLE `translation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `user_attributes`
--
ALTER TABLE `user_attributes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcement`
--
ALTER TABLE `announcement`
  ADD CONSTRAINT `announcement_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `announcement_ibfk_2` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`);

--
-- Constraints for table `announcement_items`
--
ALTER TABLE `announcement_items`
  ADD CONSTRAINT `announcement_items_ibfk_1` FOREIGN KEY (`announcement_id`) REFERENCES `announcement` (`id`),
  ADD CONSTRAINT `announcement_items_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`);

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`),
  ADD CONSTRAINT `attendance_ibfk_3` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`);

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_assignment_ibfk_2` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `device_preferences`
--
ALTER TABLE `device_preferences`
  ADD CONSTRAINT `fk_devicePreferences_to_device` FOREIGN KEY (`device_id`) REFERENCES `device` (`id`);

--
-- Constraints for table `feed`
--
ALTER TABLE `feed`
  ADD CONSTRAINT `feed_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `feed_ibfk_2` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`);

--
-- Constraints for table `feed_comments`
--
ALTER TABLE `feed_comments`
  ADD CONSTRAINT `feed_comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `feed_comments_ibfk_2` FOREIGN KEY (`feed_id`) REFERENCES `feed` (`id`),
  ADD CONSTRAINT `feed_comments_ibfk_3` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`);

--
-- Constraints for table `feed_likes`
--
ALTER TABLE `feed_likes`
  ADD CONSTRAINT `feed_likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `feed_likes_ibfk_2` FOREIGN KEY (`feed_id`) REFERENCES `feed` (`id`),
  ADD CONSTRAINT `feed_likes_ibfk_3` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`);

--
-- Constraints for table `grade`
--
ALTER TABLE `grade`
  ADD CONSTRAINT `grade_ibfk_2` FOREIGN KEY (`school_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `grade_ratio`
--
ALTER TABLE `grade_ratio`
  ADD CONSTRAINT `fk-grade_ratio-grade_id` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `grade_teacher`
--
ALTER TABLE `grade_teacher`
  ADD CONSTRAINT `fk-grade_teacher-grade_id` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-grade_teacher-school_id` FOREIGN KEY (`school_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-grade_teacher-teacher_id` FOREIGN KEY (`teacher_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `grade_teacher_schedule`
--
ALTER TABLE `grade_teacher_schedule`
  ADD CONSTRAINT `fk-grade_teacher_schedule-grade_id` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk-grade_teacher_schedule-teacher_id` FOREIGN KEY (`teacher_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `fk-user-id-group_school_id` FOREIGN KEY (`school_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `group_members`
--
ALTER TABLE `group_members`
  ADD CONSTRAINT `fk-group_members-group_id` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-group_members-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk-messages-group_id` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-messages-sender_id` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`);

--
-- Constraints for table `student_schedule`
--
ALTER TABLE `student_schedule`
  ADD CONSTRAINT `fk-student_schedule-grade_id` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-student_schedule-student_id` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sale` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk-user-plan_id` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_attributes`
--
ALTER TABLE `user_attributes`
  ADD CONSTRAINT `user_attributes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
