<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
var_dump($_POST);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['product_id']) && isset($_POST['name']) && isset($_POST['price']) && isset($_POST['category']) && isset($_POST['description']) && isset($_POST['short_description']) && isset($_POST['rating'])) {
        
        include 'config.php'; 
        
        $product_id = $_POST['product_id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $short_description = $_POST['short_description'];
        $rating = $_POST['rating'];

        $name = mysqli_real_escape_string($conn, $name);
        $price = mysqli_real_escape_string($conn, $price);
        $category = mysqli_real_escape_string($conn, $category);
        $description = mysqli_real_escape_string($conn, $description);
        $short_description = mysqli_real_escape_string($conn, $short_description);
        $rating = mysqli_real_escape_string($conn, $rating);


        $update_query = "UPDATE `products` SET name='$name', price='$price', category='$category', description='$description', short_description='$short_description', rating='$rating' WHERE id='$product_id'";
        $result = mysqli_query($conn, $update_query);

        if ($result) {
            http_response_code(200);
            echo "Product information updated successfully!";
        } else {
            http_response_code(500);
            echo "Error: Failed to update product information!";
        }

        mysqli_close($conn);
    } else {
        http_response_code(400);
        echo "Error: Missing required fields!";
    }
}
?>
