<?php
  include "db.php";

   if(isset($_POST['submit'])){
    $name =$_POST['name'];
    $email =$_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $role = "user";
 
    $sql = "insert into users(name,email,password,phone,address,role) values('$name','$email','$password','$phone','$address','$role')";
    $result= mysqli_query($conn,$sql);
    if(!$result){
        echo "Error!:{$conn->error}";
    }
    else{
        echo "Registered Successfully";
    }   
  }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            background-color: #E7DECD;
        }
        .registerdiv{
            margin: 200px;
            position:fixed;
            left: 30%;
            display: flex;
            flex-wrap:wrap;
            flex-direction: row;
            justify-content: center;
        }
        .shoplink{
            display: block;
            width: 100px;
            position: fixed;
            top:20%;
            left:45%;
            border: 2px solid black;
            text-decoration: none;
            text-align: center;
            font-weight: bolder;
            background-color: #66F227;
            color:black;
            padding: 10px;
        }
        .registerdiv input{
            display: block;
            border: 2px solid black;
            border-radius: 15px 50px;
            padding: 15px;
            margin: 8px;
        }
        .registerdiv textarea{
            display: block;
            border: 2px solid black;
            border-radius: 15px 50px;
            padding: 15px;
            margin: 8px;
            
        }
        .button{
            width: 194px;
            background-color: black;
            color: white;
            
           
        }
        .login{
            position:fixed;
            left:43.6%;
            width:150px;
            border: 2px solid black;
            border-radius: 15px 50px;
            padding: 20px;
            text-align: center;
            background-color: black;
            
        }
        .login a{
            text-decoration: none;
            color: white;
        }
        
        


    </style>






</head>
<body>
    <div class="content">
    <a class="shoplink" href="index.php">Shop</a>
  <div class="registerdiv">
    
    
    <form action="register.php" method="post">
       <input type="text" name="name" placeholder="Enter your name here!" required>
       <input type="email" name="email" placeholder="Enter your email here!" required>
       <input type="password" name="password" placeholder="Enter your password here!" required>
       <input type="text" name="phone" placeholder="Enter your phone number" required>
       <textarea class="textarea" name="address" placeholder="Enter your address here"></textarea>
       <input class="button" type="submit" name="submit" value="Sign up">
       <div class="login"> 
        <a href="login.php">Login</a>
       </div>
    </form>
    
  </div>
  </div>




    
</body>
</html>