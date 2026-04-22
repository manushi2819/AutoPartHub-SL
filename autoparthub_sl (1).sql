-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Apr 22, 2026 at 06:30 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `autoparthub_sl`
--

-- --------------------------------------------------------

--
-- Table structure for table `auctions`
--

CREATE TABLE `auctions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_type` enum('vehicle','product') NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `starting_price` decimal(10,2) NOT NULL,
  `bid_increment` decimal(10,2) NOT NULL,
  `status` enum('upcoming','active','ended') NOT NULL DEFAULT 'upcoming',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `auctions`
--

INSERT INTO `auctions` (`id`, `item_type`, `item_id`, `start_time`, `end_time`, `starting_price`, `bid_increment`, `status`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'vehicle', 2, '2026-04-10 08:30:00', '2026-04-12 10:30:00', 7500000.00, 30000.00, 'ended', 1, '2026-04-09 09:29:06', '2026-04-18 13:47:36'),
(2, 'product', 1, '2026-04-10 09:00:00', '2026-04-13 21:00:00', 15000.00, 1000.00, 'ended', 1, '2026-04-09 15:24:27', '2026-04-18 13:47:36'),
(3, 'vehicle', 3, '2026-04-11 11:39:00', '2026-04-11 12:39:00', 98000000.00, 50000.00, 'ended', 1, '2026-04-10 07:10:03', '2026-04-18 13:47:36'),
(4, 'product', 13, '2026-04-11 14:08:00', '2026-04-13 14:08:00', 50000.00, 2500.00, 'ended', 1, '2026-04-10 08:38:34', '2026-04-18 13:47:36');

-- --------------------------------------------------------

--
-- Table structure for table `auction_bids`
--

CREATE TABLE `auction_bids` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `auction_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `bid_amount` decimal(10,2) NOT NULL,
  `bid_time` datetime NOT NULL DEFAULT current_timestamp(),
  `is_winner` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `auction_bids`
--

INSERT INTO `auction_bids` (`id`, `auction_id`, `customer_id`, `bid_amount`, `bid_time`, `is_winner`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 16000.00, '2026-04-10 19:11:08', 0, '2026-04-10 13:41:08', '2026-04-10 13:41:08'),
(2, 2, 2, 17000.00, '2026-04-10 19:12:35', 0, '2026-04-10 13:42:35', '2026-04-10 13:42:35');

-- --------------------------------------------------------

--
-- Table structure for table `auction_notifications`
--

CREATE TABLE `auction_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `auction_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('winner','outbid','general') NOT NULL,
  `sent_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Toyota', '1772893481_brand-15.png', 1, '2026-03-07 08:52:27', '2026-03-07 08:54:41'),
