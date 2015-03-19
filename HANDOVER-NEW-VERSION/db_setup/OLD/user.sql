-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 15, 2015 at 11:18 PM
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
  `userPassword` varchar(10) NOT NULL,
  `userCat` varchar(10) NOT NULL DEFAULT 'general',
  PRIMARY KEY (`userId`),
  UNIQUE KEY `user_id` (`userId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `userFName`, `userSName`, `userLogin`, `userPassword`, `userCat`) VALUES
(4, 'Cormac', 'Liston', 'cliston', 'password', 'admin'),
(8, 'Silvia', 'Alvarez', 'salvarez', 'password', 'general'),
(6, 'Alicja', 'Sielecka', 'asielecka', 'password', 'general'),
(7, 'Darragh', 'Killeen', 'dkilleen', 'password', 'general'),
(9, 'Declan', 'McNamara', 'dmcnamara', 'password', 'general'),
(10, 'Justin', 'Donovan', 'jdonovan', 'password', 'general'),
(11, 'Brian', 'Lawlor', 'blawlor', 'password', 'general'),
(12, 'Talal', 'Tariq', 'ttariq', 'password', 'general'),
(13, 'John', 'Doyle', 'jdoyle', 'password', 'general'),
(14, 'Peter', 'Sherry', 'psherry', 'password', 'general'),
(15, 'Christina', 'Offutt', 'coffutt', 'password', 'general'),
(16, 'John Paul', 'Tuohy', 'jptuohy', 'password', 'general'),
(17, 'Asim', 'Muhammad', 'amuhammad', 'password', 'general'),
(18, 'Brendan', 'Farrell', 'bfarrell', 'password', 'general'),
(19, 'John', 'Kerr', 'jkerr', 'password', 'general'),
(20, 'Adeyemi', 'Okeshola', 'aokeshola', 'password', 'general'),
(21, 'Paul', 'Gray', 'pgray', 'password', 'general'),
(22, 'Daniel', 'Sweeney', 'dsweeney', 'password', 'general'),
(23, 'Sam', 'McCarthy', 'smccarthy', 'password', 'general'),
(24, 'Noel', 'Spillane', 'nspillane', 'password', 'general'),
(25, 'Michael', 'Gallagher', 'mgallagher', 'password', 'general'),
(26, 'Robert', 'Gleeson', 'rgleeson', 'password', 'general'),
(27, 'Ciara', 'Cassidy', 'ccassidy', 'password', 'general'),
(28, 'Ronan', 'Henry', 'rhenry', 'password', 'general'),
(29, 'George', 'Corcoran', 'gcorcoran', 'password', 'general'),
(30, 'Richard', 'O''Reilly', 'roreilly', 'password', 'general'),
(31, 'Matthew', 'Butler', 'mbutler', 'password', 'general'),
(32, 'Graham', 'Jones', 'gjones', 'password', 'general'),
(33, 'Kevin ', 'Bayliss', 'kbayliss', 'password', 'general'),
(34, 'Ivor', 'Reynolds', 'ireynolds', 'password', 'general'),
(35, 'Marek', 'Hajnce', 'mhajnce', 'password', 'general'),
(36, 'David', 'Ryall', 'dryall', 'password', 'general'),
(37, 'David', 'Flynn', 'dflynn', 'password', 'general'),
(38, 'Martin', 'McCormack', 'mmccormack', 'password', 'general');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
