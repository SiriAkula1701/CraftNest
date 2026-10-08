<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

include("../includes/db.php");

if(isset($_POST['add_product'])){

    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category_id = $_POST['category'];

    // Insert Product
    $query = "INSERT INTO products(category_id, product_name, description, price, stock)
              VALUES('$category_id','$product_name','$description','$price','$stock')";

    if(mysqli_query($conn,$query)){

        // Get Last Inserted Product ID
        $product_id = mysqli_insert_id($conn);

        // Upload Multiple Images
        foreach($_FILES['images']['name'] as $key => $image_name){

            if(!empty($image_name)){

                $temp_name = $_FILES['images']['tmp_name'][$key];

                $target = "../uploads/products/" . $image_name;

                if(move_uploaded_file($temp_name, $target)){

                    $img_query = "INSERT INTO product_images(product_id, image_name)
                                  VALUES('$product_id', '$image_name')";

                    mysqli_query($conn, $img_query);

                }else{

                    echo "<script>alert('Failed to upload image: $image_name');</script>";

                }

            }

        }

        echo "<script>
                alert('Product Added Successfully');
                window.location='manage_store.php';
              </script>";

    }else{

        echo "<script>alert('Failed to Add Product');</script>";

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>CraftNest | Add Product</title>

<style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background: #f7efe5;
    color: #3f2a1d;
}

/* ================= SIDEBAR ================= */

.sidebar {
    position: fixed;
    left: 0;
    top: 0;
    width: 230px;
    height: 100vh;
    background: #5b3a29;
    padding: 30px 18px;
}

.logo {
    text-align: center;
    margin-bottom: 40px;
}

.logo h2 {
    color: white;
    font-size: 25px;
    letter-spacing: 1px;
}

.logo p {
    color: #d9c1ad;
    font-size: 12px;
    margin-top: 5px;
}

.sidebar a {
    display: block;
    text-decoration: none;
    color: #f7eee7;
    padding: 13px 15px;
    margin-bottom: 8px;
    border-radius: 7px;
    font-size: 14px;
    transition: 0.2s;
}

.sidebar a:hover {
    background: #79543d;
}

.sidebar .active {
    background: #79543d;
}

.sidebar .logout {
    position: absolute;
    bottom: 25px;
    left: 18px;
    right: 18px;
    background: #8b5e3c;
    text-align: center;
}

.sidebar .logout:hover {
    background: #70472f;
}

/* ================= MAIN ================= */

.main {
    margin-left: 230px;
    padding: 35px;
}

/* ================= TOP BAR ================= */

.topbar {
    background: #fffdf9;
    padding: 20px 25px;
    border-radius: 10px;

    display: flex;
    justify-content: space-between;
    align-items: center;

    box-shadow: 0 4px 15px rgba(82,55,35,0.08);

    margin-bottom: 30px;
}

.topbar h1 {
    font-size: 24px;
    color: #4a3021;
}

.admin-name {
    font-size: 14px;
    color: #765640;
}

.admin-name b {
    color: #4a3021;
}

/* ================= FORM CARD ================= */

.form-card {
    max-width: 850px;

    background: #fffdf9;

    padding: 35px;

    border-radius: 10px;

    box-shadow: 0 4px 15px rgba(82,55,35,0.08);
}

.form-card h2 {
    font-size: 20px;
    color: #4a3021;
    margin-bottom: 8px;
}

.form-description {
    color: #8b7564;
    font-size: 13px;
    margin-bottom: 28px;
}

/* ================= FORM ================= */

.form-group {
    margin-bottom: 22px;
}

.form-group label {
    display: block;

    font-size: 14px;

    font-weight: 600;

    color: #4d382a;

    margin-bottom: 8px;
}

.form-group input,
.form-group select,
.form-group textarea {

    width: 100%;

    padding: 13px 14px;

    border: 1px solid #d8c8b8;

    border-radius: 7px;

    outline: none;

    font-size: 14px;

    color: #3f2a1d;

    background: white;

}

.form-group textarea {
    resize: vertical;
    min-height: 120px;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {

    border-color: #8b5e3c;

    box-shadow:
    0 0 0 3px rgba(139,94,60,0.10);

}

/* ================= TWO COLUMN ================= */

.form-row {

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 20px;

}

/* ================= FILE UPLOAD ================= */

.file-box {

    border: 1px dashed #cbb7a5;

    background: #faf5ef;

    padding: 20px;

    border-radius: 8px;

}

.file-box input {

    border: none;

    padding: 5px 0;

    background: transparent;

}

/* ================= BUTTONS ================= */

.button-row {

    display: flex;

    gap: 10px;

    margin-top: 10px;

}

.add-btn {

    border: none;

    background: #6b4632;

    color: white;

    padding: 13px 25px;

    border-radius: 6px;

    font-size: 14px;

    cursor: pointer;

}

.add-btn:hover {

    background: #523525;

}

.cancel-btn {

    display: inline-block;

    text-decoration: none;

    background: #e5d7ca;

    color: #5b3a29;

    padding: 13px 25px;

    border-radius: 6px;

    font-size: 14px;

}

.cancel-btn:hover {

    background: #d8c6b6;

}

/* ================= RESPONSIVE ================= */

@media(max-width:800px){

    .form-row {

        grid-template-columns: 1fr;

    }

}

@media(max-width:650px){

    .sidebar {

        position: relative;

        width: 100%;

        height: auto;

    }

    .sidebar .logout {

        position: relative;

        left: auto;

        right: auto;

        bottom: auto;

        margin-top: 15px;

    }

    .main {

        margin-left: 0;

        padding: 20px;

    }

    .topbar {

        flex-direction: column;

        align-items: flex-start;

        gap: 10px;

    }

    .form-card {

        padding: 25px;

    }

    .button-row {

        flex-direction: column;

    }

}

</style>

</head>

<body>


<!-- ================= SIDEBAR ================= -->

<div class="sidebar">

    <div class="logo">

        <h2>CraftNest</h2>

        <p>Admin Panel</p>

    </div>


    <a href="dashboard.php">
        Dashboard
    </a>


    <a href="add_products.php" class="active">
        Add Product
    </a>


    <a href="manage_store.php">
        Manage Store
    </a>


    <a href="orders.php">
        Manage Orders
    </a>


    <a href="logout.php" class="logout">
        Logout
    </a>

</div>


<!-- ================= MAIN ================= -->

<div class="main">


    <!-- TOP BAR -->

    <div class="topbar">

        <h1>Add Product</h1>

        <div class="admin-name">

            Welcome,
            <b>
                <?php echo htmlspecialchars($_SESSION['admin']); ?>
            </b>

        </div>

    </div>


    <!-- ================= FORM ================= -->

    <div class="form-card">

        <h2>Create New Product</h2>

        <p class="form-description">

            Add a handmade product to your CraftNest store.

        </p>


        <form method="POST" enctype="multipart/form-data">


            <!-- PRODUCT NAME -->

            <div class="form-group">

                <label>
                    Product Name
                </label>

                <input
                    type="text"
                    name="product_name"
                    placeholder="Enter product name"
                    required
                >

            </div>


            <!-- DESCRIPTION -->

            <div class="form-group">

                <label>
                    Description
                </label>

                <textarea
                    name="description"
                    placeholder="Enter product description"
                    required
                ></textarea>

            </div>


            <!-- PRICE + STOCK -->

            <div class="form-row">


                <div class="form-group">

                    <label>
                        Price (₹)
                    </label>

                    <input
                        type="number"
                        name="price"
                        placeholder="Enter price"
                        min="0"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Stock
                    </label>

                    <input
                        type="number"
                        name="stock"
                        placeholder="Enter stock quantity"
                        min="0"
                        required
                    >

                </div>


            </div>


            <!-- CATEGORY -->

            <div class="form-group">

                <label>
                    Category
                </label>

                <select name="category" required>

                    <option value="">
                        Select Category
                    </option>


                    <?php

                    $cat = mysqli_query(
                        $conn,
                        "SELECT * FROM categories"
                    );

                    while($row = mysqli_fetch_assoc($cat)){

                    ?>

                    <option
                        value="<?php echo $row['category_id']; ?>"
                    >

                        <?php
                        echo htmlspecialchars($row['category_name']);
                        ?>

                    </option>

                    <?php

                    }

                    ?>

                </select>

            </div>


            <!-- IMAGES -->

            <div class="form-group">

                <label>
                    Product Images
                </label>

                <div class="file-box">

                    <input
                        type="file"
                        name="images[]"
                        multiple
                        accept="image/*"
                        required
                    >

                    <p style="
                        margin-top:10px;
                        font-size:12px;
                        color:#8b7564;
                    ">

                        You can select multiple images for this product.

                    </p>

                </div>

            </div>


            <!-- BUTTONS -->

            <div class="button-row">


                <button
                    type="submit"
                    name="add_product"
                    class="add-btn"
                >

                    Add Product

                </button>


                <a
                    href="manage_store.php"
                    class="cancel-btn"
                >

                    Cancel

                </a>


            </div>


        </form>

    </div>


</div>

</body>

</html>