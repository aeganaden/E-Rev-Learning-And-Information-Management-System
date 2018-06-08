-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2018 at 07:40 PM
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
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `activity_id` int(20) NOT NULL,
  `activity_venue` varchar(20) NOT NULL,
  `activity_status` tinyint(1) NOT NULL DEFAULT '1',
  `activity_description` varchar(500) NOT NULL,
  `activity_details_id` int(20) NOT NULL,
  `lecturer_id` int(20) DEFAULT NULL,
  `offering_id` int(20) NOT NULL,
  `activity_schedule_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `activity_details`
--

CREATE TABLE `activity_details` (
  `activity_details_id` int(20) NOT NULL,
  `activity_details_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `activity_schedule`
--

CREATE TABLE `activity_schedule` (
  `activity_schedule_id` int(20) NOT NULL,
  `activity_schedule_date` int(10) NOT NULL,
  `activity_schedule_start_time` int(10) NOT NULL,
  `activity_schedule_end_time` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(20) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(50) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `midname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `image_path` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `announcement_id` int(20) NOT NULL,
  `announcement_title` varchar(100) NOT NULL,
  `announcement_content` varchar(800) NOT NULL,
  `announcement_created_at` int(20) NOT NULL,
  `announcement_edited_at` int(20) NOT NULL,
  `announcement_is_active` tinyint(1) NOT NULL,
  `announcement_audience` varchar(10) NOT NULL,
  `announcement_announcer` varchar(100) NOT NULL,
  `announcement_start_datetime` int(15) NOT NULL,
  `announcement_end_datetime` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_in`
--

CREATE TABLE `attendance_in` (
  `attendance_in_id` int(20) NOT NULL,
  `attendance_in_time` int(20) NOT NULL,
  `lecturer_attendance_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_out`
--

CREATE TABLE `attendance_out` (
  `attendance_out_id` int(20) NOT NULL,
  `attendance_out_time` int(20) NOT NULL,
  `lecturer_attendance_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `choice`
--

CREATE TABLE `choice` (
  `choice_id` int(20) NOT NULL,
  `choice_choice` varchar(800) NOT NULL,
  `choice_is_answer` tinyint(1) NOT NULL,
  `courseware_question_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(20) NOT NULL,
  `comment_content` varchar(500) NOT NULL,
  `comment_user_id` int(20) NOT NULL,
  `courseware_question_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(20) NOT NULL,
  `course_course_code` varchar(20) NOT NULL,
  `course_course_title` varchar(100) NOT NULL,
  `course_department` varchar(10) NOT NULL,
  `course_is_active` tinyint(1) NOT NULL,
  `enrollment_id` int(20) NOT NULL,
  `professor_id` int(20) NOT NULL,
  `year_level_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `courseware`
--

CREATE TABLE `courseware` (
  `courseware_id` int(50) NOT NULL,
  `courseware_name` varchar(100) NOT NULL,
  `courseware_description` varchar(800) DEFAULT NULL,
  `courseware_date_added` int(20) NOT NULL,
  `courseware_date_edited` int(20) NOT NULL,
  `courseware_status` tinyint(1) DEFAULT '1',
  `topic_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `courseware_question`
--

CREATE TABLE `courseware_question` (
  `courseware_question_id` int(20) NOT NULL,
  `courseware_question_question` text NOT NULL,
  `courseware_question_status` tinyint(1) NOT NULL DEFAULT '1',
  `courseware_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `courseware_time`
--

CREATE TABLE `courseware_time` (
  `courseware_time_id` int(20) NOT NULL,
  `courseware_time_time` varchar(255) NOT NULL,
  `grade_assessment_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `course_modules`
--

CREATE TABLE `course_modules` (
  `course_modules_id` int(20) NOT NULL,
  `course_modules_path` varchar(200) NOT NULL,
  `course_modules_name` text NOT NULL,
  `course_modules_status` tinyint(1) NOT NULL DEFAULT '1',
  `topic_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `data_scores`
--

CREATE TABLE `data_scores` (
  `data_scores_id` int(20) NOT NULL,
  `data_scores_type` tinyint(1) NOT NULL,
  `data_scores_score` int(45) NOT NULL,
  `data_scores_passing` int(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `enrollment_id` int(20) NOT NULL,
  `enrollment_sy` varchar(20) NOT NULL,
  `enrollment_term` tinyint(1) NOT NULL,
  `enrollment_is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fic`
--

CREATE TABLE `fic` (
  `fic_id` int(20) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `midname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(45) NOT NULL,
  `image_path` varchar(100) NOT NULL,
  `fic_department` varchar(5) NOT NULL,
  `fic_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `grade_assessment`
--

CREATE TABLE `grade_assessment` (
  `grade_assessment_id` int(20) NOT NULL,
  `grade_assessment_score` int(10) NOT NULL,
  `grade_assessment_total` int(10) NOT NULL,
  `student_id` int(20) NOT NULL,
  `courseware_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

CREATE TABLE `lecturer` (
  `lecturer_id` int(20) NOT NULL,
  `id_number` int(20) DEFAULT NULL,
  `firstname` varchar(45) NOT NULL,
  `midname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `lecturer_expertise` varchar(300) NOT NULL,
  `email` varchar(50) NOT NULL,
  `lecturer_status` tinyint(1) NOT NULL DEFAULT '0',
  `image_path` varchar(100) NOT NULL,
  `lecturer_is_confirm` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lecturer_feedback`
--

CREATE TABLE `lecturer_feedback` (
  `lecturer_feedback_id` int(20) NOT NULL,
  `lecturer_feedback_timedate` int(20) NOT NULL,
  `lecturer_feedback_comment` varchar(500) NOT NULL,
  `lecturer_feedback_department` varchar(5) NOT NULL,
  `student_id` int(20) NOT NULL,
  `lecturer_id` int(20) NOT NULL,
  `enrollment_id` int(20) NOT NULL,
  `offering_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `log_id` int(20) NOT NULL,
  `log_user_id` int(20) NOT NULL,
  `log_timedate` int(20) NOT NULL,
  `log_platform` tinyint(1) NOT NULL,
  `log_content_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `login_sessions`
--

CREATE TABLE `login_sessions` (
  `login_sessions_id` int(20) NOT NULL,
  `login_sessions_identifier` int(45) NOT NULL,
  `login_sessions_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `log_content`
--

CREATE TABLE `log_content` (
  `log_content_id` int(20) NOT NULL,
  `log_content_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `offering`
--

CREATE TABLE `offering` (
  `offering_id` int(20) NOT NULL,
  `offering_name` varchar(20) NOT NULL,
  `offering_department` varchar(5) NOT NULL,
  `course_id` int(20) NOT NULL,
  `fic_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `professor`
--

CREATE TABLE `professor` (
  `professor_id` int(20) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `midname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `professor_department` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image_path` varchar(100) NOT NULL,
  `professor_feedback_active` tinyint(1) NOT NULL DEFAULT '0',
  `professor_status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `remedial_coursewares`
--

CREATE TABLE `remedial_coursewares` (
  `remedial_coursewares_id` int(20) NOT NULL,
  `is_done` tinyint(1) NOT NULL DEFAULT '0',
  `student_scores_id` int(20) NOT NULL,
  `courseware_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `remedial_grade_assessment`
--

CREATE TABLE `remedial_grade_assessment` (
  `remedial_grade_assessment_id` int(20) NOT NULL,
  `remedial_grade_assessment_score` int(10) NOT NULL,
  `remedial_grade_assessment_total` int(10) NOT NULL,
  `remedial_grade_assessment_time` varchar(255) NOT NULL,
  `student_id` int(20) NOT NULL,
  `courseware_id` int(50) NOT NULL,
  `remedial_coursewares_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `remedial_student_answer`
--

CREATE TABLE `remedial_student_answer` (
  `remedial_student_answer_id` int(11) NOT NULL,
  `choice_is_correct` tinyint(1) NOT NULL DEFAULT '0',
  `courseware_question_id` int(20) NOT NULL,
  `choice_id` int(20) NOT NULL,
  `student_id` int(20) NOT NULL,
  `courseware_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` int(20) NOT NULL,
  `schedule_start_time` int(20) NOT NULL,
  `schedule_end_time` int(20) NOT NULL,
  `schedule_venue` varchar(20) NOT NULL,
  `lecturer_id` int(20) DEFAULT '999999999',
  `offering_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(20) NOT NULL,
  `student_num` int(10) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `midname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `student_department` varchar(10) NOT NULL,
  `image_path` varchar(100) NOT NULL,
  `student_is_blocked` tinyint(1) NOT NULL DEFAULT '0',
  `offering_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_answer`
--

CREATE TABLE `student_answer` (
  `student_answer_id` int(11) NOT NULL,
  `choice_is_correct` tinyint(1) NOT NULL DEFAULT '0',
  `courseware_question_id` int(20) NOT NULL,
  `choice_id` int(20) NOT NULL,
  `student_id` int(20) NOT NULL,
  `courseware_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_list`
--

CREATE TABLE `student_list` (
  `student_id` int(20) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `midname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `department` varchar(5) NOT NULL,
  `image_path` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_scores`
--

CREATE TABLE `student_scores` (
  `student_scores_id` int(20) NOT NULL,
  `student_scores_is_failed` tinyint(1) NOT NULL,
  `student_scores_score` int(45) NOT NULL,
  `student_scores_stud_num` int(10) NOT NULL,
  `student_scores_topic_id` varchar(45) NOT NULL,
  `course_id` int(20) NOT NULL,
  `data_scores_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(20) NOT NULL,
  `subject_name` text NOT NULL,
  `subject_description` text,
  `lecturer_id` int(20) DEFAULT NULL,
  `course_id` int(20) NOT NULL,
  `subject_list_id` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subject_list`
--

CREATE TABLE `subject_list` (
  `subject_list_id` int(20) NOT NULL,
  `subject_list_name` varchar(100) NOT NULL,
  `subject_list_department` varchar(5) NOT NULL,
  `subject_list_is_active` tinyint(1) NOT NULL,
  `subject_list_description` text,
  `year_level_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subject_list_has_topic_list`
--

CREATE TABLE `subject_list_has_topic_list` (
  `subject_list_id` int(20) NOT NULL,
  `topic_list_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE `topic` (
  `topic_id` int(50) NOT NULL,
  `topic_name` varchar(100) NOT NULL,
  `topic_description` text,
  `topic_done` tinyint(1) NOT NULL DEFAULT '0',
  `subject_id` int(20) NOT NULL,
  `topic_list_id` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `topic_list`
--

CREATE TABLE `topic_list` (
  `topic_list_id` int(20) NOT NULL,
  `topic_list_name` varchar(100) NOT NULL,
  `topic_list_is_active` tinyint(1) NOT NULL,
  `topic_list_description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `total_grade`
--

CREATE TABLE `total_grade` (
  `total_grade_id` int(11) NOT NULL,
  `total_grade_total` varchar(45) NOT NULL,
  `subject_id` int(20) NOT NULL,
  `student_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `year_level`
--

CREATE TABLE `year_level` (
  `year_level_id` int(20) NOT NULL,
  `year_level_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`activity_id`),
  ADD KEY `fk_activity_activity_details1_idx` (`activity_details_id`),
  ADD KEY `fk_activity_lecturer1_idx` (`lecturer_id`),
  ADD KEY `fk_activity_offering1_idx` (`offering_id`),
  ADD KEY `fk_activity_activity_schedule1_idx` (`activity_schedule_id`);

--
-- Indexes for table `activity_details`
--
ALTER TABLE `activity_details`
  ADD PRIMARY KEY (`activity_details_id`);

--
-- Indexes for table `activity_schedule`
--
ALTER TABLE `activity_schedule`
  ADD PRIMARY KEY (`activity_schedule_id`);

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
-- Indexes for table `attendance_in`
--
ALTER TABLE `attendance_in`
  ADD PRIMARY KEY (`attendance_in_id`),
  ADD KEY `fk_attendance_in_lecturer_attendance1_idx` (`lecturer_attendance_id`);

--
-- Indexes for table `attendance_out`
--
ALTER TABLE `attendance_out`
  ADD PRIMARY KEY (`attendance_out_id`),
  ADD KEY `fk_attendance_out_lecturer_attendance1_idx` (`lecturer_attendance_id`);

--
-- Indexes for table `choice`
--
ALTER TABLE `choice`
  ADD PRIMARY KEY (`choice_id`),
  ADD KEY `fk_choice_courseware_question1_idx` (`courseware_question_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `fk_comment_courseware_question1_idx` (`courseware_question_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `fk_offering_enrollment1_idx` (`enrollment_id`),
  ADD KEY `fk_offering_professor1_idx` (`professor_id`),
  ADD KEY `fk_course_year_level1_idx` (`year_level_id`);

--
-- Indexes for table `courseware`
--
ALTER TABLE `courseware`
  ADD PRIMARY KEY (`courseware_id`),
  ADD KEY `fk_courseware_topic1_idx` (`topic_id`);

--
-- Indexes for table `courseware_question`
--
ALTER TABLE `courseware_question`
  ADD PRIMARY KEY (`courseware_question_id`),
  ADD KEY `fk_courseware_question_courseware1_idx` (`courseware_id`);

--
-- Indexes for table `courseware_time`
--
ALTER TABLE `courseware_time`
  ADD PRIMARY KEY (`courseware_time_id`),
  ADD KEY `fk_courseware_time_grade_assessment1_idx` (`grade_assessment_id`);

--
-- Indexes for table `course_modules`
--
ALTER TABLE `course_modules`
  ADD PRIMARY KEY (`course_modules_id`),
  ADD KEY `fk_course_modules_topic1_idx` (`topic_id`);

--
-- Indexes for table `data_scores`
--
ALTER TABLE `data_scores`
  ADD PRIMARY KEY (`data_scores_id`);

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`enrollment_id`);

--
-- Indexes for table `fic`
--
ALTER TABLE `fic`
  ADD PRIMARY KEY (`fic_id`);

--
-- Indexes for table `grade_assessment`
--
ALTER TABLE `grade_assessment`
  ADD PRIMARY KEY (`grade_assessment_id`),
  ADD KEY `fk_grade_assessment_student1_idx` (`student_id`),
  ADD KEY `fk_grade_assessment_courseware1_idx` (`courseware_id`);

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
  ADD KEY `fk_lecturer_attendance_lecturer1_idx` (`lecturer_id`),
  ADD KEY `fk_lecturer_attendance_offering1_idx` (`offering_id`),
  ADD KEY `fk_lecturer_attendance_schedule1_idx` (`schedule_id`);

--
-- Indexes for table `lecturer_feedback`
--
ALTER TABLE `lecturer_feedback`
  ADD PRIMARY KEY (`lecturer_feedback_id`),
  ADD KEY `fk_lecturer_feedback_student1_idx` (`student_id`),
  ADD KEY `fk_lecturer_feedback_lecturer1_idx` (`lecturer_id`),
  ADD KEY `fk_lecturer_feedback_enrollment1_idx` (`enrollment_id`),
  ADD KEY `fk_lecturer_feedback_offering1_idx` (`offering_id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `fk_log_log_content1_idx` (`log_content_id`);

--
-- Indexes for table `login_sessions`
--
ALTER TABLE `login_sessions`
  ADD PRIMARY KEY (`login_sessions_id`);

--
-- Indexes for table `log_content`
--
ALTER TABLE `log_content`
  ADD PRIMARY KEY (`log_content_id`);

--
-- Indexes for table `offering`
--
ALTER TABLE `offering`
  ADD PRIMARY KEY (`offering_id`),
  ADD KEY `fk_offering_course1_idx` (`course_id`),
  ADD KEY `fk_offering_fic1_idx` (`fic_id`);

--
-- Indexes for table `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`professor_id`);

--
-- Indexes for table `remedial_coursewares`
--
ALTER TABLE `remedial_coursewares`
  ADD PRIMARY KEY (`remedial_coursewares_id`),
  ADD KEY `fk_remedial_coursewares_student_scores1_idx` (`student_scores_id`),
  ADD KEY `fk_remedial_coursewares_courseware1_idx` (`courseware_id`);

--
-- Indexes for table `remedial_grade_assessment`
--
ALTER TABLE `remedial_grade_assessment`
  ADD PRIMARY KEY (`remedial_grade_assessment_id`),
  ADD KEY `fk_grade_assessment_student1_idx` (`student_id`),
  ADD KEY `fk_grade_assessment_courseware1_idx` (`courseware_id`),
  ADD KEY `fk_remedial_grade_assessment_remedial_coursewares1_idx` (`remedial_coursewares_id`);

--
-- Indexes for table `remedial_student_answer`
--
ALTER TABLE `remedial_student_answer`
  ADD PRIMARY KEY (`remedial_student_answer_id`),
  ADD KEY `fk_student_answer_courseware_question1_idx` (`courseware_question_id`),
  ADD KEY `fk_student_answer_choice1_idx` (`choice_id`),
  ADD KEY `fk_student_answer_student1_idx` (`student_id`),
  ADD KEY `fk_student_answer_courseware1_idx` (`courseware_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `fk_schedule_lecturer1_idx` (`lecturer_id`),
  ADD KEY `fk_schedule_offering1_idx` (`offering_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `fk_student_offering1_idx` (`offering_id`);

--
-- Indexes for table `student_answer`
--
ALTER TABLE `student_answer`
  ADD PRIMARY KEY (`student_answer_id`),
  ADD KEY `fk_student_answer_courseware_question1_idx` (`courseware_question_id`),
  ADD KEY `fk_student_answer_choice1_idx` (`choice_id`),
  ADD KEY `fk_student_answer_student1_idx` (`student_id`),
  ADD KEY `fk_student_answer_courseware1_idx` (`courseware_id`);

--
-- Indexes for table `student_list`
--
ALTER TABLE `student_list`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `student_id_UNIQUE` (`student_id`);

--
-- Indexes for table `student_scores`
--
ALTER TABLE `student_scores`
  ADD PRIMARY KEY (`student_scores_id`),
  ADD KEY `fk_student_scores_course1_idx` (`course_id`),
  ADD KEY `fk_student_scores_data_scores1_idx` (`data_scores_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`),
  ADD KEY `fk_subject_lecturer1_idx` (`lecturer_id`),
  ADD KEY `fk_subject_course1_idx` (`course_id`),
  ADD KEY `fk_subject_subject_list1_idx` (`subject_list_id`);

--
-- Indexes for table `subject_list`
--
ALTER TABLE `subject_list`
  ADD PRIMARY KEY (`subject_list_id`),
  ADD KEY `fk_subject_list_year_level1_idx` (`year_level_id`);

--
-- Indexes for table `subject_list_has_topic_list`
--
ALTER TABLE `subject_list_has_topic_list`
  ADD PRIMARY KEY (`subject_list_id`,`topic_list_id`),
  ADD KEY `fk_subject_list_has_topic_list_topic_list1_idx` (`topic_list_id`),
  ADD KEY `fk_subject_list_has_topic_list_subject_list1_idx` (`subject_list_id`);

--
-- Indexes for table `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`topic_id`),
  ADD KEY `fk_topic_subject1_idx` (`subject_id`),
  ADD KEY `fk_topic_topic_list1_idx` (`topic_list_id`);

--
-- Indexes for table `topic_list`
--
ALTER TABLE `topic_list`
  ADD PRIMARY KEY (`topic_list_id`),
  ADD UNIQUE KEY `topic_list_name_UNIQUE` (`topic_list_name`);

--
-- Indexes for table `total_grade`
--
ALTER TABLE `total_grade`
  ADD PRIMARY KEY (`total_grade_id`),
  ADD KEY `fk_total_grade_subject1_idx` (`subject_id`),
  ADD KEY `fk_total_grade_student1_idx` (`student_id`);

--
-- Indexes for table `year_level`
--
ALTER TABLE `year_level`
  ADD PRIMARY KEY (`year_level_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `activity_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `activity_details`
--
ALTER TABLE `activity_details`
  MODIFY `activity_details_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `activity_schedule`
--
ALTER TABLE `activity_schedule`
  MODIFY `activity_schedule_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `announcement_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `choice`
--
ALTER TABLE `choice`
  MODIFY `choice_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courseware`
--
ALTER TABLE `courseware`
  MODIFY `courseware_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courseware_question`
--
ALTER TABLE `courseware_question`
  MODIFY `courseware_question_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courseware_time`
--
ALTER TABLE `courseware_time`
  MODIFY `courseware_time_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_modules`
--
ALTER TABLE `course_modules`
  MODIFY `course_modules_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_scores`
--
ALTER TABLE `data_scores`
  MODIFY `data_scores_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enrollment`
--
ALTER TABLE `enrollment`
  MODIFY `enrollment_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grade_assessment`
--
ALTER TABLE `grade_assessment`
  MODIFY `grade_assessment_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lecturer`
--
ALTER TABLE `lecturer`
  MODIFY `lecturer_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lecturer_feedback`
--
ALTER TABLE `lecturer_feedback`
  MODIFY `lecturer_feedback_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `log_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_sessions`
--
ALTER TABLE `login_sessions`
  MODIFY `login_sessions_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_content`
--
ALTER TABLE `log_content`
  MODIFY `log_content_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offering`
--
ALTER TABLE `offering`
  MODIFY `offering_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `remedial_coursewares`
--
ALTER TABLE `remedial_coursewares`
  MODIFY `remedial_coursewares_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `remedial_grade_assessment`
--
ALTER TABLE `remedial_grade_assessment`
  MODIFY `remedial_grade_assessment_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `remedial_student_answer`
--
ALTER TABLE `remedial_student_answer`
  MODIFY `remedial_student_answer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_answer`
--
ALTER TABLE `student_answer`
  MODIFY `student_answer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_scores`
--
ALTER TABLE `student_scores`
  MODIFY `student_scores_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subject_list`
--
ALTER TABLE `subject_list`
  MODIFY `subject_list_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `topic`
--
ALTER TABLE `topic`
  MODIFY `topic_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `topic_list`
--
ALTER TABLE `topic_list`
  MODIFY `topic_list_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `total_grade`
--
ALTER TABLE `total_grade`
  MODIFY `total_grade_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `year_level`
--
ALTER TABLE `year_level`
  MODIFY `year_level_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `fk_activity_activity_details1` FOREIGN KEY (`activity_details_id`) REFERENCES `activity_details` (`activity_details_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_activity_activity_schedule1` FOREIGN KEY (`activity_schedule_id`) REFERENCES `activity_schedule` (`activity_schedule_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_activity_lecturer1` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`lecturer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_activity_offering1` FOREIGN KEY (`offering_id`) REFERENCES `offering` (`offering_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `attendance_in`
--
ALTER TABLE `attendance_in`
  ADD CONSTRAINT `fk_attendance_in_lecturer_attendance1` FOREIGN KEY (`lecturer_attendance_id`) REFERENCES `lecturer_attendance` (`lecturer_attendance_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `attendance_out`
--
ALTER TABLE `attendance_out`
  ADD CONSTRAINT `fk_attendance_out_lecturer_attendance1` FOREIGN KEY (`lecturer_attendance_id`) REFERENCES `lecturer_attendance` (`lecturer_attendance_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `choice`
--
ALTER TABLE `choice`
  ADD CONSTRAINT `fk_choice_courseware_question1` FOREIGN KEY (`courseware_question_id`) REFERENCES `courseware_question` (`courseware_question_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_comment_courseware_question1` FOREIGN KEY (`courseware_question_id`) REFERENCES `courseware_question` (`courseware_question_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `fk_course_year_level1` FOREIGN KEY (`year_level_id`) REFERENCES `year_level` (`year_level_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_offering_enrollment1` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollment` (`enrollment_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_offering_professor1` FOREIGN KEY (`professor_id`) REFERENCES `professor` (`professor_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `courseware`
--
ALTER TABLE `courseware`
  ADD CONSTRAINT `fk_courseware_topic1` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`topic_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `courseware_question`
--
ALTER TABLE `courseware_question`
  ADD CONSTRAINT `fk_courseware_question_courseware1` FOREIGN KEY (`courseware_id`) REFERENCES `courseware` (`courseware_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `courseware_time`
--
ALTER TABLE `courseware_time`
  ADD CONSTRAINT `fk_courseware_time_grade_assessment1` FOREIGN KEY (`grade_assessment_id`) REFERENCES `grade_assessment` (`grade_assessment_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `course_modules`
--
ALTER TABLE `course_modules`
  ADD CONSTRAINT `fk_course_modules_topic1` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`topic_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `grade_assessment`
--
ALTER TABLE `grade_assessment`
  ADD CONSTRAINT `fk_grade_assessment_courseware1` FOREIGN KEY (`courseware_id`) REFERENCES `courseware` (`courseware_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_grade_assessment_student1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `lecturer_attendance`
--
ALTER TABLE `lecturer_attendance`
  ADD CONSTRAINT `fk_lecturer_attendance_lecturer1` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`lecturer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_lecturer_attendance_offering1` FOREIGN KEY (`offering_id`) REFERENCES `offering` (`offering_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_lecturer_attendance_schedule1` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`schedule_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `lecturer_feedback`
--
ALTER TABLE `lecturer_feedback`
  ADD CONSTRAINT `fk_lecturer_feedback_enrollment1` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollment` (`enrollment_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_lecturer_feedback_lecturer1` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`lecturer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_lecturer_feedback_offering1` FOREIGN KEY (`offering_id`) REFERENCES `offering` (`offering_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_lecturer_feedback_student1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `fk_log_log_content1` FOREIGN KEY (`log_content_id`) REFERENCES `log_content` (`log_content_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `offering`
--
ALTER TABLE `offering`
  ADD CONSTRAINT `fk_offering_course1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_offering_fic1` FOREIGN KEY (`fic_id`) REFERENCES `fic` (`fic_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `remedial_coursewares`
--
ALTER TABLE `remedial_coursewares`
  ADD CONSTRAINT `fk_remedial_coursewares_courseware1` FOREIGN KEY (`courseware_id`) REFERENCES `courseware` (`courseware_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_remedial_coursewares_student_scores1` FOREIGN KEY (`student_scores_id`) REFERENCES `student_scores` (`student_scores_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `remedial_grade_assessment`
--
ALTER TABLE `remedial_grade_assessment`
  ADD CONSTRAINT `fk_grade_assessment_courseware10` FOREIGN KEY (`courseware_id`) REFERENCES `courseware` (`courseware_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_grade_assessment_student10` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_remedial_grade_assessment_remedial_coursewares1` FOREIGN KEY (`remedial_coursewares_id`) REFERENCES `remedial_coursewares` (`remedial_coursewares_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `remedial_student_answer`
--
ALTER TABLE `remedial_student_answer`
  ADD CONSTRAINT `fk_student_answer_choice10` FOREIGN KEY (`choice_id`) REFERENCES `choice` (`choice_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_student_answer_courseware10` FOREIGN KEY (`courseware_id`) REFERENCES `courseware` (`courseware_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_student_answer_courseware_question10` FOREIGN KEY (`courseware_question_id`) REFERENCES `courseware_question` (`courseware_question_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_student_answer_student10` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `fk_schedule_lecturer1` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`lecturer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_schedule_offering1` FOREIGN KEY (`offering_id`) REFERENCES `offering` (`offering_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `fk_student_offering1` FOREIGN KEY (`offering_id`) REFERENCES `offering` (`offering_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `student_answer`
--
ALTER TABLE `student_answer`
  ADD CONSTRAINT `fk_student_answer_choice1` FOREIGN KEY (`choice_id`) REFERENCES `choice` (`choice_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_student_answer_courseware1` FOREIGN KEY (`courseware_id`) REFERENCES `courseware` (`courseware_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_student_answer_courseware_question1` FOREIGN KEY (`courseware_question_id`) REFERENCES `courseware_question` (`courseware_question_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_student_answer_student1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `student_scores`
--
ALTER TABLE `student_scores`
  ADD CONSTRAINT `fk_student_scores_course1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_student_scores_data_scores1` FOREIGN KEY (`data_scores_id`) REFERENCES `data_scores` (`data_scores_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `subject`
--
ALTER TABLE `subject`
  ADD CONSTRAINT `fk_subject_course1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_subject_lecturer1` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`lecturer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_subject_subject_list1` FOREIGN KEY (`subject_list_id`) REFERENCES `subject_list` (`subject_list_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `subject_list`
--
ALTER TABLE `subject_list`
  ADD CONSTRAINT `fk_subject_list_year_level1` FOREIGN KEY (`year_level_id`) REFERENCES `year_level` (`year_level_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `subject_list_has_topic_list`
--
ALTER TABLE `subject_list_has_topic_list`
  ADD CONSTRAINT `fk_subject_list_has_topic_list_subject_list1` FOREIGN KEY (`subject_list_id`) REFERENCES `subject_list` (`subject_list_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_subject_list_has_topic_list_topic_list1` FOREIGN KEY (`topic_list_id`) REFERENCES `topic_list` (`topic_list_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `topic`
--
ALTER TABLE `topic`
  ADD CONSTRAINT `fk_topic_subject1` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_topic_topic_list1` FOREIGN KEY (`topic_list_id`) REFERENCES `topic_list` (`topic_list_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `total_grade`
--
ALTER TABLE `total_grade`
  ADD CONSTRAINT `fk_total_grade_student1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_total_grade_subject1` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
