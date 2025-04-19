<?php
require_once 'pdo.php';
// Đặt múi giờ Việt Nam
date_default_timezone_set('Asia/Ho_Chi_Minh');
/**
 * Get all statuses with user information
 * @param int $limit Number of statuses to retrieve
 * @param int $offset Offset for pagination
 * @return array List of statuses with user information
 */
function getAllStatuses($limit = 10, $offset = 0) {
    $conn = pdo_get_connection();
    $query = "SELECT s.*, u.username, u.full_name 
              FROM status s 
              JOIN users u ON s.user_id = u.id 
              ORDER BY s.created_at DESC 
              LIMIT :limit OFFSET :offset";
    
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
/**
 * Count total number of statuses
 * @return int Total number of statuses
 */
function countStatuses() {
    $conn = pdo_get_connection();
    $query = "SELECT COUNT(*) as total FROM status";
    
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'];
}

/**
 * Create a new status
 * @param int $user_id ID of the user creating the status
 * @param string $content Content of the status
 * @param string $image_path Path to the image (if any)
 * @return bool True if successful, false otherwise
 */
function createStatus($user_id, $content, $image_path = null) {
    $conn = pdo_get_connection();
    $query = "INSERT INTO status (user_id, content, image_path, created_at) 
              VALUES (?, ?, ?, NOW())";
    
    $stmt = $conn->prepare($query);
    return $stmt->execute([$user_id, $content, $image_path]);
}

/**
 * Get a status by ID
 * @param int $status_id ID of the status
 * @return array|bool Status data or false if not found
 */
function getStatusById($status_id) {
    $conn = pdo_get_connection();
    $query = "SELECT s.*, u.username, u.full_name
              FROM status s 
              JOIN users u ON s.user_id = u.id 
              WHERE s.id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->execute([$status_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Update a status
 * @param int $status_id ID of the status to update
 * @param string $content New content
 * @param string $image_path New image path (if any)
 * @return bool True if successful, false otherwise
 */
function updateStatus($status_id, $content, $image_path = null) {
    $conn = pdo_get_connection();
    
    // Check if image_path is being updated
    if ($image_path !== null) {
        $query = "UPDATE status SET content = ?, image_path = ? WHERE id = ?";
        $params = [$content, $image_path, $status_id];
    } else {
        $query = "UPDATE status SET content = ? WHERE id = ?";
        $params = [$content, $status_id];
    }
    
    $stmt = $conn->prepare($query);
    return $stmt->execute($params);
}

/**
 * Delete a status
 * @param int $status_id ID of the status to delete
 * @return bool True if successful, false otherwise
 */
function deleteStatus($status_id) {
    $conn = pdo_get_connection();
    $query = "DELETE FROM status WHERE id = ?";
    
    $stmt = $conn->prepare($query);
    return $stmt->execute([$status_id]);
}

/**
 * Check if a user is the owner of a status
 * @param int $status_id ID of the status
 * @param int $user_id ID of the user
 * @return bool True if the user is the owner, false otherwise
 */
function isStatusOwner($status_id, $user_id) {
    $conn = pdo_get_connection();
    $query = "SELECT COUNT(*) as count FROM status WHERE id = ? AND user_id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->execute([$status_id, $user_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $result['count'] > 0;
}