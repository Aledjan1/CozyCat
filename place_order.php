<?php
    // Start session to access the cart and logged-in user
    session_start();

    // Connect to the database
    include "includes/db.php";

    // Get cart data and current user ID
    $cart = $_SESSION['cart'] ?? [];
    $userID = (int)($_SESSION['user_id'] ?? 0);

    // Redirect if the user is not logged in
    if ($userID <= 0) {
    header("Location: index.php");
    exit;
    }

    // Redirect if the cart is empty
    if (empty($cart)) {
        header("Location: products.php");
        exit;
    }

    // Get checkout form data
    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $city = $_POST['city'] ?? '';
    $postcode = $_POST['postcode'] ?? '';
    $delivery = $_POST['delivery'] ?? 'standard';

    // Get product IDs from the cart
    $ids = implode(",", array_map("intval", array_keys($cart)));

     // Get product prices from the database
    $sql = "SELECT productID, price FROM cat_products WHERE productID IN ($ids)";
    $result = $conn->query($sql);

    // Stop the script if the query fails
    if (!$result) {
        die("SQL Error: " . $conn->error);
    }

    // Prepare total price and product list
    $total = 0;
    $products = [];

    // Calculate total price and save order items
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

    // Prepare SQL query to create a new order
    $stmt = $conn->prepare ("
        INSERT INTO orders
        (user_id, fullname, email, phone, address, city, postcode, delivery, total)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
     ");

     // Stop the script if prepare fails
     if (!$stmt) {
        die("Prepare failed: " . $conn->error);
     }

    // Add order data safely into the prepared query
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

    // Save the order in the database
    $stmt->execute();

     // Get the new order ID
    $orderID =$stmt->insert_id;

    // Prepare SQL query to save products from the order
    $itemStmt = $conn->prepare ("
        INSERT INTO order_items
        (orderID, productID, quantity, price)
        VALUES (?, ?, ?, ?)
    ");

    // Save each product into order_items table
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

    // Clear the cart after successful order
    unset($_SESSION['cart']);

    // Redirect user to the success page
    header("Location: order_success.php?orderID=" . $orderID);
    exit;   
?>