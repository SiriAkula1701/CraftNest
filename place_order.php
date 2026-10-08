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