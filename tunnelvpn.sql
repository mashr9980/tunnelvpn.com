-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 30, 2024 at 09:52 AM
-- Server version: 8.0.39-cll-lve
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `appapist_tunnelvpn`
--

-- --------------------------------------------------------

--
-- Table structure for table `dedicated_ip`
--

CREATE TABLE `dedicated_ip` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `city` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `country` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dedicated_servers`
--

CREATE TABLE `dedicated_servers` (
  `id` int NOT NULL,
  `dedicated_ip_id` int NOT NULL,
  `server_name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `server_img` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `server_config` varchar(1000) COLLATE utf8mb3_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `server_address` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `server_city` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `purchase_id` int NOT NULL,
  `user_id` int NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `expiry_date` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `servers`
--

CREATE TABLE `servers` (
  `server_id` int NOT NULL,
  `server_name` varchar(255) NOT NULL,
  `server_img` varchar(255) NOT NULL,
  `status` enum('1','0') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `servers`
--

INSERT INTO `servers` (`server_id`, `server_name`, `server_img`, `status`, `created_at`, `updated_at`) VALUES
(6, 'United States', 'download_667586fb53e30.png', '1', '2024-06-21 13:58:19', '2024-08-30 10:31:04'),
(7, 'USA', 'images-2_66acda2769fd1.png', '0', '2024-06-21 14:11:39', '2024-08-02 13:07:51');

-- --------------------------------------------------------

--
-- Table structure for table `sub_servers`
--

CREATE TABLE `sub_servers` (
  `sub_server_id` int NOT NULL,
  `server_id` int NOT NULL,
  `sub_server_name` varchar(255) NOT NULL,
  `sub_server_config` mediumtext NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `ip_addresss` varchar(1000) NOT NULL,
  `panel_address` varchar(256) NOT NULL,
  `password` varchar(999) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_servers`
--

INSERT INTO `sub_servers` (`sub_server_id`, `server_id`, `sub_server_name`, `sub_server_config`, `longitude`, `latitude`, `ip_addresss`, `panel_address`, `password`, `created_at`, `updated_at`) VALUES
(13, 6, 'Ohio', '[Interface]\r\nPrivateKey = PRIVATE_KEY\r\nAddress = ADDRESS_V\r\nDNS = 1.1.1.1\r\n\r\n[Peer]\r\nPublicKey = PUBLIC_KEY\r\nPresharedKey = PERSH_KEY\r\nAllowedIPs = 0.0.0.0/0, ::/0\r\nPersistentKeepalive = 0\r\nEndpoint = 3.101.69.105:51820', '-121.89496', '37.33939', '3.101.69.105', 'http://3.101.69.105:51821', 'foobar1234', '2024-06-21 14:07:56', '2024-08-30 10:44:15'),
(23, 7, 'Verginia', '[Interface]\r\nPrivateKey = PRIVATE_KEY\r\nAddress = ADDRESS_V\r\nDNS = 1.1.1.1\r\n\r\n[Peer]\r\nPublicKey = PUBLIC_KEY\r\nPresharedKey = PERSH_KEY\r\nAllowedIPs = 0.0.0.0/0, ::/0\r\nPersistentKeepalive = 0\r\nEndpoint = 3.101.69.105:51820', '-76.0015', '36.8816', '3.101.69.105', 'http://3.101.69.105:51821', 'foobar1234', '2024-08-02 13:23:31', '2024-08-30 10:45:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `registration_date` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT '0',
  `verification_token` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `apple_id` varchar(255) DEFAULT NULL,
  `auth_provider` enum('google','apple','local') DEFAULT 'local'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `registration_date`, `last_login`, `is_verified`, `verification_token`, `remember_token`, `google_id`, `apple_id`, `auth_provider`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$1ALjrPmOiNzEysa3XEsqs.Dl0qVsONAp42yoj9yx3zOswVIGOG4Gm', '2024-06-06 15:34:49', '2024-08-30 15:30:54', 1, NULL, '49f6377fb85d', NULL, NULL, 'local');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dedicated_ip`
--
ALTER TABLE `dedicated_ip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dedicated_ip_ibfk_1` (`user_id`);

--
-- Indexes for table `dedicated_servers`
--
ALTER TABLE `dedicated_servers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dedicated_servers_ibfk_1` (`dedicated_ip_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`purchase_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `servers`
--
ALTER TABLE `servers`
  ADD PRIMARY KEY (`server_id`);

--
-- Indexes for table `sub_servers`
--
ALTER TABLE `sub_servers`
  ADD PRIMARY KEY (`sub_server_id`),
  ADD UNIQUE KEY `unique_server_id` (`server_id`),
  ADD KEY `server_id` (`server_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dedicated_ip`
--
ALTER TABLE `dedicated_ip`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dedicated_servers`
--
ALTER TABLE `dedicated_servers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `purchase_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `servers`
--
ALTER TABLE `servers`
  MODIFY `server_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sub_servers`
--
ALTER TABLE `sub_servers`
  MODIFY `sub_server_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dedicated_ip`
--
ALTER TABLE `dedicated_ip`
  ADD CONSTRAINT `dedicated_ip_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `dedicated_servers`
--
ALTER TABLE `dedicated_servers`
  ADD CONSTRAINT `dedicated_servers_ibfk_1` FOREIGN KEY (`dedicated_ip_id`) REFERENCES `dedicated_ip` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_servers`
--
ALTER TABLE `sub_servers`
  ADD CONSTRAINT `sub_servers_ibfk_1` FOREIGN KEY (`server_id`) REFERENCES `servers` (`server_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
