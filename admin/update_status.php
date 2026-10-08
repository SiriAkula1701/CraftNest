<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}

include("../includes/db.php");

$order_id = $_POST['order_id'];
$status = $_POST['status'];

mysqli_query($conn,"
UPDATE orders
SET order_status='$status'
WHERE order_id='$order_id'
");

header("Location:view_order.php?id=".$order_id);
exit();
?>