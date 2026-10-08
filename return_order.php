<?php

session_start();

include("includes/db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location:login.php");
    exit();
}

if(!isset($_GET['id']))
{
    header("Location:my_orders.php");
    exit();
}

$order_id=$_GET['id'];

$user_id=$_SESSION['user_id'];

$query=mysqli_query($conn,"
SELECT *
FROM orders
WHERE order_id='$order_id'
AND user_id='$user_id'
");

if(mysqli_num_rows($query)==0)
{
    die("Invalid Order");
}

$order=mysqli_fetch_assoc($query);

if($order['order_status']=="Delivered")
{

mysqli_query($conn,"
UPDATE orders
SET order_status='Return Requested'
WHERE order_id='$order_id'
");

echo "<script>

alert('Return Request Sent Successfully');

window.location='my_orders.php';

</script>";

}
else
{

echo "<script>

alert('Return not allowed.');

window.location='my_orders.php';

</script>";

}

?>