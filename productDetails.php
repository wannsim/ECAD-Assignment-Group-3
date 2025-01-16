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
$stmt->bind_param("i", $pid); 	// "i" - integer 
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

// To Do 1:  Display Product information. Starting ....

while ($row = $result->fetch_array()) {
    // Display Page Header -
    // Pr oduct's name is read from the "ProductTitle" column of "product" table.
    echo "<div class='row' >";
    echo "<div class='col-sm-12' style='padding : 5px'>";
    echo "<span class='page-title' style='font-size: 3em;'>$row[ProductTitle]</span>";
    echo "</div>";
    echo "</div>";
    echo "<div class='row'> " ; // Start a new row
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
    echo "Price: <span style='font-weight: bold; color:red; font-size: 20px;'>S$$formattedPrice</span>";

    echo "</div>"; // Close specifications container

    echo "</div>"; // Close right column
    echo "</div>"; // Close flex container
    echo "</div>" ; // End of left column

    // echo "<div class='col-sm-3' style='vertical-align: top; padding:5px'>";
    }

    // To Do 1: Ending...

    // To Do 2: Create a Form for adding the product to shopping cart. Starting...
    echo "<form action='cartFunctions.php' method='post' style='text-align: right; margin-top: 20px;'>";
    echo "<input type='hidden' name='action' value='add' />";
    echo "<input type='hidden' name='product_id' value='$pid' />";
    echo "Quantity: <input type='number' name='quantity' value='1' min='1' max='10' style='width: 60px; margin-right: 10px;' required />";
    echo "<button class='btn btn-primary' type='submit'>Add to Cart</button>";
    echo "</form>";
    echo "</div>";
    // End of right column
    echo "</div>"; // End of row   

// To Do 2:  Ending ....

$conn->close(); // Close database connnection
echo "</div>"; // End of container
include("footer.php"); // Include the Page Layout footer
?>
