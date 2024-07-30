<?php
session_start();
include 'db.php';

$login_error = '';
$register_error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        // Handle login
        $email = $_POST['login_email'];
        $password = $_POST['login_password'];

        $sql = "SELECT user_id, username, password FROM Users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($user_id, $username, $hashed_password);
        $stmt->fetch();

        if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            $login_error = 'Invalid email or password';
        }

        $stmt->close();
    } elseif (isset($_POST['register'])) {
        // Handle registration
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];

        $sql = "INSERT INTO Users (username, email, password, first_name, last_name, address, phone) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $username, $email, $password, $first_name, $last_name, $address, $phone);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $register_error = 'Registration failed. Please try again.';
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Register - PetCare</title>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 400px;
            max-width: 100%;
            text-align: center;
            animation: fadeIn 0.5s ease forwards;
            opacity: 0;
        }

        .form-container.active {
            opacity: 1;
        }

        .form-container h3 {
            margin-bottom: 20px;
            color: #333;
        }

        .input-box {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            transition: border-color 0.3s;
        }

        .input-box:focus {
            border-color: #e79110;
        }

        .btn {
            background-color: #eb8f05;
            color: #fff;
            padding: 10px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            outline: none;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #c06108;
        }

        .error {
            color: red;
            margin-top: 10px;
            text-align: left;
        }

        .switch-btn {
            margin-top: 20px;
            text-align: center;
        }

        .switch-btn a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s;
        }

        .switch-btn a:hover {
            color: #4caf50;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="form-container active">
        <form action="login.php" method="POST" class="login-form">
            <h3>Login</h3>
            <input type="text" name="login_email" placeholder="Enter your email" class="input-box" required>
            <input type="password" name="login_password" placeholder="Enter your password" class="input-box" required>
            <input type="submit" name="login" value="Login" class="btn">
            <p class="error"><?php echo $login_error; ?></p>
            <div class="switch-btn">
                <a href="#" onclick="showRegisterForm()">Don't have an account? Register here.</a>
            </div>
        </form>
        <form action="login.php" method="POST" class="register-form" style="display: none;">
            <h3>Register</h3>
            <input type="text" name="username" placeholder="Username" class="input-box" required>
            <input type="email" name="email" placeholder="Email" class="input-box" required>
            <input type="password" name="password" placeholder="Password" class="input-box" required>
            <input type="text" name="first_name" placeholder="First Name" class="input-box">
            <input type="text" name="last_name" placeholder="Last Name" class="input-box">
            <input type="text" name="address" placeholder="Address" class="input-box">
            <input type="text" name="phone" placeholder="Phone" class="input-box">
            <input type="submit" name="register" value="Register" class="btn">
            <p class="error"><?php echo $register_error; ?></p>
            <div class="switch-btn">
                <a href="#" onclick="showLoginForm()">Already have an account? Login here.</a>
            </div>
        </form>
    </div>

    <script>
        function showRegisterForm() {
            document.querySelector('.login-form').style.display = 'none';
            document.querySelector('.register-form').style.display = 'block';
            document.querySelector('.form-container').classList.add('active');
        }

        function showLoginForm() {
            document.querySelector('.login-form').style.display = 'block';
            document.querySelector('.register-form').style.display = 'none';
            document.querySelector('.form-container').classList.add('active');
        }
    </script>
</body>
</html>
