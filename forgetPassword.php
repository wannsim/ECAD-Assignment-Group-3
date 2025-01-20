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
    </form></div>';
} else {
	if(isset($_SESSION["password"])){
		$password = $_SESSION["password"];
		echo "<p><span text-align:center; font-size:20px;'>Your password is".$password." </span></p>";
	}
	else{
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
					<input class="form-control" name="email" id="email" type="email" value="' . htmlspecialchars($_SESSION["checkemail"]) . '" readonly />
				</div>
			</div>
			<br>
		</form></div>';
	}
    // If the email has been submitted, make the first form read-only
    
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
		$shopperid = $row["ShopperID"] ;
		$_SESSION["security_answer"] = $row["PwdAnswer"];
		$_SESSION["password"] = $row["Password"];
		echo '<div style="width:80%; margin:auto;">
		<form id="form2" method="post">
	
	<div class="form-group row">
		<label class="col-sm-3 col-form-label" for="eMail">
         Security Question: </label>
		<div class="col-sm-9">
			<input class="form-control" name="question" id="question" type="text" value="'.$row["PwdQuestion"].'" readonly />
                    
		</div>
	</div>
	<br>
	<div class="form-group row">
		<label class="col-sm-3 col-form-label" for="answer">
         Answer: </label>
		<div class="col-sm-9">
			<input class="form-control" name="answer" id="answer" type="text" required />
		</div>
	</div>
	<br>
	<div class="form-group row">      
		<div class="col-sm-9 offset-sm-3">
			<button class="btn btn-primary" type="submit">Submit</button>
		</div>
	</div>
</form></div>';
		
		/* $new_pwd = "password"; //Default password
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
		}  */
	}
	else {
		echo "<p><span style='color:red; text-align:center; font-size:20px;'>
		      Wrong E-mail address!</span></p>";
	}
	
}

// Handle form submission for security question verification
if (isset($_POST["answer"])) {
    $answer = $_POST["answer"];
    if ($answer == $_SESSION["answer"]) {
        echo "<p><span style='text-align:center; font-size:20px;'>Your password is ".$_SESSION['password']." </span></p>";
        // Implement password reset logic here
    } else {
        echo "<p><span style='color:red; text-align:center; font-size:20px;'>Incorrect Answer!</span></p>";
    }
}
?>

</div> <!-- Closing container -->
<?php 
include("footer.php"); // Include the Page Layout footer
?>