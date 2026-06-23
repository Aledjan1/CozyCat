<?php
    // Start session to access the logged-in user
    session_start();

     // Set page title and CSS file
    $pageTitle = "Order Details";
    $pageCss = "CSS/account.css";

    // Connect to the database
    include "includes/db.php";

      // Get the current user ID from the session
    $userID = (int)($_SESSION['user_id'] ?? 0);

    // Redirect to home page if the user is not logged in
    if ($userID <= 0) {
        header("Location: index.php");
        exit;
    }

    // Include the site header after login check
    include "includes/header.php";

    // Get the order ID from the URL
    $orderID = (int)($_GET['orderID'] ?? 0);


    // Get the order only if it belongs to the current user
    $orderSql = "SELECT * FROM orders WHERE orderID = $orderID AND user_id = $userID";
    $orderResult = $conn->query($orderSql);


    // Show an error message if the order was not found
    if (!$orderResult || $orderResult->num_rows === 0) {
        echo "<section class='account_page'><div class='account_card'><p>Order not found.</p></div></section>";
        include "includes/footer.php";
        exit;
    }

    // Convert the order result into an associative array
    $order = $orderResult->fetch_assoc();

    // Get all items that belong to this order
    $itemsSql = "
        SELECT order_items.quantity, order_items.price, cat_products.name, cat_products.image
        FROM order_items
        JOIN cat_products ON order_items.productID = cat_products.productID
        WHERE order_items.orderID = $orderID
    ";

    $itemsResult = $conn->query($itemsSql);

    // Stop the page if the items query fails
    if (!$itemsResult) {
        die("SQL Error: " . $conn->error);
    }
?>
<!-- Order details page -->
<section class="account_page">
    <!-- Order card -->
    <div class="account_card">
         <!-- Order information -->
        <h2>Order #<?php echo $order['orderID']; ?></h2>
        <p><strong>Status :</strong><?php echo htmlspecialchars($order['status'] ?? 'Pending'); ?></p>
        <p><strong>Date :</strong> <?php echo htmlspecialchars($order['created_at']); ?></p>
         <!-- Ordered items -->
        <h3>Items</h3>
        <?php while ($item = $itemsResult->fetch_assoc()): ?>
            <!-- Single item -->
            <div class="order_item">
                <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                <!-- Item details -->
                <div>
                    <h4><?php echo htmlspecialchars($item['name']); ?></h4>
                    <p>£<?php echo number_format($item['price'], 2); ?> × <?php echo (int)$item['quantity']; ?></p>
                </div>
            </div>
        <?php endwhile; ?>
        <!-- Order total -->
        <h3>Total: £<?php echo number_format($order['total'], 2); ?></h3>
        <!-- Navigation links -->
        <div class="account_links">
            <a href="my_orders.php">⬅ Back to My Orders</a>
        </div>
    </div>
</section>
<?php include "includes/footer.php"; ?>// Include the site footer