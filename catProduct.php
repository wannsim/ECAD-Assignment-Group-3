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
    table-layout: fixed;
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
        <h1 style = "margin-top :-10px">
          <?php echo "$_GET[catName]"; ?>
        </h1>
    </div>
</div> <!-- End of header row -->
<br>
<?php 

// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php");

$cid = $_GET["cid"];

// Form SQL to retrieve list of products associated to the Category ID
$qry = "SELECT p.ProductID, p.ProductTitle, p.ProductImage, p.Price, p.Quantity
        FROM CatProduct cp
        INNER JOIN product p ON cp.ProductID=p.ProductID
        WHERE cp.CategoryID=?";

$stmt = $conn->prepare($qry);
$stmt->bind_param("i", $cid); // "i" - integer
$stmt->execute();

$result = $stmt->get_result();
// Close the statement to release resources
$stmt->close();


echo "<table>";
// Display each category in a row
while ($row = $result->fetch_array()) {
  //echo "<div class='row' style='padding:5px'>"; // Start a new row

  // Left column - display a text link showing the category's name,
  // display category's description in a new paragraph

  echo "<tr>";
  echo "<th colspan='2' style='text-align:center'>";
  $product = "productDetails.php?pid=$row[ProductID]";
  $formattedPrice = number_format($row["Price"], 2);
  //echo "<div class='col-8'>"; // 67% of row width
  echo "<h2><a href=$product>$row[ProductTitle]</a></h2>";
  echo "</th>";
  echo "</tr>";
  echo "<tr>";
  echo "<td>";
  // Right column - display the category's image
  $img = "./Images/products/$row[ProductImage]";
  //echo "<div class='col-4'>"; // 33% of row width
  echo "<img src='$img' />";
  echo "</td>";
  echo "<td>";
  echo "Price: <span style='font-weight: bold; color: red;'>$$formattedPrice</span>";
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






<!-- Create a container, 60% width of viewport -->
<div style='width:60%; margin:auto;'>
<!-- Display Page Header - Category's name is read 
     from the query string passed from previous page -->
<div class="row" style="padding:5px">
	<div class="col-12">
		<span class="page-title"><?php echo "$_GET[catName]"; ?></span>
	</div>
</div>

<?php 
// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php");

// To Do:  Starting ....
// Read Category ID from query string
$cid = $_GET["cid"];

// Form SQL to retrieve list of products associated to the Category ID
$qry = "SELECT p.ProductID, p.ProductTitle, p.ProductImage, p.Price, p.Quantity
        FROM CatProduct cp
        INNER JOIN product p ON cp.ProductID=p.ProductID
        WHERE cp.CategoryID=?";

$stmt = $conn->prepare($qry);
$stmt->bind_param("i", $cid); // "i" - integer
$stmt->execute();

$result = $stmt->get_result();
// Close the statement to release resources
$stmt->close();


// Display each product in a row
while ($row = $result->fetch_array()) {
  echo "<div class='row' style='padding:5px'>"; // Start a new row

  // Left column - display a text link showing the product's name,
  // display the selling price in red in a new paragraph
  $product = "productDetails.php?pid=$row[ProductID]";
  $formattedPrice = number_format($row["Price"], 2);

  echo "<div class='col-8'>"; // 67% of row width
  echo "<p><a href=$product>$row[ProductTitle]</a></p>";
  echo "Price: <span style='font-weight: bold; color: red;'>$$formattedPrice</span>";
  echo "</div>";

  // Right column - display the product's image
  $img = "./Images/products/$row[ProductImage]";
  echo "<div class='col-4'>"; // 33% of row width
  echo "<img src='$img' />";
  echo "</div>";

  echo "</div>"; // End of a row
}
// To Do:  Ending ....

$conn->close(); // Close database connnection
echo "</div>"; // End of container
include("footer.php"); // Include the Page Layout footer
?>
