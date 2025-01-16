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

<style>
  .row img {
    width: 200px;
    height: 200px; /* Ensure consistent height */
    object-fit: cover; /* Crop image to fit */
    display: block; /* Remove inline spacing */
    margin: auto; /* Center align */
  }

.card {
    height: 500px;
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
  @media(max-width:852px){
  table{
        text-align: center;
        display: inline-block;
    }
    table td,tr{
        display: flex;
        flex-direction: column;
        align-items: center;
        width:auto;
        padding: 10px;
    }

    table img{
        width:100%;
    }
    /* p{
      font-size: 25px;
    } */
  }
  @media(max-width:450px){
      table td{
        padding: 5px;
      }
    }
</style>

<?php
echo "<span class='page-title' style='font-size: 3em; text-align: center;
 display: block; width: 100%; margin: auto;'>OFFER Products!</span>";

// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php"); 
$qry = "SELECT * FROM product";
$stmt = $conn->prepare($qry); 
$stmt->execute(); 
$result = $stmt->get_result(); 

echo "<div class='container'>";
echo "<div class='row'>";
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

            echo "<h2><a href=$product>$row[ProductTitle]</a></h2>";
            $img = "./Images/products/$row[ProductImage]";
            echo "<img src='$img' />";

            echo "<div class='body'>";
            $offerPrice = number_format($row["OfferedPrice"], 2);
            echo "Price: <span style='font-weight: bold; font-size: 20px; text-decoration: line-through;'>S$$formattedPrice</span>";
            echo "<span style='font-weight: bold; color:red; font-size: 30px;'>  S$$offerPrice</span>";
            echo "<p style='font-size:11px;' >From: " . $startDate->format('Y-m-d') . " to " . $endDate->format('Y-m-d') . "</p>";
            
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

    
//     // Display Page Header -
//     // Pr oduct's name is read from the "ProductTitle" column of "product" table.
//     echo "<div class='row' >";
//     echo "<div class='col-sm-12' style='padding : 5px'>";
//     echo "<span class='page-title' style='font-size: 3em;'>$row[ProductTitle]</span>";
//     echo "</div>";
//     echo "</div>";
//     echo "<div class='row'> " ; // Start a new row
//     $img = "./Images/products/$row[ProductImage]";

//     // Start the flex container
//     echo "<div style='display: flex; align-items: flex-start; gap: 20px;'>";

//     // Left column - Display the product's image
//     echo "<div style='flex: 1; max-width: 30%;'>
//             <img src='$img' alt='Product Image' style='width: 100%; border: 1px solid #ccc; padding: 10px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);'>
//         </div>";

//     // Right column - Display the product's description and specifications
//     echo "<div style='flex: 2; padding: 5px;'>";

//     // Product Description
//     echo "<p style='font-size: 1.2em;'>$row[ProductDesc]</p>";

//     // Fetch and display specifications
//     $qry = "SELECT s.SpecName, ps.SpecVal 
//             FROM productspec ps 
//             INNER JOIN specification s ON ps.SpecID = s.SpecID 
//             WHERE ps.ProductID = ? 
//             ORDER BY ps.priority";

//     $stmt = $conn->prepare($qry);
//     $stmt->bind_param("i", $pid);
//     $stmt->execute();
//     $result2 = $stmt->get_result();
//     $stmt->close();

//     echo "<div style='margin-top: 10px;'>";
//     while ($row2 = $result2->fetch_array()) {
//         echo "<p><strong>" . htmlspecialchars($row2["SpecName"]) . ":</strong> " . htmlspecialchars($row2["SpecVal"]) . "</p>";
//     }

//     // Right column - display the product's price
//     $formattedPrice = number_format($row["Price"], 2);

    
//     echo "</div>"; // Close specifications container

//     echo "</div>"; // Close right column
//     echo "</div>"; // Close flex container
//     echo "</div>" ; // End of left column

//     // echo "<div class='col-sm-3' style='vertical-align: top; padding:5px'>";
//     }

//     // To Do 1: Ending...

//     // To Do 2: Create a Form for adding the product to shopping cart. Starting...
//     echo "<form action='cartFunctions.php' method='post' style='text-align: right; margin-top: 20px;'>";
//     echo "<input type='hidden' name='action' value='add' />";
//     echo "<input type='hidden' name='product_id' value='$pid' />";
//     echo "Quantity: <input type='number' name='quantity' value='1' min='1' max='10' style='width: 60px; margin-right: 10px;' required />";
//     // check number of stock left

//     $qry = "SELECT Quantity
//             FROM Product 
//             WHERE ProductID = ?" ;

//     $stmt = $conn->prepare($qry);
//     $stmt->bind_param("i", $pid);
//     $stmt->execute();
//     $result3 = $stmt->get_result();
//     $stmt->close();

//     $row = $result3->fetch_array();
//     $stock = $row["Quantity"];
//     if ($stock <= 0){
//         // no stock left, disable button
//         echo "<button class='btn btn-secondary disabled' type='submit'>Add to Cart</button>";
//         echo "<p style='color: red; margin-right: 10px;'>Out of Stock</p>";
//     }
//     else {// if stock > 0
//         echo "<button class='btn btn-primary' type='submit'>Add to Cart</button>";
//     }
//     echo "</form>";
//     echo "</div>";
//     // End of right column
//     echo "</div>"; // End of row   

// // To Do 2:  Ending ....

// $conn->close(); // Close database connnection
// echo "</div>"; // End of container

?>

<?php 
// Include the Page Layout footer
include("footer.php"); 
?>






