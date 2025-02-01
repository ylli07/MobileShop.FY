<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require_once 'config.php';

// Fetch admin data
$stmt = $pdo->prepare("SELECT fullname, email, username, created_at FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$admin = $stmt->fetch();

// Fetch statistics safely
try {
    $totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    
    // Kontrollo nëse ekziston tabela products
    $stmt = $pdo->query("SHOW TABLES LIKE 'products'");
    if ($stmt->rowCount() > 0) {
        $totalProducts = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
    } else {
        $totalProducts = 0;
    }
    
    // Kontrollo nëse ekziston tabela orders
    $stmt = $pdo->query("SHOW TABLES LIKE 'orders'");
    if ($stmt->rowCount() > 0) {
        $totalOrders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
    } else {
        $totalOrders = 0;
    }
} catch (PDOException $e) {
    // Në rast të ndonjë errori, vendos vlera default
    $totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $totalProducts = 0;
    $totalOrders = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile - F&Y Mobile Shop</title>
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
            max-width: 1000px;
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
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .profile-section, .admin-stats {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
        }

        .profile-section h3, .admin-stats h3 {
            color: #4CAF50;
            margin-bottom: 15px;
            font-size: 1.5em;
        }

        .info-item {
            margin-bottom: 15px;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }

        .info-item strong {
            color: #4CAF50;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
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
            margin-bottom: 10px;
        }

        .stat-box p {
            font-size: 1.5em;
            margin: 0;
        }

        .admin-actions {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .admin-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .admin-button:hover {
            background-color: #45a049;
        }

        @media (max-width: 768px) {
            .profile-content {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include 'nav.php'; ?>
    
    <div class="profile-container">
        <div class="profile-header">
            <h1>Admin Profile</h1>
            <p>Menaxhimi i sistemit dhe statistikat</p>
        </div>

        <div class="profile-content">
            <div class="profile-section">
                <h3>Informacionet Personale</h3>
                <div class="info-item">
                    <p><strong>Emri i plotë:</strong> <?php echo htmlspecialchars($admin['fullname']); ?></p>
                </div>
                <div class="info-item">
                    <p><strong>Username:</strong> <?php echo htmlspecialchars($admin['username']); ?></p>
                </div>
                <div class="info-item">
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($admin['email']); ?></p>
                </div>
                <div class="info-item">
                    <p><strong>Anëtar që nga:</strong> <?php echo date('d M Y', strtotime($admin['created_at'])); ?></p>
                </div>
                
                <div class="admin-actions">
                    <a href="edit_profile.php" class="admin-button">Ndrysho Profilin</a>
                    <a href="admin_dashboard.php" class="admin-button">Dashboard</a>
                </div>
            </div>

            <div class="admin-stats">
                <h3>Statistikat e Sistemit</h3>
                <div class="stats-grid">
                    <div class="stat-box">
                        <h4>Total Përdorues</h4>
                        <p><?php echo $totalUsers; ?></p>
                    </div>
                    <div class="stat-box">
                        <h4>Total Produkte</h4>
                        <p><?php echo $totalProducts; ?></p>
                    </div>
                    <div class="stat-box">
                        <h4>Total Porosi</h4>
                        <p><?php echo $totalOrders; ?></p>
                    </div>
                </div>

                <div class="admin-actions" style="margin-top: 30px;">
                    <a href="manage_products.php" class="admin-button">Menaxho Produktet</a>
                    <a href="manage_orders.php" class="admin-button">Menaxho Porositë</a>
                    <a href="system_logs.php" class="admin-button">Shiko Logs</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 