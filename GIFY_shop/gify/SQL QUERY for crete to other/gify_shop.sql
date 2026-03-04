-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2026 at 02:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gify_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address_line` varchar(255) NOT NULL,
  `building_name` varchar(100) DEFAULT NULL,
  `faculty` varchar(100) NOT NULL,
  `is_default` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `address_line`, `building_name`, `faculty`, `is_default`, `created_at`) VALUES
(1, 6, 'b1-101', 'c2', 'Faculty of Computing', 1, '2026-03-03 07:21:23'),
(2, 15, 'l1-101', 'b1', 'Faculty of Computing', 1, '2026-03-03 07:24:27'),
(3, 16, 'l1-101', 'c1', 'Faculty of Computing', 1, '2026-03-04 11:32:49');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `phone`, `subject`, `message`, `created_at`) VALUES
(1, 'Tharindu Roshana', 'tahrindu@gamil.com', '6985651323', 'sales', 'sfgbs', '2026-02-28 12:54:51'),
(2, 'Tharindu Roshana', 'tmtroshana@students.nsbm.ac.lk', '0720464563', 'sales', 'testing 1', '2026-02-28 13:53:40'),
(3, 'dasuni', 'dasuni@gamil.com', '6985651323', 'support', 'sdvsvds', '2026-02-28 13:54:03'),
(4, 'now', 'now@gmail.com', '7865454', 'partnership', 'bhjvhghk', '2026-03-01 06:31:38'),
(5, 'last check', 'last@gamil.com', '0000000000', 'partnership', 'last check', '2026-03-04 11:16:30');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` enum('card','cash') NOT NULL,
  `delivery_address` text NOT NULL,
  `status` enum('pending','processing','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `faculty` varchar(100) NOT NULL DEFAULT 'Not Specified',
  `delivery_option` varchar(50) NOT NULL DEFAULT 'standard',
  `special_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_number`, `total_amount`, `payment_method`, `delivery_address`, `status`, `created_at`, `faculty`, `delivery_option`, `special_notes`) VALUES
(1, 6, 'ORD-20260303-69A68C0A3C786', 7300.00, 'cash', 'c2, b1-101', 'cancelled', '2026-03-03 07:21:46', 'Faculty of Computing', 'express', 'hi'),
(2, 15, 'ORD-20260303-69A68CBB2013A', 9400.00, 'cash', 'b1, l1-101', 'pending', '2026-03-03 07:24:43', 'Faculty of Computing', 'express', 'qer'),
(3, 6, 'ORD-20260303-69A695E63FB50', 14000.00, 'card', 'c2, b1-101', 'completed', '2026-03-03 08:03:50', 'Faculty of Computing', 'standard', 'sdfs'),
(4, 6, 'ORD-20260303-69A6ACDE65374', 26000.00, 'cash', 'c2, b1-101', 'pending', '2026-03-03 09:41:50', 'Library', 'scheduled', 'Scheduled for 11th march at 11 a\'clock'),
(5, 16, 'ORD-20260304-69A8187571D0B', 19800.00, 'cash', 'c1, l1-101', 'completed', '2026-03-04 11:33:09', 'Faculty of Computing', 'express', 'last check');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `price`, `quantity`) VALUES
(1, 1, 2, 'Tulip Bouquet', 2800.00, 1),
(2, 1, 15, 'Valentine Special', 4500.00, 1),
(3, 2, 6, 'Lavender Bouquet', 3800.00, 1),
(4, 2, 9, 'Soft Teddy Bear', 1800.00, 1),
(5, 3, 2, 'Tulip Bouquet', 2800.00, 1),
(6, 4, 3, 'Lily Bouquet', 3200.00, 1),
(7, 4, 14, 'Flower & Gift Combo', 5500.00, 1),
(8, 4, 15, 'Valentine\'s Special', 4500.00, 1),
(9, 4, 16, 'Birthday Bundle', 3800.00, 1),
(10, 5, 1, 'Rose Bouquet', 3700.00, 1),
(11, 5, 4, 'Sunflower Bouquet', 2500.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `category` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) NOT NULL DEFAULT 'https://via.placeholder.com/300',
  `rating` decimal(2,1) DEFAULT 4.5,
  `reviews` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `old_price`, `description`, `image_url`, `rating`, `reviews`, `created_at`) VALUES
