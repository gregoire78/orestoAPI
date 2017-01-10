-- Adminer 4.2.4 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `oresto`;
CREATE DATABASE `oresto` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `oresto`;

DROP TABLE IF EXISTS `restaurants`;
CREATE TABLE `restaurants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `postal_code` int(11) NOT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date_register` datetime,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `restaurants` (`id`, `name`, `city`, `postal_code`, `latitude`, `longitude`, `address`, `description`, `image`, `date_register`) VALUES
(1,	'marin',	'maule',	78580,	NULL,	NULL,	'25 rue saint vincent',	'description',	NULL,	'2017-01-06 01:30:50'),
(2,	'greg',	'maule',	78580,	NULL,	NULL,	'25 rue saint vincent',	'descr',	NULL,	'2017-01-06 01:30:50'),
(6,	'lolo',	'paris',	75020,	NULL,	NULL,	'27 rue des gg',	'bouh',	NULL,	'2017-01-06 01:34:29');

DROP TABLE IF EXISTS `test`;
CREATE TABLE `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `test` (`id`, `text`) VALUES
(1,	'greg'),
(2,	'greg');

-- 2017-01-06 00:36:55
