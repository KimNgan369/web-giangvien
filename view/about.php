<?php
ob_start();

// Check if user is logged in
if (isset($_SESSION["role"])) {

    $default_profile = [
        "name" => "TS. Nguyễn Văn A",
        "degree" => "Tiến sĩ Toán học ứng dụng",
        "faculty" => "Khoa Toán - Tin, Đại học For Education",
        "bio" => "Tiến sĩ Nguyễn Văn A là giảng viên có hơn 15 năm kinh nghiệm giảng dạy và nghiên cứu trong lĩnh vực Toán học ứng dụng...",
        "education" => [],
        "experience" => [],
        "projects" => [],
        "avatar" => "layout/img/teacher1.jpg" // default avatar
    ];
    
    $teacher = array_merge($default_profile, $_SESSION['teacher_profile'] ?? []);    
    
    // Only teachers can edit - determine if we're in edit mode
    $isTeacher = ($_SESSION["role"] == 'teacher');
    $isEditing = $isTeacher && isset($_GET['edit']) && $_GET['edit'] == '1';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giới Thiệu Giảng Viên | For Education</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="layout/css/about.css" rel="stylesheet">
</head>
<body>

<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">

            <?php if ($isEditing): ?>
            <!-- Chế độ chỉnh sửa -->
            <form method="post" action="save_profile.php" enctype="multipart/form-data">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                        <div class="col-md-4 text-center">
                            <div class="avatar-wrapper position-relative text-center mb-3">
                                <img src="<?= htmlspecialchars($teacher['avatar'] ?? 'layout/img/teacher1.jpg') ?>" class="img-fluid rounded-circle border border-primary" width="200" id="avatarPreview" alt="Avatar">
                                
                                <!-- Nút chỉnh ảnh -->
                                <label for="avatarInput" class="edit-avatar-btn position-absolute bg-light rounded-circle p-2 border shadow" style="bottom: 0; right: 0; cursor: pointer;">
                                    <i class="fas fa-pen text-primary"></i>
                                </label>
                                <input type="file" name="avatar" id="avatarInput" accept="image/*" class="d-none" onchange="previewAvatar(event)">
                            </div>
                        </div>

                            <div class="col-md-8">
                                <input type="text" class="form-control mb-2" name="name" value="<?= htmlspecialchars($teacher['name']) ?>" placeholder="Họ tên">
                                <input type="text" class="form-control mb-2" name="degree" value="<?= htmlspecialchars($teacher['degree']) ?>" placeholder="Học vị">
                                <input type="text" class="form-control mb-2" name="faculty" value="<?= htmlspecialchars($teacher['faculty']) ?>" placeholder="Khoa/Bộ môn">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Thông tin chi tiết</h5>
                    </div>
                    <div class="card-body">

                        <div class="mb-4">
                            <h6 class="fw-bold text-primary">Giới thiệu</h6>
                            <textarea name="bio" class="form-control" rows="4"><?= htmlspecialchars($teacher['bio']) ?></textarea>
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold text-primary">Trình độ</h6>
                            <div id="educationFields">
                                <?php foreach ($teacher['education'] as $edu): ?>
                                    <input type="text" class="form-control mb-2" name="education[]" value="<?= htmlspecialchars($edu) ?>" placeholder="Trình độ">
                                <?php endforeach; ?>
                            </div>
                            <button type="button" class="btn btn-outline-primary mt-2" onclick="addEducation()">+ Thêm trình độ</button>
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold text-primary">Kinh nghiệm giảng dạy</h6>
                            <div id="experienceFields">
                                <?php foreach ($teacher['experience'] as $exp): ?>
                                    <div class="mb-3">
                                        <input type="text" class="form-control mb-1" name="exp_title[]" value="<?= htmlspecialchars($exp['title']) ?>" placeholder="Chức danh">
                                        <input type="text" class="form-control" name="exp_place[]" value="<?= htmlspecialchars($exp['place']) ?>" placeholder="Nơi công tác">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" class="btn btn-outline-primary mt-2" onclick="addExperience()">+ Thêm kinh nghiệm</button>
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-flask me-2"></i>Nghiên cứu & Dự án</h6>
                            <div class="accordion" id="researchProjects">
                                <?php foreach ($teacher['projects'] as $index => $project): ?>
                                    <div class="accordion-item mb-3">
                                        <h2 class="accordion-header" id="heading<?= $index ?>">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#proj<?= $index ?>">
                                                <?= htmlspecialchars($project['title']) ?>
                                            </button>
                                        </h2>
                                        <div id="proj<?= $index ?>" class="accordion-collapse collapse" data-bs-parent="#researchProjects">
                                            <div class="accordion-body">
                                                <?= nl2br(htmlspecialchars($project['detail'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" class="btn btn-outline-primary mt-2" onclick="addProject()">+ Thêm dự án</button>
                        </div>
                    </div>
                </div>


                <div class="text-end mb-5">
                    <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                    <a href="about.php" class="btn btn-secondary">Hủy</a>
                </div>
            </form>

            <?php else: ?>
            <!-- Chế độ xem -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            <img src="layout/img/teacher1.jpg" class="img-fluid rounded-circle border border-4 border-primary" width="200" alt="Giảng viên">
                        </div>
                        <div class="col-md-8">
                            <h1 class="mb-1"><?= htmlspecialchars($teacher['name']) ?></h1>
                            <p class="text-muted mb-2"><i class="fas fa-graduation-cap me-2 text-primary"></i><?= htmlspecialchars($teacher['degree']) ?></p>
                            <p class="mb-3"><i class="fas fa-university me-2 text-primary"></i><?= htmlspecialchars($teacher['faculty']) ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Thông tin chi tiết</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="fw-bold text-primary mb-3"><i class="fas fa-user-tie me-2"></i>Giới thiệu</h6>
                        <p><?= nl2br(htmlspecialchars($teacher['bio'])) ?></p>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold text-primary">Trình độ</h6>
                        <ul class="list-unstyled">
                            <?php foreach ($teacher['education'] as $edu): ?>
                                <li><i class="fas fa-check-circle text-primary me-2"></i><?= htmlspecialchars($edu) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold text-primary mb-3"><i class="fas fa-briefcase me-2"></i>Kinh nghiệm giảng dạy</h6>
                        <ul class="list-unstyled">
                            <?php foreach ($teacher['experience'] as $exp): ?>
                                <li class="mb-2">
                                    <div class="fw-bold"><?= htmlspecialchars($exp['title']) ?></div>
                                    <div class="text-muted"><?= htmlspecialchars($exp['place']) ?></div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold text-primary mb-3"><i class="fas fa-flask me-2"></i>Nghiên cứu & Dự án</h6>
                        <div class="accordion" id="researchProjects">
                            <?php foreach ($teacher['projects'] as $index => $project): ?>
                                <div class="accordion-item mb-3">
                                    <h2 class="accordion-header" id="heading<?= $index ?>">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#proj<?= $index ?>">
                                            <?= htmlspecialchars($project['title']) ?>
                                        </button>
                                    </h2>
                                    <div id="proj<?= $index ?>" class="accordion-collapse collapse" data-bs-parent="#researchProjects">
                                        <div class="accordion-body">
                                            <?= nl2br(htmlspecialchars($project['detail'])) ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end mb-5">
                <a href="about.php?edit=1" class="btn btn-primary">Chỉnh sửa</a>
            </div>

            <?php endif; ?>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
function addProject() {
    const index = document.querySelectorAll('#researchProjects .accordion-item').length;
    const newProject = `
        <div class="accordion-item mb-3">
            <h2 class="accordion-header" id="heading${index}">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#proj${index}">
                    Dự án mới
                </button>
            </h2>
            <div id="proj${index}" class="accordion-collapse collapse" data-bs-parent="#researchProjects">
                <div class="accordion-body">
                    <input type="text" name="proj_title[]" class="form-control mb-2" placeholder="Tiêu đề dự án">
                    <textarea name="proj_detail[]" class="form-control" rows="3" placeholder="Chi tiết dự án..."></textarea>
                </div>
            </div>
        </div>
    `;
    document.getElementById('researchProjects').insertAdjacentHTML('beforeend', newProject);
}


function addEducation() {
    const newEdu = document.createElement("input");
    newEdu.type = "text";
    newEdu.name = "education[]";
    newEdu.placeholder = "Nhập trình độ mới";
    newEdu.className = "form-control mb-2";
    document.getElementById("educationFields").appendChild(newEdu);
}

function addExperience() {
    const container = document.getElementById("experienceFields");
    const div = document.createElement("div");
    div.className = "mb-3";
    div.innerHTML = `
        <input type="text" class="form-control mb-1" name="exp_title[]" placeholder="Chức danh">
        <input type="text" class="form-control" name="exp_place[]" placeholder="Nơi công tác">
    `;
    container.appendChild(div);
}

function previewAvatar(event) {
        const [file] = event.target.files;
        if (file) {
            document.getElementById('avatarPreview').src = URL.createObjectURL(file);
        }
    }
</script>

</body>
</html>

<?php
} else {
    header("Location: login.php");
    exit;
}
?>
