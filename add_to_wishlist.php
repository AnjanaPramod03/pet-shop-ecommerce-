<?php
// Include your database connection
include 'db.php';

// Check if product ID is set
if (isset($_GET['product_id'])) {
    $user_id = 1; // Assuming user is logged in and user ID is 1
    $product_id = $_GET['product_id'];

    // Check if the product already exists in the wishlist
    $check_sql = "SELECT * FROM Wishlist WHERE user_id = $user_id AND product_id = $product_id";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // Product already exists in the wishlist
        echo 'Product already exists in the wishlist.';
    } else {
        // Add product to the wishlist
        $insert_sql = "INSERT INTO Wishlist (user_id, product_id) VALUES ($user_id, $product_id)";
        if (mysqli_query($conn, $insert_sql)) {
            echo 'Product added to wishlist successfully.';
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
