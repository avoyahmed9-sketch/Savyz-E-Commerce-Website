<?php


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        .login{
            position: fixed;
            top: 35%;
            left: 35%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: darkgray;
            padding: 30px;
        }
        .login input{
            display: block;
        }







    </style>
</head>
<body>
    <div class="login">
    <form action="login.php" method="post">
        <input type="email" name="email" placeholder="Enter you email:" required>
        <input type="password" name="password" placeholder="Enter your password:" required>
        <input type="submit" name="submit" value="login">
        <p>Don't Register Yet!
            <a href="register.php">Sign up</a>
        </p>
    </form>
    </div>
    
</body>
</html>