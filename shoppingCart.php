<?php 
session_start();
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
			border: 1px solid #ddd;
            margin: 50px; /* 50px margin around the container */
			transition: box-shadow 0.3s ease;
        }
		.product-container:hover {
    		box-shadow: 0 8px 20px rgba(249, 249, 249, 0.6); /* Larger and darker shadow */
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
			max-width:50%;
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
		.checkout-container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px; /* Increased padding */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px; /* Increased width */
            margin: 0 auto;
			margin-left: auto; /* Aligns the container to the right */
            margin-right: 50px;  /* Removes any left margin */
			height:auto;
        }
        .checkout-header {
            font-size: 18px; /* Larger font size */
            font-weight: bold;
            margin-bottom: 30px; /* More margin */
        }
        .checkout-input {
            width: 100%;
            padding: 12px; /* Increased padding */
            margin: 15px 0; /* More margin */
            font-size: 16px; /* Larger font size */
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .checkout-row {
            display: flex;
            justify-content: space-between;
            margin: 20px 0; /* More margin */
        }
        .checkout-row span {
            font-size: 16px; /* Larger font size */
        }
        .checkout-total {
            font-size: 22px; /* Larger font size */
            font-weight: bold;
            margin-top: 30px; /* More margin */
        }
        .apply-btn {
            padding: 12px 24px; /* Larger button */
            background-color: #5cb85c;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px; /* Larger font size */
        }
        .apply-btn:hover {
            background-color: #4cae4c;
        }
    </style>";
// Include the code that contains shopping cart's functions.
// Current session is detected in "cartFunctions.php, hence need not start session here.
include_once("cartFunctions.php");
include("header.php"); // Include the Page Layout header

if (!isset($_SESSION["ShopperID"])) { // Check if user logged in 
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
    Product.*, 
    ShopCartItem.price AS ShopCartPrice, 
    ShopCartItem.quantity AS ShopCartQuantity,
	(ShopCartItem.quantity*ShopCartItem.price) AS Total
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
		$total_quantity = 0;
		while ($row = $result->fetch_array()) {
			$offerStartDate = new DateTime($row['OfferEndDate']); // Convert to DateTime object
			$today = new DateTime(); 
			$dateDiff = $today->diff($offerStartDate);
			$daysDifference = (int)$dateDiff->format("%r%a"); // %r includes the sign (+/-)
			$img = "./Images/products/$row[ProductImage]";
			$product = "productDetails.php?pid=$row[ProductID]";
			$total_quantity += $row["ShopCartQuantity"];

			echo '<div class="product-container">';
			echo '<a href="' . $product .'" class="product-link" style="text-decoration: none; color: inherit;">';
			echo '    <div class="product-image">';
			echo '        <img src="' . $img . '" alt="Product Image" style = "margin-left:30px">';
			echo '    </div>';
			echo '</a>';
			echo '    <div class="product-details" style = "text-align:left">';
			echo '        <h3>' . $row["ProductTitle"] .'</h3>';
			echo '        <h2 style = "margin-top:20px">' . $row["ProductDesc"] . '</h2>';
			if ($row["Offered"] == 1 && $daysDifference >= 0){
				echo '<h5 style = "margin-top:50px">$' . $row["OfferedPrice"] . "</h5>";
				echo '<h6 style = "text-decoration: line-through;">$' . $row["Price"] . "</h6>";
				echo '<p style="margin-top: 50px; background-color: green; color: white; padding: 10px; width: fit-content; border-radius: 5px;">Save ' . round(($row["Price"] - $row["OfferedPrice"]) / $row["Price"] * 100 / 10) * 10 . "%</p>";
				echo "<p style = 'color:red'>$daysDifference days left !</p>";
			}
			else{
				echo '<h5 style = "margin-top:50px">$' . $row["Price"] . "</h5>";
			}
			echo '    </div>';
			echo '    <div class="product-actions">'; // quantity
			echo '        <div class="quantity">';
			echo '<form id="cart-form" method="post" action="cartFunctions.php">';
			echo '    <div class="quantity">';
			echo '<input ';
			echo '            type="number" ';
			echo '            id="quantity" ';
			echo '            name="quantity" ';
			echo '            value="' . $row["ShopCartQuantity"] . '" ';
			echo '            data-max-quantity="' . $row["Quantity"] . '" ';
			echo '            oninput="checkQuantity(this)"'; // Add validation for numeric input
			echo '            style="height:30px;width:100px"';
			echo '        />';
			echo '    </div>';
			echo '    <input type="hidden" name="product_id" value="' . $row["ProductID"] . '">';
			echo '    <input type="hidden" name="action" value="update">';
			echo '    <p>In stock: ' . $row["Quantity"] . '</p>';
			echo '</form>';
			echo '    </div>';
			echo '<script>';
			echo '    // Function to check the entered quantity';
			echo '    function checkQuantity(input) {';
			echo '        var min = parseInt(input.getAttribute("min"));';
			echo '        var max = parseInt(input.getAttribute("max"));';
			echo '        var value = parseInt(input.value);';
			echo '        if (value < min) {';
			echo '            input.value = min;';
			echo '        } else if (value > max) {';
			echo '            input.value = max;';
			echo '        }';
			echo '    }';
			echo '</script>';
			$final_price;
			if ($row["Offered"] == 1 && $daysDifference >= 0){
				$final_price = $row["OfferedPrice"];
			}
			else{
				$final_price = $row["Price"];
			}
			$subtotal = $final_price*$row["ShopCartQuantity"];
			$subTotal += $subtotal;
			echo "<div class='price'>S$".number_format ($subtotal,2);
			echo "</div>";
			echo "<form action = 'cartFunctions.php' method = 'post'>";
			echo "<input type = 'hidden' name = 'action' value = 'remove' />";
			echo "<input type = 'hidden' name = 'product_id' value = '$row[ProductID]' />";
			echo "<input type = 'image' src = 'images/trash-can.png' title = 'Remove Item'/>";
			echo "</form>";
			echo '</div>';
			echo '</div>';

			
			/*$_SESSION["Items"][]=array("productId"=>$row["ProductID"],
			"name"=>$row["ProductTitle"],
			"price"=>$row["Price"],
			"quantity"=>$row["Quantity"]);
			// Accumulate the running sub-total
			$subTotal += $row["Total"];*/
		}
		$qry = "SELECT *
				FROM gst
				WHERE EffectiveDate <= NOW()
				ORDER BY EffectiveDate DESC
				LIMIT 1;";
		$stmt = $conn->prepare($qry) ;
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		$tax_rate;
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_array()) {
				$tax_rate = $row["TaxRate"];
				$_SESSION["Tax"] = round($subTotal*($row["TaxRate"]/100),2);
			}
		}
		echo '    <div class="checkout-container" style = "color:black">';
		echo '        <div class="checkout-row">';
		echo '            <span></span>';
		echo "            <span><b>Total in Cart ($total_quantity items)</b></span>";
		echo '        </div>';
		echo '        <div class="checkout-row">';
		echo '            <span>Subtotal</span>';
		echo "            <span>S$".number_format($subTotal,2);
		echo " 			  </span>";
		echo '        </div>';
		echo '        <div class="checkout-row">';
		echo "            <span>GST($tax_rate%)</span>";
		echo "            <span>S$".number_format($_SESSION["Tax"],2);
		echo " 			  </span>";
		echo '        </div>';
		if ($subTotal >= 200){
			$_SESSION["ShipCharge"] = 0.00;
			echo '        <div class="checkout-row">';
			echo '            <span>Shipping</span>';
			echo "            <span>(Free Shipping) S$".number_format(0,2);
			echo "</span>";			echo '        </div>';
		}
		else{
			$_SESSION["ShipCharge"] = 10.00;
			echo '        <div class="checkout-row">';
			echo '            <span>Shipping</span>';
			echo "            <span>S$".number_format(10,2);
			echo " 			  </span>";			echo '        </div>';
		}
		echo '        <div class="checkout-row checkout-total">';
		echo '            <span>Total</span>';
		echo "            <span>S$".number_format($subTotal + $_SESSION["Tax"] + $_SESSION["ShipCharge"],2);
		echo " 			  </span>";			echo '        </div>';


		echo '        <div style="text-align: right;">';
		echo "<form method='post' action='checkoutProcess.php'>";
		echo "<input type='image' style='float:right;'
		src=' https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif'>";
		echo " </form></p>";	
		echo '        </div>';


		echo '    </div>';

	
		$_SESSION["SubTotal"] = round($subTotal,2);
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
