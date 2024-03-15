-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2024 at 03:26 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `scale` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `item_id`, `qty`, `scale`) VALUES
(66, 25, 10, 'piece');

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `info`
--
ALTER TABLE `info`
  ADD KEY `item_id` (`item_id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

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
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
