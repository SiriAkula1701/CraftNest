<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

include("../includes/db.php");

if(isset($_POST['add_category'])){

    $category_name = trim($_POST['category_name']);

    if($category_name==""){

        echo "<script>alert('Category name cannot be empty');</script>";

    }else{

        $check=mysqli_query($conn,"
        SELECT *
        FROM categories
        WHERE category_name='$category_name'
        ");

        if(mysqli_num_rows($check)>0){

            echo "<script>alert('Category already exists');</script>";

        }else{

            mysqli_query($conn,"
            INSERT INTO categories(category_name)
            VALUES('$category_name')
            ");

            echo "<script>

            alert('Category Added Successfully');

            window.location='manage_store.php';

            </script>";

        }

    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>CraftNest | Add Category</title>

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
    max-width: 650px;

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

    margin-bottom: 25px;
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

.form-group input {
    width: 100%;

    padding: 13px 14px;

    border: 1px solid #d8c8b8;

    border-radius: 7px;

    outline: none;

    font-size: 14px;

    color: #3f2a1d;

    background: white;
}

.form-group input:focus {
    border-color: #8b5e3c;

    box-shadow:
    0 0 0 3px rgba(139,94,60,0.10);
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

    padding: 12px 22px;

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

    padding: 12px 22px;

    border-radius: 6px;

    font-size: 14px;
}

.cancel-btn:hover {
    background: #d8c6b6;
}

/* ================= RESPONSIVE ================= */

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

        <h1>Add Category</h1>

        <div class="admin-name">

            Welcome,
            <b>
                <?php echo htmlspecialchars($_SESSION['admin']); ?>
            </b>

        </div>

    </div>


    <!-- ================= FORM ================= -->

    <div class="form-card">

        <h2>Create New Category</h2>

        <p class="form-description">

            Add a new product category to your CraftNest store.

        </p>


        <form method="POST">


            <div class="form-group">

                <label>
                    Category Name
                </label>


                <input
                    type="text"
                    name="category_name"
                    placeholder="Enter category name"
                    required
                >

            </div>


            <div class="button-row">


                <button
                    type="submit"
                    name="add_category"
                    class="add-btn"
                >

                    Add Category

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