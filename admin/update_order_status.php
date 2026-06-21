<?php
    session_start();

    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        header("Location: ../index.php");
        exit;
    }

    include "../includes/db.php";
    include "admin_nav.php";

    $orderID = (int)($_POST['orderID'] ?? 0);
    $status = $_POST['status'] ?? 'Pending';

    $stmt = $conn->prepare("
        UPDATE orders
        SET status =?
        WHERE orderID = ?
    ");

    $stmt->bind_param("si", $status, $orderID);
    $stmt->execute();

    header("Location: orders.php");
    exit;
?>