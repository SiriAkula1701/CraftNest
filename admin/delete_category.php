<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: manage_store.php");
    exit();
}

include("../includes/db.php");

if(!isset($_GET['id'])){
    header("Location: manage_store.php");
    exit();
}

$category_id = $_GET['id'];

// Check if any products belong to this category
$check = mysqli_query($conn,
"SELECT * FROM products WHERE category_id='$category_id'");

if(mysqli_num_rows($check) > 0){

    echo "<script>
    alert('Cannot delete this category because it contains products.');
    window.location='manage_store.php';
    </script>";

    exit();
}

// Delete the category
mysqli_query($conn,
"DELETE FROM categories
WHERE category_id='$category_id'");

echo "<script>
alert('Category Deleted Successfully');
window.location='manage_store.php';
</script>";
?>