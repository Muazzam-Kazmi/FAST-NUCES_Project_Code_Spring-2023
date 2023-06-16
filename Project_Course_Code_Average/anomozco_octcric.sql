-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 30, 2023 at 07:28 AM
-- Server version: 10.3.38-MariaDB-cll-lve
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `anomozco_octcric`
--

-- --------------------------------------------------------

--
-- Table structure for table `tushantMarketing_admins`
--

CREATE TABLE `tushantMarketing_admins` (
  `id` varchar(256) NOT NULL,
  `name` varchar(256) DEFAULT '',
  `email` varchar(256) DEFAULT '',
  `password` varchar(256) DEFAULT '',
  `timeAdded` varchar(256) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tushantMarketing_admins`
--

INSERT INTO `tushantMarketing_admins` (`id`, `name`, `email`, `password`, `timeAdded`) VALUES
('admin', 'admin', 'admin@portal.com', '123', '1675351626');

-- --------------------------------------------------------

--
-- Table structure for table `tushantMarketing_affiliates`
--

CREATE TABLE `tushantMarketing_affiliates` (
  `id` varchar(256) NOT NULL,
  `email` varchar(256) DEFAULT '',
  `timeAdded` varchar(256) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tushantMarketing_affiliates`
--

INSERT INTO `tushantMarketing_affiliates` (`id`, `email`, `timeAdded`) VALUES
('LEQWLX9AN0', 'email@email.com', '1682693606');

-- --------------------------------------------------------

--
-- Table structure for table `tushantMarketing_bonus`
--

CREATE TABLE `tushantMarketing_bonus` (
  `id` varchar(256) NOT NULL,
  `salesPersonId` varchar(256) DEFAULT '',
  `upgradedTo` varchar(256) DEFAULT '',
  `bonusAwarded` int(11) DEFAULT 0,
  `timeAdded` varchar(256) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tushantMarketing_clients`
--

CREATE TABLE `tushantMarketing_clients` (
  `id` varchar(256) NOT NULL,
  `name` varchar(256) DEFAULT '',
  `firstName` varchar(256) DEFAULT '',
  `lastName` varchar(256) DEFAULT '',
  `postalAddress` varchar(256) DEFAULT '',
  `code` varchar(256) DEFAULT '',
  `timeAdded` varchar(256) DEFAULT '',
  `autoIncrement` int(11) NOT NULL,
  `email` varchar(256) DEFAULT '',
  `contactNo` varchar(256) DEFAULT '',
  `paymentStatus` varchar(256) DEFAULT 'Pending',
  `subscriptionId` varchar(256) DEFAULT 'None',
  `timeCancelled` varchar(256) DEFAULT 'None'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tushantMarketing_clients`
--

INSERT INTO `tushantMarketing_clients` (`id`, `name`, `firstName`, `lastName`, `postalAddress`, `code`, `timeAdded`, `autoIncrement`, `email`, `contactNo`, `paymentStatus`, `subscriptionId`, `timeCancelled`) VALUES
('8KFL0Z7I58', 'newton newton', 'newton', 'newton', 'newton', 'Marketing', '1681124744', 130, 'newton@newton.com', 'newton', 'Cancelled', 'sub_1MvIXtHQjkfG1DwOIV7ubp3v', '1681744909'),
('8URMN31ERO', 'msn msn', 'msn', 'msn', 'msn', 'Marketing', '1682090242', 132, 'msn@msn.com', 'msn', 'Paid', 'sub_1MzLiXHQjkfG1DwOXWmjaw5g', 'None'),
('8XWYY8HRCL', 'asd asd', 'asd', 'asd', 'asd', 'Marketing', '1682600713', 133, 'asd@asd.com', '123', 'Paid', 'sub_1N1UWNHQjkfG1DwOEu4e0ijK', 'None'),
('IQAF45FRXG', 'asdasd ddassd', 'asdasd', 'ddassd', 'asd', '68UFCH', '1682601009', 134, 'mohsinahmedzakir@gmail.com', 'asd', 'Cancelled', 'sub_1N1UaxHQjkfG1DwO8sHNE7oj', '1682601141'),
('LNJC3Q85PW', 'newton1 newton1', 'newton1', 'newton1', 'newton1', 'Marketing', '1681124785', 131, 'newton1@newton1.com', 'newton1', 'Pending', 'None', 'None');

-- --------------------------------------------------------

--
-- Table structure for table `tushantMarketing_email_template`
--

CREATE TABLE `tushantMarketing_email_template` (
  `id` varchar(256) NOT NULL,
  `subject` varchar(256) DEFAULT '',
  `description` longtext DEFAULT NULL,
  `attachment` varchar(256) DEFAULT 'none',
  `timeAdded` varchar(256) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tushantMarketing_email_template`
--

INSERT INTO `tushantMarketing_email_template` (`id`, `subject`, `description`, `attachment`, `timeAdded`) VALUES
('main', 'hello {username}', 'THank YOu {username}', 'none', '1676898095');

-- --------------------------------------------------------

--
-- Table structure for table `tushantMarketing_payrolls`
--

CREATE TABLE `tushantMarketing_payrolls` (
  `id` varchar(256) NOT NULL,
  `forMonth` varchar(256) DEFAULT '',
  `timeAdded` varchar(256) DEFAULT '',
  `forMonthTimeStamp` varchar(256) DEFAULT 'None'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tushantMarketing_payrolls`
--

INSERT INTO `tushantMarketing_payrolls` (`id`, `forMonth`, `timeAdded`, `forMonthTimeStamp`) VALUES
('HVR2LT3PY6', 'March', '1682601299', '1679875200');

-- --------------------------------------------------------

--
-- Table structure for table `tushantMarketing_salesPerson`
--

CREATE TABLE `tushantMarketing_salesPerson` (
  `autoIncrement` int(11) NOT NULL,
  `id` varchar(200) NOT NULL,
  `name` varchar(256) DEFAULT '',
  `firstName` varchar(256) DEFAULT '',
  `lastName` varchar(256) DEFAULT '',
  `codeId` varchar(256) DEFAULT '',
  `email` varchar(256) DEFAULT '',
  `phone` varchar(256) DEFAULT '',
  `instagram` varchar(256) DEFAULT '',
  `facebook` varchar(256) DEFAULT '',
  `tiktok` varchar(256) DEFAULT '',
  `timeAdded` varchar(256) DEFAULT '',
  `totalSales` int(11) DEFAULT 0,
  `salesTier` varchar(256) DEFAULT 'Tier 0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tushantMarketing_salesPerson`
--

INSERT INTO `tushantMarketing_salesPerson` (`autoIncrement`, `id`, `name`, `firstName`, `lastName`, `codeId`, `email`, `phone`, `instagram`, `facebook`, `tiktok`, `timeAdded`, `totalSales`, `salesTier`) VALUES
(109, '5FF3WKD8VX', 'Iain (Mac) Perth', 'Iain (Mac)', 'Perth', 'SSHD3X', '----@Test', '', '', '', '', '1679918474', 0, 'Tier 0'),
(113, 'AI3F2KV8A0', 'asd asd', 'asd', 'asd', 'OUJ18U', 'asd@asd.com', 'asd', 'asd', 'asd', 'asd', '1681123861', 0, 'Tier 0'),
(108, 'BLEK1C3LCW', 'Nawo Fashion Manager', 'Nawo', 'Fashion Manager', 'A4WJWC', 'nawoda.bandararedress@gmail.com', '00000000002', '', '', '', '1679918369', 0, 'Tier 0'),
(110, 'BQGD383NV1', 'Walker Hill', 'Walker', 'Hill', '12K3LX', 'Lana@walkerhilldigital.com.au', '', '', '', '', '1679918613', 0, 'Tier 0'),
(111, 'IKRECCKX7B', 'Tryshan Martin', 'Tryshan', 'Martin', 'EFO896', 'Barneymartin23@hotmail.com', '0458799926', '', '', '', '1680352807', 0, 'Tier 0'),
(127, 'IXPIB9RPVY', 'Feoic Peter', 'Feoic', 'Peter', '3Clubs', 'asd@asd.com', '123', '123', '123', '1123', '1682602824', 0, 'Tier 0'),
(126, 'JFCB89NGWN', 'asd asd', 'asd', 'asd', '6TH0LK', 'asd@sdasdasd.com', 'asd', 'asd', 'asd', 'asd', '1681218613', 0, 'Tier 0'),
(107, 'USLAOCO9PT', 'Daisy Marketing', 'Daisy', 'Marketing', 'ZCHR43', 'dap.angadol@gmail.com', '0000000001', '', '', '', '1679918250', 0, 'Tier 0'),
(105, 'Z0ZHMB01VO', 'Marketing Team', 'Marketing', 'Team', 'Marketing', 'marketing@portal.com', '123', '123', '123', '123', '1677588117', 11, 'Tier 0');

-- --------------------------------------------------------

--
-- Table structure for table `tushantMarketing_sales_person_payroll`
--

CREATE TABLE `tushantMarketing_sales_person_payroll` (
  `id` varchar(256) NOT NULL,
  `payRollId` varchar(256) DEFAULT '',
  `salesPersonId` varchar(256) DEFAULT '',
  `month` varchar(256) DEFAULT '',
  `sales` varchar(256) DEFAULT '',
  `commission` varchar(256) DEFAULT '',
  `totalAmount` varchar(256) DEFAULT '',
  `whyBonus` varchar(256) DEFAULT '',
  `bonus` varchar(256) DEFAULT '',
  `timeAdded` varchar(256) DEFAULT '',
  `forMonth` varchar(256) DEFAULT '',
  `paymentStatus` varchar(256) DEFAULT 'Not Paid'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tushantMarketing_sales_person_payroll`
--

INSERT INTO `tushantMarketing_sales_person_payroll` (`id`, `payRollId`, `salesPersonId`, `month`, `sales`, `commission`, `totalAmount`, `whyBonus`, `bonus`, `timeAdded`, `forMonth`, `paymentStatus`) VALUES
('B0AB5ILUUB', 'HVR2LT3PY6', 'NHPPJYF28B', 'March', '0', '2', '0', 'No Bonus', '0', '1682601299', '1679875200', 'Paid'),
('BDLEYGW6HH', 'HVR2LT3PY6', 'BQGD383NV1', 'March', '0', '2', '0', 'No Bonus', '0', '1682601299', '1679875200', 'Not Paid'),
('D6E1CNOQVK', 'HVR2LT3PY6', '5FF3WKD8VX', 'March', '0', '2', '0', 'No Bonus', '0', '1682601299', '1679875200', 'Not Paid'),
('ECU04TFYFH', 'HVR2LT3PY6', 'Z0ZHMB01VO', 'March', '0', '2', '0', 'No Bonus', '0', '1682601299', '1679875200', 'Paid'),
('GBJFC4K32O', 'HVR2LT3PY6', 'IKRECCKX7B', 'March', '0', '2', '0', 'No Bonus', '0', '1682601299', '1679875200', 'Not Paid'),
('GFISWV4WLP', 'HVR2LT3PY6', 'AI3F2KV8A0', 'March', '0', '2', '0', 'No Bonus', '0', '1682601299', '1679875200', 'Not Paid'),
('IWR1LFLQ4Z', 'HVR2LT3PY6', 'USLAOCO9PT', 'March', '0', '2', '0', 'No Bonus', '0', '1682601299', '1679875200', 'Not Paid'),
('SJIS6CA9BI', 'HVR2LT3PY6', 'JFCB89NGWN', 'March', '0', '2', '0', 'No Bonus', '0', '1682601299', '1679875200', 'Not Paid'),
('VL0ANIKN70', 'HVR2LT3PY6', 'BLEK1C3LCW', 'March', '0', '2', '0', 'No Bonus', '0', '1682601299', '1679875200', 'Not Paid');

-- --------------------------------------------------------

--
-- Table structure for table `tushantMarketing_verification_codes`
--

CREATE TABLE `tushantMarketing_verification_codes` (
  `id` varchar(256) NOT NULL,
  `clientId` varchar(256) DEFAULT '',
  `code` varchar(256) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tushantMarketing_verification_codes`
--

INSERT INTO `tushantMarketing_verification_codes` (`id`, `clientId`, `code`) VALUES
('SWTS7M4E0L', 'IQAF45FRXG', 'Y23ESPK4Q6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tushantMarketing_admins`
--
ALTER TABLE `tushantMarketing_admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tushantMarketing_affiliates`
--
ALTER TABLE `tushantMarketing_affiliates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tushantMarketing_bonus`
--
ALTER TABLE `tushantMarketing_bonus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tushantMarketing_clients`
--
ALTER TABLE `tushantMarketing_clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `autoIncrement` (`autoIncrement`);

--
-- Indexes for table `tushantMarketing_email_template`
--
ALTER TABLE `tushantMarketing_email_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tushantMarketing_payrolls`
--
ALTER TABLE `tushantMarketing_payrolls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tushantMarketing_salesPerson`
--
ALTER TABLE `tushantMarketing_salesPerson`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codeId` (`codeId`),
  ADD KEY `autoIncrement` (`autoIncrement`);

--
-- Indexes for table `tushantMarketing_sales_person_payroll`
--
ALTER TABLE `tushantMarketing_sales_person_payroll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tushantMarketing_verification_codes`
--
ALTER TABLE `tushantMarketing_verification_codes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tushantMarketing_clients`
--
ALTER TABLE `tushantMarketing_clients`
  MODIFY `autoIncrement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `tushantMarketing_salesPerson`
--
ALTER TABLE `tushantMarketing_salesPerson`
  MODIFY `autoIncrement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
