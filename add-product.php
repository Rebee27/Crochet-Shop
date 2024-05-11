<?php
include 'config.php';

// Verificăm dacă s-au trimis toate datele necesare prin POST
if (isset($_POST['name'], $_POST['price'], $_POST['category'], $_FILES['image'], $_POST['description'], $_POST['short_description'], $_POST['rating'])) {
    // Preluăm datele din request
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $short_description = $_POST['short_description'];
    $rating = $_POST['rating'];

    // Verificăm dacă imaginea a fost încărcată cu succes
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Obținem informații despre imagine
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];
        $image_type = $_FILES['image']['type'];

        // Continuăm procesarea imaginii...
        // Verificăm tipul de fișier pentru a ne asigura că este o imagine
        $allowed_types = array('image/jpeg', 'image/png', 'image/gif');
        if (!in_array($image_type, $allowed_types)) {
            echo "Only JPEG, PNG, and GIF files are allowed.";
        } else {
            // Setăm o dimensiune maximă pentru fișierul
            $max_size = 5 * 1024 * 1024; // 5 MB
            if ($image_size > $max_size) {
                echo "The file size exceeds the maximum allowed size (5 MB).";
            } else {
                // Generăm un nume de fișier unic
                $unique_name = uniqid('product_') . '_' . $image_name;
                // Construim calea către directorul de destinație pentru imagine
                $target_path = 'uploads/' . $unique_name;
                // Mutăm fișierul încărcat în directorul de destinație
                if (move_uploaded_file($image_tmp_name, $target_path)) {
                    // Imaginea a fost încărcată cu succes, continuăm cu inserarea datelor în baza de date

                    // Scăpăm de caracterele speciale pentru a preveni SQL injection
                    $name = mysqli_real_escape_string($conn, $name);
                    $description = mysqli_real_escape_string($conn, $description);
                    $price = mysqli_real_escape_string($conn, $price);
                    $category = mysqli_real_escape_string($conn, $category);
                    $short_description = mysqli_real_escape_string($conn, $short_description);
                    $rating = mysqli_real_escape_string($conn, $rating);
                    $image = mysqli_real_escape_string($conn, $target_path);

                    // Inserăm datele în baza de date, inclusiv calea imaginii
                    $query = "INSERT INTO products (name, price, category, description, short_description, rating, image) VALUES ('$name', '$price', '$category', '$description', '$short_description', '$rating', '$image')";
                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        // Redirecționare către pagina products.php
                        header("Location: products.php");
                        exit;
                    } else {
                        echo "Error at adding product: " . mysqli_error($conn);
                    }
                } else {
                    echo "Error occurred while uploading the image.";
                }
            }
        }
    } else {
        echo "No image uploaded or an error occurred.";
    }
} else {
    echo "Not all required fields are set.";
}
?>
