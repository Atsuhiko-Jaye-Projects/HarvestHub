-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2025 at 03:00 AM
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
(10, 1, 1, 10, '2025-12-05 20:07:44', 125, 'ordered', '2025-12-05 12:08:00', 2, 'preorder'),
(11, 2, 1, 20, '2025-12-05 20:07:52', 188, 'ordered', '2025-12-05 12:08:00', 2, 'harvest'),
(12, 5, 1, 25, '2025-12-07 10:31:49', 20, 'ordered', '2025-12-07 02:31:54', 2, 'harvest'),
(13, 3, 1, 10, '2025-12-07 11:23:44', 89, 'ordered', '2025-12-07 03:23:50', 2, 'harvest');

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
  `farmer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `farmer_id`, `user_id`, `created_at`) VALUES
(4, 2, 1, '2025-12-07 17:31:08');

-- --------------------------------------------------------

--
-- Table structure for table `crops`
--

CREATE TABLE `crops` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
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
  `baranggay` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crops`
--

INSERT INTO `crops` (`id`, `user_id`, `crop_name`, `yield`, `cultivated_area`, `date_planted`, `estimated_harvest_date`, `suggested_price`, `modified_at`, `created_at`, `stocks`, `plant_count`, `province`, `municipality`, `baranggay`) VALUES
(1, 2, 'Kalabasa', 2, 56, '2025-12-05', '2026-04-25', 0, '2025-12-05 05:56:53', '2025-12-05 13:56:53', 600, 300, 'Marinduque', 'Mogpog', 'Bintakay'),
(2, 2, 'Kalabasa', 2, 50, '2025-12-06', '2026-05-23', 0, '2025-12-06 10:26:22', '2025-12-06 18:26:22', 534, 300, 'Marinduque', 'Mogpog', 'Bintakay'),
(3, 2, 'mango', 1.8, 50, '2025-12-06', '2026-05-30', 0, '2025-12-06 10:27:42', '2025-12-06 18:27:42', 540, 300, 'Marinduque', 'Mogpog', 'Bintakay'),
(4, 2, 'Melon', 1.8, 5000, '2025-12-07', '2026-06-27', 0, '2025-12-07 03:05:57', '2025-12-07 11:05:57', 360, 200, 'Marinduque', 'Mogpog', 'Bintakay');

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
(1, 2, 'Marinduque', 'Mogpog', 'Bintakay', 'purok quatro', 'owned', 50000, '2025-12-05 13:55:43', '2025-12-05 05:55:43', 0, '', '', 0, '', 0, 0),
(2, 3, 'Marinduque', 'Boac', 'Agot', 'Purok2, anapog-sibucao', 'owned', 50000, '2025-12-07 10:14:48', '2025-12-07 02:14:48', 0, '', '', 0, '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `farm_resources`
--

CREATE TABLE `farm_resources` (
  `id` int(11) NOT NULL,
  `user_id` int(10) NOT NULL,
  `date` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `record_name` varchar(255) NOT NULL,
  `land_prep_expense_cost` double NOT NULL,
  `nursery_seedling_prep_cost` double NOT NULL,
  `transplanting_cost` double NOT NULL,
  `crop_maintenance_cost` double NOT NULL,
  `input_seed_fertilizer_cost` double NOT NULL,
  `harvesting_cost` double NOT NULL,
  `post_harvest_transport_cost` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farm_resources`
--

INSERT INTO `farm_resources` (`id`, `user_id`, `date`, `created_at`, `modified_at`, `record_name`, `land_prep_expense_cost`, `nursery_seedling_prep_cost`, `transplanting_cost`, `crop_maintenance_cost`, `input_seed_fertilizer_cost`, `harvesting_cost`, `post_harvest_transport_cost`) VALUES
(3, 2, '2025-03-01', '2025-12-06 20:50:10', '2025-12-06 12:50:10', '', 0, 0, 0, 0, 0, 0, 0),
(4, 2, '2025-12-06', '2025-12-06 22:01:07', '2025-12-06 14:01:07', 'Kalabas and kamatis expense', 2300, 2660, 23, 3666, 3000, 3666, 2366),
(5, 2, '2025-12-06', '2025-12-06 22:23:52', '2025-12-06 14:23:52', 'kamote expenses', 6000, 6000, 60, 0, 0, 0, 0),
(6, 2, '2025-12-06', '2025-12-06 22:28:52', '2025-12-06 15:01:11', '100sqm expsnese for kamatis ahah', 2500, 16830, 2562, 3000, 31500, 18000, 0);

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
(6, 2, 'Kalabasa', 19, 'KG', 'Vegetable', '1000', '', 400, 0, '3a923d600b2ee6969d7b4ccf7f5de0553367890e-kalabasa.jpg', '2025-12-06 11:55:17', '2025-12-06 19:55:17', 'Pending', 200, 5000, 2),
(7, 2, 'Kalabasa', 19, 'KG', 'Fruit', '50', '', 400, 0, '3a923d600b2ee6969d7b4ccf7f5de0553367890e-kalabasa.jpg', '2025-12-06 12:48:49', '2025-12-06 20:48:49', 'Pending', 200, 5000, 2),
(8, 2, 'Bangus', 66, 'KG', 'Vegetable', '50', '', 400, 0, '250a1561bac83ac86b2ae48565c04e7e060c2661-SweetPotato.jpg', '2025-12-06 16:25:17', '2025-12-07 00:25:17', 'Pending', 200, 17681, 2),
(9, 2, 'Okra', 74, 'KG', 'Vegetable', '200', '', 360, 0, '4dbc856221c23e1ea0c18bc08ac1b2fa5bc27ccb-6.jpg', '2025-12-07 02:27:54', '2025-12-07 10:27:54', 'Pending', 200, 17681, 1.8);

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
  `farmer_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `conversation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `farmer_id`, `message`, `user_id`, `timestamp`, `created`, `conversation_id`) VALUES
(1, 2, 'hey', 1, '2025-12-07 10:34:46', '2025-12-07 18:34:46', 4),
(2, 2, 'wassaup', 1, '2025-12-07 10:36:06', '2025-12-07 18:36:06', 4),
(3, 2, 'he', 1, '2025-12-07 10:36:11', '2025-12-07 18:36:11', 4),
(4, 2, 'wasst', 1, '2025-12-07 10:36:13', '2025-12-07 18:36:13', 4),
(5, 2, 'ye', 1, '2025-12-07 10:37:31', '2025-12-07 18:37:31', 4),
(6, 2, 'qwewq', 1, '2025-12-07 10:39:17', '2025-12-07 18:39:17', 4),
(7, 2, '231321', 1, '2025-12-07 10:41:15', '2025-12-07 18:41:15', 4),
(8, 2, '231321', 1, '2025-12-07 10:41:17', '2025-12-07 18:41:17', 4),
(9, 2, 'sadasd', 1, '2025-12-07 10:44:50', '2025-12-07 18:44:50', 4),
(10, 2, 'asdasda', 1, '2025-12-07 10:45:33', '2025-12-07 18:45:33', 4),
(11, 2, 'qweqw', 1, '2025-12-07 10:45:37', '2025-12-07 18:45:37', 4),
(12, 2, 'qwewqe', 1, '2025-12-07 10:46:38', '2025-12-07 18:46:38', 4),
(13, 2, 'qwe', 1, '2025-12-07 10:46:39', '2025-12-07 18:46:39', 4),
(14, 2, 'qwewqewq', 1, '2025-12-07 10:46:39', '2025-12-07 18:46:39', 4),
(15, 2, 'qweqw', 1, '2025-12-07 10:46:40', '2025-12-07 18:46:40', 4),
(16, 2, 'eqweqw', 1, '2025-12-07 10:46:40', '2025-12-07 18:46:40', 4),
(17, 2, 'eqw', 1, '2025-12-07 10:46:40', '2025-12-07 18:46:40', 4),
(18, 2, 'qweq', 1, '2025-12-07 10:46:41', '2025-12-07 18:46:41', 4),
(19, 2, 'eqwe', 1, '2025-12-07 10:46:41', '2025-12-07 18:46:41', 4),
(20, 2, 'qwe', 1, '2025-12-07 10:46:41', '2025-12-07 18:46:41', 4),
(21, 2, 'asd\'lmad;lasmd;alsm', 1, '2025-12-07 10:46:42', '2025-12-07 18:46:42', 4),
(22, 2, 'lamd;lasmd;aslmd', 1, '2025-12-07 10:46:44', '2025-12-07 18:46:44', 4),
(23, 2, 'hey', 1, '2025-12-07 10:46:48', '2025-12-07 18:46:48', 4),
(24, 2, 'asdas', 1, '2025-12-07 10:47:35', '2025-12-07 18:47:35', 4),
(25, 2, 'qwe', 1, '2025-12-07 10:47:41', '2025-12-07 18:47:41', 4),
(26, 2, 'qwe', 1, '2025-12-07 10:47:41', '2025-12-07 18:47:41', 4),
(27, 2, 'qweqw', 1, '2025-12-07 10:47:42', '2025-12-07 18:47:42', 4),
(28, 2, 'eqwe', 1, '2025-12-07 10:47:42', '2025-12-07 18:47:42', 4),
(29, 2, 'wqe', 1, '2025-12-07 10:47:42', '2025-12-07 18:47:42', 4),
(30, 2, 'qweqwewq', 1, '2025-12-07 10:49:43', '2025-12-07 18:49:43', 4),
(31, 2, 'qwewq', 1, '2025-12-07 10:49:44', '2025-12-07 18:49:44', 4),
(32, 2, 'qwewqewq', 1, '2025-12-07 10:49:47', '2025-12-07 18:49:47', 4),
(33, 2, 'qwewqewq', 1, '2025-12-07 10:49:49', '2025-12-07 18:49:49', 4),
(34, 2, 'qweqw', 1, '2025-12-07 10:49:50', '2025-12-07 18:49:50', 4),
(35, 2, 'qweqw', 1, '2025-12-07 10:49:50', '2025-12-07 18:49:50', 4),
(36, 2, 'qweqw', 1, '2025-12-07 10:49:50', '2025-12-07 18:49:50', 4),
(37, 2, 'qweqw', 1, '2025-12-07 10:49:51', '2025-12-07 18:49:51', 4),
(38, 2, 'qweqw', 1, '2025-12-07 10:49:51', '2025-12-07 18:49:51', 4),
(39, 2, 'eqw', 1, '2025-12-07 10:49:51', '2025-12-07 18:49:51', 4),
(40, 2, 'qe', 1, '2025-12-07 10:49:52', '2025-12-07 18:49:52', 4),
(41, 2, 'qweqw', 1, '2025-12-07 10:49:52', '2025-12-07 18:49:52', 4),
(42, 2, 'asd', 1, '2025-12-07 10:49:52', '2025-12-07 18:49:52', 4),
(43, 2, 'fasdsas3d1asdasdfasf1a', 1, '2025-12-07 10:49:54', '2025-12-07 18:49:54', 4),
(44, 2, 'qwqweqw', 1, '2025-12-07 10:51:40', '2025-12-07 18:51:40', 4),
(45, 2, 'eqweqw', 1, '2025-12-07 10:51:40', '2025-12-07 18:51:40', 4),
(46, 2, 'eqwe', 1, '2025-12-07 10:51:41', '2025-12-07 18:51:41', 4),
(47, 2, 'weqwe', 1, '2025-12-07 10:51:41', '2025-12-07 18:51:41', 4),
(48, 2, 'qweqw', 1, '2025-12-07 10:51:41', '2025-12-07 18:51:41', 4),
(49, 2, 'awdea', 1, '2025-12-07 10:51:42', '2025-12-07 18:51:42', 4),
(50, 2, 'das', 1, '2025-12-07 10:51:42', '2025-12-07 18:51:42', 4),
(51, 2, 'asdas', 1, '2025-12-07 10:51:42', '2025-12-07 18:51:42', 4),
(52, 2, 'qeqweqw', 1, '2025-12-07 10:51:47', '2025-12-07 18:51:47', 4),
(53, 2, 'qweqweqw', 1, '2025-12-07 10:51:48', '2025-12-07 18:51:48', 4),
(54, 2, 'wqewqewq', 1, '2025-12-07 10:52:00', '2025-12-07 18:52:00', 4),
(55, 2, 'qeqweqw', 1, '2025-12-07 10:52:02', '2025-12-07 18:52:02', 4),
(56, 2, 'potanginam o', 1, '2025-12-07 10:52:04', '2025-12-07 18:52:04', 4),
(57, 2, 'haidaslkdnaskldnaslndlkasdna', 1, '2025-12-07 10:52:06', '2025-12-07 18:52:06', 4),
(58, 2, 'hahahah', 1, '2025-12-07 10:52:07', '2025-12-07 18:52:07', 4),
(59, 2, 'ge tra', 1, '2025-12-07 10:52:09', '2025-12-07 18:52:09', 4),
(60, 2, 'a;dadnas,.dna.s', 1, '2025-12-07 10:52:10', '2025-12-07 18:52:10', 4),
(61, 2, 'tra', 1, '2025-12-07 10:52:11', '2025-12-07 18:52:11', 4),
(62, 2, 'g na', 1, '2025-12-07 10:52:12', '2025-12-07 18:52:12', 4),
(63, 2, 'HAHAHHA', 1, '2025-12-07 10:52:13', '2025-12-07 18:52:13', 4),
(64, 2, 'dasdasdas', 1, '2025-12-07 10:54:28', '2025-12-07 18:54:28', 4),
(65, 2, 'asdas', 1, '2025-12-07 10:54:28', '2025-12-07 18:54:28', 4),
(66, 2, 'dasd', 1, '2025-12-07 10:54:28', '2025-12-07 18:54:28', 4),
(67, 2, 'asd', 1, '2025-12-07 10:54:29', '2025-12-07 18:54:29', 4),
(68, 2, 'asd', 1, '2025-12-07 10:54:29', '2025-12-07 18:54:29', 4),
(69, 2, 'asd', 1, '2025-12-07 10:54:29', '2025-12-07 18:54:29', 4),
(70, 2, 'asd', 1, '2025-12-07 10:54:29', '2025-12-07 18:54:29', 4),
(71, 2, 'qweqwewq', 1, '2025-12-07 10:54:48', '2025-12-07 18:54:48', 4),
(72, 2, 'asdas', 1, '2025-12-07 10:54:51', '2025-12-07 18:54:51', 4),
(73, 2, 'qweqweqw', 1, '2025-12-07 10:59:48', '2025-12-07 18:59:48', 4),
(74, 2, 'ahdhahdahaha', 1, '2025-12-07 11:04:15', '2025-12-07 19:04:15', 4),
(75, 2, 'asdasdas', 1, '2025-12-07 11:04:34', '2025-12-07 19:04:34', 4),
(76, 2, 'dasdasd', 1, '2025-12-07 11:04:34', '2025-12-07 19:04:34', 4),
(77, 2, 'asdas', 1, '2025-12-07 11:04:35', '2025-12-07 19:04:35', 4),
(78, 2, 'dasdas', 1, '2025-12-07 11:04:35', '2025-12-07 19:04:35', 4),
(79, 2, 'wqeqweq', 1, '2025-12-07 11:04:43', '2025-12-07 19:04:43', 4),
(80, 2, 'game', 1, '2025-12-07 11:05:07', '2025-12-07 19:05:07', 4),
(81, 2, 'game', 1, '2025-12-07 11:05:08', '2025-12-07 19:05:08', 4);

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
  `reason` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `product_id`, `invoice_number`, `customer_id`, `mode_of_payment`, `quantity`, `status`, `created_at`, `modified_at`, `farmer_id`, `product_type`, `review_status`, `reason`) VALUES
(14, 5, 'INV-6934E71A99904', 1, 'COD', 25, 'complete', '2025-12-07 10:31:54', '2025-12-07 03:34:18', 2, 'harvest', 1, ''),
(15, 3, 'INV-6934F3465ECDF', 1, 'COP', 10, 'complete', '2025-12-07 11:23:50', '2025-12-07 03:26:58', 2, 'harvest', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `order_status_history`
--

CREATE TABLE `order_status_history` (
  `id` int(11) NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `timestamp` datetime NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_status_history`
--

INSERT INTO `order_status_history` (`id`, `invoice_number`, `status`, `timestamp`, `product_id`) VALUES
(46, 'INV-6934E71A99904', 'order placed', '2025-12-07 10:31:54', 5),
(47, 'INV-6934E71A99904', 'accept', '2025-12-07 10:12:06', 5),
(48, 'INV-6934E71A99904', 'order shipout', '2025-12-07 10:12:08', 5),
(49, 'INV-6934E71A99904', 'order recieved', '2025-12-07 10:12:28', 5),
(50, 'INV-6934F3465ECDF', 'order placed', '2025-12-07 11:23:50', 3),
(51, 'INV-6934E71A99904', 'accept', '2025-12-07 11:12:14', 5),
(52, 'INV-6934F3465ECDF', 'accept', '2025-12-07 11:12:20', 3),
(53, 'INV-6934F3465ECDF', 'order shipout', '2025-12-07 11:12:25', 3),
(54, 'INV-6934E71A99904', 'order shipout', '2025-12-07 11:12:33', 5),
(55, 'INV-6934F3465ECDF', 'order recieved', '2025-12-07 11:12:58', 3),
(56, 'INV-6934E71A99904', 'order recieved', '2025-12-07 11:12:18', 5);

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
(5, 3, 'talong', 89, 2, '', 'KG', 0, '', 1000, 400, '3a923d600b2ee6969d7b4ccf7f5de0553367890e-kalabasa.jpg', 20, '2025-12-06 11:41:56', '2025-12-06 19:41:56', 'Active', 'harvest', 380, NULL),
(6, 5, 'talongPAs', 20, 2, 'Vegetable', 'KG', 0, '', 1000, 400, '3a923d600b2ee6969d7b4ccf7f5de0553367890e-kalabasa.jpg', 100, '2025-12-06 11:54:29', '2025-12-06 19:54:29', 'Active', 'harvest', 300, NULL);

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
(1, 3, 2, 1, 5, 'test', '', '2025-12-07 11:28:49', '2025-12-07 03:28:49', 0, 0, '', '', ''),
(2, 5, 2, 1, 5, 'great', '', '2025-12-07 11:34:30', '2025-12-07 03:34:30', 0, 0, '', '', '');

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
(1, 'testconsumer', 'testfirstname', 'testconsumer@gmail.com', '12345678911', 'purok 3 tres', 'bintakay', 'mogpog', 'marinduque', 'consumer', '$2y$10$CGg4Y5imBoKMZXAOu1janOtaNJ.MhNRarBT/OSK2W7k8E85DQOHYC', 0, '2025-12-05 13:53:02', 0, '2025-12-05 13:53:02', '0', '', 1, ''),
(2, 'test', 'testfarmer', 'testfarmer@gmail.com', '09533307696', 'purok 4 quatro', 'laon', 'mogpog', 'marinduque', 'Farmer', '$2y$10$nZ.RXNQn588vcTARnQNUCeu7MCP9ttDpRCChhCqL8fZ8tO54Y8xV6', 0, '2025-12-05 13:53:44', 0, '2025-12-05 13:53:44', '1', '', 1, ''),
(3, 'AlexisJaye', 'Dumale', 'alexisdumale@gmail.com', '+639533307696', '', '', '', '', 'Farmer', '$2y$10$cPjZcN/NRSnKPhBAWS6YQuMqtLOceEybufg1G21WF5dZjZlo6O5Ie', 0, '2025-12-07 10:14:07', 0, '2025-12-07 10:14:07', '1', '', 1, '2bc90d07eb1c0cf263f94be40646c600fbde93ec1013da5fd2439ea9aed316f1');

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
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `crops`
--
ALTER TABLE `crops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- AUTO_INCREMENT for table `farm_details`
--
ALTER TABLE `farm_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `farm_resources`
--
ALTER TABLE `farm_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `harvested_products`
--
ALTER TABLE `harvested_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `order_status_history`
--
ALTER TABLE `order_status_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_histories`
--
ALTER TABLE `product_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
