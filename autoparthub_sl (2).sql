-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Jul 02, 2026 at 02:58 PM
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
-- Table structure for table `admin_bank_accounts`
--

CREATE TABLE `admin_bank_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `account_name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_bank_accounts`
--

INSERT INTO `admin_bank_accounts` (`id`, `bank_name`, `branch`, `account_name`, `account_number`, `is_default`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'BOC', 'Ridigama', 'WDKD Weerasekara', '8465232656', 1, NULL, '2026-06-30 09:13:06', '2026-06-30 09:13:06');

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `name`, `email`, `phone`, `password`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Manushi Weerasinghe', 'manuw2819@gmail.com', '0716280393', '$2y$12$26DKm1jf.galinEtDQvEzO2obOqt4U6vZ8//GxzhJW4L5q0x0EvIG', 1, '2026-05-26 08:14:50', '2026-05-26 08:15:06');

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
  `updated_at` timestamp NULL DEFAULT NULL,
  `winner_approved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `auctions`
--

INSERT INTO `auctions` (`id`, `item_type`, `item_id`, `start_time`, `end_time`, `starting_price`, `bid_increment`, `status`, `is_active`, `created_at`, `updated_at`, `winner_approved`) VALUES
(2, 'product', 4, '2026-05-18 09:00:00', '2026-05-21 13:40:00', 15000.00, 1000.00, 'ended', 1, '2026-04-09 15:24:27', '2026-05-21 08:32:41', 1),
(4, 'product', 13, '2026-06-01 14:08:00', '2026-06-15 14:08:00', 50000.00, 2500.00, 'ended', 1, '2026-04-10 08:38:34', '2026-06-23 16:02:49', 0),
(5, 'product', 10, '2026-05-19 09:00:00', '2026-05-20 12:58:00', 4800.00, 100.00, 'ended', 1, '2026-05-19 09:05:53', '2026-05-21 08:07:49', 1),
(6, 'product', 8, '2026-05-20 11:42:00', '2026-05-26 11:42:00', 28000.00, 1000.00, 'ended', 1, '2026-05-20 06:12:19', '2026-05-26 07:51:08', 0);

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
(2, 2, 2, 17000.00, '2026-04-10 19:12:35', 0, '2026-04-10 13:42:35', '2026-04-10 13:42:35'),
(3, 2, 2, 19000.00, '2026-05-19 12:45:37', 0, '2026-05-19 07:15:37', '2026-05-19 07:15:37'),
(4, 2, 2, 20000.00, '2026-05-19 12:46:45', 0, '2026-05-19 07:16:45', '2026-05-19 07:16:45'),
(5, 2, 2, 21000.00, '2026-05-19 12:48:53', 0, '2026-05-19 07:18:53', '2026-05-19 07:18:53'),
(6, 2, 2, 22000.00, '2026-05-19 12:50:10', 0, '2026-05-19 07:20:10', '2026-05-19 07:20:10'),
(7, 2, 2, 23000.00, '2026-05-19 12:52:41', 1, '2026-05-19 07:22:41', '2026-05-21 08:10:21'),
(8, 5, 1, 4900.00, '2026-05-20 11:27:22', 1, '2026-05-20 05:57:22', '2026-05-20 07:28:00');

-- --------------------------------------------------------

--
-- Table structure for table `auction_notifications`
--

CREATE TABLE `auction_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `auction_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('auction_ended','winner_selected','winner_approved','outbid','general') NOT NULL,
  `sent_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `auction_notifications`
--

INSERT INTO `auction_notifications` (`id`, `auction_id`, `customer_id`, `type`, `sent_at`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'auction_ended', '2026-05-20 11:23:08', '2026-05-20 05:53:08', '2026-05-20 05:53:08'),
(2, 2, 2, 'auction_ended', '2026-05-20 11:23:09', '2026-05-20 05:53:09', '2026-05-20 05:53:09'),
(6, 5, 1, 'auction_ended', '2026-05-20 12:58:04', '2026-05-20 07:28:04', '2026-05-20 07:28:04'),
(7, 5, 1, 'winner_approved', '2026-05-21 13:28:40', '2026-05-21 07:58:40', '2026-05-21 07:58:40'),
(8, 2, 2, 'winner_approved', '2026-05-21 13:59:49', '2026-05-21 08:29:49', '2026-05-21 08:29:49');

-- --------------------------------------------------------

--
-- Table structure for table `auction_winners`
--

CREATE TABLE `auction_winners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `auction_id` bigint(20) UNSIGNED NOT NULL,
  `winner_id` bigint(20) UNSIGNED NOT NULL,
  `winner_bid_id` bigint(20) UNSIGNED NOT NULL,
  `winner_price` decimal(12,2) NOT NULL,
  `status` enum('pending_admin_approval','approved','rejected') NOT NULL DEFAULT 'pending_admin_approval',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `auction_winners`
--

