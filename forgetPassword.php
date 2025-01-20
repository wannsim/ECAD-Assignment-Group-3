<?php 
session_start(); // Detect the current session
include("header.php"); // Include the Page Layout header
if (!isset($_SESSION["checkemail"])) {
    // If no email has been submitted, display the first form
    echo '<div style="width:80%; margin:auto;">
    <form id="form1" method="post">
        <div class="form-group row">
            <div class="col-sm-9 offset-sm-3">
                <span class="page-title">Forget Password</span>
            </div>
        </div>
        <br>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for="email">
                Email:
            </label>
            <div class="col-sm-9">
                <input class="form-control" name="email" id="email" type="email" required />
            </div>
        </div>
        <br>
        <div class="form-group row">
            <div class="col-sm-9 offset-sm-3">
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
        </div>
    </form></div><br>';
}
// Process after user click the submit button
if (isset($_POST["email"])) {
	// Read email address entered by user
	$eMail = $_POST["email"];
	// Retrieve shopper record based on e-mail address
	include_once("mysql_conn.php");
	$qry = "SELECT * FROM Shopper WHERE Email=?";
	$stmt = $conn->prepare($qry);
	$stmt->bind_param("s", $eMail); 	// "s" - string 
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
	if ($result->num_rows > 0) {
		$_SESSION["checkemail"] = $eMail;
		
		$row= $result ->fetch_array();
		$_SESSION["question"] = $row["PwdQuestion"];
		$_SESSION["answer"] = $row["PwdAnswer"];
		$_SESSION["checkpassword"] = $row["Password"];
		header("Location: securityquestion.php");
		
	}
	else {
		echo "<p><span style='color:red; text-align:center; font-size:20px;'>
		      Wrong E-mail address!</span></p>";
	}
	
}


?>

</div> <!-- Closing container -->
<?php 
include("footer.php"); // Include the Page Layout footer
?>