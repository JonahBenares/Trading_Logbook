-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2018 at 07:13 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_trading`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE IF NOT EXISTS `activity_log` (
`log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `encoded_date` varchar(20) DEFAULT NULL,
  `logged_date` varchar(20) DEFAULT NULL,
  `logged_time` varchar(20) DEFAULT NULL,
  `notes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login_logs`
--

CREATE TABLE IF NOT EXISTS `login_logs` (
`login_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `login_date` varchar(20) DEFAULT NULL,
  `login_time` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_logs`
--

INSERT INTO `login_logs` (`login_id`, `user_id`, `login_date`, `login_time`) VALUES
(1, 1, '2018-04-07', '09:21:57'),
(2, 1, '2018-04-07', '09:32:52'),
(3, 1, '2018-04-07', '09:35:04'),
(4, 1, '2018-04-07', '09:40:49'),
(5, 1, '2018-04-07', '09:41:28'),
(6, 1, '2018-04-07', '09:41:42'),
(7, 1, '2018-04-07', '09:45:52'),
(8, 1, '2018-04-07', '09:52:03'),
(9, 1, '2018-04-07', '09:57:53'),
(10, 1, '2018-04-07', '09:59:51'),
(11, 1, '2018-04-10', '08:33:16'),
(12, 1, '2018-04-10', '08:37:22'),
(13, 2, '2018-04-10', '09:16:35'),
(14, 1, '2018-04-10', '09:18:11'),
(15, 1, '2018-04-10', '09:57:32'),
(16, 1, '2018-04-10', '10:48:09');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_logs`
--

CREATE TABLE IF NOT EXISTS `schedule_logs` (
`sched_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sched_date` varchar(20) DEFAULT NULL,
  `start_hr` varchar(20) DEFAULT NULL,
  `end_hr` varchar(20) DEFAULT NULL,
  `date_plotted` varchar(20) DEFAULT NULL,
  `remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `upload_logs`
--

CREATE TABLE IF NOT EXISTS `upload_logs` (
`upload_id` int(11) NOT NULL,
  `log_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_remarks` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`user_id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `usertype_id` int(11) NOT NULL,
  `status` varchar(100) DEFAULT NULL,
  `initial` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `fullname`, `usertype_id`, `status`, `initial`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 1, 'Active', 0),
(2, 'staff', 'staff', 'staff', 2, 'Inactive', 0),
(11, 'ad', 'admin', 'admin', 2, 'Inactive', 1),
(12, '123', '123', 'admin', 2, 'Inactive', 0),
(13, 'asdasd', 'sadasd', 'asasd', 2, 'Active', 1),
(15, 'asdasdsada', 'asdasd', 'asdas', 1, 'Active', 1),
(16, 'aw', '1234', 'admin', 1, 'Active', 1);

-- --------------------------------------------------------

--
-- Table structure for table `usertype`
--

CREATE TABLE IF NOT EXISTS `usertype` (
`usertype_id` int(11) NOT NULL,
  `usertype_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usertype`
--

INSERT INTO `usertype` (`usertype_id`, `usertype_name`) VALUES
(1, 'Admin'),
(2, 'Staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
 ADD PRIMARY KEY (`log_id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `login_logs`
--
ALTER TABLE `login_logs`
 ADD PRIMARY KEY (`login_id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `schedule_logs`
--
ALTER TABLE `schedule_logs`
 ADD PRIMARY KEY (`sched_id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `upload_logs`
--
ALTER TABLE `upload_logs`
 ADD PRIMARY KEY (`upload_id`), ADD KEY `log_id` (`log_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`), ADD KEY `usertype_id` (`usertype_id`);

--
-- Indexes for table `usertype`
--
ALTER TABLE `usertype`
 ADD PRIMARY KEY (`usertype_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `login_logs`
--
ALTER TABLE `login_logs`
MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `schedule_logs`
--
ALTER TABLE `schedule_logs`
MODIFY `sched_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `upload_logs`
--
ALTER TABLE `upload_logs`
MODIFY `upload_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `usertype`
--
ALTER TABLE `usertype`
MODIFY `usertype_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
