<?php 
    // Start session to check the logged-in user
    session_start();

    // Connect to the database
    include "includes/db.php";

    // Only logged-in users can submit reviews
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit;
    }

    // Get review data from the form
    $userID = $_SESSION['user_id'];
    $productID = (int)($_POST['productID'] ?? 0);
    $rating = (int)($_POST['rating'] ?? 0);
    $comment = trim($_POST['comment'] ?? '');

    // Validate review data before saving
    if ($productID <= 0 || $rating < 1 || $rating > 5 || empty($comment)) {
        header("Location: product_details.php?id=" . $productID);
        exit;
    }

   // Prepare SQL statement to insert a new review
    $stmt = $conn->prepare("
        INSERT INTO reviews (user_id, productID, rating, comment)
        VALUES (?, ?, ?, ?)
    ");

    // Bind values and execute the query
    $stmt->bind_param("iiis", $userID, $productID, $rating, $comment);
    $stmt->execute();

    // Calculate new average rating and total reviews
    $avgSql = "
        SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews
        FROM reviews
        WHERE productID = $productID
    ";

    // Execute the query and get the result
    $avgResult = $conn->query($avgSql);
    // Convert result into an associative array
    $row = $avgResult->fetch_assoc();

    // Store calculated values
    $averageRating = round($row['avg_rating'], 1);
    $totalReviews = (int)$row['total_reviews'];

    // Prepare SQL statement to update product data
    $updateStmt = $conn->prepare("
        UPDATE cat_products
        SET rating = ?, reviews_count = ?
        WHERE productID = ?
    ");

    // Bind values and execute the update
    $updateStmt->bind_param("dii", $averageRating, $totalReviews, $productID);
    $updateStmt->execute();

    // Return user back to the product page
    header("Location: product_details.php?id=" . $productID);
    exit;
?> 