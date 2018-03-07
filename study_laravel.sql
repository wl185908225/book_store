/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.7.17-log : Database - study_laravel
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`study_laravel` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `study_laravel`;

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_no` int(11) NOT NULL,
  `preview` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `categories` */

/*Table structure for table `members` */

DROP TABLE IF EXISTS `members`;

CREATE TABLE `members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` int(11) DEFAULT '0',
  `password` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `members` */

insert  into `members`(`id`,`nickname`,`email`,`phone`,`active`,`password`,`created_at`,`updated_at`) values (1,NULL,NULL,'15201956048',0,'e10adc3949ba59abbe56e057f20f883e','2018-01-14 22:43:19','2018-01-14 22:43:19'),(7,NULL,'185908225@qq.com',NULL,1,'e10adc3949ba59abbe56e057f20f883e','2018-01-15 21:36:35','2018-01-15 21:37:05');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2018_01_12_145720_create_sessions_table',1),(4,'2018_01_14_120658_create_members_table',2),(5,'2018_01_14_120715_create_categories_table',2),(6,'2018_01_14_120728_create_products_table',2),(7,'2018_01_14_120805_create_product_contents_table',3),(8,'2018_01_14_120821_create_product_images_table',3),(9,'2018_01_14_173825_create_temp_phones_table',4),(10,'2018_01_14_230153_create_temp_emails_table',5);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `product_contents` */

DROP TABLE IF EXISTS `product_contents`;

CREATE TABLE `product_contents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `product_contents` */

/*Table structure for table `product_images` */

DROP TABLE IF EXISTS `product_images`;

CREATE TABLE `product_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image_path` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_no` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `product_images` */

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `preview` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `products` */

/*Table structure for table `sessions` */

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sessions` */

