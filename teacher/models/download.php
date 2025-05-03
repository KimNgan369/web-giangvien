// Thay phần đầu file bằng:
<?php
require_once 'pdo.php';
require_once 'tailieu.php';

session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die("ID tài liệu không hợp lệ");
}

$docId = (int)$_GET['id'];
$document = get_document_by_id($docId);

if (!$document) {
    die("Tài liệu không tồn tại");
}

// Sửa đường dẫn tại đây
$filePath = '../uploads/' . $document['file_path'];

if (!file_exists($filePath)) {
    die("File không tồn tại tại: " . htmlspecialchars($filePath));
}

// Thiết lập headers
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"" . basename($filePath) . "\"");
header("Content-Length: " . filesize($filePath));

readfile($filePath);
exit;