INSERT INTO `auction_winners` (`id`, `auction_id`, `winner_id`, `winner_bid_id`, `winner_price`, `status`, `created_at`, `updated_at`, `rejection_reason`) VALUES
(3, 5, 1, 8, 4900.00, 'approved', '2026-05-20 07:28:00', '2026-05-21 07:58:35', NULL),
(4, 2, 2, 7, 23000.00, 'approved', '2026-05-21 08:10:21', '2026-05-21 08:29:45', NULL);

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
  `vendor_commission_percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `parent_id`, `status`, `vendor_commission_percentage`, `created_at`, `updated_at`) VALUES
(1, 'Air Conditioning & Heating', 'uploads/category_images/1777228464_69ee5ab02fe28.jpg', NULL, 1, 8.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(2, 'Air Intake & Fuel Delivery', 'uploads/category_images/1777228516_69ee5ae4868bc.jpg', NULL, 1, 8.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(3, 'Axles & Axle Parts', 'uploads/category_images/1777228554_69ee5b0a59820.jpg', NULL, 1, 7.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(4, 'Battery', 'uploads/category_images/1777228581_69ee5b2542bc3.jpg', NULL, 1, 6.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(5, 'Brakes', 'uploads/category_images/1777228610_69ee5b426dbc0.jpg', NULL, 1, 7.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(6, 'Car Audio Systems', 'uploads/category_images/1777228626_69ee5b5202d5d.png', NULL, 1, 12.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(7, 'Car DVR', 'uploads/category_images/1777228660_69ee5b749bf97.jpg', NULL, 1, 12.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(8, 'Car Tuning & Styling', 'uploads/category_images/1777228706_69ee5ba28a98b.jpg', NULL, 1, 15.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(9, 'Carburetor', 'uploads/category_images/1777228740_69ee5bc4e20e4.jpg', NULL, 1, 8.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(10, 'Chassis', 'uploads/category_images/1777228761_69ee5bd96a268.jpg', NULL, 1, 6.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(11, 'Electrical Components', 'uploads/category_images/1777282980_69ef2fa490cfe.jpg', NULL, 1, 6.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(12, 'Emission Systems', 'uploads/category_images/1777283010_69ef2fc2ee5a7.jpg', NULL, 1, 6.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(13, 'Engine Cooling', 'uploads/category_images/1777283043_69ef2fe340f88.jpg', NULL, 1, 8.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(14, 'Engines & Engine Parts', 'uploads/category_images/1777283069_69ef2ffd4c0b9.jpg', NULL, 1, 7.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(15, 'Exhausts & Exhaust Parts', 'uploads/category_images/1777283110_69ef30268ecc7.jpg', NULL, 1, 8.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(16, 'External & Body Parts', 'uploads/category_images/1777283143_69ef304723d9c.jpg', NULL, 1, 6.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(17, 'External Lights & Indicators', 'uploads/category_images/1777283171_69ef3063ce347.jpg', NULL, 1, 12.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(18, 'Footrests, Pedals & Pegs', 'uploads/category_images/1777283201_69ef3081bb678.jpg', NULL, 1, 5.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(19, 'Freezer', 'uploads/category_images/1777283272_69ef30c85a45e.jpg', NULL, 1, 3.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(20, 'Gauges, Dials & Instruments', 'uploads/category_images/1777283294_69ef30dea9c13.jpg', NULL, 1, 9.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(21, 'Generator', NULL, NULL, 1, 0.00, '2026-04-26 12:57:26', '2026-04-26 12:57:26'),
(22, 'GPS & In-Car Technology', NULL, NULL, 1, 12.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(23, 'Handlebars, Grips & Levers', NULL, NULL, 1, 5.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(24, 'Helmets, Clothing & Protection', NULL, NULL, 1, 5.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(25, 'Interior Parts & Furnishings', NULL, NULL, 1, 6.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(26, 'Lighting & Indicators', NULL, NULL, 1, 12.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(27, 'Mirrors', NULL, NULL, 1, 5.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(28, 'Oils, Lubricants & Fluids', NULL, NULL, 1, 4.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(29, 'Other', NULL, NULL, 1, 3.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(30, 'Reverse Camera', NULL, NULL, 1, 12.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(31, 'Seating', NULL, NULL, 1, 0.00, '2026-04-26 12:57:26', '2026-04-26 12:57:26'),
(32, 'Service Kits', NULL, NULL, 1, 5.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(33, 'Silencer', NULL, NULL, 1, 0.00, '2026-04-26 12:57:26', '2026-04-26 12:57:26'),
(34, 'Solar Panels', NULL, NULL, 1, 3.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(35, 'Starter Motors', NULL, NULL, 1, 7.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(36, 'Stickers', NULL, NULL, 1, 15.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(37, 'Suspension, Steering & Handling', NULL, NULL, 1, 7.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(38, 'Transmission & Drivetrain', NULL, NULL, 1, 7.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(39, 'Turbos & Superchargers', NULL, NULL, 1, 9.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(40, 'Water Pumps', NULL, NULL, 1, 7.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(41, 'Wheels, Tyres & Rims', NULL, NULL, 1, 5.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20'),
(42, 'Windscreen Wipers & Washers', NULL, NULL, 1, 4.00, '2026-04-26 12:57:26', '2026-06-27 17:30:20');

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
(2, 'Kasthurii', 'Dhananjaya', 'kasthurid1234@gmail.com', '0716316143', NULL, 1, '$2y$12$ialXlrJZtnollGjy287fkOnAlumBxf.wbY/UquUjEs7lVdffo1zUi', NULL, NULL, '2026-04-01 22:33:16', '2026-04-26 13:25:44'),
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
(1, 2, 'product_view', 18, NULL, '2026-05-26 09:10:11', '2026-05-26 09:10:11'),
(2, 1, 'vehicle_view', 3, NULL, '2026-05-27 07:38:35', '2026-05-27 07:38:35'),
(3, 1, 'vehicle_view', 3, NULL, '2026-05-27 07:43:04', '2026-05-27 07:43:04'),
(4, 1, 'vehicle_view', 3, NULL, '2026-05-27 07:54:35', '2026-05-27 07:54:35'),
(5, 1, 'vehicle_brand_view', NULL, 'Toyota', '2026-05-27 07:56:00', '2026-05-27 07:56:00'),
(6, 1, 'brand_view', NULL, 'Toyota', '2026-05-27 07:56:34', '2026-05-27 07:56:34'),
(7, 1, 'brand_view', NULL, 'Honda', '2026-05-27 07:56:48', '2026-05-27 07:56:48'),
(8, 1, 'product_view', 17, NULL, '2026-05-27 07:56:51', '2026-05-27 07:56:51'),
(9, 1, 'product_view', 16, NULL, '2026-05-27 07:57:02', '2026-05-27 07:57:02'),
(10, 1, 'product_view', 17, NULL, '2026-05-27 08:30:16', '2026-05-27 08:30:16'),
(11, 1, 'product_view', 21, NULL, '2026-05-27 08:33:18', '2026-05-27 08:33:18'),
(12, 1, 'brand_view', NULL, 'BMW', '2026-05-27 08:44:57', '2026-05-27 08:44:57'),
(13, 1, 'category_view', 1, NULL, '2026-05-27 08:45:37', '2026-05-27 08:45:37'),
(14, 1, 'search', NULL, 'toyota', '2026-05-27 08:46:24', '2026-05-27 08:46:24'),
(15, 1, 'search', NULL, 'Toyo', '2026-05-27 08:47:14', '2026-05-27 08:47:14'),
(16, 1, 'search', NULL, 'Toyota', '2026-05-27 08:47:22', '2026-05-27 08:47:22'),
(17, 1, 'vehicle_brand_view', NULL, 'Toyota', '2026-06-04 10:37:43', '2026-06-04 10:37:43'),
(18, 1, 'vehicle_search', NULL, 'Civic', '2026-06-04 10:42:50', '2026-06-04 10:42:50'),
(19, 1, 'category_view', 5, NULL, '2026-06-06 05:29:33', '2026-06-06 05:29:33'),
(20, 1, 'category_view', 4, NULL, '2026-06-06 05:44:38', '2026-06-06 05:44:38'),
(21, 1, 'category_view', 13, NULL, '2026-06-06 05:44:47', '2026-06-06 05:44:47'),
(22, 1, 'category_view', 6, NULL, '2026-06-06 05:52:48', '2026-06-06 05:52:48'),
(23, 1, 'category_view', 9, NULL, '2026-06-06 05:52:53', '2026-06-06 05:52:53'),
(24, 1, 'category_view', 11, NULL, '2026-06-06 05:55:21', '2026-06-06 05:55:21'),
(25, 1, 'category_view', 21, NULL, '2026-06-06 05:55:41', '2026-06-06 05:55:41'),
(26, 1, 'product_view', 23, NULL, '2026-06-27 16:23:45', '2026-06-27 16:23:45'),
(27, 1, 'product_view', 5, NULL, '2026-06-27 16:27:32', '2026-06-27 16:27:32'),
(28, 1, 'product_view', 20, NULL, '2026-06-28 17:59:15', '2026-06-28 17:59:15'),
(29, 1, 'product_view', 24, NULL, '2026-06-28 18:10:21', '2026-06-28 18:10:21'),
(30, 1, 'product_view', 2, NULL, '2026-06-29 11:50:19', '2026-06-29 11:50:19'),
(31, 1, 'product_view', 12, NULL, '2026-06-29 12:08:45', '2026-06-29 12:08:45'),
(32, 2, 'product_view', 24, NULL, '2026-07-02 12:11:04', '2026-07-02 12:11:04'),
(33, 2, 'product_view', 23, NULL, '2026-07-02 12:11:10', '2026-07-02 12:11:10');

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

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"a481118c-f3ec-4476-81aa-2fe7d075838a\",\"displayName\":\"App\\\\Events\\\\NewAuctionBid\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\NewAuctionBid\\\":1:{s:3:\\\"bid\\\";O:21:\\\"App\\\\Models\\\\AuctionBid\\\":33:{s:13:\\\"\\u0000*\\u0000connection\\\";s:5:\\\"mysql\\\";s:8:\\\"\\u0000*\\u0000table\\\";s:12:\\\"auction_bids\\\";s:13:\\\"\\u0000*\\u0000primaryKey\\\";s:2:\\\"id\\\";s:10:\\\"\\u0000*\\u0000keyType\\\";s:3:\\\"int\\\";s:12:\\\"incrementing\\\";b:1;s:7:\\\"\\u0000*\\u0000with\\\";a:0:{}s:12:\\\"\\u0000*\\u0000withCount\\\";a:0:{}s:19:\\\"preventsLazyLoading\\\";b:0;s:10:\\\"\\u0000*\\u0000perPage\\\";i:15;s:6:\\\"exists\\\";b:1;s:18:\\\"wasRecentlyCreated\\\";b:1;s:28:\\\"\\u0000*\\u0000escapeWhenCastingToString\\\";b:0;s:13:\\\"\\u0000*\\u0000attributes\\\";a:7:{s:10:\\\"auction_id\\\";i:2;s:11:\\\"customer_id\\\";i:2;s:10:\\\"bid_amount\\\";s:5:\\\"20000\\\";s:8:\\\"bid_time\\\";s:19:\\\"2026-05-19 12:46:45\\\";s:10:\\\"updated_at\\\";s:19:\\\"2026-05-19 12:46:45\\\";s:10:\\\"created_at\\\";s:19:\\\"2026-05-19 12:46:45\\\";s:2:\\\"id\\\";i:4;}s:11:\\\"\\u0000*\\u0000original\\\";a:7:{s:10:\\\"auction_id\\\";i:2;s:11:\\\"customer_id\\\";i:2;s:10:\\\"bid_amount\\\";s:5:\\\"20000\\\";s:8:\\\"bid_time\\\";s:19:\\\"2026-05-19 12:46:45\\\";s:10:\\\"updated_at\\\";s:19:\\\"2026-05-19 12:46:45\\\";s:10:\\\"created_at\\\";s:19:\\\"2026-05-19 12:46:45\\\";s:2:\\\"id\\\";i:4;}s:10:\\\"\\u0000*\\u0000changes\\\";a:0:{}s:11:\\\"\\u0000*\\u0000previous\\\";a:0:{}s:8:\\\"\\u0000*\\u0000casts\\\";a:1:{s:8:\\\"bid_time\\\";s:8:\\\"datetime\\\";}s:17:\\\"\\u0000*\\u0000classCastCache\\\";a:0:{}s:21:\\\"\\u0000*\\u0000attributeCastCache\\\";a:0:{}s:13:\\\"\\u0000*\\u0000dateFormat\\\";N;s:10:\\\"\\u0000*\\u0000appends\\\";a:0:{}s:19:\\\"\\u0000*\\u0000dispatchesEvents\\\";a:0:{}s:14:\\\"\\u0000*\\u0000observables\\\";a:0:{}s:12:\\\"\\u0000*\\u0000relations\\\";a:0:{}s:10:\\\"\\u0000*\\u0000touches\\\";a:0:{}s:27:\\\"\\u0000*\\u0000relationAutoloadCallback\\\";N;s:26:\\\"\\u0000*\\u0000relationAutoloadContext\\\";N;s:10:\\\"timestamps\\\";b:1;s:13:\\\"usesUniqueIds\\\";b:0;s:9:\\\"\\u0000*\\u0000hidden\\\";a:0:{}s:10:\\\"\\u0000*\\u0000visible\\\";a:0:{}s:11:\\\"\\u0000*\\u0000fillable\\\";a:5:{i:0;s:10:\\\"auction_id\\\";i:1;s:11:\\\"customer_id\\\";i:2;s:10:\\\"bid_amount\\\";i:3;s:8:\\\"bid_time\\\";i:4;s:9:\\\"is_winner\\\";}s:10:\\\"\\u0000*\\u0000guarded\\\";a:1:{i:0;s:1:\\\"*\\\";}}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1779175006,\"delay\":null}', 0, NULL, 1779175006, 1779175006),
(2, 'default', '{\"uuid\":\"66a12006-2275-439f-903a-768e72d5b2ea\",\"displayName\":\"App\\\\Events\\\\NewAuctionBid\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\NewAuctionBid\\\":1:{s:3:\\\"bid\\\";O:21:\\\"App\\\\Models\\\\AuctionBid\\\":33:{s:13:\\\"\\u0000*\\u0000connection\\\";s:5:\\\"mysql\\\";s:8:\\\"\\u0000*\\u0000table\\\";s:12:\\\"auction_bids\\\";s:13:\\\"\\u0000*\\u0000primaryKey\\\";s:2:\\\"id\\\";s:10:\\\"\\u0000*\\u0000keyType\\\";s:3:\\\"int\\\";s:12:\\\"incrementing\\\";b:1;s:7:\\\"\\u0000*\\u0000with\\\";a:0:{}s:12:\\\"\\u0000*\\u0000withCount\\\";a:0:{}s:19:\\\"preventsLazyLoading\\\";b:0;s:10:\\\"\\u0000*\\u0000perPage\\\";i:15;s:6:\\\"exists\\\";b:1;s:18:\\\"wasRecentlyCreated\\\";b:1;s:28:\\\"\\u0000*\\u0000escapeWhenCastingToString\\\";b:0;s:13:\\\"\\u0000*\\u0000attributes\\\";a:7:{s:10:\\\"auction_id\\\";i:2;s:11:\\\"customer_id\\\";i:2;s:10:\\\"bid_amount\\\";s:5:\\\"20000\\\";s:8:\\\"bid_time\\\";s:19:\\\"2026-05-19 12:46:45\\\";s:10:\\\"updated_at\\\";s:19:\\\"2026-05-19 12:46:45\\\";s:10:\\\"created_at\\\";s:19:\\\"2026-05-19 12:46:45\\\";s:2:\\\"id\\\";i:4;}s:11:\\\"\\u0000*\\u0000original\\\";a:7:{s:10:\\\"auction_id\\\";i:2;s:11:\\\"customer_id\\\";i:2;s:10:\\\"bid_amount\\\";s:5:\\\"20000\\\";s:8:\\\"bid_time\\\";s:19:\\\"2026-05-19 12:46:45\\\";s:10:\\\"updated_at\\\";s:19:\\\"2026-05-19 12:46:45\\\";s:10:\\\"created_at\\\";s:19:\\\"2026-05-19 12:46:45\\\";s:2:\\\"id\\\";i:4;}s:10:\\\"\\u0000*\\u0000changes\\\";a:0:{}s:11:\\\"\\u0000*\\u0000previous\\\";a:0:{}s:8:\\\"\\u0000*\\u0000casts\\\";a:1:{s:8:\\\"bid_time\\\";s:8:\\\"datetime\\\";}s:17:\\\"\\u0000*\\u0000classCastCache\\\";a:0:{}s:21:\\\"\\u0000*\\u0000attributeCastCache\\\";a:0:{}s:13:\\\"\\u0000*\\u0000dateFormat\\\";N;s:10:\\\"\\u0000*\\u0000appends\\\";a:0:{}s:19:\\\"\\u0000*\\u0000dispatchesEvents\\\";a:0:{}s:14:\\\"\\u0000*\\u0000observables\\\";a:0:{}s:12:\\\"\\u0000*\\u0000relations\\\";a:0:{}s:10:\\\"\\u0000*\\u0000touches\\\";a:0:{}s:27:\\\"\\u0000*\\u0000relationAutoloadCallback\\\";N;s:26:\\\"\\u0000*\\u0000relationAutoloadContext\\\";N;s:10:\\\"timestamps\\\";b:1;s:13:\\\"usesUniqueIds\\\";b:0;s:9:\\\"\\u0000*\\u0000hidden\\\";a:0:{}s:10:\\\"\\u0000*\\u0000visible\\\";a:0:{}s:11:\\\"\\u0000*\\u0000fillable\\\";a:5:{i:0;s:10:\\\"auction_id\\\";i:1;s:11:\\\"customer_id\\\";i:2;s:10:\\\"bid_amount\\\";i:3;s:8:\\\"bid_time\\\";i:4;s:9:\\\"is_winner\\\";}s:10:\\\"\\u0000*\\u0000guarded\\\";a:1:{i:0;s:1:\\\"*\\\";}}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1779175006,\"delay\":null}', 0, NULL, 1779175006, 1779175006),
(3, 'default', '{\"uuid\":\"47917646-e14a-4499-ac56-cf9832b9fd1c\",\"displayName\":\"App\\\\Events\\\\NewAuctionBid\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\NewAuctionBid\\\":1:{s:3:\\\"bid\\\";O:21:\\\"App\\\\Models\\\\AuctionBid\\\":33:{s:13:\\\"\\u0000*\\u0000connection\\\";s:5:\\\"mysql\\\";s:8:\\\"\\u0000*\\u0000table\\\";s:12:\\\"auction_bids\\\";s:13:\\\"\\u0000*\\u0000primaryKey\\\";s:2:\\\"id\\\";s:10:\\\"\\u0000*\\u0000keyType\\\";s:3:\\\"int\\\";s:12:\\\"incrementing\\\";b:1;s:7:\\\"\\u0000*\\u0000with\\\";a:0:{}s:12:\\\"\\u0000*\\u0000withCount\\\";a:0:{}s:19:\\\"preventsLazyLoading\\\";b:0;s:10:\\\"\\u0000*\\u0000perPage\\\";i:15;s:6:\\\"exists\\\";b:1;s:18:\\\"wasRecentlyCreated\\\";b:1;s:28:\\\"\\u0000*\\u0000escapeWhenCastingToString\\\";b:0;s:13:\\\"\\u0000*\\u0000attributes\\\";a:7:{s:10:\\\"auction_id\\\";i:2;s:11:\\\"customer_id\\\";i:2;s:10:\\\"bid_amount\\\";s:5:\\\"21000\\\";s:8:\\\"bid_time\\\";s:19:\\\"2026-05-19 12:48:53\\\";s:10:\\\"updated_at\\\";s:19:\\\"2026-05-19 12:48:53\\\";s:10:\\\"created_at\\\";s:19:\\\"2026-05-19 12:48:53\\\";s:2:\\\"id\\\";i:5;}s:11:\\\"\\u0000*\\u0000original\\\";a:7:{s:10:\\\"auction_id\\\";i:2;s:11:\\\"customer_id\\\";i:2;s:10:\\\"bid_amount\\\";s:5:\\\"21000\\\";s:8:\\\"bid_time\\\";s:19:\\\"2026-05-19 12:48:53\\\";s:10:\\\"updated_at\\\";s:19:\\\"2026-05-19 12:48:53\\\";s:10:\\\"created_at\\\";s:19:\\\"2026-05-19 12:48:53\\\";s:2:\\\"id\\\";i:5;}s:10:\\\"\\u0000*\\u0000changes\\\";a:0:{}s:11:\\\"\\u0000*\\u0000previous\\\";a:0:{}s:8:\\\"\\u0000*\\u0000casts\\\";a:1:{s:8:\\\"bid_time\\\";s:8:\\\"datetime\\\";}s:17:\\\"\\u0000*\\u0000classCastCache\\\";a:0:{}s:21:\\\"\\u0000*\\u0000attributeCastCache\\\";a:0:{}s:13:\\\"\\u0000*\\u0000dateFormat\\\";N;s:10:\\\"\\u0000*\\u0000appends\\\";a:0:{}s:19:\\\"\\u0000*\\u0000dispatchesEvents\\\";a:0:{}s:14:\\\"\\u0000*\\u0000observables\\\";a:0:{}s:12:\\\"\\u0000*\\u0000relations\\\";a:0:{}s:10:\\\"\\u0000*\\u0000touches\\\";a:0:{}s:27:\\\"\\u0000*\\u0000relationAutoloadCallback\\\";N;s:26:\\\"\\u0000*\\u0000relationAutoloadContext\\\";N;s:10:\\\"timestamps\\\";b:1;s:13:\\\"usesUniqueIds\\\";b:0;s:9:\\\"\\u0000*\\u0000hidden\\\";a:0:{}s:10:\\\"\\u0000*\\u0000visible\\\";a:0:{}s:11:\\\"\\u0000*\\u0000fillable\\\";a:5:{i:0;s:10:\\\"auction_id\\\";i:1;s:11:\\\"customer_id\\\";i:2;s:10:\\\"bid_amount\\\";i:3;s:8:\\\"bid_time\\\";i:4;s:9:\\\"is_winner\\\";}s:10:\\\"\\u0000*\\u0000guarded\\\";a:1:{i:0;s:1:\\\"*\\\";}}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1779175133,\"delay\":null}', 0, NULL, 1779175133, 1779175133),
(4, 'default', '{\"uuid\":\"1cba0260-1807-4f6f-8741-20a76106743e\",\"displayName\":\"App\\\\Events\\\\NewAuctionBid\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\NewAuctionBid\\\":1:{s:3:\\\"bid\\\";O:21:\\\"App\\\\Models\\\\AuctionBid\\\":33:{s:13:\\\"\\u0000*\\u0000connection\\\";s:5:\\\"mysql\\\";s:8:\\\"\\u0000*\\u0000table\\\";s:12:\\\"auction_bids\\\";s:13:\\\"\\u0000*\\u0000primaryKey\\\";s:2:\\\"id\\\";s:10:\\\"\\u0000*\\u0000keyType\\\";s:3:\\\"int\\\";s:12:\\\"incrementing\\\";b:1;s:7:\\\"\\u0000*\\u0000with\\\";a:0:{}s:12:\\\"\\u0000*\\u0000withCount\\\";a:0:{}s:19:\\\"preventsLazyLoading\\\";b:0;s:10:\\\"\\u0000*\\u0000perPage\\\";i:15;s:6:\\\"exists\\\";b:1;s:18:\\\"wasRecentlyCreated\\\";b:1;s:28:\\\"\\u0000*\\u0000escapeWhenCastingToString\\\";b:0;s:13:\\\"\\u0000*\\u0000attributes\\\";a:7:{s:10:\\\"auction_id\\\";i:2;s:11:\\\"customer_id\\\";i:2;s:10:\\\"bid_amount\\\";s:5:\\\"21000\\\";s:8:\\\"bid_time\\\";s:19:\\\"2026-05-19 12:48:53\\\";s:10:\\\"updated_at\\\";s:19:\\\"2026-05-19 12:48:53\\\";s:10:\\\"created_at\\\";s:19:\\\"2026-05-19 12:48:53\\\";s:2:\\\"id\\\";i:5;}s:11:\\\"\\u0000*\\u0000original\\\";a:7:{s:10:\\\"auction_id\\\";i:2;s:11:\\\"customer_id\\\";i:2;s:10:\\\"bid_amount\\\";s:5:\\\"21000\\\";s:8:\\\"bid_time\\\";s:19:\\\"2026-05-19 12:48:53\\\";s:10:\\\"updated_at\\\";s:19:\\\"2026-05-19 12:48:53\\\";s:10:\\\"created_at\\\";s:19:\\\"2026-05-19 12:48:53\\\";s:2:\\\"id\\\";i:5;}s:10:\\\"\\u0000*\\u0000changes\\\";a:0:{}s:11:\\\"\\u0000*\\u0000previous\\\";a:0:{}s:8:\\\"\\u0000*\\u0000casts\\\";a:1:{s:8:\\\"bid_time\\\";s:8:\\\"datetime\\\";}s:17:\\\"\\u0000*\\u0000classCastCache\\\";a:0:{}s:21:\\\"\\u0000*\\u0000attributeCastCache\\\";a:0:{}s:13:\\\"\\u0000*\\u0000dateFormat\\\";N;s:10:\\\"\\u0000*\\u0000appends\\\";a:0:{}s:19:\\\"\\u0000*\\u0000dispatchesEvents\\\";a:0:{}s:14:\\\"\\u0000*\\u0000observables\\\";a:0:{}s:12:\\\"\\u0000*\\u0000relations\\\";a:0:{}s:10:\\\"\\u0000*\\u0000touches\\\";a:0:{}s:27:\\\"\\u0000*\\u0000relationAutoloadCallback\\\";N;s:26:\\\"\\u0000*\\u0000relationAutoloadContext\\\";N;s:10:\\\"timestamps\\\";b:1;s:13:\\\"usesUniqueIds\\\";b:0;s:9:\\\"\\u0000*\\u0000hidden\\\";a:0:{}s:10:\\\"\\u0000*\\u0000visible\\\";a:0:{}s:11:\\\"\\u0000*\\u0000fillable\\\";a:5:{i:0;s:10:\\\"auction_id\\\";i:1;s:11:\\\"customer_id\\\";i:2;s:10:\\\"bid_amount\\\";i:3;s:8:\\\"bid_time\\\";i:4;s:9:\\\"is_winner\\\";}s:10:\\\"\\u0000*\\u0000guarded\\\";a:1:{i:0;s:1:\\\"*\\\";}}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1779175133,\"delay\":null}', 0, NULL, 1779175133, 1779175133),
(5, 'default', '{\"uuid\":\"6e2c969d-e427-4f2c-b3d8-80322138073b\",\"displayName\":\"App\\\\Events\\\\NewAuctionBid\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\NewAuctionBid\\\":1:{s:3:\\\"bid\\\";O:21:\\\"App\\\\Models\\\\AuctionBid\\\":33:{s:13:\\\"\\u0000*\\u0000connection\\\";s:5:\\\"mysql\\\";s:8:\\\"\\u0000*\\u0000table\\\";s:12:\\\"auction_bids\\\";s:13:\\\"\\u0000*\\u0000primaryKey\\\";s:2:\\\"id\\\";s:10:\\\"\\u0000*\\u0000keyType\\\";s:3:\\\"int\\\";s:12:\\\"incrementing\\\";b:1;s:7:\\\"\\u0000*\\u0000with\\\";a:0:{}s:12:\\\"\\u0000*\\u0000withCount\\\";a:0:{}s:19:\\\"preventsLazyLoading\\\";b:0;s:10:\\\"\\u0000*\\u0000perPage\\\";i:15;s:6:\\\"exists\\\";b:1;s:18:\\\"wasRecentlyCreated\\\";b:1;s:28:\\\"\\u0000*\\u0000escapeWhenCastingToString\\\";b:0;s:13:\\\"\\u0000*\\u0000attributes\\\";a:7:{s:10:\\\"auction_id\\\";i:2;s:11:\\\"customer_id\\\";i:2;s:10:\\\"bid_amount\\\";s:5:\\\"22000\\\";s:8:\\\"bid_time\\\";s:19:\\\"2026-05-19 12:50:10\\\";s:10:\\\"updated_at\\\";s:19:\\\"2026-05-19 12:50:10\\\";s:10:\\\"created_at\\\";s:19:\\\"2026-05-19 12:50:10\\\";s:2:\\\"id\\\";i:6;}s:11:\\\"\\u0000*\\u0000original\\\";a:7:{s:10:\\\"auction_id\\\";i:2;s:11:\\\"customer_id\\\";i:2;s:10:\\\"bid_amount\\\";s:5:\\\"22000\\\";s:8:\\\"bid_time\\\";s:19:\\\"2026-05-19 12:50:10\\\";s:10:\\\"updated_at\\\";s:19:\\\"2026-05-19 12:50:10\\\";s:10:\\\"created_at\\\";s:19:\\\"2026-05-19 12:50:10\\\";s:2:\\\"id\\\";i:6;}s:10:\\\"\\u0000*\\u0000changes\\\";a:0:{}s:11:\\\"\\u0000*\\u0000previous\\\";a:0:{}s:8:\\\"\\u0000*\\u0000casts\\\";a:1:{s:8:\\\"bid_time\\\";s:8:\\\"datetime\\\";}s:17:\\\"\\u0000*\\u0000classCastCache\\\";a:0:{}s:21:\\\"\\u0000*\\u0000attributeCastCache\\\";a:0:{}s:13:\\\"\\u0000*\\u0000dateFormat\\\";N;s:10:\\\"\\u0000*\\u0000appends\\\";a:0:{}s:19:\\\"\\u0000*\\u0000dispatchesEvents\\\";a:0:{}s:14:\\\"\\u0000*\\u0000observables\\\";a:0:{}s:12:\\\"\\u0000*\\u0000relations\\\";a:0:{}s:10:\\\"\\u0000*\\u0000touches\\\";a:0:{}s:27:\\\"\\u0000*\\u0000relationAutoloadCallback\\\";N;s:26:\\\"\\u0000*\\u0000relationAutoloadContext\\\";N;s:10:\\\"timestamps\\\";b:1;s:13:\\\"usesUniqueIds\\\";b:0;s:9:\\\"\\u0000*\\u0000hidden\\\";a:0:{}s:10:\\\"\\u0000*\\u0000visible\\\";a:0:{}s:11:\\\"\\u0000*\\u0000fillable\\\";a:5:{i:0;s:10:\\\"auction_id\\\";i:1;s:11:\\\"customer_id\\\";i:2;s:10:\\\"bid_amount\\\";i:3;s:8:\\\"bid_time\\\";i:4;s:9:\\\"is_winner\\\";}s:10:\\\"\\u0000*\\u0000guarded\\\";a:1:{i:0;s:1:\\\"*\\\";}}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1779175210,\"delay\":null}', 0, NULL, 1779175210, 1779175210),
(6, 'default', '{\"uuid\":\"04168556-a227-4a2a-b8d7-534dd07740a2\",\"displayName\":\"App\\\\Events\\\\NewAuctionBid\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\NewAuctionBid\\\":1:{s:3:\\\"bid\\\";O:21:\\\"App\\\\Models\\\\AuctionBid\\\":33:{s:13:\\\"\\u0000*\\u0000connection\\\";s:5:\\\"mysql\\\";s:8:\\\"\\u0000*\\u0000table\\\";s:12:\\\"auction_bids\\\";s:13:\\\"\\u0000*\\u0000primaryKey\\\";s:2:\\\"id\\\";s:10:\\\"\\u0000*\\u0000keyType\\\";s:3:\\\"int\\\";s:12:\\\"incrementing\\\";b:1;s:7:\\\"\\u0000*\\u0000with\\\";a:0:{}s:12:\\\"\\u0000*\\u0000withCount\\\";a:0:{}s:19:\\\"preventsLazyLoading\\\";b:0;s:10:\\\"\\u0000*\\u0000perPage\\\";i:15;s:6:\\\"exists\\\";b:1;s:18:\\\"wasRecentlyCreated\\\";b:1;s:28:\\\"\\u0000*\\u0000escapeWhenCastingToString\\\";b:0;s:13:\\\"\\u0000*\\u0000attributes\\\";a:7:{s:10:\\\"auction_id\\\";i:2;s:11:\\\"customer_id\\\";i:2;s:10:\\\"bid_amount\\\";s:5:\\\"22000\\\";s:8:\\\"bid_time\\\";s:19:\\\"2026-05-19 12:50:10\\\";s:10:\\\"updated_at\\\";s:19:\\\"2026-05-19 12:50:10\\\";s:10:\\\"created_at\\\";s:19:\\\"2026-05-19 12:50:10\\\";s:2:\\\"id\\\";i:6;}s:11:\\\"\\u0000*\\u0000original\\\";a:7:{s:10:\\\"auction_id\\\";i:2;s:11:\\\"customer_id\\\";i:2;s:10:\\\"bid_amount\\\";s:5:\\\"22000\\\";s:8:\\\"bid_time\\\";s:19:\\\"2026-05-19 12:50:10\\\";s:10:\\\"updated_at\\\";s:19:\\\"2026-05-19 12:50:10\\\";s:10:\\\"created_at\\\";s:19:\\\"2026-05-19 12:50:10\\\";s:2:\\\"id\\\";i:6;}s:10:\\\"\\u0000*\\u0000changes\\\";a:0:{}s:11:\\\"\\u0000*\\u0000previous\\\";a:0:{}s:8:\\\"\\u0000*\\u0000casts\\\";a:1:{s:8:\\\"bid_time\\\";s:8:\\\"datetime\\\";}s:17:\\\"\\u0000*\\u0000classCastCache\\\";a:0:{}s:21:\\\"\\u0000*\\u0000attributeCastCache\\\";a:0:{}s:13:\\\"\\u0000*\\u0000dateFormat\\\";N;s:10:\\\"\\u0000*\\u0000appends\\\";a:0:{}s:19:\\\"\\u0000*\\u0000dispatchesEvents\\\";a:0:{}s:14:\\\"\\u0000*\\u0000observables\\\";a:0:{}s:12:\\\"\\u0000*\\u0000relations\\\";a:0:{}s:10:\\\"\\u0000*\\u0000touches\\\";a:0:{}s:27:\\\"\\u0000*\\u0000relationAutoloadCallback\\\";N;s:26:\\\"\\u0000*\\u0000relationAutoloadContext\\\";N;s:10:\\\"timestamps\\\";b:1;s:13:\\\"usesUniqueIds\\\";b:0;s:9:\\\"\\u0000*\\u0000hidden\\\";a:0:{}s:10:\\\"\\u0000*\\u0000visible\\\";a:0:{}s:11:\\\"\\u0000*\\u0000fillable\\\";a:5:{i:0;s:10:\\\"auction_id\\\";i:1;s:11:\\\"customer_id\\\";i:2;s:10:\\\"bid_amount\\\";i:3;s:8:\\\"bid_time\\\";i:4;s:9:\\\"is_winner\\\";}s:10:\\\"\\u0000*\\u0000guarded\\\";a:1:{i:0;s:1:\\\"*\\\";}}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1779175210,\"delay\":null}', 0, NULL, 1779175210, 1779175210),
(7, 'default', '{\"uuid\":\"9e8f8aa0-39e0-4f87-89ff-5dacbfaf411e\",\"displayName\":\"App\\\\Events\\\\NewAuctionBid\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\NewAuctionBid\\\":1:{s:3:\\\"bid\\\";O:21:\\\"App\\\\Models\\\\AuctionBid\\\":33:{s:13:\\\"\\u0000*\\u0000connection\\\";s:5:\\\"mysql\\\";s:8:\\\"\\u0000*\\u0000table\\\";s:12:\\\"auction_bids\\\";s:13:\\\"\\u0000*\\u0000primaryKey\\\";s:2:\\\"id\\\";s:10:\\\"\\u0000*\\u0000keyType\\\";s:3:\\\"int\\\";s:12:\\\"incrementing\\\";b:1;s:7:\\\"\\u0000*\\u0000with\\\";a:0:{}s:12:\\\"\\u0000*\\u0000withCount\\\";a:0:{}s:19:\\\"preventsLazyLoading\\\";b:0;s:10:\\\"\\u0000*\\u0000perPage\\\";i:15;s:6:\\\"exists\\\";b:1;s:18:\\\"wasRecentlyCreated\\\";b:1;s:28:\\\"\\u0000*\\u0000escapeWhenCastingToString\\\";b:0;s:13:\\\"\\u0000*\\u0000attributes\\\";a:7:{s:10:\\\"auction_id\\\";i:2;s:11:\\\"customer_id\\\";i:2;s:10:\\\"bid_amount\\\";s:5:\\\"23000\\\";s:8:\\\"bid_time\\\";s:19:\\\"2026-05-19 12:52:41\\\";s:10:\\\"updated_at\\\";s:19:\\\"2026-05-19 12:52:41\\\";s:10:\\\"created_at\\\";s:19:\\\"2026-05-19 12:52:41\\\";s:2:\\\"id\\\";i:7;}s:11:\\\"\\u0000*\\u0000original\\\";a:7:{s:10:\\\"auction_id\\\";i:2;s:11:\\\"customer_id\\\";i:2;s:10:\\\"bid_amount\\\";s:5:\\\"23000\\\";s:8:\\\"bid_time\\\";s:19:\\\"2026-05-19 12:52:41\\\";s:10:\\\"updated_at\\\";s:19:\\\"2026-05-19 12:52:41\\\";s:10:\\\"created_at\\\";s:19:\\\"2026-05-19 12:52:41\\\";s:2:\\\"id\\\";i:7;}s:10:\\\"\\u0000*\\u0000changes\\\";a:0:{}s:11:\\\"\\u0000*\\u0000previous\\\";a:0:{}s:8:\\\"\\u0000*\\u0000casts\\\";a:1:{s:8:\\\"bid_time\\\";s:8:\\\"datetime\\\";}s:17:\\\"\\u0000*\\u0000classCastCache\\\";a:0:{}s:21:\\\"\\u0000*\\u0000attributeCastCache\\\";a:0:{}s:13:\\\"\\u0000*\\u0000dateFormat\\\";N;s:10:\\\"\\u0000*\\u0000appends\\\";a:0:{}s:19:\\\"\\u0000*\\u0000dispatchesEvents\\\";a:0:{}s:14:\\\"\\u0000*\\u0000observables\\\";a:0:{}s:12:\\\"\\u0000*\\u0000relations\\\";a:0:{}s:10:\\\"\\u0000*\\u0000touches\\\";a:0:{}s:27:\\\"\\u0000*\\u0000relationAutoloadCallback\\\";N;s:26:\\\"\\u0000*\\u0000relationAutoloadContext\\\";N;s:10:\\\"timestamps\\\";b:1;s:13:\\\"usesUniqueIds\\\";b:0;s:9:\\\"\\u0000*\\u0000hidden\\\";a:0:{}s:10:\\\"\\u0000*\\u0000visible\\\";a:0:{}s:11:\\\"\\u0000*\\u0000fillable\\\";a:5:{i:0;s:10:\\\"auction_id\\\";i:1;s:11:\\\"customer_id\\\";i:2;s:10:\\\"bid_amount\\\";i:3;s:8:\\\"bid_time\\\";i:4;s:9:\\\"is_winner\\\";}s:10:\\\"\\u0000*\\u0000guarded\\\";a:1:{i:0;s:1:\\\"*\\\";}}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1779175361,\"delay\":null}', 0, NULL, 1779175361, 1779175361),
(8, 'default', '{\"uuid\":\"253f1113-cc92-4ad1-a960-e40b63816519\",\"displayName\":\"App\\\\Events\\\\NewAuctionBid\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\NewAuctionBid\\\":1:{s:3:\\\"bid\\\";O:21:\\\"App\\\\Models\\\\AuctionBid\\\":33:{s:13:\\\"\\u0000*\\u0000connection\\\";s:5:\\\"mysql\\\";s:8:\\\"\\u0000*\\u0000table\\\";s:12:\\\"auction_bids\\\";s:13:\\\"\\u0000*\\u0000primaryKey\\\";s:2:\\\"id\\\";s:10:\\\"\\u0000*\\u0000keyType\\\";s:3:\\\"int\\\";s:12:\\\"incrementing\\\";b:1;s:7:\\\"\\u0000*\\u0000with\\\";a:0:{}s:12:\\\"\\u0000*\\u0000withCount\\\";a:0:{}s:19:\\\"preventsLazyLoading\\\";b:0;s:10:\\\"\\u0000*\\u0000perPage\\\";i:15;s:6:\\\"exists\\\";b:1;s:18:\\\"wasRecentlyCreated\\\";b:1;s:28:\\\"\\u0000*\\u0000escapeWhenCastingToString\\\";b:0;s:13:\\\"\\u0000*\\u0000attributes\\\";a:7:{s:10:\\\"auction_id\\\";i:5;s:11:\\\"customer_id\\\";i:1;s:10:\\\"bid_amount\\\";s:4:\\\"4900\\\";s:8:\\\"bid_time\\\";s:19:\\\"2026-05-20 11:27:22\\\";s:10:\\\"updated_at\\\";s:19:\\\"2026-05-20 11:27:22\\\";s:10:\\\"created_at\\\";s:19:\\\"2026-05-20 11:27:22\\\";s:2:\\\"id\\\";i:8;}s:11:\\\"\\u0000*\\u0000original\\\";a:7:{s:10:\\\"auction_id\\\";i:5;s:11:\\\"customer_id\\\";i:1;s:10:\\\"bid_amount\\\";s:4:\\\"4900\\\";s:8:\\\"bid_time\\\";s:19:\\\"2026-05-20 11:27:22\\\";s:10:\\\"updated_at\\\";s:19:\\\"2026-05-20 11:27:22\\\";s:10:\\\"created_at\\\";s:19:\\\"2026-05-20 11:27:22\\\";s:2:\\\"id\\\";i:8;}s:10:\\\"\\u0000*\\u0000changes\\\";a:0:{}s:11:\\\"\\u0000*\\u0000previous\\\";a:0:{}s:8:\\\"\\u0000*\\u0000casts\\\";a:1:{s:8:\\\"bid_time\\\";s:8:\\\"datetime\\\";}s:17:\\\"\\u0000*\\u0000classCastCache\\\";a:0:{}s:21:\\\"\\u0000*\\u0000attributeCastCache\\\";a:0:{}s:13:\\\"\\u0000*\\u0000dateFormat\\\";N;s:10:\\\"\\u0000*\\u0000appends\\\";a:0:{}s:19:\\\"\\u0000*\\u0000dispatchesEvents\\\";a:0:{}s:14:\\\"\\u0000*\\u0000observables\\\";a:0:{}s:12:\\\"\\u0000*\\u0000relations\\\";a:0:{}s:10:\\\"\\u0000*\\u0000touches\\\";a:0:{}s:27:\\\"\\u0000*\\u0000relationAutoloadCallback\\\";N;s:26:\\\"\\u0000*\\u0000relationAutoloadContext\\\";N;s:10:\\\"timestamps\\\";b:1;s:13:\\\"usesUniqueIds\\\";b:0;s:9:\\\"\\u0000*\\u0000hidden\\\";a:0:{}s:10:\\\"\\u0000*\\u0000visible\\\";a:0:{}s:11:\\\"\\u0000*\\u0000fillable\\\";a:5:{i:0;s:10:\\\"auction_id\\\";i:1;s:11:\\\"customer_id\\\";i:2;s:10:\\\"bid_amount\\\";i:3;s:8:\\\"bid_time\\\";i:4;s:9:\\\"is_winner\\\";}s:10:\\\"\\u0000*\\u0000guarded\\\";a:1:{i:0;s:1:\\\"*\\\";}}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1779256643,\"delay\":null}', 0, NULL, 1779256643, 1779256643);

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
(45, '2026_04_22_210617_change_vehicle_type_to_json_in_products_table', 22),
(46, '2026_04_27_003941_add_condition_to_products_table', 23),
(47, '2026_05_20_111401_update_auction_notifications_type_column', 24),
(48, '2026_05_20_122757_create_auction_winners_table', 25),
(49, '2026_05_21_131229_add_winner_approved_to_auctions_table', 26),
(50, '2026_05_21_132028_add_rejection_reason_to_auction_winners_table', 27),
(51, '2026_05_26_133639_create_admin_users_table', 28),
(53, '2026_06_27_134133_create_vendors_table', 29),
(54, '2026_06_27_141401_update_products_table', 30),
(55, '2026_06_27_195459_add_description_and_found_year_to_vendors_table', 31),
(56, '2026_06_27_224523_add_vendor_commission_percentage_to_categories_table', 32),
(57, '2026_06_27_230415_add_vendor_percentage_to_products_table', 33),
(58, '2026_06_27_231000_add_vendor_commission_amount_to_products_table', 34),
(59, '2026_06_27_233929_add_vendor_id_to_order_items_table', 35),
(61, '2026_06_28_231411_add_vendor_commission_fields_to_order_items_table', 36),
(62, '2026_06_28_235001_add_status_tracking_no_to_order_items_table', 37),
(63, '2026_06_29_170704_create_vendor_commissions_table', 38),
(64, '2026_06_29_170712_create_vendor_earnings_table', 38),
(66, '2026_06_30_104732_create_vendor_earning_settlements_table', 39),
(67, '2026_06_30_104823_create_vendor_earning_settlement_items_table', 40),
(68, '2026_06_30_104855_create_vendor_commission_settlements_table', 41),
(69, '2026_06_30_104926_create_vendor_commission_settlement_items_table', 42),
(70, '2026_06_30_142317_create_admin_bank_accounts_table', 43);

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
(1, 1, 'ORD-VJCWYBPW', NULL, 'Manushi', 'Weerasinghe', 'manuw2819@gmail.com', '0716280393', 'No.124, Ridigama, Kurunegala', 'Kurunegala', '60040', 'Sri Lanka', 2500.00, 0.00, 2500.00, 'card', 'confirmed', 'paid', '2026-06-29 12:06:15', '2026-06-29 12:06:51'),
(2, 1, 'ORD-XZFZ5BXH', NULL, 'Manushi', 'Weerasinghe', 'manuw2819@gmail.com', '0716280393', 'No.124, Ridigama, Kurunegala', 'Kurunegala', '60040', 'Sri Lanka', 40470.00, 0.00, 40470.00, 'cod', 'pending', 'pending', '2026-06-29 12:10:07', '2026-06-29 12:10:07'),
(3, 2, 'ORD-NADZXUFZ', NULL, 'Kasthurii', 'Dhananjaya', 'kasthurid1234@gmail.com', '0716316143', 'No.124', 'Ridigama, Kurunegala', '60040', 'Sri Lanka', 6205.00, 0.00, 6205.00, 'cod', 'pending', 'pending', '2026-07-02 12:11:52', '2026-07-02 12:11:52');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `tracking_no` varchar(255) DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vendor_percentage` decimal(5,2) DEFAULT NULL,
  `vendor_commission_amount` decimal(12,2) DEFAULT NULL,
  `vendor_earning_amount` decimal(12,2) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `tracking_no`, `product_id`, `vendor_id`, `vendor_percentage`, `vendor_commission_amount`, `vendor_earning_amount`, `quantity`, `price`, `subtotal`, `status`, `payment_status`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 24, 2, 8.00, 200.00, 2300.00, 1, 2500.00, 2500.00, 'confirmed', 'paid', '2026-06-29 12:06:15', '2026-06-29 12:06:51'),
