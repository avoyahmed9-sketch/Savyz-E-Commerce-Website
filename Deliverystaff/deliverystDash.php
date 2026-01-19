<?php
session_start();
include "connect.php";

if (!isset($_SESSION['delivery_id'])) {
    header("Location: deliveryst.php");
    exit();
}

$delivery_id = $_SESSION['delivery_id'];

if (isset($_POST['accept'])) {
    $order_id = $_POST['order_id'];
    $conn->query("UPDATE orders SET delivery_staff_id=$delivery_id, delivery_status='assigned', status='processing' WHERE id=$order_id");
    header("Location: deliverystDash.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delivery Dashboard - SAVYZ</title>
    <link rel="stylesheet" href="deliverystDash.css">
    <style>
        .content-area {
            margin-left: 400px;
            padding: 40px;
        }
        .order-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-top: 40px;
        }
        .order-card {
            background: rgb(188, 249, 64);
            padding: 20px;
            border-radius: 15px;
            border: 2px solid black;
            width: 300px;
        }
        .order-card h3 {
            margin: 0 0 15px 0;
            color: #000;
        }
        .order-card p {
            margin: 8px 0;
            color: #333;
        }
        .order-card strong {
            color: #000;
        }
        .btn-accept {
            width: 100%;
            padding: 10px 20px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 15px;
        }
        .btn-accept:hover {
            background: #229954;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-box {
            background: rgb(188, 249, 64);
            padding: 20px;
            border-radius: 15px;
            border: 2px solid black;
            text-align: center;
        }
        .stat-box h3 {
            margin: 0 0 10px 0;
        }
        .stat-box .number {
            font-size: 36px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h1>Delivery Panel</h1>
        <p style="color:black; text-align:center; margin-bottom:20px; font-weight:bold;">Welcome, <?php echo $_SESSION['delivery_name']; ?>!</p>
        <ul style="padding:40px;">
            <li><a href="deliverystDash.php">Available Orders</a></li>
            <li><a href="Dmyd.php">My Deliveries</a></li>
            <li><a href="Dlogout.php">Logout</a></li>
        </ul>
    </div>
    
    <img src="SAVYZ TEXT LOGO.png">
    
    <div class="content-area">
        <h1 style="font-family: 'Gravitas One', serif; color: rgb(170, 255, 0);">Available Orders for Delivery</h1>
        
        <div class="stats">
            <div class="stat-box">
                <h3>Available Orders</h3>
                <?php
                $result = $conn->query("SELECT COUNT(*) as count FROM orders WHERE delivery_staff_id IS NULL AND status='pending'");
                $row = $result->fetch_assoc();
                echo "<p class='number'>" . $row['count'] . "</p>";
                ?>
            </div>
            <div class="stat-box">
                <h3>My Active Deliveries</h3>
                <?php
                $result = $conn->query("SELECT COUNT(*) as count FROM orders WHERE delivery_staff_id=$delivery_id AND delivery_status != 'delivered'");
                $row = $result->fetch_assoc();
                echo "<p class='number'>" . $row['count'] . "</p>";
                ?>
            </div>
            <div class="stat-box">
                <h3>Completed Deliveries</h3>
                <?php
                $result = $conn->query("SELECT COUNT(*) as count FROM orders WHERE delivery_staff_id=$delivery_id AND delivery_status='delivered'");
                $row = $result->fetch_assoc();
                echo "<p class='number'>" . $row['count'] . "</p>";
                ?>
            </div>
        </div>
        
        <h2 style="margin-top:30px; color:#333;">Orders Waiting for Pickup</h2>
        <div class="order-grid">
            <?php
            $result = $conn->query("SELECT * FROM orders WHERE delivery_staff_id IS NULL AND status='pending' ORDER BY id DESC");
            
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <div class="order-card">
                        <h3>Order #<?php echo $row['id']; ?></h3>
                        <p><strong>Customer:</strong> <?php echo $row['customer_name']; ?></p>
                        <p><strong>Address:</strong> <?php echo $row['delivery_address']; ?></p>
                        <p><strong>Amount:</strong> <?php echo $row['total_amount']; ?> BDT</p>
                        <p><strong>Payment:</strong> <?php echo ucfirst($row['payment_method']); ?></p>
                        <p><strong>Date:</strong> <?php echo date('d M Y', strtotime($row['order_date'])); ?></p>
                        
                        <form method="POST" action="">
                            <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="accept" class="btn-accept">Accept Delivery</button>
                        </form>
                    </div>
            <?php }
            } else {
                echo "<p>No available orders at the moment.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>