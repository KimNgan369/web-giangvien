<?php
session_start();
ob_start();

//Nhúng kết nối CSDL
include "models/pdo.php";
include "models/user.php";

include "view/header.php";

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
                        header('location: teacher/index.php');
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
            
        default:
            include "view/home.php";
            break;
    }
}

include "view/footer.php";
?>