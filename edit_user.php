<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
   
require_once 'config.php';

$error = '';
$success = '';

// Merr të dhënat e përdoruesit
if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
    
    if (!$user) {
        header("Location: admin_dashboard.php?error=user_not_found");
        exit();
    }
} else {
    header("Location: admin_dashboard.php");
    exit();
}

// Përditëso të dhënat e përdoruesit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $new_password = trim($_POST['new_password']);
    
    try {
        if (!empty($new_password)) {
            // Përditëso të gjitha fushat përfshirë password-in
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET fullname = ?, email = ?, username = ?, password = ? WHERE id = ?");
            $stmt->execute([$fullname, $email, $username, $hashed_password, $user_id]);
        } else {
            // Përditëso të gjitha fushat përveç password-it
            $stmt = $pdo->prepare("UPDATE users SET fullname = ?, email = ?, username = ? WHERE id = ?");
            $stmt->execute([$fullname, $email, $username, $user_id]);
        }
        $success = "Të dhënat u përditësuan me sukses!";
    } catch(PDOException $e) {
        $error = "Ndodhi një gabim gjatë përditësimit të të dhënave!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ndrysho Përdoruesin - F&Y Mobile Shop</title>
    <link rel="stylesheet" href="nav.css">
    <style>
        body {
            background-image: url("fotot e projektit/backgroundgreenblack.jfif");
            color: white;
            min-height: 100vh;
        }
        .edit-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }
        .btn-primary {
            background-color: #4CAF50;
            color: white;
        }
        .btn-secondary {
            background-color: #666;
            color: white;
        }
        .message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .success {
            background-color: rgba(76, 175, 80, 0.1);
            color: #4CAF50;
        }
        .error {
            background-color: rgba(244, 67, 54, 0.1);
            color: #f44336;
        }
    </style>
</head>
<body>
    <?php include 'nav.php'; ?>

    <div class="edit-container">
        <h1>Ndrysho Përdoruesin</h1>
        
        <?php if ($error): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="message success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
            <input type="hidden" name="update" value="1">
            
            <div class="form-group">
                <label for="fullname">Emri i plotë</label>
                <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>

            <div class="form-group">
                <label for="new_password">Password i ri (lëre bosh për të mos e ndryshuar)</label>
                <input type="password" id="new_password" name="new_password">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Ruaj Ndryshimet</button>
                <a href="admin_dashboard.php" class="btn btn-secondary">Kthehu</a>
            </div>
        </form>
    </div>
</body>
</html> 