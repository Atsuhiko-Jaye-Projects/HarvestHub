-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2025 at 05:29 PM
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
(65, 113, 21, 20, '2025-11-23 23:02:09', 31, 'ordered', '2025-11-27 12:23:52', 2, 'harvest'),
(66, 113, 23, 15, '2025-11-23 23:47:49', 31, 'ordered', '2025-11-27 12:23:52', 2, 'harvest'),
(67, 113, 27, 15, '2025-11-27 20:23:38', 59, 'ordered', '2025-11-27 12:23:52', 2, 'harvest'),
(68, 122, 27, 20, '2025-11-27 21:24:09', 3, 'ordered', '2025-11-27 15:34:46', 28, 'harvest'),
(69, 122, 21, 20, '2025-11-27 23:34:38', 3, 'ordered', '2025-11-27 15:34:46', 28, 'harvest');

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
  `plant_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crops`
--

INSERT INTO `crops` (`id`, `user_id`, `crop_name`, `yield`, `cultivated_area`, `date_planted`, `estimated_harvest_date`, `suggested_price`, `modified_at`, `created_at`, `stocks`, `plant_count`) VALUES
(46, 2, 'Strawberry', 2, 512, '2025-11-19', '2026-01-20', 0, '2025-11-19 12:03:41', '2025-11-19 20:03:41', 2472, 1236),
(47, 2, 'mango', 15, 512, '2025-11-19', '2026-04-18', 0, '2025-11-19 12:05:33', '2025-11-19 20:04:31', 930, 62),
(48, 2, 'Melon', 2, 500, '2025-11-22', '2026-03-28', 0, '2025-11-22 02:25:00', '2025-11-19 21:47:37', 2400, 1200),
(49, 2, 'guava', 2, 500, '2025-11-23', '2026-05-08', 0, '2025-11-23 05:46:35', '2025-11-23 13:46:35', 240, 120),
(50, 28, 'Kamote', 2, 523, '2025-11-27', '2026-01-31', 0, '2025-11-27 12:33:55', '2025-11-27 20:30:13', 2000, 1000);

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
  `municipality` varchar(250) NOT NULL,
  `baranggay` varchar(250) NOT NULL,
  `purok` varchar(255) NOT NULL,
  `farm_ownership` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `lot_size` int(11) NOT NULL,
  `used_lot_size` int(11) NOT NULL,
  `farm_name` varchar(255) NOT NULL,
  `farm_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farm_details`
--

