<?php
require 'auth.php';
yeu_cau_dang_nhap('vanchuyen');
require 'db.php';

// XỬ LÝ KHI ĐƠN VỊ VẬN CHUYỂN BẤM DUYỆT: chuyển trạng thái sang 'Đã đến điểm bán'
$id = $_GET['id'] ?? '';
if ($id !== '') {
    $pdo->prepare("UPDATE sanpham SET trang_thai = 'Đã đến điểm bán' WHERE id = ?")->execute([$id]);
    header('Location: vanchuyen.php');
    exit;
}
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
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fa-solid fa-truck"></i> Lô hàng chờ vận chuyển</h1>
        <h3><i class="fa-solid fa-list"></i> Danh sách đơn đã duyệt, đang vận chuyển</h3>
        <table>
            <tr>
                <th>Mã Lô</th>
                <th>Tên Sản Phẩm</th>
                <th>Người gửi</th>
                <th>Thao tác</th>
            </tr>
            <?php
            // Chỉ hiện đơn admin đã duyệt và đang trên đường vận chuyển (chưa đến điểm bán)
            $ds = $pdo->query("SELECT * FROM sanpham WHERE trang_thai_duyet = 'da_duyet' AND trang_thai = 'Đang vận chuyển'")->fetchAll();
            foreach ($ds as $row):
            ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['ten_nongsan']) ?></td>
                <td><?= htmlspecialchars($row['ten_nongdan']) ?></td>
                <td>
                    <a href="vanchuyen.php?id=<?= urlencode($row['id']) ?>"
                       style="background:#059669; color:#fff; padding:6px 12px; border-radius:4px; text-decoration:none;">
                        Đã đến điểm bán
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
