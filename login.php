<?php
// Detect the current session
session_start();
// Include the Page Layout header
include ( "header.php" );
?>
<!-- Create a cenrally located container-->
<div style="width:80%; margin:auto;" >
    <!-- Create a HTML Form wit hin the container -->
    <form action="checkLogin.php" method="post">
        <!-- 1st row - Header Row-->
        <div class="mb-3 row" >
            <div class="col-sm-9 offset-sm-3">
                <span class="page-title" >Member Login</span>
            </div>
        </div>
        <!-- 2nd row - Entry of email address-->
        <div class="mb-3 row" >
            <label class="col-sm-3 col-form-label" for="email">
            Email Address:
            </label>
            <div class="col-sm-9">
                <input class="form-control" type="email"
                name="email" id="email" required />
            </div>
        </div>
        <!-- 3rd row - Entry of password-->
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="password">
            Password:
            </label>
            <div class="col-sm-9">
                <input class="form-control" type="password"
                name="password" id="password" required />
            </div>
        </div>
        <!-- 4th row - Login button -->
        <div class='mb-3 row' >
            <div class='col-sm-9 offset-sm-3' >
                <button class='btn btn-primary' type='submit' >Login</button>
                <p>Please sign up if you do not have an account. </p>
                <p><a href="forgetPassword.php" >Forget Password </a></p>
            </div>
        </div>
    </form>
</div>


<!-- <div class="form-container">
    <div class="form" id="login">
        <form id="LoginForm" method="post" action="~/Member/MemberLogin">
            <div class="form-group memberform">
                <input placeholder="Email Address" type="email" name="txtLoginID"
                       id="txtLoginID" required />
                <i class='bx bxs-user'></i>

            </div>
            <div class="form-group memberform">
                <input placeholder="Password" type="password" name="txtPassword"
                       id="txtPassword"
                       required />
                <i class='bx bxs-lock-alt'></i>

            </div>
            <br>
            <input type="submit" id="btnStaffLogin"
                   class="btn btn-primary login" value="Login" />
            <span style="color:red;">@TempData["Message"]</span><br>
            <span style="position:relative; text-align:center; top:15px;">New user? Click <a href="~/Home/MemberSignUp">here</a> to sign up.</span>

        </form>
    </div>
</div> -->
<?php
// Include the Page Layout
include ( "footer.php" );
?>