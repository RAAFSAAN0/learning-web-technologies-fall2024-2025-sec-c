-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2025 at 06:27 PM
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
-- Database: `agriculture`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `crop_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price_per_kg` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `crop_id`, `quantity`, `price_per_kg`, `total_price`, `added_at`, `updated_at`) VALUES
(58, 7, 38, 10, 25.75, 257.50, '2025-01-09 09:13:13', '2025-01-09 09:22:12'),
(59, 1, 39, 1, 30.50, 30.50, '2025-01-10 06:43:51', '2025-01-10 06:43:51'),
(60, 1, 38, 10, 25.75, 257.50, '2025-01-10 06:44:35', '2025-01-10 06:44:41'),
(61, 1, 38, 1, 25.75, 25.75, '2025-01-10 06:53:33', '2025-01-10 06:53:33'),
(62, 1, 38, 4, 25.75, 103.00, '2025-01-10 13:30:09', '2025-01-10 13:30:09'),
(63, 1, 38, 3, 25.75, 77.25, '2025-01-10 13:33:05', '2025-01-10 13:33:05'),
(64, 1, 38, 1, 25.75, 25.75, '2025-01-10 14:03:18', '2025-01-10 14:03:18'),
(65, 1, 38, 1, 25.75, 25.75, '2025-01-10 14:03:22', '2025-01-10 14:03:22'),
(66, 1, 38, 1, 25.75, 25.75, '2025-01-10 14:03:25', '2025-01-10 14:03:25'),
(67, 1, 38, 1, 25.75, 25.75, '2025-01-10 14:06:11', '2025-01-10 14:06:11'),
(68, 1, 38, 1, 25.75, 25.75, '2025-01-10 14:06:14', '2025-01-10 14:06:14'),
(84, 21, 38, 225, 25.75, 5793.75, '2025-01-16 09:32:26', '2025-01-16 09:46:33'),
(85, 21, 38, 1, 25.75, 25.75, '2025-01-16 11:44:58', '2025-01-16 11:44:58'),
(86, 21, 38, 20, 25.75, 515.00, '2025-01-16 12:22:24', '2025-01-16 13:38:17'),
(87, 2, 38, 5, 25.75, 128.75, '2025-01-16 13:46:48', '2025-01-16 13:46:52'),
(89, 4, 38, 1, 25.75, 25.75, '2025-01-17 05:50:43', '2025-01-17 05:50:43'),
(107, 6, 39, 8, 30.50, 244.00, '2025-01-19 10:55:05', '2025-01-19 10:55:10');

-- --------------------------------------------------------

--
-- Table structure for table `consumer`
--

