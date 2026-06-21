<?php
    session_start();

    $productID = $_POST['productID'] ?? 0;
    $action = $_POST['action'] ?? '';

    $productID = (int)$productID;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if ($productID > 0) {
        if ($action === 'plus') {
            $_SESSION['cart'][$productID] = ($_SESSION['cart'][$productID] ?? 0) + 1;
        }
        if ($action === 'minus') {
            if (isset($_SESSION['cart'][$productID])) {
                $_SESSION['cart'][$productID]--;

                if ($_SESSION['cart'][$productID] <= 0) {
                    unset($_SESSION['cart'][$productID]);
                }
            }
        }
        if ($action === 'remove') {
            unset($_SESSION['cart'][$productID]);
        }
    }
    echo array_sum($_SESSION['cart'] ?? []);

?>