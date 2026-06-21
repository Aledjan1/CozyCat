<?php
    session_start();

    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        header("Location: ../index.php");
        exit;
    }

    include "../includes/db.php";
    include "admin_nav.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $material = $_POST['material'];
        $description = $_POST['description'];
        $imageName = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $imagePath = "../images/" . $imageName;
        $dbImagePath = "images/" . $imageName;
        move_uploaded_file($imageTmp, $imagePath);

        $stmt = $conn->prepare("
            INSERT INTO cat_products
            (name, price, category, material, description, image)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "sdssss",
            $name,
            $price,
            $category,
            $material,
            $description,
            $dbImagePath,
        );

        $stmt->execute();

        header("Location: products.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/admin.css">
    <title>Add Product</title>
</head>
<body>
    <h1>Add Product</h1>
    <form method="POST" enctype="multipart/form-data" class="admin_form">
        <p>Name</p>
        <input type="text" name="name" required>
        <p>Price</p>
        <input type="number" step="0.01" name="price" required>
        <p>Category</p>
        <input type="text" name="category" required>
        <p>Material</p>
        <input type="text" name="material" required>
        <p>Description</p>
        <textarea name="description" required></textarea>
        <p>Image</p>
        <input type="file" name="image" required>
        <br><br>
        <button type="submit">Add Product</button>
    </form>
    <br>
    <a href="products.php" class="back_link">⬅ Back</a>
    <script src="../JS/admin.js"></script>
</body>
</html>