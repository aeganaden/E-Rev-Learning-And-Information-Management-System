-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2018 at 04:30 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

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

--
-- Dumping data for table `activity_details`
--

INSERT INTO `activity_details` (`activity_details_id`, `activity_details_name`) VALUES
(1, 'Lecture'),
(2, 'Seatwork'),
(3, 'Quiz'),
(4, 'Other');

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`, `firstname`, `midname`, `lastname`, `image_path`) VALUES
(999999999, 'admin', 'admin', 'admin', 'admin', 'admin', 'admin');

--
-- Dumping data for table `choice`
--

INSERT INTO `choice` (`choice_id`, `choice_choice`, `choice_is_answer`, `courseware_question_id`) VALUES
(1, '<p>True</p>', 0, 1),
(2, '<p>False</p>', 1, 1),
(3, '<p>True</p>', 0, 2),
(4, '<p>False</p>', 1, 2),
(5, '<p>True</p>', 0, 3),
(6, '<p>False</p>', 1, 3),
(7, '<p>True</p>', 0, 4),
(8, '<p>False</p>', 1, 4),
(9, '<p>True</p>', 0, 5),
(10, '<p>False</p>', 1, 5),
(11, '<p>True</p>', 0, 6),
(12, '<p>False</p>', 1, 6),
(13, '<p>True</p>', 0, 7),
(14, '<p>False</p>', 1, 7),
(15, '<p>True</p>', 0, 8),
(16, '<p>False</p>', 1, 8),
(17, '<p>True</p>', 0, 9),
(18, '<p>False</p>', 1, 9),
(19, '<p>True</p>', 0, 10),
(20, '<p>False</p>', 1, 10);

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_course_code`, `course_course_title`, `course_department`, `course_is_active`, `enrollment_id`, `professor_id`, `year_level_id`) VALUES
(1, 'CECORREL1', 'CE CORRELATION COURSE 1', 'CE', 1, 1, 201111111, 2),
(2, 'CECORREL2', 'CE CORRELATION COURSE 2', 'CE', 1, 1, 201111111, 3),
(3, 'MECORREL1', 'ME CORRELATION COURSE 1', 'ME', 1, 1, 201122222, 2),
(4, 'MECORREL2', 'ME CORRELATION COURSE 2', 'ME', 1, 1, 201122222, 3),
(5, 'ECECORREL1', 'ECE CORRELATION COURSE 1', 'ECE', 1, 1, 201133333, 2),
(6, 'ECECORREL2', 'ECE CORRELATION COURSE 2', 'ECE', 1, 1, 201133333, 3);

--
-- Dumping data for table `courseware`
--

INSERT INTO `courseware` (`courseware_id`, `courseware_name`, `courseware_description`, `courseware_date_added`, `courseware_date_edited`, `courseware_status`, `topic_id`) VALUES
(1, 'Algebra 1', 'algebra here', 1523086577, 1523086577, 1, 69),
(2, 'Plane and spherical geo 1', 'bla bla', 1523086998, 1523086998, 1, 70),
(3, 'Plane and spherical trigo', 'bla bla', 1523087012, 1523087012, 1, 70),
(4, 'plane and spherical trigo', 'bla bla', 1523087033, 1523087033, 1, 70),
(5, 'test trigo', 'hey', 1523087104, 1523087104, 1, 71);

--
-- Dumping data for table `courseware_question`
--

INSERT INTO `courseware_question` (`courseware_question_id`, `courseware_question_question`, `courseware_question_status`, `courseware_id`) VALUES
(1, '<div><p>trigo question 1</p>\n</div>', 1, 5),
(2, '<div><p>trigo question 2</p>\n</div>', 1, 5),
(3, '<div><p>geo question 1</p>\n</div>', 1, 2),
(4, '<div><p>geo question 2</p>\n</div>', 1, 2),
(5, '<div><p>algebra question 1</p>\n</div>', 1, 1),
(6, '<div><p>algebra question 2</p>\n</div>', 1, 1),
(7, '<div><p>geo question 3</p>\n</div>', 1, 3),
(8, '<div><p>geo question 4</p>\n</div>', 1, 3),
(9, '<div><p>geo question 5</p>\n</div>', 1, 4),
(10, '<div><p>geo question 6</p>\n</div>', 1, 4);

--
-- Dumping data for table `data_scores`
--

INSERT INTO `data_scores` (`data_scores_id`, `data_scores_type`, `data_scores_score`, `data_scores_passing`) VALUES
(1, 1, 30, 20),
(2, 1, 30, 20),
(3, 1, 40, 20);

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`enrollment_id`, `enrollment_sy`, `enrollment_term`, `enrollment_is_active`) VALUES
(1, '2018-2019', 1, 1);

--
-- Dumping data for table `fic`
--

INSERT INTO `fic` (`fic_id`, `firstname`, `midname`, `lastname`, `username`, `password`, `email`, `image_path`, `fic_department`, `fic_status`) VALUES
(201200001, 'Riza', 'Blossom', 'Malaya', 'cefic', 'cefic', 'rbmalaya@fit.edu.ph', 'assets/img/profiles/profile.jpg', 'CE', 1),
(201200002, 'Fabian', 'Javier ', 'Ladera', 'mefic', 'mefic', 'rbmalaya@fit.edu.ph', 'assets/img/profiles/profile.jpg', 'ME', 1),
(201200003, 'Monte', 'Jovany', 'Castillo', 'ecefic', 'ecefic', 'rbmalaya@fit.edu.ph', 'assets/img/profiles/profile.jpg', 'ECE', 1),
(201200004, 'Jack', 'Elvin', 'Manahan', 'eefic', 'eefic', 'rbmalaya@fit.edu.ph', 'assets/img/profiles/profile.jpg', 'EE', 1);

--
-- Dumping data for table `lecturer`
--

INSERT INTO `lecturer` (`lecturer_id`, `id_number`, `firstname`, `midname`, `lastname`, `lecturer_expertise`, `email`, `lecturer_status`, `image_path`, `lecturer_is_confirm`) VALUES
(1, 201011111, 'Omarion', 'Ampaso', 'Ramos', 'Basic and General Mathematics', 'ramos@gmail.com', 1, 'assets/img/profiles/profile.jpg', 1),
(2, 201022222, 'Timothy', 'Paz', 'Cabrera', 'Hydraulics Engineer', 'cabrera@gmail.com', 1, 'assets/img/profiles/profile.jpg', 1),
(3, 201033333, 'Steve', 'Sinagtala', 'Cordero', 'Engineering Economics', 'cordero@gmail.com', 1, 'assets/img/profiles/profile.jpg', 1),
(4, 201044444, 'Roland', 'Mikel', 'Canencia', 'Power and Industrial Plant Engineering', 'canencia@gmail.com', 1, 'assets/img/profiles/profile.jpg', 1),
(5, 201055555, 'Esmeralda', 'Choa', 'Aboitiz', 'Electrical Engineering Professional', 'aboitiz@gmail.com', 1, 'assets/img/profiles/profile.jpg', 1),
(6, 201066666, 'Carola', 'Magos', 'Amparo', 'Machine Design', 'amparo@gmail.com', 1, 'assets/img/profiles/profile.jpg', 1),
(7, 201077777, 'Magdalena', 'Francisco', 'Andrada', 'Electronics System', 'andrada@gmail.com', 1, 'assets/img/profiles/profile.jpg', 1),
(8, 201088888, 'Brisa', 'Cabigas', 'Lingao', 'General Engineering', 'lingao@gmail.com', 1, 'assets/img/profiles/profile.jpg', 1);

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`log_id`, `log_user_id`, `log_timedate`, `log_platform`, `log_content_id`) VALUES
(1, 201200003, 1523086498, 1, 1),
(2, 21, 1523087327, 1, 1),
(3, 201200003, 1523087388, 1, 1),
(4, 201200003, 1523089244, 1, 1),
(5, 21, 1523090890, 1, 1),
(6, 21, 1523090898, 1, 1),
(7, 23, 1523091175, 1, 1),
(8, 999999999, 1523974915, 1, 1),
(9, 201200001, 1523974923, 1, 1);

