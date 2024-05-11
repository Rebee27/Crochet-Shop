<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$grand_total = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_order'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $payment = mysqli_real_escape_string($conn, $_POST['payment']);
    
    $product_ids = array();
    $select_cart = mysqli_query($conn, "SELECT product_id FROM cart WHERE user_id = '$user_id'");
    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
        $product_ids[] = $fetch_cart['product_id'];
    }
    $product_ids_string = implode(',', $product_ids);

    $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'");
    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
        $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
        $grand_total += $sub_total;
    }
    
    $insert_order_query = "INSERT INTO orders (user_id, user_name, user_email, user_phone, user_address, payment_method, product_ids, total) VALUES ('$user_id', '$name', '$email', '$phone', '$address', '$payment', '$product_ids_string', '$grand_total')";
    mysqli_query($conn, $insert_order_query) or die('Error: ' . mysqli_error($conn));
    
    mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'");

    echo "<script>alert('Order confirmed');</script>"; 
    echo "<script>window.location.href = 'home.php';</script>";
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout & Payment</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="./utils/favicon.png">
    <script src="https://kit.fontawesome.com/9c00960078.js" crossorigin="anonymous"></script>
</head>

<body>

    <?php include 'header.php'; ?>

    <section class="main-container">
        <div class="checkout">
            <div class="checkout-title">
                <h2>Checkout & Payment</h2>
                <h3>Review Your Cart and Complete Payment</h3>
            </div>

            <?php
            $grand_total = 0;
            $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'");
            if (mysqli_num_rows($select_cart) > 0) {
                while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                    $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
                    $grand_total += $sub_total;
                    ?>
                    <div class="checkout-item">
                        <div class="checkout-img">
                            <img src="<?php echo $fetch_cart['image']; ?>" alt="Product Image">
                        </div>
                        <div class="checkout-details">
                            <h4><?php echo $fetch_cart['name']; ?></h4>
                            <p>Price: $<?php echo $fetch_cart['price']; ?></p>
                            <p>Quantity: <?php echo $fetch_cart['quantity']; ?></p>
                            <p class='sub-total'>Subtotal: $<?php echo $sub_total; ?></p>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">Your cart is empty.</p>';
            }
            ?>

            <div class="checkout-total">
                <p class="total">Total: $<?php echo $grand_total; ?></p>

                <p class="user-info-title">Order information </p>

                <form method="post" action="">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number:</label>
                        <input type="text" id="phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="address" id="address" name="address" required>
                    </div>
                    <div class="form-group" class="payment">
                        <label for="payment">Payment Method:</label>
                        <select id="payment" name="payment" required>
                            <option value="card">Card on Delivery</option>
                            <option value="cash">Cash on Delivery</option>
                        </select>
                    </div>

                    <button type="submit" class="dark-bttn" name="confirm_order" <?php echo ($grand_total <= 0) ? 'disabled' : ''; ?>>Confirm Order</button>
                </form>
            </div>
        </div>
    </section>

</body>

</html>