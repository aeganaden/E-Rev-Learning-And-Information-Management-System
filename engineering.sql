-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2018 at 01:28 PM
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
  `activity_id` bigint(20) NOT NULL,
  `activity_section` varchar(5) NOT NULL,
  `activity_sy` varchar(10) NOT NULL,
  `activity_term` tinyint(4) NOT NULL,
  `activity_date_time` bigint(20) NOT NULL,
  `activity_venue` varchar(10) NOT NULL,
  `activity_topic` varchar(30) NOT NULL,
  `activity_status` tinyint(4) NOT NULL,
  `offering_id` bigint(20) NOT NULL,
  `activity_details_id` bigint(20) NOT NULL,
  `offering_course_code` varchar(20) NOT NULL,
  `lecturer_id` bigint(20) NOT NULL,
  `lecturer_attendance_id` bigint(20) NOT NULL,
  `lecturer_feedback_id` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `activity_details`
--

CREATE TABLE `activity_details` (
  `activity_details_id` bigint(20) NOT NULL,
  `activity_details_name` varchar(100) NOT NULL,
  `activity_details_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `choice`
--

CREATE TABLE `choice` (
  `choice_id` bigint(20) NOT NULL,
  `answer_content` varchar(100) NOT NULL,
  `choice_correct` tinyint(4) NOT NULL,
  `courserware_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` bigint(20) NOT NULL,
  `comment_content` varchar(1000) NOT NULL,
  `courserware_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courseware`
--

CREATE TABLE `courseware` (
  `courserware_id` bigint(20) NOT NULL,
  `courserware_question` varchar(1000) NOT NULL,
  `topic_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `enrollment_id` bigint(20) NOT NULL,
  `enrollment_course_code` varchar(20) NOT NULL,
  `enrollment_section` varchar(6) NOT NULL,
  `enrollment_sy` varchar(10) NOT NULL,
  `enrollment_term` tinyint(4) NOT NULL,
  `offering_id` bigint(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `offering_course_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

CREATE TABLE `lecturer` (
  `lecturer_id` bigint(20) NOT NULL COMMENT 'student number (unique)',
  `lecturer_firstname` varchar(30) NOT NULL,
  `lecturer_midname` varchar(30) NOT NULL,
  `lecturer_lastname` varchar(20) NOT NULL,
  `lecturer_expertise` varchar(100) NOT NULL,
  `lecturer_status` tinyint(4) NOT NULL,
  `activity_id` bigint(20) NOT NULL,
  `offering_id` bigint(20) NOT NULL,
  `activity_details_id` bigint(20) NOT NULL,
  `offering_course_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lecturer_attendance`
--

CREATE TABLE `lecturer_attendance` (
  `lecturer_attendance_id` bigint(20) NOT NULL,
  `lecturer_attendance_date` bigint(20) NOT NULL,
  `lecturer_attendance_in` bigint(20) NOT NULL,
  `lecturer_attendance_out` bigint(20) NOT NULL,
  `activity_id` bigint(20) NOT NULL,
  `offering_id` bigint(20) NOT NULL,
  `activity_details_id` bigint(20) NOT NULL,
  `offering_course_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lecturer_feedback`
--

CREATE TABLE `lecturer_feedback` (
  `lecturer_feedback_id` varchar(500) NOT NULL,
  `lecturer_feedback_time` bigint(20) NOT NULL,
  `lecturer_feedback_date` bigint(20) NOT NULL,
  `lecturer_feedback_comment` varchar(225) NOT NULL,
  `activity_id` bigint(20) NOT NULL,
  `offering_id` bigint(20) NOT NULL,
  `activity_details_id` bigint(20) NOT NULL,
  `offering_course_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `offering`
--

CREATE TABLE `offering` (
  `offering_id` bigint(20) NOT NULL,
  `offering_course_code` varchar(20) NOT NULL,
  `offering_course_title` varchar(30) NOT NULL,
  `offering_section` varchar(6) NOT NULL,
  `offering_term` tinyint(4) NOT NULL,
  `offering_program` varchar(3) NOT NULL COMMENT 'course of the student',
  `offering_sy` varchar(10) NOT NULL COMMENT 'school year',
  `professor_id` bigint(20) NOT NULL,
  `schedule_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `professor`
--

CREATE TABLE `professor` (
  `professor_id` bigint(20) NOT NULL COMMENT 'student number (unique)',
  `professor_firstname` varchar(30) NOT NULL,
  `professor_midname` varchar(30) NOT NULL,
  `professor_lastname` varchar(20) NOT NULL,
  `professor_department` varchar(10) NOT NULL,
  `professor_email` varchar(30) NOT NULL,
  `offering_id` bigint(20) NOT NULL,
  `offering_course_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reference`
--

CREATE TABLE `reference` (
  `ref_id` bigint(20) NOT NULL,
  `ref_reference` varchar(1000) NOT NULL,
  `courserware_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` varchar(20) NOT NULL,
  `schedule_section` varchar(6) NOT NULL,
  `schedule_term` tinyint(4) NOT NULL,
  `schedule_sy` varchar(10) NOT NULL,
  `schedule_start_time` bigint(20) NOT NULL,
  `schedule_end_time` bigint(20) NOT NULL,
  `schedule_venue` varchar(5) NOT NULL,
  `offering_id` bigint(20) NOT NULL,
  `offering_course_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` bigint(20) NOT NULL COMMENT 'student number (unique)',
  `student_firstname` varchar(30) NOT NULL,
  `student_midname` varchar(30) NOT NULL,
  `student_lastname` varchar(20) NOT NULL,
  `student_program` varchar(3) NOT NULL,
  `student_email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE `topic` (
  `topic_id` bigint(20) NOT NULL,
  `topic_name` varchar(50) NOT NULL,
  `topic_description` varchar(500) NOT NULL,
  `activity_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`activity_id`),
  ADD KEY `activity_activity_details_fk` (`activity_details_id`),
  ADD KEY `activity_lecturer_attendance_fk` (`lecturer_attendance_id`),
  ADD KEY `activity_lecturer_feedback_fk` (`lecturer_feedback_id`),
  ADD KEY `activity_lecturer_fk` (`lecturer_id`),
  ADD KEY `activity_offering_fk` (`offering_id`,`offering_course_code`);

--
-- Indexes for table `activity_details`
--
ALTER TABLE `activity_details`
  ADD PRIMARY KEY (`activity_details_id`);

--
-- Indexes for table `choice`
--
ALTER TABLE `choice`
  ADD PRIMARY KEY (`choice_id`),
  ADD KEY `choice_courseware_fk` (`courserware_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment_courseware_fk` (`courserware_id`);

--
-- Indexes for table `courseware`
--
ALTER TABLE `courseware`
  ADD PRIMARY KEY (`courserware_id`),
  ADD KEY `courseware_topic_fk` (`topic_id`);

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD KEY `enrollment_offering_fk` (`offering_id`,`offering_course_code`),
  ADD KEY `enrollment_student_fk` (`student_id`);

--
-- Indexes for table `lecturer`
--
ALTER TABLE `lecturer`
  ADD PRIMARY KEY (`lecturer_id`),
  ADD KEY `lecturer_activity_fk` (`activity_id`);

--
-- Indexes for table `lecturer_attendance`
--
ALTER TABLE `lecturer_attendance`
  ADD PRIMARY KEY (`lecturer_attendance_id`),
  ADD KEY `lecturer_attendance_activity_fk` (`activity_id`);

--
-- Indexes for table `lecturer_feedback`
--
ALTER TABLE `lecturer_feedback`
  ADD PRIMARY KEY (`lecturer_feedback_id`),
  ADD KEY `lecturer_feedback_activity_fk` (`activity_id`);

--
-- Indexes for table `offering`
--
ALTER TABLE `offering`
  ADD PRIMARY KEY (`offering_id`,`offering_course_code`),
  ADD KEY `offering_professor_fk` (`professor_id`),
  ADD KEY `offering_schedule_fk` (`schedule_id`);

--
-- Indexes for table `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`professor_id`),
  ADD KEY `professor_offering_fk` (`offering_id`,`offering_course_code`);

--
-- Indexes for table `reference`
--
ALTER TABLE `reference`
  ADD PRIMARY KEY (`ref_id`),
  ADD KEY `reference_courseware_fk` (`courserware_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `schedule_offering_fk` (`offering_id`,`offering_course_code`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`topic_id`),
  ADD KEY `topic_activity_fk` (`activity_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `activity_activity_details_fk` FOREIGN KEY (`activity_details_id`) REFERENCES `activity_details` (`activity_details_id`),
  ADD CONSTRAINT `activity_lecturer_attendance_fk` FOREIGN KEY (`lecturer_attendance_id`) REFERENCES `lecturer_attendance` (`lecturer_attendance_id`),
  ADD CONSTRAINT `activity_lecturer_feedback_fk` FOREIGN KEY (`lecturer_feedback_id`) REFERENCES `lecturer_feedback` (`lecturer_feedback_id`),
  ADD CONSTRAINT `activity_lecturer_fk` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`lecturer_id`),
  ADD CONSTRAINT `activity_offering_fk` FOREIGN KEY (`offering_id`,`offering_course_code`) REFERENCES `offering` (`offering_id`, `offering_course_code`);

--
-- Constraints for table `choice`
--
ALTER TABLE `choice`
  ADD CONSTRAINT `choice_courseware_fk` FOREIGN KEY (`courserware_id`) REFERENCES `courseware` (`courserware_id`);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_courseware_fk` FOREIGN KEY (`courserware_id`) REFERENCES `courseware` (`courserware_id`);

--
-- Constraints for table `courseware`
--
ALTER TABLE `courseware`
  ADD CONSTRAINT `courseware_topic_fk` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`topic_id`);

--
-- Constraints for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD CONSTRAINT `enrollment_offering_fk` FOREIGN KEY (`offering_id`,`offering_course_code`) REFERENCES `offering` (`offering_id`, `offering_course_code`),
  ADD CONSTRAINT `enrollment_student_fk` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `lecturer`
--
ALTER TABLE `lecturer`
  ADD CONSTRAINT `lecturer_activity_fk` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`activity_id`);

--
-- Constraints for table `lecturer_attendance`
--
ALTER TABLE `lecturer_attendance`
  ADD CONSTRAINT `lecturer_attendance_activity_fk` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`activity_id`);

--
-- Constraints for table `lecturer_feedback`
--
ALTER TABLE `lecturer_feedback`
  ADD CONSTRAINT `lecturer_feedback_activity_fk` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`activity_id`);

--
-- Constraints for table `offering`
--
ALTER TABLE `offering`
  ADD CONSTRAINT `offering_professor_fk` FOREIGN KEY (`professor_id`) REFERENCES `professor` (`professor_id`),
  ADD CONSTRAINT `offering_schedule_fk` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`schedule_id`);

--
-- Constraints for table `professor`
--
ALTER TABLE `professor`
  ADD CONSTRAINT `professor_offering_fk` FOREIGN KEY (`offering_id`,`offering_course_code`) REFERENCES `offering` (`offering_id`, `offering_course_code`);

--
-- Constraints for table `reference`
--
ALTER TABLE `reference`
  ADD CONSTRAINT `reference_courseware_fk` FOREIGN KEY (`courserware_id`) REFERENCES `courseware` (`courserware_id`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_offering_fk` FOREIGN KEY (`offering_id`,`offering_course_code`) REFERENCES `offering` (`offering_id`, `offering_course_code`);

--
-- Constraints for table `topic`
--
ALTER TABLE `topic`
  ADD CONSTRAINT `topic_activity_fk` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`activity_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
