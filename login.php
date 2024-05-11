<?php
// Include the configuration file
include 'config.php';

// Start the session
session_start();

$loggedIn = isset($_SESSION['user_id']);

// Check if the login form is submitted
if (isset($_POST['submit'])) {
    // Get the email and password from the form and sanitize them
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

    // Query the database to check if the user exists with the provided credentials
    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');


    // If the user exists
    if (mysqli_num_rows($select_users) > 0) {
        $user_data = mysqli_fetch_assoc($select_users);

        echo "<p><strong>Username:</strong> " . $user_data['username'] . "</p>";

        // Set session variables for user
        $_SESSION['user_name'] = $user_data['username'];
        $_SESSION['user_email'] = $user_data['email'];
        $_SESSION['user_id'] = $user_data['id'];

        // Check user type
        if ($user_data['user_type'] === 'admin') {
            $_SESSION['is_admin'] = true; // Set session variable indicating admin status
            echo "Admin session set: " . $_SESSION['is_admin']; // Debug output
        }

        // Redirect user to the account page
        header('location: my-account.php');
        exit();
    } else {
        // If user with provided email doesn't exist, display error message
        $message = 'User not found!';
    }
}

// Check if user is already logged in and redirect to home page
if (isset($_SESSION['user_id'])) {
    header('location: my-account.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="./utils/favicon.png">
    <script src="https://kit.fontawesome.com/9c00960078.js" crossorigin="anonymous"></script>

</head>

<body style="background-color: #f5f5f5;">



    <?php
    include 'header.php';
    ?>

    <main class="main-container">
        <section class="login">
            <div class="split-button">
                <a href="register.php" class="toggle-button register-button left-half">Register</a>
                <a href="login.php" class="toggle-button login-button right-half active">Login</a>
            </div>

            <div class="info">
                <div class="message-container">
                    <?php if (!empty($message)): ?>
                        <div class="message">
                            <p><?php echo $message; ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <form action="" method="post">
                    <div id="email-form">
                        <i class="fa fa-light fa-envelope" class="input-icons"></i>
                        <input type="text" id="email-input" name="email" placeholder="Email" required>
                    </div>
                    <div id="psw-form">
                        <i class="fa fa-light fa-unlock" class="input-icons"></i>
                        <input type="password" id="psw-input" name="password" placeholder="Password" required>
                    </div>

                    <input type="submit" name="submit" value="Join us!" class="dark-bttn">
                </form>
            </div>

        </section>
    </main>

</body>

</html>