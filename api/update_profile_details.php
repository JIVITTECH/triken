<?php

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

include("../database.php");

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "";
$first_name = isset($_POST['firstname']) ? $_POST['firstname'] : "";
$last_name = isset($_POST['lastname']) ? $_POST['lastname'] : "";
$phone = isset($_POST['phone']) ? $_POST['phone'] : "";
$email = isset($_POST['email_1']) ? $_POST['email_1'] : "";

if($user_id !== "") {
    $qry = "update kot_customer_details 
    set customer_name = '$first_name',
    last_name = '$last_name',
    contact_no = '$phone',
    email_addr = '$email'
    where id = $user_id";

    $result = mysqli_query($conn, $qry);
    header('Location: ../my-account.php');
}

?>