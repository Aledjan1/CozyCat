<?php
    session_start();

    $pageTitle = "Products";
    $activePage = "products";
    $pageCss = "CSS/product.css";
    $pageJs = "JS/product.js";

    include "includes/db.php";
    include "includes/header.php";


    $category = $_GET['category'] ?? '';
    $material = $_GET['material'] ?? '';
    $sort = $_GET['sort'] ?? 'newest';
    $price = $_GET['price'] ?? 100;
    $page = $_GET['page'] ?? 1;
    $page = (int)$page;
    $search = $_GET['search'] ?? '';

    if ($page < 1) {
        $page = 1;
    }

    $limit = 8;
    $offset = ($page - 1) * $limit;

    $where = " WHERE 1";

    if (!empty($category)) {
        $categorySafe = $conn->real_escape_string($category);
        $where .= " AND category = '$categorySafe'";
    }

    if (!empty($material)) {
        $materialSafe = $conn->real_escape_string($material);
        $where .= " AND material = '$materialSafe'";
    }

    if (!empty($price)) {
        $price = (int)$price;
        $where .= " AND price <= $price";
    }

    if (!empty($search)) {
        $searchSafe = $conn->real_escape_string($search);

        $where .= " AND (
            name LIKE '%$searchSafe%'
            OR category LIKE '%$searchSafe%'
            OR material LIKE '%$searchSafe%'
            OR description LIKE '%$searchSafe%'
            )";
    }

    $countSql = "SELECT COUNT(*) AS total FROM cat_products" . $where;
    $countResult = $conn->query($countSql);

    if (!$countResult) {
        die($conn->error);
    }

    $totalProducts = $countResult->fetch_assoc()['total'];
    $totalPages = ceil($totalProducts / $limit);

    $sql = "SELECT * FROM cat_products" . $where;

    if($sort === 'price_low') {
        $sql .= " ORDER BY price ASC";
    } elseif ($sort === 'price_high') {
        $sql .= " ORDER BY price DESC";
    } elseif ($sort === 'name_az') {
        $sql .= " ORDER BY name ASC";
    } else {
        $sql .= " ORDER BY productID DESC";
    }

    $sql .= " LIMIT $limit OFFSET $offset";

    $result = $conn->query($sql);

    if (!$result) {
        die($conn->error);
    }
?>

