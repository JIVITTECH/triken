<?php

$servername = "localhost";
$username = "root";
$password = "admin";
$dbname = "cms_main";
$conn = new mysqli($servername, $username, $password, $dbname);

$sel_obo_order_type = "3";
$radius = 100;
$user_id = 1;
$cart_id = 404;

if ($conn->connect_error) {
    die("connection failed:" . $conn->connect_error);
}
mysqli_set_charset($conn, "utf8");

//current date/time
date_default_timezone_set("Asia/Kolkata");
$current_zone_time = date("Y-m-d H:i:s");


?>