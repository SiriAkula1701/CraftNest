<?php

session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}

include("../includes/db.php");

$order_id = intval($_GET['id']);

mysqli_query($conn, "
    UPDATE orders
    SET order_status='Returned'
    WHERE order_id='$order_id'
");

echo "<script>

alert('Return Approved');

window.location='orders.php';

</script>";

?>