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
        .main{
            padding: 30px;
            margin-left: 200px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <ul>
            <li><a href="addproduct.php">Add product</a></li>
            <li><a href="http://">View order</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="main">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus nisi facere saepe nulla deleniti architecto repellat vero eum nam assumenda. Dolor necessitatibus dolorem iste dolores dignissimos eius delectus enim assumenda, repudiandae quo libero quam error praesentium maxime? Sequi expedita veniam perferendis ad dolorum corporis ipsam voluptas, repudiandae velit nesciunt maxime!
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis ratione consectetur commodi blanditiis! Magnam exercitationem dignissimos quia veniam laborum, a commodi odit qui dolore dicta praesentium sit numquam quidem ex?
        </p>




    </div>
    
</body>
</html>