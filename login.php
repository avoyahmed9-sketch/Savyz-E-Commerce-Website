<?php


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="login.php" method="post">
        <input type="email" name="email" placeholder="Enter you email:" required>
        <input type="password" name="password" placeholder="Enter your password:" required>
        <input type="submit" name="submit" value="login">
        <p>Don't Register Yet!
            <a href="register.php">Sign up</a>
        </p>
    </form>
    
</body>
</html>