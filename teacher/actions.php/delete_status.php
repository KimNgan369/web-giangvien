<?php
session_start();
require_once '../models/pdo.php';
require_once '../models/status.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $status_id = $_POST['status_id'];
    $user_id = $_SESSION['user_id'];
    
    deleteStatus($status_id, $user_id);
    header('Location: ../view/status.php');
    exit();
}