<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}


require_once 'config.php';

// Merr të dhënat e përdoruesit
$stmt = $pdo->prepare("SELECT fullname, email, username, created_at FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - F&Y Mobile Shop</title>
    <link rel="stylesheet" href="nav.css">
    <style>
        body {
            background-image: url("fotot e projektit/backgroundgreenblack.jfif");
            color: white;
            min-height: 100vh;
        }
        .dashboard-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        .user-info {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .info-box {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 5px;
        }
        .quick-actions {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .action-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }
        .action-button {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .action-button:hover {
            background-color: #45a049;
        }
        .latest-products {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
        }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 15px;
        }
        .product-card {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 5px;
            text-align: center;
        }
        .product-card img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <?php include 'nav.php'; ?>

    <div class="dashboard-container">
        <div class="user-info">
            <h2>Mirësevini, <?php echo htmlspecialchars($user['fullname']); ?>!</h2>
            <div class="info-grid">
                <div class="info-box">
                    <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                </div>
                <div class="info-box">
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                </div>
                <div class="info-box">
                    <p><strong>Anëtar që nga:</strong> <?php echo date('d M Y', strtotime($user['created_at'])); ?></p>
                </div>
            </div>
        </div>

        <div class="quick-actions">
            <h3>Veprime të Shpejta</h3>
            <div class="action-buttons">
                <a href="edit_profile.php" class="action-button">Ndrysho Profilin</a>
                <a href="products.php" class="action-button">Shiko Produktet</a>
                <a href="news.php" class="action-button">Lajmet e Fundit</a>
            </div>
        </div>

        <div class="latest-products">
            <h3>Produktet e Fundit</h3>
            <div class="products-grid">
                <?php
                $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC LIMIT 4");
                while ($product = $stmt->fetch()) {
                    echo "<div class='product-card'>";
                    if ($product['image_url']) {
                        echo "<img src='" . htmlspecialchars($product['image_url']) . "' alt='" . htmlspecialchars($product['name']) . "'>";
                    }
                    echo "<h4>" . htmlspecialchars($product['name']) . "</h4>";
                    echo "<p>$" . htmlspecialchars($product['price']) . "</p>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html> 