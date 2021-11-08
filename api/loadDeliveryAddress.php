<?php

include("../database.php");

$user_id = $_SESSION['user_id'];

if ($_GET["action"] == "get_all_delivery_address") {

    $query = "SELECT delivery_add_id,
                     delivery_address,
                     current_address
              FROM obo_customer_addresses
              WHERE customer_id = '".$user_id."';";

    $result = mysqli_query($conn, $query);
    $res = '';

    while ($rows = mysqli_fetch_array($result)) {

        $events = array(
                "delivery_add_id" => "$rows[delivery_add_id]",
		        "delivery_address" => "$rows[delivery_address]",
		        "current_address" => "$rows[current_address]"
               );

        $output[] = $events;
        $res = json_encode($output);
    }

    if ($res == "") {
        $res = json_encode([]);
    }

    echo $res;
}

if ($_GET["action"] == "get_current_delivery_address") {

    $query = "SELECT delivery_add_id,
                     delivery_address,
              FROM obo_customer_addresses
              WHERE current_address = 'Y'
                AND customer_id = '".$user_id."';";

    $result = mysqli_query($conn, $query);
    $res = '';

    while ($rows = mysqli_fetch_array($result)) {

        $events = array(
                "delivery_add_id" => "$rows[delivery_add_id]",
		        "delivery_address" => "$rows[delivery_address]",
		       );

        $output[] = $events;
        $res = json_encode($output);
    }

    if ($res == "") {
        $res = json_encode([]);
    }

    echo $res;
}
	 
?>

