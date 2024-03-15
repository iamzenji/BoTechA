-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 01, 2024 at 02:24 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lauvan`
--

-- --------------------------------------------------------

--
-- Table structure for table `daily_time_record`
--

CREATE TABLE `daily_time_record` (
  `record_id` int(10) NOT NULL,
  `rec_emp_id` int(10) NOT NULL,
  `record_emp_name` varchar(250) NOT NULL,
  `record_emp_position` varchar(250) NOT NULL,
  `record_shift` varchar(100) NOT NULL,
  `record_date` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daily_time_record`
--

INSERT INTO `daily_time_record` (`record_id`, `rec_emp_id`, `record_emp_name`, `record_emp_position`, `record_shift`, `record_date`) VALUES
(1, 1, 'John Doe', 'Mascot', 'Present', 12345);

-- --------------------------------------------------------

--
-- Table structure for table `employee_details`
--

CREATE TABLE `employee_details` (
  `employee_id` int(10) NOT NULL,
  `employee_name` varchar(200) NOT NULL,
  `employee_position` varchar(250) NOT NULL,
  `employee_contact` varchar(200) NOT NULL,
  `employee_datestart` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_details`
--

INSERT INTO `employee_details` (`employee_id`, `employee_name`, `employee_position`, `employee_contact`, `employee_datestart`) VALUES
(1, 'John Doe', 'Mascot', '09123456789', '2024-03-02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daily_time_record`
--
ALTER TABLE `daily_time_record`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `ada` (`rec_emp_id`),
  ADD KEY `dada` (`record_emp_name`),
  ADD KEY `sasa` (`record_emp_position`);

--
-- Indexes for table `employee_details`
--
ALTER TABLE `employee_details`
  ADD PRIMARY KEY (`employee_id`),
  ADD KEY `employee_name` (`employee_name`),
  ADD KEY `employee_position` (`employee_position`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee_details`
--
ALTER TABLE `employee_details`
  MODIFY `employee_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `daily_time_record`
--
ALTER TABLE `daily_time_record`
  ADD CONSTRAINT `ada` FOREIGN KEY (`rec_emp_id`) REFERENCES `employee_details` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dada` FOREIGN KEY (`record_emp_name`) REFERENCES `employee_details` (`employee_name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sasa` FOREIGN KEY (`record_emp_position`) REFERENCES `employee_details` (`employee_position`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
