<?php
session_start();

include("includes/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id'])){
    header("Location: wishlist.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$wishlist_id = $_GET['id'];

// Delete only the logged-in user's wishlist item
mysqli_query($conn,"
DELETE FROM wishlist
WHERE wishlist_id='$wishlist_id'
AND user_id='$user_id'
");

echo "<script>
alert('Product removed from wishlist.');
window.location='wishlist.php';
</script>";
?>