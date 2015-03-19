-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 18, 2015 at 11:37 AM
-- Server version: 5.5.20
-- PHP Version: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `handover`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `userFName` varchar(20) NOT NULL,
  `userSName` varchar(20) NOT NULL,
  `userLogin` varchar(20) NOT NULL,
  `userPassword` varchar(50) NOT NULL,
  `userCat` varchar(10) NOT NULL DEFAULT 'general',
  `userEmail` varchar(30) NOT NULL,
  `userActive` varchar(5) NOT NULL DEFAULT 'Yes',
  PRIMARY KEY (`userId`),
  UNIQUE KEY `user_id` (`userId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `userFName`, `userSName`, `userLogin`, `userPassword`, `userCat`, `userEmail`, `userActive`) VALUES
(4, 'Cormac', 'Liston', 'cliston', '4b057c100aa4b584998047bdf7fe55e6', 'admin', 'cormac.liston@gmail.com', 'yes'),
(8, 'Silvia', 'Alvarez', 'salvarez', 'password', 'admin', 'cormac.liston@gmail.com', 'yes'),
(6, 'Alicja', 'Sielecka', 'asielecka', 'dc00875d5ec47a4115eacf7b67195ab2', 'admin', 'cormac.liston@gmail.com', 'yes'),
(7, 'Darragh', 'Killeen2', 'dkilleen', 'a2e7625f43', 'general', 'cormac.liston@gmail.com', 'No'),
(9, 'Declan', 'McNamara', 'dmcnamara', 'password', 'general', 'cormac.liston@gmail.com', 'No'),
(10, 'Justin', 'Donovan', 'jdonovan', 'password', 'general', 'cormac.liston@gmail.com', 'yes'),
(11, 'Brian', 'Lawlor', 'blawlor', 'password', 'general', 'cormac.liston@gmail.com', 'No'),
(12, 'Talal', 'Tariq', 'ttariq', 'password', 'general', 'cormac.liston@gmail.com', 'yes'),
(13, 'John', 'Doyle', 'jdoyle', 'password', 'general', 'cormac.liston@gmail.com', 'No'),
(14, 'Peter', 'Sherry', 'psherry', 'password', 'general', 'cormac.liston@gmail.com', 'yes'),
(15, 'Christina', 'Offutt', 'coffutt', 'password', 'general', 'cormac.liston@gmail.com', 'yes'),
(16, 'John Paul', 'Tuohy', 'jptuohy', 'password', 'general', 'cormac.liston@gmail.com', 'yes'),
(17, 'Asim', 'Muhammad', 'amuhammad', 'password', 'general', 'cormac.liston@gmail.com', 'yes'),
(18, 'Brendan', 'Farrell', 'bfarrell', 'password', 'general', 'cormac.liston@gmail.com', 'yes'),
(19, 'John', 'Kerr', 'jkerr', 'password', 'general', 'cormac.liston@gmail.com', 'yes'),
(20, 'Adeyemi', 'Okeshola', 'aokeshola', 'password', 'general', 'cormac.liston@gmail.com', 'yes'),
(21, 'Paul', 'Gray', 'pgray', 'password', 'general', 'cormac.liston@gmail.com', 'yes'),
(22, 'Daniel', 'Sweeney', 'dsweeney', 'password', 'general', 'cormac.liston@gmail.com', 'yes'),
(23, 'Sam', 'McCarthy', 'smccarthy', 'password', 'general', 'cormac.liston@gmail.com', 'yes'),
(24, 'Noel', 'Spillane', 'nspillane', 'password', 'general', 'cormac.liston@gmail.com', 'yes'),
(25, 'Michael', 'Gallagher', 'mgallagher', 'password', 'general', 'cormac.liston@gmail.com', 'yes'),
(26, 'Robert', 'Gleeson', 'rgleeson', 'password', 'general', 'cormac.liston@gmail.com', 'No'),
(27, 'Ciara', 'Cassidy', 'ccassidy', 'password', 'general', 'cormac.liston@gmail.com', 'yes'),
(28, 'Ronan', 'Henry', 'rhenry', 'password', 'general', 'cormac.liston@gmail.com', 'yes'),
(29, 'George', 'Corcoran', 'gcorcoran', 'password', 'general', 'cormac.liston@gmail.com', 'yes'),
(30, 'Richard', 'O''Reilly', 'roreilly', 'password', 'general', 'cormac.liston@gmail.com', 'yes'),
(31, 'Matthew', 'Butler', 'mbutler', 'password', 'general', 'cormac.liston@gmail.com', 'yes'),
(32, 'Graham', 'Jones', 'gjones', 'password', 'general', 'cormac.liston@gmail.com', 'yes'),
(33, 'Kevin ', 'Bayliss', 'kbayliss', 'password', 'general', 'cormac.liston@gmail.com', 'yes'),
(34, 'Ivor', 'Reynolds', 'ireynolds', 'password', 'general', 'cormac.liston@gmail.com', 'yes'),
(35, 'Marek', 'Hajnce', 'mhajnce', 'password', 'general', 'cormac.liston@gmail.com', 'yes'),
(36, 'David', 'Ryall', 'dryall', 'password', 'general', 'cormac.liston@gmail.com', 'yes'),
(37, 'David', 'Flynn', 'dflynn', 'password', 'general', 'cormac.liston@gmail.com', 'No'),
(38, 'Martin', 'McCormack', 'mmccormack', 'password', 'general', 'cormac.liston@gmail.com', 'yes'),
(41, 'luhven', 'Echenique', 'lechenique', '440d40c5ceb7bfdfccb0d16051cb48dd', 'general', 'luhvenechenique@gmail.com', 'No'),
(42, 'luhven', 'Echenique', 'lechenique', '440d40c5ceb7bfdfccb0d16051cb48dd', 'general', 'luhvenechenique@gmail.com', 'Yes'),
(43, 'bertie', 'Wooster', 'bwooster', 'f8773f695d3b0e7f7f44669ab0d8bf8b', 'admin', 'cccd@meteor.ie', 'Yes'),
(44, 'Daley', 'Thompson', 'genUser1', 'bac33f83f882ed4edb6630926cc6d14b', 'general', 'cccd@meteor.ie', 'Yes');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
