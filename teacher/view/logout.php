<?php
session_start();
session_unset(); // Xóa tất cả biến phiên
session_destroy(); // Hủy session

// Chuyển hướng về trang đăng nhập (hoặc trang chủ)
header("Location: ../login.php");
exit();
