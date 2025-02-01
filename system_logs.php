<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require_once 'config.php';

// Pagination setup
$records_per_page = 15;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Get total number of logs
$total_logs = $pdo->query("SELECT COUNT(*) FROM system_logs")->fetchColumn();
$total_pages = ceil($total_logs / $records_per_page);

// Fetch logs with user information
$stmt = $pdo->prepare("
    SELECT sl.*, u.username, p.name as product_name 
    FROM system_logs sl 
    LEFT JOIN users u ON sl.user_id = u.id 
    LEFT JOIN products p ON sl.product_id = p.id
    ORDER BY sl.created_at DESC 
    LIMIT :offset, :records_per_page
");
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':records_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
$logs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Logs - F&Y Mobile Shop</title>
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

        .logs-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        .logs-header {
            text-align: center;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .logs-table {
            width: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        th {
            background-color: rgba(76, 175, 80, 0.3);
            color: #4CAF50;
        }

        tr:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .pagination a {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .pagination a:hover {
            background-color: #45a049;
        }

        .pagination .current {
            background-color: #45a049;
        }

        .filter-section {
            margin-bottom: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 15px;
            border-radius: 10px;
        }

        .filter-section select, .filter-section input {
            padding: 8px;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #4CAF50;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .filter-section button {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .action-add {
            color: #4CAF50;
            background-color: rgba(74, 175, 80, 0.1);
            padding: 5px 10px;
            border-radius: 4px;
            border: 1px solid #4CAF50;
        }

        .action-edit {
            color: #2196F3;
            background-color: rgba(33, 150, 243, 0.1);
            padding: 5px 10px;
            border-radius: 4px;
            border: 1px solid #2196F3;
        }

        .action-delete {
            color: #f44336;
            background-color: rgba(244, 67, 54, 0.1);
            padding: 5px 10px;
            border-radius: 4px;
            border: 1px solid #f44336;
        }

        .changes-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .changes-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <?php include 'nav.php'; ?>
    
    <div class="logs-container">
        <div class="logs-header">
            <h1>System Logs</h1>
            <p>Monitorimi i aktivitetit të sistemit</p>
        </div>

        <div class="filter-section">
            <form method="GET">
                <select name="action_type">
                    <option value="">Të gjitha veprimet</option>
                    <option value="login">Login</option>
                    <option value="update">Update</option>
                    <option value="delete">Delete</option>
                </select>
                <input type="date" name="date_from" placeholder="Data prej">
                <input type="date" name="date_to" placeholder="Data deri">
                <button type="submit">Filtro</button>
            </form>
        </div>

        <div class="logs-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Admin</th>
                        <th>Veprimi</th>
                        <th>Produkti</th>
                        <th>Detajet</th>
                        <th>Ndryshimet</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($log['id']); ?></td>
                        <td><?php echo htmlspecialchars($log['username']); ?></td>
                        <td><?php 
                            $action = htmlspecialchars($log['action']);
                            $actionClass = '';
                            switch($action) {
                                case 'add_product':
                                    $actionClass = 'action-add';
                                    $action = 'Shtuar';
                                    break;
                                case 'edit_product':
                                    $actionClass = 'action-edit';
                                    $action = 'Edituar';
                                    break;
                                case 'delete_product':
                                    $actionClass = 'action-delete';
                                    $action = 'Fshirë';
                                    break;
                            }
                            echo "<span class='$actionClass'>$action</span>";
                        ?></td>
                        <td><?php echo htmlspecialchars($log['product_name'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($log['details']); ?></td>
                        <td><?php 
                            if ($log['old_values'] || $log['new_values']) {
                                echo "<button onclick='showChanges(this)' data-old='" . 
                                     htmlspecialchars($log['old_values']) . "' data-new='" . 
                                     htmlspecialchars($log['new_values']) . "'>Shiko ndryshimet</button>";
                            }
                        ?></td>
                        <td><?php echo date('d-m-Y H:i:s', strtotime($log['created_at'])); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>" 
                   class="<?php echo $page === $i ? 'current' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    </div>

    <script>
    function showChanges(button) {
        const oldValues = JSON.parse(button.getAttribute('data-old') || '{}');
        const newValues = JSON.parse(button.getAttribute('data-new') || '{}');
        
        let message = 'Ndryshimet:\n\n';
        
        if (oldValues) {
            message += 'Vlerat e vjetra:\n';
            for (const [key, value] of Object.entries(oldValues)) {
                message += `${key}: ${value}\n`;
            }
            message += '\n';
        }
        
        if (newValues) {
            message += 'Vlerat e reja:\n';
            for (const [key, value] of Object.entries(newValues)) {
                message += `${key}: ${value}\n`;
            }
        }
        
        alert(message);
    }
    </script>
</body>
</html> 