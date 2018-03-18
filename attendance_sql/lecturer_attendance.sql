-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2018 at 02:32 PM
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
-- Table structure for table `lecturer_attendance`
--

CREATE TABLE `lecturer_attendance` (
  `lecturer_attendance_id` int(50) NOT NULL,
  `lecturer_attendance_date` int(20) NOT NULL,
  `lecturer_id` int(20) NOT NULL,
  `offering_id` int(20) NOT NULL,
  `schedule_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lecturer_attendance`
--

INSERT INTO `lecturer_attendance` (`lecturer_attendance_id`, `lecturer_attendance_date`, `lecturer_id`, `offering_id`, `schedule_id`) VALUES
(1, 1521413400, 1, 1, 1),
(2, 1521414025, 1, 2, 2),
(3, 1521327958, 1, 3, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lecturer_attendance`
--
ALTER TABLE `lecturer_attendance`
  ADD PRIMARY KEY (`lecturer_attendance_id`),
  ADD KEY `fk_lecturer_attendance_lecturer1_idx` (`lecturer_id`),
  ADD KEY `fk_lecturer_attendance_offering1_idx` (`offering_id`),
  ADD KEY `fk_lecturer_attendance_schedule1_idx` (`schedule_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lecturer_attendance`
--
ALTER TABLE `lecturer_attendance`
  ADD CONSTRAINT `fk_lecturer_attendance_lecturer1` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`lecturer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_lecturer_attendance_offering1` FOREIGN KEY (`offering_id`) REFERENCES `offering` (`offering_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_lecturer_attendance_schedule1` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`schedule_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