--
-- Dumping data for table `login_sessions`
--

INSERT INTO `login_sessions` (`login_sessions_id`, `login_sessions_identifier`, `login_sessions_status`) VALUES
(1, 201310584, 0),
(2, 201310584, 0),
(3, 201310584, 1),
(4, 201410367, 1);

--
-- Dumping data for table `log_content`
--

INSERT INTO `log_content` (`log_content_id`, `log_content_name`) VALUES
(1, 'Login'),
(2, 'Logout');

--
-- Dumping data for table `offering`
--

INSERT INTO `offering` (`offering_id`, `offering_name`, `offering_department`, `course_id`, `fic_id`) VALUES
(1, 'V21', 'CE', 1, 201200001),
(2, 'V22', 'CE', 1, 201200001),
(3, 'K21', 'ME', 3, 201200002),
(4, 'K22', 'ME', 3, 201200002),
(5, 'F21', 'ECE', 5, 201200003),
(6, 'F22', 'ECE', 5, 201200003);

--
-- Dumping data for table `professor`
--

INSERT INTO `professor` (`professor_id`, `firstname`, `midname`, `lastname`, `professor_department`, `email`, `username`, `password`, `image_path`, `professor_feedback_active`, `professor_status`) VALUES
(201111111, 'Juan Carlo', 'De Regla', 'Valencia', 'CE', 'jdvalencia@fit.edu.ph', 'ceprof', 'ceprof', 'assets/img/profiles/profile.jpg', 0, 1),
(201122222, 'Angelo Markus', 'Buan', 'Zaguirre', 'ME', 'abzaguirre@fit.edu.ph', 'meprof', 'meprof', 'assets/img/profiles/profile.jpg', 0, 1),
(201133333, 'Allen', 'Pogi', 'Torres', 'ECE', 'aptorres@fit.edu.ph', 'eceprof', 'eceprof', 'assets/img/profiles/profile.jpg', 0, 1),
(201144444, 'Ralph Adrian', 'Cute', 'Buen', 'EE', 'rbuen@fit.edu.ph', 'eeprof', 'eeprof', 'assets/img/profiles/profile.jpg', 0, 1);

--
-- Dumping data for table `remedial_coursewares`
--

INSERT INTO `remedial_coursewares` (`remedial_coursewares_id`, `is_done`, `student_scores_id`, `courseware_id`) VALUES
(1, 0, 1, 1),
(2, 0, 2, 2),
(3, 0, 7, 1);

--
-- Dumping data for table `remedial_grade_assessment`
--

INSERT INTO `remedial_grade_assessment` (`remedial_grade_assessment_id`, `remedial_grade_assessment_score`, `remedial_grade_assessment_total`, `remedial_grade_assessment_time`, `student_id`, `courseware_id`, `remedial_coursewares_id`) VALUES
(1, 0, 2, '00:00:13', 21, 1, 1),
(2, 1, 2, '00:00:08', 21, 1, 1);

--
-- Dumping data for table `remedial_student_answer`
--

INSERT INTO `remedial_student_answer` (`remedial_student_answer_id`, `choice_is_correct`, `courseware_question_id`, `choice_id`, `student_id`, `courseware_id`) VALUES
(1, 0, 5, 9, 21, 1),
(2, 0, 6, 11, 21, 1);

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `schedule_start_time`, `schedule_end_time`, `schedule_venue`, `lecturer_id`, `offering_id`) VALUES
(1, 1521414000, 1521421200, 'T607', 1, 1),
(2, 1521421200, 1521428400, 'T607', 1, 2),
(3, 1520895600, 1520902800, 'T607', 2, 3),
(4, 1520902800, 1520910000, 'T607', 2, 4),
(5, 1520982000, 1520989200, 'T607', 3, 5),
(6, 1520989200, 1520996400, 'T607', 3, 6);

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `student_num`, `firstname`, `midname`, `lastname`, `username`, `password`, `email`, `student_department`, `image_path`, `student_is_blocked`, `offering_id`) VALUES
(1, 201410679, 'NEHEMIAH', 'ONGTANGCO', 'BALUYUT', 'nobaluyut', 'nobaluyut', 'adre@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg', 0, 1),
(2, 201411491, 'BERNADETTE', 'ALCARAZ', 'ANGELES', 'baangeles', 'baangeles', 'adre@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg', 0, 1),
(3, 201411851, 'RYAN CARLO', 'GUNIO', 'BETON', 'rgbeton', 'rgbeton', 'adre@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg', 0, 1),
(4, 201511281, 'Mark Denver', 'Gatan', 'Babaran', 'mgbabaran', 'mark', 'mgbabaran@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg', 0, 1),
(5, 201511438, 'CHRISTIAN JOSEPH', 'BACULI', 'ADRE', 'cbadre', 'cbadre', 'adre@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg', 0, 1),
(6, 201410215, 'MIKE LUIS', 'AMIS', 'BOTE', 'mabote', 'mabote', 'adre@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg', 0, 2),
(7, 201410617, 'CARL', 'MAGNAYON', 'CASTRO', 'cmcastro', 'cmcastro', 'adre@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg', 0, 2),
(8, 201411823, 'AISLINN', 'TOQUERO', 'CASTRO', 'atcastro', 'atcastro', 'adre@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg', 0, 2),
(9, 201420096, 'SHIELA', 'PAZ', 'BUSTAMANTE', 'spbustamante', 'spbustamante', 'adre@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg', 0, 2),
(10, 201512590, 'VIRGILIO MIGUEL', 'ZORNOSA', 'CASTELO IV', 'vzcastelo', 'vzcastelo', 'adre@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg', 0, 2),
(11, 201311355, 'JUSTIN', 'BRUN', 'NEBRIJA', 'BRUN', 'BRUN', 'BRUN@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg', 0, 3),
(12, 201311694, 'JOHN HENRY', 'BELLO', 'SABAN', 'BELLO', 'BELLO', 'BELLO@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg', 0, 3),
(13, 201412123, 'WILLIAM', 'BUENAVENTURA', 'GENESE', 'BUENAVENTURA', 'BUENAVENTURA', 'BUENAVENTURA@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg', 0, 3),
(14, 201412338, 'CARL GERARD', 'CADIZ', 'FLORENDO', 'CADIZ', 'CADIZ', 'CADIZ@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg', 0, 3),
(15, 201420066, 'ROBERT IAN', 'CABRAL', 'DE LEON', 'CABRAL', 'CABRAL', 'CABRAL@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg', 0, 3),
(16, 201210843, 'DALE PATRICK', 'LANUZO', 'TOLENTINO', 'LANUZO', 'LANUZO', 'LANUZO@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg', 0, 4),
(17, 201410704, 'VEA DENISSE', 'CUEVAS', 'LITAN', 'CUEVAS', 'CUEVAS', 'CUEVAS@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg', 0, 4),
(18, 201410821, 'SHAIRA MAE', 'COSTALES', 'BUNAO', 'COSTALES', 'COSTALES', 'COSTALES@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg', 0, 4),
(19, 201412224, 'ROGER', 'CAJES JR.', 'DATALIO', 'CAJES JR.', 'CAJES JR.', 'CAJES JR.@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg', 0, 4),
(20, 201412670, 'PAUL DERICK', 'ENRIQUEZ', 'NOCHE', 'ENRIQUEZ', 'ENRIQUEZ', 'ENRIQUEZ@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg', 0, 4),
(21, 201310584, 'BRIAN PAUL', 'ANDAYA', 'MARTINEZ', 'ANDAYA', 'ANDAYA', 'ANDAYA@fit.edu.ph', 'ECE', 'assets/img/profiles/profile.jpg', 1, 5),
(22, 201310916, 'JOSE GABRIEL', 'QUEDDENG', 'SUÑGA', 'QUEDDENG', 'QUEDDENG', 'QUEDDENG@fit.edu.ph', 'ECE', 'assets/img/profiles/profile.jpg', 0, 5),
(23, 201410367, 'JENNY LIZA', 'SUNGA', 'BATALLA', 'SUNGA', 'SUNGA', 'SUNGA@fit.edu.ph', 'ECE', 'assets/img/profiles/profile.jpg', 1, 5),
(24, 201512691, 'MARCO JERIC', 'ROSALES', 'NAVARRO', 'ROSALES', 'ROSALES', 'ROSALES@fit.edu.ph', 'ECE', 'assets/img/profiles/profile.jpg', 0, 5),
(25, 201710117, 'HARRY MILLE', 'ANG', 'WANG', 'ANG', 'ANG', 'ANG@fit.edu.ph', 'ECE', 'assets/img/profiles/profile.jpg', 0, 5);

