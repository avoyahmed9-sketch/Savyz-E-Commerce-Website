<?php


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            background-color: #E7DECD;
        }

        .login{
            position: fixed;
            top: 35%;
            left: 42%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #804E49;
            border-radius: 15px 50px;
            padding: 30px;
        }
        .login input{
            display: block;
            border-radius: 15px 50px;
            border-bottom: 2px solid darkblue;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 5px;
        }
        .login a{
            color: white;
            padding:10px;
        }
        .btn{
            background-color: black;
            color: white;
            width: 100%;
            cursor: pointer;
        }







    </style>
</head>
<body>
    <div class="login">
    <form action="login.php" method="post">
        <input type="email" name="email" placeholder="Enter you email:" required>
        <input type="password" name="password" placeholder="Enter your password:" required>
        <input class="btn" type="submit" name="submit" value="login">
        <p>Don't Register Yet!
            <a href="register.php">Sign up</a>
        </p>
    </form>
    </div>
    
</body>
</html>