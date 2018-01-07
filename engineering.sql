-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2018 at 04:52 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `activity_id` varchar(10) NOT NULL,
  `activity_date_time` bigint(20) NOT NULL,
  `activity_venue` varchar(10) NOT NULL,
  `activity_topic` varchar(30) NOT NULL,
  `activity_status` tinyint(4) NOT NULL,
  `activity_details_id` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `activity_details`
--

CREATE TABLE `activity_details` (
  `activity_details_id` tinyint(4) NOT NULL,
  `activity_details_name` varchar(100) NOT NULL,
  `activity_details_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` bigint(20) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `announcement_id` bigint(20) NOT NULL,
  `announcement_tite` varchar(100) NOT NULL,
  `announcement_content` varchar(800) NOT NULL,
  `announcement_created_at` decimal(20,0) NOT NULL,
  `announcement_edited_at` decimal(20,0) NOT NULL,
  `announcement_is_active` decimal(20,0) NOT NULL,
  `announcement_audience` tinyint(4) NOT NULL,
  `announcement_announcer_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `choice`
--

CREATE TABLE `choice` (
  `choice_id` bigint(20) NOT NULL,
  `choice_content` varchar(100) NOT NULL,
  `choice_is_correct` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` bigint(20) NOT NULL,
  `comment_content` varchar(1000) NOT NULL,
  `comment_user_id` bigint(20) NOT NULL,
  `courseware_file_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courseware_file`
--

CREATE TABLE `courseware_file` (
  `courseware_file_id` bigint(20) NOT NULL,
  `courseware_file_path` varchar(100) NOT NULL,
  `topic_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courseware_question`
--

CREATE TABLE `courseware_question` (
  `courseware_file_id` bigint(20) NOT NULL,
  `courseware_file_question` varchar(500) NOT NULL,
  `courseware_file_reference` varchar(500) NOT NULL,
  `topic_id` bigint(20) NOT NULL,
  `choice_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `enrollment_id` bigint(20) NOT NULL,
  `enrollment_sy` varchar(10) NOT NULL,
  `enrollment_term` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

CREATE TABLE `lecturer` (
  `lecturer_id` bigint(20) NOT NULL,
  `lecturer_firstname` varchar(30) NOT NULL,
  `lecturer_midname` varchar(30) NOT NULL,
  `lecturer_lastname` varchar(30) NOT NULL,
  `lecturer_expertise` varchar(200) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `lecturer_email` varchar(30) NOT NULL,
  `lecturer_status` tinyint(4) NOT NULL,
  `lecturer_offering_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lecturer_attendance`
--

CREATE TABLE `lecturer_attendance` (
  `lecturer_attendance_id` bigint(20) NOT NULL,
  `lecturer_attendance_date` bigint(20) NOT NULL,
  `lecturer_attendance_in` bigint(20) DEFAULT NULL,
  `lecturer_attendance_out` bigint(20) DEFAULT NULL,
  `offering_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lecturer_feedback`
--

CREATE TABLE `lecturer_feedback` (
  `lecturer_feedback_id` bigint(20) NOT NULL,
  `lecturer_feedback_time` bigint(20) NOT NULL,
  `lecturer_feedback_date` bigint(20) NOT NULL,
  `lecturer_feedback_comment` varchar(300) NOT NULL,
  `lecturer_feedback_user_id` bigint(20) NOT NULL,
  `offering_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `offering`
--

CREATE TABLE `offering` (
  `offering_id` bigint(20) NOT NULL,
  `offering_course_code` varchar(20) NOT NULL,
  `offering_course_title` varchar(30) NOT NULL,
  `offering_program` varchar(3) NOT NULL,
  `offering_section` bigint(20) NOT NULL,
  `activity_id` varchar(10) NOT NULL,
  `enrollment_id` bigint(20) NOT NULL,
  `professor_id` bigint(20) NOT NULL,
  `offering_lecturer_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `professor`
--

CREATE TABLE `professor` (
  `professor_id` bigint(20) NOT NULL,
  `professor_firstname` varchar(30) NOT NULL,
  `professor_midname` varchar(30) NOT NULL,
  `professor_lastname` varchar(30) NOT NULL,
  `professor_department` varchar(10) NOT NULL,
  `professor_email` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` bigint(20) NOT NULL,
  `schedule_start_time` bigint(20) NOT NULL,
  `schedule_end_time` bigint(20) NOT NULL,
  `schedule_venue` varchar(10) NOT NULL,
  `offering_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` bigint(20) NOT NULL,
  `student_firstname` varchar(30) NOT NULL,
  `student_midname` varchar(30) NOT NULL,
  `student_lastname` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `student_program` varchar(3) NOT NULL,
  `student_email` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `student_made_feedback` tinyint(4) NOT NULL,
  `enrollment_id` bigint(20) NOT NULL,
  `offering_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE `topic` (
  `topic_id` bigint(20) NOT NULL,
  `topic_name` varchar(50) NOT NULL,
  `topic_description` varchar(500) NOT NULL,
  `topic_done` tinyint(4) DEFAULT NULL,
  `offering_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`activity_id`),
  ADD KEY `activity_activity_details_fk` (`activity_details_id`);

--
-- Indexes for table `activity_details`
--
ALTER TABLE `activity_details`
  ADD PRIMARY KEY (`activity_details_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `choice`
--
ALTER TABLE `choice`
  ADD PRIMARY KEY (`choice_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment_courseware_question_fk` (`courseware_file_id`);

--
-- Indexes for table `courseware_file`
--
ALTER TABLE `courseware_file`
  ADD PRIMARY KEY (`courseware_file_id`),
  ADD KEY `courseware_file_topic_fk` (`topic_id`);

--
-- Indexes for table `courseware_question`
--
ALTER TABLE `courseware_question`
  ADD PRIMARY KEY (`courseware_file_id`),
  ADD KEY `courseware_question_choice_fk` (`choice_id`),
  ADD KEY `courseware_question_topic_fk` (`topic_id`);

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`enrollment_id`);

--
-- Indexes for table `lecturer`
--
ALTER TABLE `lecturer`
  ADD PRIMARY KEY (`lecturer_id`);

--
-- Indexes for table `lecturer_attendance`
--
ALTER TABLE `lecturer_attendance`
  ADD PRIMARY KEY (`lecturer_attendance_id`),
  ADD KEY `lecturer_attendance_offering_fk` (`offering_id`);

--
-- Indexes for table `lecturer_feedback`
--
ALTER TABLE `lecturer_feedback`
  ADD PRIMARY KEY (`lecturer_feedback_id`),
  ADD KEY `lecturer_feedback_offering_fk` (`offering_id`);

--
-- Indexes for table `offering`
--
ALTER TABLE `offering`
  ADD PRIMARY KEY (`offering_id`),
  ADD KEY `offering_activity_fk` (`activity_id`),
  ADD KEY `offering_enrollment_fk` (`enrollment_id`),
  ADD KEY `offering_professor_fk` (`professor_id`);

--
-- Indexes for table `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`professor_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `schedule_offering_fk` (`offering_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `student_enrollment_fk` (`enrollment_id`),
  ADD KEY `student_offering_fk` (`offering_id`);

--
-- Indexes for table `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`topic_id`),
  ADD KEY `topic_offering_fk` (`offering_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `activity_activity_details_fk` FOREIGN KEY (`activity_details_id`) REFERENCES `activity_details` (`activity_details_id`);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_courseware_question_fk` FOREIGN KEY (`courseware_file_id`) REFERENCES `courseware_question` (`courseware_file_id`);

--
-- Constraints for table `courseware_file`
--
ALTER TABLE `courseware_file`
  ADD CONSTRAINT `courseware_file_topic_fk` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`topic_id`);

--
-- Constraints for table `courseware_question`
--
ALTER TABLE `courseware_question`
  ADD CONSTRAINT `courseware_question_choice_fk` FOREIGN KEY (`choice_id`) REFERENCES `choice` (`choice_id`),
  ADD CONSTRAINT `courseware_question_topic_fk` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`topic_id`);

--
-- Constraints for table `lecturer_attendance`
--
ALTER TABLE `lecturer_attendance`
  ADD CONSTRAINT `lecturer_attendance_offering_fk` FOREIGN KEY (`offering_id`) REFERENCES `offering` (`offering_id`);

--
-- Constraints for table `lecturer_feedback`
--
ALTER TABLE `lecturer_feedback`
  ADD CONSTRAINT `lecturer_feedback_offering_fk` FOREIGN KEY (`offering_id`) REFERENCES `offering` (`offering_id`);

--
-- Constraints for table `offering`
--
ALTER TABLE `offering`
  ADD CONSTRAINT `offering_activity_fk` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`activity_id`),
  ADD CONSTRAINT `offering_enrollment_fk` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollment` (`enrollment_id`),
  ADD CONSTRAINT `offering_professor_fk` FOREIGN KEY (`professor_id`) REFERENCES `professor` (`professor_id`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_offering_fk` FOREIGN KEY (`offering_id`) REFERENCES `offering` (`offering_id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_enrollment_fk` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollment` (`enrollment_id`),
  ADD CONSTRAINT `student_offering_fk` FOREIGN KEY (`offering_id`) REFERENCES `offering` (`offering_id`);

--
-- Constraints for table `topic`
--
ALTER TABLE `topic`
  ADD CONSTRAINT `topic_offering_fk` FOREIGN KEY (`offering_id`) REFERENCES `offering` (`offering_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
