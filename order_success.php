<?php
    session_start();

    $pageTitle = "Order Success";
    $activePage = "";
    $pageCss = "CSS/checkout.css";

    include "includes/header.php";

    $orderID = (int)($_GET['orderID'] ?? 0);

    if ($orderID <= 0) {
        echo "<p>Invalid order.</p>";
        include "includes/footer.php";
        exit;
    }
?>

<section class="checkout_page">
    <div class="checkout_form">
        <h2>Thank you for your order!</h2>
        <p>Your order number is: <strong>#<?php echo htmlspecialchars($orderID); ?></strong></p>
        <a href="products.php" class="checkout_btn">Continue Shopping</a>
    </div>
</section>

<?php include "includes/footer.php"; ?>