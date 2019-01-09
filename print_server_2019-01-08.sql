-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 08, 2019 at 05:26 PM
-- Server version: 5.7.24-0ubuntu0.16.04.1
-- PHP Version: 7.0.32-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `print_server`
--

-- --------------------------------------------------------

--
-- Table structure for table `queue`
--

CREATE TABLE `queue` (
  `Job_ID` int(11) NOT NULL,
  `User_name` varchar(255) DEFAULT NULL,
  `File_Name` varchar(255) DEFAULT NULL,
  `File_Path` varchar(255) DEFAULT NULL,
  `Pages` int(11) DEFAULT NULL,
  `page_range` varchar(255) DEFAULT NULL,
  `Status` varchar(255) DEFAULT 'not-printed',
  `Uploaded_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Printed_Time` varchar(255) DEFAULT NULL,
  `Print_Time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `queue`
--

INSERT INTO `queue` (`Job_ID`, `User_name`, `File_Name`, `File_Path`, `Pages`, `page_range`, `Status`, `Uploaded_Time`, `Printed_Time`, `Print_Time`) VALUES
(66, 'mc16me10', 'pdf-sample.pdf', '/home/printmaster/uploads/pdf-sample.pdf', 0, '', 'printed', '2018-06-30 04:05:45', '01-12-2018 12:03:25pm', NULL),
(67, 'mc16me10', 'pdf-sample.pdf', '/home/printmaster/uploads/mc16me10-pdf-sample.pdf', 1, '', 'printed', '2018-06-30 04:06:57', '01-12-2018 12:03:25pm', NULL),
(75, 'mc16me09', 'a1986-hopcroft.pdf', '/home/printmaster/uploads/75-a1986-hopcroft.pdf', 5, '1', 'cancelled', '2018-07-09 15:13:37', '-', NULL),
(76, 'mc16me09', 'a1986-hopcroft.pdf', '/home/printmaster/uploads/76-a1986-hopcroft.pdf', 5, '1', 'printed', '2018-07-09 15:17:42', '10-12-2018 07:57:47pm', '2018-12-10 14:27:47'),
(77, 'mc16me09', 'a1974-knuth.pdf', '/home/printmaster/uploads/77-a1974-knuth.pdf', 7, '1', 'cancelled', '2018-07-09 15:18:15', NULL, NULL),
(78, 'mc16me09', 'mes_passwd.txt', '/home/printmaster/uploads/78-mes_passwd.txt', 0, '1', 'cancelled', '2018-07-09 15:33:13', '-', NULL),
(79, 'mc16me09', 'RARBG.txt', '/home/printmaster/uploads/79-RARBG.txt', 0, '1', 'cancelled', '2018-07-09 15:36:59', '-', NULL),
(80, 'mc16me09', 'mes_passwd.txt', '/home/printmaster/uploads/80-mes_passwd.txt', 0, '1', 'cancelled', '2018-07-09 15:39:33', '-', NULL),
(81, 'mc16me09', 'a1986-hopcroft.pdf', '/home/printmaster/uploads/81-a1986-hopcroft.pdf', 5, '1', 'cancelled', '2018-07-09 15:39:50', NULL, NULL),
(82, 'mc16me09', 'a1974-knuth.pdf', '/home/printmaster/uploads/82-a1974-knuth.pdf', 7, '1', 'printed', '2018-07-09 15:52:31', NULL, '2018-12-19 10:34:03'),
(86, 'mc16me09', 'mes-password.txt', '/home/printmaster/uploads/86-mes-password.txt', 0, '1', 'cancelled', '2018-07-11 07:05:22', '-', NULL),
(107, 'mc16me09', 'IMT5_2018.pdf', '/home/printmaster/uploads/107-IMT5_2018.pdf', 1, '1', 'printed', '2018-07-11 07:23:56', '06-12-2018 02:16:14pm', NULL),
(111, 'mc16me09', 'mes-password.txt', '/home/printmaster/uploads/111-mes-password.txt', 0, '1', 'cancelled', '2018-07-11 07:27:34', '-', NULL),
(113, 'mc16me09', 'scootyInsurance2018_0502523118P106832391.pdf', '/home/printmaster/uploads/113-scootyInsurance2018_0502523118P106832391.pdf', 2, '1', 'cancelled', '2018-12-01 05:16:05', NULL, NULL),
(114, 'mc16me10', 'Email Address Approval Form.pdf', '/home/printmaster/uploads/114-Email Address Approval Form.pdf', 0, '', 'cancelled', '2018-12-01 06:29:34', NULL, NULL),
(115, 'mc16me09', 'carInsurance2018_MOP4822579.pdf', '/home/printmaster/uploads/115-carInsurance2018_MOP4822579.pdf', 0, '1', 'cancelled', '2018-12-01 06:32:29', NULL, NULL),
(116, 'mc16me09', 'BSNL-Recipt-NOV18.pdf', '/home/printmaster/uploads/116-BSNL-Recipt-NOV18.pdf', 1, '1', 'printed', '2018-12-01 07:24:30', '06-12-2018 02:18:53pm', NULL),
(117, 'mc16me09', 'Email Address Approval Form.pdf', '/home/printmaster/uploads/117-Email Address Approval Form.pdf', 0, '1', 'cancelled', '2018-12-04 10:59:51', '-', NULL),
(118, 'mc16me09', 'BSNL-Recipt-NOV18.pdf', '/home/printmaster/uploads/118-BSNL-Recipt-NOV18.pdf', 1, '1', 'printed', '2018-12-04 11:09:01', '06-12-2018 02:49:24pm', NULL),
(119, 'mc16me09', 'BSNL-Recipt-NOV18.pdf', '', 0, '1', 'cancelled', '2018-12-06 08:58:32', '-', NULL),
(120, 'mc16me09', 'Semester_E-Receipt.pdf', '/home/printmaster/uploads/120-Semester_E-Receipt.pdf', 2, '1', 'printed', '2018-12-06 09:03:53', '06-12-2018 02:35:13pm', NULL),
(121, 'mc16me10', 'VoterSlip-Sai_Shashank_Bandela.pdf', '/home/printmaster/uploads/121-VoterSlip-Sai_Shashank_Bandela.pdf', 1, '', 'printed', '2018-12-06 09:25:12', '06-12-2018 02:56:00pm', NULL),
(122, 'mc16me10', 'SemRegForm.PDF', '/home/printmaster/uploads/122-SemRegForm.pdf', 1, '', 'printed', '2018-12-06 10:46:38', '06-12-2018 04:16:55pm', NULL),
(123, 'mc16me10', 'Mobile Number Approval Form.pdf', '/home/printmaster/uploads/123-Mobile Number Approval Form.pdf', 2, '', 'printed', '2018-12-06 10:48:16', '06-12-2018 04:18:43pm', NULL),
(124, 'mc16me10', 'BSNL-Recipt-NOV18.pdf', '/home/printmaster/uploads/124-BSNL-Recipt-NOV18.pdf', 1, '', 'cancelled', '2018-12-06 10:59:54', NULL, NULL),
(125, 'mc16me10', 'Countries and HDI.html', '/home/printmaster/uploads/125-Countries and HDI.pdf', 4, '', 'cancelled', '2018-12-06 11:01:17', NULL, NULL),
(126, 'mc16me09', 'BSNL-Recipt-NOV18.pdf', '/home/printmaster/uploads/126-BSNL-Recipt-NOV18.pdf', 1, '1', 'cancelled', '2018-12-10 06:09:30', NULL, NULL),
(127, 'mc16me09', 'carInsurance2018_MOP4822579.pdf', '/home/printmaster/uploads/127-carInsurance2018_MOP4822579.pdf', 0, '1', 'printed', '2018-12-10 06:20:37', NULL, '2018-12-10 17:10:39'),
(128, 'mc16me09', 'carInsurance2018_MOP4822579.pdf', '/home/printmaster/uploads/128-carInsurance2018_MOP4822579.pdf', 0, '1', 'printed', '2018-12-10 06:29:46', NULL, '2018-12-10 16:42:06'),
(129, 'mc16me09', 'BSNL-Recipt-NOV18.pdf', '/home/printmaster/uploads/129-BSNL-Recipt-NOV18.pdf', 1, '1', 'printed', '2018-12-10 06:32:04', '10-12-2018 07:57:47pm', '2018-12-10 14:27:48'),
(130, 'mc16me09', 'BSNL-Recipt-NOV18.pdf', '/home/printmaster/uploads/130-BSNL-Recipt-NOV18.pdf', 1, '1', 'cancelled', '2018-12-11 01:16:52', NULL, NULL),
(131, 'mc16me09', 'VoterSlip-Sai_Shashank_Bandela.pdf', '/home/printmaster/uploads/131-VoterSlip-Sai_Shashank_Bandela.pdf', 1, '1', 'printed', '2018-12-11 01:25:37', NULL, '2019-01-04 10:34:38'),
(132, 'mc16me09', 'VoterSlip-Sai_Shashank_Bandela.pdf', '/home/printmaster/uploads/132-VoterSlip-Sai_Shashank_Bandela.pdf', 1, '1', 'printed', '2018-12-11 01:27:08', NULL, '2019-01-04 10:34:34'),
(133, 'mc16me09', 'Semester_E-Receipt_Portrait.PDF', '/home/printmaster/uploads/133-Semester_E-Receipt_Portrait.pdf', 1, '1', 'printed', '2018-12-11 04:40:57', NULL, '2018-12-17 02:39:39'),
(136, '', 'twoPages.pdf', '/home/printmaster/uploads/136-twoPages.pdf', 2, '', 'not-printed', '2018-12-17 04:17:06', NULL, NULL),
(137, 'mc16me09', 'twoPages.pdf', '/home/printmaster/uploads/137-twoPages.pdf', 2, '1-2', 'printed', '2018-12-17 04:17:19', NULL, '2019-01-04 10:37:31'),
(138, 'mc16me09', 'twoPages.pdf', '/home/printmaster/uploads/138-twoPages.pdf', 2, '1', 'printed', '2018-12-17 04:21:33', NULL, '2019-01-04 09:53:53'),
(139, 'mc16me09', 'threePages.pdf', '/home/printmaster/uploads/139-threePages.pdf', 3, '1-2', 'printed', '2018-12-17 04:26:08', NULL, '2019-01-04 10:16:35'),
(140, 'mc16me09', 'onePage.odt', '/home/printmaster/uploads/140-onePage.pdf', 1, '1', 'printed', '2018-12-17 04:27:13', NULL, '2019-01-04 10:30:01'),
(141, 'mc16me09', 'onePage.odt', '/home/printmaster/uploads/141-onePage.pdf', 1, '1', 'printed', '2018-12-17 05:12:20', NULL, '2019-01-04 10:27:41'),
(142, 'mc16me09', 'onePage.odt', '/home/printmaster/uploads/142-onePage.pdf', 1, '1', 'printed', '2018-12-17 05:12:32', NULL, '2019-01-04 02:21:26'),
(143, 'mc16me09', 'onePage.odt', '/home/printmaster/uploads/143-onePage.pdf', 1, '1', 'printed', '2018-12-17 05:17:34', NULL, '2018-12-28 17:11:04'),
(144, 'mc16me09', 'twoPages.pdf', '/home/printmaster/uploads/144-twoPages.pdf', 2, '1', 'printed', '2018-12-17 06:12:14', NULL, '2018-12-28 17:10:58'),
(145, 'mc16me09', 'twoPages.pdf', '/home/printmaster/uploads/145-twoPages.pdf', 2, '1', 'printed', '2018-12-17 06:12:20', NULL, '2018-12-19 08:03:46'),
(146, 'mc16me09', 'threePages.pdf', '/home/printmaster/uploads/146-threePages.pdf', 3, '1', 'cancelled', '2018-12-17 06:28:24', NULL, NULL),
(147, 'mc16me09', 'threePages.pdf', '/home/printmaster/uploads/147-threePages.pdf', 3, '1', 'cancelled', '2018-12-17 06:29:02', NULL, NULL),
(148, 'mc16me09', 'threePages.pdf', '/home/printmaster/uploads/148-threePages.pdf', 3, '1', 'printed', '2018-12-17 06:30:18', NULL, '2018-12-19 08:03:39'),
(149, 'mc16me09', 'threePages.pdf', '/home/printmaster/uploads/149-threePages.pdf', 3, '1', 'printed', '2018-12-17 06:32:02', NULL, '2018-12-19 07:06:39'),
(150, 'mc16me09', 'threePages.pdf', '/home/printmaster/uploads/150-threePages.pdf', 3, '1', 'printed', '2018-12-17 07:07:52', NULL, '2018-12-19 07:06:32'),
(151, 'mc16me09', 'onePage.odt', '/home/printmaster/uploads/151-onePage.pdf', 1, '1', 'printed', '2018-12-17 08:46:25', NULL, '2018-12-19 07:10:53'),
(152, 'mc16me09', 'onePage.odt', '/home/printmaster/uploads/152-onePage.pdf', 1, '1', 'printed', '2018-12-17 08:47:24', NULL, '2018-12-19 06:03:36'),
(153, 'mc16me09', 'threePages.pdf', '/home/printmaster/uploads/153-threePages.pdf', 3, '1', 'cancelled', '2018-12-19 08:21:38', NULL, NULL),
(154, 'mc16me09', 'onePage.odt', '/home/printmaster/uploads/154-onePage.pdf', 1, '1', 'cancelled', '2018-12-19 08:23:18', NULL, NULL),
(155, 'mc16me09', 'onePage.odt', '/home/printmaster/uploads/155-onePage.pdf', 1, '1', 'printed', '2018-12-19 08:24:20', NULL, '2018-12-19 10:54:01'),
(156, 'mc16me09', 'onePage.odt', '/home/printmaster/uploads/156-onePage.pdf', 1, '1', 'printed', '2018-12-19 08:25:53', NULL, '2018-12-19 10:53:43'),
(157, 'mc16me09', 'twoPages.pdf', '/home/printmaster/uploads/157-twoPages.pdf', 2, '1', 'printed', '2018-12-19 08:26:01', NULL, '2018-12-19 10:52:19'),
(158, 'mc16me09', 'twoPages.pdf', '/home/printmaster/uploads/158-twoPages.pdf', 2, '1', 'printed', '2018-12-19 08:27:58', NULL, '2018-12-19 10:52:10'),
(159, 'mc16me09', 'onePage.odt', '/home/printmaster/uploads/159-onePage.pdf', 1, '1', 'printed', '2018-12-19 08:28:03', NULL, '2018-12-19 10:51:32'),
(160, 'mc16me09', 'final-notice-IntMtech.pdf', '/home/printmaster/uploads/160-final-notice-IntMtech.pdf', 2, '1', 'printed', '2018-12-19 08:28:37', NULL, '2018-12-19 10:25:03'),
(161, 'mc16me09', 'BSNL-Recipt-NOV18.pdf', '/home/printmaster/uploads/161-BSNL-Recipt-NOV18.pdf', 1, '1', 'printed', '2018-12-19 10:42:03', NULL, '2018-12-19 10:47:28'),
(162, 'mc16me09', 'BSNL-Recipt-NOV18.pdf', '/home/printmaster/uploads/162-BSNL-Recipt-NOV18.pdf', 1, '1', 'printed', '2018-12-20 13:37:51', NULL, '2018-12-28 17:01:24'),
(163, 'mc16me09', 'School-Time-Table_Landscape.pdf', '/home/printmaster/uploads/163-School-Time-Table_Landscape.pdf', 4, '1-2', 'printed', '2019-01-04 10:19:11', NULL, '2019-01-04 10:20:16'),
(164, 'mc16me09', 'School-Time-Table_Landscape.pdf', '/home/printmaster/uploads/164-School-Time-Table_Landscape.pdf', 4, '4', 'printed', '2019-01-04 10:27:25', NULL, '2019-01-04 10:34:42'),
(165, 'mc16me10', 'School-Time-Table_Landscape.pdf', '/home/printmaster/uploads/165-School-Time-Table_Landscape.pdf', 4, NULL, 'not-printed', '2019-01-04 10:43:53', NULL, NULL),
(166, 'mc16me10', 'SemRegForm.PDF', '/home/printmaster/uploads/166-SemRegForm.pdf', 1, '1', 'printed', '2019-01-04 10:44:09', NULL, '2019-01-04 10:57:35'),
(167, 'mc16me10', 'School-Time-Table.pdf', '/home/printmaster/uploads/167-School-Time-Table.pdf', 2, '1', 'printed', '2019-01-04 11:00:12', NULL, '2019-01-04 11:04:08'),
(168, 'mc16me09', 'School-Time-Table_Landscape.pdf', '/home/printmaster/uploads/168-School-Time-Table_Landscape.pdf', 4, NULL, 'not-printed', '2019-01-05 01:28:28', NULL, NULL),
(169, 'mc16me09', 'SemRegForm.PDF', '/home/printmaster/uploads/169-SemRegForm.pdf', 1, '1', 'printed', '2019-01-06 08:10:50', NULL, '2019-01-06 08:11:34'),
(170, 'mc16me09', 'imtech15revised2018.pdf', '/home/printmaster/uploads/170-imtech15revised2018.pdf', 2, '2', 'printed', '2019-01-06 08:25:41', NULL, '2019-01-06 08:26:00'),
(171, 'mc16me09', 'imtech15revised2018.pdf', '/home/printmaster/uploads/171-imtech15revised2018.pdf', 2, '1', 'printed', '2019-01-06 08:30:06', NULL, '2019-01-06 08:30:10'),
(172, 'mc16me09', 'School-Time-Table_Landscape.pdf', '/home/printmaster/uploads/172-School-Time-Table_Landscape.pdf', 4, NULL, 'not-printed', '2019-01-07 10:51:55', NULL, NULL),
(173, 'mc16me09', 'SemRegForm.PDF', '/home/printmaster/uploads/173-SemRegForm.pdf', 1, NULL, 'not-printed', '2019-01-07 11:15:24', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quota`
--

CREATE TABLE `quota` (
  `stream_code` varchar(255) NOT NULL,
  `stream_name` varchar(255) NOT NULL,
  `stream_quota` int(11) NOT NULL,
  `reg_exp` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quota`
--

INSERT INTO `quota` (`stream_code`, `stream_name`, `stream_quota`, `reg_exp`) VALUES
('faculty', 'Faculty', 25, '/(ravics|swaroopacs|yvsrcs|blehcs|vineetcs|akpcs|prbcs|udgatacs|apcs|rpl|agcs|aruncs|rukmarekha|samcs|atulcs|pngcs|sdbcs|mascs|alokcs|hmcs|blmcs|wankarcs|uday|naveenphd|bapics|saics|askcs|crrcs|dpcs|murli|tsrcs|manics|rathore|kvcs|chakcs|knmcs|nncs)/'),
('mcmc', 'MCA', 10, '/(mc..mc..|..mcmc..)/'),
('mcme', 'Integrated M.Tech', 10, '/(mc..me..|..mcme..)/'),
('mcmt', 'M.Tech ', 15, '/(mc..mt..|..mcmt..|..mcmi..|..mcmi..|..mcmb..|..mcmb..)/'),
('mcpc', 'Ph.D.', 10, '/(mc..pc..|..mcpc..)/');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `stream` varchar(255) NOT NULL,
  `quota` int(11) NOT NULL,
  `renewal_date` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `stream`, `quota`, `renewal_date`) VALUES
(9, 'shashank', '', 2, 1533061800),
(10, 'soubhagya', '', 10, 1533061800),
(23, 'mc16me02', 'Integrated M.Tech', 10, 1533061800),
(24, 'mc16me10', 'Integrated M.Tech', 4, 1548959400),
(25, 'mc16me14', 'Integrated M.Tech', 10, 1533061800),
(26, 'mc16me09', 'Integrated M.Tech', 5, 1548959400),
(32, 'mc16mt09', 'M.Tech ', 15, 1548959400),
(33, 'mc16me15', 'Integrated M.Tech', 10, 1548959400);

-- --------------------------------------------------------

--
-- Table structure for table `utility`
--

CREATE TABLE `utility` (
  `name` varchar(255) NOT NULL,
  `value` varchar(535) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `utility`
--

INSERT INTO `utility` (`name`, `value`) VALUES
('admin-password', 'admin@123'),
('printing', 'TRUE'),
('quota-renewal-time', '1month');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`Job_ID`);

--
-- Indexes for table `quota`
--
ALTER TABLE `quota`
  ADD PRIMARY KEY (`stream_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `utility`
--
ALTER TABLE `utility`
  ADD PRIMARY KEY (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue`
  MODIFY `Job_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
