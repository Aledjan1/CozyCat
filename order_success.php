<?php
    // Start session for user data and cart features
    session_start();

    // Set page title and CSS file
    $pageTitle = "Order Success";
    $activePage = "";
    $pageCss = "CSS/checkout.css";

    // Include the site header
    include "includes/header.php";

    // Get the order ID from the URL
    $orderID = (int)($_GET['orderID'] ?? 0);

    // Stop the page if the order ID is missing or invalid
    if ($orderID <= 0) {
        echo "<p>Invalid order.</p>";
        include "includes/footer.php";
        exit;
    }
?>
<!-- Order success page -->
<section class="checkout_page">
    <!-- Success message box -->
    <div class="checkout_form">
         <!-- Show order confirmation -->
        <h2>Thank you for your order!</h2>
        <p>Your order number is: <strong>#<?php echo htmlspecialchars($orderID); ?></strong></p>
        <!-- Link back to products -->
        <a href="products.php" class="checkout_btn">Continue Shopping</a>
    </div>
</section>

<?php include "includes/footer.php"; ?>// Include the site footer