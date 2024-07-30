<?php
// Include your database connection
include 'db.php';

// Check if product ID is set
if (isset($_GET['product_id'])) {
    $user_id = 1; // Assuming user is logged in and user ID is 1
    $product_id = $_GET['product_id'];

    // Check if the product already exists in the cart
    $check_sql = "SELECT * FROM Cart WHERE user_id = $user_id AND product_id = $product_id";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // Product already exists in the cart
        echo 'Product already exists in the cart.';
    } else {
        // Add product to the cart
        $insert_sql = "INSERT INTO Cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, 1)";
        if (mysqli_query($conn, $insert_sql)) {
            echo 'Product added to cart successfully.';
        } else {
            echo 'Error: ' . mysqli_error($conn);
        }
    }
} else {
    echo 'Product ID is not set.';
}

// Close database connection
mysqli_close($conn);
?>
