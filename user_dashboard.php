<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="nav.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-image: url("fotot e projektit/backgroundgreenblack.jfif");
            color: white;
        }
        .dashboard-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
        }
        .welcome-message {
            text-align: center;
            margin-bottom: 30px;
        }
        .user-info {
            margin-bottom: 20px;
        }
        .logout-btn {
            background-color: #ff4444;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .nav-links {
            margin-top: 20px;
        }
        .nav-links a {
            color: white;
            margin-right: 15px;
            text-decoration: none;
        }
        .dashboard-nav {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 10px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .dashboard-nav a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            margin: 0 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .dashboard-nav a:hover {
            background-color: #4CAF50;
        }
    </style>
</head>
<body>
    <?php include 'nav.php'; ?>
    
    <div class="dashboard-container">
        <div class="welcome-message">
            <h1>User Dashboard</h1>
            <p>Mirësevini <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        </div>

        <div class="dashboard-nav">
            <a href="products.php">Shiko Produktet</a>
            <a href="orders.php">Porositë e Mia</a>
            <a href="profile.php">Profili Im</a>
        </div>

        <div class="user-info">
            <?php
            require_once 'config.php';
            $stmt = $pdo->prepare("SELECT fullname, email FROM users WHERE id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $user = $stmt->fetch();
            ?>
            <h2>Të dhënat e profilit:</h2>
            <p>Emri i plotë: <?php echo htmlspecialchars($user['fullname']); ?></p>
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
            <p>Username: <?php echo htmlspecialchars($_SESSION['username']); ?></p>
        </div>

        <div class="nav-links">
            <a href="home.php">Kthehu në faqen kryesore</a>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
</body>
</html> 