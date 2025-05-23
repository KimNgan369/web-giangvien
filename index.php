<?php
session_start();
ob_start();

//Nhúng kết nối CSDL
include "models/pdo.php";
include "models/user.php";
include "models/class.php";
include "view/header.php";
include "models/tailieu.php";

//data cho trang chu 

if (!isset($_GET['act'])) {
    include "view/home.php";
} else {
    switch ($_GET['act']) {

        case 'gioithieu':
            include "view/gioithieu.php";
            break;
        case 'login':
            // Nếu đã đăng nhập thì chuyển về trang chủ
            if (isset($_SESSION['username']) && ($_SESSION['username'] != "")) {
                header('location: index.php');
                exit;
            }
            
            $error = '';
            if (isset($_POST['login']) && ($_POST['login'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                
                $userInfo = checkuser($username, $password);
                
                if ($userInfo) {
                    // Đăng nhập thành công
                    $_SESSION['role'] = $userInfo['role'];
                    $_SESSION['iduser'] = $userInfo['id'];
                    $_SESSION['username'] = $userInfo['username'];
                    
                    // Regenerate session ID để tăng cường bảo mật
                    session_regenerate_id(true);
                    
                    if ($userInfo['role'] == 'teacher') {
                        header('location: teacher/index.php?act=mydocuments');
                    } else if ($userInfo['role'] == 'admin') {
                        header('location: admin/index.php');
                    } else {
                        header('location: index.php');
                    }
                    exit;
                } else {
                    $error = 'Tên đăng nhập hoặc mật khẩu không đúng!';
                }
            }
            include "view/login.php";
            break;
            
        case 'logout':
            if(isset($_SESSION['role'])) {
                unset($_SESSION['role']);
                unset($_SESSION['username']);
                unset($_SESSION['iduser']);
                session_destroy();
            }
            header('location: index.php');
            exit;
            break;

        case 'mydocuments':
            header('location: teacher/index.php?act=mydocuments');
            break;

        case'myclasses':
            $classes = get_myclass();
            include "view/myclass.php";
            break;

        case'khoahoc':
            $classes = get_myclass();
            include "view/myclass.php";
            break;
        
        case'logo':
            include "view/home.php";
            break;
    
        case'userinfo':
            include "view/profile.php";
            break;
        
        // case 'mydocuments':
        //     include "teacher/documents.php"; // documents.php sẽ không include header/footer nữa
        //     break;

        case 'tailieu':
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
            
            // header('location: student/view/status1.php');
            include "view/status.php";
            break;

        case'about':
            include "view/about.php";
            break;

        default:
            include "view/home.php";
            break;
    }
}

include "view/footer.php";
?>