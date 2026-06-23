<?php
    // Start session to access admin data
    session_start();

     // Allow access only for administrators
    // Redirect other users to the home page
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        header("Location: ../index.php");
        exit;
    }

    // Connect to the database and load admin navigation
    include "../includes/db.php";
    include "admin_nav.php";

     // Get product ID from the URL
    // Convert it to integer for safety
    $productID = $_GET['id'] ?? 0;
    $productID = (int)$productID;

    // Redirect back if the product ID is invalid
    if ($productID <= 0) {
        header("Location: products.php");
        exit;
    }

    // Delete the selected product from the database
    // Prepared statement is used for security
    $stmt = $conn->prepare("DELETE FROM cat_products WHERE productID = ?");
    $stmt->bind_param("i", $productID);
    $stmt->execute();

    // Return to the products page after deletion
    header("Location: products.php");
    exit;
?>