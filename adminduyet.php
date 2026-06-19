<<?php
require 'db.php';
$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';

if ($action == 'user') {
    $pdo->prepare("UPDATE dangkytk SET status = 'da_duyet' WHERE id = ?")->execute([$id]);
} elseif ($action == 'product') {
    $pdo->prepare("UPDATE sanpham SET status = 'da_duyet' WHERE id = ?")->execute([$id]);
}

// Dòng này quan trọng: Nó giúp trang web tải lại sau khi duyệt xong
header('Location: admin.php');
exit; 
?>