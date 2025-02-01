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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("fotot e projektit/backgroundgreenblack.jfif");
            background-size: cover;
            background-attachment: fixed;
            min-height: 100vh;
        }

        .klasa-produkteve {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .boxi-produkteve {
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            color: white;
            transition: transform 0.3s;
        }

        .boxi-produkteve:hover {
            transform: translateY(-5px);
        }

        .boxi-produkteve img {
            width: 100%;
            max-width: 200px;
            height: auto;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .boxi-produkteve h3 {
            color: #4CAF50;
            margin: 10px 0;
        }

        .boxi-produkteve p {
            font-size: 1.1em;
            color: white;
        }

        @media (max-width: 768px) {
            .klasa-produkteve {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                padding: 10px;
            }
        }

        @media (max-width: 480px) {
            .klasa-produkteve {
                gap: 10px;
                padding: 10px 5px;
            }

            .boxi-produkteve {
                padding: 10px;
            }

            .boxi-produkteve h3 {
                font-size: 18px;
            }

            .boxi-produkteve p {
                font-size: 16px;
            }
        }
    </style>
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