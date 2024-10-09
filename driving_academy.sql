-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2024 at 08:38 AM
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
-- Database: `driving_academy`
--

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `course` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `preferred_time` time NOT NULL,
  `enrollment_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'Pending',
  `status` enum('Not Started Yet','In Progress','Completed') NOT NULL DEFAULT 'Not Started Yet'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `user_email`, `course`, `start_date`, `preferred_time`, `enrollment_date`, `amount`, `payment_status`, `status`) VALUES
(1, 'admin@gmail.com', 'basic-driving', '2025-05-08', '08:00:00', '2024-10-06', 2000.00, 'In Progress', 'Completed'),
(2, 'admin@gmail.com', 'basic-driving', '2025-05-08', '08:00:00', '2024-10-06', 2000.00, 'Paid', 'Completed'),
(3, 'admin@gmail.com', 'advanced-driving', '2004-05-08', '00:00:00', '2024-10-06', 3000.00, 'Paid', 'Not Started Yet'),
(4, 'admin@gmail.com', 'advanced-driving', '2004-05-08', '00:00:00', '2024-10-06', 3000.00, 'Pending', 'Not Started Yet'),
(5, 'admin@gmail.com', 'advanced-driving', '2004-05-08', '00:00:00', '2024-10-06', 0.00, 'Paid', 'Not Started Yet'),
(6, 'admin@gmail.com', 'advanced-driving', '2004-05-08', '00:00:00', '2024-10-06', 0.00, 'Pending', 'Not Started Yet'),
(7, 'admin@gmail.com', 'defensive-driving', '2005-05-31', '08:00:00', '2024-10-06', 2500.00, 'Pending', 'Not Started Yet'),
(8, 'admin@gmail.com', 'basic-driving', '2024-10-08', '08:00:00', '2024-10-06', 2000.00, 'Paid', 'Not Started Yet'),
(9, 'suman@gmail.com', 'basic-driving', '2024-10-10', '08:00:00', '2024-10-06', 2000.00, 'Paid', 'Not Started Yet'),
(10, 'suman@gmail.com', 'advanced-driving', '2000-05-08', '08:00:00', '2024-10-06', 3000.00, 'Paid', 'Not Started Yet'),
(11, 'admin123@gmail.com', 'advanced-driving', '2024-10-08', '08:00:00', '2024-10-06', 3000.00, 'Paid', 'Completed'),
(12, 'shravan@gmail.com', 'basic-driving', '2024-10-08', '12:00:00', '2024-10-06', 2000.00, 'Paid', 'In Progress'),
(13, 'chiku@gmail.com', 'basic-driving', '2024-10-08', '08:00:00', '2024-10-06', 2000.00, 'Paid', 'Completed'),
(14, 'admin@gmail.com', 'basic-driving', '2222-08-01', '08:05:00', '2024-10-08', 2000.00, 'Paid', 'Completed'),
(15, 'john@gmail.com', 'basic-driving', '2024-10-08', '20:30:00', '2024-10-08', 2000.00, 'Paid', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `mobile_no` varchar(15) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `role` enum('admin','instructor','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `mobile_no`, `birthdate`, `role`) VALUES
(1, 'shubham kamble', 'admin@gmail.com', '123456', '2024-10-05 23:57:35', '+918805643880', '2004-05-08', 'admin'),
(2, 'suman kamble', 'suman@gmail.com', '123456', '2024-10-06 05:27:10', '7888261744', '1981-04-10', 'admin'),
(3, 'shruti bahekar', 'admin123@gmail.com', '123456', '2024-10-06 07:53:27', '7558445305', '2003-09-12', 'instructor'),
(4, 'shravan bahekar', 'shravan@gmail.com', '123456', '2024-10-06 08:02:42', '1234567890', '2010-06-10', 'user'),
(5, 'chiku kamble', 'chiku@gmail.com', '123456', '2024-10-06 12:30:19', '6666655555', '2020-10-22', 'user'),
(6, 'John Fernandez', 'john@gmail.com', '123456', '2024-10-08 05:21:46', '7519516521', '2024-10-08', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
