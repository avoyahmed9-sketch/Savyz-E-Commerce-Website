<?php
session_start();
include "connect.php";

if (!isset($_SESSION['seller_id'])) {
    header("Location: Slogin.php");
    exit();
}

$seller_id = $_SESSION['seller_id'];

if (isset($_GET['delete'])) {
    $product_id = $_GET['delete'];
    $conn->query("DELETE FROM product WHERE id=$product_id AND seller_id=$seller_id");
    header("Location: Sproducts.php");
    exit();
}

if (isset($_POST['update'])) {
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];
    
    $stmt = $conn->prepare("UPDATE product SET name=?, price=?, stock=?, description=? WHERE id=? AND seller_id=?");
    $stmt->bind_param("sdisii", $name, $price, $stock, $description, $product_id, $seller_id);
    $stmt->execute();
    $stmt->close();
    header("Location: Sproducts.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Products - SAVYZ</title>
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
    
    <div class="content">
        <img src="SAVYZ TEXT LOGO.png">
        <h2 style="margin-left:400px; margin-top:100px;">My Products</h2>
    </div>
    
    <div class="main">
        <?php
        $result = $conn->query("SELECT * FROM product WHERE seller_id = $seller_id");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) { 
                // Fix image path - go up one level then into uploads
                $image_path = "../" . $row['image'];
                ?>
                <div class="procard">
                    <div class="product-img">
                        <img src="<?php echo $image_path; ?>" alt="<?php echo $row['name']; ?>">
                    </div>
                    <h3><?php echo $row['name']; ?></h3>
                    <p><?php echo $row['price']; ?> BDT</p>
                    <p style="font-size:14px; color:#666;">Stock: <?php echo $row['stock']; ?></p>
                    <div class="product-actions">
                        <button class="btn-edit" onclick="editProduct(<?php echo $row['id']; ?>, '<?php echo addslashes($row['name']); ?>', <?php echo $row['price']; ?>, <?php echo $row['stock']; ?>, '<?php echo addslashes($row['description']); ?>')">Edit</button>
                        <a href="Sproducts.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this product?')" class="btn-delete">Delete</a>
                    </div>
                </div>
        <?php }
        } else {
            echo "<p>No products yet. <a href='Saddproduct.php' style='color:#66ff33;'>Add your first product</a></p>";
        }
        ?>
    </div>
    
    <div id="editModal" class="modal">
        <div class="modal-content">
            <h3>Edit Product</h3>
            <form method="POST" action="">
                <input type="hidden" name="product_id" id="edit_id">
                <label>Product Name:</label>
                <input type="text" name="name" id="edit_name" required>
                <label>Price (BDT):</label>
                <input type="number" name="price" id="edit_price" required>
                <label>Stock:</label>
                <input type="number" name="stock" id="edit_stock" required>
                <label>Description:</label>
                <textarea name="description" id="edit_description" rows="4"></textarea>
                <button type="submit" name="update" class="btn-primary">Update</button>
                <button type="button" onclick="document.getElementById('editModal').style.display='none'" class="btn-secondary">Cancel</button>
            </form>
        </div>
    </div>
    
    <script>
    function editProduct(id, name, price, stock, description) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_price').value = price;
        document.getElementById('edit_stock').value = stock;
        document.getElementById('edit_description').value = description;
        document.getElementById('editModal').style.display = 'block';
    }
    </script>
</body>
</html>