<?php
session_start();
include 'db.php';


if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
  
    header("Location: login.php");
    exit(); 
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        foreach ($_POST['quantities'] as $cart_id => $quantity) {
            $sql = "UPDATE Cart SET quantity = ? WHERE cart_id = ? AND user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $quantity, $cart_id, $user_id);
            $stmt->execute();
            $stmt->close();
        }
    } elseif (isset($_POST['remove'])) {
        $cart_id = $_POST['remove'];
        $sql = "DELETE FROM Cart WHERE cart_id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $cart_id, $user_id);
        $stmt->execute();
        $stmt->close();
    }
}

$sql = "SELECT Cart.cart_id, Products.name, Products.price, Products.image_url, Cart.quantity 
        FROM Cart 
        INNER JOIN Products ON Cart.product_id = Products.product_id 
        WHERE Cart.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
$total = 0;

while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    $total += $row['price'] * $row['quantity'];
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <!-- Include CSS -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        
        .box-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        
        .action i {
            color: #fff;
            margin: 0 10px;
            cursor: pointer;
        }
        .cart {
            padding: 20px 0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .title {
            font-size: 28px;
            margin-bottom: 20px;
            color: #343a40;
        }
        .cart-items {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .box {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            gap: 15px;
        }
        .icons {
            display: flex;
            gap: 10px;
        }
        .icons .remove-btn {
            background: none;
            border: none;
            color: #ff6b6b;
            font-size: 18px;
            cursor: pointer;
        }
        .image img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
        }
        .product-desc {
            flex-grow: 1;
        }
        .product-desc h3 {
            font-size: 20px;
            margin: 0;
        }
        .product-desc .price {
            font-size: 18px;
            color: #28a745;
        }
        .quantity-input {
            width: 50px;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ced4da;
        }
        .cart-total {
            text-align: right;
            font-size: 22px;
            margin-top: 20px;
        }
        .cart-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }
        .btn {
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #218838;
        }
        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="box-container">
            <a href="index.php" class="logo"><i class="fa fa-paw"></i> petCare</a>
            <nav class="navbar">
                <ul class="menuList">
                    <li><a href="index.php#home">home</a></li>
                    <li><a href="index.php#about">about</a></li>
                    <li><a href="index.php#shop">shop</a></li>
                    <li><a href="index.php#services">services</a></li>
                </ul>
            </nav>
            <div class="action">
                <i class="far fa-search"></i>
                <i class="far fa-user" id="login-btn"></i>
                <i class="far fa-heart"></i>
                <i class="far fa-shopping-cart"></i>
                <i class="fas fa-bars" id="menu-btn"></i>
            </div>
        </div>
    </header>
    
    <!-- Cart Section -->
    <section class="cart">
        <div class="container">
            <h2 class="title">Your Shopping Cart</h2>
            <form method="POST" action="cart.php">
                <div class="cart-items">
                    <?php if (count($cart_items) > 0): ?>
                        <?php foreach ($cart_items as $item): ?>
                            <div class="box">
                                <div class="icons">
                                    <button type="submit" name="remove" value="<?php echo $item['cart_id']; ?>" class="remove-btn"><i class="far fa-trash-alt"></i></button>
                                </div>
                                <div class="image">
                                    <img src="uploads/<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                </div>
                                <div class="product-desc">
                                    <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                                    <p class="price">Rs.<?php echo number_format($item['price'], 2); ?></p>
                                    <input type="number" name="quantities[<?php echo $item['cart_id']; ?>]" value="<?php echo $item['quantity']; ?>" min="1" class="quantity-input">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Your shopping cart is empty.</p>
                    <?php endif; ?>
                </div>
                <div class="cart-total">
                    <p>Total: Rs.<?php echo number_format($total, 2); ?></p>
                </div>
                <div class="cart-buttons">
                    <button type="submit" name="update" class="btn">Update Cart</button>
                    <a href="checkout.php" class="btn">Proceed to Checkout</a>
                </div>
            </form>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 PetCare. All rights reserved.</p>
    </footer>
    
    <!-- Include JavaScript -->
    <script src="./script.js"></script>
</body>
</html>
