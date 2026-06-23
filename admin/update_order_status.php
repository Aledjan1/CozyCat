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

    // Get order ID and new status from the form
    $orderID = (int)($_POST['orderID'] ?? 0);
    $status = $_POST['status'] ?? 'Pending';

    // Update the order status in the database
    $stmt = $conn->prepare("
        UPDATE orders
        SET status =?
        WHERE orderID = ?
    ");

    // Bind values and execute the query
    $stmt->bind_param("si", $status, $orderID);
    $stmt->execute();

    // Return to the orders page after updating
    header("Location: orders.php");
    exit;
?>