(2, 2, NULL, 12, 1, 0.00, 0.00, 38000.00, 1, 38000.00, 38000.00, 'pending', 'pending', '2026-06-29 12:10:07', '2026-06-29 12:10:07'),
(3, 2, '12345678', 23, 2, 3.00, 74.10, 2395.90, 2, 1235.00, 2470.00, 'delivered', 'paid', '2026-06-29 12:10:08', '2026-06-30 11:06:53'),
(4, 3, '1234545', 24, 2, 8.00, 200.00, 2300.00, 1, 2500.00, 2500.00, 'confirmed', 'pending', '2026-07-02 12:11:52', '2026-07-02 12:31:36'),
(5, 3, '5654845', 23, 2, 3.00, 111.15, 3593.85, 3, 1235.00, 3705.00, 'confirmed', 'pending', '2026-07-02 12:11:52', '2026-07-02 12:31:53');

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
  `vendor_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vehicle_type_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`vehicle_type_ids`)),
  `price` decimal(10,2) NOT NULL,
  `vendor_percentage` decimal(5,2) DEFAULT NULL,
  `vendor_commission_amount` decimal(12,2) DEFAULT NULL,
  `cost_price` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `small_description` text DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `condition` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `vendor_id`, `category_id`, `name`, `sku`, `brand_id`, `vehicle_type_ids`, `price`, `vendor_percentage`, `vendor_commission_amount`, `cost_price`, `description`, `small_description`, `stock_quantity`, `status`, `condition`, `created_at`, `updated_at`) VALUES
(1, 1, 26, 'HONDA CIVIC SO4/EK/EJ 1996-1998 PRE-FACELIFT HEAD LAMP LH/RH REPLACEMENT PARTS', 'LIG-CAR-0001', 2, '[\"1\"]', 28000.00, NULL, NULL, NULL, '<p><br></p>', NULL, 4, 1, 'Brand New', '2026-04-27 07:16:35', '2026-04-27 07:33:56'),
(2, 1, 14, 'HONDA ACCORD SM4 SV4 CIVIC FERIO SR4 SO4 MANUAL EG EJ EK SPEED METER SENSOR 78410-SM4-000 78410-SY0-000', 'ENG-CAR-0001', 2, '[\"1\"]', 4500.00, NULL, NULL, NULL, '<p>HONDA ACCORD SM4 SV4 CIVIC FERIO SR4 SO4 MANUAL EG EJ EK SPEED METER SENSOR 78410-SM4-000 78410-SY0-000</p>', NULL, 4, 1, 'Brand New', '2026-04-27 07:25:24', '2026-06-29 11:51:03'),
(3, 1, 20, 'Smith Tools Auto LCD Water Temperature & Voltmeter Gauge 2 in 1 With Joint Pipe Adapter 1/8NPT OD 26MM-40MM', 'GAU-CAR-0001', 2, '[\"1\"]', 6500.00, NULL, NULL, NULL, '<p>Smith Tools Auto LCD Water Temperature &amp; Voltmeter Gauge 2 in 1 With Joint Pipe Adapter 1/8NPT OD 26MM-40MM</p>', NULL, 4, 1, 'Brand New', '2026-04-27 08:01:40', '2026-04-27 08:01:40'),
(4, 1, 26, 'MITSUBISHI GALENT A172 TAIL LAMP RH', 'LIG-CAR-0002', 14, '[\"1\"]', 13500.00, NULL, NULL, NULL, '<p>MITSUBISHI GALENT A172 TAIL LAMP RH</p>', NULL, 5, 1, 'Brand New', '2026-04-27 08:04:06', '2026-04-27 08:04:06'),
(5, 1, 14, 'Timing Belt Kit Set for Mitsubishi Lancer CK 4G92 4G93 1.6 1.8 DOCH (NEW) (100,000KM) \'154YU29\'', 'ENG-CAR-0002', 14, '[\"1\"]', 28000.00, NULL, NULL, NULL, '<p>Timing Belt Kit Set for Mitsubishi Lancer CK 4G92 4G93 1.6 1.8 DOCH (NEW) (100,000KM) \'154YU29\'</p>', NULL, 4, 1, 'Brand New', '2026-04-27 08:06:39', '2026-04-27 08:06:39'),
(6, 1, 13, 'Racing Car Greddy FV Blow Off Valve Modified Turbo Pressure Relief Valve Intercooler Wastegate Exhaust Valve', 'ENG-CAR-0003', 14, '[\"1\"]', 12800.00, NULL, NULL, NULL, '<p>Racing Car Greddy FV Blow Off Valve Modified Turbo Pressure Relief Valve Intercooler Wastegate Exhaust Valve</p>', NULL, 5, 1, 'Brand New', '2026-04-27 08:09:16', '2026-04-27 08:09:16'),
(7, 1, 9, '[Local Ready Stock] TOMEI Fuel Pressure Regulator With Gauge Adjustable Type-S (Small Type)', 'CAR-CAR-0001', 2, '[\"1\"]', 9200.00, NULL, NULL, NULL, '<p>[Local Ready Stock] TOMEI Fuel Pressure Regulator With Gauge Adjustable Type-S (Small Type)</p>', NULL, 5, 1, NULL, '2026-04-27 08:10:48', '2026-04-27 08:10:48'),
(8, 1, 37, 'Universal Coilover conversion kit fit Wira Satria Waja Persona Honda EG EK and more Customize Rateadjustable civic', 'SUS-CAR-0001', 2, '[\"1\"]', 28000.00, NULL, NULL, NULL, '<p>Universal Coilover conversion kit fit Wira Satria Waja Persona Honda EG EK and more Customize Rateadjustable civic</p>', NULL, 5, 1, 'Brand New', '2026-04-27 08:12:13', '2026-04-27 08:12:13'),
(9, 1, 25, 'NARDI 14\" LEATHER / MUGEN BALDU /OMP SPORT STEERING WHEEL HONDA CIVIC EG, EK, FD2, FN2, EP3, FC, INTEGRA DC5, DC2, JAZZ GD, GE, GK & CL7', 'INT-CAR-0001', 2, '[\"1\"]', 15849.99, NULL, NULL, NULL, '<p>NARDI 14\" LEATHER / MUGEN BALDU /OMP SPORT STEERING WHEEL HONDA CIVIC EG, EK, FD2, FN2, EP3, FC, INTEGRA DC5, DC2, JAZZ GD, GE, GK &amp; CL7</p>', NULL, 4, 1, 'Brand New', '2026-04-27 08:14:52', '2026-04-27 08:14:52'),
(10, 1, 9, 'pump generator HEP-02A 12V motorcycle universal diesel gasoline electric fuel pump fuel pump generator', 'CAR-CAR-0002', 7, '[\"1\"]', 4800.00, NULL, NULL, NULL, '<p>pump generator HEP-02A 12V motorcycle universal diesel gasoline electric fuel pump fuel pump generator</p>', NULL, 3, 1, 'Brand New', '2026-04-27 08:16:48', '2026-04-27 08:16:48'),
(11, 1, 2, 'ORIGINAL CHARCOAL AIR COND FILTER HONDA ACCORD CIVIC FB FD STREAM CRV ODYSSEY RN6 TAO T2A TRO CABIN CARBON 80292-SDN-A01', 'AIR-CAR-0001', 2, '[\"1\"]', 2400.00, NULL, NULL, NULL, '<p>ORIGINAL CHARCOAL AIR COND FILTER HONDA ACCORD CIVIC FB FD STREAM CRV ODYSSEY RN6 TAO T2A TRO CABIN CARBON 80292-SDN-A01</p>', NULL, 5, 1, NULL, '2026-04-27 08:18:12', '2026-04-27 08:18:12'),
(12, 1, 14, '5 IN 1 SET - ENGINE MOUNTING KIT - HONDA CIVIC 1996 EK3 EK4 EJ7 1.6 SO4 / CRV S10 RD1', 'ENG-CAR-0004', 2, '[\"1\"]', 38000.00, NULL, NULL, NULL, '<p>5 IN 1 SET - ENGINE MOUNTING KIT - HONDA CIVIC 1996 EK3 EK4 EJ7 1.6 SO4 / CRV S10 RD1</p>', NULL, 4, 1, 'Brand New', '2026-04-27 08:33:34', '2026-06-29 12:10:08'),
(13, 1, 14, 'JDM Mugen  Aluminum Engine Oil Cap Fuel Filler Tank Cover for Honda Civic EG EK Blue Red Gold Silver Black', 'ENG-CAR-0005', 2, '[\"1\"]', 1350.00, NULL, NULL, NULL, '<p>JDM Mugen&nbsp;Aluminum Engine Oil Cap Fuel Filler Tank Cover for Honda Civic EG EK Blue Red Gold Silver Black</p>', NULL, 5, 1, 'Brand New', '2026-04-27 08:53:47', '2026-04-27 08:53:47'),
(14, 1, 9, 'HONDA EX5-DREAM CARBURETOR ASSY EX5DREAM', 'CAR-MOTO-0001', 2, '[\"2\"]', 4250.00, NULL, NULL, NULL, '<p>HONDA EX5-DREAM CARBURETOR ASSY EX5DREAM</p>', NULL, 5, 1, 'Brand New', '2026-04-27 09:06:55', '2026-04-27 09:06:55'),
(15, 1, 27, 'HONDA GBO SIDE MIRROR R/L (SKYSHOP) BACK MIRROR C70 PETAK', 'MIR-MOTO-0001', 2, '[\"2\"]', 1300.00, NULL, NULL, NULL, '<p>HONDA GBO SIDE MIRROR R/L (SKYSHOP) BACK MIRROR C70 PETAK</p>', NULL, 7, 1, 'Brand New', '2026-04-27 09:08:26', '2026-04-27 09:08:26'),
(16, 1, 16, 'HONDA EX5 FRONT COVER LEG SHIELD KEPAK SAYAP KEPOK JELLY TINTED STD KEPAK PUTIH', 'EXT-MOTO-0001', 2, '[\"2\"]', 3500.00, NULL, NULL, NULL, '<p>HONDA EX5 FRONT COVER LEG SHIELD KEPAK SAYAP KEPOK JELLY TINTED STD KEPAK PUTIH</p>', NULL, 5, 1, 'Brand New', '2026-04-27 09:09:23', '2026-04-27 09:09:23'),
(17, 1, 16, 'HONDA EX5 / EX5 DREAM BODY COVER SET ( INSTALL STICKER )FREE FRONT FORK COVER REFLECTOR SET DAN GERAH TEPI COVER BATTERY', 'EXT-MOTO-0002', 2, '[\"2\"]', 35000.00, NULL, NULL, NULL, '<p>HONDA EX5 / EX5 DREAM BODY COVER SET ( INSTALL STICKER )FREE FRONT FORK COVER REFLECTOR SET DAN GERAH TEPI COVER BATTERY</p>', NULL, 5, 1, 'Brand New', '2026-04-27 09:10:28', '2026-04-27 09:10:28'),
(18, 1, 29, 'FUEL TANK CAP Y16/Y16ZR/Y15/Y15ZR/LC135/AVANTIZ/SOLARIZ/EGO S LC/NOUVO S LC/EGOS Fi/NVX TANGKI MINYAK PETROL PENUTUP', 'OTH-CAR-0001', 15, '[\"1\"]', 1500.00, NULL, NULL, NULL, '<p>FUEL TANK CAP Y16/Y16ZR/Y15/Y15ZR/LC135/AVANTIZ/SOLARIZ/EGO S LC/NOUVO S LC/EGOS Fi/NVX TANGKI MINYAK PETROL PENUTUP</p>', NULL, 5, 1, 'Brand New', '2026-04-27 09:12:25', '2026-04-27 09:12:25'),
(19, 1, 5, 'YAMAHA FZ150 V1 V2 V3 DISC PLATE WITH BRACKET FZ150I FRONT 320MM', 'BRA-MOTO-0001', 15, '[\"2\"]', 8300.00, NULL, NULL, NULL, '<p>YAMAHA FZ150 V1 V2 V3 DISC PLATE WITH BRACKET FZ150I FRONT 320MM</p>', NULL, 5, 1, 'Brand New', '2026-04-27 09:13:30', '2026-04-27 09:13:30'),
(20, 1, 14, 'Yamaha R25 (250) - Starter Motor Unit', 'ENG-MOTO-0001', 15, '[\"2\"]', 8500.00, NULL, NULL, NULL, '<p>Yamaha R25 (250) - Starter Motor Unit</p>', NULL, 4, 1, NULL, '2026-04-27 09:14:28', '2026-06-28 18:00:12'),
(21, 1, 5, 'FREE FRONT FORK COVER REFLECTOR SET DAN GERAH TEPI COVER BATTERY', 'BRA-CAR-0001', 1, '[\"1\"]', 35000.00, NULL, NULL, NULL, '<p>jytrjrtjtrj</p>', 'htrhtrj', 4, 1, 'Used', '2026-05-27 08:19:48', '2026-05-27 08:30:31'),
(22, 1, 1, 'new', 'AIR-CAR-0002', 1, '[\"1\"]', 55855.00, NULL, NULL, 5252.00, '<p>htjtj</p>', 'grht', 2, 1, 'Brand New', '2026-06-27 10:27:40', '2026-06-27 10:28:05'),
(23, 2, 29, 'new vendor part', 'AIR-CAR-0003', 2, '[\"1\"]', 1235.00, 3.00, 37.05, 5656.00, '<p>hthyhyhh</p>', 'htrjhty', 2, 1, 'Brand New', '2026-06-27 10:33:43', '2026-07-02 12:11:52'),
(24, 2, 1, 'Part Vendor', 'AIR-CAR-0004', 2, '[\"1\"]', 2500.00, 8.00, 200.00, NULL, '<p><br></p>', NULL, 4, 1, 'Brand New', '2026-06-27 17:52:21', '2026-07-02 12:11:52');

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
(1, 1, '1777274273_69ef0da1d8539.jpeg', 1, '2026-04-27 07:17:53', '2026-04-27 07:17:53'),
(2, 1, '1777274273_69ef0da1d9bee.jpeg', 0, '2026-04-27 07:17:53', '2026-04-27 07:17:53'),
(3, 1, '1777274273_69ef0da1da872.jpeg', 0, '2026-04-27 07:17:53', '2026-04-27 07:17:53'),
(4, 2, '1777274731_69ef0f6b7d8b8.jpeg', 1, '2026-04-27 07:25:31', '2026-04-27 07:25:31'),
(5, 2, '1777274731_69ef0f6b7f753.jpeg', 0, '2026-04-27 07:25:31', '2026-04-27 07:25:31'),
(6, 3, '1777276923_69ef17fbed3ab.jpeg', 1, '2026-04-27 08:02:03', '2026-04-27 08:02:03'),
(7, 3, '1777276923_69ef17fbef452.jpeg', 0, '2026-04-27 08:02:03', '2026-04-27 08:02:03'),
(8, 3, '1777276923_69ef17fbefe06.jpeg', 0, '2026-04-27 08:02:03', '2026-04-27 08:02:03'),
(9, 4, '1777277060_69ef18840948c.jpeg', 1, '2026-04-27 08:04:20', '2026-04-27 08:04:20'),
(10, 4, '1777277060_69ef18840b38c.jpeg', 0, '2026-04-27 08:04:20', '2026-04-27 08:04:20'),
(11, 5, '1777277214_69ef191e8f11f.jpeg', 1, '2026-04-27 08:06:54', '2026-04-27 08:06:54'),
(12, 6, '1777277364_69ef19b426f11.jpeg', 1, '2026-04-27 08:09:24', '2026-04-27 08:09:24'),
(13, 6, '1777277364_69ef19b428bed.jpeg', 0, '2026-04-27 08:09:24', '2026-04-27 08:09:24'),
(14, 7, '1777277464_69ef1a18a97fe.jpeg', 1, '2026-04-27 08:11:04', '2026-04-27 08:11:04'),
(15, 7, '1777277464_69ef1a18ab716.jpeg', 0, '2026-04-27 08:11:04', '2026-04-27 08:11:04'),
(16, 8, '1777277540_69ef1a64ea495.jpeg', 1, '2026-04-27 08:12:20', '2026-04-27 08:12:20'),
(17, 8, '1777277540_69ef1a64ec074.jpeg', 0, '2026-04-27 08:12:20', '2026-04-27 08:12:20'),
(18, 9, '1777277697_69ef1b01619d9.jpeg', 1, '2026-04-27 08:14:57', '2026-04-27 08:14:57'),
(19, 10, '1777277814_69ef1b76ae677.jpeg', 1, '2026-04-27 08:16:54', '2026-04-27 08:16:54'),
(20, 10, '1777277814_69ef1b76b0497.jpeg', 0, '2026-04-27 08:16:54', '2026-04-27 08:16:54'),
(21, 11, '1777277899_69ef1bcb9a0bc.jpeg', 1, '2026-04-27 08:18:19', '2026-04-27 08:18:19'),
(22, 11, '1777277899_69ef1bcb9be77.jpeg', 0, '2026-04-27 08:18:19', '2026-04-27 08:18:19'),
(23, 12, '1777278834_69ef1f72a37db.jpeg', 1, '2026-04-27 08:33:54', '2026-04-27 08:33:54'),
(24, 13, '1777280034_69ef24225d3a0.jpeg', 1, '2026-04-27 08:53:54', '2026-04-27 08:53:54'),
(25, 14, '1777280833_69ef2741a7ca6.jpeg', 1, '2026-04-27 09:07:13', '2026-04-27 09:07:13'),
(26, 14, '1777280833_69ef2741a9af6.jpeg', 0, '2026-04-27 09:07:13', '2026-04-27 09:07:13'),
(27, 15, '1777280911_69ef278fd44ee.jpeg', 1, '2026-04-27 09:08:31', '2026-04-27 09:08:31'),
(28, 16, '1777280968_69ef27c828b69.jpeg', 1, '2026-04-27 09:09:28', '2026-04-27 09:09:28'),
(29, 17, '1777281035_69ef280ba5ed1.jpeg', 1, '2026-04-27 09:10:35', '2026-04-27 09:10:35'),
(30, 17, '1777281035_69ef280ba7de8.jpeg', 0, '2026-04-27 09:10:35', '2026-04-27 09:10:35'),
(31, 17, '1777281035_69ef280ba878c.jpeg', 0, '2026-04-27 09:10:35', '2026-04-27 09:10:35'),
(32, 18, '1777281150_69ef287e41978.jpeg', 1, '2026-04-27 09:12:30', '2026-04-27 09:12:30'),
(33, 19, '1777281222_69ef28c69d1a8.jpeg', 1, '2026-04-27 09:13:42', '2026-04-27 09:13:42'),
(34, 19, '1777281222_69ef28c69e7ff.jpeg', 0, '2026-04-27 09:13:42', '2026-04-27 09:13:42'),
(35, 20, '1777281292_69ef290cd2efb.jpeg', 1, '2026-04-27 09:14:52', '2026-04-27 09:14:52'),
(36, 20, '1777281292_69ef290cd4d53.jpeg', 0, '2026-04-27 09:14:52', '2026-04-27 09:14:52'),
(37, 21, '1779870012_6a16a93c09a9e.jpg', 1, '2026-05-27 08:20:12', '2026-05-27 08:20:12'),
(38, 23, '1782556438_6a3fa71617a48.png', 1, '2026-06-27 10:33:58', '2026-06-27 10:33:58'),
(39, 23, '1782556438_6a3fa71618dc7.png', 0, '2026-06-27 10:33:58', '2026-06-27 10:33:58');

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
(1, 1, 'Honda', 'CIVIC SO4/EK', 1998, NULL, NULL, NULL, NULL, NULL, '2026-04-27 07:16:36', '2026-04-27 07:33:56'),
(2, 2, 'Honda', 'CIVIC FERIO', 2000, NULL, NULL, NULL, NULL, 'Manual', '2026-04-27 07:25:24', '2026-04-27 07:33:34'),
(3, 3, 'Honda', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-27 08:01:40', '2026-04-27 08:01:40'),
(4, 4, 'Mitsubishi', 'Lancer', NULL, NULL, '4G12', 1400, NULL, NULL, '2026-04-27 08:04:06', '2026-04-27 08:04:06'),
(5, 5, 'Mitsubishi', 'Lancer', 1998, NULL, NULL, 1500, 'Petrol', NULL, '2026-04-27 08:06:39', '2026-04-27 08:06:48'),
(6, 6, 'Mitsubishi', 'Lancer', 2002, NULL, NULL, 1500, 'Petrol', NULL, '2026-04-27 08:09:16', '2026-04-27 08:09:16'),
(7, 7, 'Honda', 'Civic', NULL, NULL, NULL, 1500, 'Petrol', NULL, '2026-04-27 08:10:48', '2026-04-27 08:10:48'),
(8, 8, 'Honda', 'Civic', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-27 08:12:13', '2026-04-27 08:12:13'),
(9, 9, 'Honda', 'Civic', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-27 08:14:52', '2026-04-27 08:14:52'),
(10, 10, 'Nissan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-27 08:16:48', '2026-04-27 08:16:48'),
(11, 11, 'Honda', 'Civic', 1998, NULL, NULL, 1500, 'Petrol', NULL, '2026-04-27 08:18:12', '2026-04-27 08:18:12'),
(12, 12, 'Honda', 'Civic', 1996, NULL, NULL, NULL, NULL, NULL, '2026-04-27 08:33:34', '2026-04-27 08:33:34'),
(13, 13, 'Honda', 'Civic', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-27 08:53:47', '2026-04-27 08:53:47'),
(14, 14, 'Honda', 'EX5', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-27 09:06:55', '2026-04-27 09:07:08'),
(15, 15, 'Honda', 'EX5', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-27 09:08:26', '2026-04-27 09:08:26'),
(16, 16, 'Honda', 'EX5', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-27 09:09:23', '2026-04-27 09:09:23'),
(17, 17, 'Honda', 'EX5', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-27 09:10:28', '2026-04-27 09:10:28'),
(18, 18, 'Yamaha', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-27 09:12:25', '2026-04-27 09:12:25'),
(19, 19, 'Yamaha', 'FZ', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-27 09:13:30', '2026-04-27 09:13:30'),
(20, 20, 'Yamaha', 'R25', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-27 09:14:28', '2026-04-27 09:14:48'),
(21, 21, 'Toyota', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-27 08:19:48', '2026-05-27 08:19:48'),
(22, 22, 'Toyota', 'Lancer', 222, NULL, NULL, NULL, NULL, NULL, '2026-06-27 10:27:40', '2026-06-27 10:27:40'),
(23, 23, 'Honda', 'Civic', 2021, NULL, NULL, NULL, NULL, NULL, '2026-06-27 10:33:43', '2026-06-27 10:33:43'),
(24, 24, 'Honda', 'Lancer', 2008, NULL, NULL, NULL, NULL, NULL, '2026-06-27 17:52:21', '2026-06-27 17:52:21');

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
(3, 20, 'Manushi Weerasinghe', 'manuw2819@gmail.com', 'Good product', 5, 'approved', '2026-05-19 05:05:12', '2026-05-19 05:05:20'),
(4, 21, 'Manushi Weerasinghe', 'manuw2819@gmail.com', 'grgr', 5, 'approved', '2026-06-04 10:59:43', '2026-06-04 10:59:49'),
(5, 23, 'Shone Weerasinghe', 'shone@gmail.com', 'Good Product', 5, 'approved', '2026-06-28 17:33:23', '2026-06-28 17:41:01');

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
(4, 14, 'Lancer Box 1400', NULL, 1075000.00, NULL, 'used', 'Petrol', NULL, 1398, NULL, 'Red', 'Kurunegala', 'Rideegama', '<p>#Lancer Box 1400 ♥️</p><p>Original Book📕&nbsp;</p><p>Documents clear 💯✔️</p><p>License insurance updated&nbsp;</p><p>All A/C parts have</p><p>&nbsp;&nbsp;&nbsp;&nbsp;📌Engine &amp; Running 💯</p><p>&nbsp;&nbsp;&nbsp; 📌Paint condition 💯&nbsp;</p><p>&nbsp;&nbsp;&nbsp; 📌Good body condition&nbsp;</p><p>No tinkering&nbsp;</p><p>Good tyre condition ☑️</p><p>All lights working perfectly&nbsp;</p><p>1L to -15 km ⛽️</p><p>Price- 10.75negotiable&nbsp;</p><p>Location- Kurunegala,Rideegama&nbsp;</p><p>Tp- 0716316143 ( call 📞 or WhatsApp)</p><p>0️⃣7️⃣1️⃣6️⃣3️⃣1️⃣6️⃣1️⃣4️⃣3️⃣☎️</p>', 1, '2026-06-23 16:05:22', '2026-06-23 16:05:22');

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
(9, 4, '1782230730_6a3aaecad7c38.jpeg', 1, '2026-06-23 16:05:30', '2026-06-23 16:05:30'),
(10, 4, '1782230730_6a3aaecad9a72.jpeg', 0, '2026-06-23 16:05:30', '2026-06-23 16:05:30'),
(11, 4, '1782230730_6a3aaecada58a.jpeg', 0, '2026-06-23 16:05:30', '2026-06-23 16:05:30'),
(12, 4, '1782230730_6a3aaecadb473.jpeg', 0, '2026-06-23 16:05:30', '2026-06-23 16:05:30');

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
(1, 'Car', 1, '2026-04-27 06:13:58', '2026-04-27 06:13:58'),
(2, 'Motor Bike', 1, '2026-04-27 06:14:11', '2026-04-27 06:14:11');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `owner_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `nic` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `district` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `branch_name` varchar(255) DEFAULT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `nic_front` varchar(255) DEFAULT NULL,
  `nic_back` varchar(255) DEFAULT NULL,
  `business_registration` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `found_year` year(4) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected','Suspended') NOT NULL DEFAULT 'Pending',
  `approved_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `shop_name`, `slug`, `owner_name`, `email`, `phone`, `nic`, `address`, `district`, `province`, `bank_name`, `branch_name`, `account_name`, `account_number`, `logo`, `banner`, `nic_front`, `nic_back`, `business_registration`, `description`, `found_year`, `status`, `approved_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Autoparthubsl', 'autoparthubsl', 'Kasthuri Dhananjaya', 'kasthurid1234@gmail.com', '0716316143', '200073203633', 'Ridigama', 'Kurunegala', 'North Western', NULL, NULL, NULL, NULL, 'uploads/vendors/1782578513_logo.png', NULL, NULL, NULL, NULL, 'Your trusted automotive marketplace for vehicles and spare parts, featuring direct sales and auction integration for a smarter buying experience. ', '2021', 'Approved', '2026-06-27 08:58:37', '$2y$12$7k4rM6vSbDUsfe5OerAnwu1YglN1ZnLaKlSxrZNDrzaVwhLYYWbbu', NULL, '2026-06-27 08:58:37', '2026-06-28 17:32:19'),
