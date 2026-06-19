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
-- Cấu trúc bảng cho bảng `lichtrinh`
--

CREATE TABLE `lichtrinh` (
  `id` int(11) NOT NULL,
  `sanpham_id` varchar(50) DEFAULT NULL,
  `giai_doan` varchar(255) NOT NULL,
  `thoi_gian` datetime NOT NULL,
  `noi_dung` text NOT NULL,
  `nguoi_xacnhan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lichtrinh`
--

INSERT INTO `lichtrinh` (`id`, `sanpham_id`, `giai_doan`, `thoi_gian`, `noi_dung`, `nguoi_xacnhan`) VALUES
(1, 'LOT-001', 'Canh tác & Thu hoạch', '2026-05-10 08:00:00', 'Thu hoạch tại ruộng hộ gia đình Tây Sơn, Bình Định. Đạt chuẩn VietGAP.', 'Nguyễn Văn Ruộng (Nông dân)'),
(2, 'LOT-001', 'Vận chuyển lộ trình', '2026-05-11 14:30:00', 'Bốc xếp lên xe đông lạnh 77C-12345 di chuyển về Quy Nhơn.', 'Lâm Tài Xế (Nhà vận chuyển)'),
(3, 'LOT-001', 'Phân phối & Kiểm định', '2026-05-12 09:00:00', 'Đối soát mã Blockchain thành công. Đủ điều kiện lên kệ siêu thị.', 'Ban Quản Trị (Admin)'),
(4, 'LOT-002', 'Canh tác & Thu hoạch', '2026-05-12 07:00:00', 'Thu hoạch xoài tại nhà vườn Hoài Nhơn.', 'Trần Thị Vườn (Nông dân)');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `lichtrinh`
--
ALTER TABLE `lichtrinh`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sanpham_id` (`sanpham_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `lichtrinh`
--
ALTER TABLE `lichtrinh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `lichtrinh`
--
ALTER TABLE `lichtrinh`
  ADD CONSTRAINT `lichtrinh_ibfk_1` FOREIGN KEY (`sanpham_id`) REFERENCES `sanpham` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
