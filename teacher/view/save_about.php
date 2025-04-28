<?php
session_start();
ob_start();
require_once "../models/pdo.php"; // Kết nối MySQL bằng PDO

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Nhận dữ liệu từ form
$name = $_POST['name'] ?? '';
$degree = $_POST['degree'] ?? '';
$faculty = $_POST['faculty'] ?? '';
$bio = $_POST['bio'] ?? '';
$education = $_POST['education'] ?? [];
$experience_titles = $_POST['exp_title'] ?? [];
$experience_places = $_POST['exp_place'] ?? [];
$projects_titles = $_POST['proj_title'] ?? [];
$projects_details = $_POST['proj_detail'] ?? [];

// Xử lý avatar (nếu có)
$avatar_path = null;
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = "../layout/img/";
    $filename = "avatar_" . time() . "_" . basename($_FILES['avatar']['name']);
    $target_file = $upload_dir . $filename;

    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file)) {
        $avatar_path = $target_file;
    }
}

// Gộp dữ liệu JSON cho các mục phức tạp
$experience = [];
foreach ($experience_titles as $i => $title) {
    $experience[] = [
        "title" => $title,
        "place" => $experience_places[$i] ?? ''
    ];
}

$projects = [];
foreach ($projects_titles as $i => $title) {
    $projects[] = [
        "title" => $title,
        "detail" => $projects_details[$i] ?? ''
    ];
}

$education_json = json_encode($education, JSON_UNESCAPED_UNICODE);
$experience_json = json_encode($experience, JSON_UNESCAPED_UNICODE);
$projects_json = json_encode($projects, JSON_UNESCAPED_UNICODE);

// Chuẩn bị câu SQL
$sql = "UPDATE users 
        SET full_name = :name, 
            degree = :degree, 
            faculty = :faculty, 
            bio = :bio, 
            education = :education, 
            experience = :experience, 
            projects = :projects";

if ($avatar_path) {
    $sql .= ", avatar = :avatar";
}

$sql .= " WHERE id = :id";

$conn = pdo_get_connection();
$stmt = $conn->prepare($sql);

// Gán giá trị cho placeholder
$params = [
    ':name' => $name,
    ':degree' => $degree,
    ':faculty' => $faculty,
    ':bio' => $bio,
    ':education' => $education_json,
    ':experience' => $experience_json,
    ':projects' => $projects_json,
    ':id' => $user_id
];

if ($avatar_path) {
    $params[':avatar'] = $avatar_path;
}

// Thực thi câu lệnh
if ($stmt->execute($params)) {
    $_SESSION['teacher_profile'] = [
        "name" => $name,
        "degree" => $degree,
        "faculty" => $faculty,
        "bio" => $bio,
        "education" => $education,
        "experience" => $experience,
        "projects" => $projects,
        "avatar" => $avatar_path ?? $_SESSION['teacher_profile']['avatar'] ?? '../layout/img/teacher1.jpg'
    ];

    header("Location: about.php");
    exit;
} else {
    echo "Lỗi khi lưu dữ liệu!";
}
?>
