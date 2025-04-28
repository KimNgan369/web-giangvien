<?php
// This file would be saved as "teacher/view/status.php"
// require_once 'models/pdo.php';
// require_once 'models/status.php';
// require_once 'models/user.php';

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$currentUser = null;

if ($isLoggedIn) {
    $currentUser = getUserById($_SESSION['user_id']);
}

// Handle form submissions (only for teacher role)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION["role"]) && $_SESSION["role"] == 'teacher') {
    // Create new status
    if (isset($_POST['action']) && $_POST['action'] === 'create_status') {
        if (!$isLoggedIn) {
            header('Location: index.php?act=login');
            exit;
        }
        
        $content = trim($_POST['content']);
        $image_path = null;
        
        // Handle image upload if present
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../uploads/status/';
            
            // Create directory if it doesn't exist
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $file_name = uniqid('status_') . '.' . $file_extension;
            $upload_path = $upload_dir . $file_name;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                // $image_path = $upload_path;
                // Lưu đường dẫn tương đối từ gốc ứng dụng (project/) vào database
                $image_path = '../uploads/status/' . $file_name;
            }
        }

        // if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        //     // Đường dẫn tuyệt đối từ file teacher/view/status.php
        //     $upload_dir = __DIR__ . '/../uploads/status/'; 
            
        //     // Tạo thư mục nếu chưa tồn tại
        //     if (!file_exists($upload_dir)) {
        //         mkdir($upload_dir, 0777, true);
        //     }
            
        //     $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        //     $file_name = uniqid('status_') . '.' . $file_extension;
        //     $upload_path = $upload_dir . $file_name;
            
        //     if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
        //         // Lưu đường dẫn tương đối từ gốc ứng dụng (project/) vào database
        //         $image_path = 'teacher/uploads/status/' . $file_name;
        //     }
        // }
        
        if (!empty($content)) {
            if (createStatus($_SESSION['user_id'], $content, $image_path)) {
                // Redirect to prevent form resubmission
                header('Location: index.php?act=status&success=posted');
                exit;
            } else {
                $error = "Không thể đăng trạng thái. Vui lòng thử lại.";
            }
        } else {
            $error = "Nội dung không được để trống.";
        }
    }
    
    // Delete status
    if (isset($_POST['action']) && $_POST['action'] === 'delete_status') {
        if (!$isLoggedIn) {
            header('Location: index.php?act=login');
            exit;
        }
        
        $status_id = $_POST['status_id'];
        
        // Check if user is the owner of the status
        if (isStatusOwner($status_id, $_SESSION['user_id'])) {
            // Get status to delete the image if exists
            $status = getStatusById($status_id);
            
            if (deleteStatus($status_id)) {
                // Delete image file if exists
                if (!empty($status['image_path']) && file_exists($status['image_path'])) {
                    unlink($status['image_path']);
                }
                
                header('Location: index.php?act=status&success=deleted');
                exit;
            } else {
                $error = "Không thể xóa trạng thái. Vui lòng thử lại.";
            }
        } else {
            $error = "Bạn không có quyền xóa trạng thái này.";
        }
    }
}

function formatTimeAgo($datetime) {
    $now = new DateTime();
    $past = new DateTime($datetime);
    $diff = $now->diff($past);
    
    // Tính tổng số giây
    $totalSeconds = $diff->s + ($diff->i * 60) + ($diff->h * 3600) + ($diff->d * 86400) + ($diff->m * 2592000) + ($diff->y * 31536000);
    
    if ($totalSeconds < 5) {
        return 'Vừa xong';
    }
    
    if ($diff->y > 0) {
        return $diff->y . ' năm trước';
    }
    if ($diff->m > 0) {
        return $diff->m . ' tháng trước';
    }
    if ($diff->d > 0) {
        return $diff->d . ' ngày trước';
    }
    if ($diff->h > 0) {
        return $diff->h . ' giờ trước';
    }
    if ($diff->i > 0) {
        return $diff->i . ' phút trước';
    }
    
    return $diff->s . ' giây trước';
}
?>

