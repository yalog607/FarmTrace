-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 12, 2026 lúc 09:23 PM
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
-- Cơ sở dữ liệu: `farmtrace`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dangkytk`
--

CREATE TABLE `dangkytk` (
  `tendangnhap` varchar(50) NOT NULL,
  `matkhau` varchar(255) NOT NULL,
  `phanquyen` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` varchar(20) DEFAULT 'cho_duyet'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `dangkytk`
--

INSERT INTO `dangkytk` (`tendangnhap`, `matkhau`, `phanquyen`, `email`, `status`) VALUES
('[value-1]', '[value-2]', '[value-3]', '[value-4]', 'cho_duyet'),
('vanchuyen', 'vanchuyen01234', 'vanchuyen', 'vanchuyen5687@gmail.com', 'cho_duyet'),
('admin', 'admin6785', 'admin', 'admin2468@gmail.com', 'cho_duyet'),
('nongdan', 'nongdan1234', 'nongdan', 'nongdan87945@gmail.com', 'cho_duyet');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
