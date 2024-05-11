<?php
session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_user'])) {
    include 'config.php';
    
    $user_id = $_POST['user_id'];
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $second_name = mysqli_real_escape_string($conn, $_POST['second_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $user_type = mysqli_real_escape_string($conn, $_POST['user_type']);

    $update_query = "UPDATE `users` SET username='$username', first_name='$first_name', second_name='$second_name', user_type='$user_type', email='$email' WHERE id='$user_id'";
    mysqli_query($conn, $update_query) or die('Error: Query failed');
    $alert = 'User information updated!';
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_product'])) {
    include 'config.php';
    
    $product_id = $_POST['product_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $short_description = mysqli_real_escape_string($conn, $_POST['short_description']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);

    $update_query = "UPDATE `products` SET name='$name', price='$price', category='$category', description='$description', short_description='$short_description', rating='$rating' WHERE id='$product_id'";
    mysqli_query($conn, $update_query) or die('Error: Query failed');
    $alert = 'Product information updated!';
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_order'])) {
    include 'config.php';
    
    $order_id = $_POST['order_id'];
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
    $user_phone = mysqli_real_escape_string($conn, $_POST['user_phone']);
    $user_address = mysqli_real_escape_string($conn, $_POST['user_address']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $product_ids = mysqli_real_escape_string($conn, $_POST['product_ids']);
    $total = mysqli_real_escape_string($conn, $_POST['total']);

    $update_query = "UPDATE `orders` SET user_id='$user_id', user_name='$user_name', user_email='$user_email',
     user_phone='$user_phone', user_address='$user_address', payment_method='$payment_method', product_ids='$product_ids', 
     total='$total' WHERE id='$order_id'";
    mysqli_query($conn, $update_query) or die('Error: Query failed');
    $alert = 'Order information updated!';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <link rel="icon" href="./utils/favicon.png">
    <script src="https://kit.fontawesome.com/9c00960078.js" crossorigin="anonymous"></script>

    <title>Admin</title>
</head>

<body>
    <?php include 'header.php'; ?>

    <main class="main-container">
        <section class="main-container-admin">
            <nav class="admin-navbar">
                <ul>
                    <li><a href="#users">Users</a></li>
                    <li><a href="#products">Products</a></li>
                    <li><a href="#orders">Orders</a></li>
                </ul>
            </nav>

            <section class="user-data" id="users">
                <h2 class="users-title">Users</h2>
                <div class="users-table table">
                    <table>
                        <thead>
                            <tr>
                                <th class="user-data">User ID</th>
                                <th class="user-data">First Name</th>
                                <th class="user-data">Second Name</th>
                                <th class="user-data">Username</th>
                                <th class="user-data">Email</th>
                                <th class="user-data">User Type</th>
                                <th class="user-data">Modify</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'config.php';

                            $query = "SELECT * FROM users";
                            $result = mysqli_query($conn, $query);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td class='user-data'><input type='text' value='" . $row['id'] . "'></td>";
                                    echo "<td class='user-data'><input type='text' name='first_name' value='" . $row['first_name'] . "'></td>";
                                    echo "<td class='user-data'><input type='text' name='second_name' value='" . $row['second_name'] . "'></td>";
                                    echo "<td class='user-data'><input type='text' name='username' value='" . $row['username'] . "'></td>";
                                    echo "<td class='user-data'><input type='text' name='email' value='" . $row['email'] . "'></td>";
                                    echo "<td class='user-data'>";
                                    echo "<select name='user_type'>";
                                    $categories = array("user", "admin"); 
                                    foreach ($categories as $category) {
                                        if ($category == $row['user_type']) {
                                            echo "<option value='$category' selected>$category</option>";
                                        } else {
                                            echo "<option value='$category'>$category</option>";
                                        }
                                    }
                                    echo "</select>";
                                    echo "</td>";
                                    echo "<td><button type='submit' name='edit_user' value='save' class='dark-bttn edit-user-bttn' data-user-id='" . $row['id'] . "'>Save</button></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No users found</td></tr>";
                            }
                            mysqli_close($conn);
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="product-data" id="products">
                <h2 class="product-title">Products</h2>
                <div class="products-table table">
                    <table>
                        <thead>
                            <tr>
                                <th class="user-data">Product ID</th>
                                <th class="user-data">Name</th>
                                <th class="user-data">Price</th>
                                <th class="user-data">Category</th>
                                <th class="user-data">Description</th>
                                <th class="user-data">Short Description</th>
                                <th class="user-data">Rating</th>
                                <th class="user-data">Modify</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'config.php';

                            $query = "SELECT * FROM products";
                            $result = mysqli_query($conn, $query);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td class='user-data'><input type='text' name='product_id' value='" . $row['id'] . "'></td>";
                                    echo "<td class='user-data'><input type='text' name='name' value='" . $row['name'] . "'></td>";
                                    echo "<td class='user-data'><input type='text' name='price' value='" . $row['price'] . "'></td>";
                                    echo "<td class='user-data'>";
                                    echo "<select name='category'>";
                                    $categories = array("Kids Clothes", "Winter Clothes", "Toys", "Accessories", "Crochet Thread"); 
                                    foreach ($categories as $category) {
                                        if ($category == $row['category']) {
                                            echo "<option value='$category' selected>$category</option>";
                                        } else {
                                            echo "<option value='$category'>$category</option>";
                                        }
                                    }
                                    echo "</select>";
                                    echo "</td>";
                                    echo "<td class='user-data'><input type='text' name='description' value='" . $row['description'] . "'></td>";
                                    echo "<td class='user-data'><input type='text' name='short_description' value='" . $row['short_description'] . "'></td>";
                                    echo "<td class='user-data'><input type='number' min='1' max='5' name='rating' value='" . $row['rating'] . "'></td>";
                                    echo "<td><button type='submit' name='edit_product' value='save' class='dark-bttn edit-product-bttn' data-product-id='" . $row['id'] . "'>Save</button></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No products found</td></tr>";
                            }
                            mysqli_close($conn);
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="orders-data" id="orders">
                <h2 class="orders-title">Orders</h2>
                <div class="orders-table table">
                    <table>
                        <thead>
                            <tr>
                                <th class="user-data">Order ID</th>
                                <th class="user-data">User ID</th>
                                <th class="user-data">User Name</th>
                                <th class="user-data">User Email</th>
                                <th class="user-data">User Phone</th>
                                <th class="user-data">User Address</th>
                                <th class="user-data">Payment Method</th>
                                <th class="user-data">Products ID</th>
                                <th class="user-data">Total Price</th>
                                <th class="user-data">Modify</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'config.php';

                            $query = "SELECT * FROM orders";
                            $result = mysqli_query($conn, $query);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td class='user-data'><input type='text' value='" . $row['id'] . "'></td>";
                                    echo "<td class='user-data'><input type='text' name='user_id' value='" . $row['user_id'] . "'></td>";
                                    echo "<td class='user-data'><input type='text' name='user_name' value='" . $row['user_name'] . "'></td>";
                                    echo "<td class='user-data'><input type='text' name='user_email' value='" . $row['user_email'] . "'></td>";
                                    echo "<td class='user-data'><input type='text' name='user_phone' value='" . $row['user_phone'] . "'></td>";
                                    echo "<td class='user-data'><input type='text' name='user_address' value='" . $row['user_address'] . "'></td>";
                                    echo "<td class='user-data'>";
                                    echo "<select name='payment_method'>";
                                    $categories = array("cash", "card"); 
                                    foreach ($categories as $category) {
                                        if ($category == $row['payment_method']) {
                                            echo "<option value='$category' selected>$category</option>";
                                        } else {
                                            echo "<option value='$category'>$category</option>";
                                        }
                                    }
                                    echo "</select>";
                                    echo "</td>";
                                    echo "<td class='user-data'><input type='text' name='product_ids' value='" . $row['product_ids'] . "'></td>";
                                    echo "<td class='user-data'><input type='text' name='total' value='" . $row['total'] . "'></td>";
                                    echo "<td><button type='submit' name='edit_order' value='save' class='dark-bttn edit-order-bttn' data-order-id='" . $row['id'] . "'>Save</button></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No orders found</td></tr>";
                            }
                            mysqli_close($conn);
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </section>
    </main>

    <script src="./admin.js"></script>
</body>

</html>
