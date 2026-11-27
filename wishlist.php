
<?php
session_start();

include("includes/db.php");
include("includes/header.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = (int)$_SESSION['user_id'];

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

/* Wishlist Page */

.wishlist-container {
    width: 92%;
    margin: 40px auto;
}

/* Heading */

.wishlist-heading {
    text-align: center;
    color: #70442c;
    font-family: Georgia, "Times New Roman", serif;
    font-size: 32px;
    margin-bottom: 35px;
}

/* Wishlist Table */

.wishlist-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: white;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 7px 25px rgba(70, 45, 30, 0.10);
}

/* Table Heading */

.wishlist-table th {
    background: #70442c;
    color: white;
    padding: 18px 12px;
    font-size: 16px;
    font-weight: 600;
}

/* Table Cells */

.wishlist-table td {
    padding: 18px 12px;
    text-align: center;
    color: #66554d;
    font-size: 15px;
    border-bottom: 1px solid #eee2d8;
}

/* Product Image */

.wishlist-table td img {
    width: 105px;
    height: 105px;
    object-fit: cover;
    border-radius: 12px;
    box-shadow: 0 3px 10px rgba(70, 45, 30, 0.10);
    transition: 0.3s ease;
}

.wishlist-table td img:hover {
    transform: scale(1.08);
}

/* Product Name */

.wishlist-table td:nth-child(2) {
    color: #70442c;
    font-weight: bold;
}

/* Price */

.wishlist-table td:nth-child(4) {
    color: #8f5f40;
    font-weight: bold;
}

/* Stock */

.in-stock {
    color: #64834f;
    font-weight: bold;
}

.out-stock {
    color: #b45d50;
    font-weight: bold;
}

/* Common Buttons */

.wishlist-btn {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 22px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    border: none;
    transition: 0.3s ease;
}

/* Move to Cart */

.move-cart-btn {
    background: #d49a6a;
    color: #3d2b22;
}

.move-cart-btn:hover {
    background: #8f5f40;
    color: white;
    transform: translateY(-2px);
}

/* Remove Button */

.remove-wishlist-btn {
    background: #f7efe5;
    color: #70442c;
    border: 1px solid #b99b87;
}

.remove-wishlist-btn:hover {
    background: #ead9ca;
    transform: translateY(-2px);
}

/* Empty Wishlist */

.empty-wishlist {
    text-align: center;
    background: white;
    width: 55%;
    margin: 40px auto;
    padding: 45px 25px;
    border-radius: 22px;
    box-shadow: 0 7px 25px rgba(70, 45, 30, 0.10);
}

.empty-wishlist h3 {
    color: #70442c;
    font-size: 25px;
}

.empty-wishlist p {
    color: #806c60;
    font-size: 16px;
}

/* Continue Shopping */

.shop-btn {
    display: inline-block;
    margin-top: 15px;
    background: #d49a6a;
    color: #3d2b22;
    padding: 12px 25px;
    border-radius: 25px;
    text-decoration: none;
    font-size: 15px;
    font-weight: bold;
    transition: 0.3s ease;
}

.shop-btn:hover {
    background: #8f5f40;
    color: white;
    transform: translateY(-3px);
}

/* Table Row Hover */

.wishlist-table tr:not(:first-child):hover {
    background: #fffaf5;
}

/* Responsive */

@media(max-width: 768px) {

    .wishlist-container {
        width: 98%;
        overflow-x: auto;
    }

    .wishlist-table {
        min-width: 700px;
    }

    .wishlist-heading {
        font-size: 26px;
    }

    .empty-wishlist {
        width: 85%;
    }

}

</style>


<div class="wishlist-container">

<h2 class="wishlist-heading">My Wishlist ♡</h2>

<?php

if(mysqli_num_rows($query)==0){

?>

<div class="empty-wishlist">

    <h3>Your Wishlist is Empty ♡</h3>

    <p>You haven't added any handmade products to your wishlist yet.</p>

    <a href="index.php" class="shop-btn">
        Continue Shopping
    </a>

</div>

<?php

}
else{

?>

<table class="wishlist-table">

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

$product_image = "uploads/no-image.png";

if($img){
    $product_image = "uploads/products/".$img['image_name'];
}

?>

<tr>

<td>

<img src="<?php echo htmlspecialchars($product_image); ?>"
     alt="<?php echo htmlspecialchars($row['product_name']); ?>">

</td>

<td>

<?php echo htmlspecialchars($row['product_name']); ?>

</td>

<td>

<?php echo htmlspecialchars($row['category_name']); ?>

</td>

<td>

₹<?php echo htmlspecialchars($row['price']); ?>

</td>

<td>

<?php

if($row['stock']>0)
{
    echo "<span class='in-stock'>In Stock</span>";
}
else
{
    echo "<span class='out-stock'>Out of Stock</span>";
}

?>

</td>

<td>

<?php if($row['stock'] > 0) { ?>

<a href="move_to_cart.php?id=<?php echo $row['product_id']; ?>"
   class="wishlist-btn move-cart-btn">

Move to Cart

</a>

<br><br>

<?php } ?>

<a href="remove_wishlist.php?id=<?php echo $row['wishlist_id']; ?>"
   class="wishlist-btn remove-wishlist-btn"
   onclick="return confirm('Remove from wishlist?')">

Remove

</a>

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
