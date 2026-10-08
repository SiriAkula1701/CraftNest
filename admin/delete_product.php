<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: manage_store.php");
    exit();
}

include("../includes/db.php");

$product_id = $_GET['id'];

// Delete uploaded image files
$image_query = mysqli_query($conn,
"SELECT image_name FROM product_images WHERE product_id='$product_id'");

while($img=mysqli_fetch_assoc($image_query)){

    $path="../uploads/".$img['image_name'];

    if(file_exists($path)){
        unlink($path);
    }
}

// Delete product
mysqli_query($conn,"DELETE FROM products WHERE product_id='$product_id'");

echo "<script>alert('Product Deleted Successfully');</script>";
echo "<script>window.location='manage_store.php';</script>";

?>