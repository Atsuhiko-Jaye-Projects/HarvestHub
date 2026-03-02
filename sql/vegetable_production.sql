-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2026 at 07:04 AM
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
-- Database: `harvesthub`
--

-- --------------------------------------------------------

--
-- Table structure for table `vegetable_production`
--

CREATE TABLE `vegetable_production` (
  `id` int(11) NOT NULL,
  `crop_name` varchar(100) NOT NULL,
  `distance_of_planting` varchar(50) DEFAULT NULL,
  `plant_population_per_hill` int(11) DEFAULT NULL,
  `plant_population_per_hectare` int(11) DEFAULT NULL,
  `production_per_hill` decimal(10,2) DEFAULT NULL,
  `production_per_hill_unit` varchar(20) DEFAULT NULL,
  `production_per_hectare` decimal(12,2) DEFAULT NULL,
  `production_per_hectare_unit` varchar(20) DEFAULT NULL,
  `fruiting_peak` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vegetable_production`
--

INSERT INTO `vegetable_production` (`id`, `crop_name`, `distance_of_planting`, `plant_population_per_hill`, `plant_population_per_hectare`, `production_per_hill`, `production_per_hill_unit`, `production_per_hectare`, `production_per_hectare_unit`, `fruiting_peak`) VALUES
(1, 'Ampalaya', '2 x 1', 3, 15000, 3.00, 'kilos', 45000.00, 'kilos', '3 months'),
(2, 'Eggplant', '1 x 1', 1, 10000, 10.00, 'kilos', 100000.00, 'kilos', '12 months'),
(3, 'Stringbeans', '1 x 0.5', 2, 40000, 1.00, 'kilo', 40000.00, 'kilos', '1 month'),
(4, 'Squash', '2 x 2', 2, 5000, 6.00, 'kilos', 30000.00, 'kilos', '3 months'),
(5, 'Pechay', '10 x 0.1', 1, 1000000, 0.10, 'kilo', 100000.00, 'kilos', 'once'),
(6, 'Mustard', '10 x 0.1', 1, 1000000, 0.10, 'kilo', 100000.00, 'kilos', 'once'),
(7, 'Radish', '10 x 0.1', 1, 500000, 0.15, 'kilo', 75000.00, 'kilos', 'once'),
(8, 'Pepper', '1 x 0.5', 1, 20000, 2.00, 'kilos', 40000.00, 'kilos', '3 months'),
(9, 'Cucumber', '1 x 0.75', 2, 26666, 5.00, 'kilos', 133330.00, 'kilos', '2 months'),
(10, 'Upo', '1 x 1', 2, 30000, 10.00, 'pcs', 300000.00, 'kilos', '3 months'),
(11, 'Patola', '1 x 1', 2, 30000, 10.00, 'pcs', 300000.00, 'kilos', '3 months'),
(12, 'Sayote', '1 x 1', 1, 10000, 5.00, 'kilos', 100000.00, 'kilos', 'year round'),
(13, 'Okra', '1 x 0.5', 1, 20000, 2.00, 'kilos', 160000.00, 'kilos', '3 months'),
(14, 'Snap beans', '1 x 0.5', 3, 80000, 2.00, 'kilos', 40000.00, 'kilos', '1 month'),
(15, 'Tomato', '1 x 0.5', 1, 20000, 2.00, 'kilos', 40000.00, 'kilos', '1 month');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vegetable_production`
--
ALTER TABLE `vegetable_production`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vegetable_production`
--
ALTER TABLE `vegetable_production`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
