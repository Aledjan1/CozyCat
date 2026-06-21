<?php
    session_start();
    include "includes/db.php";

    $productID = $_POST['productID'] ?? 0;
    $productID = (int)$productID;

    if ($productID <= 0) {
        exit;
    }

    if (!isset($_SESSION['user_id'])) {
        echo "login-required";
        exit;
    }
        
    $userID = (int)$_SESSION['user_id'];

    $check = $conn->prepare("SELECT * FROM favorites WHERE user_id = ? AND productID = ?");
    $check->bind_param("ii", $userID, $productID);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $delete = $conn->prepare("DELETE FROM favorites WHERE user_id = ? AND productID = ?");
        $delete->bind_param("ii", $userID, $productID);
        $delete->execute();

        echo "removed";
    } else {
        $insert = $conn->prepare("INSERT INTO favorites (user_id, productID) VALUES (?, ?)");
        $insert->bind_param("ii", $userID, $productID);
        $insert->execute();

        echo "added";
    }
?>