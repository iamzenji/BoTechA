-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2024 at 05:09 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `category`, `brand`, `type`, `unit`, `price`, `quantity`, `unit_qty`, `total`, `order_id`, `tracking_number`) VALUES
(1, 'Paracetamol', 'Biogesic', 'Tablet', '500mg', 3996.60, 10, 1500, 39966.00, 35, 'TN6622b7703b880'),
(2, 'Paracetamol', 'Biogesic Tempra', 'Syrup', '500mg', 3996.60, 10, 2000, 39966.00, 35, 'TN6622b7703b880'),
(10, 'Paracetamol', 'Biogesic', 'Tablet', '500mg', 3996.60, 1, 150, 3996.60, 46, 'TN6622c49c0baa2'),
(11, 'Paracetamol', 'Biogesic', 'Tablet', '500mg', 3996.60, 1, 150, 3996.60, 47, 'TN6622c4a9cd1de'),
(12, 'Paracetamol', 'Biogesic', 'Tablet', '500mg', 3996.60, 1, 150, 3996.60, 48, 'TN6622c51ee1b96'),
(13, 'Paracetamol', 'Biogesic', 'Tablet', '500mg', 3996.60, 1, 150, 3996.60, 49, 'TN6622c52015140'),
(14, 'Paracetamol', 'Biogesic', 'Tablet', '500mg', 3996.60, 1, 150, 3996.60, 50, 'TN6622c5b582317'),
(15, 'Paracetamol', 'Biogesic', 'Tablet', '500mg', 3996.60, 10, 1500, 39966.00, 51, 'TN6622c6870179f'),
(16, 'Paracetamol', 'Biogesic', 'Tablet', '500mg', 3996.60, 4, 600, 15986.40, 52, 'TN6622c72fd8318'),
(17, 'Paracetamol', 'Biogesic', 'Tablet', '500mg', 3996.60, 10, 1500, 39966.00, 53, 'TN6622d013a4fc3'),
(18, 'Paracetamol', 'Biogesic', 'Tablet', '500mg', 3996.60, 10, 1500, 39966.00, 53, 'TN6622d013a4fc3'),
(19, 'Paracetamol', 'Biogesic Tempra', 'Syrup', '500mg', 3996.60, 15, 3000, 39966.00, 53, 'TN6622d013a4fc3'),
(20, 'Paracetamol', 'Biogesic', 'Tablet', '500mg', 3996.60, 15, 2250, 59949.00, 54, 'TN6622d081d85f6'),
(21, 'Paracetamol', 'Biogesic Tempra', 'Syrup', '500mg', 3996.60, 15, 3000, 59949.00, 54, 'TN6622d081d85f6'),
(22, 'Paracetamol', 'Biogesic', 'Tablet', '500mg', 3996.60, 15, 2250, 59949.00, 55, 'TN6622d09b4fd78'),
(23, 'Paracetamol', 'Biogesic Tempra', 'Syrup', '250mg', 4596.60, 2, 400, 9193.20, 56, 'TN6622d1ddec4c3'),
(24, 'Paracetamol', 'Biogesic', 'Tablet', '500mg', 3996.60, 16, 2400, 63945.60, 57, 'TN6622d2f3f1117'),
(25, 'Paracetamol', 'Biogesic', 'Tablet', '500mg', 3996.60, 10, 1500, 39966.00, 58, 'TN66230441dd49b'),
(26, 'Paracetamol', 'Biogesic Tempra', 'Syrup', '250mg', 4596.60, 23, 4600, 105721.80, 59, 'TN66240c58f1774'),
(27, 'Paracetamol', 'Biogesic', 'Tablet', '500mg', 3996.60, 10, 1500, 39966.00, 60, 'TN66240dd39b32e'),
(28, 'Paracetamol', 'Biogesic', 'Tablet', '500mg', 3996.60, 5, 750, 19983.00, 61, 'TN66240ed3d7656'),
(29, 'Paracetamol', 'Biogesic', 'Tablet', '500mg', 3996.60, 3, 450, 11989.80, 62, 'TN66241a6fb379d'),
(30, 'Paracetamol', 'Neozep', 'Tablet', '500mg', 3996.60, 10, 2000, 11989.80, 62, 'TN66241a6fb379d');

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
(2, 'Hormonal Therapies', 'Premarin', '0.625mg', 1000.00, 100.00, 1, 10, 1000.00, 2, 1, 'PO-662f34a71b2ce', '2024-05-04', '2024-04-29', '07:48:23', 0, 0),
(3, 'Dermatological Agents ', 'Cortaid', '15 grams', 2000.00, 200.00, 1, 10, 2000.00, 3, 1, 'PO-662f395f506d8', '2024-05-04', '2024-04-29', '08:08:31', 0, 0),
(4, 'Paracetamol', 'Biogesic', '250mg', 1129.60, 41.00, 1, 150, 1129.60, 4, 1, 'PO-662f39972eafc', '2024-05-04', '2024-04-29', '08:09:27', 1, 0),
(5, 'Paracetamol', 'Biogesic', '250mg', 1129.60, 41.00, 1, 150, 1129.60, 6, 1, 'PO-662f3a537a300', '2024-05-04', '2024-04-29', '08:12:35', 1, 0),
(6, 'Paracetamol', 'Biogesic', '250mg', 1129.60, 41.00, 1, 150, 1129.60, 7, 1, 'PO-662f465ebf105', '2024-05-04', '2024-04-29', '09:03:58', 1, 0),
(7, 'Paracetamol', 'Biogesic', '250mg', 1129.60, 41.00, 1, 150, 1129.60, 8, 1, 'PO-662f4b2b14f7b', '2024-05-04', '2024-04-29', '09:24:27', 1, 0),
(8, 'Paracetamol', 'Biogesic', '250mg', 1129.60, 41.00, 1, 150, 1129.60, 9, 1, 'PO-662f4b5ba9fbb', '2024-05-04', '2024-04-29', '09:25:15', 1, 0),
(9, 'Paracetamol', 'Biogesic', '250mg', 1129.60, 41.00, 1, 150, 1129.60, 10, 1, 'PO-662f4cce0400c', '2024-05-04', '2024-04-29', '09:31:26', 1, 0),
(10, 'Hormonal Therapies', 'Premarin', '1.25mg', 1500.00, 150.00, 1, 10, 1500.00, 11, 1, 'PO-662f4dc2c89f3', '2024-05-04', '2024-04-29', '09:35:30', 2, 0),
(11, 'Paracetamol', 'Biogesic', 'Capsule', 250.00, 1129.60, 1, 41, 250.00, 12, 1, 'PO-662f4f650c686', '2024-05-04', '2024-04-29', '09:42:29', 1, 0),
(12, 'Paracetamol', 'Biogesic', '41', 250.00, 1129.60, 1, 150, 250.00, 13, 1, 'PO-662f5755b86a8', '2024-05-04', '2024-04-29', '10:16:21', 1, 0),
(13, '', '', NULL, NULL, NULL, NULL, NULL, NULL, 14, 1, 'PO-662f58d172b71', '2024-05-04', '2024-04-29', '10:22:41', 1, 3),
(14, '', '', '', 0.00, 0.00, 0, 0, 0.00, 15, 1, 'PO-662f593e8e23b', '2024-05-04', '2024-04-29', '10:24:30', 1, 3),
(15, 'Paracetamol', 'Biogesic', '41', 250.00, 1129.60, 1, 150, 250.00, 16, 1, 'PO-662f59ab74274', '2024-05-04', '2024-04-29', '10:26:19', 1, 0),
(16, 'Paracetamol', 'Biogesic', '41', 250.00, 1129.60, 1, 150, 250.00, 17, 1, 'PO-662f5be7901f8', '2024-05-04', '2024-04-29', '10:35:51', 1, 0),
(17, 'Paracetamol', 'Biogesic', '41', 250.00, 1129.60, 1, 150, 250.00, 18, 1, 'PO-662f5c6f3224a', '2024-05-04', '2024-04-29', '10:38:07', 1, 0),
(18, 'Paracetamol', 'Biogesic', '41', 250.00, 1129.60, 1, 150, 250.00, 19, 1, 'PO-662f5c86f3c4f', '2024-05-04', '2024-04-29', '10:38:30', 1, 0),
(19, 'Paracetamol', 'Biogesic', '41', 250.00, 1129.60, 1, 150, 250.00, 21, 1, 'PO-662f5f3434a6e', '2024-05-04', '2024-04-29', '10:49:56', 1, 0),
(20, 'Paracetamol', 'Biogesic', '41', 250.00, 1129.60, 1, 150, 250.00, 22, 1, 'PO-662f5f8adc6a9', '2024-05-04', '2024-04-29', '10:51:22', 1, 0),
(21, 'Paracetamol', 'Biogesic', '41', 250.00, 1129.60, 1, 150, 250.00, 23, 1, 'PO-662f60723918d', '2024-05-04', '2024-04-29', '10:55:14', 1, 0),
(22, 'Paracetamol', 'Biogesic', '41', 250.00, 1129.60, 1, 150, 250.00, 31, 1, 'PO-662f635d94f31', '2024-05-04', '2024-04-29', '11:07:41', 1, 0),
(23, 'Paracetamol', 'Biogesic', '41', 250.00, 1129.60, 1, 150, 250.00, 32, 1, 'PO-662f636839c22', '2024-05-04', '2024-04-29', '11:07:52', 1, 0),
(24, 'Paracetamol', 'Biogesic', '41', 250.00, 1129.60, 1, 150, 250.00, 37, 1, 'PO-662f650c26d52', '2024-05-04', '2024-04-29', '11:14:52', 0, 0),
(25, 'Paracetamol', 'Biogesic', '41', 250.00, 1129.60, 1, 150, 250.00, 38, 1, 'PO-662f658d128db', '2024-05-04', '2024-04-29', '11:17:01', 1, 3),
(26, 'Paracetamol', 'Biogesic', '41', 250.00, 1129.60, 1, 150, 250.00, 39, 1, 'PO-662f65e1a2cd7', '2024-05-04', '2024-04-29', '11:18:25', 1, 3),
(27, 'Dermatological Agents ', 'Cortaid', '350.00', 30.00, 3500.00, 1, 10, 30.00, 40, 1, 'PO-662f661932567', '2024-05-04', '2024-04-29', '11:19:21', 2, 1),
(28, 'Analgesic', 'Bioflu', '8', 500.00, 500.00, 1, 24, 500.00, 41, 4, 'PO-662f70e50dbf3', '2024-05-04', '2024-04-29', '12:05:25', 2, 2),
(29, 'Analgesic', 'Bioflu', '8', 500.00, 500.00, 1, 24, 500.00, 42, 5, 'PO-662fdd652cdaa', '2024-05-04', '2024-04-29', '19:48:21', 2, 2),
(30, 'Dermatological Agents ', 'Cortaid', '200.00', 15.00, 2000.00, 1, 10, 15.00, 43, 5, 'PO-662fde192f4cd', '2024-05-04', '2024-04-29', '19:51:21', 2, 1),
(31, 'Analgesic', 'Bioflu', '8', 500.00, 500.00, 1, 24, 500.00, 44, 5, 'PO-662fe4e1261b3', '2024-05-04', '2024-04-29', '20:20:17', 2, 2),
(32, 'Hormonal Therapies', 'Premarin', '150.00', 1.25, 1500.00, 1, 10, 1.25, 45, 5, 'PO-662fe8e2a5fd3', '2024-05-04', '2024-04-29', '20:37:22', 2, 2),
(33, 'Analgesic', 'Bioflu', '8', 500.00, 500.00, 1, 24, 500.00, 46, 5, 'PO-662fe98cbde8a', '2024-05-04', '2024-04-29', '20:40:12', 2, 2),
(34, 'Dermatological Agents ', 'Cortaid', '200.00', 15.00, 2000.00, 1, 10, 15.00, 47, 5, 'PO-662fea893b5e6', '2024-05-04', '2024-04-29', '20:44:25', 2, 1),
(35, 'Laxatives ', 'Dulcolax', '30.00', 5.00, 300.00, 1, 10, 5.00, 48, 5, 'PO-662ffe57c83c7', '2024-05-04', '2024-04-29', '22:08:55', 2, 2),
(36, 'Immunizations ', 'Fluzone', '500.00', 5.00, 5000.00, 1, 10, 5.00, 49, 5, 'PO-6630588f4ed65', '2024-05-05', '2024-04-30', '04:33:51', 2, 5),
(37, 'Hormonal Therapies', 'Premarin', '150.00', 1.25, 1500.00, 1, 10, 1.25, 50, 1, 'PO-66305a847d6d1', '2024-05-05', '2024-04-30', '04:42:12', 2, 2);

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
(8, 'Analgesic');

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
  `value` decimal(10,0) NOT NULL,
  `unit_qty` int(11) NOT NULL,
  `total_cost` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discounted_item`
--

INSERT INTO `discounted_item` (`id`, `employee`, `supplier`, `category`, `brand`, `type`, `value`, `unit_qty`, `total_cost`) VALUES
(1, '', 'UNILAB', 'Paracetamol', 'Neozep', 'Tablet', 5, 50, 0),
(2, 'Zenji Yangco', 'UNILAB', 'Paracetamol', 'Neozep', 'Tablet', 4, 10, 40),
(3, 'Zenji Yangco', 'UNILAB', 'Paracetamol', 'Biogesic', 'Tablet', 4, 10, 40);

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
  `remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dtrrevised`
--

INSERT INTO `dtrrevised` (`record_id`, `employee_id`, `date`, `time_in`, `time_out`, `remarks`) VALUES
(1, 17, '2024-03-30', '08:18:22', '09:18:22', ''),
(2, 17, '2024-03-31', '08:25:54', '09:25:54', ''),
(3, 17, '2024-04-01', '08:26:55', '09:26:55', 'Late and Valid Time Out'),
(6, 19, '2024-03-30', '09:51:15', '10:51:15', ''),
(7, 19, '2024-03-31', '09:51:36', '10:51:36', ''),
(8, 20, '2024-03-30', '09:52:16', '10:52:16', ''),
(9, 20, '2024-03-31', '09:52:38', '10:52:38', ''),
(10, 21, '2024-03-30', '09:53:06', '10:53:06', ''),
(11, 21, '2024-03-31', '09:53:27', '10:53:27', ''),
(30, 18, '2024-03-16', '08:00:00', '20:00:00', ''),
(31, 18, '2024-03-17', '08:00:00', '20:00:00', ''),
(32, 19, '2024-04-01', '07:00:00', '11:00:00', ''),
(33, 19, '2024-04-10', '07:00:00', '09:00:00', ''),
(34, 19, '2024-04-11', '08:00:00', '12:00:00', ''),
(35, 19, '2024-04-12', '07:00:00', '09:00:00', ''),
(36, 18, '2024-04-10', '07:00:00', '09:00:00', ''),
(37, 18, '2024-04-12', '07:00:00', '09:00:00', ''),
(38, 20, '2024-04-10', '07:00:00', '09:00:00', ''),
(39, 21, '2024-04-10', '07:00:00', '09:00:00', ''),
(44, 55, '2024-04-01', '05:18:20', '19:18:54', '');

-- --------------------------------------------------------

--
-- Table structure for table `employee_details`
--

CREATE TABLE `employee_details` (
  `employee_id` int(10) NOT NULL,
  `employee_name` varchar(200) NOT NULL,
  `employee_position` varchar(250) NOT NULL,
  `employee_contact` varchar(200) NOT NULL,
  `employee_datestart` date DEFAULT NULL,
  `employee_username` varchar(255) NOT NULL,
  `employee_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_details`
--

INSERT INTO `employee_details` (`employee_id`, `employee_name`, `employee_position`, `employee_contact`, `employee_datestart`, `employee_username`, `employee_password`) VALUES
(17, 'Marco Torres', 'HR Officer', '09556454874', '2024-03-16', 'Marco_1', 'Marco_1'),
(18, 'Micosh Yutuc', 'Purchase Order Officer', '09154751547', '2024-03-16', 'Micosh_1', 'Micosh_1'),
(19, 'Aeron Herrera', 'Finance Officer', '09123854784', '2024-03-16', 'Aeron_1', 'Aeron_1'),
(20, 'Regina Velarde', 'Sales Officer - Cashier', '09548975891', '2024-03-16', 'Regina_1', 'regina_1'),
(21, 'Zenji Yangco', 'Inventory Officer', '09651254985', '2024-03-16', 'Zenji_1', 'Zenji_1'),
(55, 'Trisha Macapagal', 'HR Officer', '09458745618', '2024-04-13', 'Trisha_1', 'Trisha_1');

-- --------------------------------------------------------

--
-- Table structure for table `employee_salary`
--

CREATE TABLE `employee_salary` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `salary` int(50) NOT NULL,
  `insurance` int(50) DEFAULT 1000,
  `tax` int(50) DEFAULT 1000,
  `hours_worked` int(50) NOT NULL,
  `pay_per_hour` int(50) DEFAULT 10,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_salary`
