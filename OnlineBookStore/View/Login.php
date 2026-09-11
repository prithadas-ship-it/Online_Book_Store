<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Book Store - Login</title>
    <link rel="stylesheet" href="../CSS/Login.css">
</head>

<body>

    <div class="login-container">
        <h1>Online Book Store</h1>
        <h2>Login to Your Account</h2>

        <?php if (isset($_GET["success"])) echo "<p class='success'>" . htmlspecialchars($_GET["success"]) . "</p>"; ?>
        <?php if (isset($_GET["loginError"])) echo "<p class='error' style='text-align:center; margin-bottom:15px;'>" . htmlspecialchars($_GET["loginError"]) . "</p>"; ?>

        <form id="loginForm" action="../Control/loginControl.php" method="POST" onsubmit="return validateLoginForm()">

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" placeholder="Enter your email"><br>
            <span id="emailError" class="error">
                <?php if (isset($_GET["emailError"])) echo htmlspecialchars($_GET["emailError"]); ?>
            </span>
            <br><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" placeholder="Enter password"><br>
            <span id="passwordError" class="error">
                <?php if (isset($_GET["passwordError"])) echo htmlspecialchars($_GET["passwordError"]); ?>
            </span>
            <br><br>

            <div class="remember">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember Me</label>
            </div>
            <br>

            <input type="submit" name="login" value="Login" class="login-btn">

        </form>

        <br>
        <p class="register-text">
            Don't have an account?
            <a href="Register.php">Register Here</a>
        </p>
    </div>

    <script src="../JS/Login.js"></script>
</body>
</html>