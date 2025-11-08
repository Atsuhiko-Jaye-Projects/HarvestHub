-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2025 at 06:22 AM
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
  `modified` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `product_id`, `user_id`, `quantity`, `created`, `amount`, `status`, `modified`) VALUES
(22, 89, 3, 10, '2025-11-07 23:37:06', 60, 'Ordered', '2025-11-07 15:37:43');

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
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crops`
--

INSERT INTO `crops` (`id`, `user_id`, `crop_name`, `yield`, `cultivated_area`, `date_planted`, `estimated_harvest_date`, `suggested_price`, `modified_at`, `created_at`) VALUES
(32, 2, 'Strawberry', 1, 50, '2025-11-08', '2026-01-16', 0, '2025-11-07 18:42:05', '2025-11-08 02:42:05');

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
  `used_lot_size` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farm_details`
--

INSERT INTO `farm_details` (`id`, `user_id`, `municipality`, `baranggay`, `purok`, `farm_ownership`, `created_at`, `modified_at`, `lot_size`, `used_lot_size`) VALUES
(26, 20, 'Mogpog', 'Anapog-Sibucao', 'Purok 2', 'owned', '2025-10-27 23:56:09', '2025-10-27 15:56:09', 5000, 0);

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
(11, 2, 'Kubota', 'machine', 5000, '2025-11-08', '2025-11-08 02:24:46', '2025-11-07 18:24:46');

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
(87, 2, 'Tomatoes/Kamatis', 0, 'KG', 'Vegetable', '1000', 'Fresh Farm Tomatoes\r\nHandpicked from local farms in Mogpog, these vibrant red tomatoes are juicy, flavorful, and packed with natural sweetness. Perfect for salads, sauces, and everyday cooking. Enjoy farm-fresh quality straight from the source.', 0, 0, 'e329d7f3bccba3a5b668150707ac422c58655116-tomato.jpg', '2025-11-07 14:55:56', '2025-11-07 22:51:07', 'Posted'),
(88, 2, 'Okra', 0, 'KG', 'Vegetable', '1000', 'Fresh Farm Okra\r\nCrisp, tender, and freshly harvested from local farms in Mogpog. Our okra is perfect for stews, sinigang, pinakbet, or frying. Enjoy the taste of fresh produce grown with care and delivered straight from the farm to your table.', 0, 0, '5e2c7a9d3e7c0110d4f7f9349f4f6743c4419dd2-okra.jpg', '2025-11-07 14:55:54', '2025-11-07 22:51:38', 'Posted'),
(89, 2, 'Kangkong', 0, 'KG', 'Vegetable', '1000', 'Fresh Native Kangkong\r\nLocally grown and freshly harvested, our kangkong is crisp, vibrant, and perfect for sinigang, adobo, or stir-fried dishes. Delivered straight from Mogpog farms to your kitchen for that farm-fresh goodness.', 0, 0, 'b6a48d68350a9324abb08733845caad15ffbd27a-kangkong.jpg', '2025-11-07 14:55:52', '2025-11-07 22:53:53', 'Posted'),
(90, 2, 'Egg Plant', 0, 'KG', 'Vegetable', '1000', 'Fresh Native Eggplant (Talong)\r\nHandpicked from local farms, our eggplants are firm, shiny, and full of flavor — perfect for tortang talong, pinakbet, or grilled dishes. Delivered fresh straight from the farm to your table.', 0, 0, '74e6f0f1275cc642225f1c94937cb77e6a46e3f2-eggplant.jpg', '2025-11-07 14:55:51', '2025-11-07 22:54:48', 'Posted'),
(91, 2, 'Kalabasa', 0, 'KG', 'Vegetable', '1000', 'Fresh Native Kalabasa (Squash)\r\nHarvested from local farms, our kalabasa is naturally sweet and rich in flavor — perfect for ginataang kalabasa, soups, or stir-fried dishes. Packed with nutrients and freshness straight from the field.', 0, 0, '976d0884a7b2312d9c460490f6459da9aa3990f3-squash.jpg', '2025-11-07 18:24:32', '2025-11-07 22:55:42', 'Posted'),
(92, 2, 'Sitaw', 0, 'KG', 'Vegetable', '1000', 'great', 0, 0, 'b6a48d68350a9324abb08733845caad15ffbd27a-kangkong.jpg', '2025-11-07 18:55:05', '2025-11-08 02:55:05', 'Pending'),
(93, 2, 'Sitaw', 0, 'KG', 'Vegetable', '100', 'sadsadsa', 0, 0, 'e329d7f3bccba3a5b668150707ac422c58655116-tomato.jpg', '2025-11-07 19:09:57', '2025-11-08 02:56:29', 'Pending');

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
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `product_id`, `invoice_number`, `customer_id`, `mode_of_payment`, `quantity`, `status`, `created_at`, `modified_at`) VALUES
(39, 89, 'INV-690E1247B93D5', 3, 'COD', 20, 'Order Placed', '2025-11-07 23:37:43', '2025-11-07 15:37:43');

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
(45, 91, 'Kalabasa', 43, 2, 'Vegetable', 'KG', 0, 'Fresh Native Kalabasa (Squash)\r\nHarvested from local farms, our kalabasa is naturally sweet and rich in flavor — perfect for ginataang kalabasa, soups, or stir-fried dishes. Packed with nutrients and freshness straight from the field.', 1000, 0, '976d0884a7b2312d9c460490f6459da9aa3990f3-squash.jpg', 0, '2025-11-07 14:55:46', '2025-11-07 22:55:46', 'Active'),
(46, 90, 'Egg Plant', 90, 2, 'Vegetable', 'KG', 0, 'Fresh Native Eggplant (Talong)\r\nHandpicked from local farms, our eggplants are firm, shiny, and full of flavor — perfect for tortang talong, pinakbet, or grilled dishes. Delivered fresh straight from the farm to your table.', 1000, 0, '74e6f0f1275cc642225f1c94937cb77e6a46e3f2-eggplant.jpg', 0, '2025-11-07 14:55:51', '2025-11-07 22:55:51', 'Active'),
(47, 89, 'Kangkong', 60, 2, 'Vegetable', 'KG', 0, 'Fresh Native Kangkong\r\nLocally grown and freshly harvested, our kangkong is crisp, vibrant, and perfect for sinigang, adobo, or stir-fried dishes. Delivered straight from Mogpog farms to your kitchen for that farm-fresh goodness.', 1000, 0, 'b6a48d68350a9324abb08733845caad15ffbd27a-kangkong.jpg', 0, '2025-11-07 14:55:52', '2025-11-07 22:55:52', 'Active'),
(48, 88, 'Okra', 80, 2, 'Vegetable', 'KG', 0, 'Fresh Farm Okra\r\nCrisp, tender, and freshly harvested from local farms in Mogpog. Our okra is perfect for stews, sinigang, pinakbet, or frying. Enjoy the taste of fresh produce grown with care and delivered straight from the farm to your table.', 1000, 0, '5e2c7a9d3e7c0110d4f7f9349f4f6743c4419dd2-okra.jpg', 0, '2025-11-07 14:55:54', '2025-11-07 22:55:54', 'Active'),
(49, 87, 'Tomatoes/Kamatis', 100, 2, 'Vegetable', 'KG', 0, 'Fresh Farm Tomatoes\r\nHandpicked from local farms in Mogpog, these vibrant red tomatoes are juicy, flavorful, and packed with natural sweetness. Perfect for salads, sauces, and everyday cooking. Enjoy farm-fresh quality straight from the source.', 1000, 0, 'e329d7f3bccba3a5b668150707ac422c58655116-tomato.jpg', 0, '2025-11-07 14:55:56', '2025-11-07 22:55:56', 'Active'),
(50, 91, 'Kalabasa', 0, 2, 'Vegetable', 'KG', 0, 'Fresh Native Kalabasa (Squash)\r\nHarvested from local farms, our kalabasa is naturally sweet and rich in flavor — perfect for ginataang kalabasa, soups, or stir-fried dishes. Packed with nutrients and freshness straight from the field.', 1000, 0, '976d0884a7b2312d9c460490f6459da9aa3990f3-squash.jpg', 0, '2025-11-07 18:24:32', '2025-11-08 02:24:32', 'Active');

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
  `farm_details_exists` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `baranggay`, `address`, `user_type`, `email_address`, `contact_number`, `password`, `rating`, `created`, `modified`, `first_time_logged_in`, `farm_details_exists`) VALUES
(2, 'Farmer', 'Richard', 'boac', '', 'Farmer', 'farmer@farm.com', '09533307696', '$2a$12$3/rLxv7G3eZUpBll/80TVeEYO8/N4HyynnxGph57KHrOHvDtyxlcS', 0, '2025-03-10 05:49:38', '2025-03-10 05:49:38', 0, '1'),
(3, 'Customer', 'Dave', '', '', 'Consumer', 'consumer@consume.com', '', '$2y$10$OP.c25h2BF404wKs2jM4JOKXnVhVvgeSIWx2BHhzbO6kSA/DC/NeO', 0, '2025-08-13 18:07:34', '2025-08-13 18:07:34', 0, '0');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crops`
--
ALTER TABLE `crops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `farm_resources`
--
ALTER TABLE `farm_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `harvested_products`
--
ALTER TABLE `harvested_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
