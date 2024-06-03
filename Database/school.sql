-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 03, 2024 lúc 01:53 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `school`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `username` varchar(255) NOT NULL,
  `passwordd` varchar(255) NOT NULL,
  `typee` bit(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`username`, `passwordd`, `typee`) VALUES
('admin', 'admin', b'00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tb_class`
--

CREATE TABLE `tb_class` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tb_class`
--

INSERT INTO `tb_class` (`id`, `name`, `teacher_id`) VALUES
(1, '1A', 1),
(2, '2A', 1),
(3, '3A', 2),
(4, '4A', 2),
(6, '5A', 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tb_student`
--

CREATE TABLE `tb_student` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tb_student`
--

INSERT INTO `tb_student` (`id`, `name`, `gender`, `dob`, `class_id`) VALUES
(1, 'Học Sinh 1A 1', 'Nữ', '2015-06-17', 1),
(2, 'Học Sinh 1A 2', 'Nữ', '2014-06-04', 1),
(3, 'Học Sinh 2A 1', 'Nam', '2015-06-04', 2),
(4, 'Học Sinh 2A 2', 'Nữ', '2014-06-04', 2),
(5, 'Học Sinh 3A 1', 'Nam', '2015-06-04', 3),
(6, 'Học Sinh 3A 2', 'Nữ', '2014-06-04', 3),
(7, 'Học Sinh 4A 1', 'Nam', '2015-06-04', 4),
(8, 'Học Sinh 4A 2', 'Nữ', '2014-06-04', 4),
(14, 'Học sinh 5A 1', 'Nam', '2010-05-03', 6);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tb_subject`
--

CREATE TABLE `tb_subject` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tb_subject`
--

INSERT INTO `tb_subject` (`id`, `name`) VALUES
(1, 'Toán'),
(2, 'Văn'),
(3, 'Anh'),
(4, 'Hóa');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tb_subject_grade`
--

CREATE TABLE `tb_subject_grade` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `grade` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tb_subject_grade`
--

INSERT INTO `tb_subject_grade` (`id`, `student_id`, `subject_id`, `grade`) VALUES
(1, 1, 1, 7.2),
(2, 2, 1, 8),
(3, 1, 2, 9),
(4, 2, 2, 2),
(5, 1, 3, 1),
(6, 2, 3, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tb_teacher`
--

CREATE TABLE `tb_teacher` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tb_teacher`
--

INSERT INTO `tb_teacher` (`id`, `name`, `gender`, `email`, `phone`) VALUES
(1, 'Lại Văn A', 'Nam', 'laivana@gmail.com', '0123456789'),
(2, 'Phạm Thị B', 'Nữ', 'phamthib@gmail.com', '0987654321'),
(4, 'Nguyễn Như C', 'Nam', 'nguyennhuc@gmail.com', '0478369122');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `tb_class`
--
ALTER TABLE `tb_class`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_class_ibfk_1` (`teacher_id`);

--
-- Chỉ mục cho bảng `tb_student`
--
ALTER TABLE `tb_student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_student_ibfk_1` (`class_id`);

--
-- Chỉ mục cho bảng `tb_subject`
--
ALTER TABLE `tb_subject`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tb_subject_grade`
--
ALTER TABLE `tb_subject_grade`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_subject_grade_ibfk_1` (`student_id`),
  ADD KEY `tb_subject_grade_ibfk_2` (`subject_id`);

--
-- Chỉ mục cho bảng `tb_teacher`
--
ALTER TABLE `tb_teacher`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `tb_class`
--
ALTER TABLE `tb_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `tb_student`
--
ALTER TABLE `tb_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `tb_subject`
--
ALTER TABLE `tb_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `tb_subject_grade`
--
ALTER TABLE `tb_subject_grade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `tb_teacher`
--
ALTER TABLE `tb_teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `tb_class`
--
ALTER TABLE `tb_class`
  ADD CONSTRAINT `tb_class_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `tb_teacher` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tb_student`
--
ALTER TABLE `tb_student`
  ADD CONSTRAINT `tb_student_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `tb_class` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tb_subject_grade`
--
ALTER TABLE `tb_subject_grade`
  ADD CONSTRAINT `tb_subject_grade_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `tb_student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_subject_grade_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `tb_subject` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
