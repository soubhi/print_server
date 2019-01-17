-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 10, 2019 at 05:31 PM
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

CREATE TABLE `queue1` (
  `Job_ID` int(11) NOT NULL,
  `User_name` varchar(255) DEFAULT NULL,
  `File_Name` varchar(255) DEFAULT NULL,
  `File_Path` varchar(255) DEFAULT NULL,
  `Pages` int(11) DEFAULT NULL,
  `Status` varchar(255) DEFAULT 'not-printed',
  `Uploaded_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Printed_Time` datetime DEFAULT NULL,
  `User_stream` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `queue`
--

INSERT INTO `queue1` (`Job_ID`, `User_name`, `File_Name`, `File_Path`, `Pages`, `Status`, `Uploaded_Time`, `Printed_Time`, `User_stream`) VALUES
(66, 'mc16me10', 'pdf-sample.pdf', '/home/printmaster/uploads/pdf-sample.pdf', 0, 'printed', '2018-06-30 04:05:45', NULL, 'mcme'),
(67, 'mc16me10', 'pdf-sample.pdf', '/home/printmaster/uploads/mc16me10-pdf-sample.pdf', 1, 'printed', '2018-06-30 04:06:57', NULL, ''),
(68, 'mc16me10', 'pdf.pdf', '/home/printmaster/uploads/mc16me10-pdf.pdf', 5, 'printed', '2018-06-30 14:14:55', NULL, ''),
(69, 'mc16me10', 'mozilla.pdf', '/home/printmaster/uploads/mc16me10-mozilla.pdf', 2, 'printed', '2018-06-30 14:17:27', NULL, 'mcme'),
(70, 'mc16me10', 'pdf.pdf', '/home/printmaster/uploads/mc16me10-pdf.pdf', 5, 'printed', '2018-06-30 14:17:44', NULL, ''),
(71, 'mc16me10', 'pdf-sample.pdf', '/home/printmaster/uploads/mc16me10-pdf-sample.pdf', 1, 'printed', '2018-07-01 06:27:10', NULL, ''),
(72, 'mc16me10', 'pdf-sample.pdf', '/home/printmaster/uploads/mc16me10-pdf-sample.pdf', 1, 'printed', '2018-07-01 06:27:18', NULL, 'faculty'),
(73, 'mc16me10', 'pdf-sample.pdf', '/home/printmaster/uploads/mc16me10-pdf-sample.pdf', 1, 'printed', '2018-11-01 06:33:53', NULL, ''),
(74, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/mc16me10-sample.pdf', 2, 'printed', '2018-10-01 06:34:00', NULL, ''),
(75, 'mc16me10', 'mozilla.pdf', '/home/printmaster/uploads/mc16me10-mozilla.pdf', 2, 'printed', '2018-09-01 06:34:12', NULL, ''),
(76, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/mc16me10-sample.pdf', 2, 'printed', '2018-08-01 06:34:39', NULL, ''),
(77, 'mc16me10', 'mozilla.pdf', '/home/printmaster/uploads/mc16me10-mozilla.pdf', 2, 'printed', '2018-07-01 06:34:53', NULL, ''),
(78, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/mc16me10-sample.pdf', 2, 'printed', '2018-07-01 06:41:07', NULL, ''),
(79, 'mc16me10', 'pdf.pdf', '/home/printmaster/uploads/mc16me10-pdf.pdf', 5, 'printed', '2018-07-01 06:41:15', NULL, 'mcme'),
(80, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/mc16me10-sample.pdf', 2, 'printed', '2018-06-01 06:41:23', NULL, 'mcme'),
(81, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/mc16me10-sample.pdf', 2, 'printed', '2018-07-01 06:44:18', NULL, ''),
(82, 'mc16me10', 'pdf.pdf', '/home/printmaster/uploads/mc16me10-pdf.pdf', 5, 'printed', '2018-07-01 06:44:25', NULL, ''),
(83, 'mc16me10', 'pdf-sample.pdf', '/home/printmaster/uploads/mc16me10-pdf-sample.pdf', 1, 'printed', '2018-07-01 06:44:31', NULL, ''),
(84, 'mc16me10', 'mozilla.pdf', '/home/printmaster/uploads/mc16me10-mozilla.pdf', 2, 'printed', '2018-07-01 06:44:39', NULL, ''),
(85, 'mc16me14', 'pdf.pdf', '/home/printmaster/uploads/mc16me14-pdf.pdf', 5, 'cancelled', '2018-05-03 05:10:29', NULL, 'mcme'),
(86, 'mc16me14', 'mozilla.pdf', '/home/printmaster/uploads/mc16me14-mozilla.pdf', 2, 'printed', '2018-07-03 05:10:39', NULL, ''),
(87, 'mc16me14', 'presentation topics.pdf', '/home/printmaster/uploads/mc16me14-presentation topics.pdf', 0, 'printed', '2018-07-03 05:10:55', NULL, ''),
(88, 'mc16me14', 'mozilla.pdf', '/home/printmaster/uploads/mc16me14-mozilla.pdf', 2, 'printed', '2018-02-03 05:11:10', NULL, ''),
(89, 'mc16me14', 'sample.pdf', '/home/printmaster/uploads/mc16me14-sample.pdf', 2, 'printed', '2018-07-03 05:15:40', NULL, ''),
(90, 'mc16me10', 'command_helper.txt', '/home/printmaster/uploads/mc16me10-command_helper.txt', 0, 'printed', '2018-04-03 05:21:05', NULL, ''),
(91, 'mc16me10', 'command_helper.txt', '/home/printmaster/uploads/mc16me10-command_helper.txt', 0, 'printed', '2018-07-03 05:35:23', NULL, ''),
(92, 'mc16me10', 'mozilla.pdf', '/home/printmaster/uploads/92-mozilla.pdf', 2, 'printed', '2018-07-03 05:42:48', NULL, ''),
(93, 'mc16me10', 'mozilla.pdf', '/home/printmaster/uploads/93-mozilla.pdf', 0, 'printed', '2018-07-03 05:43:15', NULL, ''),
(94, 'mc16me10', 'pdf-sample.pdf', '/home/printmaster/uploads/94-pdf-sample.pdf', 1, 'cancelled', '2018-07-03 05:43:56', NULL, ''),
(95, 'mc16me10', 'command_helper.txt', '/home/printmaster/uploads/95-command_helper.txt', 0, 'printed', '2018-07-03 05:46:16', NULL, ''),
(96, 'mc16me10', 'command_helper.txt', '/home/printmaster/uploads/96-command_helper.txt', 0, 'printed', '2018-07-03 05:57:30', NULL, ''),
(97, 'mc16me10', 'command_helper.txt', '/home/printmaster/uploads/', 0, 'printed', '2018-07-03 06:00:38', NULL, ''),
(98, 'mc16me10', 'command_helper.txt', '/home/printmaster/uploads/98-command_helper.txt', 0, 'printed', '2018-07-03 06:04:21', NULL, ''),
(99, 'mc16me10', 'command_helper.txt', '/home/printmaster/uploads/99-command_helper.txt', 0, 'printed', '2018-07-03 06:05:34', NULL, ''),
(100, 'mc16me10', 'command_helper.txt', '/home/printmaster/uploads/100-command_helper.txt', 0, 'printed', '2018-07-03 06:07:27', NULL, ''),
(101, 'mc16me10', 'command_helper.txt', '/home/printmaster/uploads/101-command_helper.txt', 0, 'printed', '2018-07-03 06:16:23', NULL, ''),
(102, 'mc16me10', 'command_helper.txt', '/home/printmaster/uploads/102-command_helper.txt', 0, 'printed', '2018-07-03 06:17:32', NULL, ''),
(103, 'mc16me10', 'command_helper.txt', '/home/printmaster/uploads/103-command_helper.txt', 0, 'printed', '2018-07-03 06:18:15', NULL, ''),
(104, 'mc16me10', 'sample.pdf', '../uploads/104-sample.pdf', 0, 'printed', '2018-07-03 06:37:28', NULL, ''),
(105, 'mc16me10', 'pdf-sample.pdf', '../uploads/105-pdf-sample.pdf', 0, 'cancelled', '2018-07-03 06:38:52', NULL, ''),
(106, 'mc16me10', 'sample.pdf', '../uploads/106-sample.pdf', 0, 'cancelled', '2018-07-03 06:39:42', NULL, ''),
(108, 'mc16me10', 'pdf.pdf', '/home/printmaster/uploads/108-pdf.pdf', 5, 'printed', '2018-07-03 06:44:14', NULL, ''),
(109, 'mc16me10', 'pdf-sample.pdf', '/home/printmaster/uploads/109-pdf-sample.pdf', 1, 'printed', '2018-07-09 05:26:56', NULL, ''),
(110, 'mc16me10', 'pdf-sample.pdf', '/home/printmaster/uploads/110-pdf-sample.pdf', 0, 'printed', '2018-07-09 05:27:03', NULL, ''),
(111, 'mc16me10', 'pdf-sample.pdf', '/home/printmaster/uploads/111-pdf-sample.pdf', 0, 'printed', '2018-07-09 05:27:36', NULL, ''),
(112, 'mc16me10', 'command_helper.txt', '/home/printmaster/uploads/112-command_helper.txt', 0, 'printed', '2018-07-09 07:36:24', NULL, ''),
(113, 'mc16me10', 'command_helper.txt', '/home/printmaster/uploads/113-command_helper.txt', 0, 'printed', '2018-07-09 07:37:11', NULL, ''),
(114, 'mc16me10', 'pdf.pdf', '/home/printmaster/uploads/114-pdf.pdf', 5, 'printed', '2018-07-09 07:37:19', NULL, ''),
(115, 'mc16me10', 'command_helper.txt', '/home/printmaster/uploads/113-command_helper.txt', 0, 'printed', '2018-07-09 07:37:11', NULL, ''),
(116, 'mc16me10', 'command_helper.txt', '/home/printmaster/uploads/95-command_helper.txt', 0, 'printed', '2018-07-03 05:46:16', NULL, ''),
(228, 'mc16me10', 'Screenshot from 2018-02-23 14-41-23.png', '/home/printmaster/uploads/228-Screenshot from 2018-02-23 14-41-23.pdf', 1, 'not-printed', '2018-07-18 05:09:32', NULL, ''),
(229, 'mc16me10', 'Screenshot from 2017-11-16 17-28-36.png', '/home/printmaster/uploads/229-Screenshot from 2017-11-16 17-28-36.pdf', 1, 'not-printed', '2018-07-18 05:11:11', NULL, ''),
(231, 'mc16me10', 'command_helper.txt', '/home/printmaster/uploads/231-command_helper.pdf', 1, 'not-printed', '2018-07-18 05:13:37', NULL, ''),
(232, 'mc16me10', 'pdf.pdf', '/home/printmaster/uploads/232-pdf.pdf', 5, 'not-printed', '2018-07-23 04:56:16', NULL, ''),
(233, 'mc16me04', 'Sheet1.html', '', 0, 'not-printed', '2018-07-30 14:27:38', NULL, ''),
(234, 'mc16me10', 'round_icon.png', '/home/printmaster/uploads/234-round_icon.pdf', 1, 'not-printed', '2018-10-28 11:13:51', NULL, ''),
(235, 'mc16me10', 'home.png', '/home/printmaster/uploads/235-home.pdf', 1, 'not-printed', '2018-12-01 06:34:20', NULL, ''),
(236, 'mc16me10', 'imtech.html', '/home/printmaster/uploads/236-imtech.pdf', 2, 'not-printed', '2018-12-01 06:34:46', NULL, ''),
(237, 'mc16me10', 'home.png', '/home/printmaster/uploads/237-home.pdf', 1, 'not-printed', '2018-12-01 06:54:23', NULL, ''),
(238, 'mc16me10', 'dskjjdlksfjlkjdsoiejrjeoo3j4lkj954tu9p4jfl4k5mgk.4t4..txt', '/home/printmaster/uploads/238-dskjjdlksfjlkjdsoiejrjeoo3j4lkj954tu9p4jfl4k5mgk.4t4..pdf', 1, 'cancelled', '2018-12-03 11:00:40', NULL, ''),
(239, 'mc16me14', 'style.css', '/home/printmaster/uploads/239-style.pdf', 13, 'not-printed', '2018-12-06 04:32:21', NULL, ''),
(240, 'mc16me10', 'pdf-sample.pdf', '/home/printmaster/uploads/240-pdf-sample.pdf', 1, 'cancelled', '2018-12-09 12:28:15', NULL, ''),
(242, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/242-sample.pdf', 2, 'not-printed', '2018-12-09 14:10:35', NULL, ''),
(243, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/243-sample.pdf', 2, 'not-printed', '2018-12-09 14:12:23', NULL, ''),
(244, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/244-sample.pdf', 2, 'not-printed', '2018-12-11 10:22:42', NULL, ''),
(245, 'mc16me10', 'pdf.pdf', '/home/printmaster/uploads/245-pdf.pdf', 5, 'not-printed', '2018-12-18 08:42:29', NULL, ''),
(246, 'mc16me10', 'pdf.pdf', '/home/printmaster/uploads/246-pdf.pdf', 5, 'not-printed', '2018-12-18 08:42:34', NULL, ''),
(247, 'mc16me10', 'req.dat', '/home/printmaster/uploads/247-req.pdf', 1, 'not-printed', '2018-12-18 08:42:37', NULL, ''),
(248, 'mc16me10', 'req.dat', '/home/printmaster/uploads/248-req.pdf', 1, 'not-printed', '2018-12-18 08:43:06', NULL, 'mcme'),
(249, 'mc16me10', 'req.dat', '/home/printmaster/uploads/249-req.pdf', 1, 'not-printed', '2018-12-18 08:43:49', NULL, ''),
(250, 'mc16me10', 'pdf.pdf', '/home/printmaster/uploads/250-pdf.pdf', 5, 'not-printed', '2018-12-18 18:56:27', NULL, ''),
(251, 'mc16me10', 'pdf.pdf', '/home/printmaster/uploads/251-pdf.pdf', 5, 'not-printed', '2018-12-18 19:02:18', NULL, ''),
(252, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/252-sample.pdf', 2, 'not-printed', '2018-12-18 19:03:07', NULL, ''),
(253, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/253-sample.pdf', 2, 'not-printed', '2018-12-18 19:03:25', NULL, ''),
(254, 'mc16me10', 'pdf-sample.pdf', '/home/printmaster/uploads/254-pdf-sample.pdf', 1, 'not-printed', '2018-12-18 19:04:46', NULL, ''),
(255, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/255-sample.pdf', 2, 'not-printed', '2018-12-18 19:15:07', NULL, ''),
(256, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/256-sample.pdf', 2, 'not-printed', '2018-12-18 19:32:19', NULL, 'Integrated M.Tech'),
(257, 'mc16me10', 'mozilla.pdf', '/home/printmaster/uploads/257-mozilla.pdf', 2, 'not-printed', '2018-12-18 19:32:38', NULL, 'faculty'),
(258, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/258-sample.pdf', 2, 'not-printed', '2018-12-19 01:48:56', NULL, 'mcmc'),
(259, 'mc16me10', 'pdf-sample.pdf', '/home/printmaster/uploads/259-pdf-sample.pdf', 1, 'not-printed', '2018-12-19 01:50:20', NULL, 'Integrated M.Tech'),
(260, 'mc16me10', 'pdf-sample.pdf', '/home/printmaster/uploads/260-pdf-sample.pdf', 1, 'not-printed', '2018-12-19 01:55:01', NULL, 'mcmt'),
(261, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/261-sample.pdf', 2, 'not-printed', '2018-12-19 01:55:52', NULL, 'faculty'),
(262, 'mc16me10', 'pdf-sample.pdf', '/home/printmaster/uploads/262-pdf-sample.pdf', 1, 'not-printed', '2018-12-19 01:57:39', NULL, ''),
(263, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/263-sample.pdf', 2, 'not-printed', '2018-12-19 01:59:22', NULL, ''),
(264, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/264-sample.pdf', 2, 'not-printed', '2018-12-19 02:00:06', NULL, ''),
(265, 'mc16me10', 'pdf-sample.pdf', '/home/printmaster/uploads/265-pdf-sample.pdf', 1, 'not-printed', '2018-12-19 02:01:01', NULL, ''),
(266, 'mc16me10', 'pdf-sample.pdf', '/home/printmaster/uploads/266-pdf-sample.pdf', 1, 'not-printed', '2017-12-19 02:02:40', NULL, ''),
(267, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/267-sample.pdf', 2, 'not-printed', '2018-12-19 02:44:14', NULL, ''),
(268, 'mc16me10', 'pdf-sample.pdf', '/home/printmaster/uploads/268-pdf-sample.pdf', 1, 'not-printed', '2017-12-19 02:54:02', NULL, ''),
(269, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/269-sample.pdf', 2, 'not-printed', '2017-12-19 02:58:21', NULL, ''),
(270, 'mc16me10', 'pdf-sample.pdf', '/home/printmaster/uploads/270-pdf-sample.pdf', 1, 'not-printed', '2018-02-19 03:42:01', NULL, ''),
(271, 'mc16me10', 'pdf-sample.pdf', '/home/printmaster/uploads/271-pdf-sample.pdf', 1, 'not-printed', '2018-12-19 03:55:07', NULL, ''),
(272, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/272-sample.pdf', 2, 'not-printed', '2018-12-19 03:56:01', NULL, ''),
(273, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/273-sample.pdf', 2, 'not-printed', '2018-12-19 04:03:42', NULL, ''),
(274, 'mc16me10', 'pdf-sample.pdf', '/home/printmaster/uploads/274-pdf-sample.pdf', 1, 'not-printed', '2018-12-19 04:21:22', NULL, ''),
(275, 'mc16me10', 'pdf.pdf', '/home/printmaster/uploads/275-pdf.pdf', 5, 'not-printed', '2017-12-12 06:03:41', NULL, ''),
(276, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/276-sample.pdf', 2, 'not-printed', '2018-12-19 06:03:54', NULL, ''),
(277, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/277-sample.pdf', 2, 'not-printed', '2018-12-19 06:08:00', NULL, ''),
(278, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/278-sample.pdf', 2, 'not-printed', '2018-12-19 06:32:48', NULL, ''),
(279, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/279-sample.pdf', 2, 'not-printed', '2018-12-19 06:33:34', NULL, 'mcme'),
(280, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/280-sample.pdf', 2, 'printed', '2018-12-19 06:34:04', '2018-12-19 13:40:50', 'mcmt'),
(281, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/281-sample.pdf', 2, 'not-printed', '2018-01-19 10:32:45', NULL, 'mcmc'),
(282, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/282-sample.pdf', 2, 'not-printed', '2018-01-19 10:37:50', NULL, 'mcme'),
(283, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/283-sample.pdf', 2, 'not-printed', '2018-01-19 11:27:56', NULL, 'mcme'),
(284, 'mc16me09', 'AcadCal18.pdf', '/home/printmaster/uploads/284-AcadCal18.pdf', 6, 'not-printed', '2018-12-19 11:29:14', NULL, ''),
(285, 'mc16me14', 'sample.pdf', '/home/printmaster/uploads/285-sample.pdf', 2, 'not-printed', '2018-12-20 02:30:35', NULL, ''),
(286, 'mc16me10', 'pdf-sample.pdf', '/home/printmaster/uploads/286-pdf-sample.pdf', 1, 'not-printed', '2018-12-30 17:21:11', NULL, 'faculty'),
(287, 'mc16me10', 'Lecture17.pdf', '/home/printmaster/uploads/287-Lecture17.pdf', 30, 'not-printed', '2017-12-30 17:22:39', NULL, 'Integrated M.Tech'),
(288, 'mc16mc10', 'sample.pdf', '/home/printmaster/uploads/288-sample.pdf', 2, 'not-printed', '2017-12-30 17:28:42', NULL, 'MCA'),
(289, 'mc16me10', 'history.txt', '/home/printmaster/uploads/289-history.pdf', 14, 'not-printed', '2019-01-08 17:58:09', NULL, 'mcme'),
(290, 'mc16me10', 'sample.pdf', '/home/printmaster/uploads/290-sample.pdf', 2, 'not-printed', '2019-01-08 17:58:20', NULL, 'mcme'),
(291, 'mc16mc14', 'pdf-sample.pdf', '/home/printmaster/uploads/291-pdf-sample.pdf', 1, 'not-printed', '2019-01-10 10:51:25', NULL, ''),
(292, 'mc16mc14', 'sample.pdf', '/home/printmaster/uploads/292-sample.pdf', 2, 'not-printed', '2019-01-10 10:53:14', NULL, 'mcmc');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `queue`
--
ALTER TABLE `queue1`
  ADD PRIMARY KEY (`Job_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue1`
  MODIFY `Job_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=293;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
