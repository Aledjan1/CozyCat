<?php
    $cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
    $isLoggedIn = isset($_SESSION['user_id']);
    $userName = $_SESSION['user_name'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="CSS/common.css"> 
    <link rel="icon" type="image/png" href="images/animal_shelter.png">
    <title><?php echo $pageTitle ?? "CozyCat"; ?></title>
    <?php if (!empty($pageCss)): ?>
        <link rel="stylesheet" type="text/css" href="<?php echo $pageCss; ?>">
    <?php endif; ?>
</head>
<body>
    <div class="container">
        <!-- TopBar -->
        <div class="top_bar">
            <div class="top_left">
                <p>🚚Free delivery on orders over £50</p>
            </div>
            <div class="top_right">
                <?php if ($isLoggedIn): ?>
                    <a href="account.php" class="login_btn">
                        👤 <?php echo htmlspecialchars($userName); ?>
                    </a>
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <a href="admin/dashboard.php" class="admin_btn">⚙️ Admin</a>
                    <?php endif; ?>
                    <a href="auth/logout.php" class="register_btn">Logout</a>
                <?php else: ?>
                    <button onclick="openLogin()" class="login_btn">👤Login</button>
                    <button onclick="openRegister()" class="register_btn">📋Register</button>
                <?php endif; ?>
                <?php
                    $cartCount = array_sum($_SESSION['cart'] ?? []);
                ?>
                <button onclick="openCart()" class="cart_btn">🛒 Cart (<span class="cart_count"><?php echo $cartCount; ?></span>)</button>
            </div>   
        </div>
        <div class="mobile_overlay"></div>
        <div class="mobile_menu">
            <span class="mobile_close">×</span>
            <h3>MENU</h3>
                <a href="index.php">🏠 Home</a>
                <a href="products.php">🛍 Products</a>
                <a href="about.php">ⓘ About</a>
                <a href="care.php">🐾 Care</a>
            <hr>
            <h3>ACCOUNT</h3>
                <?php if ($isLoggedIn): ?>
                    <a href="account.php">👤 My Account</a>
                    <a href="my_orders.php">📦 My Orders</a>
                    <a href="#" onclick="openFavorites()">♡ Favorites</a>
                <?php else: ?>
                    <a href="#" onclick="closeMobileMenu(); onclick=openLogin()">👤 Login</a>
                    <a href="#" onclick="closeMobileMenu(); onclick=openRegister()">📋 Register</a>
                <?php endif; ?>
            <hr>
            <h3>MORE</h3>
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <a href="admin/dashboard.php">⚙️ Admin Panel</a>
            <?php endif; ?>
            <a href="#" onclick="openCart()">🛒 Cart</a>
            <?php if ($isLoggedIn): ?>
                <a href="auth/logout.php">↪ Logout</a>
            <?php endif; ?>
        </div>
        <!--NavBar-->
        <header class="header">
            <div class="menu_toggle">☰</div>
            <div class="header_logo">
                <a href="index.php"><img src="images/animal-shelter.png" alt="CozyCat logo"></a>
                <div class="logo_text">
                    <h1>Cozy<span style="color:#DB5C69">Cat</span></h1>
                    <p><img src="images/paw.png" alt="cats paws" class="paws">HOMES<img src="images/paw.png" alt="cats paws" class="paws"></p>
                </div>
            </div>
            <nav class="header_nav">
                <ul>
                    <li><a href="index.php" class="<?php echo ($activePage === 'home') ? 'active' : ''; ?>">Home</a></li>
                    <li><a href="products.php" class="<?php echo ($activePage === 'products') ? 'active' : ''; ?>">Products</a></li>
                    <li><a href="about.php" class="<?php echo ($activePage === 'about') ? 'active' : ''; ?>">About</a></li>
                    <li><a href="care.php" class="<?php echo ($activePage === 'care') ? 'active' : ''; ?>">Care</a></li>
                </ul>
            </nav>
            <div class="header_icons">
                <span onclick="toggleSearch()">🔍</span>
                <span onclick="toggleFavorites()">❤️</span>
                <span onclick="toggleTheme()">🌙</span>
            </div>
            <div id="searchBox" class="search_box">
                <input type="text" id="siteSearchInput" placeholder="Search products..." onkeyup="liveSearch()">
                <span onclick="toggleSearch()" class="close">×</span>
                <div id="searchResults" class="search_results"></div>
            </div>
        </header>
        <div id="favoritesBox" class="favorites">
            <div class="favorite_content">
                <span onclick="closeFavorites()" class="close">×</span>
                <h2>Your Favorites</h2>
                <p>No favorites yet</p>
            </div>
        </div>