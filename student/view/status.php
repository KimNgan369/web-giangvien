<?php
// This file would be saved as "student/view/status.php"
require_once 'models/pdo.php';
require_once 'models/status.php';
require_once 'models/user.php';

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
        <div class="col">
            <h2 class="fw-bold text-dark mb-0"><i class="fas fa-comment-alt me-2 text-primary"></i>Bảng tin</h2>
            <p class="text-muted">Xem các thông báo và bài đăng từ giáo viên</p>
        </div>
    </div>
    
    <!-- Phần bảng tin (chỉ xem) -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Danh sách bài đăng -->
            <div class="post-list">
                <?php if (empty($statuses)): ?>
                <div class="card shadow-sm mb-4">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-comment-slash fa-3x text-muted mb-3"></i>
                        <h5>Chưa có bài đăng nào</h5>
                        <p>Hiện tại chưa có thông báo nào từ giáo viên.</p>
                    </div>
                </div>
                <?php else: ?>
                    <?php foreach ($statuses as $status): ?>
                    <div class="card shadow-sm mb-4 post">
                        <div class="card-header bg-white d-flex align-items-center p-3">
                            <div class="d-flex align-items-center">
                                <img src="<?php echo !empty($status['avatar_path']) ? $status['avatar_path'] : 'layout/img/teacher1.jpg'; ?>" 
                                     class="rounded-circle avatar me-3" alt="Avatar" style="width: 40px; height: 40px; object-fit: cover;">
                                <div>
                                    <h6 class="mb-0 fw-bold"><?php echo htmlspecialchars($status['full_name'] ?? $status['username']); ?></h6>
                                    <small class="text-muted"><?php echo formatTimeAgo($status['created_at']); ?> • <i class="fas fa-globe-asia"></i></small>
                                </div>
                            </div>
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