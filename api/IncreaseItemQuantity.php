<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods', 'OPTIONS, GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, X-Token-Auth, Authorization');

include("../database.php");

$item_id = $_GET['menu_id'];
$branch = $_GET['branch_id'];
$customer_id = $_GET['customer_id'];
$quantity = $_GET['quantity'];
$price = $_GET['price'];
$cus_cart_id = $_GET['cus_cart_id'];
$cal_price = $quantity * $price;
$cart_item_id = $_GET['cart_item_id'];
$packing_charge = $_GET['packing_charge'];

$sql = "update obo_cart_item_details set quantity = $quantity ,price = $cal_price, packing_charge= $packing_charge where cart_id =$cus_cart_id  and cart_item_id = $cart_item_id and  predef_menu_id =$item_id";
$result = mysqli_query($conn, $sql);

echo $sql;
?>

