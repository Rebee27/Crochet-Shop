<?php
// Include the configuration file
include 'config.php';

// Start the session
session_start();

$loggedIn = isset($_SESSION['user_id']) || isset($_SESSION['admin_id']);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crochet Cozy</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="./utils/favicon.png">
    <script src="https://kit.fontawesome.com/9c00960078.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include 'header.php' ?>

    <div class="hero">
        <div class="hero-content">
            <h1>Welcome to</h1>
            <h2>Our Handmade Crochet Shop</h2>
            <p>Discover the charm of handcrafted crochet creations designed to add that cosy touch to your home and
                wardrobe.</p>
            <a href="about.php" class="dark-bttn">About us</a>
            <a href="product.php" class="dark-bttn">See Products</a>
        </div>
        <img src="./utils/background2.jpg" alt="Handmade Crochet Shop">
    </div>

    <section class="columns">
        <div class="column">
            <div class="title">
                <i class="fas fa-solid fa-signature"></i>
                <h2>Our Signature</h2>
            </div>

            <p>At Crochet Cozy, we take pride in our distinctive styles and patterns that set our handmade crochet items
                apart.</p>
            <a href="about.php" class="light-bttn">More Details...</a>
        </div>

        <div class="column">
            <div class="title">
                <i class="fas fa-fire"></i>
                <h2>Unique Yarns</h2>
            </div>

            <p>We carefully select high-quality yarns that are both beautiful and durable, ensuring each item is as
                functional as it is charming.</p>
        </div>

        <div class="column">
            <div class="title">
                <i class="fas fa-solid fa-clock"></i>
                <h2>Customizable</h2>
            </div>

            <p>Your vision meets our craftsmanship. Create personalized crochet items that reflect your style and fit
                your space perfectly.</p>
        </div>

        <div class="column">
            <div class="title">
                <i class="fas fa-solid fa-cloud"></i>
                <h2>Eco-Friendly</h2>
            </div>

            <p>Committed to sustainability, we use eco-friendly materials whenever possible, crafting with care for the
                planet and future generations.</p>
        </div>
    </section>

    <footer>

    </footer>

</body>

</html>