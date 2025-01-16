 <?php
 if (!isset($_SESSION["ShopperName"])) {
    $content1 = "<a href='login.php'><i class='fa-solid fa-right-to-bracket'></i><span id='username'>Login</span></a>";
    $content2 = "";
}
else{
    $content1 = "<a href='logout.php'><i class='fa-solid fa-right-from-bracket fa-flip-horizontal'></i><span id='username'>Logout</span></a>";
    if (isset($_SESSION["NumCartItem"])) {
        $content2 .=" (".$_SESSION["NumCartItem"].")";
    
}}

?>
 <header>
        <a href="" class="logo"><img src="Images/icon.png" alt="" style="width:80px;"></a>
        <div class="bx bx-menu" id="menu-icon" style="color:black"></div>
        <!-- Navigation bar -->
        <ul class="navbar">
            <li><a href="index.php"><i class="fa-sharp fa-solid fa-house"></i><span>&nbsp;Home</span></a></li>
            <li><a href="search.php"><i class="fa-solid fa-magnifying-glass"></i><span>&nbsp;Product Search</span></a></li>
            <li><a href="category.php"><i class="fa-solid fa-list"></i><span>&nbsp;Product Category</span></a></li>
            <li><a href="shoppingCart.php"><i class="fa-solid fa-cart-shopping"></i><span>&nbsp;Shopping Cart<?php echo $content2?></span></a></li>
        </ul>
        <div class="profile">
            <!-- Create a dropdown navbar to change password, logout etc, past orders -->
            <?php
                if (!isset($_SESSION["ShopperName"])){
                    echo "<a href='login.php'><i class='fa-solid fa-right-to-bracket'></i><span id='username'>Login</span></a>";
                }
                else{
                    echo "<a href='logout.php'><i class='fa-solid fa-right-from-bracket fa-flip-horizontal'></i><span id='username'>Logout</span></a>";
                }
            ?>
        </div>
    </header>
    <br><br><br><br><br>
