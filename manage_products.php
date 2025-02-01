<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require_once 'config.php';

// Në fillim të file-it, shtoni këtë funksion
function addSystemLog($pdo, $action, $details, $product_id = null, $old_values = null, $new_values = null) {
    try {
        $stmt = $pdo->prepare("
            INSERT INTO system_logs (user_id, action, details, product_id, old_values, new_values, ip_address) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $_SESSION['user_id'],
            $action,
            $details,
            $product_id,
            $old_values ? json_encode($old_values, JSON_UNESCAPED_UNICODE) : null,
            $new_values ? json_encode($new_values, JSON_UNESCAPED_UNICODE) : null,
            $_SERVER['REMOTE_ADDR']
        ]);
    } catch (PDOException $e) {
        // Log error ose handle sipas nevojës
        error_log("Error in addSystemLog: " . $e->getMessage());
    }
}

// Shto produkt të ri
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add') {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        
        // Procesi i ngarkimit të fotos
        $image_url = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $target_dir = "product_images/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            
            $image_url = $target_dir . time() . '_' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $image_url);
        }
        
        $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image_url, stock) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $description, $price, $image_url, $stock]);
        $product_id = $pdo->lastInsertId();

        // Shtoni log
        $new_values = [
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'stock' => $stock,
            'image_url' => $image_url
        ];
        addSystemLog($pdo, 'add_product', "Produkti u shtua: $name", $product_id, null, $new_values);

        header("Location: manage_products.php?success=added");
        exit();
    }
    
    // Fshi produkt
    elseif ($_POST['action'] === 'delete' && isset($_POST['product_id'])) {
        // Merrni të dhënat e produktit para se të fshihet
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$_POST['product_id']]);
        $old_product = $stmt->fetch();

        // Shtoni log para fshirjes
        addSystemLog($pdo, 'delete_product', 
            "Produkti u fshi: " . $old_product['name'], 
            null, // vendosim null për product_id pasi produkti do të fshihet
            $old_product,
            null
        );

        // Pastaj fshij produktin
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$_POST['product_id']]);

        header("Location: manage_products.php?success=deleted");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menaxho Produktet</title>
    <link rel="stylesheet" href="nav.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url("fotot e projektit/backgroundgreenblack.jfif");
            color: white;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
        }
        .product-form {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .product-form input, .product-form textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        .product-card {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 5px;
        }
        .product-card img {
            max-width: 100%;
            height: auto;
        }
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
        }
        .btn-add {
            background-color: #4CAF50;
        }
        .btn-delete {
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <?php include 'nav.php'; ?>

    <div class="container">
        <h1>Menaxho Produktet</h1>
        
        <!-- Forma për shtimin e produkteve -->
        <div class="product-form">
            <h2>Shto Produkt të Ri</h2>
            <form action="manage_products.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add">
                <input type="text" name="name" placeholder="Emri i produktit" required>
                <textarea name="description" placeholder="Përshkrimi" required></textarea>
                <input type="number" name="price" step="0.01" placeholder="Çmimi" required>
                <input type="number" name="stock" placeholder="Sasia në stok" required>
                <input type="file" name="image" accept="image/*" required>
                <button type="submit" class="btn btn-add">Shto Produkt</button>
            </form>
        </div>
        
        <!-- Lista e produkteve -->
        <h2>Produktet Ekzistuese</h2>
        <div class="product-grid">
            <?php
            $stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
            while ($product = $stmt->fetch()) {
                echo "<div class='product-card'>";
                if ($product['image_url']) {
                    echo "<img src='" . htmlspecialchars($product['image_url']) . "' alt='Product Image'>";
                }
                echo "<h3>" . htmlspecialchars($product['name']) . "</h3>";
                echo "<p>" . htmlspecialchars($product['description']) . "</p>";
                echo "<p>Çmimi: $" . htmlspecialchars($product['price']) . "</p>";
                echo "<p>Në stok: " . htmlspecialchars($product['stock']) . "</p>";
                echo "<form action='manage_products.php' method='POST'>";
                echo "<input type='hidden' name='action' value='delete'>";
                echo "<input type='hidden' name='product_id' value='" . $product['id'] . "'>";
                echo "<button type='submit' class='btn btn-delete'>Fshi</button>";
                echo "</form>";
                echo "</div>";
            }
            ?>
        </div>
        
        <div style="margin-top: 20px;">
            <a href="admin_dashboard.php" style="color: white;">Kthehu në Dashboard</a>
        </div>
    </div>
</body>
</html> 