<?php
// 1. Khởi động session để nhận diện phiên làm việc hiện tại
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Xóa sạch toàn bộ dữ liệu đã lưu trong Session
session_unset();

// 3. Hủy hoàn toàn phiên làm việc của Session trên máy chủ
session_destroy();

// 4. Chuyển hướng người dùng về thẳng trang chủ index.php sạch sẽ
header('Location: index.php');
exit;
?>