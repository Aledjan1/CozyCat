<?php 
    session_start();

    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        header("Location: ../index.php");
        exit;
    }

    include "admin_nav.php";
    include "../includes/db.php";

    $productResult = $conn->query("SELECT COUNT(*) AS total FROM cat_products");
    $productCount = $productResult->fetch_assoc()['total'];

    $orderResult = $conn->query("SELECT COUNT(*) AS total FROM orders");
    $orderCount = $orderResult->fetch_assoc()['total'];

    $userResult = $conn->query("SELECT COUNT(*) AS total FROM users");
    $userCount = $userResult->fetch_assoc()['total'];

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
    <div class="admin_container">
        <div class="admin_header">
            <h1>🛠 Admin Dashboard</h1>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
        </div>
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
        <div class="admin_links">
            <a href="products.php">Manage Products</a>
            <a href="orders.php">Manage Orders</a>
            <a href="../index.php">Back to Website</a>
        </div>
    </div>
    <script src="../JS/admin.js"></script>
</body>
</html>