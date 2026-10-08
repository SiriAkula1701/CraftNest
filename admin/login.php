<?php
session_start();
include("../includes/db.php");

if(isset($_POST['login'])){

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $query = mysqli_query($conn,
        "SELECT * FROM admins WHERE username='$username'");

    if(mysqli_num_rows($query) == 1){

        $admin = mysqli_fetch_assoc($query);

        if($password == $admin['password']){

            $_SESSION['admin'] = $admin['username'];

            header("Location: dashboard.php");
            exit();

        }else{

            echo "<script>alert('Invalid Password');</script>";

        }

    }else{

        echo "<script>alert('Username not found');</script>";

    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CraftNest | Admin Login</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            background: #f7efe5;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Main Login Box */

        .login-container {
            width: 400px;
            background: #fffdf9;
            padding: 40px 45px;
            border-radius: 14px;
            box-shadow: 0 8px 30px rgba(82, 55, 35, 0.15);
        }

        /* Logo */

        .logo {
    text-align: center;
    margin-bottom: 20px;
}

.logo img {
    width: 90px;
    height: 90px;
    object-fit: contain;
    margin-bottom: 8px;
}

.logo p {
    font-size: 13px;
    color: #9a806c;
}

        /* Heading */

        .login-title {
            text-align: center;
            margin: 28px 0;
        }

        .login-title h2 {
            font-size: 23px;
            color: #3f2a1d;
            margin-bottom: 7px;
        }

        .login-title p {
            font-size: 13px;
            color: #8c7a6b;
        }

        /* Form */

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #4d382a;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #d8c8b8;
            border-radius: 7px;
            outline: none;
            font-size: 14px;
            color: #3f2a1d;
            background: #fff;
            transition: 0.2s;
        }

        .form-group input:focus {
            border-color: #8b5e3c;
            box-shadow: 0 0 0 3px rgba(139, 94, 60, 0.10);
        }

        /* Login Button */

        .login-btn {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 7px;
            background: #6b4632;
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 5px;
            transition: 0.2s;
        }

        .login-btn:hover {
            background: #523525;
        }

        /* Bottom text */

        .footer-text {
            text-align: center;
            margin-top: 25px;
            font-size: 12px;
            color: #9a806c;
        }

        /* Mobile */

        @media (max-width: 500px) {

            .login-container {
                width: 90%;
                padding: 35px 25px;
            }

            .logo h1 {
                font-size: 28px;
            }

        }

    </style>

</head>

<body>

    <div class="login-container">

        <div class="logo">
    <img src="../assets/images/logo.jpg" alt="CraftNest">
    <p>Admin Panel</p>
</div>

        <div class="login-title">
            <h2>Admin Login</h2>
            <p>Sign in to manage your CraftNest store</p>
        </div>

        <form method="POST">

            <div class="form-group">

                <label>Username</label>

                <input
                    type="text"
                    name="username"
                    placeholder="Enter admin username"
                    required
                >

            </div>


            <div class="form-group">

                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Enter password"
                    required
                >

            </div>


            <button
                type="submit"
                name="login"
                class="login-btn"
            >
                Login to Admin Panel
            </button>

        </form>

        <div class="footer-text">
            © 2026 CraftNest Admin Panel
        </div>

    </div>

</body>

</html>