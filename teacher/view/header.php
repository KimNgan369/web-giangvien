<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Tài liệu Cá nhân - Giảng viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="layout/css/mydocuments.css">
    <link rel="stylesheet" href="layout/css/index.css">

</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <div class="logo-container me-2">
                    <img src="layout/img/logoF.png" width="50" height="50" alt="icon" />
                </div>
                <span class="fw-bold text-primary">For Education</span>
            </a>
        
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
        
            <div class="collapse navbar-collapse" id="navbarContent">
            
                <div class="ms-auto d-flex align-items-center">
                    <!-- Khi đã đăng nhập sẽ hiển thị tên người dùng -->
                    <div class="dropdown teacher-profile">
                        <a href="#" class="d-flex align-items-center text-decoration-none" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="me-2 position-relative">
                            </div>
                            <div>
                                <span class="d-block fw-bold text-dark">Nguyễn Văn A</span>
                                <small class="text-muted">Giảng viên</small>
                            </div>
                            
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Thông tin cá nhân</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-text me-2"></i>Tài liệu của tôi</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-people me-2"></i>Lớp học của tôi</a></li>
                            <li><a class="dropdown-item text-danger" href="index.php?act=logout"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>