--

INSERT INTO `employee_salary` (`id`, `employee_id`, `salary`, `insurance`, `tax`, `hours_worked`, `pay_per_hour`, `date`) VALUES
(4, 18, 0, 1500, 1500, 0, 25, '2024-04-09'),
(5, 19, 0, 1000, 1000, 3, 2000, '2024-04-09'),
(6, 17, 0, 1000, 1000, 0, 100, '2024-04-09'),
(7, 20, 0, 1000, 1000, 0, 70, '2024-04-09'),
(8, 21, 0, 1000, 1000, 0, 70, '2024-04-09');

-- --------------------------------------------------------

--
-- Table structure for table `employee_salary_revised`
--

CREATE TABLE `employee_salary_revised` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `salary` int(50) NOT NULL,
  `insurance` int(50) DEFAULT 1000,
  `tax` int(50) DEFAULT 1000,
  `hours_worked` int(50) NOT NULL,
  `pay_per_hour` int(50) DEFAULT 10,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_salary_revised`
--

INSERT INTO `employee_salary_revised` (`id`, `employee_id`, `salary`, `insurance`, `tax`, `hours_worked`, `pay_per_hour`, `date`) VALUES
(23, 19, 0, 1000, 1000, 10, 2000, '2024-04-09'),
(27, 19, 0, 1000, 1000, 2, 2000, '2024-04-09'),
(29, 19, 0, 1000, 1000, 2, 2000, '2024-04-09'),
(30, 18, 0, 1500, 1500, 24, 200, '2024-04-09'),
(31, 18, 0, 1500, 1500, 2, 200, '2024-04-09'),
(33, 18, 0, 1500, 1500, 2, 200, '2024-04-09'),
(34, 20, 0, 1000, 1000, 2, 70, '2024-04-09'),
(35, 21, 0, 1000, 1000, 2, 70, '2024-04-09'),
(36, 21, 0, 1000, 1000, 2, 70, '2024-04-09'),
(37, 17, 0, 1000, 1000, 3, 100, '2024-04-09');

-- --------------------------------------------------------

--
-- Table structure for table `finance_balance`
--

CREATE TABLE `finance_balance` (
  `transactionID` int(11) NOT NULL,
  `currentbal` int(11) NOT NULL,
  `cost` int(11) DEFAULT NULL,
  `companyname` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `finance_balance`
--

INSERT INTO `finance_balance` (`transactionID`, `currentbal`, `cost`, `companyname`) VALUES
(7794684, -45362, 18505, 0),
(7183168, 0, 45362, 0);

-- --------------------------------------------------------

--
-- Table structure for table `finance_inbox`
--

CREATE TABLE `finance_inbox` (
  `id` int(11) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `msginfo` text DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(55) DEFAULT 'Pending',
  `cost` decimal(10,0) DEFAULT NULL,
  `approvaldate` datetime DEFAULT NULL,
  `approvalmsg` text DEFAULT '----------'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `finance_inbox`
--

INSERT INTO `finance_inbox` (`id`, `company`, `msginfo`, `date`, `status`, `cost`, `approvaldate`, `approvalmsg`) VALUES
(1179392, 'PO', 'Purchase Order Request', '2024-04-20 07:54:41', 'Denied', 45362, '2024-04-20 09:28:20', 'kkk'),
(3897459, 'PO', 'Purchase Order Request', '2024-04-21 02:52:03', 'Pending', 22981, NULL, '----------'),
(4954463, 'PO', 'Purchase Order Request', '2024-04-21 02:47:47', 'Pending', 45362, NULL, '----------'),
(5616664, 'PO', 'Purchase Order Request', '2024-04-21 03:41:35', 'Pending', 70029, NULL, '----------'),
(7118311, 'PO', 'Purchase Order Request', '2024-04-21 02:41:29', 'Pending', 119008, NULL, '----------'),
(7183168, 'PO', 'Purchase Order Request', '2024-04-20 03:31:19', 'Approved', 45362, '2024-04-20 03:46:21', 'as'),
(7794684, 'PO', 'Purchase Order Request', '2024-04-20 03:34:07', 'Approved', 18505, '2024-04-20 03:44:31', 'asd'),
(9006138, 'PO', 'Purchase Order Request', '2024-04-21 03:41:35', 'Pending', 70029, NULL, '----------');

-- --------------------------------------------------------

--
-- Table structure for table `finance_inbox_po`
--

CREATE TABLE `finance_inbox_po` (
  `id` int(11) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `msginfo` text DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(55) DEFAULT 'Pending',
  `cost` decimal(10,0) DEFAULT NULL,
  `approvaldate` datetime DEFAULT NULL,
  `approvalmsg` text DEFAULT '----------'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `finance_inbox_po`
--

INSERT INTO `finance_inbox_po` (`id`, `company`, `msginfo`, `date`, `status`, `cost`, `approvaldate`, `approvalmsg`) VALUES
(1179392, 'PO', 'Purchase Order Request', '2024-04-20 07:54:41', 'Denied', 45362, '2024-04-20 09:28:20', 'kkk'),
(3897459, 'PO', 'Purchase Order Request', '2024-04-21 02:52:03', 'Pending', 22981, NULL, '----------'),
(4954463, 'PO', 'Purchase Order Request', '2024-04-21 02:47:47', 'Pending', 45362, NULL, '----------'),
(5616664, 'PO', 'Purchase Order Request', '2024-04-21 03:41:35', 'Pending', 70029, NULL, '----------'),
(7118311, 'PO', 'Purchase Order Request', '2024-04-21 02:41:29', 'Pending', 119008, NULL, '----------'),
(7183168, 'PO', 'Purchase Order Request', '2024-04-20 03:31:19', 'Approved', 45362, '2024-04-20 03:46:21', 'as'),
(7794684, 'PO', 'Purchase Order Request', '2024-04-20 03:34:07', 'Approved', 18505, '2024-04-20 03:44:31', 'asd'),
(9006138, 'PO', 'Purchase Order Request', '2024-04-21 03:41:35', 'Pending', 70029, NULL, '----------');

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
  `unit_inv_qty` int(11) NOT NULL,
  `unit_cost` int(50) NOT NULL,
  `storage_location` varchar(255) NOT NULL,
  `showroom_quantity_stock` int(11) NOT NULL,
  `showroom_location` varchar(255) NOT NULL,
  `quantity_to_reorder` int(11) NOT NULL,
  `total_cost` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inventory_id`, `supplier`, `category`, `brand`, `type`, `unit`, `qty_stock`, `unit_inv_qty`, `unit_cost`, `storage_location`, `showroom_quantity_stock`, `showroom_location`, `quantity_to_reorder`, `total_cost`) VALUES
