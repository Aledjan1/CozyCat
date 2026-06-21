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

    $sql ="SELECT * FROM cat_products WHERE productID = $productID";
    $result = $conn->query($sql);

    if (!$result || $result->num_rows === 0) {
        echo "Product not found";
        exit;
    }

    $product = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $material = $_POST['material'];
        $description = $_POST['description'];
        $imageName = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_mame'];
        $imagePath ="../images/" . $imageName;
        $dbImagePath = "images/" . $imageName;
        move_uploaded_file($imageTmp, $imagePath);

        $stmt = $conn->prepare("
            UPDATE cat_products
            SET name = ?, price = ?, category = ?, material = ?, description = ?, image = ?
            WHERE productID = ?
        ");

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

        $stmt->execute();

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
    <h1>Edit Product</h1>
    <form method="POST"  enctype="multipart/form-data" class="admin_form">
        <p>Name</p>
        <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        <p>Price</p>
        <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
        <p>Category</p>
        <input type="text" name="category" value="<?php echo htmlspecialchars($product['category']); ?>" required>
        <p>Material</p>
        <input type="text" name="material" value="<?php echo htmlspecialchars($product['material']); ?>" required>
        <p>Description</p>
        <textarea name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
        <p>Image</p>
        <input type="file" name="image" value="<?php echo htmlspecialchars($product['image']); ?>">
        <br><br>
        <button type="submit">Save Changes</button>
    </form>
    <br>
    <a href="products.php" class="back_link">⬅ Back</a>
    <script src="../JS/admin.js"></script>
</body>
</html>