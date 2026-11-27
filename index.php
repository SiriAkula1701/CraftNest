<?php
include("includes/header.php");
include("includes/db.php");
?>

<main>

<!-- Hero Section -->
<!-- Hero Section -->

<section class="hero">

    <div class="hero-overlay"></div>

    <div class="hero-content">

        <h1>🧶 Handmade with Love ❤️</h1>

        <p>
            Discover unique handmade crafts created with passion by talented artisans.
        </p>

        <h2>Shop by Category</h2>

        <div class="category-buttons">

            <?php

            $query = mysqli_query($conn,"SELECT * FROM categories");

            while($row = mysqli_fetch_assoc($query))
            {

            ?>

                <a href="category.php?id=<?php echo $row['category_id']; ?>">

                    <button>
                        <?php echo $row['category_name']; ?>
                    </button>

                </a>

            <?php

            }

            ?>

        </div>

    </div>

</section>

<br><br>


<h2 align="center">🌟 Most Recommended</h2>

<table width="100%" cellspacing="20">

<tr>

<?php
$query = "SELECT p.*, c.category_name
          FROM products p
          JOIN categories c
          ON p.category_id = c.category_id
          WHERE p.is_recommended = 1
          ORDER BY p.product_id DESC";

$result = mysqli_query($conn,$query);

$count = 0;

while($row=mysqli_fetch_assoc($result)){

$product_id=$row['product_id'];

$image=mysqli_query($conn,"
SELECT image_name
FROM product_images
WHERE product_id='$product_id'
LIMIT 1");

$img=mysqli_fetch_assoc($image);

?>

<td align="center">

<img src="uploads/products/<?php echo $img['image_name']; ?>" width="220" height="220">

<br><br>

<b><?php echo $row['product_name']; ?></b>

<br>

₹<?php echo $row['price']; ?>

<br>

Category:
<?php echo $row['category_name']; ?>

<br><br>

<a href="product_details.php?id=<?php echo $product_id; ?>">

<button>View Details</button>

</a>

</td>

<?php

$count++;

if($count%4==0){

echo "</tr><tr>";

}

}

?>

</tr>

</table>

</section>

<br><br>

<!-- Offers -->

<section>

<h2 align="center">🎉 Special Offers</h2>

<table width="100%" cellspacing="20">

<tr>

<td align="center" border="1">

<h3>🧶 Crochet Collection</h3>

<p>Flat <b>20% OFF</b></p>

</td>

<td align="center">

<h3>🕯 Handmade Candles</h3>

<p>Buy 2 Get 1 FREE</p>

</td>

<td align="center">

<h3>🚚 Free Delivery</h3>

<p>On Orders Above ₹999</p>

</td>

</tr>

</table>

</section>


<br><br>

<!-- Why Choose CraftNest -->

<section align="center">

<h2>❤️ Why Choose CraftNest?</h2>

<table width="100%" cellspacing="20">

<tr>

<td align="center">

<h3>🧵 Handmade</h3>

<p>Every product is handcrafted with care.</p>

</td>

<td align="center">

<h3>🌱 Eco Friendly</h3>

<p>Sustainable and environmentally friendly products.</p>

</td>

<td align="center">

<h3>🔒 Secure Shopping</h3>

<p>Safe and reliable shopping experience.</p>

</td>

<td align="center">

<h3>🚚 Fast Delivery</h3>

<p>Quick delivery across India.</p>

</td>

</tr>

</table>

</section>

</main>

<?php include("includes/footer.php"); ?>