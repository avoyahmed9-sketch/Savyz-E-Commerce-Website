<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Savyz</title>
    <style>
        *{
            
            margin: 0px;
            padding: 0px;
            
        }
        body{
            overflow-y:auto;
        }
        .header{
            position: fixed;
            top: 0;
            width: 100%;
            background-color: gray;
            display: flex;
            flex-direction: row; /* By default flex direction row te thake its for better practice.  */
            justify-content: space-between;
            align-items: center;
            padding: 30px;
        }
        .header ul li{
            list-style: none;
        }
        .header a{
             text-decoration: none;
            color: white;
        }
        .header li{
            display: inline-block;
            margin-right: 50px;
        }
        .main{
            margin-top: 100px;
            margin-bottom: 80px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 90px;
        }
        .product{
            border: 2px solid black;
            border-radius: 10px;
            margin: 10px;
            max-width:300px;
            padding: 30px;
            text-align: center;
            margin-top:5px;
        }
       
        .product a{
            display: block;
            text-decoration:none;
            color: black;
            background-color:greenyellow;
            padding: 5px;
            margin-top: 10px;
            
        }
        .product img{
            width: 50px;
        }
        .productprice{
            color: burlywood;
            font-size: large;
        }
        .footer{
            display: flex;
            flex-direction: row; /* By default flex direction row te thake its for better practice.  */
            justify-content: center;
            align-items: center;
            background-color: gray;
            position: fixed;
            bottom: 0px;
            padding: 10px;
            width: 100%;
            
        }
        .footer p{
            text-align: center;
        }
        @media(max-width: 400px){
            .header{
                display: flex;
                flex-direction: column;
            }
            .footer{
                display: flex;
                flex-direction: column;
            }
        }
        
    </style>
</head>
<body>
    <header class="header">
        <a href="index.php">shop</a>
        <a href="index.php"><img src="" alt=""></a>
        <nav>
            <ul>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Signup</a></li>
                <li><a href="">Dashboard</a></li>
            </ul>
        </nav>





    </header>
    <main class="main">


      <!-- <?php
        $products = [
       [
        "image" => "Images/Sneakers1.jpg",
        "title" => "Running Sneakers",
        "description" => "Comfortable running shoes",
        "quantity" => "In Stock",
        "price" => "$59.99"
       ],
       [
        "image" => "Images/Sneakers2.jpg",
        "title" => "Casual Sneakers",
        "description" => "Perfect for daily wear",
        "quantity" => "Limited Stock",
        "price" => "$49.99"
       ],
       [
        "image" => "Images/3rd.jpeg",
        "title" => "Sports Sneakers",
        "description" => "Best for gym and sports",
        "quantity" => "Out of Stock",
        "price" => "$69.99"
       ]
       ];
      ?>
       <?php foreach ($products as $product) { ?>
    
    <div class="product">
        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['title']; ?>">
        <h2><?php echo $product['title']; ?></h2>
        <p><?php echo $product['description']; ?></p>
        <p><?php echo $product['quantity']; ?></p>
        <p class="productprice"><?php echo $product['price']; ?></p>
        <a href="#">Buy Now</a>
    </div>

    <?php } ?> 
    -->

















      <?php for( $i = 0; $i<30; $i++){
        ?>


        <div class="product">
            <img src="Images/Sneakers1.jpg" alt="Sneaker Image">
            <h2>Product title</h2>
            <p>Product description</p>
            <p>Product quantity</p>
            <p class="productprice">Product price</p>
            <a href="#">Buy Now</a>
        
        </div>

        <?php } ?> 

        




    </main>
    <footer class="footer">
        <p>copyright@: webtech knowledge</p>




    </footer>
</body>
</html>