<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

include("../includes/db.php");

$product_count = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM products"));

$order_count = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM orders"));

$user_count = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM users"));

$category_count = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM categories"));
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>CraftNest | Admin Dashboard</title>

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

/* Sidebar Links */

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

/* Logout */

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

/* Top Bar */

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

/* ================= WELCOME ================= */

.welcome {
    margin-bottom: 25px;
}

.welcome h2 {
    font-size: 22px;
    margin-bottom: 6px;
}

.welcome p {
    color: #8b7564;
    font-size: 14px;
}

/* ================= CARDS ================= */

.cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 35px;
}

.card {
    background: #fffdf9;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(82, 55, 35, 0.08);
}

.card p {
    font-size: 13px;
    color: #8b7564;
    margin-bottom: 12px;
}

.card h2 {
    font-size: 30px;
    color: #5b3a29;
}

/* ================= QUICK ACTIONS ================= */

.section-title {
    font-size: 18px;
    margin-bottom: 18px;
}

.actions {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
}

.action {
    background: #fffdf9;
    padding: 20px;
    border-radius: 10px;
    text-decoration: none;
    color: #4a3021;
    box-shadow: 0 4px 15px rgba(82, 55, 35, 0.08);
    transition: 0.2s;
}

.action:hover {
    transform: translateY(-2px);
    box-shadow: 0 7px 20px rgba(82, 55, 35, 0.13);
}

.action h3 {
    font-size: 16px;
    margin-bottom: 7px;
}

.action p {
    font-size: 12px;
    color: #8b7564;
}

/* ================= RESPONSIVE ================= */

@media (max-width: 900px) {

    .cards {
        grid-template-columns: repeat(2, 1fr);
    }

    .actions {
        grid-template-columns: repeat(2, 1fr);
    }

}

@media (max-width: 650px) {

    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
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

    .cards {
        grid-template-columns: 1fr;
    }

    .actions {
        grid-template-columns: 1fr;
    }

    .topbar {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
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


<!-- ================= MAIN CONTENT ================= -->

<div class="main">


    <!-- TOP BAR -->

    <div class="topbar">

        <h1>Dashboard</h1>

        <div class="admin-name">

            Welcome,
            <b><?php echo htmlspecialchars($_SESSION['admin']); ?></b>

        </div>

    </div>


    <!-- WELCOME -->

    <div class="welcome">

        <h2>Welcome to CraftNest 👋</h2>

        <p>
            Manage your handmade store from one place.
        </p>

    </div>


    <!-- ================= STATISTICS ================= -->

    <div class="cards">


        <div class="card">

            <p>Total Products</p>

            <h2>
                <?php echo $product_count['total']; ?>
            </h2>

        </div>


        <div class="card">

            <p>Total Categories</p>

            <h2>
                <?php echo $category_count['total']; ?>
            </h2>

        </div>


        <div class="card">

            <p>Total Orders</p>

            <h2>
                <?php echo $order_count['total']; ?>
            </h2>

        </div>


        <div class="card">

            <p>Total Customers</p>

            <h2>
                <?php echo $user_count['total']; ?>
            </h2>

        </div>


    </div>


    <!-- ================= QUICK ACTIONS ================= -->

    <h2 class="section-title">
        Quick Actions
    </h2>


    <div class="actions">


        <a href="add_products.php" class="action">

            <h3>Add Product</h3>

            <p>
                Add a new handmade product to your store.
            </p>

        </a>


        <a href="manage_store.php" class="action">

            <h3>Manage Store</h3>

            <p>
                Manage products and categories.
            </p>

        </a>


        <a href="orders.php" class="action">

            <h3>Manage Orders</h3>

            <p>
                View and update customer orders.
            </p>

        </a>


    </div>


</div>

</body>

</html>