﻿<?php 
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
    height: 400px;
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
</style>
<!-- Create a container, 60% width of viewport -->
<div style="width:60%; margin:auto;">
<!-- Display Page Header -->
<div class="row" style="padding:5px; text-align:center"> <!-- Start of header row -->
    <div class="col-12">
        <h1 style = "margin-top :-10px">Product Categories</h1>
        <p>Select a category listed below:</p>
    </div>
</div> <!-- End of header row -->
<br>
<?php 

// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php");
// To Do:  Starting ....
// Form SQL to select all categories
$qry = "SELECT * FROM Category";
// Execute the SQL and get the result
$result = $conn->query($qry);

$count = 0;
echo "<div class='container'>";
echo "<div class='row'>";

// Display each category in a row
while ($row = $result->fetch_array()) {
  
  echo "<div class='col-md-4' style='margin-bottom: 20px;'>";
  echo "<div class='card'>";

  $img = "./Images/category/$row[CatImage]";
  $catname = urlencode($row["CatName"]);
  $catproduct = "catProduct.php?cid=$row[CategoryID]&catName=$catname";
  echo "<a href=$catproduct>$row[CatName]>";
  echo "<img src='$img'/></a>";
  echo "<h2 ><a style='text-decoration:none;' href=$catproduct>$row[CatName] </a></h2>";

  echo "<div class='body'>";
  echo "<h5 class='card-title'>$row[CatDesc]</h5>";
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
