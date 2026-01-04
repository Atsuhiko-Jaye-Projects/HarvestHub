-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2026 at 12:35 PM
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
(1, 1, 2, 5, '2025-12-19 17:50:04', 5000, 'ordered', '2025-12-19 15:47:09', 1, 'harvest');

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

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `receiver_id`, `sender_id`, `created_at`) VALUES
(3, 1, 2, '2025-12-19 22:29:38'),
(4, 3, 2, '2025-12-19 22:30:17'),
(5, 1, 1, '2025-12-19 22:32:46');

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
  `crop_status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crops`
--

INSERT INTO `crops` (`id`, `user_id`, `farm_resource_id`, `crop_name`, `yield`, `cultivated_area`, `date_planted`, `estimated_harvest_date`, `suggested_price`, `modified_at`, `created_at`, `stocks`, `plant_count`, `province`, `municipality`, `baranggay`, `crop_status`) VALUES
(1, 1, 'FID6933689450', 'Kalabasa Hybrid', 2.1, 1000, '2025-12-20', '2026-02-03', 0, '2025-12-20 15:29:27', '2025-12-20 23:29:27', 420, 200, 'Marinduque', 'Mogpog', 'Anapog-Sibucao', 'crop planted'),
(2, 1, 'FID69451994404', 'Kamote Hybrid', 500, 1200, '2025-12-20', '2026-02-03', 0, '2025-12-24 15:16:43', '2025-12-20 23:30:39', 100000, 200, 'Marinduque', 'Mogpog', 'Anapog-Sibucao', '');

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
(1, 'FID6933689450', 'harrowings', 499, 'mulching', '2025-12-18 00:00:00', '2025-12-15 17:23:50', '0000-00-00 00:00:00', 0, 'none'),
(2, 'FID69413822959', 'Kamayan', 5000, 'transplanting', '2025-12-17 00:00:00', '2025-12-16 19:03:30', '0000-00-00 00:00:00', 0, 'great'),
(3, 'FID69413969081', 'Kamayan', 5000, 'transplanting', '2025-12-17 00:00:00', '2025-12-16 19:03:50', '0000-00-00 00:00:00', 0, 'great'),
(4, 'FID6941312505', 'Kamayan', 5000, 'transplanting', '2025-12-17 00:00:00', '2025-12-16 19:04:01', '0000-00-00 00:00:00', 0, 'great'),
(5, 'FID694131376', 'Kamayan', 5000, 'transplanting', '2025-12-17 00:00:00', '2025-12-16 19:05:05', '0000-00-00 00:00:00', 0, 'great'),
(6, 'FID69451994404', 'Kamayan', 6000, 'pest_control', '2025-12-26 00:00:00', '2025-12-19 17:23:38', '0000-00-00 00:00:00', 0, 'great'),
(7, 'FID6945510', 'Kamayan', 62000, 'land_prep', '0000-00-00 00:00:00', '2025-12-19 22:02:35', '0000-00-00 00:00:00', 0, '');

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
(1, 1, 'Marinduque', 'Mogpog', 'Anapog-Sibucao', 'Purok2, anapog-sibucao', 'rented', 5000, '2025-12-15 17:20:42', '2025-12-15 09:20:42', 2450, 'Mondragon Farm', 'Vegetable', 0, '', 0, 0),
(2, 3, 'Marinduque', 'Mogpog', 'Anapog-Sibucao', 'Purok2, anapog-sibucao', 'owned', 7000, '2025-12-19 22:01:46', '2025-12-19 14:01:46', 23, 'Griggots Farm', 'Vegetable', 0, '', 0, 0);

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
(1, 1, 'FID6933689450', '100sqm expsnese for kamatis', 'Kalabasa Hybrid', 200, 2.1, 499, '2025-12-15', '2025-12-20 15:29:27', '2025-12-15 17:23:50', 0, ''),
(3, 1, 'FID69451994404', '100sqm expsnese for kamatis', 'Kamote Hybrid', 200, 500, 6000, '2025-12-19', '2025-12-20 15:30:39', '2025-12-19 17:23:38', 0, ''),
(4, 3, 'FID6945510', '100sqm expsnese for kamatis', 'Kamote Hybrid', 200, 5.2, 62000, '2025-12-19', '2025-12-19 14:02:35', '2025-12-19 22:02:35', 0, '');

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
(1, 1, 'Kalabasa', 0, 'KG', 'Vegetable', '500', 'great', 250000, 0, '31eaf945ca68acd964d58e7426c0f0d075900139-images.jpg', '2025-12-19 09:49:44', '2025-12-19 17:49:23', 'Posted', 50000, 6000, 5),
(2, 3, 'kamote', 221, 'KG', 'Vegetable', '1000', '', 420, 0, '48d0c23bba4830341c39fb0fd6252bf7dc583d2f-Gemini_Generated_Image_vaz9j5vaz9j5vaz9.png', '2025-12-19 14:03:35', '2025-12-19 22:02:57', 'Posted', 200, 62000, 2.1),
(3, 1, 'Kamote Hybrid', 2, 'KG', 'Vegetable', '1000', 'ge', 420, 0, 'b4cfd24f81fd11aeda04a3b94f2ab5df67a19cb4-595265235_1402981218063217_1320186728234595297_n.png', '2025-12-20 16:56:01', '2025-12-21 00:56:01', 'Pending', 200, 499, 2.1);

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

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `receiver_id`, `message`, `sender_id`, `timestamp`, `created`, `conversation_id`) VALUES
(1, 2, 'hey', 1, '2025-12-20 16:57:08', '2025-12-21 00:57:08', 3);

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
(1, 1, 'INV-6945737D0D5A7', 2, 'COP', 35, 'complete', '2025-12-19 23:47:09', '2025-12-16 15:47:51', 1, 'harvest', 0, ''),
(2, 1, 'INV-6945737D0D5A9', 2, 'COP', 1, 'complete', '2025-12-19 23:47:09', '2025-12-17 15:47:51', 1, 'harvest', 0, ''),
(3, 1, 'INV-6945737D0D5A7', 2, 'COP', 35, 'complete', '2025-12-19 23:47:09', '2025-12-19 15:47:51', 1, 'harvest', 0, ''),
(4, 1, 'INV-6945737D0D5A9', 2, 'COP', 1, 'complete', '2025-12-19 23:47:09', '2025-12-18 15:47:51', 1, 'harvest', 0, ''),
(5, 1, 'INV-6945737D0D5A7', 2, 'COP', 35, 'complete', '2025-12-19 23:47:09', '2025-12-16 15:47:51', 1, 'harvest', 0, '');

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
(1, 'INV-6945737D0D5A7', 'order placed', '2025-12-19 23:47:09', 1),
(2, 'INV-6945737D0D5A7', 'accept', '2025-12-19 23:12:26', 1),
(3, 'INV-6945737D0D5A7', 'order shipout', '2025-12-19 23:12:42', 1),
(4, 'INV-6945737D0D5A7', 'order recieved', '2025-12-19 23:12:51', 1);

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

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email_address`, `token`, `expires_at`) VALUES
(1, 'testfarmer@gmail.com', '0ecab87109898778a5fdf468511afb3f3d7bd0f1f28159ba39c3587173cf9e0c', '2025-12-17 14:10:14');

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
(1, 8, 'Kamote Hybrid', 12, 1, 'fruit', '', 0, 'Reserve fresh farm produce ahead of time and get it delivered at peak quality.', 0, 431, 'ffc3f68e12fc6042dae63fc117f61f18fa48be0b-avaneesh.gif', 0, '2025-12-17 16:08:27', '2025-12-18 00:08:27', 'Active', 'preorder', 431, NULL),
(2, 1, 'Kalabasa', 5000, 1, 'Vegetable', 'KG', 0, 'great', 500, 250000, '31eaf945ca68acd964d58e7426c0f0d075900139-images.jpg', 70, '2025-12-19 09:49:44', '2025-12-19 17:49:44', 'Active', 'harvest', 249930, NULL),
(3, 2, 'kamote', 221, 3, 'Vegetable', 'KG', 0, '', 1000, 420, '48d0c23bba4830341c39fb0fd6252bf7dc583d2f-Gemini_Generated_Image_vaz9j5vaz9j5vaz9.png', 0, '2025-12-19 14:03:35', '2025-12-19 22:03:35', 'Active', 'harvest', 420, NULL);

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
(1, 'AlexisJaye', 'Dumale', 'testfarmer@gmail.com', '', 'Not Set', 'Not Set', 'Not Set', 'Not Set', 'Farmer', '$2y$10$0O7tjs8Au0gZp6JiiOVhLeL7d3Meaj9Fe/zEvO17gvahRty0/WPbC', 0, '2025-12-15 17:19:26', 0, '2025-12-20 21:25:35', '1', '31eaf945ca68acd964d58e7426c0f0d075900139-images.jpg', 1, ''),
(2, 'AlexisJaye', 'Dumale', 'testconsumer@gmail.com', '09533307696', '', '', '', '', 'consumer', '$2y$10$DfKm/DQupm01Ide1dVMOVOGuXmTm4hYIiDUrDdEf/Q8Nwy//sarNa', 0, '2025-12-19 17:45:22', 0, '2025-12-19 17:45:22', '0', '', 1, '7873e0646515ec41e7867275067922c2086bff47c2cc7bb86e85828d4c198d4b'),
(3, 'AlexisJaye', 'Dumale', 'alexisdumale@gmail.com', '+639533307696', '', '', '', '', 'Farmer', '$2y$10$N63HTU7Ed5dg0YChSkjvT.hJB4vX9HEUv5.ca166A/ZzEry7NcdLG', 0, '2025-12-19 22:01:09', 0, '2025-12-19 22:01:09', '1', '', 1, '');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `crops`
--
ALTER TABLE `crops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `farm_details`
--
ALTER TABLE `farm_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `farm_resources`
--
ALTER TABLE `farm_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `harvested_products`
--
ALTER TABLE `harvested_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_status_history`
--
ALTER TABLE `order_status_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_histories`
--
ALTER TABLE `product_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
