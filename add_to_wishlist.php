<?php
session_start();

include("includes/db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id']))
{
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_GET['id'];

// Check if product already exists in wishlist
$check = mysqli_query($conn,"
SELECT *
FROM wishlist
WHERE user_id='$user_id'
AND product_id='$product_id'
");

if(mysqli_num_rows($check) > 0)
{
    echo "<script>
    alert('Product is already in your wishlist.');
    window.history.back();
    </script>";
    exit();
}

// Add product to wishlist
mysqli_query($conn,"
INSERT INTO wishlist(user_id, product_id)
VALUES('$user_id','$product_id')
");

echo "<script>
alert('Product added to wishlist successfully.');
window.location='wishlist.php';
</script>";
?>