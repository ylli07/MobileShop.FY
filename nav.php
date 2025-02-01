<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fetch statistics for admin
$totalUsers = 0;
$totalProducts = 0;
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    require_once 'config.php';
    try {
        $totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
        $stmt = $pdo->query("SHOW TABLES LIKE 'products'");
        if ($stmt->rowCount() > 0) {
            $totalProducts = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
        }
    } catch (PDOException $e) {
        // Handle error silently
    }
}
?>
<header>
    <nav>
        <a href="home.php" class="nav-brand">F&Y Mobile Shop</a>
        <div class="menu-icon" onclick="toggleMenu()">☰</div>
        <div class="nav-links">
            <a href="home.php">Home</a>

            <a href="products.php">Products</a>
            <a href="aboutus.php">About</a>
            <a href="home.php#contact">Contact</a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <?php if($_SESSION['role'] === 'admin'): ?>
                    <a href="admin_dashboard.php">Dashboard</a>
                    <a href="manage_products.php">Menaxho Produktet</a>
                    <a href="system_logs.php">Shiko Logs</a>
                <?php else: ?>
                    <a href="user_dashboard.php">My Account</a>
                <?php endif; ?>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="signup.php">Sign Up</a>
            <?php endif; ?>
        </div>
    </nav>
</header>

<script>
function toggleMenu() {
    const navLinks = document.querySelector('.nav-links');
    navLinks.classList.toggle('active');
}

// Mbyll menunë kur klikohet jashtë saj
document.addEventListener('click', function(event) {
    const navLinks = document.querySelector('.nav-links');
    const menuIcon = document.querySelector('.menu-icon');
    
    if (!event.target.closest('.nav-links') && !event.target.closest('.menu-icon')) {
        navLinks.classList.remove('active');
    }
});
</script> 