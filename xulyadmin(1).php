<?php
session_start();
require 'db.php';
if ($_SESSION['role'] !== 'admin') exit('Truy cập bị từ chối');

$id = $_GET['id'];
$loai = $_GET['loai'];

if ($loai == 'user') {
    $pdo->prepare("UPDATE nguoidung SET trang_thai_duyet = 'da_duyet' WHERE id = ?")->execute([$id]);
} elseif ($loai == 'product') {
    $pdo->prepare("UPDATE sanpham SET status = 'da_duyet' WHERE id = ?")->execute([$id]);
}

header('Location: admin.php');
?>