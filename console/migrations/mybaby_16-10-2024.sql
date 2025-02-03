# ************************************************************
# Sequel Ace SQL dump
# Version 20062
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: 127.0.0.1 (MySQL 8.0.27)
# Database: mybaby
# Generation Time: 2024-10-16 15:34:13 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table announcement
# ------------------------------------------------------------

DROP TABLE IF EXISTS `announcement`;

CREATE TABLE `announcement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `grade_id` int DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `type` enum('announcement','event') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'announcement',
  `time` timestamp NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'active',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `grade_id` (`grade_id`),
  CONSTRAINT `announcement_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `announcement_ibfk_2` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `announcement` WRITE;
/*!40000 ALTER TABLE `announcement` DISABLE KEYS */;

INSERT INTO `announcement` (`id`, `user_id`, `grade_id`, `title`, `body`, `type`, `time`, `status`, `create_time`, `update_time`)
VALUES
	(1,1,1,'We are here','hello everyone! exciting news. we finally have an app!','announcement','2024-09-25 14:46:29','active','2024-09-25 14:46:29','2024-10-15 16:57:16'),
	(2,1,1,'Birthday celebration','Ali\'s birthday will be celebrated in the evening','event','2024-10-15 15:22:01','active','2024-10-01 14:56:41','2024-10-16 18:15:52'),
	(3,1,1,'hello boys','come early tomorrow','announcement','2024-10-15 16:55:36','active','2024-10-15 16:55:44','2024-10-15 16:55:44');

/*!40000 ALTER TABLE `announcement` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table announcement_items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `announcement_items`;

CREATE TABLE `announcement_items` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `announcement_id` int DEFAULT NULL,
  `student_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `announcement_id` (`announcement_id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `announcement_items_ibfk_1` FOREIGN KEY (`announcement_id`) REFERENCES `announcement` (`id`),
  CONSTRAINT `announcement_items_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `announcement_items` WRITE;
/*!40000 ALTER TABLE `announcement_items` DISABLE KEYS */;

INSERT INTO `announcement_items` (`id`, `announcement_id`, `student_id`)
VALUES
	(1,1,1),
	(2,2,2),
	(3,2,1),
	(4,3,1),
	(5,3,2);

/*!40000 ALTER TABLE `announcement_items` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table attendance
# ------------------------------------------------------------

DROP TABLE IF EXISTS `attendance`;

CREATE TABLE `attendance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `student_id` int DEFAULT NULL,
  `grade_id` int DEFAULT NULL,
  `time_in` timestamp NULL DEFAULT NULL,
  `time_out` timestamp NULL DEFAULT NULL,
  `lunch` enum('no','half','full') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nap` int DEFAULT NULL COMMENT 'minutes',
  `bathroom_breaks` int DEFAULT NULL,
  `status` enum('present','absent','leave','holiday') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `student_id` (`student_id`),
  KEY `grade_id` (`grade_id`),
  CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`),
  CONSTRAINT `attendance_ibfk_3` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `attendance` WRITE;
/*!40000 ALTER TABLE `attendance` DISABLE KEYS */;

INSERT INTO `attendance` (`id`, `user_id`, `student_id`, `grade_id`, `time_in`, `time_out`, `lunch`, `nap`, `bathroom_breaks`, `status`, `create_time`, `update_time`)
VALUES
	(1,1,1,1,'2024-10-14 16:49:00',NULL,'half',NULL,3,'present','2024-10-15 16:49:51','2024-10-16 17:57:12'),
	(2,1,1,1,'2024-10-15 16:52:00','2024-10-15 21:57:00',NULL,NULL,NULL,'present','2024-10-15 16:52:52','2024-10-16 18:18:28');

