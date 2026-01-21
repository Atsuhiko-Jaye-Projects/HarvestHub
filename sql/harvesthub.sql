-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2026 at 04:34 AM
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
(32, 19, 2, 20, '2026-01-19 09:41:48', 22, 'ordered', '2026-01-19 01:42:54', 1, 'harvest'),
(33, 19, 2, 15, '2026-01-19 09:42:49', 22, 'ordered', '2026-01-19 01:42:54', 1, 'harvest'),
(34, 22, 2, 5, '2026-01-19 15:39:49', 20, 'ordered', '2026-01-21 02:04:49', 1, 'harvest');

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
(1, 1, 'Marinduque', 'Mogpog', 'Anapog-Sibucao', 'Purok 2', 'owned', 1000, '2026-01-13 16:18:01', '2026-01-13 08:18:01', 0, 'Mondragon', '', 0, '', 0, 0);

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
(4, 1, 'FID69606749', 'Kamatis planting', 'kamatis', 100, 2.4, 3000, '2026-01-17', '2026-01-21 03:31:42', '2026-01-17 12:26:20', 73, ''),
(5, 1, 'FID69609091', 'kalabasa expense', 'kalabasa', 200, 3.4, 5000, '2026-01-17', '2026-01-21 03:11:33', '2026-01-17 12:27:06', 90, 'crop planted'),
(6, 1, 'FID69602932', 'okra expense', 'Okra', 100, 3.4, 3500, '2026-01-17', '2026-01-19 05:42:28', '2026-01-17 12:27:46', 89, ''),
(7, 1, 'FID69691569', 'Potato Expense', 'Potato', 76, 2.5, 6300, '2026-01-19', '2026-01-21 02:53:04', '2026-01-19 10:07:01', 60, '');

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
(22, 1, 'Kamote', 17, 'KG', 'Vegetable', '76', 'Kamote (Ipomoea batatas), or sweet potato, is a versatile root vegetable known for its large, starchy, sweet-tasting tubers and edible heart-shaped leaves (talbos ng kamote). Belonging to the morning glory family (Convolvulaceae), it\'s a vital staple in the Philippines, eaten boiled, fried, roasted,', 350, 0, '7537ce549714a622697ca1cc1c15a56b743305d6-kamote.jpg', '2026-01-19 02:04:44', '2026-01-19 10:04:24', 'Posted', 100, 5000, 3.5);

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
(35, 22, 'INV-6970344148813', 2, 'COP', 15, 'complete', '2026-01-21 10:04:49', '2026-01-21 02:05:43', 1, 'harvest', 1, '', 1);

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
(20, 'INV-6970344148813', 'order recieved', '2026-01-21 10:05:46', 22, 1);

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
(6, 19, 'Kalabasa', 22, 1, 'Vegetable', 'KG', 0, 'kalabasa great', 90, 350, 'd3ecde51500da84c80b1f62ebf6485b4c171813a-kalabasa.jpg', 105, '2026-01-17 04:30:42', '2026-01-17 12:30:42', 'Active', 'harvest', 245, NULL),
(7, 4, 'kamatis', 15, 1, 'vegetable', '', 0, 'Reserve fresh farm produce ahead of time and get it delivered at peak quality.', 0, 240, '2a7cb252aa6e87d07c2bf4f8c4191b8b84682f3f-kamatis.jpg', 40, '2026-01-17 04:36:30', '2026-01-17 12:36:30', 'Active', 'preorder', 200, NULL),
(9, 22, 'Kamote', 20, 1, 'Vegetable', 'KG', 0, 'Kamote (Ipomoea batatas), or sweet potato, is a versatile root vegetable known for its large, starchy, sweet-tasting tubers and edible heart-shaped leaves (talbos ng kamote). Belonging to the morning glory family (Convolvulaceae), it\'s a vital staple in the Philippines, eaten boiled, fried, roasted,', 76, 350, '7537ce549714a622697ca1cc1c15a56b743305d6-kamote.jpg', 30, '2026-01-19 02:04:44', '2026-01-19 10:04:44', 'Active', 'harvest', 320, NULL),
(10, 5, 'Potato', 33, 1, 'vegetable', '', 0, 'Reserve fresh farm produce ahead of time and get it delivered at peak quality.', 0, 190, 'b5ff02adfcd4876f6f67f8e5f4240669c142e6b5-patatas.jpg', 0, '2026-01-19 02:07:42', '2026-01-19 10:07:42', 'Active', 'preorder', 190, NULL);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `crop_statistics`
--
ALTER TABLE `crop_statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `order_status_history`
--
ALTER TABLE `order_status_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
-- AUTO_INCREMENT for table `seller_reviews`
--
ALTER TABLE `seller_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
