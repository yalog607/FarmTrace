<?php
// File dùng chung để kiểm tra đăng nhập và phân quyền.
// Gọi require 'auth.php'; ở đầu mỗi trang cần bảo vệ.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra người dùng đã đăng nhập chưa, và có đúng vai trò không.
// $vai_tro = null  -> chỉ cần đăng nhập là được.
// $vai_tro = 'admin' (hoặc 'nongdan', 'vanchuyen') -> bắt buộc đúng vai trò đó.
function yeu_cau_dang_nhap($vai_tro = null) {
    if (!isset($_SESSION['user_logged']) || $_SESSION['user_logged'] !== true) {
        header('Location: dangnhap.php');
        exit;
    }
    if ($vai_tro !== null && $_SESSION['role'] !== $vai_tro) {
        header('Location: dangnhap.php');
        exit;
    }
}
?>
