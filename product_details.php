
<?php
include("includes/db.php");
include("includes/header.php");

if(!isset($_GET['id'])){
    echo "Product not found.";
    include("includes/footer.php");
    exit();
}

$product_id = (int)$_GET['id'];

$query = "SELECT p.*, c.category_name
          FROM products p
          JOIN categories c
          ON p.category_id = c.category_id
          WHERE p.product_id='$product_id'";

$result = mysqli_query($conn,$query);

$product = mysqli_fetch_assoc($result);

if(!$product){
    echo "Product not found.";
    include("includes/footer.php");
    exit();
}
?>

<style>

/* Product Details Page */

.product-details-container {
    width: 88%;
    margin: 40px auto;
    padding: 30px;
    background: #fffaf5;
    border-radius: 20px;
    box-shadow: 0 5px 25px rgba(70, 45, 30, 0.10);
}

/* Product Heading */

.product-title {
    text-align: center;
    color: #70442c;
    font-family: Georgia, "Times New Roman", serif;
    font-size: 32px;
    margin-bottom: 30px;
}

/* Main Layout */

.product-details-table {
    width: 100%;
    border-collapse: collapse;
}

.product-details-table td {
    padding: 25px;
    vertical-align: top;
}

/* Product Images */

.product-images {
    width: 45%;
    text-align: center;
}

.product-images img {
    width: 90%;
    max-width: 380px;
    height: 380px;
    object-fit: cover;
    border-radius: 18px;
    margin-bottom: 20px;
    box-shadow: 0 5px 18px rgba(70, 45, 30, 0.12);
    transition: 0.3s ease;
}

.product-images img:hover {
    transform: scale(1.03);
}

/* Product Information */

.product-info {
    width: 55%;
    color: #66554d;
    font-size: 17px;
    line-height: 1.6;
}

.product-info h3 {
    color: #8f5f40;
    font-size: 19px;
    margin-bottom: 5px;
    font-family: Georgia, "Times New Roman", serif;
}

/* Price */

.product-price {
    color: #70442c;
    font-size: 25px;
    font-weight: bold;
}

/* Stock */

.product-stock {
    color: #54734c;
    font-weight: bold;
}

/* Quantity */

.product-info input[type="number"] {
    width: 75px;
    padding: 10px;
    border: 1px solid #d8b99f;
    border-radius: 8px;
    font-size: 15px;
    outline: none;
}

.product-info input[type="number"]:focus {
    border-color: #8f5f40;
}

/* Buttons */

.product-info button {
    padding: 12px 25px;
    border: none;
    border-radius: 25px;
    background: #d49a6a;
    color: #3d2b22;
    font-family: Georgia, "Times New Roman", serif;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s ease;
}

.product-info button:hover {
    background: #8f5f40;
    color: white;
    transform: translateY(-3px);
}

/* Add to Wishlist */

.wishlist-button {
    background: #f0d9c6 !important;
    color: #70442c !important;
}

.wishlist-button:hover {
    background: #8f5f40 !important;
    color: white !important;
}

/* Responsive Design */

@media (max-width: 768px) {

    .product-details-container {
        width: 92%;
        padding: 15px;
    }

    .product-details-table,
    .product-details-table tr,
    .product-details-table td {
        display: block;
        width: 100%;
    }

    .product-images img {
        width: 90%;
        height: 280px;
    }

    .product-info {
        padding: 15px;
    }

    .product-title {
        font-size: 25px;
    }

}

</style>


<div class="product-details-container">

<h2 class="product-title">
    <?php echo htmlspecialchars($product['product_name']); ?>
</h2>

<table class="product-details-table">

<tr>

<td class="product-images">

<?php

$images = mysqli_query($conn,
"SELECT * FROM product_images
WHERE product_id='$product_id'");

while($img = mysqli_fetch_assoc($images)){

?>

<img
src="uploads/products/<?php echo htmlspecialchars($img['image_name']); ?>"
alt="<?php echo htmlspecialchars($product['product_name']); ?>"
>

<br><br>

<?php
}
?>

</td>


<td class="product-info">

<h3>Category</h3>

<?php echo htmlspecialchars($product['category_name']); ?>

<br><br>


<h3>Description</h3>

<?php echo nl2br(htmlspecialchars($product['description'])); ?>

<br><br>


<h3>Price</h3>

<div class="product-price">
₹<?php echo htmlspecialchars($product['price']); ?>
</div>

<br>


<h3>Stock</h3>

<span class="product-stock">
<?php echo htmlspecialchars($product['stock']); ?> Available
</span>

<br><br>


<form action="add_to_cart.php" method="POST">

    <input type="hidden" name="product_id"
    value="<?php echo $product_id; ?>">

    <label><b>Quantity:</b></label>

    <input
        type="number"
        name="quantity"
        value="1"
        min="1"
        max="<?php echo (int)$product['stock']; ?>"
        required
    >

    <br><br>

    <button type="submit">Add to Cart</button>

</form>

<br>

<a href="add_to_wishlist.php?id=<?php echo $product_id; ?>">

<button type="button" class="wishlist-button">
    Add to Wishlist ♡
</button>

</a>

</td>

</tr>

</table>

</div>


<?php
include("includes/footer.php");
?>
