-- Adminer 4.8.1 MySQL 8.0.31 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `test`;
CREATE DATABASE `test` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `test`;

DROP TABLE IF EXISTS `Comment`;
CREATE TABLE `Comment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `post_id` int DEFAULT NULL,
  `content` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `validity` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5BC96BF0A76ED395` (`user_id`),
  KEY `IDX_5BC96BF04B89032C` (`post_id`),
  CONSTRAINT `FK_5BC96BF04B89032C` FOREIGN KEY (`post_id`) REFERENCES `Post` (`id`),
  CONSTRAINT `FK_5BC96BF0A76ED395` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `Comment` (`id`, `user_id`, `post_id`, `content`, `date`, `validity`) VALUES
(1,	2,	1,	'Ceci est un commentaire',	'2023-03-07 09:37:35',	NULL);

DROP TABLE IF EXISTS `Post`;
CREATE TABLE `Post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `excerpt` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `content` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FAB8C3B3A76ED395` (`user_id`),
  CONSTRAINT `FK_FAB8C3B3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `Post` (`id`, `user_id`, `excerpt`, `content`, `date`, `title`) VALUES
(1,	2,	'Lorem ipsum dolor sit amet, consectetur adipiscing...',	'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dui massa, tempor id feugiat a, scelerisque eu neque. In scelerisque, odio et fermentum auctor, nibh risus dictum sem, vel dapibus nisi ante eu quam. Mauris tincidunt interdum viverra. Donec fringilla fermentum ex. Cras egestas diam et ante consectetur, non tempus metus posuere. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam eu nunc mollis, aliquam turpis a, bibendum neque. Maecenas ut sapien nulla.\r\n\r\nIn et auctor eros. Ut egestas suscipit felis at vestibulum. Donec auctor massa eget arcu volutpat posuere. Sed vehicula urna sapien, imperdiet tincidunt turpis porta at. Maecenas eu porttitor lacus, in aliquet leo. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In hac habitasse platea dictumst. Duis molestie placerat massa quis porttitor. Sed nibh neque, viverra id consectetur et, ultricies et arcu. Donec bibendum nunc ipsum, nec commodo lorem ullamcorper a. Morbi ac tortor turpis.\r\n\r\nProin dui nibh, cursus sit amet euismod eu, dignissim vel justo. Mauris nec metus sem. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Ut ac leo ac nunc posuere molestie. Curabitur tempus eu felis non lacinia. Proin tortor tortor, gravida in posuere non, vehicula vitae leo. Ut facilisis, felis lacinia faucibus suscipit, ipsum tortor mollis dolor, a facilisis sapien orci in libero. Morbi euismod nisl id pellentesque suscipit.\r\n\r\nCurabitur pellentesque sem mauris, sit amet maximus dolor ultricies non. Fusce lacus enim, fermentum non consequat aliquet, aliquam vitae augue. Vivamus ac condimentum odio, rhoncus sollicitudin enim. Nunc sagittis est at magna sagittis, vitae euismod eros fringilla. Etiam tristique rutrum sem nec blandit. Aenean interdum erat nec urna semper placerat a id justo. Integer rhoncus pellentesque felis, ut tempus est varius eget. Nam eget felis pharetra magna fringilla vulputate. Vivamus venenatis urna magna, vel lacinia nisl vehicula porttitor. Pellentesque eget diam neque. Vivamus leo lorem, luctus in porta vel, maximus nec tellus. Fusce pretium nisi vel erat tempor finibus sed ac ipsum. Vestibulum metus magna, pulvinar ac diam a, bibendum aliquet metus. Suspendisse laoreet eleifend nulla, vel luctus urna efficitur at. Ut quis tincidunt enim, vel varius lacus. Nulla tincidunt, ligula quis condimentum faucibus, metus urna egestas mauris, id vulputate erat felis et sapien.\r\n\r\nCras hendrerit ligula nec tortor semper, non elementum purus tincidunt. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Integer ullamcorper purus non nulla finibus rutrum. Nulla eget libero eu urna pretium aliquam a quis quam. Quisque pretium dolor vitae lorem tincidunt, in molestie metus posuere. Donec ante justo, iaculis eu est at, pharetra tempor sapien. Mauris vel luctus dui. Vivamus lobortis, libero eu congue mattis, orci eros vehicula magna, et sagittis sem eros ac felis. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vestibulum tempor in justo sit amet fermentum. Morbi eu bibendum lectus. Donec finibus urna eu egestas placerat. Maecenas commodo eros ut orci elementum, ac convallis leo semper. Sed dictum non purus ut lacinia.',	'2023-03-07 09:37:07',	'Lorem Ipsum');

DROP TABLE IF EXISTS `User`;
CREATE TABLE `User` (
  `id` int NOT NULL AUTO_INCREMENT,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `login` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `firstname` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `lastname` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `mail` varchar(125) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `role` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_2DA17977AA08CB10` (`login`),
  UNIQUE KEY `UNIQ_2DA179775126AC48` (`mail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `User` (`id`, `password`, `login`, `firstname`, `lastname`, `mail`, `role`) VALUES
(2,	'$2y$10$ddNv5ybhgWjVSCepmU.GEO6y/50BseV7wUo5bT7A6o0OEneJcoVOC',	'root',	'root',	'root',	'Root.root@root.com',	'admin');

-- 2023-03-07 09:42:24
