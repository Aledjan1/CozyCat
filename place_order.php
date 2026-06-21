<?php
    session_start();
    include "includes/db.php";

    $cart = $_SESSION['cart'] ?? [];
    $userID = (int)($_SESSION['user_id'] ?? 0);

    if ($userID <= 0) {
    header("Location: index.php");
    exit;
    }

    if (empty($cart)) {
        header("Location: products.php");
        exit;
    }

    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $city = $_POST['city'] ?? '';
    $postcode = $_POST['postcode'] ?? '';
    $delivery = $_POST['delivery'] ?? 'standard';

    $ids = implode(",", array_map("intval", array_keys($cart)));
    $sql = "SELECT productID, price FROM cat_products WHERE productID IN ($ids)";
    $result = $conn->query($sql);

    if (!$result) {
        die("SQL Error: " . $conn->error);
    }

    $total = 0;
    $products = [];

    while ($product = $result->fetch_assoc()) {
        $id = $product['productID'];
        $qty = $cart[$id];
        $price = $product['price'];

        $total += $price * $qty;

         $products[] = [
            "productID" => $id,
            "quantity" => $qty,
            "price" => $price
         ];
    }

    $stmt = $conn->prepare ("
        INSERT INTO orders
        (user_id, fullname, email, phone, address, city, postcode, delivery, total)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
     ");

     if (!$stmt) {
        die("Prepare failed: " . $conn->error);
     }

    $stmt->bind_param (
        "isssssssd",
        $userID,
        $fullname,
        $email,
        $phone,
        $address,
        $city,
        $postcode,
        $delivery,
        $total
    );
    $stmt->execute();

    $orderID =$stmt->insert_id;

    $itemStmt = $conn->prepare ("
        INSERT INTO order_items
        (orderID, productID, quantity, price)
        VALUES (?, ?, ?, ?)
    ");

    foreach ($products as $item) {
        $itemStmt->bind_param(
            "iiid",
            $orderID,
            $item['productID'],
            $item['quantity'],
            $item['price']
        );

        $itemStmt->execute();
    }

    unset($_SESSION['cart']);

    header("Location: order_success.php?orderID=" . $orderID);
    exit;   
?>