<?php

// Include the configuration file
include 'config.php';

// Check if the registration form is submitted
if (isset($_POST['submit'])) {
    // Sanitize input data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $second_name = mysqli_real_escape_string($conn, $_POST['second_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password'])); // Hash the password
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword'])); // Hash the confirmation password
    $user_type = mysqli_real_escape_string($conn, $_POST['user_type']);

    // Check if the email already exists in the database
    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

    // If email already exists, display error message
    if (mysqli_num_rows($select_users) > 0) {
        $message[] = 'User already exists!';
    } else {
        // If email is unique, check if password matches confirmation password
        if ($pass != $cpass) {
            $message[] = "Confirmation password doesn't match!";
        } else {
            // If passwords match, insert new user into the database
            mysqli_query($conn, "INSERT INTO `users`(username, first_name, second_name, user_type, email, password) VALUES('$username', '$first_name', '$second_name', '$user_type', '$email', '$pass')") or die('error query failed');
            $message[] = 'Registration done!';

            $_SESSION['user_id'] = mysqli_insert_id($conn);

            // Redirect user to the home page after successful registration
            header('location:my-account.php');
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="./utils/favicon.png">
    <script src="https://kit.fontawesome.com/9c00960078.js" crossorigin="anonymous"></script>
</head>

<body>

    <?php
    include 'header.php'
        ?>

    <main class="main-container">
        <section class="register">
            <div class="split-button">
                <a href="register.php" class="toggle-button register-button left-half active">Register</a>
                <a href="login.php" class="toggle-button login-button right-half">Login</a>
            </div>

            <div class="info">
                <div class="message-container">
                    <?php if (!empty($message)): ?>
                        <div class="message">
                            <?php foreach ($message as $msg): ?>
                                <p><?php echo $msg; ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <form action="" method="post">
                    <div id="first-name-form">
                        <i class="fa fa-regular fa-user" class="input-icons"></i>
                        <input type="text" id="first-name-input" name="first_name" placeholder="First Name" required>
                    </div>

                    <div id="second-name-form">
                        <i class="fa fa-regular fa-user" class="input-icons"></i>
                        <input type="text" id="second-name-input" name="second_name" placeholder="Second Name" required>
                    </div>

                    <div id="username-form">
                        <i class="fa fa-regular fa-user" class="input-icons"></i>
                        <input type="text" id="username-input" name="username" placeholder="Username" required>
                    </div>

                    <input type="hidden" name="user_type" value="user">

                    <div id="email-form">
                        <i class="fa fa-light fa-envelope" class="input-icons"></i>
                        <input type="text" id="email-input" name="email" placeholder="Email" required>
                    </div>

                    <div id="psw-form">
                        <i class="fa fa-light fa-unlock" class="input-icons"></i>
                        <input type="password" id="psw-input" name="password" placeholder="Password" required>
                    </div>

                    <div id="re-psw-form">
                        <i class="fa fa-light fa-lock" class="input-icons"></i>
                        <input type="password" id="re-psw-input" name="cpassword" placeholder="Confirm password"
                            required>
                    </div>

                    <input type="submit" name="submit" value="Join us!" class="dark-bttn">
                </form>
        </section>
    </main>

</body>

</html>