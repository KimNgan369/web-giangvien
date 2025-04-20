<?php 
function checkuser($username, $password){
    $conn = pdo_get_connection();
    
    // Sử dụng prepared statement để ngăn chặn SQL Injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Kiểm tra xem có kết quả trả về không và xác thực mật khẩu
    if($user) {
        // Verify passwordAA
        // Nếu mật khẩu trong DB đã được hash (nên dùng password_hash)
        if(password_verify($password, $user['password_hash'])) {
            return $user;
        } else {
            // Phương pháp thay thế nếu mật khẩu chưa được hash (không khuyến nghị)
            if($password === $user['password_hash']) {
                return $user;
            }
        }
    }
    
    // Trả về false nếu không tìm thấy người dùng hoặc mật khẩu không khớp
    return false;
}

// Hàm để lấy thông tin user theo ID
function getUserById($userId) {
    $conn = pdo_get_connection();
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Hàm để cập nhật thông tin người dùng
function updateUser($userId, $data) {
    $conn = pdo_get_connection();
    
    $sets = [];
    $values = [];
    
    foreach($data as $key => $value) {
        $sets[] = "$key = ?";
        $values[] = $value;
    }
    
    $values[] = $userId;
    
    $query = "UPDATE users SET " . implode(", ", $sets) . " WHERE id = ?";
    $stmt = $conn->prepare($query);
    
    return $stmt->execute($values);
}