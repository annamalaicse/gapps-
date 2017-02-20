-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2017 at 02:56 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gingerpayments`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(254) NOT NULL,
  `count` int(11) NOT NULL,
  `slug` varchar(254) NOT NULL,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `count`, `slug`, `modified`) VALUES
(1, 'Friends', 0, '', '2017-02-20 02:53:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `first_name` varchar(254) NOT NULL,
  `last_name` varchar(254) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `is_active` enum('Y','N') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `created`, `modified`, `is_active`) VALUES
(1, 'Annamalai', 'Soman', '2017-02-20 02:30:59', '2017-02-20 02:30:59', 'Y'),
(2, 'Annamalai', 'Soman', '2017-02-20 02:31:20', '2017-02-20 02:31:20', 'Y'),
(3, 'Annamalai', 'Soman', '2017-02-20 02:37:34', '2017-02-20 02:37:34', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `address` varchar(254) NOT NULL,
  `city` varchar(254) NOT NULL,
  `state` varchar(254) NOT NULL,
  `country` varchar(254) NOT NULL,
  `post_code` varchar(254) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`id`, `user_id`, `address`, `city`, `state`, `country`, `post_code`, `created`, `modified`) VALUES
(1, 1, 'Jurong West', 'Singapore', 'Singapore', 'SG', '', '2017-02-20 02:30:59', '2017-02-20 02:30:59'),
(2, 1, 'Holland Village', 'Singapore', 'Singapore', 'SG', '', '2017-02-20 02:30:59', '2017-02-20 02:30:59'),
(3, 1, 'Menara Jaya', 'Petaling Jaya', 'Kuala Lumpur', 'MY', '', '2017-02-20 02:30:59', '2017-02-20 02:30:59'),
(4, 2, 'Jurong West', 'Singapore', 'Singapore', 'SG', '', '2017-02-20 02:31:20', '2017-02-20 02:31:20'),
(5, 2, 'Holland Village', 'Singapore', 'Singapore', 'SG', '', '2017-02-20 02:31:20', '2017-02-20 02:31:20'),
(6, 2, 'Menara Jaya', 'Petaling Jaya', 'Kuala Lumpur', 'MY', '', '2017-02-20 02:31:20', '2017-02-20 02:31:20'),
(7, 3, 'Jurong West', 'Singapore', 'Singapore', 'SG', '', '2017-02-20 02:37:34', '2017-02-20 02:37:34'),
(8, 3, 'Holland Village', 'Singapore', 'Singapore', 'SG', '', '2017-02-20 02:37:34', '2017-02-20 02:37:34'),
(9, 3, 'Menara Jaya', 'Petaling Jaya', 'Kuala Lumpur', 'MY', '', '2017-02-20 02:37:34', '2017-02-20 02:37:34');

-- --------------------------------------------------------

--
-- Table structure for table `user_emails`
--

CREATE TABLE `user_emails` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `email` varchar(254) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_emails`
--

INSERT INTO `user_emails` (`id`, `user_id`, `email`, `created`, `modified`) VALUES
(1, 1, 'annamalai19@gmail.com', '2017-02-20 02:30:59', '2017-02-20 02:30:59'),
(2, 1, 'annamalai19+test@gmail.com', '2017-02-20 02:30:59', '2017-02-20 02:30:59'),
(3, 2, 'annamalai19@gmail.com', '2017-02-20 02:31:20', '2017-02-20 02:31:20'),
(4, 2, 'annamalai19+test@gmail.com', '2017-02-20 02:31:20', '2017-02-20 02:31:20'),
(5, 3, 'annamalai19@gmail.com', '2017-02-20 02:37:34', '2017-02-20 02:37:34'),
(6, 3, 'annamalai19+test@gmail.com', '2017-02-20 02:37:34', '2017-02-20 02:37:34');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `user_id`, `group_id`, `created`, `modified`) VALUES
(1, 1, 1, '2017-02-20 02:54:38', '2017-02-20 02:54:38');

-- --------------------------------------------------------

--
-- Table structure for table `user_phonenumbers`
--

CREATE TABLE `user_phonenumbers` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `phone_no` varchar(254) NOT NULL,
  `type` enum('home','office','personal') NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_phonenumbers`
--

INSERT INTO `user_phonenumbers` (`id`, `user_id`, `phone_no`, `type`, `created`, `modified`) VALUES
(1, 1, '1010', 'home', '2017-02-20 02:30:59', '2017-02-20 02:30:59'),
(2, 1, '13434', 'office', '2017-02-20 02:30:59', '2017-02-20 02:30:59'),
(3, 2, '1010', 'home', '2017-02-20 02:31:20', '2017-02-20 02:31:20'),
(4, 2, '13434', 'office', '2017-02-20 02:31:20', '2017-02-20 02:31:20'),
(5, 3, '1010', 'home', '2017-02-20 02:37:34', '2017-02-20 02:37:34'),
(6, 3, '13434', 'office', '2017-02-20 02:37:34', '2017-02-20 02:37:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_emails`
--
ALTER TABLE `user_emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_phonenumbers`
--
ALTER TABLE `user_phonenumbers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `user_emails`
--
ALTER TABLE `user_emails`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user_phonenumbers`
--
ALTER TABLE `user_phonenumbers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
