<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit();
}

$image_url = '';

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];

    $image_url = isset($_POST['product_image']) ? $_POST['product_image'] : '';

    $existing_product = mysqli_query($conn, "SELECT * FROM cart WHERE product_id = '$product_id' AND user_id = '{$_SESSION['user_id']}'");
    if (mysqli_num_rows($existing_product) > 0) {
        $row = mysqli_fetch_assoc($existing_product);
        $new_quantity = $row['quantity'] + 1;
        mysqli_query($conn, "UPDATE cart SET quantity = '$new_quantity' WHERE product_id = '$product_id' AND user_id = '{$_SESSION['user_id']}'");
    } else {
        mysqli_query($conn, "INSERT INTO cart (user_id, product_id, name, price, quantity, image) VALUES ('{$_SESSION['user_id']}', '$product_id', '$product_name', '$product_price', 1, '$image_url')");
    }
    header('location:products.php');
    exit();
}


if (isset($_POST['update_cart'])) {
    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    mysqli_query($conn, "UPDATE cart SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
    $message[] = 'Cart quantity updated!';
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM cart WHERE id = '$delete_id'") or die('query failed');
    header('location:cart.php');
}

if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'") or die('query failed');
    header('location:cart.php');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="./utils/favicon.png">
    <script src="https://kit.fontawesome.com/9c00960078.js" crossorigin="anonymous"></script>
</head>

<body>

    <?php include 'header.php'; ?>

    <section class="main-container">
        <div class="cart-container">
            <div class="cart-title">
                <h2>Your Cart</h2>
                <h3>Added products:</h3>
            </div>

            <?php
            $grand_total = 0;
            $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'") or die('query failed');
            if (mysqli_num_rows($select_cart) > 0) {
                while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                    $image_url = $fetch_cart['image'];
                    ?>
                    <div class="box">
                        <div class="delete-btn-wrapper">
                            <span class="delete-btn" title="Delete from cart"><a
                                    href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times"
                                    onclick="return confirm('delete this from cart?');"></a>
                            </span>
                        </div>
                        <img src="<?php echo $image_url; ?>" alt="Product Image">


                        <div class="name"><?php echo $fetch_cart['name']; ?></div>
                        <div class="price">$<?php echo $fetch_cart['price']; ?>&nbsp;</div>
                        <form action="" method="post">
                            <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                            <p class="quantity"> Quantity: </p>
                            <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                            <input type="submit" name="update_cart" value="Update quantity" class="dark-bttn">
                        </form>
                        <div class="sub-total"> Subtotal :
                            <span>$<?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']); ?>&nbsp;</span>
                        </div>
                    </div>
                    <?php
                    $grand_total += $sub_total;
                }
            } else {
                echo '<p class="empty">Cart is empty.</p>';
            }
            ?>

            <div>
                <a href="cart.php?delete_all"
                    class="delete-btn dark-bttn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>"
                    onclick="return confirm('delete all from cart?');">Delete all</a>
            </div>

            <div class="cart-total">
                <p class='total'>Total : $<span><?php echo $grand_total; ?>&nbsp;</span></p>
                <div class="flex">
                    <a href="products.php" class="option-btn dark-bttn">Continue shopping</a>
                    <a href="checkout.php" class="dark-bttn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>">Go to
                        checkout</a>
                </div>
            </div>
        </div>

    </section>

</body>

</html>