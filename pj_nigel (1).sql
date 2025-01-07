-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2025 at 01:18 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pj_nigel`
--

-- --------------------------------------------------------

--
-- Table structure for table `footers`
--

CREATE TABLE `footers` (
  `id` int(11) NOT NULL,
  `copyright` varchar(255) DEFAULT NULL,
  `website_name` varchar(255) DEFAULT NULL,
  `website_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `footers`
--

INSERT INTO `footers` (`id`, `copyright`, `website_name`, `website_description`) VALUES
(2, 'Copyright 2025. All Rights Reserved', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `footer_socials`
--

CREATE TABLE `footer_socials` (
  `id` int(11) NOT NULL,
  `footer_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `footer_socials`
--

INSERT INTO `footer_socials` (`id`, `footer_id`, `name`, `link`, `icon`) VALUES
(4, 2, '@mnnigel_', 'https://www.instagram.com/mnnigel_/', 'assets/icons/instagram.svg'),
(5, 2, '@mnnigel_', 'https://www.instagram.com/mnnigel_/', 'assets/icons/facebook.svg'),
(6, 2, '@mnnigel_', 'https://www.instagram.com/mnnigel_/', 'assets/icons/twitter.svg');

-- --------------------------------------------------------

--
-- Table structure for table `headers`
--

CREATE TABLE `headers` (
  `id` int(11) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slogan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `headers`
--

INSERT INTO `headers` (`id`, `logo`, `title`, `slogan`) VALUES
(1, 'assets/foto.jpeg', 'Profil Mahasiswa', 'Tangkis UTS');

-- --------------------------------------------------------

--
-- Table structure for table `hobbys`
--

CREATE TABLE `hobbys` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hobbys`
--

INSERT INTO `hobbys` (`id`, `name`, `icon`) VALUES
(1, 'Bulutangkis', 'assets/icons/running.svg'),
(2, 'Musik', 'assets/icons/music.svg'),
(3, 'Film', 'assets/icons/film.svg');

-- --------------------------------------------------------

--
-- Table structure for table `navbar`
--

CREATE TABLE `navbar` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `section` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `navbar`
--

INSERT INTO `navbar` (`id`, `name`, `section`) VALUES
(1, 'Biodata', 'biodata'),
(2, 'Pendidikan', 'pendidikan'),
(3, 'Pengalaman', 'pengalaman'),
(4, 'Keahlian', 'keahlian');

-- --------------------------------------------------------

--
-- Table structure for table `section_items`
--

CREATE TABLE `section_items` (
  `id` int(11) NOT NULL,
  `section_id` int(11) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section_items`
--

INSERT INTO `section_items` (`id`, `section_id`, `label`, `value`) VALUES
(1, 1, 'NIM', '2022081044'),
(2, 1, 'Nama', 'Muhammad Nigel'),
(3, 1, 'Agama', 'Islam'),
(4, 1, 'Tanggal Lahir', '8 Juni 2004'),
(5, 1, 'Tempat Lahir', 'Jakarta'),
(6, 2, 'SMA', 'SMAN 87 Jakarta'),
(7, 2, 'Tahun Masuk', '2019'),
(8, 3, 'Kerja', 'Animator of the fox the folks'),
(9, 4, 'Unfaedah', 'Menjinakan Kucing');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `footers`
--
ALTER TABLE `footers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `footer_socials`
--
ALTER TABLE `footer_socials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `footer_socials_ibfk_1` (`footer_id`);

--
-- Indexes for table `headers`
--
ALTER TABLE `headers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hobbys`
--
ALTER TABLE `hobbys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `navbar`
--
ALTER TABLE `navbar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section_items`
--
ALTER TABLE `section_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `section_items_ibfk_1` (`section_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `footers`
--
ALTER TABLE `footers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `footer_socials`
--
ALTER TABLE `footer_socials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `headers`
--
ALTER TABLE `headers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hobbys`
--
ALTER TABLE `hobbys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `navbar`
--
ALTER TABLE `navbar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `section_items`
--
ALTER TABLE `section_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `footer_socials`
--
ALTER TABLE `footer_socials`
  ADD CONSTRAINT `footer_socials_ibfk_1` FOREIGN KEY (`footer_id`) REFERENCES `footers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `section_items`
--
ALTER TABLE `section_items`
  ADD CONSTRAINT `section_items_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `navbar` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
