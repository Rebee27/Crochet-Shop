<?php
include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];


// Initialize the $message array
$message = array();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];


    // Fetch user data from the database
    $select_user_query = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'");
    $user_data = mysqli_fetch_assoc($select_user_query);

} else {
    // Dacă utilizatorul nu este autentificat, îndreaptă-l către pagina de login
    header("location: login.php");
    exit;
}

// Check if the form was submitted
if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $second_name = mysqli_real_escape_string($conn, $_POST['second_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $user_type = mysqli_real_escape_string($conn, $_POST['user_type']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

    // Update user data
    $update_query = "UPDATE `users` SET username='$username', first_name='$first_name', second_name='$second_name', user_type='$user_type', email='$email'";
    if (!empty($pass) && !empty($cpass)) {
        if ($pass != $cpass) {
            $message[] = "Confirmation password doesn't match!";
        } else {
            $update_query .= ", password='$pass'";
        }
    }

    $update_query .= " WHERE id='$user_id'";
    mysqli_query($conn, $update_query) or die('error query failed');
    $message[] = 'Information updated!';
    //header('location:my-account.php');
    //exit; // Ensure script execution stops after redirection
}

// Logout functionality
if (isset($_POST['logout'])) {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to login page
    header("location: login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href=".\utils\favicon.png">
    <script src="https://kit.fontawesome.com/9c00960078.js" crossorigin="anonymous"></script>
</head>

<body>

    <?php include 'header.php' ?>

    <main class="main-container">
        <section class="account" id="account">
            <div class="title" id="account-title">
                <h1>Info Account</h2>
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

                <form method="post" action="">
                    <div id="first-name-form">
                        <i class="fa fa-regular fa-user" class="input-icons"></i>
                        <input type="text" id="first-name-input" name="first_name"
                            value="<?php echo $user_data['first_name']; ?>" placeholder="First Name" required>
                    </div>

                    <div id="second-name-form">
                        <i class="fa fa-regular fa-user" class="input-icons"></i>
                        <input type="text" id="second-name-input" name="second_name"
                            value="<?php echo $user_data['second_name']; ?>" placeholder="Second Name" required>
                    </div>

                    <div id="username-form">
                        <i class="fa fa-regular fa-user" class="input-icons"></i>
                        <input type="text" id="username-input" name="username"
                            value="<?php echo $user_data['username']; ?>" placeholder="Username" required>
                    </div>

                    <input type="hidden" name="user_type" value="<?php echo $user_data['user_type']; ?>">


                    <div id="email-form">
                        <i class="fa fa-light fa-envelope" class="input-icons"></i>
                        <input type="text" id="email-input" name="email" value="<?php echo $user_data['email']; ?>"
                            placeholder="Email" required>
                    </div>

                    <div id="psw-form">
                        <i class="fa fa-light fa-unlock" class="input-icons"></i>
                        <input type="password" id="psw-input" name="password" placeholder="Password" required>
                    </div>

                    <div id="cpsw-form">
                        <i class="fa fa-light fa-unlock" class="input-icons"></i>
                        <input type="password" id="cpsw-input" name="cpassword" placeholder="Confirm Password" required>
                    </div>

                    <input type="submit" name="submit" value="Modify" class="dark-bttn">
                </form>

                <form action="" method="post" class="logout-form">
                    <button type="submit" name="logout" class="dark-bttn logout-button">Logout</button>
                </form>
            </div>
        </section>
    </main>

</body>

</html>