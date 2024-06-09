<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = mysqli_connect("localhost", "root", "", "pear_pools_db");

if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if(isset($_POST["send_button"])) {

    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $contact_number = $_POST["contact_number"];
    $email_address = $_POST["email_address"];
    $help_query = $_POST["help_query"];
    $additional_notes = $_POST["additional_notes"];

    $select_customer_query = mysqli_query($conn, "SELECT customer_ID FROM customers WHERE email_address = '$email_address'");
    if(mysqli_num_rows($select_customer_query) > 0) {
        $row = mysqli_fetch_assoc($select_customer_query);
        $customer_ID = $row["customer_ID"];
        $update_customer_query = mysqli_query($conn, "UPDATE `customers` SET first_name='$first_name', last_name='$last_name', contact_number='$contact_number', email_address='$email_address' WHERE customer_ID='$customer_ID'");
    } else {
        $insert_customer_query = mysqli_query($conn, "INSERT INTO `customers` (first_name, last_name, contact_number, email_address) VALUES ('$first_name', '$last_name', '$contact_number', '$email_address')");
        $customer_ID = mysqli_insert_id($conn);
    }

    $insert_quote_query = mysqli_query($conn, "INSERT INTO `quotes` (customer_ID, first_name, last_name, contact_number, email_address, help_query, additional_notes) VALUES ('$customer_ID', '$first_name', '$last_name', '$contact_number', '$email_address', '$help_query', '$additional_notes')");

    if($insert_quote_query) {
        echo "Quote request submitted successfully.";
    } else {
        echo "ERROR: Could not execute $insert_quote_query. " . mysqli_error($conn);
    }
}

mysqli_close($conn);

?>
