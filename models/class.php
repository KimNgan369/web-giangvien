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
function get_documents() {
    $sql = "SELECT c.*, d.class_id AS classid
            from myclass c
            JOIN documents d ON c.class_id = d.class_id
            ORDER BY c.class_id DESC";
    return pdo_query($sql);
}
?>
