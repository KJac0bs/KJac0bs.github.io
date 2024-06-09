<?php

$conn = mysqli_connect("localhost", "root", "", "pear_pools_db");

if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if(isset($_POST["add_to_cart"])){

   $product_name = $_POST["product_name"];
   $product_price = $_POST["product_price"];
   $product_image = $_POST["product_image"];
   $product_quantity = 1;

   $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name'");

   if(mysqli_num_rows($select_cart) > 0){
      $message[] = "product already added to cart";
   }else{
      $insert_product = mysqli_query($conn, "INSERT INTO `cart`(name, price, image, quantity) VALUES('$product_name', '$product_price', '$product_image', '$product_quantity')");
      $message[] = "product added to cart succesfully";
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products</title>
    <link rel="stylesheet" href="css/main.css">
    <link
    href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Round|Material+Icons+Sharp|Material+Icons+Two+Tone"
    rel="stylesheet"/>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <h1>Pear Pools</h1>
            </div>
            <ul class="nav_links">
                <li><a href="index.html">Home</a></li>
                <li><a href="services.html">Services</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="quote.html" class="get_quote_button">Get Quote</a></li>
            </ul>
        </nav>

    </header>

    <div class="services_banner">
        <img src="images\products_banner.jpg" alt="services_banner">
        <div class="overlay_heading">Our Products</div>
    </div>

    <div class="gradient_background">
        <section class="shop_section">
            <div class="category_cart_container">
                    <button class="category_button">All</button>
                    <button class="category_button">Auto Pool Cleaners & Parts</button>
                    <button class="category_button">Cleaning Equipment & Accessories</button>
                    <button class="category_button">Chemicals</button>

                    <a href="cart.php">
                        <img src="images\cart.png" alt="cart" class="cart_icon">
                    </a>
            </div>

            <div class="shop_content">
                    <?php
                    $select_products = mysqli_query($conn, "SELECT * FROM `products`");
                    if(mysqli_num_rows($select_products) > 0){
                        while($fetch_product = mysqli_fetch_assoc($select_products)){
                    ?>

                    <form action="" method="post">
                        <div class="product_box">
                            <img src="images\product_page_images\New2/<?php echo $fetch_product["image"]; ?>" alt="" class="product_image">
                            <h3><?php echo $fetch_product["name"]; ?></h3>
                            <div class="price">R<?php echo $fetch_product["price"]; ?></div>
                            <input type="hidden" name="product_name" value="<?php echo $fetch_product["name"]; ?>">
                            <input type="hidden" name="product_price" value="<?php echo $fetch_product["price"]; ?>">
                            <input type="hidden" name="product_image" value="<?php echo $fetch_product["image"]; ?>">
                            <input type="submit" class="add_cart_button" value="Add to cart" name="add_to_cart">
                        </div>
                    </form>
                    <?php
                        };
                    };
                    ?>
            </div>
        </section>

        <footer>
            <div class="footer_section">
                <div class="logo_section">
                    <h1>Pear Pools</h1>
                </div>
                <div class="contact_details_section">
                    <h4>Contact Us</h4>
                    <p>Email: info@pearpools.co.za</p>
                    <h4>Operating Hours</h4>
                    <p>Sunday - Friday: 2pm - 6pm</p>
                    <p>Saturday: Closed</p>
                    <p>Public Holidays: Closed</p>
                </div>

                <div class="feedback_section">
                    <form action="feedback.php" method="post">
                        <div class="rating">
                            <div class="rating_question">
                                <div class="rating_title">Rate us</div>
                                <div class="rating_content">How was our service?</div>
                            </div>
                            <div class="rating_stars">
                                <input type="radio" name="rating1" id="r11" value="5">
                                <label for="r11" class="star"></label>
            
                                <input type="radio" name="rating1" id="r12" value="4">
                                <label for="r12" class="star"></label>
            
                                <input type="radio" name="rating1" id="r13" value="3">
                                <label for="r13" class="star"></label>
            
                                <input type="radio" name="rating1" id="r14" value="2">
                                <label for="r14" class="star"></label>
            
                                <input type="radio" name="rating1" id="r15" value="1">
                                <label for="r15" class="star"></label>
                            </div>
            
                            <div class="feedback">
                                <textarea name="" id="feedback" placeholder="Give us some feedback"></textarea>
                                <button type="submit" class="feedback_button">Submit Feedback</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </footer>
    </div>

    <script src="main.js"></script>
    
</body>
</html>

