<?php
    // Start session to access the logged-in user
    session_start();

    // Set page title and CSS file
    $pageTitle = "My Orders";
    $pageCss = "CSS/account.css";

    // Connect to the database
    include "includes/db.php";
    
    // Get the current user ID from the session
    $userID = (int)($_SESSION['user_id'] ?? 0);

    // Redirect visitors who are not logged in
    if ($userID <=0) {
        header("Location: index.php");
        exit;
    }

    // Include the site header
    include "includes/header.php";

    // Get all orders for this user, newest first
    $sql = "SELECT * FROM orders WHERE user_id = $userID ORDER BY orderID DESC";
    $result = $conn->query($sql);
?>

<!-- My orders page -->
<section class="account_page">
    <div class="account_card">
         <!-- Page title and navigation -->
        <h2>My Orders</h2>
        <div class="account_links orders_top_links">
            <a href="account.php">⬅ Back to Account</a>
            <a href="products.php">🛍️ Continue Shopping</a>
        </div>
        <!-- Show orders if the user has any -->
        <?php if ($result && $result->num_rows > 0): ?>
            <!-- Loop through all user orders -->
            <?php while ($order = $result->fetch_assoc()): ?>

                <!-- Single order card -->
                <div class="order_box">
                    <h3>Order #<?php echo $order['orderID']; ?></h3>
                    <p>Total: £<?php echo number_format($order['total'], 2); ?></p>
                    <p>Status: <?php echo htmlspecialchars($order['status'] ?? 'Pending'); ?></p>
                    <p>Date: <?php echo htmlspecialchars($order['created_at']); ?></p>
                    
                    <!-- Link to full order details -->
                    <a href="order_details.php?orderID=<?php echo (int)$order['orderID']; ?>" class="checkout_btn">
                        View Details
                    </a>
                </div>
            <?php endwhile; ?>
        <!-- Message if the user has no orders -->
        <?php else: ?>
            <p>You have no orders yet.</p>
        <?php endif; ?>
    </div>
</section>

<?php include "includes/footer.php"; ?>// Include the site footer