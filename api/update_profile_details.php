<?php

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

include("../database.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_GET["action"] == "update_user_profile") {
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "";
    $first_name = isset($_GET['firstname']) ? $_GET['firstname'] : "";
    $last_name = isset($_GET['lastname']) ? $_GET['lastname'] : "";
    $phone = isset($_GET['phone']) ? $_GET['phone'] : "";
    $email = isset($_GET['email']) ? $_GET['email'] : "";

    if($user_id !== "") {
        $query = "update kot_customer_details 
        set customer_name = '$first_name',
        last_name = '$last_name',
        contact_no = '$phone',
        email_addr = '$email'
        where id = $user_id";

        $result = mysqli_query($conn, $query);

        if ($conn->query($query) === TRUE) {
           echo "200";
        } else {
           echo "Error Updating record: " . $conn->error;
        } 
    }
}
?>