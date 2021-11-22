<?php

ob_start();

include("../database.php");

include_once '../configure.php';

header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Accept,charset,boundary,Content-Length');
header('Access-Control-Allow-Origin: *');


$pm = $_GET['payment_method'];
$cart_id = $_GET['cart_id'];
$branch_id = $_GET['branch'];
$delivery = $_GET['del_cost'];
$package_chg = $_GET['package_chg'];
$tt_amount = $_GET['gt_total'];
$schema = "654402a8f29dd23a";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$user_id  =  $_SESSION['user_id'];
$delivery_address = $_COOKIE['locName'];
$cus_lat = $_SESSION['user_loc_latitude'];
$cus_long = $_SESSION['user_loc_longitude'];

$customer_id = "";
$customer_name = "";
$email_addr = "";
$contact_no = "";
$address = "";
$eass_buzz_key = "";
$eass_buzz_salt = "";
$status = "";

$eas_qry = "select * from eass_buzz_credentails";
$eas_res = mysqli_query($conn, $eas_qry);

while ($rows2 = mysqli_fetch_array($eas_res)) {
    $eass_buzz_key = $rows2['eass_buzz_key'];
    $eass_buzz_salt = $rows2['eass_buzz_salt'];
    $status = $rows2['status'];
}

$sql_brnch = "select * from obo_cart_details  where cart_id  = $cart_id";
$res_brnch = mysqli_query($conn, $sql_brnch);

while ($rows = mysqli_fetch_array($res_brnch)) {
    $customer_id = $rows['customer_id'];
}

$cus_details = "select * from kot_customer_details where id = $customer_id";
$res_cus_details = mysqli_query($conn, $cus_details);

while ($rows_cus = mysqli_fetch_array($res_cus_details)) {
    $customer_name = $rows_cus['customer_name'];
    $contact_no = $rows_cus['contact_no'];
    $address = $rows_cus['address'];
    $email_addr =  'electronic.cater@gmail.com';
}

//Need to comment once signin process is ready
$customer_name = "Sara Ruth John";
$contact_no = "8610530271";
$address = "";
	
include_once('easebuzz-lib/easebuzz_payment_gateway.php');

$MERCHANT_KEY = $eass_buzz_key;
$SALT = $eass_buzz_salt;
$ENV = $status;  // "test for test enviroment or "prod" for production enviroment

$easebuzzObj = new Easebuzz($MERCHANT_KEY, $SALT, $ENV);
$unique_id = uniqid();
$tx_id = "OBO" . $unique_id;
$product = "Food";
$udf1 = "";
$udf2 = "";
$udf3 = "";
$udf4 = "";
$udf5 = "";
$udf6 = "";
$udf7 = "";
$udf8 = "";
$udf9 = "";
$udf10 = "";
$address1 = "-";
$address2 = "-";
$city = "-";
$state = "-";
$country = "-";
$zipcode = "000000";

$hash_seq = $MERCHANT_KEY|$tx_id|$tt_amount|$product|$customer_name|$email_addr|$udf1|$udf2|$udf3|$udf4|$udf5|$udf6|$udf7|$udf8|$udf9|$udf10|$SALT;
$hash = hash("sha512", $hash_seq);
$postData = array(
    "txnid" => $tx_id,
    "amount" => $tt_amount,
    "firstname" => $customer_name,
    "email" => $email_addr,
    "phone" => $contact_no,
    "productinfo" => $product,
    "hash" => $hash,
    "surl" => "$easebuzz_pay_callback_url/triken/paysuccess.php?pm=$pm&cart_id=$cart_id&branch_id=$branch_id&delivery=$delivery&package_chg=$package_chg&rest_key=$schema&user_id=$user_id&locName=$delivery_address&latitude=$cus_lat&longitude=$cus_long",
    "furl" => "$easebuzz_pay_callback_url/triken/cart.php?branch_id=$branch_id",
    "udf1" => $udf1,
    "udf2" => $udf2,
    "udf3" => $udf3,
    "udf4" => $udf4,
    "udf5" => $udf5,
    "udf6" => $udf6,
    "udf7" => $udf7,
    "address1" => $address1,
    "address2" => $address2,
    "city" => $city,
    "state" => $state,
    "country" => $country,
    "zipcode" => $zipcode
);

// call initiatePaymentAPI method and send data
$easebuzzObj->initiatePaymentAPI($postData);

// Note:- initiate payment API response will get for success URL or failure URL  using HTTP form post
// include easebuzz_payment_gateway.php file
include_once('easebuzz-lib/easebuzz_payment_gateway.php');

// set $SALT
// create Easebuzz class object and pass $SALT
$easebuzzObj = new Easebuzz($MERCHANT_KEY = null, $SALT, $ENV = null);

// call Easebuzz class methods or functions
$result = $easebuzzObj->easebuzzResponse($_POST);
// result contain final result after verification
ob_end_flush();

?>