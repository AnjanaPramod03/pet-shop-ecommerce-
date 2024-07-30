<?php
session_start();
include 'db.php';
include 'admin_header.php';

// Check if the user is an admin
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: admin_login.php');
    exit();
}

// Fetch counts from the database
$user_count = $conn->query("SELECT COUNT(*) AS count FROM Users")->fetch_assoc()['count'];
$product_count = $conn->query("SELECT COUNT(*) AS count FROM Products")->fetch_assoc()['count'];
$order_count = $conn->query("SELECT COUNT(*) AS count FROM Orders")->fetch_assoc()['count'];
$pending_order_count = $conn->query("SELECT COUNT(*) AS count FROM Orders WHERE status = 'Pending'")->fetch_assoc()['count'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }
     
        .container {
            width: 80%;
            margin: 20px auto;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }
        .box {
            background: #fff;
            width: 300px;
            margin: 10px;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
        }
        .box h3 {
            margin-bottom: 20px;
            color: #333;
        }
        .box p {
            font-size: 24px;
            margin: 0;
            color: #ff6600;
        }
        .box .special-details {
            font-size: 18px;
            color: #555;
        }
        .logout-btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background: #ff6600;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .logout-btn:hover {
            background: #e55d00;
        }
    </style>
</head>
<body>
    
    <div class="header">
        <h1>Admin Dashboard</h1>
    </div>
    <div class="container">
        <div class="box">
            <h3>Total Users</h3>
            <p><?php echo $user_count; ?></p>
        </div>
        <div class="box">
            <h3>Total Products</h3>
            <p><?php echo $product_count; ?></p>
        </div>
        <div class="box">
            <h3>Total Orders</h3>
            <p><?php echo $order_count; ?></p>
        </div>
        <div class="box">
            <h3>Pending Orders</h3>
            <p><?php echo $pending_order_count; ?></p>
        </div>
      
    </div>
   
</body>
</html>
