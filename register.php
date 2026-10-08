<?php

include("includes/db.php");


/* REGISTRATION */

if(isset($_POST['register']))
{
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    


    $check = mysqli_query(
        $conn,
        "SELECT * FROM users WHERE email='$email'"
    );


    if(mysqli_num_rows($check) > 0)
    {
        echo "<script>
        alert('Email already exists');
        </script>";
    }
    else
    {
        mysqli_query(
            $conn,
            "INSERT INTO users(full_name,email,phone)
            VALUES('$name','$email','$phone')"
        );

        echo "<script>
        alert('Registration Successful');
        window.location='login.php';
        </script>";
    }
}


/* HEADER */

include("includes/header.php");

?>

<style>

/* REGISTRATION PAGE */

.register-page {
    min-height: 600px;

    display: flex;
    justify-content: center;
    align-items: center;

    background: #f9f4ee;

    padding: 60px 20px;
}


/* REGISTRATION CARD */

.register-card {
    width: 450px;

    background: #fffdf9;

    border: 1px solid #e2d4c7;

    border-radius: 12px;

    padding: 40px;

    box-shadow: 0 4px 15px rgba(91, 58, 41, 0.10);
}


/* TITLE */

.register-card h2 {
    text-align: center;

    color: #4a3021;

    font-family: Georgia, serif;

    font-size: 28px;

    margin-bottom: 30px;
}


/* LABEL */

.register-card label {
    display: block;

    color: #4a3021;

    font-weight: bold;

    font-size: 14px;

    margin-bottom: 8px;
}


/* INPUT */

.register-card input {
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


.register-card input:focus {
    border-color: #8b6a52;
}


/* REGISTER BUTTON */

.register-btn {
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


.register-btn:hover {
    background: #4f3325;
}


/* LOGIN TEXT */

.login-text {
    text-align: center;

    margin-top: 22px;

    color: #8b7564;

    font-size: 14px;
}


.login-text a {
    color: #6b4632;

    text-decoration: none;

    font-weight: bold;
}


.login-text a:hover {
    text-decoration: underline;
}


/* MOBILE */

@media(max-width: 600px) {

    .register-page {
        padding: 40px 15px;
    }

    .register-card {
        width: 100%;

        padding: 30px 22px;
    }

}

</style>


<!-- REGISTRATION PAGE -->

<div class="register-page">


    <div class="register-card">


        <h2>
            Customer Registration
        </h2>


        <form method="POST">


            <!-- NAME -->

            <label>
                Full Name
            </label>

            <input
                type="text"
                name="name"
                placeholder="Enter your full name"
                required
            >


            <!-- EMAIL -->

            <label>
                Email
            </label>

            <input
                type="email"
                name="email"
                placeholder="Enter your email"
                required
            >


            <!-- PHONE -->

            <label>
                Phone Number
            </label>

            <input
                type="text"
                name="phone"
                placeholder="Enter your phone number"
                required
            >

            <!-- REGISTER -->

            <button
                type="submit"
                name="register"
                class="register-btn"
            >
                Register
            </button>


        </form>


        <div class="login-text">

            Already have an account?

            <a href="login.php">
                Login
            </a>

        </div>


    </div>


</div>


<?php

include("includes/footer.php");

?>