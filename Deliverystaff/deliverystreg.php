<?php
include "connect.php";

if (isset($_POST['register'])) {
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $phone = trim($_POST['phone']);
    $dob = $_POST['dob'];
    $vehicle_type = $_POST['vehicle_type'];

    if (empty($fname) || empty($lname) || empty($email) || empty($password) || empty($dob)) {
        $error = "All required fields must be filled!";
    } else {
        $check = $conn->prepare("SELECT * FROM delivery_staff WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();
        
        if ($result->num_rows > 0) {
            $error = "Email already registered!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $conn->prepare("INSERT INTO delivery_staff (fname, lname, email, password, phone, dob, vehicle_type, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'active')");
            $stmt->bind_param("sssssss", $fname, $lname, $email, $hashedPassword, $phone, $dob, $vehicle_type);
            
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
    <title>Delivery Staff Register - SAVYZ</title>
    <link rel="stylesheet" href="Clogin.css">
</head>
<body>

<img src="SAVYZ TEXT LOGO.png">

<div class="container">
    <h1>Register as Delivery Staff</h1>

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

        <label>Phone:</label><br>
        <input type="text" name="phone"><br><br>
        
        <label>Vehicle Type:</label><br>
        <select name="vehicle_type" style="width:200px; padding:10px; border-radius:20px;">
            <option value="Motorcycle">Motorcycle</option>
            <option value="Bicycle">Bicycle</option>
            <option value="Van">Van</option>
            <option value="Car">Car</option>
        </select><br><br>

        <label>Date of Birth:</label><br>
        <input type="date" name="dob" required><br><br>

        <div class="auth">
            <button type="submit" name="register">Register</button>
            <button type="reset">Cancel</button>
        </div>
    </form>

    <p style="margin-top:20px;">
        Already have an account?
        <a href="deliveryst.php" style="color:greenyellow; font-weight:bold;">Login Here</a>
    </p>

</div>

</body>
</html>