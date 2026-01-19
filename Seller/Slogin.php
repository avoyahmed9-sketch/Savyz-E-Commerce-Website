<?php
session_start();
include "connect.php";

if (isset($_SESSION['seller_id'])) {
    header("Location: Sdash.php");
    exit();
}

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = "All fields are required";
    } else {
        $stmt = $conn->prepare("SELECT * FROM sellers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            
            if (password_verify($password, $row['password'])) {
                if ($row['status'] == 'approved') {
                    $_SESSION['seller_id'] = $row['id'];
                    $_SESSION['seller_name'] = $row['owner_name'];
                    $_SESSION['shop_name'] = $row['shop_name'];
                    header("Location: Sdash.php");
                    exit();
                } elseif ($row['status'] == 'blocked') {
                    $error = "Your account has been blocked. Contact admin.";
                } else {
                    $error = "Your account is pending approval.";
                }
            } else {
                $error = "Wrong password";
            }
        } else {
            $error = "Seller not found";
        }
        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Login - SAVYZ</title>
    <link rel="stylesheet" href="Clogin.css">
</head>
<body>

<img src="SAVYZ TEXT LOGO.png" alt="Logo">

<div class="container">
    <h1>Seller Login</h1>

    <?php if (!empty($error)) { ?>
        <p style="color:red; font-weight:bold;"><?php echo $error; ?></p>
    <?php } ?>

    <form method="POST" action="">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <div class="auth">
            <button type="submit" name="login">Log In</button>
            <button type="reset">Cancel</button>
        </div>
        
        <p style="margin-top:20px;">
            Don't have an account? 
            <a href="Sreg.php" style="color:greenyellow; font-weight:bold;">Register Here</a>
        </p>
    </form>
</div>

</body>
</html>