<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Kết nối dữ liệu từ file db.php của bạn
require_once 'db.php';

$role = $_SESSION['role'] ?? 'khach';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Lấy danh sách sản phẩm từ DB (Có hỗ trợ tìm kiếm nếu người dùng nhập tên)
$san_pham = [];
if (isset($pdo)) {
    try {
        if (!empty($search)) {
            $stmt = $pdo->prepare("SELECT * FROM sanpham WHERE ten_nongsan LIKE ? ORDER BY ngay_thuhoach DESC");
            $stmt->execute(["%$search%"]);
        } else {
            $stmt = $pdo->query("SELECT * FROM sanpham ORDER BY ngay_thuhoach DESC");
        }
        $san_pham = $stmt->fetchAll();
    } catch (\PDOException $e) {
        // Xử lý lỗi kết nối nếu có
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cửa Hàng Nông Sản Minh Bạch - FarmTrace</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root { --primary: #059669; --dark: #1e293b; --text: #475569; --border: #e2e8f0; }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Inter', sans-serif; }
        body { background-color: #f8fafc; color: var(--dark); }

        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        
        /* Bộ lọc & Tìm kiếm */
        .search-container { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); margin-bottom: 30px; display: flex; gap: 15px; }
        .search-box { flex: 1; display: flex; align-items: center; border: 1.5px solid var(--border); border-radius: 6px; padding: 0 15px; }
        .search-box i { color: #94a3b8; margin-right: 10px; }
        .search-box input { border: none; width: 100%; padding: 12px 0; outline: none; font-size: 14px; }
        .btn-search { background: var(--primary); color: #fff; border: none; padding: 0 25px; border-radius: 6px; font-weight: 600; cursor: pointer; }

        /* Lưới hiển thị Sản phẩm (Product Grid) */
        .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px; }
        .product-card { background: #fff; border-radius: 12px; overflow: hidden; border: 1px solid var(--border); box-shadow: 0 4px 6px rgba(0,0,0,0.01); transition: transform 0.2s, box-shadow 0.2s; display: flex; flex-direction: column; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        
        /* Ảnh giả lập nông sản xinh xắn */
        .product-img { height: 180px; background: #e2e8f0; display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 48px; background-linear: linear-gradient(135deg, #e6f4ea 0%, #ceead6 100%); }
        
        .product-info { padding: 20px; flex: 1; display: flex; flex-direction: column; justify-content: space-between; }
        .product-tag { font-size: 11px; text-transform: uppercase; font-weight: 700; color: var(--primary); background: #dcfce7; padding: 3px 8px; border-radius: 4px; display: inline-block; margin-bottom: 10px; align-self: flex-start; }
        .product-name { font-size: 18px; font-weight: 700; color: #0f172a; margin-bottom: 8px; }
        .product-meta { font-size: 13px; color: var(--text); margin-bottom: 5px; }
        .product-meta i { width: 20px; color: #94a3b8; }
        
        .btn-trace { display: block; text-align: center; background: #0f172a; color: #fff; text-decoration: none; padding: 10px; border-radius: 6px; font-weight: 600; font-size: 14px; margin-top: 15px; transition: background 0.2s; }
        .btn-trace:hover { background: var(--primary); }
    </style>
</head>
<body>

    <?php include 'menu.php'; ?>

    <div class="container">
        <div style="margin-bottom: 25px;">
            <h2>Danh Sách Sản Phẩm Nông Sản Minh Bạch</h2>
            <p style="color: var(--text); font-size: 14px;">An tâm mua sắm với công nghệ kiểm định và truy xuất nguồn gốc rõ ràng.</p>
        </div>

        <form method="GET" action="" class="search-container">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Nhập tên nông sản cần tìm (Ví dụ: Dưa hấu, Xoài...)">
            </div>
            <button type="submit" class="btn-search">Tìm kiếm</button>
        </form>

        <div class="product-grid">
            <?php if (!empty($san_pham)): ?>
                <?php foreach ($san_pham as $sp): ?>
                    <div class="product-card">
                        <div class="product-img">
                            <i class="fa-solid <?= strpos($sp['ten_nongsan'], 'Dưa') !== false ? 'fa-lemon' : 'fa-apple-whole' ?>"></i>
                        </div>
                        <div class="product-info">
                            <div>
                                <span class="product-tag">VietGAP</span>
                                <h3 class="product-name"><?= htmlspecialchars($sp['ten_nongsan']) ?></h3>
                                <p class="product-meta"><i class="fa-solid fa-user-farmer"></i> Nhà vườn: <strong><?= htmlspecialchars($sp['ten_nongdan']) ?></strong></p>
                                <p class="product-meta"><i class="fa-solid fa-calendar-days"></i> Thu hoạch: <?= date('d/m/Y', strtotime($sp['ngay_thuhoach'])) ?></p>
                                <p class="product-meta"><i class="fa-solid fa-barcode"></i> Mã số: <?= htmlspecialchars($sp['id']) ?></p>
                            </div>
                            
                            <a href="trangchitiet.php?id=<?= urlencode($sp['id']) ?>" class="btn-trace">
                                <i class="fa-solid fa-qrcode"></i> Truy xuất nguồn gốc
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1/-1; text-align: center; padding: 40px; background: #fff; border-radius: 8px; color: var(--text);">
                    <i class="fa-solid fa-box-open" style="font-size: 48px; color: #cbd5e1; margin-bottom: 15px;"></i>
                    <p>Không tìm thấy sản phẩm nào phù hợp với từ khóa của bạn.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>