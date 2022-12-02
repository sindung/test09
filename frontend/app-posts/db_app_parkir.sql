-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2022 at 10:16 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_app_parkir`
--

-- --------------------------------------------------------

--
-- Table structure for table `check_in`
--

CREATE TABLE `check_in` (
  `id` int(5) NOT NULL,
  `nomor_polisi` varchar(10) NOT NULL,
  `tanggal` date NOT NULL DEFAULT current_timestamp(),
  `jam` timestamp NOT NULL DEFAULT current_timestamp(),
  `jenis_kendaraan` enum('Sepeda Motor','Mobil','Truk','Bus') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `flag_check_out` enum('1','0') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `check_in`
--

INSERT INTO `check_in` (`id`, `nomor_polisi`, `tanggal`, `jam`, `jenis_kendaraan`, `created_at`, `flag_check_out`) VALUES
(4, 'G-6025-RW', '2022-11-22', '2022-11-22 09:10:47', 'Sepeda Motor', '2022-11-22 09:10:47', '0');

-- --------------------------------------------------------

--
-- Table structure for table `check_out`
--

CREATE TABLE `check_out` (
  `id` int(5) NOT NULL,
  `nomor_polisi` varchar(10) NOT NULL,
  `tanggal_dan_jam_masuk` timestamp NOT NULL DEFAULT current_timestamp(),
  `jenis_kendaraan` enum('Sepeda Motor','Mobil','Truk','Bus') NOT NULL,
  `tanggal_keluar` date NOT NULL DEFAULT current_timestamp(),
  `jam_keluar` timestamp NOT NULL DEFAULT current_timestamp(),
  `biaya_parkir` float(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `check_out`
--

INSERT INTO `check_out` (`id`, `nomor_polisi`, `tanggal_dan_jam_masuk`, `jenis_kendaraan`, `tanggal_keluar`, `jam_keluar`, `biaya_parkir`, `created_at`) VALUES
(4, 'G-6025-RW', '2022-11-22 09:10:47', 'Sepeda Motor', '2022-11-22', '2022-11-22 09:11:00', 5000.00, '2022-11-22 09:11:08');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(5) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `user_id` varchar(128) NOT NULL,
  `gambar` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `is_active` int(1) NOT NULL,
  `role_id` int(1) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `user_id`, `gambar`, `password`, `is_active`, `role_id`, `create_at`) VALUES
(1, 'Hofar Ismail', 'hofar', 'default.jpg', '$2y$10$npd2rQYWQg2GLRXLD/BzkuSGJKOWiVmtGTS0.ynbo9XPfLwoU5rwy', 1, 1, '2019-08-31 05:20:18'),
(2, 'Admin', 'admin', 'default.jpg', '$2y$10$ZPUdSONgksImO0.PI.A7.eM0dZU5kR.sjOytNJArMlNO9XMsk6e7i', 1, 1, '2019-08-31 23:55:43'),
(3, 'User', 'user', 'default.jpg', '$2y$10$HuPSqF5hvJSdle8eromvmuB22wZKsDi6t2Zsf41B7jOSS5OpJj1we', 1, 2, '2019-08-31 23:55:56'),
(10, 'tes', 'tes', 'default.jpg', '$2y$10$4TBFGO.OPsofWEUfQyeaB.PQnfm5zNv7PhtQNMgTs1/IHkRg3YGs6', 1, 6, '2020-07-15 16:17:04'),
(11, 'tes2', 'tes2', 'default.jpg', '$2y$10$R8cHU7iwwYPbQGFxpALYJOB4Da.gR6agTNKoXYDMvNpIcgdOxupWu', 1, 2, '2020-07-15 16:29:56');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(5) NOT NULL,
  `name` varchar(50) NOT NULL,
  `nota` int(1) NOT NULL DEFAULT 0,
  `super` int(1) NOT NULL DEFAULT 0,
  `history` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `name`, `nota`, `super`, `history`) VALUES
(1, 'Administrator', 1, 1, 1),
(2, 'User', 1, 0, 0),
(6, 'Manajer', 1, 0, 1),
(10, 'tes', 0, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `check_in`
--
ALTER TABLE `check_in`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `check_out`
--
ALTER TABLE `check_out`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `check_in`
--
ALTER TABLE `check_in`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `check_out`
--
ALTER TABLE `check_out`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
