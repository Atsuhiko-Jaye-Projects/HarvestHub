-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2025 at 03:01 AM
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
(1, 2, 'talong', '2025-08-05', '2025-08-23', 5, 24, '2025-08-08 18:51:31', '2025-08-14 14:15:34'),
(2, 2, 'Sitaw', '2025-08-05', '2025-08-23', 5, 24, '2025-08-08 18:51:34', '2025-08-08 10:51:34'),
(3, 2, 'asdasdas', '2025-08-05', '2025-08-23', 5, 24, '2025-08-08 18:51:51', '2025-08-08 10:51:51'),
(4, 2, 'Sitaw', '2025-08-05', '2025-08-23', 5, 24, '2025-08-08 18:52:12', '2025-08-08 10:52:12'),
(5, 2, 'Sitaw', '2025-08-05', '2025-08-23', 5, 24, '2025-08-08 18:52:30', '2025-08-08 10:52:30'),
(6, 2, 'Sitaw', '2025-08-05', '2025-08-23', 5, 24, '2025-08-08 18:52:39', '2025-08-08 10:52:39'),
(7, 2, 'Sitaw', '2025-08-05', '2025-08-23', 5, 24, '2025-08-08 18:52:55', '2025-08-08 10:52:55'),
(8, 2, 'Sitaw', '2025-08-05', '2025-08-23', 5, 24, '2025-08-08 18:53:06', '2025-08-08 10:53:06'),
(9, 2, 'Sitaw', '2025-08-05', '2025-08-23', 5, 24, '2025-08-08 18:53:12', '2025-08-08 10:53:12'),
(10, 2, 'Sitaw', '2025-08-05', '2025-08-23', 5, 24, '2025-08-08 18:53:13', '2025-08-08 10:53:13'),
(11, 2, 'Sitaw', '2025-08-05', '2025-08-23', 5, 24, '2025-08-08 18:53:46', '2025-08-08 10:53:46'),
(12, 2, 'talong', '', '', 0, 0, '2025-08-14 20:30:50', '2025-08-14 12:30:50'),
(13, 2, 'talong', '2025-08-07', '2025-08-16', 20, 23, '2025-08-14 21:36:54', '2025-08-14 13:36:54');

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
(5, 2, 'Kubota', 5000, '2025-08-13', '2025-08-08 18:15:58', '2025-08-08 10:15:58', 'Machine'),
(6, 2, 'Kubota', 5000, '2025-08-13', '2025-08-08 18:15:58', '2025-08-08 10:15:58', 'Machine');

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
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `harvested_products`
--

