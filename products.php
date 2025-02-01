<?php
require_once 'config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Phone Products</title>
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="products.css">
</head>
<body>
    <?php include 'nav.php'; ?>

    <div class="klasa-produkteve">
        <?php
        $stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
        while ($product = $stmt->fetch()) {
            echo "<div class='boxi-produkteve'>";
            if ($product['image_url']) {
                echo "<img src='" . htmlspecialchars($product['image_url']) . "' alt='" . htmlspecialchars($product['name']) . "'>";
            }
            echo "<h3>" . htmlspecialchars($product['name']) . "</h3>";
            echo "<p>$" . htmlspecialchars($product['price']) . "</p>";
            echo "</div>";
        }
        
        if ($stmt->rowCount() == 0) {
            echo "<p style='color: white; text-align: center; width: 100%;'>Nuk ka produkte për momentin.</p>";
        }
        ?>
    </div>
</body>
</html> 