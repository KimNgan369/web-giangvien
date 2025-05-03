<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>For Education</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="layout/css/index.css" rel="stylesheet">
    <link href="layout/css/myclass.css" rel="stylesheet">
    <link href="layout/css/DocumentListPage.css" rel="stylesheet">
    

</head>
<body>
        <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php?act=logo">
                <div class="logo-container me-2">
                    <img src="layout/img/logoF.png" width="50" height="50" alt="icon" />
                </div>
                <span class="fw-bold text-primary">For Education</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarContent">
                <!-- Thêm các liên kết vào đây -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?act=about">Giới thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?act=tailieu">Tài liệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?act=khoahoc">Khóa học</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?act=status">Bảng tin</a>
                    </li>
                </ul>
                
                <div class="ms-auto d-flex align-items-center">
                <?php
                if (isset($_SESSION['username']) && ($_SESSION['username'] != "")) {
                    echo '<div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-1"></i> ' . $_SESSION['username'] . '
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="index.php?act=userinfo"><i class="fas fa-user-circle me-2"></i>Thông tin cá nhân</a></li>';
                                
                    if ($_SESSION['role'] == 'admin') {
                        echo '<li><a class="dropdown-item" href="admin/index.php"><i class="fas fa-cogs me-2"></i>Admin Dashboard</a></li>';
                    } elseif ($_SESSION['role'] == 'teacher') {
                        echo '<li><a class="dropdown-item" href="index.php?act=myclasses"><i class="fas fa-chalkboard me-2"></i>Lớp học của tôi</a></li>
                            <li><a class="dropdown-item" href="index.php?act=mydocuments"><i class="fas fa-file-alt me-2"></i>Tài liệu của tôi</a></li>';
                    } elseif ($_SESSION['role'] == 'student') {
                        echo '<li><a class="dropdown-item" href="index.php?act=myclasses"><i class="fas fa-chalkboard me-2"></i>Lớp học của tôi</a></li>';
                    }
                    
                    echo '  <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="index.php?act=logout"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
                            </ul>
                        </div>';
                } else {
                    echo '<a href="index.php?act=login" class="btn btn-primary">Đăng Nhập</a>';
                }
                ?>
                </div>
            </div>
        </div>
    </nav>