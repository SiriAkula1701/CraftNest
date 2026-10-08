<?php

include("includes/db.php");
include("includes/header.php");

if(!isset($_GET['id'])){

?>

<h2 align="center">Categories</h2>

<br><br>

<table width="100%" cellspacing="20">

<tr>

<?php

$category_query = mysqli_query($conn,
"SELECT * FROM categories ORDER BY category_id ASC"
);

$count = 0;

while($cat = mysqli_fetch_assoc($category_query)){

?>

<td align="center" width="25%">

<a href="category.php?id=<?php echo $cat['category_id']; ?>">

<button>
<?php echo $cat['category_name']; ?>
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

$category_id = (int)$_GET['id'];


// Get category details

$cat_query = mysqli_query($conn,
"SELECT * FROM categories
 WHERE category_id='$category_id'"
);


if(mysqli_num_rows($cat_query)==0){

    echo "<h2 align='center'>Invalid Category.</h2>";

    include("includes/footer.php");

    exit();

}


$category = mysqli_fetch_assoc($cat_query);

?>


<h2 align="center">

<?php echo $category['category_name']; ?>

</h2>


<br>


<table width="100%" cellspacing="20">

<tr>


<?php

$query = mysqli_query($conn,"
SELECT *
FROM products
WHERE category_id='$category_id'
ORDER BY product_id DESC
");


if(mysqli_num_rows($query)==0){

    echo "<td align='center'>

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


<td align="center" width="25%">


<img src="<?php echo $image; ?>"
     width="220"
     height="220">


<br><br>


<b>

<?php echo $row['product_name']; ?>

</b>


<br><br>


₹<?php echo $row['price']; ?>


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