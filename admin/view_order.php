<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}

include("../includes/db.php");

$order_id = $_GET['id'];

$order = mysqli_query($conn,"
SELECT *
FROM orders
WHERE order_id='$order_id'
");

$order_data = mysqli_fetch_assoc($order);

$items = mysqli_query($conn,"
SELECT order_items.*, products.product_name
FROM order_items
JOIN products
ON order_items.product_id = products.product_id
WHERE order_items.order_id='$order_id'
");
?>

<!DOCTYPE html>
<html>

<head>

    <title>View Order - CraftNest</title>

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
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .page-heading h2 {
            font-size: 26px;
            margin-bottom: 5px;
        }

        .page-heading p {
            color: #8b7564;
            font-size: 14px;
        }

        /* BACK BUTTON */

        .back-btn {
            text-decoration: none;
            background: #6b4632;
            color: white;
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 13px;
        }

        .back-btn:hover {
            background: #4f3325;
        }

        /* ORDER INFO */

        .order-info {
            background: #fffdf9;
            border: 1px solid #d8c8b8;
            border-radius: 10px;
            padding: 22px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(91, 58, 41, 0.08);
        }

        .info-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .status {
            display: inline-block;
            padding: 7px 13px;
            border-radius: 20px;
            background: #f0e4d8;
            color: #6b4632;
            font-size: 13px;
            font-weight: bold;
        }

        /* ITEMS */

        .items-card {
            background: #fffdf9;
            border: 1px solid #d8c8b8;
            border-radius: 10px;
            padding: 22px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(91, 58, 41, 0.08);
        }

        .items-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #5b3a29;
            color: white;
            padding: 13px;
            text-align: left;
            font-size: 14px;
        }

        td {
            padding: 13px;
            border-bottom: 1px solid #eadfd4;
            font-size: 14px;
        }

        tr:hover td {
            background: #faf5ef;
        }

        /* STATUS FORM */

        .status-card {
            background: #fffdf9;
            border: 1px solid #d8c8b8;
            border-radius: 10px;
            padding: 22px;
            box-shadow: 0 2px 8px rgba(91, 58, 41, 0.08);
        }

        .status-card h3 {
            font-size: 18px;
            margin-bottom: 15px;
        }

        select {
            width: 250px;
            padding: 10px;
            border: 1px solid #d8c8b8;
            border-radius: 6px;
            background: white;
            color: #4a3021;
            font-size: 14px;
        }

        .update-btn {
            margin-top: 15px;
            padding: 10px 18px;
            background: #6b4632;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        .update-btn:hover {
            background: #4f3325;
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

            .page-heading {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            select {
                width: 100%;
            }

            table {
                min-width: 500px;
            }

            .items-card {
                overflow-x: auto;
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

    <a href="manage_store.php">
        Manage Store
    </a>

    <a href="orders.php" class="active">
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

        <h2>Order Details</h2>

        <span>
            CraftNest Admin
        </span>

    </div>


    <!-- CONTENT -->

    <div class="content">


        <!-- PAGE HEADING -->

        <div class="page-heading">

            <div>

                <h2>
                    Order #<?php echo $order_id; ?>
                </h2>

                <p>
                    View order details and update order status.
                </p>

            </div>

            <a href="orders.php" class="back-btn">
                ← Back to Orders
            </a>

        </div>


        <!-- ORDER INFO -->

        <div class="order-info">

            <div class="info-title">
                Order Information
            </div>

            <p>

                <b>Status:</b>

                &nbsp;

                <span class="status">

                    <?php echo $order_data['order_status']; ?>

                </span>

            </p>

        </div>


        <!-- ORDER ITEMS -->

        <div class="items-card">

            <div class="items-title">
                Ordered Products
            </div>

            <table>

                <tr>

                    <th>
                        Product
                    </th>

                    <th>
                        Quantity
                    </th>

                    <th>
                        Price
                    </th>

                </tr>


                <?php

                while($item=mysqli_fetch_assoc($items))
                {

                ?>

                <tr>

                    <td>

                        <?php echo $item['product_name']; ?>

                    </td>

                    <td>

                        <?php echo $item['quantity']; ?>

                    </td>

                    <td>

                        ₹<?php echo $item['price']; ?>

                    </td>

                </tr>

                <?php

                }

                ?>

            </table>

        </div>


        <!-- UPDATE STATUS -->

        <div class="status-card">

            <h3>
                Update Order Status
            </h3>

            <form action="update_status.php" method="POST">

                <input
                    type="hidden"
                    name="order_id"
                    value="<?php echo $order_id; ?>"
                >

                <select name="status">

                    <option>Pending</option>

                    <option>Processing</option>

                    <option>Shipped</option>

                    <option>Delivered</option>

                    <option>Cancelled</option>

                </select>

                <br>

                <button
                    type="submit"
                    class="update-btn"
                >
                    Update Status
                </button>

            </form>

        </div>


    </div>

</div>


</body>
</html>