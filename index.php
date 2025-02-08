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
<h2 style="padding-left:30px; text-align:center;">Welcome, <?php echo $content1;?></h2>


<style>
  .row img {
    width: 200px;
    height: 200px; /* Ensure consistent height */
    object-fit: cover; /* Crop image to fit */
    display: block; /* Remove inline spacing */
    margin: auto; /* Center align */
  }

.card {
    height: 450px;
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Distribute content evenly */
    align-items: center;
    text-align: center;
    padding: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
  }

.card-title {
    font-size: 16px;
    font-weight: bold;
    margin: 10px 0;
  }

.body {
    margin-top: auto;
    font-size: 14px;
    text-align: center;
  }
  h2 a{
    color:black;
  }
  .row{
    align-items: center;
    text-align: center;
  }

  .body{
    padding: 15px;
  }

  p{
    font-size: 20px;
  }
  .discount{
    position: absolute;
    top:1rem;
    left:-1px;
    background: var(--light-orange-color);
    color:var(--bg-color);
    padding: 4px 18px;
    clip-path: polygon(100% 0%,75% 50%,100% 100%,0 100%,0% 50%,0 0);
}
</style>

<?php


// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php"); 
$qry = "SELECT * FROM product";
$stmt = $conn->prepare($qry); 
$stmt->execute(); 
$result = $stmt->get_result(); 

echo "<div class='container'>";
echo "<div class='row'>";
echo "<span class='page-title' style='font-size: 3em; text-align: left;
 display: block; width: 100%; '>OFFER Products!</span>";
$count = 0;

while ($row = $result->fetch_array()) {
    if ($row["Offered"] == 1){
        $currentDate = new DateTime();
        $endDate = new DateTime($row["OfferEndDate"]);
        $startDate = new DateTime($row["OfferStartDate"]);
        
        // Calculate the difference between the two dates
        $dateDiff = $endDate->diff($currentDate);
        
        // Get the difference in days as an integer
        $daysDifference = (int)$dateDiff->days;
        
        // on offer 
        if ($endDate > $currentDate){
            echo "<div class='col-md-4' style='margin-bottom: 20px;'>";
            echo "<div class='card'>";

            $product = "productDetails.php?pid=$row[ProductID]";
            $formattedPrice = number_format($row["Price"], 2);

           
            $img = "./Images/products/$row[ProductImage]";
            echo "<a href=$product>";
            echo "<img src='$img' /></a>";
            echo "<h2><a href=$product style='text-decoration:none'>$row[ProductTitle]</a></h2>";
            echo "<div class='body'>";
            $offerPrice = number_format($row["OfferedPrice"], 2);
            echo "Price: <span style='font-weight: bold; font-size: 20px; text-decoration: line-through;'>S$$formattedPrice</span>";
            echo "<span style='font-weight: bold; color:red; font-size: 30px;'>  S$$offerPrice</span>";
            echo "<p style='font-size:11px;' >From: " . $startDate->format('Y-m-d') . " to " . $endDate->format('Y-m-d') . "</p>";
            $percent=round(($row["Price"] - $row["OfferedPrice"]) / $row["Price"] * 100 / 10) * 10;
            echo '<span class="discount">-'.$percent.'%</span>';
            echo "</div>"; 
            echo "</div>"; 
            echo "</div>";
            $count++;
        }

    }

    if ($count % 3 == 0) {
        echo "</div><div class='row'>"; // Close the current row and start a new one
    }
}
// Close any unclosed rows
if ($count % 3 != 0) {
    echo "</div>"; // Close the last row if it is incomplete
}
    
echo "</div>"; // Close the container
$conn->close(); // Close database connnection
echo "</div>"; // End of container

?>

<?php 
// Include the Page Layout footer
include("footer.php"); 
?>






