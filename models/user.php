<?php 
function checkuser($username, $password) {
    $conn = pdo_get_connection();
    
    // Sử dụng prepared statement để ngăn chặn SQL Injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Kiểm tra xem có kết quả trả về không và xác thực mật khẩu
    if($user) {
        // Kiểm tra mật khẩu
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

// Hàm để lấy thông tin user theo username
function getUserByUsername($username) {
    $conn = pdo_get_connection();
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
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

// Hàm để lấy danh sách tất cả người dùng (cho admin)
function getAllUsers() {
    $conn = pdo_get_connection();
    $stmt = $conn->prepare("SELECT id, username, full_name, email, role FROM users");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Hàm để tạo tài khoản mới
function createUser($username, $password, $full_name, $email, $role = 'student') {
    $conn = pdo_get_connection();
    
    // Kiểm tra xem username đã tồn tại chưa
    $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check->execute([$username]);
    if($check->fetch()) {
        return false; // Username đã tồn tại
    }
    
    // Hash mật khẩu trước khi lưu
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("INSERT INTO users (username, password_hash, full_name, email, role) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$username, $password_hash, $full_name, $email, $role]);
}