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
    <title>User Dashboard - F&Y Mobile Shop</title>
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

        .dashboard-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        .welcome-message {
            text-align: center;
            margin-bottom: 30px;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
        }

        .welcome-message h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .welcome-message p {
            font-size: 18px;
            color: #f4f4f4;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .dashboard-card {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            background-color: rgba(255, 255, 255, 0.2);
        }

        .dashboard-card h2 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #4CAF50;
        }

        .dashboard-card p {
            margin-bottom: 15px;
            font-size: 16px;
        }

        .dashboard-nav {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
        }

        .dashboard-nav a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            margin: 5px;
            border-radius: 5px;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .dashboard-nav a:hover {
            background-color: #4CAF50;
        }

        .recent-activity {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
        }

        .recent-activity h2 {
            color: #4CAF50;
            margin-bottom: 15px;
        }

        .activity-item {
            padding: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 10px;
            }

            .welcome-message h1 {
                font-size: 24px;
            }

            .welcome-message p {
                font-size: 16px;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }
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

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h2>Profili Im</h2>
                <p>Menaxhoni informacionet tuaja personale dhe preferencat</p>
                <a href="edit_profile.php" class="dashboard-nav">Ndrysho Profilin</a>
            </div>

            <div class="dashboard-card">
                <h2>Porositë e Mia</h2>
                <p>Shikoni historinë e porosive dhe statusin aktual</p>
                <a href="view_orders.php" class="dashboard-nav">Shiko Porositë</a>
            </div>

            <div class="dashboard-card">
                <h2>Produktet e Preferuara</h2>
                <p>Lista e produkteve të ruajtura për më vonë</p>
                <a href="wishlist.php" class="dashboard-nav">Shiko Listën</a>
            </div>
        </div>

        <div class="recent-activity">
            <h2>Aktiviteti i Fundit</h2>
            <div class="activity-item">
                <p>Porosia #12345 është konfirmuar - 2 orë më parë</p>
            </div>
            <div class="activity-item">
                <p>Keni shtuar iPhone 14 Pro në listën e dëshirave - 1 ditë më parë</p>
            </div>
            <div class="activity-item">
                <p>Keni përditësuar profilin tuaj - 3 ditë më parë</p>
            </div>
        </div>

        <div class="dashboard-nav">
            <a href="edit_profile.php">Edit Profile</a>
            <a href="view_orders.php">View Orders</a>
            <a href="settings.php">Settings</a>
            <a href="wishlist.php">Wishlist</a>
        </div>
    </div>
</body>
</html> 