<?php
session_start();
require_once '../models/pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy user ID từ session
    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
        header("Location: ../login.php?error=notloggedin");
        exit();
    }

    $user_id = $_SESSION['user']['id']; // ID người đang đăng nhập
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        header("Location: profile.php?error=notmatch");
        exit();
    }

    // Lấy thông tin người dùng từ database
    $user = pdo_query_one("SELECT * FROM users WHERE id = ?", $user_id);

    if (!$user) {
        header("Location: profile.php?error=notfound");
        exit();
    }

    // So sánh mật khẩu hiện tại
    if (!password_verify($current_password, $user['password_hash'])) {
        header("Location: profile.php?error=wrongpassword");
        exit();
    }

    // Cập nhật mật khẩu mới
    $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
    try {
        pdo_execute("UPDATE users SET password_hash = ? WHERE id = ?", $new_hash, $user_id);
        header("Location: profile.php?success=password");
        exit();
    } catch (PDOException $e) {
        header("Location: profile.php?error=updatefail");
        exit();
    }
}
?>
