<?php
    // Start session to check the logged-in user
    session_start();

    // Allow access only for admin users
    // If the user is not admin, redirect to the home page
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        header("Location: ../index.php");
        exit;
    }

     // Include admin navigation and database connection
    include "admin_nav.php";
    include "../includes/db.php";

    // Get all products from the database
    // Newest products will be shown first
    $sql = "SELECT * FROM cat_products ORDER BY productID DESC";
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/admin.css">
    <title>Manage Products</title>
</head>
<body>
    <!-- Admin products page -->
    <div class="admin_container">
        <!-- Page title and description -->
        <div class="admin_header">
            <h1>📦 Manage Products</h1>
            <p>Add, edit or delete products.</p>
        </div>
        <!-- Link to add a new product -->
        <p><a href="add_product.php" class="back_link">➕ Add Product</a></p>
        <!-- Products table -->
        <table border="1" cellpadding="10" class="admin_table">
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>

            <?php while ($product = $result->fetch_assoc()): ?>
                <!-- Show one product row from the database -->
                <tr>
                    <td><?php echo $product['productID']; ?></td>
                    <td><img src="../<?php echo htmlspecialchars($product['image']); ?>" alt=""></td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td><?php echo $product['price']; ?></td>
                    <!-- Edit and delete product links -->
                    <td class="admin_actions">
                        <a href="edit_product.php?id=<?php echo $product['productID']; ?>">Edit</a>
                        <a href="delete_product.php?id=<?php echo $product['productID']; ?>"
                        onclick="return confirm('Delete this product?');">
                        Delete
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <br>
        <!-- Back to dashboard link -->
        <a href="dashboard.php" class="back_link">⬅ Back to Dashboard</a>
    </div>
    <!-- Admin JavaScript file -->
    <script src="../JS/admin.js"></script>
</body>
</html>