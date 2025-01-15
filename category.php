<?php 
session_start(); // Detect the current session
include("header.php"); // Include the Page Layout header
?>
<style>
  h2 a{
    color:black;
  }
  table a,tr{
    color:black;
    background-color: white;
    align-items: center;
    text-align: center;
  }
  .card{
    align-items: center;
    height: 400px;
  }
  .row{
    align-items: center;
    text-align: center;
  }
  .row img{
    width:200px;
  }

  .body{
    padding: 15px;
  }

  .card-title{
    font-size: 14px;
  }
  table td{
    padding:10px;
    font-size:20px;
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

  $catname = urlencode($row["CatName"]);
  $catproduct = "catProduct.php?cid=$row[CategoryID]&catName=$catname";
  echo "<h2><a href=$catproduct>$row[CatName]</a></h2>";
  $img = "./Images/category/$row[CatImage]";
  echo "<img src='$img' />";

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
