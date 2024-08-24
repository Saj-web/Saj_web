-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2024 at 05:28 PM
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
-- Database: `hrms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(150) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `admin_password` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT curtime()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `admin_email`, `admin_password`, `created_at`) VALUES
(1, 'Sam Augustine Junior', 'gbenartey19@gmail.com', 'junior18', '2024-06-01 18:59:02');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `attendance_date` datetime NOT NULL,
  `attendance_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `employee_id`, `attendance_date`, `attendance_status`) VALUES
(102, 15, '2024-08-05 12:23:25', 'present'),
(103, 15, '2024-08-05 12:24:43', 'present'),
(104, 15, '2024-08-05 13:08:18', 'present'),
(105, 2, '2024-08-05 13:09:37', 'present'),
(106, 10, '2024-08-05 13:11:52', 'present'),
(107, 2, '2024-08-05 13:29:23', 'present'),
(108, 2, '2024-08-05 13:29:44', 'present'),
(109, 2, '2024-08-06 16:05:11', 'present');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(255) NOT NULL,
  `department_type` varchar(255) NOT NULL,
  `department_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_name`, `department_type`, `department_description`) VALUES
(1, 'CPS', 'Computer Science', 'Responsible for programming'),
(2, 'IT', 'Technical Support', 'Responsible for technical support and maintenance');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employee_id` int(11) NOT NULL,
  `employee_name` varchar(50) NOT NULL,
  `employee_password` varchar(20) NOT NULL,
  `employee_address` varchar(50) NOT NULL,
  `employee_mobile` varchar(11) NOT NULL,
  `employee_email` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT curtime(),
  `password_changed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `employee_name`, `employee_password`, `employee_address`, `employee_mobile`, `employee_email`, `created_at`, `password_changed`) VALUES
(2, 'AUGUSTINE JUNIOR SAM', 'junior18', 'kokomlemle Ayikah Gbozah street,21', '0243534849', 'gbenartey19@gmail.com', '2024-06-01 10:51:33', 1),
(10, 'Kelvin', '1234', 'kaneshie', '0532981050', 'kellot353@gmail.com', '2024-06-01 18:33:58', 1),
(15, 'gbenartey', '12345678', 'mataheko', '0537610400', 'samuel20@gmail.com', '2024-07-28 13:32:44', 1),
(23, 'Godfred', '1234', 'La', '0234343455', 'godfred12@gmail.com', '2024-08-02 12:28:40', 1),
(24, 'TinaSam', 'junior18', 'mataheko', '0537610465', 'tina@gmail.com', '2024-08-02 12:39:52', 0);

-- --------------------------------------------------------

--
-- Table structure for table `employee_department`
--

CREATE TABLE `employee_department` (
  `employee_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_department`
--

INSERT INTO `employee_department` (`employee_id`, `department_id`) VALUES
(1, 1),
(2, 1),
(3, 2),
(5, 1),
(7, 1),
(9, 1),
(10, 2),
(11, 1),
(14, 1),
(15, 2),
(22, 0),
(23, 1),
(24, 2);

-- --------------------------------------------------------

--
-- Table structure for table `evaluation`
--

CREATE TABLE `evaluation` (
  `eval_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `eval_value` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evaluation`
--

INSERT INTO `evaluation` (`eval_id`, `employee_id`, `eval_value`, `notes`) VALUES
(2, 2, 'Good', 'Room for improvement'),
(7, 10, 'Excellent', 'Outstanding performance'),
(11, 15, 'Good', 'Good job!');

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `salary_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `salary_amount` decimal(10,2) DEFAULT NULL,
  `salary_total` decimal(10,2) DEFAULT NULL,
  `salary_type` varchar(50) DEFAULT NULL,
  `salary_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salary`
--

INSERT INTO `salary` (`salary_id`, `employee_id`, `salary_amount`, `salary_total`, `salary_type`, `salary_description`) VALUES
(2, 2, 6000.00, 72000.00, 'Monthly', 'Basic Salary'),
(10, 10, 6800.00, 81600.00, 'Monthly', 'Basic Salary'),
(15, 15, 5000.00, 60000.00, 'Monthly', 'Basic Salary'),
(17, 10, 2009.00, 7000.00, 'Basic Salary', 'Monthly');

-- --------------------------------------------------------

--
-- Table structure for table `trainings`
--

CREATE TABLE `trainings` (
  `training_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `training_type` varchar(50) DEFAULT NULL,
  `training_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainings`
--

INSERT INTO `trainings` (`training_id`, `employee_id`, `training_type`, `training_description`) VALUES
(1, 2, 'Java', 'Learning Object Oreinted Java'),
(2, 10, 'Research Methodology', 'Researching about RFL');

-- --------------------------------------------------------

--
-- Table structure for table `userroles`
--

CREATE TABLE `userroles` (
  `user_id` int(11) DEFAULT NULL,
  `role` enum('admin','hr_manager','department_manager','employee') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userroles`
--

INSERT INTO `userroles` (`user_id`, `role`) VALUES
(2, 'admin'),
(10, 'employee'),
(15, 'hr_manager'),
(23, 'department_manager'),
(24, 'hr_manager');

-- --------------------------------------------------------

--
-- Table structure for table `vacation`
--

CREATE TABLE `vacation` (
  `vacation_id` int(11) NOT NULL,
  `vacation_title` varchar(50) NOT NULL,
  `vacation_from_date` date NOT NULL,
  `vacation_to_date` date NOT NULL,
  `reason` varchar(255) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vacation`
--

INSERT INTO `vacation` (`vacation_id`, `vacation_title`, `vacation_from_date`, `vacation_to_date`, `reason`, `employee_id`, `status`) VALUES
(7, 'Christmas Holiday', '2024-08-05', '2024-08-23', 'Travel to USA', 23, 'Pending'),
(8, 'Exams Leave', '2024-08-09', '2024-08-12', 'Write my Bsc CPS exams', 10, 'Pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`eval_id`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`salary_id`);

--
-- Indexes for table `trainings`
--
ALTER TABLE `trainings`
  ADD PRIMARY KEY (`training_id`);

--
-- Indexes for table `userroles`
--
ALTER TABLE `userroles`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `vacation`
--
ALTER TABLE `vacation`
  ADD PRIMARY KEY (`vacation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `eval_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `salary`
--
ALTER TABLE `salary`
  MODIFY `salary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `trainings`
--
ALTER TABLE `trainings`
  MODIFY `training_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `vacation`
--
ALTER TABLE `vacation`
  MODIFY `vacation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`);

--
-- Constraints for table `userroles`
--
ALTER TABLE `userroles`
  ADD CONSTRAINT `userroles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `employee` (`employee_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