(1, 'UNILAB', 'Paracetamol', 'Biogesic', 'Tablet', '500mg', 3, 300, 5, 'IL2', 100, 'SL2', 100, 1500),
(2, 'UNILAB', 'Paracetamol', 'Neozep', 'Tablet', '500mg', 10, 2000, 6, 'IL1', 100, 'SL1', 100, 12000),
(3, 'Unilever', 'Dermatological Agents ', 'Cortaid', 'Tablet', '200.00', 1, 10, 0, '', 0, '', 0, 15),
(4, 'Unilever', 'Analgesic', 'Bioflu', 'Tablet', '8', 1, 24, 0, '', 0, '', 0, 500),
(5, 'Unilever', 'Hormonal Therapies', 'Premarin', 'Tablet', '150.00', 1, 10, 0, '', 0, '', 0, 1),
(6, 'Unilever', 'Laxatives ', 'Dulcolax', 'Tablet', '30.00', 1, 10, 300, '', 0, '', 0, 5),
(7, 'Unilever', 'Dermatological Agents ', 'Cortaid', 'Tablet', '200.00', 1, 10, 2000, '', 0, '', 0, 15),
(8, 'Unilever', 'Immunizations ', 'Fluzone', 'Tablet', '500.00', 1, 10, 5000, '', 0, '', 0, 5);

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
(1, '0000-00-00', '2024-04-20 19:41:35', 'Biogesic', '', 3, 450, 'Purchase order'),
(2, '0000-00-00', '2024-04-20 19:41:35', 'Neozep', '', 10, 2000, 'Purchase order'),
(3, '0000-00-00', '2024-04-20 19:42:38', 'Neozep', '21', 50, 1950, 'Add Discount'),
(4, '0000-00-00', '2024-04-20 19:43:05', 'Biogesic', '21', 20, 430, 'Return Item'),
(5, '0000-00-00', '2024-04-20 19:43:34', 'Neozep', '', 0, 1950, 'Edit Item'),
(6, '0000-00-00', '2024-04-20 19:43:53', 'Biogesic', '', 0, 430, 'Edit Item'),
(7, '0000-00-00', '2024-04-21 09:27:39', 'Neozep', '0', 100, 1850, 'Return Item'),
(8, '0000-00-00', '2024-04-21 10:03:56', 'Biogesic', '0', 100, 330, 'Return Item'),
(9, '0000-00-00', '2024-04-21 10:04:36', 'Biogesic', '', 70, 400, 'Edit Item'),
(10, '0000-00-00', '2024-04-21 10:11:09', 'Biogesic', '0', 100, 300, 'Return Item'),
(11, '0000-00-00', '2024-04-21 10:12:43', 'Biogesic', '0', 100, 200, 'Return Item'),
(12, '0000-00-00', '2024-04-21 10:35:33', 'Neozep', '21', 10, 1810, 'Add Discount'),
(13, '0000-00-00', '2024-04-21 11:22:16', 'Biogesic', '', 200, 400, 'Edit Item'),
(14, '0000-00-00', '2024-04-21 11:22:38', 'Biogesic', 'Zenji Yangco', 100, 300, 'Return Item'),
(15, '0000-00-00', '2024-04-21 11:23:08', 'Biogesic', 'Zenji Yangco', 10, 290, 'Add Discount'),
(16, '0000-00-00', '2024-04-21 15:23:23', 'Neozep', '', 190, 2000, 'Edit Item'),
(17, '0000-00-00', '2024-04-21 15:24:52', 'Biogesic', '', 10, 300, 'Edit Item'),
(18, '0000-00-00', '2024-04-29 19:59:47', '', '', 0, 0, 'Purchase order'),
(19, '0000-00-00', '2024-04-29 20:00:18', '', '', 0, 0, 'Purchase order'),
(20, '0000-00-00', '2024-04-29 20:00:35', 'Cortaid', '', 1, 10, 'Purchase order'),
(21, '0000-00-00', '2024-04-29 20:04:33', '', '', 0, 0, 'Purchase order'),
(22, '0000-00-00', '2024-04-29 20:04:35', '', '', 0, 0, 'Purchase order'),
(23, '0000-00-00', '2024-04-29 20:04:46', '', '', 0, 0, 'Purchase order'),
(24, '0000-00-00', '2024-04-29 20:05:00', 'Bioflu', '', 1, 24, 'Purchase order'),
(25, '0000-00-00', '2024-04-29 20:05:26', '', '', 0, 0, 'Purchase order'),
(26, '0000-00-00', '2024-04-29 20:05:30', '', '', 0, 0, 'Purchase order'),
(27, '0000-00-00', '2024-04-29 20:05:47', 'Premarin', '', 1, 10, 'Purchase order'),
(28, '0000-00-00', '2024-04-29 20:08:57', '', '', 0, 0, 'Purchase order'),
(29, '0000-00-00', '2024-04-29 20:08:58', '', '', 0, 0, 'Purchase order'),
(30, '0000-00-00', '2024-04-29 20:09:00', '', '', 0, 0, 'Purchase order'),
(31, '0000-00-00', '2024-04-29 20:09:01', 'Dulcolax', '', 1, 10, 'Purchase order'),
(32, '0000-00-00', '2024-04-30 02:34:34', '', '', 0, 0, 'Purchase order'),
(33, '0000-00-00', '2024-04-30 02:34:37', '', '', 0, 0, 'Purchase order'),
(34, '0000-00-00', '2024-04-30 02:34:40', 'Cortaid', '', 1, 10, 'Purchase order'),
(35, '0000-00-00', '2024-04-30 02:35:44', '', '', 0, 0, 'Purchase order'),
(36, '0000-00-00', '2024-04-30 02:35:49', '', '', 0, 0, 'Purchase order'),
(37, '0000-00-00', '2024-04-30 02:35:52', '', '', 0, 0, 'Purchase order'),
(38, '0000-00-00', '2024-04-30 02:42:54', '', '', 0, 0, 'Purchase order'),
(39, '0000-00-00', '2024-04-30 02:42:57', '', '', 0, 0, 'Purchase order'),
(40, '0000-00-00', '2024-04-30 02:43:02', '', '', 0, 0, 'Purchase order'),
(41, '0000-00-00', '2024-04-30 02:43:07', 'Fluzone', '', 1, 10, 'Purchase order');

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
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `section` int(11) NOT NULL,
  `colum` int(11) NOT NULL,
  `row` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `item_mapping`
