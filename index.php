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
            overflow: hidden;
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
        .footer{
            display: flex;
            flex-direction: row; /* By default flex direction row te thake its for better practice.  */
            justify-content: space-between;
            
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
                <li><a href="">Login</a></li>
                <li><a href="">Signup</a></li>
                <li><a href="">Dashboard</a></li>
            </ul>
        </nav>





    </header>
    <main>



    </main>
    <footer class="footer">
        <p>copyright@: webtech knowledge</p>




    </footer>
</body>
</html>