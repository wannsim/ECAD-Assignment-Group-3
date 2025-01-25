<?php 
session_start(); // Detect the current session
include("header.php"); // Include the Page Layout header
include_once("mysql_conn.php"); // Include the PHP file that establishes database connection handle: $conn
echo "<style>
    body {
        font-family: Arial, sans-serif;
    }
    .container {
        max-width: 1200px;
        margin: auto;
        padding: 15px;
    }
    th {
        background-color: black;
        color: white;
        padding: 10px;
        text-align: left;
    }
    td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    @media (max-width: 852px) {
        table {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }
        th, td {
            font-size: 14px;
            padding: 8px;
        }
        .container p, .container a {
            font-size: 16px;
        }
    }
    @media (max-width: 500px) {
        th, td {
            font-size: 12px;
        }
        .container p, .container a {
            font-size: 14px;
        }
    }
</style>";
/* $_SESSION["OrderID"]=8; */
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
	echo "<p>Order Total: S$".$_SESSION["Total"]."</p>";
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
	echo '<a class="btn btn-primary" href="index.php">Continue shopping</a></div>';}


include("footer.php"); // Include the Page Layout footer
?>
