<?php
require 'auth.php';
yeu_cau_dang_nhap('admin');
require 'db.php';

$id = $_GET['id'] ?? '';

// Duyệt sản phẩm: chuyển trạng thái duyệt sang 'da_duyet'
if ($id !== '') {
    $pdo->prepare("UPDATE sanpham SET trang_thai_duyet = 'da_duyet' WHERE id = ?")->execute([$id]);
}

// Quay lại trang quản trị sau khi duyệt xong
header('Location: admin.php');
exit;
?>
