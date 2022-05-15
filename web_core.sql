-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2022 at 12:13 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_core`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `activity_log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `date_log` datetime NOT NULL DEFAULT current_timestamp(),
  `action` text NOT NULL,
  `session_id` varchar(255) NOT NULL DEFAULT '',
  `user_level` varchar(100) NOT NULL DEFAULT '0',
  `system_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`activity_log_id`, `user_id`, `date_log`, `action`, `session_id`, `user_level`, `system_id`) VALUES
(1, 1, '2022-05-16 06:08:22', 'Reset Password Admin Account:SAMPLE_REGS - DETAILS : \r\n({\"ADMIN_ID\":\"2\",\"ADMIN_NO\":\"SAMPLE_REGS\",\"FIRSTNAME\":\"SAMPLE_REGS\",\"LASTNAME\":\"LAST\",\"USERNAME\":\"SAMPLE_REGS\",\"USER_ROLE\":\"2\"})', '7484452f8fe5377df1a67a3a83e6d50bf705662458b4f799a61c6d1fd7948412', '1', 0),
(2, 1, '2022-05-16 06:09:46', 'Delete User/s - DETAILS : \r\n( SAMPLE_REGS::SAMPLE_REGS LAST::dark_devil888@yahoo.com [2] )', '7484452f8fe5377df1a67a3a83e6d50bf705662458b4f799a61c6d1fd7948412', '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reset_code`
--

CREATE TABLE `reset_code` (
  `reset_id` int(11) NOT NULL,
  `reset_code` varchar(50) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL DEFAULT 0,
  `email_address` varchar(50) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `expire_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0,
  `user_type` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `id_no` varchar(100) NOT NULL,
  `location` text NOT NULL DEFAULT '',
  `firstname` varchar(100) NOT NULL DEFAULT '',
  `middlename` varchar(100) NOT NULL DEFAULT '',
  `lastname` varchar(100) NOT NULL DEFAULT '',
  `user_role` int(11) NOT NULL DEFAULT 0,
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `password` varchar(100) NOT NULL,
  `email_address` varchar(100) NOT NULL DEFAULT '',
  `status` int(11) NOT NULL DEFAULT 0,
  `locked` int(11) NOT NULL DEFAULT 0,
  `last_signin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `id_no`, `location`, `firstname`, `middlename`, `lastname`, `user_role`, `username`, `password`, `email_address`, `status`, `locked`, `last_signin`) VALUES
(1, 'ituser', '', 'ALVIN', '', 'MONTIANO', 1, 'ituser', 'b994f9e88b5be30943d5a7c963cf58a7a19f3394', 'ammontiano@ccc.edu.ph', 0, 0, NULL),
(2, '', '', 'SAMPLE_REGS', '', 'LAST', 2, '', 'a195c5c1019326441def43766894f74373e13003', '', 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `user_log_id` int(11) NOT NULL,
  `login_date` datetime NOT NULL,
  `logout_date` datetime NOT NULL,
  `action` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_id` varchar(100) NOT NULL,
  `ip_address` varchar(20) NOT NULL,
  `device` varchar(255) NOT NULL,
  `system_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`user_log_id`, `login_date`, `logout_date`, `action`, `user_id`, `session_id`, `ip_address`, `device`, `system_id`) VALUES
(1, '2022-05-16 05:44:34', '2022-05-16 05:45:46', 'LOGIN', 1, '654faac42003f64c70203ed26c20191d278b97f44f5e3916e3dd54cb76a8f7e7', '::1', '{\"device\":\"Chrome\",\"version\":\"101.0.4951.54\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 101.0.4951.54 on Windows 10 64-bit\"}', 0),
(2, '2022-05-16 05:45:22', '2022-05-16 05:45:46', 'LOGIN', 1, '654faac42003f64c70203ed26c20191d278b97f44f5e3916e3dd54cb76a8f7e7', '::1', '{\"device\":\"Chrome\",\"version\":\"101.0.4951.54\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 101.0.4951.54 on Windows 10 64-bit\"}', 0),
(3, '2022-05-16 05:46:56', '2022-05-16 06:04:49', 'LOGIN', 1, '91fb6aa2a34f2cafc6c94880a00020301a0e957cb8e33639a2ea45a61b4cd35a', '::1', '{\"device\":\"Chrome\",\"version\":\"101.0.4951.54\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 101.0.4951.54 on Windows 10 64-bit\"}', 0),
(4, '2022-05-16 06:05:00', '2022-05-16 06:10:22', 'LOGIN', 1, '7484452f8fe5377df1a67a3a83e6d50bf705662458b4f799a61c6d1fd7948412', '::1', '{\"device\":\"Chrome\",\"version\":\"101.0.4951.54\",\"layout\":\"Blink\",\"os\":{\"architecture\":64,\"family\":\"Windows\",\"version\":\"10\"},\"description\":\"Chrome 101.0.4951.54 on Windows 10 64-bit\"}', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`activity_log_id`);

--
-- Indexes for table `reset_code`
--
ALTER TABLE `reset_code`
  ADD PRIMARY KEY (`reset_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`user_log_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `activity_log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reset_code`
--
ALTER TABLE `reset_code`
  MODIFY `reset_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `user_log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
