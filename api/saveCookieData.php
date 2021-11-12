<?php

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

include("../database.php");

$userid = $_GET['customer_id'];
$branch_id = $_GET['branch_id'];
$items_list = $_COOKIE['item_list'];

$cus_cart_id = 0;

$sql_cart_id = "SELECT * FROM obo_cart_details "
        . "WHERE customer_id = $userid "
        . "AND order_placed= 'N' ORDER BY cart_id DESC LIMIT 1";
		
$res_cart_id = mysqli_query($conn, $sql_cart_id);

$cart_count = mysqli_num_rows($res_cart_id);

if ($cart_count > 0) {
    if ($rows_cart_id = mysqli_fetch_array($res_cart_id)) {
        $cus_cart_id = $rows_cart_id['cart_id'];
    }
} else {
    $sqlfs = "INSERT into obo_cart_details(customer_id) VALUES($userid)";
    $result = mysqli_query($conn, $sqlfs);
    $cart_id = mysqli_insert_id($conn);
    $cus_cart_id = $cart_id;
}
    
$sql_order_type = "update obo_cart_details set delivery = '$sel_obo_order_type' where cart_id = $cus_cart_id";
$result_qry = mysqli_query($conn, $sql_order_type);

$item_list_array = json_decode($items_list);

for ($i = 0; $i < sizeOf($item_list_array); $i++) {

    $item_id = $item_list_array[$i]->menu_id;
    $quantity = $item_list_array[$i]->quantity;
    $price = $item_list_array[$i]->price;
    $name = $item_list_array[$i]->item_name;  
    $pkg_charge = 0;
    
    $name = mysqli_real_escape_string($conn, $name);
	
    $sql_pkg_price = "SELECT * FROM packing_charges where predef_menu_id = $item_id AND branch_id = $branch_id";
    $result_pkg_price = mysqli_query($conn, $sql_pkg_price);
    if ($rows_pkg = mysqli_fetch_array($result_pkg_price)) {
        $pkg_charge = $rows_pkg['price'];
    }
     
    $cal_price = $quantity * $price;


    $sql_sel = "SELECT * from
        obo_cart_item_details
        WHERE (TRIM('$item_id') = '' OR predef_menu_id = '$item_id') AND cart_id = $cus_cart_id AND replace_name ='$name'";
		
    $result_qry = mysqli_query($conn, $sql_sel);
    $count = mysqli_num_rows($result_qry);
	
    if ($count == 0) {
        $sql = "insert into obo_cart_item_details(cart_id,predef_menu_id,quantity,price,branch_id,replace_name,packing_charge)values($cus_cart_id,$item_id,$quantity,$cal_price,'$branch_id','$name',$pkg_charge)";
        $result = mysqli_query($conn, $sql);
        $id = mysqli_insert_id($conn);
    } else {
		$sql = "update obo_cart_item_details set quantity = quantity + $quantity ,packing_charge = quantity * $pkg_charge ,price = price + $cal_price,replace_name ='$name' where cart_id = $cus_cart_id and  predef_menu_id = $item_id";
		$result = mysqli_query($conn, $sql);
	}
        
}
?>