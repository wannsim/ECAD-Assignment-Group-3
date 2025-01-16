<?php 
session_start(); // Detect the current session
include("header.php"); // Include the Page Layout header
?>

<!-- HTML Form to collect search keyword and submit it to the same page in server -->
<div style="width:80%; margin:auto;"> <!-- Container -->
<form name="frmSearch" method="get" action="">
    <div class="mb-3 row"> <!-- 1st row -->
        <div class="col-sm-9 offset-sm-3">
            <span class="page-title" style="font-size:30px;">Product Search</span>
        </div>
    </div> <!-- End of 1st row -->
    <div class="mb-3 row" style="font-size:30px;"> <!-- 2nd row -->
        <label for="keywords" 
               class="col-sm-3 col-form-label">Product Title:</label>
        <div class="col-sm-6">
            <input class="form-control" name="keywords" id="keywords" 
                   type="search" />
        </div>
        <div class="col-sm-3">
            <button class='btn btn-primary' type="submit">Search</button>
        </div>
    </div>  <!-- End of 2nd row -->
</form>

<?php
// The non-empty search keyword is sent to server
if (isset($_GET["keywords"]) && trim($_GET['keywords']) != "") {
    // To Do (DIY): Retrieve list of product records with "ProductTitle" 
	// contains the keyword entered by shopper, and display them in a table.
	// Include the PHP file that establishes database connection handle: $conn
    include_once("mysql_conn.php");

    // Reading inputs entered in previous page
    $keyword = "%".$_GET["keywords"]."%";
    // To Do 1 (Practical 2): Validate login credentials with database
    $qry = "SELECT * FROM product WHERE ProductTitle like ? OR ProductDesc LIKE ?";
    $stmt = $conn->prepare($qry);
    $stmt->bind_param("ss", $keyword,$keyword); // Binding email parameter to prevent SQL injection
    $stmt->execute();
    $result = $stmt->get_result(); // Execute the SQL and get the returned result

    echo "<div style='margin-left: 30px;'>"; // move search results towards the right
    echo "<h4 style='font-weight: bold;'>Search results for {$_GET['keywords']}:</h3>";
    if ($result->num_rows > 0) { // If found, display records
        while ($row = $result->fetch_array()) 
        {$product = "productDetails.php?pid=$row[ProductID]";
        echo "<p '><a href=$product>$row[ProductTitle]</a></p>";}
    }
    else {
        echo "<h3 style='color:red'>No records found</h3>";
    }
    echo "</div>"; 
	// To Do (DIY): End of Code
}

echo "</div>"; // End of container
include("footer.php"); // Include the Page Layout footer
?>