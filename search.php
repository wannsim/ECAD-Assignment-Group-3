<?php 
session_start(); // Detect the current session
include("header.php"); // Include the Page Layout header
?>
<style>
  .row img {
    height: 150px; /* Ensure consistent height */
    object-fit: cover; /* Crop image to fit */
    display: block; /* Remove inline spacing */
    margin: auto; /* Center align */
  }

.card {
    height: 350px;
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
.padding{
    width:60%; margin:auto;
}
@media(max-width:546px){
    .container img{
        right: 50px;
        width:100%;
        object-fit:contain;
    }
    .card{
        height: 350px;
    }
    .padding{
        width:90%;
    }
}
</style>
<div style="width:80%; margin:auto;"> <!-- Container -->
<form name="frmSearch" method="get" action="">
    <div class="mb-3 row"> <!-- 1st row -->
        <div class="col-sm-9 offset-sm-3">
            <span class="page-title" style="font-size:50px;">Product Search</span>
        </div>
    </div> 
<form method="get" action="">
    <div class="mb-3 row">
        <label for="keywords" class="col-sm-3 col-form-label" style="font-size:20px;">Search:</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="keywords" id="keywords" placeholder="Enter product title or description" />
        </div>
    </div>

    <div class="mb-3 row">
        <label for="availability" class="col-sm-3 col-form-label" style="font-size:20px;">Availability:</label>
        <div class="col-sm-6">
            <select class="form-control" name="availability" id="availability">
                <option value=""><--Select--></option>
                <option value="1">In Stock</option>
                <option value="0">Out of Stock</option>
            </select>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="priceRange" class="col-sm-3 col-form-label" style="font-size:20px;">Price Range:</label>
        <div class="col-sm-3">
            <input type="number" class="form-control" name="minPrice" id="minPrice" placeholder="Min Price" />
        </div>
        <div class="col-sm-3">
            <input type="number" class="form-control" name="maxPrice" id="maxPrice" placeholder="Max Price" />
        </div>
    </div>

    <div class="mb-3 row">
        <label for="offers" class="col-sm-3 col-form-label" style="font-size:20px;">Products on Offer:</label>
        <div class="col-sm-6">
            <select class="form-control" name="offers" id="offers">
                <option value=""><--Select--></option>
                <option value="1">On Offer</option>
                <option value="0">Not on Offer</option>
            </select>
        </div>
    </div>

    <div class="mb-3 row">
        <div class="col-sm-3 offset-sm-3">
            <button class="btn btn-primary" type="submit">Filter</button>
        </div>
    </div>
</div>
</form>

 <!-- Create a container, 60% width of viewport -->
 <div class="padding">
    <!-- Display Page Header -->
    <div class="row" style="padding:5px; text-align:left"> <!-- Start of header row -->
        <div class="col-12">
            <h1 style = "margin-top :-10px">Products</h1>
        </div>
    </div> <!-- End of header row -->
    <br>
<?php

$keywords = isset($_GET['keywords']) && trim($_GET['keywords']) != "" ? "%" . $_GET['keywords'] . "%" : null;
$availability = isset($_GET['availability']) && $_GET['availability'] !== "" ? $_GET['availability'] : null;
$minPrice = isset($_GET['minPrice']) && is_numeric($_GET['minPrice']) ? $_GET['minPrice'] : null;
$maxPrice = isset($_GET['maxPrice']) && is_numeric($_GET['maxPrice']) ? $_GET['maxPrice'] : null;
$offers = isset($_GET['offers']) && $_GET['offers'] !== "" ? $_GET['offers'] : null;

if ($keywords != "" || $availability != "" || $minPrice != "" || $maxPrice != "" || $offers != "" ) {

    include_once("mysql_conn.php");
    $qry = "SELECT * FROM product WHERE 1=1";
    $params = [];
    $types = "";

    if ($keywords !== null) {
        $qry .= " AND (ProductTitle LIKE ? )";
        $params[] = $keywords;
        $types .= "s";
    }

    if ($availability !== null) {
        $qry .= $availability == "1" ? " AND Quantity > 0" : " AND Quantity = 0";
    }

    if ($minPrice !== null) {
        $qry .= " AND Price >= ?";
        $params[] = $minPrice;
        $types .= "d";
    }
    if ($maxPrice !== null) {
        $qry .= " AND Price <= ?";
        $params[] = $maxPrice;
        $types .= "d";
    }

    if ($offers !== null) {
        if ($offers == "1") {
            // Filter for active offers
            $qry .= " AND Offered = 1 AND (OfferEndDate IS NULL OR OfferEndDate >= NOW())";
        } elseif ($offers == "0") {
            // Filter for ended offers
            $qry .= " AND Offered = 1 AND OfferEndDate < NOW()";
        }
    }

    // Prepare and execute the query
    $stmt = $conn->prepare($qry);
    if (!empty($types)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    
}

else{
    include_once("mysql_conn.php");
    // Form SQL to retrieve list of products associated to the Category ID
    $qry = "SELECT * FROM product
            ORDER BY ProductTitle ASC";
    
    $result = $conn->query($qry);
}
    
// Check if there are any results
if ($result->num_rows === 0){
    echo "<h3 style='color:red'>No records found</h3>";
}

else {
    $count = 0;
    echo "<div class='container'>";
    echo "<div class='row'>";

    // Display each category in a row
    while ($row = $result->fetch_array()) {
        
        echo "<div class='col-md-4' style='margin-bottom: 20px;'>";
        $product = "productDetails.php?pid=$row[ProductID]";
        
        echo "<div class='card'>";
        $formattedPrice = number_format($row["Price"], 2);

        $img = "./Images/products/$row[ProductImage]";
        echo "<a href=$product>";
        echo "<img src='$img' /></a>";
        echo "<h2><a href=".$product." style='text-decoration:none;'>$row[ProductTitle]</a></h2>";
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
            $percent=round(($row["Price"] - $row["OfferedPrice"]) / $row["Price"] * 100 / 10) * 10;
            echo '<span class="discount">-'.$percent.'%</span>';
        }
        else{
            echo "Price: <span style='font-weight: bold; color:black; font-size: 20px;'>S$$formattedPrice</span>";
        }
        }

        else{
            echo "Price: <span style='font-weight: bold; color:black; font-size: 20px;'>S$$formattedPrice</span>";
        }
        
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


        echo "</div>"; // End of container
}
include("footer.php"); // Include the Page Layout footer
?>



