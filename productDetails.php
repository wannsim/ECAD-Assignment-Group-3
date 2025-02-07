﻿Ho Yi Victoria, [8/2/2025 1:07 pm]
<style>
    .container1{
    border-radius:15px;
    display:flex;
    justify-content:right;
    }
    input[type="number"]{
        -moz-appearance: textfield;
        text-align: center;
        border:none;
        font-size:25px;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin:0;
    }

    button{
        color:var(--green-color);
        background-color:#ffffff;
        border:none;
        font-size: 25px;
        cursor:pointer;
    }

    #decrement{
        padding: 5px 0px 5px 10px;
        border-radius: 30px 0 0 30px;
    }
    #increment{
        padding: 5px 10px 5px 0px;
        border-radius: 0 30px 30px 0;
    }
</style>

<?php 
session_start(); // Detect the current session
include("header.php"); // Include the Page Layout header
?>
<!-- Create a container, 90% width of viewport -->
<div style='width:90%; margin:auto;'>

<?php 
$pid=$_GET["pid"]; // Read Product ID from query string

// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php"); 
$qry = "SELECT * from product where ProductID=?";
$stmt = $conn->prepare($qry);
$stmt->bind_param("i", $pid);   
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

while ($row = $result->fetch_array()) {
    $stock = $row["Quantity"];
    // Display Page Header -
    // Pr oduct's name is read from the "ProductTitle" column of "product" table.
    echo "<div class='row' >";
    echo "<div class='col-sm-12' style='padding : 5px'>";
    echo "<span class='page-title' style='font-size: 3em;'>$row[ProductTitle]</span>";
    echo "</div>";
    echo "</div>";
    echo "<div class='row1'> " ; // Start a new row
    $img = "./Images/products/$row[ProductImage]";

    // Start the flex container
    echo "<div style='display: flex; align-items: flex-start; gap: 20px;'>";

    // Left column - Display the product's image
    echo "<div style='flex: 1; max-width: 30%;'>
            <img src='$img' alt='Product Image' style='width: 100%; border: 1px solid #ccc; padding: 10px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);'>
        </div>";

    // Right column - Display the product's description and specifications
    echo "<div style='flex: 2; padding: 5px;'>";

    // Product Description
    echo "<p style='font-size: 1.2em;'>$row[ProductDesc]</p>";

    // Fetch and display specifications
    $qry = "SELECT s.SpecName, ps.SpecVal 
            FROM productspec ps 
            INNER JOIN specification s ON ps.SpecID = s.SpecID 
            WHERE ps.ProductID = ? 
            ORDER BY ps.priority";

    $stmt = $conn->prepare($qry);
    $stmt->bind_param("i", $pid);
    $stmt->execute();
    $result2 = $stmt->get_result();
    $stmt->close();

    echo "<div style='margin-top: 10px;'>";
    while ($row2 = $result2->fetch_array()) {
        echo "<p><strong>" . htmlspecialchars($row2["SpecName"]) . ":</strong> " . htmlspecialchars($row2["SpecVal"]) . "</p>";
    }

    // Right column - display the product's price
    $formattedPrice = number_format($row["Price"], 2);

    if ($row["Offered"] == 1){
        $currentDate = new DateTime();
        $endDate = new DateTime($row["OfferEndDate"]);
        
        // Calculate the difference between the two dates
        $dateDiff = $endDate->diff($currentDate);
        
        // Get the difference in days as an integer
        $daysDifference = (int)$dateDiff->days;
// on offer 
        if ($endDate > $currentDate){
            $offerPrice = number_format($row["OfferedPrice"], 2);
            echo '<p style="background-color: green; color: white; padding: 10px; width: fit-content; border-radius: 5px;">Save ' . round(($row["Price"] - $row["OfferedPrice"]) / $row["Price"] * 100 / 10) * 10 . "%</p>";
      echo "<p style = 'color:red; background-color: white; padding: 10px; width: fit-content; border-radius: 5px;'>$daysDifference days left !</p>";
            echo "Price: <span style='font-weight: bold; font-size: 20px; text-decoration: line-through;'>S$$formattedPrice</span>";
            echo "<span style='font-weight: bold; color:red; font-size: 30px;'>  S$$offerPrice</span>";
        }
        else{
            echo "Price: <span style='font-weight: bold; color:red; font-size: 20px;'>S$$formattedPrice</span>";
        }
    }

    else{
        echo "Price: <span style='font-weight: bold; color:red; font-size: 20px;'>S$$formattedPrice</span>";
    }
    echo "</div>"; // Close specifications container

    echo "</div>"; // Close right column
    echo "</div>"; // Close flex container
    echo "</div>" ; // End of left column

    // echo "<div class='col-sm-3' style='vertical-align: top; padding:5px'>";
    }

    echo "<br>";
    echo "<form action='cartFunctions.php' method='post' style='text-align: right; margin-top: 20px;'>";
    echo "<input type='hidden' name='action' value='add' />";
    echo "<input type='hidden' name='product_id' value='$pid' />";
    echo "<div class='container1'>";
    echo "<span style='position: relative; top: 15px; right: 10px;'>Quantity: </span>";
    echo "<button id='decrement' type='button' style='font-size: 25px;'> - </button>";
    echo "<input type='number' name='quantity' id='my-input' value='1' min='1' max='".intval($stock)."' step='1' required />";
    echo "<button id='increment' type='button' style='font-size: 25px;'> + </button>";
    echo "</div>";

    echo "<script>";
    echo "const myInput = document.getElementById('my-input');";
    echo "const max = ".intval($stock).";";
    echo "const stepper = (btn) => {";
    echo "  const min = parseInt(myInput.getAttribute('min'));";
    echo "  const step = parseInt(myInput.getAttribute('step'));";
    echo "  let value = parseInt(myInput.value);";
    echo "  let calcStep = (btn.id === 'increment') ? step : -step;";
    echo "  let newValue = value + calcStep;";
    echo "  if (newValue >= min && newValue <= max) {";
    echo "    myInput.value = newValue;";
    echo "  }";
    echo "};";
    echo "document.getElementById('increment').addEventListener('click', function () { stepper(this); });";
    echo "document.getElementById('decrement').addEventListener('click', function () { stepper(this); });";
    echo "</script>";

    
    echo '<p style="font-size: 20px; position: relative; top: 5px; right: 10px;">In stock: ' . $stock . '</p>';



    if ($stock <= 0){
        // no stock left, disable button
        echo "<button class='btn btn-secondary disabled' type='submit'>Add to Cart</button>";
        echo "<p style='color: red; margin-right: 10px;'>Out of Stock</p>";
    }
    else {// if stock > 0
        echo "<button class='btn btn-primary' type='submit'>Add to Cart</button>";
    }
    echo "</form>";
    echo "</div>";
    // End of right column
    
$conn->close(); // Close database connnection
echo "</div>"; // End of container
include("footer.php"); // Include the Page Layout footer
?>