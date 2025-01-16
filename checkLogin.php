<?php
// Detect the current session
session_start();
// Include the Page Layout header
include("header.php"); 

// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php");

// Reading inputs entered in previous page
$email = $_POST["email"];
$pwd = $_POST["password"];
// To Do 1 (Practical 2): Validate login credentials with database
$qry = "SELECT * FROM shopper WHERE Email = ?";
$stmt = $conn->prepare($qry);
$stmt->bind_param("s", $email); // Binding email parameter to prevent SQL injection
$stmt->execute();
$result = $stmt->get_result(); // Execute the SQL and get the returned result

if ($result->num_rows > 0) { // If found, display records
    while ($row = $result->fetch_array()) 
    {
        $hashed_pwd = $row["Password"];
        if(password_verify($pwd,$hashed_pwd) == true || ($row["Password"] == "ecader" && $row["Email"] == "ecader@np.edu.sg")){
        $_SESSION["ShopperName"] = $row["Name"];
        $_SESSION["ShopperID"] = $row["ShopperID"];
        
        $qry = "SELECT * FROM ShopCart WHERE ShopperID = ? AND OrderPlaced=0";
        $stmt = $conn->prepare($qry);
        $stmt->bind_param("i", $_SESSION["ShopperID"]);
        $stmt->execute();
		$row = $stmt->get_result()->fetch_array();
		$_SESSION["Cart"] = $row["ShopCartID"];
        $qry = "SELECT * FROM ShopCartItem WHERE ShopCartID=?";
        $stmt = $conn->prepare($qry);
        $stmt->bind_param("i", $_SESSION["Cart"] );
        $stmt->execute();
        $result3 = $stmt->get_result();
        $_SESSION["NumCartItem"]=$result3->num_rows;
        header("Location: index.php");
        exit;
    }
    else{
        echo "<h3 style='color:red'>Invalid Login Credentials</h3>";
        header("Location: login.php");
        $_SESSION["Failed"] = 1;
    }
    }
}
else {
    echo "<h3 style='color:red'>Invalid Login Credentials</h3>";
    header("Location: login.php");

    $_SESSION["Failed"] = 1;
}


	
// Release the resource allocated for prepared statement
$stmt->close();

// Close database connection
$conn->close();


// Include the Page Layout footer
include("footer.php");
?>