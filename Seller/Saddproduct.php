<?php
session_start();
include "connect.php";

if (!isset($_SESSION['seller_id'])) {
    header("Location: Slogin.php");
    exit();
}

$seller_id = $_SESSION['seller_id'];

if (isset($_POST['add_product'])) {
    $name = trim($_POST['name']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = trim($_POST['description']);
    $category_id = $_POST['category_id'];
    
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO product (name, price, stock, description, category_id, seller_id, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdiiiis", $name, $price, $stock, $description, $category_id, $seller_id, $target_file);
        
        if ($stmt->execute()) {
            $success = "Product added successfully!";
        } else {
            $error = "Error: " . $conn->error;
        }
        $stmt->close();
    } else {
        $error = "Error uploading image!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product - SAVYZ</title>
    <link rel="stylesheet" href="Cdash.css">
    <link rel="stylesheet" href="Sadditional.css">
</head>
<body>
    <div class="side-bar">
        <h1>Seller Panel</h1>
        <ul>
            <li><a href="Sdash.php">Dashboard</a></li>
            <li><a href="Sproducts.php">My Products</a></li>
            <li><a href="Saddproduct.php">Add Product</a></li>
            <li><a href="Sorders.php">Customer Orders</a></li>
            <li><a href="Sdiscounts.php">Manage Discounts</a></li>
            <li><a href="Slogout.php">Log out</a></li>
        </ul>
    </div>
    
    <div class="form-container">
        <h2>Add New Product</h2>
        
        <?php
        if (isset($success)) {
            echo '<p class="message message-success">' . $success . '</p>';
        }
        if (isset($error)) {
            echo '<p class="message message-error">' . $error . '</p>';
        }
        ?>
        
        <form method="POST" action="" enctype="multipart/form-data">
            <label>Product Name:</label>
            <input type="text" name="name" required>
            
            <label>Price (BDT):</label>
            <input type="number" name="price" step="0.01" required>
            
            <label>Stock Quantity:</label>
            <input type="number" name="stock" required>
            
            <label>Category:</label>
            <select name="category_id" required>
                <option value="">Select Category</option>
                <?php
                $categories = $conn->query("SELECT * FROM categories");
                while ($cat = $categories->fetch_assoc()) {
                    echo "<option value='" . $cat['id'] . "'>" . $cat['name'] . "</option>";
                }
                ?>
            </select>
            
            <label>Description:</label>
            <textarea name="description" rows="4" required></textarea>
            
            <label>Product Image:</label>
            <input type="file" name="image" accept="image/*" required>
            
            <button type="submit" name="add_product">Add Product</button>
            <a href="Sproducts.php" style="display:inline-block; padding:15px 30px; background:#95a5a6; color:white; text-decoration:none; border-radius:10px; margin-left:10px;">Cancel</a>
        </form>
    </div>
</body>
</html>