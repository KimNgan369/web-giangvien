<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>For Education</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="layout/css/index.css" rel="stylesheet">

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
                <div class="d-flex align-items-center me-auto">
                    <div class="dropdown">
                        <button class="btn btn-link text-dark text-decoration-none dropdown-toggle" type="button" id="exploreDropdown" data-bs-toggle="dropdown">
                            khám phá
                        </button>
                      
                        <div class="dropdown-menu p-3" aria-labelledby="exploreDropdown" style="width: 250px;">
                          <div class="row">
                      
                            <!--subjects -->
                            <!-- <div class="col-6">
                              <h6 class="text-uppercase fw-bold mb-2">Chủ đề</h6>
                              <a class="dropdown-item" href="#">Khoa Học Máy Tính</a>
                              <a class="dropdown-item" href="#">Kĩ thuật Phần Mềm</a>
                              <a class="dropdown-item" href="#">An Ninh Mạng</a>
                            </div> -->

                            <div class="col-6">
                                <h6 class="text-uppercase fw-bold mb-2">Môn học</h6>
                                <a class="dropdown-item" href="#">Toán cao cấp</a>
                                <a class="dropdown-item" href="#">Lập trình cơ bản</a>
                                <a class="dropdown-item" href="#">Cơ sở dữ liệu</a>
                                <a class="dropdown-item" href="#">Trí tuệ nhân tạo</a>
                                <a class="dropdown-item" href="#">Phát triển web</a>
                            </div>

                          </div>
                        </div>
                      </div>                      
                    
                    <div class="search-container ms-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                </svg>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Search">
                        </div>
                    </div>
                </div>
                
                <div class="ms-auto d-flex align-items-center">
                    <a href="#" class="btn btn-link text-dark me-2">Đăng Ký</a>
                    <a href="#" class="btn btn-primary">Đăng Nhập</a>
                </div>
            </div>
        </div>
    </nav>