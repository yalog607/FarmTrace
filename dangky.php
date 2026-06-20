<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Nếu đã đăng nhập rồi thì không cần đăng ký tài khoản mới nữa, chuyển về trang chủ
if (isset($_SESSION['user_logged']) && $_SESSION['user_logged'] === true) {
    header('Location: index.php');
    exit;
}

require_once 'db.php';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'] ?? '';
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Không cho phép tự đăng ký quyền Quản trị viên (admin).
    // Chỉ chấp nhận hai vai trò: nông dân hoặc đơn vị vận chuyển.
    if ($role !== 'nongdan' && $role !== 'vanchuyen') {
        $error = 'Bạn không được phép đăng ký với quyền Quản trị viên!';
    } elseif (isset($pdo)) {
        try {
            // Kiểm tra xem tên tài khoản hoặc email đã tồn tại hay chưa
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM dangkytk WHERE tendangnhap = ? OR email = ?");
            $stmt->execute([$username, $email]);
            
            if ($stmt->fetchColumn() > 0) {
                $error = 'Tên tài khoản hoặc Email đã tồn tại trên hệ thống!';
            } else {
                // Thêm tài khoản mới
                $stmt = $pdo->prepare("INSERT INTO dangkytk (tendangnhap, matkhau, phanquyen, email) VALUES (?, ?, ?, ?)");
                $stmt->execute([$username, $password, $role, $email]);
                $success = 'Đăng ký tài khoản thành công! <a href="dangnhap.php" style="color: #059669; font-weight: bold;">Đăng nhập ngay</a>';
            }
        } catch (\PDOException $e) {
            $error = 'Lỗi hệ thống: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký thành viên</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: #fff; padding: 40px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); width: 380px; border-top: 5px solid #059669; }
        h2 { text-align: center; margin-bottom: 20px; color: #1e293b; }
        .form-group { margin-bottom: 18px; }
        label { display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #475569; }
        input, select { width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; outline: none; }
        input:focus, select:focus { border-color: #059669; }
        button { width: 100%; padding: 12px; background-color: #059669; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 15px; font-weight: bold; }
        button:hover { background-color: #047857; }
        .error { background-color: #fee2e2; color: #dc2626; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 13px; }
        .success { background-color: #ecfdf5; color: #059669; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 13px; }
        .link { text-align: center; margin-top: 20px; font-size: 14px; color: #64748b; }
        .link a { color: #059669; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Đăng Ký</h2>
        
        <?php if (!empty($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="success"><?= $success ?></div>
        <?php endif; ?>

        <form action="dangky.php" method="POST">
            <div class="form-group">
                <label>Bạn tham gia với tư cách gì?</label>
                <select name="role" required>
                    <option value="nongdan">Nhà sản xuất / Nông dân</option>
                    <option value="vanchuyen">Đơn vị vận chuyển</option>
                </select>
            </div>
            <div class="form-group">
                <label>Tên đăng nhập</label>
                <input type="text" name="username" placeholder="Nhập tên đăng nhập" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Nhập địa chỉ Email" required>
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="password" placeholder="Mật khẩu" required>
            </div>
            <button type="submit">Đăng ký</button>
        </form>
        <div class="link">Đã có tài khoản? <a href="dangnhap.php">Đăng nhập</a></div>
    </div>
</body>
</html>