INSERT INTO `farm_details` (`id`, `user_id`, `municipality`, `baranggay`, `purok`, `farm_ownership`, `created_at`, `modified_at`, `lot_size`, `used_lot_size`, `farm_name`, `farm_type`) VALUES
(26, 2, 'Mogpog', 'Anapog-Sibucao', 'Purok 2', 'owned', '2025-10-27 23:56:09', '2025-10-27 15:56:09', 5000, 0, '', 'Vegetable'),
(27, 22, 'Mogpog', 'mogpog', 'Purok 2', '', '2025-11-18 09:53:03', '2025-11-18 01:53:03', 5000, 0, '', ''),
(28, 26, 'Mogpog', 'mogpog', 'Purok 2', 'owned', '2025-11-24 10:24:02', '2025-11-24 02:24:02', 5000, 0, '', ''),
(29, 26, 'Boac', 'mogpog', 'Purok 2', 'rented', '2025-11-24 10:25:23', '2025-11-24 02:25:23', 5000, 0, '', ''),
(30, 28, 'Mogpog', 'bintakay', 'purok 3', 'owned', '2025-11-27 20:26:39', '2025-11-27 12:26:39', 50, 0, '', ''),
(31, 28, 'Mogpog', 'bintakay', 'purok 3', 'owned', '2025-11-27 20:27:52', '2025-11-27 12:27:52', 5000, 0, '', ''),
(32, 28, 'Mogpog', 'mogpog', 'Purok 2', 'rented', '2025-11-27 20:59:56', '2025-11-27 12:59:56', 50, 0, '', ''),
(33, 28, 'Mogpog', 'mogpog', 'Purok 2', '', '2025-11-27 21:04:04', '2025-11-27 13:04:04', 50, 0, '', ''),
(34, 28, 'Mogpog', 'mogpog', 'Purok 2', 'rented', '2025-11-27 21:16:00', '2025-11-27 13:16:00', 50, 0, '', ''),
(35, 28, 'Boac', 'mogpog', 'Purok 2', 'owned', '2025-11-27 21:16:40', '2025-11-27 13:16:40', 50, 0, '', ''),
(36, 28, 'Boac', 'mogpog', 'Purok 2', 'rented', '2025-11-27 21:20:42', '2025-11-27 13:20:42', 50, 0, '', ''),
(37, 28, 'Boac', 'mogpog', 'Purok 2', '', '2025-11-27 21:21:50', '2025-11-27 13:21:50', 5000, 0, '', '');

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
(8, 20, 'agri planters', 'Fertilizer', 114001, '2025-10-21', '2025-10-27 22:49:47', '2025-10-30 06:24:28'),
(9, 2, 'agri planters', 'machine', 5000, '2025-10-30', '2025-10-30 13:39:52', '2025-10-30 05:39:52'),
(10, 2, 'Kubota', 'machine', 5000, '2025-11-08', '2025-11-08 01:56:08', '2025-11-07 17:56:08'),
(11, 2, 'Kubota', 'machine', 5000, '2025-11-08', '2025-11-08 02:24:46', '2025-11-07 18:24:46'),
(12, 2, 'Kubota', 'machine', 5000, '2025-11-18', '2025-11-10 19:04:11', '2025-11-10 11:04:11'),
(13, 2, 'Kubota', 'machine', 5000, '2025-11-18', '2025-11-10 19:04:16', '2025-11-10 11:04:16'),
(14, 2, 'Kubota', 'machine', 5000, '2025-11-18', '2025-11-10 19:04:19', '2025-11-10 11:04:19'),
(15, 2, 'asdasd', 'machine', 50002, '2025-11-10', '2025-11-10 19:04:30', '2025-11-10 11:04:30'),
(16, 2, 'asdasd', 'machine', 50002, '2025-11-10', '2025-11-10 19:04:33', '2025-11-10 11:04:33'),
(17, 2, 'asdasd', 'machine', 600, '2025-11-23', '2025-11-23 13:45:37', '2025-11-23 05:45:37'),
(18, 28, 'Fertilizer', 'machine', 2300, '2025-11-27', '2025-11-27 20:29:29', '2025-11-27 12:29:29');

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
(119, 2, 'Sitaw', 19, 'KG', 'Vegetable', '5000', 'great', 400, 0, 'b93704e4c93e045194606c3c7b1d27c38f0544b5-nov 20.png', '2025-11-24 11:08:50', '2025-11-24 18:11:39', 'Pending', 200, 5000, 2),
(120, 2, 'kamote', 19, 'KG', 'Vegetable', '5000', '', 400, 0, 'b93704e4c93e045194606c3c7b1d27c38f0544b5-nov 20.png', '2025-11-24 11:09:26', '2025-11-24 19:09:26', 'Pending', 200, 5000, 2),
(121, 2, 'kalabasa', 94, 'KG', 'Vegetable', '5000', '', 800, 0, 'b93704e4c93e045194606c3c7b1d27c38f0544b5-nov 20.png', '2025-11-24 11:09:53', '2025-11-24 19:09:53', 'Pending', 200, 50000, 4),
(122, 28, 'Sitaw', 3, 'KG', 'Vegetable', '500', 'great', 2400, 0, '250a1561bac83ac86b2ae48565c04e7e060c2661-SweetPotato.jpg', '2025-11-27 12:52:09', '2025-11-27 20:52:02', 'Posted', 200, 5000, 12);

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
(75, 113, 'INV-69230AD969625', 22, 'COD', 15, 'accept', '2025-11-23 21:23:37', '2025-11-23 13:23:37', 2, 'harvest', 0),
(76, 113, 'INV-69230AD969624', 21, 'COD', 15, 'accept', '2025-11-23 21:23:37', '2025-11-08 13:23:37', 2, 'harvest', 0),
(77, 113, 'INV-69230AD969625', 22, 'COD', 15, 'accept', '2025-11-23 21:23:37', '2025-11-23 13:23:37', 2, 'harvest', 0),
(82, 113, 'INV-692321F5BFE01', 21, 'COD', 20, 'complete', '2025-11-23 23:02:13', '2025-11-23 15:02:13', 2, 'harvest', 0),
(83, 113, 'INV-69232CAA3228A', 23, 'COD', 15, 'complete', '2025-11-23 23:47:54', '2025-11-23 15:47:54', 2, 'harvest', 0),
(84, 113, 'INV-692842D8F2DB5', 27, 'COD', 12, 'order placed', '2025-11-27 20:23:52', '2025-11-27 12:23:52', 2, 'unknown', 0),
(85, 122, 'INV-6928510E96AF3', 27, 'COD', 20, 'complete', '2025-11-27 21:24:30', '2025-11-27 13:24:30', 28, 'unknown', 0),
(86, 122, 'INV-69286F96AC14E', 21, 'COD', 20, 'complete', '2025-11-27 23:34:46', '2025-11-27 15:34:46', 28, 'unknown', 0);

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
(69, 113, 'Kalabasa', 59, 2, 'Vegetable', 'KG', 0, 'fresh', 516, 2400, '976d0884a7b2312d9c460490f6459da9aa3990f3-squash.jpg', 0, '2025-11-24 04:18:27', '2025-11-24 12:18:27', 'Active', 'harvest', 2400, NULL),
(71, 50, 'Kamote', 38, 28, 'vegetable', '', 0, 'Reserve fresh farm produce ahead of time and get it delivered at peak quality.', 0, 2000, '250a1561bac83ac86b2ae48565c04e7e060c2661-SweetPotato.jpg', 0, '2025-11-27 12:42:53', '2025-11-27 20:42:53', 'Active', 'preorder', 2000, NULL),
(72, 122, 'Sitaw', 3, 28, 'Vegetable', 'KG', 0, 'great', 500, 2400, '250a1561bac83ac86b2ae48565c04e7e060c2661-SweetPotato.jpg', 60, '2025-11-27 12:52:09', '2025-11-27 20:52:09', 'Active', 'harvest', 2340, NULL);

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
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `customer_id`, `rate`, `review_text`, `reply`, `created_at`, `modified_at`) VALUES
(1, 12, 2, 1, 2, 'ganda ng sitaw', '', '2025-08-10 18:52:43', '2025-08-10 10:52:43'),
(2, 12, 2, 2, 3, 'ganda ng siopao', '', '2025-08-10 18:52:43', '2025-08-10 10:52:43');

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
  `profile_pic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email_address`, `contact_number`, `address`, `barangay`, `municipality`, `province`, `user_type`, `password`, `rating`, `created`, `first_time_logged_in`, `modified`, `farm_details_exists`, `profile_pic`) VALUES
