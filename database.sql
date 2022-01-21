-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2022 at 12:37 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skripsi-max-miner`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(8) NOT NULL,
  `order_id` int(6) NOT NULL,
  `product_id` int(4) NOT NULL,
  `name` varchar(80) NOT NULL,
  `quantity` int(4) NOT NULL,
  `price` double NOT NULL,
  `subtotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `order_id`, `product_id`, `name`, `quantity`, `price`, `subtotal`) VALUES
(1, 2, 1, 'roti', 1, 2000, 2000),
(2, 2, 2, 'selai', 1, 2000, 2000),
(3, 2, 3, 'mentega', 1, 2000, 2000),
(4, 3, 1, 'roti', 1, 2000, 2000),
(5, 3, 3, 'mentega', 1, 2000, 2000),
(6, 4, 1, 'roti', 1, 2000, 2000),
(7, 4, 3, 'mentega', 1, 2000, 2000),
(8, 4, 4, 'susu', 1, 2000, 2000),
(9, 5, 1, 'roti', 1, 2000, 2000),
(10, 5, 3, 'mentega', 1, 2000, 2000),
(11, 5, 4, 'susu', 1, 2000, 2000),
(12, 5, 5, 'coklat', 1, 2000, 2000),
(13, 6, 4, 'susu', 1, 2000, 2000),
(14, 6, 5, 'coklat', 1, 2000, 2000);

-- --------------------------------------------------------

--
-- Table structure for table `email_confirm`
--

CREATE TABLE `email_confirm` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_uid` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirm_code` int(6) NOT NULL,
  `expire_date` datetime NOT NULL,
  `status` enum('unconfirmed','confirmed') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(6) NOT NULL,
  `uid` varchar(10) NOT NULL,
  `item` int(2) NOT NULL,
  `total` double NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `uid`, `item`, `total`, `date`, `time`) VALUES
(2, 'v7KB0lqE6R', 3, 6000, '2022-01-22', '06:15:00'),
(3, 'EoeXZqtORV', 2, 4000, '2022-01-22', '06:16:00'),
(4, '35eXZEwHyQ', 3, 6000, '2022-01-22', '06:17:00'),
(5, 'Eji4d8gBq1', 4, 8000, '2022-01-22', '06:18:00'),
(6, 'kDIn738auS', 2, 4000, '2022-01-22', '06:18:00');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(4) NOT NULL,
  `name` varchar(80) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `image`, `price`) VALUES
(1, 'roti', NULL, 2000),
(2, 'selai', NULL, 2000),
(3, 'mentega', NULL, 2000),
(4, 'susu', NULL, 2000),
(5, 'coklat', NULL, 2000);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` enum('admin','member') COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `role`, `email`, `username`, `password`, `full_name`, `photo`) VALUES
(1, 'admin', 'agungmasda29@gmail.com', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Administrator', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_confirm`
--
ALTER TABLE `email_confirm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `email_confirm`
--
ALTER TABLE `email_confirm`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
