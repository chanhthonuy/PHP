-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:5500
-- Generation Time: Jan 12, 2018 at 09:26 PM
-- Server version: 5.5.45
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `se266_patrick`
--

-- --------------------------------------------------------

--
-- Table structure for table `barbersignup`
--

CREATE TABLE `barbersignup` (
  `barberID` mediumint(8) UNSIGNED NOT NULL,
  `barberName` varchar(255) DEFAULT NULL,
  `barberEmail` varchar(255) DEFAULT NULL,
  `barberUserName` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `barberShopName` varchar(255) DEFAULT NULL,
  `barberShopCity` varchar(255) DEFAULT NULL,
  `barberShopState` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barbersignup`
--

INSERT INTO `barbersignup` (`barberID`, `barberName`, `barberEmail`, `barberUserName`, `password`, `barberShopName`, `barberShopCity`, `barberShopState`) VALUES
(8, 'Patrick', NULL, 'psergi917', 'b8aa71aafdf76d9a1452c2703cd3848392964081#!8dlkj90', 'barberStop', 'East Taunton', 'MA'),
(9, '', NULL, '', 'da39a3ee5e6b4b0d3255bfef95601890afd80709#!8dlkj90', '', '', ''),
(10, '', NULL, '', 'da39a3ee5e6b4b0d3255bfef95601890afd80709#!8dlkj90', '', '', ''),
(11, '', NULL, '', 'da39a3ee5e6b4b0d3255bfef95601890afd80709#!8dlkj90', '', '', ''),
(12, 'Patrick', NULL, 'psergi917', '59f08abd126d29eadc99a8b89eeb15a1538bfd52#!8dlkj90', 'barberStop', 'East Taunton', 'MA'),
(13, '', NULL, '', 'da39a3ee5e6b4b0d3255bfef95601890afd80709#!8dlkj90', '', '', ''),
(14, '', NULL, '', 'da39a3ee5e6b4b0d3255bfef95601890afd80709#!8dlkj90', '', '', ''),
(15, '', NULL, 'se266_patrick', '59f08abd126d29eadc99a8b89eeb15a1538bfd52#!8dlkj90', '', '', ''),
(16, '', NULL, 'se266_patrick', '59f08abd126d29eadc99a8b89eeb15a1538bfd52#!8dlkj90', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barbersignup`
--
ALTER TABLE `barbersignup`
  ADD PRIMARY KEY (`barberID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barbersignup`
--
ALTER TABLE `barbersignup`
  MODIFY `barberID` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
