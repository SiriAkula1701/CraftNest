<?php
session_start();
include("includes/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_POST['total'])) {
    header("Location: cart.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$total = $_POST['total'];
$session_id = session_id();

// Insert into orders table
$order_query = "INSERT INTO orders(user_id, session_id, total_amount)
                VALUES('$user_id', '$session_id', '$total')";

if (!mysqli_query($conn, $order_query)) {
    die("Order Error: " . mysqli_error($conn));
}

$order_id = mysqli_insert_id($conn);

// Fetch cart items
$cart_query = mysqli_query($conn, "
SELECT cart.*, products.price
FROM cart
JOIN products
ON cart.product_id = products.product_id
WHERE cart.user_id='$user_id'
");

while ($item = mysqli_fetch_assoc($cart_query)) {

    $product_id = $item['product_id'];
    $quantity = $item['quantity'];
    $price = $item['price'];

    // Insert into order_items
    $item_query = "INSERT INTO order_items(order_id, product_id, quantity, price)
                   VALUES('$order_id','$product_id','$quantity','$price')";

    if (!mysqli_query($conn, $item_query)) {
        die("Order Item Error: " . mysqli_error($conn));
    }

    // Update stock
    $stock_query = "UPDATE products
                    SET stock = stock - $quantity
                    WHERE product_id='$product_id'";

    if (!mysqli_query($conn, $stock_query)) {
        die("Stock Update Error: " . mysqli_error($conn));
    }
}

// Delete cart items
$delete_query = "DELETE FROM cart WHERE user_id='$user_id'";

if (!mysqli_query($conn, $delete_query)) {
    die("Cart Delete Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Successful</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #fffaf5;
            font-family: Georgia, "Times New Roman", serif;
            color: #66554d;
        }

        center {
            background-color: white;
            padding: 50px 65px;
            border-radius: 18px;
            box-shadow: 0 5px 20px rgba(112, 68, 44, 0.12);
            width: 380px;
            max-width: 85%;
        }

        h1 {
            color: #70442c;
            font-size: 28px;
            margin-bottom: 30px;
        }

        h3 {
            color: #8f5f40;
            font-size: 18px;
            margin-bottom: 12px;
        }

        h2 {
            display: inline-block;
            background-color: #fff1e5;
            color: #70442c;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 26px;
            margin: 5px 0;
        }

        button {
            background-color: #d49a6a;
            color: #3d2b22;
            border: none;
            padding: 13px 28px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: #8f5f40;
            color: white;
        }

        a {
            text-decoration: none;
        }

        @media (max-width: 480px) {
            center {
                padding: 35px 20px;
            }

            h1 {
                font-size: 23px;
            }
        }
    </style>
</head>
<body>

<center>

<h1>🎉 Order Placed Successfully!</h1>

<h3>Your Order ID:</h3>

<h2><?php echo $order_id; ?></h2>

<br>

<a href="index.php">
    <button>Continue Shopping</button>
</a>

</center>

</body>
</html>