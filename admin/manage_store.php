<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

include("../includes/db.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>CraftNest | Manage Store</title>

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
    color: #fff;
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

.topbar {
    background: #fffdf9;
    padding: 20px 25px;
    border-radius: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 15px rgba(82, 55, 35, 0.08);
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

/* ================= SECTION ================= */

.section {
    background: #fffdf9;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(82, 55, 35, 0.08);
    margin-bottom: 30px;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.section-header h2 {
    font-size: 20px;
    color: #4a3021;
}

/* ================= BUTTONS ================= */

.add-btn {
    display: inline-block;
    text-decoration: none;
    background: #6b4632;
    color: white;
    padding: 10px 18px;
    border-radius: 6px;
    font-size: 13px;
    transition: 0.2s;
}

.add-btn:hover {
    background: #523525;
}

.edit-btn {
    display: inline-block;
    text-decoration: none;
    background: #8b6a52;
    color: white;
    padding: 7px 12px;
    border-radius: 5px;
    font-size: 12px;
}

.delete-btn {
    display: inline-block;
    text-decoration: none;
    background: #9b5c4c;
    color: white;
    padding: 7px 12px;
    border-radius: 5px;
    font-size: 12px;
    margin-left: 5px;
}

/* ================= TABLE ================= */

.table-container {
    width: 100%;
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: #eee1d3;
    color: #4a3021;
    font-size: 13px;
    text-align: left;
    padding: 13px;
}

td {
    padding: 12px;
    border-bottom: 1px solid #eadfd5;
    font-size: 13px;
    color: #5b4638;
    vertical-align: middle;
}

tr:hover td {
    background: #fcf7f1;
}

/* ================= PRODUCT IMAGE ================= */

.product-img {
    width: 70px;
    height: 70px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #dfd0c1;
}

.no-image {
    color: #a08c7c;
    font-size: 12px;
}

/* ================= PRICE ================= */

.price {
    font-weight: 600;
    color: #6b4632;
}

/* ================= STOCK ================= */

.stock {
    font-weight: 600;
}

/* ================= RESPONSIVE ================= */

@media (max-width: 900px) {

    .sidebar {
        width: 190px;
    }

    .main {
        margin-left: 190px;
        padding: 20px;
    }

}

@media (max-width: 650px) {

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
        padding: 15px;
    }

    .topbar {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }

    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
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

    <a href="add_products.php">
        Add Product
    </a>

    <a href="manage_store.php" class="active">
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

        <h1>Manage Store</h1>

        <div class="admin-name">

            Welcome,
            <b><?php echo htmlspecialchars($_SESSION['admin']); ?></b>

        </div>

    </div>


    <!-- ================= CATEGORIES ================= -->

    <div class="section">

        <div class="section-header">

            <h2>Categories</h2>

            <a href="add_category.php" class="add-btn">
                + Add Category
            </a>

        </div>


        <div class="table-container">

            <table>

                <tr>

                    <th>ID</th>

                    <th>Category</th>

                    <th>Action</th>

                </tr>


                <?php

                $category = mysqli_query($conn,
                    "SELECT * FROM categories"
                );

                while($cat = mysqli_fetch_assoc($category))
                {

                ?>

                <tr>

                    <td>
                        <?php echo $cat['category_id']; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($cat['category_name']); ?>
                    </td>

                    <td>

                        <a
                            href="edit_category.php?id=<?php echo $cat['category_id']; ?>"
                            class="edit-btn"
                        >
                            Edit
                        </a>


                        <a
                            href="delete_category.php?id=<?php echo $cat['category_id']; ?>"
                            class="delete-btn"
                            onclick="return confirm('Delete this category?')"
                        >
                            Delete
                        </a>

                    </td>

                </tr>

                <?php
                }
                ?>

            </table>

        </div>

    </div>


    <!-- ================= PRODUCTS ================= -->

    <div class="section">

        <div class="section-header">

            <h2>Products</h2>

            <a href="add_products.php" class="add-btn">
                + Add Product
            </a>

        </div>


        <div class="table-container">

            <table>

                <tr>

                    <th>ID</th>

                    <th>Image</th>

                    <th>Product Name</th>

                    <th>Category</th>

                    <th>Price</th>

                    <th>Stock</th>

                    <th>Actions</th>

                </tr>


                <?php

                $product = mysqli_query($conn, "

                    SELECT products.*,
                           categories.category_name

                    FROM products

                    JOIN categories

                    ON products.category_id =
                       categories.category_id

                    ORDER BY products.product_id DESC

                ");


                while($row = mysqli_fetch_assoc($product))
                {

                    $image = mysqli_query($conn, "

                        SELECT image_name

                        FROM product_images

                        WHERE product_id='".$row['product_id']."'

                        LIMIT 1

                    ");

                    $img = mysqli_fetch_assoc($image);

                ?>

                <tr>


                    <td>
                        <?php echo $row['product_id']; ?>
                    </td>


                    <td>

                        <?php if(!empty($img['image_name'])) { ?>

                            <img
                                src="../uploads/products/<?php echo htmlspecialchars($img['image_name']); ?>"
                                class="product-img"
                            >

                        <?php } else { ?>

                            <span class="no-image">
                                No Image
                            </span>

                        <?php } ?>

                    </td>


                    <td>

                        <?php
                        echo htmlspecialchars($row['product_name']);
                        ?>

                    </td>


                    <td>

                        <?php
                        echo htmlspecialchars($row['category_name']);
                        ?>

                    </td>


                    <td class="price">

                        ₹<?php echo $row['price']; ?>

                    </td>


                    <td class="stock">

                        <?php echo $row['stock']; ?>

                    </td>


                    <td>

                        <a
                            href="edit_product.php?id=<?php echo $row['product_id']; ?>"
                            class="edit-btn"
                        >
                            Edit
                        </a>


                        <a
                            href="delete_product.php?id=<?php echo $row['product_id']; ?>"
                            class="delete-btn"
                            onclick="return confirm('Delete this product?')"
                        >
                            Delete
                        </a>

                    </td>


                </tr>

                <?php

                }

                ?>

            </table>

        </div>

    </div>


</div>

</body>

</html>