<?php

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

include("../database.php");

$cus_cart_id = $_GET['cart_id'];
$branch_id = $_GET['branch_id'];

if($cus_cart_id == ""){
    $cus_cart_id = -1;
}
$sql = "select count(ocid.cart_id) as count, SUM(ocid.price) as price from obo_cart_details ocd
LEFT JOIN obo_cart_item_details  ocid
ON ocid.cart_id = ocd.cart_id
WHERE ocd.cart_id = $cus_cart_id and ocid.branch_id = '$branch_id' and ocid.quantity <> 0";
//echo $sql;
$result = mysqli_query($conn, $sql);

$res = "";

while ($rows = mysqli_fetch_array($result)) {
    if ($rows['count'] !== "0") {

        $events = array(
            "count" => "$rows[count]",
            "price" => "$rows[price]",
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

