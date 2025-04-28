<?php
session_start();

// Kết nối database
$mysqli = new mysqli("localhost", "root", "", "education");

// Kiểm tra lỗi kết nối
if ($mysqli->connect_error) {
    die("Kết nối thất bại: " . $mysqli->connect_error);
}

// Kiểm tra nếu là POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Lấy dữ liệu từ form và đảm bảo đã được gửi
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $dob = trim($_POST['dob'] ?? '');
    $address = trim($_POST['address'] ?? '');

    // Chuẩn bị truy vấn cập nhật
    $stmt = $mysqli->prepare("UPDATE users SET full_name = ?, email = ?, phone = ?, dob = ?, address = ? WHERE id = ?");
    if (!$stmt) {
        die("Lỗi chuẩn bị truy vấn: " . $mysqli->error);
    }

    // Gán giá trị vào truy vấn
    $stmt->bind_param("sssssi", $fullname, $email, $phone, $dob, $address, $user_id);

    // Thực thi và kiểm tra
    if ($stmt->execute()) {
        // Cập nhật thành công
        header("Location: profile.php?success=1");
        exit;
    } else {
        // Lỗi khi thực thi
        echo "Lỗi cập nhật: " . $stmt->error;
    }

    $stmt->close();
}

$mysqli->close();
?>