/*!40000 ALTER TABLE `attendance` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table audit_trail
# ------------------------------------------------------------

DROP TABLE IF EXISTS `audit_trail`;

CREATE TABLE `audit_trail` (
  `id` int NOT NULL AUTO_INCREMENT,
  `old_value` text,
  `new_value` text,
  `action` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `field` varchar(255) DEFAULT NULL,
  `stamp` datetime NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `model_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_audit_trail_user_id` (`user_id`),
  KEY `idx_audit_trail_model_id` (`model_id`),
  KEY `idx_audit_trail_model` (`model`),
  KEY `idx_audit_trail_field` (`field`),
  KEY `idx_audit_trail_action` (`action`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;



# Dump of table auth_assignment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auth_assignment`;

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  `rule_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `rule_name` (`rule_name`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_assignment_ibfk_2` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`, `updated_at`, `rule_name`, `data`)
VALUES
	('admin','5',NULL,NULL,NULL,NULL),
	('developer','1',NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table auth_item
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auth_item`;

CREATE TABLE `auth_item` (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` int NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`)
VALUES
	('admin',2,'Access to all functions except dev configurations',NULL,NULL,NULL,NULL),
	('developer',1,'Access to ALL Functions',NULL,NULL,NULL,NULL),
	('school',4,'Basic Access',NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table auth_item_child
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auth_item_child`;

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;

INSERT INTO `auth_item_child` (`parent`, `child`)
VALUES
	('developer','admin'),
	('admin','school');

/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table auth_rule
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auth_rule`;

CREATE TABLE `auth_rule` (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;



# Dump of table device
# ------------------------------------------------------------

DROP TABLE IF EXISTS `device`;

CREATE TABLE `device` (
  `id` int NOT NULL AUTO_INCREMENT,
  `device_id` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `device_type` varchar(500) DEFAULT NULL COMMENT 'Android/iOS etc',
  `make` varchar(255) DEFAULT NULL COMMENT 'iphone',
  `model` varchar(255) DEFAULT NULL COMMENT '14 pro max',
  `os` varchar(255) DEFAULT NULL COMMENT '16.1',
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'when did user started using our app',
  `update_time` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `device` WRITE;
/*!40000 ALTER TABLE `device` DISABLE KEYS */;

INSERT INTO `device` (`id`, `device_id`, `device_type`, `make`, `model`, `os`, `name`, `email`, `mobile`, `create_time`, `update_time`)
VALUES
	(1,'42AEDEFA-B731-4557-A9F1-1944EEC40FC0','ios','iPhone','iPhone 15 Pro Max','17.0.1',NULL,NULL,NULL,'2024-03-18 02:07:17','2024-03-18 02:07:17'),
	(2,'samsung/b0qxxx/b0q:14/UP1A.231005.007/S908EXXS8DXD2:user/release-keys','android','samsung','b0qxxx','14',NULL,NULL,NULL,'2024-05-26 19:06:57','2024-05-26 19:06:57'),
	(3,'samsung/e3qxxx/e3q:14/UP1A.231005.007/S928BXXU1AXCA:user/release-keys','android','samsung','e3qxxx','14',NULL,NULL,NULL,'2024-05-26 19:57:03','2024-05-26 19:57:03'),
	(4,'samsung/e3qxxx/e3q:14/UP1A.231005.007/S928BXXS2AXD5:user/release-keys','android','samsung','e3qxxx','14',NULL,NULL,NULL,'2024-05-27 10:00:51','2024-05-27 10:00:51'),
	(5,'EC89F392-EA29-4951-BBFB-50023E395AC1','ios','iPhone','iPhone 15 Pro Max','17.0.1',NULL,NULL,NULL,'2024-07-05 00:53:40','2024-07-05 00:53:40');

/*!40000 ALTER TABLE `device` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table device_preferences
# ------------------------------------------------------------

DROP TABLE IF EXISTS `device_preferences`;

CREATE TABLE `device_preferences` (
  `id` int NOT NULL AUTO_INCREMENT,
  `device_id` int DEFAULT NULL,
  `project` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'provider_app, client_app, etc.',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'last_used, views, likes, etc.',
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`),
  KEY `fk_devicePreferences_to_device` (`device_id`),
  CONSTRAINT `fk_devicePreferences_to_device` FOREIGN KEY (`device_id`) REFERENCES `device` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `device_preferences` WRITE;
/*!40000 ALTER TABLE `device_preferences` DISABLE KEYS */;

INSERT INTO `device_preferences` (`id`, `device_id`, `project`, `title`, `value`)
VALUES
	(1,1,'teacher','last_used','2024-06-27 18:04:22'),
	(2,1,'teacher','fcm_token','your_device_token_here'),
	(3,1,'teacher','user_id','1'),
	(4,1,'teacher','app_version','1.0'),
	(5,1,'parent','last_used','2024-06-27 18:48:20'),
	(6,1,'parent','fcm_token','your_device_token_here'),
	(7,1,'parent','user_id','4'),
	(8,1,'parent','app_version','1.0');

