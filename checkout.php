<?php
    // Start session to access the cart
    session_start();

    // Set page information for the header
    $pageTitle = "Checkout";
    $activePage = "";
    $pageCss = "CSS/checkout.css";

    // Connect database and include header
    include "includes/db.php";
    include "includes/header.php";

    // Get cart data from the session
    $cart = $_SESSION['cart'] ?? [];
?>
<!-- Checkout page -->
<section class="checkout_page">
     <!-- Delivery form -->
    <div class="checkout_form">
        <h2>Checkout</h2>
        <form action="place_order.php" method="POST">
            <h3>Delivery Details</h3>

            <input type="text" name="fullname" placeholder="Full name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Phone number" required>
            <input type="text" name="address" placeholder="Address" required>
            <input type="text" name="city" placeholder="City" required>
            <input type="text" name="postcode" placeholder="Postcode" required>

            <h3>Delivery Method</h3>

            <label>
                <input type="radio" name="delivery" value="standard" checked>
                Standard delivery
            </label>
            <label>
                <input type="radio" name="delivery" value="express">
                Express delivery
            </label>

            <button type="submit" class="place_order_btn">Place order</button>
        </form>
    </div>
     <!-- Order summary -->
    <div class="order_summary">
        <h3>Order Summary</h3>

        <?php
         // Check if the cart is empty
        if (empty($cart)) {
            echo "<p>Your cart is empty.</p>";
        } else {
            // Get product IDs from the cart
            $ids = implode(",", array_map("intval", array_keys($cart)));
            // Get cart products from the database
            $sql = "SELECT productID, name, price, image FROM cat_products WHERE productID IN ($ids)";
            $result = $conn->query($sql);
            // Stop if the SQL query failsv
            if (!$result) {
                echo "SQL Error: " . $conn->error;
                exit;
            }

            $total = 0; // Start total price calculation
            
            // Show each product and calculate subtotal
            while ($product = $result->fetch_assoc()) {
                $id = $product['productID'];
                $qty = $cart[$id];
                $subtotal = $product['price'] * $qty;
                $total += $subtotal;

                echo '
                    <div class="summary_item">
                        <img src="' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '">
                        <div>
                            <h4>' . htmlspecialchars($product['name']) . '</h4>
                            <p>£' . number_format($product['price'], 2) . ' × ' . (int)$qty . '</p>
                        </div>
                    </div>
                ';
            }
            // Show final total price
            echo '<h3 class="summary_total">Total: £' . number_format($total, 2) . '</h3>';
        }
        ?>
    </div>
</section>

<?php include "includes/footer.php"; ?>// Include the site footer