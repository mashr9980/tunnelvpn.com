-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2024 at 09:35 AM
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
-- Database: `vpnpanel`
--

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promo_codes`
--

CREATE TABLE `promo_codes` (
  `promo_id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `expiration_date` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `purchase_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `expiry_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `servers`
--

CREATE TABLE `servers` (
  `server_id` int(11) NOT NULL,
  `server_name` varchar(255) NOT NULL,
  `server_img` varchar(255) NOT NULL,
  `status` enum('1','0') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `servers`
--

INSERT INTO `servers` (`server_id`, `server_name`, `server_img`, `status`, `created_at`, `updated_at`) VALUES
(6, 'United States', 'download_667586fb53e30.png', '1', '2024-06-21 13:58:19', '2024-06-21 14:25:12'),
(7, 'United Kingdom', 'download_66758a1b797f7.jpeg', '0', '2024-06-21 14:11:39', '2024-06-21 14:11:39'),
(8, 'Switzerland', 'download (1)_66758a6122b2e.png', '0', '2024-06-21 14:12:49', '2024-06-21 14:12:49'),
(9, 'South Africa', 'download (2)_66758a81c31df.png', '0', '2024-06-21 14:13:21', '2024-06-21 14:13:21'),
(10, 'Singapore', 'download (3)_66758a9f20679.png', '0', '2024-06-21 14:13:51', '2024-06-21 14:13:51'),
(11, 'Poland', 'download (4)_66758b0945965.png', '0', '2024-06-21 14:15:37', '2024-06-21 14:15:37'),
(12, 'Germany', 'download (5)_66758b2612156.png', '1', '2024-06-21 14:16:06', '2024-06-21 14:25:47');

-- --------------------------------------------------------

--
-- Table structure for table `sub_servers`
--

CREATE TABLE `sub_servers` (
  `sub_server_id` int(11) NOT NULL,
  `server_id` int(11) NOT NULL,
  `sub_server_name` varchar(255) NOT NULL,
  `sub_server_config` mediumtext NOT NULL,
  `ip_addresss` varchar(1000) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sub_servers`
--

INSERT INTO `sub_servers` (`sub_server_id`, `server_id`, `sub_server_name`, `sub_server_config`, `ip_addresss`, `created_at`, `updated_at`) VALUES
(13, 6, 'New York', '[Interface]\r\n          PrivateKey = mADnI699omLho3uq588iZoT+IHsjFNQLc9idYuTuoUE=\r\n          Address = 10.0.0.3/32\r\n          DNS = 10.0.0.1\r\n          MTU = 1320\r\n\r\n          [Peer]\r\n          PublicKey = ZjECCxTFtEDuLhjE7n3NicIpz77h9UN+pbfYOIbKQlQ=\r\n          AllowedIPs = 0.0.0.0/0\r\n          Endpoint = 109.205.61.211:443', '109.205.61.211', '2024-06-21 14:07:56', '2024-06-21 14:07:56'),
(15, 7, 'London', '[Interface]\r\n          PrivateKey = mADnI699omLho3uq588iZoT+IHsjFNQLc9idYuTuoUE=\r\n          Address = 10.0.0.3/32\r\n          DNS = 10.0.0.1\r\n          MTU = 1320\r\n\r\n          [Peer]\r\n          PublicKey = ZjECCxTFtEDuLhjE7n3NicIpz77h9UN+pbfYOIbKQlQ=\r\n          AllowedIPs = 0.0.0.0/0\r\n          Endpoint = 45.91.93.75:443', '45.91.93.75', '2024-06-21 14:18:18', '2024-06-21 14:18:18'),
(16, 8, 'Zurich', '[Interface]\r\n          PrivateKey = mADnI699omLho3uq588iZoT+IHsjFNQLc9idYuTuoUE=\r\n          Address = 10.0.0.3/32\r\n          DNS = 10.0.0.1\r\n          MTU = 1320\r\n\r\n          [Peer]\r\n          PublicKey = ZjECCxTFtEDuLhjE7n3NicIpz77h9UN+pbfYOIbKQlQ=\r\n          AllowedIPs = 0.0.0.0/0\r\n          Endpoint = 188.244.117.184:443', '188.244.117.184', '2024-06-21 14:19:12', '2024-06-21 14:19:12'),
(17, 9, 'Johannesburg', '[Interface]\r\n          PrivateKey = mADnI699omLho3uq588iZoT+IHsjFNQLc9idYuTuoUE=\r\n          Address = 10.0.0.3/32\r\n          DNS = 10.0.0.1\r\n          MTU = 1320\r\n\r\n          [Peer]\r\n          PublicKey = ZjECCxTFtEDuLhjE7n3NicIpz77h9UN+pbfYOIbKQlQ=\r\n          AllowedIPs = 0.0.0.0/0\r\n          Endpoint = 102.222.20.164:443\r\n', '102.222.20.164', '2024-06-21 14:20:12', '2024-06-21 14:20:12'),
(18, 10, 'Singapore', '[Interface]\r\n          PrivateKey = mADnI699omLho3uq588iZoT+IHsjFNQLc9idYuTuoUE=\r\n          Address = 10.0.0.3/32\r\n          DNS = 10.0.0.1\r\n          MTU = 1320\r\n\r\n          [Peer]\r\n          PublicKey = ZjECCxTFtEDuLhjE7n3NicIpz77h9UN+pbfYOIbKQlQ=\r\n          AllowedIPs = 0.0.0.0/0\r\n          Endpoint = 185.223.207.66:443', '185.223.207.66', '2024-06-21 14:20:43', '2024-06-21 14:20:43'),
(19, 11, 'Gdansk', '[Interface]\r\n          PrivateKey = mADnI699omLho3uq588iZoT+IHsjFNQLc9idYuTuoUE=\r\n          Address = 10.0.0.3/32\r\n          DNS = 10.0.0.1\r\n          MTU = 1320\r\n\r\n          [Peer]\r\n          PublicKey = ZjECCxTFtEDuLhjE7n3NicIpz77h9UN+pbfYOIbKQlQ=\r\n          AllowedIPs = 0.0.0.0/0\r\n          Endpoint = 37.252.6.188:443', '37.252.6.188', '2024-06-21 14:21:13', '2024-06-21 14:21:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `registration_date` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `registration_date`, `last_login`, `remember_token`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$1ALjrPmOiNzEysa3XEsqs.Dl0qVsONAp42yoj9yx3zOswVIGOG4Gm', '2024-06-06 15:34:49', '2024-06-25 06:46:18', '7bae51277d473c84b4f96876c45ca14e');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `promo_codes`
--
ALTER TABLE `promo_codes`
  ADD PRIMARY KEY (`promo_id`),
  ADD UNIQUE KEY `code` (`code`);

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
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `promo_codes`
--
ALTER TABLE `promo_codes`
  MODIFY `promo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `servers`
--
ALTER TABLE `servers`
  MODIFY `server_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sub_servers`
--
ALTER TABLE `sub_servers`
  MODIFY `sub_server_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

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
