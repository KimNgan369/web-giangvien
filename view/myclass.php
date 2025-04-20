<?php
$html_class = '';
foreach ($classes as $class) {
    extract($class);
    $html_class .= '<div class="col-lg-4 col-md-6 mb-4">
        <div class="card subject-card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">' . htmlspecialchars($name) . '</h5>
            </div>
            <div class="card-body">
                <p class="card-text"><i class="fas fa-chalkboard-teacher me-2"></i>Giảng viên: ' . htmlspecialchars($teacher_name) . '</p>
                <p class="card-text"><i class="fas fa-clock me-2"></i>' . htmlspecialchars($schedule) . '</p>
                <p class="card-text"><i class="fas fa-university me-2"></i>' . htmlspecialchars($room) . '</p>
            </div>
            <div class="card-footer bg-transparent">
                <a href="index.php?act=tailieu&monhoc=' . urlencode($name) . '&thoigian=&format=" class="btn btn-outline-primary btn-sm ms-2">Tài liệu</a>
            </div>
        </div>
    </div>';
}

?>
  
  
  
  
  <!-- Main Content -->
    <div class="container my-5">
        <div class="row">
            <?=$html_class?>
            <!-- <div class="col-lg-4 col-md-6 mb-4">
                <div class="card subject-card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Toán cao cấp</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><i class="fas fa-chalkboard-teacher me-2"></i>Giảng viên: Nguyễn Văn A</p>
                        <p class="card-text"><i class="fas fa-clock me-2"></i>Thứ 2, 7:30 - 9:30</p>
                        <p class="card-text"><i class="fas fa-university me-2"></i>Phòng D201</p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="#" class="btn btn-outline-primary btn-sm ms-2">Tài liệu</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card subject-card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Lập trình cơ bản</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><i class="fas fa-chalkboard-teacher me-2"></i>Giảng viên: Nguyễn Văn A</p>
                        <p class="card-text"><i class="fas fa-clock me-2"></i>Thứ 3, 13:00 - 15:00</p>
                        <p class="card-text"><i class="fas fa-university me-2"></i>Phòng Lab A102</p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="#" class="btn btn-outline-primary btn-sm ms-2">Tài liệu</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card subject-card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Cơ sở dữ liệu</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><i class="fas fa-chalkboard-teacher me-2"></i>Giảng viên: Nguyễn Văn A</p>
                        <p class="card-text"><i class="fas fa-clock me-2"></i>Thứ 4, 9:30 - 11:30</p>
                        <p class="card-text"><i class="fas fa-university me-2"></i>Phòng D305</p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="#" class="btn btn-outline-primary btn-sm ms-2">Tài liệu</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card subject-card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Trí tuệ nhân tạo</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><i class="fas fa-chalkboard-teacher me-2"></i>Giảng viên: Nguyễn Văn A</p>
                        <p class="card-text"><i class="fas fa-clock me-2"></i>Thứ 5, 15:00 - 17:00</p>
                        <p class="card-text"><i class="fas fa-university me-2"></i>Phòng Lab B203</p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="#" class="btn btn-outline-primary btn-sm ms-2">Tài liệu</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card subject-card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Phát triển web</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><i class="fas fa-chalkboard-teacher me-2"></i>Giảng viên: Nguyễn Văn A</p>
                        <p class="card-text"><i class="fas fa-clock me-2"></i>Thứ 6, 7:30 - 9:30</p>
                        <p class="card-text"><i class="fas fa-university me-2"></i>Phòng Lab A101</p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="#" class="btn btn-outline-primary btn-sm ms-2">Tài liệu</a>
                    </div>
                </div>
            </div> -->

        </div>
    </div>