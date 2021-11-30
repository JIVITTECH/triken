<?php

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

include("../database.php");

$cart_id = $_GET['cart_id'];
$sel_ord_type = $_GET['sel_ord_type'];

$del_qry_mod = "delete from obo_cart_item_modifiers where cart_id = $cart_id";
$res_del_qry_mod = mysqli_query($conn, $del_qry_mod);

$del_qry_coupon = "delete from obo_cart_coupon where cart_id = $cart_id";
$res_del_qry_coupon = mysqli_query($conn, $del_qry_coupon);

$del_qry_tax = "delete from obo_order_tax where cart_id = $cart_id";
$res_del_qry_tax = mysqli_query($conn, $del_qry_tax);

// update order type in obo_cart_details table //
$upd_order_type = "update obo_cart_details set delivery = '$sel_ord_type' where cart_id = $cart_id";
$res_upd_order_type = mysqli_query($conn, $upd_order_type);

$del_qry = "delete from obo_cart_item_details where cart_id = $cart_id";
$res_del_qry = mysqli_query($conn, $del_qry);

?>
