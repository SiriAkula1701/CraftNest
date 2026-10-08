<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CraftNest</title>

    <!-- CraftNest CSS -->
    <link rel="stylesheet" href="/CraftNest/assets/css/style.css">
</head>

<body>

<header>

    <div class="header">

        <!-- Logo -->
        <div class="logo-container">

            <a href="index.php">
                <img src="http://localhost/CraftNest/assets/images/logo.jpg"
                     alt="CraftNest Logo"
                     class="logo">
            </a>

            <span class="logo_name">Crafts Nest</span>

        </div>


        <!-- Navigation -->
        <nav class="nav-container">

            <ul>

                <li>
                    <a href="index.php">Home</a>
                </li>

                <li>
                    <a href="index.php#categories">Categories</a>
                </li>

                <li>
                    <a href="index.php#special">Specials</a>
                </li>

            </ul>

        </nav>

        <!-- Actions -->
        <div class="action-container">

            <a href="wishlist.php" title="Wishlist">
                ♡
            </a>

            <a href="cart.php" title="Cart">
                🛒
            </a>


            <?php if (isset($_SESSION['user_id'])) { ?>

                <a href="my_orders.php" class="account-link">
                    My Orders
                </a>

                <a href="logout.php" class="login-btn">
                    Logout
                </a>

            <?php } else { ?>

                <a href="login.php" class="login-btn">
                    Login
                </a>

                <a href="register.php" class="register-btn">
                    Register
                </a>

            <?php } ?>

        </div>

    </div>

</header>