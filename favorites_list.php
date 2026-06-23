<?php
// Start session to check the logged-in user
session_start();

// Connect to the database
include "includes/db.php";

// Show modal close button and title
echo '<span onclick="closeFavorites()" class="close">×</span>';
echo '<h2>Your Favorites</h2>';

// Stop if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    echo '<p>Please login to view favorites.</p>';
    exit;
}

// Get the current user ID
$userID = (int) $_SESSION['user_id'];

// Get user's favorite products from the database
$sql = "SELECT 
            cat_products.productID, 
            cat_products.name,  
            cat_products.price,
            cat_products.image 
        FROM favorites
        INNER JOIN cat_products
        ON favorites.productID = cat_products.productID 
        WHERE favorites.user_id = $userID";

$result = $conn->query($sql);

// Stop if the SQL query has an error
if (!$result) {
    echo "SQL Error: " . $conn->error;
    exit;
}

// Show message if there are no favorite products
if (!$result || $result->num_rows === 0) {
    echo '<p>No favorites yet</p>';
    exit;
}

// Display each favorite product
while ($product = $result->fetch_assoc()) {
    echo '
        <div class="favorite_item">
            <img src="' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '">
            
            <div class="favorite_info">
                <h4>' . htmlspecialchars($product['name']) . '</h4>
                <p>£' . number_format($product['price'], 2) . '</p>

                <button class="favorite_add_cart"
                        data-product-id="' . $product['productID'] . '">
                        🛒 Add to Cart
                </button>
                <button class="favorite_remove" 
                        data-product-id="' . $product['productID'] . '">
                        ❌ Remove
                </button>
            </div>
        </div>
    ';
}
?>