/*!40000 ALTER TABLE `device_preferences` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table feed
# ------------------------------------------------------------

DROP TABLE IF EXISTS `feed`;

CREATE TABLE `feed` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `grade_id` int DEFAULT NULL,
  `caption` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'active',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `grade_id` (`grade_id`),
  CONSTRAINT `feed_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `feed_ibfk_2` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `feed` WRITE;
/*!40000 ALTER TABLE `feed` DISABLE KEYS */;

INSERT INTO `feed` (`id`, `user_id`, `grade_id`, `caption`, `status`, `create_time`, `update_time`)
VALUES
	(1,1,1,'hello bros. this is my new feed post','active','2024-10-15 17:04:16','2024-10-15 17:05:03'),
	(2,1,1,'my 2nd post woohoo','active','2024-10-15 19:05:24','2024-10-15 19:05:24'),
	(3,1,1,'one post, 3 pics. waterfall is first','active','2024-10-16 14:30:27','2024-10-16 14:30:27');

/*!40000 ALTER TABLE `feed` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table feed_comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `feed_comments`;

CREATE TABLE `feed_comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `student_id` int DEFAULT NULL,
  `feed_id` int DEFAULT NULL,
  `comment` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `feed_id` (`feed_id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `feed_comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `feed_comments_ibfk_2` FOREIGN KEY (`feed_id`) REFERENCES `feed` (`id`),
  CONSTRAINT `feed_comments_ibfk_3` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `feed_comments` WRITE;
/*!40000 ALTER TABLE `feed_comments` DISABLE KEYS */;

INSERT INTO `feed_comments` (`id`, `user_id`, `student_id`, `feed_id`, `comment`, `create_time`, `update_time`)
VALUES
	(1,2,1,1,'nice post. 10 out of 10','2024-10-15 17:33:41','2024-10-15 18:00:46'),
	(2,2,1,1,'i didn\'t like it at all','2024-10-15 17:33:41','2024-10-15 18:00:47'),
	(3,1,NULL,1,'hello both','2024-10-15 18:29:23','2024-10-15 18:34:26'),
	(4,1,1,1,'assign','2024-10-15 18:33:27','2024-10-15 18:33:27'),
	(5,1,1,2,'hello','2024-10-15 19:08:20','2024-10-15 19:08:20'),
	(6,1,NULL,3,'meta legal comment','2024-10-16 15:10:58','2024-10-16 15:10:58'),
	(7,1,NULL,3,'second comm','2024-10-16 15:11:42','2024-10-16 15:11:42'),
	(8,2,2,3,'test comment from an','2024-10-16 16:26:45','2024-10-16 16:26:45'),
	(9,2,1,3,'Abdullah here','2024-10-16 16:26:59','2024-10-16 16:26:59');

/*!40000 ALTER TABLE `feed_comments` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table feed_likes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `feed_likes`;

CREATE TABLE `feed_likes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `student_id` int DEFAULT NULL,
  `feed_id` int DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `feed_id` (`feed_id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `feed_likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `feed_likes_ibfk_2` FOREIGN KEY (`feed_id`) REFERENCES `feed` (`id`),
  CONSTRAINT `feed_likes_ibfk_3` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `feed_likes` WRITE;
/*!40000 ALTER TABLE `feed_likes` DISABLE KEYS */;

INSERT INTO `feed_likes` (`id`, `user_id`, `student_id`, `feed_id`, `create_time`, `update_time`)
VALUES
	(14,1,NULL,1,'2024-10-16 15:15:28','2024-10-16 15:15:28'),
	(15,1,NULL,3,'2024-10-16 15:15:58','2024-10-16 15:15:58'),
	(20,2,1,3,'2024-10-16 16:26:00','2024-10-16 16:26:00'),
	(21,2,2,3,'2024-10-16 16:26:15','2024-10-16 16:26:15');

/*!40000 ALTER TABLE `feed_likes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table grade
# ------------------------------------------------------------

DROP TABLE IF EXISTS `grade`;

CREATE TABLE `grade` (
  `id` int NOT NULL AUTO_INCREMENT,
  `school_id` int DEFAULT NULL COMMENT 'user table',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `school_id` (`school_id`),
  CONSTRAINT `grade_ibfk_2` FOREIGN KEY (`school_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `grade` WRITE;
/*!40000 ALTER TABLE `grade` DISABLE KEYS */;