(2, 'Honda Parts', 'honda-parts-1782551366', 'M. Weerasinghe', 'manuw2819@gmail.com', '0716280393', '200073203555', 'No.124', 'Kurunegala', 'North Western', 'BOC', 'Ridigama', 'KGRSM Weerasinghe', '8465232656', 'uploads/vendors/1782555684_logo.png', NULL, '', '', '12345678', NULL, '2025', 'Approved', '2026-06-27 09:26:13', '$2y$12$n7Ol5GJ8/EU.reZ18F2CKOyGmj5DYP4zo9NHw5pJkmasLsoQPrnFe', NULL, '2026-06-27 09:09:26', '2026-06-27 14:30:44');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_commissions`
--

CREATE TABLE `vendor_commissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `commission_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','paid','not_applicable','cancelled') NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `settled_by` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor_commissions`
--

INSERT INTO `vendor_commissions` (`id`, `order_id`, `order_item_id`, `vendor_id`, `product_id`, `payment_method`, `commission_amount`, `status`, `paid_at`, `settled_by`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 24, 'card', 200.00, 'paid', '2026-06-30 07:54:24', NULL, NULL, '2026-06-29 12:06:15', '2026-06-30 07:54:24'),
(2, 2, 2, 1, 12, 'cod', 0.00, 'pending', NULL, NULL, NULL, '2026-06-29 12:10:08', '2026-06-29 12:10:08'),
(3, 2, 3, 2, 23, 'cod', 74.10, 'paid', NULL, NULL, NULL, '2026-06-29 12:10:08', '2026-06-30 09:32:19'),
(4, 3, 4, 2, 24, 'cod', 200.00, 'pending', NULL, NULL, NULL, '2026-07-02 12:11:52', '2026-07-02 12:11:52'),
(5, 3, 5, 2, 23, 'cod', 111.15, 'pending', NULL, NULL, NULL, '2026-07-02 12:11:52', '2026-07-02 12:11:52');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_commission_settlements`
--

CREATE TABLE `vendor_commission_settlements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method` enum('card','cod') NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `payment_slip` varchar(255) DEFAULT NULL,
  `transfer_reference` varchar(255) DEFAULT NULL,
  `status` enum('submitted','paid','rejected') NOT NULL DEFAULT 'paid',
  `period_start` date NOT NULL,
  `period_end` date NOT NULL,
  `submitted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor_commission_settlements`
--

INSERT INTO `vendor_commission_settlements` (`id`, `vendor_id`, `payment_method`, `total_amount`, `payment_slip`, `transfer_reference`, `status`, `period_start`, `period_end`, `submitted_by`, `submitted_at`, `reviewed_by`, `reviewed_at`, `rejection_reason`, `created_at`, `updated_at`) VALUES
(1, 2, 'card', 200.00, NULL, NULL, 'paid', '2026-06-29', '2026-06-29', NULL, NULL, 0, '2026-06-30 07:54:24', NULL, '2026-06-30 07:54:24', '2026-06-30 07:54:24'),
(2, 2, 'cod', 74.10, 'uploads/vendor-commissions/1782811657_cod_slip.png', NULL, 'paid', '2026-06-29', '2026-06-29', 2, '2026-06-30 09:27:37', 0, '2026-06-30 09:32:19', NULL, '2026-06-30 09:27:37', '2026-06-30 09:32:19');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_commission_settlement_items`
--

