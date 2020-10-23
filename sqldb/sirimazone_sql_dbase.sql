-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2020 at 09:08 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sirimazone_sql_dbase`
--

-- --------------------------------------------------------

--
-- Table structure for table `sirimazone_access_id`
--

CREATE TABLE `sirimazone_access_id` (
  `id` int(11) NOT NULL,
  `access_name` varchar(255) NOT NULL,
  `access_key` varchar(255) NOT NULL,
  `access_id_creator` varchar(255) NOT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sirimazone_access_id`
--

INSERT INTO `sirimazone_access_id` (`id`, `access_name`, `access_key`, `access_id_creator`, `is_used`) VALUES
(5, 'defaultaccessname', '$2y$10$UvmKCuLeUDa1et/hAA1gYOgqXaRpdWyLJ91TXdJSYqCaXGqpV8CHy', 'Ifex', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sirimazone_admins`
--

CREATE TABLE `sirimazone_admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `is_email_active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sirimazone_admins`
--

INSERT INTO `sirimazone_admins` (`id`, `username`, `email`, `password`, `hash`, `is_email_active`) VALUES
(15, 'Ifex', 'Ifexemail', '$2y$10$4m5ci1FstFnodrPoqRSzheWgfT7acBjh.ArxhEjvfYPkn8XHOv.f.', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sirimazone_comments`
--

CREATE TABLE `sirimazone_comments` (
  `id` int(11) NOT NULL,
  `comment_id` varchar(255) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_slug` varchar(255) NOT NULL,
  `comment_author` varchar(255) NOT NULL DEFAULT 'Anonymous',
  `comment_body` text NOT NULL,
  `creation_timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sirimazone_contents`
--

CREATE TABLE `sirimazone_contents` (
  `id` int(11) NOT NULL,
  `content_title` varchar(255) NOT NULL,
  `content_slug` varchar(255) NOT NULL,
  `content_cover_image` varchar(255) NOT NULL,
  `content_cover_image_alt` varchar(255) NOT NULL,
  `content_category` enum('Hollywood','Nollywood','Bollywood','Others') NOT NULL,
  `content_author` varchar(255) NOT NULL,
  `content_main_file` varchar(255) NOT NULL,
  `content_main_file_ext_server` text NOT NULL,
  `content_overview` text NOT NULL,
  `content_casts` text NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `is_pinned` tinyint(1) NOT NULL DEFAULT 0,
  `content_downloads` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sirimazone_uploads`
--

CREATE TABLE `sirimazone_uploads` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_extension` varchar(255) NOT NULL,
  `file_size` varchar(255) NOT NULL,
  `uploaded_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sirimazone_access_id`
--
ALTER TABLE `sirimazone_access_id`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sirimazone_admins`
--
ALTER TABLE `sirimazone_admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sirimazone_comments`
--
ALTER TABLE `sirimazone_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sirimazone_contents`
--
ALTER TABLE `sirimazone_contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sirimazone_uploads`
--
ALTER TABLE `sirimazone_uploads`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sirimazone_access_id`
--
ALTER TABLE `sirimazone_access_id`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sirimazone_admins`
--
ALTER TABLE `sirimazone_admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sirimazone_comments`
--
ALTER TABLE `sirimazone_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `sirimazone_contents`
--
ALTER TABLE `sirimazone_contents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `sirimazone_uploads`
--
ALTER TABLE `sirimazone_uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
