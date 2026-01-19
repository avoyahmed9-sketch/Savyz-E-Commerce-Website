<?php
include "connect.php";

if (isset($_POST['register'])) {
    $shop_name = trim($_POST['shop_name']);
    $owner_name = trim($_POST['owner_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $phone = trim($_POST['phone']);

    if (empty($shop_name) || empty($owner_name) || empty($email) || empty($password) || empty($phone)) {
        $error = "All fields are required!";
    } else {
        $check = $conn->prepare("SELECT * FROM sellers WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();
        
        if ($result->num_rows > 0) {
            $error = "Email already registered!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $conn->prepare("INSERT INTO sellers (shop_name, owner_name, email, password, phone, status) VALUES (?, ?, ?, ?, ?, 'pending')");
            $stmt->bind_param("sssss", $shop_name, $owner_name, $email, $hashedPassword, $phone);
            
            if ($stmt->execute()) {
                $success = "Registration successful! Wait for admin approval.";
            } else {
                $error = "Error: " . $conn->error;
            }
            $stmt->close();
        }
        $check->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Registration - SAVYZ</title>
    <link rel="stylesheet" href="Clogin.css">
</head>
<body>

<img src="SAVYZ TEXT LOGO.png">

<div class="container">
    <h1>Seller Register</h1>

    <?php
    if (isset($error)) {
        echo '<p style="color:red; font-weight:bold;">' . $error . '</p>';
    }
    if (isset($success)) {
        echo '<p style="color:greenyellow; font-weight:bold;">' . $success . '</p>';
    }
    ?>

    <form method="POST" action="">
        <label>Shop Name:</label><br>
        <input type="text" name="shop_name" required><br><br>

        <label>Owner Name:</label><br>
        <input type="text" name="owner_name" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Phone:</label><br>
        <input type="text" name="phone" required><br><br>

        <div class="auth">
            <button type="submit" name="register">Register</button>
            <button type="reset">Cancel</button>
        </div>
    </form>

    <p style="margin-top:20px;">
        Already have an account?
        <a href="Slogin.php" style="color:greenyellow; font-weight:bold;">Login Here</a>
    </p>
</div>

</body>
</html>