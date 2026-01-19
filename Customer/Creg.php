<?php
include "connect.php";

if (isset($_POST['register'])) {
    $fname    = trim($_POST['fname']);
    $lname    = trim($_POST['lname']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $dob      = $_POST['dob'];

    if (empty($fname) || empty($lname) || empty($email) || empty($password) || empty($dob)) {
        $error = "All fields are required!";
    } else {
        $check = $conn->prepare("SELECT * FROM customers WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();
        
        if ($result->num_rows > 0) {
            $error = "Email already registered!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $conn->prepare("INSERT INTO customers (fname, lname, email, password, dob) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $fname, $lname, $email, $hashedPassword, $dob);
            
            if ($stmt->execute()) {
                $success = "Registration successful! You can now login.";
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
    <title>Register - SAVYZ</title>
    <link rel="stylesheet" href="Clogin.css">
</head>
<body>

<img src="SAVYZ TEXT LOGO.png">

<div class="container">
    <h1>Register</h1>

    <?php
    if (isset($error)) {
        echo '<p style="color:red; font-weight:bold;">' . $error . '</p>';
    }
    if (isset($success)) {
        echo '<p style="color:greenyellow; font-weight:bold;">' . $success . '</p>';
    }
    ?>

    <form method="POST" action="">
        <label>First Name:</label><br>
        <input type="text" name="fname" required><br><br>

        <label>Last Name:</label><br>
        <input type="text" name="lname" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Date of Birth:</label><br>
        <input type="date" name="dob" required><br><br>

        <div class="auth">
            <button type="submit" name="register">Register</button>
            <button type="reset">Cancel</button>
        </div>
    </form>

    <p style="margin-top:20px;">
        Already have an account?
        <a href="Clogin.php" style="color:greenyellow; font-weight:bold;">Login Here</a>
    </p>
</div>

</body>
</html>