<section class="products_items">
    <div class="products_top">
        <div class="products_header">
            <h2 class="banner_title">Our Cat Houses <span>🐾</span></h2>
            <p class="banner_text">Stylish, comfortable and safe homes for your feline friend.</p>
        </div>

        <form method="GET" class="products_sort">
            <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
            <select name="sort" onchange="this.form.submit()">
                <option value="newest" <?php if($sort === 'newest') echo 'selected'; ?>>Sort by: Newest</option>
                <option value="price_low" <?php if($sort === 'price_low') echo 'selected'; ?>>Price: Low to High</option>
                <option value="price_high" <?php if($sort === 'price_high') echo 'selected'; ?>>Price: High to Low</option>
                <option value="name_az" <?php if($sort === 'name_az') echo 'selected'; ?>>Name: A-Z</option>
            </select>

        <button type="button" class="filter_top_btn">☰ Filter</button>

        <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
        <input type="hidden" name="material" value="<?php echo htmlspecialchars($material); ?>">
        <input type="hidden" name="price" value="<?php echo htmlspecialchars($price); ?>">
        </form>
    </div>
    <div class="product_layout">
        <aside class="sidebar_filter">
            <form method="GET">
                <h3>Categories</h3>
                <label>
                    <input type="radio" name="category" value=""
                    <?php if($category === '') echo 'checked'; ?>>
                    All products
                </label>
                <label>
                    <input type="radio" name="category" value="Indoor Houses"
                    <?php if($category === 'Indoor Houses') echo 'checked'; ?>>
                    Indoor Houses
                </label>
                <label>
                    <input type="radio" name="category" value="Outdoor Houses"
                    <?php if($category === 'Outdoor Houses') echo 'checked'; ?>>
                    Outdoor Houses
                </label>
                <label>
                    <input type="radio" name="category" value="Modern Houses" 
                    <?php if($category === 'Modern Houses') echo 'checked'; ?>>
                    Modern Houses
                </label>
                <label>
                    <input type="radio" name="category" value="Luxury Houses"
                    <?php if($category === 'Luxury Houses') echo 'checked'; ?>>
                    Luxury Houses
                </label>
                <h3>Material</h3>
                <label>
                    <input type="radio" name="material" value="" 
                    <?php if($material === '') echo 'checked'; ?>>
                    All Materials
                </label>
                <label>
                    <input type="radio" name="material" value="Wood"
                    <?php if($material === 'Wood') echo 'checked'; ?>>
                    Wood
                </label>
                <label>
                    <input type="radio" name="material" value="Wicker" 
                    <?php if($material === 'Wicker') echo 'checked'; ?>>
                    Wicker
                </label>
                <label>
                    <input type="radio" name="material" value="Felt" 
                    <?php if($material === 'Felt') echo 'checked'; ?>>
                    Felt
                </label>
                <label>
                    <input type="radio" name="material" value="Fabric" 
                    <?php if($material === 'Fabric') echo 'checked'; ?>>
                    Fabric
                </label>
                <h3>Price</h3>
                    <input type="range" name="price" min="20" max="100" value="<?php echo htmlspecialchars($price); ?>">
                <p>Up to £<?php echo htmlspecialchars($price); ?></p>
                <input type="hidden" name="sort" value="<?php echo htmlspecialchars($sort); ?>">
                <button type="submit" class="filter_btn">Apply filter</button>
                </form>
        </aside>
        <div class="products_container">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($product = $result->fetch_assoc()): ?>
                        <div class="product_cart">
                            <?php
                                $isFavorite = false;

                                if (isset($_SESSION['user_id'])) {
                                    $userID = (int)$_SESSION['user_id'];
                                    $productID = (int)$product['productID'];

                                    $favSql = "SELECT favoriteID FROM favorites WHERE user_id = $userID AND productID = $productID";
                                    $favResult = $conn->query($favSql);

                                    $isFavorite = ($favResult && $favResult->num_rows > 0);
                                }
                            ?>
                            <a href="product_details.php?id=<?php echo (int)$product['productID']; ?>" class="product_link">
                                <div class="product_image_box">
                                    <img
                                        src="<?php echo htmlspecialchars($product['image']); ?>"
                                        alt="<?php echo htmlspecialchars($product['name']); ?>"
                                        class="image_product"
                                    >

                                    <span class="favorite_btn <?php echo $isFavorite ? 'active' : ''; ?>"
                                        data-product-id="<?php echo (int)$product['productID']; ?>">
                                        <?php echo $isFavorite ? '❤️' : '♡'; ?>
                                    </span>
                                </div>
                                <div class="product_info">
                                    <h3 class="product_title"><?php echo htmlspecialchars($product['name']); ?></h3>
                                    <p class="product_price">£<?php echo number_format($product['price'], 2); ?></p>
                                </div>
                            </a>
                            <div class="rating">
                                <?php
                                    $rating = $product['rating'] ?? 0;

                                    for($i = 1; $i <= 5; $i++) {
                                        echo ($i <= round($rating)) ? '⭐' : '☆';                                    }
                                ?>
                                <span class="reviews_count">
                                    (<?php echo (int)($product['reviews_count'] ?? 0); ?>)
                                </span>
                            </div>
                            <button class="add_cart_btn" 
                                    data-product-id="<?php echo (int)$product['productID']; ?>">
                                <img src="images/basket.png" alt="basket" class="basket"><span class="add">+ Add to basket</span>
                            </button>
                        </div>
                    <?php endwhile; ?>
            <?php else: ?>
                <p>No products found.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="products.php?page=<?php echo $page - 1; ?>&category=<?php echo urlencode($category); ?>&material=<?php echo urlencode($material); ?>&price=<?php echo urlencode($price); ?>&sort=<?php echo urlencode($sort); ?>&search=<?php echo urlencode($search); ?>"><</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="products.php?page=<?php echo $i; ?>&category=<?php echo urlencode($category); ?>&material=<?php echo urlencode($material); ?>&price=<?php echo urlencode($price); ?>&sort=<?php echo urlencode($sort); ?>&search=<?php echo urlencode($search); ?>"
            class="<?php if ($page === $i) echo 'active_page'; ?>">
            <?php echo $i; ?>
            </a>   
        <?php endfor; ?> 
        <?php if ($page < $totalPages): ?>
            <a href="products.php?page=<?php echo $page + 1; ?>&category=<?php echo urlencode($category); ?>&material=<?php echo urlencode($material); ?>&price=<?php echo urlencode($price); ?>&sort=<?php echo urlencode($sort); ?>&search=<?php echo urlencode($search); ?>">></a>
        <?php endif; ?>
    </div>
</section>

<?php include "includes/footer.php";
$conn->close();
?>
        