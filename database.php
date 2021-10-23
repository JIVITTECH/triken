<?php

$servername = "localhost";
$username = "root";
$password = "admin";
$dbname = "cms_main";
$conn = new mysqli($servername, $username, $password, $dbname);

$sel_obo_order_type = "3";

if ($conn->connect_error) {
    die("connection failed:" . $conn->connect_error);
}
mysqli_set_charset($conn, "utf8");

?>