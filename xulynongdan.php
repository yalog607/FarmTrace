<?php
session_start();
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO sanpham (..., status, trang_thai_van_chuyen) VALUES (..., 'cho_duyet', 'moi_thu_hoach')");
    $stmt->execute([$_POST['id'], $_POST['ten_nongsan'], $_SESSION['username']]);
	$stmt_log = $pdo->prepare("INSERT INTO lichtrinh (sanpham_id, giai_doan, noi_dung, thoi_gian) VALUES (?, 'Canh tác & Thu hoạch', 'Thu hoạch tại ruộng hộ gia đình, đạt chuẩn VietGAP', NOW())");
    $stmt_log->execute([$_POST['id']]);
    header('Location: nongdan.php?status=success');
}
?>