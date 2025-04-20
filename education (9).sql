-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 19, 2025 lúc 07:53 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `education`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `documents`
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
-- Đang đổ dữ liệu cho bảng `documents`
--

INSERT INTO `documents` (`id`, `title`, `description`, `format`, `file_size`, `file_path`, `uploader_id`, `class_id`, `upload_date`, `danhmuc`, `monhoc`, `lophoc`) VALUES
(40, 'Lab 4 - Introduction to Prolog', 'Lab 4 nè', 'PDF', 401086, '1744983555_Lab 4 - Introduction to Prolog.pdf', 1, 5, '2025-04-18 20:39:15', 'Bài giảng', 'Cấu Trúc Rời Rạc', 'KTPM-K27'),
(41, 'Lab 5- Review', 'ôn tập lại các bài đã học ', 'PDF', 147331, '1744983593_Lab 5 - Review.pdf', 1, 4, '2025-04-18 20:39:53', 'Đề thi', 'Lập Trình Web', 'KTPM-K27'),
(42, 'ProblemSolvingUsingSearching', 'AI - lec3 - chương này là cái j đó không nhớ luôn í', 'PPTX', 795627, '1744983801_AI-lec03-ProblemSolvingUsingSearching.pptx', 1, 3, '2025-04-18 20:43:21', 'Bài giảng', 'Trí Tuệ Nhân Tạo', 'KHMT-K27'),
(43, 'Bài tập tuần 2', 'Ôn lại kiến thức tạo bảng cũng như các thao tác trên bảng', 'PDF', 925657, '1744983963_Bai tuan 02.pdf', 1, 1, '2025-04-18 20:46:03', 'Bài tập', 'Cơ Sở Dữ Liệu ', 'KHMT-K27'),
(44, 'Lab6', 'j j ko nhớ', 'PDF', 2574512, '1744985083_Lab6 (2).pdf', 1, 1, '2025-04-18 21:04:43', 'Tài liệu tham khảo', 'Cơ Sở Dữ Liệu ', 'KHMT-K27'),
(45, 'ko biet', 'cho đại đại á', 'PPTX', 890545, '1744986750_05-Analysis-of-Algorithms.pptx', 1, 4, '2025-04-18 21:32:30', 'Tài liệu tham khảo', 'Lập Trình Web', 'KTPM-K27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `downloads`
--

CREATE TABLE `downloads` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `download_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `myclass`
--

CREATE TABLE `myclass` (
  `class_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `schedule` varchar(100) DEFAULT NULL,
  `room` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `myclass`
--

INSERT INTO `myclass` (`class_id`, `name`, `teacher_id`, `schedule`, `room`) VALUES
(1, 'Cơ Sở Dữ Liệu ', 1, 'Thứ 6, 7:30 - 9:30', 'Phòng D305'),
(2, 'Toán Cao Cấp', 3, 'Thứ 4, 9:30 - 11:30', 'Phòng D201'),
(3, 'Trí Tuệ Nhân Tạo', 1, 'Thứ 5, 7:30 - 9:30', 'Phòng D807'),
(4, 'Lập Trình Web', 3, 'Thứ 3, 12:30 - 13:30', 'Phòng C305'),
(5, 'Cấu Trúc Rời Rạc', 3, 'Thứ 4, 15:30 - 18:00', 'Phòng C209');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `status`
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
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('student','teacher','admin') DEFAULT 'student',
  `phone` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `email`, `password_hash`, `role`) VALUES
(1, 'Ngan', 'Ngan', 'A@gmail.com', '123456', 'teacher'),
(2, 'Dung', 'Dung', 'Dung@gmail.com', '123456', 'student'),
(3, 'Anh', 'Anh', 'Anh@gmail.com', '123456', 'teacher');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploader_id` (`uploader_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Chỉ mục cho bảng `downloads`
--
ALTER TABLE `downloads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `document_id` (`document_id`);

--
-- Chỉ mục cho bảng `myclass`
--
ALTER TABLE `myclass`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Chỉ mục cho bảng `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);


--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT cho bảng `downloads`
--
ALTER TABLE `downloads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `myclass`
--
ALTER TABLE `myclass`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`uploader_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `documents_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `myclass` (`class_id`),
  ADD CONSTRAINT `fk_documents_class` FOREIGN KEY (`class_id`) REFERENCES `myclass` (`class_id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `downloads`
--
ALTER TABLE `downloads`
  ADD CONSTRAINT `downloads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `downloads_ibfk_2` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `myclass`
--
ALTER TABLE `myclass`
  ADD CONSTRAINT `myclass_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `status`
--
ALTER TABLE `status`
  ADD CONSTRAINT `status_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

CREATE TABLE teacher_profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255),
    degree VARCHAR(255),
    faculty VARCHAR(255),
    bio TEXT,
    avatar VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE teacher_education (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_id INT NOT NULL,
    education VARCHAR(255),
    FOREIGN KEY (teacher_id) REFERENCES teacher_profiles(id) ON DELETE CASCADE
);

CREATE TABLE teacher_experience (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_id INT NOT NULL,
    title VARCHAR(255),
    place VARCHAR(255),
    FOREIGN KEY (teacher_id) REFERENCES teacher_profiles(id) ON DELETE CASCADE
);

CREATE TABLE teacher_projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_id INT NOT NULL,
    title VARCHAR(255),
    detail TEXT,
    FOREIGN KEY (teacher_id) REFERENCES teacher_profiles(id) ON DELETE CASCADE
);

ALTER TABLE users
ADD COLUMN degree VARCHAR(255),
ADD COLUMN faculty VARCHAR(255),
ADD COLUMN bio TEXT,
ADD COLUMN education TEXT,
ADD COLUMN experience TEXT,
ADD COLUMN projects TEXT,
ADD COLUMN avatar VARCHAR(255);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
