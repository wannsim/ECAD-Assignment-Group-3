<?php 
// Detect the current session
session_start();
// Include the Page Layout header
include("header.php"); 
$content1="Guest";
if(isset($_SESSION["ShopperName"])) { 
	$content1 = $_SESSION["ShopperName"];
	if (isset($_SESSION ["NumCartItem"])) {
        $cartitems=$_SESSION["NumCartItem"];
    }
}
?>
<br><br>
<h1 style="text-align: center; font-size: 4em;">
     <img src="https://cdn-icons-png.flaticon.com/128/2568/2568424.png" alt="Baby Icon" 
     style="vertical-align: middle; width: 80px; height: 80px; margin-right: 10px;">
    BABY SHOP
    <img src="https://cdn-icons-png.flaticon.com/128/2568/2568424.png" alt="Baby Icon" 
    style="vertical-align: middle; width: 80px; height: 80px; margin-right: 10px;">
</h1>

<h2 style="padding-left:30px">Welcome, <?php echo $content1;?></h2>


<?php 
// Include the Page Layout footer
include("footer.php"); 
?>
