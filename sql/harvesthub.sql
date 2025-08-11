-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 11, 2025 at 05:52 AM
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
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `farm_products`
--

CREATE TABLE `farm_products` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_name` varchar(250) NOT NULL,
  `date_planted` varchar(250) NOT NULL,
  `estimated_harvest_date` varchar(255) NOT NULL,
  `yield` int(11) NOT NULL,
  `suggested_price` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farm_products`
--

INSERT INTO `farm_products` (`id`, `user_id`, `product_name`, `date_planted`, `estimated_harvest_date`, `yield`, `suggested_price`, `created_at`, `modified_at`) VALUES
(1, 2, 'Sitaw', '2025-08-05', '2025-08-23', 5, 24, '2025-08-08 18:51:31', '2025-08-08 10:51:31'),
(2, 2, 'Sitaw', '2025-08-05', '2025-08-23', 5, 24, '2025-08-08 18:51:34', '2025-08-08 10:51:34'),
(3, 2, 'Sitaw', '2025-08-05', '2025-08-23', 5, 24, '2025-08-08 18:51:51', '2025-08-08 10:51:51'),
(4, 2, 'Sitaw', '2025-08-05', '2025-08-23', 5, 24, '2025-08-08 18:52:12', '2025-08-08 10:52:12'),
(5, 2, 'Sitaw', '2025-08-05', '2025-08-23', 5, 24, '2025-08-08 18:52:30', '2025-08-08 10:52:30'),
(6, 2, 'Sitaw', '2025-08-05', '2025-08-23', 5, 24, '2025-08-08 18:52:39', '2025-08-08 10:52:39'),
(7, 2, 'Sitaw', '2025-08-05', '2025-08-23', 5, 24, '2025-08-08 18:52:55', '2025-08-08 10:52:55'),
(8, 2, 'Sitaw', '2025-08-05', '2025-08-23', 5, 24, '2025-08-08 18:53:06', '2025-08-08 10:53:06'),
(9, 2, 'Sitaw', '2025-08-05', '2025-08-23', 5, 24, '2025-08-08 18:53:12', '2025-08-08 10:53:12'),
(10, 2, 'Sitaw', '2025-08-05', '2025-08-23', 5, 24, '2025-08-08 18:53:13', '2025-08-08 10:53:13'),
(11, 2, 'Sitaw', '2025-08-05', '2025-08-23', 5, 24, '2025-08-08 18:53:46', '2025-08-08 10:53:46');

-- --------------------------------------------------------

--
-- Table structure for table `farm_resources`
--

CREATE TABLE `farm_resources` (
  `id` int(11) NOT NULL,
  `user_id` int(10) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `cost` int(10) NOT NULL,
  `date` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farm_resources`
--

INSERT INTO `farm_resources` (`id`, `user_id`, `item_name`, `cost`, `date`, `created_at`, `modified_at`, `type`) VALUES
(1, 2, 'Kubota', 5000, '2025-08-05', '2025-08-08 18:10:02', '2025-08-08 10:10:02', ''),
(2, 2, 'Kubota', 5000, '2025-08-05', '2025-08-08 18:10:30', '2025-08-08 10:10:30', ''),
(3, 2, 'Kubota', 5000, '2025-08-06', '2025-08-08 18:14:20', '2025-08-08 10:14:20', ''),
(4, 2, 'Kubota', 5000, '2025-08-13', '2025-08-08 18:15:21', '2025-08-08 10:15:21', ''),
(5, 2, 'Kubota', 5000, '2025-08-13', '2025-08-08 18:15:58', '2025-08-08 10:15:58', 'Machine');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `contact_number` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `total_price` int(11) NOT NULL,
  `mode_of_payment` varchar(100) NOT NULL,
  `lot_size` int(11) NOT NULL,
  `order_date` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `customer_id`, `order_id`, `contact_number`, `address`, `total_price`, `mode_of_payment`, `lot_size`, `order_date`, `status`, `created_at`, `modified_at`) VALUES
(1, 2, 2, 'hvsth12312455', '09533307696', 'mogpo', 5000, 'COD', 10, '10-11-25 ', 'pending', '2025-08-10 18:18:21', '2025-08-10 10:18:21');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(250) NOT NULL,
  `price_per_unit` int(20) NOT NULL,
  `category` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_description` varchar(300) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `unit` varchar(20) NOT NULL,
  `total_stocks` int(50) NOT NULL,
  `lot_size` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `price_per_unit`, `category`, `user_id`, `quantity`, `product_image`, `product_description`, `created_at`, `modified`, `unit`, `total_stocks`, `lot_size`) VALUES
(12, 'Sitaw', 20, 'Vegetable', 2, 0, '28b90ed444694a47cfe87a27c67a4e279c538f1b-qweqweqw.png', 'Great', '2025-08-07 15:45:45', '2025-08-07 07:45:45', 'kilos', 0, '20'),
(13, 'kangkong', 20, 'Vegetable', 2, 0, '28b90ed444694a47cfe87a27c67a4e279c538f1b-123123.png', 'great', '2025-08-07 15:47:16', '2025-08-07 07:47:16', 'ton', 0, '20'),
(14, 'Sitaw', 20, 'Vegetable', 2, 0, '28b90ed444694a47cfe87a27c67a4e279c538f1b-qweqwewq.png', 'great', '2025-08-07 16:55:34', '2025-08-07 08:55:34', 'kilos', 0, '20'),
(15, 'Sitaw', 20, 'Vegetable', 2, 0, '28b90ed444694a47cfe87a27c67a4e279c538f1b-qweqwewq.png', 'great', '2025-08-07 16:55:46', '2025-08-07 08:55:46', 'kilos', 0, '20'),
(16, 'Sitaw', 20, 'Vegetable', 2, 0, '28b90ed444694a47cfe87a27c67a4e279c538f1b-qweqwewq.png', 'great', '2025-08-08 13:33:56', '2025-08-08 05:33:56', 'kilos', 0, '20');

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
  `baranggay` varchar(150) NOT NULL,
  `address` varchar(150) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rating` int(10) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp(),
  `first_time_logged_in` int(11) NOT NULL,
  `farm_details_exists` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `baranggay`, `address`, `user_type`, `email_address`, `contact_number`, `password`, `rating`, `created`, `modified`, `first_time_logged_in`, `farm_details_exists`) VALUES
(2, 'evelyn', 'gascon', 'boac', '', 'Farmer', '', '09533307696', '', 0, '2025-03-10 05:49:38', '2025-03-10 05:49:38', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `farm_details`
--
ALTER TABLE `farm_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `farm_products`
--
ALTER TABLE `farm_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `farm_resources`
--
ALTER TABLE `farm_resources`
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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `farm_details`
--
ALTER TABLE `farm_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `farm_products`
--
ALTER TABLE `farm_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `farm_resources`
--
ALTER TABLE `farm_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
