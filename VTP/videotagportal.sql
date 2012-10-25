-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 25, 2012 at 05:09 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `videotagportal`
--

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE IF NOT EXISTS `favorites` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) NOT NULL COMMENT '`user`.`id`',
  `videoId` int(10) NOT NULL COMMENT '`video`.`id`',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` varchar(50) NOT NULL COMMENT 'Host Id',
  `dateRegistered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `hostSite` varchar(25) NOT NULL COMMENT 'Ex: Facebook, Google',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `yttags`
--

CREATE TABLE IF NOT EXISTS `yttags` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `videoId` varchar(255) NOT NULL,
  `userId` varchar(50) NOT NULL COMMENT '`users`.`id`',
  `start` int(10) NOT NULL COMMENT 'seconds',
  `end` int(10) NOT NULL COMMENT 'seconds',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `action` varchar(50) NOT NULL COMMENT 'image, comment, map,...',
  `content` text NOT NULL COMMENT 'imageUrl, commentText, mapsUrl,...',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 COMMENT='Tags Info for Youtube videos' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `yttags`
--

INSERT INTO `yttags` (`id`, `videoId`, `userId`, `start`, `end`, `date`, `action`, `content`) VALUES
(1, 'BFph8eXlB98', '', 4, 8, '0000-00-00 00:00:00', 'image', 'https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcRF6nSnsEAP9IxgU4dx_iarcl64TFix6rXG9MkpXgAQA5AjzOCehA');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
