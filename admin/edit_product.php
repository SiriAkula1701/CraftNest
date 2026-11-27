
<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include("../includes/db.php");

// Get product ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manage_store.php");
    exit();
}

$product_id = (int) $_GET['id'];

// Fetch product details
$query = "SELECT * FROM products WHERE product_id = $product_id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    header("Location: manage_store.php");
    exit();
}

$product = mysqli_fetch_assoc($result);
$error_message = "";

// Update product
if (isset($_POST['update_product'])) {
    $product_name = trim($_POST['product_name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = (float) ($_POST['price'] ?? 0);
    $stock = (int) ($_POST['stock'] ?? 0);
    $category_id = (int) ($_POST['category'] ?? 0);

    // Checked = 1; unchecked = 0
    $is_recommended = isset($_POST['is_recommended']) ? 1 : 0;

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE products
         SET category_id = ?,
             product_name = ?,
             description = ?,
             price = ?,
             stock = ?,
             is_recommended = ?
         WHERE product_id = ?"
    );

    if ($stmt) {
        mysqli_stmt_bind_param(
            $stmt,
            "issdiii",
            $category_id,
            $product_name,
            $description,
            $price,
            $stock,
            $is_recommended,
            $product_id
        );

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header("Location: /CraftNest/admin/manage_store.php");
            exit();
        } else {
            $error_message = "Error updating product: "
                           . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        $error_message = "Error preparing update: "
                       . mysqli_error($conn);
    }

    // Keep entered values if update fails
    $product['product_name'] = $product_name;
    $product['description'] = $description;
    $product['price'] = $price;
    $product['stock'] = $stock;
    $product['category_id'] = $category_id;
    $product['is_recommended'] = $is_recommended;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product - CraftNest</title>

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

        .sidebar a:hover,
        .sidebar a.active {
            background: #79543d;
        }

        .main {
            margin-left: 230px;
            min-height: 100vh;
        }

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

        .content {
            padding: 30px;
        }

        .page-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        .back-btn {
            text-decoration: none;
            background: #eee2d6;
            color: #6b4632;
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 13px;
            border: 1px solid #d8c8b8;
        }

        .back-btn:hover,
        .cancel-btn:hover {
            background: #e2d2c2;
        }

        .form-card {
            max-width: 850px;
            background: #fffdf9;
            border: 1px solid #d8c8b8;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(91, 58, 41, 0.08);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group > label {
            display: block;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 8px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #d8c8b8;
            border-radius: 6px;
            background: #fff;
            color: #4a3021;
            font-size: 14px;
            outline: none;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: #8b6a52;
        }

        textarea {
            min-height: 130px;
            resize: vertical;
        }

        /* Recommendation checkbox */
        .recommend-option {
            display: flex !important;
            align-items: center;
            gap: 10px;
            font-weight: normal !important;
            cursor: pointer;
        }

        .recommend-option input {
            width: auto;
            margin: 0;
        }

        .recommend-help {
            margin-top: 8px;
            font-size: 12px;
            color: #8b7564;
        }

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
            border: 1px solid #d8c8b8;
            text-decoration: none;
            padding: 11px 20px;
            border-radius: 6px;
            font-size: 14px;
        }

        .error-message {
            color: #a12622;
            background: #fbe9e7;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 18px;
        }

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
    <div class="logo">CraftNest</div>
    <div class="admin-text">Admin Panel</div>

    <a href="dashboard.php">Dashboard</a>
    <a href="add_products.php">Add Product</a>
    <a href="manage_store.php" class="active">Manage Store</a>
    <a href="orders.php">Orders</a>
    <a href="logout.php">Logout</a>
</div>

<!-- MAIN -->
<div class="main">

    <div class="topbar">
        <h2>Edit Product</h2>
        <span>CraftNest Admin</span>
    </div>

    <div class="content">

        <div class="page-heading">
            <div>
                <h1>Edit Product</h1>
                <p>Update the product information below.</p>
            </div>

            <a href="manage_store.php" class="back-btn">
                ← Back to Store
            </a>
        </div>

        <div class="form-card">

            <?php if (!empty($error_message)) { ?>
                <p class="error-message">
                    <?php
                    echo htmlspecialchars(
                        $error_message,
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>
                </p>
            <?php } ?>

            <form
                method="POST"
                action="edit_product.php?id=<?php echo $product_id; ?>"
            >

                <!-- PRODUCT NAME -->
                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input
                        type="text"
                        id="product_name"
                        name="product_name"
                        value="<?php echo htmlspecialchars($product['product_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                        required
                    >
                </div>

                <!-- DESCRIPTION -->
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea
                        id="description"
                        name="description"
                        required
                    ><?php echo htmlspecialchars($product['description'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>

                <!-- PRICE -->
                <div class="form-group">
                    <label for="price">Price (₹)</label>
                    <input
                        type="number"
                        id="price"
                        name="price"
                        step="0.01"
                        min="0"
                        value="<?php echo htmlspecialchars((string)($product['price'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
                        required
                    >
                </div>

                <!-- STOCK -->
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input
                        type="number"
                        id="stock"
                        name="stock"
                        min="0"
                        value="<?php echo htmlspecialchars((string)($product['stock'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
                        required
                    >
                </div>

                <!-- CATEGORY -->
                <div class="form-group">
                    <label for="category">Category</label>

                    <select id="category" name="category" required>
                        <?php
                        $categories = mysqli_query(
                            $conn,
                            "SELECT * FROM categories"
                        );

                        while ($cat = mysqli_fetch_assoc($categories)) {
                        ?>
                            <option
                                value="<?php echo (int)$cat['category_id']; ?>"
                                <?php
                                if (
                                    $cat['category_id']
                                    == $product['category_id']
                                ) {
                                    echo "selected";
                                }
                                ?>
                            >
                                <?php
                                echo htmlspecialchars(
                                    $cat['category_name'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                                ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- MOST RECOMMENDED CHECKBOX -->
                <div class="form-group">
                    <label>Product Recommendation</label>

                    <label class="recommend-option">
                        <input
                            type="checkbox"
                            name="is_recommended"
                            value="1"
                            <?php
                            echo !empty($product['is_recommended'])
                                ? 'checked'
                                : '';
                            ?>
                        >
                        Show this product in Most Recommended
                    </label>

                    <p class="recommend-help">
                        Check this option to display the product in
                        Most Recommended.
                    </p>
                </div>

                <!-- BUTTONS -->
                <div class="buttons">
                    <button
                        type="submit"
                        name="update_product"
                        class="update-btn"
                    >
                        Update Product
                    </button>

                    <a href="manage_store.php" class="cancel-btn">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

</body>
</html>
