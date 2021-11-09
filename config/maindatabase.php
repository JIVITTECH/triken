<?php

$dbname = "cms_main";
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "admin";
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname, "3306");

// Check connection
if (!$conn) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>