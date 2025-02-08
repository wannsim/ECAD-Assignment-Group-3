
<?php
include("header.php");
// Start the session
session_start();
session_destroy(); 
// Check if login failed
$loginFailed = isset($_SESSION["Failed"]) && $_SESSION["Failed"] == 1;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin-top: -20px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
            background-color: white;
            padding: 30px;
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

        .form-group.error input {
            border-bottom: 2px solid red;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .error-message {
            color: red;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
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
</head>
<body>
    <!-- Create a centrally located container -->
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <!-- Header -->
                <h3 class="mb-4">Member Login</h3>
                <!-- Form -->
                <form action="checkLogin.php" method="post">
                    <!-- Username Input -->
                    <div class="form-group mb-3 <?php echo $loginFailed ? 'error' : ''; ?>">
                        <input type="email" name="email" placeholder="Username" 
                               required>
                    </div>
                    <!-- Password Input -->
                    <div class="form-group mb-3 <?php echo $loginFailed ? 'error' : ''; ?>">
                        <input type="password" name="password" placeholder="Password" 
                               required>
                    </div>
                    <!-- Forget Password -->
                    <div class="text-start mb-4">
                        <a href="forgetPassword.php">Forget Password?</a>
                    </div>
                <!-- Display error message if login failed -->
                <?php if ($loginFailed): ?>
                    <div class="error-message">Invalid Login Credentials</div>
                <?php endif; ?>
                    <!-- Login Button -->
                    <button type="submit">Login</button>
                </form>
                <!-- Signup Option -->
                <div class="mt-4">
                    <p>Not a Member? <a style = "color:black" href="register.php">Signup</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
// Clear the login failure flag to prevent repeated error display
unset($_SESSION["Failed"]);
include("footer.php");
?>
