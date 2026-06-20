<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Nếu đã đăng nhập rồi thì không cho phép ở lại trang đăng nhập này nữa
if (isset($_SESSION['user_logged']) && $_SESSION['user_logged'] === true) {
    header('Location: index.php');
    exit;
}

require_once 'db.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'] ?? '';
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (isset($pdo)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM dangkytk WHERE tendangnhap = ? AND phanquyen = ?");
            $stmt->execute([$username, $role]);
            $user_db = $stmt->fetch();

            if ($user_db && $password === $user_db['matkhau']) {
                // ĐĂNG NHẬP THÀNH CÔNG -> GHI NHẬN SESSION
                $_SESSION['user_logged'] = true;
                $_SESSION['username']    = $user_db['tendangnhap'];
                $_SESSION['role']        = $user_db['phanquyen'];

                header('Location: index.php'); // Chuyển về trang chủ
                exit;
            } else {
                $error = 'Tài khoản, mật khẩu hoặc vai trò không chính xác!';
            }
        } catch (\PDOException $e) {
            $error = 'Lỗi truy vấn database: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập hệ thống</title>
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
        .link { text-align: center; margin-top: 20px; font-size: 14px; color: #64748b; }
        .link a { color: #059669; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Đăng Nhập</h2>
        
        <?php if (!empty($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form action="dangnhap.php" method="POST">
            <div class="form-group">
                <label>Vai trò</label>
                <select name="role" required>
                    <option value="nongdan">Nhà sản xuất / Nông dân</option>
                    <option value="vanchuyen">Đơn vị vận chuyển</option>
                    <option value="admin">Quản trị viên</option>
                </select>
            </div>
            <div class="form-group">
                <label>Tên đăng nhập</label>
                <input type="text" name="username" placeholder="Tên tài khoản" required autocomplete="username">
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="password" placeholder="Mật khẩu" required autocomplete="current-password">
            </div>
            <button type="submit">Đăng nhập</button>
        </form>
        <div class="link">Chưa có tài khoản? <a href="dangky.php">Đăng ký mới</a></div>
        <div class="link"><a href="index.php">&larr; Quay lại trang chủ</a></div>
    </div>
</body>
</html>