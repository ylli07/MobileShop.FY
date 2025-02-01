<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
    </style>
</head>
<body>
    <?php include 'nav.php'; ?>
    
    <div class="dashboard-container">
        <div class="welcome-message">
            <h1>Admin Dashboard</h1>
            <p>Mirësevini <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        </div>

        <h2>Lista e përdoruesve:</h2>
        <?php
        require_once 'config.php';
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