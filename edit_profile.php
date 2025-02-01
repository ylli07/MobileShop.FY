<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
    
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    
    // Verify current password
    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    
    if (password_verify($current_password, $user['password'])) {
        // Update user information
        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET fullname = ?, email = ?, password = ? WHERE id = ?");
            $stmt->execute([$fullname, $email, $hashed_password, $_SESSION['user_id']]);
        } else {
            $stmt = $pdo->prepare("UPDATE users SET fullname = ?, email = ? WHERE id = ?");
            $stmt->execute([$fullname, $email, $_SESSION['user_id']]);
        }
        header("Location: profile.php?success=1");
        exit();
    } else {
        $error = "Passwordi aktual është i gabuar!";
    }
}

// Fetch current user data
$stmt = $pdo->prepare("SELECT fullname, email FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ndrysho Profilin - F&Y Mobile Shop</title>
    <link rel="stylesheet" href="nav.css">
    <style>
        /* Similar styling as profile.php with form-specific additions */
        .edit-form input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .edit-form label {
            display: block;
            margin-bottom: 5px;
            color: #4CAF50;
        }

        .save-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .error-message {
            color: #ff4444;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php include 'nav.php'; ?>
    
    <div class="profile-container">
        <div class="profile-header">
            <h1>Ndrysho Profilin</h1>
        </div>

        <div class="profile-content">
            <?php if (isset($error)): ?>
                <p class="error-message"><?php echo $error; ?></p>
            <?php endif; ?>

            <form class="edit-form" method="POST">
                <div class="profile-section">
                    <label for="fullname">Emri i plotë</label>
                    <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

                    <label for="current_password">Passwordi aktual</label>
                    <input type="password" id="current_password" name="current_password" required>

                    <label for="new_password">Passwordi i ri (lëre bosh nëse nuk dëshiron ta ndryshosh)</label>
                    <input type="password" id="new_password" name="new_password">

                    <button type="submit" class="save-button">Ruaj Ndryshimet</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html> 