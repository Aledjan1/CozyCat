<?php
    // Start session to access user data
    session_start();

    // Set page title and CSS file
    $pageTitle = "My Account";
    $activePage = "";
    $pageCss = "CSS/account.css";

    // Include database
    include "includes/db.php";

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit;
    }
    
    // Get the user ID from the session
    $userID = (int)($_SESSION['user_id'] ?? 0);

    // Check that the ID is valid
    if ($userID <= 0) {
        header("Location: index.php");
        exit;
    }

    // Get user information from the users table
    $sql = "SELECT * FROM users WHERE usersID = $userID";
    $result = $conn->query($sql);

    // Stop the script if the query fails
    if (!$result) {
        die("SQL Error: " . $conn->error);
    }

    // Convert the result into an associative array
    $user = $result->fetch_assoc();

    // Check if the user was found in the database
    if (!$user) {
        echo "User not found.";
        exit;
    }

    // Include the site header
    include "includes/header.php";
?>
<!-- Account page -->
<section class="account_page">
     <!-- User account card -->
    <div class="account_card">
         <!-- Display user details -->
        <h2>My Account</h2>
        <p><strong>Name :</strong><?php echo htmlspecialchars($user['name']); ?></p>
        <p><strong>Email :</strong><?php echo htmlspecialchars($user['email']); ?></p>

        <!-- Navigation links -->
        <div class="account_links">
            <a href="my_orders.php">📦 My Orders</a>
            <a href="products.php">🛍️ Continue Shopping</a>
            <a href="auth/logout.php">🚪 Logout</a>
        </div>
    </div>
</section>

// Include the site footer
<?php include "includes/footer.php"; ?>