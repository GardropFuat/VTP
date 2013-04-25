-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 25, 2013 at 06:50 PM
-- Server version: 5.1.63-cll
-- PHP Version: 5.3.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vtp`
--

-- --------------------------------------------------------

--
-- Table structure for table `ContainerPos`
--

CREATE TABLE IF NOT EXISTS `ContainerPos` (
  `userId` int(10) NOT NULL,
  `video_x` int(10) DEFAULT NULL,
  `video_y` int(10) DEFAULT NULL,
  `tagContainer1_x` int(10) DEFAULT NULL,
  `tagContainer1_y` int(10) DEFAULT NULL,
  `comment_x` int(10) DEFAULT NULL,
  `comment_y` int(10) DEFAULT NULL,
  `title_x` int(10) DEFAULT NULL,
  `title_y` int(10) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE IF NOT EXISTS `favorites` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` varchar(50) NOT NULL,
  `videoId` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `googleId` varchar(50) NOT NULL,
  `facebookId` varchar(50) NOT NULL,
  `googleRefreshtkn` varchar(50) NOT NULL,
  `friendIds` text NOT NULL COMMENT 'vtpUserIds of Facebook friends',
  `dateRegistered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

--
-- Table structure for table `vimeoTags`
--

CREATE TABLE IF NOT EXISTS `vimeoTags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` varchar(50) DEFAULT NULL,
  `videoId` varchar(255) DEFAULT NULL,
  `start` int(11) DEFAULT NULL,
  `end` int(11) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `content` text,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `yttags`
--

CREATE TABLE IF NOT EXISTS `yttags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `videoId` varchar(255) DEFAULT NULL,
  `userId` varchar(50) DEFAULT NULL,
  `start` int(11) DEFAULT NULL,
  `end` int(11) DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `action` varchar(50) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Tags Info for Youtube videos' AUTO_INCREMENT=43 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
