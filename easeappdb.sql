-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2022 at 07:40 PM
-- Server version: 10.2.43-MariaDB-1:10.2.43+maria~bionic-log
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `easeappdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `site_members`
--

CREATE TABLE `site_members` (
  `sm_memb_id` bigint(20) NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(240) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sm_user_type` enum('super-admin','site-admin','application-team') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `user_data_source` enum('local','active-directory') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `is_active_status` enum('0','1','2','3') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_members`
--

INSERT INTO `site_members` (`sm_memb_id`, `username`, `password`, `email`, `sm_user_type`, `user_data_source`, `is_active_status`) VALUES
(1, 'raghuveer.dendukuri', '$argon2id$v=19$m=65536,t=4,p=1$RENJWWYwTkdVOFJFc1RLSw$/C6nfxPHn7lDYbv6bVdPO4lt39TVxJRfMw+7F910xtA', 'raghuveer.dendukuri@gmail.com', 'super-admin', 'local', '1'),
(2, 'securitywonks', '$argon2id$v=19$m=65536,t=4,p=1$RENJWWYwTkdVOFJFc1RLSw$/C6nfxPHn7lDYbv6bVdPO4lt39TVxJRfMw+7F910xtA', 'securitywonks@gmail.com', 'site-admin', 'local', '1'),
(3, 'raghuveer.dendukuri1', '$argon2id$v=19$m=65536,t=4,p=1$RENJWWYwTkdVOFJFc1RLSw$/C6nfxPHn7lDYbv6bVdPO4lt39TVxJRfMw+7F910xtA', 'raghuveer.dendukuri@dxc.com', 'application-team', 'local', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `site_members`
--
ALTER TABLE `site_members`
  ADD PRIMARY KEY (`sm_memb_id`),
  ADD KEY `email` (`email`),
  ADD KEY `is_active_status` (`is_active_status`),
  ADD KEY `username` (`username`),
  ADD KEY `sm_user_type` (`sm_user_type`),
  ADD KEY `user_data_source` (`user_data_source`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
