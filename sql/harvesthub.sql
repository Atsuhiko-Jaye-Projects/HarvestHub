-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2026 at 01:31 AM
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
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `amount` int(11) NOT NULL,
  `status` varchar(15) NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `farmer_id` int(11) NOT NULL,
  `product_type` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `product_id`, `user_id`, `quantity`, `created`, `amount`, `status`, `modified`, `farmer_id`, `product_type`) VALUES
(32, 19, 2, 20, '2026-01-19 09:41:48', 22, 'ordered', '2026-01-30 12:58:32', 1, 'harvest'),
(33, 19, 2, 15, '2026-01-19 09:42:49', 22, 'ordered', '2026-01-30 12:58:32', 1, 'harvest'),
(34, 22, 2, 5, '2026-01-19 15:39:49', 20, 'ordered', '2026-01-21 02:04:49', 1, 'harvest'),
(35, 19, 2, 10, '2026-01-30 20:58:27', 22, 'ordered', '2026-01-30 12:58:32', 1, 'harvest');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crops`
--

CREATE TABLE `crops` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `farm_resource_id` varchar(255) NOT NULL,
  `crop_name` varchar(250) NOT NULL,
  `yield` double NOT NULL,
  `cultivated_area` int(11) NOT NULL,
  `date_planted` varchar(250) NOT NULL,
  `estimated_harvest_date` varchar(255) NOT NULL,
  `suggested_price` int(11) NOT NULL,
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `stocks` int(11) NOT NULL,
  `plant_count` int(11) NOT NULL,
  `province` varchar(255) NOT NULL,
  `municipality` varchar(255) NOT NULL,
  `baranggay` varchar(250) NOT NULL,
  `crop_status` varchar(25) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crops`
--

INSERT INTO `crops` (`id`, `user_id`, `farm_resource_id`, `crop_name`, `yield`, `cultivated_area`, `date_planted`, `estimated_harvest_date`, `suggested_price`, `modified_at`, `created_at`, `stocks`, `plant_count`, `province`, `municipality`, `baranggay`, `crop_status`, `status`) VALUES
(19, 1, 'FID69606749', 'kamatis', 2.4, 73, '2025-11-01', '2026-01-29', 0, '2026-01-29 12:17:46', '2026-01-21 22:39:17', 240, 100, 'Marinduque', 'Mogpog', 'Anapog-Sibucao', 'harvested', 'posted'),
(20, 1, 'FID69602932', 'Okra', 3.4, 89, '2025-11-27', '2026-01-29', 0, '2026-01-29 10:23:23', '2026-01-27 00:11:45', 340, 100, 'Marinduque', 'Mogpog', 'Anapog-Sibucao', 'harvested', 'posted'),
(21, 1, 'FID69691569', 'Potato', 2.5, 60, '2025-11-01', '2026-01-29', 0, '2026-01-29 12:52:07', '2026-01-28 21:14:30', 190, 76, 'Marinduque', 'Mogpog', 'Anapog-Sibucao', 'harvested', 'posted');

-- --------------------------------------------------------

--
-- Table structure for table `crop_statistics`
--

CREATE TABLE `crop_statistics` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `crop_name` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `season` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daily_crop_logs`
--

CREATE TABLE `daily_crop_logs` (
  `daily_log_id` int(11) NOT NULL,
  `crop_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `log_date` date NOT NULL,
  `health_status` varchar(25) DEFAULT NULL,
  `activities` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `temperature` decimal(5,2) DEFAULT NULL,
  `humidity` decimal(5,2) DEFAULT NULL,
  `weather_conditions` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `location` varchar(50) NOT NULL,
  `precipitation` decimal(5,2) DEFAULT NULL,
  `precip_prob` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daily_crop_logs`
--

INSERT INTO `daily_crop_logs` (`daily_log_id`, `crop_id`, `user_id`, `log_date`, `health_status`, `activities`, `photo`, `temperature`, `humidity`, `weather_conditions`, `remarks`, `created_at`, `updated_at`, `location`, `precipitation`, `precip_prob`) VALUES
(54, 21, 1, '2026-01-25', 'Healthy', 'Watered,Fertilized', '1769684154_crop_21.jpg', 25.10, 72.50, 'Rain, Partially cloudy', 'Logged', '2026-01-29 11:05:35', '2026-01-29 11:05:35', 'Anapog-Sibucao Mogpog, Marinduque', 0.20, '80'),
(55, 21, 1, '2026-01-26', 'Healthy', 'Watered,Fertilized,Pesticide', '1769684154_crop_21.jpg', 26.00, 70.00, 'Rain, Cloudy', 'Logged', '2026-01-29 11:05:35', '2026-01-29 11:05:35', 'Anapog-Sibucao Mogpog, Marinduque', 0.50, '90'),
(56, 21, 1, '2026-01-27', 'Healthy', 'Watered,Pesticide', '1769684154_crop_21.jpg', 26.30, 75.00, 'Partially cloudy', 'Logged', '2026-01-29 11:05:35', '2026-01-29 11:05:35', 'Anapog-Sibucao Mogpog, Marinduque', 0.00, '20'),
(57, 21, 1, '2026-01-28', 'Healthy', 'Fertilized,Pesticide', '1769684154_crop_21.jpg', 25.80, 74.00, 'Cloudy', 'Logged', '2026-01-29 11:05:35', '2026-01-29 11:05:35', 'Anapog-Sibucao Mogpog, Marinduque', 0.10, '40'),
(58, 21, 1, '2026-01-29', 'Healthy', 'Watered,Fertilized,Pesticide,Pruned', '1769684154_crop_21.jpg', 25.40, 70.50, 'Rain, Partially cloudy', 'Logged', '2026-01-29 11:05:35', '2026-01-29 11:05:35', 'Anapog-Sibucao Mogpog, Marinduque', 0.10, '100');

-- --------------------------------------------------------

--
-- Table structure for table `deleted_products`
--

CREATE TABLE `deleted_products` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(500) NOT NULL,
  `product_status` varchar(25) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `farm_activities`
--

CREATE TABLE `farm_activities` (
  `id` int(11) NOT NULL,
  `farm_resource_id` varchar(25) NOT NULL,
  `activity_name` varchar(255) NOT NULL,
  `activity_cost` double NOT NULL,
  `farm_activity_type` varchar(25) NOT NULL,
  `activity_date` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL,
  `farmer_id` int(11) NOT NULL,
  `additional_info` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farm_activities`
--