(1, 'Rose Bouquet', 'flowers', 3700.00, 4500.00, 'Beautiful red rose bouquet perfect for any occasion.', 'rose.jpeg', 4.5, 24, '2026-02-28 11:30:38'),
(2, 'Tulip Bouquet', 'flowers', 2800.00, NULL, 'Colorful tulip bouquet to brighten someone\'s day.', 'Tulip.jpeg', 5.0, 18, '2026-02-28 11:30:38'),
(3, 'Lily Bouquet', 'flowers', 3200.00, NULL, 'Elegant white lily bouquet for special moments.', 'lily.jpeg', 4.5, 12, '2026-02-28 11:30:38'),
(4, 'Sunflower Bouquet', 'flowers', 2500.00, NULL, 'Bright sunflower bouquet to bring sunshine.', 'sunfl.jpeg', 5.0, 36, '2026-02-28 11:30:38'),
(5, 'Orchid Bouquet', 'flowers', 5500.00, 6500.00, 'Exotic orchid bouquet for luxury gifting.', 'Orchid.jpeg', 5.0, 42, '2026-02-28 11:30:38'),
(6, 'Lavender Bouquet', 'flowers', 3800.00, NULL, 'Fragrant lavender bouquet for relaxation.', 'lavender.jpeg', 4.5, 28, '2026-02-28 11:30:38'),
(7, 'Luxury Gift Box', 'gifts', 5000.00, NULL, 'Premium gift box with assorted surprises.', 'lux.jpeg', 5.0, 45, '2026-02-28 11:30:38'),
(8, 'Gourmet Chocolates', 'gifts', 2200.00, 3000.00, 'Delicious gourmet chocolate collection.', 'gourmet_choco.jpeg', 4.5, 28, '2026-02-28 11:30:38'),
(9, 'Soft Teddy Bear', 'gifts', 1800.00, NULL, 'Cuddly teddy bear for your loved ones.', 'soft_tedy.jpeg', 5.0, 52, '2026-02-28 11:30:38'),
(10, 'Scented Candle Set', 'gifts', 1500.00, NULL, 'Aromatic candle set for home fragrance.', 'Candle.jpeg', 4.5, 31, '2026-02-28 11:30:38'),
(11, 'Personalized Mug', 'gifts', 1200.00, NULL, 'Custom mug with your personal message.', 'mug.jpeg', 5.0, 67, '2026-02-28 11:30:38'),
(12, 'Elegant Photo Frame', 'gifts', 2500.00, NULL, 'Beautiful frame for precious memories.', 'elegant_frame.jpeg', 4.5, 23, '2026-02-28 11:30:38'),
(13, 'Mixed Flower Bouquet', 'sale', 3200.00, 4000.00, 'Colorful mixed flower arrangement.', 'MIx.jpeg', 5.0, 64, '2026-02-28 11:30:38'),
(14, 'Flower & Gift Combo', 'sale', 5500.00, 6500.00, 'Perfect combo of flowers and gifts.', 'combo.jpeg', 5.0, 42, '2026-02-28 11:30:38'),
(15, 'Valentine\'s Special', 'sale', 4500.00, 6000.00, 'Romantic Valentine\'s Day special.', 'valentines.jpeg', 5.0, 89, '2026-02-28 11:30:38'),
(16, 'Birthday Bundle', 'sale', 3800.00, 4200.00, 'Complete birthday celebration package.', 'BD.jpeg', 4.5, 56, '2026-02-28 11:30:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_admin` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `created_at`, `is_admin`) VALUES
(6, 'Admin', 'admin@gify.com', '$2y$10$YGnIQOutt/0gAsUEhRHZ8O/AkyPmDB1sR9Im45HvEHvcgsTSOLF0K', '2026-02-28 14:11:17', 1),
(7, 'Dasuni', 'Dasuni@Gify.Com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-02-28 14:26:06', 1),
(8, 'Tharindu', 'Tharindu@Gify.Com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-02-28 14:26:42', 1),
(9, 'Dasun', 'Dasun@Gify.Com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-02-28 14:28:35', 1),
(10, 'Anne', 'Anne@Gify.Com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-02-28 14:28:35', 1),
(11, 'Sanjula', 'Sanjula@Gify.Com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-02-28 14:28:35', 1),
(12, 'Sadasi', 'Sadasi@Gify.Com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-02-28 14:28:35', 1),
(13, 'Tharindu', 'tmtroshana@students.nsbm.ac.lk', '$2y$10$zjRyT6B.6ZB25BFvb2ZeAe5NJB1lZpaLCS.1R32Cm5ay.80WR0rXq', '2026-02-28 14:38:51', 0),
(14, 'Dasun', 'kakkibarai@nsbm.ac.lk', '$2y$10$cb4oWSXOOLS.XTVj5iEcv.AO.7HxMWA8S4ihO2cOo9d7m5mJeyujC', '2026-03-03 06:52:31', 0),
(15, 'anne', 'anne@nsbm.ac.lk', '$2y$10$QLNgUmpZdcx54NtGJNtiMedU4a0N74hYRtWFxpVlqxTKCHyVZyacq', '2026-03-03 07:22:52', 0),
(16, 'last', 'last@students.nsbm.ac.lk', '$2y$10$zxaEVq/rYeZxN.rOU8eaneQ/Uci4EqA5caO2fXukktTsI7pT7J3o.', '2026-03-04 11:31:02', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
