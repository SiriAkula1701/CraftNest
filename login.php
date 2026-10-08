<?php

session_start();

include("includes/db.php");


/* LOGIN */

if(isset($_POST['login']))
{
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    $query = mysqli_query(
        $conn,
        "SELECT * FROM users WHERE email='$email' AND phone='$phone'"
    );

    if(mysqli_num_rows($query) == 1)
    {
        $user = mysqli_fetch_assoc($query);
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['full_name'];

            header("Location:index.php");
            exit();

    }
    else
    {
        echo "<script>alert('Invaild Email or Phone Number');</script>";
    }
}


/* HEADER */

include("includes/header.php");

?>

<style>

/* LOGIN PAGE */

.login-page {
    min-height: 600px;

    display: flex;
    justify-content: center;
    align-items: center;

    background: #f9f4ee;

    padding: 60px 20px;
}


/* LOGIN CARD */

.login-card {
    width: 420px;

    background: #fffdf9;

    border: 1px solid #e2d4c7;

    border-radius: 12px;

    padding: 40px;

    box-shadow: 0 4px 15px rgba(91, 58, 41, 0.10);
}


/* TITLE */

.login-card h2 {
    text-align: center;

    color: #4a3021;

    font-family: Georgia, serif;

    font-size: 28px;

    margin-bottom: 30px;
}


/* LABEL */

.login-card label {
    display: block;

    color: #4a3021;

    font-weight: bold;

    font-size: 14px;

    margin-bottom: 8px;
}


/* INPUT */

.login-card input {
    width: 100%;

    padding: 12px 14px;

    border: 1px solid #d8c8b8;

    border-radius: 6px;

    background: white;

    color: #4a3021;

    font-size: 14px;

    outline: none;

    margin-bottom: 20px;
}


.login-card input:focus {
    border-color: #8b6a52;
}


/* LOGIN BUTTON */

.login-btn {
    width: 100%;

    padding: 12px;

    background: #6b4632;

    color: white;

    border: none;

    border-radius: 6px;

    font-size: 15px;

    cursor: pointer;

    margin-top: 5px;
}


.login-btn:hover {
    background: #4f3325;
}


/* REGISTER TEXT */

.register-text {
    text-align: center;

    margin-top: 22px;

    color: #8b7564;

    font-size: 14px;
}


.register-text a {
    color: #6b4632;

    text-decoration: none;

    font-weight: bold;
}


.register-text a:hover {
    text-decoration: underline;
}


/* MOBILE */

@media(max-width: 600px) {

    .login-page {
        padding: 40px 15px;
    }

    .login-card {
        width: 100%;

        padding: 30px 22px;
    }

}

</style>


<!-- LOGIN PAGE -->

<div class="login-page">


    <div class="login-card">


        <h2>
            Customer Login
        </h2>


        <form method="POST">


            <!-- EMAIL -->

            <label>
                Email
            </label>

            <input
                type="email"
                name="email"
                placeholder="Email"
                required
            >


            <!-- PASSWORD -->

            <label>
                Phone Number
            </label>

            <input
                type="text"
                name="phone"
                placeholder="Enter your phone number"
                required
            >


            <!-- LOGIN -->

            <button
                type="submit"
                name="login"
                class="login-btn"
            >
                Login
            </button>


        </form>


        <div class="register-text">

            Don't have an account?

            <a href="register.php">
                Register
            </a>

        </div>


    </div>


</div>


<?php

include("includes/footer.php");

?>