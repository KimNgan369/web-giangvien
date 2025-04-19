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
        // case 'shop':
        //     $dssp=get_dssp(6);
        //     include "view/shop.php";
        //     break;
        // case 'gioithieu':
        //     include "view/gioithieu.php";
        //     break;
        // case 'login':
        //     // Nếu đã đăng nhập thì chuyển về trang chủ
        //     if (isset($_SESSION['username']) && ($_SESSION['username'] != "")) {
        //         header('location: index.php');
        //         exit;
        //     }
            
        //     $error = '';
        //     if (isset($_POST['login']) && ($_POST['login'])) {
        //         $username = $_POST['username'];
        //         $password = $_POST['password'];
                
        //         $userInfo = checkuser($username, $password);
                
        //         if ($userInfo) {
        //             // Đăng nhập thành công
        //             $_SESSION['role'] = $userInfo['role'];
        //             $_SESSION['iduser'] = $userInfo['id'];
        //             $_SESSION['username'] = $userInfo['username'];
                    
        //             // Regenerate session ID để tăng cường bảo mật
        //             session_regenerate_id(true);
                    
        //             if ($userInfo['role'] == 'teacher') {
        //                 header('location: teacher/index.php');
        //             } else if ($userInfo['role'] == 'admin') {
        //                 header('location: admin/index.php');
        //             } else {
        //                 header('location: index.php');
        //             }
        //             exit;
        //         } else {
        //             $error = 'Tên đăng nhập hoặc mật khẩu không đúng!';
        //         }
        //     }
        //     include "view/login.php";
        //     break;
            
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

        case'myclasses':
            $classes = get_myclass();
            include "view/myclass.php";
            break;
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
            
                
            
        case'status':
            include "view/status.php";
            break;
            
        default:
            include "view/home.php";
            break;
    }
}

include "view/footer.php";
?>