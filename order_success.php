<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff5e6;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            text-align: center;
            padding: 50px;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h1 {
            color: #ff6600;
            font-size: 48px;
            margin-bottom: 20px;
        }
        p {
            color: #333;
            font-size: 18px;
            line-height: 1.6;
        }
        .btn {
            display: inline-block;
            margin-top: 30px;
            padding: 15px 30px;
            font-size: 18px;
            color: #fff;
            background-color: #ff6600;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #e65c00;
        }
        .thank-you-img {
            width: 150px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Thank You!</h1>
        <p>Your order has been successfully placed. We are delighted to inform you that your products will be delivered right to your doorstep within the next 2 days.</p>
        <p>Our cash on delivery service ensures a hassle-free payment experience. Get ready to enjoy our premium products with ease and convenience.</p>
        <p>If you have any questions or need further assistance, feel free to contact our customer service. Thank you for choosing PetCare! "petcare team"</p>
        <a href="index.php" class="btn">Continue Shopping</a>
        <img src="images/thank-you.png" alt="Thank You" class="thank-you-img">
    </div>
</body>
</html>
