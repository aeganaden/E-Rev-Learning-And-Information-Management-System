-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2018 at 02:33 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `engineering`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance_out`
--

CREATE TABLE `attendance_out` (
  `attendance_out_id` int(20) NOT NULL,
  `attendance_out_time` int(20) NOT NULL,
  `lecturer_attendance_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance_out`
--

INSERT INTO `attendance_out` (`attendance_out_id`, `attendance_out_time`, `lecturer_attendance_id`) VALUES
(1, 1521420600, 1),
(2, 1521349138, 2),
(3, 1521334558, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance_out`
--
ALTER TABLE `attendance_out`
  ADD PRIMARY KEY (`attendance_out_id`),
  ADD KEY `fk_attendance_out_lecturer_attendance1_idx` (`lecturer_attendance_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance_out`
--
ALTER TABLE `attendance_out`
  ADD CONSTRAINT `fk_attendance_out_lecturer_attendance1` FOREIGN KEY (`lecturer_attendance_id`) REFERENCES `lecturer_attendance` (`lecturer_attendance_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
