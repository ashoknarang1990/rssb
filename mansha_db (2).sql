-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2017 at 08:55 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mansha_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `ma_alerts`
--

CREATE TABLE `ma_alerts` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 : disable, 1 : active, 2 : deleted',
  `added_by` int(11) NOT NULL DEFAULT '0',
  `alert_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ma_diet_plan`
--

CREATE TABLE `ma_diet_plan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `is_active` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 : disbale, 1 : active, 2 : deleted, 3 : pending',
  `is_paid` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 : free, 1 : paid',
  `is_dummy` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 : main plan, 1 : dummy plan',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_plan_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `next_plan_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip_address` varchar(15) NOT NULL DEFAULT '000.000.000.000'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ma_diet_plan`
--

INSERT INTO `ma_diet_plan` (`id`, `user_id`, `is_active`, `is_paid`, `is_dummy`, `created_by`, `created_date`, `modified_date`, `last_plan_date`, `next_plan_date`, `ip_address`) VALUES
(1, 2, 0, 0, 0, 1, '2017-08-03 22:56:40', '2017-08-04 20:18:44', '2017-07-31 00:00:00', '2017-08-07 00:00:00', '000.000.000.000'),
(2, 1, -1, 0, 0, 1, '2017-07-02 13:29:11', '2017-07-02 13:29:11', '2017-06-19 00:00:00', '2017-06-26 00:00:00', '000.000.000.000'),
(3, 3, 0, 0, 0, 1, '2017-08-04 21:12:49', '2017-08-04 21:12:49', '2017-06-20 00:00:00', '2017-06-26 00:00:00', '000.000.000.000');

-- --------------------------------------------------------

--
-- Table structure for table `ma_diet_plan_items`
--

