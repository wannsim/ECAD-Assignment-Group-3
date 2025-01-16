<?php 
session_start(); // Detect the current session
include("header.php"); // Include the Page Layout header
?>



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



<!-- Create a container, 60% width of viewport -->
<div style="width:60%; margin:auto;">
<!-- Display Page Header -->
<div class="row" style="padding:5px; text-align:center"> <!-- Start of header row -->
    <div class="col-12">
        <h1 style = "margin-top :-10px">
          <?php echo "$_GET[catName]"; ?>
        </h1>
    </div>
</div> <!-- End of header row -->
<br>
<?php 

include_once("mysql_conn.php");

$cid = $_GET["cid"];

// Form SQL to retrieve list of products associated to the Category ID
$qry = "SELECT p.ProductID, p.ProductTitle, p.ProductImage, p.Price, p.Quantity, p.Offered, p.OfferedPrice, 
                p.OfferStartDate, p.OfferEndDate
        FROM CatProduct cp
        INNER JOIN product p ON cp.ProductID=p.ProductID
        WHERE cp.CategoryID=?
        ORDER BY p.ProductTitle ASC";

$stmt = $conn->prepare($qry);
$stmt->bind_param("i", $cid); // "i" - integer
$stmt->execute();

$result = $stmt->get_result();
// Close the statement to release resources
$stmt->close();

$count = 0;
echo "<div class='container'>";
echo "<div class='row'>";

// Display each category in a row
while ($row = $result->fetch_array()) {
  
  echo "<div class='col-md-4' style='margin-bottom: 20px;'>";
  echo "<div class='card'>";

  $product = "productDetails.php?pid=$row[ProductID]";
  $formattedPrice = number_format($row["Price"], 2);

  echo "<h2><a href=$product>$row[ProductTitle]</a></h2>";
  $img = "./Images/products/$row[ProductImage]";
  echo "<img src='$img' />";

  echo "<div class='body'>";
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
        $offerPrice = number_format($row["OfferedPrice"], 2);
        echo "Price: <span style='font-weight: bold; font-size: 20px; text-decoration: line-through;'>S$$formattedPrice</span>";
        echo "<span style='font-weight: bold; color:red; font-size: 20px;'>  S$$offerPrice</span>";
        echo "<p style='font-size:11px;' >From: " . $startDate->format('Y-m-d') . " to " . $endDate->format('Y-m-d') . "</p>";
    }
    else{
        echo "Price: <span style='font-weight: bold; color:black; font-size: 20px;'>S$$formattedPrice</span>";
    }
  }

    else{
        echo "Price: <span style='font-weight: bold; color:black; font-size: 20px;'>S$$formattedPrice</span>";
    }

  // echo "Price: <span style='font-weight: bold; color: red;'>$$formattedPrice</span>";
  echo "</div>"; 
  echo "</div>"; 
  echo "</div>";
  $count++;
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
include("footer.php"); // Include the Page Layout footer
?>

















