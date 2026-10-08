<?php
session_start();
include("includes/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id'])){
    header("Location: my_orders.php");
    exit();
}

$order_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Check whether the order belongs to the logged-in user
$query = mysqli_query($conn,"
SELECT * FROM orders
WHERE order_id='$order_id'
AND user_id='$user_id'
");

if(mysqli_num_rows($query)==0){
    die("Invalid Order.");
}

$order = mysqli_fetch_assoc($query);

// Allow cancellation only if Pending
if($order['order_status']=="Pending"){

    mysqli_query($conn,"
    UPDATE orders
    SET order_status='Cancelled'
    WHERE order_id='$order_id'
    ");

    echo "<script>
    alert('Order Cancelled Successfully');
    window.location='my_orders.php';
    </script>";

}else{

    echo "<script>
    alert('Only Pending orders can be cancelled.');
    window.location='my_orders.php';
    </script>";

}
?>