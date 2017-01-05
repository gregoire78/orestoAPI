-- Adminer 4.2.4 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `oresto` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `oresto`;

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
  `date_register` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `restaurants` (`id`, `name`, `city`, `postal_code`, `latitude`, `longitude`, `address`, `description`, `image`, `date_register`) VALUES
(1,	'marin',	'maule',	78580,	NULL,	NULL,	'25 rue saint vincent',	'description',	NULL,	'2017-01-04 19:24:16'),
(2,	'greg',	'maule',	78580,	NULL,	NULL,	'25 rue saint vincent',	'descr',	NULL,	'2017-01-04 19:24:16');

CREATE TABLE `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `test` (`id`, `text`) VALUES
(1,	'greg'),
(2,	'greg');

-- 2017-01-05 21:09:51
