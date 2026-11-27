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

<style>
    body {
        background-color: #fffaf5;
        font-family: Georgia, "Times New Roman", serif;
        color: #66554d;
    }

    h2 {
        color: #70442c;
        margin: 40px 0 30px;
        font-size: 30px;
    }

    center {
        background-color: white;
        max-width: 450px;
        margin: 30px auto 60px;
        padding: 40px 25px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(112, 68, 44, 0.12);
    }

    h3 {
        color: #8f5f40;
        font-size: 22px;
        margin-bottom: 30px;
    }

    button {
        background-color: #d49a6a;
        color: #3d2b22;
        border: none;
        padding: 13px 30px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }

    button:hover {
        background-color: #8f5f40;
        color: white;
    }
</style>

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