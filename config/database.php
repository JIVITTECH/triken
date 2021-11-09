<?php

$db = "cms_main";
$dbuser = "root";
$dbpass = "admin";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['obo_selected_schema'])) {
    $db = $_SESSION["obo_selected_schema"];
}

if (isset($_SESSION['obo_db_user'])) {
    $dbuser = $_SESSION["obo_db_user"];
}

if (isset($_SESSION['obo_db_pass'])) {
   $dbpass = $_SESSION["obo_db_pass"];
}

$dbhost = "localhost";
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db, "3306");

// Check connection
if (!$conn) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

date_default_timezone_set("Asia/Kolkata");
$current_zone_time = date("Y-m-d H:i:s");
?>