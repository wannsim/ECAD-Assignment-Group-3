<?php 
session_start(); // Detect the current session
include("header.php"); // Include the Page Layout header
?>
<!-- Create a cenrally located container -->
<div style="width:80%; margin:auto;">
<form method="post">
	<div class="form-group row">
		<div class="col-sm-9 offset-sm-3">
			<span class="page-title">Forget Password</span>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 col-form-label" for="eMail">
         Email Address:</label>
		<div class="col-sm-9">
			<input class="form-control" name="eMail" id="eMail"
                   type="email" required />
		</div>
	</div>
	<div class="form-group row">      
		<div class="col-sm-9 offset-sm-3">
			<button type="submit">Submit</button>
		</div>
	</div>
</form>

<?php 
// Process after user click the submit button
if (isset($_POST["eMail"])) {
	// Read email address entered by user
	$eMail = $_POST["eMail"];
	// Retrieve shopper record based on e-mail address
	include_once("mysql_conn.php");
	$qry = "SELECT * FROM Shopper WHERE Email=?";
	$stmt = $conn->prepare($qry);
	$stmt->bind_param("s", $eMail); 	// "s" - string 
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
	if ($result->num_rows > 0) {
		$row= $result ->fetch_array();
		$shopperid = $row["ShopperID"] ;
		$new_pwd = "password"; //Default password
		// Hash the default password
		$hashed_pwd = password_hash($new_pwd,PASSWORD_DEFAULT);
		$qry = "UPDATE Shopper SET Password=? WHERE ShopperID=?" ;
		$stmt = $conn->prepare($qry);
		// "s" - string, llill - integer
		$stmt->bind_param( "si" , $hashed_pwd, $shopperid);
		$stmt->execute();
		$stmt->close();
		include ( "myMail.php" ) ;
		//The "Send To" should be the e-mail address indicated
		//by shopper, i.e $eMail. In t his case, use a testing e-mail
		//address as the shopper's e-mail add r ess in our database
		//may not be a valid account.
		$to="ecadtut@gmail.com" ; // use the gmail account cr eated
		$from= "ecadtut@gmail.com" ; // use the gmail account created
		$from_name="Mamaya e-BookStore" ;
		$subject= "Mamaya e-BookStore Login Password" ; // e-mail title
		//HTML body message
		$body= "<span style='color:black; font-size:12px ' >
		Your new password is <span style='font-weight : bold' >
		$new_pwd</span>.<br/>
		Do change this default password. </span>";
		//Initiate the e-mailing sending process
		if (smtpmailer ($to, $from, $from_name, $subject, $body )) {
		echo "<p>Your new password is sent to:
		<span style='font-weight:bold'>$to </span>.</p>";
		}
		else {
		echo "<p><span style='color:red; '>
		Mailer Error: ".$error."</span></p>";
		}
	}
	else {
		echo "<p><span style='color:red;'>
		      Wrong E-mail address!</span></p>";
	}
	$conn->close();
}
?>

</div> <!-- Closing container -->
<?php 
include("footer.php"); // Include the Page Layout footer
?>