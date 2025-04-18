<?php
session_start();
ob_start();

if (isset($_SESSION["role"]) && $_SESSION["role"] == 'teacher') {
    include "view/header.php";
    include_once "models/pdo.php"; 
    include_once "models/doc.php"; 

    // Xử lý khi gửi form upload
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $errors = [];

        $documentName = $_POST['documentName'] ?? '';
        $documentDescription = $_POST['documentDescription'] ?? '';
        $documentDanhmuc = $_POST['documentDanhmuc'] ?? '';
        $classId = $_POST['classId'] ?? null;
        $documentClass = $_POST['documentClass'] ?? '';

        // Truy vấn tên môn học
        if ($classId) {
            $pdo = pdo_get_connection();
            $stmt = $pdo->prepare("SELECT name FROM myclass WHERE class_id = :class_id");
            $stmt->execute([':class_id' => $classId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $documentMonhoc = $row ? $row['name'] : '';
        } else {
            $documentMonhoc = '';
        }

        // Đảm bảo rằng tất cả các trường bắt buộc đã được điền
        if (empty($documentName) || empty($classId) || empty($documentDanhmuc) || empty($documentClass)) {
            $errors[] = "Vui lòng điền đủ thông tin!";
        }

        // Xử lý file tải lên
        $errors = []; // Đảm bảo mảng lỗi được khởi tạo
        $savedFileName = ""; // Tên file lưu vào DB

        if (isset($_FILES['documentFile']) && $_FILES['documentFile']['error'] === 0) {
            $fileName = basename($_FILES['documentFile']['name']);
            $fileTmpName = $_FILES['documentFile']['tmp_name'];
            $fileSize = $_FILES['documentFile']['size'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            // Xác định định dạng tài liệu từ đuôi file
            switch ($fileExtension) {
                case 'pdf':
                    $documentFormat = 'PDF';
                    break;
                case 'doc':
                case 'docx':
                    $documentFormat = 'DOCX';
                    break;
                case 'ppt':
                case 'pptx':
                    $documentFormat = 'PPTX';
                    break;
                case 'xls':
                case 'xlsx':
                    $documentFormat = 'Excel';
                    break;
                default:
                    $documentFormat = 'Unknown';
                    break;
            }

            // Kiểm tra loại file hợp lệ
            $allowedFileTypes = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx'];
            if (!in_array($fileExtension, $allowedFileTypes)) {
                $errors[] = "Chỉ cho phép tải lên các file PDF, DOC, DOCX, PPT, PPTX, Excel!";
            } else {
                // Tạo thư mục nếu chưa có
                if (!is_dir('uploads')) {
                    mkdir('uploads', 0777, true);
                }

                $newFileName = time() . '_' . $fileName;
                $filePath = 'uploads/' . $newFileName;

                if (move_uploaded_file($fileTmpName, $filePath)) {
                    $savedFileName = $newFileName; // Chỉ lưu tên file (không có 'uploads/')
                } else {
                    $errors[] = "Lỗi khi lưu tệp!";
                    error_log("Không thể di chuyển file từ $fileTmpName đến $filePath");
                }
            }
        } else {
            $errors[] = "Vui lòng chọn file tài liệu!";
        }

        // Nếu không có lỗi thì lưu vào database
        if (empty($errors)) {
            $uploaderId = $_SESSION['user_id'] ?? null;
            $fileSize = $_FILES['documentFile']['size'];

            if ($uploaderId && insert_document(
                $documentName,
                $documentDescription,
                $documentFormat,
                $documentDanhmuc,
                $documentClass,
                $documentMonhoc,
                $savedFileName, // chỉ lưu tên file
                $uploaderId,
                $classId,
                $fileSize
            )) {
                echo "<div class='alert alert-success'>Tải tài liệu thành công!</div>";
                header("Location: documents.php");
                exit;
            } else {
                echo "<div class='alert alert-danger'>Lỗi khi tải tài liệu!</div>";
            }
        } else {
            foreach ($errors as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        }
        }
    // Xử lý xóa tài liệu
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
        $documentId = (int)$_GET['id']; // Ép kiểu để tránh SQL injection
        $document = get_document_by_id($documentId);
        
        if (!$document) {
            $_SESSION['error'] = "Tài liệu không tồn tại!";
            header("Location: documents.php");
            exit;
        }

        // Kiểm tra quyền sở hữu
        if ($document['uploader_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = "Bạn không có quyền xóa tài liệu này!";
            header("Location: documents.php");
            exit;
        }

        // Xóa file vật lý trước
        if (file_exists($document['file_path']) && !unlink($document['file_path'])) {
            $_SESSION['error'] = "Không thể xóa file vật lý!";
            header("Location: documents.php");
            exit;
        }

        // Xóa từ database
        if (delete_document($documentId)) {
            $_SESSION['message'] = "Xóa tài liệu thành công!";
        } else {
            $_SESSION['error'] = "Lỗi khi xóa dữ liệu từ database! Chi tiết: " . $conn->errorInfo()[2];
        }
        
        header("Location: documents.php");
        exit;
    }
// Phân trang
$itemsPerPage = 5; // Số item mỗi trang
$currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($currentPage - 1) * $itemsPerPage;

// Lấy tổng số tài liệu
$totalDocuments = count_documents($_SESSION['user_id']); // Bạn cần tạo hàm này trong models/doc.php

// Tính tổng số trang
$totalPages = ceil($totalDocuments / $itemsPerPage);

// Lấy dữ liệu cho trang hiện tại
$documents = get_documents_paginated($_SESSION['user_id'], $offset, $itemsPerPage); // Thay thế hàm get_all_documents()
    // Truy vấn danh sách tài liệu

?>



<!-- HTML Body -->
<body>
<div class="container my-4">
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success"><?= $_SESSION['message'] ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-3">Tài liệu của tôi</h2>
        </div>
        <div class="col-md-4 text-md-end">
            <button class="btn btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#uploadModal">
                <i class="fas fa-plus me-2"></i>Upload tài liệu
            </button>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="documentsTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tên tài liệu</th>
                            <th>Định dạng</th>
                            <th>Ngày tải lên</th>
                            <th>Kích thước</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($documents as $index => $doc): ?>
                            <?php 
                            $filePath = $doc['file_path'];
                            $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                            switch ($fileExtension) {
                                case 'pdf':
                                    $fileIcon = '<i class="fas fa-file-pdf text-danger me-2 fs-4"></i>';
                                    break;
                                case 'doc':
                                case 'docx':
                                    $fileIcon = '<i class="fas fa-file-word text-primary me-2 fs-4"></i>';
                                    break;
                                case 'ppt':
                                case 'pptx':
                                    $fileIcon = '<i class="fas fa-file-powerpoint text-warning me-2 fs-4"></i>';
                                    break;
                                default:
                                    $fileIcon = '<i class="fas fa-file text-secondary me-2 fs-4"></i>';
                            }
                            ?>
                            <tr>
                                <td><?= $index + 1 ?></td> <!-- Sửa ở đây: thay $doc['id'] bằng $index + 1 -->
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?= $fileIcon ?>
                                        <div>
                                            <div class="fw-bold"><?= htmlspecialchars($doc['title']) ?></div>
                                            <div class="text-muted small">Môn: <?= htmlspecialchars($doc['monhoc']) ?> | Lớp: <?= htmlspecialchars($doc['lophoc']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-<?= $fileExtension == 'pdf' ? 'danger' : ($fileExtension == 'doc' || $fileExtension == 'docx' ? 'primary' : 'warning') ?>"><?= strtoupper($fileExtension) ?></span></td>
                                <td><?= date('d/m/Y', strtotime($doc['upload_date'])) ?></td>
                                <td>
                                    <?= format_file_size($doc['file_size']) ?>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-outline-danger delete-btn" 
                                                data-id="<?= $doc['id'] ?>" 
                                                data-name="<?= htmlspecialchars($doc['title']) ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-cloud-upload-alt me-2"></i>Tải lên tài liệu mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="documentName" class="form-label">Tên tài liệu</label>
                        <input type="text" class="form-control" name="documentName" required>
                    </div>
                    <div class="mb-3">
                        <label for="documentDescription" class="form-label">Mô tả</label>
                        <textarea class="form-control" name="documentDescription"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="documentDanhmuc" class="form-label">Danh mục</label>
                        <select class="form-select" name="documentDanhmuc" required>
                            <option value="">Chọn danh mục</option>
                            <option value="Bài giảng">Bài giảng</option>
                            <option value="Đề thi">Đề thi</option>
                            <option value="Tài liệu tham khảo">Tài liệu tham khảo</option>
                            <option value="Bài tập">Bài tập</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="classId" class="form-label">Môn học</label>
                        <select class="form-select" name="classId" required>
                            <option value="">Chọn môn học</option>
                            <?php foreach ($classes as $class): ?>
                                <option value="<?= $class['class_id'] ?>"><?= htmlspecialchars($class['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="documentClass" class="form-label">Lớp học</label>
                        <select class="form-select" name="documentClass" required>
                            <option value="">Chọn lớp học</option>
                            <option value="KHMT-K27">KHMT-K27</option>
                            <option value="KTPM-K27">KTPM-K27</option>
                            <option value="MMT-K27">MMT-K27</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="documentFile" class="form-label">Chọn file</label>
                        <input class="form-control" type="file" name="documentFile" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" name="submit" class="btn btn-primary">Tải lên</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle text-danger me-2"></i>Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa tài liệu <strong id="deleteDocumentName"></strong>?</p>
                <p class="text-danger">Lưu ý: Hành động này không thể hoàn tác.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                <a href="#" class="btn btn-danger" id="confirmDeleteBtn">Xóa</a>
            </div>
        </div>
    </div>
</div>

<!-- Phân trang -->

<nav aria-label="Phân trang tài liệu">
    <ul class="pagination justify-content-center">
        <li class="page-item <?= ($currentPage <= 1) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $currentPage - 1 ?>">Trước</a>
        </li>
        
        <?php 
        // Hiển thị tối đa 5 trang xung quanh trang hiện tại
        $startPage = max(1, $currentPage - 2);
        $endPage = min($totalPages, $currentPage + 2);
        
        // Luôn hiển thị trang đầu nếu cần
        if ($startPage > 1) {
            echo '<li class="page-item"><a class="page-link" href="?page=1">1</a></li>';
            if ($startPage > 2) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
        
        for ($i = $startPage; $i <= $endPage; $i++): ?>
            <li class="page-item <?= ($i === $currentPage) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; 
        
        // Luôn hiển thị trang cuối nếu cần
        if ($endPage < $totalPages) {
            if ($endPage < $totalPages - 1) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
            echo '<li class="page-item"><a class="page-link" href="?page='.$totalPages.'">'.$totalPages.'</a></li>';
        }
        ?>
        
        <li class="page-item <?= ($currentPage >= $totalPages) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $currentPage + 1 ?>">Tiếp</a>
        </li>
    </ul>
</nav>
<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="layout/js/mydocuments.js"></script>

</body>

<?php 
} else {
    header('location: login.php');
    exit;
}
include "view/footer.php";
?>