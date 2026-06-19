-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 12, 2026 lúc 09:24 PM
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
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `id` varchar(50) NOT NULL,
  `ten_nongsan` varchar(255) NOT NULL,
  `ten_nongdan` varchar(255) NOT NULL,
  `ngay_thuhoach` date NOT NULL,
  `trang_thai` varchar(100) DEFAULT 'Vừa thu hoạch',
  `trang_thai_duyet` varchar(20) DEFAULT 'cho_duyet',
  `phan_loai` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`id`, `ten_nongsan`, `ten_nongdan`, `ngay_thuhoach`, `trang_thai`, `trang_thai_duyet`, `phan_loai`) VALUES
('LOT-001', 'Dưa hấu hắc mỹ nhân', 'Nguyễn Văn Ruộng', '2026-05-10', 'Đã đến điểm bán', 'da_duyet', NULL),
('LOT-002', 'Xoài cát Hòa Lộc', 'Trần Thị Vườn', '2026-05-12', 'Đang vận chuyển', 'da_duyet', NULL),
('NS007', 'Chè xanh (Trà xanh)', 'nongdan', '0000-00-00', 'Vừa thu hoạch', 'da_duyet', 'Cây công nghiệp');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
