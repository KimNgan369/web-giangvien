<?php
session_start();
ob_start();
include "models/pdo.php"; 
include "models/user.php"; 

// Kiểm tra người dùng đã đăng nhập với vai trò admin chưa
if (isset($_SESSION["role"]) && ($_SESSION["role"] == 'teacher')) {
    
    //Nhúng kết nối CSDL

    include "view/header.php";

    if (!isset($_GET['act'])) {
        include "view/home.php";
    } else {
        switch ($_GET['act']) {

            case 'logout':
                if(isset($_SESSION['role'])) {
                    unset($_SESSION['role']);
                    unset($_SESSION['username']);
                    unset($_SESSION['user_id']);
                    session_destroy();
                }
                header('location: ../index.php');
                exit; 
                break;

            default:
                include "view/home.php";
                break;
        }
    }
    include "view/footer.php";
} else {
    header('location: login.php');
    exit;
}
?>