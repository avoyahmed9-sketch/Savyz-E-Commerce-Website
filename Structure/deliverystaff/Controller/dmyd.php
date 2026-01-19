<?php
session_start();
include "connect.php";

if (!isset($_SESSION['delivery_id'])) {
    header("Location: deliveryst.php");
    exit();
}

$delivery_id = $_SESSION['delivery_id'];

if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];
    
    if ($new_status == 'delivered') {
        $conn->query("UPDATE orders SET delivery_status='delivered', status='delivered' WHERE id=$order_id AND delivery_staff_id=$delivery_id");
    } else {
        $conn->query("UPDATE orders SET delivery_status='$new_status' WHERE id=$order_id AND delivery_staff_id=$delivery_id");
    }
    header("Location: Dmyd.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Deliveries - SAVYZ</title>
    <link rel="stylesheet" href="Dmyd.css">
    <style>
        .back-btn {
            text-align: center;
            margin-top: 40px;
        }
        .back-btn a {
            padding: 15px 30px;
            background: #66ff33;
            color: black;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
            border: 2px solid black;
        }
        .back-btn a:hover {
            background: #4dbd29;
        }
        .status-form {
            display: inline-block;
        }
        .status-select {
            padding: 8px;
            border-radius: 5px;
            border: 2px solid black;
            margin-right: 5px;
        }
        .btn-update {
            padding: 8px 15px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-update:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <img src="SAVYZ TEXT LOGO.png">
    
    <h1>My Deliveries</h1>
    
    <table class="orders-table" id="myDeliveries">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Address</th>
                <th>Amount</th>
                <th>Payment</th>
                <th>Order Status</th>
                <th>Delivery Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM orders WHERE delivery_staff_id = $delivery_id ORDER BY id DESC");
            
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td>#<?php echo $row['id']; ?></td>
                        <td><?php echo $row['customer_name']; ?></td>
                        <td><?php echo $row['delivery_address']; ?></td>
                        <td><?php echo $row['total_amount']; ?> BDT</td>
                        <td><?php echo ucfirst($row['payment_method']); ?></td>
                        <td><?php echo ucfirst($row['status']); ?></td>
                        <td><strong><?php echo ucfirst($row['delivery_status']); ?></strong></td>
                        <td><?php echo date('d M Y', strtotime($row['order_date'])); ?></td>
                        <td>
                            <?php if ($row['delivery_status'] != 'delivered') { ?>
                                <form method="POST" action="" class="status-form">
                                    <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                                    <select name="new_status" class="status-select">
                                        <option value="assigned" <?php echo $row['delivery_status']=='assigned' ? 'selected' : ''; ?>>Assigned</option>
                                        <option value="picked_up" <?php echo $row['delivery_status']=='picked_up' ? 'selected' : ''; ?>>Picked Up</option>
                                        <option value="in_transit" <?php echo $row['delivery_status']=='in_transit' ? 'selected' : ''; ?>>In Transit</option>
                                        <option value="delivered" <?php echo $row['delivery_status']=='delivered' ? 'selected' : ''; ?>>Delivered</option>
                                    </select>
                                    <button type="submit" name="update_status" class="btn-update">Update</button>
                                </form>
                            <?php } else { ?>
                                <span style="color:#27ae60; font-weight:bold;">✓ Delivered</span>
                            <?php } ?>
                        </td>
                    </tr>
            <?php }
            } else {
                echo "<tr><td colspan='9' style='text-align:center; padding:20px;'>No deliveries assigned yet</td></tr>";
            }
            ?>
        </tbody>
    </table>
    
    <div class="back-btn">
        <a href="deliverystDash.php">← Back to Dashboard</a>
    </div>
</body>
</html>