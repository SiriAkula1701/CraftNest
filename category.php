
<?php

include("includes/db.php");
include("includes/header.php");

?>

<style>

/* Main table styling */

.category-table,
.product-table {
    width: 88%;
    margin: 0 auto;
    border-collapse: separate;
    border-spacing: 22px;
    table-layout: fixed;
}

/* Category and Product cards */

.category-table td,
.product-table td {
    width: 25%;
    padding: 20px;
    vertical-align: top;
    text-align: center;
    background: #ffffff;
    border-radius: 25px;
    box-shadow: 0 7px 25px rgba(70, 45, 30, 0.10);
    transition: 0.3s ease;
}

/* Hover effect */

.category-table td:hover,
.product-table td:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 30px rgba(70, 45, 30, 0.17);
}

/* Page headings */

.category-heading {
    text-align: center;
    color: #70442c;
    font-family: Georgia, "Times New Roman", serif;
    margin: 30px 0;
    font-size: 30px;
}

/* Category buttons */

.category-table a button {
    padding: 12px 25px;
    border: none;
    border-radius: 20px;
    background: #d49a6a;
    color: #3d2b22;
    font-family: Georgia, "Times New Roman", serif;
    font-size: 17px;
    cursor: pointer;
    transition: 0.3s ease;
}

.category-table a button:hover {
    background: #8f5f40;
    color: white;
    transform: translateY(-2px);
}

/* Product images */

.product-table td img {
    width: 100%;
    height: 240px;
    object-fit: cover;
    border-radius: 16px;
    margin-bottom: 12px;
}

/* Product name */

.product-table td b {
    display: block;
    color: #70442c;
    font-size: 20px;
    margin-bottom: 5px;
}

/* Product details */

.product-table td {
    color: #66554d;
    font-size: 16px;
}

/* View Details button */

.product-table td a button {
    margin-top: 12px;
    padding: 10px 22px;
    border: none;
    border-radius: 20px;
    background: #d49a6a;
    color: #3d2b22;
    font-family: Georgia, "Times New Roman", serif;
    font-size: 15px;
    cursor: pointer;
    transition: 0.3s ease;
}

.product-table td a button:hover {
    background: #8f5f40;
    color: white;
    transform: translateY(-2px);
}

/* Empty category message */

.empty-message {
    color: #70442c;
    font-size: 20px;
    padding: 30px;
}

/* Responsive design */

@media (max-width: 768px) {

    .category-table,
    .product-table {
        width: 96%;
        border-spacing: 10px;
    }

    .category-table td,
    .product-table td {
        padding: 12px;
    }

    .product-table td img {
        height: 160px;
    }

}

</style>


<?php

// ------------------------------------
// DISPLAY ALL CATEGORIES
// ------------------------------------

if(!isset($_GET['id'])){

?>

<h2 class="category-heading">Categories</h2>

<br>

<table class="category-table">

<tr>

<?php

$category_query = mysqli_query(
    $conn,
    "SELECT * FROM categories ORDER BY category_id ASC"
);

$count = 0;

while($cat = mysqli_fetch_assoc($category_query)){

?>

<td>

<a href="category.php?id=<?php echo $cat['category_id']; ?>">

<button>
<?php echo htmlspecialchars($cat['category_name']); ?>
</button>

</a>

</td>

<?php

$count++;

if($count % 4 == 0){

    echo "</tr><tr>";

}

}

?>

</tr>

</table>

<?php

include("includes/footer.php");

exit();

}


// ------------------------------------
// GET SELECTED CATEGORY
// ------------------------------------

$category_id = (int)$_GET['id'];

$cat_query = mysqli_query(
    $conn,
    "SELECT * FROM categories
     WHERE category_id='$category_id'"
);


if(mysqli_num_rows($cat_query) == 0){

    echo "<h2 class='category-heading'>Invalid Category.</h2>";

    include("includes/footer.php");

    exit();

}

$category = mysqli_fetch_assoc($cat_query);

?>


<h2 class="category-heading">

<?php echo htmlspecialchars($category['category_name']); ?>

</h2>


<br>


<!-- ------------------------------------
     DISPLAY PRODUCTS
------------------------------------- -->

<table class="product-table">

<tr>

<?php

$query = mysqli_query($conn,"

SELECT *
FROM products
WHERE category_id='$category_id'
ORDER BY product_id DESC

");


if(mysqli_num_rows($query) == 0){

    echo "<td colspan='4' class='empty-message'>

    <h3>
    No products available in this category.
    </h3>

    </td>";

}

else{

$count = 0;


while($row = mysqli_fetch_assoc($query)){

$product_id = $row['product_id'];


// Get first image of product

$image_query = mysqli_query($conn,"

SELECT image_name
FROM product_images
WHERE product_id='$product_id'
LIMIT 1

");


$img = mysqli_fetch_assoc($image_query);


$image = "uploads/no-image.png";


if($img){

    $image = "uploads/products/".$img['image_name'];

}

?>


<td>


<img src="<?php echo htmlspecialchars($image); ?>"
     alt="<?php echo htmlspecialchars($row['product_name']); ?>">


<br><br>


<b>

<?php echo htmlspecialchars($row['product_name']); ?>

</b>


<br><br>


₹<?php echo htmlspecialchars($row['price']); ?>


<br><br>


<a href="product_details.php?id=<?php echo $product_id; ?>">

<button>

View Details

</button>

</a>


</td>


<?php

$count++;


if($count % 4 == 0){

    echo "</tr><tr>";

}

}

}

?>

</tr>

</table>


<?php

include("includes/footer.php");

?>
