<?php
session_start();
include("header.php"); 

// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php");

// Reading inputs entered in previous page
$email = $_POST["email"];
$pwd = $_POST["password"];

if ($email=="admin@admin.com" && $pwd=="admin") {
    $_SESSION["ShopperName"] = "Admin";
    header("Location: admin.php");
    exit;
}
$qry = "SELECT * FROM shopper WHERE Email = ?";
$stmt = $conn->prepare($qry);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result(); 

if ($result->num_rows > 0) { // If found, display records
    while ($row = $result->fetch_array()) 
    {
        if($row["Password"] == $pwd && $row["ActiveStatus"] == 1)
        {
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

$stmt->close();
$conn->close();

include("footer.php");
?>