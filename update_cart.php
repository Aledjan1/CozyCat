<?php
    // Start session to access the shopping cart
    session_start();

    // Get product ID and action from the POST request
    $productID = $_POST['productID'] ?? 0;
    $action = $_POST['action'] ?? '';

    // Convert product ID to integer for safety
    $productID = (int)$productID;

    // Create the cart array if it does not exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Update the cart based on the selected action
    if ($productID > 0) {
        // Increase product quantity
        if ($action === 'plus') {
            $_SESSION['cart'][$productID] = ($_SESSION['cart'][$productID] ?? 0) + 1;
        }
        // Decrease product quantity
        if ($action === 'minus') {
            if (isset($_SESSION['cart'][$productID])) {
                $_SESSION['cart'][$productID]--;
                // Remove the product if quantity reaches zero
                if ($_SESSION['cart'][$productID] <= 0) {
                    unset($_SESSION['cart'][$productID]);
                }
            }
        }
        // Remove the product completely from the cart
        if ($action === 'remove') {
            unset($_SESSION['cart'][$productID]);
        }
    }
    // Return the total number of items in the cart
    echo array_sum($_SESSION['cart'] ?? []);

?>