<?php
    // Start session to access the shopping cart
    session_start();

    // Get product ID from the POST request
    $productID = $_POST['productID'] ?? 0;
    $productID = (int)$productID;

    // Stop if the product ID is invalid
    if ($productID <= 0) {
        echo array_sum($_SESSION['cart'] ?? []);
        exit;
    }

    // Create the cart array if it does not exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add a new product or increase its quantity
    if (!isset($_SESSION['cart'][$productID])) {
        $_SESSION['cart'][$productID] = 1;
    } else {
        $_SESSION['cart'][$productID]++;
    }

    // Return the total number of items in the cart
    echo array_sum($_SESSION['cart']);
?>