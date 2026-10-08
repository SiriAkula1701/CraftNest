<?php
session_start();
include("includes/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = mysqli_query($conn,"
SELECT cart.cart_id,
       cart.quantity,
       products.product_name,
       products.price,
       (
           SELECT image_name
           FROM product_images
           WHERE product_images.product_id = products.product_id
           LIMIT 1
       ) AS image_name
FROM cart
JOIN products
ON cart.product_id = products.product_id
WHERE cart.user_id='$user_id'
");

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Your Cart | CraftNest</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial, sans-serif;
    background:#f7efe5;
    color:#4a3021;
}

/* HEADER */

.cart-header{
    background:#5b3a29;
    color:white;
    padding:22px 7%;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.cart-header h1{
    font-family:Georgia, serif;
    font-size:30px;
}

.back-home{
    text-decoration:none;
    color:white;
    background:#79543d;
    padding:10px 18px;
    border-radius:6px;
    font-size:14px;
}

.back-home:hover{
    background:#8c6248;
}

/* MAIN */

.cart-container{
    width:90%;
    max-width:1100px;
    margin:40px auto;
}

/* EMPTY CART */

.empty-cart{
    background:#fffdf9;
    border:1px solid #d8c8b8;
    border-radius:12px;
    padding:60px 20px;
    text-align:center;
    box-shadow:0 4px 15px rgba(91,58,41,0.08);
}

.empty-cart h2{
    font-family:Georgia, serif;
    font-size:26px;
    margin-bottom:12px;
}

.empty-cart p{
    color:#8b7564;
    margin-bottom:25px;
}

.shop-btn{
    display:inline-block;
    background:#6b4632;
    color:white;
    text-decoration:none;
    padding:12px 25px;
    border-radius:6px;
}

.shop-btn:hover{
    background:#79543d;
}

/* CART ITEMS */

.cart-item{
    background:#fffdf9;
    border:1px solid #d8c8b8;
    border-radius:12px;
    padding:20px;
    margin-bottom:18px;

    display:flex;
    align-items:center;
    gap:25px;

    box-shadow:0 4px 12px rgba(91,58,41,0.07);
}

.cart-item img{
    width:130px;
    height:130px;
    object-fit:cover;
    border-radius:8px;
    border:1px solid #d8c8b8;
}

.cart-details{
    flex:1;
}

.cart-details h2{
    font-family:Georgia, serif;
    font-size:22px;
    margin-bottom:12px;
}

.cart-details p{
    margin:7px 0;
    color:#6b5545;
}

.price{
    font-weight:bold;
    color:#6b4632 !important;
}

.quantity{
    color:#6b5545;
}

/* REMOVE */

.remove-btn{
    display:inline-block;
    margin-top:12px;
    padding:8px 15px;
    border:1px solid #b99b87;
    color:#79543d;
    text-decoration:none;
    border-radius:5px;
    font-size:14px;
}

.remove-btn:hover{
    background:#f1e2d4;
}

/* SUMMARY */

.cart-summary{
    background:#fffdf9;
    border:1px solid #d8c8b8;
    border-radius:12px;
    padding:25px;
    margin-top:30px;

    display:flex;
    justify-content:space-between;
    align-items:center;

    box-shadow:0 4px 12px rgba(91,58,41,0.07);
}

.total-section h2{
    font-family:Georgia, serif;
    font-size:24px;
}

.total-amount{
    color:#6b4632;
}

/* CHECKOUT */

.checkout-btn{
    background:#6b4632;
    color:white;
    text-decoration:none;
    padding:13px 25px;
    border-radius:6px;
    font-weight:bold;
}

.checkout-btn:hover{
    background:#79543d;
}

/* RESPONSIVE */

@media(max-width:700px){

    .cart-header{
        padding:18px 5%;
    }

    .cart-header h1{
        font-size:24px;
    }

    .cart-container{
        width:94%;
        margin:25px auto;
    }

    .cart-item{
        flex-direction:column;
        align-items:flex-start;
    }

    .cart-item img{
        width:100%;
        height:220px;
    }

    .cart-summary{
        flex-direction:column;
        align-items:stretch;
        gap:20px;
    }

    .checkout-btn{
        text-align:center;
    }

}

</style>

</head>

<body>

<!-- HEADER -->

<div class="cart-header">

    <h1>Your Cart</h1>

    <a href="index.php" class="back-home">
        Continue Shopping
    </a>

</div>


<!-- CART -->

<div class="cart-container">

<?php

if(mysqli_num_rows($query)>0){

    while($row=mysqli_fetch_assoc($query)){

        $subtotal = $row['price'] * $row['quantity'];

        $total = $total + $subtotal;

?>

    <div class="cart-item">

        <img
            src="uploads/products/<?php echo $row['image_name']; ?>"
            alt="<?php echo htmlspecialchars($row['product_name']); ?>"
        >

        <div class="cart-details">

            <h2>
                <?php echo htmlspecialchars($row['product_name']); ?>
            </h2>

            <p class="price">
                Price: ₹<?php echo number_format($row['price'], 2); ?>
            </p>

            <p class="quantity">
                Quantity: <?php echo $row['quantity']; ?>
            </p>

            <p>
                Subtotal:
                <strong>
                    ₹<?php echo number_format($subtotal, 2); ?>
                </strong>
            </p>

            <a
                href="remove_cart.php?id=<?php echo $row['cart_id']; ?>"
                class="remove-btn"
                onclick="return confirm('Remove this item from your cart?');"
            >
                Remove
            </a>

        </div>

    </div>

<?php

    }

?>

    <!-- SUMMARY -->

    <div class="cart-summary">

        <div class="total-section">

            <h2>
                Total Amount:
                <span class="total-amount">
                    ₹<?php echo number_format($total, 2); ?>
                </span>
            </h2>

        </div>

        <a href="checkout.php" class="checkout-btn">
            Proceed To Checkout
        </a>

    </div>

<?php

}else{

?>

    <div class="empty-cart">

        <h2>Your Cart is Empty</h2>

        <p>
            Looks like you haven't added anything to your cart yet.
        </p>

        <a href="index.php" class="shop-btn">
            Start Shopping
        </a>

    </div>

<?php

}

?>

</div>

</body>
</html>