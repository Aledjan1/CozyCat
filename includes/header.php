<?php
    // Get cart count, login status and user name from the session
    // These values are used in the header and top bar
    $cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
    $isLoggedIn = isset($_SESSION['user_id']);
    $userName = $_SESSION['user_name'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Main CSS and website icon -->
    <link rel="stylesheet" type="text/css" href="CSS/common.css"> 
    <link rel="icon" type="image/png" href="images/animal_shelter.png">
    <title><?php echo $pageTitle ?? "CozyCat"; ?></title>
    <!-- If $pageCss is not empty, connect an extra CSS file for this page. -->
    <?php if (!empty($pageCss)): ?>
        <!-- Load extra CSS file for the current page -->
        <link rel="stylesheet" type="text/css" href="<?php echo $pageCss; ?>">
    <?php endif; ?>
</head>
<body>
    <!-- Main page container -->
    <div class="container">
        <!-- Top bar with delivery message, account buttons and cart -->
        <div class="top_bar">
            <!-- Left side delivery message -->
            <div class="top_left">
                <p>🚚Free delivery on orders over £50</p>
            </div>
             <!-- Right side account and cart controls -->
            <div class="top_right">
                <!-- Show account, admin and logout buttons for logged-in users -->
                <?php if ($isLoggedIn): ?>
                    <!-- Link to user account page -->
                    <a href="account.php" class="login_btn">
                        👤 <?php echo htmlspecialchars($userName); ?>
                    </a>
                    <!-- Show admin button only for admin users -->
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <a href="admin/dashboard.php" class="admin_btn">⚙️ Admin</a>
                    <?php endif; ?>
                    <!-- Logout link -->
                    <a href="auth/logout.php" class="register_btn">Logout</a>
                <?php else: ?>
                      <!-- Show login and register buttons for guests -->
                    <button onclick="openLogin()" class="login_btn">👤Login</button>
                    <button onclick="openRegister()" class="register_btn">📋Register</button>
                <?php endif; ?>
                <?php
                // Count total items in the cart
                // array_sum counts product quantities, not only different products
                    $cartCount = array_sum($_SESSION['cart'] ?? []);
                ?>
                 <!-- Cart button with total number of items -->
                <button onclick="openCart()" class="cart_btn">🛒 Cart (<span class="cart_count"><?php echo $cartCount; ?></span>)</button>
            </div>   
        </div>
         <!-- Dark overlay behind the mobile menu -->
        <div class="mobile_overlay"></div>
        <!-- Mobile menu for small screens -->
        <div class="mobile_menu">
             <!-- Button to close mobile menu -->
            <span class="mobile_close">×</span>
            <!-- Main mobile navigation links -->
            <h3>MENU</h3>
                <a href="index.php">🏠 Home</a>
                <a href="products.php">🛍 Products</a>
                <a href="about.php">ⓘ About</a>
                <a href="care.php">🐾 Care</a>
            <hr>
             <!-- Mobile account section -->
            <h3>ACCOUNT</h3>
                <!-- Show account links for logged-in users -->
                <?php if ($isLoggedIn): ?>
                     <!-- Show account links in the mobile menu -->
                    <a href="account.php">👤 My Account</a>
                    <a href="my_orders.php">📦 My Orders</a>
                    <a href="#" onclick="openFavorites()">♡ Favorites</a>
                <?php else: ?>
                    <!-- Show login and register links for guests -->
                    <a href="#" onclick="closeMobileMenu(); onclick=openLogin()">👤 Login</a>
                    <a href="#" onclick="closeMobileMenu(); onclick=openRegister()">📋 Register</a>
                <?php endif; ?>
            <hr>
            <!-- Extra mobile menu links -->
            <h3>MORE</h3>
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <a href="admin/dashboard.php">⚙️ Admin Panel</a>
            <?php endif; ?>
             <!-- Cart link in mobile menu -->
            <a href="#" onclick="openCart()">🛒 Cart</a>
            <!-- Logout link for logged-in users -->
            <?php if ($isLoggedIn): ?>
                <a href="auth/logout.php">↪ Logout</a>
            <?php endif; ?>
        </div>
        <!-- Main header -->
        <header class="header">
            <!-- Mobile menu open button -->
            <div class="menu_toggle">☰</div>
            <!-- Logo and brand name -->
            <div class="header_logo">
                <a href="index.php"><img src="images/animal-shelter.png" alt="CozyCat logo"></a>
                <div class="logo_text">
                    <h1>Cozy<span style="color:#DB5C69">Cat</span></h1>
                    <p><img src="images/paw.png" alt="cats paws" class="paws">HOMES<img src="images/paw.png" alt="cats paws" class="paws"></p>
                </div>
            </div>
             <!-- Desktop navigation menu -->
            <nav class="header_nav">
                <ul>
                    <!-- Home link with active class -->
                    <li><a href="index.php" class="<?php echo ($activePage === 'home') ? 'active' : ''; ?>">Home</a></li>
                    <!-- Products link with active class -->
                    <li><a href="products.php" class="<?php echo ($activePage === 'products') ? 'active' : ''; ?>">Products</a></li>
                    <!-- About link with active class -->
                    <li><a href="about.php" class="<?php echo ($activePage === 'about') ? 'active' : ''; ?>">About</a></li>
                    <!-- Care link with active class -->
                    <li><a href="care.php" class="<?php echo ($activePage === 'care') ? 'active' : ''; ?>">Care</a></li>
                </ul>
            </nav>
            <!-- Header icons for search, favorites and dark mode -->
            <div class="header_icons">
                <span onclick="toggleSearch()">🔍</span>
                <span onclick="toggleFavorites()">❤️</span>
                <span onclick="toggleTheme()">🌙</span>
            </div>
             <!-- Search box with live search results -->
            <div id="searchBox" class="search_box">
                <input type="text" id="siteSearchInput" placeholder="Search products..." onkeyup="liveSearch()">
                <!-- Close search box button -->
                <span onclick="toggleSearch()" class="close">×</span>
                <!-- Live search results will appear here -->
                <div id="searchResults" class="search_results"></div>
            </div>
        </header>
         <!-- Favorites popup box -->
        <div id="favoritesBox" class="favorites">
             <!-- Favorites popup content -->
            <div class="favorite_content">
                <!-- Close favorites popup button -->
                <span onclick="closeFavorites()" class="close">×</span>
                 <!-- Favorites title and empty message -->
                <h2>Your Favorites</h2>
                <p>No favorites yet</p>
            </div>
        </div>