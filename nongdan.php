<<?php
session_start();
// Kiểm tra quyền truy cập
if (!isset($_SESSION['user_logged']) || $_SESSION['role'] !== 'nongdan') {
    header('Location: dangnhap.php');
    exit;
}
require_once 'db.php';

$msg = "";
// XỬ LÝ KHI NÔNG DÂN GỬI LÔ HÀNG MỚI
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $ten = $_POST['ten_nongsan'];
    $phan_loai = $_POST['phan_loai'] ?? '';
    $ten_nongdan = $_SESSION['username'];

    try {
        // Lưu ý: status mặc định là 'cho_duyet', trang_thai mặc định là 'Vừa thu hoạch'
        $stmt = $pdo->prepare("INSERT INTO sanpham (id, ten_nongsan, phan_loai, ten_nongdan, status, trang_thai, trang_thai_duyet) VALUES (?, ?, ?, ?, 'cho_duyet', 'Vừa thu hoạch', 'cho_duyet')");
        $stmt->execute([$id, $ten, $phan_loai, $ten_nongdan]);
        $msg = "<div style='color: green; background: #d1fae5; padding: 15px; border-radius: 8px; margin-bottom: 20px;'>✅ Đã gửi yêu cầu thu hoạch: " . htmlspecialchars($ten) . ". Đang chờ Admin duyệt!</div>";
    } catch (PDOException $e) {
        $msg = "<div style='color: red; background: #fee2e2; padding: 15px; border-radius: 8px; margin-bottom: 20px;'>❌ Lỗi: Mã lô hàng này đã tồn tại!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Góc Nông Dân - FarmTrace</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: sans-serif; background-color: #f8fafc; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2, h3 { color: #059669; }
        input { width: 100%; padding: 12px; margin: 8px 0 15px 0; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #059669; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
    </style>
</head>
<body>
    <div class="container">
        <h2><i class="fa-solid fa-leaf"></i> Góc Nhà Sản Xuất</h2>
        <?php if($msg) echo $msg; ?>

        <h3><i class="fa-solid fa-plus"></i> Thêm lô nông sản mới</h3>
        <form method="POST">
            <input type="text" name="id" placeholder="Mã lô hàng (VD: LUA001)" required>
            <input type="text" name="ten_nongsan" placeholder="Tên nông sản" required>
            <input type="text" name="phan_loai" placeholder="Phân loại (VD: Lúa gạo, Rau sạch...)" required>
            <button type="submit">Xác nhận thu hoạch</button>
        </form>

        <hr style="margin: 40px 0;">

        <h3><i class="fa-solid fa-list-check"></i> Lô hàng của bạn</h3>
        <table>
            <tr style="background: #f1f5f9;">
                <th>Mã Lô</th>
                <th>Sản phẩm</th>
                <th>Trạng thái hiện tại</th>
            </tr>
            <?php
            $stmt = $pdo->prepare("SELECT * FROM sanpham WHERE ten_nongdan = ? ORDER BY id DESC");
            $stmt->execute([$_SESSION['username']]);
            $items = $stmt->fetchAll();
            
            foreach($items as $row):
            ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['ten_nongsan']) ?></td>
                <td>
                    <?php if($row['trang_thai'] == 'Đang vận chuyển'): ?>
                        <span style="color: #dc2626; font-weight: bold; background: #fee2e2; padding: 4px 8px; border-radius: 4px;">
                            📦 Đã có người nhận vận chuyển (Chuẩn bị hàng!)
                        </span>
                    <?php else: ?>
                        <span style="color: #059669; font-weight: 500;">
                            <?= htmlspecialchars($row['trang_thai'] ?? 'Đang chờ') ?>
                        </span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>