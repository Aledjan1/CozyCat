<?php
    // Start session to check admin access
    session_start();

    // Allow only admin users to open this page
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        header("Location: ../index.php");
        exit;
    }

     // Connect to database and load admin navigation
    include "../includes/db.php";
    include "admin_nav.php";

    // Get product ID from URL and convert it to integer
    $productID = $_GET['id'] ?? 0;
    $productID = (int)$productID;

    // Find the product that admin wants to edit
    $sql ="SELECT * FROM cat_products WHERE productID = $productID";
    $result = $conn->query($sql);

    // Stop if product does not exist
    if (!$result || $result->num_rows === 0) {
        echo "Product not found";
        exit;
    }

    // Convert product data into an array for the form
    $product = $result->fetch_assoc();

     // Run this code only after admin submits the form
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get updated product data from the form
        $name = $_POST['name'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $material = $_POST['material'];
        $description = $_POST['description'];
        // Get uploaded image and prepare file paths
        $imageName = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $imagePath ="../images/" . $imageName;
        $dbImagePath = "images/" . $imageName;
         // Move uploaded image to the images folder
        move_uploaded_file($imageTmp, $imagePath);

        // Prepare safe SQL query to update product
        $stmt = $conn->prepare("
            UPDATE cat_products
            SET name = ?, price = ?, category = ?, material = ?, description = ?, image = ?
            WHERE productID = ?
        ");

         // Add form values to the prepared query
        $stmt->bind_param(
            "sdssssi",
            $name,
            $price,
            $category,
            $material,
            $description,
            $dbImagePath,
            $productID
        );

        // Save changes in the database
        $stmt->execute();

        // Return admin to products page
        header("Location: products.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/admin.css">
    <title>Edit Product</title>
</head>
<body>
     <!-- Page title -->
    <h1>Edit Product</h1>
    <!-- Form for updating product information -->
    <form method="POST"  enctype="multipart/form-data" class="admin_form">
         <!-- Product name -->
        <p>Name</p>
        <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        <!-- Product price -->
        <p>Price</p>
        <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
         <!-- Product category -->
        <p>Category</p>
        <input type="text" name="category" value="<?php echo htmlspecialchars($product['category']); ?>" required>
         <!-- Product material -->
        <p>Material</p>
        <input type="text" name="material" value="<?php echo htmlspecialchars($product['material']); ?>" required>
         <!-- Product description -->
        <p>Description</p>
        <textarea name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
         <!-- Upload a new product image -->
        <p>Image</p>
        <input type="file" name="image" value="<?php echo htmlspecialchars($product['image']); ?>">
         <!-- Save changes button -->
        <br><br>
        <button type="submit">Save Changes</button>
    </form>
    <br>
     <!-- Link back to products page -->
    <a href="products.php" class="back_link">⬅ Back</a>
    <!-- Admin JavaScript -->
    <script src="../JS/admin.js"></script>
</body>
</html>