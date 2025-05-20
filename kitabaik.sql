-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 20, 2025 at 12:06 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kitabaik`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admins_id` int NOT NULL,
  `fullname` varchar(64) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admins_id`, `fullname`, `email`, `password`) VALUES
(4, 'Rifda Nabil', 'rifdanabilr@gmail.com', '$2y$10$KhXL.hLhiMBWwkAZQ.oMY.4jh4IcLIt06vsSzjCqeHEiXu3.l0RP6');

-- --------------------------------------------------------

--
-- Table structure for table `campaign`
--

CREATE TABLE `campaign` (
  `campaign_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `target_amount` decimal(12,2) DEFAULT NULL,
  `current_amount` decimal(12,2) DEFAULT '0.00',
  `deadline` date DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `campaign`
--

INSERT INTO `campaign` (`campaign_id`, `user_id`, `title`, `description`, `target_amount`, `current_amount`, `deadline`, `status`, `image_path`, `category`, `image`) VALUES
(14, 10, 'Alami Hidrosefalus Non-Obstruktif, Tiara Butuh Biaya untuk Berobat!', 'Tiara Nur Ihsani usia 2tahun, sejak lahir mengidap Communicating Hydrocepalus. Orang tua Tiara, Pa Jenal dan Bu Iis terus berusaha demi kesembuhan anaknya. Walaupun jarak RS sangat jauh sekali yang ditempuh hampir 3jam, namun sebagai orang tua mereka terus berusaha demi kesehatan anaknya. Padahal perekonomian mereka sangat minim dan tidak berkecukupan. Pa Jenal hanya buruh tani menggarap sawah orang lain, diupah sehari hanya 40rb. Sedangkan, Ibu Iis hanya sebagai ibu rumah tangga. Pa Jenal rela menjual barang elektronika seperti, tv juga motor satu satunya, buat biaya keseharian dan oprasional anaknya berobat dan juga nutrisi untuk Tiara.\\r\\nMelalui kampanye donasi ini, mari #MenjadiBaik dengan membantu Tiara melawan Hidrosefalus Non-Obstruktif ini.', '30000000.00', '16502000.00', '2025-10-03', 'aktif', '../uploads/tiara.png', 'Donasi Pasien', 'tiara.png'),
(15, 10, 'Bantu Gizi Anak-anak Pelosok Indonesia', 'Stunting, atau kondisi gagal tumbuh pada anak yang disebabkan oleh kekurangan gizi kronis, adalah salah satu masalah kesehatan utama di Indonesia, khususnya di daerah 3T (Tertinggal, Terdepan, dan Terluar).Daerah 3T adalah daerah tertinggal, terpencil, dan terdepan yang mengalami keterbatasan akses terhadap berbagai layanan dan infrastruktur dasar seperti pendidikan, kesehatan, dan ekonomi. Keterbatasan tersebut merupakan hasil dari pembangunan yang tidak merata di seluruh Indonesia.Stunting mempengaruhi perkembangan fisik dan kognitif anak, yang dapat memengaruhi kualitas hidup mereka di masa depan. Daerah 3T di Indonesia, yang terdiri dari banyak wilayah terpencil dan kurang berkembang, memiliki angka stunting yang lebih tinggi dibandingkan daerah lainnya.Melalui kampanye donasi universal ini, mari #MenjadiBaik dengan bergotong-royong dalam upaya pengentasan stunting di daerah 3T.', '200000000.00', '65020000.00', '2026-05-18', 'aktif', '../uploads/anak indonesi.png', 'Aksi Sosial', 'anak indonesi.png'),
(16, 13, 'donasi banjir semangat dalam 2020', 'beban alam', '2.00', '0.00', '2034-03-12', 'ditolak', '../uploads/WIN_20231002_13_32_40_Pro.jpg', 'Donasi Pohon', 'WIN_20231002_13_32_40_Pro.jpg'),
(17, 14, 'Yuk, Bantu Korban Gempa Bumi', 'Mari #menjadibaik dengan membantu korban Gempa Bumi', '100000000.00', '0.00', '2025-12-12', 'aktif', '../uploads/gempa-bumi-indonesia.jpg', 'Aksi Sosial', 'gempa-bumi-indonesia.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `campaign_update`
--

CREATE TABLE `campaign_update` (
  `update_id` int NOT NULL,
  `campaign_id` int DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `image_path` varchar(255) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `campaign_update`
--

INSERT INTO `campaign_update` (`update_id`, `campaign_id`, `title`, `content`, `image_path`, `update_date`) VALUES
(5, 15, ' Bantuan Anda Sudah Mengubah Banyak Hal', 'Setiap donasi yang Anda berikan telah membawa harapan dan perubahan nyata bagi Anak-anak Pelosok Indonesia. Saat ini, kami tengah menyiapkan distribusi bantuan, dan kami tidak bisa melakukannya tanpa dukungan Anda. Terus ikuti update kami dan mari bersama-sama wujudkan masa depan yang lebih baik.', '1747579938_anak makan.png', '2025-05-18 14:52:18'),
(6, 14, 'Langkah Awal Tiara Menuju Kesembuhan', 'Hari ini adalah kontrol pertama Tiara sejak didiagnosis hidrosefalus non-obstruktif. Didampingi sang ibu, Tiara mulai menjalani serangkaian pemeriksaan untuk mengetahui penanganan terbaik bagi kondisinya. Ini adalah langkah kecil, tapi sangat berarti. Terima kasih atas doa dan bantuanmu. Bersama, kita bisa terus mendampingi Tiara menuju harapan baru.', '1747585497_tiara konsul.png', '2025-05-18 16:24:57');

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

CREATE TABLE `donation` (
  `donation_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `campaign_id` int DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` enum('pending','completed','failed') DEFAULT 'pending',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `message` text,
  `is_anonymous` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `donation`
--

INSERT INTO `donation` (`donation_id`, `user_id`, `campaign_id`, `amount`, `payment_method`, `payment_status`, `created_at`, `message`, `is_anonymous`) VALUES
(15, 10, 15, '20000.00', 'Transfer Bank', 'completed', '2025-05-18 22:33:56', 'Semoga Anak-anak Indonesia selalu sehat', 1),
(16, 10, 15, '15000000.00', 'Transfer Bank', 'completed', '2025-05-18 22:53:09', 'Semoga Hal-hal baik selalu menyertai kalian', 0),
(17, 12, 14, '1500000.00', 'E-Wallet', 'completed', '2025-05-19 00:13:15', 'Semoga Tiara cepat sembuh', 0),
(18, 10, 14, '15000000.00', 'Transfer Bank', 'completed', '2025-05-19 10:29:12', 'Semoga cepat sembuh', 1),
(19, 14, 15, '50000000.00', 'Transfer Bank', 'completed', '2025-05-19 11:23:36', 'Semoga kebaikan menyertai anak indonesia', 0),
(20, 10, 14, '2000.00', 'E-Wallet', 'completed', '2025-05-19 11:29:28', 'semoga cepat sembuh', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `fullname` varchar(64) NOT NULL,
  `email` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fullname`, `email`, `birthdate`, `password`, `is_admin`, `role`, `created_at`) VALUES
(10, 'Andi Rifki Nurazwari', 'andirifki@yahoo.com', '2002-09-30', '$2y$10$Dq2sNO7b9UoIx8uMxbE2lOBRn4VRWujS5GvDe1oT/CTXjBeqTRsW.', 0, 'user', '2025-05-14 03:25:54'),
(12, 'Rifda Nabil', 'rifdanabil@gmail.com', '2007-10-03', '$2y$10$t.W0hQgRq2LA9KqQrH07I.CM6NkBTcTA0tnIty3rSHdCf1Zq3xMnm', 0, 'user', '2025-05-18 16:11:38'),
(13, 'mido', 'midojayajaya@gmaill.com', '2025-05-08', '$2y$10$A66cTa0rZC5CvupNT.Snpus2DFeaN0frvgAHRp7FXnjxfC37tTHlK', 0, 'user', '2025-05-19 00:27:06'),
(14, 'Malik April', 'maliklikmallik@gmail.com', '2008-12-12', '$2y$10$B7ZC79yOs52RUTHN1XXHp.wS/dv/VyOsv1O6wuMkAsasCAjJFcxU2', 0, 'user', '2025-05-19 03:22:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admins_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `campaign`
--
ALTER TABLE `campaign`
  ADD PRIMARY KEY (`campaign_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `campaign_update`
--
ALTER TABLE `campaign_update`
  ADD PRIMARY KEY (`update_id`),
  ADD KEY `campaign_update_ibfk_1` (`campaign_id`);

--
-- Indexes for table `donation`
--
ALTER TABLE `donation`
  ADD PRIMARY KEY (`donation_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `campaign_id` (`campaign_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admins_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `campaign`
--
ALTER TABLE `campaign`
  MODIFY `campaign_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `campaign_update`
--
ALTER TABLE `campaign_update`
  MODIFY `update_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `donation`
--
ALTER TABLE `donation`
  MODIFY `donation_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `campaign`
--
ALTER TABLE `campaign`
  ADD CONSTRAINT `campaign_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `campaign_update`
--
ALTER TABLE `campaign_update`
  ADD CONSTRAINT `campaign_update_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `campaign` (`campaign_id`) ON DELETE CASCADE;

--
-- Constraints for table `donation`
--
ALTER TABLE `donation`
  ADD CONSTRAINT `donation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `donation_ibfk_2` FOREIGN KEY (`campaign_id`) REFERENCES `campaign` (`campaign_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
