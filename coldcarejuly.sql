-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2017 at 01:45 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.5.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coldcarejuly`
--

-- --------------------------------------------------------

--
-- Table structure for table `baseuom`
--

CREATE TABLE `baseuom` (
  `baseid` int(12) NOT NULL,
  `Baseuom` varchar(234) NOT NULL,
  `Status` enum('Active','Inactive') NOT NULL,
  `LastUpdated` varchar(123) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `baseuom`
--

INSERT INTO `baseuom` (`baseid`, `Baseuom`, `Status`, `LastUpdated`) VALUES
(1, 'Bags', 'Active', '1486981014'),
(2, 'Cases', 'Active', '1486981019'),
(3, 'Packets', 'Active', '1486981029'),
(4, 'Pieces', 'Active', '1486981035'),
(5, 'Slices', 'Active', '1486981040'),
(6, 'Box', 'Active', '1486983198'),
(7, 'Can', 'Active', '1487409738'),
(8, 'test uom', 'Active', '1493102619');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `BrandId` int(12) NOT NULL,
  `BrandName` varchar(234) NOT NULL,
  `LastUpdated` varchar(234) NOT NULL,
  `LogoPath` varchar(123) NOT NULL,
  `Status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`BrandId`, `BrandName`, `LastUpdated`, `LogoPath`, `Status`) VALUES
(1, 'Kfc', '1493123296', 'resources/brand-logos/KFC-kfc-logo.jpg', 'Inactive'),
(2, 'MCD', '1488003137', 'resources/brand-logos/MCD-mcd.jpg', 'Active'),
(3, 'Dominos', '1487067275', 'resources/brand-logos/Dominos-dominos-logo.jpg', 'Active'),
(4, 'McCain', '1487067285', 'resources/brand-logos/McCain-mccain-logo.jpg', 'Active'),
(6, 'Fuji', '1488006193', 'resources/brand-logos/Fuji-fuji.jpg', 'Active'),
(7, 'Rayal-Gala', '1488017625', 'resources/brand-logos/Rayal Gala-royal-gala.jpg', 'Active'),
(8, 'Washington', '1488007504', 'resources/brand-logos/Washington-washington.jpg', 'Active'),
(9, 'Amul', '1488180463', 'resources/brand-logos/Amul-amul.jpg', 'Active'),
(10, 'Britannia', '1488180480', 'resources/brand-logos/Britannia-britannia.jpg', 'Active'),
(11, 'Nestle', '1489579336', 'resources/brand-logos/Nestle-nestle.jpg', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `CategoryID` int(12) NOT NULL,
  `Category_Name` varchar(234) NOT NULL,
  `LogoPath` varchar(256) NOT NULL,
  `Status` enum('Active','Inactive') NOT NULL,
  `LastUpdated` varchar(123) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`CategoryID`, `Category_Name`, `LogoPath`, `Status`, `LastUpdated`) VALUES
(1, 'Vegetables', 'resources/category-logos/Vegetables-vegetables.jpg', 'Active', '1493123255'),
(2, 'Fruits', 'resources/category-logos/Fruits-fruits.jpg', 'Active', '1487067494'),
(3, 'Frozen Foods', 'resources/category-logos/Frozen Foods-frozenfood.jpg', 'Active', '1487067540'),
(4, 'Chilled', 'resources/category-logos/Chilled-chilled.jpg', 'Active', '1487067554');

-- --------------------------------------------------------

--
-- Table structure for table `getkeys`
--

