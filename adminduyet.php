<?php
require 'auth.php';
yeu_cau_dang_nhap('admin');
require 'db.php';

$id = $_GET['id'] ?? '';

// Duyệt sản phẩm: đánh dấu đã duyệt và chuyển trạng thái sang 'Đang vận chuyển'
if ($id !== '') {
    $pdo->prepare("UPDATE sanpham SET trang_thai_duyet = 'da_duyet', trang_thai = 'Đang vận chuyển' WHERE id = ?")->execute([$id]);
}

// Quay lại trang quản trị sau khi duyệt xong
header('Location: admin.php');
exit;
?>