INSERT INTO `grade` (`id`, `school_id`, `title`)
VALUES
	(1,7,'Grade 1'),
	(2,4,'Grade 5'),
	(29,4,'Grade 12'),
	(31,4,'Grade 9'),
	(32,4,'Grade 2'),
	(34,4,'Grade 7'),
	(35,4,'Grade waahid');

/*!40000 ALTER TABLE `grade` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table grade_teacher
# ------------------------------------------------------------

DROP TABLE IF EXISTS `grade_teacher`;

CREATE TABLE `grade_teacher` (
  `id` int NOT NULL AUTO_INCREMENT,
  `school_id` int NOT NULL,
  `grade_id` int DEFAULT NULL,
  `teacher_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-grade_teacher-school_id` (`school_id`),
  KEY `idx-grade_teacher-grade_id` (`grade_id`),
  KEY `idx-grade_teacher-teacher_id` (`teacher_id`),
  CONSTRAINT `fk-grade_teacher-grade_id` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-grade_teacher-school_id` FOREIGN KEY (`school_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-grade_teacher-teacher_id` FOREIGN KEY (`teacher_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `grade_teacher` WRITE;
/*!40000 ALTER TABLE `grade_teacher` DISABLE KEYS */;

INSERT INTO `grade_teacher` (`id`, `school_id`, `grade_id`, `teacher_id`)
VALUES
	(9,4,31,17),
	(10,4,34,17),
	(14,4,29,17),
	(15,4,NULL,17),
	(16,4,1,1),
	(17,4,2,1);

/*!40000 ALTER TABLE `grade_teacher` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table image
# ------------------------------------------------------------

DROP TABLE IF EXISTS `image`;

CREATE TABLE `image` (
  `id` int NOT NULL AUTO_INCREMENT,
  `model` varchar(255) DEFAULT NULL COMMENT 'user, order, product, etc.',
  `model_id` int DEFAULT NULL,
  `category` varchar(500) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `image_src` varchar(255) DEFAULT NULL,
  `thumb_src` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `image` WRITE;
/*!40000 ALTER TABLE `image` DISABLE KEYS */;

INSERT INTO `image` (`id`, `model`, `model_id`, `category`, `filename`, `image_src`, `thumb_src`, `description`, `create_time`, `update_time`)
VALUES
	(1,'feed',1,NULL,'670e766033424.jpg','uploads/feed/670e766033424.jpg',NULL,NULL,'2024-10-15 17:04:16','2024-10-15 17:04:16'),
	(2,'feed',2,NULL,'670e92c517aac.jpg','uploads/feed/670e92c517aac.jpg',NULL,NULL,'2024-10-15 19:05:25','2024-10-15 19:05:25'),
	(3,'feed',2,NULL,'670e92c518163.jpg','uploads/feed/670e92c518163.jpg',NULL,NULL,'2024-10-15 19:05:25','2024-10-15 19:05:25'),
	(4,'feed',3,NULL,'670fa3d427420.jpg','uploads/feed/670fa3d427420.jpg',NULL,NULL,'2024-10-16 14:30:28','2024-10-16 14:30:28'),
	(5,'feed',3,NULL,'670fa3d427713.jpg','uploads/feed/670fa3d427713.jpg',NULL,NULL,'2024-10-16 14:30:28','2024-10-16 14:30:28'),
	(6,'feed',3,NULL,'670fa3d4277ae.jpg','uploads/feed/670fa3d4277ae.jpg',NULL,NULL,'2024-10-16 14:30:28','2024-10-16 14:30:28');

/*!40000 ALTER TABLE `image` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table logs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `logs`;

CREATE TABLE `logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `model` varchar(255) DEFAULT NULL,
  `model_id` varchar(255) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `color` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


# Dump of table preferences
# ------------------------------------------------------------

DROP TABLE IF EXISTS `preferences`;

CREATE TABLE `preferences` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Project name',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `status` smallint DEFAULT '1',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

LOCK TABLES `preferences` WRITE;
/*!40000 ALTER TABLE `preferences` DISABLE KEYS */;

INSERT INTO `preferences` (`id`, `project`, `title`, `value`, `status`, `create_time`, `update_time`)
VALUES
	(16,'provider_app','android_version','2.23',1,'2023-05-09 18:05:36','2023-05-09 18:59:41'),
	(17,'provider_app','ios_version','1.0',1,'2023-05-09 18:13:03','2024-03-16 22:07:06'),
	(18,'client_app','ios_version','1.0',1,'2020-06-25 10:29:10','2023-03-15 02:11:11'),
	(19,'mybaby','image_url','https://api.mybaby.test/',1,'2024-07-15 20:00:06','2024-10-15 17:05:49');