CREATE TABLE `vendor_commission_settlement_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `settlement_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_commission_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor_commission_settlement_items`
--

INSERT INTO `vendor_commission_settlement_items` (`id`, `settlement_id`, `vendor_commission_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-06-30 07:54:24', '2026-06-30 07:54:24'),
(2, 2, 3, '2026-06-30 09:27:37', '2026-06-30 09:27:37');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_earnings`
--

CREATE TABLE `vendor_earnings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `earning_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','paid','self_collected','cancelled') NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `paid_by` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor_earnings`
--

INSERT INTO `vendor_earnings` (`id`, `order_id`, `order_item_id`, `vendor_id`, `product_id`, `payment_method`, `earning_amount`, `status`, `paid_at`, `paid_by`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 24, 'card', 2300.00, 'paid', '2026-06-30 16:34:01', NULL, NULL, '2026-06-29 12:06:15', '2026-06-30 07:21:01'),
(2, 2, 2, 1, 12, 'cod', 38000.00, 'pending', NULL, NULL, NULL, '2026-06-29 12:10:08', '2026-06-29 12:10:08'),
(3, 2, 3, 2, 23, 'cod', 2395.90, 'pending', NULL, NULL, NULL, '2026-06-29 12:10:08', '2026-06-29 12:10:08'),
(4, 3, 4, 2, 24, 'cod', 2300.00, 'pending', NULL, NULL, NULL, '2026-07-02 12:11:52', '2026-07-02 12:11:52'),
(5, 3, 5, 2, 23, 'cod', 3593.85, 'pending', NULL, NULL, NULL, '2026-07-02 12:11:52', '2026-07-02 12:11:52');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_earning_settlements`
--

CREATE TABLE `vendor_earning_settlements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `transfer_reference` varchar(255) DEFAULT NULL,
  `payment_slip` varchar(255) DEFAULT NULL,
  `period_start` date NOT NULL,
  `period_end` date NOT NULL,
  `paid_by` bigint(20) UNSIGNED NOT NULL,
  `paid_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor_earning_settlements`
