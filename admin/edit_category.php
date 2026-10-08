<?php

session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

include("../includes/db.php");


// Get category ID

if(!isset($_GET['id'])){
    header("Location: manage_store.php");
    exit();
}

$category_id = $_GET['id'];


// Fetch category details

$query = "SELECT * FROM categories
          WHERE category_id='$category_id'";

$result = mysqli_query($conn, $query);

$category = mysqli_fetch_assoc($result);


// Check category exists

if(!$category){
    header("Location: manage_store.php");
    exit();
}


// Update category

if(isset($_POST['update_category'])){

    $category_name = $_POST['category_name'];


    $update = "UPDATE categories SET
               category_name='$category_name'
               WHERE category_id='$category_id'";


    if(mysqli_query($conn, $update)){

        header("Location: manage_store.php");
        exit();

    }

}

?>

<!DOCTYPE html>
<html>

<head>

<title>Edit Category - CraftNest</title>

<style>

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

body {
    background: #f7efe5;
    color: #4a3021;
}


/* SIDEBAR */

.sidebar {
    width: 230px;
    height: 100vh;
    background: #5b3a29;
    position: fixed;
    left: 0;
    top: 0;
    padding: 25px 15px;
}

.logo {
    text-align: center;
    color: #fffdf9;
    font-size: 25px;
    font-weight: bold;
    margin-bottom: 35px;
}

.admin-text {
    text-align: center;
    color: #d8c8b8;
    font-size: 13px;
    margin-bottom: 25px;
}

.sidebar a {
    display: block;
    text-decoration: none;
    color: #fffdf9;
    padding: 13px 15px;
    margin-bottom: 8px;
    border-radius: 6px;
    font-size: 15px;
}

.sidebar a:hover {
    background: #79543d;
}

.sidebar a.active {
    background: #79543d;
}


/* MAIN */

.main {
    margin-left: 230px;
    min-height: 100vh;
}


/* TOPBAR */

.topbar {
    height: 70px;
    background: #fffdf9;
    border-bottom: 1px solid #d8c8b8;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 30px;
}

.topbar h2 {
    font-size: 22px;
    color: #4a3021;
}

.topbar span {
    color: #8b7564;
    font-size: 14px;
}


/* CONTENT */

.content {
    padding: 30px;
}

.page-heading {
    margin-bottom: 25px;
}

.page-heading h1 {
    font-size: 26px;
    margin-bottom: 6px;
}

.page-heading p {
    color: #8b7564;
    font-size: 14px;
}


/* FORM CARD */

.form-card {
    max-width: 650px;
    background: #fffdf9;
    border: 1px solid #d8c8b8;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 2px 8px rgba(91, 58, 41, 0.08);
}


/* FORM */

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: bold;
    font-size: 14px;
    margin-bottom: 8px;
}

input {
    width: 100%;
    padding: 11px 12px;
    border: 1px solid #d8c8b8;
    border-radius: 6px;
    background: #fff;
    color: #4a3021;
    font-size: 14px;
    outline: none;
}

input:focus {
    border-color: #8b6a52;
}


/* BUTTONS */

.buttons {
    display: flex;
    gap: 12px;
    margin-top: 10px;
}

.update-btn {
    background: #6b4632;
    color: white;
    border: none;
    padding: 11px 20px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
}

.update-btn:hover {
    background: #4f3325;
}

.cancel-btn {
    background: #eee2d6;
    color: #6b4632;
    text-decoration: none;
    padding: 11px 20px;
    border-radius: 6px;
    font-size: 14px;
    border: 1px solid #d8c8b8;
}

.cancel-btn:hover {
    background: #e2d2c2;
}


/* MOBILE */

@media(max-width: 800px) {

    .sidebar {
        position: relative;
        width: 100%;
        height: auto;
    }

    .main {
        margin-left: 0;
    }

    .content {
        padding: 15px;
    }

    .topbar {
        padding: 0 15px;
    }

    .form-card {
        padding: 20px;
    }

    .buttons {
        flex-direction: column;
    }

}

</style>

</head>

<body>


<!-- SIDEBAR -->

<div class="sidebar">

    <div class="logo">
        CraftNest
    </div>

    <div class="admin-text">
        Admin Panel
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
        Orders
    </a>

    <a href="logout.php">
        Logout
    </a>

</div>


<!-- MAIN -->

<div class="main">


    <!-- TOPBAR -->

    <div class="topbar">

        <h2>
            Edit Category
        </h2>

        <span>
            CraftNest Admin
        </span>

    </div>


    <!-- CONTENT -->

    <div class="content">


        <div class="page-heading">

            <h1>
                Edit Category
            </h1>

            <p>
                Update the category name below.
            </p>

        </div>


        <!-- FORM -->

        <div class="form-card">

            <form method="POST">


                <div class="form-group">

                    <label>
                        Category Name
                    </label>

                    <input
                        type="text"
                        name="category_name"
                        value="<?php echo $category['category_name']; ?>"
                        required
                    >

                </div>


                <div class="buttons">

                    <button
                        type="submit"
                        name="update_category"
                        class="update-btn"
                    >
                        Update Category
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

</div>

</body>

</html>