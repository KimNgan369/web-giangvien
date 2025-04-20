<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$mysqli = new mysqli("localhost", "root", "", "education");
$user_id = $_SESSION['user_id'] ?? 1;

$stmt = $mysqli->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && $user['role'] == 'teacher') {
    include "header.php";
    require_once '../models/pdo.php';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ Sơ Người Dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../layout/css/profile.css">
    <link rel="stylesheet" href="../layout/css/index.css">
    <style>
    .edit-section input, .edit-section textarea { display: none; }
    .edit-section.editing input, .edit-section.editing textarea { display: block; }
    .edit-section.editing span { display: none; }
  </style>
</head>
<body>

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3">
                <div class="card profile-sidebar">
                    <div class="card-body text-center">
                    <h5 class="mb-1"><?= htmlspecialchars($user['full_name']) ?></h5>
                        <p class="text-muted mb-3">
                            <?php
                                switch ($user['role']) {
                                    case 'teacher':
                                        echo 'Giảng viên';
                                        break;
                                    case 'student':
                                        echo 'Học viên';
                                        break;
                                    default:
                                        echo 'Người dùng';
                                        break;
                                }
                            ?>
                        </p>
                        <ul class="nav flex-column">
                            <li class="nav-item"><a class="nav-link active" href="#profile" data-bs-toggle="tab"><i class="fas fa-user-circle me-2"></i> Thông tin cá nhân</a></li>
                            <li class="nav-item"><a class="nav-link" href="#password" data-bs-toggle="tab"><i class="fas fa-key me-2"></i> Đổi mật khẩu</a></li>
                            <a class="nav-link" href="logout.php" id="logoutLink"><i class="fas fa-sign-out-alt me-2"></i> Đăng xuất</a>
                            </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="card profile-content">
                    <div class="card-header bg-primary text-white"><h4 class="mb-0"><i class="fas fa-user-cog me-2"></i>Hồ sơ người dùng</h4></div>
                    <div class="card-body">
                    <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">Cập nhật thành công!</div>
                    <?php endif; ?>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="profile">
                                <form method="post" action="save_profile.php" id="profileForm">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <div class="row mb-4">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Họ và tên</label>
                                            <input type="text" class="form-control" name="fullname" value="<?= htmlspecialchars($user['full_name']) ?>" readonly>
                                            </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user['email']) ?>" readonly>
                                            </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Số điện thoại</label>
                                            <input type="tel" class="form-control" name="phone" value="<?= isset($user['phone']) ? htmlspecialchars($user['phone']) : '' ?>" readonly>
                                            </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Ngày sinh</label>
                                            <input type="date" class="form-control" name="dob" value="<?= isset($user['dob']) ? htmlspecialchars($user['dob']) : '' ?>" readonly>
                                            </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Địa chỉ</label>
                                            <input type="text" class="form-control" name="address" value="<?= isset($user['address']) ? htmlspecialchars($user['address']) : '' ?>" readonly>
                                            </div>
                                    </div>
                                    <?php if ($user['role'] === 'teacher'): ?>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" id="editProfileBtn" class="btn btn-warning"><i class="fas fa-edit me-1"></i> Chỉnh sửa</button>
                                    </div>
                                    <button type="submit" id="saveChangesBtn" class="btn btn-primary mt-3 d-none"><i class="fas fa-save me-1"></i> Lưu thay đổi</button>
                                    <?php endif; ?>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="password">
                            <form method="post" action="change_password.php">
                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                <div class="row mb-4">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Mật khẩu hiện tại</label>
                                        <input type="password" class="form-control" name="current_password" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Mật khẩu mới</label>
                                        <input type="password" class="form-control" name="new_password" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nhập lại mật khẩu mới</label>
                                        <input type="password" class="form-control" name="confirm_password" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-key me-1"></i> Đổi mật khẩu</button>
                            </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (isset($_GET['success']) && $_GET['success'] === 'password'): ?>
        <div class="alert alert-success">Đổi mật khẩu thành công!</div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?php
                switch ($_GET['error']) {
                    case 'wrongpassword':
                        echo "Mật khẩu hiện tại không đúng!";
                        break;
                    case 'notmatch':
                        echo "Mật khẩu mới không khớp!";
                        break;
                    case 'updatefail':
                        echo "Lỗi khi cập nhật mật khẩu!";
                        break;
                    case 'notfound':
                        echo "Không tìm thấy người dùng!";
                        break;
                    default:
                        echo "Đã xảy ra lỗi.";
                        break;
                }
            ?>
        </div>
    <?php endif; ?>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editBtn = document.getElementById('editProfileBtn');
            const saveBtn = document.getElementById('saveChangesBtn');
            const deleteBtn = document.getElementById('deleteProfileBtn');
            const inputs = document.querySelectorAll('#profileForm input, #profileForm textarea, #profileForm select');

            if (editBtn) {
                editBtn.addEventListener('click', function () {
                    inputs.forEach(input => {
                        input.removeAttribute('readonly');
                        input.removeAttribute('disabled');
                    });
                    saveBtn.classList.remove('d-none');
                    editBtn.classList.add('d-none');
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
        const logoutLink = document.getElementById('logoutLink');
        if (logoutLink) {
            logoutLink.addEventListener('click', function (e) {
                const confirmLogout = confirm("Bạn có chắc chắn muốn đăng xuất?");
                if (!confirmLogout) {
                    e.preventDefault(); // Ngăn chuyển trang nếu người dùng chọn Hủy
                }
            });
        }
    });
</script>

    <footer class="bg-dark text-white py-4 mt-5"><div class="text-center"><p class="mb-0">&copy; 2025 For Education.</p></div></footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="..layout/js/profile.js"></script>
</body>
</html>
