-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2024 at 04:31 AM
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
-- Database: `botecha`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_qty` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `tracking_number` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_sales`
--

CREATE TABLE `cart_sales` (
  `cart_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `scale` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_table`
--

CREATE TABLE `cart_table` (
  `id` int(11) NOT NULL,
  `Category` varchar(50) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `wholesaleprice` decimal(10,2) DEFAULT NULL,
  `unitcost` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_qty` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `delivery_status_id` int(11) DEFAULT NULL,
  `tracking_number` varchar(100) DEFAULT NULL,
  `delivery_date` varchar(100) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `order_time` time DEFAULT NULL,
  `supplier_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_table`
--

INSERT INTO `cart_table` (`id`, `Category`, `brand`, `unit`, `wholesaleprice`, `unitcost`, `quantity`, `unit_qty`, `total`, `order_id`, `delivery_status_id`, `tracking_number`, `delivery_date`, `order_date`, `order_time`, `supplier_id`, `type_id`) VALUES
(1, 'Analgesic', 'Bioflu', '500mg', 192.00, 8.00, 50, 1200, 9600.00, 90, 5, 'PO-665a1b2d720c3', '2024-06-05', '2024-05-31', '20:47:09', 2, 2),
(2, ' Anilide preparations', 'Biogesic', '500mg', 1000.00, 5.00, 1, 10000, 1000.00, 91, 5, 'PO-665a1b3a94872', '2024-06-05', '2024-05-31', '20:47:22', 2, 2),
(3, 'Dermatological Agents ', 'Cortaid', '30g', 3500.00, 350.00, 1, 500, 3500.00, 92, 5, 'PO-665a1b5b834d9', '2024-06-05', '2024-05-31', '20:47:55', 2, 1),
(4, 'Laxatives ', 'Dulcolax', '5mg', 300.00, 30.00, 1, 500, 300.00, 93, 5, 'PO-665a1b7b6d544', '2024-06-05', '2024-05-31', '20:48:27', 2, 2),
(5, 'Immunizations ', 'Fluzone', '5ml', 5000.00, 500.00, 1, 500, 5000.00, 94, 5, 'PO-665a1b9e5dbfa', '2024-06-05', '2024-05-31', '20:49:02', 2, 5),
(6, 'Diuretics ', 'Lasix', '40mg', 750.00, 75.00, 1, 500, 750.00, 95, 5, 'PO-665a1bb4bbc4e', '2024-06-05', '2024-05-31', '20:49:24', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Paracetamol'),
(2, 'Cardiovascular Medications'),
(3, 'Dermatological Agents '),
(4, 'Diuretics '),
(5, 'Hormonal Therapies'),
(6, 'Immunizations '),
(7, 'Laxatives '),
(8, 'Analgesic'),
(9, ' Anilide preparations');

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

-- --------------------------------------------------------

--
-- Table structure for table `delivery_status`
--

CREATE TABLE `delivery_status` (
  `id` int(11) NOT NULL,
  `status_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_status`
--

INSERT INTO `delivery_status` (`id`, `status_name`) VALUES
(1, 'Pending'),
(2, 'To Ship'),
(3, 'To Receive'),
(4, 'Order Received'),
(5, 'Completed'),
(6, 'Cancel'),
(7, 'Return/Refund');

-- --------------------------------------------------------

--
-- Table structure for table `discounted_item`
--

CREATE TABLE `discounted_item` (
  `id` int(11) NOT NULL,
  `employee` varchar(50) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `value` decimal(10,0) NOT NULL,
  `unit_qty` int(11) NOT NULL,
  `total_cost` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discounted_item`
--

INSERT INTO `discounted_item` (`id`, `employee`, `supplier`, `category`, `brand`, `type`, `unit`, `value`, `unit_qty`, `total_cost`) VALUES
(1, 'Zenji Yangco', 'Unilever', 'Analgesic', 'Bioflu', 'Tablet', '500mg', 4, 50, 200),
(2, 'Zenji Yangco', 'Unilever', ' Anilide preparations', 'Biogesic', 'Tablet', '500mg', 3, 50, 150),
(3, 'Zenji Yangco', 'Unilever', 'Dermatological Agents ', 'Cortaid', 'Tablet', '30g', 150, 10, 1500),
(4, 'Zenji Yangco', 'Unilever', 'Laxatives ', 'Dulcolax', 'Tablet', '5mg', 15, 20, 300),
(5, 'Zenji Yangco', 'Unilever', 'Immunizations ', 'Fluzone', 'Tablet', '5ml', 200, 5, 1000),
(6, 'Zenji Yangco', 'Unilever', 'Diuretics ', 'Lasix', 'Tablet', '40mg', 30, 50, 1500);

-- --------------------------------------------------------

--
-- Table structure for table `dtrrevised`
--

CREATE TABLE `dtrrevised` (
  `record_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time DEFAULT NULL,
  `break_out` time DEFAULT NULL,
  `break_in` time DEFAULT NULL,
  `broken_time_in` time DEFAULT NULL,
  `broken_time_out` time DEFAULT NULL,
  `broken_break_out` time DEFAULT NULL,
  `broken_break_in` time DEFAULT NULL,
  `remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dtrrevised`
--

INSERT INTO `dtrrevised` (`record_id`, `employee_id`, `date`, `time_in`, `time_out`, `break_out`, `break_in`, `broken_time_in`, `broken_time_out`, `broken_break_out`, `broken_break_in`, `remarks`) VALUES
(1, 17, '2024-03-30', '08:18:22', '09:18:22', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', ''),
(2, 17, '2024-03-31', '08:25:54', '09:25:54', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', ''),
(3, 17, '2024-04-01', '08:26:55', '09:26:55', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 'Late and Valid Time Out'),
(6, 19, '2024-03-30', '09:51:15', '10:51:15', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', ''),
(7, 19, '2024-03-31', '09:51:36', '10:51:36', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', ''),
(8, 20, '2024-03-30', '09:52:16', '10:52:16', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', ''),
(9, 20, '2024-03-31', '09:52:38', '10:52:38', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', ''),
(10, 21, '2024-03-30', '09:53:06', '10:53:06', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', ''),
(11, 21, '2024-03-31', '09:53:27', '10:53:27', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', ''),
(30, 18, '2024-03-16', '08:00:00', '20:00:00', '08:00:00', '09:00:00', '08:00:00', '09:00:00', '08:00:00', '09:00:00', ''),
(31, 18, '2024-03-17', '08:00:00', '20:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', ''),
(32, 19, '2024-04-01', '07:00:00', '11:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', ''),
(33, 19, '2024-04-10', '07:00:00', '09:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', ''),
(34, 19, '2024-04-11', '08:00:00', '12:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', ''),
(35, 19, '2024-04-12', '07:00:00', '09:00:00', '08:00:00', '08:30:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', ''),
(36, 18, '2024-04-10', '07:00:00', '09:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', ''),
(37, 18, '2024-04-12', '07:00:00', '09:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', ''),
(38, 20, '2024-04-10', '07:00:00', '09:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', ''),
(39, 21, '2024-04-10', '07:00:00', '09:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', ''),
(47, 59, '2024-04-16', '18:34:33', '18:34:36', NULL, NULL, '00:00:00', '00:00:00', '00:00:00', '00:00:00', ''),
(50, 61, '2024-04-17', '07:00:00', '12:00:00', '12:00:00', '15:00:00', '08:00:00', '09:00:00', '09:00:00', '10:00:00', ''),
(51, 61, '2024-04-16', '07:00:00', '12:00:00', '08:30:00', '09:00:00', '08:00:00', '09:00:00', '00:00:00', '00:00:00', ''),
(52, 21, '2024-04-16', '07:00:00', '09:00:00', '07:30:00', '08:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00', ''),
(59, 62, '2024-04-20', '00:31:29', NULL, NULL, NULL, '00:00:00', '00:00:00', '00:00:00', '00:00:00', ''),
(62, 59, '2024-04-26', '07:50:03', '10:50:03', '08:50:03', '09:20:03', NULL, NULL, NULL, NULL, ''),
(64, 61, '2024-05-03', '07:00:00', '11:00:00', '08:00:00', '09:00:00', NULL, NULL, NULL, NULL, ''),
(65, 69, '2024-05-24', '17:16:30', '17:16:50', '17:16:41', '17:16:46', NULL, NULL, NULL, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `employee_details`
--

CREATE TABLE `employee_details` (
  `employee_id` int(10) NOT NULL,
  `employee_name` varchar(200) NOT NULL,
  `employee_number` int(50) NOT NULL,
  `employee_position` varchar(250) NOT NULL,
  `employee_contact` varchar(200) NOT NULL,
  `employee_datestart` date DEFAULT NULL,
  `employee_username` varchar(255) NOT NULL,
  `employee_password` varchar(255) NOT NULL,
  `employee_age` int(50) NOT NULL,
  `employee_birthday` int(50) NOT NULL,
  `employee_email` text NOT NULL,
  `employee_address` text NOT NULL,
  `employee_gender` varchar(50) NOT NULL,
  `employee_height` int(50) NOT NULL,
  `employee_weight` int(50) NOT NULL,
  `employee_leave_credit` int(11) NOT NULL DEFAULT 20
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_details`
--

INSERT INTO `employee_details` (`employee_id`, `employee_name`, `employee_number`, `employee_position`, `employee_contact`, `employee_datestart`, `employee_username`, `employee_password`, `employee_age`, `employee_birthday`, `employee_email`, `employee_address`, `employee_gender`, `employee_height`, `employee_weight`, `employee_leave_credit`) VALUES
(2, 'Justin Abrenica', 0, 'Cashier', '09213465870', '2024-05-18', 'justin', 'justin12345', 0, 0, '', '', '', 0, 0, 20),
(17, 'Marco Torres', 0, 'HR Officer', '09556454874', '2024-03-16', 'Marco_1', 'Marco_1', 0, 0, '0', '', '', 0, 0, 26),
(18, 'Micosh Yutuc', 0, 'Purchase Order Officer', '09154751547', '2024-03-16', 'Micosh_1', 'Micosh_1', 0, 0, '0', '', '', 0, 0, 20),
(19, 'Aeron Herrera', 0, 'Finance Officer', '09123854784', '2024-03-16', 'Aeron_1', 'Aeron_1', 0, 0, '0', '', '', 0, 0, 20),
(20, 'Regina Velarde', 0, 'Sales Officer - Cashier', '09548975891', '2024-03-16', 'Regina_1', 'regina_1', 0, 0, '0', '', '', 0, 0, 20),
(21, 'Zenji Yangco', 0, 'Inventory Officer', '09651254985', '2024-03-16', 'Zenji_1', 'Zenji_1', 0, 0, '0', '', '', 0, 0, 20),
(59, 'William Yusi', 0, 'Purchase Order Officer and HR Officer', '09154751547', '2024-04-16', 'f3to3hUl', 'ck8DydOA', 21, 2002, 'williamyusi@gmail.com', 'Sindalan, San Fernando, Pampanga', 'Male', 165, 81, 20),
(61, 'Alvin Villamucho', 143307, 'Finance Officer and HR Officer', '09154751541', '2024-04-17', 'aE88VvjD', '6tdjbAxP', 21, 2002, 'alvinjohn@gmail.com', 'Apalit, Pampanga', 'Male', 165, 80, 20),
(62, 'Charles Villanueva', 518210, 'Finance Officer and HR Officer', '09548975891', '2024-04-17', 'GInCGlQj', 'EFeNfmKL', 21, 2002, 'charles@gmail.com', 'Angeles, Pampanga', 'Male', 170, 70, 20),
(64, 'MaRco', 605177, 'Purchase Order Officer and Sales Officer - Cashier', '09154751547', '2024-04-19', 'HGP6SV5S', 'A5aIR6j8', 21, 2003, 'alvinjvillamucho@gmail.com', 'San Luis, Pampanga', 'Male', 2, 2, 20),
(65, 'Lavin', 803649, 'Purchase Order Officer and Inventory Officer', '09154751547', '2024-04-22', 'i5Kw8xTz', 'B5exxHDz', 21, 2003, 'alvinjvillamucho@gmail.com', 'San Juan, Apalit, Pampanga', 'Male', 165, 70, 20),
(66, 'Lauv Lavan', 145358, 'Purchase Order Officer and HR Officer', '09154751547', '2024-04-29', 'xt5DAOOW', 'vzXZhwBs', 21, 2003, 'lauv@gmail.com', 'Sindalan, San Fernando, Pampanga', 'Male', 165, 70, 20),
(67, '999999999999999999999999999999999999999999999', 547022, 'Sales Officer - Cashier', '09277093021', '5000-05-24', 'hmFPLTrS', 'ail29ygP', 55, 1969, 'alvin@gmail.com.com.com.com', 'Del Rosario, City of San Fernando, Pampanga Putanginamo', 'Male', 169, 100, 20),
(68, '999999999999999999999999999999999999999999999', 867504, 'Purchase Order Officer and Inventory Officer and Sales Officer - Cashier', '09277093021', '5000-05-24', 'kq2DwAlk', 'MANXxPJn', 24, 2000, 'alvin@gmail.com.com.com.com', 'Del Rosario, City of San Fernando, Pampanga Putanginamo', 'Male', 169, 100, 20),
(69, '888888888888888888888888888888888888888888888888', 359672, 'Sales Officer - Cashier and Finance Officer and HR Officer', '09277093055', '2024-05-24', 'PnlAXdoH', 'AswGIhxm', 25, 1999, 'bolang@gmail.com', 'Del Rosario, City of San Fernando, Pampanga Putanginamo', 'Male', 150, 121, 22);

-- --------------------------------------------------------

--
-- Table structure for table `employee_salary`
--

CREATE TABLE `employee_salary` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `salary` int(50) NOT NULL,
  `insurance` int(50) DEFAULT 1000,
  `sss` int(50) DEFAULT 250,
  `pag_ibig` int(50) DEFAULT 350,
  `tax` int(50) DEFAULT 1000,
  `hours_worked` int(50) NOT NULL,
  `pay_per_hour` int(50) DEFAULT 10,
  `date` date DEFAULT NULL,
  `status` text NOT NULL DEFAULT 'Unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_salary`
--

INSERT INTO `employee_salary` (`id`, `employee_id`, `salary`, `insurance`, `sss`, `pag_ibig`, `tax`, `hours_worked`, `pay_per_hour`, `date`, `status`) VALUES
(4, 18, 0, 1500, 250, 350, 1500, 0, 200, '2024-04-09', 'Unpaid'),
(5, 19, 0, 1000, 250, 350, 1000, 3, 2000, '2024-04-09', 'Unpaid'),
(6, 17, 0, 1000, 250, 350, 1000, 0, 100, '2024-04-09', 'Unpaid'),
(7, 20, 0, 1000, 250, 350, 1000, 0, 70, '2024-04-09', 'Unpaid'),
(8, 21, 0, 1000, 250, 350, 1000, 0, 70, '2024-04-09', 'Unpaid'),
(44, 61, 0, 1000, 250, 350, 1000, 0, 100, NULL, 'Unpaid'),
(45, 62, 0, 1000, 250, 350, 1000, 0, 20, NULL, 'Unpaid'),
(47, 64, 0, 1000, 250, 350, 1000, 0, 20, NULL, 'Unpaid'),
(48, 65, 0, 1000, 250, 350, 1000, 0, 20, NULL, 'Unpaid'),
(49, 59, 0, 1000, 250, 350, 1000, 0, 20, NULL, 'Unpaid'),
(50, 66, 0, 1000, 250, 350, 1000, 0, 20, NULL, 'Unpaid'),
(53, 69, 0, 1000, 250, 350, 1000, 0, 20, NULL, 'Unpaid');

-- --------------------------------------------------------

--
-- Table structure for table `employee_salary_revised`
--

CREATE TABLE `employee_salary_revised` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `insurance` int(50) DEFAULT 1000,
  `sss` int(50) DEFAULT 250,
  `pag_ibig` int(50) DEFAULT 350,
  `tax` int(50) DEFAULT 1000,
  `hours_worked` int(50) NOT NULL,
  `pay_per_hour` int(50) DEFAULT 10,
  `date` date DEFAULT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `gross_salary` int(50) NOT NULL,
  `total_deductions` int(50) NOT NULL,
  `total_salary` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_salary_revised`
--

INSERT INTO `employee_salary_revised` (`id`, `employee_id`, `insurance`, `sss`, `pag_ibig`, `tax`, `hours_worked`, `pay_per_hour`, `date`, `from_date`, `to_date`, `gross_salary`, `total_deductions`, `total_salary`) VALUES
(160, 17, 1000, 250, 350, 1000, 1, 100, NULL, '2024-04-01', '2024-05-02', 100, 2600, -2500),
(161, 18, 1500, 250, 350, 1500, 4, 200, NULL, '2024-04-01', '2024-05-02', 800, 3600, -2800),
(162, 19, 1000, 250, 350, 1000, 11, 2000, NULL, '2024-04-01', '2024-05-02', 22000, 2600, 19400),
(163, 20, 1000, 250, 350, 1000, 2, 70, NULL, '2024-04-01', '2024-05-02', 140, 2600, -2460),
(164, 21, 1000, 250, 350, 1000, 3, 70, NULL, '2024-04-01', '2024-05-02', 210, 2600, -2390),
(165, 59, 1000, 250, 350, 1000, 2, 20, NULL, '2024-04-01', '2024-05-02', 40, 2600, -2560),
(167, 62, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-05-02', 0, 2600, -2600),
(168, 64, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-05-02', 0, 2600, -2600),
(169, 65, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-05-02', 0, 2600, -2600),
(175, 17, 1000, 250, 350, 1000, 1, 100, NULL, '2024-04-01', '2024-04-30', 100, 2600, -2500),
(176, 18, 1500, 250, 350, 1500, 4, 200, NULL, '2024-04-01', '2024-04-30', 800, 3600, -2800),
(177, 19, 1000, 250, 350, 1000, 11, 2000, NULL, '2024-04-01', '2024-04-30', 22000, 2600, 19400),
(178, 20, 1000, 250, 350, 1000, 2, 70, NULL, '2024-04-01', '2024-04-30', 140, 2600, -2460),
(179, 21, 1000, 250, 350, 1000, 3, 70, NULL, '2024-04-01', '2024-04-30', 210, 2600, -2390),
(180, 59, 1000, 250, 350, 1000, 2, 20, NULL, '2024-04-01', '2024-04-30', 40, 2600, -2560),
(182, 62, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-04-30', 0, 2600, -2600),
(183, 64, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-04-30', 0, 2600, -2600),
(184, 65, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-04-30', 0, 2600, -2600),
(185, 66, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-04-30', 0, 2600, -2600),
(186, 17, 1000, 250, 350, 1000, 1, 100, NULL, '2024-04-01', '2024-05-03', 100, 2600, -2500),
(187, 18, 1500, 250, 350, 1500, 4, 200, NULL, '2024-04-01', '2024-05-03', 800, 3600, -2800),
(188, 19, 1000, 250, 350, 1000, 11, 2000, NULL, '2024-04-01', '2024-05-03', 22000, 2600, 19400),
(189, 20, 1000, 250, 350, 1000, 2, 70, NULL, '2024-04-01', '2024-05-03', 140, 2600, -2460),
(190, 21, 1000, 250, 350, 1000, 3, 70, NULL, '2024-04-01', '2024-05-03', 210, 2600, -2390),
(191, 59, 1000, 250, 350, 1000, 2, 20, NULL, '2024-04-01', '2024-05-03', 40, 2600, -2560),
(193, 62, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-05-03', 0, 2600, -2600),
(194, 64, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-05-03', 0, 2600, -2600),
(195, 65, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-05-03', 0, 2600, -2600),
(196, 66, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-05-03', 0, 2600, -2600),
(198, 2, NULL, 250, 350, NULL, 0, NULL, NULL, '2024-04-01', '2024-04-30', 0, 0, 0),
(199, 17, 1000, 250, 350, 1000, 1, 100, NULL, '2024-04-01', '2024-04-30', 100, 2600, -2500),
(200, 18, 1500, 250, 350, 1500, 4, 200, NULL, '2024-04-01', '2024-04-30', 800, 3600, -2800),
(201, 19, 1000, 250, 350, 1000, 11, 2000, NULL, '2024-04-01', '2024-04-30', 22000, 2600, 19400),
(202, 20, 1000, 250, 350, 1000, 2, 70, NULL, '2024-04-01', '2024-04-30', 140, 2600, -2460),
(203, 21, 1000, 250, 350, 1000, 3, 70, NULL, '2024-04-01', '2024-04-30', 210, 2600, -2390),
(204, 59, 1000, 250, 350, 1000, 2, 20, NULL, '2024-04-01', '2024-04-30', 40, 2600, -2560),
(205, 61, 1000, 250, 350, 1000, 7, 100, NULL, '2024-04-01', '2024-04-30', 700, 2600, -1900),
(206, 62, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-04-30', 0, 2600, -2600),
(207, 64, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-04-30', 0, 2600, -2600),
(208, 65, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-04-30', 0, 2600, -2600),
(209, 66, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-04-30', 0, 2600, -2600),
(210, 67, NULL, 250, 350, NULL, 0, NULL, NULL, '2024-04-01', '2024-04-30', 0, 0, 0),
(211, 68, NULL, 250, 350, NULL, 0, NULL, NULL, '2024-04-01', '2024-04-30', 0, 0, 0),
(212, 69, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-04-30', 0, 2600, -2600),
(213, 61, 1000, 250, 350, 1000, 3, 100, NULL, '2024-05-01', '2024-05-03', 300, 2600, -2300),
(214, 2, NULL, 250, 350, NULL, 0, NULL, NULL, '2024-04-01', '2024-04-30', 0, 0, 0),
(215, 17, 1000, 250, 350, 1000, 1, 100, NULL, '2024-04-01', '2024-04-30', 100, 2600, -2500),
(216, 18, 1500, 250, 350, 1500, 4, 200, NULL, '2024-04-01', '2024-04-30', 800, 3600, -2800),
(217, 19, 1000, 250, 350, 1000, 11, 2000, NULL, '2024-04-01', '2024-04-30', 22000, 2600, 19400),
(218, 20, 1000, 250, 350, 1000, 2, 70, NULL, '2024-04-01', '2024-04-30', 140, 2600, -2460),
(219, 21, 1000, 250, 350, 1000, 3, 70, NULL, '2024-04-01', '2024-04-30', 210, 2600, -2390),
(220, 59, 1000, 250, 350, 1000, 2, 20, NULL, '2024-04-01', '2024-04-30', 40, 2600, -2560),
(221, 61, 1000, 250, 350, 1000, 7, 100, NULL, '2024-04-01', '2024-04-30', 700, 2600, -1900),
(222, 62, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-04-30', 0, 2600, -2600),
(223, 64, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-04-30', 0, 2600, -2600),
(224, 65, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-04-30', 0, 2600, -2600),
(225, 66, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-04-30', 0, 2600, -2600),
(226, 67, NULL, 250, 350, NULL, 0, NULL, NULL, '2024-04-01', '2024-04-30', 0, 0, 0),
(227, 68, NULL, 250, 350, NULL, 0, NULL, NULL, '2024-04-01', '2024-04-30', 0, 0, 0),
(228, 69, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-04-30', 0, 2600, -2600),
(229, 2, NULL, 250, 350, NULL, 0, NULL, NULL, '2024-04-01', '2024-04-30', 0, 0, 0),
(230, 17, 1000, 250, 350, 1000, 1, 100, NULL, '2024-04-01', '2024-04-30', 100, 2600, -2500),
(231, 18, 1500, 250, 350, 1500, 4, 200, NULL, '2024-04-01', '2024-04-30', 800, 3600, -2800),
(232, 19, 1000, 250, 350, 1000, 11, 2000, NULL, '2024-04-01', '2024-04-30', 22000, 2600, 19400),
(233, 20, 1000, 250, 350, 1000, 2, 70, NULL, '2024-04-01', '2024-04-30', 140, 2600, -2460),
(234, 21, 1000, 250, 350, 1000, 3, 70, NULL, '2024-04-01', '2024-04-30', 210, 2600, -2390),
(235, 59, 1000, 250, 350, 1000, 2, 20, NULL, '2024-04-01', '2024-04-30', 40, 2600, -2560),
(236, 61, 1000, 250, 350, 1000, 7, 100, NULL, '2024-04-01', '2024-04-30', 700, 2600, -1900),
(237, 62, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-04-30', 0, 2600, -2600),
(238, 64, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-04-30', 0, 2600, -2600),
(239, 65, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-04-30', 0, 2600, -2600),
(240, 66, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-04-30', 0, 2600, -2600),
(241, 67, NULL, 250, 350, NULL, 0, NULL, NULL, '2024-04-01', '2024-04-30', 0, 0, 0),
(242, 68, NULL, 250, 350, NULL, 0, NULL, NULL, '2024-04-01', '2024-04-30', 0, 0, 0),
(243, 69, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-04-30', 0, 2600, -2600),
(244, 2, NULL, 250, 350, NULL, 0, NULL, NULL, '2024-04-01', '2024-04-30', 0, 0, 0),
(245, 17, 1000, 250, 350, 1000, 1, 100, NULL, '2024-04-01', '2024-04-30', 100, 2600, -2500),
(246, 18, 1500, 250, 350, 1500, 4, 200, NULL, '2024-04-01', '2024-04-30', 800, 3600, -2800),
(247, 19, 1000, 250, 350, 1000, 11, 2000, NULL, '2024-04-01', '2024-04-30', 22000, 2600, 19400),
(248, 20, 1000, 250, 350, 1000, 2, 70, NULL, '2024-04-01', '2024-04-30', 140, 2600, -2460),
(249, 21, 1000, 250, 350, 1000, 3, 70, NULL, '2024-04-01', '2024-04-30', 210, 2600, -2390),
(250, 59, 1000, 250, 350, 1000, 2, 20, NULL, '2024-04-01', '2024-04-30', 40, 2600, -2560),
(251, 61, 1000, 250, 350, 1000, 7, 100, NULL, '2024-04-01', '2024-04-30', 700, 2600, -1900),
(252, 62, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-04-30', 0, 2600, -2600),
(253, 64, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-04-30', 0, 2600, -2600),
(254, 65, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-04-30', 0, 2600, -2600),
(255, 66, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-04-30', 0, 2600, -2600),
(256, 67, NULL, 250, 350, NULL, 0, NULL, NULL, '2024-04-01', '2024-04-30', 0, 0, 0),
(257, 68, NULL, 250, 350, NULL, 0, NULL, NULL, '2024-04-01', '2024-04-30', 0, 0, 0),
(258, 69, 1000, 250, 350, 1000, 0, 20, NULL, '2024-04-01', '2024-04-30', 0, 2600, -2600),
(259, 61, 1000, 250, 350, 1000, 3, 100, NULL, '2024-04-30', '2024-05-03', 300, 2600, -2300),
(260, 19, 1000, 250, 350, 1000, 6, 2000, NULL, '2024-03-30', '2024-04-02', 12000, 2600, 9400),
(261, 19, 1000, 250, 350, 1000, 8, 2000, NULL, '2024-03-30', '2024-04-10', 16000, 2600, 13400),
(262, 19, 1000, 250, 350, 1000, 6, 2000, NULL, '2024-03-30', '2024-04-03', 12000, 2600, 9400);

-- --------------------------------------------------------

--
-- Table structure for table `finance_balance`
--

CREATE TABLE `finance_balance` (
  `id` int(11) NOT NULL,
  `trackingID` varchar(255) NOT NULL,
  `currentbal` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `company` varchar(255) NOT NULL,
  `date` datetime DEFAULT current_timestamp(),
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `finance_balance`
--

INSERT INTO `finance_balance` (`id`, `trackingID`, `currentbal`, `cost`, `company`, `date`, `description`) VALUES
(1, '0', 0, 0, 'FINANCE', '2024-04-19 22:36:47', ''),
(13, 'TN66504884de4cc', 70295, 70295, 'Point of Sales', '2024-05-24 15:57:56', 'Daily Sales'),
(14, 'TN66504884e111b', 14395, -55900, 'Finance', '2024-05-24 15:57:56', 'Expenses'),
(19, 'TN665067418f13e', 47495, -13400, 'Human Resources', '2024-05-24 18:09:05', 'Payroll Given'),
(20, 'TN6659fec317360', 57832, 10337, 'Point of Sales', '2024-06-01 00:45:55', 'Daily Sales'),
(21, 'TN6659fec3198b6', 1932, -55900, 'Finance', '2024-06-01 00:45:55', 'Expenses'),
(22, 'TN665bc99906041', 1946, 14, 'Point of Sales', '2024-06-02 09:23:37', 'Daily Sales'),
(23, 'TN665d1b70f2e8b', 1543, -403, 'Point of Sales', '2024-06-03 09:25:04', 'Daily Sales'),
(24, 'TN665d1cfa5ae91', -7857, -9400, 'Human Resources', '2024-06-03 09:31:38', 'Payroll Given');

-- --------------------------------------------------------

--
-- Table structure for table `finance_daily_sales`
--

CREATE TABLE `finance_daily_sales` (
  `id` int(11) NOT NULL,
  `totalsales` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `finance_daily_sales`
--

INSERT INTO `finance_daily_sales` (`id`, `totalsales`) VALUES
(1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `finance_expenses`
--

CREATE TABLE `finance_expenses` (
  `id` int(11) NOT NULL,
  `expenses` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `cost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `finance_expenses`
--

INSERT INTO `finance_expenses` (`id`, `expenses`, `date`, `cost`) VALUES
(1, 'Electricity', '2024-04-20 22:05:23', 500),
(2, 'Water', '2024-04-20 22:05:38', 200),
(3, 'Rent', '2024-04-20 22:05:57', 50000),
(4, 'Supplies', '2024-05-09 16:22:42', 200),
(5, 'Other Utilities', '2024-05-10 16:23:40', 5000);

-- --------------------------------------------------------

--
-- Table structure for table `finance_inbox`
--

CREATE TABLE `finance_inbox` (
  `id` int(11) NOT NULL,
  `sender` varchar(255) DEFAULT NULL,
  `receiver` varchar(255) DEFAULT NULL,
  `msginfo` text DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `finance_inbox`
--

INSERT INTO `finance_inbox` (`id`, `sender`, `receiver`, `msginfo`, `date`) VALUES
(3147385, 'Finance', 'Purchase Order', 'hello bakit may 5000 na bawas dito', '2024-06-08 16:29:49'),
(3147386, 'Finance', 'Human Resources', 'hiii yung payroll ni ganto', '2024-06-08 16:30:37'),
(3147387, 'Finance', 'Sales', 'thank you sa pera', '2024-06-08 16:32:14'),
(3147388, 'Finance', 'Purchase Order', 'hiaaa', '2024-06-08 16:32:27');

-- --------------------------------------------------------

--
-- Table structure for table `finance_inbox_hr`
--

CREATE TABLE `finance_inbox_hr` (
  `id` int(11) NOT NULL,
  `sender` varchar(255) DEFAULT NULL,
  `receiver` varchar(255) DEFAULT NULL,
  `msginfo` text DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `finance_inbox_hr`
--

INSERT INTO `finance_inbox_hr` (`id`, `sender`, `receiver`, `msginfo`, `date`) VALUES
(1, 'Finance', 'Human Resources', 'hiii yung payroll ni ganto', '2024-06-08 16:30:37');

-- --------------------------------------------------------

--
-- Table structure for table `finance_inbox_inv`
--

CREATE TABLE `finance_inbox_inv` (
  `id` int(11) NOT NULL,
  `sender` varchar(255) DEFAULT NULL,
  `receiver` varchar(255) DEFAULT NULL,
  `msginfo` text DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `finance_inbox_po`
--

CREATE TABLE `finance_inbox_po` (
  `id` int(11) NOT NULL,
  `sender` varchar(255) DEFAULT NULL,
  `receiver` varchar(255) DEFAULT NULL,
  `msginfo` text DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `finance_inbox_po`
--

INSERT INTO `finance_inbox_po` (`id`, `sender`, `receiver`, `msginfo`, `date`) VALUES
(1, 'Finance', 'Purchase Order', 'hello bakit may 5000 na bawas dito', '2024-06-08 16:29:49'),
(2, 'Finance', 'Purchase Order', 'hiaaa', '2024-06-08 16:32:27');

-- --------------------------------------------------------

--
-- Table structure for table `finance_inbox_sales`
--

CREATE TABLE `finance_inbox_sales` (
  `id` int(11) NOT NULL,
  `sender` varchar(255) DEFAULT NULL,
  `receiver` varchar(255) DEFAULT NULL,
  `msginfo` text DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `finance_inbox_sales`
--

INSERT INTO `finance_inbox_sales` (`id`, `sender`, `receiver`, `msginfo`, `date`) VALUES
(1, 'Finance', 'Sales', 'thank you sa pera', '2024-06-08 16:32:14');

-- --------------------------------------------------------

--
-- Table structure for table `finance_receipt`
--

CREATE TABLE `finance_receipt` (
  `id` int(11) NOT NULL,
  `reportid` int(11) NOT NULL,
  `date` datetime DEFAULT current_timestamp(),
  `finance` int(11) NOT NULL DEFAULT 0,
  `po` int(11) NOT NULL DEFAULT 0,
  `hr` int(11) NOT NULL DEFAULT 0,
  `inventory` int(11) NOT NULL DEFAULT 0,
  `sales` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `finance_receipt`
--

INSERT INTO `finance_receipt` (`id`, `reportid`, `date`, `finance`, `po`, `hr`, `inventory`, `sales`) VALUES
(1, 4897142, '2024-06-01 00:45:55', 0, 0, -9400, 0, -389);

-- --------------------------------------------------------

--
-- Table structure for table `finance_receipt_backup`
--

CREATE TABLE `finance_receipt_backup` (
  `id` int(11) NOT NULL,
  `reportid` int(11) NOT NULL,
  `date` date DEFAULT current_timestamp(),
  `finance` int(11) NOT NULL DEFAULT 0,
  `po` int(11) NOT NULL DEFAULT 0,
  `hr` int(11) NOT NULL DEFAULT 0,
  `inventory` int(11) NOT NULL DEFAULT 0,
  `sales` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `finance_receipt_backup`
--

INSERT INTO `finance_receipt_backup` (`id`, `reportid`, `date`, `finance`, `po`, `hr`, `inventory`, `sales`) VALUES
(1, 1, '2024-04-23', 0, 0, 0, 0, 0),
(2, 4377144, '2024-06-08', -213500, -14628, -32877, 0, 469418),
(3, 3234745, '2024-05-24', -55900, 0, 0, 0, 74543),
(4, 2427295, '2024-06-01', -167700, 0, -81000, 0, 100848);

-- --------------------------------------------------------

--
-- Table structure for table `holiday`
--

CREATE TABLE `holiday` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `title` text NOT NULL,
  `details` text NOT NULL,
  `offset_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `holiday`
--

INSERT INTO `holiday` (`id`, `date`, `title`, `details`, `offset_date`) VALUES
(1, '2024-04-09', 'Araw ng Kagitingan', 'Araw ng Kagitingan', '2024-04-09'),
(2, '2024-05-01', 'Labor Day', 'Labor Day', '2024-05-01'),
(3, '2024-06-12', 'Independence Day', 'Independence Day', '2024-06-12'),
(5, '2024-08-30', 'National Heroes Day', 'National Heroes Day', '2024-08-30'),
(6, '2024-11-30', 'Bonifacio Day', 'Bonifacio Day', '2024-11-30'),
(7, '2024-12-25', 'Christmas Day', 'Christmas Day', '2024-12-25'),
(9, '2024-12-30', 'Rizal Day', 'Rizal Day', '2024-12-30');

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE `info` (
  `item_id` int(11) NOT NULL,
  `stock_piece` int(11) DEFAULT NULL,
  `price_piece` int(11) DEFAULT NULL,
  `price_pack` int(11) DEFAULT NULL,
  `piece_pack` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `info`
--

INSERT INTO `info` (`item_id`, `stock_piece`, `price_piece`, `price_pack`, `piece_pack`) VALUES
(1, 3000, 10, 1000, 100),
(2, 3000, 17, 1700, 100),
(3, 3000, 17, 1700, 100),
(4, 3000, 17, 1700, 100),
(5, 3000, 17, 1700, 100),
(6, 3000, 114, 1140, 10),
(7, 3000, 150, 1500, 10),
(8, 3000, 20, 200, 10),
(9, 3000, 30, 300, 10),
(10, 3000, 50, 500, 10),
(11, 3000, 50, 5000, 100),
(12, 3000, 105, 10500, 100),
(13, 3000, 95, 950, 10),
(14, 3000, 445, 4450, 10),
(15, 3000, 400, 4000, 10),
(16, 3000, 145, 1450, 10),
(17, 3000, 479, 4790, 10),
(18, 3000, 47, 470, 10),
(19, 3000, 115, 1150, 10),
(20, 3000, 135, 1350, 10),
(21, 3000, 10, 1000, 100),
(22, 3000, 9, 900, 100),
(23, 3000, 21, 2100, 100),
(24, 3000, 30, 3000, 100),
(25, 3000, 8, 800, 100);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inventory_id` int(11) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `qty_stock` int(11) NOT NULL,
  `unit_cost` int(50) NOT NULL,
  `showroom_quantity_stock` int(11) NOT NULL,
  `price_pack` int(11) NOT NULL,
  `piece_pack` int(11) NOT NULL,
  `stock_pack` int(11) NOT NULL,
  `unit_inv_qty` int(11) NOT NULL,
  `storage_location` varchar(255) NOT NULL,
  `showroom_location` varchar(255) NOT NULL,
  `quantity_to_reorder` int(11) NOT NULL,
  `total_cost` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inventory_id`, `supplier`, `category`, `brand`, `type`, `unit`, `qty_stock`, `unit_cost`, `showroom_quantity_stock`, `price_pack`, `piece_pack`, `stock_pack`, `unit_inv_qty`, `storage_location`, `showroom_location`, `quantity_to_reorder`, `total_cost`) VALUES
(1, 'Unilever', 'Analgesic', 'Bioflu', 'Tablet', '500mg', 50, 8, 89, 192, 24, 10, 1050, 'MainStockroomNorth-A1', 'MedNorth-A1', 100, 8400),
(2, 'Unilever', ' Anilide preparations', 'Biogesic', 'Tablet', '500mg', 50, 5, 94, 1000, 200, 10, 9850, 'MainStockroomNorth-A2', 'MedNorth-A2', 100, 49250),
(3, 'Unilever', 'Dermatological Agents ', 'Cortaid', 'Tablet', '30g', 50, 350, 98, 3500, 10, 10, 390, 'MainStockroomNorth-A3', 'MedNorth-A3', 100, 136500),
(4, 'Unilever', 'Laxatives ', 'Dulcolax', 'Tablet', '5mg', 50, 30, 97, 300, 10, 10, 360, 'MainStockroomNorth-A4', 'MedNorth-A4', 100, 10800),
(5, 'Unilever', 'Immunizations ', 'Fluzone', 'Tablet', '5ml', 50, 500, 99, 5000, 10, 10, 395, 'MainStockroomNorth-A5', 'MedNorth-A5', 100, 197500),
(6, 'Unilever', 'Diuretics ', 'Lasix', 'Tablet', '40mg', 50, 75, 98, 750, 10, 10, 350, 'MainStockroomNorth-B1', 'MedNorth-B1', 100, 26250);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_logs`
--

CREATE TABLE `inventory_logs` (
  `log_id` int(11) NOT NULL,
  `inventory_id` date NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `brand_name` varchar(255) NOT NULL,
  `employee` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `stock_after` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_logs`
--

INSERT INTO `inventory_logs` (`log_id`, `inventory_id`, `date`, `brand_name`, `employee`, `quantity`, `stock_after`, `reason`) VALUES
(1, '0000-00-00', '2024-05-31 18:47:13', 'Bioflu', 'Micosh Yutuc', 50, 1200, 'Purchase order'),
(2, '0000-00-00', '2024-05-31 18:47:27', 'Biogesic', 'Micosh Yutuc', 1, 10000, 'Purchase order'),
(3, '0000-00-00', '2024-05-31 18:48:00', 'Cortaid', 'Micosh Yutuc', 1, 500, 'Purchase order'),
(4, '0000-00-00', '2024-05-31 18:48:30', 'Dulcolax', 'Micosh Yutuc', 1, 500, 'Purchase order'),
(5, '0000-00-00', '2024-05-31 18:49:06', 'Fluzone', 'Micosh Yutuc', 1, 500, 'Purchase order'),
(6, '0000-00-00', '2024-05-31 18:49:28', 'Lasix', 'Micosh Yutuc', 1, 500, 'Purchase order'),
(7, '0000-00-00', '2024-05-31 18:49:55', 'Bioflu', 'Zenji Yangco', 100, 1100, 'Edit Item'),
(8, '0000-00-00', '2024-05-31 18:50:08', 'Biogesic', 'Zenji Yangco', 100, 9900, 'Edit Item'),
(9, '0000-00-00', '2024-05-31 18:50:20', 'Cortaid', 'Zenji Yangco', 100, 400, 'Edit Item'),
(10, '0000-00-00', '2024-05-31 18:50:35', 'Dulcolax', 'Zenji Yangco', 100, 400, 'Edit Item'),
(11, '0000-00-00', '2024-05-31 18:50:52', 'Fluzone', 'Zenji Yangco', 100, 400, 'Edit Item'),
(12, '0000-00-00', '2024-05-31 18:51:05', 'Lasix', 'Zenji Yangco', 100, 400, 'Edit Item'),
(13, '0000-00-00', '2024-05-31 18:51:51', 'Bioflu', 'Zenji Yangco', 50, 1050, 'Add Discount'),
(14, '0000-00-00', '2024-05-31 18:52:10', 'Biogesic', 'Zenji Yangco', 50, 9850, 'Add Discount'),
(15, '0000-00-00', '2024-05-31 18:53:38', 'Cortaid', 'Zenji Yangco', 10, 390, 'Add Discount'),
(16, '0000-00-00', '2024-05-31 18:53:59', 'Dulcolax', 'Zenji Yangco', 20, 380, 'Add Discount'),
(17, '0000-00-00', '2024-05-31 18:54:25', 'Fluzone', 'Zenji Yangco', 5, 395, 'Add Discount'),
(18, '0000-00-00', '2024-05-31 18:54:50', 'Lasix', 'Zenji Yangco', 50, 350, 'Add Discount'),
(19, '0000-00-00', '2024-05-31 18:55:13', 'Dulcolax', 'Zenji Yangco', 0, 0, 'Request order'),
(20, '0000-00-00', '2024-05-31 18:56:22', 'Dulcolax', 'Zenji Yangco', 20, 360, 'Return Item'),
(21, '0000-00-00', '2024-05-31 19:23:31', 'Bioflu', 'Regina Velarde', 10, 90, 'Sell Item'),
(22, '0000-00-00', '2024-05-31 19:23:46', 'Biogesic', 'Regina Velarde', 5, 95, 'Sell Item'),
(23, '0000-00-00', '2024-05-31 19:23:58', 'Cortaid', 'Regina Velarde', 1, 99, 'Sell Item'),
(24, '0000-00-00', '2024-05-31 19:24:10', 'Lasix', 'Regina Velarde', 2, 98, 'Sell Item'),
(25, '0000-00-00', '2024-05-31 19:24:18', 'Fluzone', 'Regina Velarde', 1, 99, 'Sell Item'),
(26, '0000-00-00', '2024-05-31 19:24:30', 'Dulcolax', 'Regina Velarde', 3, 97, 'Sell Item'),
(27, '0000-00-00', '2024-06-01 01:19:41', 'Bioflu', 'Regina Velarde', 1, 89, 'Sell Item'),
(28, '0000-00-00', '2024-06-01 01:19:41', 'Biogesic', 'Regina Velarde', 1, 94, 'Sell Item'),
(29, '0000-00-00', '2024-06-02 01:24:32', 'Cortaid', 'Regina Velarde', 1, 98, 'Sell Item');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `generic_name` varchar(255) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `expiration_date` date NOT NULL,
  `medicine_type` varchar(255) NOT NULL,
  `dosage` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `generic_name`, `brand_name`, `expiration_date`, `medicine_type`, `dosage`) VALUES
(1, 'Paracetamol', 'Solmux Advance', '2024-06-12', 'Tablet', '500mg'),
(2, 'Melatonin', 'Sleepwell', '2024-06-15', 'Tablet', '500mg'),
(3, 'Paracetamol', 'Biogesic', '2026-06-12', 'Tablet', '500mg'),
(4, 'Mefenamic', 'Dolfenal', '2024-06-15', 'Tablet', '500mg'),
(5, 'Loperamide', 'Diatabs', '2024-06-15', 'Tablet', '500mg'),
(6, 'Multivitamins', 'Tiki-tiki', '2024-06-15', 'Syrup', '120ml'),
(7, 'Multivitamins', 'Celine', '2024-06-15', 'Syrup', '120ml'),
(8, 'Multivitamins', 'Lola Remedios', '2024-06-15', 'Syrup', '15ml'),
(9, 'Multivitamins', 'Gaviscon', '2024-06-15', 'Syrup', '150ml'),
(10, 'Antibiotic', 'Erceflora', '2024-06-15', 'Syrup', '5ml'),
(11, 'Painreliever', 'EyeMo', '2024-06-15', 'Drops', '7.5ml'),
(12, 'MetahylSalicylate', 'Katinko', '2024-06-15', 'Drops', '10mg'),
(13, 'PhenylephrineHCI', 'Neozep', '2024-06-15', 'Syrup', '10ml'),
(14, 'Clinicians Xylitol', 'Vicks', '2024-06-15', 'Drops', '15ml'),
(15, 'Lidocaine Baclometasone', 'Otiderm', '2024-06-15', 'Drops', '15ml'),
(16, 'Botanicals', 'OFF!', '2024-06-15', 'Topicals', '100ml'),
(17, 'Benzoyl Peroxide', 'BENZAC', '2024-06-15', 'Topicals', '50ml'),
(18, 'Benzoyl Peroxide', 'Dan Mei', '2024-06-15', 'Topicals', '7mg'),
(19, 'Petrolatum', 'Vaseline', '2024-06-15', 'Topicals', '106mg'),
(20, 'Sulfur', 'Bioderm', '2024-06-15', 'Topicals', '5mg'),
(21, 'Paracetamol', 'Alaxan', '2024-06-15', 'Capsules', '200mg'),
(22, 'Ibuprofen', 'Advil', '2024-06-15', 'Capsules', '200mg'),
(23, 'Silymarin', 'Liveraide', '2024-06-15', 'Capsules', '125mg'),
(24, 'Lutein Extract', 'Optein lutein', '2024-06-15', 'Capsules', '200mg'),
(25, 'Mucosolvan', 'Ambroxol', '2024-06-15', 'Capsules', '30mg');

-- --------------------------------------------------------

--
-- Table structure for table `item_mapping`
--

CREATE TABLE `item_mapping` (
  `map_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `shelves` varchar(20) NOT NULL,
  `colum` int(11) NOT NULL,
  `row` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `item_mapping`
--

INSERT INTO `item_mapping` (`map_id`, `item_id`, `shelves`, `colum`, `row`) VALUES
(23, 8, 'MedSouth', 2, 'B'),
(24, 1, 'MedNorth', 1, 'A'),
(25, 2, 'MedNorth', 2, 'A'),
(26, 3, 'MedNorth', 3, 'A'),
(27, 4, 'MedNorth', 4, 'A'),
(28, 5, 'MedNorth', 5, 'A'),
(29, 6, 'MedNorth', 1, 'B');

-- --------------------------------------------------------

--
-- Table structure for table `medicinetype`
--

CREATE TABLE `medicinetype` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicinetype`
--

INSERT INTO `medicinetype` (`type_id`, `type_name`) VALUES
(1, 'Creams and Ointments'),
(2, 'Tablet'),
(3, 'Capsule'),
(4, 'Syrup'),
(5, 'Injectables'),
(6, 'Patches'),
(7, 'Suppositories'),
(8, 'Nasal Sprays'),
(9, 'Eye Drops'),
(10, 'Dental Products'),
(11, 'Medical Devices'),
(12, 'Contraceptives'),
(13, 'Personal Lubricants'),
(14, 'Hygiene Products'),
(15, 'Antiseptic Solutions'),
(16, 'Allergy Relief Products'),
(17, 'Wound Dressings'),
(18, 'Diabetic Supplies'),
(19, 'Digestive Aids'),
(20, 'Vitamins and Minerals'),
(21, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `medicine_list`
--

CREATE TABLE `medicine_list` (
  `medicine_id` int(11) NOT NULL,
  `brand` text NOT NULL,
  `unit` text NOT NULL,
  `unit_qty` text NOT NULL,
  `wholesaleprice` text NOT NULL,
  `unitcost` text NOT NULL,
  `description` text NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicine_list`
--

INSERT INTO `medicine_list` (`medicine_id`, `brand`, `unit`, `unit_qty`, `wholesaleprice`, `unitcost`, `description`, `supplier_id`, `category_id`, `type_id`) VALUES
(1, 'Lipitor', '80mg', '10', '1200', '120', 'beta-blockers', 2, 2, 2),
(2, 'Cortaid', '30g', '10', '3500', '350', 'for skin conditions', 2, 3, 1),
(3, 'Lasix', '40mg', '10', '750', '75', 'for fluid retention', 2, 4, 2),
(4, 'Premarin', '1.25mg', '10', '1500', '150', 'hormone replacement therapy', 2, 5, 2),
(5, 'Fluzone', '5ml', '10', '5000', '500', 'vaccines', 2, 6, 5),
(6, 'Dulcolax', '5mg', '10', '300', '30', 'Stool Softeners', 2, 7, 2),
(7, 'Bioflu', '500mg', '24', '192', '8', 'Anti flu', 2, 8, 2),
(8, 'Biogesic', '500mg', '200', '1000', '5', 'relieve pain and fever', 2, 9, 2);

-- --------------------------------------------------------

--
-- Table structure for table `meremove`
--

CREATE TABLE `meremove` (
  `id` int(11) NOT NULL,
  `cashier_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `scale` varchar(11) NOT NULL,
  `reasons` varchar(255) NOT NULL,
  `stat` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mesali`
--

CREATE TABLE `mesali` (
  `id` int(11) NOT NULL,
  `transact_no` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `scale` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mesali`
--

INSERT INTO `mesali` (`id`, `transact_no`, `item_id`, `qty`, `scale`) VALUES
(1, 'BTA-20/000', 1, 1, 'piece'),
(2, 'BTA-20/000', 2, 1, 'piece'),
(3, 'BTA-20/001', 6, 1, 'piece'),
(4, 'BTA-20/000', 1, 10, 'piece'),
(5, 'BTA-20/001', 2, 5, 'piece'),
(6, 'BTA-20/002', 3, 1, 'piece'),
(7, 'BTA-20/003', 6, 2, 'piece'),
(8, 'BTA-20/004', 5, 1, 'piece'),
(9, 'BTA-20/005', 4, 3, 'piece'),
(10, 'BTA-20/006', 1, 1, 'piece'),
(11, 'BTA-20/006', 2, 1, 'piece'),
(12, 'BTA-20/007', 3, 1, 'piece');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `shipping_fee` decimal(10,2) DEFAULT NULL,
  `grand_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `subtotal`, `tax`, `shipping_fee`, `grand_total`) VALUES
(35, 85932.00, 10311.84, 600.00, 96843.84),
(36, 3996.60, 479.59, 600.00, 5076.19),
(37, 4596.60, 551.59, 600.00, 5748.19),
(38, 4596.60, 551.59, 600.00, 5748.19),
(39, 3996.60, 479.59, 600.00, 5076.19),
(40, 3996.60, 479.59, 600.00, 5076.19),
(41, 3996.60, 479.59, 600.00, 5076.19),
(42, 491581.80, 58989.82, 600.00, 551171.62),
(43, 3996.60, 479.59, 600.00, 5076.19),
(44, 3996.60, 479.59, 600.00, 5076.19),
(45, 3996.60, 479.59, 600.00, 5076.19),
(46, 3996.60, 479.59, 600.00, 5076.19),
(47, 3996.60, 479.59, 600.00, 5076.19),
(48, 3996.60, 479.59, 600.00, 5076.19),
(49, 3996.60, 479.59, 600.00, 5076.19),
(50, 3996.60, 479.59, 600.00, 5076.19),
(51, 39966.00, 4795.92, 600.00, 45361.92),
(52, 15986.40, 1918.37, 600.00, 18504.77),
(53, 148881.00, 17865.72, 600.00, 167346.72),
(54, 128898.00, 15467.76, 600.00, 144965.76),
(55, 59949.00, 7193.88, 600.00, 67742.88),
(56, 9193.20, 1103.18, 600.00, 10896.38),
(57, 63945.60, 7673.47, 600.00, 72219.07),
(58, 39966.00, 4795.92, 600.00, 45361.92),
(59, 105721.80, 12686.62, 600.00, 119008.42),
(60, 39966.00, 4795.92, 600.00, 45361.92),
(61, 19983.00, 2397.96, 600.00, 22980.96),
(62, 61989.80, 7438.78, 600.00, 70028.58);

-- --------------------------------------------------------

--
-- Table structure for table `order_table`
--

CREATE TABLE `order_table` (
  `id` int(11) NOT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `shipping_fee` decimal(10,2) DEFAULT NULL,
  `grand_total` decimal(10,2) DEFAULT NULL,
  `payment_method` text NOT NULL,
  `supplier_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_table`
--

INSERT INTO `order_table` (`id`, `subtotal`, `tax`, `shipping_fee`, `grand_total`, `payment_method`, `supplier_id`) VALUES
(2, 4000.00, 480.00, 600.00, 4600.00, 'Cash on Delivery', 2),
(3, 2000.00, 240.00, 600.00, 2600.00, 'Cash on Delivery', 2),
(4, 1129.60, 135.55, 600.00, 1729.60, 'Cash on Delivery', 1),
(5, 1129.60, 135.55, 600.00, 1729.60, 'Cash on Delivery', 1),
(6, 1129.60, 135.55, 600.00, 1729.60, 'Cash on Delivery', 1),
(7, 1129.60, 135.55, 600.00, 1729.60, 'Cash on Delivery', 1),
(8, 1129.60, 135.55, 600.00, 1729.60, 'Cash on Delivery', 1),
(9, 1129.60, 135.55, 600.00, 1729.60, 'Cash on Delivery', 1),
(10, 1129.60, 135.55, 600.00, 1729.60, 'Cash on Delivery', 1),
(11, 1500.00, 180.00, 600.00, 2100.00, 'Cash on Delivery', 2),
(12, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(13, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(14, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(15, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(16, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(17, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(18, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(19, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(20, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(21, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(22, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(23, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(24, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(25, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(26, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(27, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(28, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(29, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(30, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(31, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(32, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(33, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(34, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(35, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(36, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(37, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(38, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(39, 250.00, 30.00, 600.00, 850.00, 'Cash on Delivery', 1),
(40, 150.00, 18.00, 600.00, 750.00, 'Cash on Delivery', 2),
(41, 500.00, 60.00, 600.00, 1100.00, 'Cash on Delivery', 2),
(42, 500.00, 60.00, 600.00, 1100.00, 'Cash on Delivery', 2),
(43, 15.00, 1.80, 600.00, 615.00, 'Cash on Delivery', 2),
(44, 500.00, 60.00, 600.00, 1100.00, 'Cash on Delivery', 2),
(45, 1.25, 0.15, 600.00, 601.25, 'Cash on Delivery', 2),
(46, 500.00, 60.00, 600.00, 1100.00, 'Cash on Delivery', 2),
(47, 15.00, 1.80, 600.00, 615.00, 'Cash on Delivery', 2),
(48, 5.00, 0.60, 600.00, 605.00, 'Cash on Delivery', 2),
(49, 5.00, 0.60, 600.00, 605.00, 'Cash on Delivery', 2),
(50, 1.25, 0.15, 600.00, 601.25, 'Cash on Delivery', 2),
(51, 500.00, 60.00, 600.00, 1100.00, 'Cash on Delivery', 2),
(52, 500.00, 60.00, 600.00, 1100.00, 'Cash on Delivery', 2),
(53, 500.00, 60.00, 600.00, 1100.00, 'Cash on Delivery', 2),
(54, 500.00, 60.00, 600.00, 1100.00, 'Cash on Delivery', 2),
(55, 500.00, 60.00, 600.00, 1100.00, 'Cash on Delivery', 2),
(56, 2000.00, 240.00, 600.00, 2600.00, 'Cash on Delivery', 2),
(57, 500.00, 60.00, 600.00, 1100.00, 'Cash on Delivery', 2),
(58, 3000.00, 360.00, 600.00, 3600.00, 'Cash on Delivery', 2),
(59, 5000.00, 600.00, 540.00, 5540.00, 'Cash on Delivery', 2),
(60, 1500.00, 180.00, 600.00, 2100.00, 'Cash on Delivery', 2),
(61, 27000.00, 3240.00, 120.00, 27120.00, 'Cash on Delivery', 2),
(62, 2500.00, 300.00, 600.00, 3100.00, 'Cash on Delivery', 2),
(63, 5500.00, 660.00, 540.00, 6040.00, 'Cash on Delivery', 2),
(64, 1000.00, 120.00, 600.00, 1600.00, 'Cash on Delivery', 2),
(65, 9000.00, 1080.00, 540.00, 9540.00, 'Cash on Delivery', 2),
(66, 25000.00, 3000.00, 120.00, 25120.00, 'Cash on Delivery', 2),
(67, 19200.00, 2304.00, 360.00, 19560.00, 'Cash on Delivery', 2),
(68, 50000.00, 6000.00, 0.00, 50000.00, 'Cash on Delivery', 2),
(69, 175000.00, 21000.00, 0.00, 175000.00, 'Cash on Delivery', 2),
(70, 15000.00, 1800.00, 360.00, 15360.00, 'Cash on Delivery', 2),
(71, 200000.00, 24000.00, 0.00, 200000.00, 'Cash on Delivery', 2),
(72, 37500.00, 4500.00, 0.00, 37500.00, 'Cash on Delivery', 2),
(73, 9600.00, 1152.00, 540.00, 10140.00, 'Cash on Delivery', 2),
(74, 50000.00, 6000.00, 0.00, 50000.00, 'Cash on Delivery', 2),
(75, 175000.00, 21000.00, 0.00, 175000.00, 'Cash on Delivery', 2),
(76, 15000.00, 1800.00, 360.00, 15360.00, 'Cash on Delivery', 2),
(77, 250000.00, 30000.00, 0.00, 250000.00, 'Cash on Delivery', 2),
(78, 37500.00, 4500.00, 0.00, 37500.00, 'Cash on Delivery', 2),
(79, 9600.00, 1152.00, 540.00, 10140.00, 'Cash on Delivery', 2),
(80, 50000.00, 6000.00, 0.00, 50000.00, 'Cash on Delivery', 2),
(81, 175000.00, 21000.00, 0.00, 175000.00, 'Cash on Delivery', 2),
(82, 15000.00, 1800.00, 360.00, 15360.00, 'Cash on Delivery', 2),
(83, 250000.00, 30000.00, 0.00, 250000.00, 'Cash on Delivery', 2),
(84, 750.00, 90.00, 600.00, 1350.00, 'Cash on Delivery', 2),
(85, 36750.00, 4410.00, 0.00, 36750.00, 'Cash on Delivery', 2),
(86, 9600.00, 1152.00, 540.00, 10140.00, 'Cash on Delivery', 2),
(87, 50000.00, 6000.00, 0.00, 50000.00, 'Cash on Delivery', 2),
(88, 175000.00, 21000.00, 0.00, 175000.00, 'Cash on Delivery', 2),
(89, 15000.00, 1800.00, 360.00, 15360.00, 'Cash on Delivery', 2),
(90, 9600.00, 1152.00, 540.00, 10140.00, 'Cash on Delivery', 2),
(91, 50000.00, 6000.00, 0.00, 50000.00, 'Cash on Delivery', 2),
(92, 175000.00, 21000.00, 0.00, 175000.00, 'Cash on Delivery', 2),
(93, 15000.00, 1800.00, 360.00, 15360.00, 'Cash on Delivery', 2),
(94, 250000.00, 30000.00, 0.00, 250000.00, 'Cash on Delivery', 2),
(95, 37500.00, 4500.00, 0.00, 37500.00, 'Cash on Delivery', 2);

-- --------------------------------------------------------

--
-- Table structure for table `payroll_all_history`
--

CREATE TABLE `payroll_all_history` (
  `payroll_id` int(10) NOT NULL,
  `payroll_date_from` date NOT NULL,
  `payroll_date_to` date NOT NULL,
  `payroll_date_released` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payroll_all_history`
--

INSERT INTO `payroll_all_history` (`payroll_id`, `payroll_date_from`, `payroll_date_to`, `payroll_date_released`) VALUES
(16, '2024-04-09', '2024-04-24', '2024-05-02'),
(17, '2024-04-01', '2024-05-01', '2024-05-02'),
(44, '2024-04-01', '2024-05-02', '2024-05-02'),
(45, '2024-04-01', '2024-04-30', '2024-05-02'),
(46, '2024-04-01', '2024-05-03', '2024-05-02'),
(47, '2024-04-01', '2024-04-30', '2024-05-24'),
(48, '2024-04-01', '2024-04-30', '2024-05-24'),
(49, '2024-04-01', '2024-04-30', '2024-05-24'),
(50, '2024-04-01', '2024-04-30', '2024-05-24');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_table`
--

CREATE TABLE `purchase_table` (
  `id` int(11) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `unit_qty` int(11) NOT NULL,
  `unitcost` decimal(10,2) NOT NULL,
  `total_cost` decimal(10,2) NOT NULL,
  `purchase_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_table`
--

INSERT INTO `purchase_table` (`id`, `brand`, `unit_qty`, `unitcost`, `total_cost`, `purchase_date`) VALUES
(1, 'Biogesic', 600, 5.99, 599.00, '2024-04-24'),
(2, 'Bioflu', 100, 5.99, 599.00, '2024-04-24'),
(3, 'Neozep', 200, 12.75, 2550.00, '2024-04-26');

-- --------------------------------------------------------

--
-- Table structure for table `request_leave`
--

CREATE TABLE `request_leave` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `absence_type` text NOT NULL,
  `reason` text NOT NULL,
  `status` text NOT NULL DEFAULT 'Pending',
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_leave`
--

INSERT INTO `request_leave` (`id`, `employee_id`, `start_date`, `end_date`, `absence_type`, `reason`, `status`, `file_name`, `file_type`, `file_path`) VALUES
(54, 17, '2024-04-22', '2024-04-24', 'Maternity Leave', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Facilisi cras fermentum odio eu feugiat. Lacus laoreet non curabitur gravida arcu ac tortor dignissim. Potenti nullam ac tortor vitae purus faucibus ornare. Parturient montes nascetur ridiculus mus mauris vitae ultricies leo integer. Neque laoreet suspendisse interdum consectetur libero id faucibus nisl tincidunt. Aliquet risus feugiat in ante. Neque convallis a cras semper auctor neque vitae. Tempor nec feugiat nisl pretium. Sit amet mattis vulputate enim nulla aliquet porttitor lacus luctus. Egestas tellus rutrum tellus pellentesque eu. Eget nunc lobortis mattis aliquam. Ut placerat orci nulla pellentesque dignissim. Vehicula ipsum a arcu cursus vitae. Suspendisse interdum consectetur libero id faucibus nisl tincidunt. Egestas erat imperdiet sed euismod nisi porta lorem. Et netus et malesuada fames ac turpis egestas.', 'Approved', 'Voters Certificate.jpg', 'image/jpeg', 'uploads/Voters Certificate.jpg'),
(55, 17, '2024-04-23', '2024-04-27', 'Sick Leave', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Facilisi cras fermentum odio eu feugiat. Lacus laoreet non curabitur gravida arcu ac tortor dignissim. Potenti nullam ac tortor vitae purus faucibus ornare. Parturient montes nascetur ridiculus mus mauris vitae ultricies leo integer. Neque laoreet suspendisse interdum consectetur libero id faucibus nisl tincidunt. Aliquet risus feugiat in ante. Neque convallis a cras semper auctor neque vitae. Tempor nec feugiat nisl pretium. Sit amet mattis vulputate enim nulla aliquet porttitor lacus luctus. Egestas tellus rutrum tellus pellentesque eu. Eget nunc lobortis mattis aliquam. Ut placerat orci nulla pellentesque dignissim. Vehicula ipsum a arcu cursus vitae. Suspendisse interdum consectetur libero id faucibus nisl tincidunt. Egestas erat imperdiet sed euismod nisi porta lorem. Et netus et malesuada fames ac turpis egestas.', 'Rejected', 'luci.jpg', 'image/jpeg', 'uploads/luci.jpg'),
(78, 69, '2024-05-25', '2024-05-30', 'Sick Leave', 'ulul kaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'Approved', 'unity.png', 'image/png', 'includes/pictures/uploadsunity.png'),
(79, 69, '2024-05-25', '2024-05-27', 'Vacation Leave', 'mag sswimming sa space hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhjhgfhfghfghfghfgh', 'Rejected', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `request_order`
--

CREATE TABLE `request_order` (
  `id` int(11) NOT NULL,
  `employee` varchar(50) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_order`
--

INSERT INTO `request_order` (`id`, `employee`, `supplier`, `category`, `brand`, `type`, `unit`) VALUES
(1, '', 'Unilever', 'Laxatives ', 'Dulcolax', 'Tablet', '5mg');

-- --------------------------------------------------------

--
-- Table structure for table `return_item`
--

CREATE TABLE `return_item` (
  `id` int(11) NOT NULL,
  `employee` varchar(50) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `unit_qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `return_item`
--

INSERT INTO `return_item` (`id`, `employee`, `supplier`, `category`, `brand`, `type`, `unit`, `unit_qty`) VALUES
(1, 'Zenji Yangco', 'Unilever', 'Laxatives ', 'Dulcolax', 'Tablet', '', 20);

-- --------------------------------------------------------

--
-- Table structure for table `return_status`
--

CREATE TABLE `return_status` (
  `id` int(11) NOT NULL,
  `return_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `return_status`
--

INSERT INTO `return_status` (`id`, `return_name`) VALUES
(1, 'Pending'),
(2, 'Accepted'),
(3, 'Declined');

-- --------------------------------------------------------

--
-- Table structure for table `return_table`
--

CREATE TABLE `return_table` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `delivery_status_id` int(11) DEFAULT NULL,
  `transaction_number` varchar(255) NOT NULL,
  `reason_return` text NOT NULL,
  `item` varchar(255) NOT NULL,
  `Note` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `return_status_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shift`
--

CREATE TABLE `shift` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `effective_date` date NOT NULL,
  `created_date` date NOT NULL,
  `created_by` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shift`
--

INSERT INTO `shift` (`id`, `employee_id`, `effective_date`, `created_date`, `created_by`) VALUES
(61, 18, '2024-04-05', '2024-04-05', 'Lavin'),
(66, 59, '2024-04-16', '2024-04-16', 'Marco Torres'),
(68, 62, '2024-04-19', '2024-04-19', 'Marco Torres'),
(69, 64, '2024-04-22', '2024-04-22', 'Marco Torres'),
(70, 64, '2024-04-22', '2024-04-22', 'Marco Torres'),
(93, 61, '2024-05-02', '2024-05-02', 'Marco Torres'),
(97, 69, '2024-05-24', '2024-05-24', '888888888888888888888888888888888888888888888888');

-- --------------------------------------------------------

--
-- Table structure for table `shiftdetails`
--

CREATE TABLE `shiftdetails` (
  `id` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `day` text NOT NULL,
  `time_in` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `break_out` time DEFAULT NULL,
  `break_in` time DEFAULT NULL,
  `broken_time_in` time DEFAULT NULL,
  `broken_time_out` time DEFAULT NULL,
  `broken_break_in` time DEFAULT NULL,
  `broken_break_out` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shiftdetails`
--

INSERT INTO `shiftdetails` (`id`, `shift_id`, `employee_id`, `day`, `time_in`, `time_out`, `break_out`, `break_in`, `broken_time_in`, `broken_time_out`, `broken_break_in`, `broken_break_out`) VALUES
(65, 61, 18, 'Friday', '00:01:00', '05:00:00', '12:00:00', '13:00:00', NULL, NULL, NULL, NULL),
(70, 66, 59, 'Monday', '07:00:00', '16:00:00', '12:00:00', '13:00:00', NULL, NULL, NULL, NULL),
(73, 68, 62, 'Monday', '07:16:00', '19:16:00', '00:00:00', '00:00:00', NULL, NULL, NULL, NULL),
(74, 68, 62, 'Tuesday', '00:00:00', '00:00:00', '00:00:00', '00:00:00', NULL, NULL, NULL, NULL),
(75, 68, 62, 'Wednesday', '00:00:00', '00:00:00', '00:00:00', '00:00:00', NULL, NULL, NULL, NULL),
(76, 68, 62, 'Thursday', '00:00:00', '00:00:00', '00:00:00', '00:00:00', NULL, NULL, NULL, NULL),
(77, 68, 62, 'Friday', '19:15:00', '00:00:00', '00:00:00', '00:00:00', NULL, NULL, NULL, NULL),
(78, 69, 64, 'Monday', '04:48:00', '00:00:00', '00:00:00', '00:00:00', NULL, NULL, NULL, NULL),
(79, 70, 64, 'Monday', '05:02:00', '00:00:00', '00:00:00', '00:00:00', NULL, NULL, NULL, NULL),
(105, 93, 61, 'Thursday', '22:10:00', '22:10:00', '22:10:00', '22:10:00', NULL, NULL, NULL, NULL),
(106, 94, 69, 'Monday', '17:47:00', '22:53:00', '19:47:00', '20:47:00', NULL, NULL, NULL, NULL),
(107, 95, 69, 'Monday', '18:48:00', '18:49:00', '16:52:00', '22:49:00', NULL, NULL, NULL, NULL),
(108, 96, 69, 'Monday', '17:50:00', '21:49:00', '05:49:00', '17:49:00', NULL, NULL, NULL, NULL),
(109, 97, 69, 'Friday', '17:15:00', '23:15:00', '22:15:00', '22:17:00', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `address` text NOT NULL,
  `contact_person` text NOT NULL,
  `contact` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `shippingfee` text NOT NULL,
  `modeofpayment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `name`, `address`, `contact_person`, `contact`, `email`, `shippingfee`, `modeofpayment`) VALUES
(1, 'Pfizer', 'Florida, Pampanga', 'Veronica Valenzuela', '09090909090', 'valenzuelaveronica@gmail.com', '600.00', 'Cash on Delivery'),
(2, 'Unilever', 'Bacolor,Pampanga', 'Cyra Tapang', '09123456789', 'joy_joy@gmail.com', '600.00', 'Cash on Delivery');

-- --------------------------------------------------------

--
-- Table structure for table `transact`
--

CREATE TABLE `transact` (
  `id` int(11) NOT NULL,
  `transact_no` varchar(255) NOT NULL,
  `cashier_id` int(11) NOT NULL,
  `pay_method` varchar(20) NOT NULL,
  `sub_total` float(100,2) NOT NULL,
  `type` varchar(20) NOT NULL,
  `total_dis` float(100,2) NOT NULL,
  `total_amount` float(100,2) NOT NULL,
  `bayad` float(100,2) NOT NULL,
  `sukli` float(100,2) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transact`
--

INSERT INTO `transact` (`id`, `transact_no`, `cashier_id`, `pay_method`, `sub_total`, `type`, `total_dis`, `total_amount`, `bayad`, `sukli`, `date`) VALUES
(1, 'BTA-20/000', 20, 'Cash', 90.00, 'None', 0.00, 90.00, 90.00, 0.00, '2024-06-01 03:23:31'),
(2, 'BTA-20/001', 20, 'Cash', 30.00, 'None', 0.00, 30.00, 30.00, 0.00, '2024-06-01 03:23:46'),
(3, 'BTA-20/002', 20, 'Cash', 403.00, 'None', 0.00, 403.00, 403.00, 0.00, '2024-06-01 03:23:58'),
(4, 'BTA-20/003', 20, 'Cash', 172.00, 'None', 0.00, 172.00, 200.00, 28.00, '2024-06-01 03:24:10'),
(5, 'BTA-20/004', 20, 'Cash', 575.00, 'None', 0.00, 575.00, 600.00, 25.00, '2024-06-01 03:24:18'),
(6, 'BTA-20/005', 20, 'Cash', 105.00, 'None', 0.00, 105.00, 150.00, 45.00, '2024-06-01 03:24:30'),
(7, 'BTA-20/006', 20, 'Cash', 15.00, 'Senior', 0.75, 14.25, 100.00, 85.75, '2024-06-01 09:19:41'),
(8, 'BTA-20/007', 20, 'Cash', 403.00, 'None', 0.00, 403.00, 500.00, 97.00, '2024-06-02 09:24:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `cart_sales`
--
ALTER TABLE `cart_sales`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `cart_table`
--
ALTER TABLE `cart_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `delivery_status_id` (`delivery_status_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `daily_time_record`
--
ALTER TABLE `daily_time_record`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `ada` (`rec_emp_id`),
  ADD KEY `dada` (`record_emp_name`),
  ADD KEY `sasa` (`record_emp_position`);

--
-- Indexes for table `delivery_status`
--
ALTER TABLE `delivery_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discounted_item`
--
ALTER TABLE `discounted_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dtrrevised`
--
ALTER TABLE `dtrrevised`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `asdds` (`employee_id`);

--
-- Indexes for table `employee_details`
--
ALTER TABLE `employee_details`
  ADD PRIMARY KEY (`employee_id`),
  ADD KEY `employee_name` (`employee_name`),
  ADD KEY `employee_position` (`employee_position`);

--
-- Indexes for table `employee_salary`
--
ALTER TABLE `employee_salary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `employee_salary_revised`
--
ALTER TABLE `employee_salary_revised`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `finance_balance`
--
ALTER TABLE `finance_balance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance_daily_sales`
--
ALTER TABLE `finance_daily_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance_expenses`
--
ALTER TABLE `finance_expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance_inbox`
--
ALTER TABLE `finance_inbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance_inbox_hr`
--
ALTER TABLE `finance_inbox_hr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance_inbox_inv`
--
ALTER TABLE `finance_inbox_inv`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance_inbox_po`
--
ALTER TABLE `finance_inbox_po`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance_inbox_sales`
--
ALTER TABLE `finance_inbox_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance_receipt`
--
ALTER TABLE `finance_receipt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance_receipt_backup`
--
ALTER TABLE `finance_receipt_backup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holiday`
--
ALTER TABLE `holiday`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inventory_id`);

--
-- Indexes for table `inventory_logs`
--
ALTER TABLE `inventory_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_mapping`
--
ALTER TABLE `item_mapping`
  ADD PRIMARY KEY (`map_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `medicinetype`
--
ALTER TABLE `medicinetype`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `medicine_list`
--
ALTER TABLE `medicine_list`
  ADD PRIMARY KEY (`medicine_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `meremove`
--
ALTER TABLE `meremove`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `cashier_id` (`cashier_id`);

--
-- Indexes for table `mesali`
--
ALTER TABLE `mesali`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `transact_no` (`transact_no`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_table`
--
ALTER TABLE `order_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `payroll_all_history`
--
ALTER TABLE `payroll_all_history`
  ADD PRIMARY KEY (`payroll_id`);

--
-- Indexes for table `purchase_table`
--
ALTER TABLE `purchase_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_leave`
--
ALTER TABLE `request_leave`
  ADD PRIMARY KEY (`id`),
  ADD KEY `connect` (`employee_id`);

--
-- Indexes for table `request_order`
--
ALTER TABLE `request_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `return_item`
--
ALTER TABLE `return_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `return_status`
--
ALTER TABLE `return_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `return_table`
--
ALTER TABLE `return_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `delivery_status_id` (`delivery_status_id`),
  ADD KEY `return_status_id` (`return_status_id`);

--
-- Indexes for table `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `shiftdetails`
--
ALTER TABLE `shiftdetails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asa` (`shift_id`),
  ADD KEY `adasdas` (`employee_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `transact`
--
ALTER TABLE `transact`
  ADD PRIMARY KEY (`transact_no`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `cashier_id` (`cashier_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart_sales`
--
ALTER TABLE `cart_sales`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cart_table`
--
ALTER TABLE `cart_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `delivery_status`
--
ALTER TABLE `delivery_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `discounted_item`
--
ALTER TABLE `discounted_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `dtrrevised`
--
ALTER TABLE `dtrrevised`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `employee_details`
--
ALTER TABLE `employee_details`
  MODIFY `employee_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `employee_salary`
--
ALTER TABLE `employee_salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `employee_salary_revised`
--
ALTER TABLE `employee_salary_revised`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=263;

--
-- AUTO_INCREMENT for table `finance_balance`
--
ALTER TABLE `finance_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `finance_daily_sales`
--
ALTER TABLE `finance_daily_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `finance_expenses`
--
ALTER TABLE `finance_expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `finance_inbox_hr`
--
ALTER TABLE `finance_inbox_hr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `finance_inbox_inv`
--
ALTER TABLE `finance_inbox_inv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `finance_inbox_po`
--
ALTER TABLE `finance_inbox_po`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `finance_inbox_sales`
--
ALTER TABLE `finance_inbox_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `finance_receipt`
--
ALTER TABLE `finance_receipt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `finance_receipt_backup`
--
ALTER TABLE `finance_receipt_backup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `holiday`
--
ALTER TABLE `holiday`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inventory_logs`
--
ALTER TABLE `inventory_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `item_mapping`
--
ALTER TABLE `item_mapping`
  MODIFY `map_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `medicinetype`
--
ALTER TABLE `medicinetype`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `medicine_list`
--
ALTER TABLE `medicine_list`
  MODIFY `medicine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `meremove`
--
ALTER TABLE `meremove`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mesali`
--
ALTER TABLE `mesali`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `order_table`
--
ALTER TABLE `order_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `payroll_all_history`
--
ALTER TABLE `payroll_all_history`
  MODIFY `payroll_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `purchase_table`
--
ALTER TABLE `purchase_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `request_leave`
--
ALTER TABLE `request_leave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `request_order`
--
ALTER TABLE `request_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `return_item`
--
ALTER TABLE `return_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `return_status`
--
ALTER TABLE `return_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `return_table`
--
ALTER TABLE `return_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shift`
--
ALTER TABLE `shift`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `shiftdetails`
--
ALTER TABLE `shiftdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transact`
--
ALTER TABLE `transact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`);

--
-- Constraints for table `cart_sales`
--
ALTER TABLE `cart_sales`
  ADD CONSTRAINT `cart_sales_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `inventory` (`inventory_id`),
  ADD CONSTRAINT `cart_sales_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `inventory` (`inventory_id`);

--
-- Constraints for table `cart_table`
--
ALTER TABLE `cart_table`
  ADD CONSTRAINT `cart_table_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order_table` (`id`),
  ADD CONSTRAINT `cart_table_ibfk_2` FOREIGN KEY (`delivery_status_id`) REFERENCES `delivery_status` (`id`);

--
-- Constraints for table `dtrrevised`
--
ALTER TABLE `dtrrevised`
  ADD CONSTRAINT `asdds` FOREIGN KEY (`employee_id`) REFERENCES `employee_details` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
