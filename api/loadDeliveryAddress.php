<?php

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

include("../database.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user_id'];

if ($_GET["action"] == "get_all_delivery_address") {

    $query = "SELECT *
              FROM obo_customer_addresses
              WHERE customer_id = '".$user_id."';";

    $result = mysqli_query($conn, $query);
    $res = '';

    while ($rows = mysqli_fetch_array($result)) {

        $events = array(
                "delivery_add_id" => "$rows[delivery_add_id]",
		        "delivery_address" => "$rows[delivery_address]",
		        "current_address" => "$rows[current_address]",
				"flatNo" => "$rows[flatNo]",
		        "street" => "$rows[street]",
		        "area" => "$rows[area]",
				"pincode" => "$rows[pincode]",
		        "city" => "$rows[city]",
		        "landmark" => "$rows[landmark]"
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

if ($_GET["action"] == "delete_delivery_address") {

    $address_id = isset($_GET['delivery_add_id']) ? $_GET['delivery_add_id'] : "";

    if($address_id != "") {
        $query = "delete from obo_customer_addresses where customer_id = '" . $user_id . "' AND delivery_add_id = " . $address_id;
        $result = mysqli_query($conn, $query);
    }

    echo "";

}
	 
?>

