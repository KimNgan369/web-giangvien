<?php
session_start();
ob_start();

if (isset($_SESSION["role"]) && $_SESSION["role"] == 'teacher') {
    include "header.php";
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giới Thiệu Giảng Viên | For Education</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="../layout/css/about.css" rel="stylesheet">

</head>
<body>

<main class="container my-5">
    <div class="row justify-content-center">
        <!-- Main Profile -->
        <div class="col-lg-10 col-xl-8">
            <form id="profileForm">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-4 text-center mb-3 mb-md-0">
                                <img src="../layout/img/teacher1.jpg" class="img-fluid rounded-circle border border-4 border-primary" width="200" height="200" alt="Giảng viên">
                            </div>
                            <div class="col-md-8">
                                <h1 class="mb-1 editable" contenteditable="false">TS. Nguyễn Văn A</h1>
                                <p class="text-muted mb-2"><i class="fas fa-graduation-cap me-2 text-primary"></i><span class="editable" contenteditable="false">Tiến sĩ Toán học ứng dụng</span></p>
                                <p class="mb-3"><i class="fas fa-university me-2 text-primary"></i><span class="editable" contenteditable="false">Khoa Toán - Tin, Đại học For Education</span></p>

                                <div class="social-links">
                                    <a href="#" class="btn btn-sm btn-outline-primary me-2"><i class="fab fa-facebook-f"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thông tin chi tiết -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Thông tin chi tiết</h5>
                    </div>
                    <div class="card-body">
                        <!-- Giới thiệu -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-user-tie me-2"></i>Giới thiệu</h6>
                            <p class="mb-0 editable" contenteditable="false">
                                Tiến sĩ Nguyễn Văn A là giảng viên có hơn 15 năm kinh nghiệm giảng dạy và nghiên cứu trong lĩnh vực Toán học ứng dụng. Thầy đã công bố nhiều bài báo khoa học trên các tạp chí quốc tế uy tín và tham gia nhiều dự án nghiên cứu cấp Nhà nước.
                            </p>
                        </div>

                        <!-- Trình độ -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-graduation-cap me-2"></i>Trình độ</h6>
                            <ul class="list-unstyled editable-list">
                                <li class="mb-2"><i class="fas fa-check-circle me-2 text-accent"></i><span contenteditable="false">Tiến sĩ Toán học ứng dụng - Đại học Paris 6 (2010)</span></li>
                                <li class="mb-2"><i class="fas fa-check-circle me-2 text-accent"></i><span contenteditable="false">Thạc sĩ Toán học - Đại học Quốc gia Hà Nội (2005)</span></li>
                                <li class="mb-2"><i class="fas fa-check-circle me-2 text-accent"></i><span contenteditable="false">Cử nhân Sư phạm Toán - Đại học Sư phạm Hà Nội (2002)</span></li>
                            </ul>
                        </div>

                        <!-- Kinh nghiệm -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-briefcase me-2"></i>Kinh nghiệm giảng dạy</h6>
                            <ul class="list-unstyled editable-list">
                                <li class="mb-2">
                                    <div class="fw-bold" contenteditable="false">Giảng viên chính</div>
                                    <div class="text-muted" contenteditable="false">Khoa Toán - Tin, Đại học For Education (2010 - nay)</div>
                                </li>
                                <li class="mb-2">
                                    <div class="fw-bold" contenteditable="false">Giảng viên thỉnh giảng</div>
                                    <div class="text-muted" contenteditable="false">Đại học Bách Khoa Hà Nội (2015 - 2018)</div>
                                </li>
                                <li class="mb-2">
                                    <div class="fw-bold" contenteditable="false">Trợ giảng</div>
                                    <div class="text-muted" contenteditable="false">Đại học Paris 6 (2008 - 2010)</div>
                                </li>
                            </ul>
                        </div>

                        <!-- Nghiên cứu & Dự án -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-project-diagram me-2"></i>Nghiên cứu & Dự án</h6>
                            <div class="accordion" id="researchAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Ứng dụng Toán học trong AI (2020-2022)
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#researchAccordion">
                                        <div class="accordion-body editable" contenteditable="false">
                                            Nghiên cứu ứng dụng các phương pháp toán học trong phát triển thuật toán AI. Dự án hợp tác với Đại học Bách Khoa Hà Nội và một số doanh nghiệp công nghệ.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Mô hình hóa hệ thống phức tạp (2017-2019)
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#researchAccordion">
                                        <div class="accordion-body editable" contenteditable="false">
                                            Nghiên cứu phát triển các mô hình toán học để mô phỏng hệ thống phức tạp trong kinh tế và xã hội. Đề tài cấp Nhà nước.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Nút Chỉnh sửa -->
                        <div class="text-end mt-4">
                            <button type="button" id="editBtn" class="btn btn-warning">Chỉnh sửa thông tin</button>
                            <button type="submit" id="saveBtn" class="btn btn-success d-none">Lưu thay đổi</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const editBtn = document.getElementById('editBtn');
    const saveBtn = document.getElementById('saveBtn');
    const editableFields = document.querySelectorAll('.editable, .editable-list span, .editable-list div');

    editBtn.addEventListener('click', () => {
        editableFields.forEach(el => el.contentEditable = true);
        editBtn.classList.add('d-none');
        saveBtn.classList.remove('d-none');
    });

    saveBtn.addEventListener('click', (e) => {
        e.preventDefault();
        editableFields.forEach(el => el.contentEditable = false);
        editBtn.classList.remove('d-none');
        saveBtn.classList.add('d-none');
        // TODO: Gửi dữ liệu về server bằng AJAX nếu muốn
    });
</script>
</body>
</html>

<?php 
} else {
    header('location: login.php');
    exit;
}
include "footer.php";
?>
