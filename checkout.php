<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch user details
$user_id = $_SESSION['user_id'];
$user_query = "SELECT * FROM Users WHERE user_id = $user_id";
$user_result = $conn->query($user_query);
$user = $user_result->fetch_assoc();

// Fetch cart items
$cart_query = "SELECT Cart.product_id, Products.name, Products.price, Cart.quantity FROM Cart JOIN Products ON Cart.product_id = Products.product_id WHERE Cart.user_id = $user_id";
$cart_result = $conn->query($cart_query);

// Calculate total amount
$total_amount = 0;
while ($cart_item = $cart_result->fetch_assoc()) {
    $total_amount += $cart_item['price'] * $cart_item['quantity'];
}
$cart_result->data_seek(0); // Reset result pointer for fetching again in HTML

// Handle checkout form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $shipping_address = $_POST['shipping_address'];

    // Insert order
    $insert_order = "INSERT INTO Orders (user_id, total_amount, shipping_address) VALUES ($user_id, $total_amount, '$shipping_address')";
    if ($conn->query($insert_order) === TRUE) {
        $order_id = $conn->insert_id;

        // Insert order items
        while ($cart_item = $cart_result->fetch_assoc()) {
            $product_id = $cart_item['product_id'];
            $quantity = $cart_item['quantity'];
            $price = $cart_item['price'];
            $insert_order_item = "INSERT INTO OrderItems (order_id, product_id, quantity, price) VALUES ($order_id, $product_id, $quantity, $price)";
            $conn->query($insert_order_item);

            // Update product stock quantity
            $update_product = "UPDATE Products SET stock_quantity = stock_quantity - $quantity WHERE product_id = $product_id";
            $conn->query($update_product);
        }

        // Clear the cart
        $clear_cart = "DELETE FROM Cart WHERE user_id = $user_id";
        $conn->query($clear_cart);

        // Redirect to a success page
        header('Location: order_success.php');
        exit();
    } else {
        echo "Error: " . $insert_order . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .cart-items, .checkout-form {
            margin-bottom: 20px;
        }
        .cart-items table {
            width: 100%;
            border-collapse: collapse;
        }
        .cart-items table, th, td {
            border: 1px solid #ddd;
        }
        .cart-items th, .cart-items td {
            padding: 8px;
            text-align: left;
        }
        .cart-items th {
            background-color: #f2f2f2;
        }
        .checkout-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .checkout-form input[type="text"], .checkout-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }
        .checkout-form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .checkout-form input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Checkout</h1>
        <div class="cart-items">
            <h2>Your Cart</h2>
            <table>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
                <?php while ($cart_item = $cart_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($cart_item['name']); ?></td>
                    <td><?php echo htmlspecialchars($cart_item['price']); ?></td>
                    <td><?php echo htmlspecialchars($cart_item['quantity']); ?></td>
                    <td><?php echo htmlspecialchars($cart_item['price'] * $cart_item['quantity']); ?></td>
                </tr>
                <?php endwhile; ?>
                <tr>
                    <td colspan="3"><strong>Total Amount</strong></td>
                    <td><strong><?php echo $total_amount; ?></strong></td>
                </tr>
            </table>
        </div>
        <div class="checkout-form">
            <h2>Shipping Information</h2>
            <form method="POST" action="">
                <label for="shipping_address">Shipping Address</label>
                <input type="text" id="shipping_address" name="shipping_address" required value="<?php echo htmlspecialchars($user['address']); ?>">
                <input type="submit" value="Place Order">
            </form>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>
