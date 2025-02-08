<?php
session_start(); // Detect the current session

// Read the data input from previous page
$name = $_POST["name"];
$address = $_POST["address"];
$country = $_POST["country"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$password = $_POST["password"];
$securityqn = $_POST["securityqn"];
$answer = $_POST["answer"];
$birthdate = $_POST["birthdate"];
$active = 1;


// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php");

// Define the INSERT SQL statement
$qry = "INSERT INTO Shopper (Name, Address, Country, Phone, Email, Password, BirthDate, PwdQuestion, PwdAnswer,ActiveStatus,DateEntered)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($qry);
// "ssssss" 6 string parameters

$stmt->bind_param("sssssssssi", $name, $address, $country, $phone, $email, $password, $birthdate, $securityqn, $answer, $active);

if ($stmt->execute()) { // SQL statement executed successfully
    // Retrieve the Shopper ID assigned to the new shopper
    $qry = "SELECT LAST_INSERT_ID() AS ShopperID";

    $result = $conn->query($qry); // Execute the SQL and get the returned result
    while ($row = $result->fetch_array()) {
        $_SESSION["ShopperID"] = $row["ShopperID"];
    }

    // Save the Shopper Name in a session variable
    $_SESSION["ShopperName"] = $name;
    $_SESSION["NumCartItem"] = 0;

} else { // Error message
    $Message = "<h3 style='color: red;'>Error in inserting record</h3>";
}

// Release the resource allocated for prepared statement
$stmt->close();

// Close database connection
$conn->close();

// Display Page Layout header with updated session state and links
include("header.php");
echo '<div class="form-group row" style="text-align:center;"> ';
	    
if (isset($_SESSION["ShopperID"])) {

    echo "<h3>Thank you for registering with us, $name.</h3>";
    echo "<p>You can now start shopping with us.</p>";
    echo '<a href="index.php" style="align-items:left;"><button class="btn btn-primary" type="submit">Continue</button></a>';
} else {
    echo "<h3>Sorry, $name. There was an error in registering you.</h3>";
    echo "<p>Please try again later.</p>";
}
echo '</div>';
// Display Page Layout footer
include("footer.php"); 

?>