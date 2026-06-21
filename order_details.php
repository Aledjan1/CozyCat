<?php
    session_start();

    $pageTitle = "Order Details";
    $pageCss = "CSS/account.css";

    include "includes/db.php";

    $userID = (int)($_SESSION['user_id'] ?? 0);

    if ($userID <= 0) {
        header("Location: index.php");
        exit;
    }

    include "includes/header.php";

    $orderID = (int)($_GET['orderID'] ?? 0);
    $orderID = (int)$orderID;

    $orderSql = "SELECT * FROM orders WHERE orderID = $orderID AND user_id = $userID";
    $orderResult = $conn->query($orderSql);

    if ($userID <=0) {
        header("Location: index.php");
        exit;
    }

    if (!$orderResult || $orderResult->num_rows === 0) {
        echo "<section class='account_page'><div class='account_card'><p>Order not found.</p></div></section>";
        include "includes/footer.php";
        exit;
    }

    $order = $orderResult->fetch_assoc();

    $itemsSql = "
        SELECT order_items.quantity, order_items.price, cat_products.name, cat_products.image
        FROM order_items
        JOIN cat_products ON order_items.productID = cat_products.productID
        WHERE order_items.orderID = $orderID
    ";

    $itemsResult = $conn->query($itemsSql);

    if (!$itemsResult) {
        die("SQL Error: " . $conn->error);
    }
?>
<section class="account_page">
    <div class="account_card">
        <h2>Order #<?php echo $order['orderID']; ?></h2>
        <p><strong>Status :</strong><?php echo htmlspecialchars($order['status'] ?? 'Pending'); ?></p>
        <p><strong>Date :</strong> <?php echo htmlspecialchars($order['created_at']); ?></p>
        <h3>Items</h3>
        <?php while ($item = $itemsResult->fetch_assoc()): ?>
            <div class="order_item">
                <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                <div>
                    <h4><?php echo htmlspecialchars($item['name']); ?></h4>
                    <p>£<?php echo number_format($item['price'], 2); ?> × <?php echo (int)$item['quantity']; ?></p>
                </div>
            </div>
        <?php endwhile; ?>
        <h3>Total: £<?php echo number_format($order['total'], 2); ?></h3>
        <div class="account_links">
            <a href="my_orders.php">⬅ Back to My Orders</a>
        </div>
    </div>
</section>
<?php include "includes/footer.php"; ?>