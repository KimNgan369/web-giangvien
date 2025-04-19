<?php
session_start();
require_once '../models/pdo.php';
require_once '../models/status.php';
require_once '../models/user.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $content = $_POST['content'];
    $image_path = '';

    // Xử lý upload ảnh
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/';
        $file_name = uniqid() . '_' . basename($_FILES['image']['name']);
        $target_path = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            $image_path = $file_name;
        }
    }

    createStatus($user_id, $content, $image_path);
    header('Location: ../view/status.php');
    exit();
}