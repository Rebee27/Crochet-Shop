<?php
include 'config.php';

session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$user_data = null; // Initialize $user_data variable

// If user is logged in, fetch user data from the database
if ($user_id) {
    $select_user_query = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'");
    $user_data = mysqli_fetch_assoc($select_user_query);
}

if (isset($_POST['add_to_cart'])) {

    $product_name = $_POST['name'];
    $product_description = $_POST['description'];
    $product_category = $_POST['product_category'];
    $product_dimension = $_POST['product_dimension'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM cart WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'This product is already in the cart!';
    } else {
        mysqli_query($conn, "INSERT INTO cart(user_id, name, description, dimension, category, price, quantity, image) VALUES('$user_id', '$product_name', '$product_description', '$product_dimension', '$product_category', '$product_price', '$product_quantity', '$product_image')") or die('query failed1111');
        $message[] = 'Product successfully added to the cart!';
    }
}
?>