CREATE TABLE `ma_diet_plan_items` (
  `id` int(11) NOT NULL,
  `diet_plan_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `plan_date` date NOT NULL DEFAULT '0000-00-00',
  `is_active` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 : disable, 1 : active, 2 : deleted, 3 : completed, 4 : cancelled',
  `breakfast_items` varchar(250) NOT NULL DEFAULT '' COMMENT 'comma separated meal ids ',
  `lunch_items` varchar(250) NOT NULL DEFAULT '' COMMENT 'comma separated meal ids ',
  `brunch_items` varchar(250) NOT NULL DEFAULT '' COMMENT 'comma separated meal ids ',
  `dinner_items` varchar(250) NOT NULL DEFAULT '' COMMENT 'comma separated meal ids ',
  `breakfast_items_taken` varchar(250) NOT NULL DEFAULT '' COMMENT 'comma separated meal ids (with custom meal ids)',
  `lunch_items_taken` varchar(250) NOT NULL DEFAULT '' COMMENT 'comma separated meal ids (with custom meal ids)',
  `brunch_items_taken` varchar(250) NOT NULL DEFAULT '' COMMENT 'comma separated meal ids (with custom meal ids)',
  `dinner_items_taken` varchar(250) NOT NULL DEFAULT '' COMMENT 'comma separated meal ids (with custom meal ids)'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ma_diet_plan_items`
--

INSERT INTO `ma_diet_plan_items` (`id`, `diet_plan_id`, `user_id`, `plan_date`, `is_active`, `breakfast_items`, `lunch_items`, `brunch_items`, `dinner_items`, `breakfast_items_taken`, `lunch_items_taken`, `brunch_items_taken`, `dinner_items_taken`) VALUES
(1, 1, 1, '2017-06-19', 1, '2', '6', '4', '6', '', '', '', ''),
(2, 1, 1, '2017-06-20', 1, '2,3', '4', '3', '4', '', '', '', ''),
(3, 1, 1, '2017-06-21', 1, '2,3', '6', '3', '4', '', '', '', ''),
(4, 1, 1, '2017-06-22', 1, '2', '6', '3', '4', '', '', '', ''),
(5, 1, 1, '2017-06-23', 1, '2', '6', '3', '4', '', '', '', ''),
(6, 1, 1, '2017-06-24', 1, '2', '6', '3', '4', '', '', '', ''),
(7, 1, 2, '2017-07-17', 1, '2', '6', '', '', '', '', '', ''),
(8, 1, 2, '2017-07-18', 1, '2,3', '', '', '', '', '', '', ''),
(9, 1, 2, '2017-07-19', 1, '2', '', '', '', '', '', '', ''),
(10, 1, 2, '2017-07-20', 1, '2', '', '', '', '', '', '', ''),
(11, 1, 2, '2017-07-21', 1, '2', '', '', '', '', '', '', ''),
(12, 1, 2, '2017-07-22', 1, '2', '6,4', '', '', '', '', '', ''),
(13, 1, 2, '2017-07-24', 1, '', '', '', '', '', '', '', ''),
(14, 1, 2, '2017-07-25', 1, '', '', '', '', '', '', '', ''),
(15, 1, 2, '2017-07-26', 1, '', '', '', '', '', '', '', ''),
(16, 1, 2, '2017-07-27', 1, '', '', '', '', '', '', '', ''),
(17, 1, 2, '2017-07-28', 1, '', '', '', '', '', '', '', ''),
(18, 1, 2, '2017-07-29', 1, '', '', '', '', '', '', '', ''),
(19, 1, 2, '2017-07-31', 1, '2,3,4,6', '3,6', '2,3,6', '2,4,6', '', '', '', ''),
(20, 1, 2, '2017-08-01', 1, '2,3', '6', '2,3,6', '2,4,6', '', '', '', ''),
(21, 1, 2, '2017-08-02', 1, '2', '6', '2', '3', '', '', '', ''),
(22, 1, 2, '2017-08-03', 1, '2', '4', '4', '4', '', '', '', ''),
(23, 1, 2, '2017-08-04', 1, '2', '4', '4', '4', '', '', '', ''),
(24, 1, 2, '2017-08-05', 1, '6', '6', '4', '2,3,4', '', '', '', ''),
(25, 3, 3, '2017-06-20', 1, '2,4', '4', '6', '', '', '', '', ''),
(26, 3, 3, '2017-06-21', 1, '3', '4', '6', '', '', '', '', ''),
(27, 3, 3, '2017-06-22', 1, '3', '6', '6', '', '', '', '', ''),
(28, 3, 3, '2017-06-23', 1, '3', '6', '6', '', '', '', '', ''),
(29, 3, 3, '2017-06-24', 1, '3', '6', '6', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ma_login_sessions`
--

CREATE TABLE `ma_login_sessions` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `login_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `logout_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access_token` varchar(200) NOT NULL DEFAULT '',
  `is_active` tinyint(4) NOT NULL DEFAULT '0',
  `ip_address` varchar(15) NOT NULL DEFAULT '000.000.000.000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ma_meals`
--

CREATE TABLE `ma_meals` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '0 : for parent (use as category), value : parent category id',
  `title` varchar(200) NOT NULL DEFAULT '',
  `is_active` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 : disable, 1 : active, 2 : deleted',
  `is_global` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 : custom added by user, 1 : added by admin (visible to all)',
  `added_by` int(11) NOT NULL DEFAULT '0',
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ma_meals`
--

INSERT INTO `ma_meals` (`id`, `pid`, `title`, `is_active`, `is_global`, `added_by`, `created_date`, `modified_date`) VALUES
(1, 0, 'drink', 1, 0, 2, '2017-06-20 23:30:11', '2017-06-21 00:07:14'),
(2, 1, 'Soft drink', 2, 0, 1, '2017-06-21 00:08:12', '2017-08-04 22:47:22'),
(3, 1, 'milk1', 1, 0, 1, '2017-06-21 00:26:22', '2017-06-21 20:55:03'),
(4, 1, 'bear', 1, 0, 1, '2017-06-21 20:40:14', '2017-06-21 20:54:56'),
(5, 0, 'food', 1, 0, 1, '2017-06-21 20:57:10', '2017-06-21 20:57:10'),
(6, 5, '2 paratha', 1, 0, 1, '2017-06-21 20:57:30', '2017-06-21 20:57:30');

-- --------------------------------------------------------

--
-- Table structure for table `ma_plan`
--

CREATE TABLE `ma_plan` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `content` text NOT NULL,
  `price` float NOT NULL,
  `expiry` varchar(250) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ma_plan`
--

INSERT INTO `ma_plan` (`id`, `title`, `content`, `price`, `expiry`, `is_active`, `created_date`, `modified_date`) VALUES
(1, 'test 111', 'sdg', 200, '30', 1, '2017-07-17 23:08:03', '2017-07-18 00:29:56'),
(2, 'qd', '', 3242, '23', 1, '2017-07-17 23:09:16', '2017-07-17 23:09:16');

-- --------------------------------------------------------

--
-- Table structure for table `ma_push_notifications`
--

CREATE TABLE `ma_push_notifications` (
  `id` int(55) NOT NULL,
  `to_user_id` int(55) DEFAULT '0',
  `from_user_id` int(11) NOT NULL DEFAULT '0',
  `notification_type` tinyint(4) NOT NULL DEFAULT '0',
  `device_os` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 : android, 2 : IOS',
  `device_token` varchar(250) NOT NULL DEFAULT '',
  `message` varchar(255) DEFAULT '',
  `is_send` tinyint(1) DEFAULT '0',
  `is_read` tinyint(1) DEFAULT '0',
  `created_date` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_date` datetime DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ma_users`
--

CREATE TABLE `ma_users` (
  `id` int(11) NOT NULL,
  `user_type` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1 : admin, 2 : user',
  `full_name` varchar(200) NOT NULL DEFAULT '',
  `email_id` varchar(250) NOT NULL DEFAULT '',
  `otp` varchar(100) NOT NULL DEFAULT '' COMMENT 'use as otp for user and password for admin',
  `phone_number` varchar(50) NOT NULL DEFAULT '',
  `city_name` varchar(250) NOT NULL DEFAULT '',
  `gender` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1 : male, 2 : female',
  `height` double NOT NULL DEFAULT '0',
  `age` tinyint(4) NOT NULL DEFAULT '0',
  `is_paid_member` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 : unpaid, 1 : paid',
  `is_active` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 : in-active, 1 : active, 2 :  pending, 3 : suspended, 4 : deleted',
  `is_approved` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 : not approved, 1 : approved',
  `profile_image` varchar(200) NOT NULL DEFAULT '',
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `login_ip_address` varchar(15) NOT NULL DEFAULT '000.000.000.000',
  `ip_address` varchar(15) NOT NULL DEFAULT '000.000.000.000'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ma_users`
--

INSERT INTO `ma_users` (`id`, `user_type`, `full_name`, `email_id`, `otp`, `phone_number`, `city_name`, `gender`, `height`, `age`, `is_paid_member`, `is_active`, `is_approved`, `profile_image`, `created_date`, `modified_date`, `last_login`, `login_ip_address`, `ip_address`) VALUES
(1, 1, 'Sachin', 'admin', '123456', '7500001210', 'Noida', 1, 5, 12, 1, 1, 0, '', '2017-06-11 07:00:00', '2017-06-18 13:10:51', '2017-06-11 07:00:00', '000.000.000.000', '000.000.000.000'),
(2, 2, 'amit narang', 'amitnarang2009@gmail.com', '', '9568989072', 'meerut', 2, 7, 6, 1, 1, 0, '', '2017-06-30 13:47:12', '2017-06-28 23:41:43', '0000-00-00 00:00:00', '000.000.000.000', '000.000.000.000'),
(3, 2, 'abhi', 'abhi@gmail.com', '', '7500001219', 'meerut', 1, 5.6, 12, 0, -1, 1, '', '2017-06-20 21:48:53', '2017-06-20 21:49:05', '0000-00-00 00:00:00', '000.000.000.000', '000.000.000.000');

-- --------------------------------------------------------

--
-- Table structure for table `ma_user_devices`
--

CREATE TABLE `ma_user_devices` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `device_os` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 : android, 2 : IOS',
  `device_token` varchar(250) NOT NULL DEFAULT '',
  `is_active` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 : no, 1 : yes',
  `is_default` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 : no, 1 : yes',
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_address` varchar(15) NOT NULL DEFAULT '000.000.000.000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ma_alerts`
--
ALTER TABLE `ma_alerts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ma_diet_plan`
--
ALTER TABLE `ma_diet_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ma_diet_plan_items`
--
ALTER TABLE `ma_diet_plan_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ma_login_sessions`
--
ALTER TABLE `ma_login_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ma_meals`
--
ALTER TABLE `ma_meals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ma_plan`
--
ALTER TABLE `ma_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ma_push_notifications`
--
ALTER TABLE `ma_push_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ma_users`
--
ALTER TABLE `ma_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ma_user_devices`
--
ALTER TABLE `ma_user_devices`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ma_alerts`
--
ALTER TABLE `ma_alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ma_diet_plan`
--
ALTER TABLE `ma_diet_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `ma_diet_plan_items`
--
ALTER TABLE `ma_diet_plan_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `ma_login_sessions`
--
ALTER TABLE `ma_login_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ma_meals`
--
ALTER TABLE `ma_meals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `ma_plan`
--
ALTER TABLE `ma_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ma_push_notifications`
--
ALTER TABLE `ma_push_notifications`
  MODIFY `id` int(55) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ma_users`
--
ALTER TABLE `ma_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `ma_user_devices`
--
ALTER TABLE `ma_user_devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
