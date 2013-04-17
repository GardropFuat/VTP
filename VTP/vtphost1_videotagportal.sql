-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 17, 2013 at 06:13 PM
-- Server version: 5.1.63-cll
-- PHP Version: 5.3.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vtphost1_videotagportal`
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

--
-- Dumping data for table `ContainerPos`
--

INSERT INTO `ContainerPos` (`userId`, `video_x`, `video_y`, `tagContainer1_x`, `tagContainer1_y`, `comment_x`, `comment_y`, `title_x`, `title_y`, `date`) VALUES
(3, NULL, NULL, 4, -60, 45, 504, NULL, NULL, '2013-04-16 14:56:03'),
(0, NULL, NULL, -40, -72, 33, 489, NULL, NULL, '2013-04-14 21:25:52'),
(11, NULL, NULL, -12, 3, 11, 525, NULL, NULL, '2013-04-16 19:28:11'),
(2147483647, NULL, NULL, -5, -11, NULL, NULL, NULL, NULL, '2013-04-15 23:43:30');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `userId`, `videoId`, `date`) VALUES
(1, '3', 'HyAjCOw6AcQ', '2013-04-12 05:09:29'),
(2, '11', 'OpQFFLBMEPI', '2013-04-15 02:44:11'),
(3, '11', 'QK8mJJJvaes', '2013-04-15 03:12:54'),
(7, '3', 'kweUVUCYRa8', '2013-04-16 15:28:22'),
(6, '3', 'jbIQW0gkgxo', '2013-04-15 16:48:18');

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
  `dateRegistered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `googleId`, `facebookId`, `googleRefreshtkn`, `dateRegistered`) VALUES
(3, '', '115514542566634112673', '1299877146', '', '2013-04-12 04:31:09'),
(11, 'SDSM&T', '109004527497254274612', '1019151910', '1/vJ348uQgc7WxGQcKL7eQC0hgprlPWIRECrjmRBMxido', '2013-04-16 15:17:41'),
(13, '', '112989011303513058922', '100004651441731', '', '2013-04-14 20:39:24'),
(19, 'Anudeep Potlapally', '109467886486297978253', '', '1/doZrPi1epAcg6yzn1QK5oPZI9ywJIy7hb9Ie5ew6qkg', '2013-04-15 23:26:50');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Tags Info for Youtube videos' AUTO_INCREMENT=32 ;

--
-- Dumping data for table `yttags`
--