--

INSERT INTO `item_mapping` (`id`, `item_id`, `section`, `colum`, `row`) VALUES
(1, 1, 1, 1, 'a'),
(2, 2, 1, 1, 'b'),
(3, 3, 1, 1, 'c'),
(4, 4, 1, 1, 'd'),
(5, 5, 1, 1, 'e'),
(6, 6, 1, 2, 'a'),
(7, 7, 1, 2, 'b'),
(8, 8, 1, 2, 'c'),
(9, 9, 1, 2, 'd'),
(10, 10, 1, 1, 'e'),
(11, 11, 2, 1, 'a'),
(12, 12, 2, 1, 'b'),
(13, 13, 2, 1, 'c'),
(14, 14, 2, 1, 'd'),
(15, 15, 2, 1, 'e'),
(16, 16, 3, 1, 'a'),
(17, 17, 3, 1, 'b'),
(18, 18, 3, 1, 'c'),
(19, 19, 3, 1, 'd'),
(20, 20, 3, 1, 'e');

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
(42, 'Lipitor', '10 mg', '10.00', '500.00', '50.00', 'beta-blockers', 2, 2, 2),
(43, 'Lipitor', '20 mg', '10.00', '750.00', '75.00', 'beta-blockers', 2, 2, 2),
(44, 'Lipitor', '40 mg', '10.00', '1000.00', '100.00', 'beta-blockers', 2, 2, 2),
(45, 'Lipitor', '80mg', '10.00', '1200.00', '120.00', 'beta-blockers', 2, 2, 2),
(46, 'Cortaid', '15 grams', '10.00', '2000.00', '200.00', 'for skin conditions', 2, 3, 1),
(47, 'Cortaid', '30 grams', '10.00', '3500.00', '350.00', 'for skin conditions', 2, 3, 1),
(48, 'Lasix', '20 mg', '10.00', '500.00', '50.00', 'for fluid retention', 2, 4, 2),
(49, 'Lasix', '40 mg', '10.00', '750.00', '75.00', 'for fluid retention', 2, 4, 2),
(50, 'Lasix', '80 mg', '10.00', '1000.00', '100.00', 'for fluid retention', 2, 4, 2),
(51, 'Premarin', '0.3mg', '10.00', '800.00', '80.00', 'hormone replacement therapy', 2, 5, 2),
(52, 'Premarin', '0.625mg', '10.00', '1000.00', '100.00', 'hormone replacement therapy', 2, 5, 2),
(53, 'Premarin', '0.9mg', '10.00', '1200.00', '120.00', 'hormone replacement therapy', 2, 5, 2),
(54, 'Premarin', '1.25mg', '10.00', '1500.00', '150.00', 'hormone replacement therapy', 2, 5, 2),
(55, 'Fluzone', '5ml', '10.00', '5000.00', '500.00', 'vaccines', 2, 6, 5),
(56, 'Fluzone', '10ml', '10.00', '9000.00', '900.00', 'vaccines', 2, 6, 5),
(57, 'Dulcolax', '5mg', '10.00', '300.00', '30.00', 'Stool Softeners', 2, 7, 2),
(58, 'Dulcolax', '10mg', '10.00', '500.00', '50.00', 'Stool Softeners', 2, 7, 2),
(59, 'Bioflu', '500mg', '24', '500', '8', 'Anti flu', 2, 8, 2),
(61, 'Lipitor', '10 mg', '10.00', '500.00', '50.00', 'beta-blockers', 2, 2, 2),
(62, 'Lipitor', '20 mg', '10.00', '750.00', '75.00', 'beta-blockers', 2, 2, 2),
(63, 'Lipitor', '40 mg', '10.00', '1000.00', '100.00', 'beta-blockers', 2, 2, 2),
(64, 'Lipitor', '80mg', '10.00', '1200.00', '120.00', 'beta-blockers', 2, 2, 2),
(65, 'Cortaid', '15 grams', '10.00', '2000.00', '200.00', 'for skin conditions', 2, 3, 1),
(66, 'Cortaid', '30 grams', '10.00', '3500.00', '350.00', 'for skin conditions', 2, 3, 1),
(67, 'Lasix', '20 mg', '10.00', '500.00', '50.00', 'for fluid retention', 2, 4, 2),
(68, 'Lasix', '40 mg', '10.00', '750.00', '75.00', 'for fluid retention', 2, 4, 2),
(69, 'Lasix', '80 mg', '10.00', '1000.00', '100.00', 'for fluid retention', 2, 4, 2),
(70, 'Premarin', '0.3mg', '10.00', '800.00', '80.00', 'hormone replacement therapy', 2, 5, 2),
(71, 'Premarin', '0.625mg', '10.00', '1000.00', '100.00', 'hormone replacement therapy', 2, 5, 2),
(72, 'Premarin', '0.9mg', '10.00', '1200.00', '120.00', 'hormone replacement therapy', 2, 5, 2),
(73, 'Premarin', '1.25mg', '10.00', '1500.00', '150.00', 'hormone replacement therapy', 2, 5, 2),
(74, 'Fluzone', '5ml', '10.00', '5000.00', '500.00', 'vaccines', 2, 6, 5),
(75, 'Fluzone', '10ml', '10.00', '9000.00', '900.00', 'vaccines', 2, 6, 5),
(76, 'Dulcolax', '5mg', '10.00', '300.00', '30.00', 'Stool Softeners', 2, 7, 2),
(77, 'Dulcolax', '10mg', '10.00', '500.00', '50.00', 'Stool Softeners', 2, 7, 2),
(78, 'Lipitor', '10 mg', '10.00', '500.00', '50.00', 'beta-blockers', 2, 2, 2),
(79, 'Lipitor', '20 mg', '10.00', '750.00', '75.00', 'beta-blockers', 2, 2, 2),
(80, 'Lipitor', '40 mg', '10.00', '1000.00', '100.00', 'beta-blockers', 2, 2, 2),
(81, 'Lipitor', '80mg', '10.00', '1200.00', '120.00', 'beta-blockers', 2, 2, 2),
(82, 'Cortaid', '15 grams', '10.00', '2000.00', '200.00', 'for skin conditions', 2, 3, 1),
(83, 'Cortaid', '30 grams', '10.00', '3500.00', '350.00', 'for skin conditions', 2, 3, 1),
(84, 'Lasix', '20 mg', '10.00', '500.00', '50.00', 'for fluid retention', 2, 4, 2),
(85, 'Lasix', '40 mg', '10.00', '750.00', '75.00', 'for fluid retention', 2, 4, 2),
(86, 'Lasix', '80 mg', '10.00', '1000.00', '100.00', 'for fluid retention', 2, 4, 2),
(87, 'Premarin', '0.3mg', '10.00', '800.00', '80.00', 'hormone replacement therapy', 2, 5, 2),
(88, 'Premarin', '0.625mg', '10.00', '1000.00', '100.00', 'hormone replacement therapy', 2, 5, 2),
(89, 'Premarin', '0.9mg', '10.00', '1200.00', '120.00', 'hormone replacement therapy', 2, 5, 2),
(90, 'Premarin', '1.25mg', '10.00', '1500.00', '150.00', 'hormone replacement therapy', 2, 5, 2),
(91, 'Fluzone', '5ml', '10.00', '5000.00', '500.00', 'vaccines', 2, 6, 5),
(92, 'Fluzone', '10ml', '10.00', '9000.00', '900.00', 'vaccines', 2, 6, 5),
(93, 'Dulcolax', '5mg', '10.00', '300.00', '30.00', 'Stool Softeners', 2, 7, 2),
(94, 'Dulcolax', '10mg', '10.00', '500.00', '50.00', 'Stool Softeners', 2, 7, 2),
(95, 'Lipitor', '10 mg', '10.00', '500.00', '50.00', 'beta-blockers', 2, 2, 2),
(96, 'Lipitor', '20 mg', '10.00', '750.00', '75.00', 'beta-blockers', 2, 2, 2),
(97, 'Lipitor', '40 mg', '10.00', '1000.00', '100.00', 'beta-blockers', 2, 2, 2),
(98, 'Lipitor', '80mg', '10.00', '1200.00', '120.00', 'beta-blockers', 2, 2, 2),
(99, 'Cortaid', '15 grams', '10.00', '2000.00', '200.00', 'for skin conditions', 2, 3, 1),
(100, 'Cortaid', '30 grams', '10.00', '3500.00', '350.00', 'for skin conditions', 2, 3, 1),
(101, 'Lasix', '20 mg', '10.00', '500.00', '50.00', 'for fluid retention', 2, 4, 2),
(102, 'Lasix', '40 mg', '10.00', '750.00', '75.00', 'for fluid retention', 2, 4, 2),
(103, 'Lasix', '80 mg', '10.00', '1000.00', '100.00', 'for fluid retention', 2, 4, 2),
(104, 'Premarin', '0.3mg', '10.00', '800.00', '80.00', 'hormone replacement therapy', 2, 5, 2),
(105, 'Premarin', '0.625mg', '10.00', '1000.00', '100.00', 'hormone replacement therapy', 2, 5, 2),
(106, 'Premarin', '0.9mg', '10.00', '1200.00', '120.00', 'hormone replacement therapy', 2, 5, 2),
(107, 'Premarin', '1.25mg', '10.00', '1500.00', '150.00', 'hormone replacement therapy', 2, 5, 2),
(108, 'Fluzone', '5ml', '10.00', '5000.00', '500.00', 'vaccines', 2, 6, 5),
(109, 'Fluzone', '10ml', '10.00', '9000.00', '900.00', 'vaccines', 2, 6, 5),
(110, 'Dulcolax', '5mg', '10.00', '300.00', '30.00', 'Stool Softeners', 2, 7, 2),
(111, 'Dulcolax', '10mg', '10.00', '500.00', '50.00', 'Stool Softeners', 2, 7, 2);

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
(50, 1.25, 0.15, 600.00, 601.25, 'Cash on Delivery', 2);

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
-- Table structure for table `return_item`
--

