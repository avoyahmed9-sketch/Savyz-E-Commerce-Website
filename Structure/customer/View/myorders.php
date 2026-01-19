<?php
session_start();
include "connect.php";

if (!isset($_SESSION['customer_id'])) {
    header("Location: Clogin.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

$orders = $conn->query("
    SELECT * FROM orders 
    WHERE customer_id = $customer_id 
    ORDER BY order_date DESC
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Orders - SAVYZ</title>
    <link rel="stylesheet" href="viewcart.css">
    <style>
        .order-card {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 15px;
            border: 2px solid #66ff33;
        }
        .order-header {
            display: flex;
            justify-content: space-between;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .status-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            color: white;
        }
        .status-pending { background-color: #f39c12; }
        .status-processing { background-color: #3498db; }
        .status-shipped { background-color: #9b59b6; }
        .status-delivered { background-color: #27ae60; }
        .status-cancelled { background-color: #e74c3c; }
    </style>
</head>
<body>
    <div class="cart-container">
        <h2>My Orders</h2>
        <a href="Cdash.php" style="display:inline-block; margin-bottom:20px; color:#66ff33; text-decoration:none; font-weight:bold;">← Back to Shop</a>
        
        <?php if ($orders->num_rows > 0) { 
            while ($order = $orders->fetch_assoc()) { 
                $order_items = $conn->query("SELECT * FROM order_items WHERE order_id = " . $order['id']);
        ?>
            <div class="order-card">
                <div class="order-header">
                    <div>
                        <h3>Order #<?php echo $order['id']; ?></h3>
                        <p>Date: <?php echo date('d M Y', strtotime($order['order_date'])); ?></p>
                    </div>
                    <div>
                        <span class="status-badge status-<?php echo $order['status']; ?>">
                            <?php echo strtoupper($order['status']); ?>
                        </span>
                    </div>
                </div>
                
                <p><strong>Payment Method:</strong> <?php echo ucfirst($order['payment_method']); ?></p>
                <p><strong>Delivery Address:</strong> <?php echo $order['delivery_address']; ?></p>
                
                <h4 style="margin-top:15px;">Order Items:</h4>
                <table style="width:100%; border-collapse:collapse;">
                    <tr>
                        <th style="text-align:left; padding:8px; border-bottom:1px solid #ddd;">Product</th>
                        <th style="text-align:center; padding:8px; border-bottom:1px solid #ddd;">Quantity</th>
                        <th style="text-align:right; padding:8px; border-bottom:1px solid #ddd;">Price</th>
                    </tr>
                    <?php while ($item = $order_items->fetch_assoc()) { ?>
                    <tr>
                        <td style="padding:8px;"><?php echo $item['product_name']; ?></td>
                        <td style="text-align:center; padding:8px;"><?php echo $item['quantity']; ?></td>
                        <td style="text-align:right; padding:8px;"><?php echo $item['price'] * $item['quantity']; ?> BDT</td>
                    </tr>
                    <?php } ?>
                </table>
                
                <p style="text-align:right; font-size:18px; font-weight:bold; margin-top:15px;">
                    Total: <?php echo $order['total_amount']; ?> BDT
                </p>
            </div>
        <?php } 
        } else { ?>
            <p style="text-align:center; font-size:18px;">You haven't placed any orders yet.</p>
            <a href="Cdash.php" style="display:block; text-align:center; color:#66ff33; font-weight:bold; margin-top:20px;">Start Shopping</a>
        <?php } ?>
    </div>
</body>
</html>