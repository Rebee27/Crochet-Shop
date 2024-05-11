<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['user_id']) && isset($_POST['username']) && isset($_POST['first_name']) && isset($_POST['second_name']) && isset($_POST['email']) && isset($_POST['user_type'])) {
        include 'config.php'; 

        $user_id = $_POST['user_id'];
        $username = $_POST['username'];
        $first_name = $_POST['first_name'];
        $second_name = $_POST['second_name'];
        $email = $_POST['email'];
        $user_type = $_POST['user_type'];

        $username = mysqli_real_escape_string($conn, $username);
        $first_name = mysqli_real_escape_string($conn, $first_name);
        $second_name = mysqli_real_escape_string($conn, $second_name);
        $email = mysqli_real_escape_string($conn, $email);
        $user_type = mysqli_real_escape_string($conn, $user_type);


        $update_query = "UPDATE `users` SET username='$username', first_name='$first_name', second_name='$second_name', email='$email', user_type='$user_type' WHERE id='$user_id'";
        $result = mysqli_query($conn, $update_query);

        if ($result) {
            http_response_code(200);
            echo "User information updated successfully!";
        } else {
            http_response_code(500);
            echo "Error: Failed to update user information!";
        }
        mysqli_close($conn);
    } else {
        http_response_code(400);
        echo "Error: Missing required fields!";
    }
} else {
    http_response_code(405);
    echo "Error: Method not allowed!";
}
?>
