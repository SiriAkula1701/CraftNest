<?php
include("includes/db.php");
include("includes/header.php");

if(!isset($_GET['id'])){
    echo "Product not found.";
    exit();
}

$product_id = $_GET['id'];

$query = "SELECT p.*, c.category_name
          FROM products p
          JOIN categories c
          ON p.category_id = c.category_id
          WHERE p.product_id='$product_id'";

$result = mysqli_query($conn,$query);

$product = mysqli_fetch_assoc($result);

if(!$product){
    echo "Product not found.";
    exit();
}
?>

<h2><?php echo $product['product_name']; ?></h2>

<table width="100%" cellpadding="20">

<tr>

<td width="45%" valign="top">

<?php

$images = mysqli_query($conn,
"SELECT * FROM product_images
WHERE product_id='$product_id'");

while($img = mysqli_fetch_assoc($images)){

?>

<img src="uploads/products/<?php echo $img['image_name']; ?>"
width="250"
height="250">

<br><br>

<?php
}
?>

</td>

<td valign="top">

<h3>Category</h3>

<?php echo $product['category_name']; ?>

<br><br>

<h3>Description</h3>

<?php echo $product['description']; ?>

<br><br>

<h3>Price</h3>

₹<?php echo $product['price']; ?>

<br><br>

<h3>Stock</h3>

<?php echo $product['stock']; ?>

<br><br>

<form action="add_to_cart.php" method="POST">

    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">

    <label>Quantity:</label>

    <input
        type="number"
        name="quantity"
        value="1"
        min="1"
        max="<?php echo $product['stock']; ?>"
    >

    <br><br>

    <button type="submit">Add to Cart</button>

</form>

&nbsp;&nbsp;

<a href="add_to_wishlist.php?id=<?php echo $product_id; ?>">

<button>Add to Wishlist</button>

</a>

</td>

</tr>

</table>

<?php
include("includes/footer.php");
?>