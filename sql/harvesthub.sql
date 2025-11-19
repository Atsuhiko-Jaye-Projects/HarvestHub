-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2025 at 02:28 PM
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
  `farmer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `product_id`, `user_id`, `quantity`, `created`, `amount`, `status`, `modified`, `farmer_id`) VALUES
(35, 108, 21, 5, '2025-11-16 12:19:38', 38, 'Ordered', '2025-11-16 04:19:43', 2),
(36, 90, 21, 15, '2025-11-16 12:55:33', 90, 'Ordered', '2025-11-16 04:55:40', 2),
(37, 88, 23, 10, '2025-11-18 08:57:23', 80, 'Pending', '2025-11-18 00:57:23', 2),
(38, 91, 21, 5, '2025-11-18 09:20:50', 43, 'Pending', '2025-11-18 01:20:50', 2);

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
(47, 2, 'mango', 15, 512, '2025-11-19', '2026-04-18', 0, '2025-11-19 12:05:33', '2025-11-19 20:04:31', 930, 62);

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
(27, 22, 'Mogpog', 'mogpog', 'Purok 2', '', '2025-11-18 09:53:03', '2025-11-18 01:53:03', 5000, 0, '', '');

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
(16, 2, 'asdasd', 'machine', 50002, '2025-11-10', '2025-11-10 19:04:33', '2025-11-10 11:04:33');

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
  `is_posted` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `harvested_products`
--

INSERT INTO `harvested_products` (`id`, `user_id`, `product_name`, `price_per_unit`, `unit`, `category`, `lot_size`, `product_description`, `total_stocks`, `quantity`, `product_image`, `modified`, `created_at`, `is_posted`) VALUES
(105, 2, 'Kamatis', 29, 'KG', 'Vegetable', '1000', '', 0, 0, '36fc1f203d6ed26741703fab7790adcbda4abc03-sss number.jpg', '2025-11-15 14:06:05', '2025-11-15 22:06:05', 'Pending'),
(106, 2, 'Sitaw', 38, 'KG', 'Vegetable', '1000', '', 0, 0, 'f400ddc95293fa115b74463f002ea790964a9ec0-cics logo.png', '2025-11-15 14:10:52', '2025-11-15 22:10:52', 'Pending'),
(107, 2, 'kalabasa', 25, 'KG', 'Vegetable', '1000', '', 0, 0, 'f400ddc95293fa115b74463f002ea790964a9ec0-cics logo.png', '2025-11-15 14:49:41', '2025-11-15 22:49:41', 'Pending'),
(108, 2, 'patatas', 38, 'KG', 'Vegetable', '500', 'asdsad', 0, 0, '19f8582993b0eb48f7d2056cb04f6a0c54d96376-1.jpg', '2025-11-16 02:18:10', '2025-11-15 23:05:00', 'Posted'),
(109, 2, 'New Patatas', 63, 'KG', 'Vegetable', '1000', '', 1, 0, '976d0884a7b2312d9c460490f6459da9aa3990f3-squash.jpg', '2025-11-19 12:24:54', '2025-11-18 19:17:34', 'Posted'),
(110, 2, 'Sitaw', 78, 'KG', 'Vegetable', '1000', 'great', 2200, 0, '22b5e0083bf9b56d876756682c4a60946b5e2741-3.jpg', '2025-11-19 12:33:01', '2025-11-18 19:21:07', 'Pending'),
(111, 2, 'new breed kamatis', 36, 'KG', 'Vegetable', '1000', 'new updates', 4800, 0, 'a36850033c95d1912a366a36403a1c428a1a5a75-b811bd39-815d-4dcb-a7cf-75518f84e0c0.jpg', '2025-11-19 12:32:53', '2025-11-18 19:22:14', 'Pending');

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
  `farmer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `product_id`, `invoice_number`, `customer_id`, `mode_of_payment`, `quantity`, `status`, `created_at`, `modified_at`, `farmer_id`) VALUES
(43, 108, 'INV-691950DF42E3F', 21, 'COD', 5, 'order placed', '2025-11-16 12:19:43', '2025-11-16 04:19:43', 2),
(44, 90, 'INV-6919594C9AC8E', 21, 'COD', 15, 'complete', '2025-11-16 12:55:40', '2025-11-16 04:55:40', 2);

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
  `status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_id`, `product_name`, `price_per_unit`, `user_id`, `category`, `unit`, `quantity`, `product_description`, `lot_size`, `total_stocks`, `product_image`, `sold_count`, `modified`, `created_at`, `status`) VALUES
(52, 110, 'Sitaw', 78, 2, 'Vegetable', 'KG', 0, '', 1000, 480, '22b5e0083bf9b56d876756682c4a60946b5e2741-3.jpg', 26, '2025-11-18 11:24:05', '2025-11-18 19:24:05', 'Active'),
(57, 111, 'new breed kamatis', 36, 2, 'Vegetable', 'KG', 0, 'new updates', 1000, 4800, 'a36850033c95d1912a366a36403a1c428a1a5a75-b811bd39-815d-4dcb-a7cf-75518f84e0c0.jpg', 526, '2025-11-18 12:08:16', '2025-11-18 20:08:16', 'Active'),
(58, 109, 'New Patatas', 63, 2, 'Vegetable', 'KG', 0, '', 1000, 500, '976d0884a7b2312d9c460490f6459da9aa3990f3-squash.jpg', 126, '2025-11-19 12:24:54', '2025-11-19 20:24:54', 'Active');

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
(22, 'Juan', 'Dela Cruz', 'juandelacruz@gmail.com', '09324435144', '', '', '', '', 'Farmer', '$2y$10$EUjqB4lviFzVdvhPaXKTtOpf9ehHs9oMYOTkz8jRl4VRBwLhfG2xO', 0, '2025-11-18 08:55:46', 0, '2025-11-18 08:55:46', '0', ''),
(23, 'jessieca', 'sadiwa', 'jessiecasadiwa@gmail.com', '', '', '', '', '', 'consumer', '$2y$10$PyTxYxaqthK2SMn4fLFmSOpMiPvPeihnLiQtC4vv2A5uqM6zIj6Ua', 0, '2025-11-18 08:56:59', 0, '2025-11-18 08:56:59', '0', ''),
(24, 'jessieca', 'sadiwa', 'jessiecasadiwa23@gmail.com', '', '', '', '', '', 'consumer', '$2y$10$VPy1fnc0bFK865B7YmVBxeE0ZAk4sxLbSCtJFjdf9.tdbvX0DUAoa', 0, '2025-11-18 09:20:16', 0, '2025-11-18 09:20:16', '0', ''),
(25, 'asdasd', 'asdasd', 'ajcodalify@gmail.com', '', '', '', '', '', 'consumer', '$2y$10$YFeDEzSSeKqdYwVYPHzc/OHtthSLxfn5IbFQfew334CClyLlc6KGu', 0, '2025-11-19 08:51:22', 0, '2025-11-19 08:51:22', '0', '');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crops`
--
ALTER TABLE `crops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `farm_resources`
--
ALTER TABLE `farm_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `harvested_products`
--
ALTER TABLE `harvested_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
