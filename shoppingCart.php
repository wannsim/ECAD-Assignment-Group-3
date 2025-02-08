<?php 
include_once("cartFunctions.php");
include("header.php"); // Include the Page Layout header
if (!isset($_SESSION["ShopperID"])) { // Check if user logged in 
	// redirect to login page if the session variable shopperid is not set
	header ("Location: login.php");
	exit;
}
// Include the code that contains shopping cart's functions.
// Current session is detected in "cartFunctions.php, hence need not start session here.

echo "  <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }
        .breadcrumb {
            margin: 20px 0;
            font-size: 14px;
			text-align: center;
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
            margin: 30px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
			text-align: center;
        }
        .cart-image {
            width: 150px;
            margin: auto;
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
/*         .quantity {
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
        } */
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
            font-size: 16px;s /* Larger font size */
        }
        .apply-btn:hover {
            background-color: #4cae4c;
        }
			#title{
				margin-top:-10px;
			}
		b{
		font-size:0px;}
		@media(max-width:600px) {
			.product-container{
				flex-direction: column;
			}
			.checkout-container {
				margin-left:50px;
			}
			.product-image img{
			width: 100%;
			}
			#title{
				margin-top:-80px;
			}
		}
    .container1{
    border-radius:15px;
    display:flex;
    justify-content:right;
    }
    input[type='number']{
        -moz-appearance: textfield;
        text-align: center;
        border:none;
        font-size:25px;
		background-color: var(--green-color);
		color:white;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin:0;
    }

    button{
        color:white;
        background-color:var(--green-color);
        border:none;
        font-size: 25px;
        cursor:pointer;
    }

    #decrement{
        padding: 5px 0px 5px 10px;
        border-radius: 30px 0 0 30px;
    }
    #increment{
        padding: 5px 10px 5px 0px;
        border-radius: 0 30px 30px 0;
    }
    </style>";


