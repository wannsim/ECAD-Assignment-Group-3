<?php
// Detect the current session
session_start();
// Include the Page Layout header
include("header.php");
?>
<!-- Custom CSS for the Login Page -->
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 500px;
        margin: auto;
        margin-top: 100px;
        padding-bottom:200px;
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        background-color: white;
        padding: 40px;
    }

    h3 {
        font-size: 32px;
        font-weight: bold;
        color: #000;
        margin-bottom: 30px;
    }

    .form-group input {
        font-size: 20px;
        border: none;
        border-bottom: 2px solid #ccc;
        padding: 15px 10px;
        width: 100%;
        outline: none;
        transition: border-color 0.3s;
    }

    .form-group input:focus {
        border-bottom: 2px solid #000;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .text-start a {
        font-size: 18px;
        color: #007bff;
        text-decoration: none;
    }

    .text-start a:hover {
        text-decoration: underline;
    }

    button {
        font-size: 20px;
        font-weight: bold;
        padding: 15px 20px;
        border-radius: 30px;
        border: 2px solid #000;
        background-color: white;
        color: #000;
        cursor: pointer;
        transition: all 0.3s;
        width: 100%;
    }

    button:hover {
        background-color: #000;
        color: #fff;
    }

    .mt-3 p {
        font-size: 18px;
        color: #000;
        margin: 0;
    }

    .mt-3 a {
        font-size: 18px;
        font-weight: bold;
        color: #007bff;
        text-decoration: none;
    }

    .mt-3 a:hover {
        text-decoration: underline;
    }
</style>

<!-- Create a centrally located container -->
<div class="container">
    <div class="card shadow-sm">
        <div class="card-body text-center">
            <!-- Header -->
            <h3 class="mb-4">Member Login</h3>
            <!-- Form -->
            <form action="checkLogin.php" method="post">
                <!-- Username Input -->
                <div class="form-group mb-3">
                    <input type="email" name="email" placeholder="Username" 
                           required>
                </div>
                <!-- Password Input -->
                <div class="form-group mb-3">
                    <input type="password" name="password" placeholder="Password" 
                           required>
                </div>
                <!-- Forget Password -->
                <div class="text-start mb-4">
                    <a href="forgetPassword.php">Forget Password?</a>
                </div>
                <!-- Login Button -->
                <button type="submit">Login</button>
            </form>
            <!-- Signup Option -->
            <div class="mt-4">
                <p>Not a Member? <a href="register.php">Signup</a></p>
            </div>
        </div>
    </div>
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
// Include the Page Layout footer
include("footer.php");
?>
