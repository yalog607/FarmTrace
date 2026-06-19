<?php
// Khởi động session và kiểm tra quyền
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['user_logged']) || $_SESSION['role'] !== 'vanchuyen') {
    header('Location: dangnhap.php');
    exit;
}
require 'db.php'; // Đảm bảo file db.php của bạn nằm cùng thư mục
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kênh Vận Chuyển - FarmTrace</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f1f5f9; }
        .btn-nhan { background: #0284c7; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fa-solid fa-truck"></i> Lô hàng chờ vận chuyển</h1>
	<div class="card" style="margin-bottom: 30px;">
        <h3><i class="fa-solid fa-list"></i> Danh sách đơn hàng chờ vận chuyển</h3>
        <table style="width:100%; border-collapse: collapse; margin-top:20px;">
        <?php
        require 'db.php';
        // Chỉ hiện đơn đã được duyệt và chưa vận chuyển
        $ds = $pdo->query("SELECT * FROM sanpham WHERE trang_thai_duyet = 'da_duyet' AND trang_thai = 'Vừa thu hoạch'")->fetchAll();
        foreach($ds as $row):
        ?>
        <tr>
            <td style="padding:12px; border:1px solid #cbd5e1;"><?= $row['id'] ?></td>
            <td style="padding:12px; border:1px solid #cbd5e1;"><?= $row['ten_nongsan'] ?></td>
            <td style="padding:12px; border:1px solid #cbd5e1;">
                <a href="update_vanchuyen.php?id=<?= $row['id'] ?>" style="color:#0284c7; font-weight:bold;">Nhận vận chuyển</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
        
        <table>
            <tr>
                <th>Mã Lô</th>
                <th>Tên Sản Phẩm</th>
                <th>Người gửi</th>
                <th>Thao tác</th>
            </tr>
            <?php
            // Lấy danh sách sản phẩm từ nông dân
            $ds = $pdo->query("SELECT * FROM sanpham WHERE trang_thai = 'Vừa thu hoạch'")->fetchAll();
            foreach($ds as $row):
            ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['ten_nongsan']) ?></td>
                <td><?= htmlspecialchars($row['ten_nongdan']) ?></td>
                <td>
                    <a href="update_vanchuyen.php?id=<?= $row['id'] ?>" class="btn-nhan">Nhận vận chuyển</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>