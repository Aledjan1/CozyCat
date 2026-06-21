<?php
    session_start();

    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        header("Location: ../index.php");
        exit;
    }

    include "../includes/db.php";
    include "admin_nav.php";

    $productID = $_GET['id'] ?? 0;
    $productID = (int)$productID;

    if ($productID <= 0) {
        header("Location: products.php");
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM cat_products WHERE productID = ?");
    $stmt->bind_param("i", $productID);
    $stmt->execute();

    header("Location: products.php");
    exit;
?>