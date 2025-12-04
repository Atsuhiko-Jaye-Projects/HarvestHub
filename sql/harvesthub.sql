-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2025 at 10:45 AM
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
(17, 3, 3, 15, '2025-12-04 16:53:18', 50, 'Pending', '2025-12-04 08:53:18', 6, 'harvest');

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
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crops`
--

CREATE TABLE `crops` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `crop_name` varchar(250) NOT NULL,
  `yield` int(11) NOT NULL,
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
(1, 2, 'Sitaw', 2, 50, '2025-12-04', '2026-05-27', 0, '2025-12-04 04:00:55', '2025-12-04 12:00:55', 200, 100, 'Marinduque', 'Mogpog', 'Anapog-Sibucao'),
(2, 2, 'kalabasa', 2, 500, '2025-12-04', '2026-04-30', 0, '2025-12-04 04:03:34', '2025-12-04 12:03:34', 2000, 1000, 'Marinduque', 'Mogpog', 'Anapog-Sibucao'),
(3, 6, 'mango', 3, 50, '2025-12-04', '2026-02-27', 0, '2025-12-04 05:27:43', '2025-12-04 13:27:43', 150, 50, 'Marinduque', 'Mogpog', 'Laon'),
(4, 7, 'Kalabasa', 3, 50, '2025-12-04', '2026-01-23', 0, '2025-12-04 06:01:33', '2025-12-04 14:01:33', 150, 50, 'Marinduque', 'Mogpog', 'Capayang'),
(5, 8, 'Kalabasa', 5, 50, '2025-12-04', '2026-01-28', 0, '2025-12-04 06:09:53', '2025-12-04 14:09:53', 250, 50, 'Marinduque', 'Mogpog', 'Laon'),
(6, 2, 'Kalabasa', 2, 50, '2025-12-04', '2026-05-22', 0, '2025-12-04 07:08:29', '2025-12-04 15:08:29', 400, 200, 'Marinduque', 'Mogpog', 'Anapog-Sibucao');

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
(1, 2, 'Marinduque', 'Mogpog', 'Anapog-Sibucao', 'Purok2', 'owned', 50000, '2025-12-03 15:18:04', '2025-12-03 07:18:04', 0, '', '', 0, '', 0, 0),
(2, 6, 'Marinduque', 'Mogpog', 'Laon', 'Kaunlaran', 'rented', 500, '2025-12-04 13:24:46', '2025-12-04 05:24:46', 0, '', '', 0, '', 0, 0),
(3, 7, 'Marinduque', 'Mogpog', 'Capayang', 'Tokyo', 'rented', 500, '2025-12-04 13:59:02', '2025-12-04 05:59:02', 0, '', '', 0, '', 0, 0),
(4, 8, 'Marinduque', 'Mogpog', 'Laon', 'Tokyo', 'rented', 50, '2025-12-04 14:09:30', '2025-12-04 06:09:30', 0, '', '', 0, '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `farm_resources`
--

CREATE TABLE `farm_resources` (
  `id` int(11) NOT NULL,
  `user_id` int(10) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `type` varchar(255) NOT NULL,
  `cost` int(10) NOT NULL,
  `date` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farm_resources`
--

INSERT INTO `farm_resources` (`id`, `user_id`, `item_name`, `type`, `cost`, `date`, `created_at`, `modified_at`) VALUES
(1, 2, 'Sitaw Seed', 'seeds', 50000, '2025-12-04', '2025-12-04 12:01:43', '2025-12-04 04:01:43'),
(2, 6, 'Abono', 'fertilizer', 5000, '2025-12-04', '2025-12-04 13:25:56', '2025-12-04 05:25:56'),
(3, 7, 'Sitaw', 'fertilizer', 5000, '2025-12-04', '2025-12-04 14:00:02', '2025-12-04 06:00:02'),
(4, 2, 'Fertilizer', 'machine', 600, '2025-12-04', '2025-12-04 15:08:04', '2025-12-04 07:08:04');

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
(1, 2, 'Kalabasa', 94, 'KG', 'Vegetable', '1000', '', 400, 0, '3a923d600b2ee6969d7b4ccf7f5de0553367890e-kalabasa.jpg', '2025-12-03 07:20:00', '2025-12-03 15:19:54', 'Posted', 200, 25000, 2),
(2, 6, 'Kalabasa', 13, 'KG', 'Vegetable', '50', '', 600, 0, '3a923d600b2ee6969d7b4ccf7f5de0553367890e-kalabasa.jpg', '2025-12-04 05:32:23', '2025-12-04 13:32:06', 'Posted', 200, 5000, 3),
(3, 7, 'Kalabasa', 3, 'KG', 'Vegetable', '50', '', 3000, 0, '3a923d600b2ee6969d7b4ccf7f5de0553367890e-kalabasa.jpg', '2025-12-04 06:03:17', '2025-12-04 14:03:03', 'Posted', 200, 5000, 15),
(4, 2, 'Garlic', 38, 'KG', 'Vegetable', '50', 'fresh from the farm', 200, 0, 'fcaf0705798b041a593261cc6345ed601ff186e1-Screenshot 2025-11-26 101756.png', '2025-12-04 07:09:53', '2025-12-04 15:09:46', 'Posted', 200, 5000, 1);

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
  `review_status` int(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `product_id`, `invoice_number`, `customer_id`, `mode_of_payment`, `quantity`, `status`, `created_at`, `modified_at`, `farmer_id`, `product_type`, `review_status`) VALUES
