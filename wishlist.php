<?php
session_start();

include("includes/db.php");
include("includes/header.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = mysqli_query($conn,"
SELECT
products.*,
categories.category_name,
wishlist.wishlist_id
FROM wishlist
JOIN products
ON wishlist.product_id = products.product_id
JOIN categories
ON products.category_id = categories.category_id
WHERE wishlist.user_id='$user_id'
");
?>
<style>

.wishlist-btn {
    display: inline-block;
    padding: 9px 18px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    border: none;
}

/* Move to Cart */

.move-cart-btn {
    background: #6b4632;
    color: white;
}

.move-cart-btn:hover {
    background: #79543d;
}

/* Remove */

.remove-wishlist-btn {
    background: #f7efe5;
    color: #6b4632;
    border: 1px solid #b99b87;
}

.remove-wishlist-btn:hover {
    background: #ead9ca;
}

/* Continue Shopping */

.shop-btn button {
    background: #6b4632;
    color: white;
    border: none;
    padding: 11px 22px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
}

.shop-btn button:hover {
    background: #79543d;
}

</style>
<h2 align="center">My Wishlist ❤️</h2>

<?php

if(mysqli_num_rows($query)==0){

?>

<h3 align="center">Your Wishlist is Empty</h3>

<p align="center">

<a href="index.php" class="shop-btn">

<button>Continue Shopping</button>

</a>

</p>

<?php

}
else{

?>

<table border="1" width="95%" align="center" cellpadding="10">

<tr>

<th>Image</th>

<th>Product</th>

<th>Category</th>

<th>Price</th>

<th>Stock</th>

<th>Actions</th>

</tr>

<?php

while($row=mysqli_fetch_assoc($query)){

$image=mysqli_query($conn,"
SELECT image_name
FROM product_images
WHERE product_id='".$row['product_id']."'
LIMIT 1
");

$img=mysqli_fetch_assoc($image);

?>

<tr>

<td align="center">

<img src="uploads/products/<?php echo $img['image_name']; ?>" width="100">

</td>

<td>

<?php echo $row['product_name']; ?>

</td>

<td>

<?php echo $row['category_name']; ?>

</td>

<td>

₹<?php echo $row['price']; ?>

</td>

<td>

<?php

if($row['stock']>0)
{
    echo "In Stock";
}
else
{
    echo "Out of Stock";
}

?>

</td>

<td>

<a href="move_to_cart.php?id=<?php echo $row['product_id']; ?>">

<button>

Move to Cart

</button>

</a>

<br><br>

<a href="remove_wishlist.php?id=<?php echo $row['wishlist_id']; ?>">

<button onclick="return confirm('Remove from wishlist?')">

Remove

</button>

</a>

</td>

</tr>

<?php

}

?>

</table>

<?php

}

include("includes/footer.php");

?>