CREATE TABLE `consumer` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `country` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `dob` date NOT NULL,
  `role` enum('Consumer','Admin') NOT NULL,
  `profile_image` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consumer`
--

INSERT INTO `consumer` (`id`, `first_name`, `last_name`, `email`, `mobile`, `password`, `country`, `address`, `dob`, `role`, `profile_image`) VALUES
(1, 'Rafsan', 'Mahmud', 'rgrgrgr@hamgild', '01712247730', '1', 'BANGLADESH', 'new york', '2025-02-02', 'Consumer', 'profile_6778077fc7707.jpg'),
(2, 'Shahrukh', 'KHAN', 'mahmudrafsan099@yahoo.com', '01712247731', '1', 'Canadaddd', '111fsafj', '2024-11-26', 'Consumer', 'profile_6779552980611.png'),
(3, 'newassssss', 'Consumerssss', 'new@gmail.com', '017122477314443', '2', 'BANGLADESH', '18', '2025-01-17', 'Consumer', 'profile_678b4fdfe1570.jpg'),
(4, 'AKIDs', 'PANDA', 'panda@gmail.comm', '017122477312335', '1', 'USA', '1', '2024-12-12', 'Consumer', 'profile_6789f12c02716.jpg'),
(5, 'Tom', 'Cruise', 'tom@gmail.com', '01712247ss73033', '2', 'Bangladesh', '1ss', '2025-01-16', 'Consumer', 'profile_678a62393b1c5.jpg'),
(6, 'Cristiano', 'Ronaldo', 'cr7@gmail.com', '01712247730', 'Asdf1', 'USAssss', 'Bangladesh', '2024-12-25', 'Consumer', 'profile_678b9fb648bdb.jpg'),
(7, 'rafsan', 'mahmud', '1@gmail.com', '1', '1', 'USA', '1', '2024-11-15', 'Consumer', NULL),
(8, '1', '1', '12@gmail.com', '1', '1', 'USA', '1', '2025-01-01', 'Consumer', NULL),
(9, 'AL', 'PACINO', 'al@gmail.com', '01712247730', '2', 'USA', 'Bangladesh', '2024-12-31', 'Consumer', 'profile_6779733700b28.webp'),
(10, 'rafsan', 'mahmud', 'rgrg332223rgr@hamgild', '01712247730', '1', 'USA', '12', '2024-12-30', 'Consumer', NULL),
(11, 'John', 'Doe', 'john.doe@example.com', '01712247732', '1', 'USA', '123 Main St, New York', '1990-05-23', 'Consumer', 'profile_677a274e2574e.jpeg'),
(12, 'Janeds', 'Smith', 'jane.smith@example.com', '01712247733', 'securePass1', 'Canada', '45 Queen St, Toronto', '1988-03-20', 'Consumer', 'profile_677a4181a6247.jpg'),
(13, 'Alice', 'Brown', 'alice.brown@example.com', '01712247734', 'alicePass99', 'UK', '67 Park Lane, London', '1995-08-12', 'Consumer', 'profile_987654.jpg'),
(14, 'Bob', 'White', 'bob.white@example.com', '01712247735', 'bobSecure23', 'Australia', '12 High St, Sydney', '1987-12-25', 'Consumer', 'profile_321456.jpg'),
(17, 'd', 'd', 'd', '01712247730', 'd', 'UK', 'd', '2024-12-30', 'Consumer', NULL),
(18, 'd', 'd', 'mahmudrafsan099@yahood.com', '01712247730', 'd', 'Canada', 'd', '2024-12-31', 'Consumer', 'profile_677f5d03e646e.jpeg'),
(19, 'ss', 'ss', 'mahmudrafsan099@yahoo.comss', '01712247730', 's', 'Canada', 's', '2024-12-31', 'Consumer', NULL),
(20, 's', 's', 'mahmudrafsan099@yahoo.comsss', '01712247730', 's', 'Canada', 's', '2025-01-02', 'Consumer', NULL),
(21, 'rafsan', 'mahmud', 'r@gmail.com', '017945487531', 'Asdf1', 'Canada', '18', '2024-12-31', 'Consumer', NULL),
(22, 'rafsan', 'mahmud', 'rgrgrgr@hamgild.com', '01794548753', 'Asdf1', 'Canada', 'asf', '2025-01-01', 'Consumer', NULL),
(23, 'hellow', 'word', 'wor@gmail.com', '01794548753', 'Asdf1', 'Canada', '18', '2025-01-08', 'Consumer', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `consumer_account`
--

CREATE TABLE `consumer_account` (
  `account_id` int(11) NOT NULL,
  `consumer_id` int(11) NOT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consumer_account`
--

INSERT INTO `consumer_account` (`account_id`, `consumer_id`, `balance`, `created_at`, `updated_at`) VALUES
(10, 7, 672.00, '2025-01-09 08:47:45', '2025-01-09 09:14:15'),
(11, 1, 332.25, '2025-01-10 06:56:40', '2025-01-10 14:24:38'),
(12, 4, 5958.75, '2025-01-10 14:25:38', '2025-01-17 09:38:25'),
(13, 21, 922.75, '2025-01-16 06:47:29', '2025-01-16 06:47:39'),
(14, 5, 98394.75, '2025-01-17 09:53:47', '2025-01-17 16:26:46'),
(15, 3, 2416.25, '2025-01-18 06:51:49', '2025-01-18 11:07:49'),
(16, 6, 650.00, '2025-01-18 11:59:22', '2025-01-19 13:25:45');

