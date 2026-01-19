<?php
session_start();
include "connect.php";

if (!isset($_SESSION['seller_id'])) {
    header("Location: Slogin.php");
    exit();
}

$seller_id = $_SESSION['seller_id'];

if (isset($_POST['add_discount'])) {
    $product_id = $_POST['product_id'];
    $discount_percentage = $_POST['discount_percentage'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    
    $stmt = $conn->prepare("INSERT INTO discounts (product_id, seller_id, discount_percentage, start_date, end_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiss", $product_id, $seller_id, $discount_percentage, $start_date, $end_date);
    $stmt->execute();
    $stmt->close();
    header("Location: Sdiscounts.php");
    exit();
}

if (isset($_GET['delete'])) {
    $discount_id = $_GET['delete'];
    $conn->query("DELETE FROM discounts WHERE id=$discount_id AND seller_id=$seller_id");
    header("Location: Sdiscounts.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Discounts - SAVYZ</title>
    <link rel="stylesheet" href="viewcart.css">
</head>
<body>
    <div class="cart-container">
        <h2>Manage Discounts & Offers</h2>
        <a href="Sdash.php" style="display:inline-block; margin-bottom:20px; color:#66ff33; text-decoration:none; font-weight:bold;">← Back to Dashboard</a>
        
        <button onclick="document.getElementById('addModal').style.display='block'" style="padding:10px 20px; background:#27ae60; color:white; border:none; border-radius:10px; cursor:pointer; margin-bottom:20px;">Add Discount</button>
        
        <h3>Active Discounts</h3>
        <table>
            <tr>
                <th>Product</th>
                <th>Discount %</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
            $result = $conn->query("
                SELECT d.*, p.name as product_name 
                FROM discounts d 
                JOIN product p ON d.product_id = p.id 
                WHERE d.seller_id = $seller_id 
                ORDER BY d.id DESC
            ");
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['discount_percentage']; ?>%</td>
                        <td><?php echo date('d M Y', strtotime($row['start_date'])); ?></td>
                        <td><?php echo date('d M Y', strtotime($row['end_date'])); ?></td>
                        <td><?php echo $row['is_active'] ? 'Active' : 'Inactive'; ?></td>
                        <td>
                            <a href="Sdiscounts.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this discount?')" style="color:red; text-decoration:none;">Delete</a>
                        </td>
                    </tr>
            <?php }
            } else {
                echo "<tr><td colspan='6'>No discounts yet</td></tr>";
            }
            ?>
        </table>
    </div>
    
    <div id="addModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7); z-index:1000;">
        <div style="background:white; width:400px; margin:100px auto; padding:30px; border-radius:15px;">
            <h3>Add Discount</h3>
            <form method="POST" action="">
                <label>Select Product:</label><br>
                <select name="product_id" required style="width:100%; padding:10px; margin:10px 0; border:1px solid #ddd; border-radius:5px;">
                    <option value="">Choose Product</option>
                    <?php
                    $products = $conn->query("SELECT * FROM product WHERE seller_id = $seller_id");
                    while ($p = $products->fetch_assoc()) {
                        echo "<option value='" . $p['id'] . "'>" . $p['name'] . "</option>";
                    }
                    ?>
                </select>
                
                <label>Discount Percentage:</label><br>
                <input type="number" name="discount_percentage" min="1" max="100" required style="width:100%; padding:10px; margin:10px 0; border:1px solid #ddd; border-radius:5px;">
                
                <label>Start Date:</label><br>
                <input type="date" name="start_date" required style="width:100%; padding:10px; margin:10px 0; border:1px solid #ddd; border-radius:5px;">
                
                <label>End Date:</label><br>
                <input type="date" name="end_date" required style="width:100%; padding:10px; margin:10px 0; border:1px solid #ddd; border-radius:5px;">
                
                <button type="submit" name="add_discount" style="padding:10px 20px; background:#27ae60; color:white; border:none; border-radius:5px; cursor:pointer;">Add Discount</button>
                <button type="button" onclick="document.getElementById('addModal').style.display='none'" style="padding:10px 20px; background:#95a5a6; color:white; border:none; border-radius:5px; cursor:pointer; margin-left:10px;">Cancel</button>
            </form>
        </div>
    </div>
</body>
</html>