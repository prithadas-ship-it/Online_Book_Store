<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Book Store - Register</title>
    <link rel="stylesheet" href="../css/Register.css">
</head>

<body>

    <div class="main-container">

        <h1>Online Book Store</h1>
        <h2>Create Your Account</h2>
        <p>Join Online Book Store</p>

        <form
            id="registerForm"
            method="POST"
            onsubmit="return validateForm()"
        >

            <label for="name">Full Name:</label>
            <input
                type="text"
                id="name"
                name="name"
                placeholder="Enter your full name"
            >
            <span class="error-msg">
                <?php if (isset($_GET["nameError"])) { echo $_GET["nameError"]; } ?>
            </span>

            <label for="email">Email:</label>
            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter your email"
            >
            <span class="error-msg">
                <?php if (isset($_GET["emailError"])) { echo $_GET["emailError"]; } ?>
            </span>

            <label for="password">Password:</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter password"
            >
            <span class="error-msg">
                <?php if (isset($_GET["passwordError"])) { echo $_GET["passwordError"]; } ?>
            </span>

            <label for="confirm_password">Confirm Password:</label>
            <input
                type="password"
                id="confirm_password"
                name="confirm_password"
                placeholder="Confirm password"
            >
            <span class="error-msg">
                <?php if (isset($_GET["confirmPasswordError"])) { echo $_GET["confirmPasswordError"]; } ?>
            </span>

            <label for="address">Address:</label>
            <textarea
                id="address"
                name="address"
                placeholder="Enter your address"
            ></textarea>
            <span class="error-msg">
                <?php if (isset($_GET["addressError"])) { echo $_GET["addressError"]; } ?>
            </span>

            <label for="phone">Phone Number:</label>
            <input
                type="text"
                id="phone"
                name="phone"
                placeholder="01XXXXXXXXX"
            >
            <span class="error-msg">
                <?php if (isset($_GET["phoneError"])) { echo $_GET["phoneError"]; } ?>
            </span>

            <label for="role">Register As:</label>
            <select id="role" name="role">
                <option value="">Select Role</option>
                <option value="customer">Customer</option>
                <option value="admin">Admin</option>
            </select>
            <span class="error-msg">
                <?php if (isset($_GET["roleError"])) { echo $_GET["roleError"]; } ?>
            </span>

            <input
                type="submit"
                name="mysubmit"
                value="Create Account"

            >

            <p class="login-link">
                Already have an account? <a href="login.php">Login</a>
            </p>
    

        </form>

    </div>

    <script src="../JS/Register.js"></script>

</body>

</html>