-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2026 at 04:43 PM
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
(3, 'dasuni', 'dasuni@gamil.com', '6985651323', 'support', 'sdvsvds', '2026-02-28 13:54:03');

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
  `image_url` varchar(500) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT 4.5,
  `reviews` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `old_price`, `description`, `image_url`, `rating`, `reviews`, `created_at`) VALUES
(1, 'Rose Bouquet', 'flowers', 3500.00, 4500.00, 'Beautiful red rose bouquet perfect for any occasion.', 'https://images.unsplash.com/photo-1561181286-d3fee65d69e8?w=400', 4.5, 24, '2026-02-28 11:30:38'),
(2, 'Tulip Bouquet', 'flowers', 2800.00, NULL, 'Colorful tulip bouquet to brighten someone\'s day.', 'https://images.unsplash.com/photo-1591248431733-2f9f2b3b9b3a?w=400', 5.0, 18, '2026-02-28 11:30:38'),
(3, 'Lily Bouquet', 'flowers', 3200.00, NULL, 'Elegant white lily bouquet for special moments.', 'https://images.unsplash.com/photo-1563241527-3004b7be0ffd?w=400', 4.5, 12, '2026-02-28 11:30:38'),
(4, 'Sunflower Bouquet', 'flowers', 2500.00, NULL, 'Bright sunflower bouquet to bring sunshine.', 'https://images.unsplash.com/photo-1589123053646-4e8c4c8f4b9a?w=400', 5.0, 36, '2026-02-28 11:30:38'),
(5, 'Orchid Bouquet', 'flowers', 5500.00, 6500.00, 'Exotic orchid bouquet for luxury gifting.', 'https://images.unsplash.com/photo-1561136594-7f68413f212b?w=400', 5.0, 42, '2026-02-28 11:30:38'),
(6, 'Lavender Bouquet', 'flowers', 3800.00, NULL, 'Fragrant lavender bouquet for relaxation.', 'https://images.unsplash.com/photo-1582798358481-d199fb7347bb?w=400', 4.5, 28, '2026-02-28 11:30:38'),
(7, 'Luxury Gift Box', 'gifts', 5000.00, NULL, 'Premium gift box with assorted surprises.', 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?w=400', 5.0, 45, '2026-02-28 11:30:38'),
(8, 'Gourmet Chocolates', 'gifts', 2200.00, 3000.00, 'Delicious gourmet chocolate collection.', 'https://images.unsplash.com/photo-1513201099705-a9746e1e201f?w=400', 4.5, 28, '2026-02-28 11:30:38'),
(9, 'Soft Teddy Bear', 'gifts', 1800.00, NULL, 'Cuddly teddy bear for your loved ones.', 'https://images.unsplash.com/photo-1607344645866-009c320b63e0?w=400', 5.0, 52, '2026-02-28 11:30:38'),
(10, 'Scented Candle Set', 'gifts', 1500.00, NULL, 'Aromatic candle set for home fragrance.', 'https://images.unsplash.com/photo-1513885535751-8b9238bd345a?w=400', 4.5, 31, '2026-02-28 11:30:38'),
(11, 'Personalized Mug', 'gifts', 1200.00, NULL, 'Custom mug with your personal message.', 'https://images.unsplash.com/photo-1514228742587-6b1558fcca3d?w=400', 5.0, 67, '2026-02-28 11:30:38'),
(12, 'Elegant Photo Frame', 'gifts', 2500.00, NULL, 'Beautiful frame for precious memories.', 'https://images.unsplash.com/photo-1545996124-0501ebae84b0?w=400', 4.5, 23, '2026-02-28 11:30:38'),
(13, 'Mixed Flower Bouquet', 'sale', 3200.00, 4000.00, 'Colorful mixed flower arrangement.', 'https://images.unsplash.com/photo-1582794543462-0d7922e50cf5?w=400', 5.0, 64, '2026-02-28 11:30:38'),
(14, 'Flower & Gift Combo', 'sale', 5500.00, 6500.00, 'Perfect combo of flowers and gifts.', 'https://images.unsplash.com/photo-1519378058457-4c29a0a2efac?w=400', 5.0, 42, '2026-02-28 11:30:38'),
(15, 'Valentine\'s Special', 'sale', 4500.00, 6000.00, 'Romantic Valentine\'s Day special.', 'https://images.unsplash.com/photo-1518199266791-5375a83190b7?w=400', 5.0, 89, '2026-02-28 11:30:38'),
(16, 'Birthday Bundle', 'sale', 3800.00, 4200.00, 'Complete birthday celebration package.', 'https://images.unsplash.com/photo-1530103862676-de8c9debad1d?w=400', 4.5, 56, '2026-02-28 11:30:38'),
(17, 'Rose Bouquet', 'flowers', 3500.00, 4500.00, 'Beautiful red rose bouquet perfect for any occasion.', 'https://images.unsplash.com/photo-1561181286-d3fee65d69e8?w=400', 4.5, 24, '2026-02-28 13:30:28'),
(18, 'Tulip Bouquet', 'flowers', 2800.00, NULL, 'Colorful tulip bouquet to brighten someones day.', 'https://images.unsplash.com/photo-1591248431733-2f9f2b3b9b3a?w=400', 5.0, 18, '2026-02-28 13:30:28'),
(19, 'Lily Bouquet', 'flowers', 3200.00, NULL, 'Elegant white lily bouquet for special moments.', 'https://images.unsplash.com/photo-1563241527-3004b7be0ffd?w=400', 4.5, 12, '2026-02-28 13:30:28'),
(20, 'Sunflower Bouquet', 'flowers', 2500.00, NULL, 'Bright sunflower bouquet to bring sunshine.', 'https://images.unsplash.com/photo-1589123053646-4e8c4c8f4b9a?w=400', 5.0, 36, '2026-02-28 13:30:28'),
(21, 'Orchid Bouquet', 'flowers', 5500.00, 6500.00, 'Exotic orchid bouquet for luxury gifting.', 'https://images.unsplash.com/photo-1561136594-7f68413f212b?w=400', 5.0, 42, '2026-02-28 13:30:28'),
(22, 'Lavender Bouquet', 'flowers', 3800.00, NULL, 'Fragrant lavender bouquet for relaxation.', 'https://images.unsplash.com/photo-1582798358481-d199fb7347bb?w=400', 4.5, 28, '2026-02-28 13:30:28'),
(23, 'Luxury Gift Box', 'gifts', 5000.00, NULL, 'Premium gift box with assorted surprises.', 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?w=400', 5.0, 45, '2026-02-28 13:30:28'),
(24, 'Gourmet Chocolates', 'gifts', 2200.00, 3000.00, 'Delicious gourmet chocolate collection.', 'https://images.unsplash.com/photo-1513201099705-a9746e1e201f?w=400', 4.5, 28, '2026-02-28 13:30:28'),
(25, 'Soft Teddy Bear', 'gifts', 1800.00, NULL, 'Cuddly teddy bear for your loved ones.', 'https://images.unsplash.com/photo-1607344645866-009c320b63e0?w=400', 5.0, 52, '2026-02-28 13:30:28'),
(26, 'Scented Candle Set', 'gifts', 1500.00, NULL, 'Aromatic candle set for home fragrance.', 'https://images.unsplash.com/photo-1513885535751-8b9238bd345a?w=400', 4.5, 31, '2026-02-28 13:30:28'),
(34, 'Gourmet Chocolates', 'gifts', 2200.00, 3000.00, 'Delicious gourmet chocolate collection.', 'https://images.unsplash.com/photo-1513201099705-a9746e1e201f?w=400', 4.5, 28, '2026-02-28 13:32:02'),
(51, 'Orchid Bouquet', 'flowers', 5500.00, 6500.00, 'Exotic orchid bouquet for luxury gifting.', 'https://images.unsplash.com/photo-1561136594-7f68413f212b?w=400', 5.0, 42, '2026-02-28 13:33:50'),
(52, 'Lavender Bouquet', 'flowers', 3800.00, NULL, 'Fragrant lavender bouquet for relaxation.', 'https://images.unsplash.com/photo-1582798358481-d199fb7347bb?w=400', 4.5, 28, '2026-02-28 13:33:50'),
(53, 'Luxury Gift Box', 'gifts', 5000.00, NULL, 'Premium gift box with assorted surprises.', 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?w=400', 5.0, 45, '2026-02-28 13:33:50'),
(54, 'Gourmet Chocolates', 'gifts', 2200.00, 3000.00, 'Delicious gourmet chocolate collection.', 'https://images.unsplash.com/photo-1513201099705-a9746e1e201f?w=400', 4.5, 28, '2026-02-28 13:33:50'),
(55, 'Soft Teddy Bear', 'gifts', 1800.00, NULL, 'Cuddly teddy bear for your loved ones.', 'https://images.unsplash.com/photo-1607344645866-009c320b63e0?w=400', 5.0, 52, '2026-02-28 13:33:50'),
(56, 'Scented Candle Set', 'gifts', 1500.00, NULL, 'Aromatic candle set for home fragrance.', 'https://images.unsplash.com/photo-1513885535751-8b9238bd345a?w=400', 4.5, 31, '2026-02-28 13:33:50'),
(57, 'Rose Bouquet', 'flowers', 3500.00, 4500.00, 'Beautiful red rose bouquet perfect for any occasion.', 'https://images.unsplash.com/photo-1561181286-d3fee65d69e8?w=400', 4.5, 24, '2026-02-28 13:35:25'),
(58, 'Tulip Bouquet', 'flowers', 2800.00, NULL, 'Colorful tulip bouquet to brighten someones day.', 'https://images.unsplash.com/photo-1591248431733-2f9f2b3b9b3a?w=400', 5.0, 18, '2026-02-28 13:35:25'),
(59, 'Lily Bouquet', 'flowers', 3200.00, NULL, 'Elegant white lily bouquet for special moments.', 'https://images.unsplash.com/photo-1563241527-3004b7be0ffd?w=400', 4.5, 12, '2026-02-28 13:35:25'),
(60, 'Sunflower Bouquet', 'flowers', 2500.00, NULL, 'Bright sunflower bouquet to bring sunshine.', 'https://images.unsplash.com/photo-1589123053646-4e8c4c8f4b9a?w=400', 5.0, 36, '2026-02-28 13:35:25'),
(61, 'Orchid Bouquet', 'flowers', 5500.00, 6500.00, 'Exotic orchid bouquet for luxury gifting.', 'https://images.unsplash.com/photo-1561136594-7f68413f212b?w=400', 5.0, 42, '2026-02-28 13:35:25'),
(62, 'Lavender Bouquet', 'flowers', 3800.00, NULL, 'Fragrant lavender bouquet for relaxation.', 'https://images.unsplash.com/photo-1582798358481-d199fb7347bb?w=400', 4.5, 28, '2026-02-28 13:35:25'),
(63, 'Luxury Gift Box', 'gifts', 5000.00, NULL, 'Premium gift box with assorted surprises.', 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?w=400', 5.0, 45, '2026-02-28 13:35:25'),
(64, 'Gourmet Chocolates', 'gifts', 2200.00, 3000.00, 'Delicious gourmet chocolate collection.', 'https://images.unsplash.com/photo-1513201099705-a9746e1e201f?w=400', 4.5, 28, '2026-02-28 13:35:25'),
(65, 'Soft Teddy Bear', 'gifts', 1800.00, NULL, 'Cuddly teddy bear for your loved ones.', 'https://images.unsplash.com/photo-1607344645866-009c320b63e0?w=400', 5.0, 52, '2026-02-28 13:35:25'),
(66, 'Scented Candle Set', 'gifts', 1500.00, NULL, 'Aromatic candle set for home fragrance.', 'https://images.unsplash.com/photo-1513885535751-8b9238bd345a?w=400', 4.5, 31, '2026-02-28 13:35:25'),
(67, 'Rose Bouquet', 'flowers', 3500.00, 4500.00, 'Beautiful red rose bouquet perfect for any occasion.', 'https://images.unsplash.com/photo-1561181286-d3fee65d69e8?w=400', 4.5, 24, '2026-02-28 13:35:27'),
(68, 'Tulip Bouquet', 'flowers', 2800.00, NULL, 'Colorful tulip bouquet to brighten someones day.', 'https://images.unsplash.com/photo-1591248431733-2f9f2b3b9b3a?w=400', 5.0, 18, '2026-02-28 13:35:27'),
(69, 'Lily Bouquet', 'flowers', 3200.00, NULL, 'Elegant white lily bouquet for special moments.', 'https://images.unsplash.com/photo-1563241527-3004b7be0ffd?w=400', 4.5, 12, '2026-02-28 13:35:27'),
(70, 'Sunflower Bouquet', 'flowers', 2500.00, NULL, 'Bright sunflower bouquet to bring sunshine.', 'https://images.unsplash.com/photo-1589123053646-4e8c4c8f4b9a?w=400', 5.0, 36, '2026-02-28 13:35:27'),
(71, 'Orchid Bouquet', 'flowers', 5500.00, 6500.00, 'Exotic orchid bouquet for luxury gifting.', 'https://images.unsplash.com/photo-1561136594-7f68413f212b?w=400', 5.0, 42, '2026-02-28 13:35:27'),
(72, 'Lavender Bouquet', 'flowers', 3800.00, NULL, 'Fragrant lavender bouquet for relaxation.', 'https://images.unsplash.com/photo-1582798358481-d199fb7347bb?w=400', 4.5, 28, '2026-02-28 13:35:27'),
(73, 'Luxury Gift Box', 'gifts', 5000.00, NULL, 'Premium gift box with assorted surprises.', 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?w=400', 5.0, 45, '2026-02-28 13:35:27'),
(74, 'Gourmet Chocolates', 'gifts', 2200.00, 3000.00, 'Delicious gourmet chocolate collection.', 'https://images.unsplash.com/photo-1513201099705-a9746e1e201f?w=400', 4.5, 28, '2026-02-28 13:35:27'),
(75, 'Soft Teddy Bear', 'gifts', 1800.00, NULL, 'Cuddly teddy bear for your loved ones.', 'https://images.unsplash.com/photo-1607344645866-009c320b63e0?w=400', 5.0, 52, '2026-02-28 13:35:27'),
(76, 'Scented Candle Set', 'gifts', 1500.00, NULL, 'Aromatic candle set for home fragrance.', 'https://images.unsplash.com/photo-1513885535751-8b9238bd345a?w=400', 4.5, 31, '2026-02-28 13:35:27'),
(80, 'Sunflower Bouquet', 'flowers', 2500.00, NULL, 'Bright sunflower bouquet to bring sunshine.', 'https://images.unsplash.com/photo-1589123053646-4e8c4c8f4b9a?w=400', 5.0, 36, '2026-02-28 13:38:01'),
(81, 'Orchid Bouquet', 'flowers', 5500.00, 6500.00, 'Exotic orchid bouquet for luxury gifting.', 'https://images.unsplash.com/photo-1561136594-7f68413f212b?w=400', 5.0, 42, '2026-02-28 13:38:01'),
(82, 'Lavender Bouquet', 'flowers', 3800.00, NULL, 'Fragrant lavender bouquet for relaxation.', 'https://images.unsplash.com/photo-1582798358481-d199fb7347bb?w=400', 4.5, 28, '2026-02-28 13:38:01'),
(83, 'Luxury Gift Box', 'gifts', 5000.00, NULL, 'Premium gift box with assorted surprises.', 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?w=400', 5.0, 45, '2026-02-28 13:38:01'),
(84, 'Gourmet Chocolates', 'gifts', 2200.00, 3000.00, 'Delicious gourmet chocolate collection.', 'https://images.unsplash.com/photo-1513201099705-a9746e1e201f?w=400', 4.5, 28, '2026-02-28 13:38:01'),
(85, 'Soft Teddy Bear', 'gifts', 1800.00, NULL, 'Cuddly teddy bear for your loved ones.', 'https://images.unsplash.com/photo-1607344645866-009c320b63e0?w=400', 5.0, 52, '2026-02-28 13:38:01'),
(86, 'Scented Candle Set', 'gifts', 1500.00, NULL, 'Aromatic candle set for home fragrance.', 'https://images.unsplash.com/photo-1513885535751-8b9238bd345a?w=400', 4.5, 31, '2026-02-28 13:38:01');

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
(6, 'Admin', 'admin@gify.com', '$2y$10$/nv7CWFrdxB6FinLDAN3ju8QcqC1lcxYE.Z2Kks/CUYogmvqu2zZ.', '2026-02-28 14:11:17', 1),
(7, 'Dasuni', 'Dasuni@Gify.Com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-02-28 14:26:06', 1),
(8, 'Tharindu', 'Tharindu@Gify.Com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-02-28 14:26:42', 1),
(9, 'Dasun', 'Dasun@Gify.Com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-02-28 14:28:35', 1),
(10, 'Anne', 'Anne@Gify.Com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-02-28 14:28:35', 1),
(11, 'Sanjula', 'Sanjula@Gify.Com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-02-28 14:28:35', 1),
(12, 'Sadasi', 'Sadasi@Gify.Com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-02-28 14:28:35', 1),
(13, 'Tharindu', 'tmtroshana@students.nsbm.ac.lk', '$2y$10$zjRyT6B.6ZB25BFvb2ZeAe5NJB1lZpaLCS.1R32Cm5ay.80WR0rXq', '2026-02-28 14:38:51', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
