<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce</title>
    <!-- <link rel="icon" type="image/x-icon" href="images/home/icon.png"> -->
    <link rel="stylesheet" href="css/site.css">
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body style="background: linear-gradient( rgba(0,0,0,0.5)50%,rgba(0,0,0,0.5)50%), url(Images/background.jpg);color:white;border: 0px;
    padding: 0px;width:100%;height:100vh;background-size:cover;background-position:center;">
    <div id="progress">
        <span id="progress-value"><i class="fa fa-arrow-up"></i></span>
    </div>
    <header>
        <a href="" class="logo"><img src="Images/icon.png" alt="" style="width:80px;"></a>
        <div class="bx bx-menu" id="menu-icon" style="color:black"></div>
        <!-- Navigation bar -->
        <ul class="navbar">
            <li><a href="index.php"><i class="fa-sharp fa-solid fa-house"></i><span>&nbsp;Home</span></a></li>
            <li><a href="category.php"><i class="fa-solid fa-magnifying-glass"></i><span>&nbsp;Product Category</span></a></li>
            <li><a href="shoppingCart.php" id="cart-icon"><i class="fa-solid fa-cart-shopping"></i><span>&nbsp;Shopping Cart</span></a></li>
        </ul>
        <div class="profile">
            <!-- Create a dropdown navbar to change password, logout etc, past orders -->
            <?php
                if (!isset($_SESSION["ShopperName"])){
                    echo "<a href='login.php' id='logout'><i class='fa-solid fa-user'></i><span id='username'>Guest</span></a>";
                }
                else{
                    echo "<a href='login.php' id='logout'><i class='fa-solid fa-user'></i><span id='username'>$_SESSION[ShopperName]</span></a>";
                }
            ?>
        </div>
    </header>
    <br><br><br><br><br>
    <script src="js/user.js"></script>
