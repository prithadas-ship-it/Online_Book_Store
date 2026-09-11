<?php
session_start();
require_once("../Control/ProfileControl.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - BookHaven</title>

    <link rel="stylesheet" href="../CSS/Profile.css">
</head>

<body>

<div class="navbar">

    <a href="Home.php" class="logo">BookHaven</a>

    <div class="nav">

        <a href="Home.php">Home</a>
        <a href="Browse.php">Browse Books</a>
        <a href="Profile.php">My Profile</a>
        <a href="../Control/LogoutControl.php">Logout</a>

    </div>

</div>


<div class="container">

    <h2>Update Profile</h2>


    <?php if (isset($_SESSION['msg'])): ?>

        <div class="alert">
            <?php
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
            ?>
        </div>

    <?php endif; ?>


    <?php if (isset($_SESSION['error'])): ?>

        <div class="error">
            <?php
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
        </div>

    <?php endif; ?>


    <div class="profile-pic-preview">

        <?php

        $pic = !empty($userData['profile_picture'])
            ? "../uploads/" . $userData['profile_picture']
            : "https://via.placeholder.com/120";

        ?>

        <img src="<?php echo htmlspecialchars($pic); ?>"
             alt="Profile Picture">

    </div>


    <form action="../Control/ProfileControl.php"
          method="POST"
          enctype="multipart/form-data">


        <div class="form-group">

            <label>Profile Picture (JPG/PNG, Max 2MB)</label>

            <input type="file"
                   id="profile_pic"
                   name="profile_pic"
                   accept="image/png, image/jpeg, image/jpg">

        </div>


        <div class="form-group">

            <label>Name</label>

            <input type="text"
                   id="name"
                   name="name"
                   value="<?php echo $userData['name']; ?>">
                  

        </div>


        <div class="form-group">

            <label>Email</label>

            <input type="email"
                   id="email"
                   name="email"
                   value="<?php echo $userData['email'];  ?>">
                   

        </div>


        <div class="form-group">

            <label>Phone</label>

            <input type="text"
                   id="phone"
                   name="phone"
                   value="<?php echo $userData['phone'] ?>">

        </div>


        <div class="form-group">

            <label>Address</label>

            <input type="text"
                   id="address"
                   name="address"
                   value="<?php echo $userData['address']; ?>">

        </div>


        <hr>


        <h3>Change Password (Optional)</h3>


        <div class="form-group">

            <label>Current Password</label>

            <input type="password"
                   id="curr_pass"
                   name="curr_pass">

        </div>


        <div class="form-group">

            <label>New Password (min 8 characters)</label>

            <input type="password"
                   id="new_pass"
                   name="new_pass">

        </div>


        <button type="submit"
                name="update_profile"
                class="btn">
            Save Changes
        </button>

    </form>

</div>

</body>
</html>