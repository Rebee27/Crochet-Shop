<?php
include 'config.php';

session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$user_data = null;

if ($user_id) {
    $select_user_query = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'");
    $user_data = mysqli_fetch_assoc($select_user_query);
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

    <title>Products</title>
</head>

<body>
    <?php include 'header.php' ?>

    <main class="main-products main-container">

        <section class="search-bar-section">
            <h2>Filters</h2>
            <input type="text" class="search-bar" placeholder="Search...">

            <div class="checkbox-select">
                <div class="option">
                    <input type="checkbox" id="all" value="all">
                    <label for="all">All</label>
                </div>
                <div class="option">
                    <input type="checkbox" id="Kids clothes" value="Kids clothes">
                    <label for="Kids clothes">Kids clothes</label>
                </div>
                <div class="option">
                    <input type="checkbox" id="Winter clothes" value="Winter clothes">
                    <label for="Winter clothes">Winter clothes</label>
                </div>
                <div class="option">
                    <input type="checkbox" id="Toys" value="Toys">
                    <label for="Toys">Toys</label>
                </div>
                <div class="option">
                    <input type="checkbox" id="Crochet Thread" value="Crochet Thread">
                    <label for="Crochet Thread">Crochet Thread</label>
                </div>
                <div class="option">
                    <input type="checkbox" id="Accessories" value="Accessories">
                    <label for="Accessories">Accessories</label>
                </div>
            </div>


        </section>

        <div class="first-section">
            <div class="title-wrapper">
                <h2 class="products-title">Products</h2>
            </div>
            <div class="button-wrapper">
                <?php if ($user_data && $user_data['user_type'] == 'admin'): ?>
                    <button class="dark-bttn add-prod-bttn">Add Product</button>
                <?php endif; ?>
            </div>
        </div>


        <section class="products-container">
            <div class="products">
                <div class="no-products-message" style="display: none;">
                    There are no products in this category!
                </div>

                <?php
                $select_products_query = mysqli_query($conn, "SELECT * FROM products");

                if (mysqli_num_rows($select_products_query) > 0) {
                    while ($product = mysqli_fetch_assoc($select_products_query)) {
                        ?>
                        <div class="product" data-name="<?php echo $product['name']; ?>"
                            data-description="<?php echo $product['description']; ?>"
                            data-rating="<?php echo $product['rating']; ?>" data-price="<?php echo $product['price']; ?>"
                            data-category="<?php echo $product['category']; ?>">
                            <img src="<?php echo $product['image']; ?>">
                            <h3><?php echo $product['name']; ?></h3>
                            <p>$<?php echo $product['price']; ?></p>
                            <p>Category: <?php echo $product['category']; ?></p>
                            <p><?php echo $product['short_description']; ?></p>
                            <form action="cart.php" method="post">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
                                <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
                                <input type="hidden" name="product_image" value="<?php echo $product['image']; ?>">
                                <button type="submit" class="buy-bttn" name="add_to_cart">Add to Cart</button>
                            </form>
                            <button class="dark-bttn see-more-bttn">See More</button>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>There are no products at the moment.</p>";
                }
                ?>
            </div>
        </section>

        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <div class="product-info">
                    <h2 id="modal-product-name"></h2>
                    <img id="modal-product-image" src="" alt="Product Image">
                    <p id="modal-product-price"></p>
                    <p id="modal-product-rating"></p>
                    <form action="cart.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $product['image']; ?>">
                        <button type="submit" class="buy-bttn" name="add_to_cart">Add to Cart</button>
                    </form>
                </div>
                <div class="product-description">
                    <p id="modal-product-category"></p>
                    <p id="modal-product-description"></p>
                </div>
            </div>
        </div>
    </main>

    <div id="modal" class="prod-modal">
        <div class="prod-modal-content">
            <span class="prod-close">&times;</span>
            <div class="prod-info">
                <h2>Add Product</h2>
                <form id="add-product-form" enctype="multipart/form-data" method="POST" action="add-product.php">
                    <div class="form-group">
                        <label for="name">Product Name:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="short-description">Short description:</label>
                        <textarea id="short-description" name="short_description" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" id="price" name="price" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Select Image:</label>
                        <input type="file" id="image" name="image" accept="image/*" required>
                    </div>
                    <div class="form-group">
                        <label for="category">Category:</label>
                        <select id="category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="Kids Clothes">Kids Clothes</option>
                            <option value="Winter Clothes">Winter Clothes</option>
                            <option value="Toys">Toys</option>
                            <option value="Crochet Threads">Crochet Threads</option>
                            <option value="Accessories">Accessories</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="rating">Rating:</label>
                        <input type="number" id="rating" name="rating" min="1" max="5" step="1" required>
                    </div>

                    <button type="submit" class="dark-bttn">Add Product</button>
                </form>
            </div>
        </div>
    </div>



    <script src="./modal.js"></script>
    <script src="./search-bar.js"></script>
    <script src="./add-product-modal.js"></script>



</body>

</html>