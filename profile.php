<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'config.php';

// Fetch user data
$stmt = $pdo->prepare("SELECT fullname, email, username, created_at FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profili Im - F&Y Mobile Shop</title>
    <link rel="stylesheet" href="nav.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url("fotot e projektit/backgroundgreenblack.jfif");
            background-size: cover;
            background-attachment: fixed;
            color: white;
        }

        .profile-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
        }

        .profile-header {
            text-align: center;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .profile-content {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
        }

        .profile-section {
            margin-bottom: 20px;
            padding: 15px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }

        .profile-section h3 {
            color: #4CAF50;
            margin-bottom: 10px;
        }

        .edit-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        .edit-button:hover {
            background-color: #45a049;
        }

        .profile-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .stat-box {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 5px;
            text-align: center;
        }

        .stat-box h4 {
            color: #4CAF50;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <?php include 'nav.php'; ?>
    
    <div class="profile-container">
        <div class="profile-header">
            <h1>Profili Im</h1>
        </div>

        <div class="profile-content">
            <div class="profile-section">
                <h3>Informacionet Personale</h3>
                <p><strong>Emri i plotë:</strong> <?php echo htmlspecialchars($user['fullname']); ?></p>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Anëtar që nga:</strong> <?php echo date('d M Y', strtotime($user['created_at'])); ?></p>
                <a href="edit_profile.php" class="edit-button">Ndrysho Profilin</a>
            </div>

            <div class="profile-stats">
                <div class="stat-box">
                    <h4>Porositë Totale</h4>
                    <p>5</p>
                </div>
                <div class="stat-box">
                    <h4>Produktet e Preferuara</h4>
                    <p>3</p>
                </div>
                <div class="stat-box">
                    <h4>Pikët e Besnikërisë</h4>
                    <p>150</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 