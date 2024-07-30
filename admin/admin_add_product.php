<?php

include 'db.php';
include 'admin_header.php';

// Handle form submission for adding a product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];
    $category = $_POST['category'];
    $image = $_FILES['image']['name'];
    $target = "../uploads/" . basename($image);

    $sql = "INSERT INTO Products (name, description, price, stock_quantity, category, image_url) 
            VALUES ('$name', '$description', '$price', '$stock_quantity', '$category', '$image')";

    if ($conn->query($sql) === TRUE && move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        echo "New product added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle form submission for updating a product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_product'])) {
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];
    $category = $_POST['category'];
    $image = $_FILES['image']['name'];
    $target = "../uploads/" . basename($image);

    if ($image) {
        $sql = "UPDATE Products SET name='$name', description='$description', price='$price', 
                stock_quantity='$stock_quantity', category='$category', image_url='$image' 
                WHERE product_id='$product_id'";
    } else {
        $sql = "UPDATE Products SET name='$name', description='$description', price='$price', 
                stock_quantity='$stock_quantity', category='$category' 
                WHERE product_id='$product_id'";
    }

    if ($conn->query($sql) === TRUE) {
        if ($image) move_uploaded_file($_FILES['image']['tmp_name'], $target);
        echo "Product updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle form submission for deleting a product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_product'])) {
    $product_id = $_POST['product_id'];

    $sql = "DELETE FROM Products WHERE product_id='$product_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Product deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch products for display
$products = $conn->query("SELECT * FROM Products");

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Add Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #343a40;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #495057;
        }
        input[type="text"], input[type="number"], input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #f58e18;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #eb993c;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #dee2e6;
        }
        th, td {
            padding: 10px;
            text-align: left;
            color: #495057;
        }
        th {
            background-color: #e9ecef;
        }
        .actions {
            display: flex;
            gap: 5px;
        }
        .btn-update {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-update:hover {
            background-color: #0056b3;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Add New Product</h1>
    <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" id="product_id" name="product_id">

        <label for="name">Product Name</label>
        <input type="text" id="name" name="name" required>

        <label for="description">Description</label>
        <input type="text" id="description" name="description" required>

        <label for="price">Price</label>
        <input type="number" id="price" name="price" step="0.01" required>

        <label for="stock_quantity">Stock Quantity</label>
        <input type="number" id="stock_quantity" name="stock_quantity" required>

        <label for="category">Category</label>
        <input type="text" id="category" name="category" required>

        <label for="image">Image</label>
        <input type="file" id="image" name="image">

        <input type="submit" name="add_product" value="Add Product">
        <input type="submit" name="update_product" value="Update Product">
    </form>

    <h1>Product List</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Stock Quantity</th>
            <th>Category</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        <?php if ($products->num_rows > 0): ?>
            <?php while($row = $products->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['product_id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><?php echo $row['stock_quantity']; ?></td>
                    <td><?php echo $row['category']; ?></td>
                    <td><img src="../uploads/<?php echo $row['image_url']; ?>" width="50" height="50"></td>
                    <td>
                        <div class="actions">
                            <button class="btn-update" onclick="fillForm('<?php echo $row['product_id']; ?>', '<?php echo $row['name']; ?>', '<?php echo $row['description']; ?>', '<?php echo $row['price']; ?>', '<?php echo $row['stock_quantity']; ?>', '<?php echo $row['category']; ?>', '<?php echo $row['image_url']; ?>')">Update</button>
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                <input type="submit" name="delete_product" value="Delete" class="btn-delete">
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="8">No products found</td>
            </tr>
        <?php endif; ?>
    </table>
</div>

<script>
    function fillForm(id, name, description, price, stock, category, image) {
        document.getElementById('product_id').value = id;
        document.getElementById('name').value = name;
        document.getElementById('description').value = description;
        document.getElementById('price').value = price;
        document.getElementById('stock_quantity').value = stock;
        document.getElementById('category').value = category;
        // Handle image preview or change logic here if needed
    }
</script>

</body>
</html>
