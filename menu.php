<?php
// Kiểm tra và khởi động session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Xác định vai trò hiện tại của người dùng (mặc định là 'khach' nếu chưa đăng nhập)
$current_role = $_SESSION['role'] ?? 'khach';
$current_user = $_SESSION['username'] ?? '';

// Lấy tên file hiện tại để tự động thêm class 'active' nhằm tô sáng mục menu tương ứng
$active_page = basename($_SERVER['PHP_SELF']);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    /* Định dạng thanh Menu Điều Hướng */
    .farmtrace-navbar { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        padding: 15px 80px; 
        background: #ffffff; 
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        position: sticky;
        top: 0;
        z-index: 999;
    }
    .farmtrace-navbar .logo { 
        font-size: 22px; 
        font-weight: 700; 
        color: #059669; 
        text-decoration: none; 
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .farmtrace-navbar .nav-links { 
        display: flex; 
        list-style: none; 
        gap: 25px; 
        align-items: center;
        margin: 0;
        padding: 0;
    }
    .farmtrace-navbar .nav-links a { 
        text-decoration: none; 
        color: #475569; 
        font-weight: 500; 
        font-size: 15px;
        transition: color 0.2s;
    }
    .farmtrace-navbar .nav-links a:hover, 
    .farmtrace-navbar .nav-links a.active { 
        color: #059669; 
        font-weight: 600;
    }
    .farmtrace-navbar .user-actions {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .farmtrace-navbar .user-welcome {
        font-size: 14px;
        color: #334155;
    }
    .farmtrace-navbar .user-welcome strong {
        color: #059669;
    }
    .farmtrace-navbar .role-badge {
        font-size: 11px;
        background: #e2e8f0;
        color: #475569;
        padding: 2px 6px;
        border-radius: 4px;
        font-weight: 600;
        text-transform: uppercase;
    }
    .farmtrace-navbar .btn-nav { 
        padding: 8px 16px; 
        border-radius: 6px; 
        text-decoration: none; 
        font-weight: 600; 
        font-size: 14px;
        transition: background 0.2s;
    }
    .farmtrace-navbar .btn-login {
        background: #059669;
        color: #ffffff;
    }
    .farmtrace-navbar .btn-login:hover {
        background: #047857;
    }
    .farmtrace-navbar .btn-logout {
        background: #fee2e2;
        color: #dc2626;
    }
    .farmtrace-navbar .btn-logout:hover {
        background: #fca5a5;
    }
</style>

<nav class="farmtrace-navbar">
    <a href="index.php" class="logo">
        <i class="fa-solid fa-seedling"></i> FarmTrace
    </a>

    <ul class="nav-links">
        <li>
            <a href="index.php" class="<?= $active_page == 'index.php' ? 'active' : '' ?>">
                <i class="fa-solid fa-house"></i> Trang chủ
            </a>
        </li>

        <li>
            <a href="sanpham.php" class="<?= $active_page == 'sanpham.php' ? 'active' : '' ?>">
                <i class="fa-solid fa-basket-shopping"></i> Sản phẩm
            </a>
        </li>

        <?php if ($current_role !== 'khach'): ?>
            <li>
                <a href="trangtonghop.php" class="<?= $active_page == 'trangtonghop.php' ? 'active' : '' ?>">
                    <i class="fa-solid fa-list-check"></i> Quản lý lô hàng
                </a>
            </li>
        <?php endif; ?>

        <?php if ($current_role === 'nongdan'): ?>
            <li><a href="nongdan.php" class="<?= $active_page == 'nongdan.php' ? 'active' : '' ?>" style="color: #0284c7;"><i class="fa-solid fa-wheat-awn"></i> Góc Nông Dân</a></li>
        <?php elseif ($current_role === 'vanchuyen'): ?>
            <li><a href="vanchuyen.php" class="<?= $active_page == 'vanchuyen.php' ? 'active' : '' ?>" style="color: #0284c7;"><i class="fa-solid fa-truck-fast"></i> Góc Vận Chuyển</a></li>
        <?php elseif ($current_role === 'admin'): ?>
            <li><a href="admin.php" class="<?= $active_page == 'admin.php' ? 'active' : '' ?>" style="color: #b91c1c;"><i class="fa-solid fa-user-shield"></i> Khối Quản Trị</a></li>
        <?php endif; ?>
    </ul>

    <div class="user-actions">
        <?php if ($current_role !== 'khach'): ?>
            <div class="user-welcome">
                <i class="fa-regular fa-circle-user"></i> Chào, <strong><?= htmlspecialchars($current_user) ?></strong>
                <span class="role-badge"><?= $current_role ?></span>
            </div>
            <a href="index.php?action=logout" class="btn-nav btn-logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Đăng xuất</a>
        <?php else: ?>
            <a href="dangnhap.php" class="btn-nav btn-login"><i class="fa-solid fa-lock"></i> Đăng nhập</a>
        <?php endif; ?>
    </div>
</nav>