CREATE TABLE `return_item` (
  `id` int(11) NOT NULL,
  `employee` varchar(50) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `unit_qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `return_item`
--

INSERT INTO `return_item` (`id`, `employee`, `supplier`, `category`, `brand`, `type`, `unit_qty`) VALUES
(1, '', 'UNILAB', 'Paracetamol', 'Biogesic', 'Tablet', 20),
(2, 'Zenji Yangco', 'UNILAB', 'Paracetamol', 'Neozep', 'Tablet', 100),
(3, 'Zenji Yangco', 'UNILAB', 'Paracetamol', 'Neozep', 'Tablet', 10),
(4, 'Zenji Yangco', 'UNILAB', 'Paracetamol', 'Biogesic', 'Tablet', 100),
(5, 'Zenji Yangco', 'UNILAB', 'Paracetamol', 'Biogesic', 'Tablet', 100),
(6, 'Zenji Yangco', 'UNILAB', 'Paracetamol', 'Biogesic', 'Tablet', 100),
(7, 'Zenji Yangco', 'UNILAB', 'Paracetamol', 'Biogesic', 'Tablet', 100);

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
(64, 55, '2024-04-13', '2024-04-13', 'Marco');

-- --------------------------------------------------------

--
-- Table structure for table `shiftdetails`
--

CREATE TABLE `shiftdetails` (
  `id` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `day` text NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shiftdetails`
--

INSERT INTO `shiftdetails` (`id`, `shift_id`, `employee_id`, `day`, `time_in`, `time_out`) VALUES
(65, 61, 18, 'Friday', '00:01:00', '05:00:00'),
(68, 64, 55, 'Saturday', '09:00:00', '10:00:00');

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
-- Indexes for table `finance_inbox`
--
ALTER TABLE `finance_inbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance_inbox_po`
--
ALTER TABLE `finance_inbox_po`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holiday`
--
ALTER TABLE `holiday`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `info`
--
ALTER TABLE `info`
  ADD KEY `item_id` (`item_id`);

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
  ADD PRIMARY KEY (`id`),
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
-- Indexes for table `purchase_table`
--
ALTER TABLE `purchase_table`
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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `cart_table`
--
ALTER TABLE `cart_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `delivery_status`
--
ALTER TABLE `delivery_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `discounted_item`
--
ALTER TABLE `discounted_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dtrrevised`
--
ALTER TABLE `dtrrevised`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `employee_details`
--
ALTER TABLE `employee_details`
  MODIFY `employee_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `employee_salary`
--
ALTER TABLE `employee_salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `employee_salary_revised`
--
ALTER TABLE `employee_salary_revised`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `finance_inbox`
--
ALTER TABLE `finance_inbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9006139;

--
-- AUTO_INCREMENT for table `finance_inbox_po`
--
ALTER TABLE `finance_inbox_po`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9006139;

--
-- AUTO_INCREMENT for table `holiday`
--
ALTER TABLE `holiday`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `inventory_logs`
--
ALTER TABLE `inventory_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `item_mapping`
--
ALTER TABLE `item_mapping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `medicinetype`
--
ALTER TABLE `medicinetype`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `medicine_list`
--
ALTER TABLE `medicine_list`
  MODIFY `medicine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `order_table`
--
ALTER TABLE `order_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `purchase_table`
--
ALTER TABLE `purchase_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `return_item`
--
ALTER TABLE `return_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `shiftdetails`
--
ALTER TABLE `shiftdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`);

