<?php
// Khởi động session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// XỬ LÝ ĐĂNG XUẤT
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ - FarmTrace</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
       /* Reset & Font */
       * { box-sizing: border-box; margin: 0; padding: 0; }
       body { font-family: 'Inter', sans-serif; background-color: #ffffff; color: #1e293b; line-height: 1.6; }

       /* Hero Section: Thiết kế dạng Gradient sang trọng */
        .hero { 
        text-align: center; 
        padding: 120px 20px; 
        background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%);
        border-bottom: 1px solid #e2e8f0;
    }
        .hero h1 { font-size: 56px; font-weight: 800; margin-bottom: 24px; letter-spacing: -1px; }
        .hero h1 span { color: #059669; }
        .hero p { color: #475569; font-size: 20px; margin-bottom: 40px; max-width: 700px; margin-left: auto; margin-right: auto; }
    
        /* Button: Bo tròn nhẹ và hiệu ứng hover */
        .cta-btn { 
        background: #059669; color: #fff; padding: 18px 35px; 
        border-radius: 50px; text-decoration: none; font-weight: 600; 
        transition: all 0.3s ease; display: inline-block; box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2);
    }
        .cta-btn:hover { background: #047857; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(5, 150, 105, 0.3); }

        /* Features: Thêm hiệu ứng nổi (Lift-up) */
        .features { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; padding: 80px 20px; max-width: 1100px; margin: 0 auto; }
        .feature-card { 
        padding: 40px; border-radius: 20px; border: 1px solid #f1f5f9; 
        background: #fff; transition: all 0.4s ease;
    }
        .feature-card:hover { border-color: #059669; transform: translateY(-10px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05); }
        .feature-card i { font-size: 36px; color: #059669; margin-bottom: 20px; }
        .feature-card h3 { font-size: 22px; margin-bottom: 12px; }
    
        /* Footer */
        .footer { background: #0f172a; color: #94a3b8; text-align: center; padding: 40px; margin-top: 60px; font-size: 14px; }
    </style>
</head>
<body>

    <?php include 'menu.php'; ?>

    <section class="hero">
        <h1>Truy xuất nguồn gốc <br><span>Nông sản</span> minh bạch</h1>
        <p>Hệ thống giám sát hành trình nông sản từ nhà vườn đến tay người tiêu dùng. Đảm bảo tính trung thực, an toàn chất lượng và nâng tầm giá trị nông sản Việt.</p>
        <a href="sanpham.php" class="cta-btn">Tra cứu sản phẩm ngay</a>
    </section>

    <section class="features">
        <div class="feature-card">
            <i class="fa-solid fa-shield-halved"></i>
            <h3>Minh bạch thông tin</h3>
            <p>Mọi dữ liệu từ khâu gieo trồng đến thu hoạch đều được lưu trữ và công khai, giúp người tiêu dùng an tâm tuyệt đối.</p>
        </div>
        <div class="feature-card">
            <i class="fa-solid fa-truck-fast"></i>
            <h3>Truy xuất nhanh chóng</h3>
            <p>Chỉ cần mã lô hàng, bạn có thể biết ngay nguồn gốc nông sản chỉ trong vài giây.</p>
        </div>
        <div class="feature-card">
            <i class="fa-solid fa-seedling"></i>
            <h3>Nâng tầm nông sản</h3>
            <p>Hỗ trợ người nông dân khẳng định thương hiệu và uy tín nông sản trên thị trường.</p>
        </div>
    </section>

    <footer class="footer">
        <p>&copy; 2026 FarmTrace - Hệ thống truy xuất nguồn gốc nông sản số 1.</p>
    </footer>

</body>
</html>