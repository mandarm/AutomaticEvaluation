-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 14, 2023 at 10:51 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testautomation`
--

-- --------------------------------------------------------

--
-- Table structure for table `qp`
--

CREATE TABLE `qp` (
  `id` int(6) NOT NULL,
  `tc` varchar(50) NOT NULL,
  `qpaper` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `qp`
--

INSERT INTO `qp` (`id`, `tc`, `qpaper`) VALUES
(17, '1', '1_1689143549.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `student_allocation`
--

CREATE TABLE `student_allocation` (
  `id` int(10) NOT NULL,
  `tc` varchar(50) NOT NULL,
  `stud_roll_no` varchar(50) NOT NULL,
  `student_name` varchar(150) NOT NULL,
  `course` varchar(250) DEFAULT NULL,
  `batch` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_allocation`
--

INSERT INTO `student_allocation` (`id`, `tc`, `stud_roll_no`, `student_name`, `course`, `batch`) VALUES
(24, '1', 'CRS22-001', 'AMIT RANJAN AZAD', NULL, NULL),
(25, '1', 'CRS22-002', 'PRIYANKA ROY', NULL, NULL),
(26, '1', 'CRS22-003', 'SAMIM RAHAMAN', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t1`
--

CREATE TABLE `t1` (
  `id` int(5) NOT NULL,
  `student_roll` varchar(50) NOT NULL,
  `student_name` varchar(150) NOT NULL,
  `prog_lang` varchar(10) DEFAULT 'X',
  `Q1_marks` int(3) DEFAULT 0,
  `Q1_fm` int(3) DEFAULT 1,
  `Q2_marks` int(3) DEFAULT 0,
  `Q2_fm` int(3) DEFAULT 1,
  `tot_marks_obtained` int(3) GENERATED ALWAYS AS (`Q1_marks` + `Q2_marks`) VIRTUAL,
  `full_marks` int(3) GENERATED ALWAYS AS (`Q1_fm` + `Q2_fm`) VIRTUAL,
  `percentage` decimal(10,2) GENERATED ALWAYS AS (`tot_marks_obtained` / `full_marks` * 100) VIRTUAL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t1`
--

INSERT INTO `t1` (`id`, `student_roll`, `student_name`, `prog_lang`, `Q1_marks`, `Q1_fm`, `Q2_marks`, `Q2_fm`) VALUES
(1, 'CRS22-001', 'AMIT RANJAN AZAD', 'C', 70, 70, 30, 30),
(2, 'CRS22-002', 'PRIYANKA ROY', 'C++', 28, 70, 0, 30),
(3, 'CRS22-003', 'SAMIM RAHAMAN', 'PYTHON', 70, 70, 0, 30);

-- --------------------------------------------------------

--
-- Table structure for table `t2`
--

CREATE TABLE `t2` (
  `id` int(5) NOT NULL,
  `student_roll` varchar(50) NOT NULL,
  `student_name` varchar(150) NOT NULL,
  `prog_lang` varchar(10) DEFAULT 'X',
  `Q1_marks` int(3) DEFAULT 0,
  `Q1_fm` int(3) DEFAULT 1,
  `Q2_marks` int(3) DEFAULT 0,
  `Q2_fm` int(3) DEFAULT 1,
  `tot_marks_obtained` int(3) GENERATED ALWAYS AS (`Q1_marks` + `Q2_marks`) VIRTUAL,
  `full_marks` int(3) GENERATED ALWAYS AS (`Q1_fm` + `Q2_fm`) VIRTUAL,
  `percentage` decimal(10,2) GENERATED ALWAYS AS (`tot_marks_obtained` / `full_marks` * 100) VIRTUAL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testcase`
--

CREATE TABLE `testcase` (
  `id` int(11) NOT NULL,
  `tc` varchar(50) NOT NULL,
  `qn` int(2) NOT NULL,
  `notc` int(11) NOT NULL,
  `evalpt` varchar(50) NOT NULL,
  `marks` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testcase`
--

INSERT INTO `testcase` (`id`, `tc`, `qn`, `notc`, `evalpt`, `marks`) VALUES
(41, '1', 1, 2, '40-60', 70),
(42, '1', 2, 3, '35-35-30', 30),
(43, '2', 1, 2, '40-60', 70),
(44, '2', 2, 3, '25-25-50', 30);

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` int(6) NOT NULL,
  `tc` varchar(50) NOT NULL,
  `tname` varchar(250) NOT NULL,
  `faculty_roll` int(6) NOT NULL,
  `tdate` varchar(10) NOT NULL,
  `tstime` varchar(8) NOT NULL,
  `tedate` varchar(10) NOT NULL,
  `tetime` varchar(8) NOT NULL,
  `tdesc` varchar(1000) DEFAULT NULL,
  `noc` int(2) NOT NULL,
  `total_marks` int(3) NOT NULL,
  `test_password` varchar(50) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `modified_on` varchar(50) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `tc`, `tname`, `faculty_roll`, `tdate`, `tstime`, `tedate`, `tetime`, `tdesc`, `noc`, `total_marks`, `test_password`, `status`, `modified_on`) VALUES
(15, '1', 'Sample Test-1', 9626, '12-07-2023', '12:00:00', '16-07-2023', '13:15:00', 'none', 2, 100, '123', 'Active', '2023-07-12 11:50:27'),
(16, '2', 'sample test 2', 9626, '13-07-2023', '10:00:00', '14-07-2023', '11:00:00', 'jj', 2, 100, '123', 'Pending', '2023-07-12 13:59:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(5) NOT NULL,
  `roll_no` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `designation` varchar(150) NOT NULL,
  `office_address` varchar(100) DEFAULT NULL,
  `password` varchar(250) NOT NULL DEFAULT '$2y$10$ftFX4d590/y3HoZuOC4x9.wCoJcS8OvXfgRobaYVtPuzpESjjLnq2',
  `user_role` varchar(100) NOT NULL,
  `account_status` varchar(50) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `roll_no`, `email`, `full_name`, `designation`, `office_address`, `password`, `user_role`, `account_status`) VALUES
(1, '9626', 'biswajit.appl@gmail.com', 'Mr. Biswajit Halder', 'Associate Scientist - A', 'R509 (Algorithm Lab)', '$2y$10$szJiYWNc5Q.GxCyhyMr6KO85MQu4bts1uAlNmS78lj/HWA2Y.IQ8K', 'DB-Admin', 'Active'),
(2, '9192', 'ssk@isical.ac.in', 'Prof. Susmita Sur-Kolay', 'Professor (HAG)', '--', '$2y$10$ftFX4d590/y3HoZuOC4x9.wCoJcS8OvXfgRobaYVtPuzpESjjLnq2', 'Faculty', 'Active'),
(3, '8455', 'nandysc@isical.ac.in', 'Prof. Subhas Chandra Nandy', 'Professor (HAG)', '--', '$2y$10$ftFX4d590/y3HoZuOC4x9.wCoJcS8OvXfgRobaYVtPuzpESjjLnq2', 'Faculty', 'Active'),
(4, '9235', 'sandipdas@isical.ac.in', 'Prof. Sandip Das', 'Professor', '--', '$2y$10$ftFX4d590/y3HoZuOC4x9.wCoJcS8OvXfgRobaYVtPuzpESjjLnq2', 'Faculty', 'Active'),
(5, '9332', 'sasthi@isical.ac.in', 'Prof. Sasthi Charan Ghosh', 'Professor', '--', '$2y$10$ftFX4d590/y3HoZuOC4x9.wCoJcS8OvXfgRobaYVtPuzpESjjLnq2', 'Faculty', 'Active'),
(6, '8459', 'ndas@isical.ac.in', 'Prof. Nabanita Das', 'Professor', '--', '$2y$10$ftFX4d590/y3HoZuOC4x9.wCoJcS8OvXfgRobaYVtPuzpESjjLnq2', 'Faculty', 'Active'),
(7, '9193', 'krishnendu@isical.ac.in', 'Prof. Krishnendu Mukhopadhyaya', 'Professor', '--', '$2y$10$ftFX4d590/y3HoZuOC4x9.wCoJcS8OvXfgRobaYVtPuzpESjjLnq2', 'Faculty', 'Active'),
(8, '9549', 'sourav@isical.ac.in', 'Dr. Sourav Chakraborty', 'Associate Professor', '--', '$2y$10$ftFX4d590/y3HoZuOC4x9.wCoJcS8OvXfgRobaYVtPuzpESjjLnq2', 'Faculty', 'Active'),
(9, '9463', 'sasanka@isical.ac.in', 'Dr. Sasanka Roy', 'Associate Professor', '--', '$2y$10$ftFX4d590/y3HoZuOC4x9.wCoJcS8OvXfgRobaYVtPuzpESjjLnq2', 'Faculty', 'Active'),
(11, '9315', 'arijit@isical.ac.in', 'Prof. Arijit Bishnu', 'Professor', '--', '$2y$10$ftFX4d590/y3HoZuOC4x9.wCoJcS8OvXfgRobaYVtPuzpESjjLnq2', 'Faculty', 'Active'),
(12, '9348', 'ansuman@isical.ac.in', 'Prof. Ansuman Banerjee', 'Professor', '--', '$2y$10$ftFX4d590/y3HoZuOC4x9.wCoJcS8OvXfgRobaYVtPuzpESjjLnq2', 'Faculty', 'Active'),
(15, '8989', 'suchitra15isi@gmail.com', 'Sm. Suchitra Balame', 'Section Officer', 'ACMU', '$2y$10$ftFX4d590/y3HoZuOC4x9.wCoJcS8OvXfgRobaYVtPuzpESjjLnq2', 'DB-Admin', 'Active'),
(16, '9365', 'snmahato@gmail.com', 'Mr. Sachchidanand Mahato', 'Office Assistant \'A\'', 'ACMU', '$2y$10$ftFX4d590/y3HoZuOC4x9.wCoJcS8OvXfgRobaYVtPuzpESjjLnq2', 'DB-Admin', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `qp`
--
ALTER TABLE `qp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_allocation`
--
ALTER TABLE `student_allocation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tc` (`tc`,`stud_roll_no`);

--
-- Indexes for table `t1`
--
ALTER TABLE `t1`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_roll` (`student_roll`);

--
-- Indexes for table `t2`
--
ALTER TABLE `t2`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_roll` (`student_roll`);

--
-- Indexes for table `testcase`
--
ALTER TABLE `testcase`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tc` (`tc`,`qn`,`notc`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tc` (`tc`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `roll_no` (`roll_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `qp`
--
ALTER TABLE `qp`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `student_allocation`
--
ALTER TABLE `student_allocation`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `t1`
--
ALTER TABLE `t1`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t2`
--
ALTER TABLE `t2`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testcase`
--
ALTER TABLE `testcase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
