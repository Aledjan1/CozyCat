<?php
    session_start();

    $pageTitle = "Checkout";
    $activePage = "";
    $pageCss = "CSS/checkout.css";

    include "includes/db.php";
    include "includes/header.php";

    $cart = $_SESSION['cart'] ?? [];
?>

<section class="checkout_page">
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
    <div class="order_summary">
        <h3>Order Summary</h3>

        <?php
        if (empty($cart)) {
            echo "<p>Your cart is empty.</p>";
        } else {
            $ids = implode(",", array_map("intval", array_keys($cart)));
            $sql = "SELECT productID, name, price, image FROM cat_products WHERE productID IN ($ids)";
            $result = $conn->query($sql);

            if (!$result) {
                echo "SQL Error: " . $conn->error;
                exit;
            }

            $total = 0;
            
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
            echo '<h3 class="summary_total">Total: £' . number_format($total, 2) . '</h3>';
        }
        ?>
    </div>
</section>

<?php include "includes/footer.php"; ?>