<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once 'db.php';

$ma_lo = $_GET['id'] ?? '';
$san_pham = null;
$timeline = [];
$thong_bao = '';

// Tài khoản vận chuyển có thể thêm một mốc lịch trình mới cho lô hàng này
$role = $_SESSION['role'] ?? '';
if ($role === 'vanchuyen' && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($pdo) && !empty($ma_lo)) {
    $giai_doan = trim($_POST['giai_doan'] ?? '');
    $noi_dung  = trim($_POST['noi_dung'] ?? '');
    if ($giai_doan !== '' && $noi_dung !== '') {
        $nguoi_xacnhan = ($_SESSION['username'] ?? 'Nhà vận chuyển') . ' (Nhà vận chuyển)';
        $stmt_them = $pdo->prepare("INSERT INTO lichtrinh (sanpham_id, giai_doan, thoi_gian, noi_dung, nguoi_xacnhan) VALUES (?, ?, NOW(), ?, ?)");
        $stmt_them->execute([$ma_lo, $giai_doan, $noi_dung, $nguoi_xacnhan]);
        $thong_bao = 'Đã thêm mốc lịch trình mới!';
    } else {
        $thong_bao = 'Vui lòng nhập đầy đủ giai đoạn và nội dung!';
    }
}

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

            <?php if ($role === 'vanchuyen'): ?>
                <hr style="margin: 30px 0; border: 0; border-top: 1px solid #eee;">
                <h3 style="color: var(--primary);"><i class="fa-solid fa-plus"></i> Thêm mốc lịch trình mới</h3>
                <?php if (!empty($thong_bao)): ?>
                    <p style="color: var(--primary); font-weight: 600; margin: 10px 0;"><?= htmlspecialchars($thong_bao) ?></p>
                <?php endif; ?>
                <form method="POST" style="display: flex; flex-direction: column; gap: 12px; margin-top: 15px;">
                    <input type="text" name="giai_doan" placeholder="Giai đoạn (VD: Vận chuyển lộ trình)" required
                           style="padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                    <textarea name="noi_dung" rows="3" placeholder="Nội dung chi tiết (VD: Bốc xếp lên xe đông lạnh...)" required
                              style="padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;"></textarea>
                    <button type="submit"
                            style="padding: 10px; background: var(--primary); color: #fff; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
                        Thêm lịch trình
                    </button>
                </form>
            <?php endif; ?>
        <?php else: ?>
            <p>Không tìm thấy thông tin lô hàng này.</p>
        <?php endif; ?>
    </div>
</body>
</html>