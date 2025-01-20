<?php 
session_start(); // Detect the current session
include("header.php"); // Include the Page Layout header

echo '<div id="forgetpassword"><div style="width:80%; margin:auto;">
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
                <input class="form-control" name="email" id="email" type="email" required value='.$_SESSION["checkemail"].' readonly/>
            </div>
        </div>
    </form></div><br>
    <div style="width:80%; margin:auto;">
		<form id="form2" method="post">
    <div class="form-group row">
    <label class="col-sm-3 col-form-label" for="eMail">
     Security Question: </label>
    <div class="col-sm-9">
        <input class="form-control" name="question" id="question" type="text" value="'.$_SESSION["question"].'" readonly />
                
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
</form></div></div>';
  // Handle form submission for security question verification
if (isset($_POST["answer"])) {
    $answer = $_POST["answer"];
    if ($answer == $_SESSION["answer"]) {
        $_SESSION["password"] = $_SESSION["checkpassword"];
        echo '
        <p style="text-align:center; font-size:20px;"><span >Your password is '.$_SESSION["password"].' </span></p>
		<div class="form-group row">      
		<div style="text-align:center;">
			<a href="login.php" style="align-items:right;"><button class="btn btn-primary" type="submit">Continue</button></a>
		</div>
	    </div>
        <script>
            document.getElementById("forgetpassword").style.display = "none";
        </script>';
    } else {
        echo "<p><span style='color:red; text-align:center; font-size:20px;'>Incorrect Answer!</span></p>";
    }
}  
include("footer.php"); // Include the Page Layout footer
?>