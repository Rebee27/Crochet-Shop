<?php
$loggedIn = isset($_SESSION['user_id']) || isset($_SESSION['admin_id']);
?>



<header>
    <div class="logo">
        <img src=".\utils\logo.png" id="logo">
    </div>

    <div class="title">
        <h1>Crochet Cozy</h1>
    </div>

    <div class="pages">
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="my-account.php">Account</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="products.php">Products</a></li>
                <?php
                // Check if the user is logged in
                if ($loggedIn) {
                    // Check if the user is an admin
                    if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
                        // Display link to admin page
                        echo '<li><a href="admin.php">Admin</a></li>';
                    }
                }
                ?>
            </ul>
        </nav>
    </div>


    <div class="icons">
        <a href="my-account.php">
            <?php
            if ($loggedIn) { ?><i class="fas fa-solid fa-user-check"></i><?php } else { ?> <i
                    class="fa fa-regular fa-user"></i><?php } ?>
        </a>
        <a href="cart.php"><i class="fas fa-solid fa-cart-plus"></i></a>
    </div>

</header>