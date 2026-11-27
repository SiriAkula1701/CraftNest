
<?php
session_start();

include("includes/db.php");

$message = "";
$status = "";

// Check login
if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

// Check product ID
if(!isset($_GET['id']))
{
    header("Location: index.php");
    exit();
}

$user_id = (int)$_SESSION['user_id'];
$product_id = (int)$_GET['id'];

// Check if product exists in wishlist
$check = mysqli_query($conn,"
SELECT *
FROM wishlist
WHERE user_id='$user_id'
AND product_id='$product_id'
");

if(mysqli_num_rows($check) > 0)
{
    $message = "Product is already in your wishlist.";
    $status = "error";
}
else
{
    // Add product to wishlist
    $insert = mysqli_query($conn,"
    INSERT INTO wishlist(user_id, product_id)
    VALUES('$user_id','$product_id')
    ");

    if($insert)
    {
        $message = "Product added to wishlist successfully!";
        $status = "success";
    }
    else
    {
        $message = "Unable to add product to wishlist. Please try again.";
        $status = "error";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>CraftNest - Wishlist</title>

<style>

body {
    margin: 0;
    padding: 0;
    background: #fffaf5;
    font-family: Georgia, "Times New Roman", serif;
}

/* Message Container */

.wishlist-message {
    width: 420px;
    max-width: 85%;
    margin: 120px auto;
    padding: 40px 25px;
    text-align: center;
    background: white;
    border-radius: 25px;
    box-shadow: 0 7px 25px rgba(70, 45, 30, 0.12);
}

/* Icon */

.wishlist-icon {
    font-size: 55px;
    margin-bottom: 15px;
}

/* Heading */

.wishlist-message h2 {
    color: #70442c;
    font-size: 25px;
    margin-bottom: 15px;
}

/* Description */

.wishlist-message p {
    color: #66554d;
    font-size: 17px;
    line-height: 1.6;
}

/* Button */

.wishlist-message a {
    display: inline-block;
    margin-top: 20px;
    padding: 12px 28px;
    background: #d49a6a;
    color: #3d2b22;
    text-decoration: none;
    border-radius: 25px;
    font-size: 16px;
    transition: 0.3s ease;
}

.wishlist-message a:hover {
    background: #8f5f40;
    color: white;
    transform: translateY(-3px);
}

/* Success and Error */

.success {
    border-top: 6px solid #8caa75;
}

.error {
    border-top: 6px solid #c98272;
}

</style>

</head>

<body>

<div class="wishlist-message <?php echo $status; ?>">

    <?php if($status == "success") { ?>

        <div class="wishlist-icon">♡</div>

    <?php } else { ?>

        <div class="wishlist-icon">!</div>

    <?php } ?>

    <h2>
        <?php echo htmlspecialchars($message); ?>
    </h2>

    <?php if($status == "success") { ?>

        <p>Your favourite handmade product has been added to your wishlist.</p>

        <a href="wishlist.php">View Wishlist</a>

    <?php } else { ?>

        <p>Please check your wishlist and try again.</p>

        <a href="wishlist.php">Go to Wishlist</a>

    <?php } ?>

</div>

</body>
</html>
