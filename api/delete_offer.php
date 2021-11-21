<?php

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

include "../database.php";

$cartId = $_GET['cart_id'];

$query = "delete from obo_cart_coupon where cart_id = $cartId";
$result = mysqli_query($conn, $query);

if ($conn->query($query) === TRUE) {
    echo "200";
} else {
    echo "Error Removing an offer: " . $conn->error;
} 

?>
