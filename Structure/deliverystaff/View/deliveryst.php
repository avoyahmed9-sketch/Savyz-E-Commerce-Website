<?php
session_start();
include "connect.php";

if (isset($_SESSION['delivery_id'])) {
    header("Location: deliverystDash.php");
    exit();
}

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = "All fields are required";
    } else {
        $stmt = $conn->prepare("SELECT * FROM delivery_staff WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            
            if (password_verify($password, $row['password'])) {
                if ($row['status'] == 'active') {
                    $_SESSION['delivery_id'] = $row['id'];
                    $_SESSION['delivery_name'] = $row['fname'] . ' ' . $row['lname'];
                    $_SESSION['delivery_email'] = $row['email'];
                    header("Location: deliverystDash.php");
                    exit();
                } else {
                    $error = "Your account is inactive. Contact admin.";
                }
            } else {
                $error = "Wrong password";
            }
        } else {
            $error = "Delivery staff not found";
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
    <title>Delivery Staff Login - SAVYZ</title>
    <link rel="stylesheet" href="deliveryst.css">
</head>
<body>

<img src="SAVYZ TEXT LOGO.png" alt="Logo">

<div class="header">
    <h1>Delivery Staff Panel</h1>
</div>

<div class="container">
    <h1>Log In</h1>

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
            <a href="deliverystreg.php" style="color:greenyellow; font-weight:bold;">Register Here</a>
        </p>
    </form>
</div>

</body>
</html>