--
-- Dumping data for table `student_list`
--

INSERT INTO `student_list` (`student_id`, `firstname`, `midname`, `lastname`, `username`, `password`, `email`, `department`, `image_path`) VALUES
(201011240, 'MARLON', 'MACABENTA', 'TANGHAL', 'MACABENTA', 'MACABENTA', 'MACABENTA@fit.edu.ph', 'EE', 'assets/img/profiles/profile.jpg'),
(201011434, 'JOHN MICHAEL', 'SANTOS', 'CATURA', 'SANTOS', 'SANTOS', 'SANTOS@fit.edu.ph', 'EE', 'assets/img/profiles/profile.jpg'),
(201111222, 'JOSEF ANGELO', 'TU', 'FRANCISCO', 'TU', 'TU', 'TU@fit.edu.ph', 'EE', 'assets/img/profiles/profile.jpg'),
(201210843, 'DALE PATRICK', 'LANUZO', 'TOLENTINO', 'LANUZO', 'LANUZO', 'LANUZO@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg'),
(201230137, 'GELLY ANN', 'MATA', 'FRANCISCO', 'MATA', 'MATA', 'MATA@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg'),
(201310584, 'BRIAN PAUL', 'ANDAYA', 'MARTINEZ', 'ANDAYA', 'ANDAYA', 'ANDAYA@fit.edu.ph', 'ECE', 'assets/img/profiles/profile.jpg'),
(201310916, 'JOSE GABRIEL', 'QUEDDENG', 'SUÑGA', 'QUEDDENG', 'QUEDDENG', 'QUEDDENG@fit.edu.ph', 'ECE', 'assets/img/profiles/profile.jpg'),
(201311355, 'JUSTIN', 'BRUN', 'NEBRIJA', 'BRUN', 'BRUN', 'BRUN@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg'),
(201311694, 'JOHN HENRY', 'BELLO', 'SABAN', 'BELLO', 'BELLO', 'BELLO@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg'),
(201410215, 'MIKE LUIS', 'AMIS', 'BOTE', 'mabote', 'mabote', 'adre@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg'),
(201410367, 'JENNY LIZA', 'SUNGA', 'BATALLA', 'SUNGA', 'SUNGA', 'SUNGA@fit.edu.ph', 'ECE', 'assets/img/profiles/profile.jpg'),
(201410617, 'CARL', 'MAGNAYON', 'CASTRO', 'cmcastro', 'cmcastro', 'adre@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg'),
(201410679, 'NEHEMIAH', 'ONGTANGCO', 'BALUYUT', 'nobaluyut', 'nobaluyut', 'adre@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg'),
(201410704, 'VEA DENISSE', 'CUEVAS', 'LITAN', 'CUEVAS', 'CUEVAS', 'CUEVAS@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg'),
(201410821, 'SHAIRA MAE', 'COSTALES', 'BUNAO', 'COSTALES', 'COSTALES', 'COSTALES@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg'),
(201410881, 'ROMAR', 'SALERA', 'CONCEPCION', 'rsconcepcion', 'rsconcepcion', 'adre@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg'),
(201410901, 'ANGELENE ROCEL', 'LAUNIO', 'BACAYLAN', 'LAUNIO', 'LAUNIO', 'LAUNIO@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg'),
(201410941, 'PAOLO GIO', 'MENDIOLA', 'MARTINEZ', 'MENDIOLA', 'MENDIOLA', 'MENDIOLA@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg'),
(201411107, 'KESIAH MAE', 'MIGUEL', 'CARDONA', 'MIGUEL', 'MIGUEL', 'MIGUEL@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg'),
(201411266, 'KENNETH ROGER', 'PANTALEON', 'PANALIGAN', 'PANTALEON', 'PANTALEON', 'PANTALEON@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg'),
(201411491, 'BERNADETTE', 'ALCARAZ', 'ANGELES', 'baangeles', 'baangeles', 'adre@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg'),
(201411736, 'MICHAEL', 'ANCHETA', 'LAJERA', 'ANCHETA', 'ANCHETA', 'ANCHETA@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg'),
(201411823, 'AISLINN', 'TOQUERO', 'CASTRO', 'atcastro', 'atcastro', 'adre@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg'),
(201411851, 'RYAN CARLO', 'GUNIO', 'BETON', 'rgbeton', 'rgbeton', 'adre@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg'),
(201412123, 'WILLIAM', 'BUENAVENTURA', 'GENESE', 'BUENAVENTURA', 'BUENAVENTURA', 'BUENAVENTURA@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg'),
(201412224, 'ROGER', 'CAJES JR.', 'DATALIO', 'CAJES JR.', 'CAJES JR.', 'CAJES JR.@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg'),
(201412315, 'JOHN VENN', 'PERANDO', 'MANTALA', 'PERANDO', 'PERANDO', 'PERANDO@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg'),
(201412338, 'CARL GERARD', 'CADIZ', 'FLORENDO', 'CADIZ', 'CADIZ', 'CADIZ@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg'),
(201412670, 'PAUL DERICK', 'ENRIQUEZ', 'NOCHE', 'ENRIQUEZ', 'ENRIQUEZ', 'ENRIQUEZ@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg'),
(201412671, 'ARLYN GAEL', 'MURILLO', 'MABUTAS', 'MURILLO', 'MURILLO', 'MURILLO@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg'),
(201412795, 'KEN NICOLE', 'SESE', 'AGUIRRE', 'SESE', 'SESE', 'SESE@fit.edu.ph', 'EE', 'assets/img/profiles/profile.jpg'),
(201420024, 'RAUL REXOR', 'PIOQUINTO', 'ROSARIO', 'PIOQUINTO', 'PIOQUINTO', 'PIOQUINTO@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg'),
(201420066, 'ROBERT IAN', 'CABRAL', 'DE LEON', 'CABRAL', 'CABRAL', 'CABRAL@fit.edu.ph', 'ME', 'assets/img/profiles/profile.jpg'),
(201420096, 'SHIELA', 'PAZ', 'BUSTAMANTE', 'spbustamante', 'spbustamante', 'adre@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg'),
(201510186, 'MARK JOSEPH', 'GULTIANO', 'ASCAN', 'mgascan', 'mgascan', 'adre@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg'),
(201510573, 'LOUIS DAREL', 'VIDANES', 'ANIEVAS', 'lvanievas', 'lvanievas', 'adre@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg'),
(201510652, 'KEVIN', 'RAMOS', 'ACHACOSO', 'krachacoso', 'krachacoso', 'adre@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg'),
(201511230, 'JULIUS RODNI', 'FESTIN', 'AHORRO', 'jfahorro', 'jfahorro', 'adre@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg'),
(201511281, 'Mark Denver', 'Gatan', 'Babaran', 'mgbabaran', 'mark', 'mgbabaran@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg'),
(201511438, 'CHRISTIAN JOSEPH', 'BACULI', 'ADRE', 'cbadre', 'cbadre', 'adre@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg'),
(201511911, 'KASIAN PAUL', 'CALIXTRO', 'ALFONSO', 'kcalfonso', 'kcalfonso', 'adre@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg'),
(201512068, 'KIMPEE COSUHING', 'MASAGCA', 'ABOROT', 'kmaborot', 'kmaborot', 'adre@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg'),
(201512491, 'JUNAID', 'TAGO', 'ABUBACAR', 'jtabubacar', 'jtabubacar', 'adre@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg'),
(201512532, 'RESHMA', 'VIDAL', 'AREVALO', 'rvarevalo', 'rvarevalo', 'adre@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg'),
(201512590, 'VIRGILIO MIGUEL', 'ZORNOSA', 'CASTELO IV', 'vzcastelo', 'vzcastelo', 'adre@fit.edu.ph', 'CE', 'assets/img/profiles/profile.jpg'),
(201512691, 'MARCO JERIC', 'ROSALES', 'NAVARRO', 'ROSALES', 'ROSALES', 'ROSALES@fit.edu.ph', 'ECE', 'assets/img/profiles/profile.jpg'),
(201710002, 'JEMARSON', 'TIU', 'BERNADINO', 'TIU', 'TIU', 'TIU@fit.edu.ph', 'EE', 'assets/img/profiles/profile.jpg'),
(201710019, 'ALAIN VINCENT', 'MINDAÑA', 'ELIZAGA', 'MINDAÑA', 'MINDAÑA', 'MINDAÑA@fit.edu.ph', 'EE', 'assets/img/profiles/profile.jpg'),
(201710020, 'DAIAN', 'VILLA', 'ELIZAGA', 'VILLA', 'VILLA', 'VILLA@fit.edu.ph', 'EE', 'assets/img/profiles/profile.jpg'),
(201710032, 'JOSE PAOLO', 'FRANCISCO', 'GONZALES', 'FRANCISCO', 'FRANCISCO', 'FRANCISCO@fit.edu.ph', 'ECE', 'assets/img/profiles/profile.jpg'),
(201710040, 'BENJAMIN', 'CORTINA III', 'FROYALDE', 'CORTINA III', 'CORTINA III', 'CORTINA III@fit.edu.ph', 'ECE', 'assets/img/profiles/profile.jpg'),
(201710042, 'DARYL', 'GUZMAN', 'GARCIA', 'GUZMAN', 'GUZMAN', 'GUZMAN@fit.edu.ph', 'ECE', 'assets/img/profiles/profile.jpg'),
(201710050, 'APPLE JOY', 'OBENARIO', 'CASUNDIN', 'OBENARIO', 'OBENARIO', 'OBENARIO@fit.edu.ph', 'EE', 'assets/img/profiles/profile.jpg'),
(201710054, 'FERDINAND GABRIEL', 'PERALTA', 'ALHAMBRA', 'PERALTA', 'PERALTA', 'PERALTA@fit.edu.ph', 'EE', 'assets/img/profiles/profile.jpg'),
(201710057, 'PEACHY ANNE', 'FELICIANO', 'TIGLAO', 'FELICIANO', 'FELICIANO', 'FELICIANO@fit.edu.ph', 'ECE', 'assets/img/profiles/profile.jpg'),
(201710074, 'MARK JOHNNEL', 'BALEN', 'ALORO', 'BALEN', 'BALEN', 'BALEN@fit.edu.ph', 'ECE', 'assets/img/profiles/profile.jpg'),
(201710076, 'ANSLEY JANSON', 'YANGA', 'DELA CRUZ', 'YANGA', 'YANGA', 'YANGA@fit.edu.ph', 'EE', 'assets/img/profiles/profile.jpg'),
(201710100, 'DARRYLL D`WAYNE', 'BUSTILLOS', 'CUSTAN', 'BUSTILLOS', 'BUSTILLOS', 'BUSTILLOS@fit.edu.ph', 'ECE', 'assets/img/profiles/profile.jpg'),
(201710117, 'HARRY MILLE', 'ANG', 'WANG', 'ANG', 'ANG', 'ANG@fit.edu.ph', 'ECE', 'assets/img/profiles/profile.jpg'),
(201710152, 'OTHIEL MARK', 'ENRIJO', 'PRIETO', 'ENRIJO', 'ENRIJO', 'ENRIJO@fit.edu.ph', 'ECE', 'assets/img/profiles/profile.jpg'),
(201710174, 'JAN LESTER', 'QUINTOS', 'TORRES', 'QUINTOS', 'QUINTOS', 'QUINTOS@fit.edu.ph', 'EE', 'assets/img/profiles/profile.jpg'),
(201710221, 'GABRIEL', 'DELA FUENTE', 'VARGAS', 'DELA FUENTE', 'DELA FUENTE', 'DELA FUENTE@fit.edu.ph', 'ECE', 'assets/img/profiles/profile.jpg'),
(201710258, 'MARK JOSEPH', 'DELOS REYES', 'GARCIA', 'DELOS REYES', 'DELOS REYES', 'DELOS REYES@fit.edu.ph', 'ECE', 'assets/img/profiles/profile.jpg'),
(201710260, 'POJUER KENNETH', 'REYES IV', 'CABALLES', 'REYES IV', 'REYES IV', 'REYES IV@fit.edu.ph', 'EE', 'assets/img/profiles/profile.jpg'),
(201710338, 'GERSHOM NORMAN', 'MONTES', 'AJEDO', 'MONTES', 'MONTES', 'MONTES@fit.edu.ph', 'EE', 'assets/img/profiles/profile.jpg'),
(201710341, 'JOHN MCLEIGH', 'YOTOKO', 'REYNOSA', 'YOTOKO', 'YOTOKO', 'YOTOKO@fit.edu.ph', 'EE', 'assets/img/profiles/profile.jpg'),
(201710347, 'BRIAN', 'MAGADIA', 'CAPISTRANO', 'MAGADIA', 'MAGADIA', 'MAGADIA@fit.edu.ph', 'EE', 'assets/img/profiles/profile.jpg'),
(201710362, 'GABRIEL LUIS', 'MARCELO', 'ENRIQUEZ', 'MARCELO', 'MARCELO', 'MARCELO@fit.edu.ph', 'EE', 'assets/img/profiles/profile.jpg'),
(201710365, 'BYEONGJO', 'KIM', 'KIM', 'KIM', 'KIM', 'KIM@fit.edu.ph', 'EE', 'assets/img/profiles/profile.jpg'),
(201710368, 'MARIE SHEILA', 'MARTIN', 'MALACAD', 'MARTIN', 'MARTIN', 'MARTIN@fit.edu.ph', 'EE', 'assets/img/profiles/profile.jpg'),
(201710384, 'JOAN STEPHEN', 'PAZ', 'DUQUE', 'PAZ', 'PAZ', 'PAZ@fit.edu.ph', 'EE', 'assets/img/profiles/profile.jpg'),
(201710400, 'KHALED', 'HASANEIN', 'SORIANO', 'HASANEIN', 'HASANEIN', 'HASANEIN@fit.edu.ph', 'ECE', 'assets/img/profiles/profile.jpg'),
(201710405, 'DALE', 'POLICARPIO', 'REGOSO', 'POLICARPIO', 'POLICARPIO', 'POLICARPIO@fit.edu.ph', 'EE', 'assets/img/profiles/profile.jpg'),
(201710424, 'HANS PETER KARL', 'BRUNNER', 'FERRERA', 'BRUNNER', 'BRUNNER', 'BRUNNER@fit.edu.ph', 'ECE', 'assets/img/profiles/profile.jpg'),
(201710447, 'MARTIN DAVE', 'BADINAS', 'TOBIAS', 'BADINAS', 'BADINAS', 'BADINAS@fit.edu.ph', 'ECE', 'assets/img/profiles/profile.jpg'),
(201710453, 'QAEDA VENETT', 'CINCO', 'CRUZ', 'CINCO', 'CINCO', 'CINCO@fit.edu.ph', 'ECE', 'assets/img/profiles/profile.jpg'),
(201710458, 'SAMI', 'IBRAHIM', 'YOUSUF', 'IBRAHIM', 'IBRAHIM', 'IBRAHIM@fit.edu.ph', 'ECE', 'assets/img/profiles/profile.jpg');

