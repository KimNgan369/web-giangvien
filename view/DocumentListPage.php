<?php
require_once 'models/tailieu.php';

// Lấy danh sách môn học duy nhất
$monhoc_list = pdo_query("SELECT DISTINCT monhoc FROM documents WHERE monhoc IS NOT NULL AND monhoc != ''");

// Xử lý bộ lọc
$filters = [
    'monhoc' => trim($_GET['monhoc'] ?? ''),
    'format' => $_GET['format'] ?? '',
    'thoigian' => $_GET['thoigian'] ?? '',
    'tungay' => '',
    'denngay' => ''
];

// Xử lý thời gian
if (!empty($filters['thoigian']) && in_array($filters['thoigian'], ['today', 'week', 'month', 'year'])) {
    switch ($filters['thoigian']) {
        case 'today':
            $filters['tungay'] = date('Y-m-d 00:00:00');
            $filters['denngay'] = date('Y-m-d 23:59:59');
            break;
        case 'week':
            $filters['tungay'] = date('Y-m-d 00:00:00', strtotime('monday this week'));
            $filters['denngay'] = date('Y-m-d 23:59:59', strtotime('sunday this week'));
            break;
        case 'month':
            $filters['tungay'] = date('Y-m-01 00:00:00');
            $filters['denngay'] = date('Y-m-t 23:59:59');
            break;
        case 'year':
            $filters['tungay'] = date('Y-01-01 00:00:00');
            $filters['denngay'] = date('Y-12-31 23:59:59');
            break;
    }
}

// Lấy danh sách tài liệu từ database
$documents = layDanhSachDocuments($filters);

// Xử lý phân trang
$itemsPerPage = 4;
$totalDocuments = count($documents);
$totalPages = ceil($totalDocuments / $itemsPerPage);
$currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$currentPage = min($currentPage, $totalPages);
$startIndex = ($currentPage - 1) * $itemsPerPage;
$documentsOnPage = array_slice($documents, $startIndex, $itemsPerPage);

$current_url = $_SERVER['PHP_SELF'] . '?act=tailieu';
if (!empty($filters['monhoc'])) $current_url .= '&monhoc=' . urlencode($filters['monhoc']);
if (!empty($filters['format'])) $current_url .= '&format=' . urlencode($filters['format']);
if (!empty($filters['thoigian'])) $current_url .= '&thoigian=' . urlencode($filters['thoigian']);
?>

<!-- Header -->
<header class="bg-light py-4">
    <div class="container">
        <?php
        $title = 'Tài Liệu ';
        $desc = 'Duyệt và tải xuống tài liệu học tập ';
        
        if (!empty($filters['monhoc'])) {
            $title .= htmlspecialchars($filters['monhoc']);
            $desc .= 'cho môn ' . htmlspecialchars($filters['monhoc']);
        } else {
            $title .= 'Tất Cả Môn Học';
            $desc .= 'cho tất cả các môn';
        }
        ?>
        <h1 class="text-center"><?= $title ?></h1>
        <p class="text-center lead"><?= $desc ?></p>
    </div>
</header>

<!-- Main -->
<main class="container my-4">
    <div class="row">
        <!-- Bộ lọc -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Bộ lọc</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="<?= $_SERVER['PHP_SELF'] ?>">
                        <input type="hidden" name="act" value="tailieu">

                        <div class="mb-3">
                            <label for="monhoc-filter" class="form-label">Môn học</label>
                            <select class="form-select" id="monhoc-filter" name="monhoc">
                                <option value="">Tất cả môn học</option>
                                <?php foreach ($monhoc_list as $mh): ?>
                                    <option value="<?= htmlspecialchars($mh['monhoc']) ?>" <?= $filters['monhoc'] == $mh['monhoc'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($mh['monhoc']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="thoigian-filter" class="form-label">Thời gian đăng</label>
                            <select class="form-select" id="thoigian-filter" name="thoigian">
                                <option value="">Tất cả thời gian</option>
                                <option value="today" <?= ($filters['thoigian'] ?? '') === 'today' ? 'selected' : '' ?>>Hôm nay</option>
                                <option value="week" <?= ($filters['thoigian'] ?? '') === 'week' ? 'selected' : '' ?>>Tuần này</option>
                                <option value="month" <?= ($filters['thoigian'] ?? '') === 'month' ? 'selected' : '' ?>>Tháng này</option>
                                <option value="year" <?= ($filters['thoigian'] ?? '') === 'year' ? 'selected' : '' ?>>Năm nay</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="format-filter" class="form-label">Định dạng</label>
                            <select class="form-select" id="format-filter" name="format">
                                <option value="">Tất cả định dạng</option>
                                <option value="pdf" <?= $filters['format'] === 'pdf' ? 'selected' : '' ?>>PDF</option>
                                <option value="doc" <?= $filters['format'] === 'doc' ? 'selected' : '' ?>>Word Doc</option>
                                <option value="pptx" <?= $filters['format'] === 'pptx' ? 'selected' : '' ?>>PowerPoint</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Áp dụng bộ lọc</button>
                            <a href="DocumentListPage.php" class="btn btn-outline-secondary">Đặt lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Danh sách tài liệu -->
        <div class="col-lg-9">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">Tài liệu</h5>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-primary"><?= $totalDocuments ?> tài liệu</span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($documentsOnPage)): ?>
                        <div class="list-group-item document-item p-3 text-center">
                            <i class="fas fa-folder-open fa-2x text-muted mb-2"></i>
                            <p class="mb-0">Không tìm thấy tài liệu nào phù hợp</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($documentsOnPage as $doc): ?>
                            <div class="list-group-item document-item p-3">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h5 class="document-title"><?= htmlspecialchars($doc['title']) ?></h5>
                                        <p class="document-description mb-2"><?= htmlspecialchars($doc['description']) ?></p>
                                        <div class="document-meta">
                                            <span class="document-format format-<?= $doc['format'] ?>"><?= strtoupper($doc['format']) ?></span>
                                            <span class="document-size"><?= $doc['file_size_readable'] ?></span> • 
                                            <span class="document-date"><?= $doc['upload_date_formatted'] ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-md-end document-actions">
                                        <a href="/giuaki/web-giangvien/models/download.php?id=<?= $doc['id'] ?>" class="btn btn-sm btn-download">
                                            <i class="fas fa-download me-1"></i> Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Phân trang -->
            <nav aria-label="Phân trang tài liệu">
                <ul class="pagination justify-content-center" id="pagination">
                    <li class="page-item <?= ($currentPage <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= $current_url . '&page=' . ($currentPage - 1) ?>">Trước</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= ($i === $currentPage) ? 'active' : '' ?>">
                            <a class="page-link" href="<?= $current_url . '&page=' . $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= ($currentPage >= $totalPages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= $current_url . '&page=' . ($currentPage + 1) ?>">Tiếp</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</main>

<script src="layout/js/DocumnetListPage.js"></script>
