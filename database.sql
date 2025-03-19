-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2024 at 09:37 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `answer_id` int(11) NOT NULL,
  `answer` text NOT NULL,
  `correct` int(1) NOT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`answer_id`, `answer`, `correct`, `question_id`) VALUES
(1, 'five', 0, 1),
(2, 'two', 0, 1),
(3, 'three', 1, 1),
(4, 'four', 0, 1),
(5, 'Tokyo', 0, 2),
(6, 'Paris', 1, 2),
(7, 'London', 0, 2),
(8, 'Hanoi', 0, 2),
(9, 'N3', 0, 3),
(10, 'O2', 0, 3),
(11, 'N2', 0, 3),
(12, 'H2O', 1, 3),
(13, 'SWEN501', 0, 4),
(14, 'SWEN123', 0, 4),
(15, 'SWEN502', 1, 4),
(16, 'SWEN504', 0, 4),
(17, '1', 0, 5),
(18, '10', 1, 5),
(19, '7', 0, 5),
(20, '5', 0, 5),
(21, 'chicken', 0, 6),
(22, 'hen', 0, 6),
(23, 'the void', 1, 6),
(24, 'another egg', 0, 6),
(25, 'yes', 1, 7),
(26, 'no', 0, 7),
(27, 'maybe?', 0, 7),
(28, 'no idea', 0, 7),
(29, 'why not?', 1, 8),
(30, 'why...', 0, 8),
(31, 'okay?', 0, 8),
(32, 'yeah', 0, 8);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `user_id` int(255) NOT NULL,
  `email` varchar(999) NOT NULL,
  `password` varchar(999) NOT NULL,
  `user_level` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`user_id`, `email`, `password`, `user_level`) VALUES
(2, 'teacher@gmail.com', 'teacher', 2),
(3, 'student@gmail.com', 'student', 1),
(4, 'ngnxtan@gmail.com', '1235', 1),
(5, 'nguyenbui.mt1712@gmail.com', '1245', 1),
(6, 'huh@gmail.com', '123', 1),
(7, 'teacher2@gmail.com', 'teacher', 2);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `quizz_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `question_text`, `quizz_id`) VALUES
(1, 'What is two+one?', 1),
(2, 'What is the capital of France?', 1),
(3, 'What is water?', 1),
(4, 'What is the second course of MSwDev?', 2),
(5, 'What is larger 9?', 2),
(6, 'What comes before egg?', 3),
(7, 'is the Sun a star?', 3),
(8, 'why do we live, just to suffer?', 3);

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `quizz_id` int(11) NOT NULL,
  `quizz_name` varchar(999) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`quizz_id`, `quizz_name`, `teacher_id`) VALUES
(1, 'default101', 2),
(2, 'default102', 2),
(3, 'workplease1', 7);

-- --------------------------------------------------------

--
-- Table structure for table `quizz_student`
--

CREATE TABLE `quizz_student` (
  `quizz_id` int(255) NOT NULL,
  `student_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizz_student`
--

INSERT INTO `quizz_student` (`quizz_id`, `student_id`) VALUES
(1, 3),
(1, 6),
(2, 3),
(3, 6);

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `student_id` int(11) NOT NULL,
  `quiz_name` text NOT NULL,
  `question_total` int(11) NOT NULL,
  `question_correct` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`student_id`, `quiz_name`, `question_total`, `question_correct`, `quiz_id`) VALUES
(3, ' default101', 3, 2, 1),
(3, ' default101', 3, 1, 1),
(3, ' default101', 3, 1, 1),
(3, ' default101', 3, 0, 1),
(3, ' default101', 3, 3, 1),
(3, ' default101', 3, 0, 1),
(3, ' default101', 3, 3, 1),
(6, ' default101', 3, 3, 1),
(6, ' workplease1', 3, 2, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD UNIQUE KEY `answer_id` (`answer_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD UNIQUE KEY `question_id` (`question_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD UNIQUE KEY `class_id` (`quizz_id`);

--
-- Indexes for table `quizz_student`
--
ALTER TABLE `quizz_student`
  ADD UNIQUE KEY `unique_quizz_student_pair` (`quizz_id`,`student_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
