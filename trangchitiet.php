<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once 'db.php';

$ma_lo = $_GET['id'] ?? '';
$san_pham = null;
$timeline = [];

if (isset($pdo) && !empty($ma_lo)) {
    try {
        $stmt_sp = $pdo->prepare("SELECT * FROM sanpham WHERE id = ?");
        $stmt_sp->execute([$ma_lo]);
        $san_pham = $stmt_sp->fetch();

        $stmt_tl = $pdo->prepare("SELECT * FROM lichtrinh WHERE sanpham_id = ? ORDER BY thoi_gian ASC");
        $stmt_tl->execute([$ma_lo]);
        $timeline = $stmt_tl->fetchAll();
    } catch (\PDOException $e) {}
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết lô hàng <?= htmlspecialchars($ma_lo) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root { --primary: #059669; --border: #e2e8f0; }
        body { background-color: #f8fafc; font-family: 'Inter', sans-serif; }
        .container { max-width: 800px; margin: 40px auto; background: #fff; padding: 40px; border-radius: 12px; border: 1px solid var(--border); }
        .back-link { display: inline-block; margin-bottom: 20px; color: var(--primary); text-decoration: none; font-weight: 600; }
        .timeline-axis { position: relative; border-left: 3px solid #e2e8f0; margin-left: 20px; padding-left: 30px; }
        .timeline-block { position: relative; margin-bottom: 35px; }
        .timeline-icon { position: absolute; left: -46px; top: 3px; width: 28px; height: 28px; border-radius: 50%; background: #fff; border: 3px solid var(--primary); display: flex; align-items: center; justify-content: center; color: var(--primary); }
        .timeline-card { background: #f8fafc; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <?php include 'menu.php'; ?>
    <div class="container">
        <a href="trangtonghop.php" class="back-link"><i class="fa-solid fa-arrow-left"></i> Quay lại bảng tổng hợp</a>
        
        <?php if ($san_pham): ?>
            <h2>Mã Lô: <?= htmlspecialchars($san_pham['id']) ?></h2>
            <p>Sản phẩm: <strong><?= htmlspecialchars($san_pham['ten_nongsan']) ?></strong></p>
            <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">
            
            <div class="timeline-axis">
                <?php foreach ($timeline as $tl): ?>
                <div class="timeline-block">
                    <div class="timeline-icon"><i class="fa-solid fa-check"></i></div>
                    <div class="timeline-card">
                        <h3><?= htmlspecialchars($tl['giai_doan']) ?></h3>
                        <p><?= htmlspecialchars($tl['noi_dung']) ?></p>
                        <small style="color: #64748b;">Thời gian: <?= date('d/m/Y H:i', strtotime($tl['thoi_gian'])) ?></small>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Không tìm thấy thông tin lô hàng này.</p>
        <?php endif; ?>
    </div>
</body>
</html>