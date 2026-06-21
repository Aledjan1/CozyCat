<?php 
    session_start();

    include "includes/db.php";

    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit;
    }

    $userID = $_SESSION['user_id'];
    $productID = (int)($_POST['productID'] ?? 0);
    $rating = (int)($_POST['rating'] ?? 0);
    $comment = trim($_POST['comment'] ?? '');

    if ($productID <= 0 || $rating < 1 || $rating > 5 || empty($comment)) {
        header("Location: product_details.php?id=" . $productID);
        exit;
    }

    $stmt = $conn->prepare("
        INSERT INTO reviews (user_id, productID, rating, comment)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->bind_param("iiis", $userID, $productID, $rating, $comment);
    $stmt->execute();

    $avgSql = "
        SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews
        FROM reviews
        WHERE productID = $productID
    ";

    $avgResult = $conn->query($avgSql);
    $row = $avgResult->fetch_assoc();

    $averageRating = round($row['avg_rating'], 1);
    $totalReviews = (int)$row['total_reviews'];

    $updateStmt = $conn->prepare("
        UPDATE cat_products
        SET rating = ?, reviews_count = ?
        WHERE productID = ?
    ");

    $updateStmt->bind_param("dii", $averageRating, $totalReviews, $productID);
    $updateStmt->execute();

    header("Location: product_details.php?id=" . $productID);
    exit;
?> 