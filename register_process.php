<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Kontrollo nëse username ekziston
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    
    if ($stmt->rowCount() > 0) {
        header("Location: signup.html?error=exists");
        exit();
    }
    
    // Regjistro përdoruesin e ri (default role: user)
    $stmt = $pdo->prepare("INSERT INTO users (fullname, email, username, password, role) VALUES (?, ?, ?, ?, 'user')");
    
    try {
        $stmt->execute([$fullname, $email, $username, $password]);
        header("Location: login.html?registered=1");
    } catch(PDOException $e) {
        header("Location: signup.html?error=registration_failed");
    }
}
?> 