(2, 'Richard updated', 'farmer', 'farmer@farm.com', '09772639814', 'Purok 2', 'Anapog-Sibucao', 'Anapog', 'Marinduque', 'Farmer', '$2a$12$3/rLxv7G3eZUpBll/80TVeEYO8/N4HyynnxGph57KHrOHvDtyxlcS', 0, '2025-03-10 05:49:38', 0, '2025-11-13 17:56:29', '1', 'b6a48d68350a9324abb08733845caad15ffbd27a-kangkong.jpg'),
(21, 'Alexis Jaye', 'Dumales', 'don@gmail.com', '09533307696', 'Anapog-Sibucao', 'Anapog', 'Mogpog', 'Marinduque', 'consumer', '$2y$10$wGotL4R6eNsz03aTF8hFLu2cWtfYNwsIRekLjJCU8LkbMiYpf0kDO', 0, '2025-11-08 18:42:11', 0, '2025-11-15 11:02:21', '0', 'f400ddc95293fa115b74463f002ea790964a9ec0-cics logo.png'),
(27, 'Juan', 'Dela Cruz', 'juandelacruz@gmail.com', '09533307696', 'purok 2', 'Anapog-Sibucao', 'Mogpog', 'Marinduque', 'consumer', '$2y$10$Wsx28p66./9jttxIfw.UP.rRIeB0UAnA6r2LS7NDT9GI4DlsTNZnm', 0, '2025-11-27 20:23:17', 0, '2025-11-27 20:24:57', '0', ''),
(28, 'carlo', 'Dela Cruz', 'carlo@gmail.com', '09707662820', '', '', '', '', 'Farmer', '$2y$10$ADz3Kr95s1Q6gwNVDAwOc.qATpx6r8R2pRY.r.k9/v9JU/xRmueVW', 0, '2025-11-27 20:26:08', 0, '2025-11-27 20:26:08', '1', '');

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crops`
--
ALTER TABLE `crops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `farm_resources`
--
ALTER TABLE `farm_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `harvested_products`
--
ALTER TABLE `harvested_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
