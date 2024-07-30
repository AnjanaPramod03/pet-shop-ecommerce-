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
    <title>PetCare</title>

    <!-- cdn -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <!-- css -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include'header.php'; ?>
    
    <!------------ HOME ------------>
    <section class="home">
        <div class="content">
            <h3>hi welcome to <span>petCare</span></h3>
            <a href="#products" class="btn">shop now</a>
        </div>
    </section>

    <!------------ ABOUT ------------>
    <section class="about" id="about">
        <div class="left-box">
            <img src="./images/about.jpg" alt="" height="450px">
        </div>
        <div class="right-box">
            <h2>Put Your Pet First</h2>
            <h3><span>premium</span> care </h3>
            <p class="kk">more than 200 locations in North America, Camp Bow Wow is the largest pet care franchise
                and offers a
                fun and safe place where pups can romp together in an open-play environment and pricing is
                all-inclusive. We provide pet parents peace of mind because we’re all about Making Dogs Happy.
            </p>
            <a href="login.php" class="btn">shop now</a>
        </div>
    </section>

    <!------------ PRODUCTS ------------>
    <section class="products" id="products">
        <h2 class="title"><span>premium</span> products</h2>
        <div class="products-box">
            <?php
               include 'db.php';

                // Fetch products from the database
                $sql = "SELECT product_id, name, price, image_url,category,description FROM Products";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        $product_id = $row["product_id"];
                        $name = $row["name"];
                        $price = $row["price"];
                        $category = $row["category"];
                        $description = $row["description"];
                        $image_url = $row["image_url"] ? $row["image_url"] : "default.jpg";

                        echo '<div class="box">';
                        echo '    <div class="icons">';
                        echo '        <a href="add_to_cart.php?product_id=' . $product_id . '"><i class="far fa-shopping-cart"></i></a>';
                        echo '        <a href="add_to_wishlist.php?product_id=' . $product_id . '"><i class="far fa-heart"></i></a>';
                        echo '    </div>';
                        echo '    <div class="image">';
                        echo '         <img src="uploads/' . htmlspecialchars($image_url) . '" alt="">';
                        echo '    </div>';
                        echo '    <div class="product-desc">';
                        echo '        <h3>' . htmlspecialchars($name) . '</h3>';
                        echo '        <h4>' . htmlspecialchars($category) . '</h4>';
                        echo '        <p>' . htmlspecialchars($description) . '<p>';
                        
                        echo '        <p class="price">Rs.' . htmlspecialchars($price) . '</p>';
                        echo '    </div>';
                        echo '</div>';
                    }
                } else {
                    echo "0 results";
                }
                $conn->close();
            ?>
        </div>
    </section>

    <!------------ SERVICES ------------>
    <section class="services" id="services">
        <h2 class="title"><span>premium</span> services</h2>
        <div class="service-box">
            <div class="box">
                <div class="icon">
                    <i class="fa fa-dog-leashed"></i>
                </div>
                <h3>pet training</h3>
                <p>
                At Pet Training, we believe in nurturing a strong bond between you and your furry friend. Our experienced trainers use positive reinforcement techniques to teach obedience, agility, and good manners. Whether you have a new puppy or an older dog, our personalized training programs cater to all breeds and temperaments. Join us today to unleash your pet's full potential!
                </p>
                <a href="#">read more</a>
            </div>
            <div class="box">
                <div class="icon">
                    <i class="fa fa-bath"></i>
                </div>
                <h3>spa & grooming</h3>
                <p>
                Treat your beloved pet to a pampering session at our Spa & Grooming salon. Our team of certified groomers provides top-notch services, including bathing, grooming, nail trimming, and styling. With premium products and gentle care, we ensure your pet looks and feels their best. Give your furry friend the luxury treatment they deserve and book an appointment with us today!
                </p>
                <a href="#">read more</a>
            </div>
            <div class="box">
                <div class="icon">
                    <i class="fa fa-file-medical"></i>
                </div>
                <h3>health care</h3>
                <p>
                At Pet Health Care, we prioritize the well-being of your furry companions. Our veterinary experts offer comprehensive health services, including routine check-ups, vaccinations, dental care, and diagnostic testing. With state-of-the-art facilities and compassionate staff, we provide personalized care tailored to your pet's specific needs. Trust us to keep your pet healthy and thriving!
                </p>
                <a href="#">read more</a>
            </div>
            <div class="box">
                <div class="icon">
                    <i class="fa fa-pills"></i>
                </div>
                <h3>pet treatment</h3>
                <p>
                When your pet needs medical attention, trust Pet Treatment to deliver compassionate and effective care. Our experienced veterinarians specialize in treating a wide range of ailments, from minor injuries to chronic conditions. With advanced diagnostics and treatment options, we strive to improve your pet's quality of life and ensure their comfort and recovery. Your pet's health is our priority!
                </p>
                <a href="#">read more</a>
            </div>
            <div class="box">
                <div class="icon">
                    <i class="fa fa-home"></i>
                </div>
                <h3>pet boarding</h3>
                <p>
                Planning a trip? Leave your pet in safe hands at Pet Boarding. Our spacious and comfortable facilities provide a home away from home for your furry friends. With round-the-clock care, supervised playtime, and personalized attention, we ensure your pet enjoys a stress-free stay while you're away. Rest easy knowing your pet is in a loving and secure environment!
                </p>
                <a href="#">read more</a>
            </div>
            <div class="box">
                <div class="icon">
                    <i class="fa fa-steak"></i>
                </div>
                <h3>pet feeding</h3>
                <p>
                Ensure your pet receives the nutrition they need with Pet Feeding. Our nutritionists create customized meal plans tailored to your pet's age, breed, and dietary requirements. We offer a variety of high-quality pet food options, including premium dry food, wet food, and natural treats. Give your pet the nourishment they deserve and support their overall health and vitality with Pet Feeding!
                </p>
                <a href="#">read more</a>
            </div>
        </div>
    </section>

    <!------------ FOOTER ------------>
    <footer class="footer">
        <div class="box-container flex">
            <div class="box">
                <h2>contact</h2>
                <ul class="footer-list flex">
                    <li>
                        <i class="fa fa-building"></i>
                        <address>Petcare , Kegalle</address>
                    </li>
                    <li>
                        <i class="fa fa-phone"></i>
                        <p>01124574685</p>
                    </li>
                    <li>
                        <i class="fa fa-envelope"></i>
                        <p>petcare_info@petcare.com</p>
                    </li>
                </ul>
            </div>
            <div class="box">
                <h2>products</h2>
                <ul class="footer-list">
                    <li><a href="#">accessories</a></li>
                    <li><a href="#">dry food</a></li>
                    <li><a href="#">fresh food</a></li>
                    <li><a href="#">shampoo</a></li>
                </ul>
            </div>
            <div class="box">
                <h2>our company</h2>
                <ul class="footer-list">
                    <li><a href="#">terms and conditions</a></li>
                    <li><a href="#">about us</a></li>
                    <li><a href="#">secure payment</a></li>
                </ul>
            </div>
            <div class="box">
                <h2>services</h2>
                <ul class="footer-list">
                    <li><a href="#">training</a></li>
                    <li><a href="#">spa & grooming</a></li>
                    <li><a href="#">health</a></li>
                    <li><a href="#">treatment</a></li>
                    <li><a href="#">boarding</a></li>
                    <li><a href="#">feeding</a></li>
                </ul>
            </div>
        </div>
    </footer>
    <script src="./script.js"></script>
</body>
</html>