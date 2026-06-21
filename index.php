<?php
    session_start();

    $pageTitle = "Home";
    $pageCss = "CSS/home.css";
    $activePage = "home";
    $pageJs = "JS/home.js";

    include "includes/db.php";

    $sql = "SELECT * FROM cat_products ORDER BY productID DESC LIMIT 4";
    $result = $conn->query($sql);

    include "includes/header.php";
?>

<section class="banner">
    <button class="slider_btn prev" onclick="prevSlide()">&lt;</button>
        <div class="banner_content">
            <h2 class="banner_title" id="bannerTitle">Cozy homes for happy cats</h2>
            <p class="banner_text" id="bannerText">Stylish, comfortable and safe cat houses that your feline friend will love</p>
            <a href="products.php" class="banner_buy_btn">Buy Now<img src="images/pets.png" class="paws" alt="cats paws"></a>
        </div>
    <button class="slider_btn next" onclick="nextSlide()">&gt;</button>
</section>
<section class="features">
    <div class="features_container">
        <div class="feature_item">
            <div class="feature_icon">🛡️</div>
                <div class="feature_text">
                    <h3>Safe Materials</h3>
                    <p>Eco-friendly and pet-safe design</p>
                </div>  
        </div>
        <div class="feature_item">
            <div class="feature_icon">🚚</div>
                <div class="feature_text">
                    <h3>Free Delivery</h3>
                    <p>On all orders over £50</p>
                </div>
        </div>
        <div class="feature_item">
            <div class="feature_icon">❤️</div>
                <div class="feature_text">
                    <h3>Happy Cats</h3>
                    <p>Loved by thousands of pets</p>
                </div>
        </div>
        <div class="feature_item">
            <div class="feature_icon">🔰</div>
                <div class="feature_text">
                    <h3>Ultimate Comfort</h3>
                    <p>Soft and cozy spaces for your cat</p>
                </div>
        </div>
    </div>
</section>
<section class="products">
    <div class="products_header">
        <h2>Popular Cat Houses</h2>
        <a href="products.php">View all products</a>
    </div>
     <div class="products_container">
        <?php if($result && $result->num_rows > 0): ?>
            <?php while ($product = $result->fetch_assoc()): ?>
                <div class="product_cart">
                    <a href="product_details.php?id=<?php echo (int)$product['productID']; ?>" class="product_link">
                        <img
                            src="<?php echo htmlspecialchars($product['image']); ?>"
                             alt="<?php echo htmlspecialchars($product['name']); ?>"
                            class="image_product"
                        >
                        <div class="product_info">
                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p>£<?php echo number_format($product['price'], 2); ?></p>
                        </div>
                    </a>
                    <div class="rating"> 
                        <?php 
                            $rating = $product['rating'] ?? 0;
                            
                            for ($i = 1; $i <= 5; $i++) {
                                if($i <= $rating) {
                                    echo '<span class="star filled">⭐</span>';
                                } else {
                                    echo '<span class="star empty">☆</span>';
                                }
                            }
                        ?>
                    </div>
                    <button class="add_cart_btn" data-product-id="<?php echo (int)$product['productID']; ?>">
                        <img src="images/basket.png" alt="basket" class="basket">
                    </button>
                </div>  
            <?php endwhile; ?>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>
</section>
<section class="video_section">
    <div class="video_frame">
        <iframe  
            src="https://www.youtube.com/embed/-T4FJ1zfggY?si=VcYYx2SNBiiqVHBH" 
            title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
        </iframe>
    </div>
    <div class="video_content">
        <h2>How to choose the perfect<br>home for your cat<img src="images/paw.png" alt="Two cat paws" id="paw"></h2>
        <p>Watch our short video to make the best choice for your furry friend.</p>
        <a href="https://www.youtube.com/watch?v=DleF8UxSDWc"
            target="_blank"
            class="watch_btn">Watch Video<img src="images/play.png" alt="Button play" id="button_play"></a>
    </div>
</section>

<?php include "includes/footer.php"; ?>
        