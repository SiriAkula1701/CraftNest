<?php

$conn = mysqli_connect("localhost", "root", "", "craft_nest");

if(!$conn){
    die("Database connection failed: " . mysqli_connect_error());
}

?>