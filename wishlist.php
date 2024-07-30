<?php
session_start();
include 'db.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
  
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <!-- Include CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .wishlist {
            padding: 50px 0;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 0 20px;
        }

        .title {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .wishlist-items {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            grid-gap: 20px;
        }

        .box {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .box:hover {
            transform: translateY(-5px);
        }

        .box .icons {
            display: flex;
            justify-content: flex-end;
            padding: 10px;
        }

        .box .icons a {
            color: #333;
            text-decoration: none;
            margin-left: 10px;
            transition: color 0.3s;
        }

        .box .icons a:hover {
            color: #4caf50;
        }

        .box .image {
            text-align: center;
        }

        .box .image img {
            max-width: 100%;
            height: auto;
        }

        .box .product-desc {
            padding: 20px;
        }

        .box .product-desc h3 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .box .product-desc p.price {
            margin: 10px 0 0;
            font-size: 16px;
            color: #4caf50;
        }

        .empty-wishlist {
            text-align: center;
            color: #333;
        }

        .empty-wishlist i {
            font-size: 50px;
            margin-bottom: 20px;
            color: #999;
        }
    </style>
</head>
<body>
     <?php include 'header.php'; ?>
    <!-- Wishlist Section -->
    <section class="wishlist">
        <div class="container">
            <h2 class="title">Your Wishlist</h2>
            <div class="wishlist-items">
                <?php
                // Include your database connection
                include 'db.php';

                // Fetch wishlist items from the database
                $user_id = 1; // Assuming user is logged in and user ID is 1
                $sql = "SELECT * FROM Wishlist INNER JOIN Products ON Wishlist.product_id = Products.product_id WHERE Wishlist.user_id = $user_id";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Display wishlist item
                        echo '<div class="box">';
                        echo '<div class="icons">';
                        echo '<a href="#"><i class="fas fa-user"></i></a>';
                        echo '<a href="#"><i class="fas fa-heart"></i></a>';
                        echo '<a href="#"><i class="fas fa-shopping-cart"></i></a>';
                        echo '</div>';
                        echo '<div class="image">';
                        echo '<img src="' . $row['image_url'] . '" alt="' . $row['name'] . '">';
                        echo '</div>';
                        echo '<div class="product-desc">';
                        echo '<h3>' . $row['name'] . '</h3>';
                        echo '<p class="price">$' . $row['price'] . '</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="empty-wishlist">';
                    echo '<i class="fas fa-heart"></i>';
                    echo '<p>Your wishlist is empty.</p>';
                    echo '</div>';
                }

                // Close database connection
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </section>
</body>
</html>
