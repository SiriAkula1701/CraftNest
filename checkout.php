<?php
session_start();

include("includes/db.php");
include("includes/header.php");

$user_id = $_SESSION['user_id'];

$query = mysqli_query($conn,"
SELECT cart.*,products.product_name,products.price
FROM cart
JOIN products
ON cart.product_id=products.product_id
WHERE user_id='$user_id'
");

$total=0;

while($row=mysqli_fetch_assoc($query))
{
    $total += $row['price'] * $row['quantity'];
}
?>

<h2 align="center">Checkout</h2>

<center>

<h3>Total Amount : ₹<?php echo $total; ?></h3>

<form action="place_order.php" method="POST">

<input type="hidden" name="total" value="<?php echo $total; ?>">

<button type="submit">
Place Order
</button>

</form>

</center>

<?php
include("includes/footer.php");
?>