-- --------------------------------------------------------

--
-- Table structure for table `consumer_purchase`
--

CREATE TABLE `consumer_purchase` (
  `purchase_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `crop_id` int(11) NOT NULL,
  `amount_bought` decimal(10,2) NOT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `transaction_type` enum('Mobile Banking','Retail Banking') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consumer_purchase`
--

INSERT INTO `consumer_purchase` (`purchase_id`, `user_id`, `crop_id`, `amount_bought`, `purchase_date`, `transaction_type`) VALUES
(160, 6, 38, 4.00, '2025-01-18 19:40:29', 'Retail Banking'),
(161, 6, 38, 2.00, '2025-01-18 19:40:40', 'Mobile Banking'),
(162, 6, 38, 8.00, '2025-01-18 19:56:03', 'Retail Banking'),
(163, 6, 38, 4.00, '2025-01-19 06:06:16', 'Retail Banking'),
(164, 6, 39, 3.00, '2025-01-19 06:06:37', 'Mobile Banking'),
(165, 6, 39, 1.00, '2025-01-19 06:39:25', 'Retail Banking'),
(166, 6, 38, 3.00, '2025-01-19 06:41:10', 'Retail Banking'),
(167, 6, 39, 4.00, '2025-01-19 08:38:43', 'Retail Banking');

-- --------------------------------------------------------

--
-- Table structure for table `crop`
--

CREATE TABLE `crop` (
  `crop_id` int(11) NOT NULL,
  `farmer_id` int(11) NOT NULL,
  `crop_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `quantity` float NOT NULL,
  `available_quantity` float NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crop`
--

INSERT INTO `crop` (`crop_id`, `farmer_id`, `crop_name`, `description`, `quantity`, `available_quantity`, `price`, `image`) VALUES
(38, 11, 'Wheat', 'High-quality wheat', 1000, 9108, 25.75, 'C:/xampp/htdocs/NEW/AGRICULTURE/asset/images/tomato.jpg'),
(39, 12, 'Carrot', 'Organic Carrot', 1500, 1321, 30.50, 'C:/xampp/htdocs/NEW/AGRICULTURE/asset/images/carrot.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `crop_exchange`
--

CREATE TABLE `crop_exchange` (
  `id` int(11) NOT NULL,
  `crop_name` varchar(255) NOT NULL,
  `crop_quantity` varchar(255) NOT NULL,
  `crop_description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crop_exchange`
--

INSERT INTO `crop_exchange` (`id`, `crop_name`, `crop_quantity`, `crop_description`, `created_at`) VALUES
(2, 'bhutta', '33', 'dsf', '2025-01-19 08:10:02');

-- --------------------------------------------------------

--
-- Table structure for table `crop_review`
--

CREATE TABLE `crop_review` (
  `id` int(11) NOT NULL,
  `crop_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_type` enum('Consumer','Farmer') NOT NULL,
  `review_text` text NOT NULL,
  `review_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crop_review`
--

INSERT INTO `crop_review` (`id`, `crop_id`, `user_id`, `user_type`, `review_text`, `review_date`) VALUES
(110, 38, 6, 'Consumer', 'great product', '2025-01-19 06:33:42'),
(111, 38, 6, 'Consumer', 'jhgf', '2025-01-19 10:54:32'),
(112, 39, 6, 'Consumer', 'dd', '2025-01-19 13:56:02');

-- --------------------------------------------------------

--
-- Table structure for table `farmer`
--

CREATE TABLE `farmer` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `country` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `role` enum('Farmer') NOT NULL DEFAULT 'Farmer',
  `profile_image` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farmer`
--

INSERT INTO `farmer` (`id`, `first_name`, `last_name`, `email`, `mobile`, `password`, `country`, `address`, `dob`, `role`, `profile_image`) VALUES
(11, 's', 's', '22-46207-1@student.aiub.edus', '01712247730', 's', 'USA', 's', '2025-01-02', 'Farmer', 'default.jpg'),
(12, 'farmer ', 'ali', 'mahmudrafsan099@yahoo.comaa', '01712247730', 'Asdf12', 'Canada', 'a', '2025-01-01', 'Farmer', 'default.jpg'),
(13, 's', 's', 'ddd@gmail.com', '01712247730', 'Aiub3', 'USA', 'Bangladesh', '2024-12-31', 'Farmer', 'default.jpg'),
(14, 'PM', 'Tashrif', 't@gmail.com', '01794548753', 'Abcd1', 'Canada', '18', '2025-01-02', 'Farmer', 'default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `country` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `dob` date NOT NULL,
  `role` enum('Student') NOT NULL,
  `profile_image` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `first_name`, `last_name`, `email`, `mobile`, `password`, `country`, `address`, `dob`, `role`, `profile_image`) VALUES
(1, 's', 's', 'mahmudrafsan099@yahoo.comsdf', '01712247730', 's', 'Canada', 'Bangladesh', '2025-01-01', 'Student', 'default.jpg'),
(2, 's', 's', 'mahmudrafsan0s99@yahoo.comsss', '01712247730', 's', 'UK', '1', '2025-01-01', 'Student', 'default.jpg'),
(3, 'e', 'e', 'e@gmaill.comeeee', '01712247730', 'Aiub3', 'UK', 'Bangladesh', '2024-12-31', 'Student', 'default.jpg'),
(4, 'f', 'f', 'ddd@gmail.comdsf', '01712247730', 'Aiub3', 'Canada', 'Bangladesh', '2024-12-31', 'Student', 'default.jpg'),
(5, 'rafsan', 'mahmud', 'rgrgrgr@hamgild.comss', '01712247730', 'Aiub3', 'UK', 'Bangladesh', '2025-01-02', 'Student', 'default.jpg'),
(6, 'd', 'd', 'mahmudrafsan099@yahoo.coms', '01794548753', 'Asdf1', 'USA', '18', '2025-01-18', 'Student', 'default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE `video` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `video_path` varchar(255) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `likes` int(11) DEFAULT 0,
  `dislikes` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`id`, `email`, `title`, `description`, `video_path`, `upload_date`, `likes`, `dislikes`) VALUES
(23, 'ddd@gmail.com', 'Eye Exercise 1', 'hosdasdfas', 'C:/xampp/htdocs/agri20/asset/video/video_677f68656c83f.mp4', '2025-01-09 01:10:45', 29, 26),
(24, 'ddd@gmail.com', 'Atif aslam singing live', 'dd', 'C:/xampp/htdocs/agri20/asset/video/video_67890e20535f3.mp4', '2025-01-16 08:48:16', 9, 5),
(25, 'mahmudrafsan099@yahoo.comaa', 'Eye Exercise 2', 'asdjfaskdfkjasdhfljsadhfkjsahdf kjasdhfjkasd f kjashfjkasdnf kjassdhfjasdhf', 'C:/xampp/htdocs/agri20/asset/video/video_6789238fe3969.mp4', '2025-01-16 10:19:43', 0, 0),
(26, 'mahmudrafsan099@yahoo.comaa', 'ss', 'ss', '../asset/videos/1737228281_4k.mp4', '2025-01-18 19:24:41', 0, 0),
(28, 'cr7@gmail.com', 'sadf', 'sadf', '../asset/videos/1737228939_4k.mp4', '2025-01-18 19:35:39', 0, 0),
(29, '22-46207-1@student.aiub.edus', '2', '2', '../asset/videos/1737230414_4k.mp4', '2025-01-18 20:00:14', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `video_comments`
--

CREATE TABLE `video_comments` (
  `id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_type` enum('Consumer','Student') NOT NULL,
  `comment_text` text NOT NULL,
  `comment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `video_comments`
--

INSERT INTO `video_comments` (`id`, `video_id`, `user_id`, `user_type`, `comment_text`, `comment_date`) VALUES
(81, 26, 6, 'Consumer', 'm', '2025-01-18 19:33:00'),
(82, 23, 6, 'Consumer', 'ii', '2025-01-18 19:57:41'),
(83, 24, 6, 'Consumer', 'great concert it was!', '2025-01-19 06:33:25'),
(84, 25, 6, 'Consumer', 'great', '2025-01-19 07:52:56'),
(85, 23, 6, 'Consumer', 'ttt', '2025-01-19 10:55:18'),
(86, 23, 6, 'Consumer', 'ttt', '2025-01-19 13:26:17'),
(87, 23, 6, 'Consumer', 'fgg', '2025-01-19 13:26:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `crop_id` (`crop_id`);

--
-- Indexes for table `consumer`
--
ALTER TABLE `consumer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `consumer_account`
--
ALTER TABLE `consumer_account`
  ADD PRIMARY KEY (`account_id`),
  ADD KEY `consumer_id` (`consumer_id`);

--
-- Indexes for table `consumer_purchase`
--
ALTER TABLE `consumer_purchase`
  ADD PRIMARY KEY (`purchase_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `crop_id` (`crop_id`);

--
-- Indexes for table `crop`
--
ALTER TABLE `crop`
  ADD PRIMARY KEY (`crop_id`),
  ADD KEY `farmer_id` (`farmer_id`);

--
-- Indexes for table `crop_exchange`
--
ALTER TABLE `crop_exchange`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crop_review`
--
ALTER TABLE `crop_review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `crop_id` (`crop_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `farmer`
--
ALTER TABLE `farmer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_comments`
--
ALTER TABLE `video_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `video_id` (`video_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `consumer`
--
ALTER TABLE `consumer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `consumer_account`
--
ALTER TABLE `consumer_account`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `consumer_purchase`
--
ALTER TABLE `consumer_purchase`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT for table `crop`
--
ALTER TABLE `crop`
  MODIFY `crop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `crop_exchange`
--
ALTER TABLE `crop_exchange`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `crop_review`
--
ALTER TABLE `crop_review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `farmer`
--
ALTER TABLE `farmer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `video_comments`
--
ALTER TABLE `video_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `consumer` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`crop_id`) REFERENCES `crop` (`crop_id`);

--
-- Constraints for table `consumer_account`
--
ALTER TABLE `consumer_account`
  ADD CONSTRAINT `consumer_account_ibfk_1` FOREIGN KEY (`consumer_id`) REFERENCES `consumer` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `consumer_purchase`
--
ALTER TABLE `consumer_purchase`
  ADD CONSTRAINT `consumer_purchase_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `consumer` (`id`),
  ADD CONSTRAINT `consumer_purchase_ibfk_2` FOREIGN KEY (`crop_id`) REFERENCES `crop` (`crop_id`);

--
-- Constraints for table `crop`
--
ALTER TABLE `crop`
  ADD CONSTRAINT `crop_ibfk_1` FOREIGN KEY (`farmer_id`) REFERENCES `farmer` (`id`);

--
-- Constraints for table `crop_review`
--
ALTER TABLE `crop_review`
  ADD CONSTRAINT `crop_review_ibfk_1` FOREIGN KEY (`crop_id`) REFERENCES `crop` (`crop_id`),
  ADD CONSTRAINT `crop_review_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `consumer` (`id`);

--
-- Constraints for table `video_comments`
--
ALTER TABLE `video_comments`
  ADD CONSTRAINT `video_comments_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `video` (`id`),
  ADD CONSTRAINT `video_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `consumer` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