<!-- Main Content -->
<main class="container my-5">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold text-dark mb-0"><i class="fas fa-comment-alt me-2 text-primary"></i>Bảng tin</h2>
        </div>
        <div class="col-md-6 text-md-end">
            <!-- Nút đăng bài chỉ hiển thị cho giáo viên đã đăng nhập -->
            <?php if ($isLoggedIn && $_SESSION["role"] == 'teacher'): ?>
            <button class="btn btn-primary" id="createPostBtn" data-bs-toggle="modal" data-bs-target="#createPostModal">
                <i class="fas fa-plus me-1"></i> Đăng bài
            </button>
            <?php endif; ?>
        </div>
    </div>
    
    <?php if (isset($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $error; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['success']) && $_GET['success'] === 'posted'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Đăng bài thành công!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['success']) && $_GET['success'] === 'deleted'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Xóa bài thành công!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>
    
    <!-- Phần bảng tin -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Danh sách bài đăng -->
            <div class="post-list">
                <?php if (empty($statuses)): ?>
                <div class="card shadow-sm mb-4">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-comment-slash fa-3x text-muted mb-3"></i>
                        <h5>Chưa có bài đăng nào</h5>
                        <?php if ($isLoggedIn && $_SESSION["role"] == 'teacher'): ?>
                        <p>Hãy là người đầu tiên chia sẻ điều gì đó!</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPostModal">
                            <i class="fas fa-plus me-1"></i> Đăng bài
                        </button>
                        <?php else: ?>
                        <p>Chưa có thông báo nào từ giáo viên.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php else: ?>
                    <?php foreach ($statuses as $status): ?>
                    <div class="card shadow-sm mb-4 post">
                        <div class="card-header bg-white d-flex align-items-center justify-content-between p-3">
                            <div class="d-flex align-items-center">
                                <img src="<?php echo !empty($status['avatar_path']) ? $status['avatar_path'] : 'layout/img/teacher1.jpg'; ?>" 
                                     class="rounded-circle avatar me-3" alt="Avatar" style="width: 40px; height: 40px; object-fit: cover;">
                                <div>
                                    <h6 class="mb-0 fw-bold"><?php echo htmlspecialchars($status['full_name'] ?? $status['username']); ?></h6>
                                    <small class="text-muted"><?php echo formatTimeAgo($status['created_at']); ?> • <i class="fas fa-globe-asia"></i></small>
                                </div>
                            </div>
                            <?php if ($isLoggedIn && $_SESSION["role"] == 'teacher' && $status['user_id'] == $_SESSION['user_id']): ?>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light" type="button" id="dropdownMenuButton<?php echo $status['id']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton<?php echo $status['id']; ?>">
                                    <li>
                                        <form method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài đăng này?');">
                                            <input type="hidden" name="action" value="delete_status">
                                            <input type="hidden" name="status_id" value="<?php echo $status['id']; ?>">
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-trash-alt me-2"></i> Xóa bài đăng
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><?php echo nl2br(htmlspecialchars($status['content'])); ?></p>
                            <?php if (!empty($status['image_path'])): ?>
                            <div class="post-image mb-3">
                                <img src="<?php echo $status['image_path']; ?>" class="img-fluid rounded" alt="Status image">
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            
                <!-- Phân trang -->
                <?php if ($totalPages > 1): ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="index.php?act=status&page=<?php echo $page - 1; ?>" tabindex="-1">Trước</a>
                        </li>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                            <a class="page-link" href="index.php?act=status&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                        <?php endfor; ?>
                        <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="index.php?act=status&page=<?php echo $page + 1; ?>">Tiếp</a>
                        </li>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<!-- Modal Đăng bài (chỉ hiển thị cho giáo viên) -->
<div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPostModalLabel">Tạo bài đăng mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="postForm" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="create_status">
                    <div class="mb-3">
                        <textarea class="form-control" id="postContent" name="content" rows="4" placeholder="Bạn muốn chia sẻ điều gì?" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="postImage" class="form-label">Thêm ảnh (không bắt buộc)</label>
                        <input type="file" class="form-control" id="postImage" name="image" accept="image/*">
                    </div>
                    <div id="imagePreview" class="mb-3 d-none">
                        <img src="" class="img-fluid rounded" id="previewImg" alt="Preview">
                        <button type="button" class="btn btn-outline-danger btn-sm mt-2" id="removeImage">
                            <i class="fas fa-times me-1"></i> Xóa ảnh
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" form="postForm" class="btn btn-primary" id="publishPost">Đăng bài</button>
            </div>
        </div>
    </div>
</div>

<script>
// Preview image before upload
document.getElementById('postImage').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('d-none');
        }
        reader.readAsDataURL(file);
    }
});

// Remove image
document.getElementById('removeImage').addEventListener('click', function() {
    document.getElementById('postImage').value = '';
    document.getElementById('imagePreview').classList.add('d-none');
});
</script>