<?php
session_start();

include("includes/db.php");
include("includes/header.php");

if(!isset($_SESSION['user_id']))
{
    header("Location:login.php");
    exit();
}

$user_id=$_SESSION['user_id'];

$query=mysqli_query($conn,"
SELECT *
FROM orders
WHERE user_id='$user_id'
ORDER BY order_date DESC
");

?>

<h2 align="center">My Orders</h2>

<table border="1" width="90%" align="center" cellpadding="10">

<tr>

<th>Order ID</th>
<th>Date</th>
<th>Total</th>
<th>Status</th>
<th>Action</th>

</tr>

<?php

while($row=mysqli_fetch_assoc($query))
{

?>

<tr>

<td><?php echo $row['order_id']; ?></td>

<td><?php echo $row['order_date']; ?></td>

<td>₹<?php echo $row['total_amount']; ?></td>

<td><?php echo $row['order_status']; ?></td>

<td>

<?php

if($row['order_status']=="Pending")
{
?>

<a href="cancel_order.php?id=<?php echo $row['order_id']; ?>">

<button onclick="return confirm('Cancel this order?')">

Cancel Order

</button>

</a>

<?php
}
elseif($row['order_status']=="Delivered")
{
?>

<a href="return_order.php?id=<?php echo $row['order_id']; ?>">

<button onclick="return confirm('Return this order?')">

Return Order

</button>

</a>

<?php
}
elseif($row['order_status']=="Return Requested")
{
    echo "<b>Return Requested</b>";
}
elseif($row['order_status']=="Returned")
{
    echo "<b>Returned</b>";
}
elseif($row['order_status']=="Cancelled")
{
    echo "<b>Cancelled</b>";
}
else
{
    echo "-";
}

?>

</td>

</tr>

<?php
}
?>

</table>

<?php
include("includes/footer.php");
?>