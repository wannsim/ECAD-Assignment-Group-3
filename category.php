<?php 
session_start(); // Detect the current session
include("header.php"); // Include the Page Layout header
?>
<style>
  table a,tr{
    color:black;
    background-color: white;
  }
  table img{
    width:200px;
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

echo "<table>";
// Display each category in a row
while ($row = $result->fetch_array()) {
  //echo "<div class='row' style='padding:5px'>"; // Start a new row

  // Left column - display a text link showing the category's name,
  // display category's description in a new paragraph
  echo "<tr>";
  echo "<th colspan='2' style='text-align:center'>";
  $catname = urlencode($row["CatName"]);
  $catproduct = "catProduct.php?cid=$row[CategoryID]&catName=$catname";
  //echo "<div class='col-8'>"; // 67% of row width
  echo "<h2><a href=$catproduct>$row[CatName]</a></h2>";
  echo "</th>";
  echo "</tr>";
  echo "<tr>";
  echo "<td>";
  // Right column - display the category's image
  $img = "./Images/category/$row[CatImage]";
  //echo "<div class='col-4'>"; // 33% of row width
  echo "<img src='$img' />";
  echo "</td>";
  echo "<td>";
  echo "$row[CatDesc]";
  echo "</td>";


  echo "</tr>"; // End of a row
 // echo "</div>"; // End of arrow
  echo "<tr>";
  echo "</tr>";
}
echo "</table>";

$conn->close(); // Close database connnection
echo "</div>"; // End of container
include("footer.php"); // Include the Page Layout footer
?>
