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
</head>
<body>
    
</body>
</html>