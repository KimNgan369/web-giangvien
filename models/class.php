<?php
require_once "pdo.php";

function get_myclass() {
    $sql = "SELECT c.*, u.full_name AS teacher_name 
            FROM myclass c 
            JOIN users u ON c.teacher_id = u.id 
            WHERE u.role = 'teacher' 
            ORDER BY c.class_id DESC";
    return pdo_query($sql);
}

?>
