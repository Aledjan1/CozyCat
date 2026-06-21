<?php 
    session_start();

    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        header("Location: ../index.php");
        exit;
    }

    include "../includes/db.php";
    include "admin_nav.php";

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
    <div class="admin_container">
        <div class="admin_header">
            <h1>🛒 Manage Orders</h1>
            <p>View customer orders and update status.</p>
        </div>
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
                    <td>#<?php echo $order['orderID']; ?></td>
                    <td><?php echo htmlspecialchars($order['fullname']); ?></td>
                    <td><?php echo htmlspecialchars($order['email']); ?></td>
                    <td>£<?php echo htmlspecialchars($order['total']); ?></td>
                    <td>
                    <?php $statusClass = strtolower($order['status'] ?? 'pending'); ?>
                    <span class="status status-<?php echo $statusClass; ?>">
                        <?php echo htmlspecialchars($order['status'] ?? 'Pending'); ?>
                    </span>
                </td>

                <td>
                    <form action="update_order_status.php" method="POST" class="status_form">
                        <input type="hidden" name="orderID" value="<?php echo $order['orderID']; ?>">

                        <select name="status">
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