<?php
session_start();
include("includes/db.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['product_id'])) {

    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Check if product already exists in this user's cart
    $check = mysqli_query($conn,
        "SELECT * FROM cart
         WHERE user_id='$user_id'
         AND product_id='$product_id'"
    );

    if (mysqli_num_rows($check) > 0) {

        // Product already exists, increase quantity
        mysqli_query($conn,
            "UPDATE cart
             SET quantity = quantity + $quantity
             WHERE user_id='$user_id'
             AND product_id='$product_id'"
        );

    } else {

        // Product doesn't exist, add it
        mysqli_query($conn,
            "INSERT INTO cart(user_id, product_id, quantity)
             VALUES('$user_id', '$product_id', '$quantity')"
        );
    }

    header("Location: cart.php");
    exit();
}
?>