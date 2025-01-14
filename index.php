<?php 
// Detect the current session
session_start();
// Include the Page Layout header
include("header.php"); 
?>

<h1 style="text-align: center; font-size: 4em; font-family: Arial, sans-serif;">
     <img src="https://cdn-icons-png.flaticon.com/128/2568/2568424.png" alt="Baby Icon" 
     style="vertical-align: middle; width: 80px; height: 80px; margin-right: 10px;">
    BABY SHOP
    <img src="https://cdn-icons-png.flaticon.com/128/2568/2568424.png" alt="Baby Icon" 
    style="vertical-align: middle; width: 80px; height: 80px; margin-right: 10px;">
</h1>

<?php
    echo "<i class='fa-solid fa-user' style='margin-left: 20px;'></i>
          <span id='username' style='margin-left: 5px;'>WELCOME, ".$_SESSION['ShopperName']."</span>";
?>


<?php 
// Include the Page Layout footer
include("footer.php"); 
?>
