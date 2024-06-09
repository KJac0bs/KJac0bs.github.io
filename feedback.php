<?php

$link = mysqli_connect("localhost", "root", "", "pear_pools_db");

if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$rating = mysqli_real_escape_string($link, $_POST["rating1"]);
$feedback_text = mysqli_real_escape_string($link, $_POST["feedback_text"]);

$feedback_sql = "INSERT INTO customer_feedback (rating, feedback_text) VALUES (?, ?)";
if ($feedback_stmt = mysqli_prepare($link, $feedback_sql)) {
    mysqli_stmt_bind_param($feedback_stmt, "is", $rating, $feedback_text);

    if (mysqli_stmt_execute($feedback_stmt)) {
        echo "Feedback submitted successfully";
    } else {
        echo "ERROR: Could not execute query: $feedback_sql. " . mysqli_error($link);
    }

    mysqli_stmt_close($feedback_stmt);
} else {
    echo "ERROR: Could not prepare query: $feedback_sql. " . mysqli_error($link);
}

mysqli_close($link);

?>