INSERT INTO `harvested_products` (`id`, `user_id`, `product_name`, `price_per_unit`, `unit`, `category`, `lot_size`, `product_description`, `total_stocks`, `quantity`, `product_image`, `modified`, `created_at`) VALUES
(12, 2, 'Sitaws kong updated', 20, 'kilos', 'Vegetable', '20', 'Great ubasadsdas', 0, 0, '28b90ed444694a47cfe87a27c67a4e279c538f1b-qweqweqw.png', '2025-08-16 05:37:44', '2025-08-07 15:45:45'),
(13, 2, 'kangkong', 20, 'ton', 'Vegetable', '20', 'great', 0, 0, '28b90ed444694a47cfe87a27c67a4e279c538f1b-123123.png', '2025-08-07 07:47:16', '2025-08-07 15:47:16'),
(14, 2, 'Sitaw', 20, 'kilos', 'Vegetable', '20', 'great', 0, 0, '28b90ed444694a47cfe87a27c67a4e279c538f1b-qweqwewq.png', '2025-08-07 08:55:34', '2025-08-07 16:55:34'),
(15, 2, 'Sitaw', 20, 'kilos', 'Vegetable', '20', 'great', 0, 0, '28b90ed444694a47cfe87a27c67a4e279c538f1b-qweqwewq.png', '2025-08-07 08:55:46', '2025-08-07 16:55:46'),
(16, 2, 'Sitaw', 20, 'kilos', 'Vegetable', '20', 'great', 0, 0, '28b90ed444694a47cfe87a27c67a4e279c538f1b-qweqwewq.png', '2025-08-08 05:33:56', '2025-08-08 13:33:56'),
(17, 2, 'Sitaw', 20, 'kilos', 'Vegetable', '20', 'great', 0, 0, '28b90ed444694a47cfe87a27c67a4e279c538f1b-qweqwewq.png', '2025-08-08 05:33:56', '2025-08-08 13:33:56'),
(18, 2, 'okra', 20, 'kilos', 'Meat', '20', 'great', 0, 0, '77c91bfb612d7cef7fdfc8d348dca4cf03cdaad6-530662302_753126267471399_8058883301672027554_n.jpg', '2025-08-18 10:29:12', '2025-08-18 18:29:12'),
(19, 2, 'okra', 20, 'kilos', 'Meat', '20', 'great', 0, 0, '77c91bfb612d7cef7fdfc8d348dca4cf03cdaad6-530662302_753126267471399_8058883301672027554_n.jpg', '2025-08-18 10:29:21', '2025-08-18 18:29:21');

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
  `per_price_unit` int(20) NOT NULL,
  `category` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_description` varchar(500) NOT NULL,
  `lot_size` int(20) NOT NULL,
  `total_stocks` int(20) NOT NULL,
  `product_image` varchar(500) NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
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
(2, 'evelyn', 'gascon', 'boac', '', 'Farmer', 'ajcodalify@gmail.com', '09533307696', '$2a$12$3/rLxv7G3eZUpBll/80TVeEYO8/N4HyynnxGph57KHrOHvDtyxlcS', 0, '2025-03-10 05:49:38', '2025-03-10 05:49:38', 0, 1),
(3, 'Alexis Jaye', 'Dumale', '', '', 'consumer', 'alexisdumale@gmail.com', '', '$2y$10$OP.c25h2BF404wKs2jM4JOKXnVhVvgeSIWx2BHhzbO6kSA/DC/NeO', 0, '2025-08-13 18:07:34', '2025-08-13 18:07:34', 0, 0),
(4, 'Alexis Jaye', 'Dumale', '', '', 'consumer', 'alexisdumale@gmail.com', '', '$2y$10$XmqzVQBLn9q5bxVV57zET.mEeT315FVASiS0LDu5AR6vhZlQ4HyOG', 0, '2025-08-13 18:08:13', '2025-08-13 18:08:13', 0, 0),
(5, 'Alexis Jaye', 'Dumale', '', '', 'consumer', 'alexisdumale@gmail.com', '', '$2y$10$5zTcSJTFI7AFAtV2eSA.7OxFnHPtIHG5//6CQshvHSGU.AvbwTYpy', 0, '2025-08-13 18:09:11', '2025-08-13 18:09:11', 0, 0),
(6, 'Alexis Jaye', 'Dumale', '', '', 'consumer', 'alexisdumale@gmail.com', '', '$2y$10$JRsNg2UleLgdev9KsecryumpVddKjQ5LWbEWn22TWmJonpxKqQah.', 0, '2025-08-13 18:11:39', '2025-08-13 18:11:39', 0, 0),
(7, 'asdasd', 'asdasd', '', '', 'seller', 'ajcodalify@gmail.com', '', '$2y$10$W4xFaAakW0eHv1NVDhpUwe2US.3hQhsePK20Mf80ycNmQswDgi/Y.', 0, '2025-08-16 17:43:43', '2025-08-16 17:43:43', 0, 0),
(8, 'asdasd', 'asdasd', '', '', 'seller', 'ajcodalify@gmail.com', '', '$2y$10$O/lmdAWOnDSdv7j0sdsgde7.vluRjcEN1gwS8ZUxJ0tksnBW45GG2', 0, '2025-08-16 17:44:22', '2025-08-16 17:44:22', 0, 0),
(9, 'asdasd', 'asdasd', '', '', 'seller', 'ajcodalify@gmail.com', '', '$2y$10$Nxu.XNqkBaZnBNatSgAinOeHOeCQ2Brd3sIfaodP4sAMrrpzSHr4m', 0, '2025-08-16 17:44:48', '2025-08-16 17:44:48', 0, 0),
(10, 'asdasd', 'asdasd', '', '', '', 'ajcodalify@gmail.com', '+639533307696', '$2y$10$1qmfSej/7rgQ1AkjUC6WdukKnF0kvU30kfkjHP9ApUW2GId1K6Z.S', 0, '2025-08-16 18:00:13', '2025-08-16 18:00:13', 0, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `farm_resources`
--
ALTER TABLE `farm_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `harvested_products`
--
ALTER TABLE `harvested_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
