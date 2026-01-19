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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard - SAVYZ</title>
    <link rel="stylesheet" href="Cdash.css">
    <link rel="stylesheet" href="Sadditional.css">
</head>
<body>
    <div class="side-bar">
        <h1>Seller Panel</h1>
        <p style="color:white; text-align:center; margin-bottom:20px;">Shop: <?php echo $_SESSION['shop_name']; ?></p>
        <ul>
            <li><a href="Sdash.php">Dashboard</a></li>
            <li><a href="Sproducts.php">My Products</a></li>
            <li><a href="Saddproduct.php">Add Product</a></li>
            <li><a href="Sorders.php">Customer Orders</a></li>
            <li><a href="Slogout.php">Log out</a></li>
        </ul>
    </div>
    
    <div class="content">
        <img src="SAVYZ TEXT LOGO.png">
        <h2 style="margin-left:400px; margin-top:100px; color:#333;">Welcome, <?php echo $_SESSION['seller_name']; ?>!</h2>
    </div>
    
    <div class="content-container">
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Products</h3>
                <?php
                $result = $conn->query("SELECT COUNT(*) as count FROM product WHERE seller_id = $seller_id");
                if ($result) {
                    $row = $result->fetch_assoc();
                    echo "<p class='number'>" . $row['count'] . "</p>";
                } else {
                    echo "<p class='number'>0</p>";
                }
                ?>
            </div>
            
            <div class="stat-card">
                <h3>Total Orders</h3>
                <?php
                $result = $conn->query("
                    SELECT COUNT(DISTINCT oi.order_id) as count 
                    FROM order_items oi 
                    JOIN product p ON oi.product_id = p.id 
                    WHERE p.seller_id = $seller_id
                ");
                if ($result) {
                    $row = $result->fetch_assoc();
                    echo "<p class='number'>" . $row['count'] . "</p>";
                } else {
                    echo "<p class='number'>0</p>";
                }
                ?>
            </div>
            
            <div class="stat-card">
                <h3>Total Revenue</h3>
                <?php
                $result = $conn->query("
                    SELECT SUM(oi.price * oi.quantity) as total 
                    FROM order_items oi 
                    JOIN product p ON oi.product_id = p.id 
                    JOIN orders o ON oi.order_id = o.id 
                    WHERE p.seller_id = $seller_id AND o.status = 'delivered'
                ");
                if ($result) {
                    $row = $result->fetch_assoc();
                    echo "<p class='number'>" . ($row['total'] ? $row['total'] : 0) . " BDT</p>";
                } else {
                    echo "<p class='number'>0 BDT</p>";
                }
                ?>
            </div>
        </div>
        
        <div style="background:white; padding:30px; border-radius:15px; border:2px solid black;">
            <h3>Recent Orders</h3>
            <table class="seller-table">
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
                <?php
                $result = $conn->query("
                    SELECT o.id, o.customer_name, oi.product_name, oi.quantity, oi.price, o.status, o.order_date
                    FROM orders o 
                    JOIN order_items oi ON o.id = oi.order_id 
                    JOIN product p ON oi.product_id = p.id 
                    WHERE p.seller_id = $seller_id 
                    ORDER BY o.id DESC 
                    LIMIT 5
                ");
                
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td>#<?php echo $row['id']; ?></td>
                            <td><?php echo $row['customer_name']; ?></td>
                            <td><?php echo $row['product_name']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo $row['price'] * $row['quantity']; ?> BDT</td>
                            <td><?php echo ucfirst($row['status']); ?></td>
                            <td><?php echo date('d M Y', strtotime($row['order_date'])); ?></td>
                        </tr>
                <?php }
                } else {
                    echo "<tr><td colspan='7' style='text-align:center; padding:20px;'>No orders yet</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>