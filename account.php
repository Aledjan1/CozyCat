<?php
    session_start();

    $pageTitle = "My Account";
    $activePage = "";
    $pageCss = "CSS/account.css";

    include "includes/db.php";

    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit;
    }
    
    $userID = (int)($_SESSION['user_id'] ?? 0);

    if ($userID <= 0) {
        header("Location: index.php");
        exit;
    }

    $sql = "SELECT * FROM users WHERE usersID = $userID";
    $result = $conn->query($sql);

    if (!$result) {
        die("SQL Error: " . $conn->error);
    }

    $user = $result->fetch_assoc();

    if (!$user) {
        echo "User not found.";
        exit;
    }

    include "includes/header.php";
?>

<section class="account_page">
    <div class="account_card">
        <h2>My Account</h2>
        <p><strong>Name :</strong><?php echo htmlspecialchars($user['name']); ?></p>
        <p><strong>Email :</strong><?php echo htmlspecialchars($user['email']); ?></p>

        <div class="account_links">
            <a href="my_orders.php">📦 My Orders</a>
            <a href="products.php">🛍️ Continue Shopping</a>
            <a href="auth/logout.php">🚪 Logout</a>
        </div>
    </div>
</section>

<?php include "includes/footer.php"; ?>