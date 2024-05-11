<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['order_id']) && isset($_POST['user_id']) && isset($_POST['user_name']) && isset($_POST['user_email'])  
    && isset($_POST['user_phone']) && isset($_POST['user_address']) && isset($_POST['payment_method']) && isset($_POST['product_ids']) 
    && isset($_POST['total'])) {

        include 'config.php'; 

        $order_id = $_POST['order_id'];
        $user_id = $_POST['user_id'];
        $user_name = $_POST['user_name'];
        $user_email = $_POST['user_email'];
        $user_phone = $_POST['user_phone'];
        $user_address = $_POST['user_address'];
        $payment_method = $_POST['payment_method'];
        $product_ids = $_POST['product_ids'];
        $total = $_POST['total'];

        $user_id = mysqli_real_escape_string($conn, $user_id);
        $user_name = mysqli_real_escape_string($conn, $user_name);
        $user_email = mysqli_real_escape_string($conn, $user_email);
        $user_phone = mysqli_real_escape_string($conn, $user_phone);
        $user_address = mysqli_real_escape_string($conn, $user_address);
        $payment_method = mysqli_real_escape_string($conn, $payment_method);
        $product_ids = mysqli_real_escape_string($conn, $product_ids);
        $total = mysqli_real_escape_string($conn, $total);


        $update_query = "UPDATE `orders` SET user_id='$user_id', user_name='$user_name', user_email='$user_email',
         user_phone='$user_phone', user_address='$user_address', payment_method='$payment_method', product_ids='$product_ids',
         total='$total' WHERE id='$order_id'";
        $result = mysqli_query($conn, $update_query);

        if ($result) {
            http_response_code(200);
            echo "Order information updated successfully!";
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
