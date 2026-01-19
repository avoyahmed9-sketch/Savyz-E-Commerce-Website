<?php
session_start();
include "connect.php";

if (!isset($_SESSION['customer_id'])) {
    header("Location: Clogin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard - SAVYZ</title>
    <link rel="stylesheet" href="Cdash.css">
</head>
<body>
    <div class="side-bar">
        <h1>Dashboard</h1>
        <p style="color:white; text-align:center; margin-bottom:20px;">Welcome, <?php echo $_SESSION['customer_name']; ?>!</p>
        <ul>
            <li><a href="Cdash.php">All Products</a></li>
            <li><a href="viewcart.php">View Cart</a></li>
            <li><a href="myorders.php">My Orders</a></li>
            <li><a href="">Offers</a></li>
            <li><a href="">Wishlist</a></li>
            <li><a href="">Payment Policy</a></li>
            <li><a href="clogout.php">Log out</a></li>
        </ul>
    </div>
    
    <div class="content">
        <img src="SAVYZ TEXT LOGO.png">
        <div class="srcbar">
            <form method="GET" action="">
                <input type="search" name="search" placeholder="Search products..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <button type="submit">Search</button>
            </form>
        </div>
    </div>
    
    <div class="main">
        <?php
        $sql = "SELECT * FROM product WHERE stock > 0";
        
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $conn->real_escape_string($_GET['search']); 
            $sql = "SELECT * FROM product WHERE name LIKE '%$search%' AND stock > 0";
        }
        
        $result = $conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) { 
                
                $image_path = "../" . $row['image'];
                ?>
                <div class="procard">
                    <div class="product-img">
                        <img src="<?php echo $image_path; ?>" alt="<?php echo $row['name']; ?>">
                    </div>
                    <h3><?php echo $row['name']; ?></h3>
                    <p><?php echo $row['price']; ?> BDT</p>
                    <p style="font-size:12px; color:#666;">Stock: <?php echo $row['stock']; ?></p>
                    <button>
                        <a href="viewcart.php?add=<?php echo $row['id']; ?>" style="text-decoration:none;color:black;">Add to Cart</a>
                    </button>
                </div>
        <?php }
        } else {
            echo "<p>No products found.</p>";
        }
        ?>
    </div>
</body>
</html>