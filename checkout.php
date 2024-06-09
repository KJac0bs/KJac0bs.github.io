<?php

$conn = mysqli_connect("localhost", "root", "", "pear_pools_db");

if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if(isset($_POST["final_checkout_button"])){

    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $contact_number = $_POST["contact_number"];
    $email_address = $_POST["email_address"];
    $delivery_address = $_POST["delivery_address"];
    $city = $_POST["city"];
    $postal_code = $_POST["postal_code"];
    $payment_method = $_POST["payment_method"];

    $select_customer_query = mysqli_query($conn, "SELECT customer_ID FROM customers WHERE contact_number = '$contact_number' AND email_address = '$email_address'");
    if(mysqli_num_rows($select_customer_query) > 0) {
        $row = mysqli_fetch_assoc($select_customer_query);
        $customer_ID = $row["customer_ID"];
        $update_customer_query = mysqli_query($conn, "UPDATE `customers` SET first_name='$first_name', last_name='$last_name', contact_number='$contact_number', email_address='$email_address' WHERE customer_ID='$customer_ID'");
    } else {
        $insert_customer_query = mysqli_query($conn, "INSERT INTO `customers` (first_name, last_name, contact_number, email_address) VALUES ('$first_name', '$last_name', '$contact_number', '$email_address')");
        $customer_ID = mysqli_insert_id($conn);
    }

    $cart_query = mysqli_query($conn, "SELECT * FROM `cart`");
    $price_total = 0;
    if(mysqli_num_rows($cart_query) > 0){
       while($product_item = mysqli_fetch_assoc($cart_query)){
          $product_name[] = $product_item["name"] .' ('. $product_item["quantity"] .') ';
          $product_price = number_format($product_item["price"] * $product_item["quantity"]);
          $price_total += $product_price;
       };
    };
 
    $total_product = implode(", ",$product_name);
    $detail_query = mysqli_query($conn, "INSERT INTO `orders` (first_name, last_name, contact_number, email_address, delivery_address, city, postal_code, payment_method, total_products, total_price) VALUES('$first_name','$last_name','$contact_number','$email_address','$delivery_address','$city','$postal_code','$payment_method','$total_product','$price_total')") or die('query failed');
 
    if($cart_query && $detail_query){
        echo "
        <div class='order_message_container'>
            <div class='message_container'>
                <img src='images\product_page_images\close_icon.png' class='close_icon' alt='Close'>
                <h3>Thank you for shopping with us!</h3>
                <a href='products.php' class='btn'>Continue Shopping</a>
            </div>
        </div>
       ";
    }
 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Services</title>
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
        <img src="images\quote_banner.jpg" alt="services_banner">
        <div class="overlay_heading">Checkout</div>
    </div>

    <div class="gradient_background">
        <div class="checkout_section">
            <div class="billing_container">
                <form action="" method="post">
                    <div class="row">
                        <div class="form_section">
                            <label for="first_name">First Name <span>*</span></label>
                            <input type="text" id="first_name" name="first_name" required>
                        </div>

                        <div class="form_section">
                            <label for="last_name">Last Name <span>*</span></label>
                            <input type="text" id="last_name" name="last_name" required>
                        </div>
                    </div>

                    <div class="full_address">
                        <div class="form_section">
                            <label for="delivery_address">Delivery Address <span>*</span></label>
                            <input type="text" id="delivery_address" name="delivery_address" required placeholder="Street address, apartment, suite, unit, etc.">
                        </div>

                        <div class="row">
                            <div class="form_section">
                                <label for="city">City <span>*</span></label>
                                <input type="text" id="city" name="city" required>
                            </div>

                            <div class="form_section">
                                <label for="postal_code">Postal Code <span>*</span></label>
                                <input type="text" id="postal_code" name="postal_code" required>
                            </div>
                        </div>
                    </div>

                    <div class="form_section">
                        <label for="contact_number">Contact Number <span>*</span></label>
                        <input type="text" id="contact_number" name="contact_number" required>
                    </div>

                    <div class="form_section">
                        <label for="email">Email Address <span>*</span></label>
                        <input type="text" id="email" name="email_address" required>
                    </div>

                    <div class="form_section">
                        <label for="payment_method">Payment Method <span>*</span></label>
                        <select id="payment_method" name="payment_method" required>
                            <option value="" disabled selected hidden class="option_select_text">Select a payment method</option>
                            <option value="cash">Cash</option>
                            <option value="credit card">Credit Card</option>
                        </select>
                    </div>

                    <button type="submit" name="final_checkout_button" class="final_checkout_button">Checkout</button>
                </form>
            </div>

            <div class="display_order">
                <?php
                    $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
                    $subtotal = 0;
                    $vat = 0;
                    $grand_total = 0;
                    if(mysqli_num_rows($select_cart) > 0){
                        while($fetch_cart = mysqli_fetch_assoc($select_cart)){
                        $total_price = number_format($fetch_cart["price"] * $fetch_cart["quantity"]);
                        $subtotal += $total_price;
                        }
                        $vat = $subtotal * 0.15;
                        $grand_total = $subtotal + $vat;
                    }
                ?>
            </div>

            <div class="order_container">
                <h2 class="order_title">Your Order</h2>
                <div class="order_summary">
                    <div class="items">
                        <div class="subtotal_title">Subtotal</div>
                        <div class="subtotal_price">R<?= $subtotal; ?></div>
                    </div>
                    <div class="items">
                        <div class="delivery_title">15% VAT</div>
                        <div class="delivery_price">R<?= $vat; ?></div>
                    </div>
                    <div class="items">
                        <div class="delivery_title">Delivery Fee</div>
                        <div class="delivery_price">Free Delivery</div>
                    </div>
                    <div class="items">
                        <div class="totals_title">Total</div>
                        <div class="totals_price">R<?= $grand_total; ?></div>
                    </div>
                </div>
            </div>
        </div>
    
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