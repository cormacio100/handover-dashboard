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
-- Table structure for table `dashstatus`
--

CREATE TABLE IF NOT EXISTS `dashstatus` (
  `id` int(11) NOT NULL,
  `freeSms` int(11) NOT NULL,
  `sectors` int(11) NOT NULL,
  `netAvail2G` int(11) NOT NULL,
  `trafVol2G` int(11) NOT NULL,
  `netLocSuc2G` int(11) NOT NULL,
  `netAvail3G` int(11) NOT NULL,
  `trafVol3G` int(11) NOT NULL,
  `voiceTraf2G` int(11) NOT NULL,
  `callCompRate2G` int(11) NOT NULL,
  `callSuccRate2G` int(11) NOT NULL,
  `callCompRate3G` int(11) NOT NULL,
  `callSuccRate3G` int(11) NOT NULL,
  `dataVol2G` int(11) NOT NULL,
  `edgeThru2G` int(11) NOT NULL,
  `gprsThru2G` int(11) NOT NULL,
  `dataVol3G` int(11) NOT NULL,
  `pakSetSuc3G` int(11) NOT NULL,
  `pakCompRate3G` int(11) NOT NULL,
  `mmsCompRate` int(11) NOT NULL,
  `smsCompRate` int(11) NOT NULL,
  `pssVoice` varchar(10) NOT NULL,
  `pssData` varchar(10) NOT NULL,
  `pssMessaging` varchar(10) NOT NULL,
  `pssRoaming` varchar(10) NOT NULL,
  `pss2GNetwork` varchar(10) NOT NULL,
  `pss3GNetwork` varchar(10) NOT NULL,
  `essCustMgmnt` varchar(10) NOT NULL,
  `essCustBill` varchar(10) NOT NULL,
  `essServProv` varchar(10) NOT NULL,
  `essTopUp` varchar(10) NOT NULL,
  `essRetPos` varchar(10) NOT NULL,
  `cssDataWareBI` varchar(10) NOT NULL,
  `cssEmail` varchar(10) NOT NULL,
  `cssNetwork` varchar(10) NOT NULL,
  `cssTelePbx` varchar(10) NOT NULL,
  `cssErpBss` varchar(10) NOT NULL,
  `_userId` int(11) NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dashstatus`
--

INSERT INTO `dashstatus` (`id`, `freeSms`, `sectors`, `netAvail2G`, `trafVol2G`, `netLocSuc2G`, `netAvail3G`, `trafVol3G`, `voiceTraf2G`, `callCompRate2G`, `callSuccRate2G`, `callCompRate3G`, `callSuccRate3G`, `dataVol2G`, `edgeThru2G`, `gprsThru2G`, `dataVol3G`, `pakSetSuc3G`, `pakCompRate3G`, `mmsCompRate`, `smsCompRate`, `pssVoice`, `pssData`, `pssMessaging`, `pssRoaming`, `pss2GNetwork`, `pss3GNetwork`, `essCustMgmnt`, `essCustBill`, `essServProv`, `essTopUp`, `essRetPos`, `cssDataWareBI`, `cssEmail`, `cssNetwork`, `cssTelePbx`, `cssErpBss`) VALUES
(1, 57, 97, 93, 96, 57, 92, 91, 93, 95, 96, 56, 9, 446, 112, 47, 117, 46, 119, 30, 39, 'amber', 'amber', 'amber', 'amber', 'amber', 'amber', 'red', 'red', 'red', 'red', 'red', 'amber', 'amber', 'amber', 'amber', 'amber');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
