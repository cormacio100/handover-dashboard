-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 18, 2015 at 11:36 AM
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
-- Table structure for table `ticker`
--

CREATE TABLE IF NOT EXISTS `ticker` (
  `tickerDisplay` varchar(5) NOT NULL DEFAULT 'yes',
  `tickerDesc` varchar(190) NOT NULL,
  `_userId` int(11) NOT NULL,
  PRIMARY KEY (`tickerDesc`),
  FOREIGN KEY (`_userId`) REFERENCES user(`userId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ticker`
--

INSERT INTO `ticker` (`tickerDisplay`, `tickerDesc`) VALUES
('yes', 'scrolling ticker');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
