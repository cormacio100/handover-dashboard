-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 15, 2015 at 11:24 PM
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
-- Table structure for table `dash_status`
--

CREATE TABLE IF NOT EXISTS `dash_status` (
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
  `pssVoice` text NOT NULL,
  `pssData` text NOT NULL,
  `pssMessaging` text NOT NULL,
  `pssRoaming` text NOT NULL,
  `pss2GNetwork` text NOT NULL,
  `pss3GNetwork` text NOT NULL,
  `essCustMgmnt` text NOT NULL,
  `essCustBill` text NOT NULL,
  `essServProv` text NOT NULL,
  `essTopUp` text NOT NULL,
  `essRetPos` text NOT NULL,
  `cssDataWareBI` text NOT NULL,
  `cssEmail` text NOT NULL,
  `cssNetwork` text NOT NULL,
  `cssTelePbx` text NOT NULL,
  `cssErpBss` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dash_status`
--

INSERT INTO `dash_status` (`id`, `freeSms`, `sectors`, `netAvail2G`, `trafVol2G`, `netLocSuc2G`, `netAvail3G`, `trafVol3G`, `voiceTraf2G`, `callCompRate2G`, `callSuccRate2G`, `callCompRate3G`, `callSuccRate3G`, `dataVol2G`, `edgeThru2G`, `gprsThru2G`, `dataVol3G`, `pakSetSuc3G`, `pakCompRate3G`, `mmsCompRate`, `smsCompRate`, `pssVoice`, `pssData`, `pssMessaging`, `pssRoaming`, `pss2GNetwork`, `pss3GNetwork`, `essCustMgmnt`, `essCustBill`, `essServProv`, `essTopUp`, `essRetPos`, `cssDataWareBI`, `cssEmail`, `cssNetwork`, `cssTelePbx`, `cssErpBss`) VALUES
(1, 57, 97, 92, 98, 92, 96, 92, 92, 94, 95, 54, 111, 445, 113, 45, 115, 45, 117, 25, 26, 'green', 'amber', 'green', 'green', 'red', 'green', 'green', 'green', 'green', 'green', 'green', 'green', 'green', 'green', 'red', 'amber');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