INSERT INTO `yttags` (`id`, `videoId`, `userId`, `start`, `end`, `date`, `action`, `content`) VALUES
(27, 'HyAjCOw6AcQ', '11', 26, 35, '2013-04-16 15:14:16', 'image', 'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcRXuwf1pilWfdpG4ecKr_gefBm485joZ_1sN6b9-httkiATdhnRww'),
(2, 'OpQFFLBMEPI', NULL, 0, 127, '2013-04-13 14:23:21', 'map', '[{"markerTitle":"test"},{"lng":"-103.20676791088863"},{"lat":"44.07432896362102"}]'),
(26, 'HyAjCOw6AcQ', '11', 12, 26, '2013-04-16 15:07:57', 'image', 'http://www.sdsmt.edu/uploadedImages/Content/About/brarchWideview.jpg'),
(25, 'HyAjCOw6AcQ', '11', 0, 11, '2013-04-16 15:04:48', 'image', 'http://ecatalog.sdsmt.edu/mime/media/8/585/Helicopter%20(2).jpg'),
(24, 'HyAjCOw6AcQ', '11', 35, 97, '2013-04-16 15:14:23', 'image', 'http://i.ytimg.com/vi/UJv87nNOomg/0.jpg'),
(7, 'jbIQW0gkgxo', NULL, 0, 21, '2013-04-14 03:36:03', 'map', '[{"markerTitle":"MIT"},{"lng":"-71.09364497082515"},{"lat":"42.35882954783987"}]'),
(8, 'jbIQW0gkgxo', NULL, 0, 21, '2013-04-14 03:40:37', 'image', 'images/tags/1365910837.gif'),
(9, 'jbIQW0gkgxo', NULL, 22, 38, '2013-04-14 03:46:53', 'image', 'images/tags/1365911212.png'),
(10, 'jbIQW0gkgxo', NULL, 40, 60, '2013-04-14 03:50:01', 'image', 'images/tags/1365911401.jpg'),
(11, 'jbIQW0gkgxo', NULL, 61, 92, '2013-04-14 04:05:01', 'image', 'images/tags/1365912293.jpg'),
(12, 'jbIQW0gkgxo', NULL, 95, 126, '2013-04-14 04:07:15', 'image', 'images/tags/1365912435.png'),
(13, 'jbIQW0gkgxo', NULL, 127, 153, '2013-04-14 04:10:54', 'image', 'images/tags/1365912654.jpg'),
(14, 'jbIQW0gkgxo', NULL, 240, 318, '2013-04-14 04:17:21', 'image', 'images/tags/1365913041.png'),
(15, 'jbIQW0gkgxo', NULL, 174, 221, '2013-04-14 04:21:32', 'image', 'images/tags/1365913292.png'),
(16, 'OpQFFLBMEPI', '11', 0, 179, '2013-04-15 00:34:04', 'comment', 'Testing Comments....................................................\r\n,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,\r\n\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\'),
(17, 'OpQFFLBMEPI', '11', 0, 20, '2013-04-15 00:33:53', 'comment', 'dfsdfsfsdfs\r\ndfsd\r\nfsd\r\nfsd\r\nfs\r\ndf\r\nthyju\r\nkiu\r\nlk\r\nuk\r\nu'),
(18, 'OpQFFLBMEPI', '11', 0, 63, '2013-04-15 00:33:56', 'comment', 'fslog;jsds\r\nds\r\ndf\r\nsdf\r\nsd\r\nfs\r\ndf\r\nsd\r\nfs\r\ndf\r\nsd'),
(19, 'OpQFFLBMEPI', '11', 0, 156, '2013-04-15 00:33:49', 'comment', 'qqqq qqqqq qqqqqqqqqqq qqqqqqqqq qqqqqq qqqqqq qqqqqq qqqqq qqqqqqqqqqqqqqqq  qqqqqqqq qqqqqqqq qdddddddd dddddddddddd ddddddddd ddddddd ddddd dddddd dojjjjjjjj dfoiuhpvghpsauvhipofyhgvp9aherpgpoihsavpoghapfvougbpery ghpq98oywr98tyqr98tqughbvjbfsvjbfbhvpuqrgprqwhpgyohqprghverfhvbwrbjvugqprugpqorqpu8ty59897y69 y69ruihjkiv nfj;lncf vjherp 0t98093 45wy8reuc ilkunhwep ruti nwie orc4w3n09nt ucghsiw98eri gcoeyt9 84f3y8n7 turhcfilheb7r98 tyfcb 847nuh wglniuyer oui ygh oausghi  q3 847y 487uy t9q82 47uy h o43yt oq 28y 4t oghrek bghg43o 987y53t hyerh tg5rot 8gy h35847y6 87345 y6t8rg hbvkf hber 5y tg8753y t87 ryt gfhdiue th8 743y th'),
(20, 'OpQFFLBMEPI', '109467886486297978253', 0, 167, '2013-04-15 23:43:25', 'image', 'data:image/jpeg;base64,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'),
(22, 'OpQFFLBMEPI', '11', 0, 38, '2013-04-16 02:05:08', 'link', 'http://api.jquery.com/live/'),
(23, 'OpQFFLBMEPI', '11', 10, 108, '2013-04-16 02:23:57', 'link', 'http://vtp.host-ed.me/vtp/src/index.php'),
(28, 'HyAjCOw6AcQ', '11', 0, 28, '2013-04-16 17:07:34', 'comment', 'Interested in Our CSR program go to webpage http://rias.sdsmt.edu/rias_seminar   for more information.'),
(29, 'kweUVUCYRa8', '3', 0, 41, '2013-04-16 15:19:40', 'image', 'images/tags/1366125579.jpg'),
(30, 'HyAjCOw6AcQ', '11', 5, 38, '2013-04-16 15:20:19', 'map', '[{"markerTitle":"Mines"},{"lng":"-103.20719706433101"},{"lat":"44.07266401138099"}]'),
(31, 'HyAjCOw6AcQ', '11', 99, 200, '2013-04-16 17:08:14', 'image', 'http://www.sdsmt.edu/images/header/logo.png');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