--
-- Dumping data for table `student_scores`
--

INSERT INTO `student_scores` (`student_scores_id`, `student_scores_is_failed`, `student_scores_score`, `student_scores_stud_num`, `student_scores_topic_id`, `course_id`, `data_scores_id`) VALUES
(1, 1, 19, 201310584, '69', 5, 1),
(2, 1, 10, 201310584, '70', 5, 2),
(3, 0, 21, 201310584, '71', 5, 3),
(4, 0, 29, 201310916, '69', 5, 1),
(5, 0, 29, 201310916, '70', 5, 2),
(6, 0, 27, 201310916, '71', 5, 3),
(7, 1, 9, 201410367, '69', 5, 1),
(8, 0, 29, 201410367, '70', 5, 2),
(9, 0, 40, 201410367, '71', 5, 3),
(10, 0, 20, 201512691, '69', 5, 1),
(11, 0, 30, 201512691, '70', 5, 2),
(12, 0, 39, 201512691, '71', 5, 3),
(13, 0, 21, 201710117, '69', 5, 1),
(14, 0, 30, 201710117, '70', 5, 2),
(15, 0, 39, 201710117, '71', 5, 3);

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `subject_name`, `subject_description`, `lecturer_id`, `course_id`, `subject_list_id`) VALUES
(1, 'MATHEMATICS, SURVEYING AND TRANSPORTATION ENGINEERING', 'This subject area is exclusive for CE department', 1, 1, 1),
(2, 'MATHEMATICS, SURVEYING AND TRANSPORTATION ENGINEERING', 'This subject area is exclusive for CE department', NULL, 2, 2),
(3, 'HYDRAULICS AND GEOTECHNICAL ENGINEERING', 'This subject area is exclusive for CE department', NULL, 2, 4),
(4, 'MATHEMATICS, ENGINEERING ECONOMICS AND BASIC ENGINEERING SCIENCES', 'This subject area is exclusive for ME department', 2, 3, 21),
(5, 'MATHEMATICS, ENGINEERING ECONOMICS AND BASIC ENGINEERING SCIENCES', 'This subject area is exclusive for ME department', NULL, 4, 22),
(6, 'MACHINE DESIGN, MATERIALS, AND SHOP PRACTICE', 'This subject area is exclusive for ME department', NULL, 4, 24),
(7, 'MATHEMATICS', 'This subject area is exclusive for ECE department', 3, 5, 13),
(8, 'MATHEMATICS', 'This subject area is exclusive for ECE department', NULL, 6, 14),
(9, 'ELECTRONICS ENGINEERING', 'This subject area is exclusive for ECE department', NULL, 6, 16),
(10, 'GENERAL ENGINEERING AND APPLIED SCIENCES', 'This subject area is exclusive for ECE department', NULL, 6, 18);