/*!40000 ALTER TABLE `preferences` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table student
# ------------------------------------------------------------

DROP TABLE IF EXISTS `student`;

CREATE TABLE `student` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent_id` int DEFAULT NULL,
  `grade_id` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_ar` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` datetime DEFAULT NULL,
  `gender` enum('m','f') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `health` json DEFAULT NULL,
  `allergies` json DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `status_ex` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `grade_id` (`grade_id`),
  CONSTRAINT `student_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `user` (`id`),
  CONSTRAINT `student_ibfk_2` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;

INSERT INTO `student` (`id`, `parent_id`, `grade_id`, `name`, `name_ar`, `dob`, `gender`, `health`, `allergies`, `status`, `status_ex`, `create_time`, `update_time`)
VALUES
	(1,2,1,'Abdullah Saleem','Abdullah Saleem','1990-06-16 00:00:00','m',NULL,NULL,'active',NULL,'2024-10-01 14:24:25','2024-10-15 18:02:16'),
	(2,2,1,'Hashim Ilyas','Hashim Ilyas','2006-06-16 00:00:00','m',NULL,NULL,'active',NULL,'2024-10-01 14:24:25','2024-10-15 18:02:17');

/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table translation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `translation`;

CREATE TABLE `translation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `en` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `ur` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

LOCK TABLES `translation` WRITE;
/*!40000 ALTER TABLE `translation` DISABLE KEYS */;

INSERT INTO `translation` (`id`, `title`, `en`, `ur`)
VALUES
	(1,'en','English',NULL),
	(2,'ur','Urdu',NULL),
	(3,'unconfirmed','Unconfirmed',NULL),
	(4,'finished','Finished',NULL);

