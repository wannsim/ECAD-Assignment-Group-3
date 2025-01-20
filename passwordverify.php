<?php 
session_start(); // Detect the current session
include("header.php"); // Include the Page Layout header

echo '<div style="width:80%; margin:auto;"><p><span text-align:center; font-size:20px;>Your password is '.$_SESSION["password"].' </span></p>
		<div class="form-group row">      
		<div class="col-sm-9 offset-sm-3">
			<a href="login.php"><button class="btn btn-primary" type="submit">Continue</button></a>
		</div>
	</div></div>';

session_destroy(); 
include("footer.php"); // Include the Page Layout footer
?>