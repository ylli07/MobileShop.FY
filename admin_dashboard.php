<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require_once 'config.php';

// Fetch statistics
try {
    $totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $stmt = $pdo->query("SHOW TABLES LIKE 'products'");
    if ($stmt->rowCount() > 0) {
        $totalProducts = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
    } else {
        $totalProducts = 0;
    }
} catch (PDOException $e) {
    $totalUsers = 0;
    $totalProducts = 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - F&Y Mobile Shop</title>
    <link rel="stylesheet" href="nav.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url("fotot e projektit/backgroundgreenblack.jfif");
            color: white;
        }
        .dashboard-container {
            max-width: 1000px;
            margin: 20px auto;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: rgba(255, 255, 255, 0.1);
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #333;
        }
        .action-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            margin-right: 5px;
        }
        .delete-btn {
            background-color: #ff4444;
            color: white;
        }
        .edit-btn {
            background-color: #44ff44;
            color: black;
        }
        .logout-btn {
            background-color: #ff4444;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            display: inline-block;
        }
        /* Dropdown styles */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: rgb(32, 31, 31);
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 5px;
        }

        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #4CAF50;
        }

        /* Modify existing nav styles */
        header nav .admin-nav {
            position: relative;
            padding: 8px 15px;
            cursor: pointer;
            color: white;
            font-weight: bold;
        }

        .stats-container {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-box {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border-radius: 10px;
            flex: 1;
            text-align: center;
        }

        .stat-box h3 {
            color: #4CAF50;
            margin-bottom: 10px;
        }

        .stat-box p {
            font-size: 24px;
            font-weight: bold;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 10px;
                margin: 10px;
            }

            .stats-container {
                flex-direction: column;
                gap: 10px;
            }

            .stat-box {
                width: 100%;
            }

            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            th, td {
                padding: 8px;
                font-size: 14px;
            }

            .welcome-message h1 {
                font-size: 24px;
            }

            .welcome-message p {
                font-size: 16px;
            }
        }

        @media (max-width: 480px) {
            .dashboard-container {
                padding: 5px;
                margin: 5px;
            }

            .welcome-message h1 {
                font-size: 20px;
            }

            .welcome-message p {
                font-size: 14px;
            }

            .stat-box h3 {
                font-size: 16px;
            }

            .stat-box p {
                font-size: 20px;
            }

            th, td {
                padding: 6px;
                font-size: 12px;
            }

            .action-btn {
                padding: 6px 12px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <?php include 'nav.php'; ?>
    
    <div class="dashboard-container">
        <div class="welcome-message">
            <h1>Admin Dashboard</h1>
            <p>Mirësevini <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        </div>

        <div class="stats-container">
            <div class="stat-box">
                <h3>Totali i përdoruesve</h3>
                <p><?php echo $totalUsers; ?></p>
            </div>
            <div class="stat-box">
                <h3>Totali i produkteve</h3>
                <p><?php echo $totalProducts; ?></p>
            </div>
        </div>

        <h2>Lista e përdoruesve:</h2>
        <?php
        $stmt = $pdo->query("SELECT id, fullname, email, username, role, created_at FROM users");
        $users = $stmt->fetchAll();
        ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Emri i plotë</th>
                <th>Email</th>
                <th>Username</th>
                <th>Roli</th>
                <th>Data e regjistrimit</th>
                <th>Veprime</th>
            </tr>
            <?php foreach($users as $user): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td>
                    <form action="change_role.php" method="POST" style="display: inline;">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <select name="new_role" onchange="this.form.submit()">
                            <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                            <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                        </select>
                    </form>
                </td>
                <td><?php echo $user['created_at']; ?></td>
                <td>
                    <button class="action-btn edit-btn">Ndrysho</button>
                    <button class="action-btn delete-btn">Fshi</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html> 