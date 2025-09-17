-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2025 at 09:05 AM
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
-- Database: `fdb_main`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2024-01-15-000001', 'App\\Database\\Migrations\\AddGoogleFieldsToUsers', 'default', 'App', 1757839050, 1);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `author_name` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `author_name`, `title`, `content`, `image`, `created_at`) VALUES
(1, 'test name', 'tezt title', 'content test', NULL, '2025-06-19 16:07:07'),
(2, 'name', 'title', 'content', NULL, '2025-06-19 16:39:21'),
(3, 'test name', 'yjynn', 'sdwdw', NULL, '2025-06-20 09:34:45'),
(4, 'user123', 'ganon tagala', 'gaon takaga', NULL, '2025-06-20 11:33:51'),
(5, 'testing name', 'testing no edit anon', 'im an anonymous user so no edit', NULL, '2025-06-20 11:34:30'),
(6, 'anonymous 072625', 'anonymous 072625', 'anonymous 072625', NULL, '2025-07-26 11:22:10'),
(7, 'user123', 'Edit Ft', 'Ito ay art', '1758079015_4b06b0ee57c2e893d64e.png', '2025-09-17 11:16:55'),
(8, 'user123', 'edited yown', 'eyown', '1758086872_6c4008b24cbe75afa464.png', '2025-09-17 13:27:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `google_name` varchar(255) DEFAULT NULL,
  `google_picture` text DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `alert_email_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `alert_min_probability` decimal(5,2) NOT NULL DEFAULT 50.00,
  `alert_restrict_to_red` tinyint(1) NOT NULL DEFAULT 1,
  `last_login_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `google_id`, `google_name`, `google_picture`, `email_verified_at`, `password`, `role`, `created_at`, `updated_at`, `is_active`, `alert_email_enabled`, `alert_min_probability`, `alert_restrict_to_red`, `last_login_at`) VALUES
(1, 'admin', 'atest@gmail.com', NULL, NULL, NULL, NULL, '$2y$10$hUFpZcCHSO8H6A89v.6RIu0kmuNKoMcGhT1CqU3e0Xg0LuWRO47wa', 'admin', '2025-07-26 13:41:59', '2025-09-13 17:45:48', 1, 1, 50.00, 1, NULL),
(3, 'admin1', 'btest@gmail.com', NULL, NULL, NULL, NULL, '$2y$10$5g8iShR49bYfoVmwEavu7ukHxX/UX4jDpuarhSD5hbFgj8ZKNvjPW', 'admin', '2025-07-26 13:41:59', '2025-09-13 17:45:56', 1, 1, 50.00, 1, NULL),
(4, 'user123', 'sampol@sanbida.edu.ph', NULL, NULL, NULL, NULL, '$2y$10$5ig/CvJwwR8f2m7ckuDoBOb4Ci0AH7Bc.FfeuBu/kTDPFL5rQOanO', 'user', '2025-07-26 13:41:59', '2025-09-12 17:40:14', 1, 1, 50.00, 1, NULL),
(5, '0726251343', 'jer99@gmail.com', '35436346456', 'Jer Rald', 'https://lh3.googleusercontent.com/a/ACg8ocK_0VpYVPZIbnmVMDPw8k65UPWdnX3wBbqnrBkQ9cKjU4a3nAif=s96-c', NULL, '$2y$10$EKjvzoNYBX3TltYb7vBLF.dm/PdY/Z8zRL660kpNZi46hpYJKssxi', 'user', '2025-07-26 05:43:42', '2025-09-14 09:12:39', 1, 1, 50.00, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_locations`
--

CREATE TABLE `user_locations` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `lat` decimal(9,6) NOT NULL,
  `lon` decimal(9,6) NOT NULL,
  `hazard_level` enum('RED','ORANGE','YELLOW','GREEN') DEFAULT NULL,
  `last_checked_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_locations`
--

INSERT INTO `user_locations` (`id`, `user_id`, `lat`, `lon`, `hazard_level`, `last_checked_at`) VALUES
(1, 4, 14.663680, 121.123635, 'GREEN', '2025-09-16 04:28:22'),
(2, 5, 14.664684, 121.101940, 'GREEN', '2025-09-14 09:14:43');

-- --------------------------------------------------------

--
-- Table structure for table `weather_daily`
--

CREATE TABLE `weather_daily` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `lat` decimal(8,5) DEFAULT NULL,
  `lon` decimal(8,5) DEFAULT NULL,
  `weather_code` smallint(6) DEFAULT NULL,
  `rain_sum_mm` decimal(5,2) DEFAULT NULL,
  `precipitation_hours` decimal(4,1) DEFAULT NULL,
  `temp_max_c` decimal(4,1) DEFAULT NULL,
  `temp_min_c` decimal(4,1) DEFAULT NULL,
  `river_discharge_m3s` decimal(7,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `weather_daily`
--

INSERT INTO `weather_daily` (`id`, `date`, `lat`, `lon`, `weather_code`, `rain_sum_mm`, `precipitation_hours`, `temp_max_c`, `temp_min_c`, `river_discharge_m3s`, `created_at`) VALUES
(6, '2025-07-14', 14.65729, 121.11524, 95, 0.00, 16.0, 31.7, 26.6, 29.06, '2025-07-16 07:01:37'),
(7, '2025-07-15', 14.65729, 121.11524, 96, 0.00, 17.0, 30.9, 26.5, 33.12, '2025-07-16 07:01:37'),
(12, '2025-07-16', 14.65729, 121.11524, 95, 0.00, 21.0, 31.0, 26.0, 34.48, '2025-07-18 07:31:57'),
(22, '2025-07-17', 14.65729, 121.11524, 96, 1.30, 20.0, 29.6, 25.9, 40.40, '2025-07-19 13:59:22'),
(27, '2025-07-18', 14.65729, 121.11524, 95, 5.70, 24.0, 27.3, 25.7, 41.46, '2025-07-20 03:03:53'),
(28, '2025-07-19', 14.65729, 121.11524, 95, 19.40, 24.0, 27.1, 25.4, 98.08, '2025-07-20 03:03:53'),
(29, '2025-07-20', 14.65729, 121.11524, 80, 0.00, 24.0, 30.1, 26.0, 172.78, '2025-07-20 03:03:53'),
(30, '2025-07-21', 14.65729, 121.11524, 95, 0.00, 23.0, 29.0, 25.7, 186.50, '2025-07-20 03:03:53'),
(31, '2025-07-22', 14.65729, 121.11524, 95, 0.00, 21.0, 29.1, 24.7, 180.13, '2025-07-20 03:03:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `uq_users_email` (`email`),
  ADD UNIQUE KEY `google_id` (`google_id`);

--
-- Indexes for table `user_locations`
--
ALTER TABLE `user_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ul_user` (`user_id`);

--
-- Indexes for table `weather_daily`
--
ALTER TABLE `weather_daily`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_idx` (`date`,`lat`,`lon`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_locations`
--
ALTER TABLE `user_locations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `weather_daily`
--
ALTER TABLE `weather_daily`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_locations`
--
ALTER TABLE `user_locations`
  ADD CONSTRAINT `fk_ul_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
