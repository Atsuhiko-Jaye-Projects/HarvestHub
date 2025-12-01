-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2025 at 03:09 AM
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

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `user_id`, `message`, `created_at`) VALUES
(1, 2, 'hey', '2025-11-30 04:36:42'),
(2, 1, 'hey', '2025-11-30 04:47:41'),
(3, 1, 'wassup', '2025-11-30 04:48:08'),
(4, 1, 'im good', '2025-11-30 04:48:15'),
(5, 1, 'hey', '2025-11-30 05:01:01'),
(6, 1, 'sup', '2025-11-30 05:01:10'),
(7, 1, 'how you doing', '2025-11-30 05:01:24'),
(8, 1, 'im good', '2025-11-30 05:01:31'),
(9, 1, 'lets g', '2025-11-30 05:01:41'),
(10, 1, 'hey', '2025-11-30 05:02:00'),
(11, 1, 'what?', '2025-11-30 05:02:06');

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
(57, 30, 'okra', 2, 500, '2025-11-29', '2026-01-29', 0, '2025-11-29 13:22:18', '2025-11-29 21:22:18', 652, 326, 'Marinduque', 'Mogpog', 'Anapog-Sibucao');

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
(42, 28, 'Marinduque', 'Mogpog', 'Anapog-Sibucao', 'purok2', 'owned', 5000, '2025-11-29 18:24:59', '2025-11-29 10:24:59', 0, 'Mondragon Farm and Pigery', '', 1230, '', 0, 47),
(43, 30, 'Marinduque', 'Mogpog', 'Anapog-Sibucao', 'Purok2', 'owned', 5000, '2025-11-29 19:55:29', '2025-11-29 11:55:29', 0, '', '', 0, '', 0, 0),
(44, 28, 'Marinduque', 'Boac', 'Agot', 'purok', 'owned', 5000, '2025-11-29 21:25:01', '2025-11-29 13:25:01', 0, '', '', 0, '', 0, 0);

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
(31, 30, 'Kubota', 'machine', 5000, '2025-10-23', '2025-11-08 00:39:15', '2025-11-30 06:08:20'),
(32, 30, 'kubota', 'machine', 5000, '2025-10-22', '2025-11-30 14:16:17', '2025-11-30 06:18:55'),
(33, 30, 'talong', 'seeds', 500, '2025-11-30', '2025-11-30 14:17:00', '2025-11-30 06:17:00');

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
(1, 28, 'Kalabasa', 16, 'KG', 'Vegetable', '1000', 'Fresh from the farm', 2400, 0, '976d0884a7b2312d9c460490f6459da9aa3990f3-squash.jpg', '2025-11-29 03:56:36', '2025-11-29 11:56:28', 'Posted', 1200, 25000, 2),
(2, 30, 'talong', 188, 'KG', 'Vegetable', '1000', 'greate', 400, 0, '74e6f0f1275cc642225f1c94937cb77e6a46e3f2-eggplant.jpg', '2025-11-29 16:02:15', '2025-11-29 22:20:55', 'Pending', 200, 50000, 2),
(3, 30, 'Sitaw', 188, 'KG', 'Vegetable', '50', 'great', 400, 0, '5e2c7a9d3e7c0110d4f7f9349f4f6743c4419dd2-okra.jpg', '2025-11-30 05:03:52', '2025-11-30 13:03:52', 'Pending', 200, 50000, 2);

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
(1, 1, 'Kalabasa', 16, 28, 'Vegetable', 'KG', 0, 'Fresh from the farm', 1000, 2400, '976d0884a7b2312d9c460490f6459da9aa3990f3-squash.jpg', 20, '2025-11-29 03:56:36', '2025-11-29 11:56:36', 'Active', 'harvest', 2400, NULL),
(2, 51, 'okra', 23, 28, 'vegetable', '', 0, 'Reserve fresh farm produce ahead of time and get it delivered at peak quality.', 0, 1000, '5e2c7a9d3e7c0110d4f7f9349f4f6743c4419dd2-okra.jpg', 0, '2025-11-29 03:57:47', '2025-11-29 11:57:47', 'Active', 'preorder', 1000, NULL);

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

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `customer_id`, `rate`, `review_text`, `reply`, `created_at`, `modified_at`, `product_rating`, `farmer_rating`, `performance_review`, `product_quality_review`, `farmer_response`) VALUES
(1, 1, 2, 29, 2, 'ganda ng sitaw', '', '2025-08-10 18:52:43', '2025-08-10 10:52:43', 1.55, 0, 'So Fresh from the farm', 'BEST Product', 'Thansk for your support'),
(2, 1, 2, 31, 3, 'ganda ng siopao', '', '2025-08-10 18:52:43', '2025-08-10 10:52:43', 3, 0, 'Will buy again', 'Good', ''),
(3, 1, 2, 29, 2, 'ganda ng sitaw', '', '2025-08-10 18:52:43', '2025-08-10 10:52:43', 4, 0, 'So Fresh from the farm', 'BEST Product', 'Thansk for your support'),
(4, 1, 2, 31, 3, 'ganda ng siopao', '', '2025-08-10 18:52:43', '2025-08-10 10:52:43', 3, 0, 'Will buy again', 'Good', ''),
(5, 1, 2, 29, 2, 'ganda ng sitaw', '', '2025-08-10 18:52:43', '2025-08-10 10:52:43', 4, 0, 'So Fresh from the farm', 'BEST Product', 'Thansk for your support'),
(6, 1, 2, 31, 3, 'ganda ng siopao', '', '2025-08-10 18:52:43', '2025-08-10 10:52:43', 3, 0, 'Will buy again', 'Good', ''),
(7, 1, 2, 29, 2, 'ganda ng sitaw', '', '2025-08-10 18:52:43', '2025-08-10 10:52:43', 4, 0, 'So Fresh from the farm', 'BEST Product', 'Thansk for your support'),
(8, 1, 2, 31, 3, 'ganda ng siopao', '', '2025-08-10 18:52:43', '2025-08-10 10:52:43', 3, 0, 'Will buy again', 'Good', '');

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
(28, 'carlo', 'Dela Cruz', 'carlo@gmail.com', '09707662820', '', '', '', '', 'Farmer', '$2y$10$ADz3Kr95s1Q6gwNVDAwOc.qATpx6r8R2pRY.r.k9/v9JU/xRmueVW', 0, '2025-11-27 20:26:08', 0, '2025-11-27 20:26:08', '1', ''),
(29, 'James', 'Dela Cruz', 'james123@gmail.com', '09999635031', '', '', '', '', 'consumer', '$2y$10$xpyxvB224SWe.eX9BmSvyOdwA9gJWuBSt.3ed3j2z5LcPDJj2mHwe', 0, '2025-11-29 12:13:29', 0, '2025-11-29 12:13:29', '0', ''),
(30, 'sheila', 'laurente', 'sheilalaurente@gmail.com', '09123545848', '', '', '', '', 'Farmer', '$2y$10$mhcvgaqYOhFjwQKCLbBJ/uSQXRcSxk2HBXwWbYy4WMmVeSC2pnG5S', 0, '2025-11-29 12:15:55', 0, '2025-11-29 12:15:55', '1', ''),
(31, 'Sheila', 'deleon', 'james321@gmail.com', '09999963979', '', '', '', '', 'consumer', '$2y$10$tWynlH6uZApytP.44NVyWOCo4tBaWYecIrwdKFRdl5StWuV50RyfG', 0, '2025-11-29 12:24:56', 0, '2025-11-29 12:24:56', '0', '');

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
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `crops`
--
ALTER TABLE `crops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `farm_resources`
--
ALTER TABLE `farm_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `harvested_products`
--
ALTER TABLE `harvested_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
