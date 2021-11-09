<?php

session_start();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods', 'OPTIONS, GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, X-Token-Auth, Authorization');
include("../database.php");

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "";

$query = "select id, customer_name, last_name, contact_no, email_addr from kot_customer_details where id = '$user_id'";

$result = mysqli_query($conn, $query);

$res = '';

while ($rows = mysqli_fetch_array($result)) {

    $events = array(
        "id" => "$rows[id]",
        "customer_name" => "$rows[customer_name]",
        "last_name" => "$rows[last_name]",
        "contact_no" => "$rows[contact_no]",
        "email_addr" => "$rows[email_addr]"
    );

    $output[] = $events;
    $res = json_encode($output);

}

if ($res == "") {
    $res = json_encode([]);
}

echo $res;

?>