/*!40000 ALTER TABLE `translation` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_ar` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` datetime DEFAULT NULL,
  `gender` enum('m','f') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` enum('admin','school','teacher','parent') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `show_notification` tinyint(1) DEFAULT '1',
  `language` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('active','pending','blocked') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'pending',
  `status_ex` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`id`, `username`, `name`, `name_ar`, `email`, `mobile`, `dob`, `gender`, `role`, `auth_key`, `password_hash`, `password_reset_token`, `show_notification`, `language`, `status`, `status_ex`, `create_time`, `update_time`)
VALUES
	(1,'teacher','Mubashir Teacher','','abdullah@gmail.com','122',NULL,'m','teacher','myl-teacher','$2y$13$fPTCpac6MlUELMh0z/vcxeNp/2pYhH6B56XGXFE/CTOsP5SKb4Umi','123132456789',1,'en','active',NULL,'2024-01-02 19:12:23','2024-10-15 15:38:20'),
	(2,'parent','Mubashir Younus','','parent@gmail.com','111',NULL,'m','parent','myl-parent','$2y$13$fPTCpac6MlUELMh0z/vcxeNp/2pYhH6B56XGXFE/CTOsP5SKb4Umi','12313245678',1,'en','active',NULL,'2024-01-02 19:12:23','2024-10-08 12:56:37'),
	(4,'testschool','Test School','','','123',NULL,'m','school','schoolauthkey','$2y$13$fPTCpac6MlUELMh0z/vcxeNp/2pYhH6B56XGXFE/CTOsP5SKb4Umi','123456789',1,'en','active',NULL,'2024-01-02 19:12:23','2024-10-15 01:29:43'),
	(5,'admin','admin','','admin@mybabyapp.net','123456789',NULL,'m','admin','adminauthkey','$2y$13$fPTCpac6MlUELMh0z/vcxeNp/2pYhH6B56XGXFE/CTOsP5SKb4Umi','12345678',1,'ar','active',NULL,'2024-01-02 19:12:23','2024-10-15 02:55:00'),
	(7,'yyounus','Yawar','jbbEUj_b','Yyounus@aaa.com','1123445',NULL,NULL,'school','KokjN4GIc5z4URP_rcD0_oXm2sgy5QcQ','$2y$13$V4jgyeSpQ/JTGAP.hUmbfOhtigVLPcQ5gIGIDdvj7fHTPqmzHT3im',NULL,1,NULL,'active',NULL,'2024-10-08 22:13:36','2024-10-09 20:43:08'),
	(15,'teacher1','yawar','YlRhItAa','teacher@gmail.cpom','123456789',NULL,NULL,'teacher','JMVkkJlAsBoDx4kI_gxAHrZ67-F867Qz','$2y$13$5p0Zb6pBDsZtDMJW2b005eAC9eOTfK3b.g7WWYT4mEAsCeazseb8W',NULL,1,NULL,'pending',NULL,'2024-10-13 21:52:29','2024-10-13 21:52:29'),
	(17,'teacher2','Yawar','','teacher@gmail.com','',NULL,NULL,'teacher','7OAzeKiZ1raLY4ABjw22W0-TPZ44s_Om','$2y$13$hMdrBL.iX3S.35xvWLaDvulQVr1d5wZALVGHEIW1B3JftIyg5joUi',NULL,1,NULL,'pending',NULL,'2024-10-13 21:55:30','2024-10-14 20:37:43'),
	(18,'abc','yawar','yq6QjEoe','abc@gmail.com','123456',NULL,NULL,'teacher','EBIAn2oWHdbiIGFO_htyCpQ54k8oKj1A','$2y$13$KZvPsnN.JmzZX0e5Wo.5QOtxxCAgR1ZG3zA.UHV8Oe.xl7YhJPNeG',NULL,1,NULL,'pending',NULL,'2024-10-14 13:42:27','2024-10-14 13:42:27'),
	(19,'aa','Yawara','fmfbmhfF','aa@gamil.com','123456',NULL,NULL,'teacher','g7Wk6PNjhAYVnEOpfrzB_ZuEf-eGva3C','$2y$13$m4H3m39dC9LGQOWaMR5QsOdZ4P7QP.cwyjUmmws2mhsXjoZnxjzEa',NULL,1,NULL,'pending',NULL,'2024-10-14 14:47:16','2024-10-14 14:47:16'),
	(21,'teacher123','Yawara','EiLbH1ok','teacher123@gamil.com','123456789',NULL,NULL,'teacher','bh342mpkZ8QZIvUO5lnBdMA5UuS__d8Z','$2y$13$r2y.9lz/j9W4RJ4WYiZx/O4m5xKQu3Y6T8xvR5beJUb0TP/iw8Kda',NULL,1,NULL,'pending',NULL,'2024-10-14 15:40:18','2024-10-14 15:40:18'),
	(23,'teacher1234','Yawara','sbd9jDaU','teacher1234@gamil.com','123456789',NULL,NULL,'teacher','Cfj5f8BUIuZKLLZPNCh4TGXZn0zutN5I','$2y$13$V0En8JZ9ArzV617nlx6/Ve6xG6HRa8E1rbcW44R3N.PoHtYLxgxxS',NULL,1,NULL,'pending',NULL,'2024-10-14 15:42:25','2024-10-14 15:42:25'),
	(25,'teacherxyz','Teacher XYZ','MYsTCk6B','TeacherXYZ@gmail.com','123456789',NULL,NULL,'teacher','mf-AQucMXupVhAMHpy-KunpMQqigLmUx','$2y$13$yaT6oSbGfI2qykvbdj/Hpe90yuy0FpY.cACYnDa5Qtwv9j36OWpzK',NULL,1,NULL,'pending',NULL,'2024-10-14 16:47:24','2024-10-14 16:47:24'),
	(26,'teachera','teachera','ogfcsPgH','teachera@gmail.com','11111',NULL,NULL,'school','782hduY8dhp57gZN-50hrgi06LQERQLz','$2y$13$5JqxFjZS2Lyt8GGY3t3qxuGN1pd90pEhO4hbCpuCCZssUy795prYu',NULL,1,NULL,'pending',NULL,'2024-10-14 17:14:17','2024-10-15 02:01:22');

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_attributes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_attributes`;

CREATE TABLE `user_attributes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `value` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `type` enum('public','private') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'public',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_attributes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `user_attributes` WRITE;
/*!40000 ALTER TABLE `user_attributes` DISABLE KEYS */;

INSERT INTO `user_attributes` (`id`, `user_id`, `key`, `value`, `type`)
VALUES
	(1,1,'homepage_access','announcement,upcoming_event,attendance,result,social_media','public');

/*!40000 ALTER TABLE `user_attributes` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
