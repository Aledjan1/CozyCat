<?php
    // Start session to use user login, favorites and cart features
    session_start();

    // Set page settings for the header
    // These variables are used in header.php
    $pageTitle = "Product Details";
    $activePage = "products";
    $pageCss = "CSS/product_details.css";
    $pageJs = "JS/product_details.js";

    // Connect to database and include the site header
    include "includes/db.php";
    include "includes/header.php";

    // Get product ID from the URL, for example product_details.php?id=5
    // Convert it to integer for safety
    $id = $_GET['id'] ?? 0;
    $id = (int)$id;

    // Find the selected product in the database
    $sql = "SELECT * FROM cat_products WHERE productID = $id";
    $result = $conn->query($sql);

    // If the product ID is wrong or product does not exist, stop the page
    if (!$result || $result->num_rows === 0) {
        echo "<p>Product not found.</p>";
        include "includes/footer.php";
        exit;
    }
    // Convert database result into an array so we can show product data
    $product = $result->fetch_assoc();
?>
<!-- Product details section -->
<section class="product_details">
    <!-- Product image and favorite button -->
    <div class="product_details_image">
        <img src="<?php echo htmlspecialchars($product['image']); ?>"
             alt="<?php echo htmlspecialchars($product['name']); ?>">
        <?php
            // Check if the logged-in user has already added this product to favorites
            // If yes, the heart button will be shown as active
            $isFavorite = false;

            if (isset($_SESSION['user_id'])) {
                $userID = (int)$_SESSION['user_id'];
                $productID = (int)$product['productID'];

                $favSql = "SELECT favoriteID FROM favorites WHERE user_id = $userID AND productID = $productID";
                $favResult = $conn->query($favSql);

                $isFavorite = ($favResult && $favResult->num_rows > 0);
            }
        ?>
        <span class="favorite_btn <?php echo $isFavorite ? 'active' : ''; ?>"
                data-product-id="<?php echo (int)$product['productID']; ?>">
            <?php echo $isFavorite ? '❤️' : '♡'; ?>
        </span>
    </div>
    <!-- Product information -->
    <div class="product_details_info">
        <h2 class="cart_name"><?php echo htmlspecialchars($product['name']); ?></h2>
        <p class="price">£<?php echo number_format($product['price'], 2); ?></p>
        <p><strong>Category: </strong><?php echo htmlspecialchars($product['category']); ?></p>
        <p><strong>Material: </strong><?php echo htmlspecialchars($product['material']); ?></p>
        <p><strong>Description: </strong><?php echo htmlspecialchars($product['description']); ?></p>
        <!-- Product rating -->
        <div class="rating_wrapper">
            <div class="rating">
                <?php
                    // Get product rating from the database
                    // Then show 5 stars based on the rating value
                    $rating = $product['rating'] ?? 0;

                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= round($rating)) {
                            echo '⭐';
                        } else {
                            echo '☆';
                        }
                    }
                ?>
                <?php echo $rating; ?>
                (<?php echo (int)($product['reviews_count'] ?? 0); ?>)
                ▼
            </div>
            <div class="rating_popup">
                <strong><?php echo $rating; ?> out of 5</strong><br>
                <?php echo (int)($product['reviews_count'] ?? 0); ?> reviews
            </div>
        </div>
        <!-- Add to cart button -->
        <button class="add_cart_btn" 
                data-product-id="<?php echo (int)$product['productID']; ?>">
            <img src="images/basket.png" alt="basket" class="basket"><span class="add">+ Add to basket</span>
        </button> 
    </div>
</section>

<!-- Reviews section -->
<section class="reviews_section">
    <h3>Customer Reviews</h3>
    <!-- Review form -->
    <?php if (isset($_SESSION['user_id'])): ?>
         <!-- Show review form only for logged-in users -->
        <form action="save_review.php" method="POST" class="review_form">
            <input type="hidden" name="productID" value="<?php echo (int)$product['productID']; ?>">

            <label>Your rating</label>
            <select name="rating" required>
                <option value="5">⭐⭐⭐⭐⭐ 5</option>
                <option value="4">⭐⭐⭐⭐ 4</option>
                <option value="3">⭐⭐⭐ 3</option>
                <option value="2">⭐⭐ 2</option>
                <option value="1">⭐ 1</option>
            </select>

            <textarea name="comment" placeholder="Write your review..." required></textarea>

            <button type="submit">Submit Review</button>
        </form>
    <?php else: ?>
         <!-- Ask guests to login before writing a review -->
        <p>Please login to write a review.</p>
    <?php endif; ?>

    <?php
        // Get all reviews for this product
        // Also get the user name from the users table
        $reviewSql = "
            SELECT reviews.rating, reviews.comment, reviews.created_at, users.name
            FROM reviews
            LEFT JOIN users ON reviews.user_id = users.usersID
            WHERE reviews.productID = " . (int)$product['productID'] . "
            ORDER BY reviews.created_at DESC
        ";

        $reviewResult = $conn->query($reviewSql);

        // Show SQL error if reviews query fails
        if (!$reviewResult) {
            echo "SQL Error: " . $conn->error;
        }
    ?>
    <!-- Reviews list -->
    <?php if ($reviewResult && $reviewResult->num_rows > 0): ?>
         <!-- Show reviews if this product has reviews -->
        <?php while ($review = $reviewResult->fetch_assoc()): ?>
             <!-- Show one review from the database -->
            <div class="review_item">
                <h4><?php echo htmlspecialchars($review['name'] ?? 'Anonymous'); ?></h4>

                <p class="review_stars">
                    <?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo ($i <= $review['rating']) ? '⭐' : '☆';
                        }
                    ?>
                </p>

                <p><?php echo htmlspecialchars($review['comment']); ?></p>
                <small><?php echo htmlspecialchars($review['created_at']); ?></small>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <!-- Show message if there are no reviews yet -->
        <p>No reviews yet.</p>
    <?php endif; ?>
</section>
<?php
    include "includes/footer.php"; // Include the site footer
?>