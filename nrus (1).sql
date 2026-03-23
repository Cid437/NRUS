-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2026 at 02:25 AM
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
-- Database: `nrus`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Yamaha', 'schimmel-bahringer-and-friesen-660', '2026-03-21 01:38:42', '2026-03-21 01:38:42'),
(2, 'Fender', 'spencer-becker-79', '2026-03-21 01:38:42', '2026-03-21 01:38:42'),
(3, 'Gibson', 'torp-and-sons-641', '2026-03-21 01:38:42', '2026-03-21 01:38:42');

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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'String', 'tenetur-536', '2026-03-21 01:38:42', '2026-03-21 01:38:42'),
(2, 'Percussion', 'est-66', '2026-03-21 01:38:42', '2026-03-21 01:38:42'),
(3, 'Brass', 'deserunt-543', '2026-03-21 01:38:42', '2026-03-21 01:38:42');

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
(3, '0001_01_02_000000_add_user_fields', 1),
(4, '0001_01_03_000000_create_categories_brands_products', 1),
(5, '0001_01_04_000000_create_product_photos', 1),
(6, '0001_01_05_000000_create_reviews', 1),
(7, '0001_01_06_000000_create_transactions_and_items', 1),
(8, '2026_03_10_000001_create_products_crud_table', 1),
(9, '2026_03_21_092439_create_sessions_table', 1),
(10, '2026_03_22_123015_drop_category_column_from_products_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `brand_id`, `name`, `slug`, `description`, `price`, `stock`, `is_active`, `deleted_at`, `created_at`, `updated_at`) VALUES
(17, 1, 1, 'Yamaha C40 Classical Guitar', 'yamaha-c40-classical-guitar', NULL, 5980.00, 10, 1, NULL, '2026-03-21 01:57:54', '2026-03-22 11:49:05'),
(18, 1, 2, 'Fender FA-25 Dreadnought Acoustic Guitar', 'fender-fa-25-dreadnought-acoustic-guitar', NULL, 9600.00, 10, 1, NULL, '2026-03-21 04:43:12', '2026-03-22 08:09:54'),
(19, 1, 2, 'Fender ESC-105 Educational Series Classical Guitar', 'fender-esc-105-educational-series-classical-guitar', NULL, 10800.00, 10, 1, NULL, '2026-03-21 04:44:31', '2026-03-22 08:11:21'),
(20, 1, 3, 'Gibson Electric Guitar Les Paul Studio', 'gibson-les-paul-studio', NULL, 181000.00, 5, 1, NULL, '2026-03-22 00:46:10', '2026-03-22 08:13:37'),
(21, 1, 3, 'Gibson Les Paul Custom', 'gibson-les-paul-custom', NULL, 334000.00, 2, 1, NULL, '2026-03-22 04:23:32', '2026-03-22 08:15:21'),
(22, 1, 1, 'Yamaha F310 Acoustic Guitar', 'yamaha-f310-acoustic-guitar', NULL, 10950.00, 9, 1, NULL, '2026-03-22 08:05:41', '2026-03-22 11:43:25'),
(23, 2, 1, 'Yamaha Stage Custom Birch Drum Set', 'yamaha-stage-custom-birch-drum-set', NULL, 80000.00, 10, 1, NULL, '2026-03-22 08:17:09', '2026-03-22 08:17:09'),
(24, 2, 1, 'Yamaha DD-75 Digital Percussion Drum Set', 'yamaha-dd-75-digital-percussion-drum-set', NULL, 21000.00, 20, 1, NULL, '2026-03-22 08:19:12', '2026-03-22 08:19:12'),
(25, 2, 2, 'Gretsch Energy Drum Set', 'gretsch-energy-drum-set', NULL, 25000.00, 19, 1, NULL, '2026-03-22 08:23:58', '2026-03-22 11:43:25'),
(26, 2, 2, 'Latin Percussion Aspire Cajon', 'latin-percussion-aspire-cajon', NULL, 5000.00, 50, 1, NULL, '2026-03-22 08:26:07', '2026-03-22 08:26:07'),
(27, 3, 1, 'Yamaha YTR-2330 Bb Trumpet', 'yamaha-ytr-2330-bb-trumpet', NULL, 35000.00, 10, 1, NULL, '2026-03-22 08:27:57', '2026-03-22 08:27:57'),
(28, 3, 1, 'Yamaha YAS-280 Alto Saxophone', 'yamaha-yas-280-alto-saxophone', NULL, 75000.00, 10, 1, NULL, '2026-03-22 08:29:14', '2026-03-22 08:29:14'),
(29, 3, 3, 'tests', 'test', NULL, 1.00, 1, 1, '2026-03-22 10:11:46', NULL, '2026-03-22 10:11:46');

-- --------------------------------------------------------

--
-- Table structure for table `product_photos`
--

CREATE TABLE `product_photos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_photos`
--

INSERT INTO `product_photos` (`id`, `product_id`, `file`, `is_primary`, `created_at`, `updated_at`) VALUES
(25, 22, 'products/AToqUMtVvhmYNz97kOD75umDpajFvoItsGqBUZ4V.jpg', 1, '2026-03-22 08:05:41', '2026-03-22 08:05:41'),
(26, 22, 'products/tu04fYptTEeWOBdcsDZ06PVTEJz3yYpcFZz6pR0U.jpg', 0, '2026-03-22 08:05:41', '2026-03-22 08:05:41'),
(29, 18, 'products/N161QxgnrsOZfzRvgGlJMM12opaXBHpHu4gfyCDw.jpg', 1, '2026-03-22 08:09:54', '2026-03-22 08:09:54'),
(30, 18, 'products/lRs7ZhtHx9YFi2mumBopWg87vb9HmQIQSJVj0ria.jpg', 0, '2026-03-22 08:09:54', '2026-03-22 08:09:54'),
(31, 19, 'products/UVhWI08WWIcnlwPurAmyfyDN6d2QdUHyWSLaeqXH.jpg', 1, '2026-03-22 08:11:21', '2026-03-22 08:11:21'),
(32, 19, 'products/SgA3zXniwdF3qRtcVFrQ8kexUPH8s8oufmwZjbWM.jpg', 0, '2026-03-22 08:11:21', '2026-03-22 08:11:21'),
(33, 20, 'products/JRgpbS1gdLqR398Xz3fW3oyHtnLesuvEkY9vfr4x.jpg', 1, '2026-03-22 08:13:37', '2026-03-22 08:13:37'),
(34, 20, 'products/nTGazclEGPbtvzPGCbCx6UebnW2CCfqBWdL3QJE5.jpg', 0, '2026-03-22 08:13:37', '2026-03-22 08:13:37'),
(35, 21, 'products/7OtuiLGjkPZ8igOWLTEUQSd5lWfd3hMgnxSzirtV.jpg', 1, '2026-03-22 08:15:21', '2026-03-22 08:15:21'),
(36, 21, 'products/Aw1AGaPy3PPBssTOnNOobCZMArIYOZfWCcKSvJOa.jpg', 0, '2026-03-22 08:15:21', '2026-03-22 08:15:21'),
(37, 23, 'products/93baO3G3mqRgQDuHmvoMkB0p2ngpSiDvLrWBwxeE.jpg', 1, '2026-03-22 08:17:09', '2026-03-22 08:17:09'),
(38, 23, 'products/t0dcrprWgpgb2nWuPf9BgYF5ZugmT3ckMD8icRQd.jpg', 0, '2026-03-22 08:17:09', '2026-03-22 08:17:09'),
(39, 24, 'products/1sS0MawkI4faaDQsVOkn8hHGBtzDWDdEAvg0jf8a.jpg', 1, '2026-03-22 08:19:12', '2026-03-22 08:19:12'),
(40, 24, 'products/rZo27r8jRzfotG0Jb0tDeeRAIQTSm4ndtwlUGpWL.jpg', 0, '2026-03-22 08:19:12', '2026-03-22 08:19:12'),
(41, 25, 'products/W7ECOG48SEnywYtZQUmVHsQJ7isaf4JqvSkrrW8c.jpg', 1, '2026-03-22 08:23:58', '2026-03-22 08:23:58'),
(42, 25, 'products/iRhclifyDuA4X4l6Wnp7jLaKRW9iXWfRkq9TGq9W.jpg', 0, '2026-03-22 08:23:58', '2026-03-22 08:23:58'),
(43, 26, 'products/T0FMy4WkaaZHpGe9L8zPQ7to2Xmul8iyQ6zIAOma.jpg', 1, '2026-03-22 08:26:07', '2026-03-22 08:26:07'),
(44, 26, 'products/Tj9m9yfU9U3h0TOEL8YfpoMy2b5JTElQIhjxreFk.jpg', 0, '2026-03-22 08:26:07', '2026-03-22 08:26:07'),
(45, 27, 'products/u3mAH5lTqBJjN5rO286HzYKNzAhiOPpBTw706eSQ.jpg', 1, '2026-03-22 08:27:57', '2026-03-22 08:27:57'),
(46, 27, 'products/pvM6eWpf6FM3uj1j7dPvkDTlfQBPm7ylxhqCHN62.jpg', 0, '2026-03-22 08:27:57', '2026-03-22 08:27:57'),
(47, 28, 'products/xIwqeYmh1yv3z0F43Uy94NYUrcPCPmerXUXu8QyU.jpg', 1, '2026-03-22 08:29:14', '2026-03-22 08:29:14'),
(48, 28, 'products/yKM6ElvzYcprrD6Rldvt4RlVTsQUk6epLDF8I0UA.jpg', 0, '2026-03-22 08:29:14', '2026-03-22 08:29:14'),
(49, 17, 'products/YF9yM17lbNuiqMBYYlaCJBNQdxyrP8M7kkkneRDb.jpg', 1, '2026-03-22 08:43:17', '2026-03-22 08:43:17'),
(50, 17, 'products/vjKJSlXZIlCEWT31try9eKCUi0uVLS1rRBdKBBeR.jpg', 0, '2026-03-22 08:43:17', '2026-03-22 08:43:17');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(4) NOT NULL DEFAULT 5,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(6, 7, 20, 5, 'ganda naman', NULL, '2026-03-22 10:17:52'),
(7, 7, 18, 5, 'sakto lang', NULL, '2026-03-22 10:18:30'),
(8, 7, 25, 5, 'nice', NULL, '2026-03-22 11:45:41');

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
('IsVrfoULbAOg3kKpKIbv4sQpOJ0DgO0Y7hIRHBTv', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiamp3NFFBMXFSSjhQSWgyVjdOdks2Y3ZqRUNOczlrT0xiOXk1MVltZSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ob21lIjt9fQ==', 1774226968),
('M2HXlcpKbg90FSvSQf8X0nDbyvSPppszndm7SnEm', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWHRoMU9oSFNaMGlkRzh0REdTQXZ4RFQ4S3M4OUhucVg2Tk9CZEJheCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi91c2VycyI7czo1OiJyb3V0ZSI7czoxNzoiYWRtaW4udXNlcnMuaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1774211719),
('pQpVtITMKlnHUQrNtpbWYmw3v4KlEW9PhxUm2Ke9', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM29zd2haOE10anJUcFZZMWd3aEdRWkZWUkVPbnBWTVpNdUhGNm1WMCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czoxMDoic2hvcC5pbmRleCI7fX0=', 1774212414),
('uaiZdYYBtUG9VtCRCKPHkYENygDvOkE7HHlrerdL', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicTZadkh3NlJQbjZsTGliVkxxN1E0NnllQUZxb1NtWlVqc3U2NnM5YSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czoxMDoic2hvcC5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774229071);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `receipt_path` varchar(255) DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `total`, `status`, `receipt_path`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 2, 132.83, 'completed', NULL, '2026-03-21 23:50:19', '2026-03-21 01:38:42', '2026-03-21 23:50:19'),
(2, 2, 339.48, 'completed', NULL, '2026-03-21 01:38:42', '2026-03-21 01:38:42', '2026-03-21 01:38:42'),
(3, 2, 189.35, 'completed', NULL, '2026-03-21 01:38:42', '2026-03-21 01:38:42', '2026-03-21 01:38:42'),
(4, 7, 120.00, 'completed', 'receipts/txn_4.pdf', '2026-03-22 00:25:47', '2026-03-21 05:05:44', '2026-03-22 00:25:47'),
(5, 7, 60.00, 'completed', 'receipts/txn_5.pdf', '2026-03-21 08:00:09', '2026-03-21 06:22:46', '2026-03-21 08:00:09'),
(6, 8, 120.00, 'completed', 'receipts/txn_6.pdf', '2026-03-22 00:45:00', '2026-03-22 00:31:23', '2026-03-22 00:45:00'),
(7, 7, 60.00, 'completed', 'receipts/txn_7.pdf', '2026-03-22 01:14:59', '2026-03-22 01:13:03', '2026-03-22 01:14:59'),
(8, 7, 60.00, 'completed', 'receipts/txn_8.pdf', '2026-03-22 03:00:37', '2026-03-22 02:59:28', '2026-03-22 03:00:37'),
(9, 7, 5980.00, 'completed', NULL, '2026-03-22 10:24:58', '2026-03-22 10:19:46', '2026-03-22 10:24:58'),
(10, 7, 35950.00, 'completed', 'receipts/txn_10.pdf', '2026-03-22 11:43:25', '2026-03-22 10:32:04', '2026-03-22 11:43:25'),
(11, 7, 75000.00, 'processing', 'receipts/txn_11.pdf', '2026-03-22 11:41:22', '2026-03-22 11:41:22', '2026-03-22 11:41:22');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_items`
--

CREATE TABLE `transaction_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_items`
--

INSERT INTO `transaction_items` (`id`, `transaction_id`, `product_id`, `quantity`, `unit_price`, `created_at`, `updated_at`) VALUES
(4, 4, 17, 2, 60.00, '2026-03-21 05:05:44', '2026-03-21 05:05:44'),
(5, 5, 18, 1, 60.00, '2026-03-21 06:22:46', '2026-03-21 06:22:46'),
(6, 6, 19, 2, 60.00, '2026-03-22 00:31:23', '2026-03-22 00:31:23'),
(7, 7, 20, 1, 60.00, '2026-03-22 01:13:03', '2026-03-22 01:13:03'),
(8, 8, 20, 1, 60.00, '2026-03-22 02:59:28', '2026-03-22 02:59:28'),
(9, 9, 17, 1, 5980.00, '2026-03-22 10:19:46', '2026-03-22 10:19:46'),
(10, 10, 25, 1, 25000.00, '2026-03-22 10:32:04', '2026-03-22 10:32:04'),
(11, 10, 22, 1, 10950.00, '2026-03-22 10:32:04', '2026-03-22 10:32:04'),
(12, 11, 28, 1, 75000.00, '2026-03-22 11:41:22', '2026-03-22 11:41:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `photo`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@example.com', 'admin', '2026-03-21 01:38:41', '$2y$12$PCCblHLKhzCCVZZda7na5ewyIRuFafGxBamdl1imx9qg0i87gXIMW', NULL, 1, 'k1tMS6QSdOxXDvmZ0mVh4NXwN2rFjkWg02gFe3vmPJkLUoJdKMxlSlxuZFjJ', '2026-03-21 01:38:42', '2026-03-21 01:38:42'),
(2, 'Ms. Elfrieda Flatley V', 'armand78@example.com', 'user', '2026-03-21 01:38:42', '$2y$12$.qPnrDBIEUynl/U0gzoCLeU.VGdM2tLjJ.h2lu8aIxAIElnohZQfy', NULL, 1, 't4qMXIGmtb', '2026-03-21 01:38:42', '2026-03-21 02:08:49'),
(3, 'Jackeline Torp', 'kemmer.darian@example.org', 'user', '2026-03-21 01:38:42', '$2y$12$meSHP8Lj2hzwhnygsonP6.8MU0pj/gLNj3/LUIPfKIk5KtNOWlFw2', NULL, 1, 'YnKpE3h6IZ', '2026-03-21 01:38:42', '2026-03-21 01:38:42'),
(4, 'Van Schultz', 'vosinski@example.net', 'user', '2026-03-21 01:38:42', '$2y$12$meSHP8Lj2hzwhnygsonP6.8MU0pj/gLNj3/LUIPfKIk5KtNOWlFw2', NULL, 1, 'KhpW9uNiPs', '2026-03-21 01:38:42', '2026-03-21 01:38:42'),
(5, 'Prof. Jarrell Bernier', 'jaskolski.annamarie@example.net', 'user', '2026-03-21 01:38:42', '$2y$12$meSHP8Lj2hzwhnygsonP6.8MU0pj/gLNj3/LUIPfKIk5KtNOWlFw2', NULL, 1, 'Uhfsg3DALH', '2026-03-21 01:38:42', '2026-03-21 01:38:42'),
(6, 'Eileen Bergstrom', 'lois.kassulke@example.net', 'user', '2026-03-21 01:38:42', '$2y$12$meSHP8Lj2hzwhnygsonP6.8MU0pj/gLNj3/LUIPfKIk5KtNOWlFw2', NULL, 1, 'TOKxJhtuc6', '2026-03-21 01:38:42', '2026-03-21 01:38:42'),
(7, 'Cyrus Pagayunan', 'pagayunancyrus@gmail.com', 'user', '2026-03-21 04:35:00', '$2y$12$TBzTCmqFNhXQFOTI2tMbC.xB41zAeRLkQI1uhia4E.vTMudwE6bUa', 'user_photos/SPo6ar6QApNz2OYRct0pwvYdVMgtqMRWKZmXWbYn.jpg', 1, NULL, '2026-03-21 04:27:22', '2026-03-22 09:59:33'),
(8, 'emman', 'emman@gmail.com', 'user', '2026-03-22 00:01:27', '$2y$12$In5N1wAGAbu3a1Gz5daSTekwwHQ6KkDqlZb4Z6cLSrGIHM/GXI6QC', NULL, 0, NULL, '2026-03-21 04:52:27', '2026-03-22 01:09:37'),
(9, 'cy', 'cy@e', 'user', NULL, '$2y$12$Q5Dxd5iaQTSIyHjxe15WHedji32Tqrmmjs8yDSrDU/uKoSXF3n3am', NULL, 1, NULL, '2026-03-22 08:38:00', '2026-03-22 08:38:00'),
(12, 'test', 'test@1', 'user', '2026-03-22 11:44:01', '$2y$12$h.GyXqJS1aAwBtx/AwNLD.VGmDjr5o.PV2pXZD50F4v7zFYT0w8f6', NULL, 1, NULL, '2026-03-22 11:43:51', '2026-03-22 11:44:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_slug_unique` (`slug`);

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
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`);

--
-- Indexes for table `product_photos`
--
ALTER TABLE `product_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_photos_product_id_foreign` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_user_id_foreign` (`user_id`);

--
-- Indexes for table `transaction_items`
--
ALTER TABLE `transaction_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_items_transaction_id_foreign` (`transaction_id`),
  ADD KEY `transaction_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `product_photos`
--
ALTER TABLE `product_photos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `transaction_items`
--
ALTER TABLE `transaction_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_photos`
--
ALTER TABLE `product_photos`
  ADD CONSTRAINT `product_photos_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaction_items`
--
ALTER TABLE `transaction_items`
  ADD CONSTRAINT `transaction_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_items_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