--

INSERT INTO `vendor_earning_settlements` (`id`, `vendor_id`, `total_amount`, `transfer_reference`, `payment_slip`, `period_start`, `period_end`, `paid_by`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES
(1, 2, 2300.00, NULL, 'uploads/vendor-earnings/1782804061_slip.png', '2026-06-29', '2026-06-29', 0, '2026-06-30 07:33:33', NULL, '2026-06-30 07:21:01', '2026-06-30 07:21:01');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_earning_settlement_items`
--

CREATE TABLE `vendor_earning_settlement_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `settlement_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_earning_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor_earning_settlement_items`
--

INSERT INTO `vendor_earning_settlement_items` (`id`, `settlement_id`, `vendor_earning_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-06-30 07:21:01', '2026-06-30 07:21:01');

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
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_bank_accounts`
--
ALTER TABLE `admin_bank_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_users_email_unique` (`email`);

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
-- Indexes for table `auction_winners`
--
ALTER TABLE `auction_winners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auction_winners_auction_id_foreign` (`auction_id`),
  ADD KEY `auction_winners_winner_id_foreign` (`winner_id`),
  ADD KEY `auction_winners_winner_bid_id_foreign` (`winner_bid_id`);

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
  ADD KEY `order_items_product_id_foreign` (`product_id`),
  ADD KEY `order_items_vendor_id_index` (`vendor_id`);

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
  ADD KEY `products_brand_id_foreign` (`brand_id`),
  ADD KEY `products_vendor_id_index` (`vendor_id`);

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
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vendors_slug_unique` (`slug`),
  ADD UNIQUE KEY `vendors_email_unique` (`email`),
  ADD UNIQUE KEY `vendors_nic_unique` (`nic`);

--
-- Indexes for table `vendor_commissions`
--
ALTER TABLE `vendor_commissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vendor_commissions_order_item_id_unique` (`order_item_id`),
  ADD KEY `vendor_commissions_order_id_foreign` (`order_id`),
  ADD KEY `vendor_commissions_product_id_foreign` (`product_id`),
  ADD KEY `vendor_commissions_vendor_id_status_index` (`vendor_id`,`status`);

--
-- Indexes for table `vendor_commission_settlements`
--
ALTER TABLE `vendor_commission_settlements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_commission_settlements_vendor_id_foreign` (`vendor_id`);

--
-- Indexes for table `vendor_commission_settlement_items`
--
ALTER TABLE `vendor_commission_settlement_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_commission_settlement_items_settlement_id_foreign` (`settlement_id`),
  ADD KEY `vendor_commission_settlement_items_vendor_commission_id_foreign` (`vendor_commission_id`);

--
-- Indexes for table `vendor_earnings`
--
ALTER TABLE `vendor_earnings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vendor_earnings_order_item_id_unique` (`order_item_id`),
  ADD KEY `vendor_earnings_order_id_foreign` (`order_id`),
  ADD KEY `vendor_earnings_product_id_foreign` (`product_id`),
  ADD KEY `vendor_earnings_vendor_id_status_index` (`vendor_id`,`status`);

--
-- Indexes for table `vendor_earning_settlements`
--
ALTER TABLE `vendor_earning_settlements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_earning_settlements_vendor_id_foreign` (`vendor_id`);

--
-- Indexes for table `vendor_earning_settlement_items`
--
ALTER TABLE `vendor_earning_settlement_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vesi_settle_vendor_unique` (`settlement_id`,`vendor_earning_id`),
  ADD KEY `vendor_earning_settlement_items_vendor_earning_id_foreign` (`vendor_earning_id`);

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
-- AUTO_INCREMENT for table `admin_bank_accounts`
--
ALTER TABLE `admin_bank_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `auctions`
--
ALTER TABLE `auctions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `auction_bids`
--
ALTER TABLE `auction_bids`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `auction_notifications`
--
ALTER TABLE `auction_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `auction_winners`
--
ALTER TABLE `auction_winners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer_activities`
--
ALTER TABLE `customer_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `product_vehicle_compatibilities`
--
ALTER TABLE `product_vehicle_compatibilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vehicle_images`
--
ALTER TABLE `vehicle_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `vehicle_types`
--
ALTER TABLE `vehicle_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vendor_commissions`
--
ALTER TABLE `vendor_commissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vendor_commission_settlements`
--
ALTER TABLE `vendor_commission_settlements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vendor_commission_settlement_items`
--
ALTER TABLE `vendor_commission_settlement_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vendor_earnings`
--
ALTER TABLE `vendor_earnings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vendor_earning_settlements`
--
ALTER TABLE `vendor_earning_settlements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vendor_earning_settlement_items`
--
ALTER TABLE `vendor_earning_settlement_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `auction_winners`
--
ALTER TABLE `auction_winners`
  ADD CONSTRAINT `auction_winners_auction_id_foreign` FOREIGN KEY (`auction_id`) REFERENCES `auctions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auction_winners_winner_bid_id_foreign` FOREIGN KEY (`winner_bid_id`) REFERENCES `auction_bids` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auction_winners_winner_id_foreign` FOREIGN KEY (`winner_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `vendor_commissions`
--
ALTER TABLE `vendor_commissions`
  ADD CONSTRAINT `vendor_commissions_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vendor_commissions_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vendor_commissions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vendor_commissions_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vendor_commission_settlements`
--
ALTER TABLE `vendor_commission_settlements`
  ADD CONSTRAINT `vendor_commission_settlements_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vendor_commission_settlement_items`
--
ALTER TABLE `vendor_commission_settlement_items`
  ADD CONSTRAINT `vendor_commission_settlement_items_settlement_id_foreign` FOREIGN KEY (`settlement_id`) REFERENCES `vendor_commission_settlements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vendor_commission_settlement_items_vendor_commission_id_foreign` FOREIGN KEY (`vendor_commission_id`) REFERENCES `vendor_commissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vendor_earnings`
--
ALTER TABLE `vendor_earnings`
  ADD CONSTRAINT `vendor_earnings_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vendor_earnings_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vendor_earnings_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vendor_earnings_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vendor_earning_settlements`
--
ALTER TABLE `vendor_earning_settlements`
  ADD CONSTRAINT `vendor_earning_settlements_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vendor_earning_settlement_items`
--
ALTER TABLE `vendor_earning_settlement_items`
  ADD CONSTRAINT `vendor_earning_settlement_items_settlement_id_foreign` FOREIGN KEY (`settlement_id`) REFERENCES `vendor_earning_settlements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vendor_earning_settlement_items_vendor_earning_id_foreign` FOREIGN KEY (`vendor_earning_id`) REFERENCES `vendor_earnings` (`id`) ON DELETE CASCADE;

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
