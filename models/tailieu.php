<?php
require_once 'pdo.php'; // Đường dẫn đến file pdo.php của bạn

/**
 * Hàm lấy danh sách tài liệu với PDO
 */
function layDanhSachDocuments($filters = []) {
    $sql = "SELECT * FROM documents WHERE 1=1";
    $params = [];
    
    // Lọc môn học (chính xác hơn)
    if (!empty($filters['monhoc'])) {
        $sql .= " AND monhoc = ?";  // Sử dụng = thay vì LIKE để chính xác
        $params[] = trim($filters['monhoc']);  // Loại bỏ khoảng trắng
    }
    
    // Lọc định dạng
    if (!empty($filters['format'])) {
        $sql .= " AND format = ?";
        $params[] = $filters['format'];
    }
    
    // Lọc thời gian (sửa lại)
    if (!empty($filters['tungay']) && !empty($filters['denngay'])) {
        $sql .= " AND upload_date BETWEEN ? AND ?";
        $params[] = $filters['tungay'];
        $params[] = $filters['denngay'];
    }
    

    $sql .= " ORDER BY upload_date DESC";

   
    try {
        $documents = pdo_query($sql, ...$params);
        foreach ($documents as &$doc) {
            $doc['file_size_readable'] = chuyenDoiKichThuocFile($doc['file_size']);
            $doc['upload_date_formatted'] = date('d/m/Y H:i', strtotime($doc['upload_date']));
        }
        return $documents;
    } catch (PDOException $e) {
        error_log("Lỗi truy vấn: " . $e->getMessage());
        return [];
    }
}

// Giữ nguyên hàm chuyenDoiKichThuocFile()
function chuyenDoiKichThuocFile($bytes) {
    if ($bytes == 0) return '0 Byte';
    
    $units = ['Byte', 'KB', 'MB', 'GB', 'TB'];
    $i = floor(log($bytes, 1024));
    
    return round($bytes / pow(1024, $i), 2) . ' ' . $units[$i];
}

function get_document_by_id($id) {
    $sql = "SELECT * FROM documents WHERE id = ?";
    return pdo_query_one($sql, $id);
}
?>