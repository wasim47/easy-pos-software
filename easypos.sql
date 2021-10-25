-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 06, 2013 at 05:49 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `easypos`
--

-- --------------------------------------------------------

--
-- Table structure for table `hqinv`
--

DROP TABLE IF EXISTS `hqinv`;
CREATE TABLE IF NOT EXISTS `hqinv` (
  `barcode` int(8) unsigned NOT NULL DEFAULT '0',
  `pdtname` varchar(256) NOT NULL,
  `category` varchar(100) NOT NULL,
  `manufacturer` varchar(50) NOT NULL,
  `cost` decimal(4,2) DEFAULT NULL,
  `curstock` int(10) DEFAULT NULL,
  `minstock` int(10) DEFAULT NULL,
  `bundle` int(10) DEFAULT NULL,
  `recdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`barcode`),
  UNIQUE KEY `barcode` (`barcode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hqpdts`
--

DROP TABLE IF EXISTS `hqpdts`;
CREATE TABLE IF NOT EXISTS `hqpdts` (
  `barcode` int(8) unsigned NOT NULL DEFAULT '0',
  `pdtname` varchar(256) NOT NULL,
  PRIMARY KEY (`barcode`),
  UNIQUE KEY `barcode` (`barcode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hqstock`
--

DROP TABLE IF EXISTS `hqstock`;
CREATE TABLE IF NOT EXISTS `hqstock` (
  `shopid` varchar(256) NOT NULL DEFAULT '',
  `barcode` int(8) unsigned NOT NULL DEFAULT '0',
  `citycurstock` int(10) DEFAULT NULL,
  `citylastprice` decimal(4,2) DEFAULT NULL,
  `recdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`shopid`,`barcode`),
  UNIQUE KEY `barcode` (`barcode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hqtransactions`
--

DROP TABLE IF EXISTS `hqtransactions`;
CREATE TABLE IF NOT EXISTS `hqtransactions` (
  `trnid` int(10) NOT NULL DEFAULT '0',
  `barcode` int(8) unsigned NOT NULL DEFAULT '0',
  `shopid` int(10) unsigned NOT NULL,
  `qtysold` int(10) DEFAULT NULL,
  `itemprice` decimal(4,2) DEFAULT NULL,
  `timedate` date NOT NULL,
  PRIMARY KEY (`trnid`,`barcode`,`shopid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hqtrnmaster`
--

DROP TABLE IF EXISTS `hqtrnmaster`;
CREATE TABLE IF NOT EXISTS `hqtrnmaster` (
  `trnid` int(10) NOT NULL AUTO_INCREMENT,
  `shopid` int(10) unsigned NOT NULL,
  `transtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`trnid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `shopslist`
--

DROP TABLE IF EXISTS `shopslist`;
CREATE TABLE IF NOT EXISTS `shopslist` (
  `shopid` int(10) NOT NULL AUTO_INCREMENT,
  `shopname` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`shopid`),
  UNIQUE KEY `shopid` (`shopid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `temptrans`
--

DROP TABLE IF EXISTS `temptrans`;
CREATE TABLE IF NOT EXISTS `temptrans` (
  `barcode` int(8) unsigned NOT NULL DEFAULT '0',
  `shopid` int(10) unsigned NOT NULL,
  `qtysold` int(10) DEFAULT NULL,
  `itemprice` decimal(4,2) DEFAULT NULL,
  `timedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `recid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `emailid` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `shopid` int(5) NOT NULL,
  `recdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`recid`),
  UNIQUE KEY `emailid` (`emailid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
