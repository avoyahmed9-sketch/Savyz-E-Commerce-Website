<?php
session_start();
include "connect.php";

if (!isset($_SESSION['customer_id'])) {
    header("Location: Clogin.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

if (isset($_GET['add'])) {
    $product_id = intval($_GET['add']);
    
    $check = $conn->prepare("SELECT * FROM cart WHERE product_id=? AND customer_id=?");
    $check->bind_param("ii", $product_id, $customer_id);
    $check->execute();
    $result = $check->get_result();
    
    if ($result->num_rows > 0) {
        $update = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE product_id=? AND customer_id=?");
        $update->bind_param("ii", $product_id, $customer_id);
        $update->execute();
        $update->close();
    } else {
        $insert = $conn->prepare("INSERT INTO cart (customer_id, product_id, quantity) VALUES (?, ?, 1)");
        $insert->bind_param("ii", $customer_id, $product_id);
        $insert->execute();
        $insert->close();
    }
    $check->close();
    header("Location: viewcart.php");
    exit();
}

if (isset($_GET['remove'])) {
    $cart_id = intval($_GET['remove']);
    $conn->query("DELETE FROM cart WHERE id=$cart_id AND customer_id=$customer_id");
    header("Location: viewcart.php");
    exit();
}

if (isset($_POST['confirm'])) {
    $payment_method = $_POST['payment'];
    $delivery_address = $_POST['address'];
    
    $cart_items = $conn->query("
        SELECT c.*, p.name, p.price, p.id as product_id
        FROM cart c 
        JOIN product p ON c.product_id = p.id 
        WHERE c.customer_id = $customer_id
    ");
    
    if ($cart_items->num_rows > 0) {
        $total = 0;
        $items = [];
        
        while ($item = $cart_items->fetch_assoc()) {
            $subtotal = $item['price'] * $item['quantity'];
            $total += $subtotal;
            $items[] = $item;
        }
        
        $customer_name = $_SESSION['customer_name'];
        $stmt = $conn->prepare("INSERT INTO orders (customer_id, customer_name, total_amount, payment_method, delivery_address, status) VALUES (?, ?, ?, ?, ?, 'pending')");
        $stmt->bind_param("issss", $customer_id, $customer_name, $total, $payment_method, $delivery_address);
        
        if ($stmt->execute()) {
            $order_id = $conn->insert_id;
            
            
            foreach ($items as $item) {
                $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, quantity, price) VALUES (?, ?, ?, ?, ?)");
                $item_stmt->bind_param("iisid", $order_id, $item['product_id'], $item['name'], $item['quantity'], $item['price']);
                $item_stmt->execute();
                $item_stmt->close();
                
                

                $conn->query("UPDATE product SET stock = stock - " . $item['quantity'] . " WHERE id = " . $item['product_id']);
            }
            
            
            $conn->query("DELETE FROM cart WHERE customer_id = $customer_id");
            
            echo "<script>alert('Order Confirmed! Order ID: #$order_id'); window.location.href='myorders.php';</script>";
            exit();
        }
        $stmt->close();
    }
}

$cart_items = $conn->query("
    SELECT c.*, p.name, p.price, p.image 
    FROM cart c 
    JOIN product p ON c.product_id = p.id 
    WHERE c.customer_id = $customer_id
");

$total = 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Cart - SAVYZ</title>
    <link rel="stylesheet" href="viewcart.css">
</head>
<body>
    <div class="cart-container">
        <h2>Your Cart</h2>
        <a href="Cdash.php" style="display:inline-block; margin-bottom:20px; color:#66ff33; text-decoration:none; font-weight:bold;">← Back to Shop</a>
        
        <?php if($cart_items->num_rows > 0){ ?>
        <form method="POST">
        <table>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Price (BDT)</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            <?php while($item = $cart_items->fetch_assoc()){ 
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
                
                $image_path = "../" . $item['image'];
            ?>
            <tr>
                <td><img src="<?php echo $image_path; ?>" alt="<?php echo $item['name']; ?>"></td>
                <td><?php echo $item['name']; ?></td>
                <td><?php echo $item['price']; ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td><?php echo $subtotal; ?></td>
                <td><a href="viewcart.php?remove=<?php echo $item['id']; ?>" style="color:red; text-decoration:none;">Remove</a></td>
            </tr>
            <?php } ?>
            <tr class="total-row">
                <td colspan="4">Grand Total</td>
                <td colspan="2"><?php echo $total; ?> BDT</td>
            </tr>
        </table>

        <div class="payment-method">
            <label for="payment">Payment Method: </label>
            <select id="payment" name="payment" required>
                <option value="cash">Cash on Delivery</option>
                <option value="bkash">bKash</option>
                <option value="card">Card</option>
            </select>
        </div>
        
        <div class="payment-method">
            <label for="address">Delivery Address: </label><br>
            <textarea name="address" id="address" rows="3" style="width:400px; padding:10px; border-radius:10px;" required></textarea>
        </div>

        <button type="submit" name="confirm" class="confirm-btn">Confirm Order</button>
        </form>

        <?php } else { ?>
            <p style="text-align:center; font-size:18px;">Your cart is empty.</p>
            <a href="Cdash.php" style="display:block; text-align:center; color:#66ff33; font-weight:bold;">Continue Shopping</a>
        <?php } ?>
    </div>
</body>
</html>