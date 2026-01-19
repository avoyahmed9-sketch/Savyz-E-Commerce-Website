<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: adminlogin.php");
    exit();
}
include "connect.php";

if (isset($_GET['approve'])) {
    $id = $_GET['approve'];
    $conn->query("UPDATE sellers SET status='approved' WHERE id=$id");
    header("Location: managesellers.php");
}

if (isset($_GET['block'])) {
    $id = $_GET['block'];
    $conn->query("UPDATE sellers SET status='blocked' WHERE id=$id");
    header("Location: managesellers.php");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM sellers WHERE id=$id");
    header("Location: managesellers.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Sellers</title>
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
            <h2>Manage Sellers</h2>
            <p>Approve or block seller accounts</p>
        </div>
        
        <div class="recent-section">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Shop Name</th>
                    <th>Owner Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <?php
                $result = $conn->query("SELECT * FROM sellers");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['shop_name']; ?></td>
                            <td><?php echo $row['owner_name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td>
                                <?php 
                                $status = $row['status'];
                                $color = $status == 'approved' ? '#27ae60' : ($status == 'blocked' ? '#e74c3c' : '#f39c12');
                                echo "<span style='padding:5px 10px; background:$color; color:white; border-radius:3px;'>$status</span>";
                                ?>
                            </td>
                            <td>
                                <?php if ($row['status'] != 'approved') { ?>
                                    <a href="managesellers.php?approve=<?php echo $row['id']; ?>" style="padding:5px 10px; background:#27ae60; color:white; text-decoration:none; border-radius:3px; margin-right:5px;">Approve</a>
                                <?php } ?>
                                <?php if ($row['status'] != 'blocked') { ?>
                                    <a href="managesellers.php?block=<?php echo $row['id']; ?>" style="padding:5px 10px; background:#e74c3c; color:white; text-decoration:none; border-radius:3px; margin-right:5px;">Block</a>
                                <?php } ?>
                                <a href="managesellers.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')" style="padding:5px 10px; background:#95a5a6; color:white; text-decoration:none; border-radius:3px;">Delete</a>
                            </td>
                        </tr>
                <?php }
                } else {
                    echo "<tr><td colspan='7'>No sellers found</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>