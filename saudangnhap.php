<?php
// 1. Khởi động session đầu tiên
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. KIỂM TRA PHẦN SAU KHI ĐĂNG NHẬP (Nếu đã có session đăng nhập)
if (isset($_SESSION['user_logged']) && $_SESSION['user_logged'] === true) {
    // Tự động chuyển hướng họ về trang chức năng dựa trên vai trò đã lưu
    if ($_SESSION['role'] === 'nongdan') {
        header('Location: nongdan.php'); 
    } elseif ($_SESSION['role'] === 'vanchuyen') {
        header('Location: vanchuyen.php'); 
    } elseif ($_SESSION['role'] === 'admin') {
        header('Location: admin.php'); 
    } else {
        header('Location: dangnhap.php'); // Mặc định về trang chủ
    }
    exit; // Chặn không cho chạy tiếp code bên dưới
}

// 3. Kết nối database
require_once 'dangnhap.php';
$error = '';

// 4. Xử lý khi người dùng nhấn nút submit gửi dữ liệu Đăng nhập lên
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'] ?? '';
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password) || empty($role)) {
        $error = 'Vui lòng nhập đầy đủ thông tin đăng nhập!';
    } else {
        if ($pdo) {
            $stmt = $pdo->prepare("SELECT * FROM dangkytk WHERE tendangnhap = ? AND phanquyen = ?");
            $stmt->execute([$username, $role]);
            $user_db = $stmt->fetch();

            if ($user_db && $password === $user_db['matkhau']) {
                // Đăng nhập đúng -> Thiết lập Session
                $_SESSION['user_logged'] = true;
                $_SESSION['username'] = $user_db['tendangnhap'];
                $_SESSION['role'] = $user_db['phanquyen'];
                
                // Chuyển hướng đúng trang chức năng ngay lập tức
                if ($_SESSION['role'] === 'nongdan') {
                    header('Location: nongdan.php');
                } elseif ($_SESSION['role'] === 'vanchuyen') {
                    header('Location: vanchuyen.php');
                } elseif ($_SESSION['role'] === 'admin') {
                    header('Location: admin.php');
                } else {
                    header('Location: index3.php');
                }
                exit;
            } else {
                $error = 'Tài khoản, mật khẩu hoặc vai trò không chính xác!';
            }
        }
    }
}
?>