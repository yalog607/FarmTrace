<?php
session_start();
if (!isset($_SESSION['user_logged']) || $_SESSION['role'] !== 'admin') {
    header('Location: dangnhap.php');
    exit;
}
require 'db.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bảng Quản Trị</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; }
        .btn-duyet { background: #059669; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <h3>Danh sách Sản phẩm chờ duyệt</h3>
        <table>
            <tr><th>Mã Lô</th><th>Tên Nông Sản</th><th>Trạng thái</th><th>Thao tác</th></tr>
            <?php
            stmt = $pdo->query("SELECT * FROM sanpham WHERE trang_thai_duyet = 'cho_duyet'");
            $prods = $stmt->fetchAll();
            
            if ($prods && count($prods) > 0) {
                foreach($prods as $p) {
                    echo "<tr>
                            <td>" . htmlspecialchars($p['id'] ?? '') . "</td>
                            <td>" . htmlspecialchars($p['ten_nongsan'] ?? '') . "</td>
                            <td>" . htmlspecialchars($p['phan_loai'] ?? '') . "</td> <td><span style='color:orange;'>Đang chờ duyệt</span></td>
                            <td><a href='adminduyet.php?action=product&id={$p['id']}' class='btn-duyet'>Duyệt</a></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Không có sản phẩm nào đang chờ duyệt.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>