CREATE TABLE `getkeys` (
  `SLNO` int(12) NOT NULL,
  `KeyFor` varchar(246) NOT NULL,
  `EncKey` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `getkeys`
--

INSERT INTO `getkeys` (`SLNO`, `KeyFor`, `EncKey`) VALUES
(1, 'congif-encryption-key', 'w10MJ8mkeVT1X77BGdqRjB7D059K1r52'),
(2, 'Blowfish_Pre', '$2a$05$'),
(3, 'Blowfish_End', '$');

-- --------------------------------------------------------

--
-- Table structure for table `measurements`
--

CREATE TABLE `measurements` (
  `MeasurementId` int(12) NOT NULL,
  `MeasurementUnit` varchar(256) NOT NULL,
  `Status` enum('Active','Inactive') NOT NULL,
  `LastUpdated` varchar(123) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `measurements`
--

INSERT INTO `measurements` (`MeasurementId`, `MeasurementUnit`, `Status`, `LastUpdated`) VALUES
(1, 'gms', 'Active', '1486980950'),
(2, 'kgs', 'Active', '1486980956'),
(3, 'ml', 'Active', '1486980962'),
(4, 'ltrs', 'Active', '1486981007');

-- --------------------------------------------------------

--
-- Table structure for table `orderproducts`
--

CREATE TABLE `orderproducts` (
  `OPID` int(12) NOT NULL,
  `OrderId` int(12) NOT NULL,
  `Product` int(12) NOT NULL,
  `PackageId` int(12) NOT NULL,
  `Quantity` int(12) NOT NULL,
  `OrderedOn` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orderproducts`
--

INSERT INTO `orderproducts` (`OPID`, `OrderId`, `Product`, `PackageId`, `Quantity`, `OrderedOn`) VALUES
(1, 1, 2, 8, 3, '2017-02-28 14:59:01'),
(2, 1, 1, 1, 2, '2017-02-28 14:59:01'),
(3, 1, 1, 3, 2, '2017-02-28 14:59:01'),
(4, 2, 25, 63, 1, '2017-03-03 15:03:30'),
(5, 2, 14, 41, 1, '2017-03-03 15:03:30'),
(6, 2, 21, 53, 1, '2017-03-03 15:03:30'),
(7, 2, 2, 11, 1, '2017-03-03 15:03:30'),
(8, 2, 3, 12, 1, '2017-03-03 15:03:30'),
(9, 2, 1, 3, 1, '2017-03-03 15:03:30'),
(10, 3, 52, 106, 3, '2017-03-15 17:39:33'),
(11, 3, 61, 119, 4, '2017-03-15 17:39:33'),
(12, 3, 33, 77, 1, '2017-03-15 17:39:33'),
(13, 3, 23, 57, 5, '2017-03-15 17:39:33'),
(14, 4, 50, 104, 7, '2017-03-15 17:57:32'),
(15, 4, 65, 125, 6, '2017-03-15 17:57:32'),
(16, 4, 39, 89, 1, '2017-03-15 17:57:32'),
(17, 5, 52, 106, 1, '2017-03-15 17:57:56'),
(18, 5, 53, 107, 1, '2017-03-15 17:57:56'),
(19, 5, 59, 114, 1, '2017-03-15 17:57:56'),
(20, 6, 3, 12, 1, '2017-03-15 18:04:43'),
(21, 6, 1, 3, 1, '2017-03-15 18:04:43'),
(22, 6, 21, 53, 1, '2017-03-15 18:04:43'),
(23, 7, 21, 53, 2, '2017-03-21 12:23:15'),
(24, 7, 25, 62, 2, '2017-03-21 12:23:15'),
(25, 7, 15, 44, 1, '2017-03-21 12:23:15'),
(26, 7, 57, 111, 4, '2017-03-21 12:23:15'),
(27, 7, 59, 114, 1, '2017-03-21 12:23:15'),
(28, 7, 65, 128, 1, '2017-03-21 12:23:15'),
(29, 8, 47, 101, 3, '2017-03-21 13:55:01'),
(30, 8, 51, 105, 1, '2017-03-21 13:55:01'),
(31, 8, 38, 85, 1, '2017-03-21 13:55:01'),
(32, 8, 29, 71, 1, '2017-03-21 13:55:01'),
(33, 8, 35, 79, 4, '2017-03-21 13:55:01'),
(34, 8, 65, 123, 1, '2017-03-21 13:55:01'),
(35, 8, 63, 121, 1, '2017-03-21 13:55:01'),
(36, 8, 61, 118, 4, '2017-03-21 13:55:01'),
(37, 9, 52, 106, 1, '2017-03-24 12:37:57'),
(38, 9, 56, 110, 1, '2017-03-24 12:37:57'),
(39, 9, 42, 96, 1, '2017-03-24 12:37:57'),
(40, 9, 43, 97, 1, '2017-03-24 12:37:57'),
(41, 9, 27, 67, 1, '2017-03-24 12:37:57'),
(42, 9, 14, 41, 1, '2017-03-24 12:37:57'),
(43, 9, 21, 53, 1, '2017-03-24 12:37:57'),
(44, 9, 20, 52, 1, '2017-03-24 12:37:57'),
(45, 9, 26, 65, 1, '2017-03-24 12:37:57'),
(46, 10, 60, 115, 3, '2017-04-05 18:45:37'),
(47, 10, 32, 76, 4, '2017-04-05 18:45:37'),
(48, 10, 52, 106, 1, '2017-04-05 18:45:37'),
(49, 11, 38, 85, 1, '2017-04-25 14:28:41'),
(50, 11, 42, 96, 1, '2017-04-25 14:28:41'),
(51, 11, 27, 67, 1, '2017-04-25 14:28:41'),
(52, 11, 43, 97, 1, '2017-04-25 14:28:41'),
(53, 11, 29, 70, 1, '2017-04-25 14:28:41'),
(54, 12, 48, 102, 1, '2017-05-10 12:13:41');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderId` int(12) NOT NULL,
  `OrderBy` int(12) NOT NULL,
  `OrderStatus` enum('Awaiting','Shipped','Confirmed','Delivered','Cancelled') COLLATE utf8_unicode_ci NOT NULL,
  `TotalProducts` int(12) NOT NULL,
  `Total_Amount` int(12) NOT NULL,
  `OrderedOn` datetime NOT NULL,
  `LastUpdated` datetime NOT NULL,
  `Expected_Delivery_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderId`, `OrderBy`, `OrderStatus`, `TotalProducts`, `Total_Amount`, `OrderedOn`, `LastUpdated`, `Expected_Delivery_date`) VALUES
(1, 24, 'Delivered', 3, 425, '2017-02-28 14:59:01', '2017-03-04 15:34:25', '0000-00-00 00:00:00'),
(2, 24, 'Awaiting', 6, 825, '2017-03-03 15:03:30', '2017-03-03 15:03:30', '0000-00-00 00:00:00'),
(3, 29, 'Delivered', 4, 2130, '2017-03-15 17:39:33', '2017-03-15 17:48:22', '0000-00-00 00:00:00'),
(4, 29, 'Shipped', 3, 1575, '2017-03-15 17:57:32', '2017-03-21 12:14:15', '0000-00-00 00:00:00'),
(5, 30, 'Shipped', 3, 370, '2017-03-15 17:57:56', '2017-03-20 12:23:10', '2017-03-20 11:23:10'),
(6, 30, 'Shipped', 3, 330, '2017-03-15 18:04:43', '2017-03-21 12:16:55', '2017-03-21 11:16:55'),
(7, 41, 'Cancelled', 6, 1730, '2017-03-21 12:23:15', '2017-03-21 12:25:17', '2017-03-21 03:24:20'),
(8, 43, 'Delivered', 8, 1934, '2017-03-21 13:55:01', '2017-05-10 12:35:47', '0000-00-00 00:00:00'),
(9, 44, 'Shipped', 9, 2055, '2017-03-24 12:37:57', '2017-03-28 16:38:11', '2017-03-28 06:36:11'),
(10, 45, 'Delivered', 3, 1510, '2017-04-05 18:45:37', '2017-05-10 12:52:01', '2017-05-10 11:51:55'),
(11, 43, 'Shipped', 5, 1455, '2017-04-25 14:28:41', '2017-04-25 14:30:34', '2017-04-25 03:30:34'),
(12, 49, 'Shipped', 1, 25, '2017-05-10 12:13:41', '2017-05-10 12:16:32', '2017-05-12 03:20:32');

-- --------------------------------------------------------

--
-- Table structure for table `packagintypes`
--

CREATE TABLE `packagintypes` (
  `Id` int(12) NOT NULL,
  `ProductId` int(12) NOT NULL,
  `Netweight` varchar(254) NOT NULL,
  `Grossweight` varchar(254) NOT NULL,
  `Quantity` varchar(254) NOT NULL,
  `Price` varchar(254) NOT NULL,
  `Lastupdated` varchar(254) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `packagintypes`
--

INSERT INTO `packagintypes` (`Id`, `ProductId`, `Netweight`, `Grossweight`, `Quantity`, `Price`, `Lastupdated`) VALUES
(1, 1, '5', '5', '1', '60', '1488190560'),
(2, 1, '10', '10', '1', '100', '1488190560'),
(3, 1, '15', '15', '1', '130', '1488190560'),
(8, 2, '5', '5', '1', '15', '1488270099'),
(9, 2, '10', '10', '1', '25', '1488270099'),
(10, 2, '15', '15', '1', '40', '1488270099'),
(11, 2, '20', '20', '1', '55', '1488270099'),
(12, 3, '10', '10', '1', '100', '1488274608'),
(13, 4, '5', '5', '1', '75', '1488274689'),
(14, 4, '10', '10', '1', '130', '1488274689'),
(15, 5, '20', '20', '1', '300', '1488274812'),
(16, 5, '25', '25', '1', '360', '1488274812'),
(17, 5, '30', '30', '1', '450', '1488274812'),
(18, 6, '10', '15', '1', '100', '1488275170'),
(19, 6, '15', '15', '1', '150', '1488275170'),
(20, 7, '10', '15', '1', '180', '1488275272'),
(21, 7, '15', '15', '1', '260', '1488275272'),
(22, 7, '25', '52', '1', '420', '1488275272'),
(23, 8, '15', '15', '1', '100', '1488275357'),
(24, 8, '20', '20', '1', '120', '1488275357'),
(25, 8, '10', '10', '1', '70', '1488275357'),
(26, 9, '5', '5', '1', '70', '1488275463'),
(27, 9, '10', '10', '1', '150', '1488275463'),
(28, 9, '15', '15', '1', '200', '1488275463'),
(29, 10, '5', '5', '1', '150', '1488275553'),
(30, 11, '10', '10', '1', '150', '1488275748'),
(31, 11, '20', '20', '1', '300', '1488275748'),
(32, 12, '10', '10', '1', '150', '1488275922'),
(33, 12, '15', '15', '1', '200', '1488275922'),
(34, 12, '20', '20', '1', '280', '1488275922'),
(35, 12, '30', '30', '1', '350', '1488275922'),
(36, 13, '5', '5', '1', '80', '1488276047'),
(37, 13, '15', '15', '1', '240', '1488276047'),
(38, 13, '25', '25', '1', '400', '1488276047'),
(39, 14, '15', '15', '1', '150', '1488276244'),
(40, 14, '20', '20', '1', '200', '1488276244'),
(41, 14, '25', '25', '1', '250', '1488276244'),
(42, 15, '10', '10', '1', '150', '1488276356'),
(43, 15, '15', '15', '1', '225', '1488276356'),
(44, 15, '20', '20', '1', '300', '1488276356'),
(45, 16, '10', '10', '1', '150', '1488276565'),
(46, 16, '15', '15', '1', '225', '1488276565'),
(47, 17, '10', '10', '1', '170', '1488276642'),
(48, 17, '20', '20', '1', '20', '1488276642'),
(49, 18, '10', '10', '1', '250', '1488276745'),
(50, 18, '20', '20', '1', '450', '1488276745'),
(51, 19, '10', '10', '1', '250', '1488276854'),
(52, 20, '5', '5', '1', '300', '1488277809'),
(53, 21, '10', '10', '1', '100', '1488277811'),
(54, 22, '2', '2', '1', '100', '1488279740'),
(55, 22, '4', '4', '1', '180', '1488279740'),
(56, 23, '300', '300', '1', '200', '1488279813'),
(57, 23, '500', '500', '1', '300', '1488279813'),
(58, 24, '5', '5', '1', '300', '1488279995'),
(59, 24, '7', '7', '1', '500', '1488279995'),
(60, 24, '10', '10', '1', '800', '1488279995'),
(61, 25, '2', '2', '1', '100', '1488280094'),
(62, 25, '3', '3', '1', '140', '1488280094'),
(63, 25, '4', '4', '1', '190', '1488280094'),
(64, 26, '3', '3', '1', '150', '1488280174'),
(65, 26, '5', '5', '1', '250', '1488280174'),
(66, 27, '5', '5', '1', '400', '1488280600'),
(67, 27, '8', '8', '1', '800', '1488280600'),
(68, 28, '6', '6', '1', '450', '1488280663'),
(69, 28, '10', '10', '1', '900', '1488280663'),
(70, 29, '4', '4', '1', '350', '1488280719'),
(71, 29, '8', '8', '1', '650', '1488280719'),
(72, 30, '3', '3', '1', '300', '1488280826'),
(73, 30, '5', '5', '1', '500', '1488280826'),
(74, 31, '5', '5', '1', '600', '1488283534'),
(75, 31, '8', '8', '1', '800', '1488283534'),
(76, 32, '3', '3', '1', '300', '1488284015'),
(77, 33, '3', '3', '1', '350', '1488284084'),
(78, 34, '3', '3', '1', '350', '1488284211'),
(79, 35, '300', '300', '1', '150', '1488284346'),
(80, 36, '500', '500', '1', '200', '1488284410'),
(81, 37, '300', '300', '1', '150', '1488284569'),
(82, 37, '500', '500', '1', '300', '1488284569'),
(83, 37, '600', '600', '1', '450', '1488284569'),
(84, 38, '200', '200', '1', '80', '1488284682'),
(85, 38, '450', '450', '1', '160', '1488284682'),
(86, 39, '50', '50', '1', '80', '1488285214'),
(87, 39, '100', '100', '1', '160', '1488285214'),
(88, 39, '150', '150', '1', '240', '1488285214'),
(89, 39, '250', '250', '1', '320', '1488285214'),
(90, 40, '50', '50', '1', '85', '1488285392'),
(91, 40, '100', '100', '1', '170', '1488285392'),
(92, 40, '200', '200', '1', '340', '1488285392'),
(93, 41, '50', '50', '1', '70', '1488285739'),
(94, 41, '100', '100', '1', '140', '1488285739'),
(95, 41, '150', '150', '1', '210', '1488285739'),
(96, 42, '50', '50', '1', '100', '1488285992'),
(97, 43, '1', '1', '12', '45', '1488286293'),
(98, 44, '120', '120', '1', '40', '1488286557'),
(99, 45, '150', '150', '1', '50', '1488286757'),
(100, 46, '1', '1', '6', '60', '1488287644'),
(101, 47, '120', '120', '1', '50', '1488287770'),
(102, 48, '500', '500', '1', '25', '1488287835'),
(103, 49, '500', '500', '1', '80', '1488287887'),
(104, 50, '500', '500', '1', '25', '1488287957'),
(105, 51, '500', '500', '1', '60', '1488288007'),
(106, 52, '150', '150', '1', '40', '1491398078'),
(107, 53, '500', '500', '1', '150', '1488288233'),
(108, 54, '500', '500', '1', '160', '1488288341'),
(109, 55, '500', '500', '1', '155', '1488288442'),
(110, 56, '500', '500', '1', '170', '1488288522'),
(111, 57, '500', '500', '1', '180', '1488288598'),
(112, 58, '400', '400', '1', '300', '1488288664'),
(113, 59, '200', '200', '1', '90', '1488288739'),
(114, 59, '400', '400', '1', '180', '1488288739'),
(115, 60, '250', '250', '1', '90', '1488288906'),
(116, 60, '500', '500', '1', '180', '1488288906'),
(117, 60, '900', '900', '1', '400', '1488288906'),
(118, 61, '150', '150', '1', '16', '1491399383'),
(119, 61, '400', '400', '1', '40', '1491399383'),
(120, 62, '150', '150', '1', '60', '1489820126'),
(121, 63, '500', '500', '1', '160', '1491399369'),
(122, 64, '150', '150', '1', '300', '1491396598'),
(126, 63, '650', '650', '1', '220', '1491399369'),
(130, 52, '200', '200', '1', '50', '1491398078'),
(134, 65, '', '', '', '', '1492872209'),
(139, 66, '', '', '', '', '1492872416'),
(143, 67, '250', '250', '1', '3520', '1494400104'),
(144, 67, '100', '100', '100', '1250', '1494400104');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ProductId` int(12) NOT NULL,
  `Product_Code` varchar(123) NOT NULL,
  `BrandId` int(11) NOT NULL,
  `Category_Id` int(12) NOT NULL,
  `Sub_CatId` int(11) NOT NULL,
  `Type` varchar(123) NOT NULL,
  `ProductName` varchar(256) NOT NULL,
  `ProductDesc` text NOT NULL,
  `ProductPrice` varchar(123) NOT NULL,
  `MeasurementUnit` varchar(123) NOT NULL,
  `ProductImage` varchar(256) NOT NULL,
  `BaseUOM` varchar(123) NOT NULL,
  `NetWeight` varchar(123) NOT NULL,
  `GrossWeight` varchar(123) NOT NULL,
  `Qty` varchar(123) NOT NULL,
  `ReadyTo` enum('NA','Eat','Cook') NOT NULL,
  `LastUpdated` varchar(123) NOT NULL,
  `Status` enum('Active','Inactive') NOT NULL,
  `AddedBy` varchar(123) NOT NULL,
  `AddedOn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductId`, `Product_Code`, `BrandId`, `Category_Id`, `Sub_CatId`, `Type`, `ProductName`, `ProductDesc`, `ProductPrice`, `MeasurementUnit`, `ProductImage`, `BaseUOM`, `NetWeight`, `GrossWeight`, `Qty`, `ReadyTo`, `LastUpdated`, `Status`, `AddedBy`, `AddedOn`) VALUES
(1, 'SKclZiy1', 1, 1, 1, 'Root', 'Beetroot', 'The beetroot is the taproot portion of the beet plant, usually known in North America as the beet, also table beet, garden beet, red beet, or golden bee', '', '2', 'resources/product-images/1488267112_beetroot.jpg', '1', '', '', '', 'NA', '1488267112', 'Active', '', '2017-02-28 13:01:52'),
(2, 'sWGfXud2', 1, 1, 1, 'Tubes', 'Bottle Gourd', 'In order to make bottle gourd cubes, firstly peel the bottle gourd and discard the stem. Place on a chopping board and cut the peeled bottle gourd into halves', '', '2', 'resources/product-images/1488270099_bottle-gourd.jpg', '1', '', '', '', 'NA', '1488270099', 'Active', '', '2017-02-28 13:51:39'),
(3, 'HskqutY3', 1, 1, 1, 'Tubes', 'Bitter Gourd', 'Bitter melon, also known as bitter gourd or karela (in India), is a unique vegetable-fruit that can be used as food or medicine. It is the edible part of the plant Momordica Charantia, which is a vine of the Cucurbitaceae family and is considered the most bitter among all fruits and vegetabl', '', '2', 'resources/product-images/1488274608_bitter-gourd.jpg', '1', '', '', '', 'NA', '1488274608', 'Active', '', '2017-02-28 15:06:48'),
(4, 'IBhzGRo4', 1, 1, 1, 'Tubes', 'Brinjal', 'The Brinjal, which is commonly known as the Baigan is a very common and affordable vegetable. Although the raw brinjal does not have an agreeable taste, bu', '', '2', 'resources/product-images/1488274689_brinjal.jpg', '1', '', '', '', 'NA', '1488274689', 'Active', '', '2017-02-28 15:08:09'),
(5, 'YRjWbKU5', 1, 1, 1, 'Leafy', 'Cabbage', ' Cabbage is one of those unsung heroes in the kitchen. You might not think too much about it, but it can be one of the most versatile veggi', '', '2', 'resources/product-images/1488274812_cabbage.jpg', '1', '', '', '', 'NA', '1488274812', 'Active', '', '2017-02-28 15:10:12'),
(6, 'mRqaxyU6', 1, 1, 1, 'Root', 'Carrot', 'Carrots is a unique space in Bangalore, filled with love and positive energy whipping up health-conscious vegan plates, juice blends and smoothies. Come ', '', '2', 'resources/product-images/1488275170_carrot.jpg', '1', '', '', '', 'NA', '1488275170', 'Active', '', '2017-02-28 15:16:10'),
(7, 'jVhoRTn7', 1, 1, 1, 'Flower', 'Cauliflower', 'auliflower even ranks among the top 20 foods in regards to ANDI score (Aggregate Nutrient Density Index), which measures vitamin, minera', '', '2', 'resources/product-images/1488275272_cauliflower.jpg', '1', '', '', '', 'NA', '1488275272', 'Active', '', '2017-02-28 15:17:52'),
(8, 'kiUJTSK8', 1, 1, 1, 'Fruit', 'Cucumber', 'The cucumber is a member of the botanical family Cucurbitaceae, along with honeydew, cantaloupe, and watermelon. ', '', '2', 'resources/product-images/1488275357_cucumber.jpg', '1', '', '', '', 'NA', '1488275357', 'Active', '', '2017-02-28 15:19:17'),
(9, 'lVBCoeK9', 1, 1, 1, 'Sticks', 'Drumstick', 'A drumstick is a type of percussion mallet used particularly for playing snare drum, drum kit and some other percussion instruments, and particularly for play', '', '2', 'resources/product-images/1488275463_drumstick.jpg', '1', '', '', '', 'NA', '1488275463', 'Active', '', '2017-02-28 15:21:03'),
(10, 'iGVpoxX10', 0, 0, 0, '', '', '', '', '', 'resources/product-images/1493098779_ladies-finger.jpg', '', '', '', '', '', '1493098779', 'Active', '', '2017-02-28 15:22:33'),
(11, 'RZkXAVE11', 1, 1, 1, 'Root', 'Parsnips', 'By looking at them it can be easy to mistake parsnips for white carrots. Sure, they''re related, but parsnips do a wonderful job of shining on their .', '', '2', 'resources/product-images/1488275748_parsnips.jpg', '1', '', '', '', 'NA', '1488275748', 'Active', '', '2017-02-28 15:25:48'),
(12, 'PQCFvml12', 1, 1, 1, 'Tubes', 'Potatos', 'The world''s favourite root vegetable, the potato comes in innumerable varieties. A member of the nightshade family, like tomatoes and aubergines, it originated .', '', '2', 'resources/product-images/1488275922_potato.jpg', '1', '', '', '', 'NA', '1488275922', 'Active', '', '2017-02-28 15:28:42'),
(13, 'UPJkKbT13', 1, 1, 1, 'Tubes', 'Yellow Cucumber', 'yellow-orange cucumber from mainland China; the young fruit is green. 10-inch fruit are as crisp as an apple.', '', '2', 'resources/product-images/1488276047_yellow-cucumber.jpg', '1', '', '', '', 'NA', '1488276047', 'Active', '', '2017-02-28 15:30:47'),
(14, 'ypXkYIj14', 6, 1, 2, 'Leafy Vegetable', 'Artichoke', 'The globe artichoke is a variety of a species of thistle cultivated as a food. The edible portion of the plant consists of the flower buds before the flowers come into bloom.', '', '2', 'resources/product-images/1488276244_artichoke.jpg', '1', '', '', '', 'Cook', '1488276244', 'Active', '', '2017-02-28 15:34:04'),
(15, 'URTMkNf15', 6, 1, 2, 'Seeds', 'Brussel', 'The Brussels sprout is a member of the Gemmifera Group of cabbages, grown for its edible buds. The leafy green vegetables are typically 2.5–4 cm in diameter and look like miniature cabbages.', '', '2', 'resources/product-images/1488276356_brussel.jpg', '1', '', '', '', 'Cook', '1488276356', 'Active', '', '2017-02-28 15:35:56'),
(16, 'XHICJoM16', 1, 1, 1, 'Fruit', 'Tomato', 'The tomato is the edible fruit of Solanum lycopersicum, commonly known as a tomato plant, which belongs to the', '', '2', 'resources/product-images/1488276565_tomato.jpg', '1', '', '', '', 'NA', '1488276565', 'Active', '', '2017-02-28 15:39:25'),
(17, 'FvComjf17', 1, 1, 1, 'Tubes', 'Onion', 'The onion, also known as the bulb onion or common onion, is a vegetable and is the most widely cultivated species of the genus Allium. ', '', '2', 'resources/product-images/1488276642_onion.jpg', '1', '', '', '', 'NA', '1488276642', 'Active', '', '2017-02-28 15:40:42'),
(18, 'NawEpHo18', 1, 1, 1, 'Tubes', 'Ridge Gourd', 'Luffa is a genus of tropical and subtropical vines in the cucumber family. In everyday non-technical usage, the luffa, also spelled loofah, usually means the fruit of the two species L. aegyptiaca and L. acutangula', '', '2', 'resources/product-images/1488276745_ridge-gourd.jpg', '1', '', '', '', 'NA', '1488276745', 'Active', '', '2017-02-28 15:42:25'),
(19, 'BbTAUQa19', 7, 1, 2, 'Beans', 'Scarlet Runner', 'Scarlet Runner is an ornamental and edible climber or trailer. It bears large, showy sprays of bright scarlet flowers, followed by loads of slender pods about 8', '', '2', 'resources/product-images/1488276854_scarlet-runner.jpg', '1', '', '', '', 'Cook', '1488276854', 'Active', '', '2017-02-28 15:44:14'),
(20, 'lvcesxb20', 7, 1, 2, 'Beans', 'Chickpeas', 'Scarlet Runner is an ornamental and edible climber or trailer. It bears large, showy sprays of bright scarlet flowers, followed by loads of slender pods about 8', '', '2', 'resources/product-images/1488277809_chickpeas.jpg', '1', '', '', '', 'Cook', '1488277809', 'Active', '', '2017-02-28 16:00:09'),
(21, 'FwmMfUe21', 2, 1, 1, 'Beans', 'Beens', 'An event that could have but never did occur: "This is one of the great might-have-beens of modern history', '', '2', 'resources/product-images/1488277811_beens.jpg', '1', '', '', '', 'NA', '1488277811', 'Active', '', '2017-02-28 16:00:11'),
(22, 'fxokIpj22', 2, 1, 2, 'Leafy', 'Celery', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum. Donec id ornare enim.', '', '2', 'resources/product-images/1488279740_celery.jpg', '3', '', '', '', 'Cook', '1488279740', 'Active', '', '2017-02-28 16:32:20'),
(23, 'EavoOzw23', 2, 1, 2, 'Leafy Vegetable', 'Broccoli', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum. Donec id ornare enim.', '', '1', 'resources/product-images/1488279813_broccoli.jpg', '3', '', '', '', 'Eat', '1488279813', 'Active', '', '2017-02-28 16:33:33'),
(24, 'VCkKyRT24', 4, 1, 2, 'Leafy Vegetable', 'Romanesco', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum. Donec id ornare enim.', '', '2', 'resources/product-images/1488279995_romanesco.jpg', '1', '', '', '', 'Cook', '1488279995', 'Active', '', '2017-02-28 16:36:35'),
(25, 'KfjVdlB25', 4, 1, 2, 'Sticks', 'Asparagus', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum. Donec id ornare enim.', '', '2', 'resources/product-images/1488280094_asparagus.jpg', '1', '', '', '', 'Cook', '1488280094', 'Active', '', '2017-02-28 16:38:14'),
(26, 'iYEKuFh26', 4, 1, 2, 'Leafy Vegetable', 'Lettuce', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum. Donec id ornare enim.', '', '2', 'resources/product-images/1488280174_lettuce.jpg', '1', '', '', '', 'Cook', '1488280174', 'Active', '', '2017-02-28 16:39:34'),
(27, 'ofmsjpd27', 6, 2, 6, 'Red Apple', 'Apple', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum. Donec id ornare enim.', '', '2', 'resources/product-images/1488280600_apple.jpg', '6', '', '', '', 'Eat', '1488280600', 'Active', '', '2017-02-28 16:46:40'),
(28, 'WolTUOC28', 7, 2, 6, 'Red Apple', 'Apple', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum. Donec id ornare enim.', '', '2', 'resources/product-images/1488280663_royal-gala-apple.jpg', '6', '', '', '', 'Eat', '1488280663', 'Active', '', '2017-02-28 16:47:43'),
(29, 'eowrmpF29', 8, 2, 6, 'Red Apple', 'Apple', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum. Donec id ornare enim.', '', '2', 'resources/product-images/1488280719_washington-apple.jpg', '6', '', '', '', 'Eat', '1488280719', 'Active', '', '2017-02-28 16:48:39'),
(30, 'hzErGBa30', 6, 2, 6, 'Green Grapes', 'Grapes', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum. Donec id ornare enim.', '', '2', 'resources/product-images/1488280826_grapes.jpg', '6', '', '', '', 'Eat', '1488280826', 'Active', '', '2017-02-28 16:50:26'),
(31, 'KxhevmM31', 6, 2, 6, 'Green Apple', 'Green Apple', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '2', 'resources/product-images/1488283534_green-apple.jpg', '6', '', '', '', 'Eat', '1488283534', 'Active', '', '2017-02-28 17:35:34'),
(32, 'cOVijNa32', 7, 2, 6, 'Green Grapes', 'Green Grapes', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '2', 'resources/product-images/1488284015_grapes.jpg', '6', '', '', '', 'Eat', '1488284015', 'Active', '', '2017-02-28 17:43:35'),
(33, 'AKMFDvV33', 7, 2, 6, 'Black Grapes', 'Black Grapes', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '2', 'resources/product-images/1488284084_grapes_black.jpg', '6', '', '', '', 'Eat', '1488284084', 'Active', '', '2017-02-28 17:44:44'),
(34, 'OqGKksj34', 8, 2, 6, 'Black Grapes', 'Black Grapes', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '2', 'resources/product-images/1488284211_grapes_black.jpg', '6', '', '', '', 'Eat', '1488284211', 'Active', '', '2017-02-28 17:46:51'),
(35, 'hITKrEy35', 6, 2, 6, 'Berry', 'Cranberry', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '1', 'resources/product-images/1488284346_cranberry.jpg', '3', '', '', '', 'Eat', '1488284346', 'Active', '', '2017-02-28 17:49:06'),
(36, 'yaHQVWf36', 8, 2, 6, 'Nuts', 'Brazil Nut', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '1', 'resources/product-images/1488284410_brazil-nut.jpg', '3', '', '', '', 'Eat', '1488284410', 'Active', '', '2017-02-28 17:50:10'),
(37, 'SyRbliT37', 8, 2, 6, 'Berry', 'Blackberry', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '1', 'resources/product-images/1488284569_blackberry.jpg', '3', '', '', '', 'Eat', '1488284569', 'Active', '', '2017-02-28 17:52:49'),
(38, 'JiWIUvx38', 7, 2, 6, 'Berry', 'Acerola', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '1', 'resources/product-images/1488284682_acerola.jpg', '3', '', '', '', 'Eat', '1488284682', 'Active', '', '2017-02-28 17:54:42'),
(39, 'xHvqeQU39', 8, 2, 5, 'Strawberry', 'Strawberry Oblate', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '1', 'resources/product-images/1488285214_strawberry-oblate.jpg', '3', '', '', '', 'Eat', '1488285214', 'Active', '', '2017-02-28 18:03:34'),
(40, 'iaqRUPU40', 7, 2, 5, 'Strawberry', 'Straberry Long Conic', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '100', '1', 'resources/product-images/1488285392_straberry-long-conic.jpg', '3', '120', '120', '1', 'Eat', '1488519380', 'Active', '', '2017-02-28 18:06:32'),
(41, 'dGSgfHc41', 6, 2, 5, 'Strawberry', 'Straberry', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '1', 'resources/product-images/1488285739_straberry.jpg', '3', '', '', '', 'Eat', '1488285739', 'Active', '', '2017-02-28 18:12:19'),
(42, 'JxhCfvF42', 6, 2, 5, 'Berry', 'Acai Berry', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '1', 'resources/product-images/1488285992_acai-berry.jpg', '3', '', '', '', 'Eat', '1488285992', 'Active', '', '2017-02-28 18:16:32'),
(43, 'uilYVzJ43', 6, 2, 5, '', 'Banana', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '2', 'resources/product-images/1488286293_banana.jpg', '4', '', '', '', 'Eat', '1488286293', 'Active', '', '2017-02-28 18:21:33'),
(44, 'yIXtVor44', 8, 2, 5, '', 'Pineapple', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '1', 'resources/product-images/1488286557_pineapple.jpg', '4', '', '', '', 'Eat', '1488286557', 'Active', '', '2017-02-28 18:25:57'),
(45, 'SUDYOFw45', 7, 2, 5, '', 'Papaya', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '1', 'resources/product-images/1488286757_papaya.jpg', '4', '', '', '', 'Eat', '1488286757', 'Active', '', '2017-02-28 18:29:17'),
(46, 'MGKrHAV46', 7, 2, 5, '', 'Pomegranate', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '2', 'resources/product-images/1488287644_pomegranate.jpg', '3', '', '', '', 'Eat', '1488287644', 'Active', '', '2017-02-28 18:44:04'),
(47, 'whifZHD47', 9, 4, 0, 'Cheese', 'Cheese', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '1', 'resources/product-images/1488287770_ammul.jpg', '3', '', '', '', 'NA', '1488287770', 'Active', '', '2017-02-28 18:46:10'),
(48, 'WmlbBwD48', 9, 4, 0, 'Milk', 'Taaza Milk', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '3', 'resources/product-images/1488287835_ammul-taaza.jpg', '3', '', '', '', 'NA', '1488287835', 'Active', '', '2017-02-28 18:47:15'),
(49, 'PKBwEbZ49', 9, 4, 0, 'Milk Powder', 'Milk Powder', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '1', 'resources/product-images/1488287887_amul-milk-powder.jpg', '3', '', '', '', 'NA', '1488287887', 'Active', '', '2017-02-28 18:48:07'),
(50, 'mfDFdCi50', 11, 4, 0, 'Milk', 'Milk', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '3', 'resources/product-images/1488287957_ap-milk.jpg', '3', '', '', '', 'NA', '1488287957', 'Active', '', '2017-02-28 18:49:17'),
(51, 'aTwfNBG51', 11, 4, 0, 'Milk Powder', 'Milk Powder', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '1', 'resources/product-images/1488288007_condensed-milk.jpg', '3', '', '', '', 'NA', '1488288007', 'Active', '', '2017-02-28 18:50:07'),
(52, 'lYUFajH52', 10, 4, 0, 'Cheese', 'Cheese', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '1', 'resources/product-images/1488288051_slices-cheese.jpg', '3', '', '', '', 'NA', '1491398078', 'Active', 'admin', '2017-02-28 18:50:51'),
(53, 'rhbNpsA53', 1, 3, 4, 'Chiken Skin Less Breast', 'Chicken Breasts', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '1', 'resources/product-images/1488288233_harvestland-chicken-breasts.jpg', '3', '', '', '', 'Cook', '1488288233', 'Active', '', '2017-02-28 18:53:53'),
(54, 'JNIOHBm54', 1, 3, 4, 'Chiken Skinless Legs', 'Chiken Legs', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '1', 'resources/product-images/1488288341_harvestland-chicken-legs.jpg', '3', '', '', '', 'Cook', '1488288341', 'Active', '', '2017-02-28 18:55:41'),
(55, 'UasxvFB55', 1, 3, 4, 'Chiken Skin Less Wings', 'Chicken Wings', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '1', 'resources/product-images/1488288442_harvestland-chicken-wings.jpg', '3', '', '', '', 'Cook', '1488288442', 'Active', '', '2017-02-28 18:57:22'),
(56, 'cRUIKNi56', 2, 3, 4, 'Chiken Skinless Legs', 'Chicken Legs', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '1', 'resources/product-images/1488288521_jyothi-chicken-wings.jpg', '3', '', '', '', 'Cook', '1488288522', 'Active', '', '2017-02-28 18:58:42'),
(57, 'TeuboaO57', 3, 3, 4, 'Chiken Skin Less Breast', 'Chiken Breast', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '1', 'resources/product-images/1488288598_tyson-chicken-breast-skinless2.jpg', '3', '', '', '', 'Cook', '1488288598', 'Active', '', '2017-02-28 18:59:58'),
(58, 'UPHgtxm58', 1, 3, 4, 'Chicken Crispy', 'Chicken Cryspy', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '1', 'resources/product-images/1488288664_cp-chicken-cryspy.jpg', '3', '', '', '', 'Eat', '1488288664', 'Active', '', '2017-02-28 19:01:04'),
(59, 'YCOHlZM59', 2, 3, 4, 'Chicken Crispy', 'Chicken Crispy Legs', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '1', 'resources/product-images/1488288739_frozen-chicken-cryspy.jpg', '3', '', '', '', 'Eat', '1488288739', 'Active', '', '2017-02-28 19:02:19'),
(60, 'FHvfQEM60', 2, 3, 4, 'Chiken Skin Less Breast', 'Greatvalue Chicken Breast', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '1', 'resources/product-images/1488288906_greatvalue-chicken-breast.jpg', '3', '', '', '', 'Cook', '1488288906', 'Active', '', '2017-02-28 19:05:06'),
(61, 'auGPtox61', 4, 3, 3, 'Nuggets', 'Nuggets', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '1', 'resources/product-images/1488288995_mccain-veg-nuggets.jpg', '3', '', '', '', 'NA', '1491399383', 'Active', 'userB', '2017-02-28 19:06:35'),
(62, 'GwNfRJl62', 1, 3, 3, 'Samosa', 'Mini Samosa', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '1', 'resources/product-images/1488289109_haldirams-mini-samosa.jpg', '3', '', '', '', 'NA', '1489820126', 'Active', 'admin', '2017-02-28 19:08:29'),
(63, 'xiaeEkd63', 4, 3, 3, 'Chaap', 'Treat Chaap', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.\nAdded content goes here', '', '1', 'resources/product-images/1488289181_frozen-treat-chaap.jpg', '3', '', '', '', 'NA', '1491399369', 'Active', 'userB', '2017-02-28 19:09:41'),
(64, 'zbaUhTk64', 2, 3, 3, 'Kabab', 'Afghani Seekh Kabab', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '1', 'resources/product-images/1488289250_godrej-afghani-seekh-kabab.jpg', '3', '', '', '', 'NA', '1491396598', 'Active', 'admin', '2017-02-28 19:10:50'),
(65, 'JQuyMxq65', 3, 3, 3, 'Chat', 'Aloo Chat', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque consequat libero in rhoncus. Nullam vestibulum ultrices gravida. Donec eu augue et dolor interdum rutrum.', '', '1', 'resources/product-images/1488610076_Godrej-dilli-aloo-chat.jpg', '3', '', '', '', 'NA', '1492872209', 'Active', 'admin', '2017-02-28 19:12:12'),
(66, 'eXQNRYv66', 1, 1, 1, 'Mushroom', 'Mushroom', 'mushroom', '', '2', 'resources/product-images/1492872362_IMG-20161219-WA0000.jpg', '3', '', '', '', 'NA', '1492872416', 'Active', 'admin', '2017-04-22 20:16:02'),
(67, 'cUQtUuI67', 1, 1, 1, 'Tubes', 'Carrot', 'Descrition goes here', '', '2', 'resources/product-images/1493102584_carrot.jpg', '1', '', '', '', 'NA', '1494400104', 'Active', 'admin', '2017-04-25 12:13:04');

-- --------------------------------------------------------

--
-- Table structure for table `smtp_details`
--

CREATE TABLE `smtp_details` (
  `SLNO` int(12) NOT NULL,
  `user` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `smtp_details`
--

INSERT INTO `smtp_details` (`SLNO`, `user`, `password`) VALUES
(1, 'sudhaker.1228@gmail.com', 'sonet_1228');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `Sub_CatId` int(12) NOT NULL,
  `CategId` int(12) NOT NULL,
  `SubCategory` varchar(256) NOT NULL,
  `Status` enum('Active','Inactive') NOT NULL,
  `LastUpdated` varchar(123) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`Sub_CatId`, `CategId`, `SubCategory`, `Status`, `LastUpdated`) VALUES
(1, 1, 'domestic', 'Active', '1487052447'),
(2, 1, 'international', 'Active', '1487052381'),
(3, 3, 'veg', 'Active', '1487052457'),
(4, 3, 'non-veg', 'Active', '1487052468'),
(5, 2, 'domestic', 'Active', '1487052412'),
(6, 2, 'international', 'Active', '1487052421');

-- --------------------------------------------------------

--
-- Table structure for table `subcattypes`
--

CREATE TABLE `subcattypes` (
  `Id` int(12) NOT NULL,
  `CategoryId` int(12) NOT NULL,
  `Type` varchar(123) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subcattypes`
--

INSERT INTO `subcattypes` (`Id`, `CategoryId`, `Type`) VALUES
(1, 1, 'Leafy Vegetable'),
(2, 1, 'Beans'),
(3, 1, 'Tubes'),
(4, 1, 'Sticks'),
(5, 1, 'Fruit'),
(6, 1, 'Root'),
(7, 1, 'Leafy'),
(8, 1, 'Flower'),
(9, 1, 'Seeds'),
(10, 2, 'Red Apple'),
(11, 2, 'Green Apple'),
(12, 2, 'Strawberry'),
(13, 2, 'Oblate'),
(14, 2, 'Long Conic'),
(15, 2, 'Globose'),
(16, 3, 'Breast'),
(17, 3, 'Wings'),
(18, 3, 'Legs'),
(19, 3, 'Chicken Crispy'),
(20, 4, 'Cheese'),
(21, 4, 'Milk Powder'),
(22, 4, 'Milk'),
(23, 2, 'Green Grapes'),
(24, 2, 'Black Grapes'),
(25, 2, 'Berry'),
(26, 2, 'Nuts'),
(27, 3, 'Chiken Skin Less Breast'),
(28, 3, 'Chiken Skinless Legs'),
(29, 3, 'Chiken Skin Less Wings'),
(30, 3, 'Nuggets'),
(31, 3, 'Samosa'),
(32, 3, 'Chaap'),
(33, 3, 'Kabab'),
(34, 3, 'Chat'),
(35, 1, 'Mushroom');

-- --------------------------------------------------------

--
-- Table structure for table `uploadpaths`
--

CREATE TABLE `uploadpaths` (
  `SLNO` int(12) NOT NULL,
  `UploadFor` varchar(245) NOT NULL,
  `Path` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uploadpaths`
--

INSERT INTO `uploadpaths` (`SLNO`, `UploadFor`, `Path`) VALUES
(1, 'brand', 'resources/brand-logos/'),
(2, 'category', 'resources/category-logos/'),
(3, 'product-image', 'resources/product-images/');

-- --------------------------------------------------------

--
-- Table structure for table `userdetails`
--

CREATE TABLE `userdetails` (
  `ID` int(12) NOT NULL,
  `SLNO` int(12) NOT NULL,
  `BrandId` int(11) NOT NULL,
  `Owner_Name` varchar(234) NOT NULL,
  `Email` varchar(234) NOT NULL,
  `AuthorisedEmail` varchar(123) NOT NULL,
  `Phone` varchar(234) NOT NULL,
  `Address` text NOT NULL,
  `Location` text NOT NULL,
  `City` varchar(123) NOT NULL,
  `LastUpdated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userdetails`
--

INSERT INTO `userdetails` (`ID`, `SLNO`, `BrandId`, `Owner_Name`, `Email`, `AuthorisedEmail`, `Phone`, `Address`, `Location`, `City`, `LastUpdated`) VALUES
(16, 19, 1, 'nayasa', 'nayasaa@mailinator.com', '', '', '', 'ramanthapur', '', '2017-02-22 11:13:00'),
(20, 23, 3, 'tameem', 'tameem@mailinator.com', '', '', '', 'MEHADIPATNAM', '', '2017-02-23 18:38:51'),
(21, 24, 2, 'jackson', 'jackson@mailinator.com', 'jacksonauthor@mailinator.com', '9963945012', '', 'vidhyanagar', '', '2017-02-24 17:03:50'),
(22, 25, 3, 'Sharma enterprises', 'tecknovision.com@gmail.com', '', '', '', 'Shivam', '', '2017-02-24 16:37:54'),
(23, 26, 8, 'Jimson', 'jimson_was@mailinator.com', '', '', '', 'Banjara hills', '', '2017-03-03 10:28:55'),
(24, 27, 1, 'userA', 'userA@mailinator.com', 'userA@mailinator.com', '9963945086', '', '', '', '0000-00-00 00:00:00'),
(25, 28, 1, 'userB', 'userB@mailinator.com', 'userB@mailinator.com', '9968745296', '', '', '', '0000-00-00 00:00:00'),
(26, 29, 3, 'Dominos', 'info@trillionit.com', 'shravan@trillionit.com', '04040157734', 'Shivam road', 'shivam', '', '2017-03-28 11:06:57'),
(27, 30, 2, 'sammy', 'sammy@mailinator.com', 'samy_auth@mailinator.com', '', '', 'Hyderabad', '', '2017-03-15 17:57:47'),
(28, 31, 0, 'MCD amberpet', 'tecknovision.com@gmail.com', '', '9885486645', 'amberpet', 'amberpet', '', '2017-03-15 19:33:43'),
(29, 32, 0, 'justdoit', 'justdoit@mailinator.com', '', '99639658656', 'Amberper', 'Amberpet', '', '2017-03-15 19:34:37'),
(30, 33, 0, 'teststore', 'teststore@mailinator.com', '', '9963956896', 'Amberpet', 'Amberpet', '', '2017-03-15 19:36:22'),
(31, 34, 0, 'Another', 'anotherstore@mailinator.com', '', '9968596452', 'Amberpet', 'Amberpet', '', '2017-03-15 19:38:16'),
(32, 35, 1, 'samplestore', 'samplestore@mailinator.com', 'samplestore_auth@mailinator.com', '9963856987', 'sdfdsf', 'Amberpet', '', '2017-03-16 10:18:29'),
(33, 36, 2, 'MCD amberpet', 'tecknovision@mailinator.com', '', '9885486645', 'amberpet', 'amberpet', '', '2017-03-15 19:48:25'),
(34, 37, 2, 'MCD', 'sudhakar@coldcaregroup.com', '', '', '', 'Banjara Hils', '', '2017-03-15 21:41:31'),
(35, 39, 0, 'Javeed', 'javeed@mailinator.com', '', '', '', 'Patelwada', 'Hyderabad', '2017-05-10 12:34:00'),
(36, 40, 0, 'iqbal', 'iqbol@mailinator.com', '', '9993949689', 'Address goes here', 'Prem Nagar', 'Hyderabad', '2017-03-17 18:56:18'),
(37, 41, 0, 'vasavi', 'vasaavi@mailinator.com', 'vasavi.auth@mailinator.com', '8745628965', '', 'prem nagar', 'Hyderabad', '2017-03-21 12:21:29'),
(38, 42, 0, 'mehareen', 'mehareen@mailinator.com', 'mehareen.auth@mailinator.com', '8569874513', '', 'Malakpet', 'Hyderabad', '2017-03-21 12:35:30'),
(39, 43, 0, 'Anamica', 'anamica@mailinator.com', 'anamica.auth@mailinator.com', '9968652369', 'My store address will goes here', 'Premnagar', 'Hyderabad', '2017-03-24 12:46:25'),
(40, 44, 0, 'jeff-jospeh', 'jeff.jospeh@mailinator.com', 'jeff.jospeh.auth@mailinator.com', '9963945071', '', 'jeff-jospeh', 'Hyderabad', '2017-03-24 12:37:29'),
(41, 45, 0, 'nanak', 'nanak@mailinator.com', 'nanak.auth@mailinator.com', '9965897458', 'H.no# 3-19-098, Nanak ramguda', 'nanakramguda', 'Hyderabad', '2017-04-05 18:33:57'),
(42, 46, 0, 'sanny', 'sanny@mailinator.com', '', '9963659856', 'Address goes here', 'Location', 'Hyderabad', '2017-04-25 14:05:33'),
(43, 47, 0, 'newteststore123', 'newteststore@mailinator.com', '', '9968598745', 'Address', 'Location', 'Hyderabad', '2017-04-25 14:32:27'),
(44, 48, 0, 'sonic', 'sonic@mailinator.com', '', '9985697845', 'ramanthapur', 'ramanthapur', 'Hyderabad', '2017-05-01 14:59:57'),
(45, 49, 0, 'mercury', 'mercury@mailinator.com', 'mercuree-auth@mailinator.com', '89567458965', 'address goes here', 'Vidhyanagar', 'Hyderabad', '2017-07-13 16:28:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `SLNO` int(12) NOT NULL,
  `UserName` varchar(253) NOT NULL,
  `Password` varchar(253) NOT NULL,
  `Salt` varchar(253) NOT NULL,
  `LastLogin` datetime NOT NULL,
  `Status` enum('Active','Inactive','New') NOT NULL,
  `LastUpdated` int(12) NOT NULL,
  `Role` enum('1','2','3','0') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`SLNO`, `UserName`, `Password`, `Salt`, `LastLogin`, `Status`, `LastUpdated`, `Role`) VALUES
(1, 'admin', '$2a$05$d0EQuN13DAVKrsP2ZRidy.1CnuIiQYx5rRIJiuX22OqlgDRBQ5mOC', 'd0EQuN13DAVKrsP2ZRidy', '2017-10-30 18:05:08', 'Active', 1509366908, '1'),
(19, 'nayasaa', '$2a$05$Dv9MYEUOqIvJI0VYv320z.GOCAbxIez2ssy6Qj7ZzPnw5RVuf/Rp.', 'Dv9MYEUOqIvJI0VYv320z', '2017-02-22 11:15:26', 'Active', 1487742326, '2'),
(23, 'tameem', '$2a$05$8EgItMTKt5PCdxGe8EhtQ.LYWX1PTk9arfKeQwGzhoWVY4ETp9hxe', '8EgItMTKt5PCdxGe8EhtQ', '2017-02-23 18:38:51', 'Active', 1487855331, '2'),
(24, 'jackson', '$2a$05$MEi7bLeFcRtnhG75da4BE.H7DuSwHRcXUGZKrjaTrtGaO5x0JYKay', 'MEi7bLeFcRtnhG75da4BE', '2017-03-03 15:03:24', 'Active', 1489742142, '2'),
(25, 'vskshravan', '$2a$05$P/mDeAqA1J.7TmN8/bCKE.nhE.x7wMuLIQH6DO5E1Ozi4syAE8pFa', 'P/mDeAqA1J.7TmN8/bCKE', '2017-02-24 16:46:05', 'Active', 1487934965, '2'),
(26, 'jimson_was', '$2a$05$TD0PAGBR/WwfC.04aWz5W.i.SXHV68QSZgR5ARBjo.3qIpdSnCZvm', 'TD0PAGBR/WwfC.04aWz5W', '0000-00-00 00:00:00', 'New', 1488517135, '2'),
(27, 'userA', '$2a$05$F48e2uXuo28BSAV8ruKWS.3vVXSHGMZLXOFATG5k.9vg/8XOuuIc6', 'F48e2uXuo28BSAV8ruKWS', '2017-03-15 19:54:17', 'Active', 1489587857, '1'),
(28, 'userB', '$2a$05$wdABhRf6nSfRh5VIxQKlk.pAALwPfkK2K2jYVXQgqByEQ5WTb.VIW', 'wdABhRf6nSfRh5VIxQKlk', '2017-04-05 19:05:30', 'Active', 1491399330, '1'),
(29, 'info@trillionit.com', '$2a$05$7ZDZrOid6DTcBLO2Lp/LC.CeMLLGBFBUdq/GHDmsj16Xu/OH3Ppya', '7ZDZrOid6DTcBLO2Lp/LC', '2017-03-28 10:45:56', 'Active', 1490678156, '2'),
(30, 'sammy', '$2a$05$PEx3QIDjY6bl09aa/Nmsd.1R9a/X0wmxh0xKF.S4KtPINhDXRj.ri', 'PEx3QIDjY6bl09aa/Nmsd', '2017-03-15 17:57:24', 'Active', 1489580844, '2'),
(31, 'tecknovision', '$2a$05$WbSTCu/DhyQ7nBL9uIvaD.yjDg3VtWSZWBiPvH.RZZh/erD1XLvDu', 'WbSTCu/DhyQ7nBL9uIvaD', '0000-00-00 00:00:00', 'Active', 1489586623, '2'),
(32, 'justdoit', '$2a$05$G.hnGXubJLw8FVi6YgIyi.pv5He8m3tYqC3pN9a8SNGlB3OxwMrHi', 'G.hnGXubJLw8FVi6YgIyi', '0000-00-00 00:00:00', 'Active', 1489586677, '2'),
(33, 'testuser', '$2a$05$Ap9.RMtsLQOP.AcMZbxQo.eJ0mPgcDyqP/A3L9M7CaB6Xm/iSlZqy', 'Ap9.RMtsLQOP.AcMZbxQo', '0000-00-00 00:00:00', 'Active', 1489586782, '2'),
(34, 'anotheruser', '$2a$05$3aOOg1FlVMaT7i2wuBmSG.AkeoVJGpKZ609Con6Kr0Se.NoHuOs.y', '3aOOg1FlVMaT7i2wuBmSG', '0000-00-00 00:00:00', 'Active', 1489586896, '2'),
(35, 'sampleuserid', '$2a$05$/33UPJN30DtDmqJb9taAE.uji34yd.uCYam/Au.ebAmZ6oda95MzC', '/33UPJN30DtDmqJb9taAE', '2017-03-16 10:18:09', 'Active', 1489639689, '2'),
(36, 'tecknovision123', '$2a$05$VPWH3YCLfRENoqh6i7XSv.k7Sio20sr9Itxww/rTXUCpW96pHybeK', 'VPWH3YCLfRENoqh6i7XSv', '2017-03-15 19:48:25', 'Active', 1489587505, '2'),
(37, 'sudhakar123', '$2a$05$uyMn4UIBvXCulv98iEId/.u5g0zeVa7R5V.cnpii5ly4gOl.Tqj2u', 'uyMn4UIBvXCulv98iEId/', '2017-03-15 22:02:44', 'Active', 1489595564, '2'),
(39, 'javeed', '$2a$05$HEwwnvYjaC3/Ygf00Y7uP.nrsTxrDdy4FOzEKbqkxM4B7BN.gfkA6', 'HEwwnvYjaC3/Ygf00Y7uP', '2017-05-10 12:34:00', 'Active', 1494399840, '2'),
(40, 'iqbal', '$2a$05$SXBxYkgfH/Je7Kfuo9iWO./E5O2Ii6jfwqmcb83nRf5bTPG90uQWy', 'SXBxYkgfH/Je7Kfuo9iWO', '0000-00-00 00:00:00', 'Active', 1489757178, '2'),
(41, 'vasaavi', '$2a$05$VeXgXlx.A/iBuM.Beacrm.XgUiluAeRg9RGJhVs4diw3YvaWSIg3q', 'VeXgXlx.A/iBuM.Beacrm', '2017-03-21 12:21:08', 'Active', 1490079068, '2'),
(42, 'mehareen', '$2a$05$ulC44Ng0g4Z.7J9pbukJf.mrIdGyBdlglC9RN5.R5ihpcrdR7zkWC', 'ulC44Ng0g4Z.7J9pbukJf', '2017-03-21 12:35:14', 'Active', 1490079914, '2'),
(43, 'anamica', '$2a$05$yhO5kpUnXk32T7lJm/TrO.ksLnq84rY53ympFyDoVpTdqP8aXx8eK', 'yhO5kpUnXk32T7lJm/TrO', '2017-04-25 14:28:36', 'Active', 1493110716, '2'),
(44, 'jeff-jospeh', '$2a$05$yAbJs6M6KaiFnv1AkIPjc.ok.eQhgdTqr2ZLjqjQRolOi8P8oCgK6', 'yAbJs6M6KaiFnv1AkIPjc', '2017-03-24 12:34:54', 'Active', 1490339094, '2'),
(45, 'nanak', '$2a$05$2yJi818MemauXyGpgxISM.LDeNksCMWCuRmPxpZHyXuynONfaH6eG', '2yJi818MemauXyGpgxISM', '2017-04-05 18:35:36', 'Active', 1491397536, '2'),
(46, 'sanny', '$2a$05$oF8vCIxhp/uZ0X8s3uaw2.8S98IiefVVweVouWfD4RKSlbZxShJDe', 'oF8vCIxhp/uZ0X8s3uaw2', '2017-04-25 14:05:33', 'Active', 1493109333, '2'),
(47, 'newtestuser', '$2a$05$lZW3P05ajb/wR1LjJEfCg.XOWv0UdjIndAJyYMwvBWZK6uO6cdUk.', 'lZW3P05ajb/wR1LjJEfCg', '0000-00-00 00:00:00', 'Active', 1493110947, '2'),
(48, 'sonic', '$2a$05$fIcQzt3i97qhVwZg5iYKs.9Hj1tRyfhINS/WXc4nP2XgNFOU6HkfW', 'fIcQzt3i97qhVwZg5iYKs', '0000-00-00 00:00:00', 'Active', 1493630997, '2'),
(49, 'mercuree', '$2a$05$fO2P7sq.jhQtUmgCdlB9A.kO4666fFEVg4eOFvVJ6wNb9DU1BCkYq', 'fO2P7sq.jhQtUmgCdlB9A', '2017-07-13 16:28:37', 'Active', 1499943517, '2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `baseuom`
--
ALTER TABLE `baseuom`
  ADD PRIMARY KEY (`baseid`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`BrandId`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `getkeys`
--
ALTER TABLE `getkeys`
  ADD PRIMARY KEY (`SLNO`);

--
-- Indexes for table `measurements`
--
ALTER TABLE `measurements`
  ADD PRIMARY KEY (`MeasurementId`);

--
-- Indexes for table `orderproducts`
--
ALTER TABLE `orderproducts`
  ADD PRIMARY KEY (`OPID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderId`);

--
-- Indexes for table `packagintypes`
--
ALTER TABLE `packagintypes`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductId`);

--
-- Indexes for table `smtp_details`
--
ALTER TABLE `smtp_details`
  ADD PRIMARY KEY (`SLNO`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`Sub_CatId`);

--
-- Indexes for table `subcattypes`
--
ALTER TABLE `subcattypes`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `uploadpaths`
--
ALTER TABLE `uploadpaths`
  ADD PRIMARY KEY (`SLNO`);

--
-- Indexes for table `userdetails`
--
ALTER TABLE `userdetails`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`SLNO`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `baseuom`
--
ALTER TABLE `baseuom`
  MODIFY `baseid` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `BrandId` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `CategoryID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `getkeys`
--
ALTER TABLE `getkeys`
  MODIFY `SLNO` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `measurements`
--
ALTER TABLE `measurements`
  MODIFY `MeasurementId` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `orderproducts`
--
ALTER TABLE `orderproducts`
  MODIFY `OPID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderId` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `packagintypes`
--
ALTER TABLE `packagintypes`
  MODIFY `Id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ProductId` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT for table `smtp_details`
--
ALTER TABLE `smtp_details`
  MODIFY `SLNO` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `Sub_CatId` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `subcattypes`
--
ALTER TABLE `subcattypes`
  MODIFY `Id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `uploadpaths`
--
ALTER TABLE `uploadpaths`
  MODIFY `SLNO` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `userdetails`
--
ALTER TABLE `userdetails`
  MODIFY `ID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `SLNO` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
