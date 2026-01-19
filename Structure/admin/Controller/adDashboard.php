<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: adminlogin.php");
    exit();
}
include "connect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="adDash.css">
</head>
<body>
    <div class="side-bar">
        <h1>Admin Panel</h1>
        <ul>
            <li><a href="adDashboard.php">Dashboard</a></li>
            <li><a href="manageusers.php">Manage Users</a></li>
            <li><a href="managesellers.php">Manage Sellers</a></li>
            <li><a href="logout.php">Log out</a></li>
        </ul>
    </div>
    <div class="content">
        <div class="header">
            <h2>Welcome, Admin</h2>
            <p>Manage your e-commerce platform</p>
        </div>
        
        <div class="dashboard-cards">
            <div class="card">
                <h3>Total Customers</h3>
                <?php
                $result = $conn->query("SELECT COUNT(*) as count FROM customers");
                if ($result) {
                    $row = $result->fetch_assoc();
                    echo "<p class='number'>" . $row['count'] . "</p>";
                } else {
                    echo "<p class='number'>0</p>";
                }
                ?>
            </div>
            
            <div class="card">
                <h3>Total Sellers</h3>
                <?php
                $result = $conn->query("SELECT COUNT(*) as count FROM sellers");
                if ($result) {
                    $row = $result->fetch_assoc();
                    echo "<p class='number'>" . $row['count'] . "</p>";
                } else {
                    echo "<p class='number'>0</p>";
                }
                ?>
            </div>
            
            <div class="card">
                <h3>Total Products</h3>
                <?php
                $result = $conn->query("SELECT COUNT(*) as count FROM product");
                if ($result) {
                    $row = $result->fetch_assoc();
                    echo "<p class='number'>" . $row['count'] . "</p>";
                } else {
                    echo "<p class='number'>0</p>";
                }
                ?>
            </div>
            
            <div class="card">
                <h3>Total Orders</h3>
                <?php
                $result = $conn->query("SELECT COUNT(*) as count FROM orders");
                if ($result) {
                    $row = $result->fetch_assoc();
                    echo "<p class='number'>" . $row['count'] . "</p>";
                } else {
                    echo "<p class='number'>0</p>";
                }
                ?>
            </div>
        </div>
        
        <div class="recent-section">
            <h3>Recent Orders</h3>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
                <?php
                $result = $conn->query("SELECT * FROM orders ORDER BY id DESC LIMIT 5");
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td>#<?php echo $row['id']; ?></td>
                            <td><?php echo $row['customer_name']; ?></td>
                            <td><?php echo $row['total_amount']; ?> BDT</td>
                            <td><?php echo ucfirst($row['status']); ?></td>
                            <td><?php echo date('d M Y', strtotime($row['order_date'])); ?></td>
                        </tr>
                <?php }
                } else {
                    echo "<tr><td colspan='5'>No orders found</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>