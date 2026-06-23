<?php 
    // Start session to check admin access
    session_start();

    // Allow this page only for admin users
    // If the user is not admin, redirect to homepage
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        header("Location: ../index.php");
        exit;
    }

    // Connect to the database and include admin navigation
    include "../includes/db.php";
    include "admin_nav.php";

     // Get all orders from newest to oldest
    $sql = "SELECT * FROM orders ORDER BY orderID DESC";
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/admin.css">
    <title>Manage Orders</title>
</head>
<body>
    <!-- Admin page container -->
    <div class="admin_container">
        <!-- Page title and description -->
        <div class="admin_header">
            <h1>🛒 Manage Orders</h1>
            <p>View customer orders and update status.</p>
        </div>
        <!-- Orders table -->
        <table class="admin_table">
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Email</th>
                <th>Total</th>
                <th>Status</th>
                <th>Change status</th>
                <th>Date</th>
            </tr>
            
            <?php while ($order = $result->fetch_assoc()): ?>
                <tr>
                     <!-- Show one order from the database -->
                    <td>#<?php echo $order['orderID']; ?></td>
                    <td><?php echo htmlspecialchars($order['fullname']); ?></td>
                    <td><?php echo htmlspecialchars($order['email']); ?></td>
                    <td>£<?php echo htmlspecialchars($order['total']); ?></td>
                    <td>
                    // Create CSS class from order status
                    // Example: Pending becomes status-pending
                    <?php $statusClass = strtolower($order['status'] ?? 'pending'); ?>
                    <span class="status status-<?php echo $statusClass; ?>">
                        <?php echo htmlspecialchars($order['status'] ?? 'Pending'); ?>
                    </span>
                </td>

                <td>
                    <!-- Status update form -->
                    <form action="update_order_status.php" method="POST" class="status_form">
                        <!-- Send order ID with the form -->
                        <input type="hidden" name="orderID" value="<?php echo $order['orderID']; ?>">
                         <!-- Select new order status -->
                        <select name="status">
                            // Keep the current status selected in the dropdown
                            <option value="Pending" <?php if (($order['status'] ?? '') == 'Pending') echo 'selected'; ?>>
                                Pending
                            </option>

                            <option value="Processing" <?php if (($order['status'] ?? '') == 'Processing') echo 'selected'; ?>>
                                Processing
                            </option>

                            <option value="Shipped" <?php if (($order['status'] ?? '') == 'Shipped') echo 'selected'; ?>>
                                Shipped
                            </option>

                            <option value="Delivered" <?php if (($order['status'] ?? '') == 'Delivered') echo 'selected'; ?>>
                                Delivered
                            </option>
                        </select>
                         <!-- Submit new status -->
                        <button type="submit" class="update_btn">Update</button>
                    </form>
                </td>
                    <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <a href="dashboard.php" class="back_link">⬅ Back to Dashboard</a>
    <script src="../JS/admin.js"></script>
</body>
</html>