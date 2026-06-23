<?php 
    // Start session to check admin login
    session_start();

    // Protect this page from non-admin users
    // Only users with the admin role can open the dashboard
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        header("Location: ../index.php");
        exit;
    }

    // Include admin navigation and database connection
    include "admin_nav.php";
    include "../includes/db.php";

    // Count all products in the database
    $productResult = $conn->query("SELECT COUNT(*) AS total FROM cat_products");
    $productCount = $productResult->fetch_assoc()['total'];

    // Count all customer orders
    $orderResult = $conn->query("SELECT COUNT(*) AS total FROM orders");
    $orderCount = $orderResult->fetch_assoc()['total'];

    // Count all registered users
    $userResult = $conn->query("SELECT COUNT(*) AS total FROM users");
    $userCount = $userResult->fetch_assoc()['total'];

    // Calculate total revenue from all orders
    // If there are no orders, use 0
    $revenueResult = $conn->query("SELECT SUM(total) AS revenue FROM orders");
    $revenue = $revenueResult->fetch_assoc()['revenue'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/admin.css">
    <title>Admin Dashbort</title>
</head>
<body>
    <!-- Admin dashboard wrapper -->
    <div class="admin_container">
        <!-- Dashboard title and admin name -->
        <div class="admin_header">
            <h1>🛠 Admin Dashboard</h1>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
        </div>
        <!-- Statistics cards -->
        <div class="admin_cards">
            <div class="admin_card">
                <h2>📦 Products</h2>
                <p><?php echo $productCount; ?></p>
            </div>
            <div class="admin_card">
                <h2>🛒 Orders</h2>
                <p><?php echo $orderCount; ?></p>
            </div>
            <div class="admin_card">
                <h2>👥 Users</h2>
                <p><?php echo $userCount; ?></p>
            </div>
            <div class="admin_card">
                <h2>💰 Revenue</h2>
                <p>£<?php echo number_format($revenue, 2); ?></p>
            </div>
        </div>
        <!-- Admin navigation links -->
        <div class="admin_links">
            <a href="products.php">Manage Products</a>
            <a href="orders.php">Manage Orders</a>
            <a href="../index.php">Back to Website</a>
        </div>
    </div>
    <script src="../JS/admin.js"></script>
</body>
</html>