(2, 'Honda', '1772893408_brand-13.png', 1, '2026-03-07 08:52:27', '2026-03-07 08:53:28'),
(3, 'Ford', '1776697511_brands-11.png', 1, '2026-04-20 15:04:03', '2026-04-20 15:05:11'),
(4, 'BMW', '1772893423_brands-2.png', 1, '2026-03-07 08:52:27', '2026-03-07 08:53:43'),
(5, 'Mercedes-Benz', '1772893428_brands-3.png', 1, '2026-03-07 08:52:27', '2026-03-07 08:53:48'),
(6, 'Audi', '1772893433_brands-1.png', 1, '2026-03-07 08:52:27', '2026-03-07 08:53:53'),
(7, 'Nissan', '1772893438_brand-16.png', 1, '2026-03-07 08:52:27', '2026-03-07 08:53:58'),
(8, 'Hyundai', '1772893445_brands-7.png', 1, '2026-03-07 08:52:27', '2026-03-07 08:54:05'),
(9, 'Porsche', '1772893451_brands-6.png', 1, '2026-03-07 08:52:27', '2026-03-07 08:54:11'),
(10, 'Tesla', '1772893461_brands-4.png', 1, '2026-03-07 08:52:27', '2026-03-07 08:54:21'),
(11, 'Suzuki', '1772893467_brand-14.png', 1, '2026-03-07 08:52:27', '2026-03-07 08:54:27'),
(12, 'Jaguar', '1772893476_brands-10.png', 1, '2026-03-07 08:52:27', '2026-03-07 08:54:36'),
(14, 'Mitsubishi', '1776871433_Mitsubish.png', 1, '2026-04-22 15:23:53', '2026-04-22 15:23:53'),
(15, 'Yamaha', '1776874304_png-clipart-yamaha-motor-company-yamaha-corporation-motorcycle-logo-motorcycle-emblem-trademark-thumbnail.png', 1, '2026-04-22 16:11:44', '2026-04-22 16:11:44'),
(16, 'Bajaj', '1776874363_Bajaj-Logo.png', 1, '2026-04-22 16:12:43', '2026-04-22 16:12:43'),
(17, 'TVS', '1776874395_TVS-Motor-logo.png', 1, '2026-04-22 16:13:15', '2026-04-22 16:13:15'),
(18, 'Hero', '1776874413_images.png', 1, '2026-04-22 16:13:33', '2026-04-22 16:13:33');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `customer_id`, `session_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, NULL, '6CqkVTQRcQik22MLOXaQBZzCOR1kE2Y2GV6CGdhg', 3, 2, 44381.00, '2026-03-01 04:57:31', '2026-03-01 04:57:31'),
(2, NULL, '6CqkVTQRcQik22MLOXaQBZzCOR1kE2Y2GV6CGdhg', 8, 2, 38741.00, '2026-03-01 05:00:43', '2026-03-01 05:01:26'),
(18, NULL, '4faCqN8ztO3GuZTWR8Z7sx3NOGN8E9reDqM1dJwD', 2, 1, 15196.00, '2026-03-18 07:32:49', '2026-03-18 07:32:49'),
(19, NULL, 'Ko4GEXz8j7uvYlssqH4SXkZPwXxJZuTX69nzowNO', 15, 1, 10442.00, '2026-04-05 04:51:29', '2026-04-05 04:51:29'),
(21, NULL, '0ykdA3SFLuWcOzsG9efWplyGtL9tMGq7GB9gbMyW', 1, 2, 15196.00, '2026-04-06 05:52:13', '2026-04-06 05:57:40'),
(22, NULL, 'nrL1MJplU5ohzM0TVXtrs4kL35pFlXY3hEOU2yBh', 2, 1, 15196.00, '2026-04-21 08:23:38', '2026-04-21 09:01:18');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `parent_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Engine Components', 'uploads/category_images/1772725883_69a9a67bac19d.jpg', NULL, 1, '2026-02-19 10:23:45', '2026-03-05 10:21:23'),
(2, 'Pistons', NULL, 1, 1, '2026-02-19 10:23:45', '2026-02-19 10:30:37'),
(3, 'Standard Pistons', NULL, 2, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(4, 'Forged Pistons', NULL, 2, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(5, 'High-Compression Pistons', NULL, 2, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(6, 'Alloy Pistons', NULL, 2, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(7, 'Performance Pistons', NULL, 2, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(8, 'Camshafts', NULL, 1, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(9, 'Standard Camshafts', NULL, 8, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(10, 'Performance Camshafts', NULL, 8, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(11, 'Hydraulic Camshafts', NULL, 8, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(12, 'Solid Camshafts', NULL, 8, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(13, 'Race Camshafts', NULL, 8, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(14, 'Gaskets & Seals', NULL, 1, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(15, 'Head Gaskets', NULL, 14, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(16, 'Valve Cover Gaskets', NULL, 14, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(17, 'Oil Seals', NULL, 14, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(18, 'Exhaust Gaskets', NULL, 14, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(19, 'Timing Cover Gaskets', NULL, 14, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(20, 'Suspension & Steering', 'uploads/category_images/1772725904_69a9a69037580.jpg', NULL, 1, '2026-02-19 10:23:45', '2026-03-05 10:21:44'),
(21, 'Shock Absorbers', NULL, 20, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(22, 'Front Shock Absorbers', NULL, 21, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(23, 'Rear Shock Absorbers', NULL, 21, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(24, 'Gas Shocks', NULL, 21, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(25, 'Hydraulic Shocks', NULL, 21, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(26, 'Performance Shocks', NULL, 21, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(27, 'Control Arms', NULL, 20, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(28, 'Front Control Arms', NULL, 27, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(29, 'Rear Control Arms', NULL, 27, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(30, 'Adjustable Control Arms', NULL, 27, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(31, 'Lower Control Arms', NULL, 27, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(32, 'Upper Control Arms', NULL, 27, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(33, 'Steering Racks', NULL, 20, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(34, 'Power Steering Racks', NULL, 33, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(35, 'Manual Steering Racks', NULL, 33, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(36, 'Rack & Pinion', NULL, 33, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(37, 'Rebuilt Steering Racks', NULL, 33, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(38, 'Performance Steering Racks', NULL, 33, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(39, 'Brakes', 'uploads/category_images/1772725914_69a9a69aef9cf.jpg', NULL, 1, '2026-02-19 10:23:45', '2026-03-05 10:21:54'),
(40, 'Brake Pads', NULL, 39, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(41, 'Ceramic Pads', NULL, 40, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(42, 'Semi-Metallic Pads', NULL, 40, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(43, 'Performance Pads', NULL, 40, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(44, 'OEM Pads', NULL, 40, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(45, 'Truck Pads', NULL, 40, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(46, 'Brake Discs', NULL, 39, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(47, 'Vented Discs', NULL, 46, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(48, 'Drilled Discs', NULL, 46, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(49, 'Slotted Discs', NULL, 46, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(50, 'OEM Discs', NULL, 46, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(51, 'Performance Discs', NULL, 46, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(52, 'Brake Lines', NULL, 39, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(53, 'Steel Braided Lines', NULL, 52, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(54, 'Rubber Brake Lines', NULL, 52, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(55, 'OEM Brake Lines', NULL, 52, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(56, 'Performance Brake Lines', NULL, 52, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(57, 'Rear Brake Lines', NULL, 52, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(58, 'Transmission', 'uploads/category_images/1772725927_69a9a6a7b56ba.jpg', NULL, 1, '2026-02-19 10:23:45', '2026-03-05 10:22:07'),
(59, 'Clutches', NULL, 58, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(60, 'Standard Clutch Kit', NULL, 59, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(61, 'Performance Clutch Kit', NULL, 59, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(62, 'Ceramic Clutch', NULL, 59, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(63, 'OEM Clutch', NULL, 59, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(64, 'Truck Clutch', NULL, 59, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(65, 'Flywheels', NULL, 58, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(66, 'Lightweight Flywheel', NULL, 65, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(67, 'OEM Flywheel', NULL, 65, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(68, 'Performance Flywheel', NULL, 65, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(69, 'Dual-Mass Flywheel', NULL, 65, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(70, 'Steel Flywheel', NULL, 65, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(71, 'Transmission Fluid', NULL, 58, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(72, 'Automatic Transmission Fluid', NULL, 71, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(73, 'Manual Transmission Fluid', NULL, 71, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(74, 'Synthetic ATF', NULL, 71, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(75, 'OEM Transmission Fluid', NULL, 71, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(76, 'High-Performance Fluid', NULL, 71, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(77, 'Electrical', 'uploads/category_images/1772726017_69a9a701cdb16.jpg', NULL, 1, '2026-02-19 10:23:45', '2026-03-05 10:23:37'),
(78, 'Batteries', NULL, 77, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(79, 'Lead-Acid Battery', NULL, 78, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(80, 'AGM Battery', NULL, 78, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(81, 'Lithium-Ion Battery', NULL, 78, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(82, 'Truck Battery', NULL, 78, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(83, 'Motorcycle Battery', NULL, 78, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(84, 'Alternators', NULL, 77, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(85, 'Standard Alternator', NULL, 84, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(86, 'High Output Alternator', NULL, 84, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(87, 'OEM Alternator', NULL, 84, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(88, 'Remanufactured Alternator', NULL, 84, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(89, 'Performance Alternator', NULL, 84, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(90, 'Starters', NULL, 77, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(91, 'Standard Starter', NULL, 90, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(92, 'High Torque Starter', NULL, 90, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(93, 'OEM Starter', NULL, 90, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(94, 'Rebuilt Starter', NULL, 90, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(95, 'Performance Starter', NULL, 90, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(96, 'Exhaust', 'uploads/category_images/1772725982_69a9a6de4d2a9.webp', NULL, 1, '2026-02-19 10:23:45', '2026-03-05 10:23:02'),
(97, 'Mufflers', NULL, 96, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(98, 'Standard Muffler', NULL, 97, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(99, 'Performance Muffler', NULL, 97, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(100, 'OEM Muffler', NULL, 97, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(101, 'Stainless Steel Muffler', NULL, 97, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(102, 'Turbo Muffler', NULL, 97, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(103, 'Catalytic Converters', NULL, 96, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(104, 'OEM Catalytic Converter', NULL, 103, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(105, 'High Flow Converter', NULL, 103, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(106, 'Direct Fit Converter', NULL, 103, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(107, 'Universal Converter', NULL, 103, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(108, 'Truck Converter', NULL, 103, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(109, 'Exhaust Pipes', NULL, 96, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(110, 'Stainless Steel Pipes', NULL, 109, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(111, 'Aluminized Pipes', NULL, 109, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(112, 'Custom Exhaust Pipes', NULL, 109, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(113, 'OEM Pipes', NULL, 109, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(114, 'Turbo Pipes', NULL, 109, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(115, 'Fuel System', 'uploads/category_images/1772725994_69a9a6eac8cc7.jpg', NULL, 1, '2026-02-19 10:23:45', '2026-03-05 10:23:14'),
(116, 'Fuel Pumps', NULL, 115, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(117, 'Electric Fuel Pump', NULL, 116, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(118, 'Mechanical Fuel Pump', NULL, 116, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(119, 'High Flow Pump', NULL, 116, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(120, 'OEM Pump', NULL, 116, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(121, 'Performance Pump', NULL, 116, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(122, 'Fuel Injectors', NULL, 115, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(123, 'Standard Injector', NULL, 122, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(124, 'High Performance Injector', NULL, 122, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(125, 'OEM Injector', NULL, 122, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(126, 'Throttle Body Injector', NULL, 122, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(127, 'Direct Injection Injector', NULL, 122, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(128, 'Fuel Filters', NULL, 115, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(129, 'Inline Fuel Filter', NULL, 128, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(130, 'Cartridge Filter', NULL, 128, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(131, 'OEM Fuel Filter', NULL, 128, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(132, 'High Flow Fuel Filter', NULL, 128, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(133, 'Diesel Fuel Filter', NULL, 128, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(134, 'Cooling System', 'uploads/category_images/1772726063_69a9a72f8518c.jpg', NULL, 1, '2026-02-19 10:23:45', '2026-03-05 10:24:23'),
(135, 'Radiators', NULL, 134, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(136, 'Aluminum Radiator', NULL, 135, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(137, 'OEM Radiator', NULL, 135, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(138, 'Performance Radiator', NULL, 135, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(139, 'Truck Radiator', NULL, 135, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(140, 'Motorcycle Radiator', NULL, 135, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(141, 'Water Pumps', NULL, 134, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(142, 'Standard Water Pump', NULL, 141, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(143, 'High Flow Water Pump', NULL, 141, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(144, 'OEM Water Pump', NULL, 141, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(145, 'Performance Water Pump', NULL, 141, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(146, 'Electric Water Pump', NULL, 141, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(147, 'Thermostats', NULL, 134, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(148, 'Standard Thermostat', NULL, 147, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(149, 'High Temp Thermostat', NULL, 147, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(150, 'OEM Thermostat', NULL, 147, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(151, 'Performance Thermostat', NULL, 147, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(152, 'Truck Thermostat', NULL, 147, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(153, 'Body & Exterior', 'uploads/category_images/1772726090_69a9a74a4f697.png', NULL, 1, '2026-02-19 10:23:45', '2026-03-05 10:24:50'),
(154, 'Mirrors', NULL, 153, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(155, 'Side Mirrors', NULL, 154, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(156, 'Rearview Mirror', NULL, 154, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(157, 'Heated Mirror', NULL, 154, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(158, 'Power Mirror', NULL, 154, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(159, 'Manual Mirror', NULL, 154, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(160, 'Bumpers', NULL, 153, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(161, 'Front Bumper', NULL, 160, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(162, 'Rear Bumper', NULL, 160, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(163, 'OEM Bumper', NULL, 160, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(164, 'Performance Bumper', NULL, 160, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(165, 'Custom Bumper', NULL, 160, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(166, 'Lights', NULL, 153, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(167, 'Headlights', NULL, 166, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(168, 'Tail Lights', NULL, 166, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(170, 'LED Light Bars', NULL, 166, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(171, 'Turn Signals', NULL, 166, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(172, 'Interior', 'uploads/category_images/1772726274_69a9a802e383b.jpg', NULL, 1, '2026-02-19 10:23:45', '2026-03-05 10:27:54'),
(173, 'Seats', NULL, 172, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(174, 'Standard Seats', NULL, 173, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(175, 'Sports Seats', NULL, 173, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(176, 'Leather Seats', NULL, 173, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(177, 'OEM Seats', NULL, 173, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(178, 'Custom Seats', NULL, 173, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(179, 'Steering Wheels', NULL, 172, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(180, 'Standard Wheel', NULL, 179, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(181, 'Sport Wheel', NULL, 179, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(182, 'Leather Wheel', NULL, 179, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(183, 'OEM Wheel', NULL, 179, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(184, 'Custom Wheel', NULL, 179, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(185, 'Dashboard Accessories', NULL, 172, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(186, 'Gauges', NULL, 185, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(187, 'Dash Covers', NULL, 185, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(188, 'Cup Holders', NULL, 185, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(189, 'Phone Mounts', NULL, 185, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45'),
(190, 'Custom Panels', NULL, 185, 1, '2026-02-19 10:23:45', '2026-02-19 10:23:45');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `reply_comment` text DEFAULT NULL,
  `is_replied` tinyint(1) NOT NULL DEFAULT 0,
  `replied_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `phone`, `subject`, `message`, `reply_comment`, `is_replied`, `replied_at`, `created_at`, `updated_at`) VALUES
(4, 'Manushi Weerasinghe', 'manuw2819@gmail.com', '0716280393', 'hi', 'hiii', NULL, 0, NULL, '2026-03-10 10:59:51', '2026-03-10 10:59:51');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `password` varchar(255) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `provider_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `last_name`, `email`, `phone`, `address`, `status`, `password`, `provider`, `provider_id`, `created_at`, `updated_at`) VALUES
(1, 'Manushi', 'Weerasinghe', 'manuw2819@gmail.com', '0716280393', 'No.124, Ridigama, Kurunegala', 1, '$2y$12$yjd2AhSYf0qTNGDccIAA3eMMbN1hulKFc3MFAkia9MJCckzeVkuda', NULL, NULL, '2026-02-18 03:05:37', '2026-04-01 10:35:28'),
(2, 'Kasthuri', 'Dhananjaya', 'kasthurid1234@gmail.com', '0716316143', NULL, 1, '$2y$12$ialXlrJZtnollGjy287fkOnAlumBxf.wbY/UquUjEs7lVdffo1zUi', NULL, NULL, '2026-04-01 22:33:16', '2026-04-01 22:33:44'),
(4, 'Ruwindi', 'Weerasinghe', 'ruwindi2819@gmail.com', NULL, NULL, 1, NULL, 'google', '106816235934481292237', '2026-04-22 08:50:12', '2026-04-22 08:50:12');

-- --------------------------------------------------------

--
-- Table structure for table `customer_activities`
--

CREATE TABLE `customer_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `activity_type` varchar(255) NOT NULL,
  `reference_id` bigint(20) UNSIGNED DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_activities`
--

INSERT INTO `customer_activities` (`id`, `customer_id`, `activity_type`, `reference_id`, `value`, `created_at`, `updated_at`) VALUES
(1, 1, 'product_view', 2, NULL, '2026-03-07 10:18:16', '2026-03-07 10:18:16'),
(3, 1, 'search', NULL, 'Radiator', '2026-03-07 10:22:30', '2026-03-07 10:22:30'),
(4, 1, 'category_view', 39, NULL, '2026-03-07 10:22:42', '2026-03-07 10:22:42'),
(5, 1, 'category_view', 77, NULL, '2026-03-07 10:22:54', '2026-03-07 10:22:54'),
(6, 1, 'brand_view', NULL, 'Honda', '2026-03-07 10:23:05', '2026-03-07 10:23:05'),
(7, 1, 'product_view', 14, NULL, '2026-04-01 01:08:10', '2026-04-01 01:08:10'),
(8, 2, 'category_view', 1, NULL, '2026-04-01 22:35:00', '2026-04-01 22:35:00'),
(9, 2, 'category_view', 20, NULL, '2026-04-01 22:35:05', '2026-04-01 22:35:05'),
(10, 2, 'category_view', 20, NULL, '2026-04-01 22:35:53', '2026-04-01 22:35:53'),
(11, 2, 'category_view', 20, NULL, '2026-04-01 22:36:21', '2026-04-01 22:36:21'),
(12, 2, 'category_view', 20, NULL, '2026-04-01 22:36:41', '2026-04-01 22:36:41'),
(13, 2, 'category_view', 1, NULL, '2026-04-01 22:37:00', '2026-04-01 22:37:00'),
(14, 2, 'category_view', 20, NULL, '2026-04-01 22:37:00', '2026-04-01 22:37:00'),
(15, 2, 'vehicle_location_view', NULL, 'Colombo', '2026-04-04 08:29:48', '2026-04-04 08:29:48'),
(16, 2, 'vehicle_condition_view', NULL, 'Reconditioned', '2026-04-04 08:30:42', '2026-04-04 08:30:42'),
(17, 2, 'search', NULL, 'Radiator', '2026-04-04 08:35:35', '2026-04-04 08:35:35'),
(18, 1, 'category_view', 20, NULL, '2026-04-10 06:33:05', '2026-04-10 06:33:05'),
(19, 2, 'vehicle_view', NULL, '2', '2026-04-10 15:39:21', '2026-04-10 15:39:21'),
(20, 2, 'category_view', 96, NULL, '2026-04-22 08:40:55', '2026-04-22 08:40:55'),
(21, 2, 'product_view', 20, NULL, '2026-04-22 08:41:00', '2026-04-22 08:41:00');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_18_083239_create_customers_table', 2),
(9, '2026_02_19_134716_create_categories_table', 3),
(10, '2026_02_19_134816_create_products_table', 3),
(11, '2026_02_19_134913_create_product_images_table', 3),
(12, '2026_02_19_134952_create_product_vehicle_compatibilities_table', 3),
(13, '2026_02_20_010010_create_contact_messages_table', 4),
(14, '2026_02_28_170258_add_address_to_customers_table', 5),
(15, '2026_02=3_01_050258_add_small_decrisption_to_products_table', 6),
(16, '2026_03_01_102025_create_carts_table', 7),
(17, '2026_03_01_102104_create_wishlists_table', 7),
(18, '2026_03_03_153516_create_orders_table', 8),
(19, '2026_03_03_153528_create_order_items_table', 8),
(21, '2026_03_03_164640_create_reviews_table', 9),
(22, '2026_03_05_154110_add_image_to_categories_table', 10),
(26, '2026_03_06_162547_create_brands_table', 11),
(27, '2026_03_07_142452_create_customer_activities_table', 12),
(28, '2026_03_31_014110_add_tracking_no_to_orders_table', 13),
(29, '2026_04_01_014110_add_status_to_customers_table', 14),
(32, '2026_04_04_063037_create_vehicles_table', 15),
(33, '2026_04_04_063223_create_vehicle_images_table', 15),
(34, '2026_04_09_141948_create_auctions_table', 16),
(35, '2026_04_09_142100_create_auction_bids_table', 16),
(36, '2026_04_09_142138_create_auction_notifications_table', 16),
(37, '2026_04_20_200134_add_brand_id_to_products_table', 17),
(38, '2026_04_20_201304_remove_brand_from_products_table', 18),
(39, '2026_04_22_141742_add_provider_fields_to_customers_table', 19),
(40, '2026_04_22_141925_modify_password_nullable_in_customers_table', 20),
(43, '2026_04_22_202242_create_vehicle_types_table', 21),
(44, '2026_04_22_202326_add_vehicle_type_id_to_products_table', 21),
(45, '2026_04_22_210617_change_vehicle_type_to_json_in_products_table', 22);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_number` varchar(255) DEFAULT NULL,
  `tracking_no` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL DEFAULT 'Sri Lanka',
  `subtotal` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL DEFAULT 'cod',
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `order_number`, `tracking_no`, `first_name`, `last_name`, `email`, `phone`, `address`, `city`, `zip`, `country`, `subtotal`, `discount`, `total`, `payment_method`, `status`, `payment_status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'ORD-CGK7ZTDW', NULL, 'Kasthuri', 'Dhananjaya', 'kasthurid1234@gmail.com', '0716316143', 'No.124,Ridigama,', 'Kurunegala', '60040', 'Sri Lanka', 16396.00, 0.00, 16396.00, 'cod', 'pending', 'pending', '2026-04-22 08:38:31', '2026-04-22 08:38:31'),
(2, 2, 'ORD-QUVJUF4Y', NULL, 'Kasthuri', 'Dhananjaya', 'kasthurid1234@gmail.com', '0716316143', 'No.124', 'Ridigama, Kurunegala', '60040', 'Sri Lanka', 42050.00, 0.00, 42050.00, 'cod', 'pending', 'pending', '2026-04-22 08:41:40', '2026-04-22 08:41:40');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 1, 16396.00, 16396.00, '2026-04-22 08:38:31', '2026-04-22 08:38:31'),
(2, 2, 20, 1, 42050.00, 42050.00, '2026-04-22 08:41:40', '2026-04-22 08:41:40');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vehicle_type_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`vehicle_type_ids`)),
  `price` decimal(10,2) NOT NULL,
  `cost_price` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `small_description` text DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `sku`, `brand_id`, `vehicle_type_ids`, `price`, `cost_price`, `description`, `small_description`, `stock_quantity`, `status`, `created_at`, `updated_at`) VALUES
(1, 137, 'OEM Radiator', 'OEM-CAR-0001', 1, '[\"1\"]', 15196.00, 14267.00, '<p>Choosing the right rim involves considering factors such as the vehicle type, intended use, driving conditions, and personal preferences for style and performance. A well-maintained and properly selected set of rims can significantly enhance the overall look and performance of a vehicle.</p><p>wheels provide a means of mounting and affixing the tires to the vehicle through which the engine’s power is transferred to the ground. As the engine generates power, it moves through the drivetrain to the wheels, which bolt to the wheel hub and rotate around the axles For the wheels to turn and propel the car forward, you need to have friction provided by the tires in direct and constant contact with the ground under the car.</p><p><strong>Features </strong>:</p><ul><li>Rims can be made from different materials</li><li>This includes spoke wheels, multi-spoke wheels</li><li>The weight of the rim can impact the vehicle\'s overall weight and performance.</li><li>Certain rims may have features that make them easier to clean and maintain.</li></ul><p><br></p>', 'Choosing the right rim involves considering factors such as the vehicle type, intended use, driving conditions, and personal preferences for style and performance.', 38, 1, '2026-02-03 12:01:48', '2026-04-22 15:40:58'),
(2, 137, 'OEM Radiator', 'OEM-CAR-0002', 8, '[\"1\"]', 15196.00, 14267.00, '<p>Choosing the right rim involves considering factors such as the vehicle type, intended use, driving conditions, and personal preferences for style and performance. A well-maintained and properly selected set of rims can significantly enhance the overall look and performance of a vehicle.</p><p>wheels provide a means of mounting and affixing the tires to the vehicle through which the engine’s power is transferred to the ground. As the engine generates power, it moves through the drivetrain to the wheels, which bolt to the wheel hub and rotate around the axles For the wheels to turn and propel the car forward, you need to have friction provided by the tires in direct and constant contact with the ground under the car.</p><p><strong style=\"color: unset;\">Features </strong>:</p><ul><li>Rims can be made from different materials</li><li>This includes spoke wheels, multi-spoke wheels</li><li>The weight of the rim can impact the vehicle\'s overall weight and performance.</li><li>Certain rims may have features that make them easier to clean and maintain.</li></ul>', 'Choosing the right rim involves considering factors such as the vehicle type, intended use, driving conditions, and personal preferences for style and performance.', 38, 1, '2026-03-04 12:01:48', '2026-04-22 15:46:41'),
(3, 74, 'Synthetic ATF', 'SYN-CAR-0003', 2, '[\"1\"]', 44381.00, 26178.00, '<p>Synthetic ATF is engineered to enhance transmission efficiency and durability. It provides superior lubrication and thermal stability compared to conventional fluids.</p><ul><li>Improves gear shifting performance</li><li>Reduces wear and friction</li><li>Performs well under high temperatures</li><li>Extends transmission life</li></ul>', 'High-performance automatic transmission fluid designed for smoother shifting and better protection.', 37, 1, '2026-02-23 12:01:48', '2026-04-22 15:41:13'),
(4, 143, 'High Flow Water Pump', 'HIG-CAR-0004', 1, '[\"1\"]', 16396.00, 16828.00, '<p>A high flow water pump increases the movement of coolant through the engine, preventing overheating in high-performance conditions.</p><ul><li>Enhances cooling efficiency</li><li>Ideal for performance and racing engines</li><li>Reduces risk of overheating</li><li>Durable and long-lasting construction</li></ul><p><br></p>', 'Upgraded water pump designed to improve coolant circulation and engine cooling.', 11, 1, '2026-03-04 12:01:48', '2026-04-22 15:41:20'),
(5, 108, 'Truck Converter', 'TRU-LORR-0005', 1, '[\"5\"]', 12284.00, 15555.00, '<p>Truck converters are designed to handle higher torque loads and provide better power transfer in heavy vehicles.</p><ul><li>Improves towing capacity</li><li>Enhances acceleration under load</li><li>Built for durability and strength</li><li>Suitable for commercial and heavy-duty use&nbsp;</li></ul><p><br></p>', 'Heavy-duty torque converter built for trucks to improve power delivery and towing performance.', 24, 1, '2026-02-23 12:01:48', '2026-04-22 15:41:29'),
(6, 70, 'Steel Flywheel', 'STE-CAR-0006', 1, '[\"1\"]', 45877.00, 31201.00, '<p>Steel flywheels are heavier than aluminum ones, offering better rotational stability and smoother power delivery.</p><ul><li>Provides consistent engine momentum</li><li>Increases durability</li><li>Ideal for daily driving and heavy-duty use</li><li>Improves clutch engagement</li></ul><p><br></p>', 'Strong and durable flywheel made from steel for improved engine stability and performance.', 34, 1, '2026-02-23 12:01:48', '2026-04-22 15:41:41'),
(7, 151, 'Performance Thermostat', 'PER-CAR-0007', 2, '[\"1\"]', 24389.00, 33058.00, '<p>Performance thermostats open at lower temperatures to maintain optimal engine cooling.</p><ul><li>Helps prevent overheating</li><li>Improves engine efficiency</li><li>Maintains stable operating temperature</li><li>Ideal for modified or high-performance engines</li></ul><p><br></p>', 'Thermostat designed to regulate engine temperature more efficiently for better performance.', 17, 1, '2026-02-23 12:01:48', '2026-04-22 15:41:48'),
(8, 180, 'Standard Wheel', 'STA-CAR-0008', 1, '[\"1\",\"4\"]', 38741.00, 30546.00, '<p>Standard wheels are designed for general use, balancing comfort, durability, and cost-effectiveness.</p><ul><li>Suitable for daily driving</li><li>Provides stable handling</li><li>Cost-effective solution</li><li>Available in various sizes and designs</li></ul><p><br></p>', 'Reliable and durable wheel suitable for everyday driving conditions.', 39, 1, '2026-02-23 12:01:48', '2026-04-22 15:42:00'),
(9, 11, 'Hydraulic Camshafts', 'HYD-CAR-0009', NULL, '[\"1\"]', 17553.00, 39220.00, '<p>Hydraulic camshafts automatically adjust valve clearance, reducing maintenance and improving performance.</p><ul><li>Low maintenance operation</li><li>Reduces engine noise</li><li>Improves fuel efficiency</li><li>Ensures smoother valve timing</li></ul><p><br></p>', 'Camshafts that use hydraulic lifters for smoother and quieter engine operation.', 26, 1, '2026-02-23 12:01:48', '2026-04-22 15:42:10'),
(10, 178, 'Custom Seats', 'CUS-CAR-0010', 7, '[\"1\",\"4\"]', 17158.00, 36881.00, '<p>Custom seats are tailored to improve both aesthetics and driving comfort. They can be designed for luxury or performance use.</p><ul><li>Enhanced comfort and ergonomics</li><li>Custom design and materials</li><li>Improved driver support</li><li>Suitable for long drives or racing setups</li></ul><p><br></p>', 'Specially designed seats for enhanced comfort, style, and support.', 23, 1, '2026-02-23 12:01:48', '2026-04-22 15:42:19'),
(11, 4, 'Forged Pistons', 'FOR-CAR-0011', 2, '[\"1\"]', 32605.00, 5315.00, '<p>Forged pistons are built using high-pressure forging processes, making them stronger than cast pistons. Ideal for high-performance and turbocharged engines.</p><ul><li>Handles high pressure and heat</li><li>Improves engine durability</li><li>Ideal for racing and performance builds</li><li>Longer lifespan under stress</li></ul><p><br></p>', 'High-strength pistons designed for extreme performance and durability.', 3, 1, '2026-02-23 12:01:48', '2026-04-22 15:42:29'),
(12, 152, 'Truck Thermostat', 'TRU-LORR-0012', NULL, '[\"5\"]', 23531.00, 10969.00, '<p>Truck thermostats are built to withstand higher loads and maintain optimal cooling in large engines.</p><ul><li>Maintains stable engine temperature</li><li>Prevents overheating under load</li><li>Durable construction for heavy-duty use</li><li>Improves engine efficiency</li></ul><p><br></p>', 'Heavy-duty thermostat designed for trucks to regulate engine temperature efficiently.', 10, 1, '2026-02-23 12:01:48', '2026-04-22 15:42:41'),
(13, 42, 'Semi-Metallic Pads', 'SEM-CAR-0013', 7, '[\"1\",\"4\"]', 48614.00, 30287.00, '<p>Semi-metallic brake pads offer excellent heat resistance and braking power, making them suitable for demanding driving conditions.</p><ul><li>High braking performance</li><li>Better heat dissipation</li><li>Durable and long-lasting</li><li>Slightly noisier than ceramic pads&nbsp;</li></ul><p><br></p>', 'Brake pads made with metal compounds for strong braking performance.', 27, 1, '2026-02-23 12:01:48', '2026-04-22 15:42:53'),
(14, 183, 'OEM Wheel', 'OEM-CAR-0014', 2, '[\"1\",\"4\"]', 29073.00, 22685.00, '<p>OEM wheels are built to manufacturer specifications, ensuring compatibility and consistent performance.</p><ul><li>Perfect fit for specific vehicles</li><li>Reliable and durable</li><li>Maintains factory standards</li><li>Balanced performance and comfort</li></ul><p><br></p>', 'Original equipment manufacturer wheel designed for perfect fit and reliability.', 36, 1, '2026-02-23 12:01:48', '2026-04-22 15:45:19'),
(15, 176, 'Leather Seats', 'LEA-CAR-0015', NULL, '[\"1\"]', 10442.00, 35868.00, '<p>Leather seats enhance the interior look and provide superior comfort and durability.</p><ul><li>Elegant and premium appearance</li><li>Comfortable for long drives</li><li>Easy to clean and maintain</li><li>Durable material</li></ul><p><br></p>', 'Premium seats designed with leather for comfort and luxury.', 27, 1, '2026-02-23 12:01:48', '2026-04-22 15:43:35'),
(16, 190, 'Custom Panels', 'CUS-CAR-0016', 7, '[\"1\",\"4\"]', 46682.00, 14373.00, '<p>Custom panels allow vehicle owners to modify the appearance and improve aesthetics or functionality.</p><ul><li>Unique design options</li><li>Enhances vehicle appearance</li><li>Available in various materials</li><li>Suitable for interior or exterior upgrades</li></ul><p><br></p>', 'Custom panels designed for style and personalization.', 26, 1, '2026-02-23 12:01:48', '2026-04-22 15:43:07'),
(17, 79, 'Lead-Acid Battery', 'LEA-CAR-0017', 2, '[\"1\",\"4\",\"5\"]', 6745.00, 32081.00, '<p>Lead-acid batteries are widely used due to their affordability and dependable performance.</p><ul><li>Cost-effective solution</li><li>Provides consistent power</li><li>Suitable for most vehicles</li><li>Easy to maintain</li></ul><p><br></p>', 'Reliable automotive battery for starting and powering electrical systems.', 28, 1, '2026-02-23 12:01:48', '2026-04-22 15:39:59'),
(18, 16, 'Valve Cover Gaskets', 'VAL-CAR-0018', 2, '[\"1\"]', 9926.00, 16694.00, '<p>Valve cover gaskets ensure a tight seal between the valve cover and engine, protecting against oil leakage.</p><ul><li>Prevents oil leaks</li><li>Maintains engine cleanliness</li><li>Resistant to heat and pressure</li><li>Easy to replace</li></ul><p><br></p>', 'Seals the valve cover to prevent oil leaks in the engine.', 38, 1, '2026-02-23 12:01:48', '2026-04-22 15:43:52'),
(19, 159, 'Manual Mirror', 'MAN-CAR-0019', 1, '[\"1\",\"4\"]', 12958.00, 15328.00, '<p>Manual mirrors are simple, reliable, and cost-effective alternatives to powered mirrors.</p><ul><li>No electrical components</li><li>Easy to maintain</li><li>Durable design</li><li>Budget-friendly option</li></ul><p><br></p>', 'Side mirror adjusted manually without electronic controls.', 6, 1, '2026-02-23 12:01:48', '2026-04-22 15:44:04'),
(20, 113, 'OEM Pipes', 'OEM-CAR-0020', 1, '[\"1\",\"4\",\"5\"]', 42050.00, 19719.00, '<p>OEM pipes are manufactured to match original specifications, ensuring proper flow and compatibility.</p><ul><li>Perfect fit for vehicles</li><li>Maintains original performance</li><li>Durable material</li><li>Reliable and long-lasting</li></ul><p><br></p>', 'Factory-standard pipes designed for reliable performance and fit.', 24, 1, '2026-02-23 12:01:48', '2026-04-22 15:44:25'),
(22, 159, 'Manual Mirror', 'MAN-CAR-0021', 1, '[\"1\",\"4\"]', 12958.00, 15328.00, '<p>Manual mirrors are simple, reliable, and cost-effective alternatives to powered mirrors.</p><ul><li>No electrical components</li><li>Easy to maintain</li><li>Durable design</li><li>Budget-friendly option</li></ul><p><br></p>', 'Side mirror adjusted manually without electronic controls.', 6, 1, '2026-02-23 12:01:48', '2026-04-22 15:45:33'),
(31, 59, 'Motorbike Chain Set', 'CLU-MOTO-0022', 2, '[\"2\"]', 8500.00, 5950.00, '<p>Motorbike Chain Set suitable for most motorcycles.</p>', 'High quality motorbike spare part.', 16, 1, '2026-04-22 15:53:08', '2026-04-22 16:16:53'),
(32, 42, 'Disc Brake Pads (Bike)', 'SEM-MOTO-0023', 15, '[\"2\"]', 2500.00, 1750.00, '<p>Disc Brake Pads (Bike) suitable for most motorcycles.</p>', 'High quality motorbike spare part.', 19, 1, '2026-04-22 15:53:08', '2026-04-22 16:17:10'),
(33, 74, 'Motorcycle Engine Oil 10W-40', 'SYN-MOTO-0024', 16, '[\"2\"]', 3200.00, 2240.00, '<p>Motorcycle Engine Oil 10W-40 suitable for most motorcycles.</p>', 'High quality motorbike spare part.', 47, 1, '2026-04-22 15:53:08', '2026-04-22 16:17:28'),
(34, 129, 'Bike Air Filter', 'INL-MOTO-0025', 11, '[\"2\"]', 1500.00, 1050.00, '<p>Bike Air Filter suitable for most motorcycles.</p>', 'High quality motorbike spare part.', 47, 1, '2026-04-22 15:53:08', '2026-04-22 16:17:44'),
(35, 60, 'Motorbike Clutch Plate Kit', 'STA-MOTO-0026', 2, '[\"2\"]', 4200.00, 2940.00, '<p>Motorbike Clutch Plate Kit suitable for most motorcycles.</p>', 'High quality motorbike spare part.', 39, 1, '2026-04-22 15:53:08', '2026-04-22 16:18:03'),
(36, 167, 'LED Headlight Bulb (Bike)', 'HEA-MOTO-0027', 15, '[\"2\"]', 1800.00, 1260.00, '<p>LED Headlight Bulb (Bike) suitable for most motorcycles.</p>', 'High quality motorbike spare part.', 10, 1, '2026-04-22 15:53:08', '2026-04-22 16:18:24'),
(37, 83, 'Motorcycle Battery 12V', 'MOT-MOTO-0028', 17, '[\"2\"]', 6500.00, 4550.00, '<p>Motorcycle Battery 12V suitable for most motorcycles.</p>', 'High quality motorbike spare part.', 29, 1, '2026-04-22 15:53:08', '2026-04-22 16:18:46'),
(38, 123, 'Bike Spark Plug', 'STA-MOTO-0029', 16, '[\"2\"]', 900.00, 630.00, '<p>Bike Spark Plug suitable for most motorcycles.</p>', 'High quality motorbike spare part.', 20, 1, '2026-04-22 15:53:08', '2026-04-22 16:19:01'),
(39, 155, 'Motorbike Rear View Mirror Set', 'SID-MOTO-0030', 18, '[\"2\"]', 2200.00, 1540.00, '<p>Motorbike Rear View Mirror Set suitable for most motorcycles.</p>', 'High quality motorbike spare part.', 45, 1, '2026-04-22 15:53:08', '2026-04-22 16:19:15'),
(40, 171, 'Bike Indicator Light Set', 'TUR-MOTO-0031', 2, '[\"2\"]', 1700.00, 1190.00, '<p>Bike Indicator Light Set suitable for most motorcycles.</p>', 'High quality motorbike spare part.', 46, 1, '2026-04-22 15:53:08', '2026-04-22 16:19:27');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `is_main` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `is_main`, `created_at`, `updated_at`) VALUES
(3, 2, '1771868636_699c91dc3c4cf.jpg', 1, '2026-02-23 12:13:56', '2026-02-23 12:13:56'),
(4, 3, '1771868648_699c91e8c665f.png', 1, '2026-02-23 12:14:08', '2026-02-23 12:14:08'),
(6, 4, '1771868724_699c9234e53ce.png', 1, '2026-02-23 12:15:24', '2026-02-23 12:15:24'),
(7, 6, '1771868748_699c924c2989e.jpg', 1, '2026-02-23 12:15:48', '2026-02-23 12:15:48'),
(8, 7, '1771868775_699c9267647b6.jpg', 1, '2026-02-23 12:16:15', '2026-02-23 12:16:15'),
(9, 8, '1771868807_699c9287882b0.jpg', 1, '2026-02-23 12:16:47', '2026-02-23 12:16:47'),
(10, 9, '1771868837_699c92a50f0d5.jpg', 1, '2026-02-23 12:17:17', '2026-02-23 12:17:17'),
(11, 10, '1771868861_699c92bda5289.jpg', 1, '2026-02-23 12:17:41', '2026-02-23 12:17:41'),
(12, 11, '1771868886_699c92d62af6d.jpg', 1, '2026-02-23 12:18:06', '2026-02-23 12:18:06'),
(13, 12, '1771868914_699c92f26e466.jpg', 1, '2026-02-23 12:18:34', '2026-02-23 12:18:34'),
(14, 13, '1771868940_699c930cd61b2.jpg', 1, '2026-02-23 12:19:00', '2026-02-23 12:19:00'),
(15, 14, '1771868986_699c933a26434.jpg', 1, '2026-02-23 12:19:46', '2026-02-23 12:19:46'),
(16, 15, '1771869012_699c93541cfe4.jpg', 1, '2026-02-23 12:20:12', '2026-02-23 12:20:12'),
(17, 16, '1771869059_699c93831d849.jpg', 1, '2026-02-23 12:20:59', '2026-02-23 12:20:59'),
(18, 17, '1771869089_699c93a1e8f58.jpg', 1, '2026-02-23 12:21:29', '2026-02-23 12:21:29'),
(19, 18, '1771869116_699c93bc5e2a5.jpg', 1, '2026-02-23 12:21:56', '2026-02-23 12:21:56'),
(20, 19, '1771869149_699c93dd7a7dc.jpg', 1, '2026-02-23 12:22:29', '2026-02-23 12:22:29'),
(21, 20, '1771869174_699c93f6a110a.png', 1, '2026-02-23 12:22:54', '2026-02-23 12:22:54'),
(23, 1, '1772354758_69a3fcc64235a.jpg', 1, '2026-03-01 03:15:58', '2026-03-01 03:15:58'),
(24, 1, '1772354758_69a3fcc644234.jpg', 0, '2026-03-01 03:15:58', '2026-03-01 03:15:58'),
(25, 1, '1772354758_69a3fcc644d82.jpg', 0, '2026-03-01 03:15:58', '2026-03-01 03:15:58'),
(26, 5, '1772360021_69a4115583aae.jpg', 1, '2026-03-01 04:43:41', '2026-03-01 04:43:41'),
(28, 22, '1776871664_69e8e8f0c028b.jpg', 1, '2026-04-22 15:27:44', '2026-04-22 15:27:44'),
(29, 31, '1776873383_69e8efa762524.jpg', 1, '2026-04-22 15:56:23', '2026-04-22 15:56:23'),
(30, 32, '1776873460_69e8eff46301e.jpg', 1, '2026-04-22 15:57:40', '2026-04-22 15:57:40'),
(31, 33, '1776873550_69e8f04e51e36.png', 1, '2026-04-22 15:59:10', '2026-04-22 15:59:10'),
(32, 34, '1776873747_69e8f113520fd.jpg', 1, '2026-04-22 16:02:27', '2026-04-22 16:02:27'),
(33, 35, '1776873830_69e8f16634e04.jpg', 1, '2026-04-22 16:03:50', '2026-04-22 16:03:50'),
(34, 36, '1776873923_69e8f1c3c8dd8.jpg', 1, '2026-04-22 16:05:23', '2026-04-22 16:05:23'),
(35, 37, '1776873962_69e8f1ea65b1e.jpg', 1, '2026-04-22 16:06:02', '2026-04-22 16:06:02'),
(36, 38, '1776874014_69e8f21ec8d6e.jpg', 1, '2026-04-22 16:06:54', '2026-04-22 16:06:54'),
(37, 39, '1776874067_69e8f2536d4e7.jpg', 1, '2026-04-22 16:07:47', '2026-04-22 16:07:47'),
(38, 40, '1776874115_69e8f283399f9.jpg', 1, '2026-04-22 16:08:35', '2026-04-22 16:08:35');

-- --------------------------------------------------------

--
-- Table structure for table `product_vehicle_compatibilities`
--

CREATE TABLE `product_vehicle_compatibilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `year_from` int(11) DEFAULT NULL,
  `year_to` int(11) DEFAULT NULL,
  `engine_type` varchar(255) DEFAULT NULL,
  `engine_cc` int(11) DEFAULT NULL,
  `fuel_type` varchar(255) DEFAULT NULL,
  `transmission` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_vehicle_compatibilities`
--

INSERT INTO `product_vehicle_compatibilities` (`id`, `product_id`, `brand`, `model`, `year_from`, `year_to`, `engine_type`, `engine_cc`, `fuel_type`, `transmission`, `created_at`, `updated_at`) VALUES
(1, 1, 'Toyota', 'Lancer', 2010, 2023, 'Inline', 2000, 'Diesel', 'Automatic', '2026-02-23 12:01:48', '2026-04-20 15:09:00'),
(2, 2, 'Hyundai', 'Lanzer', 2010, 2023, 'Inline', 2000, 'Diesel', 'Automatic', '2026-02-23 12:01:48', '2026-04-20 15:09:20'),
(3, 3, 'Honda', 'Mazda3', 2012, 2023, 'Rotary', 1000, 'Petrol', 'Automatic', '2026-02-23 12:01:48', '2026-02-23 12:10:53'),
(4, 4, 'Toyota', 'Mazda3', 2013, 2023, 'V-Type', 2000, 'Hybrid', 'Automatic', '2026-02-23 12:01:48', '2026-02-23 12:11:14'),
(5, 5, 'Toyota', 'Lanzer', 2013, 2022, 'V-Type', 1000, 'Petrol', 'Manual', '2026-02-23 12:01:48', '2026-04-20 15:09:59'),
(6, 6, 'Toyota', 'Mazda3', 2009, 2022, 'Rotary', 1500, 'Hybrid', 'Automatic', '2026-02-23 12:01:48', '2026-04-20 15:10:08'),
(7, 7, 'Honda', 'Civic', 2009, 2025, 'Rotary', 1300, 'Diesel', 'Manual', '2026-02-23 12:01:48', '2026-02-23 12:01:48'),
(8, 8, 'Toyota', 'Mazda3', 2006, 2025, 'Rotary', 1300, 'Petrol', 'Automatic', '2026-02-23 12:01:48', '2026-02-23 12:16:32'),
(9, 9, NULL, 'Corolla', 2011, 2021, 'Rotary', 1800, 'Petrol', 'Automatic', '2026-02-23 12:01:48', '2026-04-22 15:42:10'),
(10, 10, 'Nissan', 'Altima', 2013, 2019, 'Inline', 1000, 'Hybrid', 'Automatic', '2026-02-23 12:01:48', '2026-04-20 15:10:21'),
(11, 11, 'Honda', 'Altima', 2011, 2020, 'Rotary', 1300, 'Petrol', 'Manual', '2026-02-23 12:01:48', '2026-02-23 12:17:55'),
(12, 12, NULL, 'Lancer', 2016, 2024, 'Rotary', 1300, 'Petrol', 'Automatic', '2026-02-23 12:01:48', '2026-04-22 15:42:41'),
(13, 13, 'Nissan', 'Mazda3', 2008, 2024, 'V-Type', 1500, 'Hybrid', 'Automatic', '2026-02-23 12:01:48', '2026-02-23 12:18:48'),
(14, 14, 'Honda', 'Lancer', 2015, 2025, 'Inline', 1800, 'Hybrid', 'Manual', '2026-02-23 12:01:48', '2026-02-23 12:19:25'),
(15, 15, NULL, 'Altima', 2011, 2024, 'Rotary', 1000, 'Hybrid', 'Manual', '2026-02-23 12:01:48', '2026-04-22 15:43:35'),
(16, 16, 'Nissan', 'Lancer', 2008, 2023, 'V-Type', 2000, 'Petrol', 'Manual', '2026-02-23 12:01:48', '2026-04-20 15:10:40'),
(17, 17, 'Honda', 'Corolla', 2015, 2021, 'Rotary', 1500, 'Hybrid', 'Automatic', '2026-02-23 12:01:48', '2026-02-23 12:21:25'),
(18, 18, 'Honda', 'Mazda3', 2007, 2025, 'Inline', 1800, 'Hybrid', 'Manual', '2026-02-23 12:01:48', '2026-02-23 12:01:48'),
(19, 19, 'Toyota', 'Civic', 2017, 2019, 'Inline', 1300, 'Hybrid', 'Manual', '2026-02-23 12:01:48', '2026-04-20 15:10:52'),
(20, 20, 'Toyota', 'Corolla', 2016, 2022, 'V-Type', 1300, 'Petrol', 'Automatic', '2026-02-23 12:01:48', '2026-02-23 12:22:39'),
(26, 31, 'Honda', 'CBR 150', 2015, 2023, 'Single Cylinder', 150, 'Petrol', 'Manual', '2026-04-22 15:53:08', '2026-04-22 15:54:34'),
(27, 32, 'Yamaha', 'FZ-S', 2015, 2023, 'Single Cylinder', 150, 'Petrol', 'Manual', '2026-04-22 15:53:08', '2026-04-22 16:00:40'),
(28, 33, 'Bajaj', 'Pulsar 150', 2015, 2023, 'Single Cylinder', 150, 'Petrol', 'Manual', '2026-04-22 15:53:08', '2026-04-22 15:58:44'),
(29, 34, 'Suzuki', 'Gixxer', 2015, 2023, 'Single Cylinder', 155, 'Petrol', 'Manual', '2026-04-22 15:53:08', '2026-04-22 16:02:18'),
(30, 35, 'Honda', 'CD 125', 2015, 2023, 'Single Cylinder', 125, 'Petrol', 'Manual', '2026-04-22 15:53:08', '2026-04-22 16:03:17'),
(31, 36, 'Yamaha', 'R15', 2015, 2023, 'Single Cylinder', 155, 'Petrol', 'Manual', '2026-04-22 15:53:08', '2026-04-22 16:04:38'),
(32, 37, 'TVS', 'Apache RTR', 2015, 2023, 'Single Cylinder', 160, 'Petrol', 'Manual', '2026-04-22 15:53:08', '2026-04-22 16:05:58'),
(33, 38, 'Bajaj', 'Discover 125', 2015, 2023, 'Single Cylinder', 125, 'Petrol', 'Manual', '2026-04-22 15:53:08', '2026-04-22 16:06:40'),
(34, 39, 'Hero', 'Hunk', 2015, 2023, 'Single Cylinder', 150, 'Petrol', 'Manual', '2026-04-22 15:53:08', '2026-04-22 16:07:26'),
(35, 40, 'Honda', 'Hornet 160R', 2015, 2023, 'Single Cylinder', 160, 'Petrol', 'Manual', '2026-04-22 15:53:08', '2026-04-22 16:08:06');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `rating` tinyint(4) NOT NULL DEFAULT 5,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `name`, `email`, `message`, `rating`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ruvidi Weerasinghe', 'ruwindi2819@gmail.com', 'Good!!', 4, 'approved', '2026-03-03 11:26:10', '2026-03-03 11:39:38'),
(2, 4, 'John Doe', 'johndoe@gmail.com', 'Installed this water pump and noticed better cooling performance immediately.', 5, 'approved', '2026-04-22 08:33:19', '2026-04-22 08:33:49');

-- --------------------------------------------------------

--
-- Table structure for table `review_images`
--

CREATE TABLE `review_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `review_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `review_images`
--

INSERT INTO `review_images` (`id`, `review_id`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, '1772556970_69a712aa1ee26.jpg', '2026-03-03 11:26:10', '2026-03-03 11:26:10'),
(2, 1, '1772556970_69a712aa1f9cd.jpg', '2026-03-03 11:26:10', '2026-03-03 11:26:10'),
(3, 2, '1776846799_69e887cff02fb.png', '2026-04-22 08:33:19', '2026-04-22 08:33:19');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('CSNV3QjSk2pCGjxF4J8GH5ufabXSqTqdOxnnFkjg', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWndLZG5HSmhhZGhVYjFyYW44MHQ4TlRPWlVrQnJDWjZjZkt5bzd3diI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg1OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXV0aC9nb29nbGUvY2FsbGJhY2s/YXV0aHVzZXI9MiZjb2RlPTQlMkYwQWNpOThFOVVZSVZCOXhfMUFzUWhZM2FiWFY1dlBXa2RGck9uSFFGeW00UnUtX20tcDY4czlNUDNqZ1o1b3BDREItNVdMUSZpc3M9aHR0cHMlM0ElMkYlMkZhY2NvdW50cy5nb29nbGUuY29tJnByb21wdD1jb25zZW50JnNjb3BlPWVtYWlsJTIwcHJvZmlsZSUyMGh0dHBzJTNBJTJGJTJGd3d3Lmdvb2dsZWFwaXMuY29tJTJGYXV0aCUyRnVzZXJpbmZvLnByb2ZpbGUlMjBodHRwcyUzQSUyRiUyRnd3dy5nb29nbGVhcGlzLmNvbSUyRmF1dGglMkZ1c2VyaW5mby5lbWFpbCUyMG9wZW5pZCZzdGF0ZT1TaDdnSVdiczBDSTBSZG96Q09LRmpjcWg0dzVyanNnT0VySW9qcjFPIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1776661385);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', '2026-03-06 11:23:19', '$2y$12$0aorHw/iX6K/U9LpZPtIz.HZSFK.bKNvO1FA6CeE2fKY3qWJQuNcC', 'jSa7btyH4i', '2026-03-06 11:23:19', '2026-03-06 11:23:19');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `model` varchar(255) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `mileage` int(11) DEFAULT NULL,
  `condition` varchar(255) NOT NULL DEFAULT 'used',
  `fuel_type` varchar(255) DEFAULT NULL,
  `transmission` varchar(255) DEFAULT NULL,
  `engine_cc` int(11) DEFAULT NULL,
  `body_type` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `brand_id`, `model`, `year`, `price`, `mileage`, `condition`, `fuel_type`, `transmission`, `engine_cc`, `body_type`, `color`, `district`, `city`, `description`, `status`, `created_at`, `updated_at`) VALUES
(3, 1, 'Prius', '2017', 9800000.00, 72000, 'used', 'Petrol', 'Automatic', 1800, 'Sedan', 'Pearl White', 'Kurunegala', 'Kurunegala', '<p>✅ Well maintained Toyota Prius 2017 (Hybrid)</p><p>✅ Excellent fuel efficiency with hybrid technology</p><p>✅Smooth and silent driving experience</p><p>✅ Original paint, accident-free vehicle</p><p>✅ Spacious interior with digital display and reverse camera</p><p>✅ Ideal for daily use with low running cost</p><p>✅ Price negotiable after inspection</p>', 1, '2026-04-04 03:09:36', '2026-04-04 08:15:14');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_images`
--

CREATE TABLE `vehicle_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `is_main` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle_images`
--

INSERT INTO `vehicle_images` (`id`, `vehicle_id`, `image_url`, `is_main`, `created_at`, `updated_at`) VALUES
(7, 3, '1775292094_69d0cebe7cc85.jpg', 1, '2026-04-04 03:11:34', '2026-04-04 03:11:34'),
(8, 3, '1775292094_69d0cebe7efc1.jpg', 0, '2026-04-04 03:11:34', '2026-04-04 03:11:34');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_types`
--

CREATE TABLE `vehicle_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle_types`
--

INSERT INTO `vehicle_types` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Car', 1, '2026-04-22 15:22:19', '2026-04-22 15:22:19'),
(2, 'Motorbike', 1, '2026-04-22 15:15:29', '2026-04-22 15:15:29'),
(4, 'Van', 1, '2026-04-22 15:15:29', '2026-04-22 15:15:29'),
(5, 'Lorry', 1, '2026-04-22 15:15:29', '2026-04-22 15:15:29'),
(6, 'Bus', 1, '2026-04-22 15:15:29', '2026-04-22 15:15:29'),
(7, 'Three Wheeler', 1, '2026-04-22 15:15:29', '2026-04-22 15:15:29');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `customer_id`, `session_id`, `product_id`, `created_at`, `updated_at`) VALUES
(2, NULL, '6CqkVTQRcQik22MLOXaQBZzCOR1kE2Y2GV6CGdhg', 3, '2026-03-01 04:59:07', '2026-03-01 04:59:07'),
(3, NULL, '6CqkVTQRcQik22MLOXaQBZzCOR1kE2Y2GV6CGdhg', 8, '2026-03-01 05:02:15', '2026-03-01 05:02:15'),
(4, 1, NULL, 3, '2026-03-01 05:05:53', '2026-03-01 05:05:53'),
(5, NULL, 'Ko4GEXz8j7uvYlssqH4SXkZPwXxJZuTX69nzowNO', 2, '2026-04-05 04:50:12', '2026-04-05 04:50:12'),
(6, NULL, '0ykdA3SFLuWcOzsG9efWplyGtL9tMGq7GB9gbMyW', 1, '2026-04-06 05:53:04', '2026-04-06 05:53:04'),
(7, NULL, 'PkoKdQE7yQ4EvOAimfFmkbTlQv9PAj9pMUoy3yd1', 1, '2026-04-08 08:49:23', '2026-04-08 08:49:23'),
(8, NULL, 'Ltfm0bqmyjLSBejcEzx7UGiFcUICZEivlv5gDQ59', 3, '2026-04-20 12:15:39', '2026-04-20 12:15:39'),
(10, NULL, 'nrL1MJplU5ohzM0TVXtrs4kL35pFlXY3hEOU2yBh', 3, '2026-04-21 08:49:18', '2026-04-21 08:49:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auctions`
--
ALTER TABLE `auctions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auction_bids`
--
ALTER TABLE `auction_bids`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auction_bids_auction_id_foreign` (`auction_id`),
  ADD KEY `auction_bids_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `auction_notifications`
--
ALTER TABLE `auction_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auction_notifications_auction_id_foreign` (`auction_id`),
  ADD KEY `auction_notifications_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_customer_id_index` (`customer_id`),
  ADD KEY `carts_session_id_index` (`session_id`),
  ADD KEY `carts_product_id_index` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

--
-- Indexes for table `customer_activities`
--
ALTER TABLE `customer_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_activities_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD UNIQUE KEY `orders_tracking_no_unique` (`tracking_no`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_vehicle_compatibilities`
--
ALTER TABLE `product_vehicle_compatibilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_vehicle_compatibilities_product_id_foreign` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`);

--
-- Indexes for table `review_images`
--
ALTER TABLE `review_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_images_review_id_foreign` (`review_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicles_brand_id_foreign` (`brand_id`);

--
-- Indexes for table `vehicle_images`
--
ALTER TABLE `vehicle_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicle_images_vehicle_id_foreign` (`vehicle_id`);

--
-- Indexes for table `vehicle_types`
--
ALTER TABLE `vehicle_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlists_customer_id_index` (`customer_id`),
  ADD KEY `wishlists_session_id_index` (`session_id`),
  ADD KEY `wishlists_product_id_index` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auctions`
--
ALTER TABLE `auctions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `auction_bids`
--
ALTER TABLE `auction_bids`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `auction_notifications`
--
ALTER TABLE `auction_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer_activities`
--
ALTER TABLE `customer_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `product_vehicle_compatibilities`
--
ALTER TABLE `product_vehicle_compatibilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `review_images`
--
ALTER TABLE `review_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vehicle_images`
--
ALTER TABLE `vehicle_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vehicle_types`
--
ALTER TABLE `vehicle_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auction_bids`
--
ALTER TABLE `auction_bids`
  ADD CONSTRAINT `auction_bids_auction_id_foreign` FOREIGN KEY (`auction_id`) REFERENCES `auctions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auction_bids_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auction_notifications`
--
ALTER TABLE `auction_notifications`
  ADD CONSTRAINT `auction_notifications_auction_id_foreign` FOREIGN KEY (`auction_id`) REFERENCES `auctions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auction_notifications_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_activities`
--
ALTER TABLE `customer_activities`
  ADD CONSTRAINT `customer_activities_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_vehicle_compatibilities`
--
ALTER TABLE `product_vehicle_compatibilities`
  ADD CONSTRAINT `product_vehicle_compatibilities_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `review_images`
--
ALTER TABLE `review_images`
  ADD CONSTRAINT `review_images_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vehicle_images`
--
ALTER TABLE `vehicle_images`
  ADD CONSTRAINT `vehicle_images_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
