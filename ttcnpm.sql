-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 19, 2021 at 03:02 AM
-- Server version: 8.0.18
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ttcnpm`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(11) NOT NULL,
  `name` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `address` text COLLATE utf8mb4_general_ci NOT NULL,
  `tables_num` int(11) NOT NULL,
  `manager` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `address`, `tables_num`, `manager`, `status`) VALUES
(3, 'Chi nhánh Quận 10', 'Lý Thường Kiệt, P.14, Q.10, TPHCM', 20, 4, 1),
(4, 'Chi nhánh Dĩ An', 'Dĩ An, Bình Dương', 15, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `phone` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(256) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `avatar` text COLLATE utf8mb4_general_ci,
  `gender` int(1) DEFAULT '0',
  `birthday` date DEFAULT NULL,
  `address` text COLLATE utf8mb4_general_ci,
  `status` int(1) DEFAULT '0',
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `image` text COLLATE utf8mb4_general_ci,
  `name` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `branch` int(11) DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `price` int(11) NOT NULL,
  `status` int(11) DEFAULT '0',
  `status_date` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `image`, `name`, `branch`, `description`, `price`, `status`, `status_date`) VALUES
(3, '8407051ebc6d0778fbc24ff6a43dac73.jpg', 'Cơm chiên dương châu', 3, 'Cơm chiên số 1 VN', 25000, 1, 0),
(4, '5e056aef8fb1b29e4507a785dd23f094.jpg', 'Cá khô tộ', 3, 'Cá kho tộ gia truyền', 20000, 0, 0),
(5, '9a420181eaa743292e1d6511f59c6110.jpg', 'Ramen', 4, 'Ramen ngon bổ rẻ', 30000, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `menuratings`
--

CREATE TABLE `menuratings` (
  `id` int(11) NOT NULL,
  `menu` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `rating` int(1) DEFAULT '5',
  `comment` text COLLATE utf8mb4_general_ci,
  `comment_time` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `id` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `menu` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_code` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `order_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `customer` int(11) DEFAULT NULL,
  `branch` int(11) DEFAULT NULL,
  `table` int(11) NOT NULL,
  `status` int(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `id` int(11) NOT NULL,
  `phone` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(256) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `idc` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` text COLLATE utf8mb4_general_ci,
  `gender` int(1) DEFAULT '0',
  `birthday` date DEFAULT NULL,
  `address` text COLLATE utf8mb4_general_ci,
  `branch` int(11) DEFAULT NULL,
  `role` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `create_by` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`id`, `phone`, `password`, `email`, `name`, `idc`, `avatar`, `gender`, `birthday`, `address`, `branch`, `role`, `create_time`, `create_by`, `status`) VALUES
(1, '1234567890', 'f657536db476b2dd5cb480c841890e1fad37edcdc3e69cdc12b96a4dec1eb91e', 'admin@pos.v2', 'Super admin', '', NULL, 0, NULL, NULL, NULL, 'admin', '2021-05-18 21:28:38', NULL, 1),
(4, '0212121211', 'f657536db476b2dd5cb480c841890e1fad37edcdc3e69cdc12b96a4dec1eb91e', 'manager190521002@pos.v2', 'Quản lý CS Q10', '1', '350be8e57d00a33973a000496125f34e.jpg', 1, '2021-05-19', NULL, 3, 'manager', '2021-05-19 09:49:01', 1, 1),
(5, '0212121212', 'f657536db476b2dd5cb480c841890e1fad37edcdc3e69cdc12b96a4dec1eb91e', 'manager190521003@pos.v2', 'Quản lý CS Dĩ An', '2', '9a0965319efb79eac5c57adda1125562.jpg', 2, '2021-05-18', NULL, 4, 'manager', '2021-05-19 09:49:40', 1, 1),
(6, '0212121213', 'f657536db476b2dd5cb480c841890e1fad37edcdc3e69cdc12b96a4dec1eb91e', 'chef190521004@pos.v2', 'Đầu bếp Q10 - 1', '3', NULL, 0, '2021-05-19', NULL, 3, 'chef', '2021-05-19 09:53:43', 1, 1),
(7, '0212121214', 'f657536db476b2dd5cb480c841890e1fad37edcdc3e69cdc12b96a4dec1eb91e', 'chef190521005@pos.v2', 'Đầu bếp Q10 - 2', '4', NULL, 0, '2021-05-18', NULL, 3, 'chef', '2021-05-19 09:54:02', 1, 1),
(8, '0212121215', 'f657536db476b2dd5cb480c841890e1fad37edcdc3e69cdc12b96a4dec1eb91e', 'chef190521006@pos.v2', 'Đầu bếp Dĩ An - 1', '5', NULL, 0, '2021-05-11', NULL, 4, 'chef', '2021-05-19 09:54:29', 1, 1),
(9, '0212121216', 'f657536db476b2dd5cb480c841890e1fad37edcdc3e69cdc12b96a4dec1eb91e', 'waiter190521007@pos.v2', 'Phục vụ cơ sở Q10 - 1', '123', NULL, 1, '2021-05-24', NULL, 3, 'waiter', '2021-05-19 09:59:11', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `manager` (`manager`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch` (`branch`);

--
-- Indexes for table `menuratings`
--
ALTER TABLE `menuratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer` (`customer`),
  ADD KEY `menu` (`menu`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order` (`order`),
  ADD KEY `menu` (`menu`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_code` (`order_code`),
  ADD KEY `customer` (`customer`),
  ADD KEY `branch` (`branch`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `idc` (`idc`),
  ADD KEY `branch` (`branch`),
  ADD KEY `create_by` (`create_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `menuratings`
--
ALTER TABLE `menuratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `branches`
--
ALTER TABLE `branches`
  ADD CONSTRAINT `branches_ibfk_1` FOREIGN KEY (`manager`) REFERENCES `staffs` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`branch`) REFERENCES `branches` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `menuratings`
--
ALTER TABLE `menuratings`
  ADD CONSTRAINT `menuratings_ibfk_1` FOREIGN KEY (`customer`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `menuratings_ibfk_2` FOREIGN KEY (`menu`) REFERENCES `menu` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`order`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`menu`) REFERENCES `menu` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`branch`) REFERENCES `branches` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `staffs`
--
ALTER TABLE `staffs`
  ADD CONSTRAINT `staffs_ibfk_1` FOREIGN KEY (`branch`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `staffs_ibfk_2` FOREIGN KEY (`create_by`) REFERENCES `staffs` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
