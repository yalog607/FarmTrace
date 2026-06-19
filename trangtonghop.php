<?php
require 'auth.php';
yeu_cau_dang_nhap(); // chỉ cần đã đăng nhập
require_once 'db.php';

$role = $_SESSION['role'] ?? 'khach';
$cac_lo_hang = [];

if (isset($pdo)) {
    try {
        // Lấy tất cả lô hàng nông sản trong hệ thống, xếp lô mới nhất lên đầu
        $stmt = $pdo->query("SELECT * FROM sanpham ORDER BY ngay_thuhoach DESC");
        $cac_lo_hang = $stmt->fetchAll();
    } catch (\PDOException $e) {
        $error = "Lỗi tải dữ liệu: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tổng hợp lô hàng nội bộ - FarmTrace</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #059669; --dark: #1e293b; --text: #475569; --border: #e2e8f0; }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Inter', sans-serif; }
        body { background-color: #f8fafc; color: var(--dark); }
        
        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        .header-box { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .header-box h2 { font-size: 24px; color: var(--dark); }
        
        .btn-action { padding: 8px 16px; background: var(--primary); color: #fff; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px; display: inline-block; }
        
        /* Giao diện Bảng dữ liệu */
        .table-container { background: #fff; border-radius: 10px; overflow: hidden; border: 1px solid var(--border); box-shadow: 0 4px 6px rgba(0,0,0,0.01); }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th, td { padding: 16px; border-bottom: 1px solid var(--border); font-size: 14px; }
        th { background: #f1f5f9; color: var(--text); font-weight: 600; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px; }
        tr:last-child td { border-bottom: none; }
        tr:hover { background-color: #f8fafc; }
        
        /* Huy hiệu trạng thái */
        .badge { padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: 600; display: inline-block; }
        .badge-new { background: #e0f2fe; color: #0369a1; } /* Vừa thu hoạch */
        .badge-shipping { background: #fef9c3; color: #a16207; } /* Đang vận chuyển */
        .badge-done { background: #dcfce7; color: #15803d; } /* Đã đến điểm bán */
        
        .link-detail { color: var(--primary); text-decoration: none; font-weight: 600; }
        .link-detail:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <?php include 'menu.php'; ?>

    <div class="container">
        <div class="header-box">
            <div>
                <h2>Bảng Kiểm Soát & Tổng Hợp Lô Hàng</h2>
                <p style="color: var(--text); font-size: 14px; margin-top: 5px;">Tài khoản kiểm duyệt: <span style="font-weight: 600; color: var(--primary);"><?= strtoupper($role) ?></span></p>
            </div>
            
            <?php if ($role === 'nongdan'): ?>
                <a href="nongdan.php" class="btn-action"><i class="fa-solid fa-plus"></i> Thu hoạch lô mới</a>
            <?php endif; ?>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Mã Số Lô</th>
                        <th>Tên Nông Sản</th>
                        <th>Nhà Sản Xuất</th>
                        <th>Ngày Thu Hoạch</th>
                        <th>Trạng Thái Chuỗi</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($cac_lo_hang)): ?>
                        <?php foreach ($cac_lo_hang as $lo): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($lo['id']) ?></strong></td>
                            <td><?= htmlspecialchars($lo['ten_nongsan']) ?></td>
                            <td><?= htmlspecialchars($lo['ten_nongdan']) ?></td>
                            <td><?= date('d/m/Y', strtotime($lo['ngay_thuhoach'])) ?></td>
                            <td>
                                <?php 
                                    $badge_class = 'badge-new';
                                    if ($lo['trang_thai'] === 'Đang vận chuyển') $badge_class = 'badge-shipping';
                                    if ($lo['trang_thai'] === 'Đã đến điểm bán') $badge_class = 'badge-done';
                                ?>
                                <span class="badge <?= $badge_class ?>">
                                    <?= htmlspecialchars($lo['trang_thai']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="trangchitiet.php?id=<?= urlencode($lo['id']) ?>" class="link-detail">
                                    <i class="fa-solid fa-clock-history"></i> Xem lịch trình chi tiết
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--text); padding: 30px;">Hệ thống chưa ghi nhận lô hàng nông sản nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>