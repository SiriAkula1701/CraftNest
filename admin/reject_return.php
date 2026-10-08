<?php

session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}

include("../includes/db.php");

$order_id=$_GET['id'];

mysqli_query($conn,"
UPDATE orders
SET order_status='Delivered'
WHERE order_id='$order_id'
");

echo "<script>

alert('Return Rejected');

window.location='orders.php';

</script>";

?>