--
-- Constraints for table `cart_table`
--
ALTER TABLE `cart_table`
  ADD CONSTRAINT `cart_table_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order_table` (`id`),
  ADD CONSTRAINT `cart_table_ibfk_2` FOREIGN KEY (`delivery_status_id`) REFERENCES `delivery_status` (`id`);

--
-- Constraints for table `daily_time_record`
--
ALTER TABLE `daily_time_record`
  ADD CONSTRAINT `ada` FOREIGN KEY (`rec_emp_id`) REFERENCES `employee_details` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dada` FOREIGN KEY (`record_emp_name`) REFERENCES `employee_details` (`employee_name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sasa` FOREIGN KEY (`record_emp_position`) REFERENCES `employee_details` (`employee_position`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dtrrevised`
--
ALTER TABLE `dtrrevised`
  ADD CONSTRAINT `asdds` FOREIGN KEY (`employee_id`) REFERENCES `employee_details` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_salary`
--
ALTER TABLE `employee_salary`
  ADD CONSTRAINT `mean` FOREIGN KEY (`employee_id`) REFERENCES `employee_details` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_salary_revised`
--
ALTER TABLE `employee_salary_revised`
  ADD CONSTRAINT `mur` FOREIGN KEY (`employee_id`) REFERENCES `employee_details` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `info`
