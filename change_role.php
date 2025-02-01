<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id']) && isset($_POST['new_role'])) {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['new_role'];
    
    try {
        $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
        $stmt->execute([$new_role, $user_id]);
        header("Location: admin_dashboard.php?success=1");
    } catch(PDOException $e) {
        header("Location: admin_dashboard.php?error=1");
    }
}
?> 