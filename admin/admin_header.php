<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .header {
            background: #ffffff;
            color: #1a1a1a;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header .logo {
            display: flex;
            align-items: center;
        }
        .header .logo img {
            height: 50px;
            margin-right: 10px;
        }
        .header .logo h1 {
            margin: 0;
            font-size: 24px;
        }
        .header .nav-links {
            display: flex;
            align-items: center;
        }
        .header .nav-links a {
            color: #0f0f0f;
            text-decoration: none;
            margin: 0 10px;
            font-size: 18px;
            transition: color 0.3s;
        }
        .header .nav-links a:hover {
            color: #ffd699;
        }
        .logout-btn {
            display: inline-block;
            padding: 10px 20px;
            margin-left: 20px;
            background: #e55d00;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .logout-btn:hover {
            background: #cc5200;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="../images/png-clipart-orange-dog-paw-illustration-dog-bengal-cat-tiger-paw-paw-prints-animals-pet.png" alt="Logo">
            <h1>Pet Care!</h1>
        </div>
        <div class="nav-links">
            <a href="admin_dashboard.php">Dashboard</a>
            <a href="admin_view_orders.php">Orders</a>
            <a href="admin_add_product.php">Products</a>
            <a href="admin_logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
</body>
</html>