insert  into `sessions`(`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) values ('KiQhW2hneYLfslV3gvVasMJZhrOt5w6kHH35f0jO',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRlFtQnpZRHhDUWxlV2k5TmVPMFJPOTdVc29CRzJuaEhuVmU5MjBESyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTc6Imh0dHA6Ly93d3cuc3R1ZHlfbGFyYXZlbC5jb20vc2VydmljZS92YWxpZGF0ZV9jb2RlL2NyZWF0ZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MTM6InZhbGlkYXRlX2NvZGUiO3M6NDoieWt2YSI7czo2OiJtZW1iZXIiO086MTc6IkFwcFxFbnRpdHlcTWVtYmVyIjoyNjp7czo4OiIAKgB0YWJsZSI7czo3OiJtZW1iZXJzIjtzOjEzOiIAKgBwcmltYXJ5S2V5IjtzOjI6ImlkIjtzOjEzOiIAKgBjb25uZWN0aW9uIjtzOjU6Im15c3FsIjtzOjEwOiIAKgBrZXlUeXBlIjtzOjM6ImludCI7czoxMjoiaW5jcmVtZW50aW5nIjtiOjE7czo3OiIAKgB3aXRoIjthOjA6e31zOjEyOiIAKgB3aXRoQ291bnQiO2E6MDp7fXM6MTA6IgAqAHBlclBhZ2UiO2k6MTU7czo2OiJleGlzdHMiO2I6MTtzOjE4OiJ3YXNSZWNlbnRseUNyZWF0ZWQiO2I6MDtzOjEzOiIAKgBhdHRyaWJ1dGVzIjthOjg6e3M6MjoiaWQiO2k6NztzOjg6Im5pY2tuYW1lIjtOO3M6NToiZW1haWwiO3M6MTY6IjE4NTkwODIyNUBxcS5jb20iO3M6NToicGhvbmUiO047czo2OiJhY3RpdmUiO2k6MTtzOjg6InBhc3N3b3JkIjtzOjMyOiJlMTBhZGMzOTQ5YmE1OWFiYmU1NmUwNTdmMjBmODgzZSI7czoxMDoiY3JlYXRlZF9hdCI7czoxOToiMjAxOC0wMS0xNSAyMTozNjozNSI7czoxMDoidXBkYXRlZF9hdCI7czoxOToiMjAxOC0wMS0xNSAyMTozNzowNSI7fXM6MTE6IgAqAG9yaWdpbmFsIjthOjg6e3M6MjoiaWQiO2k6NztzOjg6Im5pY2tuYW1lIjtOO3M6NToiZW1haWwiO3M6MTY6IjE4NTkwODIyNUBxcS5jb20iO3M6NToicGhvbmUiO047czo2OiJhY3RpdmUiO2k6MTtzOjg6InBhc3N3b3JkIjtzOjMyOiJlMTBhZGMzOTQ5YmE1OWFiYmU1NmUwNTdmMjBmODgzZSI7czoxMDoiY3JlYXRlZF9hdCI7czoxOToiMjAxOC0wMS0xNSAyMTozNjozNSI7czoxMDoidXBkYXRlZF9hdCI7czoxOToiMjAxOC0wMS0xNSAyMTozNzowNSI7fXM6MTA6IgAqAGNoYW5nZXMiO2E6MDp7fXM6ODoiACoAY2FzdHMiO2E6MDp7fXM6ODoiACoAZGF0ZXMiO2E6MDp7fXM6MTM6IgAqAGRhdGVGb3JtYXQiO047czoxMDoiACoAYXBwZW5kcyI7YTowOnt9czoxOToiACoAZGlzcGF0Y2hlc0V2ZW50cyI7YTowOnt9czoxNDoiACoAb2JzZXJ2YWJsZXMiO2E6MDp7fXM6MTI6IgAqAHJlbGF0aW9ucyI7YTowOnt9czoxMDoiACoAdG91Y2hlcyI7YTowOnt9czoxMDoidGltZXN0YW1wcyI7YjoxO3M6OToiACoAaGlkZGVuIjthOjA6e31zOjEwOiIAKgB2aXNpYmxlIjthOjA6e31zOjExOiIAKgBmaWxsYWJsZSI7YTowOnt9czoxMDoiACoAZ3VhcmRlZCI7YToxOntpOjA7czoxOiIqIjt9fX0=',1516028894);

/*Table structure for table `temp_emails` */

DROP TABLE IF EXISTS `temp_emails`;

CREATE TABLE `temp_emails` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `code` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deadline` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `temp_emails_member_id_unique` (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `temp_emails` */

insert  into `temp_emails`(`id`,`member_id`,`code`,`deadline`,`created_at`,`updated_at`) values (1,3,'c8ae155ec7ea8ec4b28696d7f5318d0b','2018-01-15 23:11:39','2018-01-14 23:11:39','2018-01-14 23:11:39'),(2,4,'c53afcfb27558d60c0d96359d54930e0','2018-01-15 23:11:58','2018-01-14 23:11:58','2018-01-14 23:11:58'),(3,5,'e51a43cebe72bf062167e99dd7fa6f9d','2018-01-15 23:14:19','2018-01-14 23:14:19','2018-01-14 23:14:19'),(4,6,'ab0988f7cf1addb2a177d765c0e8256b','2018-01-16 21:30:28','2018-01-15 21:30:28','2018-01-15 21:30:28'),(5,7,'db1c4fa5b1221face7b9e233a6db3df6','2018-01-16 21:36:35','2018-01-15 21:36:35','2018-01-15 21:36:35');

/*Table structure for table `temp_phones` */

DROP TABLE IF EXISTS `temp_phones`;

CREATE TABLE `temp_phones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` int(11) NOT NULL,
  `deadline` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `temp_phones` */

insert  into `temp_phones`(`id`,`phone`,`code`,`deadline`,`created_at`,`updated_at`) values (1,'15201956048',954768,'2018-01-14 23:43:01','2018-01-14 21:14:27','2018-01-14 22:43:01');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`password`,`remember_token`,`created_at`,`updated_at`) values (2,'william','185908225@qq.com','$2y$10$tw..u2Bpoq0shyCVyZyB3OIssxDspM1pEhcWG7K0i3PtCqiNBBZcG',NULL,'2018-01-13 07:48:44','2018-01-13 07:48:44'),(4,'william1','185908225@qq.cn','$2y$10$8F9glzsjYF6ug2pvechebeP0SppgNaFtMqR7M.TaDcimowRdkh6b.',NULL,'2018-01-13 07:50:02','2018-01-13 07:50:02');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