echo "<div id='myShopCart' style='margin:auto'>"; // Start a container
if (isset($_SESSION["Cart"])) {
	include_once("mysql_conn.php");

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
	$stmt->bind_param("i",$_SESSION["Cart"]) ; 
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
	if ($result->num_rows > 0) {
		echo '<h1 id="title" style = " text-align:center">Shopping Cart</h1>';
		$_SESSION["Items"]=array();
		$subTotal = 0; // Declare a variable to compute subtotal before tax
		$total_quantity = 0;
		$discount = 0;
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
				echo '<h5 style = "margin-top:50px">$' . number_format($row["OfferedPrice"],2) . "</h5>";
				echo '<h6 style = "text-decoration: line-through;">$' . number_format($row["Price"],2) . "</h6>";
				echo '<p style="margin-top: 50px; background-color: green; color: white; padding: 10px; width: fit-content; border-radius: 5px;">Save ' . round(($row["Price"] - $row["OfferedPrice"]) / $row["Price"] * 100 / 10) * 10 . "%</p>";
				echo "<p style = 'color:red'>$daysDifference days left !</p>";
			}
			else{
				echo '<h5 style = "margin-top:50px">$' . number_format($row["Price"],2) . "</h5>";
			}
			echo '    </div>';
			echo '    <div class="product-actions">'; // quantity
			echo '        <div class="quantity">';
			echo '<form id="cart-form" method="post" action="cartFunctions.php">';
			
			
			echo "<div class='container1'>";
			echo "<span style='position: relative;top: 16;
			right: 10; font-size: 20px;'>Quantity: </span>";
			echo "<button id='decrement' onclick='stepper(this)' style='font-size: 35px;'> - </button>";
			echo '<input onChange="this.form.submit()"';
			echo '            type="number" ';
			echo '            id="my-input" ';
			echo '            name="quantity" min="1" ';
			echo '            value="' . $row["ShopCartQuantity"] . '" ';
			echo '            max="' . $row["Quantity"] . '" ';
			echo '            oninput="checkQuantity(this)"'; // Add validation for numeric input
			echo '            step="1" style="font-size: 30px"';
			echo '        />';
			echo "<button id='increment' onclick='stepper(this)' style='font-size: 30px;'> + </button>";
			echo "</div>";
			

		
			echo '    <input type="hidden" name="product_id" value="' . $row["ProductID"] . '">';
			echo '    <input type="hidden" name="action" value="update">';
			echo '   <br> <p style="text-align:center;font-size: 20px;">In stock: ' . $row["Quantity"] . '</p>';
			echo '</form>';
			echo '    </div>';
			echo "<script>";
			echo "const myInput = document.getElementById('my-input');";
			echo "function stepper(btn) {";
			echo "let id = btn.getAttribute('id');";
			echo "let min = myInput.getAttribute('min');";
			echo "let max = myInput.getAttribute('max');";
			echo "let step=myInput.getAttribute('step');";
			echo "let value = myInput.getAttribute('value');";
			echo "let calcStep=(id=='increment')?(step*1):(step*-1);";
			echo "let newValue = parseInt(value) + calcStep;";
			echo "if(newValue >= min && newValue <= max){";
			echo "myInput.setAttribute('value', newValue);}}";
			echo "</script>";
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
				$final_price = number_format($row["OfferedPrice"],2);
				$discount += number_format($row["Price"] - $row["OfferedPrice"],2)*$row["ShopCartQuantity"];
			}
			else{
				$final_price = number_format($row["Price"],2);
			}
			$subtotal = $final_price*$row["ShopCartQuantity"];
			$subTotal += $subtotal;
			echo "<div class='price'>S$".number_format ($subtotal,2);
			echo "</div>";
			echo "<form id='removeform' action = 'cartFunctions.php' method = 'post'>";
			echo "<input type = 'hidden' name = 'action' value = 'remove' />";
			echo "<input type = 'hidden' name = 'product_id' value = '$row[ProductID]' />";
			echo "<input type = 'image' src = 'images/trash-can.png' title = 'Remove Item'/>";
			echo "</form>";
			echo '</div>';
			echo '</div>';

			
			$_SESSION["Items"][]=array("productId"=>$row["ProductID"],
			"name"=>$row["ProductTitle"],
			"price"=>$final_price,
			"quantity"=>$row["ShopCartQuantity"]);
		}
		$_SESSION["SubTotal"] = round($subTotal,2);
		$_SESSION["Discount"] = round($discount,2);
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
		echo '        <div class="checkout-row">';
		echo "            <span>Total Discount</span>";
		echo "            <span>Save: S$".number_format($_SESSION["Discount"],2)."</span>";
		echo '        </div>';
		echo '<form method="post" action="checkoutProcess.php">';
		
		if ($subTotal >= 200){
			$_SESSION["ShipCharge"] = 0.00;
			echo '        <div class="checkout-row">';
			echo '            <span>Delivery Mode<p style="font-size:13px;color:red;">(Express Delivery - Delivery within 24 hours)</p></span>';
			echo '           <span>Express Shipping</span>';
			echo '        </div>';
			echo '        <div class="checkout-row">';
			echo '            <span>Shipping</span>';
			echo "            <span>(Free Shipping) S$".number_format(0,2);
			echo "</span>";			
			echo '        </div>';
		}
		else{
			$formSubmitted = false; // Track if form was submitted
			if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delivery'])) {
				$_SESSION["ShipCharge"] = (float)$_POST["delivery"];
				$formSubmitted = true; // Mark form as submitted
			} 
			else {
				// Set a default ShipCharge if not already set
				$_SESSION["ShipCharge"] = 10.00; // Default value
			}
			echo "
			<script>
			function shipcharge() {
				// Get the selected value from the dropdown
				const shipCharge = document.getElementById('delivery').value;

				// Update the text dynamically
				document.getElementById('shipcharge').innerHTML = 'S$' + parseFloat(shipCharge).toFixed(2);
				document.getElementById('total').innerHTML = 'S$' + (parseFloat($subTotal) + parseFloat(shipCharge) + parseFloat(".$_SESSION["Tax"].")).toFixed(2);
			}
			</script>";
			echo '        <div class="checkout-row">';
			echo '   <span style="text-align:left;">Delivery Mode <p style="font-size:12px;color:red;">(Normal Delivery- Delivery within 2 working days)<br>(Express Delivery - Delivery within 24 hours)</p></span>';
			echo '    <select name="delivery" id="delivery" onchange="shipcharge();">';
			echo '            <option value="5"' . ($_SESSION["ShipCharge"] == 5 ? ' selected' : '') . '>Normal Delivery</option>';
			echo '            <option value="10"' . ($_SESSION["ShipCharge"] == 10 ? ' selected' : '') . '>Express Delivery</option>';
			echo '    </select>';
			echo '        </div>';
			echo '        <div class="checkout-row" id="deliverySection">';
			echo '            <span>Shipping</span>';
			echo "            <span id='shipcharge'>S$".number_format($_SESSION["ShipCharge"],2);
			echo " 			  </span>";			
			echo '        </div>';
		}
		echo '        <div class="checkout-row">';
		echo '            <span>Preferred Delivery Time</span>';
		echo '    <select name="time">';
		echo '		  <option value=""><--Select--></option>';
		echo '        <option value="1">9 am - 12 noon</option>';
		echo '        <option value="2">12 noon - 3pm</option>';
		echo '        <option value="3">3pm - 6pm</option>';
		echo '    </select>';
		echo '        </div>';
		echo '        <div class="checkout-row">';
		echo '            <span>Message</span>';
		echo '           <span> <input type="text" size="12" placeholder="Enter message" name="message"/>';
		echo " 			  </span>";			
		echo '        </div>';
		echo '        <div class="checkout-row checkout-total">';
		echo '            <span>Total</span>';
		echo "            <span id='total'>S$".number_format($subTotal + $_SESSION["Tax"] + $_SESSION["ShipCharge"],2);
		echo " 			  </span>";			
		echo '        </div>';
		$_SESSION["Total"] = round($subTotal + $_SESSION["Tax"] + $_SESSION["ShipCharge"],2);
		echo '        <div style="text-align: right;">';
		echo "<input type='image' style='float:right;'
		src=' https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif'>";
		echo '        </div>';
		echo " </form>";	


		echo '    </div>';

	
		$_SESSION["SubTotal"] = round($subTotal,2);
	}
	else {
		// when shopping cart is empty
		echo '<h1 style = "margin-top : -10px; text-align:center">Shopping Cart</h1>';
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
	echo '<h1 style = "margin-top : -10px; text-align:center">Shopping Cart</h1>';
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
echo "</div><br><br>"; // End of container
include("footer.php"); // Include the Page Layout footer

?>
