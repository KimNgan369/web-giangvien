-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 17, 2025 at 03:53 PM
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
-- Database: `education`
--

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `format` varchar(20) DEFAULT NULL,
  `file_size` bigint(20) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploader_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `upload_date` datetime DEFAULT current_timestamp(),
  `danhmuc` varchar(100) DEFAULT NULL,
  `monhoc` varchar(100) DEFAULT NULL,
  `lophoc` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `title`, `description`, `format`, `file_size`, `file_path`, `uploader_id`, `class_id`, `upload_date`, `danhmuc`, `monhoc`, `lophoc`) VALUES
(28, 'jztr', 'okehe', 'PDF', 0, 'uploads/67fe5d58c50ed_Lab 5 - Review.pdf', 1, 1, '2025-04-15 20:21:28', 'Bài giảng', 'Cơ Sở Dữ Liệu ', 'MMT-K27'),
(30, 'kkk', '123456', 'PPTX', 0, 'uploads/67fe6133f3b32_Chuong I - gioi thieu.pptx', 1, 1, '2025-04-15 20:37:56', 'Tài liệu tham khảo', 'Cơ Sở Dữ Liệu ', 'KTPM-K27');

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE `downloads` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `download_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `myclass`
--

CREATE TABLE `myclass` (
  `class_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `schedule` varchar(100) DEFAULT NULL,
  `room` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `myclass`
--

INSERT INTO `myclass` (`class_id`, `name`, `teacher_id`, `schedule`, `room`) VALUES
(1, 'Cơ Sở Dữ Liệu ', 1, 'Thứ 6, 7:30 - 9:30', 'Phòng D305'),
(2, 'Toán Cao Cấp', 3, 'Thứ 4, 9:30 - 11:30', 'Phòng D201'),
(3, 'Trí Tuệ Nhân Tạo', 1, 'Thứ 5, 7:30 - 9:30', 'Phòng D807'),
(4, 'Lập Trình Web', 3, 'Thứ 3, 12:30 - 13:30', 'Phòng C305'),
(5, 'Cấu Trúc Rời Rạc', 3, 'Thứ 4, 15:30 - 18:00', 'Phòng C209');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `user_id`, `content`, `image_path`, `created_at`) VALUES
(11, 1, 'czcxz', 'uploads/status/status_680102d82e9d2.JPG', '2025-04-17 20:32:08'),
(13, 1, 'xZCCX', 'uploads/status/status_680105e47e03e.JPG', '2025-04-17 20:45:08'),
(14, 1, 'xzczv', 'uploads/status/status_68010684d85e1.png', '2025-04-17 20:47:48'),
(15, 1, 'àafas', 'uploads/status/status_6801069252e8a.png', '2025-04-17 20:48:02'),
(16, 1, 'hi cưng', 'uploads/status/status_680106a2043ed.webp', '2025-04-17 20:48:18'),
(17, 1, ':3', 'uploads/status/status_680106b933417.jpg', '2025-04-17 20:48:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('student','teacher','admin') DEFAULT 'student'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `email`, `password_hash`, `role`) VALUES
(1, 'Ngan', 'Ngan', 'A@gmail.com', '123456', 'teacher'),
(2, 'Dung', 'Dung', 'Dung@gmail.com', '123456', 'student'),
(3, 'Anh', 'Anh', 'Anh@gmail.com', '123456', 'teacher');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploader_id` (`uploader_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `downloads`
--
ALTER TABLE `downloads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `document_id` (`document_id`);

--
-- Indexes for table `myclass`
--
ALTER TABLE `myclass`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `downloads`
--
ALTER TABLE `downloads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `myclass`
--
ALTER TABLE `myclass`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`uploader_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `documents_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `myclass` (`class_id`),
  ADD CONSTRAINT `fk_documents_class` FOREIGN KEY (`class_id`) REFERENCES `myclass` (`class_id`) ON DELETE SET NULL;

--
-- Constraints for table `downloads`
--
ALTER TABLE `downloads`
  ADD CONSTRAINT `downloads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `downloads_ibfk_2` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `myclass`
--
ALTER TABLE `myclass`
  ADD CONSTRAINT `myclass_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `status`
--
ALTER TABLE `status`
  ADD CONSTRAINT `status_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;