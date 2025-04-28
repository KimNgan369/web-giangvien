<?php
session_start();
ob_start();
include "models/pdo.php"; 
include "models/user.php";
include "models/class.php"; 


// Kiểm tra người dùng đã đăng nhập với vai trò admin chưa
if (isset($_SESSION["role"]) && ($_SESSION["role"] == 'teacher')) {
    
    // Nhúng kết nối CSDL và header (chỉ include header một lần ở đây)
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
            
            
            case 'status':
                // Include status model
                include "models/status.php";
                
                // Pagination
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $limit = 5; // 5 statuses per page
                $offset = ($page - 1) * $limit;
                
                // Get statuses for current page
                $statuses = getAllStatuses($limit, $offset);
                $totalStatuses = countStatuses();
                $totalPages = ceil($totalStatuses / $limit);
                
                include "view/status.php"; // Display statuses with pagination
                break;

            case 'mydocuments':
                include "documents.php"; 
                break;

            case'myclasses':
                $classes = get_myclass();
                include "view/myclass.php";
                break;
                
            case'khoahoc':
                $classes = get_myclass();
                include "view/myclass.php";
                break;

            case 'tailieu':
                include "models/tailieu.php"; 
                
                // Tạo mảng lọc từ tham số GET
                $filters = [];
                
                if (isset($_GET['monhoc']) && $_GET['monhoc'] !== '') {
                    $filters['monhoc'] = $_GET['monhoc'];
                }
                
                if (isset($_GET['format']) && $_GET['format'] !== '') {
                    $filters['format'] = $_GET['format'];
                }
                
                // Xử lý bộ lọc thời gian
                if (isset($_GET['thoigian']) && $_GET['thoigian'] !== '') {
                    switch ($_GET['thoigian']) {
                        case 'today':
                            $filters['tungay'] = date('Y-m-d');
                            $filters['denngay'] = date('Y-m-d');
                            break;
                        case 'week':
                            $filters['tungay'] = date('Y-m-d', strtotime('monday this week'));
                            $filters['denngay'] = date('Y-m-d', strtotime('sunday this week'));
                            break;
                        case 'month':
                            $filters['tungay'] = date('Y-m-01');
                            $filters['denngay'] = date('Y-m-t');
                            break;
                        case 'year':
                            $filters['tungay'] = date('Y-01-01');
                            $filters['denngay'] = date('Y-12-31');
                            break;
                    }
                }
                $documents = layDanhSachDocuments($filters);
                include 'view/DocumentListPage.php';
                break;
                    
            
            case 'userinfo':
                include "view/profile.php"; 
                break;
            
            case 'about':
                include "view/about.php"; 
                break;

            default:
                include "view/home.php";
                break;
        }
    }
    include "view/footer.php"; // Footer cũng chỉ include một lần ở đây
} else {
    header('location: login.php');
    exit;
}
?>