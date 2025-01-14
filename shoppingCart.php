<?php 
echo "  <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
            text-align: center;
        }
        .breadcrumb {
            margin: 20px 0;
            font-size: 14px;
        }
        .breadcrumb a {
            color: #007BFF;
            text-decoration: none;
        }
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        .cart-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .cart-image {
            width: 300px;
            margin: 75px auto;
        }
        .cart-message {
			color: black;
            font-size: 18px;
            margin: 20px 0;
        }
        .return-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }
        .return-button:hover {
            background-color: #0056b3;
        }
		.product-container {
			color:black;
            display: flex;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: calc(100% - 100px); /* Adjust for 50px margin on both sides */
            padding: 50px;
            border-radius: 10px;
            margin: 50px; /* 50px margin around the container */
        }
        .product-image {
            flex: 0 0 150px;
            margin-right: 50px;
        }
        .product-image img {
            width: 250px;
            border-radius: 8px;
        }
        .product-details {
            flex-grow: 1;
        }
        .product-details h2 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }
        .product-details p {
            color: #777;
            font-size: 14px;
        }
        .product-options {
            margin-top: 20px;
        }
        .product-options label {
            font-size: 14px;
            color: #333;
        }
        .product-options select,
        .product-options input {
            padding: 5px;
            margin-top: 5px;
            font-size: 14px;
        }
        .product-actions {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: flex-end;
        }
        .quantity {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .quantity button {
            padding: 5px;
            background-color: #ddd;
            border: none;
            cursor: pointer;
        }
        .quantity input {
            width: 40px;
            text-align: center;
            border: 1px solid #ccc;
            margin: 0 5px;
        }
        .price {
            font-size: 18px;
            font-weight: bold;
        }
        .remove {
            color: #e74c3c;
            cursor: pointer;
        }
    </style>";
// Include the code that contains shopping cart's functions.
// Current session is detected in "cartFunctions.php, hence need not start session here.
include_once("cartFunctions.php");
include("header.php"); // Include the Page Layout header

if (! isset($_SESSION["ShopperID"])) { // Check if user logged in 
	// redirect to login page if the session variable shopperid is not set
	header ("Location: login.php");
	exit;
}

echo "<div id='myShopCart' style='margin:auto'>"; // Start a container
if (isset($_SESSION["Cart"])) {
	include_once("mysql_conn.php");
	// To Do 1 (Practical 4): 
	// Retrieve from database and display shopping cart in a table
	$qry = "SELECT 
    ShopCartItem.*, 
    (ShopCartItem.Price * ShopCartItem.Quantity) AS Total, 
    Product.ProductImage, 
    Product.ProductDesc 
FROM 
    ShopCartItem 
INNER JOIN 
    Product ON ShopCartItem.ProductID = Product.ProductID 
WHERE 
    ShopCartItem.ShopCartID = ?";
	$stmt = $conn->prepare($qry) ;
	$stmt->bind_param("i",$_SESSION["Cart"]) ; //"i" - integer
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
	/* Things to compelte:
		1. The quantity buttons
		2. The quantity checker (display like bricklink)
		3. Show discount (strike and days left for discount)
	*/
	if ($result->num_rows > 0) {
		// To Do 2 (Practical 4): Format and display 
		// the page header and header row of shopping cart page
		echo "<p class='page-title' style='text-align:center'>Shopping Cart</p>"; 
		// To Do 5 (Practical 5):
		// Declare an array to store the shopping cart items in session variable 
		$_SESSION["Items"]=array();
		// To Do 3 (Practical 4): 
		// Display the shopping cart content
		$subTotal = 0; // Declare a variable to compute subtotal before tax
		while ($row = $result->fetch_array()) {
			$img = "./Images/products/$row[ProductImage]";

			echo '<div class="product-container">';
			echo '    <div class="product-image">';
			echo '        <img src="' . $img . '" alt="Product Image" style = "margin-left:50px">';
			echo '    </div>';
			echo '    <div class="product-details" style = "text-align:left">';
			echo '        <h3>' . $row["Name"] .'</h3>';
			echo '        <h2 style = "margin-top:20px">' . $row["ProductDesc"] . '</h2>';
			echo '    </div>';
			echo '    <div class="product-actions">'; // quantity
			echo '        <div class="quantity">';
			echo '<form id="cart-form" method="post" action="cartFunctions.php">';
			echo '    <div class="quantity">';
			echo '        <button type="button" id="decrease">-</button>';
			echo '        <input type="text" id="quantity" name="quantity" value="1" />';
			echo '        <button type="button" id="increase">+</button>';
			echo '    </div>';
			echo '    <input type="hidden" name="product_id" value="'$row["ProductID"]'">';  // add checker for quantity also
			echo '    <input type="hidden" name="action" value="update">'; // Action to identify the request
			echo '</form>';
			echo '    </div>';
			echo '        <div class="price">$59.95</div>'; //  add the discounted thing here
			echo "<form action = 'cartFunctions.php' method = 'post'>";
			echo "<input type = 'hidden' name = 'action' value = 'remove' />";
			echo "<input type = 'hidden' name = 'product_id' value = '$row[ProductID]' />";
			echo "<input type = 'image' src = 'images/trash-can.png' title = 'Remove Item'/>";
			echo '    </div>';
			echo '</div>';



			/*
			echo "<tr>";
			echo "<td style='width:50%'>$row[Name] <br />";
			echo "Product ID: $row[ProductID] </td>";
			$formattedPrice = number_format($row["Price"], 2) ;
			echo "<td>$formattedPrice</td>" ;
			echo "<td>"; // Column for update quantity of purchase
			echo "<form action='cartFunctions.php' method='post'>";
			echo "<select name='quantity' onChange='this.form.submit()'>";
			for ($i = 1; $i <= 10; $i++) { // To populate drop -down list from 1 to 10
			if ($i == $row["Quantity"])
			// Select drop-down list item with value same as the quantity of pu r chase
				$selected = "selected" ;
			else
				$selected = "" ; // No specific item i s selected
			echo "<option value='$i' $selected>$i</option>";
			}
			echo "</select>";
			echo "<input type='hidden' name='action' value='update' /> ";
			echo "<input type='hidden' name='product_id' value='$row[ProductID]' /> " ;
			echo "</form>";
			echo "</td>";
			$formattedTotal = number_format ($row["Total"], 2) ;
			echo "<td>$formattedTotal</td >";
			echo "<td>"; // Column for remove item from shopping cart
			echo "<form action='cartFunctions.php' method='post'>";
			echo "<input type='hidden' name='action' value='remove' /> ";
			echo "<input type='hidden' name='product_id' value='$row[ProductID]' />" ;
			echo "<input type='image' src='images/trash-can.png' title='Remove Item'/> ";
			echo "</form>";
			echo "</td>";
			echo "</tr>";*/
			// To Do 6 (Practical 5):
		    // Store the shopping cart items in session variable as an associate array
			$_SESSION["Items"][]=array("productId"=>$row["ProductID"],
			"name"=>$row["Name"],
			"price"=>$row["Price"],
			"quantity"=>$row["Quantity"]);
			// Accumulate the running sub-total
			$subTotal += $row["Total"];
		}
		echo "</tbody>"; // End of table's body section
		echo "</table>"; // End of table
		echo "</div>"; // End of Bootstrap responsive table
		
		// To Do 4 (Practical 4): 
		// Display the subtotal at the end of the shopping cart
		echo "<p style='text-align : right; font-size:20px'>
		Subtotal= S$".number_format ($subTotal,2);
		$_SESSION["SubTotal"] = round($subTotal,2);
		// To Do 7 (Practical 5):
		// Add PayPal Checkout button on the shopping cart page
		echo "<form method='post' action='checkoutProcess.php'>";
		echo "<input type='image' style='float:right;'
		src=' https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif'>";
		echo " </form></p>";	
	}
	else {
		// when shopping cart is empty
		echo '<h1 >Shopping Cart</h1>';
		echo '<div class="breadcrumb">';
		echo '<a href="index.php" style = "color:white">Home</a> \\ <a href="shoppingcart.php" style = "color:white"> Shopping Cart</a>';
		echo '</div>';
		echo '<div class="cart-container">';
		echo '<img src="Images/ShoppingCartCart.png" alt="Shopping Cart" class="cart-image">';
		echo '<h2 class="cart-message"><b>YOUR CART IS CURRENTLY EMPTY!</b></h2>';
		echo '<p class = "cart-message">Add an item to your shopping cart before proceeding to checkout!</p>';
		echo '<a href="index.php" class="return-button">Continue Browsing</a>';
		echo '</div>';
	}
	$conn->close(); // Close database connection
}
else {
// when shopping cart is empty
	echo '<h1 style = "margin-top : 50px">Shopping Cart</h1>';
	echo '<div class="breadcrumb">';
	echo '<a href="index.php" style = "color:white">Home</a> \\ <a href="shoppingcart.php" style = "color:white"> Shopping Cart</a>';
	echo '</div>';
	echo '<div class="cart-container">';
	echo '<img src="Images/ShoppingCartCart.png" alt="Shopping Cart" class="cart-image">';
	echo '<h2 class="cart-message"><b>YOUR CART IS CURRENTLY EMPTY!</b></h2>';
	echo '<p class = "cart-message">Add an item to your shopping cart before proceeding to checkout!</p>';
	echo '<a href="index.php" class="return-button">Continue Browsing</a>';
	echo '</div>';
}
echo "</div>"; // End of container
include("footer.php"); // Include the Page Layout footer
?>