INSERT INTO `farm_activities` (`id`, `farm_resource_id`, `activity_name`, `activity_cost`, `farm_activity_type`, `activity_date`, `created_at`, `modified_at`, `farmer_id`, `additional_info`) VALUES
(1, 'FID69660125097', 'Land clearing', 2000, 'land_prep', '2026-01-13 00:00:00', '2026-01-13 16:24:05', '0000-00-00 00:00:00', 0, ''),
(2, 'FID69660125097', 'Seed tray preparation', 1000, 'nursery_seedling', '2026-01-13 00:00:00', '2026-01-13 16:24:05', '0000-00-00 00:00:00', 0, ''),
(3, 'FID696062578', 'Land clearing', 3000, 'land_prep', '2026-01-17 00:00:00', '2026-01-16 17:37:00', '0000-00-00 00:00:00', 0, 'graet'),
(4, 'FID6961246899', 'Land clearing', 3000, 'land_prep', '0000-00-00 00:00:00', '2026-01-16 19:08:20', '0000-00-00 00:00:00', 0, ''),
(5, 'FID69606749', 'Land clearing', 3000, 'land_prep', '0000-00-00 00:00:00', '2026-01-17 12:26:20', '0000-00-00 00:00:00', 0, ''),
(6, 'FID69609091', 'Land clearing', 5000, 'land_prep', '0000-00-00 00:00:00', '2026-01-17 12:27:06', '0000-00-00 00:00:00', 0, ''),
(7, 'FID69602932', 'Land clearing', 3500, 'land_prep', '0000-00-00 00:00:00', '2026-01-17 12:27:46', '0000-00-00 00:00:00', 0, ''),
(8, 'FID69691569', 'Land clearing', 6300, 'land_prep', '0000-00-00 00:00:00', '2026-01-19 10:07:01', '0000-00-00 00:00:00', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `farm_details`
--

CREATE TABLE `farm_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `province` varchar(255) NOT NULL,
  `municipality` varchar(250) NOT NULL,
  `baranggay` varchar(250) NOT NULL,
  `purok` varchar(255) NOT NULL,
  `farm_ownership` varchar(50) NOT NULL,
  `lot_size` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `used_lot_size` int(11) NOT NULL,
  `farm_name` varchar(255) NOT NULL,
  `farm_type` varchar(255) NOT NULL,
  `follower_count` int(11) NOT NULL,
  `farm_image` varchar(525) NOT NULL,
  `reputation` int(11) NOT NULL,
  `following_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farm_details`
--

INSERT INTO `farm_details` (`id`, `user_id`, `province`, `municipality`, `baranggay`, `purok`, `farm_ownership`, `lot_size`, `created_at`, `modified_at`, `used_lot_size`, `farm_name`, `farm_type`, `follower_count`, `farm_image`, `reputation`, `following_count`) VALUES
(1, 1, 'Marinduque', 'Mogpog', 'Anapog-Sibucao', 'Purok 2', 'owned', 1000, '2026-01-13 16:18:01', '2026-01-13 08:18:01', -605, 'Mondragon', '', 0, '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `farm_resources`
--

CREATE TABLE `farm_resources` (
  `id` int(11) NOT NULL,
  `user_id` int(10) NOT NULL,
  `farm_resource_id` varchar(25) NOT NULL,
  `record_name` varchar(255) NOT NULL,
  `crop_name` varchar(25) NOT NULL,
  `plant_count` int(11) NOT NULL,
  `average_yield_per_plant` double NOT NULL,
  `grand_total` double NOT NULL,
  `date` varchar(255) NOT NULL,
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `planted_area_sqm` double NOT NULL,
  `crop_status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farm_resources`
--

INSERT INTO `farm_resources` (`id`, `user_id`, `farm_resource_id`, `record_name`, `crop_name`, `plant_count`, `average_yield_per_plant`, `grand_total`, `date`, `modified_at`, `created_at`, `planted_area_sqm`, `crop_status`) VALUES
(4, 1, 'FID69606749', 'Kamatis planting', 'kamatis', 100, 2.4, 3000, '2026-01-17', '2026-01-21 14:39:17', '2026-01-17 12:26:20', 73, 'crop planted'),
(5, 1, 'FID69609091', 'kalabasa expense', 'kalabasa', 200, 3.4, 5000, '2026-01-17', '2026-01-21 03:11:33', '2026-01-17 12:27:06', 90, 'crop planted'),
(6, 1, 'FID69602932', 'okra expense', 'Okra', 100, 3.4, 3500, '2026-01-17', '2026-01-26 16:11:45', '2026-01-17 12:27:46', 89, 'crop planted'),
(7, 1, 'FID69691569', 'Potato Expense', 'Potato', 76, 2.5, 6300, '2026-01-19', '2026-01-28 13:14:30', '2026-01-19 10:07:01', 60, 'crop planted');

-- --------------------------------------------------------

--
-- Table structure for table `harvested_products`
--

CREATE TABLE `harvested_products` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_name` varchar(250) NOT NULL,
  `price_per_unit` int(20) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `category` varchar(255) NOT NULL,
  `lot_size` varchar(255) NOT NULL,
  `product_description` varchar(300) NOT NULL,
  `total_stocks` int(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_posted` varchar(25) NOT NULL,
  `plant_count` int(11) NOT NULL,
  `expense` double NOT NULL,
  `kilo_per_plant` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `harvested_products`
--

INSERT INTO `harvested_products` (`id`, `user_id`, `product_name`, `price_per_unit`, `unit`, `category`, `lot_size`, `product_description`, `total_stocks`, `quantity`, `product_image`, `modified`, `created_at`, `is_posted`, `plant_count`, `expense`, `kilo_per_plant`) VALUES
(19, 1, 'Kalabasa', 21, 'KG', 'Vegetable', '90', 'kalabasa great', 350, 0, 'd3ecde51500da84c80b1f62ebf6485b4c171813a-kalabasa.jpg', '2026-01-17 04:30:42', '2026-01-17 12:28:27', 'Posted', 100, 5000, 3.5),
(22, 1, 'Kamote', 17, 'KG', 'Vegetable', '76', 'Kamote (Ipomoea batatas), or sweet potato, is a versatile root vegetable known for its large, starchy, sweet-tasting tubers and edible heart-shaped leaves (talbos ng kamote). Belonging to the morning glory family (Convolvulaceae), it\'s a vital staple in the Philippines, eaten boiled, fried, roasted,', 350, 0, '7537ce549714a622697ca1cc1c15a56b743305d6-kamote.jpg', '2026-01-19 02:04:44', '2026-01-19 10:04:24', 'Posted', 100, 5000, 3.5),
(24, 1, 'Okra', 0, 'KG', 'Not Set', '89', '', 0, 0, '', '2026-01-29 10:23:23', '2026-01-29 18:23:23', 'Pending', 100, 3500, 0),
(25, 1, 'kamatis', 0, 'KG', 'Not Set', '73', '', 0, 0, '', '2026-01-29 12:12:51', '2026-01-29 20:12:51', 'Pending', 100, 3000, 0),
(26, 1, 'kamatis', 0, 'KG', 'Not Set', '73', '', 0, 0, '', '2026-01-29 12:14:57', '2026-01-29 20:14:57', 'Pending', 100, 3000, 0),
(27, 1, 'kamatis', 0, 'KG', 'Not Set', '73', '', 0, 0, '', '2026-01-29 12:17:46', '2026-01-29 20:17:46', 'Pending', 100, 3000, 0),
(28, 1, 'Potato', 0, 'KG', 'Not Set', '60', '', 0, 0, '', '2026-01-29 12:28:14', '2026-01-29 20:28:14', 'Pending', 76, 6300, 0),
(29, 1, 'Potato', 38, 'KG', 'Not Set', '60', '', 200, 0, '', '2026-01-29 12:29:09', '2026-01-29 20:29:09', 'Pending', 76, 6300, 200),
(30, 1, 'Potato', 25, 'KG', 'Not Set', '60', '', 300, 0, '', '2026-01-29 12:30:23', '2026-01-29 20:30:23', 'Pending', 76, 6300, 200),
(31, 1, 'Potato', 25, 'KG', 'Not Set', '60', '', 300, 0, '', '2026-01-29 12:34:41', '2026-01-29 20:34:41', 'Pending', 76, 6300, 3.5),
(32, 1, 'Potato', 38, 'KG', 'Not Set', '60', '', 200, 0, '', '2026-01-29 12:52:07', '2026-01-29 20:52:07', 'Pending', 76, 6300, 2.3);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `inovoice_number` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `sender_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `conversation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `mode_of_payment` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `farmer_id` int(11) NOT NULL,
  `product_type` varchar(25) NOT NULL,
  `review_status` int(4) NOT NULL DEFAULT 0,
  `reason` varchar(255) NOT NULL,
  `farmer_rated` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `product_id`, `invoice_number`, `customer_id`, `mode_of_payment`, `quantity`, `status`, `created_at`, `modified_at`, `farmer_id`, `product_type`, `review_status`, `reason`, `farmer_rated`) VALUES
(27, 19, 'INV-696D8C1EE583D', 2, 'COP', 30, 'complete', '2026-01-19 09:42:54', '2025-12-02 01:43:55', 1, 'harvest', 0, '', 0),
(28, 19, 'INV-696D8C1EE583F', 2, 'COP', 11, 'complete', '2026-01-19 09:42:54', '2025-12-31 01:43:55', 1, 'harvest', 0, '', 0),
(29, 19, 'INV-696D8C1EE583T', 2, 'COP', 50, 'complete', '2026-01-19 09:42:54', '2026-01-15 01:43:55', 1, 'harvest', 1, '', 0),
(30, 19, 'INV-696D8C1EE583HJ', 2, 'COP', 45, 'complete', '2026-01-19 09:42:54', '2026-02-03 01:43:55', 1, 'harvest', 0, '', 0),
(31, 19, 'INV-696D8C1EE583HJ', 2, 'COP', 16, 'complete', '2026-01-19 09:42:54', '2026-01-17 01:43:55', 1, 'harvest', 1, '', 0),
(32, 19, 'INV-696D8C1EE583PO', 2, 'COP', 30, 'complete', '2025-12-01 09:42:54', '2026-01-18 01:43:55', 1, 'harvest', 1, '', 0),
(33, 19, 'INV-696D8C1EE583IU', 2, 'COP', 50, 'complete', '2026-01-19 09:42:54', '2026-01-20 01:43:55', 1, 'harvest', 1, '', 0),
(34, 19, 'INV-696D8C1EE583HIUM', 2, 'COP', 5, 'complete', '2026-01-19 09:42:54', '2026-01-20 01:43:55', 1, 'harvest', 1, '', 1),
(35, 22, 'INV-6970344148813', 2, 'COP', 15, 'complete', '2025-01-01 10:04:49', '2026-01-21 02:05:43', 1, 'harvest', 1, '', 1),
(36, 19, 'INV-697CAAF85FB96', 2, 'COP', 10, 'complete', '2026-01-30 20:58:32', '2026-01-30 12:58:54', 1, 'harvest', 0, '', 0),
(37, 19, 'INV-20250101-001', 2, 'COP', 30, 'complete', '2025-01-01 10:12:45', '2026-01-30 04:00:00', 1, 'harvest', 0, '0', 0),
(38, 19, 'INV-20250105-002', 2, 'COP', 11, 'complete', '2025-01-05 09:45:32', '2026-01-30 04:00:00', 1, 'harvest', 0, '0', 0),
(39, 19, 'INV-20250110-003', 2, 'COP', 50, 'complete', '2025-01-10 14:20:10', '2026-01-30 04:00:00', 1, 'harvest', 1, '0', 0),
(40, 19, 'INV-20250112-004', 2, 'COP', 45, 'complete', '2025-01-12 16:50:55', '2026-01-30 04:00:00', 1, 'harvest', 0, '0', 0),
(41, 19, 'INV-20250115-005', 2, 'COP', 16, 'complete', '2025-01-15 08:30:22', '2026-01-30 04:00:00', 1, 'harvest', 1, '0', 0),
(42, 19, 'INV-20250118-006', 2, 'COP', 30, 'complete', '2025-01-18 11:10:05', '2026-01-30 04:00:00', 1, 'harvest', 1, '0', 0),
(43, 19, 'INV-20250120-007', 2, 'COP', 50, 'complete', '2025-01-20 13:15:17', '2026-01-30 04:00:00', 1, 'harvest', 1, '0', 0),
(44, 19, 'INV-20250125-008', 2, 'COP', 5, 'complete', '2025-01-25 10:00:00', '2026-01-30 04:00:00', 1, 'harvest', 1, '1', 1),
(45, 19, 'INV-20250127-009', 2, 'COP', 10, 'complete', '2025-01-27 15:35:48', '2026-01-30 04:00:00', 1, 'harvest', 0, '0', 0),
(46, 19, 'INV-20250130-010', 2, 'COP', 15, 'complete', '2025-01-30 09:55:30', '2026-01-30 04:00:00', 1, 'harvest', 1, '1', 1),
(47, 22, 'INV-20250103-011', 2, 'COP', 15, 'complete', '2025-01-03 12:12:12', '2026-01-30 04:00:00', 1, 'harvest', 1, '1', 1),
(48, 22, 'INV-20250106-012', 2, 'COP', 10, 'complete', '2025-01-06 14:40:20', '2026-01-30 04:00:00', 1, 'harvest', 0, '0', 0),
(49, 22, 'INV-20250111-013', 2, 'COP', 15, 'complete', '2025-01-11 08:05:44', '2026-01-30 04:00:00', 1, 'harvest', 1, '1', 1),
(50, 22, 'INV-20250114-014', 2, 'COP', 10, 'complete', '2025-01-14 17:22:33', '2026-01-30 04:00:00', 1, 'harvest', 0, '0', 0),
(51, 22, 'INV-20250117-015', 2, 'COP', 15, 'complete', '2025-01-17 13:14:15', '2026-01-30 04:00:00', 1, 'harvest', 1, '1', 1),
(52, 22, 'INV-20250121-016', 2, 'COP', 10, 'complete', '2025-01-21 09:10:05', '2026-01-30 04:00:00', 1, 'harvest', 0, '0', 0),
(53, 22, 'INV-20250123-017', 2, 'COP', 15, 'complete', '2025-01-23 16:30:29', '2026-01-30 04:00:00', 1, 'harvest', 1, '1', 1),
(54, 22, 'INV-20250126-018', 2, 'COP', 10, 'complete', '2025-01-26 11:11:11', '2026-01-30 04:00:00', 1, 'harvest', 0, '0', 0),
(55, 22, 'INV-20250128-019', 2, 'COP', 15, 'complete', '2025-01-28 14:45:56', '2026-01-30 04:00:00', 1, 'harvest', 1, '1', 1),
(56, 22, 'INV-20250130-020', 2, 'COP', 10, 'complete', '2025-01-30 10:30:00', '2026-01-30 04:00:00', 1, 'harvest', 0, '0', 0),
(57, 19, 'INV-20250201-021', 2, 'COP', 30, 'complete', '2025-02-01 09:15:10', '2026-01-30 04:00:00', 1, 'harvest', 0, '0', 0),
(58, 19, 'INV-20250205-022', 2, 'COP', 11, 'complete', '2025-02-05 10:55:45', '2026-01-30 04:00:00', 1, 'harvest', 0, '0', 0),
(59, 19, 'INV-20250210-023', 2, 'COP', 50, 'complete', '2025-02-10 12:10:33', '2026-01-30 04:00:00', 1, 'harvest', 1, '0', 0),
(60, 19, 'INV-20250212-024', 2, 'COP', 45, 'complete', '2025-02-12 14:20:44', '2026-01-30 04:00:00', 1, 'harvest', 0, '0', 0),
(61, 19, 'INV-20250215-025', 2, 'COP', 16, 'complete', '2025-02-15 16:45:00', '2026-01-30 04:00:00', 1, 'harvest', 1, '0', 0),
(62, 19, 'INV-20250218-026', 2, 'COP', 30, 'complete', '2025-02-18 08:30:20', '2026-01-30 04:00:00', 1, 'harvest', 1, '0', 0),
(63, 19, 'INV-20250220-027', 2, 'COP', 50, 'complete', '2025-02-20 10:10:10', '2026-01-30 04:00:00', 1, 'harvest', 1, '0', 0),
(64, 19, 'INV-20250225-028', 2, 'COP', 5, 'complete', '2025-02-25 13:25:35', '2026-01-30 04:00:00', 1, 'harvest', 1, '1', 1),
(65, 19, 'INV-20250227-029', 2, 'COP', 10, 'complete', '2025-02-27 15:40:50', '2026-01-30 04:00:00', 1, 'harvest', 0, '0', 0),
(66, 19, 'INV-20250228-030', 2, 'COP', 15, 'complete', '2025-02-28 11:55:05', '2026-01-30 04:00:00', 1, 'harvest', 1, '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_status_history`
--

CREATE TABLE `order_status_history` (
  `id` int(11) NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `timestamp` datetime NOT NULL,
  `product_id` int(11) NOT NULL,
  `notif_viewed` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_status_history`
--

INSERT INTO `order_status_history` (`id`, `invoice_number`, `status`, `timestamp`, `product_id`, `notif_viewed`) VALUES
(13, 'INV-696D8C1EE583D', 'order placed', '2026-01-19 09:43:00', 19, 1),
(14, 'INV-696D8C1EE583D', 'accept', '2026-01-19 09:43:48', 19, 1),
(15, 'INV-696D8C1EE583D', 'order shipout', '2026-01-19 21:30:24', 19, 1),
(16, 'INV-696D8C1EE583D', 'order recieved', '2026-01-19 21:30:21', 19, 1),
(17, 'INV-6970344148813', 'order placed', '2026-01-21 10:04:53', 22, 1),
(18, 'INV-6970344148813', 'accept', '2026-01-21 10:05:32', 22, 1),
(19, 'INV-6970344148813', 'order shipout', '2026-01-21 10:05:39', 22, 1),
(20, 'INV-6970344148813', 'order recieved', '2026-01-21 10:05:46', 22, 1),
(21, 'INV-697CAAF85FB96', 'order placed', '2026-01-30 20:58:32', 19, 0),
(22, 'INV-697CAAF85FB96', 'accept', '2026-01-30 20:01:48', 19, 0),
(23, 'INV-697CAAF85FB96', 'order shipout', '2026-01-30 20:01:50', 19, 0),
(24, 'INV-697CAAF85FB96', 'order recieved', '2026-01-30 20:01:54', 19, 0);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pre-orders`
--

CREATE TABLE `pre-orders` (
  `id` int(11) NOT NULL,
  `crop_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(250) NOT NULL,
  `price_per_unit` int(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_description` varchar(500) NOT NULL,
  `lot_size` int(20) NOT NULL,
  `total_stocks` int(20) NOT NULL,
  `product_image` varchar(500) NOT NULL,
  `sold_count` int(11) NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(25) NOT NULL,
  `product_type` varchar(11) NOT NULL,
  `available_stocks` int(11) NOT NULL,
  `discount` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_id`, `product_name`, `price_per_unit`, `user_id`, `category`, `unit`, `quantity`, `product_description`, `lot_size`, `total_stocks`, `product_image`, `sold_count`, `modified`, `created_at`, `status`, `product_type`, `available_stocks`, `discount`) VALUES
(6, 19, 'Kalabasa', 22, 1, 'Vegetable', 'KG', 0, 'kalabasa great', 90, 350, 'd3ecde51500da84c80b1f62ebf6485b4c171813a-kalabasa.jpg', 125, '2026-01-17 04:30:42', '2026-01-17 12:30:42', 'Active', 'harvest', 225, NULL),
(7, 4, 'kamatis', 15, 1, 'vegetable', '', 0, 'Reserve fresh farm produce ahead of time and get it delivered at peak quality.', 0, 240, '2a7cb252aa6e87d07c2bf4f8c4191b8b84682f3f-kamatis.jpg', 40, '2026-01-17 04:36:30', '2026-01-17 12:36:30', 'Active', 'preorder', 200, NULL),
(9, 22, 'Kamote', 20, 1, 'Vegetable', 'KG', 0, 'Kamote (Ipomoea batatas), or sweet potato, is a versatile root vegetable known for its large, starchy, sweet-tasting tubers and edible heart-shaped leaves (talbos ng kamote). Belonging to the morning glory family (Convolvulaceae), it\'s a vital staple in the Philippines, eaten boiled, fried, roasted,', 76, 350, '7537ce549714a622697ca1cc1c15a56b743305d6-kamote.jpg', 30, '2026-01-19 02:04:44', '2026-01-19 10:04:44', 'Active', 'harvest', 320, NULL),
(10, 5, 'Potato', 33, 1, 'vegetable', '', 0, 'Reserve fresh farm produce ahead of time and get it delivered at peak quality.', 0, 190, 'b5ff02adfcd4876f6f67f8e5f4240669c142e6b5-patatas.jpg', 0, '2026-01-19 02:07:42', '2026-01-19 10:07:42', 'Active', 'preorder', 190, NULL),
(12, 20, 'kamatis', 15, 1, '', '', 0, 'Reserve fresh farm produce ahead of time and get it delivered at peak quality.', 0, 240, '9dd3eb7124b7bd69c493f7b657d4abc7a792ffc0-Kalabasa_(Calabaza)_squash_from_the_Philippines.jpg', 20, '2026-01-21 14:40:19', '2026-01-21 22:40:19', 'Active', 'preorder', 220, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_histories`
--

CREATE TABLE `product_histories` (
  `id` int(11) NOT NULL,
  `farmer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price_per_unit` double NOT NULL,
  `recorded_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_types`
--

CREATE TABLE `product_types` (
  `id` int(11) NOT NULL,
  `type_name` varchar(100) NOT NULL,
  `shelf_life_room` int(11) DEFAULT NULL,
  `shelf_life_chilled` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_types`
--

INSERT INTO `product_types` (`id`, `type_name`, `shelf_life_room`, `shelf_life_chilled`) VALUES
(1, 'Leafy Greens', 3, 7),
(2, 'Fruiting Vegetables', 5, 10),
(3, 'Root Crops / Tubers', 15, 30),
(4, 'Bulbs / Herbs', 7, 14),
(5, 'Soft Fruits', 3, 7),
(6, 'Hard Fruits', 14, 30),
(7, 'Citrus', 7, 14),
(8, 'Beans / Legumes', 3, 7),
(9, 'Coconut / Nuts', 14, 30),
(10, 'Corn / Sweet Corn', 3, 7),
(11, 'Pumpkin / Squash', 30, 90),
(12, 'Other Crops', 7, 14);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `farmer_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `rating` double NOT NULL,
  `review_text` varchar(500) NOT NULL,
  `reply` varchar(500) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `product_rating` double NOT NULL,
  `farmer_rating` int(11) NOT NULL,
  `performance_review` varchar(525) NOT NULL,
  `product_quality_review` varchar(525) NOT NULL,
  `farmer_response` varchar(526) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `farmer_id`, `customer_id`, `rating`, `review_text`, `reply`, `created_at`, `modified_at`, `product_rating`, `farmer_rating`, `performance_review`, `product_quality_review`, `farmer_response`) VALUES
(1, 19, 1, 2, 3, 'The product are fresh and packed very well, will order next time', '', '2026-01-19 09:44:44', '2026-01-19 01:44:44', 0, 0, '', '', ''),
(2, 19, 1, 2, 5, 'good', '', '2026-01-19 15:40:40', '2026-01-19 07:40:40', 0, 0, '', '', ''),
(3, 19, 1, 2, 5, 'great', '', '2026-01-19 20:13:34', '2026-01-19 12:13:34', 0, 0, '', '', ''),
(4, 19, 1, 2, 5, 'great', '', '2026-01-19 21:30:12', '2026-01-19 13:30:12', 0, 0, '', '', ''),
(5, 19, 1, 2, 5, 'farmer review rating feature', '', '2026-01-19 21:52:29', '2026-01-19 13:52:29', 0, 0, '', '', ''),
(6, 22, 1, 2, 3, 'fresh product from the farm', '', '2026-01-21 10:08:05', '2026-01-21 02:08:05', 0, 0, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `review_images`
--

CREATE TABLE `review_images` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `farmer_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review_images`
--

INSERT INTO `review_images` (`id`, `image`, `product_id`, `customer_id`, `farmer_id`, `created_at`) VALUES
(13, 'img_69703505d9b699.19380964.jpg', 22, 2, 1, '2026-01-21 10:08:05'),
(14, 'img_69703505d9e717.31317849.jpg', 22, 2, 1, '2026-01-21 10:08:05');

-- --------------------------------------------------------

--
-- Table structure for table `seasonal_crops`
--

CREATE TABLE `seasonal_crops` (
  `id` int(11) NOT NULL,
  `crop_name` varchar(255) NOT NULL,
  `best_season` varchar(255) DEFAULT NULL,
  `avg_precip` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seasonal_crops`
--

INSERT INTO `seasonal_crops` (`id`, `crop_name`, `best_season`, `avg_precip`, `created`, `modified`) VALUES
(6, 'Potato', 'Rainy Season', '0.18', '2026-01-29 20:52:07', '2026-01-29 12:52:07');

-- --------------------------------------------------------

--
-- Table structure for table `seller_reviews`
--

CREATE TABLE `seller_reviews` (
  `id` int(11) NOT NULL,
  `farmer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `review_text` varchar(255) NOT NULL,
  `message_rating` double NOT NULL,
  `rating` double NOT NULL,
  `review_tags` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller_reviews`
--

INSERT INTO `seller_reviews` (`id`, `farmer_id`, `product_id`, `customer_id`, `review_text`, `message_rating`, `rating`, `review_tags`, `created_at`, `modified_at`, `order_id`) VALUES
(5, 1, 19, 2, 'this is great feature for farmers features', 5, 5, '[\"Fast Response\",\"Fresh Products\",\"Good Packaging\",\"Friendly Seller\"]', '2026-01-19 22:03:11', '2026-01-19 14:03:11', 34),
(6, 1, 22, 2, 'great seller, fast response', 5, 5, '[\"Fast Response\",\"Fresh Products\",\"Good Packaging\",\"Friendly Seller\"]', '2026-01-21 10:27:05', '2026-01-21 02:27:05', 35);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(150) NOT NULL,
  `lastname` varchar(150) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `address` varchar(150) NOT NULL,
  `barangay` varchar(150) NOT NULL,
  `municipality` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rating` int(10) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `first_time_logged_in` int(11) NOT NULL,
  `modified` datetime NOT NULL DEFAULT current_timestamp(),
  `farm_details_exists` varchar(11) DEFAULT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `is_verified` tinyint(4) NOT NULL,
  `verification_token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email_address`, `contact_number`, `address`, `barangay`, `municipality`, `province`, `user_type`, `password`, `rating`, `created`, `first_time_logged_in`, `modified`, `farm_details_exists`, `profile_pic`, `is_verified`, `verification_token`) VALUES
(1, 'Sheila Mae', 'Laurente', 'testfarmer@gmail.com', '+639772639814', 'Purok 2', 'Anapog-Sibucao', 'Mogpo', 'Marinduque', 'Farmer', '$2y$10$BcHRBElcAV5x7Tp8gM.TuecfiOhCTsc0qtu.QN7O3Fm.1OxEZcjUy', 0, '2026-01-13 16:15:26', 0, '2026-01-21 11:32:08', '1', '36450cd9803a614682521f804264fe3fe61269e0-3bd65777-5010-4f87-862f-632f3e6dbc87.jpg', 1, ''),
(2, 'Jessie', 'Sadiwa', 'testconsumer@gmail.com', '09533307696', 'Purok2, anapog-sibucao', 'Anapog-Sibucao', 'Mogpog', 'Marinduque', 'consumer', '$2y$10$IoukiA0wErTkXSb09L5GuOR2ZVjBbDMPJQoUcIJToyYA9ylWk0Mii', 0, '2026-01-13 16:51:41', 0, '2026-01-13 21:16:20', '0', '', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `vegetable_crops`
--

CREATE TABLE `vegetable_crops` (
  `id` int(11) NOT NULL,
  `crop_name` varchar(100) NOT NULL,
  `local_name` varchar(100) DEFAULT NULL,
  `days_to_harvest` int(11) NOT NULL,
  `shelf_life_days` int(11) NOT NULL,
  `yield_per_sqm_kg` decimal(5,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vegetable_crops`
--

INSERT INTO `vegetable_crops` (`id`, `crop_name`, `local_name`, `days_to_harvest`, `shelf_life_days`, `yield_per_sqm_kg`, `created_at`) VALUES
(1, 'Tomato', 'Kamatis', 70, 7, 4.50, '2026-01-21 13:57:28'),
(2, 'Eggplant', 'Talong', 80, 7, 3.50, '2026-01-21 13:57:28'),
(3, 'Bitter Gourd', 'Ampalaya', 55, 5, 2.80, '2026-01-21 13:57:28'),
(4, 'String Beans', 'Sitaw', 50, 3, 2.20, '2026-01-21 13:57:28'),
(5, 'Squash', 'Kalabasa', 90, 14, 5.00, '2026-01-21 13:57:28'),
(6, 'Okra', 'Okra', 60, 3, 2.50, '2026-01-21 13:57:28'),
(7, 'Chili Pepper', 'Siling Labuyo', 75, 7, 1.80, '2026-01-21 13:57:28'),
(8, 'Bell Pepper', 'Siling Berde', 75, 7, 3.00, '2026-01-21 13:57:28'),
(9, 'Cucumber', 'Pipino', 55, 7, 4.00, '2026-01-21 13:57:28'),
(10, 'Radish', 'Labanos', 30, 14, 3.50, '2026-01-21 13:57:28'),
(11, 'Carrots', 'Karot', 70, 21, 4.00, '2026-01-21 13:57:28'),
(12, 'Cabbage', 'Repolyo', 80, 14, 6.00, '2026-01-21 13:57:28'),
(13, 'Lettuce', 'Litsugas', 45, 7, 2.50, '2026-01-21 13:57:28'),
(14, 'Spinach', 'Espinaka', 40, 7, 2.00, '2026-01-21 13:57:28'),
(15, 'Mustard Greens', 'Mustasa', 40, 3, 2.20, '2026-01-21 13:57:28'),
(16, 'Pechay', 'Pechay', 35, 5, 2.80, '2026-01-21 13:57:28'),
(17, 'Kangkong', 'Kangkong', 30, 3, 3.00, '2026-01-21 13:57:28'),
(18, 'Sweet Potato', 'Kamote', 120, 30, 4.50, '2026-01-21 13:57:28'),
(19, 'Potato', 'Patatas', 90, 60, 5.00, '2026-01-21 13:57:28'),
(20, 'Onion', 'Sibuyas', 100, 30, 3.00, '2026-01-21 13:57:28'),
(21, 'Garlic', 'Bawang', 150, 90, 2.00, '2026-01-21 13:57:28'),
(22, 'Ginger', 'Luya', 240, 60, 3.50, '2026-01-21 13:57:28'),
(23, 'Turmeric', 'Luyang Dilaw', 240, 60, 3.00, '2026-01-21 13:57:28'),
(24, 'Taro', 'Gabi', 180, 14, 4.00, '2026-01-21 13:57:28'),
(25, 'Cassava', 'Kamoteng Kahoy', 300, 7, 6.00, '2026-01-21 13:57:28'),
(26, 'Pumpkin', 'Kalabasa Pula', 100, 30, 5.50, '2026-01-21 13:57:28'),
(27, 'Zucchini', 'Zukini', 50, 5, 3.50, '2026-01-21 13:57:28'),
(28, 'Green Beans', 'Habichuelas', 55, 5, 2.50, '2026-01-21 13:57:28'),
(29, 'Peas', 'Gisantes', 60, 3, 2.00, '2026-01-21 13:57:28'),
(30, 'Corn', 'Mais', 80, 3, 3.00, '2026-01-21 13:57:28'),
(31, 'Broccoli', 'Brokoli', 70, 7, 3.50, '2026-01-21 13:57:28'),
(32, 'Cauliflower', 'Koliflor', 75, 7, 4.00, '2026-01-21 13:57:28'),
(33, 'Celery', 'Kintsay', 85, 14, 2.50, '2026-01-21 13:57:28'),
(34, 'Leeks', 'Liks', 120, 14, 2.00, '2026-01-21 13:57:28'),
(35, 'Asparagus', 'Esparrago', 365, 5, 1.50, '2026-01-21 13:57:28'),
(36, 'Artichoke', 'Artikoke', 150, 7, 2.00, '2026-01-21 13:57:28'),
(37, 'Brussels Sprouts', 'Bruselsprut', 90, 7, 2.50, '2026-01-21 13:57:28'),
(38, 'Kale', 'Kale', 55, 7, 2.80, '2026-01-21 13:57:28'),
(39, 'Swiss Chard', 'Swiss Chard', 50, 5, 2.50, '2026-01-21 13:57:28'),
(40, 'Beet', 'Beet', 55, 14, 3.00, '2026-01-21 13:57:28'),
(41, 'Turnip', 'Turnip', 50, 21, 3.50, '2026-01-21 13:57:28'),
(42, 'Parsnip', 'Parsnip', 120, 30, 2.50, '2026-01-21 13:57:28'),
(43, 'Rutabaga', 'Rutabaga', 90, 60, 3.00, '2026-01-21 13:57:28'),
(44, 'Kohlrabi', 'Kohlrabi', 55, 14, 2.50, '2026-01-21 13:57:28'),
(45, 'Bok Choy', 'Petsay', 50, 5, 2.80, '2026-01-21 13:57:28'),
(46, 'Napa Cabbage', 'Petsay Wombok', 70, 14, 4.00, '2026-01-21 13:57:28'),
(47, 'Arugula', 'Arugula', 40, 5, 1.50, '2026-01-21 13:57:28'),
(48, 'Endive', 'Endivya', 45, 7, 2.00, '2026-01-21 13:57:28'),
(49, 'Radicchio', 'Radikyo', 60, 7, 2.50, '2026-01-21 13:57:28'),
(50, 'Watercress', 'Berro', 30, 3, 2.00, '2026-01-21 13:57:28'),
(51, 'Collard Greens', 'Kolard', 60, 5, 2.50, '2026-01-21 13:57:28'),
(52, 'Mustard', 'Mustasa Puti', 40, 3, 2.20, '2026-01-21 13:57:28'),
(53, 'Sorrel', 'Sorel', 60, 5, 1.80, '2026-01-21 13:57:28'),
(54, 'Dandelion Greens', 'Dandelyon', 50, 5, 1.50, '2026-01-21 13:57:28'),
(55, 'Mizuna', 'Mizuna', 40, 5, 2.00, '2026-01-21 13:57:28'),
(56, 'Tatsoi', 'Tatsoi', 45, 5, 2.20, '2026-01-21 13:57:28'),
(57, 'Malabar Spinach', 'Alugbati', 70, 3, 2.50, '2026-01-21 13:57:28'),
(58, 'Amaranth', 'Kulitis', 40, 3, 2.00, '2026-01-21 13:57:28'),
(59, 'Jicama', 'Singkamas', 150, 30, 4.00, '2026-01-21 13:57:28'),
(60, 'Yam', 'Ube', 240, 30, 4.50, '2026-01-21 13:57:28'),
(61, 'Jerusalem Artichoke', 'Sunchoke', 120, 14, 3.00, '2026-01-21 13:57:28'),
(62, 'Water Spinach', 'Kangkong Tubig', 30, 3, 3.00, '2026-01-21 13:57:28'),
(63, 'Chinese Broccoli', 'Kai-lan', 60, 5, 2.50, '2026-01-21 13:57:28'),
(64, 'Yu Choy', 'Yu Choy', 45, 5, 2.20, '2026-01-21 13:57:28'),
(65, 'Chinese Mustard', 'Gai Choy', 50, 5, 2.50, '2026-01-21 13:57:28'),
(66, 'Snow Peas', 'Sitsaro', 60, 3, 2.00, '2026-01-21 13:57:28'),
(67, 'Snap Peas', 'Snap Peas', 60, 5, 2.20, '2026-01-21 13:57:28'),
(68, 'Lima Beans', 'Patani', 75, 5, 2.50, '2026-01-21 13:57:28'),
(69, 'Fava Beans', 'Fava', 85, 5, 2.80, '2026-01-21 13:57:28'),
(70, 'Soybean', 'Soya', 90, 7, 3.00, '2026-01-21 13:57:28'),
(71, 'Edamame', 'Edamame', 80, 5, 2.50, '2026-01-21 13:57:28'),
(72, 'Mung Bean', 'Munggo', 90, 180, 2.00, '2026-01-21 13:57:28'),
(73, 'Winged Bean', 'Sigarilyas', 70, 5, 2.50, '2026-01-21 13:57:28'),
(74, 'Yard Long Bean', 'Sitaw Tagalog', 60, 3, 2.80, '2026-01-21 13:57:28'),
(75, 'Hyacinth Bean', 'Bataw', 90, 5, 2.50, '2026-01-21 13:57:28'),
(76, 'Pigeon Pea', 'Kadios', 120, 180, 2.00, '2026-01-21 13:57:28'),
(77, 'Chickpea', 'Garbansos', 100, 365, 2.50, '2026-01-21 13:57:28'),
(78, 'Lentil', 'Lentilyas', 100, 365, 2.00, '2026-01-21 13:57:28'),
(79, 'Black-eyed Pea', 'Utong Puti', 75, 180, 2.20, '2026-01-21 13:57:28'),
(80, 'Cowpea', 'Utong', 75, 180, 2.50, '2026-01-21 13:57:28'),
(81, 'Runner Bean', 'Runner Bean', 70, 5, 2.30, '2026-01-21 13:57:28'),
(82, 'Broad Bean', 'Broad Bean', 85, 5, 2.50, '2026-01-21 13:57:28'),
(83, 'Horseradish', 'Malunggay Puti', 150, 60, 2.00, '2026-01-21 13:57:28'),
(84, 'Wasabi', 'Wasabi', 365, 14, 1.50, '2026-01-21 13:57:28'),
(85, 'Parsley', 'Perehil', 70, 7, 1.50, '2026-01-21 13:57:28'),
(86, 'Cilantro', 'Wansoy', 50, 7, 1.80, '2026-01-21 13:57:28'),
(87, 'Dill', 'Eneldo', 60, 7, 1.50, '2026-01-21 13:57:28'),
(88, 'Fennel', 'Hinojo', 65, 7, 2.50, '2026-01-21 13:57:28'),
(89, 'Basil', 'Balanoy', 60, 5, 1.80, '2026-01-21 13:57:28'),
(90, 'Mint', 'Yerba Buena', 70, 7, 2.00, '2026-01-21 13:57:28'),
(91, 'Oregano', 'Oregano', 80, 7, 1.50, '2026-01-21 13:57:28'),
(92, 'Thyme', 'Tomilyo', 90, 7, 1.20, '2026-01-21 13:57:28'),
(93, 'Rosemary', 'Romero', 365, 14, 1.50, '2026-01-21 13:57:28'),
(94, 'Sage', 'Sambong', 365, 7, 1.30, '2026-01-21 13:57:28'),
(95, 'Chives', 'Sibuyas Dahon', 60, 7, 1.50, '2026-01-21 13:57:28'),
(96, 'Scallions', 'Sibuyas Mura', 60, 7, 2.00, '2026-01-21 13:57:28'),
(97, 'Shallots', 'Sibuyas Tagalog', 90, 30, 2.50, '2026-01-21 13:57:28'),
(98, 'Chinese Chives', 'Kuchai', 70, 7, 1.80, '2026-01-21 13:57:28'),
(99, 'Lemongrass', 'Tanglad', 120, 14, 2.00, '2026-01-21 13:57:28'),
(100, 'Spring Onion', 'Sibuyot', 60, 7, 2.00, '2026-01-21 13:57:28'),
(101, 'Welsh Onion', 'Welsh Onyon', 70, 7, 2.20, '2026-01-21 13:57:28'),
(102, 'Ramps', 'Wild Leek', 150, 5, 1.50, '2026-01-21 13:57:28'),
(103, 'Rhubarb', 'Rubarbo', 365, 7, 2.50, '2026-01-21 13:57:28'),
(104, 'Sea Kale', 'Dagat Repolyo', 365, 7, 1.80, '2026-01-21 13:57:28'),
(105, 'Cardoon', 'Karduna', 120, 7, 2.00, '2026-01-21 13:57:28'),
(106, 'Salsify', 'Salsapi', 120, 14, 2.50, '2026-01-21 13:57:28'),
(107, 'Scorzonera', 'Itim na Salsapi', 120, 14, 2.50, '2026-01-21 13:57:28'),
(108, 'Celeriac', 'Kintsay Ugat', 120, 30, 3.00, '2026-01-21 13:57:28'),
(109, 'Hamburg Parsley', 'Perehil Ugat', 90, 21, 2.50, '2026-01-21 13:57:28'),
(110, 'Florence Fennel', 'Hinojo Bola', 85, 7, 2.50, '2026-01-21 13:57:28'),
(111, 'Radicchio Treviso', 'Radikyo Treviso', 85, 7, 2.00, '2026-01-21 13:57:28'),
(112, 'Belgian Endive', 'Witloof', 150, 7, 2.00, '2026-01-21 13:57:28'),
(113, 'Frisee', 'Frise', 45, 7, 1.80, '2026-01-21 13:57:28'),
(114, 'Escarole', 'Eskarola', 50, 7, 2.00, '2026-01-21 13:57:28'),
(115, 'Mache', 'Mache', 50, 5, 1.50, '2026-01-21 13:57:28'),
(116, 'Purslane', 'Purslane', 50, 3, 1.80, '2026-01-21 13:57:28'),
(117, 'Chickweed', 'Chickweed', 40, 3, 1.50, '2026-01-21 13:57:28'),
(118, 'Good King Henry', 'Good King Henry', 60, 5, 1.80, '2026-01-21 13:57:28'),
(119, 'Orach', 'Bundok Espinaka', 50, 3, 2.00, '2026-01-21 13:57:28'),
(120, 'New Zealand Spinach', 'Tetragonia', 70, 5, 2.20, '2026-01-21 13:57:28'),
(121, 'Ice Plant', 'Yelo Halaman', 70, 5, 1.50, '2026-01-21 13:57:28'),
(122, 'Skirret', 'Skirret', 120, 14, 2.00, '2026-01-21 13:57:28'),
(123, 'Chinese Artichoke', 'Crosnes', 120, 7, 1.80, '2026-01-21 13:57:28'),
(124, 'Oca', 'Oka', 180, 14, 2.50, '2026-01-21 13:57:28'),
(125, 'Ulluco', 'Ulukor', 180, 14, 2.50, '2026-01-21 13:57:28'),
(126, 'Mashua', 'Mashua', 180, 14, 2.00, '2026-01-21 13:57:28'),
(127, 'Yacon', 'Yakon', 200, 14, 4.00, '2026-01-21 13:57:28'),
(128, 'Arracacha', 'Arakaka', 240, 14, 3.50, '2026-01-21 13:57:28'),
(129, 'Maca', 'Maka', 240, 180, 2.00, '2026-01-21 13:57:28'),
(130, 'Canna', 'Kana Lily', 180, 14, 3.00, '2026-01-21 13:57:28'),
(131, 'Arrowroot', 'Uraro', 300, 30, 3.50, '2026-01-21 13:57:28'),
(132, 'Lotus Root', 'Lotes Ugat', 120, 14, 2.50, '2026-01-21 13:57:28'),
(133, 'Water Chestnut', 'Apulid', 120, 14, 2.00, '2026-01-21 13:57:28'),
(134, 'Bamboo Shoots', 'Labong', 365, 7, 3.00, '2026-01-21 13:57:28'),
(135, 'Heart of Palm', 'Ubod', 365, 7, 2.00, '2026-01-21 13:57:28'),
(136, 'Fiddlehead Fern', 'Pako', 365, 3, 1.50, '2026-01-21 13:57:28'),
(137, 'Nopales', 'Cactus Pad', 365, 7, 2.50, '2026-01-21 13:57:28'),
(138, 'Chayote', 'Sayote', 90, 14, 3.50, '2026-01-21 13:57:28'),
(139, 'Bottle Gourd', 'Upo', 80, 7, 4.00, '2026-01-21 13:57:28'),
(140, 'Ridge Gourd', 'Patola', 70, 5, 2.50, '2026-01-21 13:57:28'),
(141, 'Snake Gourd', 'Ahas Kalabasa', 70, 5, 2.80, '2026-01-21 13:57:28'),
(142, 'Sponge Gourd', 'Patola Espongha', 75, 5, 2.50, '2026-01-21 13:57:28'),
(143, 'Ash Gourd', 'Kundol', 120, 180, 5.00, '2026-01-21 13:57:28'),
(144, 'Ivy Gourd', 'Tindora', 60, 5, 2.00, '2026-01-21 13:57:28'),
(145, 'Armenian Cucumber', 'Yard Long Melon', 70, 7, 3.50, '2026-01-21 13:57:28'),
(146, 'Luffa', 'Bunga Patola', 80, 5, 2.50, '2026-01-21 13:57:28'),
(147, 'Wax Gourd', 'Winter Melon', 120, 180, 5.50, '2026-01-21 13:57:28'),
(148, 'Horned Melon', 'Kiwano', 90, 14, 2.50, '2026-01-21 13:57:28'),
(149, 'Chinese Okra', 'Sigwa', 70, 5, 2.80, '2026-01-21 13:57:28'),
(150, 'Caper', 'Kaper', 365, 180, 1.00, '2026-01-21 13:57:28'),
(151, 'Samphire', 'Dagat Asparagus', 60, 5, 1.50, '2026-01-21 13:57:28'),
(152, 'Sea Beet', 'Dagat Beet', 60, 5, 2.00, '2026-01-21 13:57:28'),
(153, 'Saltwort', 'Asin Damo', 50, 3, 1.50, '2026-01-21 13:57:28'),
(154, 'Glasswort', 'Salikor', 50, 3, 1.50, '2026-01-21 13:57:28'),
(155, 'Pokeweed', 'Pokwid', 60, 1, 1.80, '2026-01-21 13:57:28'),
(156, 'Wild Garlic', 'Ilang Bawang', 150, 5, 1.50, '2026-01-21 13:57:28'),
(157, 'Rampion', 'Rampion', 120, 7, 1.80, '2026-01-21 13:57:28'),
(158, 'Evening Primrose', 'Gabi ng Primrose', 365, 7, 1.50, '2026-01-21 13:57:28'),
(159, 'Comfrey', 'Komfri', 365, 3, 2.00, '2026-01-21 13:57:28'),
(160, 'Nettle', 'Liparot', 60, 3, 1.80, '2026-01-21 13:57:28'),
(161, 'Fat Hen', 'Lambs Quarters', 50, 3, 1.50, '2026-01-21 13:57:28'),
(162, 'Black Nightshade', 'Onti', 70, 3, 1.50, '2026-01-21 13:57:28'),
(163, 'Garden Huckleberry', 'Wonderberry', 75, 5, 2.00, '2026-01-21 13:57:28'),
(164, 'Tomatillo', 'Tomatilyo', 75, 14, 3.00, '2026-01-21 13:57:28'),
(165, 'Ground Cherry', 'Lupa Berri', 70, 14, 2.00, '2026-01-21 13:57:28'),
(166, 'Cape Gooseberry', 'Gintong Berri', 75, 30, 2.50, '2026-01-21 13:57:28'),
(167, 'Pepino', 'Pepino Melon', 120, 14, 3.00, '2026-01-21 13:57:28'),
(168, 'Naranjilla', 'Lulo', 180, 7, 2.50, '2026-01-21 13:57:28'),
(169, 'Tamarillo', 'Puno Kamatis', 365, 14, 3.00, '2026-01-21 13:57:28'),
(170, 'Garden Sorrel', 'Halamang Sorel', 60, 5, 1.80, '2026-01-21 13:57:28'),
(171, 'Wood Sorrel', 'Kahoy Sorel', 50, 3, 1.20, '2026-01-21 13:57:28'),
(172, 'Sheep Sorrel', 'Tupa Sorel', 50, 3, 1.20, '2026-01-21 13:57:28'),
(173, 'Plantain', 'Lanting', 60, 3, 1.50, '2026-01-21 13:57:28'),
(174, 'Violet', 'Violeta', 60, 3, 1.20, '2026-01-21 13:57:28'),
(175, 'Nasturtium', 'Nasturyum', 50, 3, 1.50, '2026-01-21 13:57:28'),
(176, 'Marigold', 'Marigold', 60, 3, 1.00, '2026-01-21 13:57:28'),
(177, 'Calendula', 'Kalendula', 60, 180, 1.00, '2026-01-21 13:57:28'),
(178, 'Borage', 'Boraha', 55, 3, 1.50, '2026-01-21 13:57:28'),
(179, 'Hyssop', 'Hisopo', 365, 7, 1.20, '2026-01-21 13:57:28'),
(180, 'Lovage', 'Lovahe', 365, 7, 2.00, '2026-01-21 13:57:28'),
(181, 'Angelica', 'Anhelika', 365, 7, 1.50, '2026-01-21 13:57:28'),
(182, 'Caraway', 'Karaway', 365, 180, 1.00, '2026-01-21 13:57:28'),
(183, 'Cumin', 'Kumino', 120, 365, 1.20, '2026-01-21 13:57:28'),
(184, 'Coriander', 'Kulantro', 100, 365, 1.50, '2026-01-21 13:57:28'),
(185, 'Anise', 'Anis', 120, 365, 1.00, '2026-01-21 13:57:28'),
(186, 'Sweet Cicely', 'Matamis Sisili', 365, 7, 1.50, '2026-01-21 13:57:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crops`
--
ALTER TABLE `crops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crop_statistics`
--
ALTER TABLE `crop_statistics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_crop_logs`
--
ALTER TABLE `daily_crop_logs`
  ADD PRIMARY KEY (`daily_log_id`);

--
-- Indexes for table `deleted_products`
--
ALTER TABLE `deleted_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `farm_activities`
--
ALTER TABLE `farm_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `farm_details`
--
ALTER TABLE `farm_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `farm_resources`
--
ALTER TABLE `farm_resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `harvested_products`
--
ALTER TABLE `harvested_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `order_status_history`
--
ALTER TABLE `order_status_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`invoice_number`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_histories`
--
ALTER TABLE `product_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_types`
--
ALTER TABLE `product_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review_images`
--
ALTER TABLE `review_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seasonal_crops`
--
ALTER TABLE `seasonal_crops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seller_reviews`
--
ALTER TABLE `seller_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vegetable_crops`
--
ALTER TABLE `vegetable_crops`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `local_name` (`local_name`),
  ADD KEY `idx_crop_name` (`crop_name`),
  ADD KEY `idx_days_to_harvest` (`days_to_harvest`),
  ADD KEY `idx_shelf_life` (`shelf_life_days`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crops`
--
ALTER TABLE `crops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `crop_statistics`
--
ALTER TABLE `crop_statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_crop_logs`
--
ALTER TABLE `daily_crop_logs`
  MODIFY `daily_log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `deleted_products`
--
ALTER TABLE `deleted_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `farm_activities`
--
ALTER TABLE `farm_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `farm_details`
--
ALTER TABLE `farm_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `farm_resources`
--
ALTER TABLE `farm_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `harvested_products`
--
ALTER TABLE `harvested_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `order_status_history`
--
ALTER TABLE `order_status_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product_histories`
--
ALTER TABLE `product_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_types`
--
ALTER TABLE `product_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `review_images`
--
ALTER TABLE `review_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `seasonal_crops`
--
ALTER TABLE `seasonal_crops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `seller_reviews`
--
ALTER TABLE `seller_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vegetable_crops`
--
ALTER TABLE `vegetable_crops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
