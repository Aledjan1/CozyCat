<?php
    session_start();

    $productID = $_POST['productID'] ?? 0;
    $productID = (int)$productID;

    if ($productID <= 0) {
        echo array_sum($_SESSION['cart'] ?? []);
        exit;
    }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (!isset($_SESSION['cart'][$productID])) {
        $_SESSION['cart'][$productID] = 1;
    } else {
        $_SESSION['cart'][$productID]++;
    }

    echo array_sum($_SESSION['cart']);

?>