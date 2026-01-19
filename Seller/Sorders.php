<?php
session_start();
include "connect.php";

if (!isset($_SESSION['seller_id'])) {
    header("Location: Slogin.php");
    exit();
}

$seller_id = $_SESSION['seller_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Orders - SAVYZ</title>
    <link rel="stylesheet" href="viewcart.css">
</head>
<body>
    <div class="cart-container">
        <h2>Customer Orders for My Products</h2>
        <a href="Sdash.php" style="display:inline-block; margin-bottom:20px; color:#66ff33; text-decoration:none; font-weight:bold;">← Back to Dashboard</a>
        
        <table>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Amount</th>
                <th>Payment</th>
                <th>Delivery Address</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
            <?php
            $result = $conn->query("
                SELECT o.id, o.customer_name, oi.product_name, oi.quantity, oi.price, 
                       o.payment_method, o.delivery_address, o.status, o.order_date
                FROM orders o
                JOIN order_items oi ON o.id = oi.order_id
                JOIN product p ON oi.product_id = p.id
                WHERE p.seller_id = $seller_id
                ORDER BY o.id DESC
            ");
            
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td>#<?php echo $row['id']; ?></td>
                        <td><?php echo $row['customer_name']; ?></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td><?php echo $row['price'] * $row['quantity']; ?> BDT</td>
                        <td><?php echo ucfirst($row['payment_method']); ?></td>
                        <td><?php echo $row['delivery_address'] ? $row['delivery_address'] : 'N/A'; ?></td>
                        <td><?php echo ucfirst($row['status']); ?></td>
                        <td><?php echo date('d M Y', strtotime($row['order_date'])); ?></td>
                    </tr>
            <?php }
            } else {
                echo "<tr><td colspan='9' style='text-align:center; padding:20px;'>No orders yet for your products</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>