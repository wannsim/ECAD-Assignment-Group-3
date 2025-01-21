<?php 
session_start(); // Detect the current session
include("header.php"); // Include the Page Layout header
include_once("mysql_conn.php"); // Include the PHP file that establishes database connection handle: $conn
echo "<style>
		th {
            background-color:black; /* Adds a background color to the headings */
        }
		
	@media (max-width: 852px) {
    table td, tr {
        display: inline;
		padding:0;
		border: 1px;
    }
		th,td{
		padding: 10px;
		text-align: center;
		font-size:15px;
		width:100%;}
}
</style>";
if(isset($_SESSION["OrderID"])) {	
	
	$qry = "SELECT * FROM orderdata WHERE OrderID=?";
	$stmt = $conn->prepare($qry);

	$stmt->bind_param("i", $_SESSION["OrderID"]);
	$stmt->execute();

	$result = $stmt->get_result();
	$stmt->close(); 
	$row = $result->fetch_array();
	echo "<div class='container'><p>Checkout successful. Your order number is $_SESSION[OrderID]</p>";
	echo "<p>Order Date: ".$row['DateOrdered']."</p>";
	echo "<p>Order Total: ".$_SESSION["Total"]."</p>";
	echo "<p>Shipping Address: ".$row['ShipAddress']."</p>";
	echo "<p>Shipping Country: ".$row['ShipCountry']."</p>";
	echo "<table style= 'width:100%;'><tr><th>Quantity</th><th>Price</th><th>Product</th></tr>";
	foreach($_SESSION['Items']  as $key=>$item) 
	{
		echo '<tr>';
		echo '<td>'.$item["quantity"].'</td>';
		echo '<td>S$'.number_format($item["price"],2).'</td>';
		echo '<td>'.$item["name"].'</td>';
		echo '</tr>';
	}
	echo "</table><br>";
	echo "<p>Thank you for your purchase.</p>";
	echo '<a href="index.php">Continue shopping</a></div>';}


include("footer.php"); // Include the Page Layout footer
?>