(18, 2, 'INV-69314B43397AE', 3, '', 25, 'order placed', '2025-12-04 16:50:11', '2025-12-04 08:50:11', 6, 'unknown', 0);

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
(1, 'maemagante31@gmail.com', '745cf314fd00b536b5bbc1ce3c3bb5ebbb64e4c1296c4434236ee8ddd4447490', '2025-12-04 13:22:49');

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
(2, 3, 'mango', 50, 6, 'fruit', '', 0, 'Reserve fresh farm produce ahead of time and get it delivered at peak quality.', 0, 150, '3a923d600b2ee6969d7b4ccf7f5de0553367890e-kalabasa.jpg', 0, '2025-12-04 05:31:24', '2025-12-04 13:31:24', 'Active', 'preorder', 150, NULL),
(3, 2, 'Kalabasa', 13, 6, 'Vegetable', 'KG', 0, '', 50, 600, '3a923d600b2ee6969d7b4ccf7f5de0553367890e-kalabasa.jpg', 60, '2025-12-04 05:32:23', '2025-12-04 13:32:23', 'Active', 'harvest', 540, NULL),
(4, 4, 'Kalabasa', 50, 7, 'vegetable', '', 0, 'Reserve fresh farm produce ahead of time and get it delivered at peak quality.', 0, 150, '3a923d600b2ee6969d7b4ccf7f5de0553367890e-kalabasa.jpg', 0, '2025-12-04 06:02:20', '2025-12-04 14:02:20', 'Active', 'preorder', 150, NULL),
(5, 3, 'Kalabasa', 3, 7, 'Vegetable', 'KG', 0, '', 50, 3000, '3a923d600b2ee6969d7b4ccf7f5de0553367890e-kalabasa.jpg', 0, '2025-12-04 06:03:17', '2025-12-04 14:03:17', 'Active', 'harvest', 3000, NULL),
(6, 5, 'Kalabasa', 30, 8, 'vegetable', '', 0, 'Reserve fresh farm produce ahead of time and get it delivered at peak quality.', 0, 250, '3a923d600b2ee6969d7b4ccf7f5de0553367890e-kalabasa.jpg', 30, '2025-12-04 06:10:30', '2025-12-04 14:10:30', 'Active', 'preorder', 220, NULL),
(7, 4, 'Garlic', 38, 2, 'Vegetable', 'KG', 0, 'fresh from the farm', 50, 200, 'fcaf0705798b041a593261cc6345ed601ff186e1-Screenshot 2025-11-26 101756.png', 0, '2025-12-04 07:09:53', '2025-12-04 15:09:53', 'Active', 'harvest', 200, NULL);

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
  `user_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
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
(2, 'sheila', 'laurente', 'sheilalaurente@gmail.com', '09772639814', '', '', '', '', 'Farmer', '$2y$10$zVa3Mv1ZCjRSfzvdyjwn3ODyZLKamvSSnpHqq0Vx61IpLoiracxdK', 0, '2025-12-03 15:16:47', 0, '2025-12-03 15:16:47', '1', '', 1, ''),
(3, 'AlexisJaye', 'Dumale', 'alexisdumale@gmail.com', '09533307696', 'Not Set', 'Anapog-Sibucao', 'Mogpog', 'Marinduque', 'consumer', '$2y$10$jRw7qe2KXC14h75qYPV1Au5kzUoTio1NVEt2062dQWm0kBfNiorI2', 0, '2025-12-04 11:50:13', 0, '2025-12-04 15:07:23', '0', '', 1, '42873b27277a8aae75c8c33017560c7755b2f41a0aea1de5ba9b5de8a201ef3a'),
(5, 'Jessieca', 'Sadiwa', 'jessiecasadiwa123@gmail.com', '09123456789', '', '', '', '', 'consumer', '$2y$10$MiKfU22BPO/sMuF.ewcZee7smlJHHivjZIiEAmhCI/Ed3B8lHfMMi', 0, '2025-12-04 13:13:01', 0, '2025-12-04 13:13:01', '0', '', 1, '84140bc6e1a907171153b17e7926ae36194319ba3436cad77322688656520b40'),
(6, 'Jerlyn Mae', 'Magante', 'maemagante31@gmail.com', '09656606247', '', '', '', '', 'Farmer', '$2y$10$W4qKhnASsw3jLN9GnG0Jfe3t4RyCHKfUjflxDWGwupJ5ab/Fn8zGq', 0, '2025-12-04 13:23:06', 0, '2025-12-04 13:23:06', '1', '', 1, '2e714f3fbe3f077c9d97783bd1f5b5b42990875323dc7369e4d9e9f492b565d1'),
(7, 'Jhune Rey', 'Cepida', 'jhunreycepida@gmail.com', '09703801573', '', '', '', '', 'Farmer', '$2y$10$b5n.Uy0Tm306AyQa4ZIk5eWgLP4TPvRlhYsHVGN8Gw3heJ7APlH7y', 0, '2025-12-04 13:57:28', 0, '2025-12-04 13:57:28', '1', '', 1, '9fb58710809905569758addcdc2db8c51c3b716bd93931828693eedd02c436fe'),
(8, 'sheila', 'laurente', 'laurentesheila1097@gmail.com', '09354958075', '', '', '', '', 'consumer', '$2y$10$.RSQtVRfBDPXryYovyIz/.wiBFbV9xBj8kcQZq1hdMr3KSOMhcj8i', 0, '2025-12-04 14:06:06', 0, '2025-12-04 14:06:06', '1', '', 1, '7e1ada8801d1bb39c758306e49557ca6542b296f2d085b3ca7e3ecbe02a25e18');

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
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crops`
--
ALTER TABLE `crops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `farm_resources`
--
ALTER TABLE `farm_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `harvested_products`
--
ALTER TABLE `harvested_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `order_status_history`
--
ALTER TABLE `order_status_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
