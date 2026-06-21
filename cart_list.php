<?php
    session_start();
    
    include "includes/db.php";

    $cart = $_SESSION['cart'] ?? [];

    echo '<span onclick="closeCart()" class="close">✖️</span>';
    echo '<h2>Your Cart</h2>';

    if (empty($cart)) {
        echo '<p>No items yet</p>';
        exit;
    }

    $ids = implode(",", array_map('intval', array_keys($cart)));

    $sql = "SELECT productID, name, price, image FROM cat_products WHERE productID IN ($ids)";
    $result = $conn->query($sql);

    if(!$result) {
        echo "SQL Error: " . $conn->error;
        exit;
    }

    $total = 0;

    while ($product = $result->fetch_assoc()) {
        $id = (int)$product['productID'];
        $qty =(int) $cart[$id];
        $subtotal = $product['price'] * $qty;
        $total += $subtotal;

        echo '
            <div class="cart_item">
                <img src="' . htmlspecialchars($product['image']) . '" alt="' .htmlspecialchars($product['name']) . '">
                
                <div class="cart_item_info">
                    <h4>' . htmlspecialchars($product['name']) . '</h4>
                    <p>£' . number_format($product['price'], 2) . ' × ' . (int)$qty . '</p>

                    <div class="qty_control">
                        <button class="cart_qty_btn" data-action="remove" data-product-id="' . $id . '">🗑️</button>
                        <button class="cart_qty_btn" data-action="minus" data-product-id="' . $id . '">-</button>
                        <span>' . $qty . '</span>
                        <button class="cart_qty_btn" data-action="plus" data-product-id="' . $id . '">+</button>
                    </div>
                </div>
            </div>
        ';
    }

    echo '<h3>Total: £' . number_format($total, 2) . '</h3>';
    echo '<a href="checkout.php" class="checkout_btn">Checkout</a>';

?>