--
ALTER TABLE `info`
  ADD CONSTRAINT `info_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`);

--
-- Constraints for table `item_mapping`
--
ALTER TABLE `item_mapping`
  ADD CONSTRAINT `item_mapping_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`);

--
-- Constraints for table `medicine_list`
--
ALTER TABLE `medicine_list`
  ADD CONSTRAINT `medicine_list_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`),
  ADD CONSTRAINT `medicine_list_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`),
  ADD CONSTRAINT `medicine_list_ibfk_3` FOREIGN KEY (`type_id`) REFERENCES `medicinetype` (`type_id`);

--
-- Constraints for table `order_table`
--
ALTER TABLE `order_table`
  ADD CONSTRAINT `order_table_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`);

--
-- Constraints for table `return_table`
--
ALTER TABLE `return_table`
  ADD CONSTRAINT `return_table_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`),
  ADD CONSTRAINT `return_table_ibfk_2` FOREIGN KEY (`delivery_status_id`) REFERENCES `delivery_status` (`id`),
  ADD CONSTRAINT `return_table_ibfk_3` FOREIGN KEY (`return_status_id`) REFERENCES `return_status` (`id`);

--
-- Constraints for table `shift`
--
ALTER TABLE `shift`
  ADD CONSTRAINT `dsadasd` FOREIGN KEY (`employee_id`) REFERENCES `employee_details` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shiftdetails`
--
ALTER TABLE `shiftdetails`
  ADD CONSTRAINT `adasdas` FOREIGN KEY (`employee_id`) REFERENCES `employee_details` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asa` FOREIGN KEY (`shift_id`) REFERENCES `shift` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
