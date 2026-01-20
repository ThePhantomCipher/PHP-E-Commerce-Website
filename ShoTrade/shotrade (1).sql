-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2025 at 02:02 AM
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
-- Database: `shotrade`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `role`, `name`, `surname`, `email`, `password`, `created_at`) VALUES
(1, 'admin', 'Kamogelo', 'Mbele', 'admin@example.com', '$2y$10$1sDLwNJzRJnJeUSTWYh1V.zUIeixlfe4NL/8ME6SZkd15BJjqh2Vm', '2025-06-27 03:05:36');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `listing_id` int(11) DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `listing_id`, `added_at`) VALUES
(20, 5, 2, '2025-06-27 01:45:35'),
(21, 5, 3, '2025-06-27 01:45:37'),
(22, 6, 5, '2025-06-27 10:44:45'),
(23, 6, 4, '2025-06-27 10:44:48'),
(24, 4, 2, '2025-06-27 22:01:30'),
(25, 4, 3, '2025-06-27 22:01:31'),
(26, 4, 4, '2025-06-27 22:02:01'),
(27, 4, 5, '2025-06-27 23:32:58'),
(28, 4, 4, '2025-06-27 23:33:00');

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_requests`
--

CREATE TABLE `delivery_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `listing_id` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `driver_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_requests`
--

INSERT INTO `delivery_requests` (`id`, `user_id`, `listing_id`, `status`, `created_at`, `driver_id`) VALUES
(5, 5, 2, 'accepted', '2025-06-27 01:45:42', 2),
(6, 5, 3, 'delivered', '2025-06-27 01:45:42', 2),
(7, 6, 4, 'rejected', '2025-06-27 10:45:02', NULL),
(8, 6, 5, 'delivered', '2025-06-27 10:45:03', 2),
(9, 4, 2, 'delivered', '2025-06-27 22:01:41', 2),
(10, 4, 3, 'delivered', '2025-06-27 22:01:42', 2),
(11, 4, 4, 'pending', '2025-06-27 23:33:11', NULL),
(12, 4, 5, 'rejected', '2025-06-27 23:33:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `listings`
--

CREATE TABLE `listings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `listings`
--

INSERT INTO `listings` (`id`, `user_id`, `title`, `description`, `price`, `image`, `created_at`) VALUES
(2, 4, 'Pizza', 'lorem', 369.00, '685dd63c569f9.png', '2025-06-27 01:22:36'),
(3, 5, 'Tech', 'Tech logo new, not used', 900.00, '685dd902d37fb.png', '2025-06-27 01:34:26'),
(4, 5, 'Technology', 'tech business logo', 1000.00, '685dfd46ac7db.png', '2025-06-27 04:09:10'),
(5, 6, 'Einstein Picture', 'Einstein picture new.', 20.00, '685e7555ef097.jpg', '2025-06-27 12:41:25');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `created_at`) VALUES
(8, 5, 3, 'yo', '2025-06-27 02:35:47'),
(9, 5, 3, 'Yo', '2025-06-27 02:35:59'),
(10, 5, 2, 'hi', '2025-06-27 02:41:53'),
(11, 5, 4, 'awe', '2025-06-27 02:44:50'),
(12, 5, 3, 'Hi', '2025-06-27 02:44:58'),
(13, 4, 2, 'Hey Driver!', '2025-06-27 02:45:49'),
(14, 5, 2, 'Hope you good driver man', '2025-06-27 02:51:58'),
(15, 5, 3, 'Tshepo', '2025-06-27 02:52:40'),
(16, 5, 1, 'YO', '2025-06-27 02:53:24'),
(17, 2, 5, 'Hi', '2025-06-27 08:57:05'),
(18, 2, 5, 'Yo', '2025-06-27 21:58:20'),
(19, 5, 5, 'Hi James', '2025-06-27 22:00:15'),
(20, 4, 5, 'Awe James', '2025-06-27 22:00:59'),
(21, 2, 1, 'hi', '2025-06-27 23:29:49'),
(22, 2, 3, 'Yo', '2025-06-27 23:29:57');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `listing_id` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `reporter_id` int(11) DEFAULT NULL,
  `role` enum('user','driver','admin') NOT NULL,
  `target_id` int(11) DEFAULT NULL,
  `report_type` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `address` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `surname`, `email`, `password`, `created_at`, `address`, `profile_image`) VALUES
(1, 'user', 'Kamogelo', 'Mbele', 'kamogelokai88@gmail.com', '$2y$10$aWgB52PAulJSclYL9/WVGeBQsspzeOTA6zjfycr3rINpVMPSuo39G', '2025-06-24 23:15:41', '899 Mbeki Street', 'default.png'),
(2, 'driver', 'Jerry', 'Smith', 'Jsmith72@gmail.com', '$2y$10$MnHmaJFK.aVYHyYo.sg0HO4z0Q57OriudbJUKgyWwhf2fmfLBC94K', '2025-06-25 18:05:42', '1 Mortius Rd.', '685dbd5b7682e.jpg'),
(3, 'user', 'Tshepo', 'Mofokeng', 'Tmofokeng88@gmail.com', '$2y$10$ApV2vcHwAXqD94mT.pSqSuoZzSMkr5dtmg1n9WztaJyW/mMnfoYL6', '2025-06-25 21:11:28', '99 Easter avenue', 'default.png'),
(4, 'user', 'Tyrone', 'Ndlovu', 'Tndlovu77@gmail.com', '$2y$10$bI80oICwl5ffl4RogJA5YOnE5w.3ZVaabxY6eJQ9IjrVXq51yxvba', '2025-06-26 19:09:51', '12 Beach Island', '685dd20103308.png'),
(5, 'user', 'James', 'Motsamai', 'Jmotsamai77@gmail.com', '$2y$10$xif.wXnOvJAZGNX1ygFuvuQxZExsCO5VWMTF45qwoDMplpkcn3eF6', '2025-06-26 20:10:36', '2777 Mandela Section, Tumahole', '685de85235ae8.png'),
(6, 'user', 'Tshepo', 'Shabalala', 'Tshabalala99@gmail.com', '$2y$10$U2CjS6Orbw2UprRbQJYPE.BEGcxom1z7Xy/VZcuzCcvRnlYqT2HmC', '2025-06-27 10:39:17', '99 Vilakazi Street', 'default.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_requests`
--
ALTER TABLE `delivery_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `listings`
--
ALTER TABLE `listings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_requests`
--
ALTER TABLE `delivery_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `listings`
--
ALTER TABLE `listings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
