<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <div id="home" class="navigacioni">F&Y Mobile Shop</div>
    <nav>
        <a href="home.php">Home</a>
        <a href="products.php">Products</a>
        <a href="aboutus.php">About Us</a>
        <a href="news.php">News</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <div class="dropdown">
                    <span class="admin-nav">Admin Panel</span>
                    <div class="dropdown-content">
                        <a href="admin_profile.php">Profili</a>
                        <a href="manage_products.php">Menaxho Produktet</a>
                        <a href="admin_dashboard.php">Users Dashboard</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="user_dashboard.php">Dashboard</a>
                <a href="logout.php">Logout</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="signup.php">Sign Up</a>
        <?php endif; ?>
    </nav>
</header> 