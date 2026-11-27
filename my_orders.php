
<?php
session_start();

include("includes/db.php");
include("includes/header.php");

if(!isset($_SESSION['user_id']))
{
    header("Location:login.php");
    exit();
}

$user_id = (int)$_SESSION['user_id'];

$query = mysqli_query($conn,"
SELECT *
FROM orders
WHERE user_id='$user_id'
ORDER BY order_date DESC
");

?>

<style>

/* Orders Container */

.orders-container {
    width: 92%;
    margin: 40px auto;
}

/* Heading */

.orders-heading {
    text-align: center;
    color: #70442c;
    font-family: Georgia, "Times New Roman", serif;
    font-size: 32px;
    margin-bottom: 35px;
}

/* Orders Table */

.orders-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: #ffffff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 7px 25px rgba(70, 45, 30, 0.10);
}

/* Table Heading */

.orders-table th {
    background: #70442c;
    color: white;
    padding: 18px 15px;
    font-size: 16px;
    font-weight: 600;
}

/* Table Data */

.orders-table td {
    padding: 18px 15px;
    text-align: center;
    color: #66554d;
    font-size: 15px;
    border-bottom: 1px solid #eee2d8;
}

/* Row Hover */

.orders-table tr:not(:first-child):hover {
    background: #fffaf5;
}

/* Order ID */

.orders-table td:first-child {
    color: #70442c;
    font-weight: bold;
}

/* Total Amount */

.orders-table td:nth-child(3) {
    color: #8f5f40;
    font-weight: bold;
}

/* Status Labels */

.status {
    display: inline-block;
    padding: 7px 15px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: bold;
}

.pending {
    background: #fff0d5;
    color: #9a6b24;
}

.delivered {
    background: #e4f0df;
    color: #54734c;
}

.cancelled {
    background: #f8e3df;
    color: #a34e42;
}

.return-requested {
    background: #eee4f5;
    color: #76528b;
}

.returned {
    background: #e4eaf5;
    color: #526c99;
}

.processing {
    background: #e5edf5;
    color: #496b8a;
}

/* Action Buttons */

.order-btn {
    display: inline-block;
    padding: 10px 20px;
    border: none;
    border-radius: 22px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s ease;
}

/* Cancel Order */

.cancel-btn {
    background: #f7e6df;
    color: #9b4d3f;
    border: 1px solid #e3b8a9;
}

.cancel-btn:hover {
    background: #b75e4e;
    color: white;
    transform: translateY(-2px);
}

/* Return Order */

.return-btn {
    background: #d49a6a;
    color: #3d2b22;
}

.return-btn:hover {
    background: #8f5f40;
    color: white;
    transform: translateY(-2px);
}

/* Empty Orders */

.empty-orders {
    text-align: center;
    width: 55%;
    margin: 40px auto;
    padding: 40px 25px;
    background: white;
    border-radius: 22px;
    box-shadow: 0 7px 25px rgba(70, 45, 30, 0.10);
}

.empty-orders h3 {
    color: #70442c;
    font-size: 24px;
}

.empty-orders p {
    color: #806c60;
    font-size: 16px;
}

.shop-btn {
    display: inline-block;
    margin-top: 15px;
    padding: 12px 25px;
    background: #d49a6a;
    color: #3d2b22;
    text-decoration: none;
    border-radius: 25px;
    font-weight: bold;
    transition: 0.3s ease;
}

.shop-btn:hover {
    background: #8f5f40;
    color: white;
    transform: translateY(-2px);
}

/* Responsive */

@media(max-width: 768px) {

    .orders-container {
        width: 98%;
        overflow-x: auto;
    }

    .orders-table {
        min-width: 650px;
    }

    .orders-heading {
        font-size: 26px;
    }

    .empty-orders {
        width: 85%;
    }

}

</style>


<div class="orders-container">

<h2 class="orders-heading">My Orders</h2>

<?php

if(mysqli_num_rows($query) == 0)
{

?>

<div class="empty-orders">

    <h3>No Orders Yet ♡</h3>

    <p>You haven't placed any orders yet.</p>

    <a href="index.php" class="shop-btn">
        Continue Shopping
    </a>

</div>

<?php

}
else
{

?>

<table class="orders-table">

<tr>

<th>Order ID</th>
<th>Date</th>
<th>Total</th>
<th>Status</th>
<th>Action</th>

</tr>

<?php

while($row = mysqli_fetch_assoc($query))
{

?>

<tr>

<td>
<?php echo htmlspecialchars($row['order_id']); ?>
</td>

<td>
<?php echo htmlspecialchars($row['order_date']); ?>
</td>

<td>
₹<?php echo htmlspecialchars($row['total_amount']); ?>
</td>

<td>

<?php

$status = $row['order_status'];

if($status == "Pending")
{
    echo "<span class='status pending'>Pending</span>";
}
elseif($status == "Delivered")
{
    echo "<span class='status delivered'>Delivered</span>";
}
elseif($status == "Return Requested")
{
    echo "<span class='status return-requested'>Return Requested</span>";
}
elseif($status == "Returned")
{
    echo "<span class='status returned'>Returned</span>";
}
elseif($status == "Cancelled")
{
    echo "<span class='status cancelled'>Cancelled</span>";
}
else
{
    echo "<span class='status processing'>"
         .htmlspecialchars($status).
         "</span>";
}

?>

</td>

<td>

<?php

if($status == "Pending")
{

?>

<a href="cancel_order.php?id=<?php echo $row['order_id']; ?>"
   class="order-btn cancel-btn"
   onclick="return confirm('Cancel this order?')">

Cancel Order

</a>

<?php

}
elseif($status == "Delivered")
{

?>

<a href="return_order.php?id=<?php echo $row['order_id']; ?>"
   class="order-btn return-btn"
   onclick="return confirm('Return this order?')">

Return Order

</a>

<?php

}
elseif($status == "Return Requested")
{
    echo "<b>Return Requested</b>";
}
elseif($status == "Returned")
{
    echo "<b>Returned</b>";
}
elseif($status == "Cancelled")
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

}

?>

</div>


<?php
include("includes/footer.php");
?>
