<?php
    session_start();

    $pageTitle = "My Orders";
    $pageCss = "CSS/account.css";

    include "includes/db.php";
    
    $userID = (int)($_SESSION['user_id'] ?? 0);

    if ($userID <=0) {
        header("Location: index.php");
        exit;
    }

    include "includes/header.php";

    $sql = "SELECT * FROM orders WHERE user_id = $userID ORDER BY orderID DESC";
    $result = $conn->query($sql);
?>

<section class="account_page">
    <div class="account_card">
        <h2>My Orders</h2>
        <div class="account_links orders_top_links">
            <a href="account.php">⬅ Back to Account</a>
            <a href="products.php">🛍️ Continue Shopping</a>
        </div>

        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($order = $result->fetch_assoc()): ?>
                <div class="order_box">
                    <h3>Order #<?php echo $order['orderID']; ?></h3>
                    <p>Total: £<?php echo number_format($order['total'], 2); ?></p>
                    <p>Status: <?php echo htmlspecialchars($order['status'] ?? 'Pending'); ?></p>
                    <p>Date: <?php echo htmlspecialchars($order['created_at']); ?></p>

                    <a href="order_details.php?orderID=<?php echo (int)$order['orderID']; ?>" class="checkout_btn">
                        View Details
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>You have no orders yet.</p>
        <?php endif; ?>
    </div>
</section>

<?php include "includes/footer.php"; ?>