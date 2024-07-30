<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: login.php');
    exit();
}

include 'db.php';
include 'admin_header.php';

// Fetch all orders and their items
$sql = "SELECT 
            Orders.order_id, Orders.total_amount, Orders.order_date, Orders.shipping_address, Orders.status,
            Users.username,
            OrderItems.product_id, OrderItems.quantity, OrderItems.price,
            Products.name
        FROM Orders
        JOIN Users ON Orders.user_id = Users.user_id
        JOIN OrderItems ON Orders.order_id = OrderItems.order_id
        JOIN Products ON OrderItems.product_id = Products.product_id
        ORDER BY Orders.order_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #ff6600;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .order-items {
            margin-top: 10px;
        }
        .order-items th, .order-items td {
            background-color: #fff;
        }
        .order-details {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 10px;
            background-color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>View Orders</h1>
        <?php
        if ($result->num_rows > 0) {
            $current_order_id = 0;
            while ($row = $result->fetch_assoc()) {
                if ($current_order_id != $row['order_id']) {
                    if ($current_order_id != 0) {
                        echo '</table></div>';
                    }
                    $current_order_id = $row['order_id'];
                    echo '<div class="order-details">';
                    echo '<h2>Order ID: ' . $row['order_id'] . '</h2>';
                    echo '<p><strong>Customer:</strong> ' . htmlspecialchars($row['username']) . '</p>';
                    echo '<p><strong>Order Date:</strong> ' . $row['order_date'] . '</p>';
                    echo '<p><strong>Total Amount:</strong> $' . $row['total_amount'] . '</p>';
                    echo '<p><strong>Shipping Address:</strong> ' . htmlspecialchars($row['shipping_address']) . '</p>';
                    echo '<p><strong>Status:</strong> ' . htmlspecialchars($row['status']) . '</p>';
                    echo '<table class="order-items">';
                    echo '<tr><th>Product Name</th><th>Quantity</th><th>Price</th></tr>';
                }
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['quantity']) . '</td>';
                echo '<td>$' . htmlspecialchars($row['price']) . '</td>';
                echo '</tr>';
            }
            echo '</table></div>';
        } else {
            echo '<p>No orders found.</p>';
        }
        $conn->close();
        ?>
    </div>
</body>
</html>