--
-- Dumping data for table `subject_list`
--

INSERT INTO `subject_list` (`subject_list_id`, `subject_list_name`, `subject_list_department`, `subject_list_is_active`, `subject_list_description`, `year_level_id`) VALUES
(1, 'MATHEMATICS, SURVEYING AND TRANSPORTATION ENGINEERING', 'CE', 1, NULL, 2),
(2, 'MATHEMATICS, SURVEYING AND TRANSPORTATION ENGINEERING', 'CE', 1, NULL, 3),
(3, 'MATHEMATICS, SURVEYING AND TRANSPORTATION ENGINEERING', 'CE', 1, NULL, 5),
(4, 'HYDRAULICS AND GEOTECHNICAL ENGINEERING', 'CE', 1, NULL, 3),
(5, 'HYDRAULICS AND GEOTECHNICAL ENGINEERING', 'CE', 1, NULL, 5),
(6, 'STRUCTURAL ENGINEERING AND CONSTRUCTION', 'CE', 1, NULL, 5),
(7, 'MATHEMATICS', 'EE', 1, NULL, 2),
(8, 'MATHEMATICS', 'EE', 1, NULL, 3),
(9, 'MATHEMATICS', 'EE', 1, NULL, 5),
(10, 'ELECTRICAL ENGINEERING PROFESSIONAL SUBJECTS', 'EE', 1, NULL, 3),
(11, 'ELECTRICAL ENGINEERING PROFESSIONAL SUBJECTS', 'EE', 1, NULL, 5),
(12, 'ENGINEERING SCIENCES AND ALLIED SUBJECTS', 'EE', 1, NULL, 5),
(13, 'MATHEMATICS', 'ECE', 1, NULL, 2),
(14, 'MATHEMATICS', 'ECE', 1, NULL, 3),
(15, 'MATHEMATICS', 'ECE', 1, NULL, 5),
(16, 'ELECTRONICS ENGINEERING', 'ECE', 1, NULL, 3),
(17, 'ELECTRONICS ENGINEERING', 'ECE', 1, NULL, 5),
(18, 'GENERAL ENGINEERING AND APPLIED SCIENCES', 'ECE', 1, NULL, 3),
(19, 'GENERAL ENGINEERING AND APPLIED SCIENCES', 'ECE', 1, NULL, 5),
(20, 'ELECTRONICS SYSTEMS AND TECHNOLOGIES', 'ECE', 1, NULL, 5),
(21, 'MATHEMATICS, ENGINEERING ECONOMICS AND BASIC ENGINEERING SCIENCES', 'ME', 1, NULL, 2),
(22, 'MATHEMATICS, ENGINEERING ECONOMICS AND BASIC ENGINEERING SCIENCES', 'ME', 1, NULL, 3),
(23, 'MATHEMATICS, ENGINEERING ECONOMICS AND BASIC ENGINEERING SCIENCES', 'ME', 1, NULL, 5),
(24, 'MACHINE DESIGN, MATERIALS, AND SHOP PRACTICE', 'ME', 1, NULL, 3),
(25, 'MACHINE DESIGN, MATERIALS, AND SHOP PRACTICE', 'ME', 1, NULL, 5),
(26, 'POWER AND INDUSTRIAL PLANT ENGINEERING', 'ME', 1, NULL, 5);

