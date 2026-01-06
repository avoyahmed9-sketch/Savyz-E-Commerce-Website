 <?php
 session_start();
 if(isset($_SESSION['user_id'])){
   if($_SESSION['user_role'] == "admin"){

   }
   else{
    echo "Go for user dashboard";
   }
 }
 else{
    header("Location: ../index.php");
 }

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        *{
            margin: 0;
            padding: 0;
        }

        .sidebar{
            
            position: fixed;
            top: 0;
            background-color: #804E49;
            width: 200px;
            height: 100%;
        
        }
        .sidebar ul li{
            list-style: none;
            text-align: center;
            
        }
        .sidebar ul li a{
            padding: 10px;
            display:block;
            text-decoration: none;
            color: black;
        }
        .sidebar ul li a:hover{
            background-color: gray;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <ul>
            <li><a href="http://">Add product</a></li>
            <li><a href="http://">View order</a></li>
            <li><a href="http://">Logout</a></li>
        </ul>
    </div>
    
</body>
</html>