<?php

$conn = mysqli_connect("localhost", "root", "", "pear_pools_db");

if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if(isset($_POST["update_update_btn"])){
    $update_value = $_POST["update_quantity"];
    $update_id = $_POST["update_quantity_id"];
    $update_quantity_query = mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_value' WHERE ID = '$update_id'");
}

if(isset($_GET["remove"])){
    $remove_id = $_GET["remove"];
    mysqli_query($conn, "DELETE FROM `cart` WHERE ID = '$remove_id'");
}

if(isset($_GET["delete_all"])){
    mysqli_query($conn, "DELETE FROM `cart`");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Cart</title>
    <link rel="stylesheet" href="css/main.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Round|Material+Icons+Sharp|Material+Icons+Two+Tone" rel="stylesheet"/>
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
        <img src="images/quote_banner.jpg" alt="services_banner">
        <div class="overlay_heading">Your Cart</div>
    </div>

    <div class="gradient_background">
        <div class="container">
        <section class="shopping_cart">
            <table>
                <thead>
                    <th></th>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th></th>
                </thead>
                <tbody>
                    <?php 
                    $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
                    $grand_total = 0;
                    if(mysqli_num_rows($select_cart) > 0){
                        while($fetch_cart = mysqli_fetch_assoc($select_cart)){
                    ?>

                    <tr class="table_row_content">
                        <td><img src="images\product_page_images\New2/<?php echo $fetch_cart["image"]; ?>" height="100" alt=""></td>
                        <td><?php echo $fetch_cart["name"]; ?></td>
                        <td>
                        <form action="" method="post">
                            <input type="hidden" name="update_quantity_id"  value="<?php echo $fetch_cart["ID"]; ?>" >
                            <input type="number" name="update_quantity" min="1"  value="<?php echo $fetch_cart["quantity"]; ?>" >
                            <input type="submit" value="Update" name="update_update_btn">
                        </form>   
                        </td>
                        <td>R<?php echo $sub_total = number_format($fetch_cart["price"] * $fetch_cart["quantity"]); ?></td>
                        <td><a href="cart.php?remove=<?php echo $fetch_cart["ID"]; ?>" onclick="return confirm('remove item from cart?')" class="delete-btn"><img src="images\product_page_images\trash_icon.png"
                         alt="Remove Item" class="remove_icon"></a></td>
                    </tr>

                    <?php
                    $grand_total += $sub_total;  
                        };
                    };
                    ?>

                </tbody>
            </table>
            
            <div class="cart_total_section">
                <span class="cart_total_title">Total:</span>
                <span class="cart_total_value">R<?php echo $grand_total; ?></span>
            </div>

            <div class="cart_buttons_container">
                <a href="products.php" class="continue_shopping_button">Continue Shopping</a>
                <a href="cart.php?delete_all" onclick="return confirm('are you sure you want to delete all?');" class="clear_cart_button">Clear Cart</a>
                <a href="checkout.php" class="checkout_button <?= ($grand_total > 1)?'':'disabled'; ?>">Procced to Checkout</a>
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
                                <textarea id="feedback" placeholder="Give us some feedback"></textarea>
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
