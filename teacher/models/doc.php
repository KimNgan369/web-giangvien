<?php
require_once "pdo.php"; // nếu bạn cần gọi file kết nối
// Bắt đầu session nếu chưa có
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra đăng nhập
if (!isset($_SESSION["username"])) {
    echo "Chưa đăng nhập. Vui lòng đăng nhập.";
    exit;
}



$username = $_SESSION["username"];
$conn = pdo_get_connection();

// Lấy thông tin người dùng từ username
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$uploaderId = $user['id'] ?? null;

// Lưu uploader ID vào session để sử dụng bên documents.php
$_SESSION['user_id'] = $uploaderId;


// Hàm lấy tất cả tài liệu
function get_all_documents() {
    $pdo = pdo_get_connection();
    $sql = "SELECT d.*, m.name AS class_name 
            FROM documents d
            LEFT JOIN myclass m ON d.class_id = m.class_id
            ORDER BY d.upload_date DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$docs = get_all_documents(); // Gọi ra ngoài để dùng trong HTML




/**
 * Thêm tài liệu vào cơ sở dữ liệu
 */
function insert_document($documentName, $documentDescription, $documentFormat, $documentDanhmuc, $documentClass, $documentMonhoc, $filePath, $uploaderId, $classId,$fileSize) {
    $pdo = pdo_get_connection();
    $sqlInsert = "INSERT INTO documents (title, description, format, file_path, uploader_id, upload_date, danhmuc, monhoc, lophoc, class_id, file_size)
              VALUES (:title, :description, :format, :file_path, :uploader_id, NOW(), :danhmuc, :monhoc, :lophoc, :class_id, :file_size)";

    $stmtInsert = $pdo->prepare($sqlInsert);
    return $stmtInsert->execute([
        ':title' => $documentName,
        ':description' => $documentDescription,
        ':format' => $documentFormat,
        ':file_path' => $filePath,
        ':uploader_id' => $uploaderId,
        ':danhmuc' => $documentDanhmuc,
        ':monhoc' => $documentMonhoc,
        ':lophoc' => $documentClass,
        ':class_id' => $classId,
        ':file_size' => $fileSize
    ]);
}
function format_file_size($bytes) {
    if ($bytes == 0) return '0 Bytes';
    
    $units = ['Bytes', 'KB', 'MB', 'GB'];
    $i = floor(log($bytes, 1024));
    
    return round($bytes / pow(1024, $i), 2) . ' ' . $units[$i];
}
// Thêm hàm lấy danh sách lớp học từ bảng myclass
function get_all_classes() {
    $pdo = pdo_get_connection();
    $sql = "SELECT class_id, name FROM myclass ORDER BY name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
$classes = get_all_classes();
function get_document_by_id($id) {
    try {
        $sql = "SELECT * FROM documents WHERE id = ?";
        return pdo_query_one($sql, $id);
    } catch (PDOException $e) {
        die("Lỗi khi truy vấn tài liệu: " . $e->getMessage());
    }
}

function delete_document($id) {
    try {
        $sql = "DELETE FROM documents WHERE id = ?";
        $conn = pdo_get_connection();
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        
        // Kiểm tra xem có dòng nào bị ảnh hưởng không
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        // Ghi log lỗi
        error_log("Lỗi khi xóa tài liệu: " . $e->getMessage());
        return false;
    }
}
function count_documents($userId) {
    $pdo = pdo_get_connection();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM documents WHERE uploader_id = :user_id");
    $stmt->execute([':user_id' => $userId]);
    return $stmt->fetchColumn();
}

function get_documents_paginated($userId, $offset, $limit) {
    $pdo = pdo_get_connection();
    
    $stmt = $pdo->prepare("SELECT * FROM documents 
                          WHERE uploader_id = :user_id 
                          ORDER BY upload_date DESC 
                          LIMIT :limit OFFSET :offset");
    
    // Bind với kiểu dữ liệu rõ ràng
    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>