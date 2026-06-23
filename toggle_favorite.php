<?php
    // Start session to access the logged-in user
    session_start();

     // Connect to the database
    include "includes/db.php";

    // Get product ID sent by JavaScript using POST
    // Convert it to integer for safety
    $productID = $_POST['productID'] ?? 0;
    $productID = (int)$productID;

    // Stop the script if product ID is missing or invalid
    if ($productID <= 0) {
        exit;
    }

    // Only logged-in users can add products to favorites
    if (!isset($_SESSION['user_id'])) {
        echo "login-required";
        exit;
    }
    
    // Get logged-in user ID from the session
    $userID = (int)$_SESSION['user_id'];

    // Check if this product is already in user's favorites
    $check = $conn->prepare("SELECT * FROM favorites WHERE user_id = ? AND productID = ?");
    $check->bind_param("ii", $userID, $productID);
    $check->execute();
    $result = $check->get_result();

    // If product is already favorite, remove it
    if ($result->num_rows > 0) {
        $delete = $conn->prepare("DELETE FROM favorites WHERE user_id = ? AND productID = ?");
        $delete->bind_param("ii", $userID, $productID);
        $delete->execute();

        echo "removed";
    // If product is not favorite, add it
    } else {
        $insert = $conn->prepare("INSERT INTO favorites (user_id, productID) VALUES (?, ?)");
        $insert->bind_param("ii", $userID, $productID);
        $insert->execute();

        echo "added";
    }
?>