<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Khởi tạo mảng profile
    $profile = [];

    // Lấy thông tin cơ bản
    $profile['name'] = isset($_POST['name']) ? trim($_POST['name']) : '';
    $profile['degree'] = isset($_POST['degree']) ? trim($_POST['degree']) : '';
    $profile['faculty'] = isset($_POST['faculty']) ? trim($_POST['faculty']) : '';
    $profile['bio'] = isset($_POST['bio']) ? trim($_POST['bio']) : '';

    // Trình độ học vấn (mảng các chuỗi)
    $profile['education'] = [];
    if (isset($_POST['education']) && is_array($_POST['education'])) {
        foreach ($_POST['education'] as $edu) {
            if (trim($edu) !== '') {
                $profile['education'][] = trim($edu);
            }
        }
    }

    // Kinh nghiệm giảng dạy (mảng các cặp title + place)
    $profile['experience'] = [];
    if (isset($_POST['exp_title']) && is_array($_POST['exp_title'])) {
        foreach ($_POST['exp_title'] as $i => $title) {
            $place = $_POST['exp_place'][$i] ?? '';
            if (trim($title) !== '' || trim($place) !== '') {
                $profile['experience'][] = [
                    'title' => trim($title),
                    'place' => trim($place)
                ];
            }
        }
    }

    // Dự án nghiên cứu (mảng các cặp title + detail)
    $profile['projects'] = [];
    if (isset($_POST['proj_title']) && is_array($_POST['proj_title'])) {
        foreach ($_POST['proj_title'] as $i => $projTitle) {
            $projDetail = $_POST['proj_detail'][$i] ?? '';
            if (trim($projTitle) !== '' || trim($projDetail) !== '') {
                $profile['projects'][] = [
                    'title' => trim($projTitle),
                    'detail' => trim($projDetail)
                ];
            }
        }
    }

    //hinh anh
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../uploads/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
    
        $filename = basename($_FILES["avatar"]["name"]);
        $target_file = $target_dir . time() . "_" . $filename;
        move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);
    
        $_SESSION['teacher_profile']['avatar'] = $target_file;
    }
    

    // Lưu vào session
    $_SESSION['teacher_profile'] = $profile;

    // Quay lại trang about.php
    header("Location: about.php");
    exit;
}
?>