--
-- Dumping data for table `subject_list_has_topic_list`
--

INSERT INTO `subject_list_has_topic_list` (`subject_list_id`, `topic_list_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(2, 9),
(2, 10),
(2, 11),
(2, 12),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(3, 6),
(3, 7),
(3, 8),
(3, 9),
(3, 10),
(3, 11),
(3, 12),
(4, 13),
(4, 14),
(4, 15),
(4, 16),
(4, 17),
(4, 18),
(4, 19),
(4, 20),
(4, 21),
(4, 22),
(4, 23),
(4, 24),
(5, 13),
(5, 14),
(5, 15),
(5, 16),
(5, 17),
(5, 18),
(5, 19),
(5, 20),
(5, 21),
(5, 22),
(5, 23),
(5, 24),
(6, 25),
(6, 26),
(6, 27),
(6, 28),
(6, 29),
(6, 30),
(6, 31),
(6, 32),
(6, 33),
(7, 1),
(7, 2),
(7, 3),
(7, 4),
(7, 5),
(7, 6),
(7, 7),
(7, 34),
(7, 35),
(7, 36),
(7, 37),
(8, 1),
(8, 2),
(8, 3),
(8, 4),
(8, 5),
(8, 6),
(8, 7),
(8, 34),
(8, 35),
(8, 36),
(8, 37),
(9, 1),
(9, 2),
(9, 3),
(9, 4),
(9, 5),
(9, 6),
(9, 7),
(9, 34),
(9, 35),
(9, 36),
(9, 37),
(10, 38),
(10, 39),
(10, 40),
(10, 41),
(10, 42),
(10, 43),
(10, 44),
(10, 45),
(10, 46),
(11, 38),
(11, 39),
(11, 40),
(11, 41),
(11, 42),
(11, 43),
(11, 44),
(11, 45),
(11, 46),
(12, 47),
(12, 48),
(12, 49),
(12, 50),
(12, 51),
(12, 52),
(12, 53),
(12, 54),
(12, 55),
(12, 56),
(12, 57),
(13, 1),
(13, 2),
(13, 3),
(13, 4),
(13, 5),
(13, 6),
(13, 7),
(13, 34),
(13, 35),
(13, 36),
(13, 37),
(14, 1),
(14, 2),
(14, 3),
(14, 4),
(14, 5),
(14, 6),
(14, 7),
(14, 34),
(14, 35),
(14, 36),
(14, 37),
(15, 1),
(15, 2),
(15, 3),
(15, 4),
(15, 5),
(15, 6),
(15, 7),
(15, 34),
(15, 35),
(15, 36),
(15, 37),
(16, 38),
(16, 39),
(16, 40),
(16, 58),
(16, 59),
(17, 38),
(17, 39),
(17, 40),
(17, 58),
(17, 59),
(18, 60),
(18, 61),
(18, 62),
(18, 63),
(18, 64),
(18, 65),
(18, 66),
(19, 60),
(19, 61),
(19, 62),
(19, 63),
(19, 64),
(19, 65),
(19, 66),
(20, 67),
(20, 68),
(20, 69),
(20, 70),
(20, 71),
(20, 72),
(20, 73),
(21, 1),
(21, 4),
(21, 5),
(21, 6),
(21, 7),
(21, 34),
(21, 35),
(21, 36),
(21, 37),
(21, 74),
(21, 75),
(21, 76),
(22, 1),
(22, 4),
(22, 5),
(22, 6),
(22, 7),
(22, 34),
(22, 35),
(22, 36),
(22, 37),
(22, 74),
(22, 75),
(22, 76),
(23, 1),
(23, 4),
(23, 5),
(23, 6),
(23, 7),
(23, 34),
(23, 35),
(23, 36),
(23, 37),
(23, 74),
(23, 75),
(23, 76),
(24, 39),
(24, 40),
(24, 42),
(24, 77),
(24, 78),
(24, 79),
(24, 80),
(24, 81),
(25, 39),
(25, 40),
(25, 42),
(25, 77),
(25, 78),
(25, 79),
(25, 80),
(25, 81),
(26, 82),
(26, 83),
(26, 84),
(26, 85),
(26, 86),
(26, 87),
(26, 88),
(26, 89);

--
-- Dumping data for table `topic`
--

INSERT INTO `topic` (`topic_id`, `topic_name`, `topic_description`, `topic_done`, `subject_id`, `topic_list_id`) VALUES
(1, 'Algebra', 'This is Algebra', 0, 1, 1),
(2, 'Plane and Spherical Geometry', 'This is Plane and Spherical Geometry', 0, 1, 2),
(3, 'Plane and Spherical Trigo', 'This is Plane and Spherical Trigo', 0, 1, 3),
(4, 'Analytic Geometry', 'This is Analytic Geometry', 0, 1, 4),
(5, 'Differential Calculus', 'This is Differential Calculus', 0, 1, 5),
(6, 'Integral Calculus', 'This is Integral Calculus', 0, 1, 6),
(7, 'Differential Equation', 'This is Differential Equation', 0, 1, 7),
(8, 'Probability', 'This is Probability', 0, 1, 8),
(9, 'Economy', 'This is Economy', 0, 1, 9),
(10, 'Survey 1', 'This is Survey 1', 0, 1, 10),
(11, 'Survey 2', 'This is Survey 2', 0, 1, 11),
(12, 'Survey 3', 'This is Survey 3', 0, 1, 12),
(13, 'Algebra', 'This is Algebra', 0, 2, 1),
(14, 'Plane and Spherical Geometry', 'This is Plane and Spherical Geometry', 0, 2, 2),
(15, 'Plane and Spherical Trigo', 'This is Plane and Spherical Trigo', 0, 2, 3),
(16, 'Analytic Geometry', 'This is Analytic Geometry', 0, 2, 4),
(17, 'Differential Calculus', 'This is Differential Calculus', 0, 2, 5),
(18, 'Integral Calculus', 'This is Integral Calculus', 0, 2, 6),
(19, 'Differential Equation', 'This is Differential Equation', 0, 2, 7),
(20, 'Probability', 'This is Probability', 0, 2, 8),
(21, 'Economy', 'This is Economy', 0, 2, 9),
(22, 'Survey 1', 'This is Survey 1', 0, 2, 10),
(23, 'Survey 2', 'This is Survey 2', 0, 2, 11),
(24, 'Survey 3', 'This is Survey 3', 0, 2, 12),
(25, 'Hydraulics 1', 'This is Hydraulics 1', 0, 3, 13),
(26, 'Hydraulics 2', 'This is Hydraulics 2', 0, 3, 14),
(27, 'Hydraulics 3', 'This is Hydraulics 3', 0, 3, 15),
(28, 'Hydraulics 4', 'This is Hydraulics 4', 0, 3, 16),
(29, 'Geotech 2', 'This is Geotech 2', 0, 3, 17),
(30, 'Geotech 3', 'This is Geotech 3', 0, 3, 18),
(31, 'Geotech 4', 'This is Geotech 4', 0, 3, 19),
(32, 'Mechanics 1', 'This is Mechanics 1', 0, 3, 20),
(33, 'Mechanics 2', 'This is Mechanics 2', 0, 3, 21),
(34, 'Mechanics 3', 'This is Mechanics 3', 0, 3, 22),
(35, 'Strength 1', 'This is Strength 1', 0, 3, 23),
(36, 'Strength 2', 'This is Strength 2', 0, 3, 24),
(37, 'Algebra', 'This is Algebra', 0, 4, 1),
(38, 'Analytic Geometry', 'This is Analytic Geometry', 0, 4, 4),
(39, 'Differential Calculus', 'This is Differential Calculus', 0, 4, 5),
(40, 'Integral Calculus', 'This is Integral Calculus', 0, 4, 6),
(41, 'Differential Equation', 'This is Differential Equation', 0, 4, 7),
(42, 'Advance Math', 'This is Advance Math', 0, 4, 34),
(43, 'Probability and Statistics', 'This is Probability and Statistics', 0, 4, 35),
(44, 'Chemistry', 'This is Chemistry', 0, 4, 36),
(45, 'Physics', 'This is Physics', 0, 4, 37),
(46, 'Trigonometry', 'This is Trigonometry', 0, 4, 74),
(47, 'Solid Mensuration', 'This is Solid Mensuration', 0, 4, 75),
(48, 'Statics and Dynamics', 'This is Statics and Dynamics', 0, 4, 76),
(49, 'Algebra', 'This is Algebra', 0, 5, 1),
(50, 'Analytic Geometry', 'This is Analytic Geometry', 0, 5, 4),
(51, 'Differential Calculus', 'This is Differential Calculus', 0, 5, 5),
(52, 'Integral Calculus', 'This is Integral Calculus', 0, 5, 6),
(53, 'Differential Equation', 'This is Differential Equation', 0, 5, 7),
(54, 'Advance Math', 'This is Advance Math', 0, 5, 34),
(55, 'Probability and Statistics', 'This is Probability and Statistics', 0, 5, 35),
(56, 'Chemistry', 'This is Chemistry', 0, 5, 36),
(57, 'Physics', 'This is Physics', 0, 5, 37),
(58, 'Trigonometry', 'This is Trigonometry', 0, 5, 74),
(59, 'Solid Mensuration', 'This is Solid Mensuration', 0, 5, 75),
(60, 'Statics and Dynamics', 'This is Statics and Dynamics', 0, 5, 76),
(61, 'Strength of Materials', 'This is Strength of Materials', 0, 6, 39),
(62, 'Thermodynamics', 'This is Thermodynamics', 0, 6, 40),
(63, 'Fluid Mechanics', 'This is Fluid Mechanics', 0, 6, 42),
(64, 'Heat Transfer', 'This is Heat Transfer', 0, 6, 77),
(65, 'Combustion Engineering', 'This is Combustion Engineering', 0, 6, 78),
(66, 'Machine Elements', 'This is Machine Elements', 0, 6, 79),
(67, 'Machine Shop Theory', 'This is Machine Shop Theory', 0, 6, 80),
(68, 'Material Science Engineering', 'This is Material Science Engineering', 0, 6, 81),
(69, 'Algebra', 'This is Algebra', 0, 7, 1),
(70, 'Plane and Spherical Geometry', 'This is Plane and Spherical Geometry', 0, 7, 2),
(71, 'Plane and Spherical Trigo', 'This is Plane and Spherical Trigo', 0, 7, 3),
(72, 'Analytic Geometry', 'This is Analytic Geometry', 0, 7, 4),
(73, 'Differential Calculus', 'This is Differential Calculus', 0, 7, 5),
(74, 'Integral Calculus', 'This is Integral Calculus', 0, 7, 6),
(75, 'Differential Equation', 'This is Differential Equation', 0, 7, 7),
(76, 'Advance Math', 'This is Advance Math', 0, 7, 34),
(77, 'Probability and Statistics', 'This is Probability and Statistics', 0, 7, 35),
(78, 'Chemistry', 'This is Chemistry', 0, 7, 36),
(79, 'Physics', 'This is Physics', 0, 7, 37),
(80, 'Algebra', 'This is Algebra', 0, 8, 1),
(81, 'Plane and Spherical Geometry', 'This is Plane and Spherical Geometry', 0, 8, 2),
(82, 'Plane and Spherical Trigo', 'This is Plane and Spherical Trigo', 0, 8, 3),
(83, 'Analytic Geometry', 'This is Analytic Geometry', 0, 8, 4),
(84, 'Differential Calculus', 'This is Differential Calculus', 0, 8, 5),
(85, 'Integral Calculus', 'This is Integral Calculus', 0, 8, 6),
(86, 'Differential Equation', 'This is Differential Equation', 0, 8, 7),
(87, 'Advance Math', 'This is Advance Math', 0, 8, 34),
(88, 'Probability and Statistics', 'This is Probability and Statistics', 0, 8, 35),
(89, 'Chemistry', 'This is Chemistry', 0, 8, 36),
(90, 'Physics', 'This is Physics', 0, 8, 37),
(91, 'Mechanics', 'This is Mechanics', 0, 9, 38),
(92, 'Strength of Materials', 'This is Strength of Materials', 0, 9, 39),
(93, 'Thermodynamics', 'This is Thermodynamics', 0, 9, 40),
(94, 'Vector Analysis and Electromagnets', 'This is Vector Analysis and Electromagnets', 0, 9, 58),
(95, 'Engineering Economy', 'This is Engineering Economy', 0, 9, 59),
(96, 'Electrical Elements', 'This is Electrical Elements', 0, 10, 60),
(97, 'DC and AC circuits', 'This is DC and AC circuits', 0, 10, 61),
(98, 'Electricity and Magnetism', 'This is Electricity and Magnetism', 0, 10, 62),
(99, 'Microelectronics', 'This is Microelectronics', 0, 10, 63),
(100, 'Semiconductor Devices', 'This is Semiconductor Devices', 0, 10, 64),
(101, 'Logic Circuits', 'This is Logic Circuits', 0, 10, 65),
(102, 'Industrial Electronics and Power Supply', 'This is Industrial Electronics and Power Supply', 0, 10, 66);

--
-- Dumping data for table `topic_list`
--

INSERT INTO `topic_list` (`topic_list_id`, `topic_list_name`, `topic_list_is_active`, `topic_list_description`) VALUES
(1, 'Algebra', 1, NULL),
(2, 'Plane and Spherical Geometry', 1, NULL),
(3, 'Plane and Spherical Trigo', 1, NULL),
(4, 'Analytic Geometry', 1, NULL),
(5, 'Differential Calculus', 1, NULL),
(6, 'Integral Calculus', 1, NULL),
(7, 'Differential Equation', 1, NULL),
(8, 'Probability', 1, NULL),
(9, 'Economy', 1, NULL),
(10, 'Survey 1', 1, NULL),
(11, 'Survey 2', 1, NULL),
(12, 'Survey 3', 1, NULL),
(13, 'Hydraulics 1', 1, NULL),
(14, 'Hydraulics 2', 1, NULL),
(15, 'Hydraulics 3', 1, NULL),
(16, 'Hydraulics 4', 1, NULL),
(17, 'Geotech 2', 1, NULL),
(18, 'Geotech 3', 1, NULL),
(19, 'Geotech 4', 1, NULL),
(20, 'Mechanics 1', 1, NULL),
(21, 'Mechanics 2', 1, NULL),
(22, 'Mechanics 3', 1, NULL),
(23, 'Strength 1', 1, NULL),
(24, 'Strength 2', 1, NULL),
(25, 'Theory 1', 1, NULL),
(26, 'Theory 2', 1, NULL),
(27, 'Theory 3', 1, NULL),
(28, 'Steel 1', 1, NULL),
(29, 'Steel 2', 1, NULL),
(30, 'Steel 3', 1, NULL),
(31, 'RCD 1', 1, NULL),
(32, 'RCD 2', 1, NULL),
(33, 'RCD 3', 1, NULL),
(34, 'Advance Math', 1, NULL),
(35, 'Probability and Statistics', 1, NULL),
(36, 'Chemistry', 1, NULL),
(37, 'Physics', 1, NULL),
(38, 'Mechanics', 1, NULL),
(39, 'Strength of Materials', 1, NULL),
(40, 'Thermodynamics', 1, NULL),
(41, 'Hydraulics', 1, NULL),
(42, 'Fluid Mechanics', 1, NULL),
(43, 'Engineering Econmy', 1, NULL),
(44, 'Philippine Electrical Code', 1, NULL),
(45, 'Laws and Ethics', 1, NULL),
(46, 'Computer Fundamentals', 1, NULL),
(47, 'Circuits 1', 1, NULL),
(48, 'Circuits 2', 1, NULL),
(49, 'Circuits 3', 1, NULL),
(50, 'DC Machine', 1, NULL),
(51, 'AC Machinces', 1, NULL),
(52, 'Aparatus and Equipment', 1, NULL),
(53, 'Power Systems', 1, NULL),
(54, 'Illumination', 1, NULL),
(55, 'Transient', 1, NULL),
(56, 'Power Plant', 1, NULL),
(57, 'Electronics', 1, NULL),
(58, 'Vector Analysis and Electromagnets', 1, NULL),
(59, 'Engineering Economy', 1, NULL),
(60, 'Electrical Elements', 1, NULL),
(61, 'DC and AC circuits', 1, NULL),
(62, 'Electricity and Magnetism', 1, NULL),
(63, 'Microelectronics', 1, NULL),
(64, 'Semiconductor Devices', 1, NULL),
(65, 'Logic Circuits', 1, NULL),
(66, 'Industrial Electronics and Power Supply', 1, NULL),
(67, 'Radiowave Communications', 1, NULL),
(68, 'Transmission Lines and Waveguides', 1, NULL),
(69, 'Antenna', 1, NULL),
(70, 'Microwave Communications', 1, NULL),
(71, 'analog Modulation', 1, NULL),
(72, 'Digital Communications ', 1, NULL),
(73, 'Fiber Oprics', 1, NULL),
(74, 'Trigonometry', 1, NULL),
(75, 'Solid Mensuration', 1, NULL),
(76, 'Statics and Dynamics', 1, NULL),
(77, 'Heat Transfer', 1, NULL),
(78, 'Combustion Engineering', 1, NULL),
(79, 'Machine Elements', 1, NULL),
(80, 'Machine Shop Theory', 1, NULL),
(81, 'Material Science Engineering', 1, NULL),
(82, 'Fluid Machinery', 1, NULL),
(83, 'Combustion Engine', 1, NULL),
(84, 'Refrigeration, Heating, Ventilation and Airconditioning', 1, NULL),
(85, 'Industrial Process', 1, NULL),
(86, 'Safety Engineering and Intrumentation', 1, NULL),
(87, 'Industrial Plant Engineering', 1, NULL),
(88, 'Power Plant Engineering', 1, NULL),
(89, 'Vibration Engineering', 1, NULL);

--
-- Dumping data for table `year_level`
--

INSERT INTO `year_level` (`year_level_id`, `year_level_name`) VALUES
(1, '1st year'),
(2, '2nd year'),
(3, '3rd year'),
(4, '4th year'),
(5, 'Terminal year');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
