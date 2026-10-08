<?php

session_start();

include("includes/db.php");


// Check user login
if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();

}


$user_id = $_SESSION['user_id'];


// Get cart id
if(isset($_GET['id'])){

    $cart_id = $_GET['id'];


    // Check current quantity
    $query = mysqli_query($conn,"
        SELECT quantity
        FROM cart
        WHERE cart_id='$cart_id'
        AND user_id='$user_id'
    ");


    if(mysqli_num_rows($query) > 0){

        $row = mysqli_fetch_assoc($query);

        $quantity = $row['quantity'];


        if($quantity > 1){

            // Reduce quantity by 1
            mysqli_query($conn,"
                UPDATE cart
                SET quantity = quantity - 1
                WHERE cart_id='$cart_id'
                AND user_id='$user_id'
            ");

        }
        else{

            // Quantity is 1, so remove the product
            mysqli_query($conn,"
                DELETE FROM cart
                WHERE cart_id='$cart_id'
                AND user_id='$user_id'
            ");

        }

    }

}


// Go back to cart
header("Location: cart.php");
exit();

?>