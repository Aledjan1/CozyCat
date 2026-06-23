<?php
    // Start session to check the logged-in user's role
    session_start();

    // Allow access only for admin users
    // If the user is not admin, redirect to the home page
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        header("Location: ../index.php");
        exit;
    }

     // Connect to the database and load admin navigation
    include "../includes/db.php";
    include "admin_nav.php";

    // Run this code only when the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         // Get product data from the form
        $name = $_POST['name'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $material = $_POST['material'];
        $description = $_POST['description'];
        // Get uploaded image information
        $imageName = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];
         // Set image paths for saving and database storage
        $imagePath = "../images/" . $imageName;
        $dbImagePath = "images/" . $imageName;
        // Move uploaded image into the images folder
        move_uploaded_file($imageTmp, $imagePath);

        // Prepare SQL query to add a new product
        $stmt = $conn->prepare("
            INSERT INTO cat_products
            (name, price, category, material, description, image)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        // Attach form values to the prepared SQL query
        $stmt->bind_param(
            "sdssss",
            $name,
            $price,
            $category,
            $material,
            $description,
            $dbImagePath,
        );

        // Save the new product in the database
        $stmt->execute();

        // Redirect back to the admin products page
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
      <!-- Product form title -->
    <h1>Add Product</h1>
      <!-- Form for adding a new product -->
    <form method="POST" enctype="multipart/form-data" class="admin_form">
         <!-- Product details fields -->
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
          <!-- Image upload field -->
        <p>Image</p>
        <input type="file" name="image" required>
        <br><br>
         <!-- Submit button -->
        <button type="submit">Add Product</button>
    </form>
    <br>
     <!-- Back to products page -->
    <a href="products.php" class="back_link">⬅ Back</a>
    <script src="../JS/admin.js"></script>
</body>
</html>