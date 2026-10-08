<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}

include("../includes/db.php");
?>

<!DOCTYPE html>
<html>
<head>

    <title>Manage Orders - CraftNest</title>

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

        /* TOP BAR */

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
            margin-bottom: 20px;
        }

        .page-heading h2 {
            font-size: 25px;
            margin-bottom: 6px;
        }

        .page-heading p {
            color: #8b7564;
            font-size: 14px;
        }

        /* TABLE CARD */

        .table-card {
            background: #fffdf9;
            border: 1px solid #d8c8b8;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(91, 58, 41, 0.08);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        th {
            background: #5b3a29;
            color: white;
            padding: 14px 12px;
            text-align: left;
            font-size: 14px;
        }

        td {
            padding: 14px 12px;
            border-bottom: 1px solid #eadfd4;
            font-size: 14px;
            vertical-align: middle;
        }

        tr:hover td {
            background: #faf5ef;
        }

        /* STATUS */

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            background: #f0e4d8;
            color: #6b4632;
            font-size: 12px;
            font-weight: bold;
        }

        /* BUTTONS */

        .btn {
            display: inline-block;
            text-decoration: none;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 12px;
            cursor: pointer;
            margin-bottom: 6px;
            text-align: center;
        }

        .view-btn {
            background: #6b4632;
            color: white;
        }

        .view-btn:hover {
            background: #4f3325;
        }

        .approve-btn {
            background: #8a6a4f;
            color: white;
        }

        .approve-btn:hover {
            background: #6b513c;
        }

        .reject-btn {
            background: #9b6f5b;
            color: white;
        }

        .reject-btn:hover {
            background: #7e5645;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #8b7564;
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

            .sidebar a {
                display: inline-block;
                margin-right: 5px;
            }

            .content {
                padding: 15px;
            }

            .topbar {
                padding: 0 15px;
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


    <!-- TOP BAR -->

    <div class="topbar">

        <h2>Manage Orders</h2>

        <span>
            CraftNest Admin
        </span>

    </div>


    <!-- CONTENT -->

    <div class="content">


        <div class="page-heading">

            <h2>Orders</h2>

            <p>
                View and manage customer orders and return requests.
            </p>

        </div>


        <!-- TABLE -->

        <div class="table-card">

            <table>

                <tr>

                    <th>Order ID</th>

                    <th>Customer</th>

                    <th>Phone</th>

                    <th>Total</th>

                    <th>Status</th>

                    <th>Date</th>

                    <th>Action</th>

                </tr>


                <?php

                $query=mysqli_query($conn,"
                SELECT orders.*,
                users.full_name,
                users.phone
                FROM orders
                LEFT JOIN users
                ON orders.user_id=users.user_id
                ORDER BY orders.order_date DESC
                ");

                if(mysqli_num_rows($query) == 0)
                {

                ?>

                    <tr>

                        <td colspan="7" class="empty">

                            No orders found.

                        </td>

                    </tr>

                <?php

                }

                while($row=mysqli_fetch_assoc($query))
                {

                ?>

                <tr>


                    <!-- ORDER ID -->

                    <td>

                        <strong>
                            #<?php echo $row['order_id']; ?>
                        </strong>

                    </td>


                    <!-- CUSTOMER -->

                    <td>

                        <?php

                        echo $row['full_name']
                        ? $row['full_name']
                        : "Guest";

                        ?>

                    </td>


                    <!-- PHONE -->

                    <td>

                        <?php

                        echo $row['phone']
                        ? $row['phone']
                        : "-";

                        ?>

                    </td>


                    <!-- TOTAL -->

                    <td>

                        <strong>
                            ₹<?php echo $row['total_amount']; ?>
                        </strong>

                    </td>


                    <!-- STATUS -->

                    <td>

                        <span class="status">

                            <?php echo $row['order_status']; ?>

                        </span>

                    </td>


                    <!-- DATE -->

                    <td>

                        <?php echo $row['order_date']; ?>

                    </td>


                    <!-- ACTION -->

                    <td>


                        <a
                            href="view_order.php?id=<?php echo $row['order_id']; ?>"
                            class="btn view-btn"
                        >
                            View
                        </a>


                        <?php

                        if($row['order_status']=="Return Requested")
                        {

                        ?>

                            <br>

                            <a
                                href="approve_return.php?id=<?php echo $row['order_id']; ?>"
                                class="btn approve-btn"
                            >
                                Approve Return
                            </a>

                            <br>

                            <a
                                href="reject_return.php?id=<?php echo $row['order_id']; ?>"
                                class="btn reject-btn"
                            >
                                Reject Return
                            </a>

                        <?php

                        }

                        ?>


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